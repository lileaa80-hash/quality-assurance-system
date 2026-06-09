@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Document Distributions</h5>
            <a href="{{ route('document_distributions.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add Distribution
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="ps-4 py-3 border-0" style="width: 8%;">No</th>
                            <th class="py-3 border-0" style="width: 18%;">Document ID</th>
                            <th class="py-3 border-0" style="width: 18%;">Unit ID</th>
                            <th class="py-3 border-0">Type</th>
                            <th class="py-3 border-0 text-center" style="width: 15%;">Status</th>
                            <th class="px-4 py-3 border-0 text-center" style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($distributions as $d)
                        <tr>
                            <td class="ps-4 text-muted">
                                @if(method_exists($distributions, 'currentPage'))
                                    {{ ($distributions->currentPage() - 1) * $distributions->perPage() + $loop->iteration }}
                                @else
                                    {{ $loop->iteration }}
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1" style="font-weight: 600;">
                                    ID: #{{ $d->document_id }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-secondary border px-2 py-1" style="font-weight: 600;">
                                    Unit: #{{ $d->unit_id }}
                                </span>
                            </td>
                            <td>
                                <div class="text-uppercase text-dark fw-semibold" style="font-size: 11px; letter-spacing: 0.3px;">
                                    {{ str_replace('_', ' ', $d->distribution_type) }}
                                </div>
                            </td>
                            <td class="text-center">
                                @if($d->status == 'active' || $d->status == 'distributed')
                                    <span class="badge bg-success text-white px-2 py-1 shadow-sm text-uppercase" style="font-size: 9px; border-radius: 4px; min-width: 75px;">
                                        {{ $d->status }}
                                    </span>
                                @elseif($d->status == 'pending')
                                    <span class="badge bg-warning text-dark px-2 py-1 shadow-sm text-uppercase" style="font-size: 9px; border-radius: 4px; min-width: 75px;">
                                        Pending
                                    </span>
                                @else
                                    <span class="badge bg-secondary text-white px-2 py-1 shadow-sm text-uppercase" style="font-size: 9px; border-radius: 4px; min-width: 75px;">
                                        {{ $d->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('document_distributions.show', $d->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('document_distributions.edit', $d->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('document_distributions.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data distribusi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-white px-2 py-1" style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-share-alt d-block mb-2 fa-2x opacity-25"></i>
                                No document distributions found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    @if(method_exists($distributions, 'firstItem'))
                        Showing {{ $distributions->firstItem() ?? 0 }} to {{ $distributions->lastItem() ?? 0 }} of {{ $distributions->total() ?? 0 }} records
                    @else
                        Showing {{ $distributions->count() }} records
                    @endif
                </small>
                @if(method_exists($distributions, 'links'))
                    <div>
                        {{ $distributions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Document Distribution Controls
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
        transition: 0.2s;
    }
</style>
@endsection