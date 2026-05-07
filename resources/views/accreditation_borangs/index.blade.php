@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Accreditation Borang Management</h6>
            <a href="{{ route('accreditation_borangs.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                + Fill New Borang
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
                            <th class="ps-4 py-3 text-muted small fw-bold" style="width: 25%;">STANDARD & PERIOD</th>
                            <th class="py-3 text-muted small fw-bold">FILLER</th>
                            <th class="py-3 text-muted small fw-bold text-center">SCORE (SELF/ASSR)</th>
                            <th class="py-3 text-muted small fw-bold text-center">DOCS</th>
                            <th class="py-3 text-muted small fw-bold text-center">STATUS</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borangs as $item)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ $item->standard_name }}</div>
                                <div class="text-muted" style="font-size: 10px;">Periode: {{ $item->period_name }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $item->filler_name }}</div>
                                <div class="text-muted" style="font-size: 9px;">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 10px;">
                                    {{ $item->self_assessment_score ?? 0 }}
                                </span>
                                <span class="mx-1">/</span>
                                <span class="badge bg-primary text-white px-2 py-1" style="font-size: 10px;">
                                    {{ $item->assessor_score ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $docs = json_decode($item->supporting_documents, true);
                                    $count = is_array($docs) ? count($docs) : 0;
                                @endphp
                                <span class="text-muted" style="font-size: 11px;">
                                    <i class="bi bi-file-earmark-text"></i> {{ $count }} Files
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusBadge = [
                                        'draft' => 'bg-secondary',
                                        'submitted' => 'bg-info text-white',
                                        'verified' => 'bg-success',
                                        'revised' => 'bg-danger'
                                    ][$item->status] ?? 'bg-dark';
                                @endphp
                                <span class="badge {{ $statusBadge }} px-2 py-1" style="font-size: 9px; border-radius: 4px;">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('accreditation_borangs.show', $item->id) }}" class="btn btn-info btn-xs text-white px-2 py-0" style="font-size: 10px;">View</a>
                                    <a href="{{ route('accreditation_borangs.edit', $item->id) }}" class="btn btn-warning btn-xs text-white px-2 py-0" style="font-size: 10px;">Edit</a>
                                    <form action="{{ route('accreditation_borangs.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this borang?')">
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
                                No borang data found.
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
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endsection