<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkflowStepController extends Controller
{
    public function index()
    {
        // Menggunakan join agar nama workflow induk bisa tampil di tabel index
        $workflowSteps = DB::table('workflow_steps')
            ->join('workflows', 'workflow_steps.workflow_id', '=', 'workflows.id')
            ->select('workflow_steps.*', 'workflows.name as workflow_name', 'workflows.code as workflow_code')
            ->orderBy('workflow_steps.workflow_id', 'asc')
            ->orderBy('workflow_steps.step_order', 'asc')
            ->paginate(10);

        return view('workflow_steps.index', compact('workflowSteps'));
    }

    public function create()
    {
        // Mengambil daftar kuesioner/workflow induk untuk pilihan di dropdown form
        $workflows = DB::table('workflows')->where('is_active', true)->orderBy('name', 'asc')->get();

        return view('workflow_steps.create', compact('workflows'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'workflow_id'       => 'required|exists:workflows,id',
            'name'              => 'required|string|max:255',
            'step_order'        => 'required|integer|min:1',
            'approver_type'     => 'required|in:role,user,unit_head,position',
            'approver_value'    => 'required|string|max:255',
            'time_limit_days'   => 'nullable|integer|min:1',
            'conditions'        => 'nullable|json',
        ]);

        // Cek validasi kombinasi unique (workflow_id + step_order) secara manual di Query Builder
        $isDuplicate = DB::table('workflow_steps')
            ->where('workflow_id', $request->workflow_id)
            ->where('step_order', $request->step_order)
            ->exists();

        if ($isDuplicate) {
            return back()->withInput()->with('error', 'Urutan tahapan (Step Order) ini sudah digunakan pada alur kerja terpilih!');
        }

        try {
            DB::beginTransaction();

            $data = [
                'workflow_id'       => $request->workflow_id,
                'name'              => $request->name,
                'step_order'        => $request->step_order,
                'approver_type'     => $request->approver_type,
                'approver_value'    => $request->approver_value,
                'requires_approval' => $request->has('requires_approval') ? true : false,
                'time_limit_days'   => $request->time_limit_days,
                'conditions'        => $request->conditions, // Input harus string JSON valid
                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            DB::table('workflow_steps')->insert($data);

            DB::commit();
            return redirect()->route('workflow_steps.index')->with('success', 'Tahapan Alur (Workflow Step) Berhasil Ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Store Workflow Step: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan tahapan alur: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $step = DB::table('workflow_steps')
            ->join('workflows', 'workflow_steps.workflow_id', '=', 'workflows.id')
            ->select('workflow_steps.*', 'workflows.name as workflow_name', 'workflows.code as workflow_code')
            ->where('workflow_steps.id', $id)
            ->first();

        if (!$step) {
            abort(404);
        }

        return view('workflow_steps.show', compact('step'));
    }

    public function edit($id)
    {
        $step = DB::table('workflow_steps')->where('id', $id)->first();
        
        if (!$step) {
            abort(404);
        }

        $workflows = DB::table('workflows')->orderBy('name', 'asc')->get();

        return view('workflow_steps.edit', compact('step', 'workflows'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'workflow_id'       => 'required|exists:workflows,id',
            'name'              => 'required|string|max:255',
            'step_order'        => 'required|integer|min:1',
            'approver_type'     => 'required|in:role,user,unit_head,position',
            'approver_value'    => 'required|string|max:255',
            'time_limit_days'   => 'nullable|integer|min:1',
            'conditions'        => 'nullable|json',
        ]);

        // Proteksi validasi kombinasi unique saat update data
        $isDuplicate = DB::table('workflow_steps')
            ->where('workflow_id', $request->workflow_id)
            ->where('step_order', $request->step_order)
            ->where('id', '!=', $id)
            ->exists();

        if ($isDuplicate) {
            return back()->withInput()->with('error', 'Urutan tahapan (Step Order) tersebut sudah ada di alur kerja ini!');
        }

        try {
            DB::beginTransaction();

            DB::table('workflow_steps')
                ->where('id', $id)
                ->update([
                    'workflow_id'       => $request->workflow_id,
                    'name'              => $request->name,
                    'step_order'        => $request->step_order,
                    'approver_type'     => $request->approver_type,
                    'approver_value'    => $request->approver_value,
                    'requires_approval' => $request->has('requires_approval') ? true : false,
                    'time_limit_days'   => $request->time_limit_days,
                    'conditions'        => $request->conditions,
                    'updated_at'        => now(),
                ]);

            DB::commit();
            return redirect()->route('workflow_steps.index')->with('success', 'Tahapan Alur (Workflow Step) Berhasil Diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Update Workflow Step: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data tahapan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $step = DB::table('workflow_steps')->where('id', $id)->first();
            if (!$step) {
                return redirect()->route('workflow_steps.index')->with('error', 'Data tahapan tidak ditemukan.');
            }

            DB::table('workflow_steps')->where('id', $id)->delete();
            
            DB::commit();
            return redirect()->route('workflow_steps.index')->with('success', 'Tahapan Alur Berhasil Dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Delete Workflow Step: ' . $e->getMessage());
            return redirect()->route('workflow_steps.index')->with('error', 'Gagal menghapus tahapan: ' . $e->getMessage());
        }
    }
}