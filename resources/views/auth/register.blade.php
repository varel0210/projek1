<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #537aa0ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            height: 100vh;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            color: #2f80ed;
            font-weight: 500;
            text-decoration: none;
            border-radius: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #2f80ed;
            color: #fff;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 20px;
            padding: 30px;
            background-color: #ffffffee;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-weight: bold;
            color: #2f80ed;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-success {
            background-color: #27ae60;
            border: none;
        }

        .btn-outline-primary {
            border-color: #2f80ed;
            color: #2f80ed;
        }

        .btn-outline-primary:hover {
            background-color: #2f80ed;
            color: #fff;
        }

        .alert {
            border-radius: 10px;
        }

        input.form-control {
            border-radius: 10px;
        }

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 10px;
            }

            .mobile-nav {
                display: flex;
                justify-content: space-around;
                background-color: #fff;
                border-top: 1px solid #dee2e6;
                padding: 10px 0;
                position: fixed;
                bottom: 0;
                width: 100%;
                z-index: 1000;
            }

            .mobile-nav a {
                color: #2f80ed;
                text-decoration: none;
                font-weight: 500;
            }

            .mobile-nav a.active {
                font-weight: bold;
                text-decoration: underline;
            }
        }
    </style>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar d-none d-md-block">
    <h5 class="mb-4">Menu</h5>
    <hr>
    <a href="{{ url('/') }}">Welcome</a>
    <a href="{{ route('data.kategori') }}">Lihat Data</a><br>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="register-container">
        <div class="card" style="width: 100%; max-width: 500px;">
            <h2 class="mb-4 text-center">Registrasi</h2>

            {{-- Tampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Diri</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <small class="text-muted">Format: jpg, jpeg, png. Max: 2MB</small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Daftar</button>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Mobile bottom nav -->
<div class="mobile-nav d-md-none">
    <a href="{{ url('/') }}">Welcome</a>
    <a href="{{ route('data.kategori') }}">Lihat Data</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
