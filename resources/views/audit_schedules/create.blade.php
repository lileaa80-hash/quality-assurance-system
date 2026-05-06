@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm border-0">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3 px-4">
            <h6 class="mb-0 fw-bold">SPMI SYSTEM - Create New Audit Schedule</h6>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('audit_schedules.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Audit Number</label>
                            <input type="text" name="audit_number" class="form-control" value="{{ old('audit_number', 'AUD' . time()) }}" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Title / Agenda Name</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter agenda title..." value="{{ old('title') }}" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-muted text-uppercase">Period Year</label>
                                <input type="number" name="period_year" class="form-control" value="{{ old('period_year', 2026) }}" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-muted text-uppercase">Semester</label>
                                <select name="period_semester" class="form-select" required>
                                    <option value="ganjil">Ganjil</option>
                                    <option value="genap">Genap</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-muted text-uppercase">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-muted text-uppercase">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Standards Used</label>
                            <div class="p-3 border rounded bg-light" style="max-height: 120px; overflow-y: auto;">
                                @foreach($standards as $std)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="standards_used[]" value="{{ $std->id }}" id="std_{{ $std->id }}">
                                        <label class="form-check-label small" for="std_{{ $std->id }}">
                                            {{ $std->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Notes</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Enter additional notes...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('audit_schedules.index') }}" class="btn btn-light btn-sm px-4 border">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 shadow-sm">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection