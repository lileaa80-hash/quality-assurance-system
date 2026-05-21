<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileAttachmentController extends Controller
{
    public function index()
    {
        // Menggunakan join agar nama uploader (staff) tampil di tabel master index berkas
        $attachments = DB::table('file_attachments')
            ->join('users', 'file_attachments.uploaded_by', '=', 'users.id')
            ->select('file_attachments.*', 'users.name as uploader_name')
            ->orderBy('file_attachments.created_at', 'desc')
            ->paginate(10);

        return view('file_attachments.index', compact('attachments'));
    }

    public function create()
    {
        // Mengambil referensi pengguna staff uploader untuk pilihan dropdown form
        $users = DB::table('users')->orderBy('name', 'asc')->get();

        // Opsi daftar model target untuk polymorphic target (attachable_type)
        $targetTypes = [
            'App\Models\Document' => 'Document (Dokumen Mutu)',
            'App\Models\AuditFinding' => 'Audit Finding (Temuan Audit)',
            'App\Models\Report' => 'Report (Laporan Berkala)',
            'App\Models\AccreditationBorang' => 'Accreditation Borang (Borang Akreditasi)',
        ];

        return view('file_attachments.create', compact('users', 'targetTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attachable_type'   => 'required|string|max:255',
            'attachable_id'     => 'required|integer|min:1',
            'file'              => 'required|file|max:20480', // Maksimal batasan ukuran berkas 20MB
            'version'           => 'required|integer|min:1',
            'uploaded_by'       => 'required|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('file')) {
                $uploadedFile = $request->file('file');
                $originalName = $uploadedFile->getClientOriginalName();
                $mimeType = $uploadedFile->getClientMimeType();
                $fileSize = $uploadedFile->getSize();
                
                // Membuat nama fisik acak dan unik agar aman di cloud storage MinIO
                $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                
                // Eksekusi penyimpanan fisik berkas ke target disk 'minio'
                $filePath = $uploadedFile->storeAs('attachments', $filename, 'minio');

                // Metadata struktural file diringkas ke bentuk format JSON string text
                $metadata = json_encode([
                    'extension' => $uploadedFile->getClientOriginalExtension(),
                    'uploaded_at' => now()->toIso8601String(),
                ]);

                $isCurrent = $request->has('is_current') ? true : false;

                // Aturan otomatisasi: Jika file baru ini dipasang sebagai versi utama aktif (is_current = true),
                // maka matikan seluruh status bendera versi aktif (is_current) lama pada entitas objek target yang sama.
                if ($isCurrent) {
                    DB::table('file_attachments')
                        ->where('attachable_type', $request->attachable_type)
                        ->where('attachable_id', $request->attachable_id)
                        ->update(['is_current' => false, 'updated_at' => now()]);
                }

                // Insert record metadata file baru ke database
                DB::table('file_attachments')->insert([
                    'attachable_type'   => $request->attachable_type,
                    'attachable_id'     => $request->attachable_id,
                    'filename'          => $filename,
                    'original_filename' => $originalName,
                    'file_path'         => $filePath,
                    'disk'              => 'minio',
                    'mime_type'         => $mimeType,
                    'file_size'         => $fileSize,
                    'metadata'          => $metadata,
                    'version'           => $request->version,
                    'is_current'        => $isCurrent,
                    'uploaded_by'       => $request->uploaded_by,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('file_attachments.index')->with('success', 'File Attachment Berhasil Diunggah ke Cluster MinIO!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Store File Attachment: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memproses unggahan berkas: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        // Join data untuk menampilkan informasi spesifik berkas secara detail beserta nama pengunggahnya
        $attachment = DB::table('file_attachments')
            ->join('users', 'file_attachments.uploaded_by', '=', 'users.id')
            ->select('file_attachments.*', 'users.name as uploader_name')
            ->where('file_attachments.id', $id)
            ->first();

        if (!$attachment) {
            abort(404);
        }

        // Decode metadata JSON string ke Object/Array agar aman dirender di view 'show'
        $attachment->metadata = json_decode($attachment->metadata, true);

        return view('file_attachments.show', compact('attachment'));
    }

    public function edit($id)
    {
        $attachment = DB::table('file_attachments')->where('id', $id)->first();

        if (!$attachment) {
            abort(404);
        }

        $users = DB::table('users')->orderBy('name', 'asc')->get();

        $targetTypes = [
            'App\Models\Document' => 'Document (Dokumen Mutu)',
            'App\Models\AuditFinding' => 'Audit Finding (Temuan Audit)',
            'App\Models\Report' => 'Report (Laporan Berkala)',
            'App\Models\AccreditationBorang' => 'Accreditation Borang (Borang Akreditasi)',
        ];

        return view('file_attachments.edit', compact('attachment', 'users', 'targetTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'version'     => 'required|integer|min:1',
            'uploaded_by' => 'required|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            $attachment = DB::table('file_attachments')->where('id', $id)->first();
            if (!$attachment) {
                return redirect()->route('file_attachments.index')->with('error', 'Data berkas tidak ditemukan.');
            }

            $isCurrent = $request->has('is_current') ? true : false;

            // Jika status diubah menjadi versi aktif utama (is_current = true), matikan is_current berkas lama lainnya
            if ($isCurrent && !$attachment->is_current) {
                DB::table('file_attachments')
                    ->where('attachable_type', $attachment->attachable_type)
                    ->where('attachable_id', $attachment->attachable_id)
                    ->where('id', '!=', $id)
                    ->update(['is_current' => false, 'updated_at' => now()]);
            }

            // Update data konfigurasi versi berkas
            DB::table('file_attachments')
                ->where('id', $id)
                ->update([
                    'version'     => $request->version,
                    'uploaded_by' => $request->uploaded_by,
                    'is_current'  => $isCurrent,
                    'updated_at'  => now(),
                ]);

            DB::commit();
            return redirect()->route('file_attachments.index')->with('success', 'Konformasi Parameter Berkas Berhasil Diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Update File Attachment: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui konfigurasi data berkas: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Gunakan typecast (array) di depannya
            $attachment = (array) DB::table('file_attachments')->where('id', $id)->first();
            
            // Cek jika array kosong
            if (!$attachment) {
                return redirect()->route('file_attachments.index')->with('error', 'Data berkas tidak ditemukan.');
            }

            // Hapus data index record di tabel database
            DB::table('file_attachments')->where('id', $id)->delete();

            DB::commit();
            return redirect()->route('file_attachments.index')->with('success', 'Record File Attachment Berhasil Dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Delete File Attachment: ' . $e->getMessage());
            return redirect()->route('file_attachments.index')->with('error', 'Gagal menghapus data berkas dari sistem: ' . $e->getMessage());
        }
    }
}