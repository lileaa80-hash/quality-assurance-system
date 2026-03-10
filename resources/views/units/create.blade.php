@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary">Create New Unit</h5>
    </div>
    <form action="{{ route('units.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Unit Code</label>
                    <input type="text" name="code" class="form-control" placeholder="TI / MI / SI" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Unit Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter unit name" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Type</label>
                    <select name="type" class="form-select">
                        <option value="prodi">Program Study (Prodi)</option>
                        <option value="fakultas">Faculty</option>
                        <option value="lembaga">Institution</option>
                        <option value="biro">Bureau</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Level</label>
                    <select name="level" class="form-select">
                        <option value="department">Department</option>
                        <option value="faculty">Faculty</option>
                        <option value="university">University</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Parent Unit</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- No Parent --</option>
                        @foreach($parentUnits as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Head Name</label>
                    <input type="text" name="head_name" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Accreditation Status</label>
                    <input type="text" name="accreditation_status" class="form-control" placeholder="A / B / Unggul">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Accreditation Expiry</label>
                    <input type="date" name="accreditation_expiry" class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Is Active?</label>
                    <select name="is_active" class="form-select">
                        <option value="1">Yes, Active</option>
                        <option value="0">No, Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white text-end">
            <a href="{{ route('units.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary px-4">Save Unit</button>
        </div>
    </form>
</div>
@endsection