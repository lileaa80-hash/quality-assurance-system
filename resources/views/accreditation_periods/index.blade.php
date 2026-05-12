@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold" style="letter-spacing: 0.5px;">ACCREDITATION PERIOD MANAGEMENT</h6>
            <a href="{{ route('accreditation_periods.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm px-3" style="font-size: 11px; border-radius: 5px;">
                <i class="fas fa-plus me-1"></i> ADD NEW PERIOD
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm" style="background-color: #d4edda; color: #155724;">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="bg-light">
                            <th class="ps-4 py-3 text-dark small fw-bold" style="width: 25%;">PERIOD NAME & UNIT</th>
                            <th class="py-3 text-dark small fw-bold" style="width: 15%;">TYPE</th>
                            <th class="py-3 text-dark small fw-bold text-center">TIMELINE</th>
                            <th class="py-3 text-dark small fw-bold text-center">GRADE/SCORE</th>
                            <th class="py-3 text-dark small fw-bold text-center">STATUS</th>
                            <th class="py-3 text-dark small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periods as $item)
                        <tr class="align-middle">
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-primary" style="font-size: 13px;">{{ $item->period_name }}</div>
                                <div class="text-muted" style="font-size: 10px; font-weight: 500;">
                                    <i class="fas fa-university me-1"></i>{{ $item->unit_name }}
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border fw-bold text-uppercase" style="font-size: 10px; letter-spacing: 0.3px;">
                                    {{ $item->type }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="fw-bold text-dark" style="font-size: 12px;">{{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}</div>
                                <div class="text-muted" style="font-size: 10px;">
                                    Deadline: <span class="text-danger fw-bold">{{ $item->submission_deadline ? \Carbon\Carbon::parse($item->submission_deadline)->format('d/m/Y') : '-' }}</span>
                                </div>
                            </td>

                            <td class="text-center">
                                @if($item->result_grade)
                                    <div class="badge bg-primary px-2 py-1" style="font-size: 10px; font-weight: 700;">
                                        GRADE: {{ $item->result_grade }}
                                    </div>
                                    <div class="text-muted mt-1" style="font-size: 10px;">Score: {{ $item->result_score ?? 'N/A' }}</div>
                                @else
                                    <span class="text-muted italic small" style="font-size: 11px;">Not Assessed</span>
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
                                <span class="badge {{ $statusBadge }} px-2 py-1 text-uppercase" style="font-size: 9px; border-radius: 4px; min-width: 85px;">
                                    {{ str_replace('_', ' ', $item->status) }}
                                </span>
                            </td>

                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('accreditation_periods.show', $item->id) }}" class="btn btn-info btn-sm text-white px-2 py-1" style="font-size: 10px; min-width: 50px; font-weight: 600;">
                                        Show
                                    </a>
                                    <a href="{{ route('accreditation_periods.edit', $item->id) }}" class="btn btn-warning btn-sm text-white px-2 py-1" style="font-size: 10px; min-width: 50px; font-weight: 600;">
                                        Edit
                                    </a>
                                    <form action="{{ route('accreditation_periods.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-2 py-1" style="font-size: 10px; min-width: 55px; font-weight: 600;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <p class="text-muted small mb-0">No accreditation periods found.</p>
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
    .table thead th {
        border-top: none;
        border-bottom: 1px solid #eee;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table tbody td {
        border-bottom: 1px solid #f8f9fa;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.02);
    }
    .badge {
        letter-spacing: 0.3px;
    }
    .italic {
        font-style: italic;
    }
    .btn-sm {
        border-radius: 4px;
    }
</style>
@endsection