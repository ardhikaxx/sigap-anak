<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalPosyanduSeeder extends Seeder
{
    public function run(): void
    {
        $faskesPosyandu = array_slice(config('seeders.faskes_ids', range(1, 20)), 4, 10);
        $bidanIds = config('seeders.user_ids.bidan', range(1, 10));
        $kaderIds = config('seeders.user_ids.kader', range(1, 5));

        $tema = [
            'Penimbangan Balita',
            'Imunisasi Rutin',
            'Pemberian Vitamin A',
            'Pemeriksaan Kesehatan',
            'Pelayanan Gizi',
            'Posyandu Terpadu',
            'Skrining Tumbuh Kembang',
            'Penyuluhan Gizi',
        ];

        // Create schedules for past 3 months and future 2 months
        for ($i = -3; $i <= 2; $i++) {
            $bulan = Carbon::now()->addMonths($i);
            
            foreach ($faskesPosyandu as $faskesId) {
                // 2-3 times per month per posyandu
                $jumlahPerBulan = rand(2, 3);
                
                for ($j = 0; $j < $jumlahPerBulan; $j++) {
                    $tanggal = $bulan->copy()->setDay(rand(5, 25))->startOfDay();
                    
                    $status = $tanggal->isFuture() ? 'terjadwal' : ($tanggal->isToday() ? 'sedang_berlangsung' : 'selesai');
                    
                    if ($tanggal->isPast() && rand(0, 10) < 3) {
                        $status = 'dibatalkan';
                    }

                    $jadwalId = DB::table('jadwal_posyandu')->insertGetId([
                        'faskes_id' => $faskesId,
                        'tanggal' => $tanggal->format('Y-m-d'),
                        'jam_mulai' => '08:00:00',
                        'jam_selesai' => '12:00:00',
                        'tema' => $tema[array_rand($tema)],
                        'lokasi' => 'Di Gedung Posyandu',
                        'keterangan' => 'Hubungi kader terdekat untuk informasi lebih lanjut',
                        'nakes_pj_id' => array_rand(array_flip(array_merge($bidanIds, $kaderIds))),
                        'status' => $status,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Add attendance records for past posyandu
                    if ($status === 'selesai') {
                        $anakIds = DB::table('anak')
                            ->where('faskes_id', $faskesId)
                            ->where('status', 'aktif')
                            ->pluck('id')
                            ->toArray();

                        foreach ($anakIds as $anakId) {
                            DB::table('kehadiran_posyandu')->insert([
                                'jadwal_id' => $jadwalId,
                                'anak_id' => $anakId,
                                'hadir' => rand(0, 10) < 7,
                                'keterangan' => null,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
        }
    }
}
