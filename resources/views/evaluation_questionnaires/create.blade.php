@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 850px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="fas fa-file-medical me-2"></i> Create New Evaluation Questionnaire
            </h6>
        </div>
        
        <div class="card-body p-4 bg-white">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-4 border-0 d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('evaluation_questionnaires.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-heading me-1"></i> BASIC INFORMATION
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">QUESTIONNAIRE TITLE</label>
                            <input type="text" name="title" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., Kuesioner Kepuasan Mahasiswa Terhadap Layanan Akademik" 
                                   value="{{ old('title') }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">DESCRIPTION / INSTRUCTIONS</label>
                            <textarea name="description" class="form-control form-control-sm shadow-none" rows="3" 
                                      placeholder="Provide brief instructions or descriptions for respondents..." 
                                      style="resize: none; background-color: #fcfcfc;">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-sliders-h me-1"></i> CLASSIFICATION & PERIOD
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">EVALUATION TYPE</label>
                            <select name="type" class="form-select form-select-sm shadow-none" required>
                                <option value="" selected disabled>-- Select Type --</option>
                                <option value="student_satisfaction" {{ old('type') == 'student_satisfaction' ? 'selected' : '' }}>Student Satisfaction</option>
                                <option value="lecturer_performance" {{ old('type') == 'lecturer_performance' ? 'selected' : '' }}>Lecturer Performance</option>
                                <option value="alumni_tracer" {{ old('type') == 'alumni_tracer' ? 'selected' : '' }}>Alumni Tracer</option>
                                <option value="stakeholder_satisfaction" {{ old('type') == 'stakeholder_satisfaction' ? 'selected' : '' }}>Stakeholder Satisfaction</option>
                                <option value="self_evaluation" {{ old('type') == 'self_evaluation' ? 'selected' : '' }}>Self Evaluation</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">YEAR</label>
                            <input type="number" name="year" class="form-control form-control-sm shadow-none" 
                                   value="{{ old('year', date('Y')) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">SEMESTER</label>
                            <input type="text" name="semester" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., Ganjil" value="{{ old('semester') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">START DATE</label>
                            <input type="date" name="start_date" class="form-control form-control-sm shadow-none" 
                                   value="{{ old('start_date') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">END DATE</label>
                            <input type="date" name="end_date" class="form-control form-control-sm shadow-none" 
                                   value="{{ old('end_date') }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-users me-1"></i> TARGET AUDIENCE
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">AUDIENCE GROUP</label>
                            <select name="target_audience" class="form-select form-select-sm shadow-none" required>
                                <option value="" selected disabled>-- Select Target --</option>
                                <option value="students" {{ old('target_audience') == 'students' ? 'selected' : '' }}>Students</option>
                                <option value="lectures" {{ old('target_audience') == 'lecturers' ? 'selected' : '' }}>Lecturers</option>
                                <option value="staff" {{ old('target_audience') == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="alumni" {{ old('target_audience') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                                <option value="stakeholders" {{ old('target_audience') == 'stakeholders' ? 'selected' : '' }}>Stakeholders</option>
                                <option value="all" {{ old('target_audience') == 'all' ? 'selected' : '' }}>All</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-muted small mb-1">SPECIFIC UNITS</label>
                            <input type="text" name="target_units" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., TI, Elektro, Mesin (Separate with commas)" value="{{ old('target_units') }}">
                            <div class="form-text" style="font-size: 9px; font-style: italic;">Leave blank if the questionnaire targets all units.</div>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-cog me-1"></i> SETTINGS & EXTRA FILE
                    </h6>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">INITIAL STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-none" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-muted small mb-1">ATTACHMENT REPORT FILE (OPTIONAL - MAX 10MB)</label>
                            <input type="file" name="report_file" class="form-control form-control-sm shadow-none border-light-subtle" style="background-color: #fcfcfc;">
                            <div class="form-text" style="font-size: 9px;">Allowed formats: PDF, DOCX, XLSX (Will be securely saved into MinIO Storage)</div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="d-flex gap-4 p-2 rounded" style="background-color: #f8fafc; border: 1px solid #eef2f6;">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" name="is_anonymous" value="1" id="isAnonymous" {{ old('is_anonymous', '1') ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark fw-semibold small" for="isAnonymous" style="font-size: 11px; cursor: pointer;">
                                        <i class="fas fa-user-secret text-success me-1"></i> Anonymous Response
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" name="allow_multiple_submissions" value="1" id="allowMultiple" {{ old('allow_multiple_submissions') ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark fw-semibold small" for="allowMultiple" style="font-size: 11px; cursor: pointer;">
                                        <i class="fas fa-redo text-warning me-1"></i> Allow Multiple Submissions
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small" style="font-size: 10px;">
                        <i class="fas fa-user-shield me-1"></i> Creator: <strong>{{ Auth::user()->name ?? 'Administrator' }}</strong>
                    </span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('evaluation_questionnaires.index') }}" class="btn btn-light btn-sm px-4 fw-bold border text-muted">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Save Questionnaire
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Secure Questionnaire Management
    </div>
</div>

<style>
    .form-label {
        letter-spacing: 0.2px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.05) !important;
    }
    .card {
        transition: transform 0.2s ease;
    }
    h6 i {
        width: 20px;
    }
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>
@endsection