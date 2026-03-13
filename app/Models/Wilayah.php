<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Wilayah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tipe',
        'parent_id',
        'kode_pos',
    ];

    protected $casts = [
        'parent_id' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Wilayah::class, 'parent_id');
    }

    public function fasilitasKesehatan(): HasMany
    {
        return $this->hasMany(FasilitasKesehatan::class);
    }

    public function anak(): HasMany
    {
        return $this->hasMany(Anak::class);
    }
}
