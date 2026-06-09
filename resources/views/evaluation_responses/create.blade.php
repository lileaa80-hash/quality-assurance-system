@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 850px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="fas fa-plus-circle me-2"></i> Create New Evaluation Response Payload
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
            <form action="{{ route('evaluation_responses.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-link me-1"></i> TARGET OBJECT SYSTEM RELATIONAL
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">SELECT TARGET QUESTIONNAIRE *</label>
                            <select name="questionnaire_id" class="form-select form-select-sm shadow-none" required>
                                <option value="" selected disabled>-- Select Questionnaire Cluster --</option>
                                @foreach($questionnaires as $q)
                                    <option value="{{ $q->id }}" {{ old('questionnaire_id') == $q->id ? 'selected' : '' }}>
                                        [{{ $q->year ?? '' }}] {{ $q->title ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">SELECT MOUNTED INSTRUMENT QUESTION *</label>
                            <select name="question_id" id="questionSelect" class="form-select form-select-sm shadow-none" required>
                                <option value="" selected disabled>-- Select Bound Question Item --</option>
                                @foreach($questions as $question)
                                    <option value="{{ $question->id }}" data-type="{{ $question->type ?? 'unknown' }}" {{ old('question_id') == $question->id ? 'selected' : '' }}>
                                        [{{ strtoupper($question->type ?? 'UNKNOWN') }}] {{ Str::limit($question->question_text ?? '', 60) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-user-tag me-1"></i> RESPONDENT DEMOGRAPHY SECTOR
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">AUTHENTICATED SYSTEM USER ACCOUNT (OPTIONAL)</label>
                            <select name="respondent_id" class="form-select form-select-sm shadow-none">
                                <option value="">-- Set as Anonymous Guest Response --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('respondent_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name ?? '' }} {{ isset($user->email) ? '('.$user->email.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">RESPONDENT SUB-TYPE IDENTIFIER *</label>
                            <input type="text" name="respondent_type" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., Mahasiswa, Dosen, Tenaga Kependidikan, Alumni" 
                                   value="{{ old('respondent_type') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">WORKING UNIT / DEPT BRANCH</label>
                            <input type="text" name="respondent_unit" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., Program Studi Teknik Informatika, Biro Penjaminan Mutu" 
                                   value="{{ old('respondent_unit') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">TRACKING EMAIL ROUTE</label>
                            <input type="email" name="respondent_email" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., respondent.identity@spmi.ac.id" 
                                   value="{{ old('respondent_email') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-database me-1"></i> RESPONDENT REALIZATION PAYLOAD DATA
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4" id="metricValueContainer">
                            <label class="form-label fw-bold text-muted small mb-1">METRIC SCORE VALUE</label>
                            <input type="number" name="answer_value" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., Rentang Nilai 1 s/d 5" value="{{ old('answer_value') }}">
                        </div>

                        <div class="col-md-8" id="textOptionsContainer">
                            <label class="form-label fw-bold text-muted small mb-1">SELECTED MULTIPLE CHOICE VALUE STRING</label>
                            <input type="text" name="answer_options" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., Sangat Puas, Cepat, Sesuai Standar" value="{{ old('answer_options') }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">DESCRIPTIVE NARRATIVE TEXT ANSWER (OPEN-ENDED ESSAY)</label>
                            <textarea name="answer" class="form-control form-control-sm shadow-none" rows="4" 
                                      placeholder="Tulis ringkasan feedback narasi / argumen evaluasi komprehensif disini..." 
                                      style="resize: none; background-color: #fcfcfc;">{{ old('answer') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small" style="font-size: 10px;">
                        <i class="fas fa-user-shield me-1"></i> Authorized Officer: <strong>{{ Auth::user()->name ?? 'Administrator' }}</strong>
                    </span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('evaluation_responses.index') }}" class="btn btn-light btn-sm px-4 fw-bold border text-muted">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Save Response Item
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Secure Question Management
    </div>
</div>

<style>
    .form-label { letter-spacing: 0.2px; }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.05) !important;
    }
    .card { transition: transform 0.2s ease; }
    h6 i { width: 20px; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const questionSelect = document.getElementById('questionSelect');
        const metricValueContainer = document.getElementById('metricValueContainer');
        const textOptionsContainer = document.getElementById('textOptionsContainer');

        function adjustResponseFields() {
            const selectedOption = questionSelect.options[questionSelect.selectedIndex];
            if (!selectedOption) return;

            const type = selectedOption.getAttribute('data-type');

            if (type === 'essay') {
                metricValueContainer.classList.add('d-none');
                textOptionsContainer.classList.add('d-none');
            } else if (type === 'multiple_choice') {
                metricValueContainer.classList.add('d-none');
                textOptionsContainer.classList.remove('d-none');
            } else if (type && (type.startsWith('likert_') || type === 'rating')) {
                metricValueContainer.classList.remove('d-none');
                textOptionsContainer.classList.add('d-none');
            } else {
                metricValueContainer.classList.remove('d-none');
                textOptionsContainer.classList.remove('d-none');
            }
        }

        questionSelect.addEventListener('change', adjustResponseFields);
        adjustResponseFields(); // Init step
    });
</script>
@endsection