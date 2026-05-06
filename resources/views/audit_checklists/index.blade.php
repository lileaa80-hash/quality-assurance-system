@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-white text-uppercase">Audit Checklist Report Management</h6>
            <a href="{{ route('audit_checklists.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm px-3">
                <i class="fas fa-plus me-1"></i> + Add New Audit
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">
                            <th class="ps-4 py-3 text-muted fw-bold">Unit</th>
                            <th class="py-3 text-muted fw-bold">Standard & Indicator</th>
                            <th class="py-3 text-muted fw-bold text-center">Result</th>
                            <th class="py-3 text-muted fw-bold">Auditor</th>
                            <th class="py-3 text-muted fw-bold text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($checklists as $item)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">{{ $item->unit_name }}</td>
                            
                            <td>
                                <div class="text-muted small mb-1">{{ $item->standard_name }}</div>
                                <div class="fw-bold text-primary">{{ $item->indicator_name }}</div>
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
                            
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('audit_checklists.show', $item->id) }}" class="btn btn-info btn-sm text-white px-2 py-1" style="font-size: 11px;">Show</a>
                                    <a href="{{ route('audit_checklists.edit', $item->id) }}" class="btn btn-warning btn-sm text-white px-2 py-1" style="font-size: 11px;">Edit</a>
                                    <form action="{{ route('audit_checklists.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this report?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-2 py-1" style="font-size: 11px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open mb-2 d-block fa-2x"></i>
                                No audit records found. Click <strong>"+ Add New Audit"</strong> to start.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection