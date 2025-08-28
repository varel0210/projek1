@extends('layouts.admin')

@section('title', 'Tambah Konten')

@section('content')
<div class="card p-4">
    <h2 class="mb-3">Tambah Konten</h2>

    <form action="{{ route('konten.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="previous_url" value="{{ url()->previous() }}">

        <!-- Judul -->
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <!-- Isi -->
        <div class="mb-3">
            <label class="form-label">Isi</label>
            <textarea name="isi" class="form-control" rows="5" required></textarea>
        </div>

        <!-- Kategori + tombol tambah -->
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <div class="input-group">
                <select name="kategori_id" class="form-select">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalKategori">
                    + Tambah
                </button>
            </div>
        </div>

        <!-- Upload Gambar -->
        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="gambar" class="form-control">
        </div>

        <!-- Tombol aksi -->
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<!-- Modal Tambah Kategoris -->
<div class="modal fade" id="modalKategori" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('kategoris.store') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Tambah Kategoris</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
  </div>
</div>
@endsection
