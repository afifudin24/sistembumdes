<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('usaha')->insert([
            [
                'nama_usaha'   => 'Kedai Nusantara',
                'keterangan'   => 'Usaha kuliner lokal',
                'admin_id'     => 1,
                'alamat'       => 'Jl. Merdeka No.1',
                'no_telepon'   => '081234567890',
                'email'        => 'kedainusantara@example.com',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            [
                'nama_usaha'   => 'Batik Jatilawangan',
                'keterangan'   => 'Kerajinan batik tradisional',
                'admin_id'     => 2,
                'alamat'       => 'Jl. Batik Raya No.12',
                'no_telepon'   => '081234567891',
                'email'        => 'batikjatilawangan@example.com',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            [
                'nama_usaha'   => 'Tirta Tunjung',
                'keterangan'   => 'Distribusi air minum',
                'admin_id'     => 3,
                'alamat'       => 'Jl. Tirta Sejuk No.45',
                'no_telepon'   => '081234567892',
                'email'        => 'tirtatunjung@example.com',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
        ]);
    }
}
