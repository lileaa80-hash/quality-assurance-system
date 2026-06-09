@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Audit Findings</h5>
            <a href="{{ route('audit_findings.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add New Finding
            </a>
        </div>
        
        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-light">
                <form action="{{ route('audit_findings.index') }}" method="GET" class="row g-2 m-0">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search finding number or description..." value="{{ request('search') }}" style="font-size: 12px; border-radius: 4px;">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm" style="font-size: 12px; border-radius: 4px;">
                            <option value="">All Status</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>OPEN</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>CLOSED</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm px-3" style="font-size: 12px; border-radius: 4px; background-color: #007bff; border: none;">Filter</button>
                    </div>
                </form>
            </div>

            @if(session('success'))
                <div class="alert alert-success m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="px-4 py-3 border-0" style="width: 15%;">FINDING NO.</th>
                            <th class="py-3 border-0" style="width: 25%;">UNIT & SCHEDULE</th>
                            <th class="py-3 border-0" style="width: 35%;">DESCRIPTION</th>
                            <th class="py-3 border-0 text-center">STATUS</th>
                            <th class="px-4 py-3 border-0 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($findings as $item)
                        <tr>
                            <td class="px-4">
                                <div class="fw-bold text-primary">{{ $item->finding_number }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ \Carbon\Carbon::parse($item->finding_date)->format('d/m/Y') }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->unit_name }}</div>
                                <div class="text-muted small italic" style="font-style: italic;">{{ $item->schedule_title }}</div>
                            </td>
                            <td>
                                <div class="text-wrap" style="max-width: 280px;">
                                    <span class="badge bg-light text-dark border fw-normal mb-1" style="font-size: 9px; border-radius: 3px;">{{ strtoupper($item->category) }}</span><br>
                                    {{ Str::limit($item->finding_description, 60) }}
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusBadge = [
                                        'open' => 'bg-danger',
                                        'closed' => 'bg-success',
                                        'in_progress' => 'bg-warning text-dark'
                                    ][$item->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $statusBadge }} px-2 py-1 text-uppercase" style="font-size: 9px; border-radius: 4px;">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('audit_findings.show', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('audit_findings.edit', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('audit_findings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this finding?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-white px-2 py-1" style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                No audit findings found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing 1 to {{ count($findings) }} of {{ count($findings) }} records</small>
                @if($findings->hasPages())
                    <div class="mt-2">
                        {{ $findings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection