@extends('admin.layout.master')

@section('title', 'Dashboard')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css">
<style>
  :root {
    --primary: #0ea5e9;
    --primary-dark: #0284c7;
    --primary-light: #e0f2fe;
    --dark: #0f172a;
    --dark-secondary: #1e293b;
    --gray-500: #64748b;
    --gray-400: #94a3b8;
    --gray-100: #f1f5f9;
    --white: #ffffff;
    --success: #22c55e;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #06b6d4;
  }

  * {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  .welcome-hero {
    background: var(--primary);
    border-radius: 24px;
    padding: 36px 40px;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 28px;
  }

  .welcome-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 350px;
    height: 350px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
  }

  .welcome-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -5%;
    width: 250px;
    height: 250px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
  }

  .welcome-content {
    position: relative;
    z-index: 2;
  }

  .welcome-title {
    font-size: 1.75rem;
    font-weight: 800;
    margin-bottom: 6px;
  }

  .welcome-subtitle {
    font-size: 1rem;
    opacity: 0.9;
    font-weight: 400;
  }

  .date-card {
    background: var(--white);
    border-radius: 16px;
    padding: 20px 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
  }

  .date-icon {
    width: 52px;
    height: 52px;
    background: var(--primary-light);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 22px;
  }

  .date-label {
    font-size: 0.85rem;
    color: var(--gray-500);
    font-weight: 500;
    margin-bottom: 2px;
  }

  .date-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 28px;
  }

  .stat-card {
    background: var(--white);
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--stat-color);
  }

  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1);
  }

  .stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 16px;
    background: var(--stat-bg);
    color: var(--stat-color);
  }

  .stat-number {
    font-size: 2.25rem;
    font-weight: 800;
    color: var(--dark);
    line-height: 1;
    margin-bottom: 4px;
  }

  .stat-label {
    font-size: 0.85rem;
    color: var(--gray-500);
    font-weight: 500;
  }

  .content-card {
    background: var(--white);
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    margin-bottom: 24px;
  }

  .card-header-custom {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .card-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
  }

  .card-title i {
    color: var(--primary);
  }

  .card-body-custom {
    padding: 24px;
  }

  .chart-container {
    height: 260px;
    position: relative;
  }

  .chart-legend {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-top: 20px;
  }

  .legend-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: var(--gray-100);
    border-radius: 12px;
    transition: all 0.2s ease;
  }

  .legend-item:hover {
    background: #e2e8f0;
  }

  .legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 4px;
    flex-shrink: 0;
  }

  .legend-text {
    flex: 1;
    font-size: 0.85rem;
    color: var(--gray-500);
    font-weight: 500;
  }

  .legend-count {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--dark);
  }

  .schedule-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .schedule-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: var(--gray-100);
    border-radius: 14px;
    transition: all 0.2s ease;
  }

  .schedule-item:hover {
    background: #e2e8f0;
  }

  .schedule-date {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
  }

  .schedule-day {
    font-size: 1.35rem;
    font-weight: 800;
    line-height: 1;
  }

  .schedule-month {
    font-size: 0.7rem;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
  }

  .schedule-info {
    flex: 1;
  }

  .schedule-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 4px;
  }

  .schedule-meta {
    font-size: 0.8rem;
    color: var(--gray-500);
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .schedule-status {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .table-custom {
    width: 100%;
  }

  .table-custom th {
    padding: 14px 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gray-500);
    background: var(--gray-100);
    border: none;
  }

  .table-custom td {
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
  }

  .table-custom tbody tr {
    transition: all 0.2s ease;
  }

  .table-custom tbody tr:hover {
    background: var(--gray-100);
  }

  .table-custom tbody tr:last-child td {
    border-bottom: none;
  }

  .user-cell {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .user-avatar {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: white;
    font-size: 16px;
  }

  .avatar-blue { background: var(--primary); }
  .avatar-pink { background: #ec4899; }

  .user-name {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9rem;
  }

  .user-meta {
    font-size: 0.8rem;
    color: var(--gray-500);
  }

  .badge-custom {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }

  .badge-normal { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
  .badge-danger { background: rgba(239, 68, 68, 0.1); color: #dc2626; }
  .badge-warning { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .badge-info { background: rgba(6, 182, 212, 0.1); color: #0891b2; }
  .badge-default { background: var(--gray-100); color: var(--gray-500); }

  .btn-action {
    padding: 8px 14px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-primary-action {
    background: var(--primary);
    color: white;
  }

  .btn-primary-action:hover {
    background: var(--primary-dark);
    color: white;
  }

  .btn-outline-action {
    background: var(--gray-100);
    color: var(--gray-500);
  }

  .btn-outline-action:hover {
    background: var(--primary-light);
    color: var(--primary);
  }

  .empty-state {
    text-align: center;
    padding: 48px 24px;
  }

  .empty-icon {
    width: 80px;
    height: 80px;
    background: var(--gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
  }

  .empty-icon i {
    font-size: 32px;
    color: var(--gray-400);
  }

  .empty-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 4px;
  }

  .empty-text {
    font-size: 0.85rem;
    color: var(--gray-500);
    margin-bottom: 16px;
  }

  .safe-state {
    text-align: center;
    padding: 32px 24px;
  }

  .safe-icon {
    width: 70px;
    height: 70px;
    background: rgba(34, 197, 94, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
  }

  .safe-icon i {
    font-size: 28px;
    color: var(--success);
  }

  .safe-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--success);
    margin-bottom: 4px;
  }

  .safe-text {
    font-size: 0.85rem;
    color: var(--gray-500);
  }

  .measurement-badges {
    display: flex;
    gap: 6px;
  }

  .measure-badge {
    padding: 4px 10px;
    background: var(--gray-100);
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--gray-500);
  }

  .risk-indicator {
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .risk-high {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
  }

  .risk-medium {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
  }

  @media (max-width: 1200px) {
    .stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 768px) {
    .welcome-hero {
      padding: 28px;
      text-align: center;
    }

    .welcome-title {
      font-size: 1.5rem;
    }

    .stats-grid {
      grid-template-columns: 1fr;
    }

    .card-header-custom {
      flex-direction: column;
      gap: 12px;
      align-items: flex-start;
    }

    .chart-legend {
      grid-template-columns: 1fr;
    }

    .table-custom {
      font-size: 0.85rem;
    }

    .table-custom th,
    .table-custom td {
      padding: 12px;
    }
  }
</style>
@endsection

@section('content')
<div class="welcome-hero">
  <div class="welcome-content">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="welcome-title">
          <i class="fas fa-hand-sparkles me-2"></i>Selamat Datang, {{ auth()->user()->name }}!
        </h1>
        <p class="welcome-subtitle">Pantau kesehatan dan pertumbuhan anak dengan lebih mudah</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <div class="date-card" style="display: inline-flex; background: rgba(255,255,255,0.15); border: none;">
          <div>
            <div class="date-label" style="color: rgba(255,255,255,0.8);">Hari Ini</div>
            <div class="date-value" style="color: white;">{{ now()->format('l, d M Y') }}</div>
          </div>
          <div class="date-icon" style="background: rgba(255,255,255,0.2); color: white;">
            <i class="fas fa-calendar"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card" style="--stat-color: #0ea5e9; --stat-bg: rgba(14, 165, 233, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-children"></i>
    </div>
    <div class="stat-number">{{ $totalAnak }}</div>
    <div class="stat-label">Total Anak</div>
  </div>
  <div class="stat-card" style="--stat-color: #22c55e; --stat-bg: rgba(34, 197, 94, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-stethoscope"></i>
    </div>
    <div class="stat-number">{{ $pemeriksaanHariIni }}</div>
    <div class="stat-label">Pemeriksaan Hari Ini</div>
  </div>
  <div class="stat-card" style="--stat-color: #f59e0b; --stat-bg: rgba(245, 158, 11, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-calendar-check"></i>
    </div>
    <div class="stat-number">{{ $pemeriksaanBulanIni }}</div>
    <div class="stat-label">Pemeriksaan Bulan Ini</div>
  </div>
  <div class="stat-card" style="--stat-color: #ef4444; --stat-bg: rgba(239, 68, 68, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-comments"></i>
    </div>
    <div class="stat-number">{{ $konsultasiPending }}</div>
    <div class="stat-label">Konsultasi Pending</div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-4">
    <div class="content-card">
      <div class="card-header-custom">
        <h5 class="card-title">
          <i class="fas fa-chart-pie"></i>
          Status Gizi
        </h5>
      </div>
      <div class="card-body-custom">
        <div class="chart-container">
          <canvas id="statusGiziChart"></canvas>
        </div>
        <div class="chart-legend">
          @forelse($statusGizi as $status => $jumlah)
            @if($jumlah > 0)
            <div class="legend-item">
              <div class="legend-dot" style="background: @if($status == 'normal') #22c55e @elseif($status == 'gizi_buruk' || $status == 'wasting') #ef4444 @elseif($status == 'stunting' || $status == 'underweight') #f59e0b @else #06b6d4 @endif;"></div>
              <span class="legend-text">{{ ucfirst($status) }}</span>
              <span class="legend-count">{{ $jumlah }}</span>
            </div>
            @endif
          @empty
          <p class="text-muted text-center w-100">Belum ada data</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="content-card">
      <div class="card-header-custom">
        <h5 class="card-title">
          <i class="fas fa-calendar-days"></i>
          Jadwal Posyandu Mendatang
        </h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.posyandu.create') }}" class="btn-action btn-primary-action">
            <i class="fas fa-plus"></i> Baru
          </a>
          <a href="{{ route('admin.posyandu.index') }}" class="btn-action btn-outline-action">
            Semua <i class="fas fa-angle-right"></i>
          </a>
        </div>
      </div>
      <div class="card-body-custom" style="padding-top: 16px;">
        @if($jadwalMendatang->count() > 0)
        <div class="schedule-list">
          @foreach($jadwalMendatang->take(4) as $jadwal)
          <div class="schedule-item">
            <div class="schedule-date" style="background: @if($jadwal->status == 'terjadwal') #0ea5e9 @elseif($jadwal->status == 'sedang_berlangsung') #22c55e @else #64748b @endif;">
              <span class="schedule-day">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d') }}</span>
              <span class="schedule-month">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('M') }}</span>
            </div>
            <div class="schedule-info">
              <div class="schedule-title">{{ $jadwal->tema ?? 'Posyandu' }}</div>
              <div class="schedule-meta">
                <span><i class="fas fa-hospital me-1"></i>{{ $jadwal->faskes->nama ?? '-' }}</span>
                <span><i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
              </div>
            </div>
            <span class="schedule-status" style="background: @if($jadwal->status == 'terjadwal') rgba(14, 165, 233, 0.1) @elseif($jadwal->status == 'sedang_berlangsung') rgba(34, 197, 94, 0.1) @else rgba(100, 116, 139, 0.1) @endif; color: @if($jadwal->status == 'terjadwal') #0ea5e9 @elseif($jadwal->status == 'sedang_berlangsung') #22c55e @else #64748b @endif;">
              {{ ucfirst(str_replace('_', ' ', $jadwal->status)) }}
            </span>
          </div>
          @endforeach
        </div>
        @else
        <div class="empty-state">
          <div class="empty-icon">
            <i class="fas fa-calendar-xmark"></i>
          </div>
          <div class="empty-title">Belum Ada Jadwal</div>
          <div class="empty-text">Buat jadwal posyandu pertama Anda</div>
          <a href="{{ route('admin.posyandu.create') }}" class="btn-action btn-primary-action">
            <i class="fas fa-plus"></i> Buat Jadwal
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-6">
    <div class="content-card">
      <div class="card-header-custom">
        <h5 class="card-title">
          <i class="fas fa-clipboard-check"></i>
          Pemeriksaan Terbaru
        </h5>
        <a href="{{ route('admin.pemeriksaan.index') }}" class="btn-action btn-outline-action">
          Semua <i class="fas fa-angle-right"></i>
        </a>
      </div>
      <div style="overflow-x: auto;">
        @if($pemeriksaanTerbaru->count() > 0)
        <table class="table-custom">
          <thead>
            <tr>
              <th>Anak</th>
              <th>Ukuran</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pemeriksaanTerbaru->take(5) as $p)
            <tr>
              <td>
                <div class="user-cell">
                  <div class="user-avatar avatar-{{ $p->anak->jenis_kelamin == 'L' ? 'blue' : 'pink' }}">
                    {{ strtoupper(substr($p->anak->nama ?? 'A', 0, 1)) }}
                  </div>
                  <div>
                    <div class="user-name">{{ $p->anak->nama ?? '-' }}</div>
                    <div class="user-meta">{{ \Carbon\Carbon::parse($p->tanggal_periksa)->format('d M Y') }}</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="measurement-badges">
                  <span class="measure-badge"><i class="fas fa-weight-hanging me-1"></i>{{ $p->berat_badan ?? 0 }}kg</span>
                  <span class="measure-badge"><i class="fas fa-ruler me-1"></i>{{ $p->tinggi_badan ?? 0 }}cm</span>
                </div>
              </td>
              <td>
                @if($p->status_gizi_akhir)
                <span class="badge-custom @if($p->status_gizi_akhir == 'normal') badge-normal @elseif($p->status_gizi_akhir == 'gizi_buruk' || $p->status_gizi_akhir == 'wasting') badge-danger @elseif($p->status_gizi_akhir == 'stunting' || $p->status_gizi_akhir == 'underweight') badge-warning @else badge-info @endif">
                  <i class="fas @if($p->status_gizi_akhir == 'normal') fa-check @elseif($p->status_gizi_akhir == 'gizi_buruk' || $p->status_gizi_akhir == 'wasting') fa-triangle-exclamation @else fa-minus @endif"></i>
                  {{ ucfirst(str_replace('_', ' ', $p->status_gizi_akhir)) }}
                </span>
                @else
                <span class="badge-custom badge-default">Belum</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="empty-state">
          <div class="empty-icon">
            <i class="fas fa-clipboard-list"></i>
          </div>
          <div class="empty-title">Belum Ada Pemeriksaan</div>
          <div class="empty-text">Pemeriksaan akan muncul di sini</div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="content-card">
      <div class="card-header-custom">
        <h5 class="card-title">
          <i class="fas fa-exclamation-triangle"></i>
          Anak Berisiko
        </h5>
        <a href="{{ route('admin.anak.index') }}" class="btn-action btn-outline-action">
          Semua <i class="fas fa-angle-right"></i>
        </a>
      </div>
      <div style="overflow-x: auto;">
        @if($anakBerisiko->count() > 0)
        <table class="table-custom">
          <thead>
            <tr>
              <th>Anak</th>
              <th>BB Terakhir</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($anakBerisiko->take(5) as $anak)
            <tr>
              <td>
                <div class="user-cell">
                  <div class="user-avatar avatar-{{ $anak->jenis_kelamin == 'L' ? 'blue' : 'pink' }}">
                    {{ strtoupper(substr($anak->nama ?? 'A', 0, 1)) }}
                  </div>
                  <div>
                    <div class="user-name">{{ $anak->nama ?? '-' }}</div>
                    <div class="user-meta">{{ $anak->usia_bulan ?? 0 }} bulan</div>
                  </div>
                </div>
              </td>
              <td>
                @if($anak->latestPemeriksaan)
                <span class="measure-badge">{{ $anak->latestPemeriksaan->berat_badan ?? 0 }} kg</span>
                @else
                <span class="measure-badge">-</span>
                @endif
              </td>
              <td>
                @if($anak->latestPemeriksaan && $anak->latestPemeriksaan->status_gizi_akhir)
                <span class="risk-indicator @if($anak->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $anak->latestPemeriksaan->status_gizi_akhir == 'wasting') risk-high @else risk-medium @endif">
                  {{ ucfirst(str_replace('_', ' ', $anak->latestPemeriksaan->status_gizi_akhir)) }}
                </span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="safe-state">
          <div class="safe-icon">
            <i class="fas fa-shield-heart"></i>
          </div>
          <div class="safe-title">Semua Aman!</div>
          <div class="safe-text">Tidak ada anak berisiko tinggi</div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
  const statusGiziData = {!! json_encode($statusGizi) !!};
  
  const ctx = document.getElementById('statusGiziChart').getContext('2d');
  
  const labels = Object.keys(statusGiziData).map(key => key.charAt(0).toUpperCase() + key.slice(1).replace('_', ' '));
  const data = Object.values(statusGiziData);
  const colors = Object.keys(statusGiziData).map(key => {
    if (key === 'normal') return '#22c55e';
    if (key === 'gizi_buruk' || key === 'wasting') return '#ef4444';
    if (key === 'stunting' || key === 'underweight') return '#f59e0b';
    return '#06b6d4';
  });

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: colors,
        borderWidth: 0,
        hoverOffset: 8
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '65%',
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          backgroundColor: '#0f172a',
          titleFont: {
            family: "'Plus Jakarta Sans', sans-serif",
            size: 13,
            weight: '600'
          },
          bodyFont: {
            family: "'Plus Jakarta Sans', sans-serif",
            size: 12
          },
          padding: 12,
          cornerRadius: 10,
          displayColors: true,
          boxPadding: 6
        }
      },
      animation: {
        animateRotate: true,
        animateScale: true
      }
    }
  });
</script>
@endsection
