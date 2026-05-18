@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 8px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Evaluation Questionnaires</h6>
            <a href="{{ route('evaluation_questionnaires.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                <i class="fas fa-plus me-1"></i> ADD QUESTIONNAIRE
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm" style="background-color: #d4edda; color: #155724;">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger m-3 py-2 small border-0 shadow-sm" style="background-color: #f8d7da; color: #721c24;">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 12px;">
                    <thead>
                        <tr class="bg-white">
                            <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">TITLE & TYPE</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">PERIOD</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">TARGET AUDIENCE</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">SETTINGS</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">STATUS</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questionnaires as $item)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ $item->title }}</div>
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
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('evaluation_questionnaires.show', $item->id) }}" 
                                       class="btn btn-info btn-xs text-white px-2 py-1 fw-bold" 
                                       style="font-size: 10px; min-width: 45px;">View</a>
                                    
                                    <a href="{{ route('evaluation_questionnaires.edit', $item->id) }}" 
                                       class="btn btn-warning btn-xs text-white px-2 py-1 fw-bold" 
                                       style="font-size: 10px; min-width: 45px;">Edit</a>
                                    
                                    <form action="{{ route('evaluation_questionnaires.destroy', $item->id) }}" method="POST" 
                                          onsubmit="return confirm('Hapus kuesioner ini beserta data berkas fisiknya permanen?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs text-white px-2 py-1 fw-bold" 
                                                style="font-size: 10px; min-width: 45px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open d-block mb-2 fa-2x opacity-25"></i>
                                <span style="font-size: 11px;">No evaluation questionnaires found.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($questionnaires, 'links'))
        <div class="card-footer bg-white py-2 border-top">
            <div class="d-flex justify-content-center">
                {{ $questionnaires->links() }}
            </div>
        </div>
        @endif
    </div>

    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Questionnaire Evaluation Control
    </div>
</div>

<style>
    .btn-xs {
        padding: 2px 6px;
        font-size: 10px;
        line-height: 1.2;
        border-radius: 3px;
    }
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
        transition: 0.2s;
    }
    .badge {
        letter-spacing: 0.3px;
    }
</style>
@endsection