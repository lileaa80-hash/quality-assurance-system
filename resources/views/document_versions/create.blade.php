@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 800px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Upload New Document Version</h6>
        </div>

        <div class="card-body p-4">
            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-3 border-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Informasi Dokumen Induk --}}
            <div class="alert alert-info border-0 shadow-sm py-2 mb-4" style="background-color: #e7f3ff;">
                <div class="small fw-bold text-primary">Target Document:</div>
                <div class="fw-bold">{{ $document->title }} ({{ $document->document_number ?? 'No Number' }})</div>
            </div>

            <form action="{{ route('document_versions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Hidden input penting agar tidak kehilangan relasi ke dokumen --}}
                <input type="hidden" name="document_id" value="{{ $document->id }}">
                
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">FILE & VERSION INFO</h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-muted small mb-1">SELECT FILE (PDF, DOCX, etc.)</label>
                            <input type="file" name="document_file" class="form-control form-control-sm shadow-sm @error('document_file') is-invalid @enderror" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">VERSION NO.</label>
                            <input type="number" step="1" name="version_number" class="form-control form-control-sm shadow-sm" 
                                   placeholder="e.g. 2" value="{{ old('version_number', $nextVersion) }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">VERSION STATUS</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">SET AS CURRENT VERSION?</label>
                            <select name="status" class="form-select form-select-sm shadow-sm" required>
                                <option value="current" {{ old('status') == 'current' ? 'selected' : '' }}>Yes, make this the active version</option>
                                <option value="previous" {{ old('status') == 'previous' ? 'selected' : '' }}>No, keep as previous/history</option>
                            </select>
                            <div class="form-text mt-1" style="font-size: 10px;">
                                *If set to "current", other versions will automatically become "previous".
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">REVISION NOTES</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">CHANGE DESCRIPTION</label>
                            <textarea name="change_description" class="form-control form-control-sm shadow-sm" rows="3" 
                                      placeholder="What changes were made in this version?">{{ old('change_description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm px-3 fw-bold border">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm">Upload & Save Version</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection