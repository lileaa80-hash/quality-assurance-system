@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold">Edit Unit / Department</h5>
        <a href="{{ route('units.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
    </div>
    <form action="{{ route('units.update', $unit->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Unit Code</label>
                    <input type="text" name="code" class="form-control" value="{{ $unit->code }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Unit Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $unit->name }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Type</label>
                    <select name="type" class="form-select">
                        <option value="prodi" {{ $unit->type == 'prodi' ? 'selected' : '' }}>PRODI</option>
                        <option value="fakultas" {{ $unit->type == 'fakultas' ? 'selected' : '' }}>FAKULTAS</option>
                        <option value="lembaga" {{ $unit->type == 'lembaga' ? 'selected' : '' }}>LEMBAGA</option>
                        <option value="biro" {{ $unit->type == 'biro' ? 'selected' : '' }}>BIRO</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Level</label>
                    <select name="level" class="form-select" required>
                        <option value="university" {{ $unit->level == 'university' ? 'selected' : '' }}>University</option>
                        <option value="faculty" {{ $unit->level == 'faculty' ? 'selected' : '' }}>Faculty</option>
                        <option value="department" {{ $unit->level == 'department' ? 'selected' : '' }}>Department</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Head Name</label>
                    <input type="text" name="head_name" class="form-control" value="{{ $unit->head_name }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ $unit->is_active == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $unit->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <button type="submit" class="btn btn-warning text-white btn-sm px-4 shadow-sm">Update Unit</button>
        </div>
    </form>
</div>
@endsection