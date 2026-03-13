<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnakSeeder extends Seeder
{
    public function run(): void
    {
        $namaAnakLaki = [
            'Muhammad Akbar', 'Muhammad Zidane', 'Ahmad Faiz', 'Daffa Rabbani', 'Alvaro Pratama',
            'Rafael Saputra', 'Keenan Diaz', 'Athallah Zaidan', 'Rayhan Pratama', 'Fathir Rahman',
            'Ariq Ilham', 'Arka Syahdan', 'Danendra Wahyu', 'Ghaniyu Rafi', 'Abi Yazid',
            'Arsyad', 'Bintang Pratama', 'Dzaky Saputra', 'Fadhlur Rahman', 'Hadi Wijaya',
            'Irsyad', 'Jalaluddin', 'Khalid Abdullah', 'Luqman Hakim', 'Malik Pratama',
            'Naufal Rahman', 'Oscar Wijaya', 'Putra Pratama', 'Qais Akbar', 'Rasyid Nur',
            'Satria Wiguna', 'Thariq Zaidan', 'Ukasyah', 'Vicky Prasetyo', 'Wahyu Pratama',
            'Yusuf Saputra', 'Zaidan Fathir', 'Adam Wijaya', 'Bagus Pratama', 'Derian Saputra',
        ];

        $namaAnakPerempuan = [
            'Aurelia Ayuningtyas', 'Alya Safa', 'Bella Salsabila', 'Citra Kirana', 'Dhea Ayuningtyas',
            'Fariza Kirana', 'Gabriella Octavia', 'Hafshah Najla', 'Indah Permata', 'Jasmine Kirana',
            'Kezia Ayu', 'Laras Ayuningtyas', 'Mahira Najwa', 'Nayla Salsabila', 'Olivia Kirana',
            'Putri Ayuningtyas', 'Qori Ayu', 'Rahma Salsabila', 'Sari Ayuningtyas', 'Tiara Kirana',
            'Ulya Ayu', 'Vina Salsabila', 'Winda Ayuningtyas', 'Xena Kirana', 'Yuni Ayu',
            'Zahra Salsabila', 'Aisyah Putri', 'Bunga Ayuningtyas', 'Cindy Kirana', 'Dewi Ayu',
            'Evi Salsabila', 'Fira Ayuningtyas', 'Gita Kirana', 'Hana Ayu', 'Icha Salsabila',
            'Juju Ayuningtyas', 'Kirana Ayu', 'Lina Kirana', 'Maya Ayuningtyas', 'Nisa Ayu',
        ];

        $anakIds = [];
        
        // Get ortu IDs from config (set by UserSeeder)
        $ortuIds = config('seeders.user_ids.ortu', range(1, 30));
        $faskesIds = config('seeders.faskes_ids', range(1, 20));
        $bidanIds = config('seeders.user_ids.bidan', range(1, 10));
        $kaderIds = config('seeders.user_ids.kader', range(1, 5));

        // Create 40 children
        for ($i = 0; $i < 40; $i++) {
            $isLaki = rand(0, 1) === 1;
            $nama = $isLaki ? $namaAnakLaki[$i % count($namaAnakLaki)] : $namaAnakPerempuan[$i % count($namaAnakPerempuan)];
            $jenisKelamin = $isLaki ? 'L' : 'P';
            
            // Random birth date between 1 month and 60 months (5 years) ago
            $tanggalLahir = Carbon::now()->subMonths(rand(1, 60))->subDays(rand(0, 30));
            
            // Parents (randomly assign)
            $idxOrtu = rand(0, count($ortuIds) - 1);
            $ibuId = $ortuIds[$idxOrtu];
            $ayahId = $ortuIds[($idxOrtu + 1) % count($ortuIds)];
            
            $beratLahir = $jenisKelamin === 'L' ? rand(2800, 3800) / 100 : rand(2500, 3500) / 100;
            $panjangLahir = $jenisKelamin === 'L' ? rand(46, 52) : rand(45, 51);

            $golonganDarah = ['A', 'B', 'AB', 'O'][rand(0, 3)];
            
            $anakId = DB::table('anak')->insertGetId([
                'nama' => $nama,
                'nik_anak' => '32' . rand(10, 99) . rand(100000000, 999999999),
                'tanggal_lahir' => $tanggalLahir->format('Y-m-d'),
                'jenis_kelamin' => $jenisKelamin,
                'berat_lahir' => $beratLahir,
                'panjang_lahir' => $panjangLahir,
                'golongan_darah' => $golonganDarah,
                'nomor_bpjs' => rand(0, 1) ? '000' . rand(1000000000000, 9999999999999) : null,
                'nomor_kartu_anak' => rand(0, 1) ? 'KA' . rand(100000000, 999999999) : null,
                'ibu_id' => $ibuId,
                'ayah_id' => $ayahId,
                'faskes_id' => $faskesIds[array_rand($faskesIds)],
                'nakes_pj_id' => array_rand(array_flip(array_merge($bidanIds, $kaderIds))),
                'wilayah_id' => rand(19, 28),
                'status' => 'aktif',
                'catatan_khusus' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $anakIds[] = $anakId;
        }

        config(['seeders.anak_ids' => $anakIds]);
    }
}
