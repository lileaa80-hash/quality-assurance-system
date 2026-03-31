@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Unit Details</h5>
        </div>

        <div class="card-body p-4">
            <div class="mb-4">
                <h4 class="fw-bold text-secondary">Unit / Department Information</h4>
            </div>

            <div class="border-top border-bottom py-3">
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">Unit Code</div>
                    <div class="col-sm-9">: {{ $unit->code }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">Unit Name</div>
                    <div class="col-sm-9">: {{ $unit->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">Type</div>
                    <div class="col-sm-9">: 
                        <span class="badge bg-light text-dark border px-3">
                            {{ strtoupper($unit->type) }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">Level</div>
                    <div class="col-sm-9 text-capitalize">: {{ $unit->level }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">Head Name</div>
                    <div class="col-sm-9">: {{ $unit->head_name ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">Parent Unit</div>
                    <div class="col-sm-9">: {{ $unit->parent->name ?? 'None (Top Level)' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">Accreditation</div>
                    <div class="col-sm-9">: 
                        <span class="badge bg-info text-white">{{ $unit->accreditation_status ?? 'Not Set' }}</span>
                        @if($unit->accreditation_expiry)
                            <small class="text-muted ms-2">(Expires: {{ date('d M Y', strtotime($unit->accreditation_expiry)) }})</small>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">Status</div>
                    <div class="col-sm-9">: 
                        <span class="badge {{ $unit->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $unit->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 fw-bold text-muted">Last Updated</div>
                    <div class="col-sm-9">: {{ \Carbon\Carbon::parse($unit->updated_at)->diffForHumans() }}</div>
                </div>
            </div>

            <div class="d-flex justify-content-start gap-2 mt-4">
                <a href="{{ route('units.index') }}" class="btn btn-secondary px-4">Back</a>
                <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-warning text-white px-4">Edit</a>
            </div>
        </div>

        <div class="card-footer bg-light py-2 text-center text-muted small border-0">
            © 2026 SPMI Digital System - RPL
        </div>
    </div>
</div>
@endsection