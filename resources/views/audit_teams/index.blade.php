@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">Audit Teams Management</h6>
            <a href="{{ route('audit_teams.create') }}" class="btn btn-light btn-sm fw-bold">+ Add Member</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0" style="font-size: 0.85rem;">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="px-3">No. Audit</th>
                        <th>Auditor Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $team)
                    <tr>
                        <td class="px-3 fw-bold text-dark">{{ $team->audit_number }}</td>
                        <td>{{ $team->user_name }}</td>
                        <td><span class="badge bg-secondary">{{ $team->role }}</span></td>
                        <td>
                            @if($team->is_certified)
                                <span class="badge bg-success">Certified</span>
                            @else
                                <span class="badge bg-light text-dark border">Standard</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('audit_teams.show', $team->id) }}" class="btn btn-info btn-sm py-0 px-2 text-white" style="font-size: 0.7rem;">Show</a>
                                
                                <a href="{{ route('audit_teams.edit', $team->id) }}" class="btn btn-warning btn-sm py-0 px-2" style="font-size: 0.7rem;">Edit</a>
                                
                                <form action="{{ route('audit_teams.destroy', $team->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm py-0 px-2" style="font-size: 0.7rem;" onclick="return confirm('Delete member?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection