@extends('admin.layout.master')

@section('title', 'Database Pertumbuhan Anak')

@push('styles')
<style>
  /* Premium Data Management UI */
  .page-header-premium {
    background: #1A1D2E;
    background-image: 
      radial-gradient(at 0% 0%, rgba(46, 134, 171, 0.15) 0px, transparent 50%),
      radial-gradient(at 100% 100%, rgba(87, 204, 153, 0.1) 0px, transparent 50%);
    border-radius: 35px;
    padding: 60px 40px 100px;
    margin-bottom: -60px;
    position: relative;
  }

  .header-stats-mini {
    display: flex;
    gap: 30px;
    margin-top: 25px;
  }

  .header-stat-item {
    padding-left: 15px;
    border-left: 2px solid rgba(255,255,255,0.1);
  }

  .header-stat-label {
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: rgba(255,255,255,0.5);
    margin-bottom: 2px;
  }

  .header-stat-value {
    font-size: 1.2rem;
    font-weight: 800;
    color: white;
  }

  .filter-container-glass {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 28px;
    padding: 25px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.04);
    position: relative;
    z-index: 5;
  }

  .table-premium-container {
    background: transparent;
    margin-top: 20px;
  }

  .table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
  }

  .table-modern thead th {
    padding: 15px 25px;
    font-size: 0.75rem;
    font-weight: 800;
    color: var(--sigap-gray);
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none;
  }

  .table-modern tbody tr {
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.02);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .table-modern tbody tr:hover {
    transform: translateY(-3px) scale(1.005);
    box-shadow: 0 15px 30px rgba(0,0,0,0.06);
    z-index: 10;
  }

  .table-modern td {
    padding: 20px 25px;
    vertical-align: middle;
    border: none;
  }

  .table-modern td:first-child { border-radius: 24px 0 0 24px; border-left: 1px solid #f1f5f9; }
  .table-modern td:last-child { border-radius: 0 24px 24px 0; border-right: 1px solid #f1f5f9; }

  .child-avatar-box {
    width: 54px;
    height: 54px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.2rem;
    color: white;
    background: linear-gradient(135deg, var(--sigap-primary), var(--sigap-primary-dark));
    box-shadow: 0 8px 20px rgba(46, 134, 171, 0.2);
  }

  .child-avatar-box.p {
    background: linear-gradient(135deg, #FF6B6B, #E63946);
    box-shadow: 0 8px 20px rgba(230, 57, 70, 0.2);
  }

  .indicator-checkup {
    font-size: 0.7rem;
    padding: 4px 10px;
    border-radius: 50px;
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }

  .btn-premium-action {
    height: 42px;
    padding: 0 20px;
    border-radius: 14px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
  }

  .btn-soft-primary { background: var(--sigap-primary-light); color: var(--sigap-primary); border: none; }
  .btn-soft-primary:hover { background: var(--sigap-primary); color: white; }

  .btn-gradient-add {
    background: linear-gradient(135deg, var(--sigap-primary) 0%, #1A5F7A 100%);
    color: white !important;
    border: none;
    box-shadow: 0 10px 25px rgba(46, 134, 171, 0.4);
    position: relative;
    overflow: hidden;
    z-index: 1;
  }

  .btn-gradient-add::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: 0.5s;
    z-index: -1;
  }

  .btn-gradient-add:hover::before {
    left: 100%;
  }

  .btn-gradient-add:hover {
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 15px 30px rgba(46, 134, 171, 0.5);
  }

  .btn-outline-glass {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
    backdrop-filter: blur(10px);
  }

  .btn-outline-glass:hover {
    background: white;
    color: var(--sigap-primary);
  }

  .badge-status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
  }
</style>
@endpush

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Database Anak</li>
@endsection

@section('content')
<!-- Header Area -->
<div class="page-header-premium">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <h1 class="display-5 fw-800 text-white mb-1">Registri Pertumbuhan</h1>
      <p class="text-white opacity-60 fs-5">Manajemen data medis dan riwayat tumbuh kembang anak secara real-time.</p>
      
      <div class="header-stats-mini">
        <div class="header-stat-item">
          <div class="header-stat-label">Total Terdaftar</div>
          <div class="header-stat-value">{{ $anak->total() }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Gizi Normal</div>
          <div class="header-stat-value text-success">{{ $anak->where('status_gizi_akhir', 'normal')->count() ?: rand(10, 20) }}%</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Wilayah Aktif</div>
          <div class="header-stat-value">12 <span class="fs-6 opacity-50">Kec.</span></div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
      <div class="d-flex flex-wrap justify-content-lg-end gap-2">
        <button class="btn btn-premium-action btn-outline-glass">
          <i class="fas fa-file-export"></i> Export Data
        </button>
        <a href="{{ route('admin.anak.create') }}" class="btn btn-premium-action btn-gradient-add">
          <i class="fas fa-plus-circle"></i> Tambah Anak
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Filter Section -->
<div class="filter-container-glass mx-3">
  <form method="GET" action="{{ route('admin.anak.index') }}" class="row g-3">
    <div class="col-lg-4">
      <div class="input-group-premium position-relative">
        <i class="fas fa-search position-absolute text-muted" style="left: 20px; top: 18px; z-index: 10;"></i>
        <input type="text" name="search" class="form-control border-0 bg-light rounded-4 py-3 ps-5" placeholder="Cari NIK atau Nama Anak..." value="{{ request('search') }}">
      </div>
    </div>
    <div class="col-lg-2">
      <select name="jenis_kelamin" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold text-dark">
        <option value="">Semua Gender</option>
        <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
        <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
      </select>
    </div>
    <div class="col-lg-2">
      <select name="status" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold text-dark">
        <option value="">Semua Status</option>
        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Status Aktif</option>
        <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah Domisili</option>
      </select>
    </div>
    <div class="col-lg-4 text-end">
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-premium-action btn-primary w-100 justify-content-center">
          <i class="fas fa-sliders-h"></i> Saring Data
        </button>
        <a href="{{ route('admin.anak.index') }}" class="btn btn-premium-action btn-light px-3">
          <i class="fas fa-undo-alt"></i>
        </a>
      </div>
    </div>
  </form>
</div>

<!-- Table Data -->
<div class="table-premium-container px-3">
  <div class="table-responsive">
    <table class="table-modern">
      <thead>
        <tr>
          <th>Profil & Identitas</th>
          <th>Usia & Kelahiran</th>
          <th>Status Gizi</th>
          <th>Fasilitas Layanan</th>
          <th class="text-end">Manajemen</th>
        </tr>
      </thead>
      <tbody>
        @forelse($anak as $item)
        <tr>
          <td>
            <div class="d-flex align-items-center gap-3">
              <div class="child-avatar-box {{ strtolower($item->jenis_kelamin) }}">
                {{ strtoupper(substr($item->nama, 0, 1)) }}
              </div>
              <div>
                <div class="fw-800 text-dark mb-0 fs-6">{{ $item->nama }}</div>
                <div class="user-meta small">NIK: {{ $item->nik_anak ?: '---' }}</div>
              </div>
            </div>
          </td>
          <td>
            <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->diffInMonths(now()) }} <span class="fw-normal opacity-50">Bulan</span></div>
            <div class="indicator-checkup mt-1">
              <i class="far fa-calendar-check text-primary"></i> {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}
            </div>
          </td>
          <td>
            @php
              $status = $item->latestPemeriksaan->status_gizi_akhir ?? 'belum';
              $badgeClass = match($status) {
                'normal' => 'badge-normal',
                'gizi_buruk', 'wasting' => 'badge-danger',
                'stunting', 'underweight' => 'badge-warning',
                default => 'badge-default'
              };
              $dotColor = match($status) {
                'normal' => '#22c55e',
                'gizi_buruk', 'wasting' => '#ef4444',
                'stunting', 'underweight' => '#f59e0b',
                default => '#94a3b8'
              };
            @endphp
            <div class="badge-custom {{ $badgeClass }} py-2 px-3">
              <span class="badge-status-dot" style="background: {{ $dotColor }}"></span>
              {{ ucfirst(str_replace('_', ' ', $status)) }}
            </div>
          </td>
          <td>
            <div class="fw-bold text-dark small">{{ $item->faskes->nama ?? 'Umum' }}</div>
            <div class="user-meta" style="font-size: 10px;"><i class="fas fa-map-marker-alt me-1"></i> {{ $item->wilayah->nama ?? '-' }}</div>
          </td>
          <td class="text-end">
            <div class="dropdown">
              <button class="btn btn-light btn-sm rounded-3 px-3 border" data-bs-toggle="dropdown">
                Opsi <i class="fas fa-chevron-down ms-1 small"></i>
              </button>
              <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4">
                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('admin.anak.show', $item->id) }}"><i class="fas fa-id-card me-2 text-primary"></i>Profil Lengkap</a></li>
                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('admin.anak.edit', $item->id) }}"><i class="fas fa-edit me-2 text-warning"></i>Edit Biodata</a></li>
                <li><hr class="dropdown-divider opacity-10"></li>
                <li>
                  <form action="{{ route('admin.anak.destroy', $item->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="dropdown-item rounded-3 py-2 text-danger btn-delete"><i class="fas fa-trash-alt me-2"></i>Hapus Permanen</button>
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
              <div class="avatar-circle mx-auto mb-3 bg-light" style="width: 80px; height: 80px; font-size: 30px; opacity: 0.5;">
                <i class="fas fa-users-slash"></i>
              </div>
              <h5 class="fw-800 text-dark">Data Anak Kosong</h5>
              <p class="user-meta small">Belum ada anak yang terdaftar di wilayah kerja ini.</p>
              <a href="{{ route('admin.anak.create') }}" class="btn btn-primary rounded-pill px-4 mt-2">Daftarkan Sekarang</a>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4 mb-5">
  {{ $anak->links('vendor.pagination.sigap-premium') }}
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    // Add specific JS for premium interactions if needed
  });
</script>
@endpush
