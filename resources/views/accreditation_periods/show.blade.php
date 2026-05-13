@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Accreditation Period Details</h6>
            <a href="{{ route('accreditation_periods.index') }}" class="btn btn-light btn-sm fw-bold border shadow-sm px-3" style="font-size: 11px;">
                <i class="fas fa-arrow-left me-1"></i> BACK TO LIST
            </a>
        </div>
        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center px-4">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small fw-bold text-uppercase">Status:</span>
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
                    <span class="badge {{ $statusBadge }} px-3 py-2 text-uppercase" style="font-size: 10px; border-radius: 4px; min-width: 100px;">
                        {{ str_replace('_', ' ', $period->status) }}
                    </span>

                    <span class="text-muted small fw-bold text-uppercase ms-2">Type:</span>
                    <span class="badge bg-white text-primary border border-primary px-3 py-2 text-uppercase" style="font-size: 10px; border-radius: 4px;">
                        {{ $period->type }}
                    </span>
                </div>
                <div class="text-muted small">
                    <strong>Period:</strong> <span class="text-primary fw-bold">{{ $period->period_name }}</span>
                </div>
            </div>

            <div class="p-4 px-5">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1 text-uppercase">Unit / Department</label>
                        <p class="fw-bold border-start border-primary border-3 ps-2 text-dark fs-5">{{ $period->unit_name }}</p>
                    </div>

                    <div class="col-md-6 text-md-end">
                        <label class="text-muted small fw-bold d-block mb-1 text-uppercase">Certificate Number</label>
                        <p class="fw-semibold text-dark fs-6">
                            <i class="fas fa-certificate text-warning me-1"></i>
                            {{ $period->certificate_number ?: 'Not Yet Available' }}
                        </p>
                    </div>

                    <div class="col-12">
                        <div class="bg-white p-3 rounded border shadow-sm">
                            <h6 class="text-primary fw-bold small mb-3 border-bottom pb-2">
                                <i class="far fa-calendar-alt me-2"></i>TIMELINE MILESTONES
                            </h6>
                            <div class="row text-center">
                                <div class="col-md-3 border-end">
                                    <label class="text-muted d-block fw-bold" style="font-size: 10px;">START DATE</label>
                                    <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($period->start_date)->format('d M Y') }}</span>
                                </div>
                                <div class="col-md-3 border-end">
                                    <label class="text-muted d-block fw-bold" style="font-size: 10px;">SUBMISSION DEADLINE</label>
                                    <span class="fw-bold text-danger">{{ $period->submission_deadline ? \Carbon\Carbon::parse($period->submission_deadline)->format('d M Y') : '-' }}</span>
                                </div>
                                <div class="col-md-3 border-end">
                                    <label class="text-muted d-block fw-bold" style="font-size: 10px;">ASSESSMENT DATE</label>
                                    <span class="fw-bold text-primary">{{ $period->assesment_date ? \Carbon\Carbon::parse($period->assesment_date)->format('d M Y') : '-' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted d-block fw-bold" style="font-size: 10px;">EXPIRY DATE</label>
                                    <span class="fw-bold text-dark">{{ $period->expiry_date ? \Carbon\Carbon::parse($period->expiry_date)->format('d M Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <label class="text-muted small fw-bold d-block mb-1 text-uppercase">Final Grade & Score</label>
                        <div class="p-3 bg-white rounded border shadow-sm border-start border-success border-4">
                            @if($period->result_grade)
                                <div class="d-flex align-items-center gap-3">
                                    <h2 class="mb-0 text-success fw-bold">{{ $period->result_grade }}</h2>
                                    <div class="vr mx-2"></div>
                                    <div>
                                        <div class="text-muted small fw-bold text-uppercase">Official Score</div>
                                        <div class="fw-bold fs-5 text-dark">{{ $period->result_score ?? '0' }} <small class="text-muted">/ 400</small></div>
                                    </div>
                                </div>
                                @if($period->result_date)
                                    <div class="mt-2 text-muted italic" style="font-size: 11px;">
                                        <i class="fas fa-bullhorn me-1"></i> Announced on: {{ \Carbon\Carbon::parse($period->result_date)->format('d F Y') }}
                                    </div>
                                @endif
                            @else
                                <p class="mb-0 text-muted italic p-2" style="font-size: 13px;">
                                    <i class="fas fa-spinner fa-spin me-2"></i>Waiting for final assessment results...
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label class="text-muted small fw-bold d-block mb-1 text-uppercase">External Assessors</label>
                        <div class="p-3 bg-white rounded border shadow-sm" style="min-height: 102px;">
                            @if($period->assessors)
                                <ul class="list-unstyled mb-0" style="font-size: 12px;">
                                    @php $assessors = json_decode($period->assessors, true); @endphp
                                    @foreach($assessors as $assessor)
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-user-tie me-2 text-primary"></i> 
                                            <span class="fw-semibold text-dark">{{ $assessor }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mb-0 text-muted small italic text-center py-3">No assessors assigned yet.</p>
                            @endif
                        </div>
                    </div>

                    @if($period->certificate_file)
                    <div class="col-12">
                        <div class="alert alert-primary border-0 shadow-sm d-flex align-items-center justify-content-between px-4 py-3 mb-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf fa-2x me-3 text-danger"></i>
                                <div>
                                    <div class="fw-bold">Digital Accreditation Certificate</div>
                                    <div class="small opacity-75">Click the button to download the official document.</div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary fw-bold px-4 shadow-sm">
                                <i class="fas fa-download me-1"></i> DOWNLOAD
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <form action="{{ route('accreditation_periods.destroy', $period->id) }}" method="POST" onsubmit="return confirm('Delete this record permanently?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-4 fw-bold" style="font-size: 11px;">
                            <i class="fas fa-trash-alt me-1"></i> DELETE PERIOD
                        </button>
                    </form>
                    <a href="{{ route('accreditation_periods.edit', $period->id) }}" class="btn btn-warning btn-sm px-4 fw-bold text-white shadow-sm" style="font-size: 11px;">
                        <i class="fas fa-edit me-1"></i> EDIT INFORMATION
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
    .vr {
        width: 1px;
        background-color: #dee2e6;
        height: 40px;
    }
    .card-header h6 {
        letter-spacing: 1px;
    }
</style>
@endsection