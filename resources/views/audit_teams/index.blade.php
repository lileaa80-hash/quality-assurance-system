@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Audit Teams Management</h5>
            <a href="{{ route('audit_teams.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add Member
            </a>
        </div>
        
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm m-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="px-4 py-3 border-0">AUDIT NO</th>
                            <th class="py-3 border-0">AUDITOR NAME</th>
                            <th class="py-3 border-0">ROLE</th>
                            <th class="py-3 border-0 text-center">STATUS</th>
                            <th class="px-4 py-3 border-0 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teams as $team)
                        <tr>
                            <td class="px-4">
                                <span class="badge bg-secondary opacity-75 px-2 py-1" style="font-size: 11px;">
                                    {{ $team->audit_number }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="fw-bold text-dark">{{ $team->user_name }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border text-uppercase" style="font-size: 0.65rem; padding: 4px 8px;">
                                    {{ $team->role }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($team->is_certified)
                                    <span class="badge bg-success text-uppercase" style="font-size: 0.65rem; padding: 4px 8px;">
                                        <i class="fas fa-certificate me-1"></i> Certified
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark border text-uppercase" style="font-size: 0.65rem; padding: 4px 8px;">
                                        Standard
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('audit_teams.show', $team->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('audit_teams.edit', $team->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('audit_teams.destroy', $team->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus member ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-white px-2 py-1" style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">No audit team members found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                 <small class="text-muted">Showing 1 to {{ $teams->count() }} of {{ $teams->count() }} members</small>
                 <div>
                    {{ $teams->links() }}
                 </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted small">
        &copy; 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection