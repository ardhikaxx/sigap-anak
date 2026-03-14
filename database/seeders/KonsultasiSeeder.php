<?php

namespace Database\Seeders;

use App\Models\Konsultasi;
use App\Models\PesanKonsultasi;
use App\Models\Anak;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KonsultasiSeeder extends Seeder
{
    public function run(): void
    {
        $orangtuas = User::where('role', 'orangtua')->get();
        $nakesList = User::whereIn('role', ['dokter', 'bidan', 'ahli_gizi'])->get();
        
        if ($orangtuas->isEmpty() || $nakesList->isEmpty()) return;

        $topiks = [
            'Anak susah makan sayur', 'Demam setelah imunisasi', 'Berat badan tidak naik',
            'MPASI hari pertama', 'Alergi makanan laut', 'Batuk berdahak pada bayi',
            'Stimulasi jalan', 'Gigi pertama tumbuh', 'Pola tidur tidak teratur',
            'Tinggi badan ideal', 'Diare pada balita', 'Vitamin nafsu makan',
            'Konsultasi ASI Eksklusif', 'Ruam popok', 'Sembelit pada anak'
        ];

        $pesanTemplates = [
            'Dok, anak saya rewel terus setelah makan, kenapa ya?',
            'Sudah diberikan obat apa sebelumnya Bu?',
            'Belum ada Dok, baru saya kompres air hangat.',
            'Bagus, lanjutkan kompresnya dan pastikan anak cukup minum.',
            'Terima kasih responnya Dok, sangat membantu.',
            'Kira-kira apa menu yang bagus untuk anak usia 8 bulan?',
            'Bisa dicoba bubur saring dengan campuran hati ayam dan bayam.',
            'Anak saya beratnya turun sedikit minggu ini, apakah bahaya?',
            'Mari kita lihat grafiknya di aplikasi, jika masih di area hijau berarti aman.'
        ];

        foreach ($orangtuas as $ot) {
            $anaks = Anak::where('ibu_id', $ot->id)->get();
            if ($anaks->isEmpty()) continue;

            // Tingkatkan: Buat 3-6 konsultasi per orang tua
            $numConsultations = rand(3, 6);
            for ($i = 0; $i < $numConsultations; $i++) {
                $anak = $anaks->random();
                $nakes = $nakesList->random();
                $status = ['menunggu', 'aktif', 'selesai'][rand(0, 2)];
                $createdAt = Carbon::now()->subDays(rand(1, 120));

                $konsultasi = Konsultasi::create([
                    'anak_id' => $anak->id,
                    'orangtua_id' => $ot->id,
                    'nakes_id' => $nakes->id,
                    'tipe' => rand(0, 1) ? 'chat' : 'video_call',
                    'topik' => $topiks[array_rand($topiks)],
                    'status' => $status,
                    'jadwal' => $createdAt,
                    'durasi_menit' => $status == 'selesai' ? rand(10, 30) : null,
                    'rating' => $status == 'selesai' ? rand(3, 5) : null,
                    'ulasan' => $status == 'selesai' ? 'Sangat memuaskan.' : null,
                    'selesai_at' => $status == 'selesai' ? $createdAt->copy()->addMinutes(20) : null,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // Buat pesan yang lebih banyak (5-12 pesan)
                $numMessages = rand(5, 12);
                for ($j = 0; $j < $numMessages; $j++) {
                    $isNakes = $j % 2 != 0;
                    PesanKonsultasi::create([
                        'konsultasi_id' => $konsultasi->id,
                        'pengirim_id' => $isNakes ? $nakes->id : $ot->id,
                        'pesan' => $pesanTemplates[array_rand($pesanTemplates)],
                        'tipe' => 'text',
                        'dibaca' => true,
                        'created_at' => $createdAt->copy()->addMinutes($j * 10),
                    ]);
                }
            }
        }
    }
}
