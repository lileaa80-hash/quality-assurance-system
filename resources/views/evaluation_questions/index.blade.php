@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 mb-4" style="max-width: 1000px; margin: auto;">
        <div class="card-body p-3 bg-light rounded shadow-sm border">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-bold text-uppercase d-block mb-1">MANAGING QUESTIONS FOR:</span>
                    <h5 class="fw-bold text-primary mb-0">{{ $questionnaire->title }}</h5>
                    <div class="mt-1">
                        <span class="badge bg-white text-primary border border-primary px-2 py-1" style="font-size: 10px;">
                            {{ strtoupper($questionnaire->type) }}
                        </span>
                        <span class="text-muted small ms-2">{{ $questionnaire->year }} - {{ $questionnaire->semester }}</span>
                    </div>
                </div>
                <a href="{{ route('evaluation_questionnaires.index') }}" class="btn btn-outline-secondary btn-sm fw-bold" style="font-size: 11px;">
                    <i class="fas fa-arrow-left me-1"></i> Back to Questionnaires
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Question List</h6>
            <a href="{{ route('evaluation_questions.create', ['questionnaire_id' => $questionnaire->id]) }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                + Add New Question
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 12px;">
                    <thead class="bg-white">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold text-center" style="width: 5%;">ORD</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 20%;">SECTION</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 45%;">QUESTION TEXT</th>
                            <th class="py-3 text-muted small fw-bold text-center">TYPE</th>
                            <th class="py-3 text-muted small fw-bold text-center">REQ</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $q)
                        <tr class="align-middle">
                            <td class="ps-1 text-center fw-bold text-muted">{{ $q->order }}</td>
                            <td>
                                <span class="badge bg-info text-white px-2 py-1" style="font-size: 9px; border-radius: 4px;">
                                    {{ strtoupper($q->section) }}
                                </span>
                            </td>
                            <td>
                                <div class="text-dark fw-semibold" style="line-height: 1.4;">{{ $q->question_text }}</div>
                                @if($q->weight > 1)
                                    <small class="text-muted" style="font-size: 9px;">Weight: {{ $q->weight }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <code class="small text-primary fw-bold">{{ $q->type_label }}</code>
                            </td>
                            <td class="text-center">
                                @if($q->is_required)
                                    <i class="fas fa-check-circle text-success"></i>
                                @else
                                    <i class="fas fa-minus-circle text-muted"></i>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('evaluation_questions.edit', $q->id) }}" class="btn btn-warning btn-xs text-white px-2 py-0" style="font-size: 10px;">Edit</a>
                                    
                                    <form action="{{ route('evaluation_questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Delete this question?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs px-2 py-0" style="font-size: 10px;">Del</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted" style="font-size: 11px;">
                                <i class="fas fa-question-circle mb-2 d-block fa-2x"></i>
                                No questions added to this questionnaire yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-xs {
        padding: 1px 5px;
        line-height: 1.5;
        border-radius: 3px;
    }
</style>
@endsection