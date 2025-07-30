<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run()
    {
        DB::table('karyawans')->insert([
            [
                'nama' => 'Andi Setiawan',
                'password' => Hash::make('password123'),
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 1',
                'usaha_id' => 1,
                'status_akun' => 'aktif',
            ],
            [
                'nama' => 'Budi Santoso',
                'password' => Hash::make('budi12345'),
                'no_hp' => '081298765432',
                'alamat' => 'Jl. Pahlawan No. 10',
                'usaha_id' => 2,
                'status_akun' => 'nonaktif',
            ],
            [
                'nama' => 'Citra Lestari',
                'password' => Hash::make('citra2024'),
                'no_hp' => '081377788899',
                'alamat' => 'Jl. Sudirman No. 5',
                'usaha_id' => 1,
                'status_akun' => 'aktif',
            ],
        ]);
    }
}
