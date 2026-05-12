@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold" style="letter-spacing: 0.5px;">CORRECTIVE ACTION DETAILS (CAPA)</h6>
            <a href="{{ route('corrective_actions.index') }}" class="btn btn-light btn-sm fw-bold border shadow-sm px-3" style="font-size: 11px;">
                <i class="fas fa-arrow-left me-1"></i> BACK TO LIST
            </a>
        </div>

        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center px-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="status-item">
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="font-size: 10px;">Final Status:</span>
                        @php
                            $statusBadge = [
                                'open' => 'bg-danger',
                                'closed' => 'bg-success',
                                'reopened' => 'bg-warning text-dark'
                            ][$action->final_status] ?? 'bg-secondary';
                        @endphp
                        <span class="badge {{ $statusBadge }} px-3 py-2 text-uppercase" style="font-size: 11px; border-radius: 4px; min-width: 80px;">
                            {{ $action->final_status }}
                        </span>
                    </div>

                    <div class="status-item">
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="font-size: 10px;">Verification:</span>
                        @php
                            $vBadge = [
                                'pending' => 'bg-warning text-dark',
                                'verified' => 'bg-info text-white',
                                'rejected' => 'bg-danger'
                            ][$action->verification_status] ?? 'bg-dark';
                        @endphp
                        <span class="badge {{ $vBadge }} px-3 py-2 text-uppercase" style="font-size: 11px; border-radius: 4px; min-width: 80px;">
                            {{ $action->verification_status }}
                        </span>
                    </div>
                </div>
                <div class="text-end">
                    <span class="text-muted small fw-bold d-block" style="font-size: 10px;">CA NO:</span>
                    <span class="text-primary fw-bold" style="font-size: 16px;">{{ $action->ca_number }}</span>
                </div>
            </div>

            <div class="p-4 px-5">
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1 text-uppercase">Unit Name</label>
                        <p class="fw-bold border-start border-primary border-3 ps-3 text-dark mb-0" style="font-size: 15px;">
                            {{ $action->unit_name }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1 text-uppercase">Responsible (PIC)</label>
                        <p class="fw-semibold text-dark mb-0">
                            <i class="fas fa-user-circle me-2 text-muted"></i>{{ $action->pic_name }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1 text-uppercase">Source Finding Ref</label>
                        <p class="text-primary fw-bold mb-0">
                            <a href="#" class="text-decoration-none">{{ $action->finding_number }}</a>
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1 text-uppercase">Target Date</label>
                        <p class="text-dark mb-0">
                            <i class="far fa-calendar-alt me-2 text-muted"></i>{{ \Carbon\Carbon::parse($action->target_completion_date)->format('d F Y') }}
                        </p>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-inline-block p-2 px-3 bg-light rounded border shadow-sm">
                        <label class="text-muted small fw-bold d-block mb-0 text-uppercase" style="font-size: 9px;">Cause Category</label>
                        <span class="fw-bold text-uppercase text-primary">{{ $action->cause_category }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="mb-4">
                        <label class="text-muted small fw-bold d-block mb-2 text-uppercase">Root Cause Analysis (RCA)</label>
                        <div class="p-3 bg-white rounded border shadow-sm">
                            <p class="mb-0 text-dark italic" style="font-size: 13.5px; line-height: 1.6;">
                                "{{ $action->root_cause }}"
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small fw-bold d-block mb-2 text-uppercase">Corrective Action Plan</label>
                        <div class="p-3 bg-white rounded border shadow-sm border-start border-danger border-3">
                            <p class="mb-0 text-dark" style="white-space: pre-line;">{{ $action->corrective_action_plan }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small fw-bold d-block mb-2 text-uppercase">Preventive Action Plan</label>
                        <div class="p-3 bg-white rounded border shadow-sm border-start border-success border-3">
                            <p class="mb-0 text-dark" style="white-space: pre-line;">
                                {{ $action->preventive_action_plan ?: 'No preventive action recorded.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <form action="{{ route('corrective_actions.destroy', $action->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this CA?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold" style="font-size: 11px; border-radius: 6px;">
                            DELETE CA
                        </button>
                    </form>
                    <a href="{{ route('corrective_actions.edit', $action->id) }}" class="btn btn-warning btn-sm px-4 fw-bold text-white shadow-sm" style="font-size: 11px; border-radius: 6px;">
                        EDIT PROGRESS
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
    .italic { font-style: italic; color: #555; }
    .status-item { line-height: 1.2; }
    label { letter-spacing: 0.5px; }
    .card-header { border-radius: 8px 8px 0 0 !important; }
</style>
@endsection