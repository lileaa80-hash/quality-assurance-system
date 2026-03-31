@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Unit / Department List</h5>
        </div>
        
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-secondary mb-0">Units Management</h4>
                <a href="{{ route('units.create') }}" class="btn btn-primary px-4 shadow-sm">
                    Add Unit
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle border-top">
                    <thead class="table-light">
                        <tr class="text-uppercase small fw-bold">
                            <th class="py-3">Code</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Type</th>
                            <th class="py-3">Head Name</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $unit)
                        <tr>
                            <td class="fw-bold text-primary">{{ $unit->code }}</td>
                            <td class="fw-bold text-dark">{{ $unit->name }}</td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-2">
                                    {{ strtoupper($unit->type) }}
                                </span>
                            </td>
                            <td>{{ $unit->head_name ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $unit->is_active ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                    {{ $unit->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('units.destroy', $unit->id) }}" method="POST" onsubmit="return confirm('Delete this unit?')">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('units.show', $unit->id) }}" class="btn btn-sm btn-info text-white">Show</a>
                                    <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-sm btn-warning text-white">Edit</a>
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No units found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-center text-muted small">
                © 2026 SPMI Digital System - RPL
            </div>
        </div>
    </div>
</div>
@endsection