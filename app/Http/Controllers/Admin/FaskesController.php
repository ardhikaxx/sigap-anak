<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FasilitasKesehatan;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class FaskesController extends Controller
{
    public function index(Request $request)
    {
        $query = FasilitasKesehatan::with('wilayah');

        if ($request->tipe) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kode', 'like', '%' . $request->search . '%');
            });
        }

        $faskes = $query->orderBy('nama')->paginate(20);

        return view('admin.manajemen.faskes', compact('faskes'));
    }

    public function create()
    {
        $wilayahs = Wilayah::where('is_active', true)->orderBy('nama')->get();
        return view('admin.manajemen.faskes_create', compact('wilayahs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|unique:fasilitas_kesehatan,kode',
            'tipe' => 'required|in:rs,puskesmas,posyandu,polindes,klinik',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'wilayah_id' => 'required|exists:wilayah,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;

        FasilitasKesehatan::create($validated);

        return redirect()->route('admin.manajemen.faskes')->with('success', 'Faskes berhasil ditambahkan');
    }

    public function show(FasilitasKesehatan $faskes)
    {
        $faskes->load('wilayah');
        return view('admin.manajemen.faskes_show', compact('faskes'));
    }

    public function edit(FasilitasKesehatan $faskes)
    {
        $wilayahs = Wilayah::where('is_active', true)->orderBy('nama')->get();
        return view('admin.manajemen.faskes_edit', compact('faskes', 'wilayahs'));
    }

    public function update(Request $request, FasilitasKesehatan $faskes)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|unique:fasilitas_kesehatan,kode,' . $faskes->id,
            'tipe' => 'required|in:rs,puskesmas,posyandu,polindes,klinik',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'wilayah_id' => 'required|exists:wilayah,id',
            'is_active' => 'boolean',
        ]);

        $faskes->update($validated);

        return redirect()->route('admin.manajemen.faskes')->with('success', 'Faskes berhasil diperbarui');
    }

    public function destroy(FasilitasKesehatan $faskes)
    {
        $faskes->delete();
        return redirect()->route('admin.manajemen.faskes')->with('success', 'Faskes berhasil dihapus');
    }

    public function toggleStatus(FasilitasKesehatan $faskes)
    {
        $faskes->update(['is_active' => !$faskes->is_active]);
        return back()->with('success', 'Status faskes diperbarui');
    }
}
