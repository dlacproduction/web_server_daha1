<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Admin IT SMP Pawyatan Daha 1', // Nama Anda
            'email'    => 'admin@it.com',              // Ini username untuk login admin
            'password' => Hash::make('12345678'), // Password admin
            'role'     => 'admin',
        ]);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            SchoolSeeder::class,
            SubjectSeeder::class,
        ]);
    }
}
