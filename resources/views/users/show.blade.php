@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - User Profile Details</h5>
            <a href="{{ route('users.index') }}" class="btn btn-light btn-sm px-3 shadow-sm">Back to List</a>
        </div>

        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-4 border-end">
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold">User Information</label>
                        <h3 class="fw-bold text-dark mb-1">{{ $user->name }}</h3>
                        <p class="text-muted small">{{ $user->email }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold d-block mb-2">Status Account</label>
                        <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }} px-3 py-2 fs-6 shadow-sm">
                            {{ strtoupper($user->status ?? 'ACTIVE') }}
                        </span>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning text-white w-100 shadow-sm fw-bold">
                            <i class="fas fa-edit me-1"></i> Edit Profile
                        </a>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase small text-muted mb-3 border-bottom pb-2">System Information</h6>
                        <div class="bg-light rounded p-3 border shadow-sm">
                            <div class="row mb-2 small">
                                <div class="col-sm-4 text-muted">Join Date</div>
                                <div class="col-sm-8 fw-bold">: {{ $user->created_at->format('d M Y, H:i') }}</div>
                            </div>
                            <div class="row mb-0 small">
                                <div class="col-sm-4 text-muted">Last Update</div>
                                <div class="col-sm-8 fw-bold text-primary">: {{ \Carbon\Carbon::parse($user->updated_at)->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h6 class="fw-bold text-uppercase small text-muted mb-3">Documents Created ({{ count($documents) }})</h6>
                        <div class="table-responsive border rounded shadow-sm">
                            <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3 fw-bold">Doc Number</th>
                                        <th class="fw-bold">Title</th>
                                        <th class="fw-bold text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($documents as $doc)
                                    <tr>
                                        <td class="ps-3 fw-bold text-primary">{{ $doc->document_number }}</td>
                                        <td>{{ $doc->title }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-outline-primary py-0 px-2">View</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center py-3 text-muted italic">No documents found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection