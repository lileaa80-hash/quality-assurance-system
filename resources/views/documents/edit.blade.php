@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark py-3">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Edit Document</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('documents.update', $document->id) }}" method="POST">
                @csrf
                @method('PUT') 
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Document Number</label>
                    <input type="text" name="document_number" class="form-control bg-light" value="{{ $document->document_number }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Document Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $document->title }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-secondary">Document Type</label>
                        <select name="type" class="form-select">
                            <option value="Standard" {{ $document->type == 'Standard' ? 'selected' : '' }}>Standard</option>
                            <option value="Policy" {{ $document->type == 'Policy' ? 'selected' : '' }}>Policy</option>
                            <option value="Manual" {{ $document->type == 'Manual' ? 'selected' : '' }}>Manual</option>
                            <option value="Form" {{ $document->type == 'Form' ? 'selected' : '' }}>Form</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                         <label class="form-label fw-bold text-secondary">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft" {{ $document->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $document->status == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $document->description }}</textarea>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <a href="{{ route('documents.index') }}" class="btn btn-light border px-4">Cancel</a>
                    <button type="submit" class="btn btn-warning px-4 shadow-sm text-white">Update Document</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection