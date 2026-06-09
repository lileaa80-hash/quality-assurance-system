@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">
            Create Distribution
        </div>

        <form method="POST" action="{{ route('document_distributions.store') }}">
            @csrf

            <div class="card-body">

                <div class="mb-3">
                    <label>Document</label>
                    <select name="document_id" class="form-select">
                        @foreach($documents as $d)
                            <option value="{{ $d->id }}">{{ $d->title ?? $d->id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Unit</label>
                    <select name="unit_id" class="form-select">
                        @foreach($units as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Type</label>
                    <select name="distribution_type" class="form-select">
                        <option value="softcopy">Softcopy</option>
                        <option value="hardcopy">Hardcopy</option>
                        <option value="both">Both</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Distributed By</label>
                    <select name="distributed_by" class="form-select">
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="sent">Sent</option>
                        <option value="received">Received</option>
                        <option value="returned">Returned</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Distributed At</label>
                    <input type="datetime-local" name="distributed_at" class="form-control">
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection