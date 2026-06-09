@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Approval Transactions</h5>
            <a href="{{ route('approvals.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add New Approval
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
                            <th class="ps-4 py-3 border-0" style="width: 25%;">Target Object (Morphs)</th>
                            <th class="py-3 border-0" style="width: 20%;">Workflow Step</th>
                            <th class="py-3 border-0" style="width: 20%;">Assigned Approver</th>
                            <th class="py-3 border-0">Notes / Reason</th>
                            <th class="py-3 border-0 text-center">Status</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($approvals as $approval)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-secondary border text-uppercase px-2 py-1 mb-1" style="font-size: 9px; font-weight: 600;">
                                    {{ basename(str_replace('\\', '/', $approval->approvable_type)) }}
                                </span>
                                <div class="fw-bold text-dark">ID: #{{ $approval->approvable_id }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $approval->step_name }}</div>
                            </td>
                            <td>
                                <div class="text-secondary fw-semibold" style="font-size: 11px;">
                                    <i class="far fa-user me-1 opacity-75"></i> {{ $approval->approver_name }}
                                </div>
                            </td>
                            <td class="text-muted text-truncate" style="max-width: 200px;" title="{{ $approval->notes }}">
                                {{ $approval->notes ?? '-' }}
                            </td>
                            <td class="text-center">
                                @if($approval->status == 'pending')
                                    <span class="badge bg-warning text-dark px-2 py-1 shadow-sm text-uppercase" style="font-size: 9px; border-radius: 4px; min-width: 65px;">
                                        Pending
                                    </span>
                                @elseif($approval->status == 'approved')
                                    <span class="badge bg-success text-white px-2 py-1 shadow-sm text-uppercase" style="font-size: 9px; border-radius: 4px; min-width: 65px;">
                                        Approved
                                    </span>
                                @elseif($approval->status == 'rejected')
                                    <span class="badge bg-danger text-white px-2 py-1 shadow-sm text-uppercase" style="font-size: 9px; border-radius: 4px; min-width: 65px;">
                                        Rejected
                                    </span>
                                @elseif($approval->status == 'revised')
                                    <span class="badge bg-info text-white px-2 py-1 shadow-sm text-uppercase" style="font-size: 9px; border-radius: 4px; min-width: 65px;">
                                        Revised
                                    </span>
                                @else
                                    <span class="badge bg-secondary text-white px-2 py-1 shadow-sm text-uppercase" style="font-size: 9px; border-radius: 4px; min-width: 65px;">
                                        {{ $approval->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('approvals.show', $approval->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('approvals.edit', $approval->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('approvals.destroy', $approval->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this approval transaction?')">
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
                                <i class="fas fa-history d-block mb-2 fa-2x opacity-25"></i>
                                No approval transaction records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $approvals->count() }} records
                </small>
                @if(method_exists($approvals, 'links'))
                    <div>
                        {{ $approvals->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Secure Workflow Approval Controls
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
        transition: 0.2s;
    }
</style>
@endsection