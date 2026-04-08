<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AccreditationBorangController extends Controller
{
    public function index()
    {
        $borangs = DB::table('accreditation_borangs')
            ->join('accreditation_periods', 'accreditation_borangs.accreditation_period_id', '=', 'accreditation_periods.id')
            ->join('standards', 'accreditation_borangs.standard_id', '=', 'standards.id')
            ->join('standard_indicators', 'accreditation_borangs.standard_indicator_id', '=', 'standard_indicators.id')
            ->join('users', 'accreditation_borangs.filled_by', '=', 'users.id')
            ->select([
                'accreditation_borangs.*',
                'accreditation_borangs.id as borang_id',
                'accreditation_periods.period_name',
                'standards.name as standard_name',
                'standard_indicators.indicator_code',
                'users.name as filler_name'
            ])
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
    // $request->validate([
    //     'accreditation_period_id' => 'required',
    //     'standard_id' => 'required',
    //     'standard_indicator_id' => 'required',
    //     'data_value' => 'required',
    // ]);

    // try {
    //     \DB::table('accreditation_borangs')->insert([
    //         'accreditation_period_id' => $request->accreditation_period_id,
    //         'standard_id' => $request->standard_id,
    //         'standard_indicator_id' => $request->standard_indicator_id,
    //         'data_value' => $request->data_value,
    //         'description' => $request->description,
    //         'filled_by' => auth()->id() ?? 1,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     return redirect()->route('accreditation_borangs.index');
    // } catch (\Exception $e) {
    //     return back()->with('error', $e->getMessage());
    // }
}
    public function edit($id)
    {
        $borang = DB::table('accreditation_borangs')->where('id', $id)->first();
        if (!$borang) abort(404);

        $periods = DB::table('accreditation_periods')->get();
        $standards = DB::table('standards')->get();
        $indicators = DB::table('standard_indicators')->get();

        return view('accreditation_borangs.edit', compact('borang', 'periods', 'standards', 'indicators'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'accreditation_period_id' => 'required',
            'standard_id'             => 'required',
            'standard_indicator_id'   => 'required',
            'data_value'              => 'required',
        ]);

        try {
            DB::table('accreditation_borangs')
                ->where('id', $id)
                ->update([
                    'accreditation_period_id' => $request->accreditation_period_id,
                    'standard_id'             => $request->standard_id,
                    'standard_indicator_id'   => $request->standard_indicator_id,
                    'data_value'              => $request->data_value,
                    'description'             => $request->description,
                    'updated_at'              => now(),
                ]);

            return redirect()->route('accreditation_borangs.index')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::table('accreditation_borangs')->where('id', $id)->delete();
        return redirect()->route('accreditation_borangs.index')->with('success', 'Data berhasil dihapus!');
    }
}