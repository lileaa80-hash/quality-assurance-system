@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold">AUDIT FINDING DETAILS</h6>
            <a href="{{ route('audit_findings.index') }}" class="btn btn-light btn-sm fw-bold border shadow-sm px-3" style="font-size: 11px;">
                Back to List
            </a>
        </div>

        <div class="card-body p-0">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white">
                <span class="fw-bold text-dark small">CURRENT AUDIT STATUS</span>
                @php
                    $statusBadge = [
                        'open' => 'bg-danger',
                        'in_progress' => 'bg-warning text-dark',
                        'closed' => 'bg-success'
                    ][$finding->status] ?? 'bg-secondary';
                @endphp
                <span class="badge {{ $statusBadge }} px-3 py-2" style="font-size: 10px; border-radius: 4px;">
                    {{ strtoupper($finding->status) }}
                </span>
            </div>

            <div class="detail-row d-flex border-bottom bg-light p-3">
                <div class="detail-label small fw-bold text-muted" style="width: 250px;">REF NUMBER</div>
                <div class="detail-content small fw-bold text-primary">{{ $finding->finding_number }}</div>
            </div>

            <div class="detail-row d-flex border-bottom bg-white p-3">
                <div class="detail-label small fw-bold text-muted" style="width: 250px;">UNIT NAME</div>
                <div class="detail-content small fw-bold text-primary">{{ $finding->unit_name }}</div>
            </div>

            <div class="detail-row d-flex border-bottom bg-light p-3">
                <div class="detail-label small fw-bold text-muted" style="width: 250px;">AUDITOR</div>
                <div class="detail-content small text-dark fw-semibold">{{ $finding->auditor_name }}</div>
            </div>

            <div class="detail-row d-flex border-bottom bg-white p-3">
                <div class="detail-label small fw-bold text-muted" style="width: 250px;">AUDIT SCHEDULE</div>
                <div class="detail-content small text-dark">{{ $finding->schedule_title }}</div>
            </div>

            <div class="detail-row d-flex border-bottom bg-light p-3">
                <div class="detail-label small fw-bold text-muted" style="width: 250px;">FINDING DATE</div>
                <div class="detail-content small text-dark">{{ \Carbon\Carbon::parse($finding->finding_date)->format('d F Y') }}</div>
            </div>

            <div class="detail-row d-flex border-bottom bg-white p-3">
                <div class="detail-label small fw-bold text-muted" style="width: 250px;">CATEGORY / RISK</div>
                <div class="detail-content small">
                    <span class="text-primary fw-bold text-uppercase">{{ $finding->category }}</span>
                    <span class="text-muted mx-2">|</span>
                    <span class="text-danger fw-bold">Level {{ $finding->risk_level }} / 5</span>
                </div>
            </div>

            <div class="detail-row d-flex border-bottom bg-light p-3">
                <div class="detail-label small fw-bold text-muted" style="width: 250px;">FINDING DESCRIPTION</div>
                <div class="detail-content small text-dark" style="flex: 1;">
                    <div class="p-3 bg-white border rounded" style="white-space: pre-line;">{{ $finding->finding_description }}</div>
                </div>
            </div>

            <div class="detail-row d-flex border-bottom bg-white p-3">
                <div class="detail-label small fw-bold text-muted" style="width: 250px;">OBJECTIVE EVIDENCE</div>
                <div class="detail-content small text-dark" style="flex: 1;">
                    <div class="p-3 bg-light border rounded" style="min-height: 50px;">
                        {{ $finding->objective_evidence ?: '-' }}
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white d-flex justify-content-end gap-2">
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

    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>

<style>
    /* Styling agar baris detail rapi dan presisi */
    .detail-row {
        transition: background-color 0.2s;
    }
    .detail-label {
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    /* Memastikan konten mengisi sisa ruang */
    .detail-content {
        flex: 1;
    }
</style>
@endsection