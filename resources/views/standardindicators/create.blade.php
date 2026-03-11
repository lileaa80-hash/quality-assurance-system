@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white py-3" style="background-color: #007bff;">
                    <h5 class="mb-0 font-weight-bold">SPMI SYSTEM - Create New Indicator</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('indicators.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-dark">Parent Standard</label>
                            <select name="standard_id" class="form-control @error('standard_id') is-invalid @enderror" required>
                                <option value="">-- Select Parent Standard --</option>
                                @foreach($standards as $std)
                                    <option value="{{ $std->id }}" {{ old('standard_id') == $std->id ? 'selected' : '' }}>
                                        [{{ $std->code }}] {{ $std->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('standard_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-dark">Indicator Code</label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                    placeholder="Ex: IND-01" value="{{ old('code') }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-dark">Measurement Type</label>
                                <select name="measurement_type" class="form-control">
                                    <option value="quantitative">Quantitative (Numbers/Scores)</option>
                                    <option value="qualitative">Qualitative (Descriptions)</option>
                                    <option value="binary">Binary (Yes/No)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-dark">Indicator Description</label>
                            <textarea name="indicator_text" class="form-control @error('indicator_text') is-invalid @enderror" 
                                rows="4" placeholder="Enter details of what will be assessed..." required>{{ old('indicator_text') }}</textarea>
                            @error('indicator_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold text-dark">Target Value</label>
                                <input type="text" name="target_value" class="form-control" placeholder="Ex: 100 / 4.0" value="{{ old('target_value') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold text-dark">Unit</label>
                                <input type="text" name="unit" class="form-control" placeholder="Ex: %, Score, Document" value="{{ old('unit') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold text-dark">Priority Weight</label>
                                <input type="number" name="weight" class="form-control" value="{{ old('weight', 1) }}">
                            </div>
                        </div>

                        <div class="mb-4 mt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_mandatory" id="isMandatory" value="1" checked>
                                <label class="form-check-label text-dark" for="isMandatory">Set as Mandatory Indicator</label>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('indicators.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Save Indicator</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection