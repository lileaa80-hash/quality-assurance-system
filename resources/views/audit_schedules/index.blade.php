@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-white text-uppercase">Audit Schedules Management</h6>
            <a href="{{ route('audit_schedules.create') }}" class="btn btn-light btn-sm fw-bold px-3 shadow-sm" style="font-size: 11px;">
                + Add New Schedule
            </a>
        </div>
        
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-uppercase small text-muted border-bottom">
                            <th class="fw-bold py-3 px-3">Audit No</th>
                            <th class="fw-bold py-3">Title</th>
                            <th class="fw-bold py-3">Period / Dates</th>
                            <th class="fw-bold py-3">Standards</th>
                            <th class="fw-bold py-3">Status</th>
                            <th class="fw-bold py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $item)
                        <tr>
                            <td class="px-3">
                                <span class="badge bg-secondary px-2 py-1" style="font-size: 10px;">
                                    {{ $item->audit_number }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="fw-bold text-dark">{{ $item->title }}</div>
                                <small class="text-muted text-uppercase" style="font-size: 10px;">{{ $item->type }} | {{ $item->scope }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark small">{{ $item->period_year }} - {{ ucfirst($item->period_semester) }}</div>
                                <small class="text-primary d-block" style="font-size: 0.7rem;">
                                    {{ date('d/m/Y', strtotime($item->start_date)) }} - {{ date('d/m/Y', strtotime($item->end_date)) }}
                                </small>
                            </td>
                            <td>
                                @php $stds = json_decode($item->standards_used); @endphp
                                <span class="badge bg-light text-dark border px-2 fw-normal">
                                    {{ count($stds) }} Standards
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusColor = match($item->status) {
                                        'completed' => 'success',
                                        'ongoing' => 'primary',
                                        'cancelled' => 'danger',
                                        default => 'warning'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusColor }} text-uppercase" style="font-size: 0.65rem; padding: 4px 8px;">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('audit_schedules.show', $item->id) }}" class="btn btn-info btn-sm text-white px-3 shadow-sm" style="font-size: 10px; font-weight: bold;">
                                        SHOW
                                    </a>
                                    <a href="{{ route('audit_schedules.edit', $item->id) }}" class="btn btn-warning btn-sm text-white px-3 shadow-sm" style="font-size: 10px; font-weight: bold;">
                                        EDIT
                                    </a>
                                    <form action="{{ route('audit_schedules.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus jadwal ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm text-white px-3 shadow-sm" style="font-size: 10px; font-weight: bold;">
                                            DELETE
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">No audit schedules found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 px-2 d-flex justify-content-between align-items-center">
                 <small class="text-muted">Showing <b>{{ $schedules->count() }}</b> schedules</small>
                 <div>
                    {{ $schedules->links() }}
                 </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted small">
        &copy; 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection