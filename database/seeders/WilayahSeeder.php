<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Provinsi
            ['nama' => 'Jawa Barat', 'tipe' => 'provinsi', 'parent_id' => null, 'kode_pos' => null],
            
            // Kabupaten/Kota
            ['nama' => 'Kabupaten Bandung', 'tipe' => 'kabupaten', 'parent_id' => 1, 'kode_pos' => null],
            ['nama' => 'Kabupaten Bandung Barat', 'tipe' => 'kabupaten', 'parent_id' => 1, 'kode_pos' => null],
            ['nama' => 'Kota Bandung', 'tipe' => 'kabupaten', 'parent_id' => 1, 'kode_pos' => null],
            ['nama' => 'Kabupaten Cianjur', 'tipe' => 'kabupaten', 'parent_id' => 1, 'kode_pos' => null],
            ['nama' => 'Kabupaten Sumedang', 'tipe' => 'kabupaten', 'parent_id' => 1, 'kode_pos' => null],
            
            // Kecamatan
            ['nama' => 'Cimenyan', 'tipe' => 'kecamatan', 'parent_id' => 3, 'kode_pos' => '40191'],
            ['nama' => 'Cibeunying Kidul', 'tipe' => 'kecamatan', 'parent_id' => 3, 'kode_pos' => '40121'],
            ['nama' => 'Cibeunying Kaler', 'tipe' => 'kecamatan', 'parent_id' => 3, 'kode_pos' => '40122'],
            ['nama' => 'Sukajadi', 'tipe' => 'kecamatan', 'parent_id' => 3, 'kode_pos' => '40161'],
            ['nama' => 'Cicadas', 'tipe' => 'kecamatan', 'parent_id' => 3, 'kode_pos' => '40121'],
            ['nama' => 'Ciumbuleuit', 'tipe' => 'kecamatan', 'parent_id' => 2, 'kode_pos' => '40142'],
            ['nama' => 'Dayeuhkolot', 'tipe' => 'kecamatan', 'parent_id' => 2, 'kode_pos' => '40256'],
            ['nama' => 'Pacet', 'tipe' => 'kecamatan', 'parent_id' => 5, 'kode_pos' => '43292'],
            ['nama' => 'Cianjur', 'tipe' => 'kecamatan', 'parent_id' => 5, 'kode_pos' => '43211'],
            ['nama' => 'Jatinangor', 'tipe' => 'kecamatan', 'parent_id' => 6, 'kode_pos' => '45363'],
            
            // Kelurahan
            ['nama' => 'Ciumbuleuit', 'tipe' => 'kelurahan', 'parent_id' => 8, 'kode_pos' => '40142'],
            ['nama' => 'Ledeng', 'tipe' => 'kelurahan', 'parent_id' => 8, 'kode_pos' => '40143'],
            ['nama' => 'Sukasari', 'tipe' => 'kelurahan', 'parent_id' => 10, 'kode_pos' => '40161'],
            ['nama' => 'Pasteur', 'tipe' => 'kelurahan', 'parent_id' => 10, 'kode_pos' => '40161'],
            ['nama' => 'Cicadas', 'tipe' => 'kelurahan', 'parent_id' => 11, 'kode_pos' => '40121'],
            ['nama' => 'Cigel', 'tipe' => 'kelurahan', 'parent_id' => 12, 'kode_pos' => '40191'],
            ['nama' => ' Mekarjaya', 'tipe' => 'kelurahan', 'parent_id' => 12, 'kode_pos' => '40191'],
            ['nama' => 'Sukamenak', 'tipe' => 'kelurahan', 'parent_id' => 15, 'kode_pos' => '40256'],
            ['nama' => 'Citeureup', 'tipe' => 'kelurahan', 'parent_id' => 16, 'kode_pos' => '43292'],
            ['nama' => 'Sukataris', 'tipe' => 'kelurahan', 'parent_id' => 17, 'kode_pos' => '43211'],
            
            // RW/RT
            ['nama' => 'RW 01', 'tipe' => 'rw', 'parent_id' => 19, 'kode_pos' => '40142'],
            ['nama' => 'RW 02', 'tipe' => 'rw', 'parent_id' => 19, 'kode_pos' => '40142'],
            ['nama' => 'RW 03', 'tipe' => 'rw', 'parent_id' => 20, 'kode_pos' => '40143'],
            ['nama' => 'RW 04', 'tipe' => 'rw', 'parent_id' => 21, 'kode_pos' => '40161'],
            ['nama' => 'RW 05', 'tipe' => 'rw', 'parent_id' => 22, 'kode_pos' => '40161'],
        ];

        DB::table('wilayah')->insert($data);
    }
}
