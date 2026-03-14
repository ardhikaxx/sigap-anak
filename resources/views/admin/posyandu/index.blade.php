@extends('admin.layout.master')

@section('title', 'Manajemen Kegiatan Posyandu')

@push('styles')
<style>
  /* Premium Posyandu Management UI */
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
  .table-modern tbody tr:hover { transform: translateY(-3px) scale(1.002); box-shadow: 0 15px 30px rgba(0,0,0,0.06); }
  .table-modern td { padding: 20px 25px; vertical-align: middle; border: none; }
  .table-modern td:first-child { border-radius: 24px 0 0 24px; border-left: 1px solid #f1f5f9; }
  .table-modern td:last-child { border-radius: 0 24px 24px 0; border-right: 1px solid #f1f5f9; }

  /* Iconic Schedule Date Box */
  .posyandu-date-card {
    width: 65px; height: 65px; border-radius: 18px; display: flex; flex-direction: column; align-items: center; justify-content: center;
    background: #f8fafc; border: 1px solid #e2e8f0; flex-shrink: 0;
  }
  .posyandu-date-card .day { font-size: 1.4rem; font-weight: 800; color: var(--sigap-dark); line-height: 1; }
  .posyandu-date-card .month { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; color: var(--sigap-primary); margin-top: 2px; }

  .status-badge-premium {
    padding: 6px 14px; border-radius: 12px; font-weight: 800; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;
  }
  .status-terjadwal { background: rgba(14, 165, 233, 0.1); color: #0284c7; }
  .status-berlangsung { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
  .status-selesai { background: rgba(100, 116, 139, 0.1); color: #475569; }
  .status-dibatalkan { background: rgba(239, 68, 68, 0.1); color: #dc2626; }

  .location-info { font-size: 0.85rem; color: #64748b; margin-top: 4px; display: flex; align-items: center; gap: 6px; }
</style>
@endpush

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Kegiatan Posyandu</li>
@endsection

@section('content')
<!-- Header Area -->
<div class="page-header-premium">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <h1 class="display-5 fw-800 text-white mb-1">Agenda Posyandu</h1>
      <p class="text-white opacity-60 fs-5">Atur dan pantau jadwal layanan kesehatan masyarakat bulanan.</p>
      
      <div class="header-stats-mini">
        <div class="header-stat-item">
          <div class="header-stat-label">Total Agenda</div>
          <div class="header-stat-value">{{ $jadwal->total() }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Mendatang</div>
          <div class="header-stat-value text-info">{{ $jadwal->where('status', 'terjadwal')->count() }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Terlaksana</div>
          <div class="header-stat-value text-success">{{ $jadwal->where('status', 'selesai')->count() }}</div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
      <a href="{{ route('admin.posyandu.create') }}" class="btn btn-premium-action btn-gradient-add">
        <i class="fas fa-calendar-plus me-2"></i> Buat Jadwal Baru
      </a>
    </div>
  </div>
</div>

<!-- Filter Container -->
<div class="filter-container-glass mx-3">
  <form method="GET" action="{{ route('admin.posyandu.index') }}" class="row g-3">
    <div class="col-lg-3">
      <label class="form-label small fw-800 text-muted text-uppercase">Bulan</label>
      <select name="bulan" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold">
        <option value="">Semua Bulan</option>
        @for($i = 1; $i <= 12; $i++)
          <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->format('F') }}</option>
        @endfor
      </select>
    </div>
    <div class="col-lg-3">
      <label class="form-label small fw-800 text-muted text-uppercase">Tahun</label>
      <select name="tahun" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold">
        @for($i = 2024; $i <= 2026; $i++)
          <option value="{{ $i }}" {{ request('tahun', now()->year) == $i ? 'selected' : '' }}>Tahun {{ $i }}</option>
        @endfor
      </select>
    </div>
    <div class="col-lg-4">
      <label class="form-label small fw-800 text-muted text-uppercase">Status Kegiatan</label>
      <select name="status" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold">
        <option value="">Semua Status</option>
        <option value="terjadwal" {{ request('status') == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
        <option value="sedang_berlangsung" {{ request('status') == 'sedang_berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
      </select>
    </div>
    <div class="col-lg-2 d-flex align-items-end">
      <button type="submit" class="btn btn-primary w-100 rounded-4 py-3 fw-bold shadow-sm">
        <i class="fas fa-filter me-1"></i> Saring
      </button>
    </div>
  </form>
</div>

<!-- Activities Table -->
<div class="table-premium-container px-3">
  <div class="table-responsive">
    <table class="table-modern">
      <thead>
        <tr>
          <th>Tanggal & Waktu</th>
          <th style="width: 30%;">Fasilitas & Lokasi</th>
          <th>Tema Kegiatan</th>
          <th>Status</th>
          <th class="text-end">Opsi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($jadwal as $item)
        <tr>
          <td>
            <div class="d-flex align-items-center gap-3">
              <div class="posyandu-date-card">
                <span class="day">{{ \Carbon\Carbon::parse($item->tanggal)->format('d') }}</span>
                <span class="month">{{ \Carbon\Carbon::parse($item->tanggal)->format('M') }}</span>
              </div>
              <div>
                <div class="fw-800 text-dark mb-0">{{ \Carbon\Carbon::parse($item->tanggal)->format('l') }}</div>
                <div class="user-meta small">{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}</div>
              </div>
            </div>
          </td>
          <td>
            <div class="fw-bold text-dark">{{ $item->faskes->nama ?? 'Lokasi Umum' }}</div>
            <div class="location-info">
              <i class="fas fa-location-dot text-primary"></i>
              {{ Str::limit($item->lokasi, 40) }}
            </div>
          </td>
          <td>
            <div class="fw-800 text-primary mb-0 fs-6">{{ $item->tema ?? 'Layanan Rutin' }}</div>
            <div class="user-meta small">Penimbangan & Imunisasi</div>
          </td>
          <td>
            @php
              $status = $item->status;
              $statusClass = match($status) {
                'terjadwal' => 'status-terjadwal',
                'sedang_berlangsung' => 'status-berlangsung',
                'selesai' => 'status-selesai',
                'dibatalkan' => 'status-dibatalkan',
                default => ''
              };
            @endphp
            <span class="status-badge-premium {{ $statusClass }}">
              {{ ucfirst(str_replace('_', ' ', $status)) }}
            </span>
          </td>
          <td class="text-end">
            <div class="dropdown">
              <button class="btn btn-light btn-sm rounded-3 border px-3" data-bs-toggle="dropdown">
                Kelola <i class="fas fa-chevron-down ms-1 small"></i>
              </button>
              <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4">
                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('admin.posyandu.show', $item->id) }}"><i class="fas fa-eye me-2 text-primary"></i>Detail Agenda</a></li>
                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('admin.posyandu.absensi', $item->id) }}"><i class="fas fa-user-check me-2 text-success"></i>Absensi & Catatan</a></li>
                <li><hr class="dropdown-divider opacity-10"></li>
                <li>
                  <form action="{{ route('admin.posyandu.destroy', $item->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="dropdown-item rounded-3 py-2 text-danger btn-delete"><i class="fas fa-trash-alt me-2"></i>Hapus Agenda</button>
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
              <i class="fas fa-calendar-xmark fa-4x opacity-10 mb-3"></i>
              <h5 class="fw-800 text-dark">Belum Ada Agenda</h5>
              <p class="user-meta small">Jadwal kegiatan posyandu akan muncul di sini.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4 mb-5">
  {{ $jadwal->links('vendor.pagination.sigap-premium') }}
</div>
@endsection
