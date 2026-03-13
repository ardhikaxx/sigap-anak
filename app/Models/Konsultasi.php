<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Konsultasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'anak_id',
        'orangtua_id',
        'nakes_id',
        'tipe',
        'topik',
        'status',
        'jadwal',
        'durasi_menit',
        'rating',
        'ulasan',
        'selesai_at',
    ];

    protected $casts = [
        'jadwal' => 'datetime',
        'selesai_at' => 'datetime',
    ];

    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class);
    }

    public function orangtua(): BelongsTo
    {
        return $this->belongsTo(User::class, 'orangtua_id');
    }

    public function nakes(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }

    public function pesan(): HasMany
    {
        return $this->hasMany(PesanKonsultasi::class);
    }
}
