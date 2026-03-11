<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StandardIndicatorController extends Controller
{
    public function index()
    {
        $indicators = DB::table('standard_indicators')
            ->join('standards', 'standard_indicators.standard_id', '=', 'standards.id')
            ->select('standard_indicators.*', 'standards.name as standard_name', 'standards.code as standard_code')
            ->orderBy('standards.code', 'asc')
            ->get();

        // Memanggil folder resources/views/standardindicators/index.blade.php
        return view('standardindicators.index', compact('indicators'));
    }

    public function create()
    {
        $standards = DB::table('standards')->select('id', 'code', 'name')->get();
        return view('standardindicators.create', compact('standards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'standard_id'    => 'required',
            'code'           => 'required',
            'indicator_text' => 'required',
        ]);

        DB::table('standard_indicators')->insert([
            'standard_id'      => $request->standard_id,
            'code'             => $request->code,
            'indicator_text'   => $request->indicator_text,
            'measurement_type' => $request->measurement_type,
            'target_value'     => $request->target_value,
            'unit'             => $request->unit,
            'weight'           => $request->weight ?? 1,
            'is_mandatory'     => $request->has('is_mandatory') ? 1 : 0,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        return redirect()->route('indicators.index')->with('success', 'New indicator added!');
    }

    public function show($id)
    {
        $indicator = DB::table('standard_indicators')
            ->join('standards', 'standard_indicators.standard_id', '=', 'standards.id')
            ->select('standard_indicators.*', 'standards.name as standard_name', 'standards.code as standard_code')
            ->where('standard_indicators.id', $id)
            ->first();

        return view('standardindicators.show', compact('indicator'));
    }

    public function edit($id)
    {
        $indicator = DB::table('standard_indicators')->where('id', $id)->first();
        $standards = DB::table('standards')->select('id', 'code', 'name')->get();

        return view('standardindicators.edit', compact('indicator', 'standards'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'standard_id'    => 'required',
            'code'           => 'required',
            'indicator_text' => 'required',
        ]);

        // Fix: Pastikan ID ditemukan sebelum update
        DB::table('standard_indicators')
            ->where('id', $id)
            ->update([
                'standard_id'      => $request->standard_id,
                'code'             => $request->code,
                'indicator_text'   => $request->indicator_text,
                'measurement_type' => $request->measurement_type,
                'target_value'     => $request->target_value,
                'unit'             => $request->unit,
                'weight'           => $request->weight ?? 1,
                'is_mandatory'     => $request->has('is_mandatory') ? 1 : 0,
                'updated_at'       => now(),
            ]);

        return redirect()->route('indicators.index')->with('success', 'Indicator updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('standard_indicators')->where('id', $id)->delete();
        return redirect()->route('indicators.index')->with('success', 'Indicator deleted.');
    }
}