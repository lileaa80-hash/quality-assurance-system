@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 fw-bold">
                Create Activity
            </h5>
        </div>

        <form action="{{ route('activities.store') }}" method="POST">
            @csrf

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label fw-bold">Log Name</label>

                    <input type="text"
                           name="log_name"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>

                    <textarea name="description"
                              class="form-control"
                              required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Event</label>

                    <input type="text"
                           name="event"
                           class="form-control">
                </div>

                <button type="submit"
                        class="btn btn-primary">
                    Save Activity
                </button>

            </div>

        </form>

    </div>
</div>
@endsection