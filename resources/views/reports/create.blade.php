@extends('layouts.app')

@section('content')
<div class="container mt-5">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">
    <h5 class="mb-0">Create Report</h5>
</div>

<form action="{{ route('reports.store') }}" method="POST">
@csrf

<div class="card-body">

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control">
    </div>

    <div class="mb-3">
        <label>Type</label>
        <select name="type" class="form-select">
            <option value="audit_summary">Audit Summary</option>
            <option value="accreditation_result">Accreditation Result</option>
            <option value="evaluation_summary">Evaluation Summary</option>
            <option value="document_status">Document Status</option>
            <option value="finding_trend">Finding Trend</option>
            <option value="custom">Custom</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Format</label>
        <select name="format" class="form-select">
            <option value="pdf">PDF</option>
            <option value="excel">Excel</option>
            <option value="html">HTML</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Year</label>
        <input type="number" name="year" class="form-control">
    </div>

    <div class="mb-3">
        <label>Created By</label>
        <select name="created_by" class="form-select">
            @foreach($users as $u)
                <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary">Save</button>

</div>

</form>

</div>

</div>
@endsection