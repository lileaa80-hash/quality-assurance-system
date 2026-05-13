<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StandardController extends Controller
{
    public function index()
    {
        $standards = DB::table('standards')
            ->leftJoin('users', 'standards.created_by', '=', 'users.id')
            ->select('standards.*', 'users.name as creator_name')
            ->orderBy('standards.created_at', 'desc')
            ->get();

        return view('standards.index', compact('standards'));
    }

    public function create()
    {
        $parentStandards = DB::table('standards')
            ->whereNull('parent_id')
            ->select('id', 'code', 'name')
            ->get();

        return view('standards.create', compact('parentStandards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:standards,code',
            'name' => 'required',
            'type' => 'required',
        ]);

        DB::table('standards')->insert([
            'code'        => $request->code,
            'name'        => $request->name,
            'description' => $request->description,
            'type'        => $request->type,
            'version'     => $request->version ?? '1.0',
            'parent_id'   => $request->parent_id,
            'is_active'   => $request->has('is_active') ? 1 : 0,
            'created_by'  => Auth::id() ?? 1, // Jika belum login, default ke ID 1
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('standards.index')
            ->with('success', 'Data Standard berhasil ditambahkan!');
    }

    /**
     * Display the specific standard.
     */
    public function show($id)
    {
        $standard = DB::table('standards')
            ->leftJoin('users', 'standards.created_by', '=', 'users.id')
            ->select('standards.*', 'users.name as creator_name')
            ->where('standards.id', $id)
            ->first();

        if (!$standard) {
            return redirect()->route('standards.index')->with('error', 'Standard tidak ditemukan!');
        }

        return view('standards.show', compact('standard'));
    }

    public function edit($id)
    {
        $standard = DB::table('standards')->where('id', $id)->first();
        
        $parentStandards = DB::table('standards')
            ->whereNull('parent_id')
            ->where('id', '!=', $id)
            ->get();

        return view('standards.edit', compact('standard', 'parentStandards'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:standards,code,' . $id,
            'name' => 'required',
        ]);

        DB::table('standards')->where('id', $id)->update([
            'code'        => $request->code,
            'name'        => $request->name,
            'description' => $request->description,
            'type'        => $request->type,
            'version'     => $request->version,
            'parent_id'   => $request->parent_id,
            'is_active'   => $request->has('is_active') ? 1 : 0,
            'updated_at'  => now(),
        ]);

        return redirect()->route('standards.index')
            ->with('success', 'Standard updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('standards')->where('id', $id)->delete();

        return redirect()->route('standards.index')
            ->with('success', 'Data Standard telah dihapus.');
    }
}