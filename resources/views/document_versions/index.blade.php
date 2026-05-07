@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Document Version History</h6>
            <a href="{{ route('document_versions.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                + Upload New Version
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
                            <th class="ps-4 py-3 text-muted small fw-bold" style="width: 25%;">DOCUMENT & VERSION</th>
                            <th class="py-3 text-muted small fw-bold">FILE INFO</th>
                            <th class="py-3 text-muted small fw-bold text-center">SIZE</th>
                            <th class="py-3 text-muted small fw-bold text-center">UPLOADER</th>
                            <th class="py-3 text-muted small fw-bold text-center">STATUS</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($versions as $item)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ $item->document_title }}</div>
                                <div class="badge bg-light text-dark border" style="font-size: 9px;">
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
                                        'current' => 'bg-success',
                                        'previous' => 'bg-warning text-dark',
                                        'archived' => 'bg-secondary',
                                    ][$item->status] ?? 'bg-dark';
                                @endphp
                                <span class="badge {{ $statusBadge }} px-2 py-1" style="font-size: 9px; border-radius: 4px;">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('document_versions.show', $item->id) }}" class="btn btn-info btn-xs text-white px-2 py-0" style="font-size: 10px;">View</a>
                                    <a href="{{ route('document_versions.edit', $item->id) }}" class="btn btn-warning btn-xs text-white px-2 py-0" style="font-size: 10px;">Edit</a>
                                    <form action="{{ route('document_versions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus versi ini? File di storage juga akan dihapus.')">
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
                                No document versions found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($versions, 'links'))
        <div class="card-footer bg-white py-2">
            {{ $versions->links() }}
        </div>
        @endif
    </div>
    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - Document Management
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
    .table-hover tbody tr:hover {
        background-color: #f1f5f9;
    }
</style>
@endsection