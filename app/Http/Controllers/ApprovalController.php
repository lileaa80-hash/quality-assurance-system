<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApprovalController extends Controller
{
    public function index()
    {
        // Menggunakan join agar nama tahapan alur dan pengverifikasi tampil di tabel index
        $approvals = DB::table('approvals')
            ->join('workflow_steps', 'approvals.workflow_step_id', '=', 'workflow_steps.id')
            ->join('users', 'approvals.approver_id', '=', 'users.id')
            ->select('approvals.*', 'workflow_steps.name as step_name', 'users.name as approver_name')
            ->orderBy('approvals.created_at', 'desc')
            ->paginate(10);

        return view('approvals.index', compact('approvals'));
    }

    public function create()
    {
        // Mengambil data referensi tahapan alur dan pengguna untuk pilihan dropdown form
        $workflowSteps = DB::table('workflow_steps')->orderBy('name', 'asc')->get();
        $users = DB::table('users')->orderBy('name', 'asc')->get();

        // Opsi daftar model target untuk polymorphic target (approvable_type)
        $targetTypes = [
            'App\Models\Document' => 'Document (Dokumen Mutu)',
            'App\Models\AuditReport' => 'Audit Report (Laporan Audit)',
            'App\Models\CorrectiveAction' => 'Corrective Action (Tindakan Korektif)',
        ];

        return view('approvals.create', compact('workflowSteps', 'users', 'targetTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'approvable_type'  => 'required|string|max:255',
            'approvable_id'    => 'required|integer|min:1',
            'workflow_step_id' => 'required|exists:workflow_steps,id',
            'approver_id'      => 'required|exists:users,id',
            'status'           => 'required|in:pending,approved,rejected,revised',
            'notes'            => 'nullable|string',
        ]);

        // Cek validasi proteksi manual: mencegah duplikasi data langkah approval aktif yang sama pada objek target
        $isDuplicate = DB::table('approvals')
            ->where('approvable_type', $request->approvable_type)
            ->where('approvable_id', $request->approvable_id)
            ->where('workflow_step_id', $request->workflow_step_id)
            ->exists();

        if ($isDuplicate) {
            return back()->withInput()->with('error', 'Tahapan approval untuk objek target tersebut sudah terdaftar di sistem!');
        }

        try {
            DB::beginTransaction();

            $actionAt = in_array($request->status, ['approved', 'rejected', 'revised']) ? now() : null;

            $data = [
                'approvable_type'  => $request->approvable_type,
                'approvable_id'    => $request->approvable_id,
                'workflow_step_id' => $request->workflow_step_id,
                'approver_id'      => $request->approver_id,
                'status'           => $request->status,
                'notes'            => $request->notes,
                'action_at'        => $actionAt,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];

            DB::table('approvals')->insert($data);

            DB::commit();
            return redirect()->route('approvals.index')->with('success', 'Data Transaksi Approval Berhasil Ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Store Approval: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan transaksi approval: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $approval = DB::table('approvals')
            ->join('workflow_steps', 'approvals.workflow_step_id', '=', 'workflow_steps.id')
            ->join('users', 'approvals.approver_id', '=', 'users.id')
            ->select('approvals.*', 'workflow_steps.name as step_name', 'users.name as approver_name')
            ->where('approvals.id', $id)
            ->first();

        if (!$approval) {
            abort(404);
        }

        return view('approvals.show', compact('approval'));
    }

    public function edit($id)
    {
        $approval = DB::table('approvals')->where('id', $id)->first();
        
        if (!$approval) {
            abort(404);
        }

        $workflowSteps = DB::table('workflow_steps')->orderBy('name', 'asc')->get();
        $users = DB::table('users')->orderBy('name', 'asc')->get();
        
        $targetTypes = [
            'App\Models\Document' => 'Document (Dokumen Mutu)',
            'App\Models\AuditReport' => 'Audit Report (Laporan Audit)',
            'App\Models\CorrectiveAction' => 'Corrective Action (Tindakan Korektif)',
        ];

        return view('approvals.edit', compact('approval', 'workflowSteps', 'users', 'targetTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'approvable_type'  => 'required|string|max:255',
            'approvable_id'    => 'required|integer|min:1',
            'workflow_step_id' => 'required|exists:workflow_steps,id',
            'approver_id'      => 'required|exists:users,id',
            'status'           => 'required|in:pending,approved,rejected,revised',
            'notes'            => 'nullable|string',
        ]);

        // Proteksi manual pengecekan duplikasi record unik saat proses update data berlangsung
        $isDuplicate = DB::table('approvals')
            ->where('approvable_type', $request->approvable_type)
            ->where('approvable_id', $request->approvable_id)
            ->where('workflow_step_id', $request->workflow_step_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($isDuplicate) {
            return back()->withInput()->with('error', 'Tahapan transaksi approval tersebut sudah digunakan oleh baris data lain!');
        }

        try {
            DB::beginTransaction();

            // Ambil data lama untuk mengecek perubahan status waktu eksekusi keputusan
            $oldApproval = DB::table('approvals')->where('id', $id)->first();
            $actionAt = $oldApproval->action_at;

            if ($oldApproval->status !== $request->status) {
                $actionAt = in_array($request->status, ['approved', 'rejected', 'revised']) ? now() : null;
            }

            DB::table('approvals')
                ->where('id', $id)
                ->update([
                    'approvable_type'  => $request->approvable_type,
                    'approvable_id'    => $request->approvable_id,
                    'workflow_step_id' => $request->workflow_step_id,
                    'approver_id'      => $request->approver_id,
                    'status'           => $request->status,
                    'notes'            => $request->notes,
                    'action_at'        => $actionAt,
                    'updated_at'       => now(),
                ]);

            DB::commit();
            return redirect()->route('approvals.index')->with('success', 'Data Transaksi Approval Berhasil Diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Update Approval: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data transaksi approval: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $approval = DB::table('approvals')->where('id', $id)->first();
            if (!$approval) {
                return redirect()->route('approvals.index')->with('error', 'Data transaksi tidak ditemukan.');
            }

            DB::table('approvals')->where('id', $id)->delete();
            
            DB::commit();
            return redirect()->route('approvals.index')->with('success', 'Transaksi Approval Berhasil Dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Delete Approval: ' . $e->getMessage());
            return redirect()->route('approvals.index')->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}