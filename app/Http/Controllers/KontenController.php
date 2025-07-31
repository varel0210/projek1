<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konten;
use App\Models\Kategori;

class KontenController extends Controller
{
    // Simpan konten baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id'
        ]);

        Konten::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori_id' => $request->kategori_id
        ]);

        return redirect()->route('kategori')->with('success', 'Konten berhasil ditambahkan!');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $konten = Konten::findOrFail($id);
        $kategori = Kategori::all(); // untuk dropdown pilihan kategori
        return view('konten.edit', compact('konten', 'kategori'));
    }

    // Proses update konten
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id'
        ]);

        $konten = Konten::findOrFail($id);
        $konten->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori_id' => $request->kategori_id
        ]);

        return redirect()->route('kategori')->with('success', 'Konten berhasil diperbarui!');
    }

    // Hapus konten
    public function destroy($id)
    {
        $konten = Konten::findOrFail($id);
        $konten->delete();

        return redirect()->route('kategori')->with('success', 'Konten berhasil dihapus!');
    }
}
