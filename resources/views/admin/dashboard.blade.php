@extends('admin.layout.master')

@section('title', 'Dashboard')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="page-header mb-4">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h1 class="page-title">Dashboard</h1>
      <p class="page-subtitle">Selamat datang kembali, <span class="text-primary fw-bold">{{ auth()->user()->name }}</span></p>
    </div>
    <div class="d-flex align-items-center gap-3">
      <a href="{{ route('admin.pemeriksaan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Pemeriksaan Baru
      </a>
      <div class="card border-0 shadow-sm" style="min-width: 160px;">
        <div class="card-body py-2 px-3">
          <div class="d-flex align-items-center gap-2">
            <div class="bg-primary bg-opacity-10 rounded p-2">
              <i class="fas fa-calendar text-primary"></i>
            </div>
            <div>
              <div class="text-muted small">Tanggal</div>
              <div class="fw-bold">{{ now()->format('d M Y') }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-md-6 col-xl-3">
    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #2E86AB !important;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <p class="text-muted small mb-1">Total Anak Terdaftar</p>
            <h2 class="mb-0 fw-bold text-dark">{{ $totalAnak }}</h2>
          </div>
          <div class="stat-card-icon" style="background: linear-gradient(135deg, #2E86AB 0%, #1A5F7A 100%); width: 48px; height: 48px;">
            <i class="fas fa-child text-white fs-5"></i>
          </div>
        </div>
        <div class="mt-3">
          <span class="badge bg-primary bg-opacity-10 text-primary">
            <i class="fas fa-user-plus me-1"></i> Aktif
          </span>
          <span class="text-muted small ms-2">anak</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #57CC99 !important;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <p class="text-muted small mb-1">Pemeriksaan Hari Ini</p>
            <h2 class="mb-0 fw-bold text-dark">{{ $pemeriksaanHariIni }}</h2>
          </div>
          <div class="stat-card-icon" style="background: linear-gradient(135deg, #57CC99 0%, #38A169 100%); width: 48px; height: 48px;">
            <i class="fas fa-stethoscope text-white fs-5"></i>
          </div>
        </div>
        <div class="mt-3">
          <span class="badge bg-success bg-opacity-10 text-success">
            <i class="fas fa-clock me-1"></i> {{ now()->format('H:i') }}
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #FFB347 !important;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <p class="text-muted small mb-1">Pemeriksaan Bulan Ini</p>
            <h2 class="mb-0 fw-bold text-dark">{{ $pemeriksaanBulanIni }}</h2>
          </div>
          <div class="stat-card-icon" style="background: linear-gradient(135deg, #FFB347 0%, #E67E22 100%); width: 48px; height: 48px;">
            <i class="fas fa-calendar-check text-white fs-5"></i>
          </div>
        </div>
        <div class="mt-3">
          <span class="badge bg-warning bg-opacity-10 text-warning">
            <i class="fas fa-calendar me-1"></i> {{ now()->format('F') }}
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #FF6B6B !important;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <p class="text-muted small mb-1">Konsultasi Pending</p>
            <h2 class="mb-0 fw-bold text-dark">{{ $konsultasiPending }}</h2>
          </div>
          <div class="stat-card-icon" style="background: linear-gradient(135deg, #FF6B6B 0%, #C0392B 100%); width: 48px; height: 48px;">
            <i class="fas fa-comments text-white fs-5"></i>
          </div>
        </div>
        <div class="mt-3">
          <span class="badge bg-danger bg-opacity-10 text-danger">
            <i class="fas fa-exclamation-circle me-1"></i> Menunggu
          </span>
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
        <div class="chart-container mb-3" style="height: 180px;">
          <canvas id="statusGiziChart"></canvas>
        </div>
        <div class="d-flex flex-wrap gap-2 justify-content-center">
          @forelse($statusGizi as $status => $jumlah)
            @if($jumlah > 0)
            <span class="badge bg-{{ 
              $status == 'normal' ? 'success' : 
              ($status == 'gizi_buruk' || $status == 'wasting' ? 'danger' : 
              ($status == 'stunting' || $status == 'underweight' ? 'warning' : 'info'))
            }}">
              {{ ucfirst($status) }} ({{ $jumlah }})
            </span>
            @endif
          @empty
          <span class="text-muted">Belum ada data</span>
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
          <a href="{{ route('admin.posyandu.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        @if($jadwalMendatang->count() > 0)
          <div class="list-group list-group-flush">
            @foreach($jadwalMendatang->take(5) as $jadwal)
            <div class="list-group-item border-0 py-3 px-4 hover-bg">
              <div class="d-flex align-items-center">
                <div class="me-3">
                  <div class="bg-primary bg-opacity-10 rounded p-3 text-center" style="min-width: 60px;">
                    <div class="text-primary fw-bold fs-4">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d') }}</div>
                    <div class="text-muted small text-uppercase">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('M') }}</div>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1 fw-semibold">{{ $jadwal->tema ?? 'Posyandu' }}</h6>
                  <div class="d-flex align-items-center text-muted small">
                    <span class="me-3">
                      <i class="fas fa-hospital me-1"></i>{{ $jadwal->faskes->nama ?? '-' }}
                    </span>
                    <span>
                      <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                    </span>
                  </div>
                </div>
                <div>
                  <span class="badge bg-{{ $jadwal->status == 'terjadwal' ? 'primary' : ($jadwal->status == 'sedang_berlangsung' ? 'success' : 'secondary') }}">
                    {{ ucfirst(str_replace('_', ' ', $jadwal->status)) }}
                  </span>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        @else
          <div class="text-center py-5">
            <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
              <i class="fas fa-calendar-times fa-2x text-muted"></i>
            </div>
            <h6 class="text-muted">Tidak ada jadwal mendatang</h6>
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
            <i class="fas fa-notes-medical text-info me-2"></i>Pemeriksaan Terbaru
          </h5>
          <a href="{{ route('admin.pemeriksaan.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        @if($pemeriksaanTerbaru->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th class="border-0 ps-4">Nama Anak</th>
                <th class="border-0">Tanggal</th>
                <th class="border-0">BB</th>
                <th class="border-0">TB</th>
                <th class="border-0">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pemeriksaanTerbaru->take(5) as $pemeriksaan)
              <tr class="hover-bg">
                <td class="ps-4">
                  <div class="d-flex align-items-center">
                    <div class="avatar-circle bg-{{ $pemeriksaan->anak->jenis_kelamin == 'L' ? 'primary' : 'info' }} text-white me-2" style="width: 32px; height: 32px; font-size: 12px;">
                      {{ substr($pemeriksaan->anak->nama ?? 'A', 0, 1) }}
                    </div>
                    <span class="fw-medium">{{ $pemeriksaan->anak->nama ?? '-' }}</span>
                  </div>
                </td>
                <td><small>{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_periksa)->format('d M') }}</small></td>
                <td><strong>{{ $pemeriksaan->berat_badan ?? '-' }}</strong> <small class="text-muted">kg</small></td>
                <td><strong>{{ $pemeriksaan->tinggi_badan ?? '-' }}</strong> <small class="text-muted">cm</small></td>
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
        @else
        <div class="text-center py-4">
          <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
          <p class="text-muted">Belum ada pemeriksaan</p>
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
                <th class="border-0">Berat</th>
                <th class="border-0">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($anakBerisiko->take(5) as $anak)
              <tr class="hover-bg">
                <td class="ps-4">
                  <div class="d-flex align-items-center">
                    <div class="avatar-circle bg-danger text-white me-2" style="width: 32px; height: 32px; font-size: 12px;">
                      {{ substr($anak->nama ?? 'A', 0, 1) }}
                    </div>
                    <span class="fw-medium">{{ $anak->nama ?? '-' }}</span>
                  </div>
                </td>
                <td>{{ $anak->usia_bulan ?? 0 }} <small class="text-muted">bln</small></td>
                <td>{{ $anak->latestPemeriksaan ? $anak->latestPemeriksaan->berat_badan . ' kg' : '-' }}</td>
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
        <div class="text-center py-5">
          <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
            <i class="fas fa-check-circle fa-2x text-success"></i>
          </div>
          <h6 class="text-muted">Tidak ada anak berisiko tinggi</h6>
          <p class="text-muted small">Semua anak dalam kondisi normal</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<style>
.hover-bg {
  transition: background-color 0.2s ease;
}
.hover-bg:hover {
  background-color: #f8fafc !important;
}
</style>
@endsection

@section('scripts')
<script>
  const statusGiziData = {!! json_encode($statusGizi) !!};
  initDashboardCharts(statusGiziData);
</script>
@endsection
