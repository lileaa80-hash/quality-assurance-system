@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Create New Unit</h5>
        </div>
        
        <form action="{{ route('units.store') }}" method="POST">
            @csrf
            <div class="card-body p-4">
                
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Unit Code</label>
                        <input type="text" name="code" class="form-control" placeholder="TI / MI / SI" value="{{ old('code') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Unit Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter unit name" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Type</label>
                        <select name="type" class="form-select">
                            <option value="prodi" {{ old('type') == 'prodi' ? 'selected' : '' }}>Program Study (Prodi)</option>
                            <option value="fakultas" {{ old('type') == 'fakultas' ? 'selected' : '' }}>Faculty</option>
                            <option value="lembaga" {{ old('type') == 'lembaga' ? 'selected' : '' }}>Institution</option>
                            <option value="biro" {{ old('type') == 'biro' ? 'selected' : '' }}>Bureau</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Level</label>
                        <select name="level" class="form-select">
                            <option value="department" {{ old('level') == 'department' ? 'selected' : '' }}>Department</option>
                            <option value="faculty" {{ old('level') == 'faculty' ? 'selected' : '' }}>Faculty</option>
                            <option value="university" {{ old('level') == 'university' ? 'selected' : '' }}>University</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Parent Unit</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- No Parent --</option>
                            @foreach($parentUnits as $p)
                                <option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Head Name</label>
                        <input type="text" name="head_name" class="form-control" placeholder="Enter name" value="{{ old('head_name') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Accreditation Status</label>
                        <input type="text" name="accreditation_status" class="form-control" placeholder="A / B / Unggul" value="{{ old('accreditation_status') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Accreditation Expiry</label>
                        <input type="date" name="accreditation_expiry" class="form-control" value="{{ old('accreditation_expiry') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Is Active?</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Yes, Active</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>No, Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('units.index') }}" class="btn btn-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Save Unit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection