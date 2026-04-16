@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Document Version Details</h6>
            <a href="{{ route('document_versions.index', ['document_id' => $version->document_id]) }}" class="btn btn-light btn-sm fw-bold border shadow-sm" style="font-size: 11px;">
                Back to Version History
            </a>
        </div>

        <div class="card-body p-0">
            {{-- Status & Version Header --}}
            <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small fw-bold text-uppercase">Status:</span>
                    @php
                        $statusBadge = [
                            'current' => 'bg-success',
                            'previous' => 'bg-warning text-dark',
                            'archived' => 'bg-secondary',
                        ][$version->status] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $statusBadge }} px-3 py-2" style="font-size: 11px; border-radius: 4px;">
                        {{ strtoupper($version->status) }}
                    </span>

                    <span class="text-muted small fw-bold text-uppercase ms-2">Version:</span>
                    <span class="badge bg-white text-primary border border-primary px-3 py-2" style="font-size: 11px; border-radius: 4px;">
                        V{{ $version->version_number }}
                    </span>
                </div>
                <div class="text-muted small text-end">
                    <strong>Document:</strong> <span class="text-primary fw-bold">{{ $version->document->title }}</span>
                </div>
            </div>

            <div class="p-4">
                <div class="row g-4">
                    {{-- File Information --}}
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block mb-1">FILE NAME</label>
                        <p class="fw-bold border-start border-primary border-3 ps-2 text-dark">
                            {{ $version->file_name }}
                        </p>
                    </div>

                    <div class="col-md-6 text-md-end">
                        <label class="text-muted small fw-bold d-block mb-1">FILE SIZE</label>
                        <h4 class="fw-bold text-primary mb-0">
                            {{ number_format($version->file_size / 1024, 2) }} <small class="fw-normal">KB</small>
                        </h4>
                        <small class="text-muted">Type: {{ strtoupper($version->mime_type) }}</small>
                    </div>

                    {{-- Revision Description --}}
                    <div class="col-12">
                        <div class="bg-light p-3 rounded border shadow-sm">
                            <h6 class="text-primary fw-bold small mb-2"><i class="fas fa-history me-2"></i>CHANGE DESCRIPTION / LOG</h6>
                            <p class="mb-0 small text-dark" style="line-height: 1.6;">
                                {{ $version->change_description ?: 'No revision notes provided for this version.' }}
                            </p>
                        </div>
                    </div>

                    {{-- Metadata & Actions --}}
                    <div class="col-md-12">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small fw-bold d-block mb-1">UPLOADED BY</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle text-muted me-2 fa-lg"></i>
                                    <span class="small text-dark fw-bold">{{ $version->creator->name ?? 'Unknown User' }}</span>
                                    <span class="ms-2 text-muted small">on {{ $version->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                            @if($version->approved_by)
                            <div class="col-md-6 text-md-end">
                                <label class="text-muted small fw-bold d-block mb-1">APPROVED BY</label>
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <span class="small text-dark fw-bold">{{ $version->approver->name ?? 'N/A' }}</span>
                                    <span class="ms-2 text-muted small">at {{ $version->approved_at->format('d M Y') }}</span>
                                    <i class="fas fa-check-circle text-success ms-2"></i>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Download Section --}}
                    <div class="col-md-12">
                        <div class="p-3 bg-white rounded border shadow-sm d-flex align-items-center justify-content-between border-start border-success border-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-download text-success me-3 fa-lg"></i>
                                <div>
                                    <span class="text-dark small d-block fw-bold">Download File</span>
                                    <span class="small text-muted italic">Click the button to get the file for this version</span>
                                </div>
                            </div>
                            <a href="{{ Storage::url($version->file_path) }}" target="_blank" class="btn btn-success btn-sm px-3 fw-bold shadow-sm" style="font-size: 10px;">
                                <i class="fas fa-download me-1"></i> DOWNLOAD FILE
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <form action="{{ route('document_versions.destroy', $version->id) }}" method="POST" onsubmit="return confirm('WARNING: Deleting a version cannot be undone. Proceed?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold" style="font-size: 11px;">
                            Delete Version
                        </button>
                    </form>
                    <a href="{{ route('document_versions.edit', $version->id) }}" class="btn btn-warning btn-sm px-4 fw-bold text-white shadow-sm" style="font-size: 11px;">
                        Edit Metadata
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>

<style>
    .italic { font-style: italic; }
</style>
@endsection