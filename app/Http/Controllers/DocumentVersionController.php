<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentVersionController extends Controller
{
    public function index()
    {
        $versions = DB::table('document_versions')
            ->join('documents', 'document_versions.document_id', '=', 'documents.id')
            ->join('users', 'document_versions.created_by', '=', 'users.id')
            ->select(
                'document_versions.*',
                'documents.title as document_title',
                'users.name as creator_name'
            )
            ->orderBy('document_versions.created_at', 'desc')
            ->paginate(10);

        return view('document_versions.index', compact('versions'));
    }

    public function create()
    {
        $documents = DB::table('documents')->select('id', 'title', 'document_number')->get();
        return view('document_versions.create', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'file'        => 'required|file|max:20480', // Max 20MB
            'status'      => 'required'
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            
            // 1. Hitung versi terakhir untuk document ini
            $lastVersion = DB::table('document_versions')
                ->where('document_id', $request->document_id)
                ->max('version_number') ?? 0;
            
            $newVersion = $lastVersion + 1;

            // 2. KOREKSI: Upload ke MinIO menggunakan disk custom 'minio' kita
            $path = $file->store('documents/v' . $newVersion, 'minio'); 

            // 3. Simpan ke database
            $data = [
                'document_id'        => $request->document_id,
                'version_number'     => $newVersion,
                'change_description' => $request->change_description,
                'file_path'          => $path,
                'file_name'          => $file->getClientOriginalName(),
                'file_size'          => $file->getSize(),
                'mime_type'          => $file->getMimeType(),
                'status'             => $request->status,
                'created_by'         => Auth::id() ?? 1,
                'created_at'         => now(),
                'updated_at'         => now(),
            ];

            DB::table('document_versions')->insert($data);

            // 4. Update current_version di tabel documents
            DB::table('documents')
                ->where('id', $request->document_id)
                ->update(['current_version' => $newVersion]);

            DB::commit();
            return redirect()->route('document_versions.index')->with('success', 'Versi Baru Berhasil Diunggah ke MinIO!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Upload Versi: ' . $e->getMessage());
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $version = DB::table('document_versions')
            ->join('documents', 'document_versions.document_id', '=', 'documents.id')
            ->leftJoin('users as creator', 'document_versions.created_by', '=', 'creator.id')
            ->leftJoin('users as approver', 'document_versions.approved_by', '=', 'approver.id')
            ->select('document_versions.*', 'documents.title', 'creator.name as creator_name', 'approver.name as approver_name')
            ->where('document_versions.id', $id)
            ->first();

        return view('document_versions.show', compact('version'));
    }

    public function edit($id)
    {
        $version = DB::table('document_versions')->where('id', $id)->first();
        return view('document_versions.edit', compact('version'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        try {
            DB::table('document_versions')
                ->where('id', $id)
                ->update([
                    'change_description' => $request->change_description,
                    'status'             => $request->status,
                    'updated_at'         => now(),
                ]);

            return redirect()->route('document_versions.index')->with('success', 'Versi Diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal Update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $version = DB::table('document_versions')->where('id', $id)->first();
            
            if (!$version) {
                return redirect()->route('document_versions.index')->with('error', 'Data tidak ditemukan.');
            }
            
            // 5. KOREKSI: Pastikan pengecekan dan penghapusan file mengarah ke disk 'minio'
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            $disk = Storage::disk('minio');
            
            if (!empty($version->file_path) && $disk->exists($version->file_path)) {
                $disk->delete($version->file_path);
            }
            
            DB::table('document_versions')->where('id', $id)->delete();
            DB::commit();
            
            return redirect()->route('document_versions.index')
                             ->with('success', 'Versi Dokumen dan File Fisik Berhasil Dihapus dari MinIO!');
                             
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Delete Version: ' . $e->getMessage());
            return redirect()->route('document_versions.index')
                             ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}