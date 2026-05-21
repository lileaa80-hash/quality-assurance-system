@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 850px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="fas fa-cloud-upload-alt me-2"></i> Upload New File Attachment
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

            <form action="{{ route('file_attachments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-link me-1"></i> TARGET OBJECT RELATION
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">TARGET MODULE TYPE</label>
                            <select name="attachable_type" class="form-select form-select-sm shadow-none" required>
                                <option value="" selected disabled>-- Select Target Module --</option>
                                @foreach($targetTypes as $classPath => $label)
                                    <option value="{{ $classPath }}" {{ old('attachable_type') == $classPath ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">TARGET RECORD ID (ID REFERENSI)</label>
                            <input type="number" name="attachable_id" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., 1, 5, 12" value="{{ old('attachable_id') }}" min="1" required>
                            <div class="form-text" style="font-size: 9px; font-style: italic;">Masukkan ID primary key dari baris modul target yang dipilih.</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-file-import me-1"></i> FILE SELECTION
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">CHOOSE FILE</label>
                            <input type="file" name="file" class="form-control form-control-sm shadow-none" required>
                            <div class="form-text" style="font-size: 9px; font-style: italic;">Batas maksimal ukuran berkas yang diperbolehkan sistem: 20MB.</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-sliders-h me-1"></i> METRICS & CONFIGURATION
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">FILE VERSION (VERSI ARSIP)</label>
                            <input type="number" name="version" class="form-control form-control-sm shadow-none" 
                                   value="{{ old('version', 1) }}" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">STAFF UPLOADER / OFFICER</label>
                            <select name="uploaded_by" class="form-select form-select-sm shadow-none" required>
                                <option value="" selected disabled>-- Select Officer --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('uploaded_by') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-cog me-1"></i> VERSION STATUS CONTROL
                    </h6>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-12">
                            <div class="d-flex gap-4 p-2 rounded" style="background-color: #f8fafc; border: 1px solid #eef2f6;">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" name="is_current" value="1" id="isCurrent" {{ old('is_current', '1') ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark fw-semibold small" for="isCurrent" style="font-size: 11px; cursor: pointer;">
                                        <i class="fas fa-check-circle text-success me-1"></i> Tetapkan sebagai Berkas Utama Aktif (Set as Current Active Version)
                                    </label>
                                </div>
                            </div>
                            <div class="form-text ps-2" style="font-size: 9px; font-style: italic;">Jika dicentang, sistem otomatis akan menonaktifkan status berkas versi lama lainnya pada target objek tersebut.</div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small" style="font-size: 10px;">
                        <i class="fas fa-server me-1"></i> Storage Node Disk Target: <strong class="text-primary">MinIO Cluster</strong>
                    </span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('file_attachments.index') }}" class="btn btn-light btn-sm px-4 fw-bold border text-muted">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">
                            <i class="fas fa-cloud-upload-alt me-1"></i> Upload Attachment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Secure Cloud Storage Management
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
    .card {
        transition: transform 0.2s ease;
    }
    h6 i {
        width: 20px;
    }
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>
@endsection