@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        {{-- Header Card --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">Evaluation Questionnaires</h6>
            <a href="{{ route('evaluation_questionnaires.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm px-3" style="font-size: 11px;">
                UPLOAD NEW QUESTIONNAIRE
            </a>
        </div>

        <div class="card-body p-0">
            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success m-3 py-2 small border-0 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Alert Error jika ada redirect balik --}}
            @if(session('error'))
                <div class="alert alert-danger m-3 py-2 small border-0 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr style="font-size: 11px;">
                            <th class="ps-4 py-3 text-muted fw-bold text-uppercase">Questionnaire & Type</th>
                            <th class="py-3 text-muted fw-bold text-uppercase">Period</th>
                            <th class="py-3 text-muted fw-bold text-uppercase text-center">Target</th>
                            <th class="py-3 text-muted fw-bold text-uppercase text-center">Status</th>
                            <th class="py-3 text-muted fw-bold text-uppercase text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px;">
                        @forelse($questionnaires as $item)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary mb-1">{{ $item->title }}</div>
                                <div class="text-muted small">
                                    <span class="fw-bold">Type:</span> {{ str_replace('_', ' ', $item->type) }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->year }} - {{ $item->semester }}</div>
                                <div class="text-muted" style="font-size: 10px;">
                                    {{ \Carbon\Carbon::parse($item->start_date)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/y') }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-2 py-1 fw-normal" style="font-size: 10px;">
                                    {{ strtoupper($item->target_audience) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusColor = [
                                        'active'   => '#ffc107', 
                                        'draft'    => '#6c757d',
                                        'closed'   => '#dc3545',
                                        'archived' => '#343a40'
                                    ][$item->status] ?? '#6c757d';
                                @endphp
                                <span class="badge text-uppercase" style="background-color: {{ $statusColor }}; font-size: 9px; padding: 5px 10px;">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- TOMBOL VIEW: Ini bagian paling penting agar tidak mental --}}
                                    <a href="{{ route('evaluation_questions.index', ['questionnaire_id' => $item->id]) }}" 
                                       class="btn btn-info btn-sm text-white px-2 py-1" 
                                       style="font-size: 10px; font-weight: bold;">View</a>

                                    <a href="{{ route('evaluation_questionnaires.edit', $item->id) }}" 
                                       class="btn btn-warning btn-sm text-white px-2 py-1" 
                                       style="font-size: 10px; font-weight: bold;">Edit</a>

                                    <form action="{{ route('evaluation_questionnaires.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this questionnaire?')" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-2 py-1" style="font-size: 10px; font-weight: bold;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No questionnaires found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 border-0 text-center text-muted small">
            © {{ date('Y') }} SPMI Digital System - RPL | Questionnaire Management Control
        </div>
    </div>
</div>
@endsection