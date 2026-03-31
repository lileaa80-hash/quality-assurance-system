<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Menampilkan daftar dokumen.
     */
    public function index()
    {
        // Mengambil data dokumen terbaru beserta user pembuatnya
        $documents = Document::with('creator')->latest()->get();
        return view('documents.index', compact('documents'));
    }

    /**
     * Menampilkan form tambah dokumen baru.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Menyimpan dokumen baru ke database.
     */
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

    /**
     * MENAMPILKAN DETAIL DOKUMEN (Penyembuh error yang kamu alami sekarang)
     */
    public function show(Document $document)
    {
        // Melempar data $document ke folder resources/views/documents/show.blade.php
        return view('documents.show', compact('document'));
    }

    /**
     * Menampilkan form edit dokumen.
     */
    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    /**
     * Update data dokumen.
     */
    public function update(Request $request, Document $document)
    {
        $data = $request->all();
        
        // Tetap paksa lowercase agar tidak error saat update
        if(isset($data['type'])) $data['type'] = strtolower($data['type']);
        if(isset($data['status'])) $data['status'] = strtolower($data['status']);
        
        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Document updated!');
    }

    /**
     * Menghapus dokumen.
     */
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