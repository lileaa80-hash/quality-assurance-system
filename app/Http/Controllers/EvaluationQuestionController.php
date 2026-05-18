<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EvaluationQuestionController extends Controller
{
   public function index()
    {
        // Mengambil data pertanyaan evaluasi bergabung dengan tabel kuesioner induk
        $questions = DB::table('evaluation_questions')
            ->join('evaluation_questionnaires', 'evaluation_questions.questionnaire_id', '=', 'evaluation_questionnaires.id')
            ->select(
                'evaluation_questions.*',
                'evaluation_questionnaires.title as questionnaire_title',
                'evaluation_questionnaires.year as questionnaire_year'
            )
            ->orderBy('evaluation_questions.questionnaire_id', 'asc')
            ->orderBy('evaluation_questions.order', 'asc')
            ->paginate(10); // Menggunakan pagination agar rapi

        // Oper variabel $questions (BUKAN $questionnaires) ke view index
        return view('evaluation_questions.index', compact('questions'));
    }
    public function create()
    {
        // Ambil data kuesioner untuk dropdown master pilihan di form input
        $questionnaires = DB::table('evaluation_questionnaires')
            ->select('id', 'title', 'status', 'year')
            ->get();

        return view('evaluation_questions.create', compact('questionnaires'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'questionnaire_id' => 'required|exists:evaluation_questionnaires,id',
            'section'          => 'required|string|max:255',
            'question_text'    => 'required|string',
            'type'             => 'required|in:likert_5,likert_4,multiple_choice,essay,rating',
            'weight'           => 'required|integer|min:1',
            'order'            => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Proteksi konversi otomatis string textarea ke JSON array/object standar laravel
            $options = null;
            if ($request->filled('options')) {
                $decodedOptions = json_decode($request->options, true);
                $options = json_last_error() === JSON_ERROR_NONE ? json_encode($decodedOptions) : json_encode(explode(',', $request->options));
            }

            $scaleLabels = null;
            if ($request->filled('scale_labels')) {
                $decodedScales = json_decode($request->scale_labels, true);
                $scaleLabels = json_last_error() === JSON_ERROR_NONE ? json_encode($decodedScales) : null;
            }

            $data = [
                'questionnaire_id' => $request->questionnaire_id,
                'section'          => $request->section,
                'question_text'    => $request->question_text,
                'type'             => $request->type,
                'options'          => $options,
                'scale_labels'     => $scaleLabels,
                'weight'           => $request->weight,
                'order'            => $request->order,
                'is_required'      => $request->has('is_required') ? true : false,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];

            DB::table('evaluation_questions')->insert($data);

            DB::commit();
            return redirect()->route('evaluation_questions.index')->with('success', 'Butir Pertanyaan Evaluasi Berhasil Ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Store Evaluation Question: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan pertanyaan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        // Mengambil data pertanyaan murni dari tabelnya sendiri
        $question = DB::table('evaluation_questions')->where('id', $id)->first();

        if (!$question) {
            abort(404);
        }
        $foreignKey = property_exists($question, 'evaluation_questionnaires_id') ? 'evaluation_questionnaires_id' : 'evaluation_questionnaire_id';
        
        if (isset($question->$foreignKey)) {
            $parent = DB::table('evaluation_questionnaires')->where('id', $question->$foreignKey)->first();
            if ($parent) {
                $question->questionnaire_title = $parent->title;
                $question->questionnaire_year = $parent->year;
            }
        }

        return view('evaluation_questions.show', compact('question'));
    }

    public function edit($id)
    {
        $question = DB::table('evaluation_questions')->where('id', $id)->first();

        if (!$question) {
            abort(404);
        }
        $questionnaires = DB::table('evaluation_questionnaires')->get();
        return view('evaluation_questions.edit', compact('question', 'questionnaires'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'section'       => 'required|string|max:255',
            'question_text' => 'required|string',
            'type'          => 'required|in:likert_5,likert_4,multiple_choice,essay,rating',
            'weight'        => 'required|integer|min:1',
            'order'         => 'required|integer|min:0',
        ]);

        try {
            // Validasi format struktur JSON raw dari input form sebelum disimpan
            $options = null;
            if ($request->filled('options')) {
                $decodedOptions = json_decode($request->options, true);
                $options = json_last_error() === JSON_ERROR_NONE ? json_encode($decodedOptions) : json_encode(array_map('trim', explode(',', $request->options)));
            }

            $scaleLabels = null;
            if ($request->filled('scale_labels')) {
                $decodedScales = json_decode($request->scale_labels, true);
                $scaleLabels = json_last_error() === JSON_ERROR_NONE ? json_encode($decodedScales) : null;
            }

            DB::table('evaluation_questions')
                ->where('id', $id)
                ->update([
                    'section'       => $request->section,
                    'question_text' => $request->question_text,
                    'type'          => $request->type,
                    'options'       => $options,
                    'scale_labels'  => $scaleLabels,
                    'weight'        => $request->weight,
                    'order'         => $request->order,
                    'is_required'   => $request->has('is_required') ? true : false,
                    'updated_at'    => now(),
                ]);

            return redirect()->route('evaluation_questions.index')->with('success', 'Butir Pertanyaan Berhasil Diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error Update Evaluation Question: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $question = DB::table('evaluation_questions')->where('id', $id)->first();
            if (!$question) {
                return redirect()->route('evaluation_questions.index')->with('error', 'Data tidak ditemukan.');
            }

            // Hapus record instrumen di database
            DB::table('evaluation_questions')->where('id', $id)->delete();
            
            DB::commit();
            return redirect()->route('evaluation_questions.index')->with('success', 'Butir Pertanyaan Evaluasi Berhasil Dihapus!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Delete Evaluation Question: ' . $e->getMessage());
            return redirect()->route('evaluation_questions.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}