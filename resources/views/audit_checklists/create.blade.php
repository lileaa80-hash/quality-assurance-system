@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Add New Audit Checklist Report</h6>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('audit_checklists.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">AUDIT SCHEDULE</label>
                        <select name="audit_schedule_id" class="form-select form-select-sm shadow-sm" required>
                            <option value="" selected disabled>-- Select Schedule --</option>
                            @foreach($schedules as $s)
                                <option value="{{ $s->id }}">{{ $s->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">UNIT</label>
                        <select name="unit_id" class="form-select form-select-sm shadow-sm" required>
                            <option value="" selected disabled>-- Select Unit --</option>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">STANDARD</label>
                        <select name="standard_id" class="form-select form-select-sm shadow-sm" required>
                            <option value="" selected disabled>-- Select Standard --</option>
                            @foreach($standards as $st)
                                <option value="{{ $st->id }}">{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">INDICATOR</label>
                        <select name="standard_indicator_id" class="form-select form-select-sm shadow-sm" required>
                            <option value="" selected disabled>-- Select Indicator --</option>
                            @foreach($indicators as $ind)
                                <option value="{{ $ind->id }}">{{ $ind->indicator_text }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">AUDIT RESULT</label>
                        <select name="result" class="form-select form-select-sm shadow-sm" required>
                            <option value="compliant">Compliant</option>
                            <option value="partially_compliant">Partially Compliant</option>
                            <option value="non_compliant">Non Compliant</option>
                            <option value="not_applicable">Not Applicable</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">SCORE (0-100)</label>
                        <input type="number" name="score" class="form-control form-control-sm shadow-sm" placeholder="e.g. 90">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">OBJECTIVE EVIDENCE</label>
                        <textarea name="objective_evidence" class="form-control form-control-sm shadow-sm" rows="2" placeholder="Describe evidence..."></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">NOTES</label>
                        <textarea name="notes" class="form-control form-control-sm shadow-sm" rows="2" placeholder="Additional notes..."></textarea>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('audit_checklists.index') }}" class="btn btn-light btn-sm px-3 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm" style="font-size: 11px;">Save Audit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection