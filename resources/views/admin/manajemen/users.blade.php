@extends('admin.layout.master')

@section('title', 'Manajemen Pengguna Sistem')

@push('styles')
<style>
  /* Reuse consistent premium styles */
  .page-header-premium {
    background: #1A1D2E;
    background-image: radial-gradient(at 0% 0%, rgba(46, 134, 171, 0.15) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(87, 204, 153, 0.1) 0px, transparent 50%);
    border-radius: 35px; padding: 60px 40px 100px; margin-bottom: -60px; position: relative;
  }
  .header-stats-mini { display: flex; gap: 30px; margin-top: 25px; }
  .header-stat-item { padding-left: 15px; border-left: 2px solid rgba(255,255,255,0.1); }
  .header-stat-label { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.5); margin-bottom: 2px; }
  .header-stat-value { font-size: 1.2rem; font-weight: 800; color: white; }
  .filter-container-glass {
    background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5); border-radius: 28px; padding: 25px; box-shadow: 0 20px 40px rgba(0,0,0,0.04); position: relative; z-index: 5;
  }
  .table-modern { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
  .table-modern thead th { padding: 15px 25px; font-size: 0.75rem; font-weight: 800; color: var(--sigap-gray); text-transform: uppercase; letter-spacing: 1px; border: none; }
  .table-modern tbody tr { background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.02); transition: all 0.3s ease; }
  .table-modern tbody tr:hover { transform: translateY(-3px) scale(1.005); box-shadow: 0 15px 30px rgba(0,0,0,0.06); }
  .table-modern td { padding: 20px 25px; vertical-align: middle; border: none; }
  .table-modern td:first-child { border-radius: 24px 0 0 24px; border-left: 1px solid #f1f5f9; }
  .table-modern td:last-child { border-radius: 0 24px 24px 0; border-right: 1px solid #f1f5f9; }

  .user-avatar-rect {
    width: 48px; height: 48px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }
  .role-badge {
    padding: 5px 12px; border-radius: 8px; font-weight: 800; font-size: 0.7rem; text-transform: uppercase;
  }
</style>
@endpush

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Manajemen User</li>
@endsection

@section('content')
<div class="page-header-premium">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <h1 class="display-5 fw-800 text-white mb-1">Pengguna Sistem</h1>
      <p class="text-white opacity-60 fs-5">Kelola hak akses petugas kesehatan dan akun orang tua.</p>
      
      <div class="header-stats-mini">
        <div class="header-stat-item">
          <div class="header-stat-label">Total User</div>
          <div class="header-stat-value">{{ $users->total() }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Admin/Nakes</div>
          <div class="header-stat-value text-info">{{ $users->whereIn('role', ['superadmin', 'dokter', 'bidan', 'ahli_gizi'])->count() }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Aktif</div>
          <div class="header-stat-value text-success">{{ $users->count() }}</div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
      <a href="{{ route('admin.manajemen.users.create') }}" class="btn btn-premium-action btn-gradient-add">
        <i class="fas fa-plus-circle me-2"></i> Tambah Pengguna Baru
      </a>
    </div>
  </div>
</div>

<div class="filter-container-glass mx-3">
  <form method="GET" action="{{ route('admin.manajemen.users') }}" class="row g-3">
    <div class="col-lg-6">
      <input type="text" name="search" class="form-control border-0 bg-light rounded-4 py-3 px-4" placeholder="Cari Nama atau Email..." value="{{ request('search') }}">
    </div>
    <div class="col-lg-4">
      <select name="role" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold">
        <option value="">Semua Peran (Role)</option>
        <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
        <option value="dokter" {{ request('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
        <option value="bidan" {{ request('role') == 'bidan' ? 'selected' : '' }}>Bidan</option>
        <option value="ahli_gizi" {{ request('role') == 'ahli_gizi' ? 'selected' : '' }}>Ahli Gizi</option>
        <option value="orangtua" {{ request('role') == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
      </select>
    </div>
    <div class="col-lg-2">
      <button type="submit" class="btn btn-primary w-100 rounded-4 py-3 fw-bold shadow-sm">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </form>
</div>

<div class="table-premium-container px-3">
  <div class="table-responsive">
    <table class="table-modern">
      <thead>
        <tr>
          <th>Profil Pengguna</th>
          <th>Hak Akses (Role)</th>
          <th>Kontak</th>
          <th>Status</th>
          <th class="text-end">Opsi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
        <tr>
          <td>
            <div class="d-flex align-items-center gap-3">
              <img src="{{ $u->avatar ? asset('storage/'.$u->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=2E86AB&color=fff&bold=true' }}" class="user-avatar-rect">
              <div>
                <div class="fw-800 text-dark mb-0">{{ $u->name }}</div>
                <div class="user-meta small">{{ $u->email }}</div>
              </div>
            </div>
          </td>
          <td>
            @php
              $roleColor = match($u->role) {
                'superadmin' => 'bg-danger text-white',
                'dokter' => 'bg-info text-white',
                'bidan', 'ahli_gizi' => 'bg-primary text-white',
                default => 'bg-light text-dark'
              };
            @endphp
            <span class="role-badge {{ $roleColor }}">
              {{ str_replace('_', ' ', $u->role) }}
            </span>
          </td>
          <td>
            <div class="fw-bold text-dark small">{{ $u->no_hp ?: '-' }}</div>
          </td>
          <td>
            <span class="badge-custom badge-normal py-1 px-3">Aktif</span>
          </td>
          <td class="text-end">
            <div class="dropdown">
              <button class="btn btn-light btn-sm rounded-3 border" data-bs-toggle="dropdown">
                <i class="fas fa-ellipsis-v"></i>
              </button>
              <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4">
                <li><a class="dropdown-item rounded-3" href="{{ route('admin.manajemen.users.show', $u->id) }}">Detail</a></li>
                <li><a class="dropdown-item rounded-3" href="{{ route('admin.manajemen.users.edit', $u->id) }}">Edit</a></li>
                <li><hr class="dropdown-divider opacity-10"></li>
                <li>
                  <form action="{{ route('admin.manajemen.users.destroy', $u->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="dropdown-item rounded-3 text-danger btn-delete">Hapus</button>
                  </form>
                </li>
              </ul>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="py-5 text-center">
            <div class="empty-state py-5">
              <i class="fas fa-user-slash fa-3x opacity-20 mb-3"></i>
              <h5 class="fw-800 text-dark">Data Tidak Ditemukan</h5>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4 mb-5">
  {{ $users->links('vendor.pagination.sigap-premium') }}
</div>
@endsection
