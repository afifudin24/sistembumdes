<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model {
    use Notifiable;

    protected $primaryKey = 'pelanggan_id';
    protected $table = 'pelanggans';
    protected $fillable = [
        'nama',
        'username',
        'password',

        'no_hp',
        'alamat',
        'tanggal_daftar',
        'status_akun',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = false;
    // karena tidak pakai created_at dan updated_at

    // buatkan relasi dengan transaksi

    public function transaksi() {
        return $this->hasMany( Transaksi::class, 'pelanggan_id' );
    }
}
