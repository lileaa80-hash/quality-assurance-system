@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-warning py-3 px-4">
            <h5 class="mb-0 fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">
                <i class="fas fa-edit me-2"></i> EDIT QUESTIONNAIRE: {{ Str::limit($questionnaire->title, 50) }}
            </h5>
        </div>

        <div class="card-body p-4 bg-white">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-4 border-0 d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('evaluation_questionnaires.update', $questionnaire->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Status & Classification</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Questionnaire Status</label>
                            <select name="status" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="draft" {{ old('status', $questionnaire->status) == 'draft' ? 'selected' : '' }}>DRAFT</option>
                                <option value="active" {{ old('status', $questionnaire->status) == 'active' ? 'selected' : '' }}>ACTIVE</option>
                                <option value="closed" {{ old('status', $questionnaire->status) == 'closed' ? 'selected' : '' }}>CLOSED</option>
                                <option value="archived" {{ old('status', $questionnaire->status) == 'archived' ? 'selected' : '' }}>ARCHIVED</option>
                            </select>
                            <div class="form-text mt-2 small text-muted">Perubahan status menentukan apakah responden bisa mengisi kuesioner.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Evaluation Type</label>
                            <select name="type" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="student_satisfaction" {{ old('type', $questionnaire->type) == 'student_satisfaction' ? 'selected' : '' }}>STUDENT SATISFACTION</option>
                                <option value="lecturer_performance" {{ old('type', $questionnaire->type) == 'lecturer_performance' ? 'selected' : '' }}>LECTURER PERFORMANCE</option>
                                <option value="alumni_tracer" {{ old('type', $questionnaire->type) == 'alumni_tracer' ? 'selected' : '' }}>ALUMNI TRACER</option>
                                <option value="stakeholder_satisfaction" {{ old('type', $questionnaire->type) == 'stakeholder_satisfaction' ? 'selected' : '' }}>STAKEHOLDER SATISFACTION</option>
                                <option value="self_evaluation" {{ old('type', $questionnaire->type) == 'self_evaluation' ? 'selected' : '' }}>SELF EVALUATION</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Basic Info & Target</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Questionnaire Title</label>
                            <input type="text" name="title" class="form-control shadow-sm border-secondary-subtle" value="{{ old('title', $questionnaire->title) }}" required style="height: 45px;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Target Audience</label>
                            <select name="target_audience" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="students" {{ old('target_audience', $questionnaire->target_audience) == 'students' ? 'selected' : '' }}>STUDENTS</option>
                                <option value="lecturers" {{ old('target_audience', $questionnaire->target_audience) == 'lecturers' ? 'selected' : '' }}>LECTURERS</option>
                                <option value="staff" {{ old('target_audience', $questionnaire->target_audience) == 'staff' ? 'selected' : '' }}>STAFF</option>
                                <option value="alumni" {{ old('target_audience', $questionnaire->target_audience) == 'alumni' ? 'selected' : '' }}>ALUMNI</option>
                                <option value="stakeholders" {{ old('target_audience', $questionnaire->target_audience) == 'stakeholders' ? 'selected' : '' }}>STAKEHOLDERS</option>
                                <option value="all" {{ old('target_audience', $questionnaire->target_audience) == 'all' ? 'selected' : '' }}>ALL</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Target Units Bound</label>
                            @php
                                // Konversi kembali string json ke comma separated text untuk mempermudah edit input
                                $unitsArray = json_decode($questionnaire->target_units, true) ?? [];
                                $unitsString = implode(', ', $unitsArray);
                            @endphp
                            <input type="text" name="target_units" class="form-control shadow-sm border-secondary-subtle" 
                                   value="{{ old('target_units', $unitsString) }}" placeholder="e.g., TI, Elektro, Mesin" style="height: 45px;">
                            <div class="form-text mt-1 text-muted" style="font-size: 10px;">Pisahkan dengan koma jika menargetkan unit kerja tertentu.</div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Timeline & Feature Rules</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4 mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Year</label>
                            <input type="number" name="year" class="form-control shadow-sm border-secondary-subtle" value="{{ old('year', $questionnaire->year) }}" required style="height: 45px;">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Semester</label>
                            <input type="text" name="semester" class="form-control shadow-sm border-secondary-subtle" value="{{ old('semester', $questionnaire->semester) }}" placeholder="e.g., Ganjil" style="height: 45px;">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Start Date</label>
                            <input type="date" name="start_date" class="form-control shadow-sm border-secondary-subtle" value="{{ old('start_date', $questionnaire->start_date) }}" required style="height: 45px;">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">End Date</label>
                            <input type="date" name="end_date" class="form-control shadow-sm border-secondary-subtle" value="{{ old('end_date', $questionnaire->end_date) }}" required style="height: 45px;">
                        </div>
                    </div>
                    
                    <div class="p-3 rounded border bg-light d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_anonymous" value="1" id="editAnonymous" {{ old('is_anonymous', $questionnaire->is_anonymous) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark small" for="editAnonymous" style="cursor: pointer;">
                                <i class="fas fa-user-secret text-success me-1"></i> Anonymous Response
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allow_multiple_submissions" value="1" id="editMultiple" {{ old('allow_multiple_submissions', $questionnaire->allow_multiple_submissions) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark small" for="editMultiple" style="cursor: pointer;">
                                <i class="fas fa-redo text-warning me-1"></i> Allow Multiple Submissions
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Analysis File & Description</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Update Attachment Report File (Optional)</label>
                            <input type="file" name="report_file" class="form-control shadow-sm border-secondary-subtle" style="background-color: #fcfcfc;">
                            @if($questionnaire->report_file)
                                <div class="form-text text-info d-flex align-items-center" style="font-size: 11px;">
                                    <i class="fas fa-paperclip me-1"></i> Current File: <span class="fw-bold text-break ms-1">{{ $questionnaire->report_file }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Description / Instructions</label>
                            <textarea name="description" class="form-control shadow-sm border-secondary-subtle" rows="5" placeholder="Enter instructions or summary details here...">{{ old('description', $questionnaire->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('evaluation_questionnaires.index') }}" class="btn btn-outline-secondary px-4 fw-bold border-2" style="font-size: 13px;">CANCEL</a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold shadow-sm text-dark" style="font-size: 13px;">UPDATE METADATA</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection