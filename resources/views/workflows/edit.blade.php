@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-warning py-3 px-4">
            <h5 class="mb-0 fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">
                <i class="fas fa-edit me-2"></i> EDIT WORKFLOW
            </h5>
        </div>

        <div class="card-body p-4 bg-white">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-4 border-0 d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('workflows.update', $workflow->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Workflow Identity</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Workflow Name</label>
                            <input type="text" name="name" class="form-control shadow-sm border-secondary-subtle" value="{{ old('name', $workflow->name) }}" placeholder="e.g., Standard Document Approval" required style="height: 45px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Unique Code</label>
                            <input type="text" name="code" class="form-control shadow-sm border-secondary-subtle" value="{{ old('code', $workflow->code) }}" placeholder="e.g., WF-DOC-01" required style="height: 45px;">
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Classification & Type</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Workflow Type</label>
                            <select name="type" class="form-select shadow-sm border-secondary-subtle" required style="height: 45px;">
                                <option value="" disabled>-- Select Workflow Type --</option>
                                <option value="document_approval" {{ old('type', $workflow->type) == 'document_approval' ? 'selected' : '' }}>DOCUMENT APPROVAL</option>
                                <option value="audit_report_approval" {{ old('type', $workflow->type) == 'audit_report_approval' ? 'selected' : '' }}>AUDIT REPORT APPROVAL</option>
                                <option value="corrective_action_approval" {{ old('type', $workflow->type) == 'corrective_action_approval' ? 'selected' : '' }}>CORRECTIVE ACTION APPROVAL</option>
                                <option value="accreditation_approval" {{ old('type', $workflow->type) == 'accreditation_approval' ? 'selected' : '' }}>ACCREDITATION APPROVAL</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">Details & Rules</h6>
                    <hr class="mt-0 mb-4 opacity-25">
                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1 text-uppercase">Description</label>
                            <textarea name="description" class="form-control shadow-sm border-secondary-subtle" rows="4" placeholder="Enter workflow description or notes here...">{{ old('description', $workflow->description) }}</textarea>
                        </div>
                    </div>

                    <div class="p-3 rounded border bg-light">
                        <div class="form-check">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="editIsActive" {{ old('is_active', $workflow->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark small" for="editIsActive" style="cursor: pointer;">
                                <i class="fas fa-toggle-on text-success me-1 small"></i> Active Status (Alur kerja ini dapat digunakan sistem)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('workflows.index') }}" class="btn btn-outline-secondary px-4 fw-bold border-2" style="font-size: 13px;">CANCEL</a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold shadow-sm text-dark" style="font-size: 13px;">UPDATE DATA</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection