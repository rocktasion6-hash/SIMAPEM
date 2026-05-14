<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Warga (Pelapor)
        User::create([
            'name' => 'Ryadi Hamdani', 
            'email' => 'warga@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'warga',
        ]);

        // 2. Akun Front Office (Verifikator)
        User::create([
            'name' => 'Petugas FO',
            'email' => 'fo@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'front_office',
        ]);

        // 3. Akun Kasi (Penanggung Jawab)
        User::create([
            'name' => 'Kepala Seksi',
            'email' => 'kasi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'kasi',
        ]);

        // 4. Akun Pelaksana (Petugas Lapangan)
        User::create([
            'name' => 'Adi Pelaksana',
            'email' => 'pelaksana@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pelaksana',
        ]);

        // 5. Akun Kadis (Monitoring)
        User::create([
            'name' => 'Kepala Dinas',
            'email' => 'kadis@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'kadis',
        ]);
    }
}