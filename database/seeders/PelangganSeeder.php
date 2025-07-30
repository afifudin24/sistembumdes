<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pelanggans')->insert([
            [
                'pelanggan_id'   => 1,
                'nama'           => 'Budi Santoso',
                'username'       => 'budi123',
                'password'       => Hash::make('password123'),
                'no_hp'          => '081234567890',
                'alamat'         => 'Jl. Merdeka No.1, Jakarta',
                'tanggal_daftar' => Carbon::now(),
                'status_akun'    => 'aktif',
            ],
            [
                'pelanggan_id'   => 2,
                'nama'           => 'Siti Aminah',
                'username'       => 'sitiaminah',
                'password'       => Hash::make('rahasia456'),
                'no_hp'          => '081987654321',
                'alamat'         => 'Jl. Kebangsaan No.2, Bandung',
                'tanggal_daftar' => Carbon::now()->subDays(3),
                'status_akun'    => 'nonaktif',
            ],
            // Tambah data lain sesuai kebutuhan
        ]);
    }
}
