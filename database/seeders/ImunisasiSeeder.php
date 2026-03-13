<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImunisasiSeeder extends Seeder
{
    public function run(): void
    {
        $anakIds = config('seeders.anak_ids', range(1, 40));
        $bidanIds = config('seeders.user_ids.bidan', range(1, 10));
        $faskesIds = config('seeders.faskes_ids', range(1, 20));

        $vaksin = [
            ['nama' => 'BCG', 'dosis' => '1', 'bulan' => 0],
            ['nama' => 'Polio 1', 'dosis' => '1', 'bulan' => 0],
            ['nama' => 'Polio 2', 'dosis' => '2', 'bulan' => 1],
            ['nama' => 'Polio 3', 'dosis' => '3', 'bulan' => 2],
            ['nama' => 'Polio 4', 'dosis' => '4', 'bulan' => 3],
            ['nama' => 'DPT-HB-Hib 1', 'dosis' => '1', 'bulan' => 1],
            ['nama' => 'DPT-HB-Hib 2', 'dosis' => '2', 'bulan' => 2],
            ['nama' => 'DPT-HB-Hib 3', 'dosis' => '3', 'bulan' => 3],
            ['nama' => 'PCV 1', 'dosis' => '1', 'bulan' => 2],
            ['nama' => 'PCV 2', 'dosis' => '2', 'bulan' => 4],
            ['nama' => 'Rotavirus 1', 'dosis' => '1', 'bulan' => 2],
            ['nama' => 'Rotavirus 2', 'dosis' => '2', 'bulan' => 4],
            ['nama' => 'MR 1', 'dosis' => '1', 'bulan' => 9],
            ['nama' => 'MR 2', 'dosis' => '2', 'bulan' => 18],
            ['nama' => 'Vitamin A', 'dosis' => '1', 'bulan' => 6, 'repeat' => true],
        ];

        foreach ($anakIds as $anakId) {
            $anak = DB::table('anak')->where('id', $anakId)->first();
            $tanggalLahir = Carbon::parse($anak->tanggal_lahir);
            
            // Give random immunizations (not all complete)
            $jumlahVaksin = rand(5, 14);
            
            for ($i = 0; $i < $jumlahVaksin; $i++) {
                $v = $vaksin[rand(0, count($vaksin) - 1)];
                $tanggal = $tanggalLahir->copy()->addMonths($v['bulan']);
                
                // Add some variation in date
                if ($tanggal->isFuture()) {
                    continue;
                }
                
                $tanggal = $tanggal->addDays(rand(-5, 10));
                
                $umurSaatIni = $tanggalLahir->diffInMonths($tanggal);
                
                DB::table('imunisasi')->insert([
                    'anak_id' => $anakId,
                    'jenis_vaksin' => $v['nama'],
                    'dosis' => $v['dosis'],
                    'tanggal' => $tanggal->format('Y-m-d'),
                    'umur_saat_ini' => $umurSaatIni,
                    'nakes_id' => array_rand(array_flip($bidanIds)),
                    'faskes_id' => array_rand(array_flip(array_slice($faskesIds, 4, 10))),
                    'nomor_batch' => 'B' . rand(100000, 999999),
                    'status' => 'selesai',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
