<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EvaluationQuestionnaireController extends Controller
{
    public function index()
    {
        $questionnaires = DB::table('evaluation_questionnaires')
            ->join('users', 'evaluation_questionnaires.created_by', '=', 'users.id')
            ->select('evaluation_questionnaires.*', 'users.name as creator_name')
            ->orderBy('evaluation_questionnaires.created_at', 'desc')
            ->paginate(10);

        return view('evaluation_questionnaires.index', compact('questionnaires'));
    }

    public function create()
    {
        return view('evaluation_questionnaires.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:student_satisfaction,lecturer_performance,alumni_tracer,stakeholder_satisfaction,self_evaluation',
            'year' => 'required|digits:4',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'target_audience' => 'required|in:students,lecturers,staff,alumni,stakeholders,all',
            'status' => 'required|in:draft,active,closed,archived',
            'report_file' => 'nullable|file|max:10240', // Max 10MB
        ]);

        try {
            DB::beginTransaction();

            $path = null;
            if ($request->hasFile('report_file')) {
                // Upload file laporan ke MinIO / S3
                $path = $request->file('report_file')->store('questionnaire_reports/' . $request->year, 's3');
            }

            // Target units disimpan sebagai JSON string jika ada inputan koma/array
            $targetUnits = $request->target_units ? json_encode(explode(',', $request->target_units)) : null;

            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'year' => $request->year,
                'semester' => $request->semester,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'target_audience' => $request->target_audience,
                'target_units' => $targetUnits,
                'status' => $request->status,
                'is_anonymous' => $request->has('is_anonymous') ? true : false,
                'allow_multiple_submissions' => $request->has('allow_multiple_submissions') ? true : false,
                'report_file' => $path,
                'created_by' => Auth::id() ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('evaluation_questionnaires')->insert($data);

            DB::commit();
            return redirect()->route('evaluation_questionnaires.index')->with('success', 'Kuesioner Evaluasi Berhasil Dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Store Questionnaire: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $questionnaire = DB::table('evaluation_questionnaires')
            ->join('users', 'evaluation_questionnaires.created_by', '=', 'users.id')
            ->select('evaluation_questionnaires.*', 'users.name as creator_name')
            ->where('evaluation_questionnaires.id', $id)
            ->first();

        if (!$questionnaire) {
            return redirect()->route('evaluation_questionnaires.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('evaluation_questionnaires.show', compact('questionnaire'));
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
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:student_satisfaction,lecturer_performance,alumni_tracer,stakeholder_satisfaction,self_evaluation',
            'year' => 'required|digits:4',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'target_audience' => 'required|in:students,lecturers,staff,alumni,stakeholders,all',
            'status' => 'required|in:draft,active,closed,archived',
            'report_file' => 'nullable|file|max:10240',
        ]);

        try {
            DB::beginTransaction();

            $questionnaire = DB::table('evaluation_questionnaires')->where('id', $id)->first();
            $path = $questionnaire->report_file;

            if ($request->hasFile('report_file')) {
                // Hapus file lama jika ada
                if ($path && Storage::disk('s3')->exists($path)) {
                    Storage::disk('s3')->delete($path);
                }
                // Upload file baru
                $path = $request->file('report_file')->store('questionnaire_reports/' . $request->year, 's3');
            }

            $targetUnits = $request->target_units ? json_encode(explode(',', $request->target_units)) : null;

            DB::table('evaluation_questionnaires')
                ->where('id', $id)
                ->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'type' => $request->type,
                    'year' => $request->year,
                    'semester' => $request->semester,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'target_audience' => $request->target_audience,
                    'target_units' => $targetUnits,
                    'status' => $request->status,
                    'is_anonymous' => $request->has('is_anonymous') ? true : false,
                    'allow_multiple_submissions' => $request->has('allow_multiple_submissions') ? true : false,
                    'report_file' => $path,
                    'updated_at' => now(),
                ]);

            DB::commit();
            return redirect()->route('evaluation_questionnaires.index')->with('success', 'Kuesioner Berhasil Diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Update Questionnaire: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $questionnaire = DB::table('evaluation_questionnaires')->where('id', $id)->first();
            
            if (!$questionnaire) {
                return redirect()->route('evaluation_questionnaires.index')->with('error', 'Data tidak ditemukan.');
            }
            if ($questionnaire->report_file && Storage::disk('s3')->exists($questionnaire->report_file)) {
                Storage::disk('s3')->delete($questionnaire->report_file);
            }
            DB::table('evaluation_questionnaires')->where('id', $id)->delete();
            DB::commit();
            return redirect()->route('evaluation_questionnaires.index')->with('success', 'Kuesioner dan File Laporan Berhasil Dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Delete Questionnaire: ' . $e->getMessage());
            return redirect()->route('evaluation_questionnaires.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}