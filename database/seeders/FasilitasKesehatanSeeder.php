<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasKesehatanSeeder extends Seeder
{
    public function run(): void
    {
        $faskesData = [
            // Puskesmas
            ['nama' => 'Puskesmas Ciumbuleuit', 'tipe' => 'puskesmas', 'alamat' => 'Jl. Ciumbuleuit No. 42, Bandung', 'telepon' => '022-2031234', 'email' => 'puskesascb@email.com', 'wilayah_id' => 12],
            ['nama' => 'Puskesmas Sukajadi', 'tipe' => 'puskesmas', 'alamat' => 'Jl. Sukajadi No. 88, Bandung', 'telepon' => '022-2031235', 'email' => 'puskesassuk@email.com', 'wilayah_id' => 10],
            ['nama' => 'Puskesmas Citeureup', 'tipe' => 'puskesmas', 'alamat' => 'Jl. Utama No. 12, Cianjur', 'telepon' => '0263-123456', 'email' => 'puskesasct@email.com', 'wilayah_id' => 16],
            ['nama' => 'Puskesmas Jatinangor', 'tipe' => 'puskesmas', 'alamat' => 'Jl. Jatinangor No. 5, Sumedang', 'telepon' => '0261-123456', 'email' => 'puskesasjt@email.com', 'wilayah_id' => 15],
            
            // Posyandu
            ['nama' => 'Posyandu Mekar Arum 1', 'tipe' => 'posyandu', 'alamat' => 'Jl. Ciumbuleuit Gg. Mekar No. 1', 'telepon' => '022-2031001', 'email' => null, 'wilayah_id' => 19],
            ['nama' => 'Posyandu Mekar Arum 2', 'tipe' => 'posyandu', 'alamat' => 'Jl. Ciumbuleuit Gg. Mekar No. 2', 'telepon' => '022-2031002', 'email' => null, 'wilayah_id' => 19],
            ['nama' => 'Posyandu Sejuk Sejahtera', 'tipe' => 'posyandu', 'alamat' => 'Jl. Ledeng No. 15', 'telepon' => '022-2031003', 'email' => null, 'wilayah_id' => 20],
            ['nama' => 'Posyandu Tunas Jaya', 'tipe' => 'posyandu', 'alamat' => 'Jl. Pasteur No. 22', 'telepon' => '022-2031004', 'email' => null, 'wilayah_id' => 21],
            ['nama' => 'Posyandu Kasih Ibu', 'tipe' => 'posyandu', 'alamat' => 'Jl. Sukasari No. 8', 'telepon' => '022-2031005', 'email' => null, 'wilayah_id' => 21],
            ['nama' => 'Posyandu Harmoni', 'tipe' => 'posyandu', 'alamat' => 'Jl. Cicadas No. 10', 'telepon' => '022-2031006', 'email' => null, 'wilayah_id' => 22],
            ['nama' => 'Posyandu Murni', 'tipe' => 'posyandu', 'alamat' => 'Jl. Citeureup No. 5, Cianjur', 'telepon' => '0263-123001', 'email' => null, 'wilayah_id' => 16],
            ['nama' => 'Posyandu Bersama', 'tipe' => 'posyandu', 'alamat' => 'Jl. Jatinangor No. 20, Sumedang', 'telepon' => '0261-123001', 'email' => null, 'wilayah_id' => 15],
            ['nama' => 'Posyandu Wijaya Kusuma', 'tipe' => 'posyandu', 'alamat' => 'Jl. Dayeuhkolot No. 30', 'telepon' => '022-2031007', 'email' => null, 'wilayah_id' => 12],
            ['nama' => 'Posyandu Sumber Rejeki', 'tipe' => 'posyandu', 'alamat' => 'Jl. Sukataris No. 12, Cianjur', 'telepon' => '0263-123002', 'email' => null, 'wilayah_id' => 17],
            ['nama' => 'Posyandu Permata', 'tipe' => 'posyandu', 'alamat' => 'Jl. Cibeunying No. 5', 'telepon' => '022-2031008', 'email' => null, 'wilayah_id' => 11],
            
            // Klinik
            ['nama' => 'Klinik Pratama Bandung', 'tipe' => 'klinik', 'alamat' => 'Jl. Asia Afrika No. 50, Bandung', 'telepon' => '022-4211234', 'email' => 'klinikbp@email.com', 'wilayah_id' => 8],
            ['nama' => 'Klinik Utama Gizi Sehat', 'tipe' => 'klinik', 'alamat' => 'Jl. Dago No. 78, Bandung', 'telepon' => '022-4211235', 'email' => 'klinikgs@email.com', 'wilayah_id' => 9],
        ];

        $faskesIds = [];
        foreach ($faskesData as $f) {
            $faskesIds[] = DB::table('fasilitas_kesehatan')->insertGetId([
                'nama' => $f['nama'],
                'tipe' => $f['tipe'],
                'wilayah_id' => $f['wilayah_id'],
                'alamat' => $f['alamat'],
                'telepon' => $f['telepon'],
                'email' => $f['email'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        config(['seeders.faskes_ids' => $faskesIds]);
    }
}
