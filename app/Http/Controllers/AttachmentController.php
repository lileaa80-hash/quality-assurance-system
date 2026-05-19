<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
    /**
     * Menampilkan daftar riwayat berkas di sistem
     */
    public function index()
    {
        // Menggunakan leftJoin agar halaman index tidak error/kosong jika data users atau tabel users belum siap
        $attachments = DB::table('file_attachments')
            ->leftJoin('users', 'file_attachments.uploaded_by', '=', 'users.id')
            ->select('file_attachments.*', 'users.name as uploader_name')
            ->orderBy('file_attachments.created_at', 'desc')
            ->paginate(10);

        return view('file_attachments.index', compact('attachments'));
    }

    /**
     * Form Unggah Berkas Baru
     */
    public function create()
    {
        $targetTypes = [
            'App\Models\Document' => 'Document (Dokumen Mutu)',
            'App\Models\AuditReport' => 'Audit Report (Laporan Audit)',
            'App\Models\CorrectiveAction' => 'Corrective Action (Tindakan Korektif)',
        ];

        return view('file_attachments.create', compact('targetTypes'));
    }

    /**
     * Menyimpan berkas baru ke MinIO S3 dan mencatat data ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'attachable_type' => 'required|string|max:255',
            'attachable_id'   => 'required|integer|min:1',
            'file'            => 'required|file|max:20480', // Maksimal 20MB
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getClientMimeType();
            $fileSize = $file->getSize();
            $extension = $file->getClientOriginalExtension();
            
            // Generate nama unik UUID
            $filename = Str::uuid() . '.' . $extension;

            // Folder di MinIO
            $folderName = strtolower(basename(str_replace('\\', '/', $request->attachable_type)));
            $targetFolder = "attachments/{$folderName}";

            // 1. Unggah ke MinIO menggunakan disk 's3' bawaan Laravel
            $uploadedPath = Storage::disk('s3')->putFileAs($targetFolder, $file, $filename);

            if (!$uploadedPath) {
                throw new \Exception("Gagal mengunggah komponen fisik berkas ke server MinIO.");
            }

            // 2. Ambil nomor versi terakhir
            $latestVersion = DB::table('file_attachments')
                ->where('attachable_type', $request->attachable_type)
                ->where('attachable_id', $request->attachable_id)
                ->max('version') ?? 0;

            $nextVersion = $latestVersion + 1;

            // 3. Matikan flag berkas aktif lama
            if ($latestVersion > 0) {
                DB::table('file_attachments')
                    ->where('attachable_type', $request->attachable_type)
                    ->where('attachable_id', $request->attachable_id)
                    ->update([
                        'is_current' => false,
                        'updated_at' => now()
                    ]);
            }

            // 4. Metadata JSON
            $metadata = [
                'client_ip'  => $request->ip(),
                'extension'  => $extension,
                'user_agent' => $request->userAgent()
            ];

            // 5. Simpan record data
            DB::table('file_attachments')->insert([
                'attachable_type'   => $request->attachable_type,
                'attachable_id'     => $request->attachable_id,
                'filename'          => $filename,
                'original_filename' => $originalName,
                'file_path'         => $uploadedPath,
                'disk'              => 's3',
                'mime_type'         => $mimeType,
                'file_size'         => $fileSize,
                'metadata'          => json_encode($metadata),
                'version'           => $nextVersion,
                'is_current'        => true,
                'uploaded_by'       => Auth::id() ?? 1, // Jika belum login, otomatis pakai ID 1
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            DB::commit();
            return redirect()->route('file_attachments.index')->with('success', 'Berkas Berhasil Diunggah!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Store Attachment: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal mengunggah berkas: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail informasi berkas lampiran
     */
    public function show($id)
    {
        $attachment = DB::table('file_attachments')
            ->leftJoin('users', 'file_attachments.uploaded_by', '=', 'users.id')
            ->select('file_attachments.*', 'users.name as uploader_name')
            ->where('file_attachments.id', $id)
            ->first();

        if (!$attachment) {
            abort(404);
        }

        return view('file_attachments.show', compact('attachment'));
    }

    /**
     * Form Edit Data Lampiran Berkas
     */
    public function edit($id)
    {
        $attachment = DB::table('file_attachments')->where('id', $id)->first();
        
        if (!$attachment) {
            abort(404);
        }

        $targetTypes = [
            'App\Models\Document' => 'Document (Dokumen Mutu)',
            'App\Models\AuditReport' => 'Audit Report (Laporan Audit)',
            'App\Models\CorrectiveAction' => 'Corrective Action (Tindakan Korektif)',
        ];

        return view('file_attachments.edit', compact('attachment', 'targetTypes'));
    }

    /**
     * Memperbarui informasi data lampiran di database
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'is_current' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $attachment = DB::table('file_attachments')->where('id', $id)->first();
            if (!$attachment) {
                return back()->with('error', 'Data berkas tidak ditemukan.');
            }

            if ($request->is_current == true) {
                DB::table('file_attachments')
                    ->where('attachable_type', $attachment->attachable_type)
                    ->where('attachable_id', $attachment->attachable_id)
                    ->where('id', '!=', $id)
                    ->update([
                        'is_current' => false,
                        'updated_at' => now()
                    ]);
            }

            DB::table('file_attachments')
                ->where('id', $id)
                ->update([
                    'is_current' => $request->is_current,
                    'updated_at' => now(),
                ]);

            DB::commit();
            return redirect()->route('file_attachments.index')->with('success', 'Data Berhasil Diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Update Attachment: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus transaksi data sekaligus menghapus objek fisik di MinIO
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $attachment = DB::table('file_attachments')->where('id', $id)->first();
            if (!$attachment) {
                return redirect()->route('file_attachments.index')->with('error', 'Data berkas tidak ditemukan.');
            }

            // Hapus berkas fisik di MinIO
            if (Storage::disk($attachment->disk)->exists($attachment->file_path)) {
                Storage::disk($attachment->disk)->delete($attachment->file_path);
            }

            // Hapus rekor di DB
            DB::table('file_attachments')->where('id', $id)->delete();
            
            // Rollback status is_current ke versi sebelumnya jika yang dihapus adalah file utama aktif
            if ($attachment->is_current) {
                $substituteAttachment = DB::table('file_attachments')
                    ->where('attachable_type', $attachment->attachable_type)
                    ->where('attachable_id', $attachment->attachable_id)
                    ->orderBy('version', 'desc')
                    ->first();

                if ($substituteAttachment) {
                    DB::table('file_attachments')
                        ->where('id', $substituteAttachment->id)
                        ->update([
                            'is_current' => true,
                            'updated_at' => now()
                        ]);
                }
            }

    //         DB::commit();
    //         return redirect()->route('file_attachments.index')->with('success', 'Berkas dan Rekor Data Berhasil Dihapus!');
            
        // } catch (\Exception $e) {
    //     //     DB::rollBack();
    //     //     Log::error('Error Delete Attachment: ' . $e->getMessage());
    //     //     return redirect()->route('file_attachments.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}