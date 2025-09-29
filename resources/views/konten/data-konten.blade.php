<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Konten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            overflow-x: hidden;
            background-color: #537aa0ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; padding: 0;
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
        .btn-primary, .btn-success, .btn-info, .btn-warning, .btn-danger {
            border-radius: 10px; padding: 8px 20px;
        }
        .btn-success { background-color: #27ae60; border-color: #27ae60; }
        .btn-success:hover { background-color: #219150; border-color: #1e824c; }
        .alert { border-radius: 10px; }
    </style>
</head>
<body>

@php
    use Illuminate\Support\Str;
    $role = Auth::user()->role ?? '';
@endphp

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
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        Home
                    </a>
                </li>

                {{-- hanya tampil jika user punya izin kategori --}}
                @if(Str::contains($role, 'kategori'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kategori') ? 'active' : '' }}" 
                       href="{{ route('kategori') }}">
                        Kategori
                    </a>
                </li>
                @endif

                {{-- hanya tampil jika user punya izin konten --}}
                @if(Str::contains($role, 'konten'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('konten.index') ? 'active' : '' }}" 
                       href="{{ route('konten.index') }}">
                        Data Konten
                    </a>
                </li>
                @endif

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

        <h2 class="mb-3">Data Konten</h2>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('konten.index') }}" class="row mb-3">
            <div class="col-md-6 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Cari judul atau isi..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 mb-2">
                <button class="btn btn-primary w-100">Cari</button>
            </div>
        </form>

        <!-- Tabel Konten -->
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Kategori</th>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($konten as $i => $k)
                    <tr>
                        <td class="text-center">{{ $konten->firstItem() + $i }}</td>
                        <td>{{ $k->judul }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($k->isi, 50) }}</td>
                        <td>{{ $k->kategori->nama ?? '-' }}</td>
                        <td class="text-center">
                            @if($k->gambar)
                                <img src="{{ asset('storage/' . $k->gambar) }}" width="80" class="img-thumbnail">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $k->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('konten.show', $k->id) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('konten.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('konten.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Belum ada konten</td></tr>
                @endforelse
            </tbody>
        </table>

      <!-- Pagination Sederhana -->
<div class="d-flex justify-content-between align-items-center mt-3">
    <!-- Info hasil -->
    <div class="text-muted">
        Menampilkan {{ $konten->firstItem() }} sampai {{ $konten->lastItem() }} dari {{ $konten->total() }} konten
    </div>

    <!-- Navigasi halaman sederhana -->
    <div>
        @if ($konten->lastPage() > 1)
            @for ($page = 1; $page <= $konten->lastPage(); $page++)
                @if ($page == $konten->currentPage())
                    <span style="margin: 0 5px; font-weight: bold;">{{ $page }}</span>
                @else
                    <a href="{{ $konten->url($page) }}" style="margin: 0 5px; text-decoration: none; color: #2f80ed;">
                        {{ $page }}
                    </a>
                @endif
            @endfor
        @endif
    </div>
</div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
