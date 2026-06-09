@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Workflows Master</h5>
            <a href="{{ route('workflows.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add New Workflow
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="ps-4 py-3 border-0" style="width: 25%;">Workflow Name</th>
                            <th class="py-3 border-0" style="width: 15%;">Code</th>
                            <th class="py-3 border-0" style="width: 20%;">Type</th>
                            <th class="py-3 border-0">Description</th>
                            <th class="py-3 border-0 text-center">Status</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($workflows as $workflow)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">
                                {{ $workflow->name }}
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border text-uppercase px-2 py-1" style="font-size: 10px; font-weight: 600;">
                                    {{ $workflow->code }}
                                </span>
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
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('workflows.show', $workflow->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('workflows.edit', $workflow->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('workflows.destroy', $workflow->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this workflow?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-white px-2 py-1" style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open d-block mb-2 fa-2x opacity-25"></i>
                                No workflows found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $workflows->count() }} records
                </small>
                @if(method_exists($workflows, 'links'))
                    <div>
                        {{ $workflows->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Workflow Management Controls
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
        transition: 0.2s;
    }
</style>
@endsection