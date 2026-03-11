<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StandardController extends Controller
{
    /**
     * Display a listing of the standards.
     */
    public function index()
    {
        // Get all standards with creator name using Query Builder Join
        $standards = DB::table('standards')
            ->leftJoin('users', 'standards.created_by', '=', 'users.id')
            ->select('standards.*', 'users.name as creator_name')
            ->orderBy('standards.created_at', 'desc')
            ->get();

        return view('standards.index', compact('standards'));
    }

    /**
     * Show the form for creating a new standard.
     */
    public function create()
    {
        // Get list for parent standard selection
        $parentStandards = DB::table('standards')
            ->whereNull('parent_id')
            ->select('id', 'code', 'name')
            ->get();

        return view('standards.create', compact('parentStandards'));
    }

    /**
     * Store a newly created standard in database.
     */
    public function store(Request $request)
    {
        // Validation - Biar data nggak asal masuk
        $request->validate([
            'code' => 'required|unique:standards,code',
            'name' => 'required',
            'type' => 'required',
        ]);

        // Insert using Query Builder
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

    /**
     * Show the form for editing.
     */
    public function edit($id)
    {
        $standard = DB::table('standards')->where('id', $id)->first();
        
        $parentStandards = DB::table('standards')
            ->whereNull('parent_id')
            ->where('id', '!=', $id)
            ->get();

        return view('standards.edit', compact('standard', 'parentStandards'));
    }

    /**
     * Update standard data.
     */
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

    /**
     * Delete standard.
     */
    public function destroy($id)
    {
        DB::table('standards')->where('id', $id)->delete();

        return redirect()->route('standards.index')
            ->with('success', 'Data Standard telah dihapus.');
    }
}