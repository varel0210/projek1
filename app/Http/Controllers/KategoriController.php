<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    // Tampilkan form + daftar kategori
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori', compact('kategori'));
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100|unique:kategoris,nama',
        ]);

        // Simpan ke database
        Kategori::create([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }
}
