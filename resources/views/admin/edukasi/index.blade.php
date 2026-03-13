@extends('admin.layout.master')

@php
use Illuminate\Support\Str;
@endphp

@section('title', 'Edukasi')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edukasi</h1>
        <a href="{{ route('admin.edukasi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Edukasi
        </a>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <form method="GET" class="d-flex gap-2">
                <select name="kategori" class="form-control">
                    <option value="">Semua Kategori</option>
                    <option value="nutrisi" {{ request('kategori') == 'nutrisi' ? 'selected' : '' }}>Nutrisi</option>
                    <option value="imunisasi" {{ request('kategori') == 'imunisasi' ? 'selected' : '' }}>Imunisasi</option>
                    <option value="perkembangan" {{ request('kategori') == 'perkembangan' ? 'selected' : '' }}>Perkembangan</option>
                    <option value="penyakit" {{ request('kategori') == 'penyakit' ? 'selected' : '' }}>Penyakit</option>
                </select>
                <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary">Cari</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Views</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($edukasis as $index => $e)
                    <tr>
                        <td>{{ $edukasis->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $e->judul }}</strong>
                            <br><small class="text-muted">{{ Str::limit(strip_tags($e->konten), 50) }}</small>
                        </td>
                        <td><span class="badge bg-info">{{ ucfirst($e->kategori) }}</span></td>
                        <td>{{ $e->views ?? 0 }}</td>
                        <td>{{ \Carbon\Carbon::parse($e->created_at)->format('d-m-Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $e->is_active ? 'success' : 'secondary' }}">
                                {{ $e->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.edukasi.show', $e->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.edukasi.edit', $e->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.edukasi.destroy', $e->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4">
                        <i class="fas fa-book-open fa-3x text-muted mb-3 d-block"></i>
                        <span class="text-muted">Tidak ada data edukasi</span>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $edukasis->links() }}
        </div>
    </div>
</div>
@endsection
