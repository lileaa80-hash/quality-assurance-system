@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="fas fa-file-alt me-2"></i> Accreditation Borang Details
            </h6>
            <a href="{{ route('accreditation_borangs.index') }}" class="btn btn-light btn-sm fw-bold border shadow-sm px-3" style="font-size: 11px; color: #0d6efd;">
                <i class="fas fa-arrow-left me-1"></i> BACK TO LIST
            </a>
        </div>

        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center px-4">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small fw-bold text-uppercase">Current Status:</span>
                    @php
                        $statusBadge = [
                            'draft' => 'bg-secondary',
                            'submitted' => 'bg-info text-white',
                            'verified' => 'bg-success',
                            'revised' => 'bg-danger',
                        ][$borang->status] ?? 'bg-dark';
                    @endphp
                    <span class="badge {{ $statusBadge }} px-3 py-2 text-uppercase" style="font-size: 10px; border-radius: 4px; letter-spacing: 0.5px;">
                        {{ str_replace('_', ' ', $borang->status ?? 'unknown') }}
                    </span>
                </div>
                <div class="text-end">
                    <span class="text-muted small fw-bold text-uppercase">Indicator:</span>
                    <span class="text-primary fw-bold ms-1" style="font-size: 13px;">
                        {{ $borang->indicator_name ?? ($borang->name ?? ($borang->indicator ?? 'N/A')) }}
                    </span>
                </div>
            </div>

            <div class="p-4 px-5">
                <div class="row g-4">
                    <div class="col-md-7">
                        <label class="text-muted small fw-bold d-block mb-1 text-uppercase">Standard & Period Information</label>
                        <div class="p-3 bg-white border-start border-primary border-4 rounded shadow-sm">
                            <h6 class="fw-bold text-dark mb-1">{{ $borang->standard_name ?? 'Standard Data Missing' }}</h6>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-calendar-alt me-1 text-primary"></i> 
                                Period: <span class="fw-semibold text-dark">{{ $borang->period_name ?? 'N/A' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label class="text-muted small fw-bold d-block mb-1 text-uppercase text-md-end">Assessment Result</label>
                        <div class="d-flex justify-content-md-end gap-3">
                            <div class="text-center p-2 border rounded bg-white" style="min-width: 100px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                <small class="d-block text-muted fw-bold" style="font-size: 9px;">SELF SCORE</small>
                                <h4 class="fw-bold text-dark mb-0">{{ $borang->self_assessment_score ?? '0' }}</h4>
                            </div>
                            <div class="text-center p-2 border rounded bg-primary text-white" style="min-width: 100px; box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);">
                                <small class="d-block fw-bold" style="font-size: 9px; opacity: 0.8;">ASSESSOR</small>
                                <h4 class="fw-bold mb-0">{{ $borang->assessor_score ?? '-' }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="bg-light p-3 rounded border" style="border-left: 4px solid #6c757d !important;">
                            <h6 class="text-primary fw-bold small mb-2 text-uppercase"><i class="fas fa-bullseye me-2"></i>Achievement Target</h6>
                            <p class="mb-0 text-dark fw-semibold" style="font-size: 14px;">{{ $borang->target ?: 'No target specified for this borang.' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-2 text-uppercase text-primary"><i class="fas fa-comment-dots me-1"></i> Response / Description</label>
                        <div class="p-3 bg-white border rounded small text-dark shadow-sm" style="min-height: 120px; line-height: 1.6; background-color: #fcfcfc !important;">
                            {{ $borang->response ?: 'No response description provided.' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-2 text-uppercase text-primary"><i class="fas fa-chart-line me-1"></i> Analysis</label>
                        <div class="p-3 bg-white border rounded small text-dark shadow-sm" style="min-height: 120px; line-height: 1.6; background-color: #fcfcfc !important;">
                            {{ $borang->analysis ?: 'No analysis provided.' }}
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small fw-bold d-block mb-2 text-uppercase">Supporting Evidence</label>
                        <div class="p-3 bg-white rounded border d-flex align-items-center justify-content-between shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="fas fa-folder-open text-warning fa-lg"></i>
                                </div>
                                <div>
                                    <span class="text-dark small d-block fw-bold">Working Documents & Files</span>
                                    <small class="text-muted">Access all evidence links and uploaded files</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm px-4 fw-bold shadow-sm" style="font-size: 11px;">
                                <i class="fas fa-external-link-alt me-1"></i> VIEW EVIDENCE
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <form action="{{ route('accreditation_borangs.destroy', $borang->id) }}" method="POST" onsubmit="return confirm('Delete this record forever?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold" style="font-size: 11px;">
                            <i class="fas fa-trash me-1"></i> DELETE
                        </button>
                    </form>
                    <a href="{{ route('accreditation_borangs.edit', $borang->id) }}" class="btn btn-warning btn-sm px-4 fw-bold text-white shadow-sm" style="font-size: 11px;">
                        <i class="fas fa-edit me-1"></i> EDIT DATA
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>

<style>
    .card { border-radius: 8px; overflow: hidden; }
    .bg-light { background-color: #f8f9fa !important; }
    .text-primary { color: #0d6efd !important; }
</style>
@endsection