@extends('admin.layout.master')

@section('title', 'Manajemen User')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Manajemen User</h1>
        <a href="{{ route('admin.manajemen.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <form method="GET" class="d-flex gap-2">
                <select name="role" class="form-control">
                    <option value="">Semua Role</option>
                    <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    <option value="dokter" {{ request('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                    <option value="bidan" {{ request('role') == 'bidan' ? 'selected' : '' }}>Bidan</option>
                    <option value="ahli_gizi" {{ request('role') == 'ahli_gizi' ? 'selected' : '' }}>Ahli Gizi</option>
                    <option value="kader" {{ request('role') == 'kader' ? 'selected' : '' }}>Kader</option>
                    <option value="orangtua" {{ request('role') == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $u)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td><span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $u->role)) }}</span></td>
                        <td>
                            <span class="badge badge-{{ $u->is_active ? 'success' : 'danger' }}">
                                {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.manajemen.users.show', $u->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('admin.manajemen.users.edit', $u->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.manajemen.users.destroy', $u->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
