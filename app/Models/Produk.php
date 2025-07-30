<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model {
    protected $primaryKey = 'unit_id';
    protected $table = 'produks';
    protected $timestamps = false;
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'gambar',
        'usaha_id',
    ];

    // Relasi ke Kategori

    // Relasi ke Usaha

    public function usaha() {
        return $this->belongsTo( Usaha::class, 'usaha_id', 'usaha_id' );
    }
}
