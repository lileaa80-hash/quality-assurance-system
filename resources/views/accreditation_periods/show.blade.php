@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Accreditation Period Details</h6>
            <a href="{{ route('accreditation_periods.index') }}" class="btn btn-light btn-sm fw-bold border shadow-sm" style="font-size: 11px;">
                Back to List
            </a>
        </div>

        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small fw-bold text-uppercase">Current Status:</span>
                    @php
                        $statusBadge = [
                            'planned' => 'bg-secondary',
                            'preparation' => 'bg-info text-white',
                            'submitted' => 'bg-primary',
                            'assesment' => 'bg-warning text-dark',
                            'waiting_result' => 'bg-dark text-white',
                            'completed' => 'bg-success',
                            'postponed' => 'bg-danger'
                        ][$period->status] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $statusBadge }} px-3 py-2" style="font-size: 11px; border-radius: 4px;">
                        {{ strtoupper(str_replace('_', ' ', $period->status)) }}
                    </span>

                    <span class="text-muted small fw-bold text-uppercase ms-2">Type:</span>
                    <span class="badge bg-white text-primary border border-primary px-3 py-2" style="font-size: 11px; border-radius: 4px;">
                        {{ strtoupper($period->type) }}
                    </span>
                </div>
                <div class="text-muted small">
                    <strong>Period Name:</strong> <span class="text-primary fw-bold">{{ $period->period_name }}</span>
                </div>
            </div>

            <div class="p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">UNIT / DEPARTMENT</label>
                        <p class="fw-bold border-start border-primary border-3 ps-2 text-dark">{{ $period->unit_name }}</p>
                    </div>

                    <div class="col-md-6 text-md-end">
                        <label class="text-muted small fw-bold d-block mb-1">CERTIFICATE NUMBER</label>
                        <p class="fw-semibold text-dark">{{ $period->certificate_number ?: 'Not Yet Available' }}</p>
                    </div>

                    <div class="col-12">
                        <div class="bg-light p-3 rounded border shadow-sm">
                            <h6 class="text-primary fw-bold small mb-3"><i class="far fa-calendar-alt me-2"></i>TIMELINE MILESTONES</h6>
                            <div class="row text-center">
                                <div class="col-md-3 border-end">
                                    <label class="text-muted d-block" style="font-size: 10px;">START DATE</label>
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($period->start_date)->format('d M Y') }}</span>
                                </div>
                                <div class="col-md-3 border-end">
                                    <label class="text-muted d-block" style="font-size: 10px;">SUBMISSION DEADLINE</label>
                                    <span class="fw-bold text-danger">{{ $period->submission_deadline ? \Carbon\Carbon::parse($period->submission_deadline)->format('d M Y') : '-' }}</span>
                                </div>
                                <div class="col-md-3 border-end">
                                    <label class="text-muted d-block" style="font-size: 10px;">ASSESSMENT DATE</label>
                                    <span class="fw-bold text-primary">{{ $period->assesment_date ? \Carbon\Carbon::parse($period->assesment_date)->format('d M Y') : '-' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted d-block" style="font-size: 10px;">EXPIRY DATE</label>
                                    <span class="fw-bold">{{ $period->expiry_date ? \Carbon\Carbon::parse($period->expiry_date)->format('d M Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <label class="text-muted small fw-bold d-block mb-1">FINAL GRADE & SCORE</label>
                        <div class="p-3 bg-white rounded border shadow-sm border-start border-success border-3">
                            @if($period->result_grade)
                                <h4 class="mb-0 text-success fw-bold">{{ $period->result_grade }}</h4>
                                <div class="text-muted small fw-bold">Score: {{ $period->result_score ?? '0' }} / 400</div>
                                @if($period->result_date)
                                    <div class="mt-2 text-muted italic" style="font-size: 11px;">Announced on: {{ \Carbon\Carbon::parse($period->result_date)->format('d F Y') }}</div>
                                @endif
                            @else
                                <p class="mb-0 text-muted italic" style="font-size: 13px;">Waiting for final assessment results...</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label class="text-muted small fw-bold d-block mb-1">EXTERNAL ASSESSORS</label>
                        <div class="p-3 bg-white rounded border shadow-sm">
                            @if($period->assessors)
                                <ul class="list-unstyled mb-0" style="font-size: 12px;">
                                    @php $assessors = json_decode($period->assessors, true); @endphp
                                    @foreach($assessors as $assessor)
                                        <li class="mb-1"><i class="fas fa-user-check me-2 text-primary"></i> {{ $assessor }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mb-0 text-muted small italic">No assessors assigned yet.</p>
                            @endif
                        </div>
                    </div>

                    @if($period->certificate_file)
                    <div class="col-12">
                        <div class="alert alert-primary py-2 border-0 shadow-sm d-flex align-items-center justify-content-between" style="font-size: 12px;">
                            <div>
                                <i class="fas fa-file-pdf me-2"></i> Digital Accreditation Certificate is available.
                            </div>
                            <a href="#" class="btn btn-primary btn-sm fw-bold px-3" style="font-size: 10px;">Download Cert</a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <form action="{{ route('accreditation_periods.destroy', $period->id) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold" style="font-size: 11px;">
                            Delete Period
                        </button>
                    </form>
                    <a href="{{ route('accreditation_periods.edit', $period->id) }}" class="btn btn-warning btn-sm px-4 fw-bold text-white shadow-sm" style="font-size: 11px;">
                        Edit Period
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