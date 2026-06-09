@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Evaluation Questionnaires</h5>
            <a href="{{ route('evaluation_questionnaires.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add Questionnaire
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger m-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="px-4 py-3 border-0" style="width: 25%;">TITLE & TYPE</th>
                            <th class="py-3 border-0" style="width: 15%;">PERIOD</th>
                            <th class="py-3 border-0 text-center">TARGET AUDIENCE</th>
                            <th class="py-3 border-0 text-center">SETTINGS</th>
                            <th class="py-3 border-0 text-center">STATUS</th>
                            <th class="px-4 py-3 border-0 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($questionnaires as $item)
                        <tr>
                            <td class="px-4">
                                <div class="fw-bold text-primary" style="font-size: 13px;">{{ $item->title }}</div>
                                <div class="badge bg-light text-secondary border mt-1 text-uppercase" style="font-size: 9px; font-weight: 500;">
                                    {{ str_replace('_', ' ', $item->type) }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">Year: {{ $item->year }}</div>
                                <div class="text-muted" style="font-size: 10px;">Semester: {{ $item->semester ?? '-' }}</div>
                            </td>
                            <td class="text-center">
                                <div class="badge bg-info text-white text-uppercase" style="font-size: 9px;">
                                    {{ $item->target_audience }}
                                </div>
                                @if($item->target_units)
                                    <div class="text-muted mt-1" style="font-size: 9px; max-width: 150px; margin: 0 auto; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ implode(', ', json_decode($item->target_units)) }}">
                                        Units: {{ implode(', ', json_decode($item->target_units)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-center" style="font-size: 11px;">
                                <div class="text-muted">
                                    <i class="fas {{ $item->is_anonymous ? 'fa-user-secret text-success' : 'fa-user text-secondary' }} me-1"></i> 
                                    {{ $item->is_anonymous ? 'Anonymous' : 'Public' }}
                                </div>
                                <div class="text-muted" style="font-size: 9px;">
                                    Multi-submit: {!! $item->allow_multiple_submissions ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>' !!}
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusBadge = [
                                        'draft'    => 'bg-warning text-dark',
                                        'active'   => 'bg-success text-white',
                                        'closed'   => 'bg-danger text-white',
                                        'archived' => 'bg-secondary text-white',
                                    ][$item->status] ?? 'bg-dark text-white';
                                @endphp
                                <span class="badge {{ $statusBadge }} px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px; min-width: 65px;">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('evaluation_questionnaires.show', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('evaluation_questionnaires.edit', $item->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('evaluation_questionnaires.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kuesioner ini beserta data berkas fisiknya permanen?')" class="d-inline">
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
                                No evaluation questionnaires found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($questionnaires, 'links') && $questionnaires->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-center">
                    {{ $questionnaires->links() }}
                </div>
            </div>
            @else
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing 1 to {{ count($questionnaires) }} of {{ count($questionnaires) }} records</small>
            </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Questionnaire Evaluation Control
    </div>
</div>
@endsection