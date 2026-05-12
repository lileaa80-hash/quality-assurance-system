@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">VERSION DETAILS: v{{ $version->version_number }}</h5>
            <a href="{{ route('document_versions.index') }}" class="btn btn-light btn-sm fw-bold px-3" style="font-size: 12px; color: #0d6efd;">BACK TO LIST</a>
        </div>

        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="fw-bold text-muted small me-2">CURRENT STATUS:</span>
                    <span class="badge {{ $version->status == 'current' ? 'bg-success' : 'bg-warning' }} text-white px-3 py-2" style="font-size: 11px;">
                        {{ strtoupper($version->status) }}
                    </span>
                </div>
                <div>
                    <span class="fw-bold text-muted small">INDICATOR:</span>
                    <span class="fw-bold text-primary ms-1">N/A</span>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="p-4 border rounded shadow-sm bg-white h-100">
                        <label class="fw-bold text-muted small d-block mb-2 text-uppercase">Document Title</label>
                        <h4 class="fw-bold text-primary mb-1">{{ $version->title }}</h4>
                        <p class="text-muted mb-0">Version: {{ $version->version_number }}</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4 border rounded shadow-sm bg-white h-100 d-flex flex-column justify-content-center">
                        <label class="fw-bold text-muted small d-block mb-1 text-uppercase">File Size</label>
                        <h3 class="fw-bold mb-0">{{ number_format($version->file_size / 1024, 2) }}</h3>
                        <small class="text-muted fw-bold">KB</small>
                    </div>
                </div>
            </div>

            <div class="bg-light p-4 rounded mb-4 border">
                <h6 class="fw-bold small text-muted border-bottom pb-2 mb-3 text-uppercase" style="letter-spacing: 1px;">File Information</h6>
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <small class="text-muted d-block text-uppercase mb-1" style="font-size: 10px;">File Name</small>
                        <span class="fw-bold text-dark">{{ $version->file_name }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block text-uppercase mb-1" style="font-size: 10px;">Uploader</small>
                        <span class="fw-bold text-dark">{{ $version->creator_name }}</span>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ Storage::disk('s3')->url($version->file_path) }}" target="_blank" class="btn btn-primary fw-bold px-4 shadow-sm">
                            Open/Download
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase">Change Description</label>
                    <div class="p-4 border rounded bg-white shadow-sm" style="min-height: 120px; border-left: 5px solid #0d6efd !important;">
                        <p class="mb-0 text-dark">{{ $version->change_description ?? 'No description provided for this version.' }}</p>
                    </div>
                </div>
            </div>

            <hr class="mt-5 mb-4 opacity-50">
            <div class="d-flex justify-content-end gap-2 mb-2">
                <form action="{{ route('document_versions.destroy', $version->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger px-4 fw-bold shadow-sm" style="font-size: 13px;">DELETE</button>
                </form>
                
                <a href="{{ route('document_versions.edit', $version->id) }}" class="btn btn-warning text-white px-4 fw-bold shadow-sm" style="font-size: 13px; background-color: #ffc107; border: none;">
                    EDIT DATA
                </a>
            </div>
        </div>
    </div>
</div>
@endsection