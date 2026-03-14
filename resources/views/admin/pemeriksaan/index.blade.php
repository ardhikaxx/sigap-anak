@extends('admin.layout.master')

@section('title', 'Manajemen Pemeriksaan Anak')

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
  
  .measurement-badge {
    background: #f8fafc; border: 1px solid #e2e8f0; padding: 6px 12px; border-radius: 12px; font-weight: 700; color: var(--sigap-dark); font-size: 0.85rem;
  }
  .checkup-icon-box {
    width: 45px; height: 45px; border-radius: 14px; background: rgba(46, 134, 171, 0.1); color: var(--sigap-primary);
    display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
  }
</style>
@endpush

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Riwayat Pemeriksaan</li>
@endsection

@section('content')
<div class="page-header-premium">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <h1 class="display-5 fw-800 text-white mb-1">Log Pemeriksaan</h1>
      <p class="text-white opacity-60 fs-5">Pantau data antropometri dan status gizi anak secara berkala.</p>
      
      <div class="header-stats-mini">
        <div class="header-stat-item">
          <div class="header-stat-label">Total Periksa</div>
          <div class="header-stat-value">{{ $pemeriksaans->total() }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Bulan Ini</div>
          <div class="header-stat-value text-primary">{{ $pemeriksaans->where('tanggal_periksa', '>=', now()->startOfMonth())->count() }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Rujukan</div>
          <div class="header-stat-value text-danger">{{ $pemeriksaans->whereIn('status_gizi_akhir', ['gizi_buruk', 'wasting'])->count() }}</div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
      <a href="{{ route('admin.pemeriksaan.create') }}" class="btn btn-premium-action btn-gradient-add">
        <i class="fas fa-plus-circle me-2"></i> Input Pemeriksaan Baru
      </a>
    </div>
  </div>
</div>

<div class="filter-container-glass mx-3">
  <form method="GET" action="{{ route('admin.pemeriksaan.index') }}" class="row g-3">
    <div class="col-lg-4">
      <input type="text" name="search" class="form-control border-0 bg-light rounded-4 py-3 px-4" placeholder="Cari Nama Anak..." value="{{ request('search') }}">
    </div>
    <div class="col-lg-3">
      <select name="bulan" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold">
        <option value="">Semua Bulan</option>
        @foreach(range(1, 12) as $m)
          <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-lg-3">
      <select name="tahun" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold">
        @foreach(range(now()->year, now()->year - 3) as $y)
          <option value="{{ $y }}" {{ request('tahun', now()->year) == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-lg-2">
      <button type="submit" class="btn btn-primary w-100 rounded-4 py-3 fw-bold shadow-sm">
        <i class="fas fa-search me-1"></i> Cari
      </button>
    </div>
  </form>
</div>

<div class="table-premium-container px-3">
  <div class="table-responsive">
    <table class="table-modern">
      <thead>
        <tr>
          <th>Anak & Tanggal</th>
          <th>Usia</th>
          <th>Berat / Tinggi</th>
          <th>Status Gizi</th>
          <th>Petugas</th>
          <th class="text-end">Opsi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pemeriksaans as $p)
        <tr>
          <td>
            <div class="d-flex align-items-center gap-3">
              <div class="checkup-icon-box">
                <i class="fas fa-file-waveform"></i>
              </div>
              <div>
                <div class="fw-800 text-dark mb-0">{{ $p->anak->nama ?? '-' }}</div>
                <div class="user-meta small">{{ \Carbon\Carbon::parse($p->tanggal_periksa)->format('d M Y') }}</div>
              </div>
            </div>
          </td>
          <td>
            <div class="fw-bold text-dark">{{ $p->umur_bulan }} <span class="fw-normal opacity-50">Bln</span></div>
          </td>
          <td>
            <div class="d-flex gap-2">
              <div class="measurement-badge">{{ $p->berat_badan }} kg</div>
              <div class="measurement-badge">{{ $p->tinggi_badan }} cm</div>
            </div>
          </td>
          <td>
            @php
              $status = $p->status_gizi_akhir;
              $badgeClass = match($status) {
                'normal' => 'badge-normal',
                'gizi_buruk', 'wasting' => 'badge-danger',
                'stunting', 'underweight' => 'badge-warning',
                default => 'badge-default'
              };
            @endphp
            <div class="badge-custom {{ $badgeClass }} py-2 px-3">
              {{ ucfirst(str_replace('_', ' ', $status)) }}
            </div>
          </td>
          <td>
            <div class="fw-bold text-dark small">{{ $p->nakes->name ?? '-' }}</div>
            <div class="user-meta" style="font-size: 10px;">ID: #{{ $p->nakes_id }}</div>
          </td>
          <td class="text-end">
            <a href="{{ route('admin.pemeriksaan.show', $p->id) }}" class="btn btn-light btn-sm rounded-3 border px-3">
              Detail <i class="fas fa-chevron-right ms-1 small"></i>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="py-5 text-center">
            <div class="empty-state py-5">
              <i class="fas fa-clipboard-list fa-3x opacity-20 mb-3"></i>
              <h5 class="fw-800 text-dark">Belum Ada Pemeriksaan</h5>
              <p class="user-meta small">Data hasil pemeriksaan antropometri akan muncul di sini.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4 mb-5">
  {{ $pemeriksaans->links('vendor.pagination.sigap-premium') }}
</div>
@endsection
