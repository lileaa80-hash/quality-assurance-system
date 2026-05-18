@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 850px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="fas fa-plus-circle me-2"></i> Create New Workflow Alur Kerja
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

            <form action="{{ route('workflows.store') }}" method="POST">
                @csrf

                {{-- Bagian 1: Identitas Utama Workflow --}}
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-id-card me-1"></i> WORKFLOW IDENTITY
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-muted small mb-1">WORKFLOW NAME</label>
                            <input type="text" name="name" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., Alur Persetujuan Dokumen Standar Mutu" 
                                   value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">WORKFLOW CODE</label>
                            <input type="text" name="code" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., WF-DOC-01" 
                                   value="{{ old('code') }}" required>
                        </div>
                    </div>
                </div>

                {{-- Bagian 2: Tipe & Deskripsi --}}
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-sliders-h me-1"></i> CONFIGURATION & TYPE
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">WORKFLOW TYPE</label>
                            <select name="type" class="form-select form-select-sm shadow-none" required>
                                <option value="" selected disabled>-- Select Workflow Type --</option>
                                <option value="document_approval" {{ old('type') == 'document_approval' ? 'selected' : '' }}>Document Approval (Persetujuan Dokumen)</option>
                                <option value="audit_report_approval" {{ old('type') == 'audit_report_approval' ? 'selected' : '' }}>Audit Report Approval (Laporan Audit)</option>
                                <option value="corrective_action_approval" {{ old('type') == 'corrective_action_approval' ? 'selected' : '' }}>Corrective Action Approval (Tindakan Korektif)</option>
                                <option value="accreditation_approval" {{ old('type') == 'accreditation_approval' ? 'selected' : '' }}>Accreditation Approval (Akreditasi)</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">DESCRIPTION</label>
                            <textarea name="description" class="form-control form-control-sm shadow-none" rows="3" 
                                      placeholder="Type workflow rule overview or notes here..." 
                                      style="resize: none; background-color: #fcfcfc;">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Bagian 3: Aturan Aktivasi Status --}}
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-toggle-on me-1"></i> ACTIVATION RULES
                    </h6>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-12">
                            <div class="d-flex gap-4 p-2 rounded" style="background-color: #f8fafc; border: 1px solid #eef2f6;">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', '1') ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark fw-semibold small" for="isActive" style="font-size: 11px; cursor: pointer;">
                                        Set Active (Otomatis dapat langsung digunakan oleh sistem jika dicentang)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian Footer Form --}}
                <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small" style="font-size: 10px;">
                        <i class="fas fa-user-shield me-1"></i> Authorized: <strong>{{ Auth::user()->name ?? 'Administrator' }}</strong>
                    </span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('workflows.index') }}" class="btn btn-light btn-sm px-4 fw-bold border text-muted">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Save Workflow
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Secure Workflow Configuration Controls
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