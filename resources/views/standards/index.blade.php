@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Standards List</h5>
            <a href="{{ route('standards.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add New Standard
            </a>
        </div>
        <div class="card-body p-0"> 
            @if(session('success'))
                <div class="alert alert-success m-3">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="px-4 py-3 border-0">CODE</th>
                            <th class="py-3 border-0">STANDARD NAME</th>
                            <th class="py-3 border-0">TYPE</th>
                            <th class="py-3 border-0">VERSION</th>
                            <th class="py-3 border-0">CREATED BY</th>
                            <th class="py-3 border-0 text-center">STATUS</th>
                            <th class="px-4 py-3 border-0 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($standards as $std)
                        <tr class="align-middle">
                            <td class="px-4">
                                <span class="badge bg-secondary opacity-75">{{ $std->code }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $std->name }}</div>
                                <small class="text-muted">{{ $std->description }}</small>
                            </td>
                            <td class="text-muted" style="font-size: 0.9rem;">{{ $std->type }}</td>
                            <td class="text-muted">v{{ $std->version }}</td>
                            <td class="text-muted">{{ $std->creator_name ?? 'N/A' }}</td>
                            <td class="text-center">
                                @if($std->is_active)
                                    <span class="badge rounded-pill bg-success px-3" style="font-size: 0.75rem;">ACTIVE</span>
                                @else
                                    <span class="badge rounded-pill bg-warning text-dark px-3" style="font-size: 0.75rem;">INACTIVE</span>
                                @endif
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('standards.show', $std->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #17a2b8; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('standards.edit', $std->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('standards.destroy', $std->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
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
                                No standards found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                <small class="text-muted">Showing 0 to {{ count($standards) }} of {{ count($standards) }} standards</small>
            </div>
        </div>
    </div>
</div>
@endsection