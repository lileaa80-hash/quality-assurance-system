@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning py-2 text-dark">
            <h6 class="mb-0 fw-bold">Edit Auditor Assignment: {{ $team->user_name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('audit_teams.update', $team->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">AUDIT SCHEDULE</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="{{ $team->audit_number }}" readonly>
                            <small class="text-muted italic">Schedule cannot be changed after assignment.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">ROLE</label>
                            <select name="role" class="form-select form-select-sm" required>
                                <option value="lead_auditor" {{ $team->role == 'lead_auditor' ? 'selected' : '' }}>Lead Auditor</option>
                                <option value="auditor" {{ $team->role == 'auditor' ? 'selected' : '' }}>Auditor</option>
                                <option value="observer" {{ $team->role == 'observer' ? 'selected' : '' }}>Observer</option>
                                <option value="trainee" {{ $team->role == 'trainee' ? 'selected' : '' }}>Trainee</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">REMARKS / NOTES</label>
                            <textarea name="notes" class="form-control form-control-sm" rows="3">{{ $team->notes }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6 border-start">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">ASSIGNED UNITS</label>
                            <div class="p-2 border rounded bg-light" style="max-height: 120px; overflow-y: auto;">
                                @php $saved_units = json_decode($team->assigned_units) ?? []; @endphp
                                @foreach($units as $unit)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="assigned_units[]" value="{{ $unit->id }}" id="unit{{ $unit->id }}"
                                            {{ in_array($unit->id, $saved_units) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="unit{{ $unit->id }}">{{ $unit->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="is_certified" value="1" id="isCert" {{ $team->is_certified ? 'checked' : '' }}>
                            <label class="form-check-label small fw-bold" for="isCert">Is Certified Auditor?</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">CERTIFICATE NUMBER</label>
                            <input type="text" name="certificate_number" class="form-control form-control-sm" value="{{ $team->certificate_number }}">
                        </div>
                    </div>
                </div>

                <div class="text-end border-top pt-3 mt-3">
                    <a href="{{ route('audit_teams.index') }}" class="btn btn-secondary btn-sm rounded-0 px-3">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm rounded-0 px-4 fw-bold">Update Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection