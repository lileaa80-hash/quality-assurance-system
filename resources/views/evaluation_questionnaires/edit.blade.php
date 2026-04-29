@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-warning py-2">
            <h6 class="mb-0 fw-bold text-dark">Edit Questionnaire: {{ $evaluationQuestionnaire->title }}</h6>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('evaluation.update', $evaluationQuestionnaire->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">GENERAL INFORMATION</h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-muted small mb-1">QUESTIONNAIRE TITLE</label>
                            <input type="text" name="title" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('title', $evaluationQuestionnaire->title) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">TYPE</label>
                            <select name="type" class="form-select form-select-sm shadow-sm" required>
                                @foreach($types as $val => $label)
                                    <option value="{{ $val }}" {{ $evaluationQuestionnaire->type == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">YEAR</label>
                            <input type="number" name="year" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('year', $evaluationQuestionnaire->year) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">SEMESTER</label>
                            <input type="text" name="semester" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('semester', $evaluationQuestionnaire->semester) }}" placeholder="e.g. Ganjil">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-sm" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $evaluationQuestionnaire->status == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">TARGET & PERIOD</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">TARGET AUDIENCE</label>
                            <select name="target_audience" class="form-select form-select-sm shadow-sm">
                                @foreach($audiences as $aud)
                                    <option value="{{ $aud }}" {{ $evaluationQuestionnaire->target_audience == $aud ? 'selected' : '' }}>{{ ucfirst($aud) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">START DATE</label>
                            <input type="date" name="start_date" class="form-control form-control-sm shadow-sm" value="{{ $evaluationQuestionnaire->start_date }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">END DATE</label>
                            <input type="date" name="end_date" class="form-control form-control-sm shadow-sm" value="{{ $evaluationQuestionnaire->end_date }}">
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('evaluation.index') }}" class="btn btn-light btn-sm px-3 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm px-3 fw-bold shadow-sm" style="font-size: 11px;">Update Questionnaire</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection