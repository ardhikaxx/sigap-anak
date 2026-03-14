<?php

namespace Database\Seeders;

use App\Models\Pemeriksaan;
use App\Models\Anak;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PemeriksaanSeeder extends Seeder
{
    public function run(): void
    {
        $anaks = Anak::all();
        $nakesList = User::whereIn('role', ['dokter', 'bidan', 'ahli_gizi', 'kader'])->get();

        foreach ($anaks as $anak) {
            $tglLahir = Carbon::parse($anak->tanggal_lahir);
            $usiaBulanSekarang = $tglLahir->diffInMonths(now());
            
            for ($i = 1; $i <= $usiaBulanSekarang; $i++) {
                $tglPeriksa = $tglLahir->copy()->addMonths($i);
                if ($tglPeriksa->isAfter(now())) break;

                $bb = $anak->berat_lahir + ($i * 0.5) + (rand(-2, 2) / 10);
                $tb = $anak->panjang_lahir + ($i * 1.5) + (rand(-5, 5) / 10);
                
                $statusGizi = ['normal', 'normal', 'normal', 'stunting', 'underweight', 'wasting', 'normal'][rand(0, 6)];

                Pemeriksaan::create([
                    'anak_id' => $anak->id,
                    'nakes_id' => $nakesList->random()->id,
                    'tanggal_periksa' => $tglPeriksa,
                    'umur_bulan' => $i,
                    'berat_badan' => $bb,
                    'tinggi_badan' => $tb,
                    'lingkar_kepala' => 34 + ($i * 0.3),
                    'lingkar_lengan' => 10 + ($i * 0.2),
                    'suhu_tubuh' => 36.5 + (rand(-5, 5) / 10),
                    'status_gizi_akhir' => $statusGizi,
                    'status_bb_u' => ($statusGizi == 'underweight' ? 'gizi_kurang' : 'gizi_baik'),
                    'status_tb_u' => ($statusGizi == 'stunting' ? 'pendek' : 'normal'),
                    'catatan' => "Pemeriksaan rutin bulan ke-$i",
                    'diberikan_vit_a' => $i % 6 == 0,
                    'diberikan_pmt' => $statusGizi != 'normal',
                ]);
            }
        }
    }
}
