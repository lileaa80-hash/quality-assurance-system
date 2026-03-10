@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold">Unit / Department List</h5>
        <a href="{{ route('units.create') }}" class="btn btn-primary btn-sm">Add Unit</a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Head Name</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($units as $unit)
                <tr>
                    <td>{{ $unit->code }}</td>
                    <td>{{ $unit->name }}</td>
                    <td><span class="badge bg-secondary">{{ strtoupper($unit->type) }}</span></td>
                    <td>{{ $unit->head_name ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $unit->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $unit->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('units.destroy', $unit->id) }}" method="POST" onsubmit="return confirm('Delete this unit?')">
                            <a href="{{ route('units.show', $unit->id) }}" class="btn btn-sm btn-info text-white">Show</a>
                            <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-sm btn-warning text-white">Edit</a>
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection