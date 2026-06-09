@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">

        {{-- HEADER --}}
        <div class="card-header d-flex justify-content-between align-items-center text-white"
             style="background-color: #007bff; padding: 1rem 1.5rem;">

            <h5 class="mb-0 fw-bold">
                SPMI SYSTEM - Audit Schedules List
            </h5>

            <a href="{{ route('audit_schedules.create') }}"
               class="btn btn-light btn-sm fw-bold text-primary px-3"
               style="border-radius: 5px;">
                Add New Schedule
            </a>
        </div>

        <div class="card-body p-0">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm m-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close">
                    </button>
                </div>
            @endif

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="bg-light"
                           style="font-size: 0.85rem; color: #495057;">
                        <tr>
                            <th class="px-4 py-3 border-0">AUDIT NO</th>
                            <th class="py-3 border-0">TITLE</th>
                            <th class="py-3 border-0">PERIOD / DATES</th>
                            <th class="py-3 border-0">STANDARDS</th>
                            <th class="py-3 border-0">STATUS</th>
                            <th class="px-4 py-3 border-0 text-center">ACTIONS</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($schedules as $item)

                            <tr>

                                {{-- AUDIT NUMBER --}}
                                <td class="px-4">
                                    <span class="badge bg-secondary opacity-75 px-2 py-1"
                                          style="font-size: 11px;">
                                        {{ $item->audit_number }}
                                    </span>
                                </td>

                                {{-- TITLE --}}
                                <td class="py-3">
                                    <div class="fw-bold text-dark">
                                        {{ $item->title }}
                                    </div>

                                    <small class="text-muted" style="font-size: 11px;">
                                        {{ $item->type }} |
                                        {{ $item->scope }}
                                    </small>
                                </td>

                                {{-- PERIOD --}}
                                <td>
                                    <div class="fw-bold text-dark small">
                                        {{ $item->period_year }} -
                                        {{ ucfirst($item->period_semester) }}
                                    </div>

                                    <small class="text-primary d-block"
                                           style="font-size: 0.7rem;">

                                        {{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}

                                    </small>
                                </td>

                                {{-- STANDARDS --}}
                                <td>
                                    @php
                                        $stds = json_decode($item->standards_used, true) ?? [];
                                    @endphp

                                    <span class="badge bg-light text-dark border px-2 fw-normal"
                                          style="font-size: 11px;">

                                        {{ count($stds) }} Standards

                                    </span>
                                </td>

                                {{-- STATUS --}}
                                <td>

                                    @php
                                        $statusColor = match($item->status) {
                                            'completed' => 'success',
                                            'ongoing' => 'primary',
                                            'cancelled' => 'danger',
                                            default => 'warning'
                                        };
                                    @endphp

                                    <span class="badge bg-{{ $statusColor }} text-uppercase"
                                          style="font-size: 0.7rem; padding: 4px 8px;">

                                        {{ $item->status }}

                                    </span>
                                </td>

                                {{-- ACTIONS --}}
                                <td class="px-4 text-center">

                                    <div class="btn-group gap-1">

                                        {{-- VIEW --}}
                                        <a href="{{ route('audit_schedules.show', $item->id) }}"
                                           class="btn btn-sm text-white px-2 py-1"
                                           style="background-color: #00bee4; font-size: 0.85rem; border-radius: 4px;">

                                            View
                                        </a>

                                        {{-- EDIT --}}
                                        <a href="{{ route('audit_schedules.edit', $item->id) }}"
                                           class="btn btn-sm text-white px-2 py-1"
                                           style="background-color: #ffc107; font-size: 0.85rem; border-radius: 4px;">

                                            Edit
                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('audit_schedules.destroy', $item->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Hapus jadwal ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm text-white px-2 py-1"
                                                    style="background-color: #dc3545; font-size: 0.85rem; border-radius: 4px;">

                                                Delete
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6"
                                    class="text-center text-muted py-5">

                                    No audit schedules found.

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            {{-- FOOTER --}}
            <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">

                <small class="text-muted">
                    Showing 1 to {{ $schedules->count() }}
                    of {{ $schedules->count() }} schedules
                </small>

                <div>
                    {{ $schedules->links() }}
                </div>

            </div>
        </div>
    </div>
    {{-- FOOTER TEXT --}}
    <div class="text-center mt-5 mb-4 text-muted small">
        &copy; 2026 SPMI Digital System - RPL
    </div>
</div>
@endsection