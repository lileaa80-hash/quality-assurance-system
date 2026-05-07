@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - User Management</h5>
            <a href="{{ route('users.create') }}" class="btn btn-light btn-sm px-3 fw-bold shadow-sm">
                <i class="fas fa-plus-circle me-1"></i> Add New User
            </a>
        </div>
        
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover align-middle border rounded">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 fw-bold small text-muted" width="50">NO</th>
                            <th class="fw-bold small text-muted">FULL NAME</th>
                            <th class="fw-bold small text-muted">EMAIL ADDRESS</th>
                            <th class="fw-bold small text-muted">STATUS</th>
                            <th class="fw-bold small text-muted text-center" width="200">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-3">
                                <span class="badge bg-light text-dark border small">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                            </td>
                            <td class="text-muted small">{{ $user->email }}</td>
                            <td>
                                @if($user->status == 'active')
                                    <span class="badge bg-success-subtle text-success border border-success px-3">ACTIVE</span>
                                @else
                                    <span class="badge bg-warning-subtle text-dark border border-warning px-3">INACTIVE</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm text-white px-2 shadow-sm" title="View Details">
                                        View
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm text-white px-2 shadow-sm" title="Edit User">
                                        Edit
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-2 shadow-sm" title="Delete User">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted italic">
                                <i class="fas fa-folder-open d-block mb-2 fs-3"></i>
                                No user data available.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="small text-muted">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        <div class="card-footer bg-light py-2 text-center text-muted small border-0">
            © 2026 SPMI Digital System - RPL
        </div>
    </div>
</div>
@endsection