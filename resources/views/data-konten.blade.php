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
            width: 100%;
            margin-top: 30px;
        }

        h2 {
            font-weight: bold;
            color: #2f80ed;
        }

        .form-label {
            font-weight: 500;
        }

        .alert {
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
    <a href="{{ route('data.kategori') }}" class="active">Lihat Data</a>
</div>

<!-- Konten -->
<div class="col-md-9 main-content">
    <div class="card">
        <h2 class="mb-4 text-primary">Daftar Konten</h2>

        <table class="table table-bordered table-striped table-sm">
            <thead class="text-center table-primary">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Kategori</th>
                    <th>Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($konten as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ Str::limit($item->isi, 60) }}</td>
                        <td>{{ $item->kategori->nama }}</td>
                        <td class="text-center">{{ $item->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Mobile bottom nav -->
<div class="mobile-nav d-md-none">
    <a href="{{ url('/') }}">Welcome</a>
    <a href="{{ route('data.kategori') }}" class="active">Lihat Data</a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
