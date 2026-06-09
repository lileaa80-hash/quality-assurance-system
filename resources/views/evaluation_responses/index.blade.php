@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Evaluation Responses</h5>
            <a href="{{ route('evaluation_responses.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add New Response
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
                            <th class="px-4 py-3 border-0" style="width: 25%;">Target System Relational</th>
                            <th class="py-3 border-0" style="width: 25%;">Respondent Profile</th>
                            <th class="py-3 border-0">Respondent Realization Payload</th>
                            <th class="py-3 border-0 text-center">Network Metadata</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        @forelse($responses as $res)
                        <tr>
                            <td class="px-4">
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
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('evaluation_responses.show', $res->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('evaluation_responses.edit', $res->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('evaluation_responses.destroy', $res->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus arsip respon evaluasi ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-white px-2 py-1" style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Belum ada record data jawaban / respon evaluasi pada kuesioner ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($responses, 'links') && $responses->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-center">
                    {{ $responses->links() }}
                </div>
            </div>
            @else
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing 1 to {{ count($responses) }} of {{ count($responses) }} records</small>
            </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-5 mb-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | File Storage Management Controls
    </div>
</div>
@endsection