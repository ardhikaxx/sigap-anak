<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FasilitasKesehatan extends Model
{
    use HasFactory;

    protected $table = 'fasilitas_kesehatan';

    protected $fillable = [
        'nama',
        'tipe',
        'wilayah_id',
        'alamat',
        'telepon',
        'email',
        'kepala_id',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function kepala(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kepala_id');
    }

    public function anak(): HasMany
    {
        return $this->hasMany(Anak::class);
    }

    public function jadwalPosyandu(): HasMany
    {
        return $this->hasMany(JadwalPosyandu::class);
    }

    public function nakesProfile(): HasMany
    {
        return $this->hasMany(NakesProfile::class);
    }
}
