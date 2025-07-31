<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #537aa0ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
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
            max-width: 500px;
            margin: 60px auto;
        }

        h2 {
            font-weight: bold;
            color: #2f80ed;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #2f80ed;
            border: none;
        }

        .btn-outline-success {
            border-color: #27ae60;
            color: #27ae60;
        }

        .btn-outline-success:hover {
            background-color: #27ae60;
            color: #fff;
        }

        .alert {
            border-radius: 10px;
        }

        input.form-control {
            border-radius: 10px;
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
    
    <a href="{{ route('data.kategori') }}">Lihat Data</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="card">
        <h2 class="mb-4 text-center">Login</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="rememberCheck">
                <label class="form-check-label" for="rememberCheck">Ingat saya</label>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="{{ route('register') }}" class="btn btn-outline-success">Daftar Sekarang</a>
            </div>
        </form>
    </div>
</div>

<!-- Mobile bottom nav -->
<div class="mobile-nav d-md-none">
    <a href="{{ url('/') }}">Welcome</a>
    <a href="{{ route('data.kategori') }}">Data</a>
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
