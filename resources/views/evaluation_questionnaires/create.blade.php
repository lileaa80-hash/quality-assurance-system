@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Add New Evaluation Questionnaire</h6>
        </div>
        <div class="card-body p-4">
            
            {{-- Menampilkan Pesan Error Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-3 border-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('evaluation_questionnaires.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">QUESTIONNAIRE INFORMATION</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">QUESTIONNAIRE TITLE</label>
                            <input type="text" name="title" class="form-control form-control-sm" value="{{ old('title') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">CATEGORY / TYPE</label>
                            <select name="type" class="form-select form-select-sm" required>
                                <option value="" selected disabled>-- Select Type --</option>
                                {{-- Value di bawah ini HARUS SAMA dengan Controller --}}
                                <option value="student_satisfaction" {{ old('type') == 'student_satisfaction' ? 'selected' : '' }}>Student Satisfaction</option>
                                <option value="lecturer_performance" {{ old('type') == 'lecturer_performance' ? 'selected' : '' }}>Lecturer Performance</option>
                                <option value="alumni_tracer" {{ old('type') == 'alumni_tracer' ? 'selected' : '' }}>Alumni Tracer</option>
                                <option value="stakeholder_satisfaction" {{ old('type') == 'stakeholder_satisfaction' ? 'selected' : '' }}>Stakeholder Satisfaction</option>
                                <option value="self_evaluation" {{ old('type') == 'self_evaluation' ? 'selected' : '' }}>Self Evaluation</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">STATUS</label>
                            <select name="status" class="form-select form-select-sm" required>
                                {{-- Value harus huruf kecil: draft, active, closed, archived --}}
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">TARGET & PERIOD</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">YEAR</label>
                            <input type="number" name="year" class="form-control form-control-sm" value="{{ old('year', 2026) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">SEMESTER</label>
                            <select name="semester" class="form-select form-select-sm" required>
                                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">TARGET AUDIENCE</label>
                            <select name="target_audience" class="form-select form-select-sm" required>
                                <option value="" selected disabled>-- Select Target --</option>
                                {{-- Value HARUS SAMA dengan Controller (pakai 's' di akhir) --}}
                                <option value="students" {{ old('target_audience') == 'students' ? 'selected' : '' }}>Students</option>
                                <option value="lecturers" {{ old('target_audience') == 'lecturers' ? 'selected' : '' }}>Lecturers</option>
                                <option value="staff" {{ old('target_audience') == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="alumni" {{ old('target_audience') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                                <option value="stakeholders" {{ old('target_audience') == 'stakeholders' ? 'selected' : '' }}>Stakeholders</option>
                                <option value="all" {{ old('target_audience') == 'all' ? 'selected' : '' }}>All Users</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">START DATE</label>
                            <input type="date" name="start_date" class="form-control form-control-sm" value="{{ old('start_date') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">END DATE</label>
                            <input type="date" name="end_date" class="form-control form-control-sm" value="{{ old('end_date') }}" required>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('evaluation_questionnaires.index') }}" class="btn btn-light btn-sm border">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm">Create Questionnaire</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection