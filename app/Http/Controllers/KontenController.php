<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Konten;
use App\Models\Kategori;

class KontenController extends Controller
{
    // ===============================
    // Tampilkan daftar konten + search + pagination
    // ===============================
   public function index(Request $request)
{
    $kategori = Kategori::orderBy('nama')->get();

    $konten = Konten::with('kategori')
        ->when($request->filled('search'), function ($q) use ($request) {
            $s = $request->search;
            $q->where(function ($qq) use ($s) {
                $qq->where('judul', 'like', "%{$s}%")
                   ->orWhere('isi', 'like', "%{$s}%");
            });
        })
        // 🔹 Filter berdasarkan role
        ->when(Auth::user()->role !== 'admin', function($q) {
            $q->where(function ($qq) {
                // hanya tampilkan konten milik user sendiri ATAU konten yang dipublish
                $qq->where('user_id', Auth::id())
                   ->orWhere('is_published', true);
            });
        })
        ->latest()
        ->paginate(5)
        ->withQueryString();

    return view('konten.data-konten', compact('kategori', 'konten'));
}


    // ===============================
    // Simpan konten baru
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'isi'         => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = [
            'judul'       => $request->judul,
            'isi'         => $request->isi,
            'kategori_id' => $request->kategori_id,
            'user_id'     => Auth::id(), // simpan user yang membuat konten
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('konten', 'public');
        }

        Konten::create($data);

          return redirect()->to($request->input('previous_url', url()->previous()))
                     ->with('success', 'Konten berhasil ditambahkan!');
    }

    // ===============================
    // Tampilkan form edit
    // ===============================
    public function edit($id)
    {
        $konten   = Konten::findOrFail($id);
        $kategori = Kategori::orderBy('nama')->get();

        return view('konten.edit', compact('konten', 'kategori'));
    }

    // ===============================
    // Proses update konten
    // ===============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'isi'         => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $konten = Konten::findOrFail($id);

        $data = [
            'judul'       => $request->judul,
            'isi'         => $request->isi,
            'kategori_id' => $request->kategori_id,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('konten', 'public');
        }

        $konten->update($data);

        // Kembali ke halaman sebelumnya
        return redirect($request->previous_url ?? route('konten.index'))
               ->with('success', 'Konten berhasil diperbarui!');
    }

    // ===============================
    // Hapus konten
    // ===============================
    public function destroy(Request $request, $id)
    {
        $konten = Konten::findOrFail($id);
        $konten->delete();

         return redirect()->back()->with('success', 'Konten berhasil dihapus.');
    }

    // ===============================
    // Detail konten
    // ===============================
    public function show($id)
    {
        $konten = Konten::with('kategori')->findOrFail($id);
        return view('konten.detail', compact('konten'));
    }

    // ===============================
    // Toggle publish/unpublish
    // ===============================
    public function togglePublish($id)
{
    $konten = Konten::findOrFail($id);
    $konten->is_published = !$konten->is_published;
    $konten->save();

    return back()->with('success', 'Status konten berhasil diubah!');
}


    public function create()
{
    $kategori = \App\Models\Kategori::orderBy('nama')->get(); // kalau perlu pilih kategori
    return view('konten.create', compact('kategori'));
}
}
