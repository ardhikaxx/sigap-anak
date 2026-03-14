<?php

namespace Database\Seeders;

use App\Models\Anak;
use App\Models\User;
use App\Models\FasilitasKesehatan;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AnakSeeder extends Seeder
{
    public function run(): void
    {
        $orangtuas = User::where('role', 'orangtua')->get();
        $faskesList = FasilitasKesehatan::all();
        $wilayahList = Wilayah::all();

        $namaAnakLaki = ['Budi', 'Andi', 'Catur', 'Dedi', 'Eko', 'Fajar', 'Guntur', 'Hendra', 'Irfan', 'Joko'];
        $namaAnakPerempuan = ['Ani', 'Bunga', 'Citra', 'Dewi', 'Endah', 'Fitri', 'Gita', 'Hani', 'Indah', 'Jelita'];

        foreach ($orangtuas as $ot) {
            $numAnak = rand(1, 3);
            for ($i = 0; $i < $numAnak; $i++) {
                $jk = rand(0, 1) ? 'L' : 'P';
                $nama = ($jk == 'L' ? $namaAnakLaki[array_rand($namaAnakLaki)] : $namaAnakPerempuan[array_rand($namaAnakPerempuan)]) . " " . rand(10, 99);
                
                Anak::create([
                    'ibu_id' => $ot->id, // Menggunakan ibu_id sebagai perwakilan orang tua
                    'faskes_id' => $faskesList->random()->id,
                    'wilayah_id' => $ot->orangtuaProfile->wilayah_id ?? $wilayahList->random()->id,
                    'nama' => $nama,
                    'nik_anak' => '3515' . rand(100000000000, 999999999999),
                    'jenis_kelamin' => $jk,
                    'tanggal_lahir' => Carbon::now()->subMonths(rand(1, 59)),
                    'berat_lahir' => rand(25, 40) / 10,
                    'panjang_lahir' => rand(45, 52),
                    'golongan_darah' => ['A', 'B', 'AB', 'O'][rand(0, 3)],
                    'status' => 'aktif',
                ]);
            }
        }
    }
}
