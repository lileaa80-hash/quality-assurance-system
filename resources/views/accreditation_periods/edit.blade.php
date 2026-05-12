@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-warning py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">
                <i class="fas fa-edit me-2"></i> Edit Accreditation Period
            </h6>
            <span class="badge bg-dark text-white px-3 py-2" style="font-size: 10px;">ID: #{{ $period->id }}</span>
        </div>

        <div class="card-body p-4 px-5">
            @if(session('error'))
                <div class="alert alert-danger py-2 small shadow-sm mb-4 border-0">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('accreditation_periods.update', $period->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3 text-uppercase">
                        <i class="fas fa-info-circle me-1"></i> Basic Information
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">PERIOD NAME</label>
                            <input type="text" name="period_name" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('period_name', $period->period_name) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">UNIT / DEPT</label>
                            <select name="unit_id" class="form-select form-select-sm shadow-sm" required>
                                @foreach($units as $u)
                                    <option value="{{ $u->id }}" {{ $period->unit_id == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">TYPE</label>
                            <select name="type" class="form-select form-select-sm shadow-sm" required>
                                @foreach(['initial', 'reaccreditation', 'maintenance'] as $type)
                                    <option value="{{ $type }}" {{ $period->type == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">CURRENT STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-sm border-warning" required>
                                @foreach(['planned', 'preparation', 'submitted', 'assesment', 'waiting_result', 'completed', 'postponed'] as $status)
                                    <option value="{{ $status }}" {{ $period->status == $status ? 'selected' : '' }}>
                                        {{ strtoupper(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3 text-uppercase">
                        <i class="fas fa-calendar-alt me-1"></i> Timeline & Milestones
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">START DATE</label>
                            <input type="date" name="start_date" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('start_date', $period->start_date) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">SUBMISSION DEADLINE</label>
                            <input type="date" name="submission_deadline" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('submission_deadline', $period->submission_deadline) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">ASSESSMENT DATE</label>
                            <input type="date" name="assesment_date" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('assesment_date', $period->assesment_date) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">EXPIRY DATE</label>
                            <input type="date" name="expiry_date" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('expiry_date', $period->expiry_date) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3 text-uppercase">
                        <i class="fas fa-trophy me-1"></i> Final Results & Certification
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">RESULT GRADE</label>
                            <input type="text" name="result_grade" class="form-control form-control-sm shadow-sm border-success" 
                                   placeholder="e.g. Unggul / A" value="{{ old('result_grade', $period->result_grade) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">RESULT SCORE</label>
                            <input type="number" name="result_score" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('result_score', $period->result_score) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">CERTIFICATE NUMBER</label>
                            <input type="text" name="certificate_number" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('certificate_number', $period->certificate_number) }}">
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('accreditation_periods.index') }}" class="btn btn-light btn-sm px-4 fw-bold border text-muted" style="font-size: 11px;">
                        CANCEL
                    </a>
                    <button type="submit" class="btn btn-warning btn-sm px-4 fw-bold shadow-sm" style="font-size: 11px;">
                        <i class="fas fa-sync-alt me-1"></i> UPDATE PERIOD DATA
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>

<style>
    .form-control-sm:focus, .form-select-sm:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
    }
    .text-primary { color: #0d6efd !important; }
</style>
@endsection