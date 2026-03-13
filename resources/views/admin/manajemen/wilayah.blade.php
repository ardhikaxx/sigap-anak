@extends('admin.layout.master')

@section('title', 'Manajemen Wilayah')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Manajemen Wilayah</h1>
        <a href="{{ route('admin.manajemen.wilayah.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Wilayah
        </a>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary">Cari</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Provinsi</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wilayahs as $index => $w)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $w->kode }}</td>
                        <td>{{ $w->nama }}</td>
                        <td>{{ $w->provinsi }}</td>
                        <td>{{ $w->kabupaten }}</td>
                        <td>{{ $w->kecamatan }}</td>
                        <td>
                            <span class="badge badge-{{ $w->is_active ? 'success' : 'secondary' }}">
                                {{ $w->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.manajemen.wilayah.edit', $w->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.manajemen.wilayah.destroy', $w->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $wilayahs->links() }}
        </div>
    </div>
</div>
@endsection
