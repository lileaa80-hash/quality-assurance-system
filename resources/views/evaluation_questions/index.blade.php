@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('evaluation_questionnaires.index') }}" class="btn btn-sm btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <div>
            <h5 class="mb-0 fw-bold">{{ $questionnaire->title }}</h5>
            <small class="text-muted">Manage questions for this evaluation</small>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h6 class="mb-0 fw-bold text-primary">List of Questions</h6>
            <a href="{{ route('evaluation_questions.create', ['questionnaire_id' => $questionnaire->id]) }}" class="btn btn-primary btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                + Add Question
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 12px;">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold" style="width: 5%;">#</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 15%;">SECTION</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 40%;">QUESTION TEXT</th>
                            <th class="py-3 text-muted small fw-bold text-center">TYPE</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $index => $q)
                        <tr class="align-middle">
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $q->section }}</span></td>
                            <td class="fw-medium">{{ $q->question_text }}</td>
                            <td class="text-center">
                                <span class="badge bg-info text-white" style="font-size: 9px;">
                                    {{ strtoupper(str_replace('_', ' ', $q->type)) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('evaluation_questions.edit', $q->id) }}" class="btn btn-warning btn-xs text-white px-2 py-0" style="font-size: 10px;">Edit</a>
                                    <form action="{{ route('evaluation_questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Delete this question?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs px-2 py-0" style="font-size: 10px;">Del</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No questions added yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection