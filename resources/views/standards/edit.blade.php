@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white py-3" style="background-color: #007bff;">
                    <h5 class="mb-0 font-weight-bold">SPMI SYSTEM - Edit Standard</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('standards.update', $standard->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Wajib ada untuk proses Update --}}
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Standard Code</label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                    value="{{ old('code', $standard->code) }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Version</label>
                                <input type="text" name="version" class="form-control" value="{{ old('version', $standard->version) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Standard Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $standard->name) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Type</label>
                                <select name="type" class="form-control">
                                    <option value="institutional" {{ $standard->type == 'institutional' ? 'selected' : '' }}>Institutional</option>
                                    <option value="sndikti" {{ $standard->type == 'sndikti' ? 'selected' : '' }}>SN-DIKTI</option>
                                    <option value="iso" {{ $standard->type == 'iso' ? 'selected' : '' }}>ISO</option>
                                    <option value="other" {{ $standard->type == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Parent Standard</label>
                                <select name="parent_id" class="form-control">
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
                            <label class="form-label font-weight-bold">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $standard->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ $standard->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">Standard is Active</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('standards.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Update Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection