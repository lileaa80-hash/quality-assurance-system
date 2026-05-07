@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Standard Indicators List</h5>
            <a href="{{ route('indicators.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3 shadow-sm">
                Add New Indicator
            </a>
        </div>
        
        <div class="card-body p-0"> 
            <div class="px-4 py-3">
                <h4 class="mb-0 fw-bold text-secondary">Indicators Management</h4>
            </div>
            @if(session('success'))
                <div class="alert alert-success mx-4 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light text-uppercase" style="font-size: 0.85rem;">
                        <tr>
                            <th class="px-4 py-3 border-0" width="10%">Code</th>
                            <th class="py-3 border-0" width="20%">Standard</th>
                            <th class="py-3 border-0" width="30%">Indicator Description</th>
                            <th class="py-3 border-0">Type</th>
                            <th class="py-3 border-0">Target</th>
                            <th class="py-3 border-0 text-center">Weight</th>
                            <th class="px-4 py-3 border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($indicators as $inc)
                        <tr>
                            <td class="px-4">
                                <span class="badge bg-secondary opacity-75 px-2">{{ $inc->code }}</span>
                            </td>
                            <td>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Standard Code: {{ $inc->standard_code }}</small>
                                <div class="fw-bold text-dark">{{ $inc->standard_name }}</div>
                            </td>
                            <td>
                                <p class="mb-0 text-dark" style="font-size: 0.9rem;">{{ Str::limit($inc->indicator_text, 80) }}</p>
                                @if($inc->is_mandatory)
                                    <span class="badge bg-danger mt-1 text-uppercase" style="font-size: 0.65rem;">MANDATORY</span>
                                @endif
                            </td>
                            <td>
                                @if($inc->measurement_type == 'quantitative')
                                    <span class="badge bg-info text-white px-3">Quantitative</span>
                                @elseif($inc->measurement_type == 'qualitative')
                                    <span class="badge bg-warning text-dark px-3">Qualitative</span>
                                @else
                                    <span class="badge bg-dark px-3">Binary</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-primary fw-bold">{{ $inc->target_value ?? '-' }}</span>
                                <small class="text-muted">{{ $inc->unit }}</small>
                            </td>
                            <td class="text-center fw-bold">{{ $inc->weight }}</td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('indicators.show', $inc->id) }}" class="btn btn-sm btn-info text-white border-0 shadow-sm" style="background-color: #17a2b8;">Show</a>
                                    <a href="{{ route('indicators.edit', $inc->id) }}" class="btn btn-sm btn-warning text-white border-0 shadow-sm" style="background-color: #ffc107;">Edit</a>
                                    <form action="{{ route('indicators.destroy', $inc->id) }}" method="POST" onsubmit="return confirm('Delete this indicator?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger border-0 shadow-sm" style="background-color: #dc3545;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted small">No indicators found. Click "Add New Indicator" to start.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted">Showing {{ count($indicators) }} indicators</small>
            </div>
        </div>
    </div>
</div>
@endsection