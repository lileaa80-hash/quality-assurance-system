@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <div>
                <h6 class="mb-0 fw-bold">Evaluation Questions</h6>
                <small style="font-size: 10px;">Questionnaire: {{ $questionnaire->title }}</small>
            </div>
            <a href="{{ route('evaluation_questions.create', ['questionnaire_id' => $questionnaire->id]) }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                + Add Question
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm" style="background-color: #d4edda;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 12px;">
                    <thead class="bg-white">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold" style="width: 5%;">ORD</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 20%;">SECTION</th>
                            <th class="py-3 text-muted small fw-bold">QUESTION TEXT</th>
                            <th class="py-3 text-muted small fw-bold text-center">TYPE</th>
                            <th class="py-3 text-muted small fw-bold text-center">WEIGHT</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $item)
                        <tr class="align-middle">
                            <td class="ps-4 text-muted fw-bold">{{ $item->order }}</td>
                            <td>
                                <span class="badge bg-light text-primary border px-2 py-1" style="font-size: 10px;">
                                    {{ strtoupper($item->section) }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ Str::limit($item->question_text, 80) }}</div>
                                @if($item->is_required)
                                    <span class="text-danger" style="font-size: 9px;">* Required</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="text-muted" style="font-size: 11px;">
                                    <i class="bi bi-list-check"></i> {{ str_replace('_', ' ', $item->type) }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary text-white px-2 py-1" style="font-size: 10px;">
                                    w: {{ $item->weight }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('evaluation_questions.show', $item->id) }}" class="btn btn-info btn-xs text-white px-2 py-0">View</a>
                                    <a href="{{ route('evaluation_questions.edit', $item->id) }}" class="btn btn-warning btn-xs text-white px-2 py-0">Edit</a>
                                    <form action="{{ route('evaluation_questions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this question?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs px-2 py-0">Del</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted" style="font-size: 11px;">
                                No questions found for this questionnaire.
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
        font-size: 10px;
        line-height: 1.5;
        border-radius: 3px;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endsection