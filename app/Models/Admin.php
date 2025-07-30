<?php
// app/Models/Admin.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable {
    use Notifiable;

    protected $primaryKey = 'admin_id';
    protected $table = 'admins';

    protected $fillable = [
        'nama_admin',
        'username',
        'email',
        'password',
        'no_hp',
        'alamat',
        'last_login',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = false;

    // Relasi: 1 admin memiliki banyak usaha

    public function usaha() {
        return $this->hasMany( Usaha::class, 'admin_id', 'admin_id' );
    }
}
