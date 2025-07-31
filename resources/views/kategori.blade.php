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
            padding-top: 30px;
            padding-bottom: 50px;
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
            max-width: 900px;
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

        table {
            font-size: 14px;
        }

        /* Mobile navigation */
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

        <!-- Main content -->
        <div class="col-md-9 main-content">
            <div class="card shadow p-4 mx-auto">
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
                <form action="{{ route('konten.store') }}" method="POST">
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
                    <button type="submit" class="btn btn-success">Simpan Konten</button>
                </form>

                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <hr class="my-4">

                <h2 class="mb-3">Data Konten</h2>
                <table class="table table-bordered table-striped">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Isi</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($konten as $i => $k)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $k->judul }}</td>
                                <td>{{ \Str::limit($k->isi, 50) }}</td>
                                <td>{{ $k->kategori->nama }}</td>
                                <td class="text-center">{{ $k->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('konten.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('konten.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">Belum ada konten</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Bottom Nav -->
<div class="mobile-nav d-md-none">
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('kategori') }}" class="{{ request()->routeIs('kategori') ? 'active' : '' }}">Kategori</a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
