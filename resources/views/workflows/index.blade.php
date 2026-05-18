@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 8px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Workflows Master</h6>
            <a href="{{ route('workflows.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                <i class="fas fa-plus me-1"></i> ADD NEW WORKFLOW
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm" style="background-color: #d4edda; color: #155724;">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger m-3 py-2 small border-0 shadow-sm" style="background-color: #f8d7da; color: #721c24;">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 12px;">
                    <thead>
                        <tr class="bg-white">
                            <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">Workflow Name</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Code</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Type</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Description</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">Status</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($workflows as $workflow)
                        <tr class="align-middle">
                            <td class="ps-4 fw-medium text-dark">
                                {{ $workflow->name }}
                            </td>
                            <td>
                                <div class="badge bg-light text-primary border text-uppercase px-2 py-1" style="font-size: 10px; font-weight: 600;">
                                    {{ $workflow->code }}
                                </div>
                            </td>
                            <td>
                                <div class="text-uppercase text-secondary fw-semibold" style="font-size: 11px;">
                                    {{ str_replace('_', ' ', $workflow->type) }}
                                </div>
                            </td>
                            <td class="text-muted text-truncate" style="max-width: 250px;" title="{{ $workflow->description }}">
                                {{ $workflow->description ?? '-' }}
                            </td>
                            <td class="text-center">
                                @if($workflow->is_active)
                                    <span class="badge bg-success text-white px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px;">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger text-white px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px;">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('workflows.show', $workflow->id) }}" 
                                       class="btn btn-info btn-xs text-white px-2 py-1 fw-bold" 
                                       style="font-size: 10px; min-width: 45px;">View</a>
                                    
                                    <a href="{{ route('workflows.edit', $workflow->id) }}" 
                                       class="btn btn-warning btn-xs text-white px-2 py-1 fw-bold" 
                                       style="font-size: 10px; min-width: 45px;">Edit</a>
                                    
                                    <form action="{{ route('workflows.destroy', $workflow->id) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this workflow?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs text-white px-2 py-1 fw-bold" 
                                                style="font-size: 10px; min-width: 45px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open d-block mb-2 fa-2x opacity-25"></i>
                                <span style="font-size: 11px;">No workflows found.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($workflows, 'links'))
        <div class="card-footer bg-white py-2 border-top">
            <div class="d-flex justify-content-center">
                {{ $workflows->links() }}
            </div>
        </div>
        @endif
    </div>

    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Workflow Management Controls
    </div>
</div>

<style>
    .btn-xs {
        padding: 2px 6px;
        font-size: 10px;
        line-height: 1.2;
        border-radius: 3px;
    }
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
        transition: 0.2s;
    }
    .badge {
        letter-spacing: 0.3px;
    }
</style>
@endsection