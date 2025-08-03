<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Superadmin extends Model
{
    /** @use HasFactory<\Database\Factories\SuperadminFactory> */
    use HasFactory;
    protected $table = 'superadmins';
    protected $primaryKey = 'superadmin_id';
    public $timestamps = false;
     protected $fillable = [
        'username',
        'nama',
        'password',
        'no_hp',
        'status',
    ];

}
