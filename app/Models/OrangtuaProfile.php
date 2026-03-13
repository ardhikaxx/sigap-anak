<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrangtuaProfile extends Model
{
    use HasFactory;

    protected $table = 'orangtua_profile';

    protected $fillable = [
        'user_id',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'wilayah_id',
        'pekerjaan',
        'pendidikan',
        'penghasilan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }
}
