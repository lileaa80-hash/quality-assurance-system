@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Create New Audit Schedule</h6>
        </div>
        
        <div class="card-body">
            <form action="{{ route('audit_schedules.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Audit Number</label>
                            <input type="text" name="audit_number" class="form-control form-control-sm" placeholder="AUD123456" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Title / Agenda Name</label>
                            <input type="text" name="title" class="form-control form-control-sm" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">Audit Type</label>
                                <select name="type" class="form-select form-select-sm">
                                    <option value="internal">Internal</option>
                                    <option value="external">External</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">Scope</label>
                                <select name="scope" class="form-select form-select-sm">
                                    <option value="program">Program</option>
                                    <option value="institutional">Institutional</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">Period Year</label>
                                <input type="number" name="period_year" class="form-control form-control-sm" value="2026">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">Semester</label>
                                <select name="period_semester" class="form-select form-select-sm">
                                    <option value="ganjil">Ganjil</option>
                                    <option value="genap">Genap</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 border-start">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">Start Date</label>
                                <input type="date" name="start_date" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">End Date</label>
                                <input type="date" name="end_date" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Standards Used</label>
                            <div class="p-2 border rounded bg-light" style="max-height: 100px; overflow-y: auto;">
                                @forelse($standards as $std)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="standards_used[]" value="{{ $std->id }}" id="std_{{ $std->id }}">
                                        <label class="form-check-label small" for="std_{{ $std->id }}">{{ $std->name }}</label>
                                    </div>
                                @empty
                                    <small class="text-danger d-block">No standards found. Please add standards first.</small>
                                @endforelse
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Notes</label>
                            <textarea name="notes" class="form-control form-control-sm" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <a href="{{ route('audit_schedules.index') }}" class="btn btn-secondary btn-sm rounded-0 border-end border-white px-3">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm rounded-0 px-4">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection