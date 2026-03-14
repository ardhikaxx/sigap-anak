<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Pemeriksaan;
use App\Models\Imunisasi;
use App\Models\KonsumsiMakanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnakController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $anaks = Anak::where('status', 'aktif')
            ->where(function($query) use ($user) {
                $query->where('ibu_id', $user->id)
                      ->orWhere('ayah_id', $user->id)
                      ->orWhere('wali_id', $user->id);
            })
            ->with('latestPemeriksaan')
            ->get();
        
        return view('mobile.anak.index', compact('anaks'));
    }

    public function show(Anak $anak)
    {
        $user = Auth::user();
        
        if (!$this->canAccessAnak($user, $anak)) {
            return redirect()->route('mobile.anak.index')->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        $pemeriksaan = $anak->pemeriksaan()->orderBy('tanggal_periksa', 'desc')->get();
        $imunisasi = $anak->imunisasi()->orderBy('tanggal', 'desc')->get();
        
        $konsumsi = KonsumsiMakanan::where('anak_id', $anak->id)
            ->whereDate('tanggal', today())
            ->get();

        $usia = Carbon::parse($anak->tanggal_lahir)->diff(now());
        
        return view('mobile.anak.show', compact('anak', 'pemeriksaan', 'imunisasi', 'konsumsi', 'usia'));
    }

    private function canAccessAnak($user, $anak)
    {
        return $anak->ibu_id == $user->id || 
               $anak->ayah_id == $user->id || 
               $anak->wali_id == $user->id;
    }
}
