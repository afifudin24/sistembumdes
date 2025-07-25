<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
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
}
