@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning py-3 px-4">
            <h6 class="mb-0 fw-bold text-dark">SPMI SYSTEM - Edit Audit Schedule: {{ $schedule->audit_number }}</h6>
        </div>
        
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm border-0 mb-4">
                    <ul class="mb-0 small"> 
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('audit_schedules.update', $schedule->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Title / Agenda Name</label>
                            <input type="text" name="title" class="form-control" value="{{ $schedule->title }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Audit Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="internal" {{ $schedule->type == 'internal' ? 'selected' : '' }}>Internal</option>
                                    <option value="external" {{ $schedule->type == 'external' ? 'selected' : '' }}>External</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Scope</label>
                                <select name="scope" class="form-select" required>
                                    <option value="program" {{ $schedule->scope == 'program' ? 'selected' : '' }}>Program</option>
                                    <option value="institutional" {{ $schedule->scope == 'institutional' ? 'selected' : '' }}>Institutional</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Period Year</label>
                                <input type="number" name="period_year" class="form-control" value="{{ $schedule->period_year }}">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Semester</label>
                                <select name="period_semester" class="form-select">
                                    <option value="ganjil" {{ $schedule->period_semester == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="genap" {{ $schedule->period_semester == 'genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $schedule->start_date }}" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $schedule->end_date }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="planned" {{ $schedule->status == 'planned' ? 'selected' : '' }}>Planned</option>
                                <option value="ongoing" {{ $schedule->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ $schedule->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Standards Used</label>
                            <div class="p-3 border rounded bg-light" style="max-height: 120px; overflow-y: auto;">
                                @php $saved_stds = json_decode($schedule->standards_used) ?? []; @endphp
                                @foreach($standards as $std)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="standards_used[]" value="{{ $std->id }}" 
                                            {{ in_array($std->id, $saved_stds) ? 'checked' : '' }}>
                                        <label class="form-check-label small">{{ $std->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('audit_schedules.index') }}" class="btn btn-secondary btn-sm px-4">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm px-4 fw-bold">Update Schedule</button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted small">
        &copy; 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection