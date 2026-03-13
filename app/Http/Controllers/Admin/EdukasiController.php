<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;

class EdukasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Edukasi::query();
        
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('konten', 'like', '%' . $request->search . '%');
            });
        }
        
        $edukasis = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.edukasi.index', compact('edukasis'));
    }

    public function show(Edukasi $edukasi)
    {
        $edukasi->increment('views');
        return view('admin.edukasi.show', compact('edukasi'));
    }

    public function create()
    {
        return view('admin.edukasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'slug' => 'required|string|unique:edukasi,slug',
            'kategori' => 'required|in:nutrisi,imunisasi,perkembangan,penyakit,ibu_hamil,lainnya',
            'konten' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('edukasi', 'public');
        }

        $validated['is_active'] = true;
        Edukasi::create($validated);

        return redirect()->route('admin.edukasi.index')->with('success', 'Edukasi berhasil ditambahkan');
    }

    public function edit(Edukasi $edukasi)
    {
        return view('admin.edukasi.edit', compact('edukasi'));
    }

    public function update(Request $request, Edukasi $edukasi)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'slug' => 'required|string|unique:edukasi,slug,' . $edukasi->id,
            'kategori' => 'required|in:nutrisi,imunisasi,perkembangan,penyakit,ibu_hamil,lainnya',
            'konten' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('edukasi', 'public');
        }

        $edukasi->update($validated);

        return redirect()->route('admin.edukasi.index')->with('success', 'Edukasi berhasil diperbarui');
    }

    public function destroy(Edukasi $edukasi)
    {
        $edukasi->delete();
        return redirect()->route('admin.edukasi.index')->with('success', 'Edukasi berhasil dihapus');
    }
}
