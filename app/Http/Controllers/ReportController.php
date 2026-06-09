<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $reports = DB::table('reports')
            ->latest()
            ->get();

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        $users = DB::table('users')->get();

        return view('reports.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'format' => 'required',
            'created_by' => 'required',
        ]);

        DB::table('reports')->insert([
            'title' => $request->title,
            'type' => $request->type,
            'parameters' => $request->parameters,
            'data_summary' => $request->data_summary,
            'file_path' => $request->file_path,
            'format' => $request->format,
            'year' => $request->year,
            'quarter' => $request->quarter,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => $request->created_by,
            'generated_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('reports.index')
            ->with('success', 'Report created successfully!');
    }

    public function show($id)
    {
        $report = DB::table('reports')->where('id', $id)->first();

        return view('reports.show', compact('report'));
    }

    public function edit($id)
    {
        $report = DB::table('reports')->where('id', $id)->first();
        $users = DB::table('users')->get();

        return view('reports.edit', compact('report', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'format' => 'required',
            'created_by' => 'required',
        ]);

        DB::table('reports')->where('id', $id)->update([
            'title' => $request->title,
            'type' => $request->type,
            'parameters' => $request->parameters,
            'data_summary' => $request->data_summary,
            'file_path' => $request->file_path,
            'format' => $request->format,
            'year' => $request->year,
            'quarter' => $request->quarter,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => $request->created_by,
            'updated_at' => now(),
        ]);

        return redirect()->route('reports.index')
            ->with('success', 'Report updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('reports')->where('id', $id)->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Report deleted successfully!');
    }
}