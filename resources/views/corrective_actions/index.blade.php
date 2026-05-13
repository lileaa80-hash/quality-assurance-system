@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2 px-4" style="border-radius: 4px 4px 0 0;">
            <h6 class="mb-0 fw-bold" style="letter-spacing: 0.5px; font-size: 14px;">Corrective Action Management (CAPA)</h6>
            <a href="{{ route('corrective_actions.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px; color: #333;">
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
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold" style="width: 15%; letter-spacing: 0.5px;">CA NUMBER</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 25%; letter-spacing: 0.5px;">FINDING & UNIT</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 20%; letter-spacing: 0.5px;">RESPONSIBLE (PIC)</th>
                            <th class="py-3 text-muted small fw-bold text-center" style="letter-spacing: 0.5px;">TARGET DATE</th>
                            <th class="py-3 text-muted small fw-bold text-center" style="letter-spacing: 0.5px;">VERIFICATION</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4" style="letter-spacing: 0.5px;">ACTIONS</th>
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
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('corrective_actions.show', $item->id) }}" class="btn btn-info btn-xs text-white fw-bold shadow-sm">Show</a>
                                    <a href="{{ route('corrective_actions.edit', $item->id) }}" class="btn btn-warning btn-xs text-white fw-bold shadow-sm">Edit</a>
                                    <form action="{{ route('corrective_actions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this action plan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs fw-bold shadow-sm">Delete</button>
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
    /* Styling Buttons agar seragam dengan modul lain */
    .btn-xs {
        padding: 2px 8px;
        font-size: 10px;
        line-height: 1.5;
        border-radius: 4px;
        border: none;
        transition: transform 0.1s ease;
    }
    
    .btn-xs:hover {
        transform: translateY(-1px);
        filter: brightness(95%);
    }

    /* Warna Tombol Spesifik */
    .btn-info { background-color: #00d2ff; } /* Biru Muda (Show) */
    .btn-warning { background-color: #ffc107; color: white !important; } /* Kuning (Edit) */
    .btn-danger { background-color: #f82c44; } /* Merah (Delete) */

    /* Row Hover */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Border per baris agar lebih clean */
    .table td, .table th {
        border-bottom: 1px solid #f2f2f2;
    }
</style>
@endsection