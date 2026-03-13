<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemeriksaanSeeder extends Seeder
{
    public function run(): void
    {
        $anakIds = config('seeders.anak_ids', range(1, 40));
        $bidanIds = config('seeders.user_ids.bidan', range(1, 10));
        $kaderIds = config('seeders.user_ids.kader', range(1, 5));
        $faskesIds = config('seeders.faskes_ids', range(1, 20));

        $statusGizi = ['normal', 'berisiko', 'stunting', 'wasting', 'underweight', 'overweight', 'obesitas', 'gizi_buruk'];
        
        foreach ($anakIds as $anakId) {
            // Get child's birth date
            $anak = DB::table('anak')->where('id', $anakId)->first();
            $tanggalLahir = Carbon::parse($anak->tanggal_lahir);
            $jenisKelamin = $anak->jenis_kelamin;
            
            // Generate 3-8 examinations per child
            $jumlahPemeriksaan = rand(3, 8);
            
            for ($i = 0; $i < $jumlahPemeriksaan; $i++) {
                $tanggalPeriksa = $tanggalLahir->copy()->addMonths(rand(1, 60));
                
                // Make sure examination date is in the past
                if ($tanggalPeriksa->isFuture()) {
                    $tanggalPeriksa = Carbon::now()->subMonths(rand(0, 2));
                }
                
                $umurBulan = $tanggalLahir->diffInMonths($tanggalPeriksa);
                
                // Generate weight and height based on age and gender (realistic values)
                $bbData = $this->getBeratBadan($jenisKelamin, $umurBulan);
                $tbData = $this->getTinggiBadan($jenisKelamin, $umurBulan);
                
                $beratBadan = $bbData['berat'];
                $tinggiBadan = $tbData['tinggi'];
                
                // Calculate Z-scores
                $bb_u_zscore = $this->calculateZScore($beratBadan, $bbData['median'], $bbData['sd']);
                $tb_u_zscore = $this->calculateZScore($tinggiBadan, $tbData['median'], $tbData['sd']);
                $bb_tb_zscore = $this->calculateBBTBZScore($beratBadan, $tinggiBadan, $jenisKelamin, $umurBulan);
                
                // Determine status
                $status_bb_u = $this->getStatusBBU($bb_u_zscore);
                $status_tb_u = $this->getStatusTBU($tb_u_zscore);
                $status_bb_tb = $this->getStatusBBTB($bb_tb_zscore);
                $status_gizi_akhir = $this->getStatusGiziAkhir($status_bb_u, $status_tb_u, $status_bb_tb);
                
                // Random chance of intervention
                $diberikan_vit_a = rand(0, 10) < 3;
                $diberikan_fe = rand(0, 10) < 2;
                
                // Chance of referral (lower for normal status)
                $dirujuk = $status_gizi_akhir === 'gizi_buruk' || $status_gizi_akhir === 'stunting' ? rand(0, 10) < 4 : false;

                DB::table('pemeriksaan')->insert([
                    'anak_id' => $anakId,
                    'nakes_id' => array_rand(array_flip($bidanIds)),
                    'posyandu_id' => array_rand(array_flip(array_slice($faskesIds, 4, 10))),
                    'tanggal_periksa' => $tanggalPeriksa->format('Y-m-d'),
                    'umur_bulan' => $umurBulan,
                    'berat_badan' => $beratBadan,
                    'tinggi_badan' => $tinggiBadan,
                    'lingkar_kepala' => rand(32, 50) + rand(0, 9) / 10,
                    'lingkar_lengan' => rand(10, 18) + rand(0, 9) / 10,
                    'bb_u_zscore' => $bb_u_zscore,
                    'tb_u_zscore' => $tb_u_zscore,
                    'bb_tb_zscore' => $bb_tb_zscore,
                    'status_bb_u' => $status_bb_u,
                    'status_tb_u' => $status_tb_u,
                    'status_bb_tb' => $status_bb_tb,
                    'status_gizi_akhir' => $status_gizi_akhir,
                    'suhu_tubuh' => rand(360, 375) / 10,
                    'kondisi_umum' => ['baik', 'sedang', 'buruk'][rand(0, 2)],
                    'edema' => $status_gizi_akhir === 'gizi_buruk' && rand(0, 10) < 3,
                    'diberikan_vit_a' => $diberikan_vit_a,
                    'diberikan_fe' => $diberikan_fe,
                    'diberikan_zinc' => false,
                    'diberikan_pmt' => $status_gizi_akhir === 'gizi_buruk' || $status_gizi_akhir === 'underweight',
                    'dirujuk' => $dirujuk,
                    'tujuan_rujukan' => $dirujuk ? 'Puskesmas Ciumbuleuit' : null,
                    'catatan' => rand(0, 10) < 3 ? 'Pemeriksaan rutin bulanan' : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function getBeratBadan($jk, $umurBulan) {
        // WHO median and SD for BB/U
        $data = [
            'L' => [
                0 => ['median' => 3.3, 'sd' => 0.475], 1 => ['median' => 4.5, 'sd' => 0.6], 3 => ['median' => 6.4, 'sd' => 0.725],
                6 => ['median' => 7.9, 'sd' => 1.05], 9 => ['median' => 9.2, 'sd' => 1.15], 12 => ['median' => 9.6, 'sd' => 1.275],
                18 => ['median' => 10.9, 'sd' => 1.375], 24 => ['median' => 12.2, 'sd' => 1.575], 36 => ['median' => 14.3, 'sd' => 1.75],
                48 => ['median' => 16.3, 'sd' => 1.95], 60 => ['median' => 18.3, 'sd' => 2.175],
            ],
            'P' => [
                0 => ['median' => 3.2, 'sd' => 0.45], 1 => ['median' => 4.1, 'sd' => 0.55], 3 => ['median' => 5.8, 'sd' => 0.675],
                6 => ['median' => 7.3, 'sd' => 0.95], 9 => ['median' => 8.6, 'sd' => 1.05], 12 => ['median' => 8.9, 'sd' => 1.175],
                18 => ['median' => 10.2, 'sd' => 1.25], 24 => ['median' => 11.5, 'sd' => 1.475], 36 => ['median' => 13.9, 'sd' => 1.65],
                48 => ['median' => 16.0, 'sd' => 1.85], 60 => ['median' => 18.2, 'sd' => 2.075],
            ]
        ];
        
        $key = $this->getClosestKey($umurBulan, array_keys($data[$jk]));
        $d = $data[$jk][$key];
        
        // Add some variation (-2 to +2 SD)
        $variance = rand(-20, 20) / 10;
        return ['berat' => round($d['median'] + ($d['sd'] * $variance), 2), 'median' => $d['median'], 'sd' => $d['sd']];
    }

    private function getTinggiBadan($jk, $umurBulan) {
        $data = [
            'L' => [
                0 => ['median' => 49.9, 'sd' => 2.15], 3 => ['median' => 61.4, 'sd' => 2.625], 6 => ['median' => 67.6, 'sd' => 2.925],
                9 => ['median' => 72.0, 'sd' => 3.0], 12 => ['median' => 75.7, 'sd' => 3.25], 18 => ['median' => 82.3, 'sd' => 3.375],
                24 => ['median' => 87.8, 'sd' => 3.625], 36 => ['median' => 96.1, 'sd' => 3.95], 48 => ['median' => 103.3, 'sd' => 4.25],
                60 => ['median' => 110.0, 'sd' => 4.5],
            ],
            'P' => [
                0 => ['median' => 49.1, 'sd' => 2.05], 3 => ['median' => 59.8, 'sd' => 2.625], 6 => ['median' => 65.7, 'sd' => 2.8],
                9 => ['median' => 70.1, 'sd' => 2.9], 12 => ['median' => 74.0, 'sd' => 3.125], 18 => ['median' => 80.7, 'sd' => 3.25],
                24 => ['median' => 86.4, 'sd' => 3.5], 36 => ['median' => 95.1, 'sd' => 3.8], 48 => ['median' => 102.7, 'sd' => 4.1],
                60 => ['median' => 109.4, 'sd' => 4.35],
            ]
        ];
        
        $key = $this->getClosestKey($umurBulan, array_keys($data[$jk]));
        $d = $data[$jk][$key];
        
        $variance = rand(-20, 20) / 10;
        return ['tinggi' => round($d['median'] + ($d['sd'] * $variance), 1), 'median' => $d['median'], 'sd' => $d['sd']];
    }

    private function getClosestKey($target, $keys) {
        return array_reduce($keys, function($carry, $item) use ($target) {
            return abs($item - $target) < abs($carry - $target) ? $item : $carry;
        });
    }

    private function calculateZScore($measurement, $median, $sd) {
        return round(($measurement - $median) / $sd, 2);
    }

    private function calculateBBTBZScore($bb, $tb, $jk, $umurBulan) {
        // Simplified BB/TB calculation
        $bb_tb_median = ($tb / 100) * ($tb / 100) * 15; // rough estimate
        $sd = 1.5;
        return round(($bb - $bb_tb_median) / $sd, 2);
    }

    private function getStatusBBU($z) {
        if ($z < -3) return 'gizi_buruk';
        if ($z < -2) return 'gizi_kurang';
        if ($z <= 1) return 'gizi_baik';
        if ($z <= 2) return 'gizi_lebih';
        return 'obesitas';
    }

    private function getStatusTBU($z) {
        if ($z < -3) return 'sangat_pendek';
        if ($z < -2) return 'pendek';
        return 'normal';
    }

    private function getStatusBBTB($z) {
        if ($z < -3) return 'sangat_kurus';
        if ($z < -2) return 'kurus';
        if ($z <= 1) return 'normal';
        if ($z <= 2) return 'gemuk';
        return 'obesitas';
    }

    private function getStatusGiziAkhir($bb_u, $tb_u, $bb_tb) {
        if (in_array($bb_u, ['gizi_buruk']) || in_array($bb_tb, ['sangat_kurus'])) return 'gizi_buruk';
        if (in_array($bb_u, ['gizi_kurang']) || in_array($bb_tb, ['kurus'])) return 'underweight';
        if (in_array($tb_u, ['sangat_pendek', 'pendek'])) return 'stunting';
        if (in_array($bb_tb, ['sangat_kurus', 'kurus'])) return 'wasting';
        if (in_array($bb_u, ['obesitas']) || in_array($bb_tb, ['obesitas'])) return 'obesitas';
        if (in_array($bb_u, ['gizi_lebih']) || in_array($bb_tb, ['gemuk'])) return 'overweight';
        return 'normal';
    }
}
