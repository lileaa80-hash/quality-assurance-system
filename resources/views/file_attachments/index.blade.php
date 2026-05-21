@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 8px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">File Attachment Master</h6>
            <a href="{{ route('file_attachments.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                <i class="fas fa-plus me-1"></i> UPLOAD NEW FILE
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm" style="background-color: #d4edda; color: #155724;">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger m-3 py-2 small border-0 shadow-sm" style="background-color: #f8d7da; color: #721c24;">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 12px;">
                    <thead>
                        <tr class="bg-white">
                            <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">Target Object Relational</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">File Information</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">Version System</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">Size (MB)</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Uploaded By</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attachments as $attachment)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary" style="font-size: 11px;">
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

                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('file_attachments.show', $attachment->id) }}" 
                                       class="btn btn-info btn-xs text-white px-2 py-1 fw-bold" 
                                       style="font-size: 10px; min-width: 45px;">View</a>
                                    
                                    <a href="{{ route('file_attachments.edit', $attachment->id) }}" 
                                       class="btn btn-warning btn-xs text-white px-2 py-1 fw-bold" 
                                       style="font-size: 10px; min-width: 45px;">Edit</a>
                                    
                                    <form action="{{ route('file_attachments.destroy', $attachment->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah anda yakin ingin menghapus arsip file ini dari kluster storage?')" class="d-inline">
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
                                <span style="font-size: 11px;">Belum ada berkas lampiran (attachments) yang diunggah ke sistem.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($attachments, 'links'))
        <div class="card-footer bg-white py-2 border-top">
            <div class="d-flex justify-content-center">
                {{ $attachments->links() }}
            </div>
        </div>
        @endif
    </div>

    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | File Storage Management Controls
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