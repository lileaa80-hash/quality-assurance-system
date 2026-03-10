@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Unit Details</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr><td class="fw-bold text-muted" width="40%">Unit Code</td><td>: {{ $unit->code }}</td></tr>
                    <tr><td class="fw-bold text-muted">Unit Name</td><td>: {{ $unit->name }}</td></tr>
                    <tr><td class="fw-bold text-muted">Type</td><td>: <span class="badge bg-secondary">{{ strtoupper($unit->type) }}</span></td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr><td class="fw-bold text-muted" width="40%">Head Name</td><td>: {{ $unit->head_name ?? '-' }}</td></tr>
                    <tr><td class="fw-bold text-muted">Status</td><td>: 
                        <span class="badge {{ $unit->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $unit->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td></tr>
                </table>
            </div>
        </div>
        <hr class="text-muted opacity-25">
        <div class="mt-2">
            <a href="{{ route('units.index') }}" class="btn btn-secondary btn-sm">Back</a>
            <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-warning btn-sm text-white">Edit This Unit</a>
        </div>
    </div>
</div>
@endsection