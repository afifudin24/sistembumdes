<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usaha extends Model {
    use HasFactory;

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

    public function units() {
        return $this->hasMany( Unit::class );
        // pastikan ada model Unit
    }
}
