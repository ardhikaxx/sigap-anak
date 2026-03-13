<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NakesProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'str_number',
        'spesialisasi',
        'faskes_id',
        'wilayah_id',
        'jadwal_praktek',
        'foto_ktp',
        'verified_at',
    ];

    protected $casts = [
        'jadwal_praktek' => 'array',
        'verified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function faskes(): BelongsTo
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'faskes_id');
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }
}
