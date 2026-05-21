@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">File Attachment Details</h5>
            <a href="{{ route('file_attachments.index') }}" class="btn btn-light btn-sm fw-bold px-3" style="font-size: 12px; color: #0d6efd;">BACK TO LIST</a>
        </div>

        <div class="card-body p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="fw-bold text-muted small me-2">STORAGE DISK:</span>
                    <span class="badge bg-secondary text-white px-3 py-2 text-uppercase shadow-sm" style="font-size: 11px; border-radius: 4px; letter-spacing: 0.3px;">
                        {{ $attachment->disk ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="fw-bold text-muted small">CURRENT ACTIVE VERSION:</span>
                    @if(!empty($attachment->is_current))
                        <span class="badge bg-success text-white px-3 py-2 text-uppercase ms-1" style="font-size: 11px; border-radius: 4px;">YES</span>
                    @else
                        <span class="badge bg-light text-secondary border px-3 py-2 text-uppercase ms-1" style="font-size: 11px; border-radius: 4px;">NO</span>
                    @endif
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-8">
                    <div class="p-4 border rounded shadow-sm bg-white h-100">
                        <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Target Object Relation (Polymorphic)</label>
                        <h5 class="fw-bold text-primary mb-2">
                            {{ str_replace('App\\Models\\', '', $attachment->attachable_type ?? 'Unknown Module') }}
                        </h5>
                        <span class="badge bg-light text-primary border text-uppercase" style="font-size: 10px; font-weight: 600; letter-spacing: 0.3px;">
                            Reference ID Instance: #{{ $attachment->attachable_id ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4 border rounded shadow-sm bg-white h-100 d-flex flex-column justify-content-center">
                        <label class="fw-bold text-muted small d-block mb-1 text-uppercase" style="letter-spacing: 0.5px;">File Version</label>
                        <h3 class="fw-bold mb-0 text-dark">v{{ $attachment->version ?? 1 }}</h3>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">
                            Size: {{ isset($attachment->file_size) ? number_format($attachment->file_size / (1024 * 1024), 2) . ' MB' : '-' }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">File Profile Information</label>
                    <div class="p-4 border rounded bg-white shadow-sm" style="border-left: 5px solid #0d6efd !important;">
                        <div class="mb-3">
                            <span class="text-muted d-block small" style="font-size: 10px; font-weight: 700;">ORIGINAL FILENAME</span>
                            <span class="text-dark fw-bold" style="font-size: 15px;"><i class="far fa-file-alt text-primary me-2"></i> {{ $attachment->original_filename ?? 'No filename available.' }}</span>
                        </div>
                        <div class="row g-2 pt-2 border-top">
                            <div class="col-md-6">
                                <span class="text-muted d-block small" style="font-size: 10px; font-weight: 700;">SYSTEM ENCRYPTED FILENAME</span>
                                <code class="text-secondary small" style="font-size: 11px;">{{ $attachment->filename ?? '-' }}</code>
                            </div>
                            <div class="col-md-6">
                                <span class="text-muted d-block small" style="font-size: 10px; font-weight: 700;">MIME TYPE / EXTENSION</span>
                                <span class="text-dark small fw-medium" style="font-size: 11px;">{{ $attachment->mime_type ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="p-3 border rounded bg-light" style="font-size: 11px;">
                        <div class="row text-muted">
                            <div class="col-md-6">
                                <i class="fas fa-user-edit me-1"></i> Uploaded By Officer: <strong class="text-dark">{{ $attachment->uploader_name ?? 'N/A' }}</strong>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <i class="fas fa-clock me-1"></i> Timestamp Record: <strong class="text-dark">{{ isset($attachment->created_at) ? date('d F Y, H:i:s', strtotime($attachment->created_at)) : '-' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="mt-4 mb-4 opacity-50">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small" style="font-size: 10px;">
                    <i class="fas fa-database me-1"></i> Attachment ID Instance: <strong>#{{ $attachment->id ?? '-' }}</strong>
                </span>
                <div class="d-flex gap-2">
                    @if(isset($attachment->id))
                        <form action="{{ route('file_attachments.destroy', $attachment->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus data berkas ini secara permanen dari server storage?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger px-4 fw-bold shadow-sm" style="font-size: 13px;">DELETE</button>
                        </form>
                        <a href="{{ route('file_attachments.edit', $attachment->id) }}" class="btn btn-warning text-white px-4 fw-bold shadow-sm" style="font-size: 13px; background-color: #ffc107; border: none;">
                            EDIT PARAMETER
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Secure Cloud Storage Management
    </div>
</div>
@endsection