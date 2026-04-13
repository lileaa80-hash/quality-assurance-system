@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-warning py-2">
            <h6 class="mb-0 fw-bold text-dark">Edit Accreditation Borang: {{ $borang->name }}</h6>
        </div>

        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger py-2 small shadow-sm mb-3 border-0">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('accreditation_borangs.update', $borang->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">BORANG INFORMATION</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">BORANG NAME</label>
                            <input type="text" name="name" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('name', $borang->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">ACCREDITATION PERIOD</label>
                            <select name="accreditation_period_id" class="form-select form-select-sm shadow-sm" required>
                                @foreach($periods as $p)
                                    <option value="{{ $p->id }}" {{ $borang->accreditation_period_id == $p->id ? 'selected' : '' }}>
                                        {{ $p->period_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">TYPE / CATEGORY</label>
                            <select name="type" class="form-select form-select-sm shadow-sm" required>
                                @foreach(['prodi' => 'Program Studi', 'fakultas' => 'Fakultas / UPPS', 'institusi' => 'Institusi'] as $val => $label)
                                    <option value="{{ $val }}" {{ $borang->type == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">CURRENT STATUS</label>
                            <select name="status" class="form-select form-select-sm shadow-sm" required>
                                @foreach(['draft', 'in_progress', 'reviewed', 'final'] as $status)
                                    <option value="{{ $status }}" {{ $borang->status == $status ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">TARGET SCORE</label>
                            <input type="number" name="target_score" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('target_score', $borang->target_score) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">EXTERNAL LINKS & DOCUMENT</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">DOCUMENT LINK (Cloud Storage / Spreadsheet)</label>
                            <input type="url" name="document_link" class="form-control form-control-sm shadow-sm" 
                                   value="{{ old('document_link', $borang->document_link) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">DESCRIPTION / NOTES</label>
                            <textarea name="description" class="form-control form-control-sm shadow-sm" rows="3">{{ old('description', $borang->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('accreditation_borangs.index') }}" class="btn btn-light btn-sm px-3 fw-bold border" style="font-size: 11px;">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm px-3 fw-bold shadow-sm" style="font-size: 11px;">Update Borang Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection