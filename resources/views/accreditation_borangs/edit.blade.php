@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-warning py-3 px-4">
            <h6 class="mb-0 fw-bold text-dark text-uppercase">
                <i class="fas fa-edit me-2"></i> Edit Borang: 
                {{-- Pakai pengaman supaya tidak error lagi --}}
                {{ $borang->standard_name ?? ($borang->name ?? 'Update Data') }}
            </h6>
        </div>
        
        <div class="card-body p-4 px-5">
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('accreditation_borangs.update', $borang->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-5">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-4 text-uppercase" style="letter-spacing: 1px;">
                        <i class="fas fa-info-circle me-1"></i> Borang & Assessment Details
                    </h6>
                    
                    <div class="row g-4">
                        {{-- Accreditation Period --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">ACCREDITATION PERIOD</label>
                            <select name="accreditation_period_id" class="form-select shadow-sm" required>
                                @foreach($periods as $p)
                                    <option value="{{ $p->id }}" {{ $borang->accreditation_period_id == $p->id ? 'selected' : '' }}>
                                        {{ $p->period_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">STATUS</label>
                            <select name="status" class="form-select shadow-sm" required>
                                @foreach(['draft', 'submitted', 'verified', 'revised'] as $st)
                                    <option value="{{ $st }}" {{ $borang->status == $st ? 'selected' : '' }}>
                                        {{ strtoupper($st) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Target & Score --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">ACHIEVEMENT TARGET</label>
                            <input type="text" name="target" class="form-control shadow-sm" 
                                   value="{{ old('target', $borang->target ?? '') }}" placeholder="Contoh: 100% Terpenuhi">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">SELF ASSESSMENT SCORE (0-4)</label>
                            <input type="number" step="0.01" name="self_assessment_score" class="form-control shadow-sm" 
                                   value="{{ old('self_assessment_score', $borang->self_assessment_score ?? 0) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-4 text-uppercase" style="letter-spacing: 1px;">
                        <i class="fas fa-pen-fancy me-1"></i> Analysis & Response
                    </h6>
                    
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">RESPONSE / DESCRIPTION</label>
                            <textarea name="response" class="form-control shadow-sm" rows="4">{{ old('response', $borang->response ?? '') }}</textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">ANALYSIS</label>
                            <textarea name="analysis" class="form-control shadow-sm" rows="4">{{ old('analysis', $borang->analysis ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('accreditation_borangs.index') }}" class="btn btn-light px-4 fw-bold border">CANCEL</a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold shadow-sm">
                        <i class="fas fa-save me-1"></i> UPDATE BORANG
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection