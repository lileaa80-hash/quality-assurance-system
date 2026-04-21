@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h6 class="mb-0 fw-bold">SPMI SYSTEM - Unit Management</h6>
            <a href="{{ route('units.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm px-3">
                Add New Unit
            </a>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3 py-2 small border-0 shadow-sm" role="alert" style="background-color: #d4edda;">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 13px;">
                    <thead class="bg-light">
                        <tr class="text-uppercase small fw-bold text-muted">
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Unit Code</th>
                            <th class="py-3">Unit Name</th>
                            <th class="py-3">Type</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $index => $unit)
                        <tr class="align-middle">
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td class="fw-bold text-primary">{{ $unit->code }}</td>
                            <td class="fw-bold text-dark">{{ $unit->name }}</td>
                            <td>
                                <span class="text-muted small">{{ strtoupper($unit->type) }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $unit->is_active ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-1" style="font-size: 10px; border-radius: 4px;">
                                    {{ $unit->is_active ? 'ACTIVE' : 'INACTIVE' }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('units.show', $unit->id) }}" class="btn btn-info btn-sm text-white px-2 py-1" style="font-size: 11px;">View</a>
                                    <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-warning btn-sm text-white px-2 py-1" style="font-size: 11px;">Edit</a>
                                    <form action="{{ route('units.destroy', $unit->id) }}" method="POST" onsubmit="return confirm('Delete this unit?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-2 py-1" style="font-size: 11px;">Delete</button>
                                    </form>
                                </div>
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

            <div class="p-3 border-top bg-light">
                <small class="text-muted">Showing {{ $units->count() }} units</small>
            </div>
        </div>
    </div>

    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection