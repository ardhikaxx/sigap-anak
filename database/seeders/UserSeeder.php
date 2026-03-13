<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        $superadminId = DB::table('users')->insertGetId([
            'name' => 'Admin Sistem',
            'email' => 'admin@sigapanak.id',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
            'is_active' => true,
            'email_verified' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Nakes - Dokter
        $dokterIds = [];
        $dokterData = [
            ['name' => 'Dr. Ahmad Wijaya, Sp.A', 'email' => 'ahmad.wijaya@sigapanak.id', 'phone' => '081234567891', 'spesialisasi' => 'Spesialis Anak'],
            ['name' => 'Dr. Dewi Susilowati, Sp.GK', 'email' => 'dewi.susilowati@sigapanak.id', 'phone' => '081234567892', 'spesialisasi' => 'Spesialis Gizi'],
            ['name' => 'Dr. Budi Santoso, Sp.A', 'email' => 'budi.santoso@sigapanak.id', 'phone' => '081234567893', 'spesialisasi' => 'Spesialis Anak'],
            ['name' => 'Dr. Rina Marlina, Sp.A', 'email' => 'rina.marlina@sigapanak.id', 'phone' => '081234567894', 'spesialisasi' => 'Spesialis Anak'],
            ['name' => 'Dr. Hendra Gunawan, M.Kes', 'email' => 'hendra.gunawan@sigapanak.id', 'phone' => '081234567895', 'spesialisasi' => 'Kesehatan Anak'],
        ];

        foreach ($dokterData as $d) {
            $userId = DB::table('users')->insertGetId([
                'name' => $d['name'],
                'email' => $d['email'],
                'phone' => $d['phone'],
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'is_active' => true,
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            DB::table('nakes_profile')->insert([
                'user_id' => $userId,
                'nip' => '19' . rand(100000, 999999) . rand(100, 999),
                'str_number' => 'STR/' . rand(100000, 999999),
                'spesialisasi' => $d['spesialisasi'],
                'verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $dokterIds[] = $userId;
        }

        // Nakes - Bidan
        $bidanData = [
            ['name' => 'Sri Wahyuni, Am.Keb', 'email' => 'sri.wahyuni@sigapanak.id', 'phone' => '081234567901'],
            ['name' => 'Nita Kartika, Am.Keb', 'email' => 'nita.kartika@sigapanak.id', 'phone' => '081234567902'],
            ['name' => 'Yanti Rohaeti, S.ST', 'email' => 'yanti.rohaeti@sigapanak.id', 'phone' => '081234567903'],
            ['name' => 'Maya Sofiaty, Am.Keb', 'email' => 'maya.sofiaty@sigapanak.id', 'phone' => '081234567904'],
            ['name' => 'Rina Kusuma, S.ST', 'email' => 'rina.kusuma@sigapanak.id', 'phone' => '081234567905'],
            ['name' => 'Dewi Lestari, Am.Keb', 'email' => 'dewi.lestari@sigapanak.id', 'phone' => '081234567906'],
            ['name' => 'Siti Rahayu, Am.Keb', 'email' => 'siti.rahayu@sigapanak.id', 'phone' => '081234567907'],
            ['name' => 'Titi Herawati, S.ST', 'email' => 'titi.herawati@sigapanak.id', 'phone' => '081234567908'],
        ];

        $bidanIds = [];
        foreach ($bidanData as $b) {
            $userId = DB::table('users')->insertGetId([
                'name' => $b['name'],
                'email' => $b['email'],
                'phone' => $b['phone'],
                'password' => Hash::make('password123'),
                'role' => 'bidan',
                'is_active' => true,
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            DB::table('nakes_profile')->insert([
                'user_id' => $userId,
                'nip' => '19' . rand(100000, 999999) . rand(100, 999),
                'str_number' => 'STR/' . rand(100000, 999999),
                'spesialisasi' => 'Bidan',
                'verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $bidanIds[] = $userId;
        }

        // Nakes - Ahli Gizi
        $ahliGiziData = [
            ['name' => 'Dr. Wati Ayuningtyas, SGz', 'email' => 'wati.ayuningtyas@sigapanak.id', 'phone' => '081234567911'],
            ['name' => 'Rizki Amalia, S.Gz', 'email' => 'rizki.amalia@sigapanak.id', 'phone' => '081234567912'],
            ['name' => 'Nisa Khoirunnisa, S.Gz', 'email' => 'nisa.khoirunnisa@sigapanak.id', 'phone' => '081234567913'],
        ];

        $ahliGiziIds = [];
        foreach ($ahliGiziData as $ag) {
            $userId = DB::table('users')->insertGetId([
                'name' => $ag['name'],
                'email' => $ag['email'],
                'phone' => $ag['phone'],
                'password' => Hash::make('password123'),
                'role' => 'ahli_gizi',
                'is_active' => true,
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            DB::table('nakes_profile')->insert([
                'user_id' => $userId,
                'nip' => '19' . rand(100000, 999999) . rand(100, 999),
                'str_number' => 'STR/' . rand(100000, 999999),
                'spesialisasi' => 'Ahli Gizi',
                'verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $ahliGiziIds[] = $userId;
        }

        // Nakes - Kader
        $kaderData = [
            ['name' => 'Hj. Umroh, A.Md', 'email' => 'umroh@sigapanak.id', 'phone' => '081234567921'],
            ['name' => 'Enok Rohayah', 'email' => 'enok.rohayah@sigapanak.id', 'phone' => '081234567922'],
            ['name' => 'Iis Siti Komariah', 'email' => 'iis.komariah@sigapanak.id', 'phone' => '081234567923'],
            ['name' => 'Ela Nuraeni', 'email' => 'ela.nuraeni@sigapanak.id', 'phone' => '081234567924'],
            ['name' => 'Cucu Cucun', 'email' => 'cucu.cucun@sigapanak.id', 'phone' => '081234567925'],
        ];

        $kaderIds = [];
        foreach ($kaderData as $k) {
            $userId = DB::table('users')->insertGetId([
                'name' => $k['name'],
                'email' => $k['email'],
                'phone' => $k['phone'],
                'password' => Hash::make('password123'),
                'role' => 'kader',
                'is_active' => true,
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            DB::table('nakes_profile')->insert([
                'user_id' => $userId,
                'nip' => '19' . rand(100000, 999999) . rand(100, 999),
                'spesialisasi' => 'Kader Posyandu',
                'verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $kaderIds[] = $userId;
        }

        // Orang Tua - Parents
        $namaIbu = [
            'Siti Aisyah', 'Dewi Sartika', 'Rina Susilowati', 'Siti Nurhaliza', 'Nengsih',
            'Yuniarti', 'Siti Rahmawati', 'Nurul Hidayah', 'Rahmah', 'Fitriani',
            'Lina Marlina', 'Siti Khadijah', 'Dewi Lestari', 'Wati', 'Irma Destiani',
            'Neng Titi', 'Yanti', 'Siti Maryam', 'Nurul', 'Rinawati',
        ];

        $namaAyah = [
            'Ahmad Fauzi', 'Budi Santoso', 'Dedi Kurniawan', 'Eko Prasetyo', 'Fajar Nugraha',
            'Galih Pratama', 'Hendi Wijaya', 'Indra Gunawan', 'Joko Susanto', 'Kurnia',
            'Lukman Hakim', 'Muhamad Rizki', 'Nico Fernando', 'Oki Mahendra', 'Putra Pratama',
            'Rendy Satria', 'Sandi Nugroho', 'Toni Hermawan', 'Udin Saputra', 'Vino Akbar',
        ];

        $ortuIds = [];
        
        // Create 30 parents (15 couples)
        for ($i = 0; $i < 30; $i++) {
            $gender = $i < 15 ? 'P' : 'L';
            $name = $i < 15 ? $namaIbu[$i] : $namaAyah[$i - 15];
            
            $userId = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . ($i + 1) . '@email.com',
                'phone' => '08' . rand(100000000, 999999999),
                'password' => Hash::make('password123'),
                'role' => 'orangtua',
                'is_active' => true,
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            DB::table('orangtua_profile')->insert([
                'user_id' => $userId,
                'nik' => '32' . rand(10, 99) . rand(100000, 999999) . rand(1000, 9999),
                'tanggal_lahir' => now()->subYears(rand(22, 45))->format('Y-m-d'),
                'jenis_kelamin' => $gender,
                'alamat' => 'Jl. Rw. Tidak Dikenal No. ' . rand(1, 100),
                'wilayah_id' => rand(19, 28),
                'pekerjaan' => rand(0, 1) ? 'Ibu Rumah Tangga' : 'Karyawan',
                'pendidikan' => ['SMA', 'D3', 'S1', 'S2'][rand(0, 3)],
                'penghasilan' => ['<1jt', '1-3jt', '3-5jt', '5-10jt'][rand(0, 3)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $ortuIds[] = $userId;
        }

        // Save IDs to database for other seeders
        config(['seeders.user_ids' => [
            'superadmin' => $superadminId,
            'dokter' => $dokterIds,
            'bidan' => $bidanIds,
            'ahli_gizi' => $ahliGiziIds,
            'kader' => $kaderIds,
            'ortu' => $ortuIds,
        ]]);
    }
}
