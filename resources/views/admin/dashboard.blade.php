@extends('admin.layout.master')

@section('title', 'Dashboard')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="dashboard-container">
  <div class="welcome-section mb-4">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <div class="welcome-card bg-gradient-primary text-white p-4 rounded-4 shadow-sm">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h2 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name }}!</h2>
              <p class="mb-0 opacity-75">Pantau kesehatan anak dengan mudah melalui dashboard ini</p>
            </div>
            <div class="d-none d-md-block">
              <div class="welcome-icon bg-white bg-opacity-25 rounded-circle p-4">
                <i class="fas fa-baby fa-3x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center justify-content-between">
            <div>
              <p class="text-muted small mb-1">Hari Ini</p>
              <h4 class="mb-0 fw-bold">{{ now()->format('l, d M Y') }}</h4>
            </div>
            <div class="bg-primary bg-opacity-10 rounded p-3">
              <i class="fas fa-calendar text-primary fs-4"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="stats-section mb-4">
    <div class="row g-3">
      <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 stats-card stats-card-primary">
          <div class="card-body p-3">
            <div class="d-flex align-items-center">
              <div class="stats-icon bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                <i class="fas fa-child text-primary fs-4"></i>
              </div>
              <div>
                <p class="text-muted small mb-0">Total Anak</p>
                <h3 class="mb-0 fw-bold">{{ $totalAnak }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 stats-card stats-card-success">
          <div class="card-body p-3">
            <div class="d-flex align-items-center">
              <div class="stats-icon bg-success bg-opacity-10 rounded-3 p-3 me-3">
                <i class="fas fa-stethoscope text-success fs-4"></i>
              </div>
              <div>
                <p class="text-muted small mb-0">Hari Ini</p>
                <h3 class="mb-0 fw-bold">{{ $pemeriksaanHariIni }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 stats-card stats-card-warning">
          <div class="card-body p-3">
            <div class="d-flex align-items-center">
              <div class="stats-icon bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                <i class="fas fa-calendar-check text-warning fs-4"></i>
              </div>
              <div>
                <p class="text-muted small mb-0">Bulan Ini</p>
                <h3 class="mb-0 fw-bold">{{ $pemeriksaanBulanIni }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 stats-card stats-card-danger">
          <div class="card-body p-3">
            <div class="d-flex align-items-center">
              <div class="stats-icon bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                <i class="fas fa-comments text-danger fs-4"></i>
              </div>
              <div>
                <p class="text-muted small mb-0">Pending</p>
                <h3 class="mb-0 fw-bold">{{ $konsultasiPending }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0 py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
              <i class="fas fa-chart-pie text-primary me-2"></i>Status Gizi
            </h5>
          </div>
        </div>
        <div class="card-body">
          <div class="chart-container mb-3" style="height: 200px;">
            <canvas id="statusGiziChart"></canvas>
          </div>
          <div class="status-legend">
            @forelse($statusGizi as $status => $jumlah)
              @if($jumlah > 0)
              <div class="legend-item">
                <span class="legend-dot bg-{{ 
                  $status == 'normal' ? 'success' : 
                  ($status == 'gizi_buruk' || $status == 'wasting' ? 'danger' : 
                  ($status == 'stunting' || $status == 'underweight' ? 'warning' : 'info'))
                }}"></span>
                <span class="legend-label">{{ ucfirst($status) }}</span>
                <span class="legend-value">{{ $jumlah }}</span>
              </div>
              @endif
            @empty
            <p class="text-muted text-center">Belum ada data</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0 py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
              <i class="fas fa-calendar-alt text-success me-2"></i>Jadwal Posyandu Mendatang
            </h5>
            <div>
              <a href="{{ route('admin.posyandu.create') }}" class="btn btn-sm btn-success me-2">
                <i class="fas fa-plus"></i>
              </a>
              <a href="{{ route('admin.posyandu.index') }}" class="btn btn-sm btn-outline-primary">
                Semua <i class="fas fa-angle-right ms-1"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          @if($jadwalMendatang->count() > 0)
            <div class="schedule-timeline">
              @foreach($jadwalMendatang->take(4) as $jadwal)
              <div class="schedule-item">
                <div class="schedule-date">
                  <div class="date-box bg-{{ $jadwal->status == 'terjadwal' ? 'primary' : ($jadwal->status == 'sedang_berlangsung' ? 'success' : 'secondary') }}">
                    <span class="date-day">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d') }}</span>
                    <span class="date-month">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('M') }}</span>
                  </div>
                </div>
                <div class="schedule-content">
                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      <h6 class="mb-1 fw-semibold">{{ $jadwal->tema ?? 'Posyandu' }}</h6>
                      <p class="mb-0 text-muted small">
                        <i class="fas fa-hospital me-1"></i>{{ $jadwal->faskes->nama ?? '-' }}
                        <span class="mx-2">•</span>
                        <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                      </p>
                    </div>
                    <span class="badge bg-{{ $jadwal->status == 'terjadwal' ? 'primary' : ($jadwal->status == 'sedang_berlangsung' ? 'success' : 'secondary') }}">
                      {{ ucfirst(str_replace('_', ' ', $jadwal->status)) }}
                    </span>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          @else
            <div class="empty-state text-center py-5">
              <div class="empty-icon bg-light rounded-circle mx-auto mb-3">
                <i class="fas fa-calendar-times text-muted fs-3"></i>
              </div>
              <h6 class="text-muted">Belum ada jadwal</h6>
              <a href="{{ route('admin.posyandu.create') }}" class="btn btn-primary btn-sm mt-2">
                <i class="fas fa-plus me-1"></i> Buat Jadwal
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-md-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
              <i class="fas fa-clipboard-check text-info me-2"></i>Pemeriksaan Terbaru
            </h5>
            <a href="{{ route('admin.pemeriksaan.index') }}" class="btn btn-sm btn-outline-primary">
              Semua <i class="fas fa-angle-right ms-1"></i>
            </a>
          </div>
        </div>
        <div class="card-body p-0">
          @if($pemeriksaanTerbaru->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th class="ps-4">Anak</th>
                  <th>Ukuran</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pemeriksaanTerbaru->take(5) as $p)
                <tr>
                  <td class="ps-4">
                    <div class="d-flex align-items-center">
                      <div class="avatar-circle bg-{{ $p->anak->jenis_kelamin == 'L' ? 'primary' : 'info' }} text-white me-2">{{ substr($p->anak->nama ?? 'A', 0, 1) }}</div>
                      <div>
                        <div class="fw-medium">{{ $p->anak->nama ?? '-' }}</div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal_periksa)->format('d M Y') }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex gap-2">
                      <span class="badge bg-light text-dark"><i class="fas fa-weight me-1"></i>{{ $p->berat_badan }}kg</span>
                      <span class="badge bg-light text-dark"><i class="fas fa-ruler-vertical me-1"></i>{{ $p->tinggi_badan }}cm</span>
                    </div>
                  </td>
                  <td>
                    @if($p->status_gizi_akhir)
                    <span class="badge bg-{{ 
                      $p->status_gizi_akhir == 'normal' ? 'success' : 
                      ($p->status_gizi_akhir == 'gizi_buruk' || $p->status_gizi_akhir == 'wasting' ? 'danger' : 
                      ($p->status_gizi_akhir == 'stunting' || $p->status_gizi_akhir == 'underweight' ? 'warning' : 'primary'))
                    }}">
                      {{ ucfirst(str_replace('_', ' ', $p->status_gizi_akhir)) }}
                    </span>
                    @else
                    <span class="badge bg-secondary">Belum</span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <div class="empty-state text-center py-4">
            <i class="fas fa-clipboard-list text-muted fs-2 mb-2 d-block"></i>
            <p class="text-muted mb-0">Belum ada pemeriksaan</p>
          </div>
          @endif
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
              <i class="fas fa-exclamation-triangle text-warning me-2"></i>Anak Berisiko
            </h5>
            <a href="{{ route('admin.anak.index') }}" class="btn btn-sm btn-outline-primary">
              Semua <i class="fas fa-angle-right ms-1"></i>
            </a>
          </div>
        </div>
        <div class="card-body p-0">
          @if($anakBerisiko->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th class="ps-4">Anak</th>
                  <th>Info</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($anakBerisiko->take(5) as $anak)
                <tr>
                  <td class="ps-4">
                    <div class="d-flex align-items-center">
                      <div class="avatar-circle bg-{{ $anak->jenis_kelamin == 'L' ? 'primary' : 'info' }} text-white me-2">{{ substr($anak->nama ?? 'A', 0, 1) }}</div>
                      <div>
                        <div class="fw-medium">{{ $anak->nama ?? '-' }}</div>
                        <small class="text-muted">{{ $anak->usia_bulan ?? 0 }} bulan</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    @if($anak->latestPemeriksaan)
                    <span class="text-muted small">
                      BB: {{ $anak->latestPemeriksaan->berat_badan }}kg
                    </span>
                    @else
                    <span class="text-muted small">-</span>
                    @endif
                  </td>
                  <td>
                    @if($anak->latestPemeriksaan)
                    <span class="badge bg-{{ 
                      $anak->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $anak->latestPemeriksaan->status_gizi_akhir == 'wasting' ? 'danger' : 'warning'
                    }}">
                      {{ ucfirst(str_replace('_', ' ', $anak->latestPemeriksaan->status_gizi_akhir)) }}
                    </span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <div class="empty-state text-center py-5">
            <div class="empty-icon bg-success bg-opacity-10 rounded-circle mx-auto mb-3">
              <i class="fas fa-check-circle text-success fs-3"></i>
            </div>
            <h6 class="text-success mb-1">Semua Aman!</h6>
            <p class="text-muted small mb-0">Tidak ada anak berisiko tinggi</p>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.bg-gradient-primary {
  background: linear-gradient(135deg, #2E86AB 0%, #1A5F7A 100%);
}

.stats-card {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.stats-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.stats-icon {
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.schedule-timeline {
  padding: 0 1rem;
}

.schedule-item {
  display: flex;
  padding: 1rem 0;
  border-bottom: 1px solid #f0f0f0;
}

.schedule-item:last-child {
  border-bottom: none;
}

.date-box {
  width: 55px;
  height: 55px;
  border-radius: 12px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: white;
}

.date-day {
  font-size: 18px;
  font-weight: 700;
  line-height: 1;
}

.date-month {
  font-size: 11px;
  text-transform: uppercase;
}

.schedule-content {
  flex: 1;
  padding-left: 1rem;
}

.empty-state {
  padding: 2rem;
}

.empty-icon {
  width: 70px;
  height: 70px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.status-legend {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.legend-item {
  display: flex;
  align-items: center;
  padding: 6px 10px;
  background: #f8f9fa;
  border-radius: 8px;
}

.legend-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  margin-right: 10px;
}

.legend-label {
  flex: 1;
  font-size: 13px;
  color: #495057;
}

.legend-value {
  font-weight: 600;
  font-size: 14px;
}
</style>
@endsection

@section('scripts')
<script>
  const statusGiziData = {!! json_encode($statusGizi) !!};
  initDashboardCharts(statusGiziData);
</script>
@endsection
