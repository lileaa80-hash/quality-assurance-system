@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Document Details</h5>
            <span class="badge bg-light text-primary">{{ $document->document_number }}</span>
        </div>
        <div class="card-body p-5">
            <div class="row border-bottom pb-3 mb-3">
                <div class="col-md-3 text-secondary fw-bold">Document Title</div>
                <div class="col-md-9 fs-5 fw-bold text-dark">{{ $document->title }}</div>
            </div>
            
            <div class="row border-bottom pb-3 mb-3">
                <div class="col-md-3 text-secondary fw-bold">Category & Status</div>
                <div class="col-md-9">
                    <span class="badge bg-warning text-dark px-3 py-2 me-2">{{ $document->type }}</span>
                    <span class="badge bg-danger px-3 py-2">{{ strtoupper($document->status) }}</span>
                </div>
            </div>

            <div class="row border-bottom pb-3 mb-3">
                <div class="col-md-3 text-secondary fw-bold">Description</div>
                <div class="col-md-9 text-muted">{{ $document->description ?? 'No description provided.' }}</div>
            </div>

            <div class="row pb-3">
                <div class="col-md-3 text-secondary fw-bold">Created By</div>
                <div class="col-md-9"><i class="text-primary fw-bold">Erlina Chantika</i></div>
            </div>

            <div class="mt-5 d-flex gap-2">
                <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">Back to List</a>
                <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning text-white shadow-sm px-4">Edit Data</a>
            </div>
        </div>
    </div>
</div>
@endsection