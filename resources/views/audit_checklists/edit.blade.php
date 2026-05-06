@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning py-3 px-4">
            <h6 class="mb-0 fw-bold text-dark text-uppercase text-start">Edit Audit Checklist Report</h6>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('audit_checklists.update', $checklist->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Unit</label>
                            <select name="unit_id" class="form-select shadow-sm" required>
                                @foreach($units as $u)
                                    <option value="{{ $u->id }}" {{ $checklist->unit_id == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Standard</label>
                            <select name="standard_id" class="form-select shadow-sm" required>
                                @foreach($standards as $st)
                                    <option value="{{ $st->id }}" {{ $checklist->standard_id == $st->id ? 'selected' : '' }}>
                                        {{ $st->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Audit Result</label>
                            <select name="result" class="form-select shadow-sm" required>
                                <option value="compliant" {{ $checklist->result == 'compliant' ? 'selected' : '' }}>Compliant</option>
                                <option value="partially_compliant" {{ $checklist->result == 'partially_compliant' ? 'selected' : '' }}>Partially Compliant</option>
                                <option value="non_compliant" {{ $checklist->result == 'non_compliant' ? 'selected' : '' }}>Non Compliant</option>
                                <option value="not_applicable" {{ $checklist->result == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Indicator</label>
                            <select name="standard_indicator_id" class="form-select shadow-sm" required>
                                @foreach($indicators as $ind)
                                    <option value="{{ $ind->id }}" {{ $checklist->standard_indicator_id == $ind->id ? 'selected' : '' }}>
                                        {{ $ind->indicator_text }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Score (0-100)</label>
                            <input type="number" name="score" class="form-control shadow-sm" 
                                   value="{{ $checklist->score }}" placeholder="e.g. 90">
                        </div>
                    </div>

                    <div class="col-12">
                        <hr class="my-2 text-muted opacity-25">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Objective Evidence</label>
                            <textarea name="objective_evidence" class="form-control shadow-sm" rows="3">{{ $checklist->objective_evidence }}</textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Notes / Recommendations</label>
                            <textarea name="notes" class="form-control shadow-sm" rows="3">{{ $checklist->notes }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('audit_checklists.index') }}" class="btn btn-secondary btn-sm px-4 shadow-sm">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm px-4 fw-bold shadow-sm">Update Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection