@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 900px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Edit Audit Finding</h6>
        </div>
        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger py-2 small shadow-sm mb-3 border-0">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('audit_findings.update', $finding->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">FINDING NUMBER</label>
                        <input type="text" name="finding_number" class="form-control form-control-sm shadow-sm" 
                               value="{{ old('finding_number', $finding->finding_number) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">FINDING DATE</label>
                        <input type="date" name="finding_date" class="form-control form-control-sm shadow-sm" 
                               value="{{ old('finding_date', $finding->finding_date) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">AUDIT SCHEDULE</label>
                        <select name="audit_schedule_id" class="form-select form-select-sm shadow-sm" required>
                            @foreach($schedules as $s)
                                <option value="{{ $s->id }}" {{ $finding->audit_schedule_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">UNIT</label>
                        <select name="unit_id" class="form-select form-select-sm shadow-sm" required>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}" {{ $finding->unit_id == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">STATUS</label>
                        <select name="status" class="form-select form-select-sm shadow-sm" required>
                            <option value="open" {{ $finding->status == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ $finding->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="closed" {{ $finding->status == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">CATEGORY</label>
                        <select name="category" class="form-select form-select-sm shadow-sm">
                            <option value="minor" {{ $finding->category == 'minor' ? 'selected' : '' }}>Minor</option>
                            <option value="major" {{ $finding->category == 'major' ? 'selected' : '' }}>Major</option>
                            <option value="observation" {{ $finding->category == 'observation' ? 'selected' : '' }}>Observation</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">FINDING DESCRIPTION</label>
                        <textarea name="finding_description" class="form-control form-control-sm shadow-sm" rows="3" required>{{ old('finding_description', $finding->finding_description) }}</textarea>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('audit_findings.index') }}" class="btn btn-light btn-sm px-3 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm" style="font-size: 11px;">Update Finding</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection