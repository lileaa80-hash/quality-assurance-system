@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">Add Question to: {{ $questionnaire->title }}</h6>
            <span class="badge bg-white text-primary small">Step 2: Questions</span>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('evaluation_questions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="questionnaire_id" value="{{ $questionnaire->id }}">

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">BASIC CONFIGURATION</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">SECTION / CATEGORY</label>
                            <input type="text" name="section" class="form-control form-control-sm shadow-sm" placeholder="e.g. Sarana Prasarana" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">QUESTION TYPE</label>
                            <select name="type" id="question_type" class="form-select form-select-sm shadow-sm" required onchange="toggleOptions()">
                                <option value="likert_5">Likert Scale (1-5)</option>
                                <option value="likert_4">Likert Scale (1-4)</option>
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="essay">Essay / Open Text</option>
                                <option value="rating">Star Rating</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small mb-1">QUESTION TEXT</label>
                            <textarea name="question_text" class="form-control form-control-sm shadow-sm" rows="3" placeholder="Enter your question here..." required></textarea>
                        </div>
                    </div>
                </div>

                {{-- Dinamis: Multiple Choice Options --}}
                <div id="multiple_choice_section" class="mb-4 d-none">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">ANSWER OPTIONS (JSON)</h6>
                    <div id="options_container">
                        <div class="input-group input-group-sm mb-2 w-75">
                            <input type="text" name="options[]" class="form-control shadow-sm" placeholder="Option value">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addOption()">+ Add More Option</button>
                </div>

                {{-- Dinamis: Likert Labels --}}
                <div id="likert_section" class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">LIKERT SCALE LABELS (Optional)</h6>
                    <div class="row g-2">
                        <div class="col-md-2">
                            <label class="small text-muted">Value 1</label>
                            <input type="text" name="scale_labels[1]" class="form-control form-control-sm" placeholder="Very Poor">
                        </div>
                        <div class="col-md-2">
                            <label class="small text-muted">Value 5</label>
                            <input type="text" name="scale_labels[5]" class="form-control form-control-sm" placeholder="Excellent">
                        </div>
                    </div>
                    <small class="text-muted italic" style="font-size: 10px;">If empty, standard numeric labels will be used.</small>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">ADVANCED SETTINGS</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">WEIGHT</label>
                            <input type="number" name="weight" class="form-control form-control-sm shadow-sm" value="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">DISPLAY ORDER</label>
                            <input type="number" name="order" class="form-control form-control-sm shadow-sm" value="0">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="is_required" id="is_required" value="1" checked>
                                <label class="form-check-label fw-bold text-muted small" for="is_required">Mandatory Question</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('evaluation_questions.index', $questionnaire->id) }}" class="btn btn-light btn-sm px-3 fw-bold border">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm">Save & Add Another</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleOptions() {
        const type = document.getElementById('question_type').value;
        const mcSection = document.getElementById('multiple_choice_section');
        const likertSection = document.getElementById('likert_section');

        if (type === 'multiple_choice') {
            mcSection.classList.remove('d-none');
        } else {
            mcSection.classList.add('d-none');
        }
        if (type.startsWith('likert')) {
            likertSection.classList.remove('d-none');
        } else {
            likertSection.classList.add('d-none');
        }
    }

    function addOption() {
        const container = document.getElementById('options_container');
        const div = document.createElement('div');
        div.className = 'input-group input-group-sm mb-2 w-75';
        div.innerHTML = `
            <input type="text" name="options[]" class="form-control shadow-sm" placeholder="Option value">
            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>
        `;
        container.appendChild(div);
    }
</script>
@endsection