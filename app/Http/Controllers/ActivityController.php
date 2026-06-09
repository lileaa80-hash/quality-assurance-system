<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = DB::table('activities')->latest()->get();

        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
        ]);

        DB::table('activities')->insert([
            'log_name' => $request->log_name,
            'description' => $request->description,
            'subject_type' => $request->subject_type,
            'subject_id' => $request->subject_id,
            'causer_type' => $request->causer_type,
            'causer_id' => $request->causer_id,
            'properties' => $request->properties,
            'event' => $request->event,
            'ip_address' => $request->ip_address,
            'user_agent' => $request->user_agent,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('activities.index')
            ->with('success', 'Activity created successfully!');
    }

    public function show($id)
    {
        $activity = DB::table('activities')->where('id', $id)->first();

        return view('activities.show', compact('activity'));
    }

    public function edit($id)
    {
        $activity = DB::table('activities')->where('id', $id)->first();

        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required',
        ]);

        DB::table('activities')->where('id', $id)->update([
            'log_name' => $request->log_name,
            'description' => $request->description,
            'subject_type' => $request->subject_type,
            'subject_id' => $request->subject_id,
            'causer_type' => $request->causer_type,
            'causer_id' => $request->causer_id,
            'properties' => $request->properties,
            'event' => $request->event,
            'ip_address' => $request->ip_address,
            'user_agent' => $request->user_agent,
            'updated_at' => now(),
        ]);

        return redirect()->route('activities.index')
            ->with('success', 'Activity updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('activities')->where('id', $id)->delete();

        return redirect()->route('activities.index')
            ->with('success', 'Activity deleted successfully!');
    }
}