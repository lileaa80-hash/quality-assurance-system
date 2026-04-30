<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EvaluationQuestionnaireController extends Controller
{
    public function index()
    {
        $questionnaires = DB::table('evaluation_questionnaires')
            ->leftJoin('users', 'evaluation_questionnaires.created_by', '=', 'users.id')
            ->select('evaluation_questionnaires.*', 'users.name as creator_name')
            ->orderBy('evaluation_questionnaires.created_at', 'desc')
            ->get();

        return view('evaluation_questionnaires.index', compact('questionnaires'));
    }

    public function create()
    {
        return view('evaluation_questionnaires.create');
    }

   public function store(Request $request)
{
    // 1. Validasi harus SAMA PERSIS dengan ENUM di migration
    $request->validate([
        'title' => 'required',
        'type' => 'required|in:student_satisfaction,lecturer_performance,alumni_tracer,stakeholder_satisfaction,self_evaluation',
        'year' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'target_audience' => 'required|in:students,lecturers,staff,alumni,stakeholders,all',
        'status' => 'required|in:draft,active,closed,archived',
    ]);

    try {
        DB::table('evaluation_questionnaires')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'year' => $request->year,
            'semester' => $request->semester,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'target_audience' => $request->target_audience,
            'target_units' => $request->target_units ? json_encode($request->target_units) : null,
            'status' => $request->status,
            'is_anonymous' => $request->has('is_anonymous') ? 1 : 0,
            'allow_multiple_submissions' => $request->has('allow_multiple_submissions') ? 1 : 0,
            'created_by' => Auth::id() ?? 1, 
            
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('evaluation_questionnaires.index')->with('success', 'Kuesioner Berhasil Dibuat!');
    } catch (\Exception $e) {
        Log::error('Error Store Questionnaire: ' . $e->getMessage());
        return back()->withInput()->with('error', 'Gagal Simpan: ' . $e->getMessage());
    }
}

    public function show($id)
    {
        $questionnaire = DB::table('evaluation_questionnaires')->where('id', $id)->first();
        
        if (!$questionnaire) {
            return redirect()->route('evaluation_questionnaires.index')->with('error', 'Data tidak ditemukan.');
        }

        $questions = DB::table('evaluation_questions')
            ->where('questionnaire_id', $id)
            ->orderBy('order', 'asc')
            ->get();

        return view('evaluation_questionnaires.show', compact('questionnaire', 'questions'));
    }

    public function edit($id)
    {
        $questionnaire = DB::table('evaluation_questionnaires')->where('id', $id)->first();
        if (!$questionnaire) {
            return redirect()->route('evaluation_questionnaires.index')->with('error', 'Data tidak ditemukan.');
        }
        return view('evaluation_questionnaires.edit', compact('questionnaire'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::table('evaluation_questionnaires')
                ->where('id', $id)
                ->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'status' => $request->status,
                    'updated_at' => now(),
                ]);

            return redirect()->route('evaluation_questionnaires.index')->with('success', 'Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::table('evaluation_questionnaires')->where('id', $id)->delete();
        return redirect()->route('evaluation_questionnaires.index')->with('success', 'Berhasil Dihapus!');
    }
}