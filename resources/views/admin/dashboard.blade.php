@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="card shadow p-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row align-items-center mb-4">
        <div class="col-md-4 text-center mb-3 mb-md-0">
            <img 
                src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://via.placeholder.com/120' }}" 
                alt="Foto Admin"
                class="profile-img">
        </div>

        <div class="col-md-8">
            <h3 class="mb-3">Halo, {{ Auth::user()->name }}!</h3>
            <p class="mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p class="mb-3"><strong>Login pada:</strong> {{ now()->format('d M Y') }}</p>

            <!-- Tombol aksi -->
            <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#editModal">
                Edit Profil
            </button>
            <button type="button" class="btn btn-info text-white mt-3 ms-2" data-bs-toggle="modal" data-bs-target="#detailModal">
                Detail Profil
            </button>
        </div>
    </div>
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
@endsection
