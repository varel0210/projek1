<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konten; // pastikan model Konten sudah ada
use App\Models\Kategori;

class KontenController extends Controller
{
   public function index(Request $request)
{
    $query = Konten::with(['kategori', 'user']);

    // Filter pencarian
    if ($search = $request->input('search')) {
        $query->where('judul', 'like', "%{$search}%")
              ->orWhere('isi', 'like', "%{$search}%")
              ->orWhereHas('user', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              });
    }

    // Pagination 5 per halaman
    $konten = $query->orderBy('created_at', 'desc')->paginate(5);

    return view('admin.data-konten', compact('konten'));
}


}
