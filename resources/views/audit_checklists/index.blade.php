@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Audit Checklist Reports</h5>
            <a href="{{ route('audit_checklists.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add New Audit
            </a>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="px-4 py-3 border-0">NO</th>
                            <th class="py-3 border-0">UNIT</th>
                            <th class="py-3 border-0">STANDARD & INDICATOR</th>
                            <th class="py-3 border-0 text-center">RESULT</th>
                            <th class="py-3 border-0">AUDITOR</th>
                            <th class="px-4 py-3 border-0 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($checklists as $index => $item)
                        <tr>
                            <td class="px-4 fw-bold text-secondary">
                                {{ $index + 1 }}
                            </td>
                            <td class="fw-bold text-dark">{{ $item->unit_name }}</td>
                            <td>
                                <div class="text-muted small mb-1">{{ $item->standard_name }}</div>
                                <div class="fw-bold text-primary" style="font-size: 0.9rem;">{{ $item->indicator_name }}</div>
                            </td>
                            <td class="text-center">
                                @php
                                    $badgeClass = [
                                        'compliant' => 'bg-success',
                                        'partially_compliant' => 'bg-warning text-dark',
                                        'non_compliant' => 'bg-danger',
                                        'not_applicable' => 'bg-secondary'
                                    ][$item->result] ?? 'bg-dark';
                                @endphp
                                <span class="badge {{ $badgeClass }} px-2 py-1 fw-bold text-uppercase" style="font-size: 10px; border-radius: 4px;">
                                    {{ str_replace('_', ' ', $item->result) }}
                                </span>
                            </td>
                            <td class="text-muted fw-semibold">{{ $item->auditor_name }}</td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('audit_checklists.show', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('audit_checklists.edit', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('audit_checklists.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this report?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-white px-2 py-1" style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open mb-2 d-block fa-2x"></i>
                                No audit records found. Click <strong>"+ Add New Audit"</strong> to start.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing 1 to {{ count($checklists) }} of {{ count($checklists) }} records</small>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection