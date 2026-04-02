@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Audit Finding Details</h6>
            <a href="{{ route('audit_findings.index') }}" class="btn btn-light btn-sm fw-bold border shadow-sm" style="font-size: 11px;">
                Back to List
            </a>
        </div>

        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small fw-bold text-uppercase">Finding Status:</span>
                    @php
                        $statusBadge = [
                            'open' => 'bg-danger',
                            'in_progress' => 'bg-warning text-dark',
                            'closed' => 'bg-success'
                        ][$finding->status] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $statusBadge }} px-3 py-2" style="font-size: 11px; border-radius: 4px;">
                        {{ strtoupper($finding->status) }}
                    </span>
                </div>
                <div class="text-muted small">
                    <strong>Ref No:</strong> <span class="text-primary fw-bold">{{ $finding->finding_number }}</span>
                </div>
            </div>

            <div class="p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">UNIT NAME</label>
                        <p class="fw-bold border-start border-primary border-3 ps-2 text-dark">{{ $finding->unit_name }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">AUDITOR</label>
                        <p class="fw-semibold text-dark"><i class="fas fa-user-check me-2 text-primary"></i>{{ $finding->auditor_name }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">AUDIT SCHEDULE</label>
                        <p class="text-dark"><i class="far fa-calendar-alt me-2 text-muted"></i>{{ $finding->schedule_title }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">FINDING DATE</label>
                        <p class="text-dark">{{ \Carbon\Carbon::parse($finding->finding_date)->format('d F Y') }}</p>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 bg-light shadow-sm">
                            <div class="card-body py-2">
                                <label class="text-muted small fw-bold d-block mb-0">CATEGORY</label>
                                <span class="fw-bold text-uppercase text-primary">{{ $finding->category }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 bg-light shadow-sm">
                            <div class="card-body py-2 text-center">
                                <label class="text-muted small fw-bold d-block mb-0">RISK LEVEL</label>
                                <span class="fw-bold text-danger">{{ $finding->risk_level }} / 5</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 bg-light shadow-sm">
                            <div class="card-body py-2 text-end">
                                <label class="text-muted small fw-bold d-block mb-0">TYPE</label>
                                <span class="fw-bold text-dark text-uppercase">{{ $finding->type }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small fw-bold d-block mb-1">FINDING DESCRIPTION</label>
                        <div class="p-3 bg-white rounded border shadow-sm border-start border-danger border-3">
                            <p class="mb-0 text-dark" style="white-space: pre-line;">{{ $finding->finding_description }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">CRITERIA REFERENCE</label>
                        <div class="p-2 border rounded bg-light small text-muted italic" style="min-height: 60px;">
                            {{ $finding->criteria_reference ?: 'No reference recorded.' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">OBJECTIVE EVIDENCE</label>
                        <div class="p-2 border rounded bg-light small text-muted" style="min-height: 60px;">
                            {{ $finding->objective_evidence ?: 'No evidence recorded.' }}
                        </div>
                    </div>

                    @if(isset($finding->checklist_question))
                    <div class="col-12">
                        <label class="text-muted small fw-bold d-block mb-1">CHECKLIST SOURCE</label>
                        <div class="alert alert-secondary py-2 border-0 shadow-sm" style="font-size: 12px;">
                            <i class="fas fa-link me-2"></i> Derived from checklist: {{ $finding->checklist_question }}
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <form action="{{ route('audit_findings.destroy', $finding->id) }}" method="POST" onsubmit="return confirm('Delete this finding?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold" style="font-size: 11px;">
                            Delete Finding
                        </button>
                    </form>
                    <a href="{{ route('audit_findings.edit', $finding->id) }}" class="btn btn-warning btn-sm px-4 fw-bold text-white shadow-sm" style="font-size: 11px;">
                        Edit Finding
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