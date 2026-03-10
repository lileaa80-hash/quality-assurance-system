<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    public function index()
    {
        $units = DB::table('units')->latest()->get();
        return view('units.index', compact('units'));
    }

    public function create()
    {
        $parentUnits = DB::table('units')->get();
        return view('units.create', compact('parentUnits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:units,code',
            'name' => 'required',
            'type' => 'required',
            'level' => 'required',
            'is_active' => 'required',
        ]);

        DB::table('units')->insert([
            'code' => $request->code,
            'name' => $request->name,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
            'level' => $request->level,
            'accreditation_status' => $request->accreditation_status,
            'accreditation_expiry' => $request->accreditation_expiry,
            'head_name' => $request->head_name,
            'head_nip' => $request->head_nip,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_active' => $request->is_active,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('units.index')->with('success', 'Unit created successfully!');
    }

    public function show($id)
    {
        $unit = DB::table('units')->where('id', $id)->first();
        return view('units.show', compact('unit'));
    }

    public function edit($id)
    {
        $unit = DB::table('units')->where('id', $id)->first();
        $parentUnits = DB::table('units')->where('id', '!=', $id)->get();
        return view('units.edit', compact('unit', 'parentUnits'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:units,code,' . $id,
            'name' => 'required',
            'type' => 'required',
            'level' => 'required', // Tambahkan validasi agar tidak null
        ]);

        DB::table('units')->where('id', $id)->update([
            'code' => $request->code,
            'name' => $request->name,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
            'level' => $request->level, // Pastikan ini dikirim ke database
            'accreditation_status' => $request->accreditation_status,
            'accreditation_expiry' => $request->accreditation_expiry,
            'head_name' => $request->head_name,
            'head_nip' => $request->head_nip,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_active' => $request->is_active,
            'updated_at' => now(),
        ]);

        return redirect()->route('units.index')->with('success', 'Unit updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('units')->where('id', $id)->delete();
        return redirect()->route('units.index')->with('success', 'Unit deleted successfully!');
    }
}