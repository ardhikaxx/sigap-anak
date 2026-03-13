<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Anak;
use App\Models\Pemeriksaan;
use App\Models\Konsultasi;
use App\Models\JadwalPosyandu;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tipe = $request->get('tipe', 'pemeriksaan');
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);

        $data = $this->generateLaporan($tipe, $bulan, $tahun);
        
        return view('admin.laporan.index', compact('data', 'tipe', 'bulan', 'tahun'));
    }

    public function generateLaporan($tipe, $bulan, $tahun)
    {
        switch ($tipe) {
            case 'pemeriksaan':
                return $this->laporanPemeriksaan($bulan, $tahun);
            case 'pertumbuhan':
                return $this->laporanPertumbuhan($bulan, $tahun);
            case 'posyandu':
                return $this->laporanPosyandu($bulan, $tahun);
            case 'konsultasi':
                return $this->laporanKonsultasi($bulan, $tahun);
            case 'gizi':
                return $this->laporanGizi($bulan, $tahun);
            default:
                return [];
        }
    }

    private function laporanPemeriksaan($bulan, $tahun)
    {
        $pemeriksaans = Pemeriksaan::whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->get();

        $total = $pemeriksaans->count();
        $statusGizi = $pemeriksaans->groupBy('status_gizi_akhir')->map->count();

        return [
            'title' => 'Laporan Pemeriksaan',
            'total' => $total,
            'status_gizi' => $statusGizi,
            'data' => $pemeriksaans->take(100)
        ];
    }

    private function laporanPertumbuhan($bulan, $tahun)
    {
        $pemeriksaans = Pemeriksaan::whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->get();

        $rerata_bb = $pemeriksaans->avg('berat_badan');
        $rerata_tb = $pemeriksaans->avg('tinggi_badan');

        return [
            'title' => 'Laporan Pertumbuhan',
            'rerata_berat' => round($rerata_bb, 2),
            'rerata_tinggi' => round($rerata_tb, 2),
            'data' => $pemeriksaans->take(100)
        ];
    }

    private function laporanPosyandu($bulan, $tahun)
    {
        $jadwals = JadwalPosyandu::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->with('kehadiran')
            ->get();

        $total_jadwal = $jadwals->count();
        $total_hadir = $jadwals->sum(function($j) {
            return $j->kehadiran->where('hadir', true)->count();
        });

        return [
            'title' => 'Laporan Posyandu',
            'total_jadwal' => $total_jadwal,
            'total_hadir' => $total_hadir,
            'data' => $jadwals
        ];
    }

    private function laporanKonsultasi($bulan, $tahun)
    {
        $konsultasis = Konsultasi::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get();

        $total = $konsultasis->count();
        $selesai = $konsultasis->where('status', 'selesai')->count();
        $rating_rata = $konsultasis->whereNotNull('rating')->avg('rating');

        return [
            'title' => 'Laporan Konsultasi',
            'total' => $total,
            'selesai' => $selesai,
            'rating_rata' => round($rating_rata, 1),
            'data' => $konsultasis
        ];
    }

    private function laporanGizi($bulan, $tahun)
    {
        $pemeriksaans = Pemeriksaan::whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->get();

        $status = [
            'normal' => $pemeriksaans->where('status_gizi_akhir', 'normal')->count(),
            'stunting' => $pemeriksaans->where('status_gizi_akhir', 'stunting')->count(),
            'wasting' => $pemeriksaans->where('status_gizi_akhir', 'wasting')->count(),
            'underweight' => $pemeriksaans->where('status_gizi_akhir', 'underweight')->count(),
            'obesitas' => $pemeriksaans->whereIn('status_gizi_akhir', ['obesitas', 'overweight'])->count(),
        ];

        return [
            'title' => 'Laporan Status Gizi',
            'status' => $status,
            'total' => $pemeriksaans->count(),
            'data' => $pemeriksaans->take(100)
        ];
    }

    public function export(Request $request)
    {
        $tipe = $request->get('tipe', 'pemeriksaan');
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);

        $data = $this->generateLaporan($tipe, $bulan, $tahun);

        return view('admin.laporan.export', compact('data', 'tipe', 'bulan', 'tahun'));
    }
}
