@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #007bff; padding: 1rem 1.5rem;">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Standard Indicators List</h5>
            <a href="{{ route('indicators.create') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 5px;">
                Add New Indicator
            </a>
        </div>
        
        <div class="card-body p-0"> 
            @if(session('success'))
                <div class="alert alert-success mx-4 mt-3 border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light" style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="px-4 py-3 border-0" width="10%">NO</th>
                            <th class="py-3 border-0" width="20%">STANDARD</th>
                            <th class="py-3 border-0" width="30%">INDICATOR DESCRIPTION</th>
                            <th class="py-3 border-0">TYPE</th>
                            <th class="py-3 border-0">TARGET</th>
                            <th class="py-3 border-0 text-center">WEIGHT</th>
                            <th class="px-4 py-3 border-0 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($indicators as $index => $inc)
                        <tr>
                            <td class="px-4 fw-bold text-secondary">
                                {{ $index + 1 }}
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
                                    <span class="badge bg-info text-white px-3" style="font-size: 0.75rem;">Quantitative</span>
                                @elseif($inc->measurement_type == 'qualitative')
                                    <span class="badge bg-warning text-dark px-3" style="font-size: 0.75rem;">Qualitative</span>
                                @else
                                    <span class="badge bg-dark text-white px-3" style="font-size: 0.75rem;">Binary</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-primary fw-bold">{{ $inc->target_value ?? '-' }}</span>
                                <small class="text-muted">{{ $inc->unit }}</small>
                            </td>
                            <td class="text-center fw-bold text-dark">{{ $inc->weight }}</td>
                            <td class="px-4 text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('indicators.show', $inc->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">View</a>
                                    <a href="{{ route('indicators.edit', $inc->id) }}" class="btn btn-sm text-white px-2 py-1" style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('indicators.destroy', $inc->id) }}" method="POST" onsubmit="return confirm('Delete this indicator?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-white px-2 py-1" style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;">Delete</button>
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
                <small class="text-muted">Showing 1 to {{ count($indicators) }} of {{ count($indicators) }} indicators</small>
            </div>
        </div>
    </div>
</div>
@endsection