@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-warning py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-dark text-uppercase">SPMI SYSTEM - EDIT AUDITOR ASSIGNMENT</h6>
            <span class="badge bg-dark px-3 py-2">AUDIT: {{ $team->audit_number }}</span>
        </div>
        
        <div class="card-body p-4">
            <h4 class="mb-4 fw-bold">Modify Assignment for: <span class="text-primary">{{ $team->user_name ?? 'Auditor' }}</span></h4>
            <form action="{{ route('audit_teams.update', $team->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Audit Schedule (Read Only)</label>
                            <input type="text" class="form-control bg-light border-1 fw-bold py-2" value="{{ $team->audit_number }}" readonly>
                            <small class="text-muted italic">Schedule cannot be changed after assignment.</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Auditor Role</label>
                            <select name="role" class="form-select py-2">
                                <option value="lead_auditor" {{ $team->role == 'lead_auditor' ? 'selected' : '' }}>Lead Auditor</option>
                                <option value="auditor" {{ $team->role == 'auditor' ? 'selected' : '' }}>Auditor</option>
                                <option value="observer" {{ $team->role == 'observer' ? 'selected' : '' }}>Observer</option>
                                <option value="trainee" {{ $team->role == 'trainee' ? 'selected' : '' }}>Trainee</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Remarks / Notes</label>
                            <textarea name="notes" class="form-control" rows="4">{{ $team->notes }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6 border-start">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Update Assigned Units</label>
                            <div class="p-3 border rounded bg-light" style="max-height: 150px; overflow-y: auto;">
                                @php $saved_units = json_decode($team->assigned_units) ?? []; @endphp
                                @foreach($units as $unit)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="assigned_units[]" value="{{ $unit->id }}" id="unit{{ $unit->id }}"
                                            {{ in_array($unit->id, $saved_units) ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-bold" for="unit{{ $unit->id }}">{{ $unit->name ?? 'Unit '.$unit->id }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4 d-flex align-items-center">
                            <div class="form-check form-switch me-3">
                                <input class="form-check-input" type="checkbox" name="is_certified" value="1" id="isCert" {{ $team->is_certified ? 'checked' : '' }}>
                            </div>
                            <label class="form-check-label small fw-bold text-muted text-uppercase" for="isCert">Is Certified Auditor?</label>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Certificate Number</label>
                            <input type="text" name="certificate_number" class="form-control py-2" value="{{ $team->certificate_number }}">
                        </div>
                    </div>
                </div>

                <div class="text-end border-top pt-4 mt-2">
                    <a href="{{ route('audit_teams.index') }}" class="btn btn-secondary btn-sm px-4 me-2 shadow-sm">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm px-4 fw-bold shadow-sm">Update Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection