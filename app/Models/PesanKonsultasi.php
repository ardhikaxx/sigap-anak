<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesanKonsultasi extends Model
{
    use HasFactory;

    protected $table = 'pesan_konsultasi';

    protected $fillable = [
        'konsultasi_id',
        'pengirim_id',
        'pesan',
        'tipe',
        'file_path',
        'dibaca',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
    ];

    public function konsultasi(): BelongsTo
    {
        return $this->belongsTo(Konsultasi::class);
    }

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }
}
