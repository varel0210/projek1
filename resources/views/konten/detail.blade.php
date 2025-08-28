<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Konten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="mb-3">{{ $konten->judul }}</h2>
        <p><strong>Kategori:</strong> {{ $konten->kategori->nama ?? '-' }}</p>
        <p><strong>Tanggal Dibuat:</strong> {{ $konten->created_at->format('d M Y H:i') }}</p>
        @if($konten->gambar)
            <img src="{{ asset('storage/' . $konten->gambar) }}" class="img-fluid mb-3" style="max-width:400px;">
        @endif
        <p>{{ $konten->isi }}</p>
        <hr>
        <br>
       <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>

    </div>
</div>

</body>
</html>
