@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Document Version History</h5>
            <a href="{{ route('document_versions.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Upload New Version
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="ps-4 py-3 border-0" style="width: 25%;">Document & Version</th>
                            <th class="py-3 border-0" style="width: 25%;">File Info</th>
                            <th class="py-3 border-0 text-center">Size</th>
                            <th class="py-3 border-0 text-center">Uploader</th>
                            <th class="py-3 border-0 text-center">Status</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($versions as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $item->document_title }}</div>
                                <div class="badge bg-light text-dark border mt-1" style="font-size: 9px; font-weight: 500;">
                                    Version {{ $item->version_number }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ Str::limit($item->file_name, 30) }}</div>
                                <div class="text-muted" style="font-size: 9px;">Type: {{ $item->mime_type }}</div>
                            </td>
                            <td class="text-center text-muted">
                                {{ number_format($item->file_size / 1024, 2) }} KB
                            </td>
                            <td class="text-center">
                                <div class="fw-bold text-dark">{{ $item->creator_name }}</div>
                                <div class="text-muted" style="font-size: 10px;">
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
                                <span class="badge {{ $statusBadge }} px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px; min-width: 65px; letter-spacing: 0.3px;">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('document_versions.show', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('document_versions.edit', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('document_versions.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus versi ini permanen?')">
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
                                <i class="fas fa-folder-open d-block mb-2 fa-2x opacity-25"></i>
                                No document versions found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $versions->count() }} records
                </small>
                @if(method_exists($versions, 'links'))
                    <div>
                        {{ $versions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Document Management Control
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
        transition: 0.2s;
    }
</style>
@endsection