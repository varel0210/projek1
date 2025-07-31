<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Konten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4>Edit Konten</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('konten.update', $konten->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $konten->judul) }}" required>
                </div>

                <div class="mb-3">
                    <label for="isi" class="form-label">Isi</label>
                    <textarea name="isi" id="isi" class="form-control" rows="5" required>{{ old('isi', $konten->isi) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        @foreach($kategori as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $konten->kategori_id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('data.kategori') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
