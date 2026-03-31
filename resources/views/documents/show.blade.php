@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Document Details: {{ $document->document_number }}</h5>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Title</th>
                    <td>{{ $document->title }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td><span class="badge bg-primary">{{ strtoupper($document->type) }}</span></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><span class="badge bg-success">{{ strtoupper($document->status) }}</span></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $document->description }}</td>
                </tr>
                <tr>
                    <th>Created By</th>
                    <td>{{ $document->creator->name ?? 'System' }}</td>
                </tr>
                <tr>
                    <th>Effective Date</th>
                    <td>{{ $document->effective_date }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning">Edit Document</a>
        </div>
    </div>
</div>
@endsection