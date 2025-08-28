<!DOCTYPE html>
<html>
<head>
    <title>Kategori & Konten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            overflow-x: hidden;
            background-color: #537aa0ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar-custom {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar-custom .nav-link {
            color: #2f80ed;
            font-weight: 500;
            margin-right: 15px;
        }

        .navbar-custom .nav-link.active {
            font-weight: bold;
            color: #2f80ed;
            border-bottom: 2px solid #2f80ed;
        }

        .main-content {
            padding: 80px 20px 50px 20px; /* top padding untuk navbar */
        }

        .card {
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: auto;
        }

        .form-label { font-weight: 600; }
        .btn-primary, .btn-success { border-radius: 10px; padding: 8px 20px; }
        .btn-success { background-color: #27ae60; border-color: #27ae60; }
        .btn-success:hover { background-color: #219150; border-color: #1e824c; }
        .alert { border-radius: 10px; }
    </style>
</head>
<body>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand text-primary fw-bold" href="{{ route('dashboard') }}">User</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kategori') ? 'active' : '' }}" href="{{ route('kategori') }}">Kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('konten.index') ? 'active' : '' }}" href="{{ route('konten.index') }}">Data Konten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">
    <div class="card shadow p-4">
        <h2 class="mb-3">Tambah Kategori</h2>
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Kategori</button>
        </form>

        <hr class="my-4">

        <h2 class="mb-3">Tambah Konten</h2>
        <form action="{{ route('konten.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="mb-3">
                <label for="isi" class="form-label">Isi Konten</label>
                <textarea class="form-control" id="isi" name="isi" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="kategori_id" class="form-label">Pilih Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Gambar</label>
                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Simpan Konten</button>
        </form>

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
