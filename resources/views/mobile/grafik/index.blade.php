@extends('mobile.layout.master')

@section('title', 'Grafik Pertumbuhan')

@section('content')
<div class="mobile-content">
  <h3 class="section-title">Grafik Pertumbuhan</h3>
  
  <div class="mobile-form-group">
    <label>Pilih Anak</label>
    <select class="form-select" id="selectAnak" onchange="filterAnak()">
      <option value="">-- Pilih Anak --</option>
      @foreach($anak as $a)
      <option value="{{ $a->id }}" {{ $selectedAnak && $selectedAnak->id == $a->id ? 'selected' : '' }}>
        {{ $a->nama }}
      </option>
      @endforeach
    </select>
  </div>

  @if($selectedAnak)
  <div class="chart-select mb-3">
    <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'bb_u']) }}" 
       class="btn {{ $indikator == 'bb_u' ? 'btn-primary' : 'btn-outline-secondary' }} btn-sm">
      BB/U
    </a>
    <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'tb_u']) }}" 
       class="btn {{ $indikator == 'tb_u' ? 'btn-primary' : 'btn-outline-secondary' }} btn-sm">
      TB/U
    </a>
    <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'bb_tb']) }}" 
       class="btn {{ $indikator == 'bb_tb' ? 'btn-primary' : 'btn-outline-secondary' }} btn-sm">
      BB/TB
    </a>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <div style="height: 300px;">
        <canvas id="growthChart"></canvas>
      </div>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-header">
      <h6 class="mb-0">Interpretasi</h6>
    </div>
    <div class="card-body">
      <p class="small text-muted">
        Grafik ini menunjukkan perkembangan pertumbuhan {{ $selectedAnak->nama }} berdasarkan indikator 
        @if($indikator == 'bb_u')
        Berat Badan terhadap Umur (BB/U)
        @elseif($indikator == 'tb_u')
        Tinggi Badan terhadap Umur (TB/U)
        @else
        Berat Badan terhadap Tinggi Badan (BB/TB)
        @endif
        dengan standar WHO.
      </p>
      <div class="d-flex flex-wrap gap-2">
        <span class="badge bg-success">Normal (> -2 SD)</span>
        <span class="badge bg-warning">Risiko (-3 SD s/d -2 SD)</span>
        <span class="badge bg-danger">Gangguan (< -3 SD)</span>
      </div>
    </div>
  </div>

  @if($pemeriksaan->count() > 0)
  <h6 class="mb-2">Riwayat Pengukuran</h6>
  <div class="mobile-list-item flex-column align-items-start" style="gap: 8px;">
    @foreach($pemeriksaan as $p)
    <div class="d-flex justify-content-between w-100">
      <span>{{ \Carbon\Carbon::parse($p->tanggal_periksa)->format('d M Y') }}</span>
      <span class="fw-bold">
        @if($indikator == 'bb_u')
        {{ $p->berat_badan }} kg (Z: {{ number_format($p->bb_u_zscore, 2) }})
        @elseif($indikator == 'tb_u')
        {{ $p->tinggi_badan }} cm (Z: {{ number_format($p->tb_u_zscore, 2) }})
        @else
        {{ $p->berat_badan }} kg / {{ $p->tinggi_badan }} cm (Z: {{ number_format($p->bb_tb_zscore, 2) }})
        @endif
      </span>
    </div>
    @endforeach
  </div>
  @else
  <div class="text-center py-4">
    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
    <p class="text-muted">Belum ada data pemeriksaan</p>
  </div>
  @endif
  @else
  <div class="text-center py-5">
    <i class="fas fa-child fa-4x text-muted mb-3"></i>
    <p class="text-muted">Silakan pilih anak terlebih dahulu</p>
  </div>
  @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function filterAnak() {
  const select = document.getElementById('selectAnak');
  const selectedValue = select.value;
  if (selectedValue) {
    window.location.href = '{{ route("mobile.grafik.index") }}?anak_id=' + selectedValue + '&indikator={{ $indikator }}';
  }
}

@if($selectedAnak && $pemeriksaan->count() > 0)
const ctx = document.getElementById('growthChart').getContext('2d');
const labels = {!! json_encode($pemeriksaan->pluck('tanggal_periksa')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M Y'))) !!};
const dataValues = {!! json_encode($pemeriksaan->pluck($indikator . '_zscore')) !!};

new Chart(ctx, {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{
      label: 'Z-Score',
      data: dataValues,
      borderColor: '#2E86AB',
      backgroundColor: '#2E86AB20',
      tension: 0.3,
      fill: true
    }, {
      label: 'Median (0)',
      data: labels.map(() => 0),
      borderColor: '#ccc',
      borderDash: [5, 5],
      pointRadius: 0
    }, {
      label: '+2 SD',
      data: labels.map(() => 2),
      borderColor: '#FFB347',
      borderDash: [5, 5],
      pointRadius: 0
    }, {
      label: '-2 SD',
      data: labels.map(() => -2),
      borderColor: '#FFB347',
      borderDash: [5, 5],
      pointRadius: 0
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: { min: -4, max: 4 }
    }
  }
});
@endif
</script>
@endsection
