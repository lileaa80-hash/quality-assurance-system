@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 850px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="fas fa-plus-circle me-2"></i> Create New Evaluation Question Item
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

            <form action="{{ route('evaluation_questions.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-link me-1"></i> PARENT QUESTIONNAIRE RELATION
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">SELECT PARENT QUESTIONNAIRE</label>
                            <select name="questionnaire_id" class="form-select form-select-sm shadow-none" required>
                                <option value="" selected disabled>-- Select Questionnaire --</option>
                                @foreach($questionnaires as $q)
                                    <option value="{{ $q->id }}" {{ old('questionnaire_id') == $q->id ? 'selected' : '' }}>
                                        [{{ $q->year }}] {{ $q->title }} ({{ ucwords($q->status) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-pen me-1"></i> QUESTION CONTENT
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">SECTION / CATEGORY</label>
                            <input type="text" name="section" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., Keandalan (Reliability), Tangibles, Layanan Akademik" 
                                   value="{{ old('section') }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">QUESTION TEXT</label>
                            <textarea name="question_text" class="form-control form-control-sm shadow-none" rows="3" 
                                      placeholder="Type your evaluation question description here..." 
                                      style="resize: none; background-color: #fcfcfc;" required>{{ old('question_text') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-sliders-h me-1"></i> METRICS & CONFIGURATION
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">ANSWER TYPE</label>
                            <select name="type" id="questionType" class="form-select form-select-sm shadow-none" required>
                                <option value="" selected disabled>-- Select Type --</option>
                                <option value="likert_5" {{ old('type') == 'likert_5' ? 'selected' : '' }}>Likert Scale (1-5)</option>
                                <option value="likert_4" {{ old('type') == 'likert_4' ? 'selected' : '' }}>Likert Scale (1-4)</option>
                                <option value="multiple_choice" {{ old('type') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="rating" {{ old('type') == 'rating' ? 'selected' : '' }}>Star Rating</option>
                                <option value="essay" {{ old('type') == 'essay' ? 'selected' : '' }}>Essay / Text Open-Ended</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">WEIGHT (BOBOT)</label>
                            <input type="number" name="weight" class="form-control form-control-sm shadow-none" 
                                   value="{{ old('weight', 1) }}" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">ORDER (URUTAN)</label>
                            <input type="number" name="order" class="form-control form-control-sm shadow-none" 
                                   value="{{ old('order', 0) }}" min="0" required>
                        </div>

                        <div class="col-md-12 d-none" id="optionsContainer">
                            <label class="form-label fw-bold text-muted small mb-1">OPTIONS (MULTIPLE CHOICE)</label>
                            <textarea name="options" class="form-control form-control-sm shadow-none" rows="2" 
                                      placeholder="e.g., Sangat Puas, Puas, Cukup, Kurang (Pisahkan dengan koma)" 
                                      style="resize: none; background-color: #fcfcfc;">{{ old('options') }}</textarea>
                            <div class="form-text" style="font-size: 9px; font-style: italic;">Gunakan tanda koma sebagai pemisah antar pilihan jawaban.</div>
                        </div>

                        <div class="col-md-12 d-none" id="scaleLabelsContainer">
                            <label class="form-label fw-bold text-muted small mb-1">CUSTOM SCALE LABELS (JSON FORMAT - OPTIONAL)</label>
                            <input type="text" name="scale_labels" class="form-control form-control-sm shadow-none" 
                                   placeholder='e.g., {"1": "Sangat Buruk", "5": "Sangat Baik"}' value="{{ old('scale_labels') }}">
                            <div class="form-text" style="font-size: 9px; font-style: italic;">Kosongkan jika ingin memakai label bawaan sistem otomatis.</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-cog me-1"></i> REQUIRMENT RULES
                    </h6>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-12">
                            <div class="d-flex gap-4 p-2 rounded" style="background-color: #f8fafc; border: 1px solid #eef2f6;">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" name="is_required" value="1" id="isRequired" {{ old('is_required', '1') ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark fw-semibold small" for="isRequired" style="font-size: 11px; cursor: pointer;">
                                        <i class="fas fa-asterisk text-danger me-1"></i> Wajib Diisi (Mandatory Question Field)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small" style="font-size: 10px;">
                        <i class="fas fa-user-shield me-1"></i> Authorized: <strong>{{ Auth::user()->name ?? 'Administrator' }}</strong>
                    </span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('evaluation_questions.index') }}" class="btn btn-light btn-sm px-4 fw-bold border text-muted">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Save Question Item
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const questionType = document.getElementById('questionType');
        const optionsContainer = document.getElementById('optionsContainer');
        const scaleLabelsContainer = document.getElementById('scaleLabelsContainer');

        function toggleDynamicFields() {
            const val = questionType.value;
            
            // Munculkan input pilihan ganda kalau tipenya multiple_choice
            if (val === 'multiple_choice') {
                optionsContainer.classList.remove('d-none');
            } else {
                optionsContainer.classList.add('d-none');
            }

            // Munculkan input kustom label json kalau tipenya likert atau rating
            if (val.startsWith('likert_') || val === 'rating') {
                scaleLabelsContainer.classList.remove('d-none');
            } else {
                scaleLabelsContainer.classList.add('d-none');
            }
        }

        questionType.addEventListener('change', toggleDynamicFields);
        toggleDynamicFields(); // Trigger di awal pas reload untuk nangkep old input laravel
    });
</script>
@endsection