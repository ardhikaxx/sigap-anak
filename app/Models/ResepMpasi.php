<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResepMpasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_resep',
        'deskripsi',
        'gambar',
        'usia_minimal',
        'usia_maksimal',
        'tingkat_alergen',
        'bahan',
        'langkah',
        'nilai_gizi',
        'waktu_memasak',
        'porsi',
        'penulis_id',
        'is_published',
        'likes',
    ];

    protected $casts = [
        'bahan' => 'array',
        'langkah' => 'array',
        'nilai_gizi' => 'array',
        'is_published' => 'boolean',
    ];

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}
