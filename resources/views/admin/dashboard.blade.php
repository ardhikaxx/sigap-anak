<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - SIGAP Anak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sigap-main.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sigap-admin.css') }}">
</head>
<body>
  <div class="admin-layout">
    @include('admin.layout.sidebar')
    
    <div class="main-content">
      @include('admin.layout.topbar')
      
      <div class="content-wrapper">
        <div class="page-header">
          <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Selamat datang kembali, {{ auth()->user()->name }}</p>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-card-icon bg-primary-light">
              <i class="fas fa-child text-primary"></i>
            </div>
            <div class="stat-card-body">
              <p class="stat-label">Total Anak Terdaftar</p>
              <h3 class="stat-value">{{ $totalAnak }}</h3>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-card-icon bg-secondary-light">
              <i class="fas fa-stethoscope text-success"></i>
            </div>
            <div class="stat-card-body">
              <p class="stat-label">Pemeriksaan Hari Ini</p>
              <h3 class="stat-value">{{ $pemeriksaanHariIni }}</h3>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-card-icon" style="background: #fff3cd;">
              <i class="fas fa-calendar-check text-warning"></i>
            </div>
            <div class="stat-card-body">
              <p class="stat-label">Pemeriksaan Bulan Ini</p>
              <h3 class="stat-value">{{ $pemeriksaanBulanIni }}</h3>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-card-icon" style="background: #fde8e8;">
              <i class="fas fa-comments text-danger"></i>
            </div>
            <div class="stat-card-body">
              <p class="stat-label">Konsultasi Pending</p>
              <h3 class="stat-value">{{ $konsultasiPending }}</h3>
            </div>
          </div>
        </div>

        <div class="charts-grid">
          <div class="card">
            <div class="card-header">
              <h5>Distribusi Status Gizi</h5>
            </div>
            <div class="card-body">
              <div class="chart-container" style="height: 250px;">
                <canvas id="statusGiziChart"></canvas>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h5>Jadwal Posyandu Mendatang</h5>
            </div>
            <div class="card-body">
              @if($jadwalMendatang->count() > 0)
                <div class="table-responsive">
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Tema</th>
                        <th>Lokasi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($jadwalMendatang as $jadwal)
                      <tr>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M') }}</td>
                        <td>{{ $jadwal->tema ?? '-' }}</td>
                        <td>{{ $jadwal->faskes->nama ?? '-' }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <p class="text-muted">Tidak ada jadwal mendatang</p>
              @endif
            </div>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-6">
            <div class="table-card">
              <div class="table-card-header">
                <h5 class="table-card-title">Pemeriksaan Terbaru</h5>
                <a href="{{ route('admin.pemeriksaan.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
              </div>
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th>Anak</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($pemeriksaanTerbaru as $pemeriksaan)
                    <tr>
                      <td>{{ $pemeriksaan->anak->nama }}</td>
                      <td>{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_periksa)->format('d M Y') }}</td>
                      <td>
                        @if($pemeriksaan->status_gizi_akhir)
                        <span class="status-badge {{ $pemeriksaan->status_gizi_akhir }}">
                          {{ ucfirst($pemeriksaan->status_gizi_akhir) }}
                        </span>
                        @else
                        -
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="table-card">
              <div class="table-card-header">
                <h5 class="table-card-title">Anak Berisiko</h5>
                <a href="{{ route('admin.anak.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
              </div>
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Usia</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($anakBerisiko as $anak)
                    <tr>
                      <td>{{ $anak->nama }}</td>
                      <td>{{ $anak->usia_bulan }} bln</td>
                      <td>
                        @if($anak->latestPemeriksaan)
                        <span class="status-badge {{ $anak->latestPemeriksaan->status_gizi_akhir }}">
                          {{ ucfirst($anak->latestPemeriksaan->status_gizi_akhir) }}
                        </span>
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
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('assets/js/sigap-charts.js') }}"></script>
  <script>
    const statusGiziData = {!! json_encode($statusGizi) !!};
    initDashboardCharts(statusGiziData);
  </script>
</body>
</html>
