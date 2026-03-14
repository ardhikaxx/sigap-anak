<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            WilayahSeeder::class,
            FasilitasKesehatanSeeder::class,
            UserSeeder::class,
            AnakSeeder::class,
            PemeriksaanSeeder::class,
            ImunisasiSeeder::class,
            JadwalPosyanduSeeder::class,
            EdukasiSeeder::class,
            KonsultasiSeeder::class, // Seeder baru yang telah dibuat
        ]);
    }
}
