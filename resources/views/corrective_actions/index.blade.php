@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Corrective Action Management (CAPA)</h6>
            <a href="{{ route('corrective_actions.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                + Create New Plan
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm" style="background-color: #d4edda;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 12px;">
                    <thead class="bg-white">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold" style="width: 15%;">CA NUMBER</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 25%;">FINDING & UNIT</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 20%;">RESPONSIBLE (PIC)</th>
                            <th class="py-3 text-muted small fw-bold text-center">TARGET DATE</th>
                            <th class="py-3 text-muted small fw-bold text-center">VERIFICATION</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($actions as $item)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ $item->ca_number }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ strtoupper($item->cause_category) }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->unit_name }}</div>
                                <div class="text-muted small">Ref: {{ $item->finding_number }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $item->pic_name }}</div>
                            </td>
                            <td class="text-center">
                                <div class="{{ \Carbon\Carbon::parse($item->target_completion_date)->isPast() && $item->final_status != 'closed' ? 'text-danger fw-bold' : '' }}">
                                    {{ \Carbon\Carbon::parse($item->target_completion_date)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $vBadge = [
                                        'pending' => 'bg-warning text-dark',
                                        'verified' => 'bg-success',
                                        'rejected' => 'bg-danger'
                                    ][$item->verification_status] ?? 'bg-dark';
                                @endphp
                                <span class="badge {{ $vBadge }} px-2 py-1" style="font-size: 9px; border-radius: 4px;">
                                    {{ strtoupper($item->verification_status) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('corrective_actions.show', $item->id) }}" class="btn btn-info btn-xs text-white px-2 py-0" style="font-size: 10px;">Show</a>
                                    <a href="{{ route('corrective_actions.edit', $item->id) }}" class="btn btn-warning btn-xs text-white px-2 py-0" style="font-size: 10px;">Edit</a>
                                    <form action="{{ route('corrective_actions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this action plan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs px-2 py-0" style="font-size: 10px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted" style="font-size: 11px;">
                                No corrective actions found. Click "+ Create New Plan" to start.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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
</style>
@endsection