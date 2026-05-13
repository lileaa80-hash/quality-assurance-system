@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Add New Accreditation Period</h6>
        </div>
        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger py-2 small shadow-sm mb-3 border-0">
                    <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('accreditation_periods.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-info-circle me-1"></i> BASIC INFORMATION
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">PERIOD NAME</label>
                            <input type="text" name="period_name" class="form-control form-control-sm shadow-sm" placeholder="e.g. Akreditasi Prodi RPL 2026" value="{{ old('period_name') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">UNIT / DEPT</label>
                            <select name="unit_id" class="form-select form-select-sm shadow-sm" required>
                                <option value="" selected disabled>-- Select Unit --</option>
                                @foreach($units as $u)
                                    <option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">TYPE</label>
                            <select name="type" class="form-select form-select-sm shadow-sm" required>
                                <option value="initial">Initial</option>
                                <option value="reaccreditation">Reaccreditation</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-sm" required>
                                <option value="planned">Planned</option>
                                <option value="preparation">Preparation</option>
                                <option value="submitted">Submitted</option>
                                <option value="assesment">Assessment</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-calendar-alt me-1"></i> TIMELINE & MILESTONES
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">START DATE</label>
                            <input type="date" name="start_date" class="form-control form-control-sm shadow-sm" value="{{ old('start_date') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">SUBMISSION DEADLINE</label>
                            <input type="date" name="submission_deadline" class="form-control form-control-sm shadow-sm" value="{{ old('submission_deadline') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">ASSESSMENT DATE</label>
                            <input type="date" name="assesment_date" class="form-control form-control-sm shadow-sm" value="{{ old('assesment_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">EXPIRY DATE</label>
                            <input type="date" name="expiry_date" class="form-control form-control-sm shadow-sm" value="{{ old('expiry_date') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-poll-h me-1"></i> PRELIMINARY RESULTS & ASSETS (OPTIONAL)
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">RESULT GRADE</label>
                            <input type="text" name="result_grade" class="form-control form-control-sm shadow-sm" placeholder="e.g. Unggul / A" value="{{ old('result_grade') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">RESULT SCORE</label>
                            <input type="number" name="result_score" class="form-control form-control-sm shadow-sm" placeholder="0-400" value="{{ old('result_score') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">CERTIFICATE NUMBER</label>
                            <input type="text" name="certificate_number" class="form-control form-control-sm shadow-sm" placeholder="Official Cert No." value="{{ old('certificate_number') }}">
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('accreditation_periods.index') }}" class="btn btn-light btn-sm px-4 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm" style="font-size: 11px;">
                        <i class="fas fa-save me-1"></i> Save Period Information
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
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .text-primary {
        color: #0d6efd !important;
    }
</style>
@endsection