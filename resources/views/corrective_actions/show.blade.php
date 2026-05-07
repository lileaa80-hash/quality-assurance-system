@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Corrective Action Details (CAPA)</h6>
            <a href="{{ route('corrective_actions.index') }}" class="btn btn-light btn-sm fw-bold border shadow-sm" style="font-size: 11px;">
                Back to List
            </a>
        </div>
        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small fw-bold text-uppercase">Final Status:</span>
                    @php
                        $statusBadge = [
                            'open' => 'bg-danger',
                            'closed' => 'bg-success',
                            'reopened' => 'bg-warning text-dark'
                        ][$action->final_status] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $statusBadge }} px-3 py-2" style="font-size: 11px; border-radius: 4px;">
                        {{ strtoupper($action->final_status) }}
                    </span>
                    <span class="text-muted small fw-bold text-uppercase ms-2">Verification:</span>
                    @php
                        $vBadge = [
                            'pending' => 'bg-warning text-dark',
                            'verified' => 'bg-info text-white',
                            'rejected' => 'bg-danger'
                        ][$action->verification_status] ?? 'bg-dark';
                    @endphp
                    <span class="badge {{ $vBadge }} px-3 py-2" style="font-size: 11px; border-radius: 4px;">
                        {{ strtoupper($action->verification_status) }}
                    </span>
                </div>
                <div class="text-muted small">
                    <strong>CA No:</strong> <span class="text-primary fw-bold">{{ $action->ca_number }}</span>
                </div>
            </div>
            <div class="p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">UNIT NAME</label>
                        <p class="fw-bold border-start border-primary border-3 ps-2 text-dark">{{ $action->unit_name }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">RESPONSIBLE (PIC)</label>
                        <p class="fw-semibold text-dark"><i class="fas fa-user-tie me-2 text-primary"></i>{{ $action->pic_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">SOURCE FINDING REF</label>
                        <p class="text-primary fw-bold">{{ $action->finding_number }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">TARGET DATE</label>
                        <p class="text-dark"><i class="far fa-calendar-alt me-2 text-muted"></i>{{ \Carbon\Carbon::parse($action->target_completion_date)->format('d F Y') }}</p>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 bg-light shadow-sm">
                            <div class="card-body py-2">
                                <label class="text-muted small fw-bold d-block mb-0">CAUSE CATEGORY</label>
                                <span class="fw-bold text-uppercase text-primary">{{ $action->cause_category }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small fw-bold d-block mb-1">ROOT CAUSE ANALYSIS (RCA)</label>
                        <div class="p-3 bg-white rounded border shadow-sm">
                            <p class="mb-0 text-dark italic" style="font-size: 13px;">{{ $action->root_cause }}</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small fw-bold d-block mb-1">CORRECTIVE ACTION PLAN</label>
                        <div class="p-3 bg-white rounded border shadow-sm border-start border-danger border-3">
                            <p class="mb-0 text-dark" style="white-space: pre-line;">{{ $action->corrective_action_plan }}</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small fw-bold d-block mb-1">PREVENTIVE ACTION PLAN</label>
                        <div class="p-3 bg-white rounded border shadow-sm border-start border-success border-3">
                            <p class="mb-0 text-dark" style="white-space: pre-line;">{{ $action->preventive_action_plan ?: 'No preventive action recorded.' }}</p>
                        </div>
                    </div>

                    @if($action->implementation_evidence)
                    <div class="col-12">
                        <label class="text-muted small fw-bold d-block mb-1">IMPLEMENTATION EVIDENCE</label>
                        <div class="alert alert-secondary py-2 border-0 shadow-sm" style="font-size: 12px;">
                            <i class="fas fa-check-double me-2"></i> {{ $action->implementation_evidence }}
                            @if($action->implementation_date)
                                <div class="mt-1 fw-bold text-muted small italic">Finished on: {{ \Carbon\Carbon::parse($action->implementation_date)->format('d/m/Y') }}</div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <form action="{{ route('corrective_actions.destroy', $action->id) }}" method="POST" onsubmit="return confirm('Delete this action plan?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold" style="font-size: 11px;">
                            Delete CA
                        </button>
                    </form>
                    <a href="{{ route('corrective_actions.edit', $action->id) }}" class="btn btn-warning btn-sm px-4 fw-bold text-white shadow-sm" style="font-size: 11px;">
                        Edit Progress
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>

<style>
    .italic { font-style: italic; }
</style>
@endsection