@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Workflow Steps Master</h5>
            <a href="{{ route('workflow_steps.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add New Step
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
                            <th class="ps-4 py-3 border-0" style="width: 25%;">Parent Workflow</th>
                            <th class="py-3 border-0 text-center" style="width: 8%;">Order</th>
                            <th class="py-3 border-0" style="width: 20%;">Step Name</th>
                            <th class="py-3 border-0">Approver Type</th>
                            <th class="py-3 border-0">Approver Value</th>
                            <th class="py-3 border-0 text-center">Requires Approval</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($workflowSteps as $step)
                        <tr>
                            {{-- Nama Workflow Induk --}}
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $step->workflow_name }}</div>
                                <small class="text-muted text-uppercase" style="font-size: 10px;">Code: {{ $step->workflow_code }}</small>
                            </td>
                            {{-- Urutan Tahapan --}}
                            <td class="text-center">
                                <span class="badge bg-secondary text-white px-2 py-1 fw-bold" style="font-size: 10px; min-width: 22px; border-radius: 50%;">
                                    {{ $step->step_order }}
                                </span>
                            </td>
                            {{-- Nama Tahapan --}}
                            <td class="fw-bold text-dark">
                                {{ $step->name }}
                            </td>
                            {{-- Tipe Approver --}}
                            <td>
                                <span class="badge bg-light text-secondary border text-uppercase px-2 py-1" style="font-size: 10px; font-weight: 600;">
                                    <i class="fas fa-user-tag me-1 text-primary opacity-75"></i>{{ str_replace('_', ' ', $step->approver_type) }}
                                </span>
                            </td>
                            {{-- Nilai Identitas Approver --}}
                            <td>
                                <code>{{ $step->approver_value }}</code>
                            </td>
                            {{-- Status Mandatori Approval --}}
                            <td class="text-center">
                                @if($step->requires_approval)
                                    <span class="badge bg-success text-white px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px;">
                                        Yes
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px;">
                                        No (Skip)
                                    </span>
                                @endif
                            </td>
                            {{-- Tombol Aksi --}}
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('workflow_steps.show', $step->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('workflow_steps.edit', $step->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('workflow_steps.destroy', $step->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this workflow step?')">
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
                                <i class="fas fa-bezier-curve d-block mb-2 fa-2x opacity-25"></i>
                                No workflow steps configured yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $workflowSteps->count() }} records
                </small>
                @if(method_exists($workflowSteps, 'links'))
                    <div>
                        {{ $workflowSteps->links() }}
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
    code {
        color: #d63384;
        background-color: #f8f9fa;
        padding: 2px 6px;
        border: 1px solid #e3e6f0;
        border-radius: 4px;
        font-size: 11px;
    }
</style>
@endsection