@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="card shadow border-0">

        <div class="card-header bg-info text-white">
            <h5 class="mb-0 fw-bold">
                Activity Details
            </h5>
        </div>

        <div class="card-body">

            <p><strong>Log Name:</strong> {{ $activity->log_name }}</p>

            <p><strong>Description:</strong> {{ $activity->description }}</p>

            <p><strong>Event:</strong> {{ $activity->event }}</p>

            <p><strong>IP Address:</strong> {{ $activity->ip_address }}</p>

            <p><strong>User Agent:</strong> {{ $activity->user_agent }}</p>

            <a href="{{ route('activities.index') }}"
               class="btn btn-secondary">
                Back
            </a>

        </div>
    </div>
</div>
@endsection