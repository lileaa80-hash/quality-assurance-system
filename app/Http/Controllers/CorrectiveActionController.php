<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CorrectiveActionController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('corrective_actions')
            ->join('audit_findings', 'corrective_actions.audit_finding_id', '=', 'audit_findings.id')
            ->join('units', 'corrective_actions.unit_id', '=', 'units.id')
            ->join('users', 'corrective_actions.responsible_person', '=', 'users.id')
            ->select(
                'corrective_actions.*', 
                'audit_findings.finding_number', 
                'units.name as unit_name',
                'users.name as pic_name'
            );

        // Filter berdasarkan status akhir
        if ($request->filled('status')) {
            $query->where('corrective_actions.final_status', $request->status);
        }

        $actions = $query->orderBy('corrective_actions.created_at', 'desc')->paginate(10);

        return view('corrective_actions.index', compact('actions'));
    }

    public function create()
    {
        // Hanya ambil temuan yang statusnya masih 'open' agar bisa dibuatkan rencana perbaikan
        $findings = DB::table('audit_findings')->where('status', 'open')->get();
        $units = DB::table('units')->get();
        $users = DB::table('users')->get();

        return view('corrective_actions.create', compact('findings', 'units', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ca_number' => 'required|unique:corrective_actions,ca_number',
            'audit_finding_id' => 'required',
            'unit_id' => 'required',
            'root_cause' => 'required',
            'corrective_action_plan' => 'required',
            'target_completion_date' => 'required|date',
            'responsible_person' => 'required',
        ]);

        DB::beginTransaction();
        try {
            DB::table('corrective_actions')->insert([
                'ca_number' => $request->ca_number,
                'audit_finding_id' => $request->audit_finding_id,
                'unit_id' => $request->unit_id,
                'root_cause' => $request->root_cause,
                'cause_category' => $request->cause_category ?? 'human',
                'corrective_action_plan' => $request->corrective_action_plan,
                'preventive_action_plan' => $request->preventive_action_plan,
                'target_completion_date' => $request->target_completion_date,
                'responsible_person' => $request->responsible_person,
                'verification_status' => 'pending',
                'final_status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update status Finding asal menjadi 'in_progress' karena sudah ada rencana perbaikan
            DB::table('audit_findings')
                ->where('id', $request->audit_finding_id)
                ->update(['status' => 'in_progress']);

            DB::commit();
            return redirect()->route('corrective_actions.index')->with('success', 'Corrective Action Plan created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $action = DB::table('corrective_actions')
            ->join('audit_findings', 'corrective_actions.audit_finding_id', '=', 'audit_findings.id')
            ->join('units', 'corrective_actions.unit_id', '=', 'units.id')
            ->join('users', 'corrective_actions.responsible_person', '=', 'users.id')
            ->leftJoin('users as verifiers', 'corrective_actions.verified_by', '=', 'verifiers.id')
            ->select(
                'corrective_actions.*', 
                'audit_findings.finding_number', 
                'audit_findings.finding_description',
                'units.name as unit_name',
                'users.name as pic_name',
                'verifiers.name as verifier_name'
            )
            ->where('corrective_actions.id', $id)
            ->first();

        if (!$action) return abort(404);

        return view('corrective_actions.show', compact('action'));
    }

    public function edit($id)
    {
        $action = DB::table('corrective_actions')->where('id', $id)->first();
        $findings = DB::table('audit_findings')->get();
        $units = DB::table('units')->get();
        $users = DB::table('users')->get();

        return view('corrective_actions.edit', compact('action', 'findings', 'units', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ca_number' => 'required|unique:corrective_actions,ca_number,' . $id,
            'root_cause' => 'required',
            'corrective_action_plan' => 'required',
        ]);

        try {
            DB::table('corrective_actions')
                ->where('id', $id)
                ->update([
                    'ca_number' => $request->ca_number,
                    'root_cause' => $request->root_cause,
                    'cause_category' => $request->cause_category,
                    'corrective_action_plan' => $request->corrective_action_plan,
                    'preventive_action_plan' => $request->preventive_action_plan,
                    'target_completion_date' => $request->target_completion_date,
                    'responsible_person' => $request->responsible_person,
                    // Field implementasi biasanya diisi saat update
                    'implementation_evidence' => $request->implementation_evidence, 
                    'implementation_date' => $request->implementation_date,
                    'verification_status' => $request->verification_status ?? 'pending',
                    'final_status' => $request->final_status ?? 'open',
                    'updated_at' => now(),
                ]);

            return redirect()->route('corrective_actions.index')->with('success', 'Corrective Action updated!');
        } catch (\Exception $e) {
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('corrective_actions')->where('id', $id)->delete();
            return redirect()->route('corrective_actions.index')->with('success', 'Data deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed.');
        }
    }
}