<?php

namespace App\Http\Controllers;

use App\Models\Konten;

class DataKategoriController extends Controller
{
    public function index()
    {
        // Ambil semua konten beserta kategori-nya, urutkan dari terbaru
        $konten = Konten::with('kategori')->latest()->get();

        // Kirim ke view data-konten.blade.php
        return view('data-konten', compact('konten'));
    }
}
