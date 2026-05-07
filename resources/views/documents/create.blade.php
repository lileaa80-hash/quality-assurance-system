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
            <form action="{{ route('documents.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">DOCUMENT NUMBER</label>
                        <input type="text" name="document_number" class="form-control form-control-sm shadow-sm" placeholder="e.g. 090808" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">TITLE</label>
                        <input type="text" name="title" class="form-control form-control-sm shadow-sm" placeholder="Enter document title..." required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">DOCUMENT TYPE</label>
                        <select name="type" class="form-select form-select-sm shadow-sm" required>
                            <option value="" selected disabled>-- Select Type --</option>
                            <option value="sop">SOP</option>
                            <option value="manual_mutu">Manual Mutu</option>
                            <option value="standard">Standard</option>
                            <option value="formulir">Formulir</option>
                            <option value="pedoman">Pedoman</option>
                            <option value="kebijakan">Kebijakan</option>
                            <option value="laporan">Laporan</option>
                            <option value="sertifikat">Sertifikat</option>
                            <option value="borang">Borang</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">STATUS</label>
                        <select name="status" class="form-select form-select-sm shadow-sm" required>
                            <option value="draft" selected>Draft</option>
                            <option value="review">Review</option>
                            <option value="approved">Approved</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                            <option value="obsolete">Obsolete</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">EFFECTIVE DATE</label>
                        <input type="date" name="effective_date" class="form-control form-control-sm shadow-sm">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">IS CONTROLLED?</label>
                        <select name="is_controlled" class="form-select form-select-sm shadow-sm">
                            <option value="1">Yes (Controlled)</option>
                            <option value="0">No (Uncontrolled)</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">DESCRIPTION</label>
                        <textarea name="description" class="form-control form-control-sm shadow-sm" rows="3" placeholder="Enter document description..."></textarea>
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