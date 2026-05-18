<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class WorkflowController extends Controller
{
    public function index()
    {
        $workflows = DB::table('workflows')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('workflows.index', compact('workflows'));
    }

    public function create()
    {
        return view('workflows.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:255|unique:workflows,code',
            'type'        => 'required|in:document_approval,audit_report_approval,corrective_action_approval,accreditation_approval',
            'description' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'name'        => $request->name,
                'code'        => strtoupper($request->code), // Otomatis uppercase untuk standarisasi kode
                'type'        => $request->type,
                'description' => $request->description,
                'is_active'   => $request->has('is_active') ? true : false,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            DB::table('workflows')->insert($data);

            DB::commit();
            return redirect()->route('workflows.index')->with('success', 'Alur Kerja (Workflow) Berhasil Ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Store Workflow: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan alur kerja: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $workflow = DB::table('workflows')->where('id', $id)->first();

        if (!$workflow) {
            abort(404);
        }

        return view('workflows.show', compact('workflow'));
    }

    public function edit($id)
    {
        $workflow = DB::table('workflows')->where('id', $id)->first();

        if (!$workflow) {
            abort(404);
        }

        return view('workflows.edit', compact('workflow'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:255|unique:workflows,code,' . $id,
            'type'        => 'required|in:document_approval,audit_report_approval,corrective_action_approval,accreditation_approval',
            'description' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            DB::table('workflows')
                ->where('id', $id)
                ->update([
                    'name'        => $request->name,
                    'code'        => strtoupper($request->code),
                    'type'        => $request->type,
                    'description' => $request->description,
                    'is_active'   => $request->has('is_active') ? true : false,
                    'updated_at'  => now(),
                ]);

            DB::commit();
            return redirect()->route('workflows.index')->with('success', 'Alur Kerja (Workflow) Berhasil Diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Update Workflow: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $workflow = DB::table('workflows')->where('id', $id)->first();
            if (!$workflow) {
                return redirect()->route('workflows.index')->with('error', 'Data tidak ditemukan.');
            }
            DB::table('workflows')->where('id', $id)->delete();
            DB::commit();
            return redirect()->route('workflows.index')->with('success', 'Alur Kerja (Workflow) Berhasil Dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Delete Workflow: ' . $e->getMessage());
            return redirect()->route('workflows.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}