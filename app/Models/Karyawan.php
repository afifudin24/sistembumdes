<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model {
    use Notifiable;

    protected $primaryKey = 'karyawan_id';
    protected $table = 'karyawans';
    protected $fillable = [
        'username',
        'nama',
        'password',
        'usaha_id',
        'no_hp',
        'status_akun',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = false;
    // karena tidak pakai created_at dan updated_at

    // buatkan relasi dengan usaha
    public function usaha() {
        return $this->belongsTo( Usaha::class, 'usaha_id', 'usaha_id' );
    }
}
