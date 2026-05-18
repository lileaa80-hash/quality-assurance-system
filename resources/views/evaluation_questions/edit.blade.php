@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-warning py-3 px-4">
            <h5 class="mb-0 fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">
                <i class="fas fa-edit me-2"></i> EDIT EVALUATION QUESTION
            </h5>
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

            <form action="{{ route('evaluation_questions.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Relation & Classification</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Parent Questionnaire</label>
                            <select name="evaluation_questionnaires_id" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="" disabled>-- Select Questionnaire --</option>
                                @foreach($questionnaires as $questionnaire)
                                    <option value="{{ $questionnaire->id }}" {{ old('evaluation_questionnaires_id', $question->evaluation_questionnaires_id ?? $question->evaluation_questionnaire_id ?? '') == $questionnaire->id ? 'selected' : '' }}>
                                        [{{ $questionnaire->year }}] {{ $questionnaire->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Question Type</label>
                            <select name="type" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="likert_5" {{ old('type', $question->type) == 'likert_5' ? 'selected' : '' }}>LIKERT 5 OPTIONS</option>
                                <option value="likert_4" {{ old('type', $question->type) == 'likert_4' ? 'selected' : '' }}>LIKERT 4 OPTIONS</option>
                                <option value="open_text" {{ old('type', $question->type) == 'open_text' ? 'selected' : '' }}>OPEN TEXT / ESSAY</option>
                                <option value="boolean" {{ old('type', $question->type) == 'boolean' ? 'selected' : '' }}>YES / NO (BOOLEAN)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Configuration & Weights</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Section / Category</label>
                            <input type="text" name="section" class="form-control shadow-sm border-secondary-subtle" value="{{ old('section', $question->section) }}" placeholder="e.g., Tangible, Reliability, Keandalan" required style="height: 45px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Question Weight</label>
                            <input type="number" name="weight" class="form-control shadow-sm border-secondary-subtle" value="{{ old('weight', $question->weight ?? 1) }}" min="1" required style="height: 45px;">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Question Text & Rules</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Question Text Content</label>
                            <textarea name="question_text" class="form-control shadow-sm border-secondary-subtle" rows="4" placeholder="Enter the evaluation question here..." required>{{ old('question_text', $question->question_text) }}</textarea>
                        </div>
                    </div>

                    <div class="p-3 rounded border bg-light">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_required" value="1" id="editRequired" {{ old('is_required', $question->is_required) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark small" for="editRequired" style="cursor: pointer;">
                                <i class="fas fa-asterisk text-danger me-1 small"></i> Required Field (Wajib Diisi Oleh Responden)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('evaluation_questions.index') }}" class="btn btn-outline-secondary px-4 fw-bold border-2" style="font-size: 13px;">CANCEL</a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold shadow-sm text-dark" style="font-size: 13px;">UPDATE DATA</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection