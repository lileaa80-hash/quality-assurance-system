<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EvaluationResponseController extends Controller
{
    public function index()
    {
        // Mengambil data respon bergabung dengan tabel kuesioner induk dan data pertanyaan
        $responses = DB::table('evaluation_responses')
            ->join('evaluation_questionnaires', 'evaluation_responses.questionnaire_id', '=', 'evaluation_questionnaires.id')
            ->join('evaluation_questions', 'evaluation_responses.question_id', '=', 'evaluation_questions.id')
            ->leftJoin('users', 'evaluation_responses.respondent_id', '=', 'users.id')
            ->select(
                'evaluation_responses.*',
                'evaluation_questionnaires.title as questionnaire_title',
                'evaluation_questions.question_text as question_text',
                'users.name as user_name'
            )
            ->orderBy('evaluation_responses.created_at', 'desc')
            ->paginate(10);

        return view('evaluation_responses.index', compact('responses'));
    }

    public function create()
    {
        // Ambil data kuesioner, pertanyaan, dan user untuk dropdown pilihan di form input
        $questionnaires = DB::table('evaluation_questionnaires')->select('id', 'title', 'year')->get();
        $questions = DB::table('evaluation_questions')->select('id', 'question_text', 'section')->get();
        $users = DB::table('users')->select('id', 'name')->orderBy('name', 'asc')->get();

        return view('evaluation_responses.create', compact('questionnaires', 'questions', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'questionnaire_id' => 'required|exists:evaluation_questionnaires,id',
            'question_id'      => 'required|exists:evaluation_questions,id',
            'respondent_id'    => 'nullable|exists:users,id',
            'respondent_type'  => 'nullable|string|max:255',
            'respondent_unit'  => 'nullable|string|max:255',
            'respondent_email' => 'nullable|email|max:255',
            'answer'           => 'nullable|string',
            'answer_value'     => 'nullable|integer',
        ]);

        try {
            DB::beginTransaction();

            // Proteksi konversi teks biasa pisah koma ke format JSON Array untuk answer_options
            $answerOptions = null;
            if ($request->filled('answer_options')) {
                $decodedOptions = json_decode($request->answer_options, true);
                $answerOptions = json_last_error() === JSON_ERROR_NONE ? json_encode($decodedOptions) : json_encode(array_map('trim', explode(',', $request->answer_options)));
            }

            $data = [
                'questionnaire_id' => $request->questionnaire_id,
                'question_id'      => $request->question_id,
                'respondent_id'    => $request->respondent_id,
                'respondent_type'  => $request->respondent_type,
                'respondent_unit'  => $request->respondent_unit,
                'respondent_email' => $request->respondent_email,
                'answer'           => $request->answer,
                'answer_value'     => $request->answer_value,
                'answer_options'   => $answerOptions,
                'session_id'       => $request->session()->getId(),
                'ip_address'       => $request->ip(),
                'user_agent'       => $request->userAgent(),
                'created_at'       => now(),
                'updated_at'       => now(),
            ];

            DB::table('evaluation_responses')->insert($data);

            DB::commit();
            return redirect()->route('evaluation_responses.index')->with('success', 'Respon Evaluasi Berhasil Disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Store Evaluation Response: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan respon: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $response = DB::table('evaluation_responses')->where('id', $id)->first();

        if (!$response) {
            abort(404);
        }

        // Cari relasi kuesioner induk
        $questionnaire = DB::table('evaluation_questionnaires')->where('id', $response->questionnaire_id)->first();
        if ($questionnaire) {
            $response->questionnaire_title = $questionnaire->title;
        }

        // Cari relasi butir pertanyaan
        $question = DB::table('evaluation_questions')->where('id', $response->question_id)->first();
        if ($question) {
            $response->question_text = $question->question_text;
        }

        // Cari data responden jika ada relasi user id
        if ($response->respondent_id) {
            $user = DB::table('users')->where('id', $response->respondent_id)->first();
            if ($user) {
                $response->user_name = $user->name;
            }
        }

        return view('evaluation_responses.show', compact('response'));
    }

    public function edit($id)
    {
        $response = DB::table('evaluation_responses')->where('id', $id)->first();

        if (!$response) {
            abort(404);
        }

        $questionnaires = DB::table('evaluation_questionnaires')->get();
        $questions = DB::table('evaluation_questions')->get();
        $users = DB::table('users')->orderBy('name', 'asc')->get();

        // Mengembalikan data JSON ke format teks pisah koma agar mudah diedit di form textarea
        $rawOptions = '';
        if (!empty($response->answer_options)) {
            $decoded = json_decode($response->answer_options, true);
            $rawOptions = is_array($decoded) ? implode(', ', $decoded) : $response->answer_options;
        }
        $response->raw_options = $rawOptions;

        return view('evaluation_responses.edit', compact('response', 'questionnaires', 'questions', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'respondent_type'  => 'nullable|string|max:255',
            'respondent_unit'  => 'nullable|string|max:255',
            'respondent_email' => 'nullable|email|max:255',
            'answer'           => 'nullable|string',
            'answer_value'     => 'nullable|integer',
        ]);

        try {
            DB::beginTransaction();

            $answerOptions = null;
            if ($request->filled('answer_options')) {
                $decodedOptions = json_decode($request->answer_options, true);
                $answerOptions = json_last_error() === JSON_ERROR_NONE ? json_encode($decodedOptions) : json_encode(array_map('trim', explode(',', $request->answer_options)));
            }

            DB::table('evaluation_responses')
                ->where('id', $id)
                ->update([
                    'respondent_type'  => $request->respondent_type,
                    'respondent_unit'  => $request->respondent_unit,
                    'respondent_email' => $request->respondent_email,
                    'answer'           => $request->answer,
                    'answer_value'     => $request->answer_value,
                    'answer_options'   => $answerOptions,
                    'updated_at'       => now(),
                ]);

            DB::commit();
            return redirect()->route('evaluation_responses.index')->with('success', 'Data Respon Berhasil Diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Update Evaluation Response: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $response = DB::table('evaluation_responses')->where('id', $id)->first();
            if (!$response) {
                return redirect()->route('evaluation_responses.index')->with('error', 'Data tidak ditemukan.');
            }

            DB::table('evaluation_responses')->where('id', $id)->delete();

            DB::commit();
            return redirect()->route('evaluation_responses.index')->with('success', 'Data Respon Evaluasi Berhasil Dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Delete Evaluation Response: ' . $e->getMessage());
            return redirect()->route('evaluation_responses.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}