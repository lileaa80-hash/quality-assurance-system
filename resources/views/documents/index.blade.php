@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Documents List</h5>
        </div>
        
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 fw-bold text-secondary">Documents Management</h4>
                <a href="{{ route('documents.create') }}" class="btn btn-primary shadow-sm">Add New Document</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">Code / No</th>
                            <th class="py-3">Title & Creator</th>
                            <th class="py-3">Description</th>
                            <th class="py-3">Type</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td>
                                <span class="badge bg-secondary px-2 py-2">{{ $doc->document_number }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $doc->title }}</div>
                                <small class="text-muted">{{ $doc->creator->name ?? 'Erlina Chantika' }}</small>
                            </td>
                            <td>
                                <small class="text-muted">{{ Str::limit($doc->description ?? 'No description', 30) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark">{{ $doc->type }}</span>
                            </td>
                            <td>
                                <span class="badge bg-danger text-uppercase" style="font-size: 0.7rem;">{{ $doc->status }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-info btn-sm text-white">Show</a>
                                    <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No documents found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection