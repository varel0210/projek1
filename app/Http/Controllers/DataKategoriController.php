<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konten;

class DataKategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query dengan pencarian judul atau isi
        $konten = Konten::with('kategori')
            ->when($search, function($query) use ($search) {
                $query->where('judul', 'like', "%{$search}%")
                      ->orWhere('isi', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // agar search tetap ada saat pagination

        return view('data-konten', compact('konten'));
    }


public function show($id)
{
    $konten = Konten::with('kategori')->findOrFail($id);
    return view('detail', compact('konten'));
}

}
