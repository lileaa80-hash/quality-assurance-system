@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 8px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Workflow Steps Master</h6>
            <a href="{{ route('workflow_steps.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                <i class="fas fa-plus me-1"></i> ADD NEW STEP
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
                            <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">Parent Workflow</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">Order</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Step Name</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Approver Type</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Approver Value</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">Requires Approval</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($workflowSteps as $step)
                        <tr class="align-middle">
                            {{-- Nama Workflow Induk --}}
                            <td class="ps-4">
                                <div class="fw-semibold text-dark">{{ $step->workflow_name }}</div>
                                <small class="text-muted text-uppercase" style="font-size: 10px;">Code: {{ $step->workflow_code }}</small>
                            </td>
                            {{-- Urutan Tahapan --}}
                            <td class="text-center">
                                <span class="badge bg-secondary text-white px-2 py-1 fw-bold" style="font-size: 10px; min-width: 24px; border-radius: 50%;">
                                    {{ $step->step_order }}
                                </span>
                            </td>
                            {{-- Nama Tahapan --}}
                            <td class="fw-medium text-dark">
                                {{ $step->name }}
                            </td>
                            {{-- Tipe Approver --}}
                            <td>
                                <span class="badge bg-light text-secondary border text-uppercase px-2 py-1" style="font-size: 10px; font-weight: 600;">
                                    <i class="fas fa-user-tag me-1 text-primary opacity-75"></i>{{ str_replace('_', ' ', $step->approver_type) }}
                                </span>
                            </td>
                            {{-- Nilai Identitas Approver --}}
                            <td class="text-dark fw-semibold">
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
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('workflow_steps.show', $step->id) }}" 
                                       class="btn btn-info btn-xs text-white px-2 py-1 fw-bold" 
                                       style="font-size: 10px; min-width: 45px;">View</a>
                                    
                                    <a href="{{ route('workflow_steps.edit', $step->id) }}" 
                                       class="btn btn-warning btn-xs text-white px-2 py-1 fw-bold" 
                                       style="font-size: 10px; min-width: 45px;">Edit</a>
                                    
                                    <form action="{{ route('workflow_steps.destroy', $step->id) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this workflow step?')" class="d-inline">
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
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-bezier-curve d-block mb-2 fa-2x opacity-25"></i>
                                <span style="font-size: 11px;">No workflow steps configured yet.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($workflowSteps, 'links'))
        <div class="card-footer bg-white py-2 border-top">
            <div class="d-flex justify-content-center">
                {{ $workflowSteps->links() }}
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
    code {
        color: #d63384;
        background-color: #f8f9fa;
        padding: 2px 4px;
        border-radius: 4px;
        font-size: 11px;
    }
</style>
@endsection