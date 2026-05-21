@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-warning py-3 px-4">
            <h5 class="mb-0 fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">
                <i class="fas fa-edit me-2"></i> EDIT WORKFLOW STEP
            </h5>
        </div>

        <div class="card-body p-4 bg-white">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-4 border-0 d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('workflow_steps.update', $step->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Relation & Order</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Parent Workflow</label>
                            <select name="workflow_id" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="" disabled>-- Select Workflow --</option>
                                @foreach($workflows as $workflow)
                                    <option value="{{ $workflow->id }}" {{ old('workflow_id', $step->workflow_id) == $workflow->id ? 'selected' : '' }}>
                                        {{ $workflow->name }} ({{ $workflow->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Step Order (Urutan Ke)</label>
                            <input type="number" name="step_order" class="form-control shadow-sm border-secondary-subtle" value="{{ old('step_order', $step->step_order) }}" min="1" required style="height: 45px;">
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Step Name & Approver</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Step Name</label>
                            <input type="text" name="name" class="form-control shadow-sm border-secondary-subtle" value="{{ old('name', $step->name) }}" placeholder="e.g., Review oleh Kepala Unit, Persetujuan Dekan" required style="height: 45px;">
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Approver Type</label>
                            <select name="approver_type" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="role" {{ old('approver_type', $step->approver_type) == 'role' ? 'selected' : '' }}>ROLE</option>
                                <option value="user" {{ old('approver_type', $step->approver_type) == 'user' ? 'selected' : '' }}>USER</option>
                                <option value="unit_head" {{ old('approver_type', $step->approver_type) == 'unit_head' ? 'selected' : '' }}>UNIT HEAD</option>
                                <option value="position" {{ old('approver_type', $step->approver_type) == 'position' ? 'selected' : '' }}>POSITION</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Approver Value (ID / Code)</label>
                            <input type="text" name="approver_value" class="form-control shadow-sm border-secondary-subtle" value="{{ old('approver_value', $step->approver_value) }}" placeholder="e.g., admin, 2, kepala_penjaminan_mutu" required style="height: 45px;">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Settings & Conditions</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Time Limit (Days / Batas Hari)</label>
                            <input type="number" name="time_limit_days" class="form-control shadow-sm border-secondary-subtle" value="{{ old('time_limit_days', $step->time_limit_days) }}" placeholder="e.g., 3 (Kosongkan jika tidak ada batas waktu)" min="1" style="height: 45px;">
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Conditions (JSON Format / Optional)</label>
                            <textarea name="conditions" class="form-control shadow-sm border-secondary-subtle" rows="3" placeholder='e.g., {"amount_greater_than": 5000000}'>{{ old('conditions', is_array($step->conditions) ? json_encode($step->conditions) : $step->conditions) }}</textarea>
                        </div>
                    </div>

                    <div class="p-3 rounded border bg-light">
                        <div class="form-check">
                            <input type="hidden" name="requires_approval" value="0">
                            <input class="form-check-input" type="checkbox" name="requires_approval" value="1" id="editRequiresApproval" {{ old('requires_approval', $step->requires_approval) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark small" for="editRequiresApproval" style="cursor: pointer;">
                                <i class="fas fa-check-circle text-success me-1 small"></i> Requires Approval (Langkah ini wajib disetujui untuk lanjut)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('workflow_steps.index') }}" class="btn btn-outline-secondary px-4 fw-bold border-2" style="font-size: 13px;">CANCEL</a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold shadow-sm text-dark" style="font-size: 13px;">UPDATE DATA</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection