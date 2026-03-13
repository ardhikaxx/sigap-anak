@extends('mobile.layout.master')

@section('title', 'Grafik Pertumbuhan')

@section('content')
<div class="mobile-content pb-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-1">Grafik Pertumbuhan</h4>
      <p class="text-muted small mb-0">Monitor pertumbuhan anak Anda</p>
    </div>
  </div>
  
  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <label class="form-label text-muted small">Pilih Anak</label>
      <select class="form-select form-select-lg border-0 bg-light" id="selectAnak" onchange="filterAnak()">
        <option value="">-- Pilih Anak --</option>
        @foreach($anak as $a)
        <option value="{{ $a->id }}" {{ $selectedAnak && $selectedAnak->id == $a->id ? 'selected' : '' }}>
          {{ $a->nama }} ({{ $a->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }})
        </option>
        @endforeach
      </select>
    </div>
  </div>

  @if($selectedAnak)
  <div class="d-flex gap-2 mb-3 overflow-auto pb-2">
    <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'bb_u']) }}" 
       class="btn {{ $indikator == 'bb_u' ? 'btn-primary' : 'btn-outline-secondary' }} btn-sm rounded-pill">
      <i class="fas fa-weight me-1"></i> BB/U
    </a>
    <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'tb_u']) }}" 
       class="btn {{ $indikator == 'tb_u' ? 'btn-primary' : 'btn-outline-secondary' }} btn-sm rounded-pill">
      <i class="fas fa-ruler-vertical me-1"></i> TB/U
    </a>
    <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'bb_tb']) }}" 
       class="btn {{ $indikator == 'bb_tb' ? 'btn-primary' : 'btn-outline-secondary' }} btn-sm rounded-pill">
      <i class="fas fa-balance-scale me-1"></i> BB/TB
    </a>
  </div>

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <div style="height: 280px;">
        <canvas id="growthChart"></canvas>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white border-0">
      <h6 class="mb-0">
        <i class="fas fa-info-circle text-primary me-2"></i>Interpretasi
      </h6>
    </div>
    <div class="card-body pt-0">
      <p class="small text-muted mb-3">
        Grafik ini menunjukkan perkembangan pertumbuhan <strong>{{ $selectedAnak->nama }}</strong> berdasarkan indikator 
        @if($indikator == 'bb_u')
        <strong>Berat Badan terhadap Umur (BB/U)</strong>
        @elseif($indikator == 'tb_u')
        <strong>Tinggi Badan terhadap Umur (TB/U)</strong>
        @else
        <strong>Berat Badan terhadap Tinggi Badan (BB/TB)</strong>
        @endif
        dengan standar WHO.
      </p>
      <div class="d-flex flex-wrap gap-2">
        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Normal (> -2 SD)</span>
        <span class="badge bg-warning"><i class="fas fa-exclamation-circle me-1"></i>Risiko (-3 SD s/d -2 SD)</span>
        <span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i>Gangguan (< -3 SD)</span>
      </div>
    </div>
  </div>

  @if($pemeriksaan->count() > 0)
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0">
      <h6 class="mb-0">
        <i class="fas fa-history text-info me-2"></i>Riwayat Pengukuran
      </h6>
    </div>
    <div class="card-body p-0">
      @foreach($pemeriksaan as $p)
      <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
        <div class="d-flex align-items-center">
          <div class="avatar-circle bg-{{ 
              ($indikator == 'bb_u' && $p->bb_u_zscore > -2) || 
              ($indikator == 'tb_u' && $p->tb_u_zscore > -2) || 
              ($indikator == 'bb_tb' && $p->bb_tb_zscore > -2) ? 'success' : 'warning'
            }} text-white me-3" style="width: 36px; height: 36px; font-size: 14px;">
            <i class="fas fa-chart-line"></i>
          </div>
          <div>
            <div class="fw-semibold">{{ \Carbon\Carbon::parse($p->tanggal_periksa)->format('d M Y') }}</div>
            <small class="text-muted">{{ $p->umur_bulan }} bulan</small>
          </div>
        </div>
        <div class="text-end">
          <div class="fw-bold text-primary">
            @if($indikator == 'bb_u')
            {{ $p->berat_badan }} kg
            @elseif($indikator == 'tb_u')
            {{ $p->tinggi_badan }} cm
            @else
            {{ $p->berat_badan }} / {{ $p->tinggi_badan }}
            @endif
          </div>
          <small class="text-muted">Z: {{ number_format($indikator == 'bb_u' ? $p->bb_u_zscore : ($indikator == 'tb_u' ? $p->tb_u_zscore : $p->bb_tb_zscore), 2) }}</small>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @else
  <div class="text-center py-5">
    <div class="avatar-circle bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 36px;">
      <i class="fas fa-chart-line"></i>
    </div>
    <h5 class="text-muted">Belum ada data pemeriksaan</h5>
    <p class="text-muted small">Silakan lakukan pemeriksaan terlebih dahulu</p>
  </div>
  @endif
  @else
  <div class="text-center py-5">
    <div class="avatar-circle bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 36px;">
      <i class="fas fa-child"></i>
    </div>
    <h5 class="text-muted">Silakan pilih anak</h5>
    <p class="text-muted small">Pilih anak untuk melihat grafik pertumbuhan</p>
  </div>
  @endif
</div>
@endsection
