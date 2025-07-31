<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Konten;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
         $konten = Konten::with('kategori')->latest()->get();
    return view('kategori', compact('kategori', 'konten'));
        return view('kategori', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        Kategori::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }
}

