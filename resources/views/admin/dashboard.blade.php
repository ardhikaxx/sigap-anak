@extends('admin.layout.master')

@section('title', 'Dashboard')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h1 class="page-title">Dashboard</h1>
      <p class="page-subtitle">Selamat datang kembali, {{ auth()->user()->name }}</p>
    </div>
    <div class="d-flex gap-2">
      <span class="badge bg-primary fs-6 py-2 px-3">
        <i class="fas fa-calendar me-2"></i>{{ now()->format('d M Y') }}
      </span>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-md-6 col-xl-3">
    <div class="stat-card h-100">
      <div class="stat-card-icon" style="background: linear-gradient(135deg, #2E86AB 0%, #1A5F7A 100%);">
        <i class="fas fa-child text-white"></i>
      </div>
      <div class="stat-card-body">
        <p class="stat-label">Total Anak Terdaftar</p>
        <h3 class="stat-value">{{ $totalAnak }}</h3>
        <div class="stat-trend up">
          <i class="fas fa-arrow-up"></i> Aktif
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="stat-card h-100">
      <div class="stat-card-icon" style="background: linear-gradient(135deg, #57CC99 0%, #38A169 100%);">
        <i class="fas fa-stethoscope text-white"></i>
      </div>
      <div class="stat-card-body">
        <p class="stat-label">Pemeriksaan Hari Ini</p>
        <h3 class="stat-value">{{ $pemeriksaanHariIni }}</h3>
        <div class="stat-trend">
          <i class="fas fa-clock me-1"></i> Hari ini
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="stat-card h-100">
      <div class="stat-card-icon" style="background: linear-gradient(135deg, #FFB347 0%, #E67E22 100%);">
        <i class="fas fa-calendar-check text-white"></i>
      </div>
      <div class="stat-card-body">
        <p class="stat-label">Pemeriksaan Bulan Ini</p>
        <h3 class="stat-value">{{ $pemeriksaanBulanIni }}</h3>
        <div class="stat-trend">
          <i class="fas fa-calendar me-1"></i> {{ now()->format('F') }}
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="stat-card h-100">
      <div class="stat-card-icon" style="background: linear-gradient(135deg, #FF6B6B 0%, #C0392B 100%);">
        <i class="fas fa-comments text-white"></i>
      </div>
      <div class="stat-card-body">
        <p class="stat-label">Konsultasi Pending</p>
        <h3 class="stat-value">{{ $konsultasiPending }}</h3>
        <div class="stat-trend down">
          <i class="fas fa-exclamation-circle"></i> Menunggu
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header bg-white border-0 pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-chart-pie text-primary me-2"></i>Distribusi Status Gizi
          </h5>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-container" style="height: 220px;">
          <canvas id="statusGiziChart"></canvas>
        </div>
        <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
          @foreach($statusGizi as $status => $jumlah)
            @if($jumlah > 0)
            <span class="badge bg-{{ 
              $status == 'normal' ? 'success' : 
              ($status == 'gizi_buruk' || $status == 'wasting' ? 'danger' : 
              ($status == 'stunting' || $status == 'underweight' ? 'warning' : 'info'))
            }}">
              {{ ucfirst($status) }}: {{ $jumlah }}
            </span>
            @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header bg-white border-0 pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-calendar-alt text-success me-2"></i>Jadwal Posyandu Mendatang
          </h5>
          <a href="{{ route('admin.posyandu.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        @if($jadwalMendatang->count() > 0)
          <div class="list-group list-group-flush">
            @foreach($jadwalMendatang->take(5) as $jadwal)
            <div class="list-group-item border-0 py-3">
              <div class="d-flex align-items-center">
                <div class="me-3">
                  <div class="bg-primary bg-opacity-10 rounded p-2 text-center" style="min-width: 50px;">
                    <div class="text-primary fw-bold">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d') }}</div>
                    <div class="text-muted small">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('M') }}</div>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1">{{ $jadwal->tema ?? 'Posyandu' }}</h6>
                  <p class="mb-0 text-muted small">
                    <i class="fas fa-hospital me-1"></i>{{ $jadwal->faskes->nama ?? '-' }}
                    <span class="mx-2">|</span>
                    <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                  </p>
                </div>
                <span class="badge bg-{{ $jadwal->status == 'terjadwal' ? 'primary' : ($jadwal->status == 'sedang_berlangsung' ? 'success' : 'secondary') }}">
                  {{ ucfirst(str_replace('_', ' ', $jadwal->status)) }}
                </span>
              </div>
            </div>
            @endforeach
          </div>
        @else
          <div class="text-center py-5">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
            <p class="text-muted">Tidak ada jadwal mendatang</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-white border-0 pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-notes-medical text-info me-2"></i>Pemeriksaan Terbaru
          </h5>
          <a href="{{ route('admin.pemeriksaan.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th class="border-0 ps-4">Nama Anak</th>
                <th class="border-0">Tanggal</th>
                <th class="border-0">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pemeriksaanTerbaru->take(5) as $pemeriksaan)
              <tr>
                <td class="ps-4">
                  <div class="d-flex align-items-center">
                    <div class="avatar-circle bg-primary text-white me-2" style="width: 32px; height: 32px; font-size: 12px;">
                      {{ substr($pemeriksaan->anak->nama ?? 'A', 0, 1) }}
                    </div>
                    {{ $pemeriksaan->anak->nama ?? '-' }}
                  </div>
                </td>
                <td>{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_periksa)->format('d M Y') }}</td>
                <td>
                  @if($pemeriksaan->status_gizi_akhir)
                  <span class="badge bg-{{ 
                    $pemeriksaan->status_gizi_akhir == 'normal' ? 'success' : 
                    ($pemeriksaan->status_gizi_akhir == 'gizi_buruk' || $pemeriksaan->status_gizi_akhir == 'wasting' ? 'danger' : 
                    ($pemeriksaan->status_gizi_akhir == 'stunting' || $pemeriksaan->status_gizi_akhir == 'underweight' ? 'warning' : 'primary'))
                  }}">
                    {{ ucfirst(str_replace('_', ' ', $pemeriksaan->status_gizi_akhir)) }}
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
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-white border-0 pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-exclamation-triangle text-warning me-2"></i>Anak Berisiko Tinggi
          </h5>
          <a href="{{ route('admin.anak.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        @if($anakBerisiko->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th class="border-0 ps-4">Nama</th>
                <th class="border-0">Usia</th>
                <th class="border-0">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($anakBerisiko->take(5) as $anak)
              <tr>
                <td class="ps-4">
                  <div class="d-flex align-items-center">
                    <div class="avatar-circle bg-danger text-white me-2" style="width: 32px; height: 32px; font-size: 12px;">
                      {{ substr($anak->nama ?? 'A', 0, 1) }}
                    </div>
                    {{ $anak->nama ?? '-' }}
                  </div>
                </td>
                <td>{{ $anak->usia_bulan ?? 0 }} bln</td>
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
        <div class="text-center py-4">
          <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
          <p class="text-muted">Tidak ada anak berisiko tinggi</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const statusGiziData = {!! json_encode($statusGizi) !!};
  initDashboardCharts(statusGiziData);
</script>
@endsection
