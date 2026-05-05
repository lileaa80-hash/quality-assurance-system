@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Documents List</h5>
            <a href="{{ route('documents.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3">
                Add New Document
            </a>
        </div>
        
        <div class="card-body p-0">
            <div class="px-4 py-3">
                <h4 class="mb-0 fw-bold text-secondary">Documents Management</h4>
            </div>

            @if(session('success'))
                <div class="alert alert-success m-3 border-0 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light text-uppercase" style="font-size: 0.85rem;">
                        <tr>
                            <th class="px-4 py-3 border-0">Code / No</th>
                            <th class="py-3 border-0">Title & Creator</th>
                            <th class="py-3 border-0">Description</th>
                            <th class="py-3 border-0">Type</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td class="px-4">
                                <span class="badge bg-secondary opacity-75">{{ $doc->document_number }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $doc->title }}</div>
                                <small class="text-muted">{{ $doc->creator->name ?? 'Erlina Chantika' }}</small>
                            </td>
                            <td>
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                    {{ Str::limit($doc->description ?? 'No description', 40) }}
                                </p>
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark text-uppercase" style="font-size: 0.7rem;">{{ $doc->type }}</span>
                            </td>
                            <td>
                                <span class="badge bg-danger text-uppercase px-3" style="font-size: 0.7rem;">{{ $doc->status }}</span>
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-info text-white border-0" style="background-color: #17a2b8;">Show</a>
                                    <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-sm btn-warning text-white border-0" style="background-color: #ffc107;">Edit</a>
                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger border-0" style="background-color: #dc3545;" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <span class="text-muted">No documents found.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-0 py-3">
                <small class="text-muted">Showing {{ count($documents) }} documents</small>
            </div>
        </div>
    </div>
</div>
@endsection