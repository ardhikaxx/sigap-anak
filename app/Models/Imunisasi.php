<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imunisasi extends Model
{
    use HasFactory;

    protected $table = 'imunisasi';

    protected $fillable = [
        'anak_id',
        'jenis_vaksin',
        'dosis',
        'tanggal',
        'umur_saat_ini',
        'nakes_id',
        'faskes_id',
        'nomor_batch',
        'reaksi',
        'next_schedule',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'next_schedule' => 'date',
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
