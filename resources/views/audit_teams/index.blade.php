@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-white text-uppercase">Audit Teams Management</h6>
            <a href="{{ route('audit_teams.create') }}" class="btn btn-light btn-sm fw-bold px-3 shadow-sm" style="font-size: 11px;">
                + Add Member
            </a>
        </div>
        
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-uppercase small text-muted border-bottom">
                            <th class="fw-bold py-3 px-3">No. Audit</th>
                            <th class="fw-bold py-3">Auditor Name</th>
                            <th class="fw-bold py-3">Role</th>
                            <th class="fw-bold py-3 text-center">Status</th>
                            <th class="fw-bold py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teams as $team)
                        <tr>
                            <td class="px-3">
                                <span class="badge bg-secondary px-2 py-1" style="font-size: 10px;">
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
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('audit_teams.show', $team->id) }}" class="btn btn-info btn-sm text-white px-3 shadow-sm" style="font-size: 10px; font-weight: bold;">
                                        SHOW
                                    </a>
                                    <a href="{{ route('audit_teams.edit', $team->id) }}" class="btn btn-warning btn-sm text-white px-3 shadow-sm" style="font-size: 10px; font-weight: bold;">
                                        EDIT
                                    </a>
                                    <form action="{{ route('audit_teams.destroy', $team->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus member ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm text-white px-3 shadow-sm" style="font-size: 10px; font-weight: bold;">
                                            DELETE
                                        </button>
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

            <div class="mt-4 px-2 d-flex justify-content-between align-items-center">
                 <small class="text-muted">Showing <b>{{ $teams->count() }}</b> members</small>
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