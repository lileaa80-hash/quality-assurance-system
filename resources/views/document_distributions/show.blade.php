@extends('layouts.app')

@section('content')
<div class="container mt-5">

<div class="card shadow border-0">

<div class="card-header bg-info text-white">
Detail Distribution
</div>

<div class="card-body">

<p><b>Document ID:</b> {{ $distribution->document_id }}</p>
<p><b>Unit ID:</b> {{ $distribution->unit_id }}</p>
<p><b>Type:</b> {{ $distribution->distribution_type }}</p>
<p><b>Status:</b> {{ $distribution->status }}</p>
<p><b>Notes:</b> {{ $distribution->notes }}</p>

<a href="{{ route('document-distributions.index') }}"
   class="btn btn-secondary">Back</a>

</div>

</div>

</div>
@endsection