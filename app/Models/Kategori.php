<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // pastikan diarahkan ke tabel yg benar
    protected $table = 'kategoris';  

    protected $fillable = ['nama'];
}
