<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditTeamController extends Controller
{
    public function index()
    {
        $teams = DB::table('audit_teams')
            ->join('audit_schedules', 'audit_teams.audit_schedule_id', '=', 'audit_schedules.id')
            ->join('users', 'audit_teams.user_id', '=', 'users.id')
            ->select('audit_teams.*', 'audit_schedules.audit_number', 'users.name as user_name')
            ->orderBy('audit_teams.id', 'desc')
            ->paginate(10);

        return view('audit_teams.index', compact('teams'));
    }

    public function create()
    {
        $schedules = DB::table('audit_schedules')->get();
        $users = DB::table('users')->get();
        $units = DB::table('units')->get();
        return view('audit_teams.create', compact('schedules', 'users', 'units'));
    }

    public function store(Request $request)
    {
        DB::table('audit_teams')->insert([
            'audit_schedule_id' => $request->audit_schedule_id,
            'user_id' => $request->user_id,
            'role' => $request->role,
            'assigned_units' => json_encode($request->assigned_units),
            'is_certified' => $request->has('is_certified'),
            'certificate_number' => $request->certificate_number,
            'notes' => $request->notes,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('audit_teams.index')->with('success', 'Member added successfully!');
    }

    public function show($id)
    {
        $team = DB::table('audit_teams')
            ->join('audit_schedules', 'audit_teams.audit_schedule_id', '=', 'audit_schedules.id')
            ->join('users', 'audit_teams.user_id', '=', 'users.id')
            ->select('audit_teams.*', 'audit_schedules.audit_number', 'users.name as user_name')
            ->where('audit_teams.id', $id)
            ->first();

        return view('audit_teams.show', compact('team'));
    }

    public function edit($id)
    {
        $team = DB::table('audit_teams')->where('id', $id)->first();
        $units = DB::table('units')->get();
        return view('audit_teams.edit', compact('team', 'units'));
    }

    public function update(Request $request, $id)
    {
        DB::table('audit_teams')->where('id', $id)->update([
            'role' => $request->role,
            'assigned_units' => json_encode($request->assigned_units),
            'is_certified' => $request->has('is_certified'),
            'certificate_number' => $request->certificate_number,
            'notes' => $request->notes,
            'updated_at' => now(),
        ]);

        return redirect()->route('audit_teams.index')->with('success', 'Assignment updated!');
    }

    public function destroy($id)
    {
        DB::table('audit_teams')->where('id', $id)->delete();
        return redirect()->route('audit_teams.index')->with('success', 'Member deleted.');
    }
}