@extends('admin.layout.master')

@section('title', 'Manajemen Faskes')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Manajemen Fasilitas Kesehatan</h1>
        <a href="{{ route('admin.manajemen.faskes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Faskes
        </a>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <form method="GET" class="d-flex gap-2">
                <select name="tipe" class="form-control">
                    <option value="">Semua Tipe</option>
                    <option value="rs" {{ request('tipe') == 'rs' ? 'selected' : '' }}>Rumah Sakit</option>
                    <option value="puskesmas" {{ request('tipe') == 'puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                    <option value="posyandu" {{ request('tipe') == 'posyandu' ? 'selected' : '' }}>Posyandu</option>
                    <option value="polindes" {{ request('tipe') == 'polindes' ? 'selected' : '' }}>Polindes</option>
                    <option value="klinik" {{ request('tipe') == 'klinik' ? 'selected' : '' }}>Klinik</option>
                </select>
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
                        <th>Tipe</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faskes as $index => $f)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $f->kode }}</td>
                        <td>{{ $f->nama }}</td>
                        <td><span class="badge badge-info">{{ strtoupper($f->tipe) }}</span></td>
                        <td>{{ $f->alamat }}</td>
                        <td>{{ $f->telepon ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $f->is_active ? 'success' : 'secondary' }}">
                                {{ $f->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.manajemen.faskes.show', $f->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('admin.manajemen.faskes.edit', $f->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.manajemen.faskes.destroy', $f->id) }}" method="POST" class="d-inline">
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
            {{ $faskes->links() }}
        </div>
    </div>
</div>
@endsection
