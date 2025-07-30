<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Produk;

class DetailTransaksi extends Model {
    use HasFactory;

    protected $table = 'detail_transaksi';
    // Nama tabel

    protected $primaryKey = 'detail_id';
    // Primary key

    public $timestamps = false;
    // Jika tidak menggunakan created_at dan updated_at

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    /**
    * Relasi ke model Transaksi
    */

    public function transaksi() {
        return $this->belongsTo( Transaksi::class, 'transaksi_id' );
    }

    /**
    * Relasi ke model Unit ( produk )
    */

    public function produk() {
        return $this->belongsTo( Produk::class, 'produk_id' );
        // Unit adalah nama model untuk produk
    }
}
