@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">ADD NEW APPROVAL TRANSACTION</h6>
        </div>
        
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger py-2 small shadow-sm mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('approvals.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    {{-- Polymorphic: Tipe Model Target --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">TARGET MODEL TYPE (MORPHS)</label>
                        <select name="approvable_type" class="form-select form-select-sm" required>
                            <option value="" selected disabled>-- Select Target Type --</option>
                            @foreach($targetTypes as $classPath => $displayLabel)
                                <option value="{{ $classPath }}" {{ old('approvable_type') == $classPath ? 'selected' : '' }}>
                                    {{ $displayLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Polymorphic: ID Rekor Target --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">TARGET RECORD ID</label>
                        <input type="number" name="approvable_id" class="form-control form-control-sm" 
                               value="{{ old('approvable_id') }}" placeholder="e.g., 1, 5, 12" min="1" required>
                    </div>

                    {{-- Relasi ke Langkah Alur Kerja --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">WORKFLOW STEP</label>
                        <select name="workflow_step_id" class="form-select form-select-sm" required>
                            <option value="" selected disabled>-- Select Step --</option>
                            @foreach($workflowSteps as $step)
                                <option value="{{ $step->id }}" {{ old('workflow_step_id') == $step->id ? 'selected' : '' }}>
                                    {{ $step->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Relasi ke User / Penyetuju --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">ASSIGNED APPROVER</label>
                        <select name="approver_id" class="form-select form-select-sm" required>
                            <option value="" selected disabled>-- Select Approver --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('approver_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status Awal Transaksi --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">INITIAL STATUS</label>
                        <select name="status" class="form-select form-select-sm" required>
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>PENDING (Menunggu Aksi)</option>
                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>APPROVED (Disetujui)</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>REJECTED (Ditolak)</option>
                            <option value="revised" {{ old('status') == 'revised' ? 'selected' : '' }}>REVISED (Butuh Revisi)</option>
                        </select>
                    </div>

                    {{-- Catatan Alasan / Deskripsi --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-dark small mb-1">NOTES / APPROVAL REASON</label>
                        <textarea name="notes" class="form-control form-control-sm" rows="4" 
                                  placeholder="Provide notes or reasons regarding this decision (Optional)...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('approvals.index') }}" class="btn btn-light btn-sm px-4 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm" style="font-size: 11px;">Save Approval Transaction</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Menyamakan style input agar identik dengan Audit Findings */
    .form-control, .form-select {
        border-color: #dee2e6;
        border-radius: 4px;
        padding: 0.5rem 0.75rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: none; /* Menghilangkan shadow biru tebal saat fokus */
    }

    label {
        letter-spacing: 0.5px;
    }
</style>
@endsection