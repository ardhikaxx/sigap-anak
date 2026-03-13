<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EdukasiSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = config('seeders.user_ids.superadmin', 1);

        $artikel = [
            [
                'judul' => 'Pentingnya ASI Eksklusif untuk Bayi',
                'kategori' => 'nutrisi',
                'konten' => 'ASI eksklusif adalah pemberian ASI saja tanpa makanan atau minuman lain selama 6 bulan pertama. Hal ini sangat penting untuk tumbuh kembang bayi karena ASI mengandung semua nutrisi yang dibutuhkan bayi.',
                'ringkasan' => 'Kenali pentingnya ASI eksklusif untuk bayi Anda.',
                'tag' => json_encode(['asi', 'menyusui', 'nutrisi', 'bayi']),
                'target_usia' => '0-6 bulan',
            ],
            [
                'judul' => 'MPASI yang Tepat untuk Bayi 6-12 Bulan',
                'kategori' => 'resep_mpasi',
                'konten' => 'Pada usia 6 bulan, bayi mulai diperkenalkan makanan pendamping ASI (MPASI). Pilih食材 yang kaya nutrisi dan sesuai dengan kemampuan makan bayi.',
                'ringkasan' => 'Panduan MPASI tepat untuk bayi 6-12 bulan.',
                'tag' => json_encode(['mpasi', 'nutrisi', 'bayi', 'makanan']),
                'target_usia' => '6-12 bulan',
            ],
            [
                'judul' => 'Mencegah Stunting pada Anak',
                'kategori' => 'nutrisi',
                'konten' => 'Stunting adalah kondisi gagal tumbuh pada anak akibat kurang gizi kronis. Pencegahan stunting dimulai dari masa kehamilan hingga usia 2 tahun.',
                'ringkasan' => 'Cara mencegah stunting pada anak.',
                'tag' => json_encode(['stunting', 'gizi', 'pertumbuhan', 'anak']),
                'target_usia' => '0-5 tahun',
            ],
            [
                'judul' => 'Jadwal Imunisasi Lengkap untuk Anak',
                'kategori' => 'imunisasi',
                'konten' => 'Imunisasi penting untuk melindungi anak dari berbagai penyakit berbahaya. Berikut jadwal imunisasi lengkap yang perlu diberikan.',
                'ringkasan' => 'Jadwal imunisasi lengkap yang perlu diketahui orang tua.',
                'tag' => json_encode(['imunisasi', 'vaksin', 'kesehatan', 'pencegahan']),
                'target_usia' => '0-18 bulan',
            ],
            [
                'judul' => 'Stimulasi yang Tepat untuk Tumbuh Kembang Anak',
                'kategori' => 'stimulasi',
                'konten' => 'Stimulasi yang tepat sangat penting untuk mendukung tumbuh kembang anak. Orang tua perlu memberikan stimulasi sesuai usia dan tahapan perkembangan anak.',
                'ringkasan' => 'Stimulasi yang tepat untuk tumbuh kembang optimal.',
                'tag' => json_encode(['stimulasi', 'tumbuh kembang', 'otak', 'belajar']),
                'target_usia' => '0-5 tahun',
            ],
            [
                'judul' => 'Tips Menaikkan Berat Badan Anak',
                'kategori' => 'nutrisi',
                'konten' => 'Jika anak mengalami penurunan berat badan atau tidak sesuai standar, orang tua perlu memperhatikan pola makan dan memberikan makanan bergizi.',
                'ringkasan' => 'Tips membantu anak mencapai berat badan ideal.',
                'tag' => json_encode(['berat badan', 'nutrisi', 'gizi', 'anak']),
                'target_usia' => '1-5 tahun',
            ],
            [
                'judul' => 'Mengenal Tanda-Tanda Alergi Makanan pada Bayi',
                'kategori' => 'penyakit',
                'konten' => 'Alergi makanan bisa terjadi pada bayi. Kenali tanda-tandanya seperti ruam, muntah, atau diare setelah makan makanan tertentu.',
                'ringkasan' => 'Kenali tanda-tanda alergi makanan pada bayi.',
                'tag' => json_encode(['alergi', 'makanan', 'bayi', 'kesehatan']),
                'target_usia' => '0-2 tahun',
            ],
            [
                'judul' => 'Resep MPASI: Bubur Ayam Keju',
                'kategori' => 'resep_mpasi',
                'konten' => 'Bubur ayam keju adalah MPASI lezat dan bergizi untuk bayi usia 8 bulan ke atas. Bahan-bahan mudah ditemukan dan cara membuatnya sederhana.',
                'ringkasan' => 'Resep MPASI bubur ayam keju yang lezat.',
                'tag' => json_encode(['resep', 'mpasi', 'bubur', 'ayam']),
                'target_usia' => '8-12 bulan',
            ],
            [
                'judul' => 'Pola Makan Seimbang untuk Anak',
                'kategori' => 'pola_makan',
                'konten' => 'Pola makan seimbang sangat penting untuk tumbuh kembang anak. Pastikan anak mendapat variasi食材 dari semua kelompok makanan.',
                'ringkasan' => 'Panduan pola makan seimbang untuk anak.',
                'tag' => json_encode(['pola makan', 'gizi', 'seimbang', 'anak']),
                'target_usia' => '1-5 tahun',
            ],
            [
                'judul' => 'Tips Parenting untuk Orang Tua Baru',
                'kategori' => 'tips_parenting',
                'konten' => 'Menjadi orang tua baru tentu memiliki tantangan tersendiri. Berikut beberapa tips untuk membantu Anda melewati masa-masa awal parenthood.',
                'ringkasan' => 'Tips berguna untuk orang tua baru.',
                'tag' => json_encode(['parenting', 'orang tua', 'tips', 'keluarga']),
                'target_usia' => 'semua usia',
            ],
        ];

        foreach ($artikel as $a) {
            DB::table('edukasi')->insert([
                'judul' => $a['judul'],
                'slug' => \Illuminate\Support\Str::slug($a['judul']),
                'konten' => $a['konten'],
                'ringkasan' => $a['ringkasan'],
                'kategori' => $a['kategori'],
                'tag' => $a['tag'],
                'penulis_id' => $adminId,
                'target_usia' => $a['target_usia'],
                'is_published' => true,
                'views' => rand(50, 500),
                'created_at' => now()->subDays(rand(1, 90)),
                'updated_at' => now(),
            ]);
        }

        // Add Resep MPASI
        $resep = [
            [
                'nama_resep' => 'Bubur Ayam Keju',
                'deskripsi' => 'MPASI tinggi protein dan kalsium untuk bayi 8+ bulan',
                'tingkat_alergen' => 'sedang',
                'bahan' => json_encode(['50g daging ayam', '30g nasi', '10g keju', '100ml air']),
                'langkah' => json_encode(['Rebus ayam hingga matang', 'Tambahkan nasi dan air', 'Masak hingga lembut', 'Tambahkan keju parut', 'Sajikan hangat']),
                'nilai_gizi' => json_encode(['kalori' => 150, 'protein' => 12, 'karbohidrat' => 15]),
                'usia_minimal' => 8,
                'usia_maksimal' => 24,
                'waktu_memasak' => 30,
                'porsi' => 1,
            ],
            [
                'nama_resep' => 'Pisang Tepung Bearn',
                'deskripsi' => 'Snack sehat tinggi kalori untuk bayi 6+ bulan',
                'tingkat_alergen' => 'rendah',
                'bahan' => json_encode(['1 buah pisang matang', '2 sdm tepung bearn', '50ml asi/susu formula']),
                'langkah' => json_encode(['Haluskanpisang', 'Campur dengantepung', 'Tambahkan asi', 'Kukus 10 menit', 'Sajikan']),
                'nilai_gizi' => json_encode(['kalori' => 100, 'protein' => 2, 'karbohidrat' => 20]),
                'usia_minimal' => 6,
                'usia_maksimal' => 12,
                'waktu_memasak' => 15,
                'porsi' => 1,
            ],
            [
                'nama_resep' => 'Puree Wortel Kentang',
                'deskripsi' => 'Puree sayuran tinggi vitamin A',
                'tingkat_alergen' => 'rendah',
                'bahan' => json_encode(['50g wortel', '50g kentang', '100ml air']),
                'langkah' => json_encode(['Kupas dan potong wortel kentang', 'Kukus hingga lembut', 'Haluskan dengan sedikit air', 'Sajikan']),
                'nilai_gizi' => json_encode(['kalori' => 80, 'protein' => 2, 'karbohidrat' => 18]),
                'usia_minimal' => 6,
                'usia_maksimal' => 24,
                'waktu_memasak' => 25,
                'porsi' => 1,
            ],
        ];

        foreach ($resep as $r) {
            DB::table('resep_mpasi')->insert([
                'nama_resep' => $r['nama_resep'],
                'deskripsi' => $r['deskripsi'],
                'tingkat_alergen' => $r['tingkat_alergen'],
                'bahan' => $r['bahan'],
                'langkah' => $r['langkah'],
                'nilai_gizi' => $r['nilai_gizi'],
                'usia_minimal' => $r['usia_minimal'],
                'usia_maksimal' => $r['usia_maksimal'],
                'waktu_memasak' => $r['waktu_memasak'],
                'porsi' => $r['porsi'],
                'penulis_id' => $adminId,
                'is_published' => true,
                'likes' => rand(10, 100),
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now(),
            ]);
        }
    }
}
