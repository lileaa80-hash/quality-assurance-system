@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">User Management</h6>
            <a href="{{ route('users.create') }}" class="btn btn-light btn-sm fw-bold py-0" style="font-size: 0.75rem;">
                + Add New User
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
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">Full Name</th>
                            <th class="fw-bold">Email Address</th>
                            <th class="fw-bold">Status</th>
                            <th class="fw-bold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="border-bottom">
                            <td>
                                <span class="badge bg-secondary text-white px-2 py-1" style="font-size: 0.65rem; border-radius: 4px;">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                </span>
                            </td>
                            <td class="fw-bold text-muted small">"{{ $user->name }}"</td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                @if($user->status == 'active')
                                    <span class="badge bg-success text-uppercase" style="font-size: 0.65rem; border-radius: 4px;">ACTIVE</span>
                                @else
                                    <span class="badge bg-warning text-dark text-uppercase" style="font-size: 0.65rem; border-radius: 4px;">INACTIVE</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm text-white py-0 px-2 rounded-0 border-end border-white" style="font-size: 0.75rem;">
                                        Show
                                    </a>

                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm text-white py-0 px-2 rounded-0 border-end border-white" style="font-size: 0.75rem;">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin?')">
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
                            <td colspan="5" class="text-center text-muted py-4">Data tidak tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection