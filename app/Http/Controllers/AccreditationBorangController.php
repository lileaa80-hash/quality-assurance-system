<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // WAJIB DIPANGGIL UNTUK MINIO

class AccreditationBorangController extends Controller
{
    public function index()
    {
        $borangs = DB::table('accreditation_borangs')
            ->join('accreditation_periods', 'accreditation_borangs.accreditation_period_id', '=', 'accreditation_periods.id')
            ->join('standards', 'accreditation_borangs.standard_id', '=', 'standards.id')
            ->leftJoin('users', 'accreditation_borangs.filled_by', '=', 'users.id')
            ->select(
                'accreditation_borangs.*',
                'accreditation_periods.period_name',
                'standards.name as standard_name',
                'users.name as filler_name'
            )
            ->orderBy('accreditation_borangs.created_at', 'desc')
            ->get();

        return view('accreditation_borangs.index', compact('borangs'));
    }

    public function create()
    {
        $periods = DB::table('accreditation_periods')->get();
        $standards = DB::table('standards')->get();
        $indicators = DB::table('standard_indicators')->get();

        return view('accreditation_borangs.create', compact('periods', 'standards', 'indicators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'accreditation_period_id' => 'required',
            'standard_id'             => 'required',
            'standard_indicator_id'   => 'required',
            'status'                  => 'required',
            'supporting_documents'    => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:20480', // Max 20MB
        ]);

        try {
            $path = null;

            // Proses upload file bukti pendukung borang ke MinIO
            if ($request->hasFile('supporting_documents')) {
                $file = $request->file('supporting_documents');
                $fileName = time() . '_' . $file->getClientOriginalName();
                
                /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
                $disk = Storage::disk('minio');
                $path = $disk->putFileAs('borangs', $file, $fileName);
            }

            $data = [
                'accreditation_period_id' => $request->accreditation_period_id,
                'standard_id'             => $request->standard_id,
                'standard_indicator_id'   => $request->standard_indicator_id,
                'response'                => $request->response,
                'analysis'                => $request->analysis,
                'target'                  => $request->target,
                'achievement'             => $request->achievement,
                // Simpan path dari MinIO ke kolom supporting_documents
                'supporting_documents'    => $path, 
                'self_assessment_score'   => $request->self_assessment_score ?? 0,
                'status'                  => $request->status,
                'filled_by'               => Auth::id() ?? 1,
                'created_at'              => now(),
                'updated_at'              => now(),
            ];

            DB::table('accreditation_borangs')->insert($data);

            return redirect()->route('accreditation_borangs.index')->with('success', 'Borang dan File Bukti Berhasil Disimpan!');

        } catch (\Exception $e) {
            dd("DATABASE ERROR: " . $e->getMessage()); 
        }
    }

    public function show($id)
    {
        $borang = DB::table('accreditation_borangs')
            ->join('accreditation_periods', 'accreditation_borangs.accreditation_period_id', '=', 'accreditation_periods.id')
            ->join('standards', 'accreditation_borangs.standard_id', '=', 'standards.id')
            ->join('standard_indicators', 'accreditation_borangs.standard_indicator_id', '=', 'standard_indicators.id')
            ->select(
                'accreditation_borangs.*', 
                'accreditation_periods.period_name', 
                'standards.name as standard_name'
            )
            ->where('accreditation_borangs.id', $id)
            ->first();
            
        if (!$borang) { abort(404); }

        // Tambahkan link URL utuh dari MinIO agar file bisa diklik/di-download di halaman show
        $fileUrl = $borang->supporting_documents ? Storage::disk('minio')->url($borang->supporting_documents) : null;

        return view('accreditation_borangs.show', compact('borang', 'fileUrl'));
    }

    public function edit($id)
    {
        $borang = DB::table('accreditation_borangs')->where('id', $id)->first();

        if (!$borang) {
            abort(404);
        }

        $periods = DB::table('accreditation_periods')->get();
        
        return view('accreditation_borangs.edit', compact('borang', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status'                => 'required|in:draft,submitted,approved',
            'self_assessment_score' => 'nullable|numeric|min:0|max:4',
            'supporting_documents'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:20480',
        ]);

        try {
            $updateData = [
                'response'              => $request->response,
                'analysis'              => $request->analysis,
                'target'                => $request->target,
                'achievement'           => $request->achievement,
                'self_assessment_score' => $request->self_assessment_score,
                'status'                => $request->status,
                'updated_at'            => now(),
            ];

            // Jika user mengunggah file baru saat edit, ganti file lama di MinIO
            if ($request->hasFile('supporting_documents')) {
                $borangOld = DB::table('accreditation_borangs')->where('id', $id)->first();
                
                /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
                $disk = Storage::disk('minio');

                // Hapus file lama jika ada
                if (!empty($borangOld->supporting_documents) && $disk->exists($borangOld->supporting_documents)) {
                    $disk->delete($borangOld->supporting_documents);
                }

                // Upload file pengganti baru
                $file = $request->file('supporting_documents');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $updateData['supporting_documents'] = $disk->putFileAs('borangs', $file, $fileName);
            }

            DB::table('accreditation_borangs')->where('id', $id)->update($updateData);

            return redirect()->route('accreditation_borangs.index')
                             ->with('success', 'Borang Berhasil Diperbarui!');

        } catch (\Exception $e) {
            Log::error('Error Update Borang: ' . $e->getMessage());
            return back()->with('error', 'Update Gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $borang = DB::table('accreditation_borangs')->where('id', $id)->first();
            
            if ($borang) {
                // Hapus file pendukung fisik dari MinIO terlebih dahulu sebelum data DB dihapus
                /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
                $disk = Storage::disk('minio');
                
                if (!empty($borang->supporting_documents) && $disk->exists($borang->supporting_documents)) {
                    $disk->delete($borang->supporting_documents);
                }
                
                DB::table('accreditation_borangs')->where('id', $id)->delete();
            }

            return redirect()->route('accreditation_borangs.index')
                             ->with('success', 'Borang dan Bukti Fisik Berhasil Dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('accreditation_borangs.index')
                             ->with('error', 'Gagal menghapus data.');
        }
    }
}