@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold">ADD NEW AUDIT FINDING</h6>
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

            <form action="{{ route('audit_findings.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">FINDING NUMBER</label>
                        <input type="text" name="finding_number" class="form-control form-control-sm" value="{{ old('finding_number') }}" placeholder="Enter finding number..." required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">FINDING DATE</label>
                        <input type="date" name="finding_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">AUDIT SCHEDULE</label>
                        <select name="audit_schedule_id" class="form-select form-select-sm" required>
                            <option value="" selected disabled>-- Select Schedule --</option>
                            @foreach($schedules as $s)
                                <option value="{{ $s->id }}" {{ old('audit_schedule_id') == $s->id ? 'selected' : '' }}>{{ $s->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small mb-1">UNIT</label>
                        <select name="unit_id" class="form-select form-select-sm" required>
                            <option value="" selected disabled>-- Select Unit --</option>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold text-dark small mb-1">FINDING DESCRIPTION</label>
                        <textarea name="finding_description" class="form-control form-control-sm" rows="4" placeholder="Describe the findings found during audit..." required>{{ old('finding_description') }}</textarea>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('audit_findings.index') }}" class="btn btn-light btn-sm px-4 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm" style="font-size: 11px;">Save Finding Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Menyamakan style input agar identik dengan Audit Checklist */
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