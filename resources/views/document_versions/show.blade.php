@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 800px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Version Details: v{{ $version->version_number }}</h6>
            <a href="{{ route('document_versions.index') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">Back to List</a>
        </div>

        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="fw-bold text-muted small d-block">DOCUMENT TITLE</label>
                    <p class="fw-bold text-primary">{{ $version->title }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <label class="fw-bold text-muted small d-block">STATUS</label>
                    <span class="badge {{ $version->status == 'current' ? 'bg-success' : 'bg-warning' }} px-3 py-1">
                        {{ strtoupper($version->status) }}
                    </span>
                </div>
            </div>

            <div class="bg-light p-3 rounded mb-4 border">
                <h6 class="fw-bold small text-muted border-bottom pb-2">FILE INFORMATION</h6>
                <div class="row g-3 mt-1">
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block">File Name</small>
                        <span class="small fw-semibold">{{ $version->file_name }}</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block">Size</small>
                        <span class="small fw-semibold">{{ number_format($version->file_size / 1024, 2) }} KB</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block">Uploader</small>
                        <span class="small fw-semibold">{{ $version->creator_name }}</span>
                    </div>
                    <div class="col-6 col-md-3 text-md-end">
                        <a href="{{ Storage::disk('s3')->url($version->file_path) }}" target="_blank" class="btn btn-primary btn-sm px-3">
                            <i class="bi bi-download"></i> Open/Download
                        </a>
                    </div>
                </div>
            </div>
            <div class="mb-0">
                <label class="fw-bold text-muted small d-block mb-1">CHANGE DESCRIPTION</label>
                <div class="p-3 border rounded bg-white small">
                    {{ $version->change_description ?? 'No description provided for this version.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection