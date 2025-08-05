<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model {
    protected $primaryKey = 'produk_id';
    protected $table = 'produks';
    public $timestamps = false;
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

    public function detailTransaksi(){
        return $this->hasMany( DetailTransaksi::class, 'produk_id', 'produk_id' );
    }
}
