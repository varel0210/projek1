<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Konten</title>
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

        .btn-primary {
            background-color: #2f80ed;
            border: none;
        }

        .table img {
            border-radius: 8px;
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
    <BR>
    <a href="{{ url('/') }}">
        <span>🏠</span> Welcome
    </a>
    <hr>
    <a href="{{ route('data.kategori') }}">
        <span>📂</span> Lihat data
    </a>
    
    
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="card">
        <h2 class="mb-4 text-center">Daftar Konten</h2>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('data.konten') }}" class="row mb-3">
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
                    <th>Gambar</th>
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
                        <td class="text-center">{{ $konten->firstItem() + $i }}</td>
                        <td class="text-center">
                            @if($k->gambar)
                                <img src="{{ asset('storage/' . $k->gambar) }}" width="80" class="img-thumbnail">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td>{{ $k->judul }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($k->isi, 50) }}</td>
                        <td>{{ $k->kategori->nama ?? '-' }}</td>
                        <td class="text-center">{{ $k->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $k->id }}">
                                Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal{{ $k->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $k->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel{{ $k->id }}">{{ $k->judul }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p><strong>Isi:</strong> {{ $k->isi }}</p>
                            <p><strong>Kategori:</strong> {{ $k->kategori->nama ?? '-' }}</p>
                            <p><strong>Gambar:</strong><br>
                                @if($k->gambar)
                                    <img src="{{ asset('storage/' . $k->gambar) }}" class="img-thumbnail" width="300">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </p>
                            <p><strong>Dibuat pada:</strong> {{ $k->created_at->format('d M Y H:i') }}</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          </div>
                        </div>
                      </div>
                    </div>

                @empty
                    <tr><td colspan="7" class="text-center">Belum ada konten</td></tr>
                @endforelse
            </tbody>
        </table>

      
   


<!-- Mobile bottom nav -->
<div class="mobile-nav d-md-none">
    <a href="{{ url('/') }}">
        <span>🏠</span> Welcome
    </a>
    <a href="{{ route('data.kategori') }}">
        <span>📂</span> Data
    </a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span>🚪</span> Logout
    </a>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
