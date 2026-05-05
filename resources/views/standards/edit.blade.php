@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10"> 
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #ffc107;">
                    <h5 class="mb-0 fw-bold text-dark">SPMI SYSTEM - Edit Standard</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('standards.update', $standard->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Standard Code</label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                    value="{{ old('code', $standard->code) }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Version</label>
                                <input type="text" name="version" class="form-control" value="{{ old('version', $standard->version) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Standard Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $standard->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Type</label>
                                <select name="type" class="form-select"> {{-- Menggunakan form-select untuk gaya modern --}}
                                    <option value="institutional" {{ $standard->type == 'institutional' ? 'selected' : '' }}>Institutional</option>
                                    <option value="sndikti" {{ $standard->type == 'sndikti' ? 'selected' : '' }}>SN-DIKTI</option>
                                    <option value="iso" {{ $standard->type == 'iso' ? 'selected' : '' }}>ISO</option>
                                    <option value="other" {{ $standard->type == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Parent Standard</label>
                                <select name="parent_id" class="form-select">
                                    <option value="">-- No Parent --</option>
                                    @foreach($parentStandards as $parent)
                                        <option value="{{ $parent->id }}" {{ $standard->parent_id == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->code }} - {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $standard->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase d-block">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ $standard->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">Standard is Active</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('standards.index') }}" class="btn btn-outline-secondary px-4 border-0">Cancel</a>
                            <button type="submit" class="btn fw-bold px-4 shadow-sm" style="background-color: #ffc107; color: #000;">Update Standard</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection