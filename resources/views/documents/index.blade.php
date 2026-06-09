@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Documents List</h5>
            <a href="{{ route('documents.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add New Document
            </a>
        </div>
        
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 border-0 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="px-4 py-3 border-0">NO</th>
                            <th class="py-3 border-0">FULL NAME</th>
                            <th class="py-3 border-0">EMAIL ADDRESS</th>
                            <th class="py-3 border-0">STATUS</th>
                            <th class="px-4 py-3 border-0 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $index => $doc)
                        <tr>
                            <td class="px-4 fw-bold text-secondary">
                                {{ $index + 1 }}
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
                                <span class="badge text-uppercase px-3" style="font-size: 0.75rem; background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 4px;">{{ $doc->status }}</span>
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-white px-2 py-1" style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <span class="text-muted">No documents found.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing 1 to {{ count($documents) }} of {{ count($documents) }} documents</small>
            </div>
        </div>
    </div>
</div>
@endsection