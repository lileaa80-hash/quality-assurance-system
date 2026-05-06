@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        {{-- Card Header: Teks sekarang di pinggir kiri (text-start) dengan padding px-4 --}}
        <div class="card-header bg-primary py-3 px-4">
            <h6 class="mb-0 fw-bold text-white text-uppercase text-start">Add New Audit Checklist Report</h6>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('audit_checklists.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Audit Schedule</label>
                            <select name="audit_schedule_id" class="form-select shadow-sm" required>
                                <option value="" selected disabled>-- Select Schedule --</option>
                                @foreach($schedules as $s)
                                    <option value="{{ $s->id }}">{{ $s->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Field lainnya tetap sama --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Standard</label>
                            <select name="standard_id" class="form-select shadow-sm" required>
                                <option value="" selected disabled>-- Select Standard --</option>
                                @foreach($standards as $st)
                                    <option value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Audit Result</label>
                            <select name="result" class="form-select shadow-sm" required>
                                <option value="compliant">Compliant</option>
                                <option value="partially_compliant">Partially Compliant</option>
                                <option value="non_compliant">Non Compliant</option>
                                <option value="not_applicable">Not Applicable</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Unit</label>
                            <select name="unit_id" class="form-select shadow-sm" required>
                                <option value="" selected disabled>-- Select Unit --</option>
                                @foreach($units as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Indicator</label>
                            <select name="standard_indicator_id" class="form-select shadow-sm" required>
                                <option value="" selected disabled>-- Select Indicator --</option>
                                @foreach($indicators as $ind)
                                    <option value="{{ $ind->id }}">{{ $ind->indicator_text }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Score (0-100)</label>
                            <input type="number" name="score" class="form-control shadow-sm" placeholder="e.g. 90">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Objective Evidence</label>
                            <textarea name="objective_evidence" class="form-control shadow-sm" rows="3" placeholder="Describe evidence found during audit..."></textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Notes</label>
                            <textarea name="notes" class="form-control shadow-sm" rows="3" placeholder="Additional auditor notes..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('audit_checklists.index') }}" class="btn btn-secondary btn-sm px-4 shadow-sm">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">Save Audit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection