<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\OrangtuaProfile;
use App\Models\NakesProfile;
use App\Models\FasilitasKesehatan;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Superadmin
        User::create([
            'name' => 'Superadmin SIGAP',
            'email' => 'admin@sigap.id',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'phone' => '081122334455',
        ]);

        $faskesList = FasilitasKesehatan::all();
        $wilayahList = Wilayah::all();

        // 2. Nakes - Tingkatkan menjadi 40 Petugas
        $roles = ['dokter', 'bidan', 'ahli_gizi', 'kader'];
        foreach (range(1, 40) as $i) {
            $role = $roles[array_rand($roles)];
            $nakes = User::create([
                'name' => "Petugas " . ucfirst($role) . " $i",
                'email' => "$role$i@sigap.id",
                'password' => Hash::make('password'),
                'role' => $role,
                'phone' => '0852' . rand(10000000, 99999999),
            ]);

            NakesProfile::create([
                'user_id' => $nakes->id,
                'faskes_id' => $faskesList->random()->id,
                'nip' => '19900101' . rand(100000, 999999),
                'spesialisasi' => $role == 'dokter' ? 'Spesialis Anak' : ($role == 'ahli_gizi' ? 'Nutrisi Anak' : 'Umum'),
            ]);
        }

        // 3. Orang Tua - Tingkatkan secara masif menjadi 200 Orang Tua
        foreach (range(1, 200) as $i) {
            $ot = User::create([
                'name' => "Orang Tua User $i",
                'email' => "ortu$i@gmail.com",
                'password' => Hash::make('password'),
                'role' => 'orangtua',
                'phone' => '0812' . rand(10000000, 99999999),
            ]);

            OrangtuaProfile::create([
                'user_id' => $ot->id,
                'wilayah_id' => $wilayahList->random()->id,
                'nik' => '3515' . rand(100000000000, 999999999999),
                'alamat' => "Jl. Pemantauan No. $i, Wilayah " . $wilayahList->random()->nama,
            ]);
        }
    }
}
