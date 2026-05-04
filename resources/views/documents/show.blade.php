@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
       
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 0.8rem 1.5rem;">
            <h5 class="mb-0 fw-bold">Detailed Document View</h5>
            <a href="{{ route('documents.index') }}" class="btn btn-light btn-sm fw-bold text-primary px-3 shadow-sm">
                Back to List
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <tbody>
                        <tr>
                            <th class="px-4 py-3 border-0 bg-light text-secondary" width="30%">Document Number</th>
                            <td class="px-4 py-3 border-0">
                                <span class="badge bg-secondary px-2">#{{ $document->document_number }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3 border-0 bg-light text-secondary">Title</th>
                            <td class="px-4 py-3 border-0 fw-bold">{{ $document->title }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3 border-0 bg-light text-secondary">Type</th>
                            <td class="px-4 py-3 border-0">
                                <span class="badge bg-primary px-3 text-uppercase" style="font-size: 0.75rem;">{{ $document->type }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3 border-0 bg-light text-secondary">Status</th>
                            <td class="px-4 py-3 border-0">
                                <span class="badge bg-success px-3 text-uppercase" style="font-size: 0.75rem;">{{ $document->status }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3 border-0 bg-light text-secondary">Description</th>
                            <td class="px-4 py-3 border-0 text-muted">{{ $document->description }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3 border-0 bg-light text-secondary">Created By</th>
                            <td class="px-4 py-3 border-0">{{ $document->creator->name ?? 'Erlina Chantika' }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3 border-0 bg-light text-secondary">Effective Date</th>
                            <td class="px-4 py-3 border-0 text-primary fw-bold">{{ $document->effective_date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-4 d-flex justify-content-end">
            <a href="{{ route('documents.edit', $document->id) }}" class="btn fw-bold px-4 shadow-sm" style="background-color: #ffc107; color: #fff;">
                Modify Data
            </a>
        </div>
    </div>
</div>
@endsection