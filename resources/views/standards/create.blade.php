@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white py-3" style="background-color: #007bff;">
                    <h5 class="mb-0 font-weight-bold">SPMI SYSTEM - Create New Standard</h5>
                </div>

                <div class="card-body p-4">
                    {{-- Form Start --}}
                    <form action="{{ route('standards.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-dark">Standard Code</label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                    placeholder="Ex: SNDIKTI-01" value="{{ old('code') }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-dark">Version</label>
                                <input type="text" name="version" class="form-control" placeholder="1.0" value="{{ old('version', '1.0') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-dark">Standard Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                placeholder="Enter standard name..." value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-dark">Standard Type</label>
                                <select name="type" class="form-control shadow-none">
                                    <option value="institutional">Institutional</option>
                                    <option value="sndikti">SN-DIKTI</option>
                                    <option value="iso">ISO</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-dark">Parent (Optional)</label>
                                <select name="parent_id" class="form-control shadow-none">
                                    <option value="">-- No Parent (Main Standard) --</option>
                                    @isset($parentStandards)
                                        @foreach($parentStandards as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->code }} - {{ $parent->name }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-dark">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Explain more about this standard..."></textarea>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" checked>
                                <label class="form-check-label" for="isActive">Mark as Active Standard</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('standards.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Save Standard</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection