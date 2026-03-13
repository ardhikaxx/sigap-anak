<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index()
    {
        $konsultasis = Konsultasi::with(['anak', 'orangtua', 'nakes'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.konsultasi.index', compact('konsultasis'));
    }

    public function show(Konsultasi $konsultasi)
    {
        $konsultasi->load(['anak', 'orangtua', 'nakes', 'pesan']);
        return view('admin.konsultasi.show', compact('konsultasi'));
    }

    public function updateStatus(Request $request, Konsultasi $konsultasi)
    {
        $request->validate([
            'status' => 'required|in:menunggu,aktif,selesai,dibatalkan'
        ]);
        
        $konsultasi->update(['status' => $request->status]);
        
        return redirect()->route('admin.konsultasi.index')->with('success', 'Status konsultasi diperbarui');
    }
}
