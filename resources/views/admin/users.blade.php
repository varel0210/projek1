@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Daftar User</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <!-- Tombol Tambah User + Export -->
    <div class="mb-3 d-flex justify-content-end gap-2">
        <a href="{{ route('users.create') }}" class="btn btn-primary">➕ Tambah User</a>
        <a href="{{ route('users.export') }}" class="btn btn-success">📥 Export</a>
    </div>

    <table class="table table-hover table-striped shadow-sm">
        <thead class="table-dark">
            <tr class="text-center">
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Akses</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="align-middle text-center">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">✏ Edit</a>

                        <!-- Tombol Kelola Permission -->
                        <button class="btn btn-sm btn-success"
                                data-bs-toggle="modal"
                                data-bs-target="#permissionModal{{ $user->id }}">
                            ⚙ Permission
                        </button>

                        <!-- Modal Permission -->
                        <div class="modal fade" id="permissionModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <form action="{{ route('users.updatePermission', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                  <h5 class="modal-title">Kelola Permission: {{ $user->name }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                               id="konten{{ $user->id }}"
                                               name="permissions[]"
                                               value="konten"
                                               {{ str_contains($user->role, 'konten') ? 'checked' : '' }}>
                                        <label for="konten{{ $user->id }}" class="form-check-label">Kelola Konten</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                               id="kategori{{ $user->id }}"
                                               name="permissions[]"
                                               value="kategori"
                                               {{ str_contains($user->role, 'kategori') ? 'checked' : '' }}>
                                        <label for="kategori{{ $user->id }}" class="form-check-label">Kelola Kategori</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-primary">💾 Simpan</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus user ini?')" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">🗑 Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
