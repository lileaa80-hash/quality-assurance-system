<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = DB::table('documents')
            ->leftJoin('users', 'documents.created_by', '=', 'users.id')
            ->select('documents.*', 'users.name as creator_name')
            ->orderBy('documents.created_at', 'desc')
            ->get();

        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $parentDocs = DB::table('documents')->select('id', 'title', 'document_number')->get();
        return view('documents.create', compact('parentDocs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_number' => 'required|unique:documents',
            'title' => 'required',
            'type' => 'required',
        ]);

        DB::table('documents')->insert([
            'document_number' => $request->document_number,
            'title'           => $request->title,
            'type'            => $request->type,
            'status'          => 'draft',
            'description'     => $request->description,
            'created_by'      => Auth::id() ?? 1,
            'current_version' => 1,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil ditambah!');
    }

    public function show($id)
    {
        $document = DB::table('documents')
            ->leftJoin('users', 'documents.created_by', '=', 'users.id')
            ->select('documents.*', 'users.name as creator_name')
            ->where('documents.id', $id)
            ->first();

        return view('documents.show', compact('document'));
    }

    public function edit($id)
    {
        $document = DB::table('documents')->where('id', $id)->first();
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        DB::table('documents')->where('id', $id)->update([
            'document_number' => $request->document_number,
            'title'           => $request->title,
            'type'            => $request->type,
            'status'          => $request->status,
            'description'     => $request->description,
            'updated_at'      => now(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diupdate!');
    }

    public function destroy($id)
    {
        DB::table('documents')->where('id', $id)->delete();
        return redirect()->route('documents.index')->with('success', 'Dokumen dihapus.');
    }
}