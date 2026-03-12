@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Audit Schedules Management</h6>
            <a href="{{ route('audit_schedules.create') }}" class="btn btn-light btn-sm fw-bold py-0" style="font-size: 0.75rem;">
                + Add New Schedule
            </a>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success py-2 border-0 shadow-sm" role="alert" style="background-color: #d1e7dd; font-size: 0.85rem;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-borderless align-middle mt-2" style="font-size: 0.85rem;">
                    <thead>
                        <tr class="border-bottom">
                            <th class="fw-bold text-muted">Audit No</th>
                            <th class="fw-bold text-muted">Title</th>
                            <th class="fw-bold text-muted">Period / Dates</th>
                            <th class="fw-bold text-muted">Standards</th>
                            <th class="fw-bold text-muted text-center">Status</th>
                            <th class="fw-bold text-muted text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $item)
                        <tr class="border-bottom">
                            <td>
                                <span class="badge bg-secondary text-white px-2 py-1" style="font-size: 0.65rem; border-radius: 4px;">
                                    {{ $item->audit_number }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-muted small">"{{ $item->title }}"</div>
                                <small class="text-secondary">{{ ucfirst($item->type) }} ({{ ucfirst($item->scope) }})</small>
                            </td>
                            <td>
                                <div class="small fw-bold">{{ $item->period_year }} - {{ ucfirst($item->period_semester) }}</div>
                                <small class="text-primary" style="font-size: 0.7rem;">
                                    {{ date('d/m/Y', strtotime($item->start_date)) }} - {{ date('d/m/Y', strtotime($item->end_date)) }}
                                </small>
                            </td>
                            <td>
                                @php
                                    $stds = json_decode($item->standards_used);
                                @endphp
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">
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
                                <span class="badge bg-{{ $statusColor }} text-uppercase" style="font-size: 0.65rem; border-radius: 4px;">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('audit_schedules.show', $item->id) }}" class="btn btn-info btn-sm text-white py-0 px-2 rounded-0 border-end border-white" style="font-size: 0.75rem;">
                                        Show
                                    </a>

                                    <a href="{{ route('audit_schedules.edit', $item->id) }}" class="btn btn-warning btn-sm text-white py-0 px-2 rounded-0 border-end border-white" style="font-size: 0.75rem;">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('audit_schedules.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm py-0 px-2 rounded-0" style="font-size: 0.75rem; border-bottom-right-radius: 4px; border-top-right-radius: 4px;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4 small">No audit schedules found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $schedules->links() }}
            </div>
        </div>
    </div>
</div>
@endsection