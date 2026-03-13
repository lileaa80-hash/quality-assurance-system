@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Register New Document</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('documents.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Document Number</label>
                            <input type="text" name="document_number" class="form-control" placeholder="e.g. 001/SPMI/2024" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter document title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Document Type</label>
                            <select name="type" class="form-select">
                                <option value="Standard">Standard</option>
                                <option value="Policy">Policy</option>
                                <option value="Manual">Manual</option>
                                <option value="Form">Form</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('documents.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Document</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection