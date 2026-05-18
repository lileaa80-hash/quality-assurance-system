@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Evaluation Question Details</h5>
            <a href="{{ route('evaluation_questions.index') }}" class="btn btn-light btn-sm fw-bold px-3" style="font-size: 12px; color: #0d6efd;">BACK TO LIST</a>
        </div>

        <div class="card-body p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="fw-bold text-muted small me-2">QUESTION TYPE:</span>
                    <span class="badge bg-secondary text-white px-3 py-2 text-uppercase shadow-sm" style="font-size: 11px; border-radius: 4px; letter-spacing: 0.3px;">
                        {{ isset($question->type) ? str_replace('_', ' ', $question->type) : 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="fw-bold text-muted small">REQUIRED FIELD:</span>
                    @if(!empty($question->is_required))
                        <span class="badge bg-danger text-white px-3 py-2 text-uppercase ms-1" style="font-size: 11px; border-radius: 4px;">YES</span>
                    @else
                        <span class="badge bg-light text-secondary border px-3 py-2 text-uppercase ms-1" style="font-size: 11px; border-radius: 4px;">NO</span>
                    @endif
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-8">
                    <div class="p-4 border rounded shadow-sm bg-white h-100">
                        <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Parent Questionnaire Relation</label>
                        {{-- Aman dari crash menggunakan ?? --}}
                        <h5 class="fw-bold text-primary mb-2">{{ $question->questionnaire_title ?? 'Questionnaire Data' }}</h5>
                        <span class="badge bg-light text-primary border text-uppercase" style="font-size: 10px; font-weight: 600; letter-spacing: 0.3px;">
                            Section: {{ $question->section ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4 border rounded shadow-sm bg-white h-100 d-flex flex-column justify-content-center">
                        <label class="fw-bold text-muted small d-block mb-1 text-uppercase" style="letter-spacing: 0.5px;">Question Weight</label>
                        <h3 class="fw-bold mb-0 text-dark">{{ $question->weight ?? 0 }}</h3>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Period: {{ $question->questionnaire_year ?? '-' }}</small>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Question Text Content</label>
                    <div class="p-4 border rounded bg-white shadow-sm" style="min-height: 120px; border-left: 5px solid #0d6efd !important;">
                        <p class="mb-0 text-dark fw-medium" style="white-space: pre-line; line-height: 1.6; font-size: 14px;">
                            {{ $question->question_text ?? 'No question text available.' }}
                            @if(!empty($question->is_required))
                                <span class="text-danger fw-bold" title="Required field">*</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <hr class="mt-5 mb-4 opacity-50">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small" style="font-size: 10px;">
                    <i class="fas fa-database me-1"></i> Question ID Instance: <strong>#{{ $question->id ?? '-' }}</strong>
                </span>
                <div class="d-flex gap-2">
                    @if(isset($question->id))
                        <form action="{{ route('evaluation_questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this question?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger px-4 fw-bold shadow-sm" style="font-size: 13px;">DELETE</button>
                        </form>
                        <a href="{{ route('evaluation_questions.edit', $question->id) }}" class="btn btn-warning text-white px-4 fw-bold shadow-sm" style="font-size: 13px; background-color: #ffc107; border: none;">
                            edit data
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Questionnaire Management Controls
    </div>
</div>
@endsection