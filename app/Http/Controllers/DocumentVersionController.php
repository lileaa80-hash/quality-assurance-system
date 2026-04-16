<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocumentVersionController extends Controller
{
    /**
     * Menampilkan riwayat versi
        */
    public function index($document_id)
    {
        // Ambil data dokumen berdasarkan ID dari URL
        $document = DB::table('documents')->where('id', $document_id)->first();

        // Jika dokumen tidak ketemu, balikkan ke daftar dokumen
        if (!$document) {
            return redirect()->route('documents.index')->with('error', 'Dokumen tidak ditemukan.');
        }

        $versions = DB::table('document_versions')
            ->leftJoin('users', 'document_versions.created_by', '=', 'users.id')
            ->where('document_id', $document_id)
            ->select('document_versions.*', 'users.name as creator_name')
            ->orderBy('version_number', 'desc')
            ->get();

        return view('document_versions.index', compact('document', 'versions'));
    }

    public function create(Request $request)
    {
        $documentId = $request->query('document_id');
        
        // Ambil data dokumen pake Query Builder
        $document = DB::table('documents')->where('id', $documentId)->first();

        if (!$document) {
            return redirect()->route('documents.index')
                             ->with('error', 'Dokumen tidak ditemukan. Pastikan klik tombol dari halaman yang benar.');
        }

        // Cari nomor versi terakhir
        $lastVersion = DB::table('document_versions')
            ->where('document_id', $documentId)
            ->max('version_number');

        $nextVersion = $lastVersion ? $lastVersion + 1 : 1;

        return view('document_versions.create', compact('nextVersion', 'document', 'documentId'));
    }

    /**
     * Simpan Data Versi Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_id'        => 'required',
            'document_file'      => 'required|file|max:10240',
            'version_number'     => 'required|integer',
            'status'             => 'required|in:current,previous',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $documentId = $request->document_id;
                $newVersionNumber = $request->version_number;

                // Handle File Upload
                $file = $request->file('document_file');
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . str_replace(' ', '_', $originalName);
                
                $path = $file->storeAs(
                    "documents/{$documentId}/v{$newVersionNumber}", 
                    $fileName, 
                    'public'
                );

                // Jika status baru adalah 'current', turunkan status versi lama
                if ($request->status === 'current') {
                    DB::table('document_versions')
                        ->where('document_id', $documentId)
                        ->where('status', 'current')
                        ->update(['status' => 'previous']);

                    // Update versi aktif di tabel documents
                    DB::table('documents')
                        ->where('id', $documentId)
                        ->update(['current_version' => $newVersionNumber]);
                }

                // Insert data baru pake Query Builder
                DB::table('document_versions')->insert([
                    'document_id'        => $documentId,
                    'version_number'     => $newVersionNumber,
                    'change_description' => $request->change_description ?? 'Update versi',
                    'file_path'          => $path,
                    'file_name'          => $originalName,
                    'file_size'          => $file->getSize(),
                    'mime_type'          => $file->getMimeType(),
                    'status'             => $request->status,
                    'created_by'         => Auth::id() ?? 1,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
            });

            return redirect()->route('document_versions.index', $request->document_id)
                             ->with('success', "Versi berhasil disimpan!");

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal simpan: ' . $e->getMessage()]);
        }
    }

    /**
     * Hapus Versi
     */
    public function destroy($id)
    {
        $version = DB::table('document_versions')->where('id', $id)->first();

        if ($version) {
            if (Storage::disk('public')->exists($version->file_path)) {
                Storage::disk('public')->delete($version->file_path);
            }

            DB::table('document_versions')->where('id', $id)->delete();
            
            return redirect()->route('document_versions.index', $version->document_id)
                             ->with('success', 'Versi berhasil dihapus.');
        }

        return back()->with('error', 'Data tidak ditemukan.');
    }
}