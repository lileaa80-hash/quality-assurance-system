@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Questionnaire Details</h6>
            <a href="{{ route('evaluation_questionnaires.index') }}" class="btn btn-light btn-sm fw-bold border shadow-sm" style="font-size: 11px;">
                Back to List
            </a>
        </div>
        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small fw-bold text-uppercase">Status:</span>
                    @php
                        $statusBadge = [
                            'draft' => 'bg-secondary',
                            'active' => 'bg-success',
                            'closed' => 'bg-danger',
                            'archived' => 'bg-dark',
                        ][$questionnaire->status] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $statusBadge }} px-3 py-2" style="font-size: 11px; border-radius: 4px;">
                        {{ strtoupper($questionnaire->status) }}
                    </span>
                    <span class="text-muted small fw-bold text-uppercase ms-2">Type:</span>
                    <span class="badge bg-white text-primary border border-primary px-3 py-2" style="font-size: 11px; border-radius: 4px;">
                        {{ strtoupper(str_replace('_', ' ', $questionnaire->type)) }}
                    </span>
                </div>
                <div class="text-muted small text-end">
                    <strong>Period:</strong> <span class="text-primary fw-bold">{{ $questionnaire->year }} ({{ $questionnaire->semester ?? 'N/A' }})</span>
                </div>
            </div>

            <div class="p-4">
                <div class="row g-4">
                    <div class="col-md-8">
                        <label class="text-muted small fw-bold d-block mb-1">QUESTIONNAIRE TITLE</label>
                        <h5 class="fw-bold text-dark border-start border-primary border-3 ps-2">
                            {{ $questionnaire->title }}
                        </h5>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <label class="text-muted small fw-bold d-block mb-1">TARGET AUDIENCE</label>
                        <h5 class="fw-bold text-primary mb-0">{{ ucfirst($questionnaire->target_audience) }}</h5>
                        <small class="text-muted">Responden yang dituju</small>
                    </div>
                    <div class="col-12">
                        <div class="bg-light p-3 rounded border shadow-sm">
                            <h6 class="text-primary fw-bold small mb-2"><i class="fas fa-info-circle me-2"></i>DESCRIPTION / INSTRUCTIONS</h6>
                            <p class="mb-0 small text-dark" style="line-height: 1.6;">
                                {{ $questionnaire->description ?: 'No additional description or instructions provided.' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-2">ACTIVE PERIOD</label>
                        <div class="d-flex gap-3 align-items-center">
                            <div class="p-2 border rounded bg-white shadow-sm flex-fill text-center">
                                <span class="d-block text-muted" style="font-size: 10px;">START DATE</span>
                                <span class="small fw-bold">{{ \Carbon\Carbon::parse($questionnaire->start_date)->format('d M Y') }}</span>
                            </div>
                            <i class="fas fa-arrow-right text-muted"></i>
                            <div class="p-2 border rounded bg-white shadow-sm flex-fill text-center">
                                <span class="d-block text-muted" style="font-size: 10px;">END DATE</span>
                                <span class="small fw-bold">{{ \Carbon\Carbon::parse($questionnaire->end_date)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-2">ADDITIONAL SETTINGS</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="p-2 border rounded bg-white shadow-sm h-100">
                                    <span class="d-block text-muted" style="font-size: 10px;">ANONYMOUS</span>
                                    <span class="badge {{ $questionnaire->is_anonymous ? 'bg-success' : 'bg-danger' }} w-100" style="font-size: 9px;">
                                        {{ $questionnaire->is_anonymous ? 'ENABLED' : 'DISABLED' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded bg-white shadow-sm h-100">
                                    <span class="d-block text-muted" style="font-size: 100x;">MULTIPLE SUBMIT</span>
                                    <span class="badge {{ $questionnaire->allow_multiple_submissions ? 'bg-success' : 'bg-secondary' }} w-100" style="font-size: 9px;">
                                        {{ $questionnaire->allow_multiple_submissions ? 'ALLOWED' : 'ONCE ONLY' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="text-muted small fw-bold d-block mb-1">FINAL REPORT DOCUMENT (MINIO)</label>
                        <div class="p-3 bg-white rounded border shadow-sm d-flex align-items-center justify-content-between">
                            @if($questionnaire->report_file)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-pdf text-danger me-3 fa-lg"></i>
                                    <div>
                                        <span class="text-dark small d-block fw-bold">Report Summary</span>
                                        <span class="small text-muted">{{ $questionnaire->report_file }}</span>
                                    </div>
                                </div>
                                <a href="{{ Storage::disk('minio')->url($questionnaire->report_file) }}" target="_blank" class="btn btn-primary btn-sm px-3 fw-bold" style="font-size: 10px;">
                                    <i class="fas fa-download me-1"></i> Download Report
                                </a>
                            @else
                                <p class="mb-0 text-muted small italic">No report file has been uploaded yet.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <form action="{{ route('evaluation_questionnaires.destroy', $questionnaire->id) }}" method="POST" onsubmit="return confirm('Delete this questionnaire?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold" style="font-size: 11px;">
                            Delete
                        </button>
                    </form>
                    <a href="{{ route('evaluation_questionnaires.edit', $questionnaire->id) }}" class="btn btn-warning btn-sm px-4 fw-bold text-white shadow-sm" style="font-size: 11px;">
                        Edit Questionnaire
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