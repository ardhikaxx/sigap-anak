<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarWho extends Model
{
    use HasFactory;

    protected $table = 'standar_who';

    protected $fillable = [
        'jenis_kelamin',
        'umur_bulan',
        'indikator',
        'sd_minus3',
        'sd_minus2',
        'sd_minus1',
        'median',
        'sd_plus1',
        'sd_plus2',
        'sd_plus3',
    ];

    public static function getZScore($jenisKelamin, $umurBulan, $indikator, $measurement)
    {
        $standar = self::where('jenis_kelamin', $jenisKelamin)
            ->where('umur_bulan', $umurBulan)
            ->where('indikator', $indikator)
            ->first();

        if (!$standar) {
            return null;
        }

        if ($standar->sd_minus2 == $standar->median || $standar->median == $standar->sd_plus2) {
            return null;
        }

        $sd = ($standar->sd_plus2 - $standar->sd_minus2) / 4;
        return ($measurement - $standar->median) / $sd;
    }
}
