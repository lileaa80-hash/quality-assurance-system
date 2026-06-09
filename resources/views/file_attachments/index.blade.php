@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - File Attachments</h5>
            <a href="{{ route('file_attachments.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Upload New File
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
                            <th class="px-4 py-3 border-0" style="width: 25%;">Target Object Relational</th>
                            <th class="py-3 border-0" style="width: 25%;">File Information</th>
                            <th class="py-3 border-0 text-center">Version System</th>
                            <th class="py-3 border-0 text-center">Size (MB)</th>
                            <th class="py-3 border-0">Uploaded By</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($attachments as $attachment)
                        <tr>
                            <td class="px-4">
                                <div class="fw-bold text-primary" style="font-size: 13px;">
                                    {{ str_replace('App\\Models\\', '', $attachment->attachable_type) }}
                                </div>
                                <div class="text-muted text-truncate mt-1" style="font-size: 10px; max-width: 200px;">
                                    ID Object Reference: #{{ $attachment->attachable_id }}
                                </div>
                            </td>
                            
                            <td>
                                <div class="fw-semibold text-dark text-truncate" style="max-width: 250px;" title="{{ $attachment->original_filename }}">
                                    <i class="far fa-file-alt text-secondary me-1"></i> {{ $attachment->original_filename }}
                                </div>
                                <div class="text-muted mt-1" style="font-size: 10px;">
                                    Storage: <span class="badge bg-light text-secondary border py-0 px-1">{{ $attachment->disk }}</span>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-secondary text-white px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px;">
                                    v{{ $attachment->version }}
                                </span>
                                @if($attachment->is_current)
                                    <div class="mt-1">
                                        <span class="badge bg-success text-white px-1" style="font-size: 8px; font-weight: 500; letter-spacing: 0.2px;">ACTIVE v1</span>
                                    </div>
                                @endif
                            </td>

                            <td class="text-center fw-medium text-secondary">
                                {{ number_format($attachment->file_size / (1024 * 1024), 2) }} MB
                            </td>

                            <td>
                                <div class="fw-semibold text-dark">{{ $attachment->uploader_name }}</div>
                                <div class="text-muted opacity-75" style="font-size: 9px;">
                                    {{ date('d M Y, H:i', strtotime($attachment->created_at)) }}
                                </div>
                            </td>

                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('file_attachments.show', $attachment->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('file_attachments.edit', $attachment->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('file_attachments.destroy', $attachment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah anda yakin ingin menghapus arsip file ini dari kluster storage?')">
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
                                Belum ada berkas lampiran (attachments) yang diunggah ke sistem.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($attachments, 'links') && $attachments->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-center">
                    {{ $attachments->links() }}
                </div>
            </div>
            @else
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing 1 to {{ count($attachments) }} of {{ count($attachments) }} records</small>
            </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | File Storage Management Controls
    </div>
</div>
@endsection