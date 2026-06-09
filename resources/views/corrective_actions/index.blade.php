@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Corrective Actions (CAPA)</h5>
            <a href="{{ route('corrective_actions.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Create New Plan
            </a>
        </div>
        
        <div class="card-body p-0">
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
                            <th class="px-4 py-3 border-0" style="width: 15%;">CA NUMBER</th>
                            <th class="py-3 border-0" style="width: 25%;">FINDING & UNIT</th>
                            <th class="py-3 border-0" style="width: 20%;">RESPONSIBLE (PIC)</th>
                            <th class="py-3 border-0 text-center">TARGET DATE</th>
                            <th class="py-3 border-0 text-center">VERIFICATION</th>
                            <th class="px-4 py-3 border-0 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($actions as $item)
                        <tr>
                            <td class="px-4">
                                <div class="fw-bold text-primary">{{ $item->ca_number }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ strtoupper($item->cause_category) }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->unit_name }}</div>
                                <div class="text-muted small">Ref: {{ $item->finding_number }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $item->pic_name }}</div>
                            </td>
                            <td class="text-center">
                                <div class="{{ \Carbon\Carbon::parse($item->target_completion_date)->isPast() && $item->final_status != 'closed' ? 'text-danger fw-bold' : 'text-dark' }}">
                                    {{ \Carbon\Carbon::parse($item->target_completion_date)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $vBadge = [
                                        'pending' => 'bg-warning text-dark',
                                        'verified' => 'bg-success text-white',
                                        'rejected' => 'bg-danger text-white'
                                    ][$item->verification_status] ?? 'bg-dark text-white';
                                @endphp
                                <span class="badge {{ $vBadge }} px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px; min-width: 60px;">
                                    {{ strtoupper($item->verification_status) }}
                                </span>
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('corrective_actions.show', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('corrective_actions.edit', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('corrective_actions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this action plan?')" class="d-inline">
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
                                No corrective actions found. Click "+ Create New Plan" to start.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing 1 to {{ count($actions) }} of {{ count($actions) }} records</small>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection