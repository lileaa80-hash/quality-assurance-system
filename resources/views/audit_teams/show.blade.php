@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-white text-uppercase">Auditor Assignment Detail</h6>
            <a href="{{ route('audit_teams.index') }}" class="btn btn-light btn-sm fw-bold px-3 shadow-sm">Back to List</a>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase" style="width: 30%;">Audit Number</th>
                            <td class="py-3 px-4 fw-bold text-primary">{{ $team->audit_number }}</td>
                        </tr>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase">Auditor Name</th>
                            <td class="py-3 px-4">{{ $team->user_name }}</td>
                        </tr>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase">Role</th>
                            <td class="py-3 px-4">
                                <span class="badge bg-secondary px-3 py-2 text-uppercase" style="font-size: 0.75rem;">
                                    {{ str_replace('_', ' ', $team->role) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase">Certification Status</th>
                            <td class="py-3 px-4">
                                @if($team->is_certified)
                                    <span class="badge bg-success px-3 py-2 text-uppercase" style="font-size: 0.75rem;">
                                        Certified ({{ $team->certificate_number }})
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark border px-3 py-2 text-uppercase" style="font-size: 0.75rem;">
                                        Standard Auditor
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase">Assigned Units</th>
                            <td class="py-3 px-4">
                                <ul class="mb-0 ps-3">
                                    @php $units = json_decode($team->assigned_units) ?? []; @endphp
                                    @forelse($units as $unitId)
                                        <li class="small fw-bold text-dark">Unit ID: {{ $unitId }}</li>
                                    @empty
                                        <li class="small text-muted italic">No units assigned</li>
                                    @endforelse
                                </ul>
                            </td>
                        </tr>
                        @if(isset($team->notes))
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase">Remarks / Notes</th>
                            <td class="py-3 px-4 small text-muted">{{ $team->notes }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-0 py-3 px-4 text-end">
            <a href="{{ route('audit_teams.edit', $team->id) }}" class="btn btn-warning btn-sm px-4 fw-bold shadow-sm">
                Modify Data
            </a>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted small">
        &copy; 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection