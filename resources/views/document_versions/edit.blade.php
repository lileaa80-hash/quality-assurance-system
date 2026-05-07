@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 700px; margin: auto;">
        <div class="card-header bg-warning text-white py-2">
            <h6 class="mb-0 fw-bold text-dark">Update Version Info: {{ $version->file_name }}</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('document_versions.update', $version->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">VERSION STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-sm" required>
                                <option value="current" {{ $version->status == 'current' ? 'selected' : '' }}>Current (Active)</option>
                                <option value="previous" {{ $version->status == 'previous' ? 'selected' : '' }}>Previous</option>
                                <option value="archived" {{ $version->status == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-bold text-muted small mb-1">REVISE DESCRIPTION</label>
                    <textarea name="change_description" class="form-control form-control-sm shadow-sm" rows="4">{{ old('change_description', $version->change_description) }}</textarea>
                </div>
                
                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('document_versions.index') }}" class="btn btn-light btn-sm px-3 fw-bold border">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm px-3 fw-bold shadow-sm text-dark">Update Metadata</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection