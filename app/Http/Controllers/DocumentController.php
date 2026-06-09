<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display all documents
     */
    public function index()
    {
        $documents = Document::with('creator')
            ->latest()
            ->get();

        return view('documents.index', compact('documents'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store new document
     */
    public function store(Request $request)
{
    $request->validate([
        'document_number' => 'required|unique:documents,document_number',
        'title'           => 'required|string|max:255',
        'type'            => 'required',
        'status'          => 'required',
        'file_dokumen'    => 'required|file|mimes:pdf,doc,docx,xls,xlsx,xlsm|max:25000', // Dinaikkan ke 25MB
    ]);

    try {
        /**
         * CHECK FILE
         */
        if (!$request->hasFile('file_dokumen')) {
            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'File tidak ditemukan!'
                ]);
        }

        /**
         * GET FILE
         */
        $file = $request->file('file_dokumen');

        /**
         * UNIQUE FILE NAME
         */
        $fileName = time() . '_' . str_replace(
            ' ',
            '_',
            $file->getClientOriginalName()
        );

        /**
         * UPLOAD TO LOCAL STORAGE (Penyimpanan Lokal Laptop)
         */
        // File akan disimpan ke folder: storage/app/public/documents
        $path = $file->storeAs('documents', $fileName, 'public');

        if (!$path) {
            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Upload file ke lokal gagal!'
                ]);
        }

        // Generate URL lokal yang bisa diakses publik
        $url = asset('storage/' . $path);

        Document::create([
            'document_number' => $request->document_number,
            'title'           => $request->title,
            'type'            => strtolower($request->type),
            'status'          => strtolower($request->status),
            'description'     => $request->description ?? '-',
            'parent_id'       => null,
            'effective_date'  => $request->effective_date ? $request->effective_date : now(),
            'created_by'      => Auth::id() ?? 1,
            'current_version' => 1,
            'is_controlled'   => $request->is_controlled ?? 1,
            'is_active'       => true,
            'file_path'       => $path,
            'file_url'        => $url,
        ]);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Document berhasil ditambahkan!');

    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->withErrors([
                'error' => 'Gagal menyimpan data: ' . $e->getMessage()
            ]);
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

        if (isset($data['type'])) {
            $data['type'] = strtolower($data['type']);
        }

        if (isset($data['status'])) {
            $data['status'] = strtolower($data['status']);
        }

        $document->update($data);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Document updated successfully!');
    }

    /**
     * Delete document
     */
    public function destroy($id)
    {
        $document = Document::find($id);

        if (!$document) {
            return redirect()
                ->route('documents.index')
                ->with('error', 'Dokumen tidak ditemukan!');
        }

        if (!empty($document->file_path)) {
            if (Storage::disk('minio')->exists($document->file_path)) {
                Storage::disk('minio')->delete($document->file_path);
            }
        }

        $document->delete();

        return redirect()
            ->route('documents.index')
            ->with('success', 'Document deleted successfully!');
    }
}