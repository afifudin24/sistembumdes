<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder {
    /**
    * Run the database seeds.
    */

    public function run(): void {
        DB::table( 'admins' )->insert( [
            [
                'username'      => 'admin1',
                'password'      => Hash::make( 'password123' ),
                'nama'          => 'Admin Satu',
                'no_hp'         => '081234567890',
                'status'        => 'aktif',

            ],
            [
                'username'      => 'admin2',
                'password'      => Hash::make( 'admin456' ),
                'nama'          => 'Admin Dua',
                'no_hp'         => '082345678901',
                'status'        => 'nonaktif',

            ],
        ] );
    }
}
