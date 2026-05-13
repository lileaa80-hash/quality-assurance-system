@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 8px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Document Version History</h6>
            <a href="{{ route('document_versions.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                <i class="fas fa-plus me-1"></i> UPLOAD NEW VERSION
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm" style="background-color: #d4edda; color: #155724;">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 12px;">
                    <thead>
                        <tr class="bg-white">
                            <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">DOCUMENT & VERSION</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">FILE INFO</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">SIZE</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">UPLOADER</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">STATUS</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($versions as $item)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ $item->document_title }}</div>
                                <div class="badge bg-light text-dark border mt-1" style="font-size: 9px; font-weight: 500;">
                                    Version {{ $item->version_number }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ Str::limit($item->file_name, 30) }}</div>
                                <div class="text-muted" style="font-size: 9px;">Type: {{ $item->mime_type }}</div>
                            </td>
                            <td class="text-center">
                                <span class="text-muted" style="font-size: 11px;">
                                    {{ number_format($item->file_size / 1024, 2) }} KB
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="fw-semibold">{{ $item->creator_name }}</div>
                                <div class="text-muted" style="font-size: 9px;">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/y H:i') }}
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusBadge = [
                                        'current' => 'bg-success text-white',
                                        'previous' => 'bg-warning text-dark',
                                        'archived' => 'bg-secondary text-white',
                                    ][$item->status] ?? 'bg-dark text-white';
                                @endphp
                                <span class="badge {{ $statusBadge }} px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px; min-width: 65px;">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('document_versions.show', $item->id) }}" 
                                       class="btn btn-info btn-xs text-white px-2 py-1 fw-bold" 
                                       style="font-size: 10px; min-width: 45px;">View</a>
                                    
                                    <a href="{{ route('document_versions.edit', $item->id) }}" 
                                       class="btn btn-warning btn-xs text-white px-2 py-1 fw-bold" 
                                       style="font-size: 10px; min-width: 45px;">Edit</a>
                                    
                                    <form action="{{ route('document_versions.destroy', $item->id) }}" method="POST" 
                                          onsubmit="return confirm('Hapus versi ini permanen?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs text-white px-2 py-1 fw-bold" 
                                                style="font-size: 10px; min-width: 45px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open d-block mb-2 fa-2x opacity-25"></i>
                                <span style="font-size: 11px;">No document versions found.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($versions, 'links'))
        <div class="card-footer bg-white py-2 border-top">
            <div class="d-flex justify-content-center">
                {{ $versions->links() }}
            </div>
        </div>
        @endif
    </div>
    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Document Management Control
    </div>
</div>
<style>
    .btn-xs {
        padding: 2px 6px;
        font-size: 10px;
        line-height: 1.2;
        border-radius: 3px;
    }
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
        transition: 0.2s;
    }
    .badge {
        letter-spacing: 0.3px;
    }
</style>
@endsection