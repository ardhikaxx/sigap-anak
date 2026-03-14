@extends('admin.layout.master')

@section('title', 'Laporan & Analitik Pertumbuhan')

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
  
  .report-filter-card {
    background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border-radius: 28px; padding: 30px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.05); margin-top: -60px; position: relative; z-index: 5; border: 1px solid white;
  }
  .summary-card-premium {
    background: white; border-radius: 24px; padding: 25px; border: 1px solid #f1f5f9; transition: all 0.3s ease; height: 100%;
  }
  .summary-card-premium:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.05); }
  .icon-circle-report {
    width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 15px;
  }
</style>
@endpush

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Laporan & Analitik</li>
@endsection

@section('content')
<div class="page-header-premium">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <h1 class="display-5 fw-800 text-white mb-1">Pusat Laporan</h1>
      <p class="text-white opacity-60 fs-5">Analisis mendalam tren kesehatan dan performa wilayah.</p>
      
      <div class="header-stats-mini">
        <div class="header-stat-item">
          <div class="header-stat-label">Periode Aktif</div>
          <div class="header-stat-value text-white">{{ Carbon\Carbon::create()->month($bulan)->format('F') }} {{ $tahun }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Jenis Data</div>
          <div class="header-stat-value text-info text-capitalize">{{ str_replace('_', ' ', $tipe) }}</div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
      <a href="{{ route('admin.laporan.export', ['tipe' => $tipe, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-premium-action btn-gradient-export" target="_blank">
        <i class="fas fa-file-pdf me-2"></i> Export Laporan (PDF)
      </a>
    </div>
  </div>
</div>

<div class="report-filter-card mx-3 mb-4">
  <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3">
    <div class="col-lg-4">
      <label class="form-label small fw-800 text-muted text-uppercase">Kategori Laporan</label>
      <select name="tipe" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold">
        <option value="pemeriksaan" {{ $tipe == 'pemeriksaan' ? 'selected' : '' }}>Pemeriksaan Bulanan</option>
        <option value="pertumbuhan" {{ $tipe == 'pertumbuhan' ? 'selected' : '' }}>Tren Pertumbuhan</option>
        <option value="posyandu" {{ $tipe == 'posyandu' ? 'selected' : '' }}>Aktivitas Posyandu</option>
        <option value="gizi" {{ $tipe == 'gizi' ? 'selected' : '' }}>Distribusi Gizi (WHO)</option>
      </select>
    </div>
    <div class="col-lg-3">
      <label class="form-label small fw-800 text-muted text-uppercase">Bulan</label>
      <select name="bulan" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold">
        @for($i = 1; $i <= 12; $i++)
          <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->format('F') }}</option>
        @endfor
      </select>
    </div>
    <div class="col-lg-3">
      <label class="form-label small fw-800 text-muted text-uppercase">Tahun</label>
      <select name="tahun" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold">
        @for($i = 2023; $i <= 2026; $i++)
          <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
      </select>
    </div>
    <div class="col-lg-2 d-flex align-items-end">
      <button type="submit" class="btn btn-primary w-100 rounded-4 py-3 fw-bold shadow-sm">
        Tampilkan
      </button>
    </div>
  </form>
</div>

@if($tipe == 'pemeriksaan' && isset($data['total']))
<div class="row g-4 mb-4 px-3">
  <div class="col-md-3">
    <div class="summary-card-premium">
      <div class="icon-circle-report bg-primary bg-opacity-10 text-primary"><i class="fas fa-users"></i></div>
      <div class="user-meta small mb-1">Total Diperiksa</div>
      <div class="h3 fw-800 text-dark mb-0">{{ $data['total'] }} <span class="fs-6 fw-normal opacity-50">Anak</span></div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="summary-card-premium">
      <div class="icon-circle-report bg-success bg-opacity-10 text-success"><i class="fas fa-heart-circle-check"></i></div>
      <div class="user-meta small mb-1">Gizi Normal</div>
      <div class="h3 fw-800 text-success mb-0">{{ $data['status_gizi']['normal'] ?? 0 }}</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="summary-card-premium">
      <div class="icon-circle-report bg-warning bg-opacity-10 text-warning"><i class="fas fa-triangle-exclamation"></i></div>
      <div class="user-meta small mb-1">Butuh Perhatian</div>
      <div class="h3 fw-800 text-warning mb-0">{{ ($data['status_gizi']['stunting'] ?? 0) + ($data['status_gizi']['underweight'] ?? 0) }}</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="summary-card-premium">
      <div class="icon-circle-report bg-danger bg-opacity-10 text-danger"><i class="fas fa-shield-virus"></i></div>
      <div class="user-meta small mb-1">Gizi Buruk</div>
      <div class="h3 fw-800 text-danger mb-0">{{ $data['status_gizi']['gizi_buruk'] ?? 0 }}</div>
    </div>
  </div>
</div>
@endif

<div class="card-custom border-0 shadow-sm mx-3 mb-5 overflow-hidden">
  <div class="card-header-custom p-4 border-0">
    <h5 class="mb-0 fw-800">Visualisasi Analitik</h5>
  </div>
  <div class="card-body-custom p-4">
    @if(isset($data['status_gizi']))
      <div style="height: 400px; width: 100%;">
        <canvas id="reportChartPremium"></canvas>
      </div>
    @else
      <div class="text-center py-5">
        <i class="fas fa-chart-bar fa-4x opacity-10 mb-3"></i>
        <p class="user-meta">Pilih parameter laporan untuk melihat grafik</p>
      </div>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
  @if(isset($data['status_gizi']))
  const ctx = document.getElementById('reportChartPremium').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: {!! json_encode($data['status_gizi']->keys()->toArray()) !!}.map(l => l.toUpperCase().replace('_', ' ')),
      datasets: [{
        label: 'Jumlah Anak',
        data: {!! json_encode($data['status_gizi']->values()->toArray()) !!},
        backgroundColor: '#2E86AB',
        borderRadius: 15,
        maxBarThickness: 60
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false } },
        x: { grid: { display: false } }
      }
    }
  });
  @endif
</script>
@endpush
