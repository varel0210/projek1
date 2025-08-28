@extends('layouts.admin') <!-- template utama -->

@section('title', 'Data Konten Admin')

@section('content')
<div class="data-konten-card">

    <h2 class="mb-3">Data Konten (Admin)</h2>

    <!-- Buttons admin -->
    <div class="mb-3">
        <a href="{{ route('konten.create') }}" class="btn btn-success">Tambah Konten Baru</a>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('admin.data-konten') }}" class="row mb-3">
        <div class="col-md-6 mb-2">
            <input type="text" name="search" class="form-control" placeholder="Cari judul, isi, atau user..." value="{{ request('search') }}">
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
                <th>User</th>
                <th>Status</th>
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
                    <td>{{ $k->user->name ?? '-' }}</td>
                    <td class="text-center">
                        @if($k->is_published)
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-secondary">Draft</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $k->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('konten.show', $k->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('konten.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('konten.destroy', $k->id) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>

                        <!-- Publish/Unpublish -->
                        <form action="{{ route('konten.toggle-publish', $k->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-primary">
                                {{ $k->is_published ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada konten</td>
                </tr>
            @endforelse
        </tbody>
    </table>

   <!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted">
        Menampilkan {{ $konten->firstItem() }} sampai {{ $konten->lastItem() }} dari {{ $konten->total() }} konten
    </div>
    <div class="d-flex">
        @if ($konten->lastPage() > 1)
            @for ($page = 1; $page <= $konten->lastPage(); $page++)
                @if ($page == $konten->currentPage())
                    <span style="
                        margin: 0 5px;
                        font-weight: bold;
                        padding: 5px 10px;
                        border-radius: 5px;
                        background-color: #2f80ed;
                        color: #fff;
                        display: inline-block;
                    ">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $konten->url($page) }}" style="
                        margin: 0 5px;
                        text-decoration: none;
                        color: #2f80ed;
                        padding: 5px 10px;
                        border-radius: 5px;
                        background-color: #e0e0e0;
                        display: inline-block;
                        transition: background-color 0.3s;
                    " onmouseover="this.style.backgroundColor='#b0c4ff';" onmouseout="this.style.backgroundColor='#e0e0e0';">
                        {{ $page }}
                    </a>
                @endif
            @endfor
        @endif
    </div>
</div>


</div>
@endsection
