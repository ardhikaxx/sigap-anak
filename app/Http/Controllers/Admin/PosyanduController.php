<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPosyandu;
use App\Models\FasilitasKesehatan;
use App\Models\KehadiranPosyandu;
use App\Models\Anak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosyanduController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalPosyandu::with('faskes');

        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->bulan) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $jadwal = $query->orderBy('tanggal', 'desc')->paginate(15);
        
        return view('admin.posyandu.index', compact('jadwal'));
    }

    public function create()
    {
        $faskes = FasilitasKesehatan::where('tipe', 'posyandu')->where('is_active', true)->get();
        
        return view('admin.posyandu.create', compact('faskes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'faskes_id' => 'required|exists:fasilitas_kesehatan,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'tema' => 'nullable|string|max:200',
            'lokasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'nakes_pj_id' => 'nullable|exists:users,id',
        ]);

        $validated['status'] = 'terjadwal';
        $validated['nakes_pj_id'] = $validated['nakes_pj_id'] ?? Auth::id();

        JadwalPosyandu::create($validated);

        return redirect()->route('admin.posyandu.index')->with('success', 'Jadwal posyandu berhasil dibuat.');
    }

    public function show(JadwalPosyandu $jadwal)
    {
        $jadwal->load(['faskes', 'nakesPj', 'kehadiran.anak']);
        
        $anakTerdaftar = Anak::where('faskes_id', $jadwal->faskes_id)
            ->where('status', 'aktif')
            ->get();

        $totalHadir = $jadwal->kehadiran()->where('hadir', true)->count();
        $totalTarget = $anakTerdaftar->count();

        return view('admin.posyandu.show', compact('jadwal', 'anakTerdaftar', 'totalHadir', 'totalTarget'));
    }

    public function absensi(JadwalPosyandu $jadwal)
    {
        $jadwal->load('faskes');
        
        $anakTerdaftar = Anak::where('faskes_id', $jadwal->faskes_id)
            ->where('status', 'aktif')
            ->get();

        $kehadiran = $jadwal->kehadiran()->pluck('hadir', 'anak_id')->toArray();

        return view('admin.posyandu.absensi', compact('jadwal', 'anakTerdaftar', 'kehadiran'));
    }

    public function updateAbsensi(Request $request, JadwalPosyandu $jadwal)
    {
        $request->validate([
            'kehadiran' => 'required|array',
        ]);

        foreach ($request->kehadiran as $anakId => $status) {
            KehadiranPosyandu::updateOrCreate(
                ['jadwal_id' => $jadwal->id, 'anak_id' => $anakId],
                ['hadir' => $status == '1', 'keterangan' => $request->keterangan[$anakId] ?? null]
            );
        }

        return redirect()->route('admin.posyandu.show', $jadwal->id)->with('success', 'Absensi berhasil disimpan.');
    }

    public function updateStatus(Request $request, JadwalPosyandu $jadwal)
    {
        $request->validate([
            'status' => 'required|in:terjadwal,sedang_berlangsung,selesai,dibatalkan',
        ]);

        $jadwal->update(['status' => $request->status]);

        return back()->with('success', 'Status posyandu diperbarui.');
    }

    public function destroy(JadwalPosyandu $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.posyandu.index')->with('success', 'Jadwal posyandu dihapus.');
    }
}
