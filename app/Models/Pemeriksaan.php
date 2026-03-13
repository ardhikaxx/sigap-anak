<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan';

    protected $fillable = [
        'anak_id',
        'nakes_id',
        'posyandu_id',
        'tanggal_periksa',
        'umur_bulan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lingkar_lengan',
        'lingkar_perut',
        'lingkar_dada',
        'bb_u_zscore',
        'tb_u_zscore',
        'bb_tb_zscore',
        'imt_u_zscore',
        'status_bb_u',
        'status_tb_u',
        'status_bb_tb',
        'status_gizi_akhir',
        'suhu_tubuh',
        'tekanan_darah',
        'kondisi_umum',
        'edema',
        'diberikan_vit_a',
        'diberikan_fe',
        'diberikan_zinc',
        'diberikan_pmt',
        'dirujuk',
        'tujuan_rujukan',
        'alasan_rujukan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_periksa' => 'date',
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
        'lingkar_kepala' => 'decimal:2',
        'lingkar_lengan' => 'decimal:2',
        'lingkar_perut' => 'decimal:2',
        'lingkar_dada' => 'decimal:2',
        'bb_u_zscore' => 'decimal:3',
        'tb_u_zscore' => 'decimal:3',
        'bb_tb_zscore' => 'decimal:3',
        'imt_u_zscore' => 'decimal:3',
        'suhu_tubuh' => 'decimal:1',
        'edema' => 'boolean',
        'diberikan_vit_a' => 'boolean',
        'diberikan_fe' => 'boolean',
        'diberikan_zinc' => 'boolean',
        'diberikan_pmt' => 'boolean',
        'dirujuk' => 'boolean',
    ];

    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class);
    }

    public function nakes(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }

    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'posyandu_id');
    }

    public function riwayatGizi()
    {
        return $this->hasOne(RiwayatGizi::class);
    }
}
