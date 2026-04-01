<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuditChecklistController extends Controller
{
    public function index()
    {
        $checklists = DB::table('audit_checklists')
            ->join('units', 'audit_checklists.unit_id', '=', 'units.id')
            ->join('standards', 'audit_checklists.standard_id', '=', 'standards.id')
            ->join('standard_indicators', 'audit_checklists.standard_indicator_id', '=', 'standard_indicators.id')
            ->join('users', 'audit_checklists.auditor_id', '=', 'users.id')
            ->select(
                'audit_checklists.*',
                'units.name as unit_name',
                'standards.name as standard_name',
                'standard_indicators.indicator_text as indicator_name', // SEKARANG SUDAH BENAR!
                'users.name as auditor_name'
            )
            ->orderBy('audit_checklists.created_at', 'desc')
            ->get();

        return view('audit_checklists.index', compact('checklists'));
    }

    public function create()
    {
        $schedules = DB::table('audit_schedules')->get();
        $units = DB::table('units')->get();
        $standards = DB::table('standards')->get();
        $indicators = DB::table('standard_indicators')->get();

        return view('audit_checklists.create', compact('schedules', 'units', 'standards', 'indicators'));
    }

    public function store(Request $request)
{
    $request->validate([
        'audit_schedule_id' => 'required',
        'unit_id' => 'required',
        'standard_id' => 'required',
        'standard_indicator_id' => 'required',
        'result' => 'required',
    ]);

    // Ambil ID yang login, kalau gak ada pake ID 1 (biar gak error pas testing)
    $auditorId = Auth::id() ?? 1; 

    DB::table('audit_checklists')->insert([
        'audit_schedule_id' => $request->audit_schedule_id,
        'unit_id' => $request->unit_id,
        'standard_id' => $request->standard_id,
        'standard_indicator_id' => $request->standard_indicator_id,
        'result' => $request->result,
        'score' => $request->score,
        'objective_evidence' => $request->objective_evidence,
        'notes' => $request->notes,
        'auditor_id' => $auditorId,
        'checked_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('audit_checklists.index')->with('success', 'Audit report created successfully!');
}
    public function show($id)
    {
        $checklist = DB::table('audit_checklists')
            ->join('units', 'audit_checklists.unit_id', '=', 'units.id')
            ->join('standards', 'audit_checklists.standard_id', '=', 'standards.id')
            ->join('standard_indicators', 'audit_checklists.standard_indicator_id', '=', 'standard_indicators.id')
            ->join('users', 'audit_checklists.auditor_id', '=', 'users.id')
            ->select(
                'audit_checklists.*', 
                'units.name as unit_name', 
                'standards.name as standard_name', 
                'standard_indicators.indicator_text',
                'users.name as auditor_name'
            )
            ->where('audit_checklists.id', $id)
            ->first();

        if (!$checklist) {
            return redirect()->route('audit_checklists.index')->with('error', 'Data not found.');
        }

        return view('audit_checklists.show', compact('checklist'));
    }

    public function edit($id)
    {
        $checklist = DB::table('audit_checklists')->where('id', $id)->first();
        $units = DB::table('units')->get();
        $standards = DB::table('standards')->get();
        $indicators = DB::table('standard_indicators')->get();
        
        return view('audit_checklists.edit', compact('checklist', 'units', 'standards', 'indicators'));
    }

    public function update(Request $request, $id)
    {
        DB::table('audit_checklists')->where('id', $id)->update([
            'result' => $request->result,
            'score' => $request->score,
            'objective_evidence' => $request->objective_evidence,
            'notes' => $request->notes,
            'updated_at' => now(),
        ]);

        return redirect()->route('audit_checklists.index')->with('success', 'Audit report updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('audit_checklists')->where('id', $id)->delete();
        return redirect()->route('audit_checklists.index')->with('success', 'Audit report deleted successfully!');
    }
}