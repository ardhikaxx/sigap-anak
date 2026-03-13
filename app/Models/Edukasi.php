<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Edukasi extends Model
{
    use HasFactory;

    protected $table = 'edukasi';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'ringkasan',
        'gambar',
        'kategori',
        'tag',
        'penulis_id',
        'target_usia',
        'is_published',
        'views',
    ];

    protected $casts = [
        'tag' => 'array',
        'is_published' => 'boolean',
    ];

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}
