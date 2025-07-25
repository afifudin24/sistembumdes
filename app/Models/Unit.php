<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model {
    protected $primaryKey = 'unit_id';

    protected $fillable = [
        'nama_unit',
        'kategori_id',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'usaha_id',
    ];

    // Relasi ke Kategori

    public function kategori() {
        return $this->belongsTo( Kategori::class, 'kategori_id', 'kategori_id' );
    }

    // Relasi ke Usaha

    public function usaha() {
        return $this->belongsTo( Usaha::class, 'usaha_id', 'usaha_id' );
    }
}
