@extends('mobile.layout.master')

@section('title', 'Grafik Pertumbuhan')

@section('content')
<div class="mobile-content pt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="section-title mb-1">
        <i class="fas fa-chart-line text-primary"></i> Grafik Tumbuh
      </h4>
      <p class="user-meta mb-0">Pantau progres pertumbuhan si kecil</p>
    </div>
  </div>
  
  <div class="card-custom mb-4 p-3 bg-glass border-0">
    <label class="form-label fw-bold text-muted small mb-2 ms-1">Pilih Data Anak</label>
    <select class="form-select border-0 bg-light py-3 rounded-4" id="selectAnak" onchange="filterAnak()">
      <option value="">-- Pilih Anak --</option>
      @foreach($anak as $a)
      <option value="{{ $a->id }}" {{ $selectedAnak && $selectedAnak->id == $a->id ? 'selected' : '' }}>
        {{ $a->nama }} ({{ $a->jenis_kelamin === 'L' ? 'L' : 'P' }})
      </option>
      @endforeach
    </select>
  </div>

  @if($selectedAnak)
  <div class="indicator-nav d-flex gap-2 mb-4 overflow-auto pb-2" style="scrollbar-width: none;">
    <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'bb_u']) }}" 
       class="btn-indicator {{ $indikator == 'bb_u' ? 'active' : '' }}">
      <i class="fas fa-weight"></i> BB/U
    </a>
    <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'tb_u']) }}" 
       class="btn-indicator {{ $indikator == 'tb_u' ? 'active' : '' }}">
      <i class="fas fa-ruler-vertical"></i> TB/U
    </a>
    <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'bb_tb']) }}" 
       class="btn-indicator {{ $indikator == 'bb_tb' ? 'active' : '' }}">
      <i class="fas fa-balance-scale"></i> BB/TB
    </a>
  </div>

  <div class="card-custom mb-4 p-2 shadow-sm">
    <div style="height: 280px; width: 100%;">
      <canvas id="growthChart"></canvas>
    </div>
  </div>

  <div class="card-custom mb-4 overflow-hidden">
    <div class="card-header-custom py-3 border-0 bg-light bg-opacity-50">
      <h6 class="mb-0 fs-7 fw-bold"><i class="fas fa-info-circle text-primary me-2"></i>Keterangan Grafik</h6>
    </div>
    <div class="card-body-custom p-3">
      <p class="user-meta mb-3" style="font-size: 0.8rem; line-height: 1.5;">
        Grafik menunjukkan posisi <strong>{{ $selectedAnak->nama }}</strong> pada kurva pertumbuhan WHO untuk indikator 
        <span class="text-primary fw-bold">
          @if($indikator == 'bb_u') Berat terhadap Umur @elseif($indikator == 'tb_u') Tinggi terhadap Umur @else Berat terhadap Tinggi @endif
        </span>.
      </p>
      <div class="d-flex flex-wrap gap-2">
        <span class="badge-custom badge-normal py-1 px-2" style="font-size: 0.65rem;">Garis Hijau (Normal)</span>
        <span class="badge-custom badge-warning py-1 px-2" style="font-size: 0.65rem;">Garis Kuning (Waspada)</span>
        <span class="badge-custom badge-danger py-1 px-2" style="font-size: 0.65rem;">Garis Merah (Bahaya)</span>
      </div>
    </div>
  </div>

  <h4 class="section-title mb-3 fs-6">
    <i class="fas fa-history text-secondary"></i> Riwayat Pengukuran
  </h4>
  <div class="card-custom mb-5">
    <div class="card-body-custom p-0">
      @forelse($pemeriksaan as $p)
      <div class="d-flex justify-content-between align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar-circle @if(($indikator == 'bb_u' && $p->bb_u_zscore > -2) || ($indikator == 'tb_u' && $p->tb_u_zscore > -2) || ($indikator == 'bb_tb' && $p->bb_tb_zscore > -2)) avatar-green @else avatar-yellow @endif" style="width: 40px; height: 40px; border-radius: 10px; font-size: 14px;">
            <i class="fas fa-calendar-day"></i>
          </div>
          <div>
            <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($p->tanggal_periksa)->format('d M Y') }}</div>
            <div class="user-meta" style="font-size: 0.75rem;">Usia: {{ $p->umur_bulan }} bulan</div>
          </div>
        </div>
        <div class="text-end">
          <div class="fw-800 text-primary">
            @if($indikator == 'bb_u') {{ $p->berat_badan }} <small class="fw-normal">kg</small>
            @elseif($indikator == 'tb_u') {{ $p->tinggi_badan }} <small class="fw-normal">cm</small>
            @else {{ $p->berat_badan }} / {{ $p->tinggi_badan }}
            @endif
          </div>
          <div class="user-meta" style="font-size: 0.65rem;">Z-Score: {{ number_format($indikator == 'bb_u' ? $p->bb_u_zscore : ($indikator == 'tb_u' ? $p->tb_u_zscore : $p->bb_tb_zscore), 2) }}</div>
        </div>
      </div>
      @empty
      <div class="p-4 text-center">
        <p class="user-meta mb-0">Belum ada riwayat pengukuran</p>
      </div>
      @endforelse
    </div>
  </div>
  @else
  <div class="empty-state py-5 mt-4 card-custom border-dashed">
    <div class="empty-icon shadow-none" style="background: var(--sigap-gray-light);"><i class="fas fa-child"></i></div>
    <h5 class="empty-title">Pilih Anak</h5>
    <p class="empty-text">Silakan pilih nama anak Anda di atas untuk melihat grafik pertumbuhan lengkap</p>
  </div>
  @endif
</div>

<style>
  .btn-indicator {
    padding: 10px 20px;
    border-radius: 50px;
    background: white;
    color: var(--sigap-gray);
    border: 1px solid var(--sigap-border);
    font-size: 0.85rem;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .btn-indicator.active {
    background: var(--sigap-primary);
    color: white;
    border-color: var(--sigap-primary);
    box-shadow: 0 4px 12px rgba(46, 134, 171, 0.3);
  }
  .indicator-nav::-webkit-scrollbar { display: none; }
</style>

<script>
  function filterAnak() {
    const anakId = document.getElementById('selectAnak').value;
    if (anakId) {
      window.location.href = "{{ route('mobile.grafik.index') }}?anak_id=" + anakId;
    }
  }
</script>
@endsection
