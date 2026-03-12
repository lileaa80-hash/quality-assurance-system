<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuditScheduleController extends Controller
{
    public function index()
    {
        $schedules = DB::table('audit_schedules')
            ->leftJoin('users', 'audit_schedules.created_by', '=', 'users.id')
            ->select('audit_schedules.*', 'users.name as creator_name')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('audit_schedules.index', compact('schedules'));
    }

    public function create()
    {
        $standards = DB::table('standards')->get();
        return view('audit_schedules.create', compact('standards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'audit_number' => 'required|unique:audit_schedules',
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'standards_used' => 'required|array',
        ]);

        DB::table('audit_schedules')->insert([
            'audit_number' => $request->audit_number,
            'title' => $request->title,
            'type' => $request->type,
            'scope' => $request->scope,
            'period_year' => $request->period_year,
            'period_semester' => $request->period_semester,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'standards_used' => json_encode($request->standards_used),
            'status' => 'planned',
            'notes' => $request->notes,
            'created_by' => Auth::id() ?? 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('audit_schedules.index')->with('success', 'Audit Schedule created successfully.');
    }

    public function show($id)
    {
        $schedule = DB::table('audit_schedules')
            ->leftJoin('users', 'audit_schedules.created_by', '=', 'users.id')
            ->select('audit_schedules.*', 'users.name as creator_name')
            ->where('audit_schedules.id', $id)
            ->first();

        return view('audit_schedules.show', compact('schedule'));
    }

    public function edit($id)
    {
        $schedule = DB::table('audit_schedules')->where('id', $id)->first();
        $standards = DB::table('standards')->get();
        return view('audit_schedules.edit', compact('schedule', 'standards'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'standards_used' => 'required|array',
        ]);

        DB::table('audit_schedules')->where('id', $id)->update([
            'title' => $request->title,
            'type' => $request->type,
            'scope' => $request->scope,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'standards_used' => json_encode($request->standards_used),
            'status' => $request->status,
            'notes' => $request->notes,
            'updated_at' => now(),
        ]);

        return redirect()->route('audit_schedules.index')->with('success', 'Audit Schedule updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('audit_schedules')->where('id', $id)->delete();
        return redirect()->route('audit_schedules.index')->with('success', 'Audit Schedule deleted.');
    }
}