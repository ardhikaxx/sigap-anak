<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Konsultasi;
use App\Models\PesanKonsultasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $konsultasi = Konsultasi::where('orangtua_id', $user->id)
            ->with(['anak', 'nakes'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('mobile.konsultasi.index', compact('konsultasi'));
    }

    public function create()
    {
        $user = Auth::user();
        
        $anak = Anak::where('status', 'aktif')
            ->where(function($query) use ($user) {
                $query->where('ibu_id', $user->id)
                      ->orWhere('ayah_id', $user->id)
                      ->orWhere('wali_id', $user->id);
            })
            ->get();

        $nakes = User::whereIn('role', ['dokter', 'bidan', 'ahli_gizi'])
            ->where('is_active', true)
            ->get();
        
        return view('mobile.konsultasi.create', compact('anak', 'nakes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anak_id' => 'required|exists:anak,id',
            'nakes_id' => 'nullable|exists:users,id',
            'tipe' => 'required|in:chat,video_call,tatap_muka',
            'topik' => 'required|string|max:255',
            'jadwal' => 'nullable|date',
        ]);

        $validated['orangtua_id'] = Auth::id();
        $validated['status'] = 'menunggu';

        $konsultasi = Konsultasi::create($validated);

        return redirect()->route('mobile.konsultasi.show', $konsultasi)->with('success', 'Konsultasi berhasil dibuat.');
    }

    public function show(Konsultasi $konsultasi)
    {
        $user = Auth::user();
        
        if ($konsultasi->orangtua_id != $user->id && $konsultasi->nakes_id != $user->id) {
            return redirect()->route('mobile.konsultasi.index')->with('error', 'Anda tidak memiliki akses.');
        }

        $konsultasi->load(['anak', 'orangtua', 'nakes', 'pesan.pengirim']);
        
        return view('mobile.konsultasi.show', compact('konsultasi'));
    }

    public function sendMessage(Request $request, Konsultasi $konsultasi)
    {
        $validated = $request->validate([
            'pesan' => 'required|string',
        ]);

        $validated['konsultasi_id'] = $konsultasi->id;
        $validated['pengirim_id'] = Auth::id();
        $validated['tipe'] = 'text';

        PesanKonsultasi::create($validated);

        if ($konsultasi->status === 'menunggu') {
            $konsultasi->update(['status' => 'aktif']);
        }

        return back();
    }
}
