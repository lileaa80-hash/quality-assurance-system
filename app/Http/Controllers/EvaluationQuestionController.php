<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EvaluationQuestionController extends Controller
{
    // Menampilkan daftar pertanyaan berdasarkan kuesioner tertentu
    public function index($questionnaireId)
    {
        $questionnaire = DB::table('evaluation_questionnaires')->where('id', $questionnaireId)->first();
        
        if (!$questionnaire) {
            return redirect()->back()->with('error', 'Kuesioner tidak ditemukan.');
        }

        $questions = DB::table('evaluation_questions')
            ->where('questionnaire_id', $questionnaireId)
            ->orderBy('order', 'asc')
            ->get();

        return view('evaluation_questions.index', compact('questions', 'questionnaire'));
    }

    public function create($questionnaireId)
    {
        return view('evaluation_questions.create', compact('questionnaireId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'questionnaire_id' => 'required',
            'question_text'    => 'required',
            'type'             => 'required|in:likert_5,likert_4,multiple_choice,essay,rating',
            'section'          => 'required',
        ]);

        try {
            DB::table('evaluation_questions')->insert([
                'questionnaire_id' => $request->questionnaire_id,
                'section'          => $request->section,
                'question_text'    => $request->question_text,
                'type'             => $request->type,
                'options'          => $request->options ? json_encode($request->options) : null,
                'scale_labels'     => $request->scale_labels ? json_encode($request->scale_labels) : null,
                'weight'           => $request->weight ?? 1,
                'order'            => $request->order ?? 0,
                'is_required'      => $request->is_required ?? true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            return redirect()->route('evaluation_questions.index', $request->questionnaire_id)
                             ->with('success', 'Pertanyaan berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Error Store Question: ' . $e->getMessage());
            return back()->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $question = DB::table('evaluation_questions')
            ->join('evaluation_questionnaires', 'evaluation_questions.questionnaire_id', '=', 'evaluation_questionnaires.id')
            ->select(
                'evaluation_questions.*', 
                'evaluation_questionnaires.title as questionnaire_title'
            )
            ->where('evaluation_questions.id', $id)
            ->first();

        if (!$question) {
            return redirect()->back()->with('error', 'Pertanyaan tidak ditemukan.');
        }
        
        $question->options = json_decode($question->options);
        $question->scale_labels = json_decode($question->scale_labels);

        return view('evaluation_questions.show', compact('question'));
    }

    public function edit($id)
    {
        $question = DB::table('evaluation_questions')->where('id', $id)->first();
        return view('evaluation_questions.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::table('evaluation_questions')->where('id', $id)->update([
                'section'       => $request->section,
                'question_text' => $request->question_text,
                'type'          => $request->type,
                'options'       => $request->options ? json_encode($request->options) : null,
                'weight'        => $request->weight,
                'order'         => $request->order,
                'updated_at'    => now(),
            ]);

            $qId = DB::table('evaluation_questions')->where('id', $id)->value('questionnaire_id');

            return redirect()->route('evaluation_questions.index', $qId)
                             ->with('success', 'Pertanyaan diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update.');
        }
    }

    public function destroy($id)
    {
        $question = DB::table('evaluation_questions')->where('id', $id)->first();
        DB::table('evaluation_questions')->where('id', $id)->delete();

        return redirect()->route('evaluation_questions.index', $question->questionnaire_id)
                         ->with('success', 'Pertanyaan dihapus!');
    }
}