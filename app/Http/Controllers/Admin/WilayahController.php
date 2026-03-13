<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index(Request $request)
    {
        $query = Wilayah::query();

        if ($request->provinsi) {
            $query->where('provinsi', $request->provinsi);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kode', 'like', '%' . $request->search . '%');
            });
        }

        $wilayahs = $query->orderBy('nama')->paginate(20);

        return view('admin.manajemen.wilayah', compact('wilayahs'));
    }

    public function create()
    {
        return view('admin.manajemen.wilayah_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|unique:wilayah,kode',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kelurahan' => 'nullable|string|max:100',
            'rw' => 'nullable|string|max:10',
            'rt' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;

        Wilayah::create($validated);

        return redirect()->route('admin.manajemen.wilayah')->with('success', 'Wilayah berhasil ditambahkan');
    }

    public function edit(Wilayah $wilayah)
    {
        return view('admin.manajemen.wilayah_edit', compact('wilayah'));
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|unique:wilayah,kode,' . $wilayah->id,
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kelurahan' => 'nullable|string|max:100',
            'rw' => 'nullable|string|max:10',
            'rt' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        $wilayah->update($validated);

        return redirect()->route('admin.manajemen.wilayah')->with('success', 'Wilayah berhasil diperbarui');
    }

    public function destroy(Wilayah $wilayah)
    {
        $wilayah->delete();
        return redirect()->route('admin.manajemen.wilayah')->with('success', 'Wilayah berhasil dihapus');
    }
}
