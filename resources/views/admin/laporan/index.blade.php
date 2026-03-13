@extends('admin.layout.master')

@section('title', 'Laporan')

@section('content')
<div class="page-header">
  <div>
    <h1 class="page-title">Laporan</h1>
    <p class="page-subtitle">Generate dan export laporan bulanan</p>
  </div>
</div>

<div class="card mb-4">
  <div class="card-header bg-white border-bottom py-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <h5 class="mb-0">
        <i class="fas fa-chart-bar text-primary me-2"></i>Filter Laporan
      </h5>
      <form method="GET" class="d-flex gap-2 align-items-center">
        <select name="tipe" class="form-select form-select-sm" style="width: 140px;">
          <option value="pemeriksaan" {{ $tipe == 'pemeriksaan' ? 'selected' : '' }}>Pemeriksaan</option>
          <option value="pertumbuhan" {{ $tipe == 'pertumbuhan' ? 'selected' : '' }}>Pertumbuhan</option>
          <option value="posyandu" {{ $tipe == 'posyandu' ? 'selected' : '' }}>Posyandu</option>
          <option value="konsultasi" {{ $tipe == 'konsultasi' ? 'selected' : '' }}>Konsultasi</option>
          <option value="gizi" {{ $tipe == 'gizi' ? 'selected' : '' }}>Status Gizi</option>
        </select>
        <select name="bulan" class="form-select form-select-sm" style="width: 130px;">
          @for($i = 1; $i <= 12; $i++)
          <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->format('F') }}</option>
          @endfor
        </select>
        <select name="tahun" class="form-select form-select-sm" style="width: 90px;">
          @for($i = 2023; $i <= 2026; $i++)
          <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
          @endfor
        </select>
        <button type="submit" class="btn btn-sm btn-primary">
          <i class="fas fa-search me-1"></i>Tampilkan
        </button>
        <a href="{{ route('admin.laporan.export', ['tipe' => $tipe, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-sm btn-success" target="_blank">
          <i class="fas fa-file-pdf me-1"></i>Export PDF
        </a>
      </form>
    </div>
  </div>
</div>

@if($tipe == 'pemeriksaan')
<div class="row g-4">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body text-center">
        <div class="stat-card-icon bg-primary-light mx-auto mb-3" style="width: 60px; height: 60px;">
          <i class="fas fa-stethoscope text-primary fa-lg"></i>
        </div>
        <h2 class="mb-1">{{ $data['total'] ?? 0 }}</h2>
        <p class="text-muted mb-0">Total Pemeriksaan</p>
      </div>
    </div>
  </div>
  @if(isset($data['status_gizi']))
  <div class="col-md-8">
    <div class="card h-100">
      <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-chart-pie text-success me-2"></i>Status Gizi</h5>
      </div>
      <div class="card-body">
        @foreach($data['status_gizi'] as $status => $jumlah)
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex align-items-center">
            <span class="badge bg-{{ 
                $status == 'normal' ? 'success' : 
                ($status == 'gizi_buruk' || $status == 'wasting' ? 'danger' : 
                ($status == 'stunting' || $status == 'underweight' ? 'warning' : 'primary'))
            }} me-2">{{ ucfirst($status) }}</span>
          </div>
          <strong>{{ $jumlah }} anak</strong>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endif
</div>
@endif

@if($tipe == 'pertumbuhan')
<div class="row g-4">
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body text-center">
        <div class="stat-card-icon bg-success mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #57CC99 0%, #38A169 100%);">
          <i class="fas fa-weight text-white fa-lg"></i>
        </div>
        <h2 class="mb-1">{{ $data['rerata_berat'] ?? 0 }} <small class="text-muted">kg</small></h2>
        <p class="text-muted mb-0">Rata-rata Berat Badan</p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body text-center">
        <div class="stat-card-icon bg-info mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #74C0FC 0%, #4dabf7 100%);">
          <i class="fas fa-ruler-vertical text-white fa-lg"></i>
        </div>
        <h2 class="mb-1">{{ $data['rerata_tinggi'] ?? 0 }} <small class="text-muted">cm</small></h2>
        <p class="text-muted mb-0">Rata-rata Tinggi Badan</p>
      </div>
    </div>
  </div>
</div>
@endif

@if($tipe == 'posyandu')
<div class="row g-4">
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body text-center">
        <div class="stat-card-icon mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #FFB347 0%, #E67E22 100%);">
          <i class="fas fa-calendar-check text-white fa-lg"></i>
        </div>
        <h2 class="mb-1">{{ $data['total_jadwal'] ?? 0 }}</h2>
        <p class="text-muted mb-0">Total Jadwal</p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body text-center">
        <div class="stat-card-icon mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #57CC99 0%, #38A169 100%);">
          <i class="fas fa-users text-white fa-lg"></i>
        </div>
        <h2 class="mb-1">{{ $data['total_hadir'] ?? 0 }}</h2>
        <p class="text-muted mb-0">Total Kehadiran</p>
      </div>
    </div>
  </div>
</div>
@endif

@if($tipe == 'konsultasi')
<div class="row g-4">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body text-center">
        <div class="stat-card-icon mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #2E86AB 0%, #1A5F7A 100%);">
          <i class="fas fa-comments text-white fa-lg"></i>
        </div>
        <h2 class="mb-1">{{ $data['total'] ?? 0 }}</h2>
        <p class="text-muted mb-0">Total Konsultasi</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body text-center">
        <div class="stat-card-icon mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #57CC99 0%, #38A169 100%);">
          <i class="fas fa-check-circle text-white fa-lg"></i>
        </div>
        <h2 class="mb-1">{{ $data['selesai'] ?? 0 }}</h2>
        <p class="text-muted mb-0">Selesai</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body text-center">
        <div class="stat-card-icon mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #FFB347 0%, #E67E22 100%);">
          <i class="fas fa-star text-white fa-lg"></i>
        </div>
        <h2 class="mb-1">{{ $data['rating_rata'] ?? 0 }} <small class="text-muted">/5</small></h2>
        <p class="text-muted mb-0">Rating Rata-rata</p>
      </div>
    </div>
  </div>
</div>
@endif

@if($tipe == 'gizi')
<div class="card">
  <div class="card-header bg-white">
    <h5 class="mb-0"><i class="fas fa-chart-pie text-warning me-2"></i>Distribusi Status Gizi</h5>
  </div>
  <div class="card-body">
    @if(isset($data['status']))
    @foreach($data['status'] as $status => $jumlah)
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex align-items-center">
        <span class="badge bg-{{ 
            $status == 'normal' ? 'success' : 
            ($status == 'stunting' || $status == 'wasting' || $status == 'gizi_buruk' ? 'danger' : 
            ($status == 'underweight' ? 'warning' : 'primary'))
        }} me-2">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
      </div>
      <div>
        <strong>{{ $jumlah }}</strong>
        <span class="text-muted">({{ round($jumlah / max($data['total'], 1) * 100, 1) }}%)</span>
      </div>
    </div>
    @endforeach
    @else
    <p class="text-muted text-center py-4">Tidak ada data</p>
    @endif
  </div>
</div>
@endif
@endsection
