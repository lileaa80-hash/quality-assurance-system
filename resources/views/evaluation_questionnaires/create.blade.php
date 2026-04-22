@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Add New Evaluation Questionnaire</h6>
        </div>

        <div class="card-body p-4">
            {{-- Alert untuk menampilkan error validasi --}}
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
                        {{-- Title / Name of Questionnaire --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">QUESTIONNAIRE TITLE</label>
                            <input type="text" name="title" class="form-control form-control-sm shadow-sm" 
                                   placeholder="e.g. Survei Kepuasan Mahasiswa 2026" 
                                   value="{{ old('title') }}" required>
                        </div>

                        {{-- Category Selection --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">CATEGORY</label>
                            <select name="category" class="form-select form-select-sm shadow-sm" required>
                                <option value="" selected disabled>-- Select Category --</option>
                                <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>Academic</option>
                                <option value="facility" {{ old('category') == 'facility' ? 'selected' : '' }}>Facility</option>
                                <option value="service" {{ old('category') == 'service' ? 'selected' : '' }}>Service</option>
                            </select>
                        </div>

                        {{-- Status Selection --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-sm" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">TARGET & PERIOD</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">START DATE</label>
                            <input type="date" name="start_date" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('start_date') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">END DATE</label>
                            <input type="date" name="end_date" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('end_date') }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">ADDITIONAL DESCRIPTION</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">DESCRIPTION / INSTRUCTIONS</label>
                            <textarea name="description" class="form-control form-control-sm shadow-sm" rows="4" 
                                      placeholder="Explain the purpose of this questionnaire...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('evaluation_questionnaires.index') }}" class="btn btn-light btn-sm px-3 fw-bold border">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm">Create Questionnaire</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
