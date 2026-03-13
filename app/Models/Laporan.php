<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'judul',
        'tipe',
        'periode_mulai',
        'periode_selesai',
        'faskes_id',
        'wilayah_id',
        'pembuat_id',
        'data_laporan',
        'file_path',
        'status',
    ];

    protected $casts = [
        'periode_mulai' => 'date',
        'periode_selesai' => 'date',
        'data_laporan' => 'array',
    ];

    public function faskes(): BelongsTo
    {
        return $this->belongsTo(FasilitasKesehatan::class);
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembuat_id');
    }
}
