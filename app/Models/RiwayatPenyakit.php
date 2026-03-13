<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPenyakit extends Model
{
    use HasFactory;

    protected $table = 'riwayat_penyakit';

    protected $fillable = [
        'anak_id',
        'nama_penyakit',
        'kode_icd',
        'tanggal_mulai',
        'tanggal_selesai',
        'gejala',
        'pengobatan',
        'nakes_id',
        'faskes_id',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class);
    }

    public function nakes(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }

    public function faskes(): BelongsTo
    {
        return $this->belongsTo(FasilitasKesehatan::class);
    }
}
