<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AccreditationBorangController extends Controller
{
    public function index()
    {
        $borangs = DB::table('accreditation_borangs')
            ->join('accreditation_periods', 'accreditation_borangs.accreditation_period_id', '=', 'accreditation_periods.id')
            ->join('standards', 'accreditation_borangs.standard_id', '=', 'standards.id')
            ->join('users', 'accreditation_borangs.filled_by', '=', 'users.id')
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
        // Ambil data untuk dropdown form
        $periods = DB::table('accreditation_periods')->get();
        $standards = DB::table('standards')->get();
        $indicators = DB::table('standard_indicators')->get();

        return view('accreditation_borangs.create', compact('periods', 'standards', 'indicators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'accreditation_period_id' => 'required',
            'standard_id' => 'required',
            'standard_indicator_id' => 'required',
            'status' => 'required',
        ]);

        try {
            DB::table('accreditation_borangs')->insert([
                'accreditation_period_id' => $request->accreditation_period_id,
                'standard_id' => $request->standard_id,
                'standard_indicator_id' => $request->standard_indicator_id,
                'response' => $request->response,
                'analysis' => $request->analysis,
                'target' => $request->target,
                'achievement' => $request->achievement,
                // Mengubah array dokumen jadi JSON
                'supporting_documents' => $request->supporting_documents ? json_encode($request->supporting_documents) : null,
                'self_assessment_score' => $request->self_assessment_score,
                'status' => $request->status,
                'filled_by' => Auth::id() ?? 1, // Menggunakan ID user login atau default 1 untuk test
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('accreditation_borangs.index')->with('success', 'Borang Berhasil Disimpan!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan borang: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $borang = DB::table('accreditation_borangs')
            ->join('accreditation_periods', 'accreditation_borangs.accreditation_period_id', '=', 'accreditation_periods.id')
            ->join('standards', 'accreditation_borangs.standard_id', '=', 'standards.id')
            ->join('standard_indicators', 'accreditation_borangs.standard_indicator_id', '=', 'standard_indicators.id')
            ->select('accreditation_borangs.*', 'accreditation_periods.period_name', 'standards.name as standard_name', 'standard_indicators.name as indicator_name')
            ->where('accreditation_borangs.id', $id)
            ->first();

        return view('accreditation_borangs.show', compact('borang'));
    }

    public function edit($id)
    {
        $borang = DB::table('accreditation_borangs')->where('id', $id)->first();
        $periods = DB::table('accreditation_periods')->get();
        $standards = DB::table('standards')->get();
        $indicators = DB::table('standard_indicators')->get();

        return view('accreditation_borangs.edit', compact('borang', 'periods', 'standards', 'indicators'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::table('accreditation_borangs')
                ->where('id', $id)
                ->update([
                    'response' => $request->response,
                    'analysis' => $request->analysis,
                    'target' => $request->target,
                    'achievement' => $request->achievement,
                    'self_assessment_score' => $request->self_assessment_score,
                    'status' => $request->status,
                    'updated_at' => now(),
                ]);

            return redirect()->route('accreditation_borangs.index')->with('success', 'Borang Berhasil Diperbarui!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Update Gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::table('accreditation_borangs')->where('id', $id)->delete();
        return redirect()->route('accreditation_borangs.index')->with('success', 'Borang Dihapus!');
    }
}