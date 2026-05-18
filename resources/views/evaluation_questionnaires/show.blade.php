@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">QUESTIONNAIRE DETAILS</h5>
            <a href="{{ route('evaluation_questionnaires.index') }}" class="btn btn-light btn-sm fw-bold px-3" style="font-size: 12px; color: #0d6efd;">BACK TO LIST</a>
        </div>

        <div class="card-body p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="fw-bold text-muted small me-2">CURRENT STATUS:</span>
                    @php
                        $statusBadge = [
                            'draft'    => 'bg-warning text-dark',
                            'active'   => 'bg-success text-white',
                            'closed'   => 'bg-danger text-white',
                            'archived' => 'bg-secondary text-white',
                        ][$questionnaire->status] ?? 'bg-dark text-white';
                    @endphp
                    <span class="badge {{ $statusBadge }} px-3 py-2 text-uppercase shadow-sm" style="font-size: 11px; border-radius: 4px;">
                        {{ $questionnaire->status }}
                    </span>
                </div>
                <div>
                    <span class="fw-bold text-muted small">AUDIENCE:</span>
                    <span class="badge bg-info text-white px-3 py-2 text-uppercase ms-1" style="font-size: 11px; border-radius: 4px;">
                        {{ $questionnaire->target_audience }}
                    </span>
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-8">
                    <div class="p-4 border rounded shadow-sm bg-white h-100">
                        <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Questionnaire Title</label>
                        <h4 class="fw-bold text-primary mb-2">{{ $questionnaire->title }}</h4>
                        <span class="badge bg-light text-secondary border text-uppercase" style="font-size: 10px; font-weight: 600; letter-spacing: 0.3px;">
                            {{ str_replace('_', ' ', $questionnaire->type) }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4 border rounded shadow-sm bg-white h-100 d-flex flex-column justify-content-center">
                        <label class="fw-bold text-muted small d-block mb-1 text-uppercase" style="letter-spacing: 0.5px;">Period Year</label>
                        <h3 class="fw-bold mb-0 text-dark">{{ $questionnaire->year }}</h3>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Semester: {{ $questionnaire->semester ?? 'N/A' }}</small>
                    </div>
                </div>
            </div>

            <div class="bg-light p-4 rounded mb-4 border">
                <h6 class="fw-bold small text-muted border-bottom pb-2 mb-3 text-uppercase" style="letter-spacing: 1px;">Configuration & Metadata</h6>
                <div class="row g-3">
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block text-uppercase mb-1" style="font-size: 10px;">Start Date</small>
                        <span class="fw-bold text-dark"><i class="far fa-calendar-alt text-primary me-1"></i> {{ \Carbon\Carbon::parse($questionnaire->start_date)->format('d M Y') }}</span>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block text-uppercase mb-1" style="font-size: 10px;">End Date</small>
                        <span class="fw-bold text-dark"><i class="far fa-calendar-check text-danger me-1"></i> {{ \Carbon\Carbon::parse($questionnaire->end_date)->format('d M Y') }}</span>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block text-uppercase mb-1" style="font-size: 10px;">Response Method</small>
                        <span class="fw-bold text-dark">
                            {!! $questionnaire->is_anonymous ? '<i class="fas fa-user-secret text-success me-1"></i> Anonymous' : '<i class="fas fa-user text-secondary me-1"></i> Public/Open' !!}
                        </span>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block text-uppercase mb-1" style="font-size: 10px;">Multi-Submission</small>
                        <span class="fw-bold text-dark">
                            {!! $questionnaire->allow_multiple_submissions ? '<span class="text-success">Allowed</span>' : '<span class="text-muted">Once Only</span>' !!}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-light p-4 rounded mb-4 border">
                <h6 class="fw-bold small text-muted border-bottom pb-2 mb-3 text-uppercase" style="letter-spacing: 1px;">Attachment Report File</h6>
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <small class="text-muted d-block text-uppercase mb-1" style="font-size: 10px;">Storage File Path (MinIO S3)</small>
                        @if($questionnaire->report_file)
                            <span class="fw-semibold text-dark text-break" style="font-size: 11px;"><i class="fas fa-paperclip text-muted me-1"></i> {{ $questionnaire->report_file }}</span>
                        @else
                            <span class="text-muted style="font-style: italic; font-size: 11px;">No report document attached to this evaluation.</span>
                        @endif
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        @if($questionnaire->report_file)
                            <a href="{{ Storage::disk('s3')->url($questionnaire->report_file) }}" target="_blank" class="btn btn-primary fw-bold px-4 shadow-sm" style="font-size: 12px;">
                                <i class="fas fa-cloud-download-alt me-1"></i> Open / Download File
                            </a>
                        @else
                            <button class="btn btn-secondary fw-bold px-4 shadow-sm" style="font-size: 12px;" disabled>
                                <i class="fas fa-ban me-1"></i> Unavailable
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Target Units Bound</label>
                    <div class="p-3 border rounded bg-white shadow-sm" style="min-height: 55px;">
                        @if($questionnaire->target_units)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(json_decode($questionnaire->target_units) as $unit)
                                    <span class="badge bg-white text-primary border border-primary px-2 py-1.5 fw-bold" style="font-size: 10px;">
                                        <i class="fas fa-building me-1 opacity-75"></i> {{ strtoupper($unit) }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="mb-0 text-muted small" style="font-style: italic;">Broad questionnaire model: Targeted directly to all work units system-wide.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Description / Instructions Log</label>
                    <div class="p-4 border rounded bg-white shadow-sm" style="min-height: 120px; border-left: 5px solid #0d6efd !important;">
                        <p class="mb-0 text-dark" style="white-space: pre-line; line-height: 1.6; font-size: 13px;">{{ $questionnaire->description ?? 'No explicit description or instructions provided for this questionnaire.' }}</p>
                    </div>
                </div>
            </div>

            <hr class="mt-5 mb-4 opacity-50">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small" style="font-size: 10px;">
                    <i class="fas fa-user-edit me-1"></i> Created By: <strong>{{ $questionnaire->creator_name }}</strong>
                </span>
                <div class="d-flex gap-2">
                    <form action="{{ route('evaluation_questionnaires.destroy', $questionnaire->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this questionnaire and its file database records?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger px-4 fw-bold shadow-sm" style="font-size: 13px;">DELETE</button>
                    </form>
                    <a href="{{ route('evaluation_questionnaires.edit', $questionnaire->id) }}" class="btn btn-warning text-white px-4 fw-bold shadow-sm" style="font-size: 13px; background-color: #ffc107; border: none;">
                        edit data
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Questionnaire Verification View
    </div>
</div>
@endsection