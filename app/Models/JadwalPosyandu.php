<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalPosyandu extends Model
{
    use HasFactory;

    protected $fillable = [
        'faskes_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'tema',
        'lokasi',
        'keterangan',
        'nakes_pj_id',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'time',
        'jam_selesai' => 'time',
    ];

    public function faskes(): BelongsTo
    {
        return $this->belongsTo(FasilitasKesehatan::class);
    }

    public function nakesPj(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nakes_pj_id');
    }

    public function kehadiran(): HasMany
    {
        return $this->hasMany(KehadiranPosyandu::class);
    }
}
