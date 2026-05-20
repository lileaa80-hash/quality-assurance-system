@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Workflow Step Details</h5>
            <a href="{{ route('workflows.show', $workflowStep->workflow_id) }}" class="btn btn-light btn-sm fw-bold px-3" style="font-size: 12px; color: #0d6efd;">BACK TO WORKFLOW</a>
        </div>

        <div class="card-body p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="fw-bold text-muted small me-2">APPROVER TYPE:</span>
                    <span class="badge bg-secondary text-white px-3 py-2 text-uppercase shadow-sm" style="font-size: 11px; border-radius: 4px; letter-spacing: 0.3px;">
                        {{ isset($workflowStep->approver_type) ? str_replace('_', ' ', $workflowStep->approver_type) : 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="fw-bold text-muted small">REQUIRED APPROVAL:</span>
                    @if(!empty($workflowStep->requires_approval))
                        <span class="badge bg-danger text-white px-3 py-2 text-uppercase ms-1" style="font-size: 11px; border-radius: 4px;">YES</span>
                    @else
                        <span class="badge bg-light text-secondary border px-3 py-2 text-uppercase ms-1" style="font-size: 11px; border-radius: 4px;">NO</span>
                    @endif
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-8">
                    <div class="p-4 border rounded shadow-sm bg-white h-100">
                        <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Parent Workflow Relation</label>
                        <h5 class="fw-bold text-primary mb-2">{{ $workflowStep->workflow->name ?? 'Workflow Matrix Data' }}</h5>
                        <span class="badge bg-light text-primary border text-uppercase" style="font-size: 10px; font-weight: 600; letter-spacing: 0.3px;">
                            Code: {{ $workflowStep->workflow->code ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4 border rounded shadow-sm bg-white h-100 d-flex flex-column justify-content-center">
                        <label class="fw-bold text-muted small d-block mb-1 text-uppercase" style="letter-spacing: 0.5px;">Step Order Sequence</label>
                        <h3 class="fw-bold mb-0 text-dark">#{{ $workflowStep->step_order ?? 0 }}</h3>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Execution Priority</small>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-8">
                    <div class="p-4 border rounded bg-white shadow-sm" style="min-height: 120px; border-left: 5px solid #0d6efd !important;">
                        <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Step Name Content</label>
                        <p class="mb-0 text-dark fw-medium" style="white-space: pre-line; line-height: 1.6; font-size: 14px;">
                            {{ $workflowStep->name ?? 'No step name available.' }}
                        </p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4 border rounded shadow-sm bg-white h-100 d-flex flex-column justify-content-center">
                        <label class="fw-bold text-muted small d-block mb-1 text-uppercase" style="letter-spacing: 0.5px;">Time Limit Duration</label>
                        <h3 class="fw-bold mb-0 text-dark">
                            {{ $workflowStep->time_limit_days ?? 0 }}
                        </h3>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Days Limit (SLA)</small>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Approver Target Value</label>
                    <div class="p-3 border rounded bg-light" style="font-family: monospace; font-size: 14px;">
                        <span class="text-secondary fw-bold">VALUE:</span> <span class="text-dark fw-bold">{{ $workflowStep->approver_value ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Step Execution Conditions (JSON)</label>
                    <div class="p-3 border rounded bg-dark text-light shadow-sm" style="min-height: 80px; font-family: monospace; font-size: 13px;">
                        @if(!empty($workflowStep->conditions))
                            @if(is_array($workflowStep->conditions) || is_object($workflowStep->conditions))
                                <pre class="mb-0 text-success" style="white-space: pre-wrap;">{{ json_encode($workflowStep->conditions, JSON_PRETTY_PRINT) }}</pre>
                            @else
                                <pre class="mb-0 text-success" style="white-space: pre-wrap;">{{ json_encode(json_decode($workflowStep->conditions), JSON_PRETTY_PRINT) }}</pre>
                            @endif
                        @else
                            <span class="text-muted">[] - No specific evaluation condition query definitions available.</span>
                        @endif
                    </div>
                </div>
            </div>

            <hr class="mt-5 mb-4 opacity-50">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small" style="font-size: 10px;">
                    <i class="fas fa-database me-1"></i> Workflow Step ID Instance: <strong>#{{ $workflowStep->id ?? '-' }}</strong>
                </span>
                <div class="d-flex gap-2">
                    @if(isset($workflowStep->id))
                        <form action="{{ route('workflow_steps.destroy', $workflowStep->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this workflow step?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger px-4 fw-bold shadow-sm" style="font-size: 13px;">DELETE</button>
                        </form>
                        <a href="{{ route('workflow_steps.edit', $workflowStep->id) }}" class="btn btn-warning text-white px-4 fw-bold shadow-sm" style="font-size: 13px; background-color: #ffc107; border: none;">
                            edit data
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Workflow Management Controls
    </div>
</div>
@endsection