@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                <i class="fas fa-plus-circle me-2"></i> Add New Accreditation Borang
            </h6>
        </div>

        <div class="card-body p-4 px-5">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-4 border-0">
                    <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Please fix the following errors:</div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('accreditation_borangs.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3 text-uppercase">
                        <i class="fas fa-tasks me-1"></i> Borang & Standard Selection
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">ACCREDITATION PERIOD</label>
                            <select name="accreditation_period_id" class="form-select form-select-sm shadow-sm border-primary-subtle" required>
                                <option value="" selected disabled>-- Select Period --</option>
                                @foreach($periods as $p)
                                    <option value="{{ $p->id }}" {{ old('accreditation_period_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->period_name ?? 'Unnamed Period' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">STANDARD</label>
                            <select name="standard_id" class="form-select form-select-sm shadow-sm" required>
                                <option value="" selected disabled>-- Select Standard --</option>
                                @foreach($standards as $s)
                                    <option value="{{ $s->id }}" {{ old('standard_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->name ?? ($s->code ?? 'Standard ID: '.$s->id) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">INDICATOR</label>
                            <select name="standard_indicator_id" class="form-select form-select-sm shadow-sm" required>
                                <option value="" selected disabled>-- Select Indicator --</option>
                                @foreach($indicators as $i)
                                    <option value="{{ $i->id }}" {{ old('standard_indicator_id') == $i->id ? 'selected' : '' }}>
                                        {{ $i->name ?? ($i->indicator_name ?? 'Indicator ID: '.$i->id) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3 text-uppercase">
                        <i class="fas fa-edit me-1"></i> Assessment Details
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-sm" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>DRAFT</option>
                                <option value="submitted" {{ old('status') == 'submitted' ? 'selected' : '' }}>SUBMITTED</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>APPROVED</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">TARGET (e.g. 100%)</label>
                            <input type="text" name="target" class="form-control form-control-sm shadow-sm" 
                                   placeholder="Input target..." value="{{ old('target') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">SELF SCORE (0-4)</label>
                            <input type="number" step="0.01" min="0" max="4" name="self_assessment_score" 
                                   class="form-control form-control-sm shadow-sm border-info" 
                                   placeholder="0.00" value="{{ old('self_assessment_score') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3 text-uppercase">
                        <i class="fas fa-file-alt me-1"></i> Response & Analysis
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">RESPONSE / DESCRIPTION</label>
                            <textarea name="response" class="form-control form-control-sm shadow-sm" 
                                      rows="3" placeholder="Provide detailed response here...">{{ old('response') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">ANALYSIS</label>
                            <textarea name="analysis" class="form-control form-control-sm shadow-sm" 
                                      rows="3" placeholder="Provide objective analysis...">{{ old('analysis') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('accreditation_borangs.index') }}" class="btn btn-light btn-sm px-4 fw-bold border text-muted" style="font-size: 11px;">
                        CANCEL
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm" style="font-size: 11px;">
                        <i class="fas fa-save me-1"></i> SAVE BORANG DATA
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>

<style>
    .form-control-sm:focus, .form-select-sm:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    textarea { resize: none; }
</style>
@endsection