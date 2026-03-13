<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\User;
use App\Models\Wilayah;
use App\Models\FasilitasKesehatan;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AnakController extends Controller
{
    public function index(Request $request)
    {
        $query = Anak::with(['ibu', 'ayah', 'faskes', 'wilayah', 'latestPemeriksaan']);

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nik_anak', 'like', '%' . $request->search . '%');
        }

        if ($request->jenis_kelamin) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->faskes_id) {
            $query->where('faskes_id', $request->faskes_id);
        }

        $anak = $query->orderBy('nama')->paginate(15);
        $faskes = FasilitasKesehatan::where('is_active', true)->get();
        
        return view('admin.anak.index', compact('anak', 'faskes'));
    }

    public function create()
    {
        $ibuList = User::where('role', 'orangtua')->where('is_active', true)->get();
        $ayahList = User::where('role', 'orangtua')->where('is_active', true)->get();
        $nakesList = User::whereIn('role', ['dokter', 'bidan', 'ahli_gizi', 'kader'])->where('is_active', true)->get();
        $faskes = FasilitasKesehatan::where('is_active', true)->get();
        $wilayah = Wilayah::where('tipe', 'kelurahan')->get();
        
        return view('admin.anak.create', compact('ibuList', 'ayahList', 'nakesList', 'faskes', 'wilayah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik_anak' => 'nullable|string|max:20',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'berat_lahir' => 'nullable|numeric|min:0',
            'panjang_lahir' => 'nullable|numeric|min:0',
            'golongan_darah' => 'nullable|in:A,B,AB,O,A+,A-,B+,B-,AB+,AB-,O+,O-',
            'nomor_bpjs' => 'nullable|string|max:30',
            'nomor_kartu_anak' => 'nullable|string|max:30',
            'ibu_id' => 'nullable|exists:users,id',
            'ayah_id' => 'nullable|exists:users,id',
            'faskes_id' => 'nullable|exists:fasilitas_kesehatan,id',
            'nakes_pj_id' => 'nullable|exists:users,id',
            'wilayah_id' => 'nullable|exists:wilayah,id',
            'catatan_khusus' => 'nullable|string',
        ]);

        $anak = Anak::create($validated);

        AuditLog::log(Auth::id(), 'create', 'anak', $anak->id, null, $validated);

        return redirect()->route('admin.anak.index')->with('success', 'Data anak berhasil disimpan.');
    }

    public function show(Anak $anak)
    {
        $anak->load(['ibu', 'ayah', 'wali', 'faskes', 'wilayah', 'nakesPj']);
        $pemeriksaan = $anak->pemeriksaan()->with('nakes')->orderBy('tanggal_periksa', 'desc')->get();
        $imunisasi = $anak->imunisasi()->orderBy('tanggal', 'desc')->get();
        $riwayatPenyakit = $anak->riwayatPenyakit()->orderBy('tanggal_mulai', 'desc')->get();
        
        return view('admin.anak.show', compact('anak', 'pemeriksaan', 'imunisasi', 'riwayatPenyakit'));
    }

    public function edit(Anak $anak)
    {
        $ibuList = User::where('role', 'orangtua')->where('is_active', true)->get();
        $ayahList = User::where('role', 'orangtua')->where('is_active', true)->get();
        $nakesList = User::whereIn('role', ['dokter', 'bidan', 'ahli_gizi', 'kader'])->where('is_active', true)->get();
        $faskes = FasilitasKesehatan::where('is_active', true)->get();
        $wilayah = Wilayah::where('tipe', 'kelurahan')->get();
        
        return view('admin.anak.edit', compact('anak', 'ibuList', 'ayahList', 'nakesList', 'faskes', 'wilayah'));
    }

    public function update(Request $request, Anak $anak)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik_anak' => 'nullable|string|max:20',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'berat_lahir' => 'nullable|numeric|min:0',
            'panjang_lahir' => 'nullable|numeric|min:0',
            'golongan_darah' => 'nullable|in:A,B,AB,O,A+,A-,B+,B-,AB+,AB-,O+,O-',
            'nomor_bpjs' => 'nullable|string|max:30',
            'nomor_kartu_anak' => 'nullable|string|max:30',
            'ibu_id' => 'nullable|exists:users,id',
            'ayah_id' => 'nullable|exists:users,id',
            'faskes_id' => 'nullable|exists:fasilitas_kesehatan,id',
            'nakes_pj_id' => 'nullable|exists:users,id',
            'wilayah_id' => 'nullable|exists:wilayah,id',
            'status' => 'required|in:aktif,pindah,meninggal',
            'catatan_khusus' => 'nullable|string',
        ]);

        $dataLama = $anak->toArray();
        $anak->update($validated);

        AuditLog::log(Auth::id(), 'update', 'anak', $anak->id, $dataLama, $validated);

        return redirect()->route('admin.anak.show', $anak)->with('success', 'Data anak berhasil diperbarui.');
    }

    public function destroy(Anak $anak)
    {
        $dataLama = $anak->toArray();
        $anak->delete();

        AuditLog::log(Auth::id(), 'delete', 'anak', $anak->id, $dataLama, null);

        return redirect()->route('admin.anak.index')->with('success', 'Data anak berhasil dihapus.');
    }
}
