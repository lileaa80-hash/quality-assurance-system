@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto;">
        <div class="card-header bg-warning text-white py-3 px-4">
            <h5 class="mb-0 fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">EDIT VERSION: {{ $version->file_name }}</h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('document_versions.update', $version->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Version & Status Details</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Version Status</label>
                            <select name="status" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="current" {{ $version->status == 'current' ? 'selected' : '' }}>CURRENT (ACTIVE)</option>
                                <option value="previous" {{ $version->status == 'previous' ? 'selected' : '' }}>PREVIOUS</option>
                                <option value="archived" {{ $version->status == 'archived' ? 'selected' : '' }}>ARCHIVED</option>
                            </select>
                            <div class="form-text mt-2 small text-muted">Update status dokumen untuk menentukan visibilitas pengguna.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Version Number</label>
                            <input type="text" class="form-control bg-light" value="v{{ $version->version_number }}" readonly style="height: 45px;">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Analysis & Description</h6>
                    <hr class="mt-0 mb-4 opacity-25">

                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Revise Description</label>
                            <textarea name="change_description" class="form-control shadow-sm border-secondary-subtle" rows="5" placeholder="Enter changes description here...">{{ old('change_description', $version->change_description) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('document_versions.index') }}" class="btn btn-outline-secondary px-4 fw-bold border-2" style="font-size: 13px;">CANCEL</a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold shadow-sm text-dark" style="font-size: 13px;">UPDATE METADATA</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection