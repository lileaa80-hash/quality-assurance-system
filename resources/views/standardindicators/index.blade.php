@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white py-3" style="background-color: #007bff;">
            <h5 class="mb-0 font-weight-bold">SPMI SYSTEM - Standard Indicators List</h5>
        </div>
        
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Indicators Management</h4>
                <a href="{{ route('indicators.create') }}" class="btn btn-primary shadow-sm">
                    Add New Indicator
                </a>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover border">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th width="10%">Code</th>
                            <th width="20%">Standard</th>
                            <th width="30%">Indicator Description</th>
                            <th>Type</th>
                            <th>Target</th>
                            <th>Weight</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($indicators as $inc)
                        <tr>
                            <td><span class="badge bg-secondary px-2">{{ $inc->code }}</span></td>
                            <td>
                                <small class="text-muted d-block">Standard Code: {{ $inc->standard_code }}</small>
                                <strong>{{ $inc->standard_name }}</strong>
                            </td>
                            <td>
                                <p class="mb-0" style="font-size: 0.9rem;">{{ Str::limit($inc->indicator_text, 80) }}</p>
                                @if($inc->is_mandatory)
                                    <span class="badge bg-danger mt-1" style="font-size: 0.7rem;">MANDATORY</span>
                                @endif
                            </td>
                            <td>
                                @if($inc->measurement_type == 'quantitative')
                                    <span class="badge bg-info text-white">Quantitative</span>
                                @elseif($inc->measurement_type == 'qualitative')
                                    <span class="badge bg-warning text-dark">Qualitative</span>
                                @else
                                    <span class="badge bg-dark">Binary</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-primary font-weight-bold">{{ $inc->target_value ?? '-' }}</span>
                                <small class="text-muted">{{ $inc->unit }}</small>
                            </td>
                            <td class="text-center">{{ $inc->weight }}</td>
                            <td class="text-center">
                                <div class="btn-group gap-1">
                                    {{-- Tombol Show (Biru Muda/Info) --}}
                                    <a href="{{ route('indicators.show', $inc->id) }}" class="btn btn-sm btn-info text-white">Show</a>
                                    
                                    {{-- Tombol Edit (Kuning) --}}
                                    <a href="{{ route('indicators.edit', $inc->id) }}" class="btn btn-sm btn-warning text-white">Edit</a>
                                    
                                    {{-- Tombol Delete (Merah) --}}
                                    <form action="{{ route('indicators.destroy', $inc->id) }}" method="POST" onsubmit="return confirm('Delete this indicator?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">No indicators found. Click "Add New Indicator" to start.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection