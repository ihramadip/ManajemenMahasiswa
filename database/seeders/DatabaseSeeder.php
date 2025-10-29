<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat User Admin
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('password'), // password: admin123ku
            'email_verified_at' => now(),
        ]);

        // Panggil Seeder
        $this->call([
            DosenSeeder::class,
            MataKuliahSeeder::class,
            JadwalSeeder::class,
        ]);
    }
}
