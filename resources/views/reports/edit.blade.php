@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark">
        <h5>Edit Report</h5>
    </div>

    <form action="{{ route('reports.update', $report->id) }}" method="POST">
        @csrf
        @method('PUT')

    <div class="card-body">
        <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control"
               value="{{ $report->title }}">
    </div>
    <div class="mb-3">
        <label>Type</label>
        <input type="text" name="type" class="form-control"
               value="{{ $report->type }}">
    </div>

    <div class="mb-3">
        <label>Format</label>
        <input type="text" name="format" class="form-control"
               value="{{ $report->format }}">
    </div>

    <div class="mb-3">
        <label>Year</label>
        <input type="number" name="year" class="form-control"
               value="{{ $report->year }}">
    </div>
    <button class="btn btn-warning text-dark">Update</button>

            </div>
        </form>
    </div>
</div>

@endsection