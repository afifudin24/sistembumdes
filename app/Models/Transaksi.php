<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model {
    use HasFactory;

    protected $table = 'transaksi';
    // Nama tabel di database

    protected $primaryKey = 'transaksi_id';
    // Primary key

    public $timestamps = false;
    // Jika tidak ada kolom created_at dan updated_at

    protected $fillable = [
        'pelanggan_id',
        'nama_penerima',
        'alamat',
        'tanggal',
        'total_harga',
        'status_transaksi',
        'metode_pembayaran',
        'keterangan',
    ];

    /**
    * Relasi ke model Pelanggan
    */

    public function pelanggan() {
        return $this->belongsTo( Pelanggan::class, 'pelanggan_id' );
    }
}
