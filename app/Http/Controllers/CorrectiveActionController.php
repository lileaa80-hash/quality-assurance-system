<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CorrectiveActionController extends Controller
{
    public function index()
    {
        $actions = DB::table('corrective_actions')
            ->join('audit_findings', 'corrective_actions.audit_finding_id', '=', 'audit_findings.id')
            ->join('units', 'corrective_actions.unit_id', '=', 'units.id')
            ->join('users', 'corrective_actions.responsible_person', '=', 'users.id')
            ->select(
                'corrective_actions.*', 
                'audit_findings.finding_number', 
                'units.name as unit_name',
                'users.name as pic_name'
            )
            ->orderBy('corrective_actions.created_at', 'desc')
            ->get();

        return view('corrective_actions.index', compact('actions'));
    }

    public function create()
    {
        // Ambil finding yang masih OPEN agar bisa dibuatkan CAPA
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
            // 1. Insert ke tabel corrective_actions
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
                'verification_status' => 'pending', // Default awal
                'final_status' => 'open',           // Masih proses
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Update status Finding asal menjadi 'in_progress'
            DB::table('audit_findings')
                ->where('id', $request->audit_finding_id)
                ->update(['status' => 'in_progress']);

            DB::commit();
            return redirect()->route('corrective_actions.index')->with('success', 'Corrective Action Plan Created!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Failed to save: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $action = DB::table('corrective_actions')
            ->join('audit_findings', 'corrective_actions.audit_finding_id', '=', 'audit_findings.id')
            ->join('units', 'corrective_actions.unit_id', '=', 'units.id')
            ->join('users', 'corrective_actions.responsible_person', '=', 'users.id')
            ->select(
                'corrective_actions.*', 
                'audit_findings.finding_number', 
                'audit_findings.finding_description',
                'units.name as unit_name',
                'users.name as pic_name'
            )
            ->where('corrective_actions.id', $id)
            ->first();

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
            'root_cause' => 'required',
            'corrective_action_plan' => 'required',
            'final_status' => 'required'
        ]);

        DB::beginTransaction();
        try {
            // 1. Update data Corrective Action
            DB::table('corrective_actions')
                ->where('id', $id)
                ->update([
                    'unit_id' => $request->unit_id,
                    'audit_finding_id' => $request->audit_finding_id,
                    'cause_category' => $request->cause_category,
                    'root_cause' => $request->root_cause,
                    'corrective_action_plan' => $request->corrective_action_plan,
                    'preventive_action_plan' => $request->preventive_action_plan,
                    'target_completion_date' => $request->target_completion_date,
                    'responsible_person' => $request->responsible_person,
                    'final_status' => $request->final_status,
                    'updated_at' => now(),
                ]);

            // 2. Jika status diubah jadi 'closed', update juga status di Finding-nya
            if ($request->final_status == 'closed') {
                $ca = DB::table('corrective_actions')->where('id', $id)->first();
                DB::table('audit_findings')
                    ->where('id', $ca->audit_finding_id)
                    ->update(['status' => 'closed']);
            }

            DB::commit();
            return redirect()->route('corrective_actions.index')->with('success', 'Report Updated Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Update Failed: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::table('corrective_actions')->where('id', $id)->delete();
        return redirect()->route('corrective_actions.index')->with('success', 'Deleted Successfully!');
    }
}