@extends('layouts.app')

@section('content')
<div class="container mt-5">

<div class="card shadow border-0">

<div class="card-header bg-info text-white">
    <h5>Report Detail</h5>
</div>

<div class="card-body">

<p><b>Title:</b> {{ $report->title }}</p>
<p><b>Type:</b> {{ $report->type }}</p>
<p><b>Format:</b> {{ $report->format }}</p>
<p><b>Year:</b> {{ $report->year }}</p>
<p><b>Quarter:</b> {{ $report->quarter }}</p>

<p><b>File:</b> {{ $report->file_path }}</p>

<a href="{{ route('reports.index') }}" class="btn btn-secondary">Back</a>

</div>

</div>

</div>
@endsection