@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Accreditation Borang Details</h6>
            <a href="{{ route('accreditation_borangs.index') }}" class="btn btn-light btn-sm fw-bold border shadow-sm" style="font-size: 11px;">
                Back to List
            </a>
        </div>
        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small fw-bold text-uppercase">Current Status:</span>
                    @php
                        $statusBadge = [
                            'draft' => 'bg-secondary',
                            'in_progress' => 'bg-info text-white',
                            'reviewed' => 'bg-warning text-dark',
                            'final' => 'bg-success',
                        ][$borang->status] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $statusBadge }} px-3 py-2" style="font-size: 11px; border-radius: 4px;">
                        {{ strtoupper(str_replace('_', ' ', $borang->status)) }}
                    </span>
                    <span class="text-muted small fw-bold text-uppercase ms-2">Type:</span>
                    <span class="badge bg-white text-primary border border-primary px-3 py-2" style="font-size: 11px; border-radius: 4px;">
                        {{ strtoupper($borang->type) }}
                    </span>
                </div>
                <div class="text-muted small text-end">
                    <strong>Borang Name:</strong> <span class="text-primary fw-bold">{{ $borang->name }}</span>
                </div>
            </div>
            <div class="p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">RELATED PERIOD</label>
                        <p class="fw-bold border-start border-primary border-3 ps-2 text-dark">
                            {{ $borang->accreditationPeriod->period_name ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-6 text-md-end">
                        <label class="text-muted small fw-bold d-block mb-1">TARGET SCORE</label>
                        <h4 class="fw-bold text-primary mb-0">{{ $borang->target_score ?? '0' }}</h4>
                        <small class="text-muted">Targeted result for this borang</small>
                    </div>

                    <div class="col-12">
                        <div class="bg-light p-3 rounded border shadow-sm">
                            <h6 class="text-primary fw-bold small mb-2"><i class="fas fa-info-circle me-2"></i>DESCRIPTION / NOTES</h6>
                            <p class="mb-0 small text-dark" style="line-height: 1.6;">
                                {{ $borang->description ?: 'No additional description or notes provided for this borang.' }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="text-muted small fw-bold d-block mb-1">WORKING DOCUMENT LINK</label>
                        <div class="p-3 bg-white rounded border shadow-sm d-flex align-items-center justify-content-between">
                            @if($borang->document_link)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-external-link-alt text-primary me-3 fa-lg"></i>
                                    <div>
                                        <span class="text-dark small d-block fw-bold">Cloud Storage / Spreadsheet</span>
                                        <a href="{{ $borang->document_link }}" target="_blank" class="small text-decoration-none truncate-link" style="max-width: 500px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $borang->document_link }}
                                        </a>
                                    </div>
                                </div>
                                <a href="{{ $borang->document_link }}" target="_blank" class="btn btn-primary btn-sm px-3 fw-bold" style="font-size: 10px;">
                                    Open Document
                                </a>
                            @else
                                <p class="mb-0 text-muted small italic">No external link attached to this borang.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <form action="{{ route('accreditation_borangs.destroy', $borang->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this borang?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold" style="font-size: 11px;">
                            Delete Borang
                        </button>
                    </form>
                    <a href="{{ route('accreditation_borangs.edit', $borang->id) }}" class="btn btn-warning btn-sm px-4 fw-bold text-white shadow-sm" style="font-size: 11px;">
                        Edit Borang
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
    .truncate-link {
        max-width: 400px;
    }
    @media (max-width: 768px) {
        .truncate-link { max-width: 200px; }
    }
</style>
@endsection