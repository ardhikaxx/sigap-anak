<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WilayahSeeder::class,
            UserSeeder::class,
            FasilitasKesehatanSeeder::class,
            AnakSeeder::class,
            PemeriksaanSeeder::class,
            ImunisasiSeeder::class,
            JadwalPosyanduSeeder::class,
            EdukasiSeeder::class,
        ]);
    }
}
