<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KonsumsiMakanan extends Model
{
    use HasFactory;

    protected $table = 'konsumsi_makanan';

    protected $fillable = [
        'anak_id',
        'tanggal',
        'waktu_makan',
        'nama_makanan',
        'porsi',
        'satuan',
        'kalori',
        'protein',
        'lemak',
        'karbohidrat',
        'serat',
        'vitamin_a',
        'vitamin_c',
        'kalsium',
        'zat_besi',
        'zinc',
        'inputter_role',
        'inputter_id',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'porsi' => 'decimal:2',
        'kalori' => 'decimal:2',
        'protein' => 'decimal:2',
        'lemak' => 'decimal:2',
        'karbohidrat' => 'decimal:2',
        'serat' => 'decimal:2',
        'vitamin_a' => 'decimal:4',
        'vitamin_c' => 'decimal:4',
        'kalsium' => 'decimal:2',
        'zat_besi' => 'decimal:4',
        'zinc' => 'decimal:4',
    ];

    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class);
    }

    public function inputter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inputter_id');
    }
}
