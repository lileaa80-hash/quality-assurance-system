@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-warning py-3 px-4">
            <h5 class="mb-0 fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">
                <i class="fas fa-edit me-2"></i> Edit File Attachment Configuration
            </h5>
        </div>

        <div class="card-body p-4 bg-white">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-4 border-0 d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('file_attachments.update', $attachment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">File Profile (Read-Only)</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Original Filename</label>
                            <input type="text" class="form-control bg-light" value="{{ $attachment->original_filename }}" readonly style="height: 45px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Polymorphic Target Instance</label>
                            <input type="text" class="form-control bg-light" value="{{ str_replace('App\\Models\\', '', $attachment->attachable_type) }} [ID: #{{ $attachment->attachable_id }}]" readonly style="height: 45px;">
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Metrics & Assignment Updates</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">File Version (Versi Arsip)</label>
                            <input type="number" name="version" class="form-control shadow-sm border-secondary-subtle" value="{{ old('version', $attachment->version) }}" min="1" required style="height: 45px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Assigned Officer / Uploader</label>
                            <select name="uploaded_by" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="" disabled>-- Select Officer --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('uploaded_by', $attachment->uploaded_by) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Active Status Control</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    
                    <div class="p-3 rounded border bg-light">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_current" value="1" id="editIsCurrent" {{ old('is_current', $attachment->is_current) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark small" for="editIsCurrent" style="cursor: pointer;">
                                <i class="fas fa-check-circle text-success me-1 small"></i> Set as Current Active Version (Tetapkan Sebagai Berkas Utama yang Aktif)
                            </label>
                        </div>
                    </div>
                    <div class="form-text ps-1 mt-2" style="font-size: 10px; font-style: italic; color: #6c757d;">
                        * Catatan: Jika opsi di atas diaktifkan, sistem secara otomatis akan menonaktifkan tanda versi utama aktif pada file-file lampiran lama lainnya yang terikat pada objek modul yang sama.
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('file_attachments.index') }}" class="btn btn-outline-secondary px-4 fw-bold border-2" style="font-size: 13px;">CANCEL</a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold shadow-sm text-dark" style="font-size: 13px;">UPDATE PARAMETERS</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection