<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SPMI - User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom { background-color: #007bff; padding: 15px; color: white; font-weight: bold; margin-bottom: 30px; }
        .info-label { font-size: 0.85rem; color: #adb5bd; text-transform: uppercase; font-weight: 600; }
        .info-value { font-size: 1.1rem; color: #495057; margin-bottom: 20px; }
    </style>
</head>
<body>
    <nav class="navbar-custom"><div class="container">SPMI SYSTEM</div></nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">User Information</h5>
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $user->name }}</div>
                        
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $user->email }}</div>
                        
                        <div class="info-label">Account Status</div>
                        <div class="info-value">
                            <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }} rounded-pill px-3">
                                {{ strtoupper($user->status) }}
                            </span>
                        </div>
                        <hr>
                        <a href="{{ url('/users') }}" class="btn btn-outline-secondary w-100">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>