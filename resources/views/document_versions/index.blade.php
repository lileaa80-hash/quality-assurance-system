@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-0 fw-bold">Document Version History</h5>
                <small class="opacity-75">Document: {{ $document->title }} ({{ $document->document_number }})</small>
            </div>
            {{-- PERBAIKAN: Menggunakan $document->id langsung tanpa array parameter --}}
          {{-- Ganti baris tombol Upload New Version dengan ini --}}
            <a href="/document_versions/{{ $document->id }}/create" class="btn btn-light btn-sm fw-bold shadow-sm">
                <i class="bi bi-plus-lg"></i> Upload New Version
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm" style="background-color: #d4edda;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr class="text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">
                            <th class="ps-4 py-3 text-muted fw-bold" style="width: 8%;">Ver</th>
                            <th class="py-3 text-muted fw-bold" style="width: 25%;">File Details</th>
                            <th class="py-3 text-muted fw-bold">Description & Author</th>
                            <th class="py-3 text-muted fw-bold text-center" style="width: 15%;">Status</th>
                            <th class="py-3 text-muted fw-bold text-center pe-4" style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($versions as $v)
                        <tr class="align-middle" style="font-size: 13px;">
                            <td class="ps-4">
                                <span class="badge bg-light text-primary border fw-bold px-2 py-1">
                                    v{{ $v->version_number }}
                                </span>
                            </td>

                            <td>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 200px;" title="{{ $v->file_name }}">
                                    {{ $v->file_name }}
                                </div>
                                <div class="text-muted" style="font-size: 11px;">
                                    {{ number_format($v->file_size / 1024, 2) }} KB | 
                                    <span class="text-uppercase">{{ pathinfo($v->file_name, PATHINFO_EXTENSION) ?: 'FILE' }}</span>
                                </div>
                            </td>

                            <td>
                                <div class="text-dark mb-1">{{ $v->change_description ?? 'No change description provided.' }}</div>
                                <div class="text-muted d-flex align-items-center" style="font-size: 11px;">
                                    <i class="bi bi-person-circle me-1"></i> 
                                    {{-- PERBAIKAN: Memanggil creator_name hasil join di Query Builder --}}
                                    {{ $v->creator_name ?? 'System' }} 
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-calendar3 me-1"></i> 
                                    {{-- PERBAIKAN: Carbon untuk formatting tanggal --}}
                                    {{ \Carbon\Carbon::parse($v->created_at)->format('d M Y, H:i') }}
                                </div>
                            </td>

                            <td class="text-center">
                                @php
                                    $status = strtolower($v->status);
                                    $statusColor = match($status) {
                                        'current'  => 'bg-success',
                                        'previous' => 'bg-secondary',
                                        'archived' => 'bg-dark',
                                        default    => 'bg-light text-dark border'
                                    };
                                @endphp
                                <span class="badge {{ $statusColor }} rounded-pill px-3 py-1" style="font-size: 10px;">
                                    {{ strtoupper($v->status) }}
                                </span>
                            </td>

                            <td class="text-center pe-4">
                                <div class="btn-group" role="group">
                                    {{-- PERBAIKAN: Pastikan route download sudah didefinisikan --}}
                                    <a href="{{ route('document_versions.show', $v->id) }}" class="btn btn-outline-primary btn-xs" title="Download">
                                        <i class="bi bi-download"></i> Get
                                    </a>
                                    <a href="{{ route('document_versions.edit', $v->id) }}" class="btn btn-outline-warning btn-xs" title="Edit Metadata">
                                        Edit
                                    </a>
                                    <form action="{{ route('document_versions.destroy', $v->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus versi ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-xs">
                                            Del
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="Empty" style="width: 50px; opacity: 0.3;">
                                <p class="text-muted mt-3 mb-0">No version history found for this document.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-5 text-muted small">
        <p>© 2026 SPMI Digital System - <strong>Rekayasa Perangkat Lunak</strong></p>
    </div>
</div>

<style>
    .btn-xs {
        padding: 0.25rem 0.5rem;
        font-size: 11px;
        line-height: 1.2;
        border-radius: 0.2rem;
    }
    .table thead th {
        border-top: none;
        border-bottom: 2px solid #f8f9fa;
    }
    .badge {
        letter-spacing: 0.3px;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.02);
    }
</style>
@endsection