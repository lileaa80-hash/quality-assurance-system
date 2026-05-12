@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="fas fa-list-alt me-2"></i> Accreditation Borang Management
            </h6>
            <a href="{{ route('accreditation_borangs.create') }}" class="btn btn-light btn-sm fw-bold px-3 shadow-sm" style="font-size: 11px; color: #0d6efd;">
                <i class="fas fa-plus me-1"></i> FILL NEW BORANG
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase text-muted small fw-bold" style="font-size: 10px;">
                            <th class="ps-4 py-3" style="width: 25%;">Standard & Period</th>
                            <th class="py-3">Filler</th>
                            <th class="py-3 text-center">Score (Self/Assr)</th>
                            <th class="py-3 text-center">Supporting Docs</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borangs as $item)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary" style="font-size: 13px;">{{ $item->standard_name }}</div>
                                <div class="text-muted small">Periode: {{ $item->period_name }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $item->filler_name }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 11px; font-weight: 500;">
                                    {{ $item->self_assessment_score ?? 0 }}
                                </span>
                                <span class="mx-1 text-muted">/</span>
                                <span class="badge bg-primary text-white px-2 py-1" style="font-size: 11px;">
                                    {{ $item->assessor_score ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $docs = json_decode($item->supporting_documents, true);
                                    $count = is_array($docs) ? count($docs) : 0;
                                @endphp
                                <div class="text-muted small">
                                    <i class="fas fa-file-alt me-1"></i> {{ $count }} Files
                                </div>
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
                                <span class="badge {{ $statusBadge }} text-uppercase" style="font-size: 9px; padding: 5px 10px; letter-spacing: 0.5px;">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center align-items-center flex-nowrap gap-1">
                                    <a href="{{ route('accreditation_borangs.show', $item->id) }}" class="btn btn-info btn-sm text-white px-3 fw-bold" style="font-size: 10px;">
                                        VIEW
                                    </a>
                                    <a href="{{ route('accreditation_borangs.edit', $item->id) }}" class="btn btn-warning btn-sm text-white px-3 fw-bold" style="font-size: 10px;">
                                        EDIT
                                    </a>
                                    <form action="{{ route('accreditation_borangs.destroy', $item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Delete this borang?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-3 fw-bold" style="font-size: 10px;">
                                            DELETE
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted small">
                                <i class="fas fa-inbox fa-2x d-block mb-2 opacity-25"></i>
                                No data available.
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
    /* Menghilangkan border default tabel yang mengganggu visual tombol */
    .table td {
        border-color: #f0f0f0;
    }
    /* Tombol tetap solid dan tidak ada outline aneh */
    .btn-sm {
        border-radius: 4px;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    /* Efek hover lembut pada baris */
    .table-hover tbody tr:hover {
        background-color: #fbfcfe !important;
    }
</style>
@endsection