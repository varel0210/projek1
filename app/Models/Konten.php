<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    protected $table = 'konten';
    protected $fillable = ['judul', 'isi', 'kategori_id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
