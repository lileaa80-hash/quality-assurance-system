@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Add New Corrective Action (CAPA)</h6>
        </div>
        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger py-2 small shadow-sm mb-3 border-0">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('corrective_actions.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-muted small mb-1">CA NUMBER</label>
                        <input type="text" name="ca_number" class="form-control form-control-sm shadow-sm" placeholder="e.g. CAPA/2026/001" value="{{ old('ca_number') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-muted small mb-1">AUDIT FINDING</label>
                        <select name="audit_finding_id" class="form-select form-select-sm shadow-sm" required>
                            <option value="" selected disabled>-- Select Finding --</option>
                            @foreach($findings as $f)
                                <option value="{{ $f->id }}">{{ $f->finding_number }} - {{ Str::limit($f->finding_description, 30) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-muted small mb-1">UNIT</label>
                        <select name="unit_id" class="form-select form-select-sm shadow-sm" required>
                            <option value="" selected disabled>-- Select Unit --</option>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-muted small mb-1">CAUSE CATEGORY</label>
                        <select name="cause_category" class="form-select form-select-sm shadow-sm">
                            <option value="human">Human</option>
                            <option value="method">Method</option>
                            <option value="machine">Machine</option>
                            <option value="material">Material</option>
                            <option value="environment">Environment</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-muted small mb-1">ROOT CAUSE</label>
                        <textarea name="root_cause" class="form-control form-control-sm shadow-sm" rows="1" placeholder="Analyze the root cause..." required>{{ old('root_cause') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">CORRECTIVE ACTION PLAN</label>
                        <textarea name="corrective_action_plan" class="form-control form-control-sm shadow-sm" rows="2" placeholder="Describe the plan to fix the issue..." required>{{ old('corrective_action_plan') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">PREVENTIVE ACTION PLAN</label>
                        <textarea name="preventive_action_plan" class="form-control form-control-sm shadow-sm" rows="2" placeholder="Describe plan to prevent recurrence...">{{ old('preventive_action_plan') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">RESPONSIBLE PERSON (PIC)</label>
                        <select name="responsible_person" class="form-select form-select-sm shadow-sm" required>
                            <option value="" selected disabled>-- Select PIC --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">TARGET COMPLETION DATE</label>
                        <input type="date" name="target_completion_date" class="form-control form-control-sm shadow-sm" required>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('corrective_actions.index') }}" class="btn btn-light btn-sm px-3 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm" style="font-size: 11px;">Save Action Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection