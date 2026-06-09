@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Accreditation Borangs</h5>
            <a href="{{ route('accreditation_borangs.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Fill New Borang
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
                            <th class="px-4 py-3 border-0" style="width: 25%;">Standard & Period</th>
                            <th class="py-3 border-0">Filler</th>
                            <th class="py-3 border-0 text-center">Score (Self/Assr)</th>
                            <th class="py-3 border-0 text-center">Supporting Docs</th>
                            <th class="py-3 border-0 text-center">Status</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($borangs as $item)
                        <tr>
                            <td class="px-4">
                                <div class="fw-bold text-primary" style="font-size: 13px;">{{ $item->standard_name }}</div>
                                <div class="text-muted small mt-1">Periode: {{ $item->period_name }}</div>
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
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('accreditation_borangs.show', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('accreditation_borangs.edit', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('accreditation_borangs.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this borang?')">
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
                                No data available.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing 1 to {{ count($borangs) }} of {{ count($borangs) }} records</small>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection