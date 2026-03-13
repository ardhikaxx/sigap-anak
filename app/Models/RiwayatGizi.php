<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatGizi extends Model
{
    use HasFactory;

    protected $table = 'riwayat_gizi';

    protected $fillable = [
        'anak_id',
        'pemeriksaan_id',
        'nakes_id',
        'diagnosis_gizi',
        'kode_icd',
        'intervensi',
        'rekomendasi',
        'target_bb',
        'target_tb',
        'follow_up_date',
        'status_kasus',
    ];

    protected $casts = [
        'target_bb' => 'decimal:2',
        'target_tb' => 'decimal:2',
        'follow_up_date' => 'date',
    ];

    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class);
    }

    public function pemeriksaan(): BelongsTo
    {
        return $this->belongsTo(Pemeriksaan::class);
    }

    public function nakes(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }
}
