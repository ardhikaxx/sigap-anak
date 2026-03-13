<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anak extends Model
{
    use HasFactory;

    protected $table = 'anak';

    protected $fillable = [
        'nama',
        'nik_anak',
        'tanggal_lahir',
        'jenis_kelamin',
        'berat_lahir',
        'panjang_lahir',
        'golongan_darah',
        'foto',
        'nomor_bpjs',
        'nomor_kartu_anak',
        'ibu_id',
        'ayah_id',
        'wali_id',
        'faskes_id',
        'nakes_pj_id',
        'wilayah_id',
        'status',
        'catatan_khusus',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'berat_lahir' => 'decimal:2',
        'panjang_lahir' => 'decimal:2',
    ];

    public function ibu(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ibu_id');
    }

    public function ayah(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ayah_id');
    }

    public function wali(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_id');
    }

    public function faskes(): BelongsTo
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'faskes_id');
    }

    public function nakesPj(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nakes_pj_id');
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function pemeriksaan(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    public function latestPemeriksaan()
    {
        return $this->hasOne(Pemeriksaan::class)->latestOfMany();
    }

    public function riwayatGizi(): HasMany
    {
        return $this->hasMany(RiwayatGizi::class);
    }

    public function konsumsiMakanan(): HasMany
    {
        return $this->hasMany(KonsumsiMakanan::class);
    }

    public function imunisasi(): HasMany
    {
        return $this->hasMany(Imunisasi::class);
    }

    public function riwayatPenyakit(): HasMany
    {
        return $this->hasMany(RiwayatPenyakit::class);
    }

    public function kehadiranPosyandu(): HasMany
    {
        return $this->hasMany(KehadiranPosyandu::class);
    }

    public function konsultasi(): HasMany
    {
        return $this->hasMany(Konsultasi::class);
    }

    public function getLatestPemeriksaan()
    {
        return $this->hasOne(Pemeriksaan::class)->latestOfMany();
    }

    public function getUsiaBulanAttribute(): int
    {
        return now()->diffInMonths($this->tanggal_lahir);
    }
}
