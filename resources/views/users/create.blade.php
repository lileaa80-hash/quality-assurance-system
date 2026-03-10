<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SPMI - Add New User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom { background-color: #007bff; padding: 15px; color: white; font-weight: bold; margin-bottom: 30px; }
        .card { border-radius: 10px; border: none; }
    </style>
</head>
<body>
    <nav class="navbar-custom"><div class="container">SPMI SYSTEM</div></nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Add New User</h5>
                        <form action="{{ url('/users/store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Initial Status</label>
                                <select name="status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ url('/users') }}" class="btn btn-light text-muted">Back</a>
                                <button type="submit" class="btn btn-primary px-4">Save User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>