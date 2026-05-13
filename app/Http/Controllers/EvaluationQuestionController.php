<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EvaluationQuestionController extends Controller
{
   
   public function index(Request $request)
    {
        $questionnaireId = $request->query('questionnaire_id');
        if (!$questionnaireId) {
            return redirect()->route('evaluation_questionnaires.index')
                             ->with('error', 'Pilih kuesioner terlebih dahulu.');
        }
        $questionnaire = DB::table('evaluation_questionnaires')->where('id', $questionnaireId)->first();
        if (!$questionnaire) {
            return redirect()->route('evaluation_questionnaires.index')->with('error', 'Kuesioner tidak ditemukan.');
        }
        $questions = DB::table('evaluation_questions')
            ->where('questionnaire_id', $questionnaireId)
            ->orderBy('order', 'asc')
            ->get();
        return view('evaluation_questions.index', compact('questions', 'questionnaire'));
    }

    public function create(Request $request)
    {
        $questionnaireId = $request->query('questionnaire_id');
        return view('evaluation_questions.create', compact('questionnaireId'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'questionnaire_id' => 'required|exists:evaluation_questionnaires,id',
            'question_text' => 'required',
            'question_type' => 'required|in:multiple_choice,rating_scale,text,boolean',
            'order' => 'required|integer',
        ]);

        try {
            DB::table('evaluation_questions')->insert([
                'questionnaire_id' => $request->questionnaire_id,
                'question_text' => $request->question_text,
                'question_type' => $request->question_type,
                'options' => $request->options ? json_encode($request->options) : null, // Untuk pilihan ganda
                'is_required' => $request->has('is_required') ? 1 : 0,
                'order' => $request->order,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('evaluation_questions.index', ['questionnaire_id' => $request->questionnaire_id])
                             ->with('success', 'Pertanyaan berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error Store Question: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal Simpan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form edit pertanyaan.
     */
    public function edit($id)
    {
        $question = DB::table('evaluation_questions')->where('id', $id)->first();
        if (!$question) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        return view('evaluation_questions.edit', compact('question'));
    }

    /**
     * Memperbarui pertanyaan.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'question_text' => 'required',
            'question_type' => 'required',
            'order' => 'required|integer',
        ]);

        try {
            $question = DB::table('evaluation_questions')->where('id', $id)->first();

            DB::table('evaluation_questions')
                ->where('id', $id)
                ->update([
                    'question_text' => $request->question_text,
                    'question_type' => $request->question_type,
                    'options' => $request->options ? json_encode($request->options) : null,
                    'is_required' => $request->has('is_required') ? 1 : 0,
                    'order' => $request->order,
                    'updated_at' => now(),
                ]);

            return redirect()->route('evaluation_questions.index', ['questionnaire_id' => $question->questionnaire_id])
                             ->with('success', 'Pertanyaan berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal Perbarui: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus pertanyaan.
     */
    public function destroy($id)
    {
        $question = DB::table('evaluation_questions')->where('id', $id)->first();
        $qid = $question->questionnaire_id;

        DB::table('evaluation_questions')->where('id', $id)->delete();

        return redirect()->route('evaluation_questions.index', ['questionnaire_id' => $qid])
                         ->with('success', 'Pertanyaan berhasil dihapus!');
    }
}