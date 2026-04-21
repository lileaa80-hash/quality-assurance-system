@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Edit Corrective Action Report</h6>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('corrective_actions.update', $action->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">CA NUMBER</label>
                        <input type="text" name="ca_number" class="form-control form-control-sm shadow-sm bg-light" 
                               value="{{ $action->ca_number }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">UNIT</label>
                        <select name="unit_id" class="form-select form-select-sm shadow-sm" required>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}" {{ $action->unit_id == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">AUDIT FINDING REFERENCE</label>
                        <select name="audit_finding_id" class="form-select form-select-sm shadow-sm" required>
                            @foreach($findings as $f)
                                <option value="{{ $f->id }}" {{ $action->audit_finding_id == $f->id ? 'selected' : '' }}>
                                    {{ $f->finding_number }} - {{ Str::limit($f->finding_description, 100) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <hr class="my-3 text-muted">

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">CAUSE CATEGORY</label>
                        <select name="cause_category" class="form-select form-select-sm shadow-sm" required>
                            <option value="human" {{ $action->cause_category == 'human' ? 'selected' : '' }}>Human</option>
                            <option value="method" {{ $action->cause_category == 'method' ? 'selected' : '' }}>Method</option>
                            <option value="machine" {{ $action->cause_category == 'machine' ? 'selected' : '' }}>Machine</option>
                            <option value="material" {{ $action->cause_category == 'material' ? 'selected' : '' }}>Material</option>
                            <option value="environment" {{ $action->cause_category == 'environment' ? 'selected' : '' }}>Environment</option>
                            <option value="other" {{ $action->cause_category == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">TARGET COMPLETION DATE</label>
                        <input type="date" name="target_completion_date" class="form-control form-control-sm shadow-sm" 
                               value="{{ $action->target_completion_date }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">ROOT CAUSE ANALYSIS</label>
                        <textarea name="root_cause" class="form-control form-control-sm shadow-sm" 
                                  rows="2" required>{{ $action->root_cause }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">CORRECTIVE ACTION PLAN</label>
                        <textarea name="corrective_action_plan" class="form-control form-control-sm shadow-sm" 
                                  rows="3" required>{{ $action->corrective_action_plan }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">PREVENTIVE ACTION PLAN</label>
                        <textarea name="preventive_action_plan" class="form-control form-control-sm shadow-sm" 
                                  rows="2">{{ $action->preventive_action_plan }}</textarea>
                    </div>

                    <hr class="my-3 text-muted">

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">RESPONSIBLE PERSON (PIC)</label>
                        <select name="responsible_person" class="form-select form-select-sm shadow-sm" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $action->responsible_person == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">FINAL STATUS</label>
                        <select name="final_status" class="form-select form-select-sm shadow-sm" required>
                            <option value="open" {{ $action->final_status == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ $action->final_status == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="reopened" {{ $action->final_status == 'reopened' ? 'selected' : '' }}>Reopened</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('corrective_actions.index') }}" class="btn btn-light btn-sm px-3 fw-bold border" style="font-size: 11px;">Cancel</a>
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