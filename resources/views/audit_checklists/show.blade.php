@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-white text-uppercase">Audit Report Details</h6>
            <a href="{{ route('audit_checklists.index') }}" class="btn btn-light btn-sm fw-bold px-3 shadow-sm">Back to List</a>
        </div>
        
        <div class="card-body p-0">
            <div class="px-4 py-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                <span class="text-muted small fw-bold text-uppercase">Current Audit Status</span>
                @php
                    $badge = [
                        'compliant' => 'bg-success',
                        'partially_compliant' => 'bg-warning text-dark',
                        'non_compliant' => 'bg-danger',
                        'not_applicable' => 'bg-secondary'
                    ][$checklist->result] ?? 'bg-dark';
                @endphp
                <span class="badge {{ $badge }} px-3 py-2 text-uppercase" style="font-size: 0.75rem;">
                    {{ str_replace('_', ' ', $checklist->result) }}
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase" style="width: 30%;">Unit Name</th>
                            <td class="py-3 px-4 fw-bold text-primary">{{ $checklist->unit_name }}</td>
                        </tr>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase">Auditor</th>
                            <td class="py-3 px-4 fw-semibold">{{ $checklist->auditor_name }}</td>
                        </tr>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase">Standard Name</th>
                            <td class="py-3 px-4">{{ $checklist->standard_name }}</td>
                        </tr>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase">Indicator Details</th>
                            <td class="py-3 px-4 italic text-muted">{{ $checklist->indicator_text }}</td>
                        </tr>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase">Audit Score</th>
                            <td class="py-3 px-4">
                                <span class="h5 fw-bold text-primary mb-0">{{ $checklist->score ?? '0' }}</span>
                                <span class="text-muted small">/ 100</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase">Objective Evidence</th>
                            <td class="py-3 px-4">
                                <div class="p-2 border rounded bg-white min-vh-10" style="min-height: 60px; font-size: 0.9rem;">
                                    {{ $checklist->objective_evidence ?: 'No evidence recorded.' }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase">Notes / Recommendations</th>
                            <td class="py-3 px-4">
                                <p class="mb-0 text-muted small">{{ $checklist->notes ?: '-' }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4 text-end">
            <a href="{{ route('audit_checklists.edit', $checklist->id) }}" class="btn btn-warning btn-sm px-4 fw-bold shadow-sm">
                Modify Report Data
            </a>
        </div>
    </div>
    <div class="text-center mt-5 mb-4 text-muted small">
        &copy; 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection