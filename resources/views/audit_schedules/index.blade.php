@extends('layouts.app')

@section('content')
<div class="container mt-5 pb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold">Audit Schedules Management</h6>
            <a href="{{ route('audit_schedules.create') }}" class="btn btn-light btn-sm fw-bold px-3 shadow-sm text-primary">
                + Add New Schedule
            </a>
        </div>
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="fw-bold text-muted small py-3 px-3">Audit No</th>
                            <th class="fw-bold text-muted small py-3">Title</th>
                            <th class="fw-bold text-muted small py-3">Period / Dates</th>
                            <th class="fw-bold text-muted small py-3">Standards</th>
                            <th class="fw-bold text-muted small py-3 text-center">Status</th>
                            <th class="fw-bold text-muted small py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $item)
                        <tr class="border-bottom">
                            <td class="px-3">
                                <span class="badge bg-secondary px-2 py-1">
                                    {{ $item->audit_number }}
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="fw-bold text-dark">"{{ $item->title }}"</div>
                                <small class="text-muted">{{ ucfirst($item->type) }} ({{ ucfirst($item->scope) }})</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark small">{{ $item->period_year }} - {{ ucfirst($item->period_semester) }}</div>
                                <small class="text-primary d-block" style="font-size: 0.75rem;">
                                    {{ date('d/m/Y', strtotime($item->start_date)) }} - {{ date('d/m/Y', strtotime($item->end_date)) }}
                                </small>
                            </td>
                            <td>
                                @php
                                    $stds = json_decode($item->standards_used);
                                @endphp
                                <span class="badge bg-light text-dark border px-2">
                                    {{ count($stds) }} Standards Selected
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusColor = match($item->status) {
                                        'completed' => 'success',
                                        'ongoing' => 'primary',
                                        'cancelled' => 'danger',
                                        default => 'warning'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusColor }} text-uppercase" style="font-size: 0.7rem;">
                                    {{ $item->status }}
                                </span>
                            </td>
                            
                            {{-- BAGIAN TOMBOL ACTIONS YANG SUDAH BERJARAK --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('audit_schedules.show', $item->id) }}" 
                                       class="btn btn-info btn-sm text-white px-3 shadow-sm">
                                       Show
                                    </a>
                                    
                                    <a href="{{ route('audit_schedules.edit', $item->id) }}" 
                                       class="btn btn-warning btn-sm text-white px-3 shadow-sm">
                                       Edit
                                    </a>
                                    
                                    <form action="{{ route('audit_schedules.destroy', $item->id) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Hapus jadwal ini?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-3 shadow-sm">
                                            Delete
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

            <div class="mt-4 px-2">
                 <small class="text-muted">Showing <b>{{ $schedules->count() }}</b> schedules</small>
            </div>
        </div>

        <div class="card-footer bg-white border-0 pb-4 px-4">
            <div class="d-flex justify-content-end">
                {{ $schedules->links() }}
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted small">
        &copy; 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection