<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            background-color: #537aa0ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar-custom {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar-custom a {
            color: #2f80ed;
            font-weight: 500;
            text-decoration: none;
            margin-right: 15px;
            transition: color 0.3s;
        }

        .navbar-custom a:hover, .navbar-custom a.active {
            color: #1c4db7;
        }

        .main-content {
            padding: 20px;
            margin-top: 70px; /* untuk jarak di bawah navbar */
        }

        .card {
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: auto;
        }

        .profile-img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .navbar-custom a { margin-right: 10px; font-size: 14px; }
            .card { margin-bottom: 80px; }
        }
    </style>
</head>
<body>

<!-- Top Navigation -->
<nav class="navbar navbar-expand-md navbar-custom fixed-top px-4">
    <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">&#9776;</span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTop">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">Kelola User</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.data-konten') }}" class="{{ request()->routeIs('admin.data-konten') ? 'active' : '' }}">Kelola Konten</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" style="color:red;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </li>
        </ul>
    </div>
</nav>


<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

<!-- Main Content -->
<div class="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
