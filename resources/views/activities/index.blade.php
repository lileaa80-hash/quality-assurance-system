@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Activity Logs</h5>
            <a href="{{ route('activities.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add Activity
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="ps-4 py-3 border-0" style="width: 8%;">No</th>
                            <th class="py-3 border-0" style="width: 20%;">Log Name</th>
                            <th class="py-3 border-0" style="width: 35%;">Description</th>
                            <th class="py-3 border-0" style="width: 12%;">Event</th>
                            <th class="py-3 border-0" style="width: 13%;">IP Address</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($activities as $activity)
                        <tr>
                            <td class="ps-4 text-muted">
                                @if(method_exists($activities, 'currentPage'))
                                    {{ ($activities->currentPage() - 1) * $activities->perPage() + $loop->iteration }}
                                @else
                                    {{ $loop->iteration }}
                                @endif
                            </td>
                            <td class="fw-bold text-dark">
                                {{ $activity->log_name }}
                            </td>
                            <td class="text-muted">{{ $activity->description }}</td>
                            <td>
                                <span class="badge bg-light text-secondary border text-uppercase px-2 py-1" style="font-size: 10px; font-weight: 600;">
                                    {{ $activity->event }}
                                </span>
                            </td>
                            <td>
                                <code style="font-size: 11px;">{{ $activity->ip_address ?? '-' }}</code>
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus log aktivitas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-white px-2 py-1" style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-history d-block mb-2 fa-2x opacity-25"></i>
                                No activities found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    @if(method_exists($activities, 'firstItem'))
                        Showing {{ $activities->firstItem() ?? 0 }} to {{ $activities->lastItem() ?? 0 }} of {{ $activities->total() ?? 0 }} records
                    @else
                        Showing {{ $activities->count() }} records
                    @endif
                </small>
                @if(method_exists($activities, 'links'))
                    <div>
                        {{ $activities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | System Security Controls
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
        transition: 0.2s;
    }
    code {
        color: #4f5d73;
        background-color: #f1f3f5;
        padding: 2px 6px;
        border-radius: 4px;
    }
</style>
@endsection