@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <div class="d-flex align-items-center">
                <h6 class="mb-0 fw-bold">Questions List: {{ $questionnaire->title }}</h6>
            </div>
            <a href="{{ route('evaluation_questions.create', $questionnaire->id) }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                + Add New Question
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
                            <th class="ps-4 py-3 text-muted small fw-bold" style="width: 5%;">NO</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 45%;">QUESTION TEXT & SECTION</th>
                            <th class="py-3 text-muted small fw-bold text-center">TYPE</th>
                            <th class="py-3 text-muted small fw-bold text-center">WEIGHT</th>
                            <th class="py-3 text-muted small fw-bold text-center">REQUIRED</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $index => $item)
                        <tr class="align-middle">
                            <td class="ps-4 text-center">
                                <span class="text-muted fw-bold">{{ $item->order ?? $index + 1 }}</span>
                            </td>
                            
                            <td>
                                <div class="fw-bold text-primary">{{ Str::limit($item->question_text, 80) }}</div>
                                <div class="text-muted" style="font-size: 9px;">
                                    <i class="bi bi-tag"></i> Section: {{ $item->section }}
                                </div>
                            </td>

                            <td class="text-center">
                                @php
                                    $typeColor = [
                                        'likert_5' => 'bg-info text-white',
                                        'multiple_choice' => 'bg-purple text-white',
                                        'essay' => 'bg-secondary text-white',
                                        'rating' => 'bg-warning text-dark'
                                    ][$item->type] ?? 'bg-light text-dark border';
                                @endphp
                                <span class="badge {{ $typeColor }} px-2 py-1" style="font-size: 9px; border-radius: 4px;">
                                    {{ strtoupper(str_replace('_', ' ', $item->type)) }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="fw-semibold">{{ $item->weight }}</div>
                            </td>

                            <td class="text-center">
                                @if($item->is_required)
                                    <span class="text-success small" style="font-size: 10px;"><i class="bi bi-check-circle-fill"></i> Yes</span>
                                @else
                                    <span class="text-muted small" style="font-size: 10px;">Optional</span>
                                @endif
                            </td>

                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('evaluation_questions.show', $item->id) }}" class="btn btn-info btn-xs text-white px-2 py-0" style="font-size: 10px;">View</a>
                                    <a href="{{ route('evaluation_questions.edit', $item->id) }}" class="btn btn-warning btn-xs text-white px-2 py-0" style="font-size: 10px;">Edit</a>
                                    <form action="{{ route('evaluation_questions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')">
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
                                No questions found for this questionnaire.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - Internal Quality Assurance
    </div>
</div>

<style
    .btn-xs {
        padding: 1px 5px;
        font-size: 10px;
        line-height: 1.5;
        border-radius: 3px;
    }
    .bg-purple {
        background-color: #6f42c1;
    }
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }
    .badge {
        font-weight: 600;
        letter-spacing: 0.3px;
    }
</style>
@endsection