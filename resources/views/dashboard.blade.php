<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            overflow-x: hidden;
            background-color: #537aa0ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 100;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px 20px 50px 20px;
        }

        .sidebar h5 {
            color: #2f80ed;
            font-weight: bold;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            color: #2f80ed;
            font-weight: 500;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #2f80ed;
            color: #fff;
        }

        .card {
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        .form-label {
            font-weight: 600;
        }

        .btn-primary,
        .btn-success {
            border-radius: 10px;
            padding: 8px 20px;
        }

        .btn-success {
            background-color: #27ae60;
            border-color: #27ae60;
        }

        .btn-success:hover {
            background-color: #219150;
            border-color: #1e824c;
        }

        .alert {
            border-radius: 10px;
        }

        .profile-img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
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
                font-size: 14px;
            }

            .mobile-nav a.active {
                font-weight: bold;
                text-decoration: underline;
            }

            .card {
                margin-bottom: 80px;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar d-none d-md-block">
            <h5 class="mb-4">Menu</h5>
            <hr>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('kategori') }}" class="{{ request()->routeIs('kategori') ? 'active' : '' }}">Kategori</a>
            <br>
            <a href="{{ route('logout') }}" style="color: red;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 main-content">
            <div class="card shadow p-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row align-items-center">
                    <div class="col-md-4 text-center mb-3 mb-md-0">
                        <img 
                            src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://via.placeholder.com/150' }}" 
                            alt="Foto Profil"
                            class="profile-img">
                    </div>

                    <div class="col-md-8">
                        <h3 class="mb-3">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p class="mb-3"><strong>Login pada:</strong> {{ now()->format('d M Y') }}</p>
                        <p>Anda telah berhasil login. Ini adalah halaman dashboard sederhana.</p>

                        <!-- Tombol -->
                        <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#editModal">Edit Profil</button>
                        <button type="button" class="btn btn-info text-white mt-3 ms-2" data-bs-toggle="modal" data-bs-target="#detailModal">Detail Profil</button>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Navigation -->
<div class="mobile-nav d-md-none">
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('kategori') }}" class="{{ request()->routeIs('kategori') ? 'active' : '' }}">Kategori</a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail Profil -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <img 
                    src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://via.placeholder.com/150' }}" 
                    alt="Foto Profil" 
                    class="profile-img mb-3">
                <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Dibuat:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
