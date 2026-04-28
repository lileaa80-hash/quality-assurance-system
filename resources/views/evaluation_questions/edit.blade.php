@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-warning py-2 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-dark">Edit Question ID: #{{ $question->id }}</h6>
            <span class="text-dark small fw-bold">{{ $questionnaire->title }}</span>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('evaluation_questions.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">QUESTION CONFIGURATION</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">SECTION / CATEGORY</label>
                            <input type="text" name="section" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('section', $question->section) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">QUESTION TYPE</label>
                            <select name="type" id="question_type" class="form-select form-select-sm shadow-sm" required onchange="toggleOptions()">
                                @foreach(['likert_5' => 'Likert Scale (1-5)', 'likert_4' => 'Likert Scale (1-4)', 'multiple_choice' => 'Multiple Choice', 'essay' => 'Essay / Open Text', 'rating' => 'Star Rating'] as $val => $label)
                                    <option value="{{ $val }}" {{ $question->type == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small mb-1">QUESTION TEXT</label>
                            <textarea name="question_text" class="form-control form-control-sm shadow-sm" rows="3" required>{{ old('question_text', $question->question_text) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Dinamis: Multiple Choice Options --}}
                <div id="multiple_choice_section" class="mb-4 {{ $question->type == 'multiple_choice' ? '' : 'd-none' }}">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">ANSWER OPTIONS</h6>
                    <div id="options_container">
                        @if($question->options)
                            @foreach($question->options as $option)
                            <div class="input-group input-group-sm mb-2 w-75">
                                <input type="text" name="options[]" class="form-control shadow-sm" value="{{ $option }}">
                                <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>
                            </div>
                            @endforeach
                        @else
                            <div class="input-group input-group-sm mb-2 w-75">
                                <input type="text" name="options[]" class="form-control shadow-sm" placeholder="Option value">
                                <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">-</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addOption()">+ Add More Option</button>
                </div>

                {{-- Dinamis: Likert Labels --}}
                <div id="likert_section" class="mb-4 {{ str_contains($question->type, 'likert') ? '' : 'd-none' }}">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">SCALE LABELS (CUSTOM)</h6>
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="small text-muted">Label for Min Value (1)</label>
                            <input type="text" name="scale_labels[1]" class="form-control form-control-sm" 
                                   value="{{ $question->scale_labels[1] ?? '' }}" placeholder="e.g. Sangat Tidak Puas">
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted">Label for Max Value</label>
                            <input type="text" name="scale_labels[max]" class="form-control form-control-sm" 
                                   value="{{ $question->scale_labels['max'] ?? '' }}" placeholder="e.g. Sangat Puas">
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">SETTINGS</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">WEIGHT</label>
                            <input type="number" name="weight" class="form-control form-control-sm shadow-sm" value="{{ $question->weight }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">ORDER</label>
                            <input type="number" name="order" class="form-control form-control-sm shadow-sm" value="{{ $question->order }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="is_required" id="is_required" value="1" {{ $question->is_required ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-muted small" for="is_required">Required Question</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('evaluation_questionnaires.show', $question->questionnaire_id) }}" class="btn btn-light btn-sm px-3 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm px-3 fw-bold shadow-sm" style="font-size: 11px;">Update Question</button>
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

        if (type.includes('likert')) {
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