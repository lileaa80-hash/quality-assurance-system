@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark py-3">
            <h5 class="mb-0 fw-bold">SPMI SYSTEM - Edit User Profile</h5>
        </div>
        
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Account Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <div class="alert alert-info border-0 shadow-sm mt-3 mb-0" style="font-size: 0.8rem;">
                            <i class="fas fa-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengubah password.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="New password">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top">
                    <a href="{{ route('users.index') }}" class="btn btn-light border px-4">Cancel</a>
                    <button type="submit" class="btn btn-warning text-dark fw-bold px-4 shadow-sm">Update User</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection