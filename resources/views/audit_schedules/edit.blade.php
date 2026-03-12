@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning py-2 text-dark">
            <h6 class="mb-0 fw-bold">Edit Schedule: {{ $schedule->audit_number }}</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger small py-2">
                    <ul class="mb-0">
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
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">TITLE</label>
                            <input type="text" name="title" class="form-control form-control-sm" value="{{ $schedule->title }}" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">AUDIT TYPE</label>
                                <select name="type" class="form-select form-select-sm" required>
                                    <option value="internal" {{ $schedule->type == 'internal' ? 'selected' : '' }}>Internal</option>
                                    <option value="external" {{ $schedule->type == 'external' ? 'selected' : '' }}>External</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">SCOPE</label>
                                <select name="scope" class="form-select form-select-sm" required>
                                    <option value="program" {{ $schedule->scope == 'program' ? 'selected' : '' }}>Program</option>
                                    <option value="institutional" {{ $schedule->scope == 'institutional' ? 'selected' : '' }}>Institutional</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">PERIOD YEAR</label>
                                <input type="number" name="period_year" class="form-control form-control-sm" value="{{ $schedule->period_year }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">SEMESTER</label>
                                <select name="period_semester" class="form-select form-select-sm">
                                    <option value="ganjil" {{ $schedule->period_semester == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="genap" {{ $schedule->period_semester == 'genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 border-start">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">START DATE</label>
                                <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $schedule->start_date }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">END DATE</label>
                                <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $schedule->end_date }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">STATUS</label>
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="planned" {{ $schedule->status == 'planned' ? 'selected' : '' }}>Planned</option>
                                <option value="ongoing" {{ $schedule->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ $schedule->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">STANDARDS USED</label>
                            <div class="p-2 border rounded bg-light" style="max-height: 100px; overflow-y: auto;">
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

                <div class="text-end border-top pt-3 mt-3">
                    <a href="{{ route('audit_schedules.index') }}" class="btn btn-secondary btn-sm rounded-0">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm rounded-0 px-4 fw-bold">Update Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection