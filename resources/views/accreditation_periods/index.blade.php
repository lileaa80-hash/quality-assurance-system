@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Accreditation Period Management</h6>
            <a href="{{ route('accreditation_periods.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                + Add New Period
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
                            <th class="ps-4 py-3 text-muted small fw-bold" style="width: 25%;">PERIOD NAME & UNIT</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 15%;">TYPE</th>
                            <th class="py-3 text-muted small fw-bold text-center">TIMELINE</th>
                            <th class="py-3 text-muted small fw-bold text-center">GRADE/SCORE</th>
                            <th class="py-3 text-muted small fw-bold text-center">STATUS</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periods as $item)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ $item->period_name }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ $item->unit_name }}</div>
                            </td>
                            <td>
                                <span class="text-dark fw-semibold" style="font-size: 11px;">{{ strtoupper($item->type) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}</div>
                                <div class="text-muted" style="font-size: 10px;">Deadline: {{ $item->submission_deadline ? \Carbon\Carbon::parse($item->submission_deadline)->format('d/m/Y') : '-' }}</div>
                            </td>
                            <td class="text-center">
                                @if($item->result_grade)
                                    <div class="badge bg-light text-primary border border-primary px-2 py-1" style="font-size: 10px;">
                                        Grade: {{ $item->result_grade }}
                                    </div>
                                    <div class="text-muted mt-1" style="font-size: 9px;">Score: {{ $item->result_score ?? 'N/A' }}</div>
                                @else
                                    <span class="text-muted small">Not Assessed</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    $statusBadge = [
                                        'planned' => 'bg-secondary',
                                        'preparation' => 'bg-info text-white',
                                        'submitted' => 'bg-primary',
                                        'assesment' => 'bg-warning text-dark',
                                        'completed' => 'bg-success',
                                        'postponed' => 'bg-danger'
                                    ][$item->status] ?? 'bg-dark';
                                @endphp
                                <span class="badge {{ $statusBadge }} px-2 py-1" style="font-size: 9px; border-radius: 4px;">
                                    {{ strtoupper(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('accreditation_periods.show', $item->id) }}" class="btn btn-info btn-xs text-white px-2 py-0" style="font-size: 10px;">View</a>
                                    <a href="{{ route('accreditation_periods.edit', $item->id) }}" class="btn btn-warning btn-xs text-white px-2 py-0" style="font-size: 10px;">Edit</a>
                                    <form action="{{ route('accreditation_periods.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs px-2 py-0" style="font-size: 10px;">Del</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted" style="font-size: 11px;">
                                No accreditation periods found.
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