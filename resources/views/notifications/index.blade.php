@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Notification Management</h5>
            <a href="{{ route('notifications.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add Notification
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
                            <th class="py-3 border-0" style="width: 25%;">Type</th>
                            <th class="py-3 border-0">Notifiable Type</th>
                            <th class="py-3 border-0">Notifiable ID</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="py-3 border-0">Created At</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($notifications as $index => $notification)
                        <tr>
                            <td class="ps-4 text-muted">
                                {{ $index + 1 }}
                            </td>
                            <td class="fw-bold text-primary">
                                {{ $notification->type }}
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ $notification->notifiable_type }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">
                                {{ $notification->notifiable_id }}
                            </td>
                            <td>
                                @if($notification->read_at)
                                    <span class="badge bg-success text-white px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px;">
                                        Read
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px;">
                                        Unread
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ \Carbon\Carbon::parse($notification->created_at)->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('notifications.show', $notification->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('notifications.edit', $notification->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this notification?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-white px-2 py-1" style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                No notifications found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing {{ $notifications->count() }} records</small>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Notification Controls
    </div>
</div>
@endsection