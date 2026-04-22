<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationQuestionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'questionnaire_id' => 'required',
            'section' => 'required',
            'question_text' => 'required',
            'type' => 'required',
        ]);

        try {
            DB::table('evaluation_questions')->insert([
                'questionnaire_id' => $request->questionnaire_id,
                'section' => $request->section,
                'question_text' => $request->question_text,
                'type' => $request->type,
                // JSON encode untuk field JSON
                'options' => $request->options ? json_encode($request->options) : null,
                'scale_labels' => $request->scale_labels ? json_encode($request->scale_labels) : null,
                'weight' => $request->weight ?? 1,
                'order' => $request->order ?? 0,
                'is_required' => $request->has('is_required') ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', 'Pertanyaan Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $question = DB::table('evaluation_questions')->where('id', $id)->first();
        
        if (!$question) {
            return back()->with('error', 'Pertanyaan tidak ditemukan.');
        }

        $questionnaire = DB::table('evaluation_questionnaires')
                            ->where('id', $question->questionnaire_id)
                            ->first();

        return view('evaluation_questions.edit', compact('question', 'questionnaire'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::table('evaluation_questions')
                ->where('id', $id)
                ->update([
                    'section' => $request->section,
                    'question_text' => $request->question_text,
                    'type' => $request->type,
                    'options' => $request->options ? json_encode($request->options) : null,
                    'order' => $request->order,
                    'updated_at' => now(),
                ]);

            return back()->with('success', 'Pertanyaan Berhasil Diupdate!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::table('evaluation_questions')->where('id', $id)->delete();
        return back()->with('success', 'Pertanyaan Berhasil Dihapus!');
    }
}