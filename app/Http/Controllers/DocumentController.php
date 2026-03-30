<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('creator')->latest()->get();
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        // Validasi hanya data yang ada di form
        $request->validate([
            'document_number' => 'required|unique:documents,document_number',
            'title'           => 'required|string|max:255',
            'type'            => 'required',
            'status'          => 'required',
        ]);

        try {
            Document::create([
                'document_number'    => $request->document_number,
                'title'              => $request->title,
                'type'               => $request->type,
                'status'             => $request->status,
                'description'        => $request->description ?? '-',
                'parent_id'          => null, // Di-null kan saja karena tidak ada di form
                'effective_date'     => now(),
                'created_by'         => Auth::id() ?? 1,
                'current_version'    => 1,
                'is_controlled'      => true,
                'is_active'          => true,
            ]);

            return redirect()->route('documents.index')->with('success', 'New document added!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $document = Document::findOrFail($id);
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $document->update($request->all());
        return redirect()->route('documents.index')->with('success', 'Document updated!');
    }

    public function destroy($id)
    {
        Document::findOrFail($id)->delete();
        return redirect()->route('documents.index')->with('success', 'Document deleted!');
    }
}