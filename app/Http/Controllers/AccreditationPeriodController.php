<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccreditationPeriodController extends Controller
{
    public function index()
    {
        $periods = DB::table('accreditation_periods')
            ->join('units', 'accreditation_periods.unit_id', '=', 'units.id')
            ->select(
                'accreditation_periods.*', 
                'units.name as unit_name'
            )
            ->orderBy('accreditation_periods.start_date', 'desc')
            ->get();

        return view('accreditation_periods.index', compact('periods'));
    }

    public function create()
    {
        $units = DB::table('units')->get();
        
        return view('accreditation_periods.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required',
            'period_name' => 'required|string|max:255',
            'type' => 'required',
            'status' => 'required',
            'start_date' => 'required|date',
            'submission_deadline' => 'nullable|date',
        ]);

        try {
            DB::table('accreditation_periods')->insert([
                'unit_id' => $request->unit_id,
                'period_name' => $request->period_name,
                'type' => $request->type,
                'status' => $request->status,
                'start_date' => $request->start_date,
                'submission_deadline' => $request->submission_deadline,
                'assesment_date' => $request->assesment_date,
                'result_date' => $request->result_date,
                'expiry_date' => $request->expiry_date,
                'result_grade' => $request->result_grade,
                'result_score' => $request->result_score,
                'certificate_number' => $request->certificate_number,
                'certificate_file' => $request->certificate_file, 
                'assessors' => $request->assessors ? json_encode($request->assessors) : null,
                'metadata' => $request->metadata ? json_encode($request->metadata) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('accreditation_periods.index')->with('success', 'Accreditation Period Created!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Failed to save: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $period = DB::table('accreditation_periods')
            ->join('units', 'accreditation_periods.unit_id', '=', 'units.id')
            ->select('accreditation_periods.*', 'units.name as unit_name')
            ->where('accreditation_periods.id', $id)
            ->first();

        return view('accreditation_periods.show', compact('period'));
    }

    public function edit($id)
    {
        $period = DB::table('accreditation_periods')->where('id', $id)->first();
        $units = DB::table('units')->get();

        return view('accreditation_periods.edit', compact('period', 'units'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'unit_id' => 'required',
            'period_name' => 'required',
            'status' => 'required'
        ]);

        try {
            DB::table('accreditation_periods')
                ->where('id', $id)
                ->update([
                    'unit_id' => $request->unit_id,
                    'period_name' => $request->period_name,
                    'type' => $request->type,
                    'status' => $request->status,
                    'start_date' => $request->start_date,
                    'submission_deadline' => $request->submission_deadline,
                    'assesment_date' => $request->assesment_date,
                    'result_date' => $request->result_date,
                    'expiry_date' => $request->expiry_date,
                    'result_grade' => $request->result_grade,
                    'result_score' => $request->result_score,
                    'certificate_number' => $request->certificate_number,
                    'assessors' => $request->assessors ? json_encode($request->assessors) : null,
                    'updated_at' => now(),
                ]);

            return redirect()->route('accreditation_periods.index')->with('success', 'Period Updated Successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Update Failed: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::table('accreditation_periods')->where('id', $id)->delete();
        return redirect()->route('accreditation_periods.index')->with('success', 'Deleted Successfully!');
    }
}