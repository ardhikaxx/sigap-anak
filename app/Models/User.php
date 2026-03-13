<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'avatar',
        'is_active',
        'email_verified',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'is_active' => 'boolean',
        'email_verified' => 'boolean',
    ];

    public function isNakes()
    {
        return in_array($this->role, ['superadmin', 'dokter', 'bidan', 'ahli_gizi', 'kader']);
    }

    public function isOrangTua()
    {
        return $this->role === 'orangtua';
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function nakesProfile()
    {
        return $this->hasOne(NakesProfile::class);
    }

    public function orangtuaProfile()
    {
        return $this->hasOne(OrangtuaProfile::class);
    }

    public function anakAsIbu()
    {
        return $this->hasMany(Anak::class, 'ibu_id');
    }

    public function anakAsAyah()
    {
        return $this->hasMany(Anak::class, 'ayah_id');
    }

    public function anakAsWali()
    {
        return $this->hasMany(Anak::class, 'wali_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'nakes_id');
    }

    public function konsultasiAsOrangTua()
    {
        return $this->hasMany(Konsultasi::class, 'orangtua_id');
    }

    public function konsultasiAsNakes()
    {
        return $this->hasMany(Konsultasi::class, 'nakes_id');
    }
}
