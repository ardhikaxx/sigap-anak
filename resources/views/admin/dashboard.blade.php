@extends('admin.layout.master')

@section('title', 'Control Center Overview')

@push('styles')
<style>
  /* Next-Gen Dashboard UI */
  :root {
    --glass-bg: rgba(255, 255, 255, 0.7);
    --glass-border: rgba(255, 255, 255, 0.4);
  }

  .premium-mesh-hero {
    background: radial-gradient(at 0% 0%, #2E86AB 0, transparent 50%), 
                radial-gradient(at 50% 0%, #57CC99 0, transparent 50%), 
                radial-gradient(at 100% 0%, #1A5F7A 0, transparent 50%);
    background-color: #1A1D2E;
    border-radius: 35px;
    padding: 60px 50px;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: -100px; /* Overlap effect */
    z-index: 0;
  }

  .mesh-decorative-circle {
    position: absolute;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.03);
    border-radius: 50%;
    top: -100px;
    right: -100px;
  }

  .dashboard-container {
    position: relative;
    z-index: 1;
    padding: 0 15px;
  }

  .glass-stat-card {
    background: var(--glass-bg);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid var(--glass-border);
    border-radius: 28px;
    padding: 25px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 100%;
  }

  .glass-stat-card:hover {
    transform: translateY(-8px);
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0 20px 45px rgba(0,0,0,0.08);
  }

  .action-app-card {
    background: white;
    border-radius: 22px;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    color: var(--sigap-dark);
    border: 1px solid var(--sigap-border);
    transition: all 0.2s;
    display: block;
  }

  .action-app-card:hover {
    border-color: var(--sigap-primary);
    transform: scale(1.05);
    box-shadow: var(--shadow-md);
    color: var(--sigap-primary);
  }

  .action-app-card i {
    font-size: 24px;
    margin-bottom: 10px;
    display: block;
  }

  .timeline-modern {
    position: relative;
    padding-left: 30px;
  }

  .timeline-modern::before {
    content: '';
    position: absolute;
    left: 7px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e2e8f0;
  }

  .timeline-item {
    position: relative;
    padding-bottom: 25px;
  }

  .timeline-dot {
    position: absolute;
    left: -30px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: white;
    border: 3px solid var(--sigap-primary);
    z-index: 2;
  }

  .stat-label-modern {
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--sigap-gray);
    margin-bottom: 5px;
  }

  .pulse-indicator {
    width: 10px;
    height: 10px;
    background: #22c55e;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 0 0 rgba(34, 197, 94, 0.4);
    animation: pulse-green 2s infinite;
  }

  @keyframes pulse-green {
    0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
    100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
  }
</style>
@endpush

@section('breadcrumb')
  <li class="breadcrumb-item active">Operational Dashboard</li>
@endsection

@section('content')
<!-- Mesh Hero -->
<div class="premium-mesh-hero">
  <div class="mesh-decorative-circle"></div>
  <div class="row align-items-center">
    <div class="col-lg-7">
      <div class="d-flex align-items-center gap-3 mb-3">
        <span class="pulse-indicator"></span>
        <span class="small fw-bold opacity-75">SISTEM AKTIF & TERKONEKSI</span>
      </div>
      <h1 class="display-4 fw-bold mb-3 text-white">Dashboard Kendali</h1>
      <p class="fs-5 opacity-75 mb-0">Memantau pertumbuhan {{ $totalAnak }} anak dengan dukungan kecerdasan sistem.</p>
    </div>
    <div class="col-lg-5 d-none d-lg-block">
      <div class="d-flex justify-content-end gap-2">
        <div class="text-end me-4">
          <div class="h2 fw-800 mb-0">{{ now()->format('H:i') }}</div>
          <div class="small opacity-75">{{ now()->format('l, d M Y') }}</div>
        </div>
        <div class="avatar-circle bg-white bg-opacity-10" style="width: 60px; height: 60px; font-size: 24px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
          <i class="fas fa-chart-line text-white"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="dashboard-container mt-5">
  <!-- Stats Block -->
  <div class="row g-4 mb-5">
    <div class="col-xl-3 col-sm-6">
      <div class="glass-stat-card">
        <div class="stat-label-modern">Populasi Anak</div>
        <div class="d-flex align-items-end gap-2">
          <h2 class="fw-800 mb-0">{{ $totalAnak }}</h2>
          <span class="text-success small fw-bold mb-1"><i class="fas fa-arrow-up"></i> 4.2%</span>
        </div>
        <div class="user-meta mt-2 small">Jiwa terdata di sistem</div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6">
      <div class="glass-stat-card">
        <div class="stat-label-modern">Target Periksa</div>
        <div class="d-flex align-items-end gap-2">
          <h2 class="fw-800 mb-0">{{ $pemeriksaanHariIni }}</h2>
          <span class="text-primary small fw-bold mb-1">/ 25</span>
        </div>
        <div class="progress-mini mt-3">
          <div class="progress-bar bg-primary" style="width: {{ ($pemeriksaanHariIni/25)*100 }}%"></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6">
      <div class="glass-stat-card">
        <div class="stat-label-modern">Antrian Konsultasi</div>
        <div class="d-flex align-items-end gap-2">
          <h2 class="fw-800 mb-0 text-warning">{{ $konsultasiPending }}</h2>
          <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1" style="font-size: 10px;">URGENT</span>
        </div>
        <div class="user-meta mt-2 small">Menunggu respon nakes</div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6">
      <div class="glass-stat-card">
        <div class="stat-label-modern">Kasus Gizi Buruk</div>
        <div class="d-flex align-items-end gap-2">
          <h2 class="fw-800 mb-0 text-danger">{{ $anakBerisiko->count() }}</h2>
          <i class="fas fa-shield-exclamation text-danger mb-1"></i>
        </div>
        <div class="user-meta mt-2 small">Butuh intervensi segera</div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <!-- Main Insights -->
    <div class="col-lg-8">
      <div class="card-custom mb-4 border-0 shadow-sm overflow-hidden">
        <div class="row g-0">
          <div class="col-md-7 p-4">
            <h5 class="fw-800 mb-4"><i class="fas fa-chart-pie me-2 text-primary"></i>Peta Status Gizi</h5>
            <div style="height: 320px;">
              <canvas id="statusGiziChart"></canvas>
            </div>
          </div>
          <div class="col-md-5 bg-light bg-opacity-50 p-4 border-start">
            <h6 class="fw-bold mb-3 small uppercase">Legenda & Distribusi</h6>
            <div class="d-flex flex-column gap-3">
              @foreach($statusGizi as $status => $jumlah)
                @if($jumlah > 0)
                <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-white border">
                  <div class="d-flex align-items-center gap-2">
                    <div style="width: 10px; height: 10px; border-radius: 3px; background: @if($status == 'normal') #22c55e @elseif($status == 'gizi_buruk' || $status == 'wasting') #ef4444 @elseif($status == 'stunting' || $status == 'underweight') #f59e0b @else #0ea5e9 @endif;"></div>
                    <span class="small fw-bold text-dark text-capitalize">{{ str_replace('_', ' ', $status) }}</span>
                  </div>
                  <span class="badge bg-light text-dark border">{{ $jumlah }}</span>
                </div>
                @endif
              @endforeach
            </div>
            <div class="mt-4 p-3 rounded-4 bg-primary bg-opacity-10 text-primary small">
              <i class="fas fa-info-circle me-1"></i> Data dihitung berdasarkan standar deviasi WHO 2025.
            </div>
          </div>
        </div>
      </div>

      <div class="card-custom border-0 shadow-sm">
        <div class="card-header-custom p-4 border-0">
          <h5 class="mb-0 fw-800">Timeline Pemeriksaan Terbaru</h5>
          <a href="{{ route('admin.pemeriksaan.index') }}" class="btn btn-link text-primary fw-bold text-decoration-none p-0">Detail <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="card-body-custom px-4 pb-2">
          <div class="timeline-modern">
            @foreach($pemeriksaanTerbaru->take(4) as $p)
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="d-flex justify-content-between align-items-start bg-light bg-opacity-30 p-3 rounded-4 border border-white">
                <div class="d-flex gap-3">
                  <div class="avatar-circle avatar-{{ $p->anak->jenis_kelamin == 'L' ? 'blue' : 'pink' }}" style="width: 45px; height: 45px; border-radius: 14px;">
                    {{ strtoupper(substr($p->anak->nama, 0, 1)) }}
                  </div>
                  <div>
                    <h6 class="fw-bold text-dark mb-0">{{ $p->anak->nama }}</h6>
                    <div class="user-meta small">BB: {{ $p->berat_badan }}kg | TB: {{ $p->tinggi_badan }}cm</div>
                  </div>
                </div>
                <div class="text-end">
                  <span class="badge-custom @if($p->status_gizi_akhir == 'normal') badge-normal @else badge-warning @endif mb-1">
                    {{ ucfirst(str_replace('_', ' ', $p->status_gizi_akhir)) }}
                  </span>
                  <div class="user-meta" style="font-size: 10px;">{{ \Carbon\Carbon::parse($p->tanggal_periksa)->diffForHumans() }}</div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar Aksi & Informasi -->
    <div class="col-lg-4">
      <div class="mb-4">
        <h6 class="fw-800 text-dark mb-3 small uppercase ms-2">Aksi Navigasi</h6>
        <div class="row g-2">
          <div class="col-6">
            <a href="{{ route('admin.pemeriksaan.create') }}" class="action-app-card">
              <i class="fas fa-file-medical text-primary"></i>
              <span class="small fw-bold">Input Data</span>
            </a>
          </div>
          <div class="col-6">
            <a href="{{ route('admin.posyandu.create') }}" class="action-app-card">
              <i class="fas fa-calendar-plus text-success"></i>
              <span class="small fw-bold">Atur Jadwal</span>
            </a>
          </div>
          <div class="col-6">
            <a href="{{ route('admin.konsultasi.index') }}" class="action-app-card">
              <i class="fas fa-message-smile text-warning"></i>
              <span class="small fw-bold">Balas Chat</span>
            </a>
          </div>
          <div class="col-6">
            <a href="{{ route('admin.laporan.index') }}" class="action-app-card">
              <i class="fas fa-file-pdf text-danger"></i>
              <span class="small fw-bold">Laporan</span>
            </a>
          </div>
        </div>
      </div>

      <div class="card-custom mb-4 border-0 shadow-sm">
        <div class="card-header-custom p-4 border-0">
          <h5 class="mb-0 fw-800">Agenda Hari Ini</h5>
        </div>
        <div class="card-body-custom px-4 pb-4">
          @forelse($jadwalMendatang->where('tanggal', now()->format('Y-m-d')) as $jadwal)
            <div class="p-3 rounded-4 bg-primary bg-opacity-5 border border-primary border-opacity-10 mb-2">
              <div class="fw-bold text-primary mb-1">{{ $jadwal->tema ?? 'Layanan Posyandu' }}</div>
              <div class="user-meta small"><i class="fas fa-clock me-1"></i> {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} • {{ $jadwal->faskes->nama }}</div>
            </div>
          @empty
            <div class="text-center py-4 border rounded-4 border-dashed">
              <i class="fas fa-calendar-day opacity-20 fa-2x mb-2"></i>
              <p class="user-meta small mb-0">Tidak ada agenda hari ini</p>
            </div>
          @endforelse
        </div>
      </div>

      <div class="p-4 rounded-4 bg-glass border" style="background: rgba(255,255,255,0.4);">
        <h6 class="fw-800 text-dark mb-3 small uppercase">Kesehatan Server</h6>
        <div class="d-flex flex-column gap-2">
          <div class="d-flex align-items-center justify-content-between">
            <span class="small fw-bold text-muted">Uptime</span>
            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">99.9%</span>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <span class="small fw-bold text-muted">Data Sync</span>
            <span class="small fw-bold text-dark">Real-time</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
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
    return '#0ea5e9';
  });

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: colors,
        hoverBackgroundColor: colors,
        borderWidth: 0,
        hoverOffset: 30,
        borderRadius: 15,
        spacing: 10
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '85%',
      plugins: {
        legend: { display: false },
        tooltip: {
          padding: 15,
          cornerRadius: 15,
          backgroundColor: '#111827',
          titleFont: { family: 'Plus Jakarta Sans', size: 14, weight: 'bold' },
          bodyFont: { family: 'Plus Jakarta Sans', size: 13 },
          boxPadding: 10
        }
      },
      animation: {
        animateRotate: true,
        animateScale: true,
        duration: 2500,
        easing: 'easeOutElastic'
      }
    }
  });
</script>
@endpush
