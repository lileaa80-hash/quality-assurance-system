@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Evaluation Questions</h5>
            <a href="{{ route('evaluation_questions.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add New Question
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="px-4 py-3 border-0" style="width: 25%;">Parent Questionnaire</th>
                            <th class="py-3 border-0" style="width: 15%;">Section / Category</th>
                            <th class="py-3 border-0">Question Text</th>
                            <th class="py-3 border-0 text-center">Type</th>
                            <th class="py-3 border-0 text-center">Weight</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($questions as $question)
                        <tr>
                            <td class="px-4">
                                <div class="fw-bold text-primary">[{{ $question->questionnaire_year }}]</div>
                                <div class="text-muted text-truncate mt-1" style="font-size: 10px; max-width: 230px;" title="{{ $question->questionnaire_title }}">
                                    {{ $question->questionnaire_title }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border text-uppercase px-2 py-1" style="font-size: 9px; font-weight: 500;">
                                    {{ $question->section }}
                                </span>
                            </td>
                            <td class="fw-medium text-dark">
                                {{ $question->question_text }}
                                @if($question->is_required)
                                    <span class="text-danger" title="Required field">*</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="text-uppercase text-secondary fw-semibold" style="font-size: 11px;">
                                    {{ str_replace('_', ' ', $question->type) }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary text-white px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px;">
                                    {{ $question->weight }}
                                </span>
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('evaluation_questions.show', $question->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('evaluation_questions.edit', $question->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('evaluation_questions.destroy', $question->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this question?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-white px-2 py-1" style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No evaluation questions found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($questions, 'links') && $questions->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-center">
                    {{ $questions->links() }}
                </div>
            </div>
            @else
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing 1 to {{ count($questions) }} of {{ count($questions) }} records</small>
            </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Questionnaire Management Controls
    </div>
</div>
@endsection