@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Audit Report Details</h6>
            <a href="{{ route('audit_checklists.index') }}" class="btn btn-light btn-sm fw-bold border shadow-sm" style="font-size: 11px;">
                Back to List
            </a>
        </div>
        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                <span class="text-muted small fw-bold text-uppercase">Audit Result Status:</span>
                @php
                    $badge = [
                        'compliant' => 'bg-success',
                        'partially_compliant' => 'bg-warning text-dark',
                        'non_compliant' => 'bg-danger',
                        'not_applicable' => 'bg-secondary'
                    ][$checklist->result] ?? 'bg-dark';
                @endphp
                <span class="badge {{ $badge }} px-3 py-2" style="font-size: 12px;">
                    {{ strtoupper(str_replace('_', ' ', $checklist->result)) }}
                </span>
            </div>
            <div class="p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">UNIT NAME</label>
                        <p class="fw-bold border-start border-primary border-3 ps-2">{{ $checklist->unit_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">AUDITOR</label>
                        <p class="fw-semibold text-dark"><i class="fas fa-user-check me-2 text-primary"></i>{{ $checklist->auditor_name }}</p>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small fw-bold d-block mb-1">STANDARD</label>
                        <p class="text-dark">{{ $checklist->standard_name }}</p>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small fw-bold d-block mb-1">INDICATOR</label>
                        <div class="p-3 bg-light rounded border shadow-sm">
                            <p class="mb-0 italic">{{ $checklist->indicator_text }}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border shadow-sm">
                            <div class="card-body text-center py-3">
                                <label class="text-muted small fw-bold d-block mb-1">SCORE</label>
                                <h3 class="fw-bold mb-0 text-primary">{{ $checklist->score ?? '0' }}</h3>
                                <small class="text-muted">out of 100</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <label class="text-muted small fw-bold d-block mb-1">OBJECTIVE EVIDENCE</label>
                        <p class="text-dark border p-2 rounded bg-white min-vh-10" style="min-height: 80px;">
                            {{ $checklist->objective_evidence ?: 'No evidence recorded.' }}
                        </p>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small fw-bold d-block mb-1">NOTES / RECOMMENDATIONS</label>
                        <div class="alert alert-info border-0 shadow-sm">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ $checklist->notes ?: 'No additional notes.' }}
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('audit_checklists.edit', $checklist->id) }}" class="btn btn-warning btn-sm px-4 fw-bold text-white shadow-sm" style="font-size: 11px;">
                        Edit Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection