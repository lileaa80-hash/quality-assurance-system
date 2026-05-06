@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">Detailed Audit Schedule View</h6>
            <a href="{{ route('audit_schedules.index') }}" class="btn btn-light btn-sm fw-bold px-3 shadow-sm text-primary">
                Back to List
            </a>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <tbody>
                    <tr>
                        <th class="py-3 px-4 text-muted small fw-bold" style="width: 30%;">Audit Number</th>
                        <td class="py-3 px-4">
                            <span class="badge bg-secondary px-2 py-1">{{ $schedule->audit_number }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th class="py-3 px-4 text-muted small fw-bold">Title</th>
                        <td class="py-3 px-4 fw-bold text-dark">{{ $schedule->title }}</td>
                    </tr>
                    <tr>
                        <th class="py-3 px-4 text-muted small fw-bold">Type / Scope</th>
                        <td class="py-3 px-4">
                             <span class="badge bg-primary px-3">{{ ucfirst($schedule->type) }} / {{ ucfirst($schedule->scope) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th class="py-3 px-4 text-muted small fw-bold">Status</th>
                        <td class="py-3 px-4">
                            <span class="badge bg-success text-uppercase">{{ $schedule->status }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th class="py-3 px-4 text-muted small fw-bold">Period / Year</th>
                        <td class="py-3 px-4">{{ $schedule->period_year }} - {{ ucfirst($schedule->period_semester) }}</td>
                    </tr>
                    <tr>
                        <th class="py-3 px-4 text-muted small fw-bold">Date Range</th>
                        <td class="py-3 px-4 text-primary fw-bold">
                            {{ date('d/m/Y', strtotime($schedule->start_date)) }} s/d {{ date('d/m/Y', strtotime($schedule->end_date)) }}
                        </td>
                    </tr>
                    <tr>
                        <th class="py-3 px-4 text-muted small fw-bold">Standards Used</th>
                        <td class="py-3 px-4">
                            @php $stds = json_decode($schedule->standards_used); @endphp
                            <ul class="mb-0 ps-3">
                                @if(is_array($stds))
                                    @foreach($stds as $std)
                                        <li>Standard ID: {{ $std }}</li>
                                    @endforeach
                                @else
                                    <li>-</li>
                                @endif
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th class="py-3 px-4 text-muted small fw-bold" style="vertical-align: top;">Notes</th>
                        <td class="py-3 px-4 text-muted">{{ $schedule->notes ?? 'No additional notes' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-0 py-4 px-4 d-flex justify-content-end">
            <a href="{{ route('audit_schedules.edit', $schedule->id) }}" class="btn btn-warning fw-bold text-white px-4 shadow-sm">
                Modify Data
            </a>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted small">
        &copy; 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection