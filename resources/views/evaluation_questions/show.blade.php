@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 800px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Question Details: #{{ $question->order }}</h6>
            <a href="{{ route('evaluation_questions.index', $question->questionnaire_id) }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">Back to List</a>
        </div>

        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-8">
                    <label class="fw-bold text-muted small d-block">QUESTION TEXT</label>
                    <p class="fw-bold text-primary" style="font-size: 1.1rem;">{{ $question->question_text }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <label class="fw-bold text-muted small d-block">INSTRUMENT TYPE</label>
                    @php
                        $typeBadge = [
                            'likert_5' => 'bg-info',
                            'multiple_choice' => 'bg-primary',
                            'essay' => 'bg-secondary',
                            'rating' => 'bg-warning text-dark'
                        ][$question->type] ?? 'bg-dark';
                    @endphp
                    <span class="badge {{ $typeBadge }} px-3 py-1">
                        {{ strtoupper(str_replace('_', ' ', $question->type)) }}
                    </span>
                </div>
            </div>

            <div class="bg-light p-3 rounded mb-4 border">
                <h6 class="fw-bold small text-muted border-bottom pb-2">TECHNICAL CONFIGURATION</h6>
                <div class="row g-3 mt-1">
                    <div class="col-6 col-md-4">
                        <small class="text-muted d-block">Section / Standard</small>
                        <span class="small fw-semibold">{{ $question->section }}</span>
                    </div>
                    <div class="col-6 col-md-2">
                        <small class="text-muted d-block">Weight</small>
                        <span class="small fw-semibold">{{ $question->weight }}</span>
                    </div>
                    <div class="col-6 col-md-2">
                        <small class="text-muted d-block">Order No</small>
                        <span class="small fw-semibold">#{{ $question->order }}</span>
                    </div>
                    <div class="col-6 col-md-4 text-md-end">
                        <small class="text-muted d-block">Status</small>
                        @if($question->is_required)
                            <span class="badge bg-success-subtle text-success border border-success-subtle small" style="font-size: 10px;">REQUIRED</span>
                        @else
                            <span class="badge bg-light text-muted border small" style="font-size: 10px;">OPTIONAL</span>
                        @endif
                    </div>
                </div>
            </div>

            @if($question->type == 'multiple_choice' && $question->options)
            <div class="mb-4">
                <label class="fw-bold text-muted small d-block mb-2">ANSWER OPTIONS</label>
                <div class="list-group shadow-sm">
                    @foreach($question->options as $index => $option)
                        <div class="list-group-item list-group-item-action d-flex align-items-center py-2">
                            <span class="badge bg-primary-subtle text-primary rounded-circle me-3" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                {{ chr(65 + $index) }}
                            </span>
                            <span class="small text-dark">{{ $option }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                <div class="small text-muted italic">
                    Linked to: <span class="fw-bold">{{ $question->questionnaire_title }}</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('evaluation_questions.edit', $question->id) }}" class="btn btn-warning btn-sm px-3 fw-bold shadow-sm">
                         Edit Question
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection