@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Upload New Document Version</h6>
        </div>

        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-3 border-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('document_versions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">DOCUMENT SELECTION</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">TARGET DOCUMENT</label>
                            <select name="document_id" class="form-select form-select-sm shadow-sm" required>
                                <option value="" selected disabled>-- Select Document --</option>
                                @foreach($documents as $doc)
                                    <option value="{{ $doc->id }}" {{ old('document_id') == $doc->id ? 'selected' : '' }}>
                                        [{{ $doc->document_number }}] {{ $doc->title }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text mt-1" style="font-size: 10px;">The system will automatically increment the version number.</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">FILE & VERSION DETAILS</h6>
                    <div class="row g-3">
                        {{-- File Upload --}}
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-muted small mb-1">FILE ATTACHMENT (MAX 20MB)</label>
                            <input type="file" name="file" class="form-control form-control-sm shadow-sm" required>
                        </div>
                        
                        {{-- Status Selection --}}
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">INITIAL STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-sm" required>
                                <option value="current" selected>Current (Active)</option>
                                <option value="previous">Previous</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">CHANGE LOG</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">CHANGE DESCRIPTION / NOTES</label>
                            <textarea name="change_description" class="form-control form-control-sm shadow-sm" rows="4" placeholder="Briefly describe what changed in this version...">{{ old('change_description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('document_versions.index') }}" class="btn btn-light btn-sm px-3 fw-bold border">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm">Upload & Process</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection