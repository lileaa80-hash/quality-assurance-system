@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Workflow Configuration Details</h5>
            <a href="{{ route('workflows.index') }}" class="btn btn-light btn-sm fw-bold px-3" style="font-size: 12px; color: #0d6efd;">BACK TO LIST</a>
        </div>

        <div class="card-body p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="fw-bold text-muted small me-2">WORKFLOW TYPE:</span>
                    <span class="badge bg-secondary text-white px-3 py-2 text-uppercase shadow-sm" style="font-size: 11px; border-radius: 4px; letter-spacing: 0.3px;">
                        {{ isset($workflow->type) ? str_replace('_', ' ', $workflow->type) : 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="fw-bold text-muted small">IS ACTIVE STATUS:</span>
                    @if(!empty($workflow->is_active))
                        <span class="badge bg-success text-white px-3 py-2 text-uppercase ms-1" style="font-size: 11px; border-radius: 4px;">ACTIVE</span>
                    @else
                        <span class="badge bg-light text-secondary border px-3 py-2 text-uppercase ms-1" style="font-size: 11px; border-radius: 4px;">INACTIVE</span>
                    @endif
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-8">
                    <div class="p-4 border rounded shadow-sm bg-white h-100">
                        <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Workflow Engine Identity</label>
                        <h4 class="fw-bold text-primary mb-2">{{ $workflow->name ?? 'Workflow Data' }}</h4>
                        <span class="badge bg-light text-primary border text-uppercase" style="font-size: 10px; font-weight: 600; letter-spacing: 0.3px;">
                            Registered System Matrix
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4 border rounded shadow-sm bg-white h-100 d-flex flex-column justify-content-center">
                        <label class="fw-bold text-muted small d-block mb-1 text-uppercase" style="letter-spacing: 0.5px;">Unique Code System</label>
                        <h4 class="fw-bold mb-1 text-dark text-monospace" style="font-family: monospace; letter-spacing: 1px;">{{ $workflow->code ?? '-' }}</h4>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">ID Parameter Key</small>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Workflow Description / SOP Scope</label>
                    <div class="p-4 border rounded bg-white shadow-sm" style="min-height: 120px; border-left: 5px solid #0d6efd !important;">
                        <p class="mb-0 text-dark fw-medium" style="white-space: pre-line; line-height: 1.6; font-size: 14px;">
                            {{ $workflow->description ?? 'No specific description provided for this operational workflow.' }}
                        </p>
                    </div>
                </div>
            </div>

            <hr class="mt-5 mb-4 opacity-50">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small" style="font-size: 10px;">
                    <i class="fas fa-database me-1"></i> Workflow Instance: <strong>#{{ $workflow->id ?? '-' }}</strong>
                </span>
                <div class="d-flex gap-2">
                    @if(isset($workflow->id))
                        <form action="{{ route('workflows.destroy', $workflow->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this workflow engine config?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger px-4 fw-bold shadow-sm" style="font-size: 13px;">DELETE</button>
                        </form>
                        <a href="{{ route('workflows.edit', $workflow->id) }}" class="btn btn-warning text-white px-4 fw-bold shadow-sm" style="font-size: 13px; background-color: #ffc107; border: none;">
                            EDIT DATA
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