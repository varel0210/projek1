<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konten;

class DataKontenController extends Controller
{
    public function index(Request $request)
    {
        $konten = Konten::with('kategori')
            ->where('status', 'published') // hanya ambil data publish
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('judul', 'like', '%' . $request->search . '%')
                      ->orWhere('isi', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('user.konten', compact('konten'));
    }
}
