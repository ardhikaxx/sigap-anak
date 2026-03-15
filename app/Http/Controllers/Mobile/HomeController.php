<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Pemeriksaan;
use App\Models\JadwalPosyandu;
use App\Models\Edukasi;
use App\Models\Imunisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $anak = Anak::where('status', 'aktif')
            ->where(function($query) use ($user) {
                $query->where('ibu_id', $user->id)
                      ->orWhere('ayah_id', $user->id)
                      ->orWhere('wali_id', $user->id);
            })
            ->with('latestPemeriksaan')
            ->get();

        $jadwalMendatang = JadwalPosyandu::where('tanggal', '>=', today())
            ->where('status', 'terjadwal')
            ->with('faskes')
            ->orderBy('tanggal')
            ->limit(3)
            ->get();

        $artikel = Edukasi::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $greeting = $this->getGreeting();
        
        return view('mobile.home', compact('anak', 'jadwalMendatang', 'artikel', 'greeting', 'user'));
    }

    private function getGreeting()
    {
        $hour = now()->hour;
        if ($hour < 12) return 'Selamat Pagi';
        if ($hour < 15) return 'Selamat Siang';
        if ($hour < 18) return 'Selamat Sore';
        return 'Selamat Malam';
    }

    public function profile()
    {
        $user = Auth::user();
        
        $anakCount = Anak::where('status', 'aktif')
            ->where(function($query) use ($user) {
                $query->where('ibu_id', $user->id)
                      ->orWhere('ayah_id', $user->id)
                      ->orWhere('wali_id', $user->id);
            })
            ->count();

        return view('mobile.profile.index', compact('user', 'anakCount'));
    }
}
