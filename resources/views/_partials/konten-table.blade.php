{{-- resources/views/_partials/konten-table.blade.php --}}
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
        @php
            // start index: jika paginator ada firstItem(), gunakan itu; otherwise mulai 1
            $start = method_exists($konten, 'firstItem') ? $konten->firstItem() : 1;
        @endphp

        @forelse ($konten as $i => $k)
            <tr>
                <td class="text-center">{{ $start + $i }}</td>
                <td>{{ $k->judul }}</td>
                <td>{{ \Str::limit($k->isi, 50) }}</td>
                <td>{{ optional($k->kategori)->nama }}</td>
                <td class="text-center">{{ $k->created_at ? $k->created_at->format('d M Y') : '-' }}</td>
                <td class="text-center">
                    @if(Route::has('konten.edit'))
                        <a href="{{ route('konten.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    @endif
                    @if(Route::has('konten.destroy'))
                        <form action="{{ route('konten.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">Belum ada konten</td></tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination jika available (Paginator punya method links()) --}}
@if (method_exists($konten, 'links') && $konten->hasPages())
    <div class="d-flex justify-content-center">
        {{ $konten->appends(request()->only('search'))->links('pagination::bootstrap-5') }}
    </div>
@endif
