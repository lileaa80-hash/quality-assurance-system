@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Audit Finding Management</h6>
            <a href="{{ route('audit_findings.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                + Add New Finding
            </a>
        </div>

        <div class="card-body p-0">
            <div class="p-3 border-bottom bg-light">
                <form action="{{ route('audit_findings.index') }}" method="GET" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search finding number or description..." value="{{ request('search') }}" style="font-size: 12px;">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm" style="font-size: 12px;">
                            <option value="">All Status</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>OPEN</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>CLOSED</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm px-3" style="font-size: 11px;">Filter</button>
                    </div>
                </form>
            </div>

            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm" style="background-color: #d4edda;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 12px;">
                    <thead class="bg-white">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold" style="width: 15%;">FINDING NO.</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 25%;">UNIT & SCHEDULE</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 30%;">DESCRIPTION</th>
                            <th class="py-3 text-muted small fw-bold text-center">STATUS</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($findings as $item)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ $item->finding_number }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ \Carbon\Carbon::parse($item->finding_date)->format('d/m/Y') }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->unit_name }}</div>
                                <div class="text-muted small italic">{{ $item->schedule_title }}</div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 250px;">
                                    <span class="badge bg-light text-dark border fw-normal mb-1" style="font-size: 9px;">{{ strtoupper($item->category) }}</span><br>
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
                                <span class="badge {{ $statusBadge }} px-2 py-1" style="font-size: 9px; border-radius: 4px;">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('audit_findings.show', $item->id) }}" class="btn btn-info btn-xs text-white px-2 py-0" style="font-size: 10px;">Show</a>
                                    <a href="{{ route('audit_findings.edit', $item->id) }}" class="btn btn-warning btn-xs text-white px-2 py-0" style="font-size: 10px;">Edit</a>
                                    <form action="{{ route('audit_findings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this finding?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs px-2 py-0" style="font-size: 10px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted" style="font-size: 11px;">
                                No audit findings found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($findings->hasPages())
        <div class="card-footer bg-white py-2">
            <div class="small">
                {{ $findings->links() }}
            </div>
        </div>
        @endif
    </div>
    
    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>

<style>
    .btn-xs {
        padding: 1px 5px;
        font-size: 10px;
        line-height: 1.5;
        border-radius: 3px;
    }
    .italic { font-style: italic; }
</style>
@endsection