@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #007bff;">
                    <h5 class="mb-0 font-weight-bold">Standard Details</h5>
                    <a href="{{ route('standards.index') }}" class="btn btn-sm btn-light text-primary font-weight-bold">Back to List</a>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <tr>
                            <th class="ps-4" width="30%">Code</th>
                            <td><span class="badge bg-secondary">{{ $standard->code }}</span></td>
                        </tr>
                        <tr>
                            <th class="ps-4">Standard Name</th>
                            <td><strong>{{ $standard->name }}</strong></td>
                        </tr>
                        <tr>
                            <th class="ps-4">Type</th>
                            <td class="text-uppercase">{{ $standard->type }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Version</th>
                            <td>v{{ $standard->version }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Description</th>
                            <td>{{ $standard->description ?? 'No description provided.' }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Status</th>
                            <td>
                                @if($standard->is_active)
                                    <span class="badge bg-success">ACTIVE</span>
                                @else
                                    <span class="badge bg-danger">INACTIVE</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="ps-4">Created By</th>
                            <td>{{ $standard->creator_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Created At</th>
                            <td>{{ \Carbon\Carbon::parse($standard->created_at)->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer bg-white d-flex justify-content-end gap-2">
                    <a href="{{ route('standards.edit', $standard->id) }}" class="btn btn-warning text-white px-4">Edit Data</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection