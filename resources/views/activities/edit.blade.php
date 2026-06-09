@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm border-0" style="max-width: 1000px; margin:auto; border-radius:12px; overflow:hidden;">

        <div class="card-header bg-warning py-3 px-4">
            <h5 class="mb-0 fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">
                EDIT ACTIVITY LOG
            </h5>
        </div>

        <div class="card-body p-4 bg-white">

            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-4 border-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('activities.update', $activity->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- BASIC INFO --}}
                <div class="mb-4">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px;">
                        Activity Information
                    </h6>
                    <hr class="mt-0 mb-3 opacity-25">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Log Name</label>
                            <input type="text"
                                   name="log_name"
                                   class="form-control shadow-sm"
                                   value="{{ old('log_name', $activity->log_name) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Event</label>
                            <input type="text"
                                   name="event"
                                   class="form-control shadow-sm"
                                   value="{{ old('event', $activity->event) }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-muted">Description</label>
                            <textarea name="description"
                                      class="form-control shadow-sm"
                                      rows="3"
                                      required>{{ old('description', $activity->description) }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- SYSTEM INFO --}}
                <div class="mb-4">
                    <h6 class="fw-bold text-primary text-uppercase mb-3" style="font-size: 13px;">
                        System Data
                    </h6>
                    <hr class="mt-0 mb-3 opacity-25">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">IP Address</label>
                            <input type="text"
                                   name="ip_address"
                                   class="form-control shadow-sm"
                                   value="{{ old('ip_address', $activity->ip_address) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">User Agent</label>
                            <input type="text"
                                   name="user_agent"
                                   class="form-control shadow-sm"
                                   value="{{ old('user_agent', $activity->user_agent) }}">
                        </div>

                    </div>
                </div>
                {{-- BUTTON --}}
                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">

                    <a href="{{ route('activities.index') }}"
                       class="btn btn-outline-secondary px-4 fw-bold">
                        CANCEL
                    </a>
                    <button type="submit"
                            class="btn btn-warning px-4 fw-bold text-dark shadow-sm">
                        UPDATE ACTIVITY
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection