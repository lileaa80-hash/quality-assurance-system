@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Edit Audit Checklist Report</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('audit_checklists.update', $checklist->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">UNIT</label>
                        <select name="unit_id" class="form-select form-select-sm shadow-sm" required>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}" {{ $checklist->unit_id == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">STANDARD</label>
                        <select name="standard_id" class="form-select form-select-sm shadow-sm" required>
                            @foreach($standards as $st)
                                <option value="{{ $st->id }}" {{ $checklist->standard_id == $st->id ? 'selected' : '' }}>
                                    {{ $st->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">INDICATOR</label>
                        <select name="standard_indicator_id" class="form-select form-select-sm shadow-sm" required>
                            @foreach($indicators as $ind)
                                <option value="{{ $ind->id }}" {{ $checklist->standard_indicator_id == $ind->id ? 'selected' : '' }}>
                                    {{ $ind->indicator_text }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <hr class="my-3 text-muted">

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">AUDIT RESULT</label>
                        <select name="result" class="form-select form-select-sm shadow-sm" required>
                            <option value="compliant" {{ $checklist->result == 'compliant' ? 'selected' : '' }}>Compliant</option>
                            <option value="partially_compliant" {{ $checklist->result == 'partially_compliant' ? 'selected' : '' }}>Partially Compliant</option>
                            <option value="non_compliant" {{ $checklist->result == 'non_compliant' ? 'selected' : '' }}>Non Compliant</option>
                            <option value="not_applicable" {{ $checklist->result == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">SCORE (0-100)</label>
                        <input type="number" name="score" class="form-control form-control-sm shadow-sm" 
                               value="{{ $checklist->score }}" placeholder="e.g. 90">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">OBJECTIVE EVIDENCE</label>
                        <textarea name="objective_evidence" class="form-control form-control-sm shadow-sm" 
                                  rows="3">{{ $checklist->objective_evidence }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">NOTES</label>
                        <textarea name="notes" class="form-control form-control-sm shadow-sm" 
                                  rows="3">{{ $checklist->notes }}</textarea>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('audit_checklists.index') }}" class="btn btn-light btn-sm px-3 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm" style="font-size: 11px;">Update Report</button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection