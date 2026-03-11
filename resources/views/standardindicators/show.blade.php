@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #007bff;">
                    <h5 class="mb-0 font-weight-bold">Detailed Indicator View</h5>
                    <a href="{{ route('indicators.index') }}" class="btn btn-sm btn-light text-primary font-weight-bold px-3">Back to List</a>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <tr>
                            <th class="ps-4 py-3" width="35%">Parent Standard</th>
                            <td class="py-3"><strong>{{ $indicator->standard_name }}</strong> ({{ $indicator->standard_code }})</td>
                        </tr>
                        <tr>
                            <th class="ps-4 py-3">Indicator Code</th>
                            <td class="py-3"><span class="badge bg-secondary px-2">#{{ $indicator->code }}</span></td>
                        </tr>
                        <tr>
                            <th class="ps-4 py-3">Indicator Description</th>
                            <td class="py-3">{{ $indicator->indicator_text }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4 py-3">Measurement Type</th>
                            <td class="py-3 text-uppercase font-weight-bold">{{ $indicator->measurement_type }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4 py-3">Target / Expected Value</th>
                            <td class="py-3"><span class="text-primary font-weight-bold">{{ $indicator->target_value ?? 'N/A' }}</span> {{ $indicator->unit }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4 py-3">Priority Weight</th>
                            <td class="py-3">{{ $indicator->weight }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4 py-3">Status Condition</th>
                            <td class="py-3">
                                @if($indicator->is_mandatory)
                                    <span class="badge bg-danger">MANDATORY</span>
                                @else
                                    <span class="badge bg-info">OPTIONAL</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer bg-white d-flex justify-content-end gap-2 p-3">
                    <a href="{{ route('indicators.edit', $indicator->id) }}" class="btn btn-warning text-white px-4 shadow-sm">Modify Data</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection