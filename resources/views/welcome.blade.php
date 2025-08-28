<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #537aa0ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        /* Sidebar Modern */
        .sidebar {
            height: 100vh;
            background-color: #f7f9fc;
            border-right: 1px solid #dee2e6;
            padding: 30px 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #2f80ed;
            font-weight: 500;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            margin-bottom: 10px;
        }

        .sidebar a span {
            font-size: 18px;
            margin-right: 10px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #2f80ed;
            color: #fff;
            font-weight: 600;
        }

        .sidebar a.logout {
            margin-top: auto;
            color: #e74c3c;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 20px;
            padding: 30px;
            background-color: #ffffffee;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
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

        /* Mobile nav */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; padding: 10px; }

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
                display: flex;
                flex-direction: column;
                align-items: center;
                font-size: 14px;
            }

            .mobile-nav a span {
                font-size: 18px;
            }

            .mobile-nav a.active {
                font-weight: 600;
                text-decoration: underline;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-none d-md-flex flex-column">
    <h4 class="mb-4" style="color:#2f80ed;">Menu</h4>
    
    <br>
    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
        <span>🏠</span> Welcome
    </a>
    <hr>
    
    <a href="{{ route('data.kategori') }}" class="{{ request()->routeIs('data.kategori') ? 'active' : '' }}">
        <span>📂</span> Lihat data
    </a>
    
   
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="card text-center">
        <h2>Selamat Datang</h2>
        <p>Silakan masuk atau daftar untuk mulai menggunakan aplikasi.</p>
        <div class="d-grid gap-3 col-8 col-md-6 mx-auto mt-4">
            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-success">Daftar Sekarang</a>
        </div>
    </div>
</div>

<!-- Mobile bottom nav -->
<div class="mobile-nav d-md-none">
    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
        <span>🏠</span>
        Welcome
    </a>
    <a href="{{ route('data.kategori') }}" class="{{ request()->routeIs('data.kategori') ? 'active' : '' }}">
        <span>📂</span>
        Data
    </a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span>🚪</span>
        Logout
    </a>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
