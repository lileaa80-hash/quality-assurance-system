@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark py-3">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Edit Unit / Department</h5>
        </div>
        
        <form action="{{ route('units.update', $unit->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Unit Code</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $unit->code) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Unit Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $unit->name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Type</label>
                        <select name="type" class="form-select">
                            <option value="prodi" {{ $unit->type == 'prodi' ? 'selected' : '' }}>Program Study (Prodi)</option>
                            <option value="fakultas" {{ $unit->type == 'fakultas' ? 'selected' : '' }}>Faculty</option>
                            <option value="lembaga" {{ $unit->type == 'lembaga' ? 'selected' : '' }}>Institution</option>
                            <option value="biro" {{ $unit->type == 'biro' ? 'selected' : '' }}>Bureau</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Level</label>
                        <select name="level" class="form-select" required>
                            <option value="university" {{ $unit->level == 'university' ? 'selected' : '' }}>University</option>
                            <option value="faculty" {{ $unit->level == 'faculty' ? 'selected' : '' }}>Faculty</option>
                            <option value="department" {{ $unit->level == 'department' ? 'selected' : '' }}>Department</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Head Name</label>
                        <input type="text" name="head_name" class="form-control" value="{{ old('head_name', $unit->head_name) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ $unit->is_active == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $unit->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Accreditation Status</label>
                        <input type="text" name="accreditation_status" class="form-control" value="{{ old('accreditation_status', $unit->accreditation_status) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Accreditation Expiry</label>
                        <input type="date" name="accreditation_expiry" class="form-control" value="{{ old('accreditation_expiry', $unit->accreditation_expiry) }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('units.index') }}" class="btn btn-light border px-4">Cancel</a>
                    <button type="submit" class="btn btn-warning text-dark fw-bold px-4 shadow-sm">
                        Update Unit
                    </button>
                </div>
            </div>
        </form>

        <div class="card-footer bg-light py-2 text-center text-muted small border-0">
            © 2026 SPMI Digital System - RPL
        </div>
    </div>
</div>
@endsection