<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // WAJIB DIPANGGIL

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
        $request->validate([
            'document_number' => 'required|unique:documents,document_number',
            'title'           => 'required|string|max:255',
            'type'            => 'required',
            'status'          => 'required',
            'file_dokumen'    => 'required|file|mimes:pdf,doc,docx|max:10240', // Maks 10MB
        ]);

        try {
            // ==== INI DIA YANG KETINGGALAN KEMARIN, ERLIA! ====
            $file = $request->file('file_dokumen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            $disk = Storage::disk('minio');
            
            // Membuat variabel $path dan $url agar tidak merah lagi
            $path = $disk->putFileAs('documents', $file, $fileName);
            $url = $disk->url($path);
            // ==================================================

            Document::create([
                'document_number' => $request->document_number,
                'title'           => $request->title,
                'type'            => strtolower($request->type),
                'status'          => strtolower($request->status),
                'description'     => $request->description ?? '-',
                'parent_id'       => null,
                'effective_date'  => now(),
                'created_by'      => Auth::id() ?? 1,
                'current_version' => 1,
                'is_controlled'   => true,
                'is_active'       => true,
                'file_path'       => $path, 
                'file_url'        => $url,  
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

        // 4. Otomatis hapus file fisiknya di MinIO jika record di database dihapus
        if (!empty($document->file_path)) {
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            $disk = Storage::disk('minio');
            
            if ($disk->exists($document->file_path)) {
                $disk->delete($document->file_path);
            }
        }

        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document and associated file deleted successfully!');
    }
}