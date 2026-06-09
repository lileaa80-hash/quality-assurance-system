@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Accreditation Periods</h5>
            <a href="{{ route('accreditation_periods.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add New Period
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
                            <th class="px-4 py-3 border-0" style="width: 25%;">PERIOD NAME & UNIT</th>
                            <th class="py-3 border-0" style="width: 15%;">TYPE</th>
                            <th class="py-3 border-0 text-center">TIMELINE</th>
                            <th class="py-3 border-0 text-center">GRADE/SCORE</th>
                            <th class="py-3 border-0 text-center">STATUS</th>
                            <th class="px-4 py-3 border-0 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($periods as $item)
                        <tr>
                            <td class="px-4">
                                <div class="fw-bold text-primary" style="font-size: 13px;">{{ $item->period_name }}</div>
                                <div class="text-muted small mt-1" style="font-weight: 500;">
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
                                    <span class="text-muted small" style="font-style: italic;">Not Assessed</span>
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

                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('accreditation_periods.show', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('accreditation_periods.edit', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('accreditation_periods.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')" class="d-inline">
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
                                No accreditation periods found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing 1 to {{ count($periods) }} of {{ count($periods) }} records</small>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection