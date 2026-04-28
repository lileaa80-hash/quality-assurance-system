@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">Evaluation Questionnaires</h6>
            <a href="{{ route('evaluation_questionnaires.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                + Create New Questionnaire
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
                            <th class="ps-4 py-3 text-muted small fw-bold" style="width: 30%;">TITLE & TYPE</th>
                            <th class="py-3 text-muted small fw-bold">PERIOD</th>
                            <th class="py-3 text-muted small fw-bold text-center">TARGET</th>
                            <th class="py-3 text-muted small fw-bold text-center">STATUS</th>
                            <th class="py-3 text-muted small fw-bold text-center pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questionnaires as $item)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ $item->title }}</div>
                                <div class="text-muted" style="font-size: 10px;">Type: {{ strtoupper(str_replace('_', ' ', $item->type)) }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $item->year }} - {{ $item->semester }}</div>
                                <div class="text-muted" style="font-size: 9px;">
                                    {{ \Carbon\Carbon::parse($item->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 10px;">
                                    {{ strtoupper($item->target_audience) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusBadge = [
                                        'draft' => 'bg-secondary',
                                        'active' => 'bg-success',
                                        'closed' => 'bg-danger',
                                        'archived' => 'bg-dark'
                                    ][$item->status] ?? 'bg-dark';
                                @endphp
                                <span class="badge {{ $statusBadge }} px-2 py-1" style="font-size: 9px; border-radius: 4px;">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('evaluation_questionnaires.show', $item->id) }}" class="btn btn-info btn-xs text-white px-2 py-0" style="font-size: 10px;">Questions</a>
                                    <a href="{{ route('evaluation_questionnaires.edit', $item->id) }}" class="btn btn-warning btn-xs text-white px-2 py-0" style="font-size: 10px;">Edit</a>
                                    <form action="{{ route('evaluation_questionnaires.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this questionnaire?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs px-2 py-0" style="font-size: 10px;">Del</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted" style="font-size: 11px;">No questionnaires found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection