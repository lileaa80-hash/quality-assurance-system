@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Add New Accreditation Borang</h6>
        </div>

        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-3 border-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('accreditation_borangs.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">BORANG & STANDARD SELECTION</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">ACCREDITATION PERIOD</label>
                            <select name="accreditation_period_id" class="form-select form-select-sm shadow-sm" required>
                                <option value="" selected disabled>-- Select Period --</option>
                                @foreach($periods as $p)
                                    <option value="{{ $p->id }}" {{ old('accreditation_period_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->period_name ?? 'Unnamed Period' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Standard Selection --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">STANDARD</label>
                            <select name="standard_id" class="form-select form-select-sm shadow-sm" required>
                                <option value="" selected disabled>-- Select Standard --</option>
                                @foreach($standards as $s)
                                    <option value="{{ $s->id }}" {{ old('standard_id') == $s->id ? 'selected' : '' }}>
                                        {{-- Proteksi: Cek kolom 'name' atau 'code' --}}
                                        {{ $s->name ?? ($s->code ?? 'Standard ID: '.$s->id) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Indicator Selection --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">INDICATOR</label>
                            <select name="standard_indicator_id" class="form-select form-select-sm shadow-sm" required>
                                <option value="" selected disabled>-- Select Indicator --</option>
                                @foreach($indicators as $i)
                                    <option value="{{ $i->id }}" {{ old('standard_indicator_id') == $i->id ? 'selected' : '' }}>
                                        {{-- Proteksi: Cek kolom 'name' atau 'indicator_name' --}}
                                        {{ $i->name ?? ($i->indicator_name ?? 'Indicator ID: '.$i->id) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">ASSESSMENT DETAILS</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-sm" required>
                                <option value="draft">Draft</option>
                                <option value="submitted">Submitted</option>
                                <option value="approved">Approved</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">TARGET (e.g. 100%)</label>
                            <input type="text" name="target" class="form-control form-control-sm shadow-sm" value="{{ old('target') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">SELF SCORE (0-4)</label>
                            <input type="number" step="0.01" name="self_assessment_score" class="form-control form-control-sm shadow-sm" value="{{ old('self_assessment_score') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">RESPONSE & ANALYSIS</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">RESPONSE / DESCRIPTION</label>
                            <textarea name="response" class="form-control form-control-sm shadow-sm" rows="3">{{ old('response') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">ANALYSIS</label>
                            <textarea name="analysis" class="form-control form-control-sm shadow-sm" rows="3">{{ old('analysis') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('accreditation_borangs.index') }}" class="btn btn-light btn-sm px-3 fw-bold border">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm">Save Borang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection