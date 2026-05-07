@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10"> 
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #ffc107;">
                    <h5 class="mb-0 fw-bold text-dark">SPMI SYSTEM - Edit Standard Indicator</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('indicators.update', $indicator->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Parent Standard</label>
                            <select name="standard_id" class="form-select @error('standard_id') is-invalid @enderror" required>
                                @foreach($standards as $std)
                                    <option value="{{ $std->id }}" {{ $indicator->standard_id == $std->id ? 'selected' : '' }}>
                                        [{{ $std->code }}] {{ $std->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('standard_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Indicator Code</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code', $indicator->code) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Measurement Type</label>
                                <select name="measurement_type" class="form-select">
                                    <option value="quantitative" {{ $indicator->measurement_type == 'quantitative' ? 'selected' : '' }}>Quantitative</option>
                                    <option value="qualitative" {{ $indicator->measurement_type == 'qualitative' ? 'selected' : '' }}>Qualitative</option>
                                    <option value="binary" {{ $indicator->measurement_type == 'binary' ? 'selected' : '' }}>Binary</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Indicator Description</label>
                            <textarea name="indicator_text" class="form-control" rows="4" required>{{ old('indicator_text', $indicator->indicator_text) }}</textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Target Value</label>
                                <input type="text" name="target_value" class="form-control" value="{{ old('target_value', $indicator->target_value) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Unit</label>
                                <input type="text" name="unit" class="form-control" value="{{ old('unit', $indicator->unit) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Weighting</label>
                                <input type="number" name="weight" class="form-control" value="{{ old('weight', $indicator->weight) }}">
                            </div>
                        </div>

                        <div class="mb-4 mt-2">
                            <label class="form-label fw-bold text-muted small text-uppercase d-block">Requirement</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_mandatory" id="isMandatory" value="1" {{ $indicator->is_mandatory ? 'checked' : '' }}>
                                <label class="form-check-label text-dark" for="isMandatory">Mark as Mandatory Indicator</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('indicators.index') }}" class="btn btn-outline-secondary px-4 border-0">Cancel</a>
                            <button type="submit" class="btn fw-bold px-4 shadow-sm" style="background-color: #ffc107; color: #000;">Update Indicator</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection