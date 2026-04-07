<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuditFindingController extends Controller
{
    
    public function index(Request $request)
    {
        $query = DB::table('audit_findings')
            ->join('audit_schedules', 'audit_findings.audit_schedule_id', '=', 'audit_schedules.id')
            ->join('units', 'audit_findings.unit_id', '=', 'units.id')
            ->join('users', 'audit_findings.auditor_id', '=', 'users.id')
            ->select(
                'audit_findings.*',
                'audit_schedules.title as schedule_title',
                'units.name as unit_name',
                'users.name as auditor_name'
            );

        if ($request->filled('status')) {
            $query->where('audit_findings.status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('finding_number', 'like', '%' . $request->search . '%')
                  ->orWhere('finding_description', 'like', '%' . $request->search . '%');
            });
        }

        $findings = $query->orderBy('audit_findings.created_at', 'desc')->paginate(10);

        return view('audit_findings.index', compact('findings'));
    }

    /**
     * Form tambah temuan baru.
     */
    public function create()
    {
        $schedules = DB::table('audit_schedules')->get();
        $units = DB::table('units')->get();
        $checklists = DB::table('audit_checklists')->get();
        
        return view('audit_findings.create', compact('schedules', 'units', 'checklists'));
    }

    /**
     * Simpan temuan baru.
     */
    public function store(Request $request)
{
    $request->validate([
        'finding_number'    => 'required|unique:audit_findings,finding_number',
        'audit_schedule_id' => 'required',
        'unit_id'           => 'required',
        'finding_description' => 'required',
        'finding_date'      => 'required|date',
    ]);

    try {
        DB::table('audit_findings')->insert([
            'finding_number'      => $request->finding_number,
            'audit_schedule_id'   => $request->audit_schedule_id,
            'unit_id'             => $request->unit_id,
            'finding_description' => $request->finding_description,
            'finding_date'        => $request->finding_date,
            
            // Berikan nilai default jika field tidak ada di form
            'audit_checklist_id'  => $request->audit_checklist_id ?? null,
            'category'            => $request->category ?? 'minor',
            'type'                => $request->type ?? 'sporadic',
            'criteria_reference'  => $request->criteria_reference ?? '-',
            'objective_evidence'  => $request->objective_evidence ?? '-',
            'risk_level'          => $request->risk_level ?? 1,
            'status'              => 'open',
            'auditor_id'          => Auth::id() ?? 1,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        return redirect()->route('audit_findings.index')->with('success', 'New finding added successfully!');
    } catch (\Exception $e) {
        // Ini triknya: kalau error, kita tampilkan pesan error aslinya biar ketahuan salahnya di mana
        Log::error($e->getMessage());
        return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
    }
}

    /**
     * Detail temuan.
     */
    public function show($id)
    {
        $finding = DB::table('audit_findings')
            ->join('audit_schedules', 'audit_findings.audit_schedule_id', '=', 'audit_schedules.id')
            ->join('units', 'audit_findings.unit_id', '=', 'units.id')
            ->join('users', 'audit_findings.auditor_id', '=', 'users.id')
            ->leftJoin('audit_checklists', 'audit_findings.audit_checklist_id', '=', 'audit_checklists.id')
            ->select(
                'audit_findings.*',
                'audit_schedules.title as schedule_title',
                'units.name as unit_name',
                'users.name as auditor_name',
                'audit_checklists.notes as checklist_notes'
            )
            ->where('audit_findings.id', $id)
            ->first();

        if (!$finding) {
            return redirect()->route('audit_findings.index')->with('error', 'Finding not found.');
        }

        return view('audit_findings.show', compact('finding'));
    }

    /**
     * Form edit temuan.
     */
    public function edit($id)
    {
        $finding = DB::table('audit_findings')->where('id', $id)->first();
        $schedules = DB::table('audit_schedules')->get();
        $units = DB::table('units')->get();

        if (!$finding) {
            return redirect()->route('audit_findings.index')->with('error', 'Data not found.');
        }

        return view('audit_findings.edit', compact('finding', 'schedules', 'units'));
    }

    /**
     * Update temuan.
     */
    public function update(Request $request, $id)
{
    // Validasi dasar
    $request->validate([
        'finding_number'    => 'required|unique:audit_findings,finding_number,' . $id,
        'audit_schedule_id' => 'required',
        'unit_id'           => 'required',
        'finding_description' => 'required',
        'finding_date'      => 'required|date',
        'status'            => 'required'
    ]);

    try {
        DB::table('audit_findings')
            ->where('id', $id)
            ->update([
                'finding_number'      => $request->finding_number,
                'audit_schedule_id'   => $request->audit_schedule_id,
                'unit_id'             => $request->unit_id,
                'finding_description' => $request->finding_description,
                'finding_date'        => $request->finding_date,
                'status'              => $request->status,
                'category'            => $request->category ?? 'minor',
                'updated_at'          => now(),
            ]);

        return redirect()->route('audit_findings.index')->with('success', 'Audit finding updated successfully!');
    } catch (\Exception $e) {
        // Log error ke file log
        Log::error($e->getMessage());
        
        // Tampilkan pesan error aslinya ke user agar kita tahu kolom mana yang bermasalah
        return back()->withInput()->with('error', 'Update failed: ' . $e->getMessage());
    }
}

    /**
     * Hapus temuan.
     */
    public function destroy($id)
    {
        try {
            DB::table('audit_findings')->where('id', $id)->delete();
            return redirect()->route('audit_findings.index')->with('success', 'Finding deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed.');
        }
    }
}