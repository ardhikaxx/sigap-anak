<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Pemeriksaan;
use App\Models\FasilitasKesehatan;
use App\Models\StandarWho;
use App\Models\AuditLog;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PemeriksaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemeriksaan::with(['anak', 'nakes', 'posyandu']);

        if ($request->tanggal_mulai) {
            $query->whereDate('tanggal_periksa', '>=', $request->tanggal_mulai);
        }

        if ($request->tanggal_selesai) {
            $query->whereDate('tanggal_periksa', '<=', $request->tanggal_selesai);
        }

        if ($request->status_gizi) {
            $query->where('status_gizi_akhir', $request->status_gizi);
        }

        $pemeriksaans = $query->orderBy('tanggal_periksa', 'desc')->paginate(15);
        
        return view('admin.pemeriksaan.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $anaks = Anak::where('status', 'aktif')->orderBy('nama')->get();
        $posyandu = FasilitasKesehatan::where('tipe', 'posyandu')->where('is_active', true)->get();
        
        return view('admin.pemeriksaan.create', compact('anaks', 'posyandu'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anak_id' => 'required|exists:anak,id',
            'posyandu_id' => 'nullable|exists:fasilitas_kesehatan,id',
            'tanggal_periksa' => 'required|date',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'lingkar_kepala' => 'nullable|numeric|min:0',
            'lingkar_lengan' => 'nullable|numeric|min:0',
            'lingkar_perut' => 'nullable|numeric|min:0',
            'lingkar_dada' => 'nullable|numeric|min:0',
            'suhu_tubuh' => 'nullable|numeric|min:0',
            'tekanan_darah' => 'nullable|string|max:20',
            'kondisi_umum' => 'nullable|in:baik,sedang,buruk',
            'edema' => 'nullable|boolean',
            'diberikan_vit_a' => 'nullable|boolean',
            'diberikan_fe' => 'nullable|boolean',
            'diberikan_zinc' => 'nullable|boolean',
            'diberikan_pmt' => 'nullable|boolean',
            'dirujuk' => 'nullable|boolean',
            'tujuan_rujukan' => 'nullable|string|max:255',
            'alasan_rujukan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $anak = Anak::find($request->anak_id);
        $validated['nakes_id'] = Auth::id();
        $validated['umur_bulan'] = Carbon::parse($anak->tanggal_lahir)->diffInMonths(Carbon::parse($request->tanggal_periksa));
        
        $this->calculateZScore($validated, $anak, $request->tanggal_periksa);

        $pemeriksaan = Pemeriksaan::create($validated);

        if (in_array($validated['status_gizi_akhir'], ['gizi_buruk', 'stunting', 'wasting'])) {
            Notifikasi::create([
                'user_id' => $anak->ibu_id,
                'judul' => 'Perhatian: Status Gizi ' . $anak->nama,
                'pesan' => 'Status gizi anak Anda terdeteksi: ' . $validated['status_gizi_akhir'] . '. Segera hubungi tenaga kesehatan.',
                'tipe' => 'warning',
                'ikon' => 'fa-exclamation-triangle',
                'link' => route('mobile.anak.show', $anak->id),
            ]);
        }

        AuditLog::log(Auth::id(), 'create', 'pemeriksaan', $pemeriksaan->id, null, $validated);

        return redirect()->route('admin.pemeriksaan.index')->with('success', 'Data pemeriksaan berhasil disimpan.');
    }

    private function calculateZScore(&$data, $anak, $tanggalPeriksa)
    {
        $umurBulan = Carbon::parse($anak->tanggal_lahir)->diffInMonths(Carbon::parse($tanggalPeriksa));
        $jenisKelamin = $anak->jenis_kelamin;

        $bb_u = StandarWho::getZScore($jenisKelamin, $umurBulan, 'BB_U', $data['berat_badan']);
        $tb_u = StandarWho::getZScore($jenisKelamin, $umurBulan, 'TB_U', $data['tinggi_badan']);
        $bb_tb = StandarWho::getZScore($jenisKelamin, $umurBulan, 'BB_TB', $data['berat_badan'], $data['tinggi_badan']);

        $data['bb_u_zscore'] = $bb_u;
        $data['tb_u_zscore'] = $tb_u;
        $data['bb_tb_zscore'] = $bb_tb;

        $data['status_bb_u'] = $this->getStatusBBU($bb_u);
        $data['status_tb_u'] = $this->getStatusTBU($tb_u);
        $data['status_bb_tb'] = $this->getStatusBBTB($bb_tb);
        $data['status_gizi_akhir'] = $this->getStatusGiziAkhir($data['status_bb_u'], $data['status_tb_u'], $data['status_bb_tb']);
    }

    private function getStatusBBU($zscore)
    {
        if ($zscore === null) return null;
        if ($zscore < -3) return 'gizi_buruk';
        if ($zscore < -2) return 'gizi_kurang';
        if ($zscore <= 1) return 'gizi_baik';
        if ($zscore <= 2) return 'gizi_lebih';
        return 'obesitas';
    }

    private function getStatusTBU($zscore)
    {
        if ($zscore === null) return null;
        if ($zscore < -3) return 'sangat_pendek';
        if ($zscore < -2) return 'pendek';
        if ($zscore <= 3) return 'normal';
        return 'tinggi';
    }

    private function getStatusBBTB($zscore)
    {
        if ($zscore === null) return null;
        if ($zscore < -3) return 'sangat_kurus';
        if ($zscore < -2) return 'kurus';
        if ($zscore <= 1) return 'normal';
        if ($zscore <= 2) return 'gemuk';
        return 'obesitas';
    }

    private function getStatusGiziAkhir($bb_u, $tb_u, $bb_tb)
    {
        if ($bb_u === 'gizi_buruk' || $bb_tb === 'sangat_kurus') return 'gizi_buruk';
        if ($bb_u === 'gizi_kurang' || $bb_tb === 'kurus') return 'underweight';
        if ($tb_u === 'sangat_pendek' || $tb_u === 'pendek') return 'stunting';
        if ($bb_tb === 'sangat_kurus' || $bb_tb === 'kurus') return 'wasting';
        if ($bb_u === 'obesitas' || $bb_tb === 'obesitas') return 'obesitas';
        if ($bb_u === 'gizi_lebih' || $bb_tb === 'gemuk') return 'overweight';
        if ($bb_u === 'gizi_baik' && $tb_u === 'normal' && $bb_tb === 'normal') return 'normal';
        return 'berisiko';
    }

    public function show(Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->load(['anak', 'nakes', 'posyandu']);
        
        return view('admin.pemeriksaan.show', compact('pemeriksaan'));
    }

    public function destroy(Pemeriksaan $pemeriksaan)
    {
        $dataLama = $pemeriksaan->toArray();
        $pemeriksaan->delete();

        AuditLog::log(Auth::id(), 'delete', 'pemeriksaan', $pemeriksaan->id, $dataLama, null);

        return redirect()->route('admin.pemeriksaan.index')->with('success', 'Data pemeriksaan berhasil dihapus.');
    }
}
