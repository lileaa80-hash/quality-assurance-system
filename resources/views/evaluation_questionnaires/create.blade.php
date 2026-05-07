@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Add New Evaluation Questionnaire</h6>
        </div>
        <div class="card-body p-4">
            {{-- Bagian Error --}}
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
                            {{-- PENTING: name harus 'type' --}}
                            <select name="type" class="form-select form-select-sm" required>
                                <option value="" selected disabled>-- Select Type --</option>
                                <option value="academic" {{ old('type') == 'academic' ? 'selected' : '' }}>Academic</option>
                                <option value="facility" {{ old('type') == 'facility' ? 'selected' : '' }}>Facility</option>
                                <option value="service" {{ old('type') == 'service' ? 'selected' : '' }}>Service</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">STATUS</label>
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="draft">Draft</option>
                                <option value="active">Active</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">TARGET & PERIOD</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">YEAR</label>
                            {{-- PENTING: name harus 'year' --}}
                            <input type="number" name="year" class="form-control form-control-sm" value="{{ old('year', 2026) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">SEMESTER</label>
                            <select name="semester" class="form-select form-select-sm" required>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">TARGET AUDIENCE</label>
                            {{-- PENTING: name harus 'target_audience' --}}
                            <select name="target_audience" class="form-select form-select-sm" required>
                                <option value="" selected disabled>-- Select Target --</option>
                                <option value="student">Student</option>
                                <option value="lecturer">Lecturer</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">START DATE</label>
                            <input type="date" name="start_date" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">END DATE</label>
                            <input type="date" name="end_date" class="form-control form-control-sm" required>
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