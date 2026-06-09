<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentDistributionController extends Controller
{
    public function index()
    {
        $distributions = DB::table('document_distributions')
            ->latest()
            ->get();

        return view('document_distributions.index', compact('distributions'));
    }

    public function create()
    {
        $documents = DB::table('documents')->get();
        $units = DB::table('units')->get();
        $users = DB::table('users')->get();

        return view('document_distributions.create', compact('documents', 'units', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required',
            'unit_id' => 'required',
            'distribution_type' => 'required',
            'distributed_at' => 'required',
            'distributed_by' => 'required',
            'status' => 'required',
        ]);

        DB::table('document_distributions')->insert([
            'document_id' => $request->document_id,
            'unit_id' => $request->unit_id,
            'distribution_type' => $request->distribution_type,
            'copy_number' => $request->copy_number,
            'distributed_at' => $request->distributed_at,
            'distributed_by' => $request->distributed_by,
            'received_at' => $request->received_at,
            'received_by' => $request->received_by,
            'status' => $request->status,
            'notes' => $request->notes,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // PERBAIKAN: Mengubah strip (-) menjadi underscore (_)
        return redirect()->route('document_distributions.index')
            ->with('success', 'Distribution created successfully!');
    }

    public function show($id)
    {
        $distribution = DB::table('document_distributions')
            ->where('id', $id)
            ->first();

        return view('document_distributions.show', compact('distribution'));
    }

    public function edit($id)
    {
        $distribution = DB::table('document_distributions')
            ->where('id', $id)
            ->first();

        $documents = DB::table('documents')->get();
        $units = DB::table('units')->get();
        $users = DB::table('users')->get();

        return view('document_distributions.edit', compact('distribution', 'documents', 'units', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'document_id' => 'required',
            'unit_id' => 'required',
            'distribution_type' => 'required',
            'distributed_at' => 'required',
            'distributed_by' => 'required',
            'status' => 'required',
        ]);

        DB::table('document_distributions')
            ->where('id', $id)
            ->update([
                'document_id' => $request->document_id,
                'unit_id' => $request->unit_id,
                'distribution_type' => $request->distribution_type,
                'copy_number' => $request->copy_number,
                'distributed_at' => $request->distributed_at,
                'distributed_by' => $request->distributed_by,
                'received_at' => $request->received_at,
                'received_by' => $request->received_by,
                'status' => $request->status,
                'notes' => $request->notes,
                'updated_at' => now(),
            ]);

        // PERBAIKAN: Mengubah strip (-) menjadi underscore (_)
        return redirect()->route('document_distributions.index')
            ->with('success', 'Distribution updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('document_distributions')
            ->where('id', $id)
            ->delete();

        // PERBAIKAN: Mengubah strip (-) menjadi underscore (_)
        return redirect()->route('document_distributions.index')
            ->with('success', 'Distribution deleted successfully!');
    }
}