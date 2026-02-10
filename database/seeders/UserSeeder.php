<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'IT SMP Pawyatan Daha 1 Kediri',
            'email' => 'it@smppd1.com',
            'password' => Hash::make('pawyatandaha1'),
            'role' => 'admin',
            'nip_nis' => '-',
        ]);

        // 2. Akun Guru
        User::create([
            'name' => 'Adi Nugroho, S. Sn.',
            'email' => 'nuge219@gmail.com',
            'password' => Hash::make('adinugroho'),
            'role' => 'guru',
            'nip_nis' => '-',
        ]);

        // 3. Akun Wali Murid
        User::create([
            'name' => 'Lacota Bambang Darma Yudha',
            'email' => 'lacota@bambang.com',
            'password' => Hash::make('lacotabambang'),
            'role' => 'wali_murid',
            'nip_nis' => '-', // Contoh No KTP
        ]);

        User::create([
            'name' => 'Endah Purwanti',
            'email' => 'endah@purwanti.com',
            'password' => Hash::make('endahpurwanti'),
            'role' => 'wali_murid',
            'nip_nis' => '-', // Contoh No KTP
        ]);

        User::create([
            'name' => 'Yudie Atmadja',
            'email' => 'yudie@atmadja.com',
            'password' => Hash::make('yudieatmadja'),
            'role' => 'wali_murid',
            'nip_nis' => '-', // Contoh No KTP
        ]);
    }
}