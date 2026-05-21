@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 1000px; margin: auto; border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Evaluation Response Details</h5>
            <a href="{{ route('evaluation_responses.index') }}" class="btn btn-light btn-sm fw-bold px-3" style="font-size: 12px; color: #0d6efd;">BACK TO LIST</a>
        </div>

        <div class="card-body p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="fw-bold text-muted small me-2">QUESTION TYPE LINK:</span>
                    <span class="badge bg-secondary text-white px-3 py-2 text-uppercase shadow-sm" style="font-size: 11px; border-radius: 4px; letter-spacing: 0.3px;">
                        {{ isset($response->question_type) ? str_replace('_', ' ', $response->question_type) : 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="fw-bold text-muted small">ACCOUNT MODE:</span>
                    @if(!empty($response->respondent_id))
                        <span class="badge bg-success text-white px-3 py-2 text-uppercase ms-1" style="font-size: 11px; border-radius: 4px;">AUTHENTICATED</span>
                    @else
                        <span class="badge bg-light text-secondary border px-3 py-2 text-uppercase ms-1" style="font-size: 11px; border-radius: 4px;">ANONYMOUS GUEST</span>
                    @endif
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-8">
                    <div class="p-4 border rounded shadow-sm bg-white h-100">
                        <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Target System Relational Matrix</label>
                        <h5 class="fw-bold text-primary mb-2">{{ $response->questionnaire_title ?? 'Questionnaire Cluster Instance' }}</h5>
                        <span class="badge bg-light text-primary border text-uppercase" style="font-size: 10px; font-weight: 600; letter-spacing: 0.3px;">
                            Q Ref: "{{ Str::limit($response->question_text ?? 'Instrument Question Text Deleted', 75) }}"
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4 border rounded shadow-sm bg-white h-100 d-flex flex-column justify-content-center">
                        <label class="fw-bold text-muted small d-block mb-1 text-uppercase" style="letter-spacing: 0.5px;">Metric Realization Score</label>
                        <h3 class="fw-bold mb-0 text-success">{{ $response->answer_value ?? '-' }}</h3>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Period Year: {{ $response->questionnaire_year ?? '-' }}</small>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="p-4 border rounded shadow-sm bg-light-subtle">
                        <label class="fw-bold text-muted small d-block mb-3 text-uppercase" style="letter-spacing: 0.5px;"><i class="fas fa-id-card me-1"></i> Respondent Demography Demarcation</label>
                        <div class="row g-3" style="font-size: 13px;">
                            <div class="col-sm-4">
                                <span class="text-muted d-block small" style="font-size: 10px; font-weight: 700;">RESPONDENT NAME ACCOUNT</span>
                                <strong class="text-dark">{{ $response->user_name ?? 'Anonymous / Outside System' }}</strong>
                            </div>
                            <div class="col-sm-4">
                                <span class="text-muted d-block small" style="font-size: 10px; font-weight: 700;">CLUSTER CLASSIFIER TYPE</span>
                                <span class="badge bg-light text-secondary border mt-1">{{ $response->respondent_type ?? 'Guest' }}</span>
                            </div>
                            <div class="col-sm-4">
                                <span class="text-muted d-block small" style="font-size: 10px; font-weight: 700;">WORKING UNIT BRANCH</span>
                                <strong class="text-secondary">{{ $response->respondent_unit ?? '-' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(($response->question_type ?? '') === 'multiple_choice' || !empty($response->answer_options))
            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Selected Option Values Array (Payload)</label>
                    <div class="p-3 border rounded bg-light">
                        <code class="text-secondary font-monospace" style="font-size: 12px;"><i class="fas fa-code-branch me-2"></i>{{ $response->answer_options }}</code>
                    </div>
                </div>
            </div>
            @endif

            <div class="row mb-4">
                <div class="col-12">
                    <label class="fw-bold text-muted small d-block mb-2 text-uppercase" style="letter-spacing: 0.5px;">Descriptive Realization Content (Narrative Text)</label>
                    <div class="p-4 border rounded bg-white shadow-sm" style="min-height: 120px; border-left: 5px solid #0d6efd !important;">
                        <p class="mb-0 text-dark fw-medium" style="white-space: pre-line; line-height: 1.6; font-size: 13px;">
                            {{ $response->answer ?? 'Tidak ada isian deskriptif / narasi esai terbuka yang dikirimkan untuk parameter respon data ini.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-3 border rounded bg-light text-muted d-flex justify-content-between align-items-center mb-4" style="font-size: 11px;">
                <span><i class="fas fa-network-wired me-1"></i> Client Tracking Node IP: <strong class="text-dark">{{ $response->ip_address ?? '0.0.0.0' }}</strong></span>
                <span><i class="fas fa-fingerprint me-1"></i> Session ID Key: <code class="text-secondary">{{ Str::limit($response->session_id ?? 'N/A', 32) }}</code></span>
            </div>

            <hr class="mt-5 mb-4 opacity-50">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small" style="font-size: 10px;">
                    <i class="fas fa-database me-1"></i> Response Instance UID: <strong>#{{ $response->id ?? '-' }}</strong>
                </span>
                <div class="d-flex gap-2">
                    @if(isset($response->id))
                        <form action="{{ route('evaluation_responses.destroy', $response->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus arsip data respon evaluasi ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger px-4 fw-bold shadow-sm" style="font-size: 13px;">DELETE</button>
                        </form>
                        <a href="{{ route('evaluation_responses.edit', $response->id) }}" class="btn btn-warning text-white px-4 fw-bold shadow-sm" style="font-size: 13px; background-color: #ffc107; border: none;">
                            EDIT DATA
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted" style="font-size: 11px;">
        © 2026 SPMI Digital System - RPL | Questionnaire Management Controls
    </div>
</div>
@endsection