@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header text-white" style="background-color: #007bff;">
            <h5 class="mb-0">SPMI SYSTEM - Standards List</h5>
        </div>
        
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Standards Management</h4>
                <a href="{{ route('standards.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Standard
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover border">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Standard Name</th>
                            <th>Type</th>
                            <th>Version</th>
                            <th>Created By</th> {{-- Ini hasil join tadi --}}
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($standards as $std)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $std->code }}</span></td>
                            <td>
                                <strong>{{ $std->name }}</strong>
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">{{ $std->description }}</p>
                            </td>
                            <td class="text-uppercase">{{ $std->type }}</td>
                            <td>v{{ $std->version }}</td>
                            
                            {{-- Memanggil alias 'creator_name' dari Query Builder Join --}}
                            <td>{{ $std->creator_name ?? 'N/A' }}</td>
                            
                            <td>
                                @if($std->is_active)
                                    <span class="badge bg-success">ACTIVE</span>
                                @else
                                    <span class="badge bg-danger">INACTIVE</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('standards.show', $std->id) }}" class="btn btn-sm btn-info text-white">Show</a>
                                    <a href="{{ route('standards.edit', $std->id) }}" class="btn btn-sm btn-warning text-white">Edit</a>
                                    <form action="{{ route('standards.destroy', $std->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <span class="text-muted">No standards found. Let's create one!</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection