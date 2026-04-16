@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 800px; margin: auto;">
        <div class="card-header bg-warning py-2">
            <h6 class="mb-0 fw-bold text-dark">Edit Version Details: v{{ $version->version_number }}</h6>
        </div>

        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger py-2 small shadow-sm mb-3 border-0">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Info File Saat Ini (Read Only) --}}
            <div class="alert alert-light border shadow-sm py-2 mb-4 d-flex align-items-center">
                <div class="me-3">
                    <i class="bi bi-file-earmark-check text-primary" style="font-size: 2rem;"></i>
                </div>
                <div>
                    <div class="small fw-bold text-muted">CURRENT FILE:</div>
                    <div class="fw-bold text-dark">{{ $version->file_name }}</div>
                    <div class="text-muted" style="font-size: 10px;">
                        Uploaded by {{ $version->creator->name ?? 'System' }} on {{ $version->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>

            <form action="{{ route('document_versions.update', $version->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">VERSION CONFIGURATION</h6>
                    <div class="row g-3">
                        {{-- Version Number --}}
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">VERSION NO.</label>
                            <input type="number" name="version_number" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('version_number', $version->version_number) }}" required>
                        </div>

                        {{-- Status Selection --}}
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-muted small mb-1">AVAILABILITY STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-sm" required>
                                @foreach(['current' => 'Current (Active)', 'previous' => 'Previous (History)', 'archived' => 'Archived'] as $val => $label)
                                    <option value="{{ $val }}" {{ $version->status == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">REVISION LOG</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">CHANGE DESCRIPTION</label>
                            <textarea name="change_description" class="form-control form-control-sm shadow-sm" rows="4">{{ old('change_description', $version->change_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('document_versions.index', ['document_id' => $version->document_id]) }}" 
                       class="btn btn-light btn-sm px-3 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm px-3 fw-bold shadow-sm" style="font-size: 11px;">
                        Update Version Info
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection