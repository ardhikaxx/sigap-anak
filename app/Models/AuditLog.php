<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'aksi',
        'tabel',
        'record_id',
        'data_lama',
        'data_baru',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function log($userId, $aksi, $tabel = null, $recordId = null, $dataLama = null, $dataBaru = null)
    {
        return self::create([
            'user_id' => $userId,
            'aksi' => $aksi,
            'tabel' => $tabel,
            'record_id' => $recordId,
            'data_lama' => $dataLama,
            'data_baru' => $dataBaru,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
