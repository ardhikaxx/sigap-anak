<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrafikController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $anak = Anak::where('status', 'aktif')
            ->where(function($query) use ($user) {
                $query->where('ibu_id', $user->id)
                      ->orWhere('ayah_id', $user->id)
                      ->orWhere('wali_id', $user->id);
            })
            ->get();

        $selectedAnak = null;
        $pemeriksaan = collect();
        $indikator = $request->indikator ?? 'bb_u';

        if ($request->anak_id) {
            $selectedAnak = Anak::find($request->anak_id);
            if ($selectedAnak && $this->canAccessAnak($user, $selectedAnak)) {
                $pemeriksaan = $selectedAnak->pemeriksaan()
                    ->orderBy('tanggal_periksa')
                    ->get();
            }
        }

        return view('mobile.grafik.index', compact('anak', 'selectedAnak', 'pemeriksaan', 'indikator'));
    }

    private function canAccessAnak($user, $anak)
    {
        return $anak->ibu_id == $user->id || 
               $anak->ayah_id == $user->id || 
               $anak->wali_id == $user->id;
    }
}
