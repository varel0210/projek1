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
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
            <label class="form-label">Foto Profil</label>
            <input type="file" name="photo" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Password Baru (Opsional)</label>
            <input type="password" name="password" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Detail Profil -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Detail Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://via.placeholder.com/150' }}" 
             class="profile-img mb-3">
        <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        <p><strong>Login terakhir:</strong> {{ now()->format('d M Y H:i') }}</p>
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
