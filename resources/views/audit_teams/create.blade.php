@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary py-3 px-4">
            <h6 class="mb-0 fw-bold text-white text-uppercase">Assign New Audit Team Member</h6>
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
            <form action="{{ route('audit_teams.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Audit Schedule</label>
                            <select name="audit_schedule_id" class="form-select" required>
                                <option value="" selected disabled>-- Select Audit Schedule --</option>
                                @foreach($schedules as $sch)
                                    <option value="{{ $sch->id }}">{{ $sch->audit_number }} - {{ $sch->title }}</option>
                                @endforeach
                            </select>
                            <div class="form-text small text-muted">Link this member to an existing audit schedule.</div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Auditor Name</label>
                            <select name="user_id" class="form-select" required>
                                <option value="" selected disabled>-- Select Auditor --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="lead_auditor">Lead Auditor</option>
                                <option value="auditor" selected>Auditor</option>
                                <option value="observer">Observer</option>
                                <option value="trainee">Trainee</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 border-start">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Assigned Units</label>
                            <div class="p-3 border rounded bg-light" style="max-height: 120px; overflow-y: auto;">
                                @foreach($units as $unit)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="assigned_units[]" value="{{ $unit->id }}" id="unit{{ $unit->id }}">
                                        <label class="form-check-label small" for="unit{{ $unit->id }}">{{ $unit->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4 d-flex align-items-center gap-3">
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" name="is_certified" value="1" id="isCertified">
                                <label class="form-check-label small fw-bold text-muted text-uppercase" for="isCertified">Is Certified Auditor?</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Certificate Number</label>
                            <input type="text" name="certificate_number" class="form-control" placeholder="Ex: CERT/2026/001">
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Remarks / Notes</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Additional details..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('audit_teams.index') }}" class="btn btn-secondary btn-sm px-4 shadow-sm">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">Save Member</button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted small">
        &copy; 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection