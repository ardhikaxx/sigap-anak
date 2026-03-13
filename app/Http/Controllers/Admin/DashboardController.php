<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Pemeriksaan;
use App\Models\JadwalPosyandu;
use App\Models\Konsultasi;
use App\Models\FasilitasKesehatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalAnak = Anak::where('status', 'aktif')->count();
        $pemeriksaanHariIni = Pemeriksaan::whereDate('tanggal_periksa', today())->count();
        $pemeriksaanBulanIni = Pemeriksaan::whereMonth('tanggal_periksa', now()->month)->count();
        
        $statusGizi = Pemeriksaan::select('status_gizi_akhir')
            ->whereHas('anak', function($q) {
                $q->where('status', 'aktif');
            })
            ->whereNotNull('status_gizi_akhir')
            ->get()
            ->groupBy('status_gizi_akhir')
            ->map(fn($q) => $q->count());
        
        $konsultasiPending = Konsultasi::where('status', 'menunggu')->count();
        
        $jadwalMendatang = JadwalPosyandu::where('tanggal', '>=', today())
            ->where('status', 'terjadwal')
            ->with('faskes')
            ->orderBy('tanggal')
            ->limit(5)
            ->get();
        
        $pemeriksaanTerbaru = Pemeriksaan::with('anak')
            ->latest()
            ->limit(5)
            ->get();
        
        $anakBerisiko = Anak::where('status', 'aktif')
            ->whereHas('pemeriksaan', function($q) {
                $q->whereIn('status_gizi_akhir', ['gizi_buruk', 'stunting', 'wasting', 'underweight'])
                  ->whereDate('tanggal_periksa', '>=', now()->subMonths(3));
            })
            ->with('latestPemeriksaan')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalAnak',
            'pemeriksaanHariIni',
            'pemeriksaanBulanIni',
            'statusGizi',
            'konsultasiPending',
            'jadwalMendatang',
            'pemeriksaanTerbaru',
            'anakBerisiko'
        ));
    }
}
