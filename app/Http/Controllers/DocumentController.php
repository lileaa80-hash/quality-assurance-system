<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        // Mengambil data dokumen terbaru beserta user pembuatnya
        $documents = Document::with('creator')->latest()->get();
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_number' => 'required|unique:documents,document_number',
            'title'           => 'required|string|max:255',
            'type'            => 'required',
            'status'          => 'required',
        ]);

        try {
            Document::create([
                'document_number' => $request->document_number,
                'title'           => $request->title,
                'type'            => strtolower($request->type), // Menghindari error Data Truncated
                'status'          => strtolower($request->status),
                'description'     => $request->description ?? '-',
                'parent_id'       => null,
                'effective_date'  => now(),
                'created_by'      => Auth::id() ?? 1, // Menggunakan ID 1 jika belum login
                'current_version' => 1,
                'is_controlled'   => true,
                'is_active'       => true,
            ]);

            return redirect()->route('documents.index')->with('success', 'Document added successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal simpan: ' . $e->getMessage()]);
        }
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $data = $request->all();
        if(isset($data['type'])) $data['type'] = strtolower($data['type']);
        if(isset($data['status'])) $data['status'] = strtolower($data['status']);
        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Document updated!');
    }

    public function destroy($id)
    {
        $document = Document::find($id);

        if (!$document) {
            return redirect()->route('documents.index')->with('error', 'Dokumen tidak ditemukan!');
        }

        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document deleted successfully!');
    }
}