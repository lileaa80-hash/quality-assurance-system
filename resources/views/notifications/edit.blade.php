@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="card shadow border-0">

        <div class="card-header bg-warning text-dark py-3">
            <h5 class="mb-0 fw-bold">
                SPMI SYSTEM - Edit Notification
            </h5>
        </div>

        <form action="{{ route('notifications.update', $notification->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body p-4">

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">
                            Notification Type
                        </label>

                        <input type="text"
                               name="type"
                               class="form-control"
                               value="{{ old('type', $notification->type) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">
                            Notifiable Type
                        </label>

                        <input type="text"
                               name="notifiable_type"
                               class="form-control"
                               value="{{ old('notifiable_type', $notification->notifiable_type) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">
                            Notifiable ID
                        </label>

                        <input type="number"
                               name="notifiable_id"
                               class="form-control"
                               value="{{ old('notifiable_id', $notification->notifiable_id) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">
                            Status
                        </label>

                        <select name="read_at" class="form-select">
                            <option value=""
                                {{ $notification->read_at == null ? 'selected' : '' }}>
                                Unread
                            </option>

                            <option value="{{ now() }}"
                                {{ $notification->read_at ? 'selected' : '' }}>
                                Read
                            </option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold small">
                            Notification Data
                        </label>

                        <textarea name="data"
                                  class="form-control"
                                  rows="6"
                                  required>{{ old('data', $notification->data) }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('notifications.index') }}"
                       class="btn btn-light border px-4">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn btn-warning text-dark fw-bold px-4 shadow-sm">
                        Update Notification
                    </button>

                </div>

            </div>
        </form>

        <div class="card-footer bg-light py-2 text-center text-muted small border-0">
            © 2026 SPMI Digital System - RPL
        </div>

    </div>
</div>
@endsection