<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Usaha extends Model {
    use HasFactory;

    protected $table = 'usaha';

    protected $fillable = [
        'nama_usaha',
        'keterangan',
        'admin_id',
        'alamat',
        'no_telepon',
        'email',
    ];

    // Relasi ke User ( Admin )

    public function admin() {
        return $this->belongsTo( User::class, 'admin_id' );
    }

    // Relasi ke produk/unit jika ada

    public function produk() {
        return $this->hasMany( Produk::class );
        // pastikan ada model Unit
    }

    public function transaksis() {
        return $this->hasMany( Transaksi::class, 'usaha_id', 'usaha_id' );
    }

}
