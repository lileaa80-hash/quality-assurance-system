@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 750px; margin: auto;">
        <div class="card-header bg-warning text-white py-2">
            <h6 class="mb-0 fw-bold text-dark">Update Question Info: #{{ $question->order }}</h6>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('evaluation_questions.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <h6 class="text-dark fw-bold small border-bottom pb-2 mb-3">CORE INFORMATION</h6>
                    <div class="row g-3">

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">SECTION / CATEGORY</label>
                            <input type="text" name="section" class="form-control form-control-sm shadow-sm" value="{{ old('section', $question->section) }}" required>
                        </div>

                        {{-- Question Text Update --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">QUESTION TEXT</label>
                            <textarea name="question_text" class="form-control form-control-sm shadow-sm" rows="3" required>{{ old('question_text', $question->question_text) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-dark fw-bold small border-bottom pb-2 mb-3">INSTRUMENT CONFIGURATION</h6>
                    <div class="row g-3">
                        {{-- Type Selection --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">RESPONSE TYPE</label>
                            <select name="type" class="form-select form-select-sm shadow-sm" required>
                                <option value="likert_5" {{ $question->type == 'likert_5' ? 'selected' : '' }}>Likert Scale (1 - 5)</option>
                                <option value="likert_4" {{ $question->type == 'likert_4' ? 'selected' : '' }}>Likert Scale (1 - 4)</option>
                                <option value="multiple_choice" {{ $question->type == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="essay" {{ $question->type == 'essay' ? 'selected' : '' }}>Essay / Open Ended</option>
                            </select>
                        </div>

                        {{-- Order Update --}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">ORDER</label>
                            <input type="number" name="order" class="form-control form-control-sm shadow-sm" value="{{ old('order', $question->order) }}">
                        </div>

                        {{-- Weight Update --}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">WEIGHT</label>
                            <input type="number" name="weight" class="form-control form-control-sm shadow-sm" value="{{ old('weight', $question->weight) }}">
                        </div>
                    </div>
                </div>

                @if($question->type == 'multiple_choice')
                <div class="mb-2">
                    <h6 class="text-dark fw-bold small border-bottom pb-2 mb-3">OPTIONS DATA</h6>
                    <label class="form-label fw-bold text-muted small mb-1">RAW JSON OPTIONS / LIST</label>
                    <textarea name="options" class="form-control form-control-sm shadow-sm font-monospace" rows="3">{{ is_array($question->options) ? implode("\n", $question->options) : $question->options }}</textarea>
                    <div class="form-text mt-1" style="font-size: 10px;">Careful: Changing the format might affect existing responses.</div>
                </div>
                @endif

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    @php
                        // Mencari ID kuesioner untuk tombol cancel
                        $qId = DB::table('evaluation_questions')->where('id', $question->id)->value('questionnaire_id');
                    @endphp
                    <a href="{{ route('evaluation_questions.index', $qId) }}" class="btn btn-light btn-sm px-3 fw-bold border">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm px-3 fw-bold shadow-sm text-dark">Update Question</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection