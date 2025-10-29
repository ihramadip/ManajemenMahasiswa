<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $prodi = ['Teknik Informatika', 'Sistem Informasi', 'Manajemen Informatika', 'Ilmu Komputer'];
        $gelar = ['S.Kom., M.Kom.', 'S.T., M.T.', 'S.Si., M.Si.', 'Dr.', 'Prof. Dr.'];

        for ($i = 1; $i <= 20; $i++) {
            $nama_lengkap = $faker->name . ', ' . $faker->randomElement($gelar);
            $email = $faker->unique()->safeEmail;

            // Buat user
            $user = User::create([
                'name' => $nama_lengkap, // Menggunakan nama lengkap untuk nama login juga
                'email' => $email,
                'password' => Hash::make('dosen' . str_pad($i, 3, '0', STR_PAD_LEFT)), // password: dosen001, dosen002, ...
                'role' => 'dosen',
            ]);

            // Buat data dosen
            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $faker->unique()->numerify('##########'), // NIDN 10 digit
                'nama_lengkap' => $nama_lengkap,
                'email' => $email,
                'prodi' => $faker->randomElement($prodi),
            ]);
        }
    }
}