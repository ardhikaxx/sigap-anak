<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KehadiranPosyandu extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_id',
        'anak_id',
        'hadir',
        'keterangan',
    ];

    protected $casts = [
        'hadir' => 'boolean',
    ];

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalPosyandu::class);
    }

    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class);
    }
}
