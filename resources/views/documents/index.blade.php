@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">SPMI Document Management</h4>
                    <a href="{{ route('documents.create') }}" class="btn btn-light btn-sm">+ Register Document</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-hover mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Doc. Number</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $doc->document_number }}</span></td>
                                <td><strong>{{ $doc->title }}</strong></td>
                                <td>{{ $doc->type }}</td>
                                <td>
                                    <span class="badge {{ $doc->status == 'published' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ strtoupper($doc->status) }}
                                    </span>
                                </td>
                                <td>{{ $doc->creator_name }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        
                                        <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No documents found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection