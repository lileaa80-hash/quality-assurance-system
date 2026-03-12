@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Assign New Audit Team Member</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('audit_teams.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">AUDIT SCHEDULE</label>
                            <select name="audit_schedule_id" class="form-select form-select-sm" required>
                                <option value="" selected disabled>-- Select Audit Schedule --</option>
                                @foreach($schedules as $sch)
                                    <option value="{{ $sch->id }}">{{ $sch->audit_number }} - {{ $sch->title }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Link this member to an existing audit schedule.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">AUDITOR NAME</label>
                            <select name="user_id" class="form-select form-select-sm" required>
                                <option value="" selected disabled>-- Select Auditor --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">ROLE</label>
                            <select name="role" class="form-select form-select-sm" required>
                                <option value="lead_auditor">Lead Auditor</option>
                                <option value="auditor" selected>Auditor</option>
                                <option value="observer">Observer</option>
                                <option value="trainee">Trainee</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 border-start">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">ASSIGNED UNITS</label>
                            <div class="p-2 border rounded bg-light" style="max-height: 120px; overflow-y: auto;">
                                @foreach($units as $unit)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="assigned_units[]" value="{{ $unit->id }}" id="unit{{ $unit->id }}">
                                        <label class="form-check-label small" for="unit{{ $unit->id }}">{{ $unit->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_certified" value="1" id="isCertified">
                                <label class="form-check-label small fw-bold" for="isCertified">Is Certified Auditor?</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">CERTIFICATE NUMBER</label>
                            <input type="text" name="certificate_number" class="form-control form-control-sm" placeholder="Ex: CERT/2026/001">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">REMARKS / NOTES</label>
                            <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="Additional details..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-end border-top pt-3 mt-3">
                    <a href="{{ route('audit_teams.index') }}" class="btn btn-secondary btn-sm rounded-0 px-3">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm rounded-0 px-4 fw-bold">Save Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection