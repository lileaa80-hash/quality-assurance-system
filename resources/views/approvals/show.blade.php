@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                <i class="fas fa-check-circle me-2"></i> Approval History Details
            </h5>
            <a href="{{ route('approvals.index') }}" class="btn btn-light btn-sm fw-bold px-3" style="font-size: 12px; color: #0d6efd;">BACK TO LIST</a>
        </div>

        <div class="card-body p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="fw-bold text-muted small me-2">APPROVAL STATUS:</span>
                    @if($approval->status == 'approved')
                        <span class="badge bg-success text-white px-3 py-2 text-uppercase shadow-sm" style="font-size: 11px; border-radius: 4px;">APPROVED</span>
                    @elseif($approval->status == 'rejected')
                        <span class="badge bg-danger text-white px-3 py-2 text-uppercase shadow-sm" style="font-size: 11px; border-radius: 4px;">REJECTED</span>
                    @elseif($approval->status == 'revised')
                        <span class="badge bg-warning text-dark px-3 py-2 text-uppercase shadow-sm" style="font-size: 11px; border-radius: 4px;">REVISED</span>
                    @else
                        <span class="badge bg-info text-white px-3 py-2 text-uppercase shadow-sm" style="font-size: 11px; border-radius: 4px;">PENDING</span>
                    @endif
                </div>
                <div>
                    <span class="fw-bold text-muted small text-uppercase">Action Date:</span>
                    <span class="badge bg-light text-secondary border px-3 py-2 ms-1" style="font-size: 11px; border-radius: 4px;">
                        {{ $approval->action_at ? \Carbon\Carbon::parse($approval->action_at)->format('d M Y H:i') : 'AWAITING ACTION' }}
                    </span>
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-8">
                    <div class="p-4 border rounded shadow-sm bg-white h-100">
                        <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Related Module Element (Morphs)</label>
                        <h5 class="fw-bold text-primary mb-2">
                            {{ isset($approval->approvable_type) ? class_basename($approval->approvable_type) : 'Unknown Module' }}
                        </h5>
                        <span class="badge bg-light text-primary border text-uppercase" style="font-size: 10px; font-weight: 600; letter-spacing: 0.3px;">
                            Source Instance ID: #{{ $approval->approvable_id ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 border rounded shadow-sm bg-white h-100 d-flex flex-column justify-content-center text-center">
                        <label class="fw-bold text-muted small d-block mb-1 text-uppercase" style="letter-spacing: 0.5px;">Workflow Step Reference</label>
                        <h5 class="fw-bold mb-0 text-dark">{{ $approval->workflowStep->name ?? 'Step Assignment' }}</h5>
                        <small class="text-muted fw-bold text-uppercase mt-1" style="font-size: 10px;">Order Sequence #{{ $approval->workflowStep->step_order ?? 0 }}</small>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Assigned Approver (User)</label>
                    <div class="p-3 border rounded bg-light d-flex align-items-center">
                        <div class="me-3 bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">{{ $approval->approver->name ?? 'System Assigned User' }}</h6>
                            <small class="text-muted" style="font-size: 12px;">Email: {{ $approval->approver->email ?? '-' }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Reviewer Notes / Comments</label>
                    <div class="p-4 border rounded bg-white shadow-sm" style="min-height: 120px; border-left: 5px solid #0d6efd !important;">
                        <p class="mb-0 text-dark fw-medium" style="white-space: pre-line; line-height: 1.6; font-size: 14px;">
                            {{ $approval->notes ?? 'No review notes or comments provided for this action.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="fw-bold text-muted small d-block mb-1 text-uppercase">Record Created At</label>
                    <div class="p-2 border rounded bg-light text-muted small">
                        {{ $approval->created_at ? $approval->created_at->format('d F Y - H:i:s') : '-' }}
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold text-muted small d-block mb-1 text-uppercase">Record Updated At</label>
                    <div class="p-2 border rounded bg-light text-muted small">
                        {{ $approval->updated_at ? $approval->updated_at->format('d F Y - H:i:s') : '-' }}
                    </div>
                </div>
            </div>

            <hr class="mt-5 mb-4 opacity-50">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small" style="font-size: 10px;">
                    <i class="fas fa-database me-1"></i> Approval Transaction ID Instance: <strong>#{{ $approval->id ?? '-' }}</strong>
                </span>
                <div class="d-flex gap-2">
                    @if(isset($approval->id))
                        <form action="{{ route('approvals.destroy', $approval->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this approval transaction log?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger px-4 fw-bold shadow-sm" style="font-size: 13px;">DELETE LOG</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | System Approval Engine
    </div>
</div>
@endsection