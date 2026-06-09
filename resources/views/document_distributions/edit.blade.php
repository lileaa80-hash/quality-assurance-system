@extends('layouts.app')

@section('content')
<div class="container mt-5">

<div class="card shadow border-0">

<div class="card-header bg-warning text-dark">
Edit Distribution
</div>

<form method="POST"
      action="{{ route('document-distributions.update', $distribution->id) }}">
@csrf
@method('PUT')

<div class="card-body">

<div class="mb-3">
<label>Type</label>
<select name="distribution_type" class="form-select">
<option value="softcopy" {{ $distribution->distribution_type == 'softcopy' ? 'selected' : '' }}>Softcopy</option>
<option value="hardcopy" {{ $distribution->distribution_type == 'hardcopy' ? 'selected' : '' }}>Hardcopy</option>
<option value="both" {{ $distribution->distribution_type == 'both' ? 'selected' : '' }}>Both</option>
</select>
</div>

<div class="mb-3">
<label>Status</label>
<select name="status" class="form-select">
<option value="sent" {{ $distribution->status == 'sent' ? 'selected' : '' }}>Sent</option>
<option value="received" {{ $distribution->status == 'received' ? 'selected' : '' }}>Received</option>
<option value="returned" {{ $distribution->status == 'returned' ? 'selected' : '' }}>Returned</option>
</select>
</div>

<div class="mb-3">
<label>Notes</label>
<textarea name="notes" class="form-control">{{ $distribution->notes }}</textarea>
</div>

<button class="btn btn-warning text-dark">Update</button>

</div>

</form>

</div>

</div>
@endsection