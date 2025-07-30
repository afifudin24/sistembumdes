<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class Superadmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('superadmins')->insert([
            [
                'superadmin_id' => 1,
                'nama_admin'    => 'Afif Waliyudin',
                'username'      => 'afifadmin',
                'password'      => Hash::make('afif123'),
                'no_hp'         => '081111111111',
                'status'        => 'aktif',
            ],
            [
                'superadmin_id' => 2,
                'nama_admin'    => 'Budi Santoso',
                'username'      => 'budiadmin',
                'password'      => Hash::make('budi123'),
                'no_hp'         => '082222222222',
                'status'        => 'aktif',
            ],
            [
                'superadmin_id' => 3,
                'nama_admin'    => 'Citra Lestari',
                'username'      => 'citraadmin',
                'password'      => Hash::make('citra123'),
                'no_hp'         => '083333333333',
                'status'        => 'aktif',
            ],
            [
                'superadmin_id' => 4,
                'nama_admin'    => 'Dedi Kurniawan',
                'username'      => 'dediadmin',
                'password'      => Hash::make('dedi123'),
                'no_hp'         => '084444444444',
                'status'        => 'aktif',
            ],
            [
                'superadmin_id' => 5,
                'nama_admin'    => 'Eka Putri',
                'username'      => 'ekaadmin',
                'password'      => Hash::make('eka123'),
                'no_hp'         => '085555555555',
                'status'        => 'aktif',
            ],
        ]);
    }
}
