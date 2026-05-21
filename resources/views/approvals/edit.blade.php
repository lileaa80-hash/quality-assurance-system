@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-warning py-3 px-4">
            <h5 class="mb-0 fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">
                <i class="fas fa-edit me-2"></i> EDIT APPROVAL TRANSACTION
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

            <form action="{{ route('approvals.update', $approval->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Workflow & Module Relation</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Workflow Step Assignment</label>
                            <select name="workflow_step_id" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="" disabled>-- Select Workflow Step --</option>
                                @foreach($workflowSteps as $step)
                                    <option value="{{ $step->id }}" {{ old('workflow_step_id', $approval->workflow_step_id) == $step->id ? 'selected' : '' }}>
                                        [{{ $step->workflow->name ?? 'Workflow' }}] - {{ $step->name }} (Order #{{ $step->step_order }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Assigned Approver (User)</label>
                            <select name="approver_id" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="" disabled>-- Select User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('approver_id', $approval->approver_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Approvable Type (Class)</label>
                            <input type="text" name="approvable_type" class="form-control shadow-sm bg-light text-secondary small" value="{{ old('approvable_type', $approval->approvable_type) }}" required readonly style="height: 45px; font-family: monospace;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Approvable ID (Record Target)</label>
                            <input type="number" name="approvable_id" class="form-control shadow-sm bg-light text-secondary" value="{{ old('approvable_id', $approval->approvable_id) }}" required readonly style="height: 45px;">
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Status & Execution Parameters</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Approval Status</label>
                            <select name="status" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="pending" {{ old('status', $approval->status) == 'pending' ? 'selected' : '' }}>PENDING (WAITING REVIEW)</option>
                                <option value="approved" {{ old('status', $approval->status) == 'approved' ? 'selected' : '' }}>APPROVED (DISETUJUI)</option>
                                <option value="rejected" {{ old('status', $approval->status) == 'rejected' ? 'selected' : '' }}>REJECTED (DITOLAK)</option>
                                <option value="revised" {{ old('status', $approval->status) == 'revised' ? 'selected' : '' }}>REVISED (BUTUH REVISI)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Action Time Stamp</label>
                            <input type="datetime-local" name="action_at" class="form-control shadow-sm border-secondary-subtle" 
                                   value="{{ old('action_at', $approval->action_at ? \Carbon\Carbon::parse($approval->action_at)->format('Y-m-d\TH:i') : '') }}" 
                                   style="height: 45px;">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Review Notes & Feedback</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Evaluation Comments / Notes</label>
                            <textarea name="notes" class="form-control shadow-sm border-secondary-subtle" rows="4" placeholder="Enter decision reasons, revision details, or audit notes here...">{{ old('notes', $approval->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('approvals.index') }}" class="btn btn-outline-secondary px-4 fw-bold border-2" style="font-size: 13px;">CANCEL</a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold shadow-sm text-dark" style="font-size: 13px;">UPDATE DATA</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection