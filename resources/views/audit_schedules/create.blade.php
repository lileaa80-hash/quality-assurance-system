@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-2 text-center">
            <h6 class="mb-0 fw-bold">Create New Audit Schedule</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('audit_schedules.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold small text-muted">Audit Number</label>
                            <input type="text" name="audit_number" class="form-control form-control-sm" value="{{ old('audit_number', 'AUD' . time()) }}" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold small text-muted">Title / Agenda Name</label>
                            <input type="text" name="title" class="form-control form-control-sm" value="{{ old('title') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3 text-start">
                                <label class="form-label fw-bold small text-muted">Period Year</label>
                                <input type="number" name="period_year" class="form-control form-control-sm" value="{{ old('period_year', 2026) }}" required>
                            </div>
                            <div class="col-md-6 mb-3 text-start">
                                <label class="form-label fw-bold small text-muted">Semester</label>
                                <select name="period_semester" class="form-select form-select-sm" required>
                                    <option value="ganjil">Ganjil</option>
                                    <option value="genap">Genap</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 border-start">
                        <div class="row">
                            <div class="col-md-6 mb-3 text-start">
                                <label class="form-label fw-bold small text-muted">Start Date</label>
                                <input type="date" name="start_date" class="form-control form-control-sm" value="{{ old('start_date') }}" required>
                            </div>
                            <div class="col-md-6 mb-3 text-start">
                                <label class="form-label fw-bold small text-muted">End Date</label>
                                <input type="date" name="end_date" class="form-control form-control-sm" value="{{ old('end_date') }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold small text-muted">Standards Used</label>
                            <div class="p-2 border rounded bg-light" style="max-height: 120px; overflow-y: auto;">
                                @foreach($standards as $std)
                                    <div class="form-check">
                                        {{-- INI BAGIAN PALING PENTING: standards_used[] --}}
                                        <input class="form-check-input" type="checkbox" name="standards_used[]" value="{{ $std->id }}" id="std_{{ $std->id }}">
                                        <label class="form-check-label small" for="std_{{ $std->id }}">
                                            {{ $std->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold small text-muted">Notes</label>
                            <textarea name="notes" class="form-control form-control-sm" rows="2">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary btn-sm px-5 shadow-sm">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection