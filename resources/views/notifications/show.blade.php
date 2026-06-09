@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold">
                SPMI SYSTEM - Notification Details
            </h5>
        </div>

        <div class="card-body p-4">

            <div class="mb-4">
                <h4 class="fw-bold text-secondary">
                    Notification Information
                </h4>
            </div>

            <div class="border-top border-bottom py-3">

                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">
                        Notification ID
                    </div>

                    <div class="col-sm-9">
                        : {{ $notification->id }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">
                        Type
                    </div>

                    <div class="col-sm-9">
                        :
                        <span class="badge bg-light text-dark border px-3">
                            {{ $notification->type }}
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">
                        Notifiable Type
                    </div>

                    <div class="col-sm-9">
                        : {{ $notification->notifiable_type }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">
                        Notifiable ID
                    </div>

                    <div class="col-sm-9">
                        : {{ $notification->notifiable_id }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">
                        Data
                    </div>

                    <div class="col-sm-9">
                        :
                        <pre class="bg-light p-3 rounded border small mb-0">{{ $notification->data }}</pre>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">
                        Status
                    </div>

                    <div class="col-sm-9">
                        :
                        @if($notification->read_at)
                            <span class="badge bg-success">
                                Read
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                Unread
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">
                        Read At
                    </div>

                    <div class="col-sm-9">
                        :
                        {{ $notification->read_at 
                            ? \Carbon\Carbon::parse($notification->read_at)->format('d M Y H:i') 
                            : '-' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold text-muted">
                        Created At
                    </div>

                    <div class="col-sm-9">
                        :
                        {{ \Carbon\Carbon::parse($notification->created_at)->format('d M Y H:i') }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3 fw-bold text-muted">
                        Last Updated
                    </div>

                    <div class="col-sm-9">
                        :
                        {{ \Carbon\Carbon::parse($notification->updated_at)->diffForHumans() }}
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-start gap-2 mt-4">

                <a href="{{ route('notifications.index') }}"
                   class="btn btn-secondary px-4">
                    Back
                </a>

                <a href="{{ route('notifications.edit', $notification->id) }}"
                   class="btn btn-warning text-white px-4">
                    Edit
                </a>

            </div>

        </div>

        <div class="card-footer bg-light py-2 text-center text-muted small border-0">
            © 2026 SPMI Digital System - RPL
        </div>

    </div>
</div>
@endsection