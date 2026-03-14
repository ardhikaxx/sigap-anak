@extends('admin.layout.master')

@section('title', 'Manajemen Cakupan Wilayah')

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

  .region-code-box {
    width: 60px; height: 40px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-family: monospace; font-weight: 800; color: var(--sigap-primary); border: 1px solid #e2e8f0;
  }
</style>
@endpush

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Manajemen Wilayah</li>
@endsection

@section('content')
<div class="page-header-premium">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <h1 class="display-5 fw-800 text-white mb-1">Cakupan Wilayah</h1>
      <p class="text-white opacity-60 fs-5">Kelola data geografis dan pembagian area kerja SIGAP Anak.</p>
      
      <div class="header-stats-mini">
        <div class="header-stat-item">
          <div class="header-stat-label">Total Wilayah</div>
          <div class="header-stat-value">{{ $wilayahs->total() }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Provinsi</div>
          <div class="header-stat-value text-info">Jawa Timur</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Status</div>
          <div class="header-stat-value text-success">Aktif</div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
      <a href="{{ route('admin.manajemen.wilayah.create') }}" class="btn btn-premium-action btn-gradient-add">
        <i class="fas fa-map-plus me-2"></i> Tambah Wilayah Baru
      </a>
    </div>
  </div>
</div>

<div class="filter-container-glass mx-3">
  <form method="GET" action="{{ route('admin.manajemen.wilayah') }}" class="row g-3">
    <div class="col-lg-10">
      <div class="input-group-premium position-relative">
        <i class="fas fa-map-marker-alt position-absolute text-muted" style="left: 20px; top: 18px; z-index: 10;"></i>
        <input type="text" name="search" class="form-control border-0 bg-light rounded-4 py-3 ps-5" placeholder="Cari Kode atau Nama Wilayah (Kecamatan/Kabupaten)..." value="{{ request('search') }}">
      </div>
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
          <th>Kode</th>
          <th>Nama Wilayah</th>
          <th>Kecamatan / Kabupaten</th>
          <th>Provinsi</th>
          <th class="text-end">Opsi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($wilayahs as $w)
        <tr>
          <td>
            <div class="region-code-box">{{ $w->kode }}</div>
          </td>
          <td>
            <div class="fw-800 text-dark mb-0 fs-6">{{ $w->nama }}</div>
          </td>
          <td>
            <div class="fw-bold text-dark small">{{ $w->kecamatan }}</div>
            <div class="user-meta small">{{ $w->kabupaten }}</div>
          </td>
          <td>
            <div class="fw-bold text-dark small">{{ $w->provinsi }}</div>
          </td>
          <td class="text-end">
            <div class="d-flex gap-2 justify-content-end">
              <a href="{{ route('admin.manajemen.wilayah.edit', $w->id) }}" class="btn btn-light btn-sm rounded-3 border">
                <i class="fas fa-pen"></i>
              </a>
              <form action="{{ route('admin.manajemen.wilayah.destroy', $w->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-light btn-sm rounded-3 border text-danger btn-delete">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="py-5 text-center">
            <div class="empty-state py-5">
              <i class="fas fa-map-marked-alt fa-3x opacity-20 mb-3"></i>
              <h5 class="fw-800 text-dark">Wilayah Belum Terdaftar</h5>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4 mb-5">
  {{ $wilayahs->links('vendor.pagination.sigap-premium') }}
</div>
@endsection
