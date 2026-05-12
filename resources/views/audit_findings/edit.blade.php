@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-warning text-dark py-3 px-4">
            <h6 class="mb-0 fw-bold">EDIT AUDIT FINDING</h6>
        </div>

        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger py-2 small shadow-sm mb-4 border-0">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('audit_findings.update', $finding->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">FINDING NUMBER</label>
                        <input type="text" name="finding_number" class="form-control form-control-sm bg-white" 
                               value="{{ old('finding_number', $finding->finding_number) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">FINDING DATE</label>
                        <input type="date" name="finding_date" class="form-control form-control-sm bg-white" 
                               value="{{ old('finding_date', $finding->finding_date) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">AUDIT SCHEDULE</label>
                        <select name="audit_schedule_id" class="form-select form-select-sm bg-white" required>
                            @foreach($schedules as $s)
                                <option value="{{ $s->id }}" {{ $finding->audit_schedule_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">UNIT</label>
                        <select name="unit_id" class="form-select form-select-sm bg-white" required>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}" {{ $finding->unit_id == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">STATUS</label>
                        <select name="status" class="form-select form-select-sm bg-white" required>
                            <option value="open" {{ $finding->status == 'open' ? 'selected' : '' }}>OPEN</option>
                            <option value="in_progress" {{ $finding->status == 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                            <option value="closed" {{ $finding->status == 'closed' ? 'selected' : '' }}>CLOSED</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">CATEGORY</label>
                        <select name="category" class="form-select form-select-sm bg-white">
                            <option value="minor" {{ $finding->category == 'minor' ? 'selected' : '' }}>MINOR</option>
                            <option value="major" {{ $finding->category == 'major' ? 'selected' : '' }}>MAJOR</option>
                            <option value="observation" {{ $finding->category == 'observation' ? 'selected' : '' }}>OBSERVATION</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <hr class="my-2 opacity-25">
                        <label class="form-label fw-bold text-dark small mb-1">FINDING DESCRIPTION</label>
                        <textarea name="finding_description" class="form-control form-control-sm bg-white" rows="4" required>{{ old('finding_description', $finding->finding_description) }}</textarea>
                    </div>
                </div>

                <div class="mt-5 d-flex justify-content-end gap-2">
                    <a href="{{ route('audit_findings.index') }}" class="btn btn-secondary btn-sm px-4 fw-bold" style="font-size: 12px; border-radius: 6px;">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-warning btn-sm px-4 fw-bold shadow-sm" style="font-size: 12px; border-radius: 6px;">
                        Update Finding
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-5 text-muted small">
        © 2026 SPMI Digital System - RPL
    </div>
</div>

<style>
    /* Styling input agar flat dan bersih sesuai screenshot 1190 & 1192 */
    .form-control, .form-select {
        border: 1px solid #dee2e6 !important;
        border-radius: 6px !important;
        padding: 0.6rem 0.75rem !important;
        box-shadow: none !important;
    }

    .form-control:focus, .form-select:focus {
        border-color: #ffc107 !important; /* Warna kuning saat fokus */
    }

    label {
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }
    
    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: #212529;
    }
</style>
@endsection