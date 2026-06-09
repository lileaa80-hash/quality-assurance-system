@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">SPMI SYSTEM - Register New Document</h6>
        </div>
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm border-0 small">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">DOCUMENT NUMBER</label>
                        <input type="text" name="document_number" class="form-control form-control-sm shadow-sm" placeholder="e.g. 090808" value="{{ old('document_number') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">TITLE</label>
                        <input type="text" name="title" class="form-control form-control-sm shadow-sm" placeholder="Enter document title..." value="{{ old('title') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">DOCUMENT TYPE</label>
                        <select name="type" class="form-select form-select-sm shadow-sm" required>
                            <option value="" selected disabled>-- Select Type --</option>
                            <option value="SOP" {{ old('type') == 'SOP' ? 'selected' : '' }}>SOP</option>
                            <option value="Manual Mutu" {{ old('type') == 'Manual Mutu' ? 'selected' : '' }}>Manual Mutu</option>
                            <option value="Standard" {{ old('type') == 'Standard' ? 'selected' : '' }}>Standard</option>
                            <option value="Formulir" {{ old('type') == 'Formulir' ? 'selected' : '' }}>Formulir</option>
                            <option value="Pedoman" {{ old('type') == 'Pedoman' ? 'selected' : '' }}>Pedoman</option>
                            <option value="Kebijakan" {{ old('type') == 'Kebijakan' ? 'selected' : '' }}>Kebijakan</option>
                            <option value="Laporan" {{ old('type') == 'Laporan' ? 'selected' : '' }}>Laporan</option>
                            <option value="Sertifikat" {{ old('type') == 'Sertifikat' ? 'selected' : '' }}>Sertifikat</option>
                            <option value="Borang" {{ old('type') == 'Borang' ? 'selected' : '' }}>Borang</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">STATUS</label>
                        <select name="status" class="form-select form-select-sm shadow-sm" required>
                            <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Review" {{ old('status') == 'Review' ? 'selected' : '' }}>Review</option>
                            <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published</option>
                            <option value="Archived" {{ old('status') == 'Archived' ? 'selected' : '' }}>Archived</option>
                            <option value="Obsolete" {{ old('status') == 'Obsolete' ? 'selected' : '' }}>Obsolete</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">EFFECTIVE DATE</label>
                        <input type="date" name="effective_date" class="form-control form-control-sm shadow-sm" value="{{ old('effective_date') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">IS CONTROLLED?</label>
                        <select name="is_controlled" class="form-select form-select-sm shadow-sm">
                            <option value="1" {{ old('is_controlled') == '1' ? 'selected' : '' }}>Yes (Controlled)</option>
                            <option value="0" {{ old('is_controlled') == '0' ? 'selected' : '' }}>No (Uncontrolled)</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">UPLOAD DOCUMENT FILE</label>
                        <input type="file" name="file_dokumen" class="form-control form-control-sm shadow-sm" required>
                        <div class="form-text text-muted" style="font-size: 11px;">Format file yang diizinkan: PDF, DOCX, XLSX, atau XLSM (Maks. 20MB).</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">DESCRIPTION</label>
                        <textarea name="description" class="form-control form-control-sm shadow-sm" rows="3" placeholder="Enter document description...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('documents.index') }}" class="btn btn-light btn-sm px-3 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm" style="font-size: 11px;">Save Document</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection