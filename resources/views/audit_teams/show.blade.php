@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Auditor Assignment Detail</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="text-muted small fw-bold">AUDIT NUMBER</label>
                    <p class="fw-bold text-primary">{{ $team->audit_number }}</p>

                    <label class="text-muted small fw-bold">AUDITOR NAME</label>
                    <p>{{ $team->user_name }}</p>

                    <label class="text-muted small fw-bold">ROLE</label>
                    <p><span class="badge bg-secondary">{{ str_replace('_', ' ', ucfirst($team->role)) }}</span></p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small fw-bold">CERTIFICATION STATUS</label>
                    <p>
                        @if($team->is_certified)
                            <span class="badge bg-success">Certified ({{ $team->certificate_number }})</span>
                        @else
                            <span class="badge bg-light text-dark border">Standard Auditor</span>
                        @endif
                    </p>

                    <label class="text-muted small fw-bold">ASSIGNED UNITS</label>
                    <ul class="ps-3">
                        @php $units = json_decode($team->assigned_units) ?? []; @endphp
                        @forelse($units as $unitId)
                            <li class="small">Unit ID: {{ $unitId }}</li>
                        @empty
                            <li class="small text-muted">No units assigned</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="border-top pt-3 mt-3">
                <a href="{{ route('audit_teams.index') }}" class="btn btn-secondary btn-sm rounded-0">Back to List</a>
                <a href="{{ route('audit_teams.edit', $team->id) }}" class="btn btn-warning btn-sm rounded-0">Edit Assignment</a>
            </div>
        </div>
    </div>
</div>
@endsection