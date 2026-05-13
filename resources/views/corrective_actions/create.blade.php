@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto;">
        <div class="card-header bg-primary text-white py-3 px-4" style="border-radius: 4px 4px 0 0;">
            <h6 class="mb-0 fw-bold" style="letter-spacing: 0.5px;">ADD NEW CORRECTIVE ACTION (CAPA)</h6>
        </div>

        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger py-2 small shadow-sm mb-4 border-0">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('corrective_actions.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small mb-1">CA NUMBER</label>
                        <input type="text" name="ca_number" class="form-control form-control-sm bg-light-focus" 
                               placeholder="e.g. CAPA/2026/001" value="{{ old('ca_number') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small mb-1">AUDIT FINDING</label>
                        <select name="audit_finding_id" class="form-select form-select-sm bg-light-focus" required>
                            <option value="" selected disabled>-- Select Finding --</option>
                            @foreach($findings as $f)
                                <option value="{{ $f->id }}" {{ old('audit_finding_id') == $f->id ? 'selected' : '' }}>
                                    {{ $f->finding_number }} - {{ Str::limit($f->finding_description, 40) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small mb-1">UNIT</label>
                        <select name="unit_id" class="form-select form-select-sm bg-light-focus" required>
                            <option value="" selected disabled>-- Select Unit --</option>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small mb-1">CAUSE CATEGORY</label>
                        <select name="cause_category" class="form-select form-select-sm bg-light-focus" required>
                            <option value="human">Human</option>
                            <option value="method">Method</option>
                            <option value="machine">Machine</option>
                            <option value="material">Material</option>
                            <option value="environment">Environment</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-dark small mb-1">ROOT CAUSE</label>
                        <textarea name="root_cause" class="form-control form-control-sm bg-light-focus" 
                                  rows="1" placeholder="Analyze the root cause..." required>{{ old('root_cause') }}</textarea>
                    </div>
                    <div class="col-12">
                        <hr class="my-2 opacity-25">
                        <label class="form-label fw-bold text-dark small mb-1">CORRECTIVE ACTION PLAN</label>
                        <textarea name="corrective_action_plan" class="form-control form-control-sm bg-light-focus" 
                                  rows="3" placeholder="Describe the plan to fix the issue..." required>{{ old('corrective_action_plan') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-dark small mb-1">PREVENTIVE ACTION PLAN</label>
                        <textarea name="preventive_action_plan" class="form-control form-control-sm bg-light-focus" 
                                  rows="3" placeholder="Describe plan to prevent recurrence...">{{ old('preventive_action_plan') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">RESPONSIBLE PERSON (PIC)</label>
                        <select name="responsible_person" class="form-select form-select-sm bg-light-focus" required>
                            <option value="" selected disabled>-- Select PIC --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('responsible_person') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">TARGET COMPLETION DATE</label>
                        <input type="date" name="target_completion_date" class="form-control form-control-sm bg-light-focus" 
                               value="{{ old('target_completion_date') }}" required>
                    </div>
                </div>

                <div class="mt-5 d-flex justify-content-end gap-2">
                    <a href="{{ route('corrective_actions.index') }}" class="btn btn-secondary btn-sm px-4 fw-bold" style="font-size: 11px; border-radius: 6px;">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm" style="font-size: 11px; border-radius: 6px;">
                        Save Action Plan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-5 text-muted small">
        © 2026 SPMI Digital System - RPL
    </div>
</div>

<style>
    /* Styling agar input bersih dan identik dengan screenshot sistem kamu */
    .form-control, .form-select {
        border: 1px solid #dee2e6 !important;
        border-radius: 6px !important;
        padding: 0.6rem 0.75rem !important;
        background-color: #fff;
        box-shadow: none !important;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #007bff !important;
        background-color: #fff;
    }

    label {
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }
    
    /* Memperhalus tampilan placeholder */
    ::placeholder {
        color: #adb5bd !important;
        font-size: 11px;
    }
</style>
@endsection