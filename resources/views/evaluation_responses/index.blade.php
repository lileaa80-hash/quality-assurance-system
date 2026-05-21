@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 8px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Evaluation Responses Master</h6>
            <a href="{{ route('evaluation_responses.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm" style="font-size: 11px;">
                <i class="fas fa-plus me-1"></i> ADD NEW RESPONSE
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
                            <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">Target System Relational</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Respondent Profile</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Respondent Realization Payload</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">Network Metadata</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($responses as $res)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-primary text-truncate" style="max-width: 240px;" title="{{ $res->questionnaire_title }}">
                                    {{ $res->questionnaire_title }}
                                </div>
                                <div class="text-muted text-truncate mt-1" style="font-size: 10px; max-width: 240px;" title="{{ $res->question_text }}">
                                    Q: {{ $res->question_text }}
                                </div>
                            </td>
                            <td>
                                @if($res->respondent_id)
                                    <div class="fw-semibold text-dark"><i class="far fa-user text-secondary me-1"></i> {{ $res->user_name }}</div>
                                @else
                                    <div class="fw-semibold text-secondary"><i class="fas fa-user-secret text-muted me-1"></i> Anonymous ({{ $res->respondent_type ?? 'Guest' }})</div>
                                @endif
                                <div class="text-muted mt-1" style="font-size: 10px;">
                                    Unit: <span class="badge bg-light text-secondary border py-0 px-1">{{ $res->respondent_unit ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($res->answer_value !== null)
                                    <span class="badge bg-secondary text-white px-2 py-1 shadow-sm" style="font-size: 9px; border-radius: 4px;">Score: {{ $res->answer_value }}</span>
                                @endif
                                @if($res->answer)
                                    <div class="text-dark text-truncate mt-1" style="max-width: 220px;" title="{{ $res->answer }}">{{ $res->answer }}</div>
                                @endif
                            </td>
                            <td class="text-center">
                                <code class="small text-secondary" style="font-size: 10px;">{{ $res->ip_address ?? '0.0.0.0' }}</code>
                                <div class="text-muted opacity-75 mt-1" style="font-size: 9px;">
                                    {{ date('d M Y, H:i', strtotime($res->created_at)) }}
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('evaluation_responses.show', $res->id) }}" class="btn btn-info btn-xs text-white px-2 py-1 fw-bold" style="font-size: 10px; min-width: 45px;">View</a>
                                    <a href="{{ route('evaluation_responses.edit', $res->id) }}" class="btn btn-warning btn-xs text-white px-2 py-1 fw-bold" style="font-size: 10px; min-width: 45px;">Edit</a>
                                    <form action="{{ route('evaluation_responses.destroy', $res->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus arsip respon evaluasi ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs text-white px-2 py-1 fw-bold" style="font-size: 10px; min-width: 45px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-comment-slash d-block mb-2 fa-2x opacity-25"></i>
                                <span style="font-size: 11px;">Belum ada record data jawaban / respon evaluasi pada kuesioner ini.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($responses, 'links'))
        <div class="card-footer bg-white py-2 border-top">
            <div class="d-flex justify-content-center">
                {{ $responses->links() }}
            </div>
        </div>
        @endif
    </div>

    <div class="text-center mt-5 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | File Storage Management Controls
    </div>
</div>

<style>
    .btn-xs { padding: 2px 6px; font-size: 10px; line-height: 1.2; border-radius: 3px; }
    .table-hover tbody tr:hover { background-color: #f8fafc; transition: 0.2s; }
    .badge { letter-spacing: 0.3px; }
</style>
@endsection