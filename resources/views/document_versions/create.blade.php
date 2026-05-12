@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 850px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="fas fa-file-upload me-2"></i> Upload New Document Version
            </h6>
        </div>

        <div class="card-body p-4 bg-white">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-4 border-0 d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('document_versions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-search me-1"></i> DOCUMENT SELECTION
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">TARGET DOCUMENT</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 text-muted">
                                    <i class="fas fa-file-alt"></i>
                                </span>
                                <select name="document_id" class="form-select form-select-sm shadow-none border-start-0" style="border-left: none;" required>
                                    <option value="" selected disabled>-- Select Document --</option>
                                    @foreach($documents as $doc)
                                        <option value="{{ $doc->id }}" {{ old('document_id') == $doc->id ? 'selected' : '' }}>
                                            [{{ $doc->document_number }}] {{ $doc->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-text mt-2 text-info d-flex align-items-center" style="font-size: 10px; font-style: italic;">
                                <i class="fas fa-info-circle me-1"></i> System will automatically detect and increment the version number.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-cog me-1"></i> FILE & VERSION DETAILS
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-muted small mb-1">FILE ATTACHMENT (MAX 20MB)</label>
                            <input type="file" name="file" class="form-control form-control-sm shadow-none border-light-subtle" style="background-color: #fcfcfc;" required>
                            <div class="form-text" style="font-size: 9px;">Allowed formats: PDF, DOCX, XLSX (Make sure the file is scanned for viruses)</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">INITIAL STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-none" required>
                                <option value="current" selected>Current (Active)</option>
                                <option value="previous">Previous</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-history me-1"></i> CHANGE LOG
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">CHANGE DESCRIPTION / NOTES</label>
                            <textarea name="change_description" class="form-control form-control-sm shadow-none" rows="4" 
                                      placeholder="Briefly describe what changed in this version..." 
                                      style="resize: none; background-color: #fcfcfc;">{{ old('change_description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small" style="font-size: 10px;">
                        <i class="fas fa-user-shield me-1"></i> Logged in as: <strong>{{ Auth::user()->name ?? 'Uploader' }}</strong>
                    </span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('document_versions.index') }}" class="btn btn-light btn-sm px-4 fw-bold border text-muted">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">
                            <i class="fas fa-cloud-upload-alt me-1"></i> Upload & Process
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Secure Document Upload
    </div>
</div>

<style>
    .form-label {
        letter-spacing: 0.2px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.05) !important;
    }
    .input-group-text {
        font-size: 0.875rem;
    }
    .card {
        transition: transform 0.2s ease;
    }
    h6 i {
        width: 20px;
    }
</style>
@endsection