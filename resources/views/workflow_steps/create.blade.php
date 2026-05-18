@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 850px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="fas fa-plus-circle me-2"></i> Create New Workflow Step
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

            <form action="{{ route('workflow_steps.store') }}" method="POST">
                @csrf

                {{-- Bagian 1: Relasi ke Induk Workflow --}}
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-link me-1"></i> PARENT WORKFLOW RELATION
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">SELECT WORKFLOW MASTER</label>
                            <select name="workflow_id" class="form-select form-select-sm shadow-none" required>
                                <option value="" selected disabled>-- Select Workflow --</option>
                                @foreach($workflows as $workflow)
                                    <option value="{{ $workflow->id }}" {{ old('workflow_id') == $workflow->id ? 'selected' : '' }}>
                                        [{{ $workflow->code }}] {{ $workflow->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Bagian 2: Identitas Utama Step --}}
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-route me-1"></i> STEP CONFIGURATION
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-muted small mb-1">STEP NAME</label>
                            <input type="text" name="name" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., Review oleh GPM, Persetujuan Dekan" 
                                   value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">STEP ORDER (URUTAN TAHAPAN)</label>
                            <input type="number" name="step_order" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., 1" value="{{ old('step_order') }}" min="1" required>
                        </div>
                    </div>
                </div>

                {{-- Bagian 3: Otoritas Approver --}}
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-user-check me-1"></i> APPROVER AUTHORITY
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">APPROVER TYPE</label>
                            <select name="approver_type" id="approverType" class="form-select form-select-sm shadow-none" required>
                                <option value="role" {{ old('approver_type', 'role') == 'role' ? 'selected' : '' }}>Role (Peran Sistem)</option>
                                <option value="user" {{ old('approver_type') == 'user' ? 'selected' : '' }}>User (Pengguna Spesifik)</option>
                                <option value="unit_head" {{ old('approver_type') == 'unit_head' ? 'selected' : '' }}>Unit Head (Kepala Unit)</option>
                                <option value="position" {{ old('approver_type') == 'position' ? 'selected' : '' }}>Position (Jabatan Institusi)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1" id="valueLabel">APPROVER VALUE</label>
                            <input type="text" name="approver_value" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., admin, dekan, 12 (ID)" 
                                   value="{{ old('approver_value') }}" required>
                        </div>
                    </div>
                </div>

                {{-- Bagian 4: Parameter & Kondisi --}}
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-clock me-1"></i> METRICS & CONDITIONS
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">TIME LIMIT (BATAS HARI - OPTIONAL)</label>
                            <input type="number" name="time_limit_days" class="form-control form-control-sm shadow-none" 
                                   placeholder="e.g., 3 (Kosongkan jika tidak ada batas)" 
                                   value="{{ old('time_limit_days') }}" min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">CONDITIONS (JSON FORMAT - OPTIONAL)</label>
                            <input type="text" name="conditions" class="form-control form-control-sm shadow-none" 
                                   placeholder='e.g., {"min_score": 75}' value="{{ old('conditions') }}">
                        </div>
                    </div>
                </div>

                {{-- Bagian 5: Aturan Persetujuan --}}
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">
                        <i class="fas fa-cog me-1"></i> REQUIREMENT RULES
                    </h6>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-12">
                            <div class="d-flex gap-4 p-2 rounded" style="background-color: #f8fafc; border: 1px solid #eef2f6;">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" name="requires_approval" value="1" id="requiresApproval" {{ old('requires_approval', '1') ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark fw-semibold small" for="requiresApproval" style="font-size: 11px; cursor: pointer;">
                                        Requires Approval (Memerlukan persetujuan aktif untuk dapat lanjut ke tahap berikutnya)
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
                        <a href="{{ route('workflow_steps.index') }}" class="btn btn-light btn-sm px-4 fw-bold border text-muted">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Save Step Item
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Secure Workflow Step Management
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const approverType = document.getElementById('approverType');
        const valueLabel = document.getElementById('valueLabel');
        const valueInput = document.getElementsByName('approver_value')[0];

        function updateApproverContext() {
            const val = approverType.value;
            if (val === 'role') {
                valueLabel.innerHTML = 'APPROVER VALUE (ROLE SLUG / ROLE ID)';
                valueInput.placeholder = 'e.g., gpm, dekan, admin';
            } else if (val === 'user') {
                valueLabel.innerHTML = 'APPROVER VALUE (USER ID / USERNAME)';
                valueInput.placeholder = 'e.g., 5, bachtiar_gpm';
            } else if (val === 'unit_head') {
                valueLabel.innerHTML = 'APPROVER VALUE (UNIT ID / CODE)';
                valueInput.placeholder = 'e.g., FATIK, Biro_Akademik';
            } else if (val === 'position') {
                valueLabel.innerHTML = 'APPROVER VALUE (POSITION NAME / JABATAN)';
                valueInput.placeholder = 'e.g., Kepala Lembaga, Ketua Jurusan';
            }
        }

        approverType.addEventListener('change', updateApproverContext);
        updateApproverContext(); // Eksekusi sekali saat halaman berhasil dimuat
    });
</script>
@endsection