@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Audit Checklist Report Management</h6>
            <a href="{{ route('audit_checklists.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                + Add New Audit
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm" style="background-color: #d4edda;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 12px;">
                    <thead class="bg-white">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold" style="width: 20%;">UNIT</th>
                            <th class="py-3 text-muted small fw-bold" style="width: 35%;">STANDARD & INDICATOR</th>
                            <th class="py-3 text-muted small fw-bold text-center">RESULT</th>
                            <th class="py-3 text-muted small fw-bold">AUDITOR</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($checklists as $item)
                        <tr class="align-middle">
                            <td class="ps-4 fw-bold text-dark">{{ $item->unit_name }}</td>
                            <td>
                                <div class="text-muted small">{{ $item->standard_name }}</div>
                                <div class="fw-semibold">{{ $item->indicator_name }}</div>
                            </td>
                            <td class="text-center">
                                @php
                                    $badge = [
                                        'compliant' => 'bg-success',
                                        'partially_compliant' => 'bg-warning text-dark',
                                        'non_compliant' => 'bg-danger',
                                        'not_applicable' => 'bg-secondary'
                                    ][$item->result] ?? 'bg-dark';
                                @endphp
                                <span class="badge {{ $badge }} px-2 py-1" style="font-size: 9px; border-radius: 4px;">
                                    {{ strtoupper(str_replace('_', ' ', $item->result)) }}
                                </span>
                            </td>
                            <td class="text-muted">{{ $item->auditor_name }}</td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('audit_checklists.show', $item->id) }}" class="btn btn-info btn-xs text-white px-2 py-0" style="font-size: 10px;">Show</a>
                                    <a href="{{ route('audit_checklists.edit', $item->id) }}" class="btn btn-warning btn-xs text-white px-2 py-0" style="font-size: 10px;">Edit</a>
                                    <form action="{{ route('audit_checklists.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this report?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs px-2 py-0" style="font-size: 10px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted" style="font-size: 11px;">
                                No audit records found. Click "+ Add New Audit" to start.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection