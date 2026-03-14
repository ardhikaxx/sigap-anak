@extends('admin.layout.master')

@section('title', 'Laporan')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css">
<style>
  :root {
    --primary: #0ea5e9; --primary-dark: #0284c7; --dark: #0f172a;
    --gray-600: #475569; --gray-500: #64748b; --gray-400: #94a3b8;
    --gray-100: #f1f5f9; --white: #ffffff;
    --success: #22c55e; --warning: #f59e0b; --danger: #ef4444;
  }
  * { font-family: 'Plus Jakarta Sans', -apple-system, sans-serif; }

  .hero-section {
    background: var(--primary); border-radius: 24px; padding: 40px 44px;
    color: white; position: relative; overflow: hidden; margin-bottom: 28px;
  }
  .hero-section::before {
    content: ''; position: absolute; top: -50%; right: -10%; width: 320px; height: 320px;
    background: rgba(255,255,255,0.08); border-radius: 50%;
  }
  .hero-title { font-size: 2.25rem; font-weight: 800; margin-bottom: 6px; }
  .hero-subtitle { font-size: 1.05rem; opacity: 0.9; }

  .content-card {
    background: var(--white); border-radius: 22px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px;
  }
  .card-header-section { padding: 22px 28px; border-bottom: 1px solid #f1f5f9; }
  .card-title-section { font-size: 1.1rem; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 12px; margin: 0; }
  .card-title-section i { color: var(--primary); }

  .filter-bar {
    display: flex; gap: 12px; flex-wrap: wrap; align-items: center; padding: 20px 28px;
    background: var(--gray-100); border-bottom: 1px solid #e2e8f0;
  }

  .filter-dropdown {
    padding: 12px 16px; border: 2px solid transparent; border-radius: 12px;
    font-size: 0.9rem; background: var(--white); cursor: pointer; min-width: 140px;
  }
  .filter-dropdown:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1); }

  .btn-filter {
    background: var(--primary); border: none; border-radius: 12px; padding: 12px 20px;
    font-weight: 600; color: white; transition: all 0.25s ease;
    display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
  }
  .btn-filter:hover { background: var(--primary-dark); transform: translateY(-1px); color: white; }

  .btn-export {
    background: var(--success); border: none; border-radius: 12px; padding: 12px 20px;
    font-weight: 600; color: white; transition: all 0.25s ease;
    display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
  }
  .btn-export:hover { background: #16a34a; transform: translateY(-1px); color: white; }

  .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }
  .stat-card {
    background: var(--white); border-radius: 20px; padding: 24px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;
    transition: all 0.35s ease; position: relative;
  }
  .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 5px; height: 100%; background: var(--stat-color); }
  .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 35px rgba(0,0,0,0.1); }
  .stat-icon {
    width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center;
    font-size: 20px; margin-bottom: 14px; background: var(--stat-bg); color: var(--stat-color);
  }
  .stat-number { font-size: 2.25rem; font-weight: 800; color: var(--dark); line-height: 1; margin-bottom: 4px; }
  .stat-label { font-size: 0.85rem; color: var(--gray-500); font-weight: 500; }

  .chart-card {
    background: var(--white); border-radius: 22px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; overflow: hidden;
  }
  .chart-header { padding: 22px 28px; border-bottom: 1px solid #f1f5f9; }
  .chart-title { font-size: 1rem; font-weight: 700; color: var(--dark); margin: 0; }
  .chart-body { padding: 24px; }

  @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 768px) {
    .hero-section { padding: 28px; text-align: center; }
    .hero-title { font-size: 1.75rem; }
    .stats-grid { grid-template-columns: 1fr; }
    .filter-bar { flex-direction: column; }
    .filter-dropdown, .btn-filter, .btn-export { width: 100%; justify-content: center; }
  }
</style>
@endsection

@section('content')
<div class="hero-section">
  <h1 class="hero-title"><i class="fas fa-chart-line me-3"></i>Laporan</h1>
  <p class="hero-subtitle">Generate dan export laporan dengan lebih mudah</p>
</div>

<div class="content-card">
  <div class="card-header-section">
    <h5 class="card-title-section"><i class="fas fa-filter"></i> Filter Laporan</h5>
  </div>
  <div class="filter-bar">
    <form method="GET" class="d-flex gap-2 flex-wrap flex-grow-1">
      <select name="tipe" class="filter-dropdown">
        <option value="pemeriksaan" {{ $tipe == 'pemeriksaan' ? 'selected' : '' }}>Pemeriksaan</option>
        <option value="pertumbuhan" {{ $tipe == 'pertumbuhan' ? 'selected' : '' }}>Pertumbuhan</option>
        <option value="posyandu" {{ $tipe == 'posyandu' ? 'selected' : '' }}>Posyandu</option>
        <option value="konsultasi" {{ $tipe == 'konsultasi' ? 'selected' : '' }}>Konsultasi</option>
        <option value="gizi" {{ $tipe == 'gizi' ? 'selected' : '' }}>Status Gizi</option>
      </select>
      <select name="bulan" class="filter-dropdown">
        @for($i = 1; $i <= 12; $i++)
        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->format('F') }}</option>
        @endfor
      </select>
      <select name="tahun" class="filter-dropdown">
        @for($i = 2023; $i <= 2026; $i++)
        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
      </select>
      <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Tampilkan</button>
    </form>
    <a href="{{ route('admin.laporan.export', ['tipe' => $tipe, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn-export" target="_blank">
      <i class="fas fa-file-pdf"></i> Export PDF
    </a>
  </div>
</div>

@if($tipe == 'pemeriksaan')
<div class="stats-grid">
  <div class="stat-card" style="--stat-color: #0ea5e9; --stat-bg: rgba(14, 165, 233, 0.1);">
    <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
    <div class="stat-number">{{ $data['total'] }}</div>
    <div class="stat-label">Total Pemeriksaan</div>
  </div>
  <div class="stat-card" style="--stat-color: #22c55e; --stat-bg: rgba(34, 197, 94, 0.1);">
    <div class="stat-icon"><i class="fas fa-check"></i></div>
    <div class="stat-number">{{ $data['normal'] }}</div>
    <div class="stat-label">Gizi Normal</div>
  </div>
  <div class="stat-card" style="--stat-color: #f59e0b; --stat-bg: rgba(245, 158, 11, 0.1);">
    <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
    <div class="stat-number">{{ $data['stunting'] + $data['underweight'] }}</div>
    <div class="stat-label">Berisiko</div>
  </div>
  <div class="stat-card" style="--stat-color: #ef4444; --stat-bg: rgba(239, 68, 68, 0.1);">
    <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
    <div class="stat-number">{{ $data['gizi_buruk'] }}</div>
    <div class="stat-label">Gizi Buruk</div>
  </div>
</div>
@endif

<div class="chart-card">
  <div class="chart-header">
    <h5 class="chart-title"><i class="fas fa-chart-pie me-2"></i>{{ ucfirst($tipe) }} - {{ Carbon\Carbon::create()->month($bulan)->format('F') }} {{ $tahun }}</h5>
  </div>
  <div class="chart-body">
    <canvas id="reportChart" height="100"></canvas>
  </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
  const ctx = document.getElementById('reportChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: {!! json_encode($chartLabels) !!},
      datasets: [{
        label: 'Jumlah',
        data: {!! json_encode($chartData) !!},
        backgroundColor: '#0ea5e9',
        borderRadius: 8
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
        x: { grid: { display: false } }
      }
    }
  });
</script>
@endsection
