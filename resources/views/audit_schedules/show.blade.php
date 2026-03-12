@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Detail Audit Schedule</h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small fw-bold">AUDIT NUMBER</label>
                    <p class="fw-bold">{{ $schedule->audit_number }}</p>
                    
                    <label class="text-muted small fw-bold">TITLE</label>
                    <p>{{ $schedule->title }}</p>

                    <label class="text-muted small fw-bold">TYPE / SCOPE</label>
                    <p>{{ ucfirst($schedule->type) }} / {{ ucfirst($schedule->scope) }}</p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small fw-bold">DATE RANGE</label>
                    <p>{{ $schedule->start_date }} s/d {{ $schedule->end_date }}</p>

                    <label class="text-muted small fw-bold">STATUS</label>
                    <div><span class="badge bg-info text-uppercase">{{ $schedule->status }}</span></div>
                </div>
            </div>
            <div class="border-top pt-3">
                <a href="{{ route('audit_schedules.index') }}" class="btn btn-secondary btn-sm rounded-0">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection