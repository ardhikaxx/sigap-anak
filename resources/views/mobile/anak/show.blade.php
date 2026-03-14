@extends('mobile.layout.master')

@section('title', 'Profil ' . $anak->nama)

@section('content')
<div class="mobile-content pt-0">
  <div class="greeting-card mb-4" style="border-radius: 0 0 30px 30px; margin: 0 -16px; padding: 40px 24px 30px;">
    <div class="d-flex align-items-center gap-3">
      <a href="{{ route('mobile.anak.index') }}" class="avatar-circle bg-glass shadow-none" style="width: 40px; height: 40px; color: white; text-decoration: none;">
        <i class="fas fa-arrow-left"></i>
      </a>
      <h1 class="greeting-name mb-0" style="font-size: 1.3rem;">Profil Anak</h1>
    </div>
    
    <div class="text-center mt-4">
      <div class="avatar-circle mx-auto mb-3 shadow-lg avatar-{{ $anak->jenis_kelamin == 'L' ? 'blue' : 'pink' }}" style="width: 90px; height: 90px; font-size: 2.5rem; border: 4px solid rgba(255,255,255,0.3);">
        {{ substr($anak->nama, 0, 1) }}
      </div>
      <h2 class="greeting-name">{{ $anak->nama }}</h2>
      <div class="d-flex justify-content-center gap-2 mt-2">
        <span class="badge-custom bg-glass text-white px-3">
          <i class="fas fa-{{ $anak->jenis_kelamin == 'L' ? 'mars' : 'venus' }} me-1"></i>
          {{ $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
        </span>
        <span class="badge-custom bg-glass text-white px-3">
          <i class="fas fa-birthday-cake me-1"></i>
          {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} Bulan
        </span>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-6">
      <div class="card-custom p-3 text-center h-100">
        <div class="user-meta mb-1">Berat Terakhir</div>
        <div class="h3 mb-0 fw-800 text-primary">{{ $latestPemeriksaan->berat_badan ?? '-' }} <small class="fs-6 fw-normal">kg</small></div>
      </div>
    </div>
    <div class="col-6">
      <div class="card-custom p-3 text-center h-100">
        <div class="user-meta mb-1">Tinggi Terakhir</div>
        <div class="h3 mb-0 fw-800 text-secondary">{{ $latestPemeriksaan->tinggi_badan ?? '-' }} <small class="fs-6 fw-normal">cm</small></div>
      </div>
    </div>
  </div>

  <div class="card-custom mb-4 overflow-hidden">
    <div class="card-header-custom bg-light border-0 py-3">
      <h5 class="mb-0 fs-6 fw-800"><i class="fas fa-heartbeat me-2 text-danger"></i>Status Gizi Terbaru</h5>
    </div>
    <div class="card-body-custom p-4 text-center">
      @if($latestPemeriksaan && $latestPemeriksaan->status_gizi_akhir)
        <div class="mb-2">
          <span class="badge-custom @if($latestPemeriksaan->status_gizi_akhir == 'normal') badge-normal @elseif($latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $latestPemeriksaan->status_gizi_akhir == 'wasting') badge-danger @else badge-warning @endif py-2 px-4 fs-6">
            {{ ucfirst(str_replace('_', ' ', $latestPemeriksaan->status_gizi_akhir)) }}
          </span>
        </div>
        <p class="user-meta mb-0 mt-3">Diperiksa pada {{ \Carbon\Carbon::parse($latestPemeriksaan->tanggal_periksa)->format('d M Y') }}</p>
      @else
        <div class="empty-state py-2">
          <div class="empty-icon" style="width: 50px; height: 50px;"><i class="fas fa-info-circle fs-4"></i></div>
          <p class="empty-text mb-0">Belum ada data pemeriksaan terbaru</p>
        </div>
      @endif
    </div>
  </div>

  <h4 class="section-title mb-3">
    <i class="fas fa-th-large text-primary"></i> Menu Anak
  </h4>
  <div class="quick-actions mb-4">
    <a href="{{ route('mobile.grafik.index', ['anak' => $anak->id]) }}" class="quick-action-btn">
      <div class="action-icon" style="background: var(--sigap-primary);">
        <i class="fas fa-chart-line"></i>
      </div>
      <span>Grafik</span>
    </a>
    <a href="{{ route('mobile.konsultasi.create', ['anak' => $anak->id]) }}" class="quick-action-btn">
      <div class="action-icon" style="background: var(--sigap-warning);">
        <i class="fas fa-comments"></i>
      </div>
      <span>Tanya Nakes</span>
    </a>
    <a href="#" class="quick-action-btn">
      <div class="action-icon" style="background: var(--sigap-secondary);">
        <i class="fas fa-syringe"></i>
      </div>
      <span>Imunisasi</span>
    </a>
    <a href="#" class="quick-action-btn">
      <div class="action-icon" style="background: var(--sigap-info);">
        <i class="fas fa-utensils"></i>
      </div>
      <span>Gizi</span>
    </a>
  </div>

  <div class="card-custom mb-4">
    <div class="card-header-custom py-3 border-0">
      <h5 class="mb-0 fs-6 fw-800"><i class="fas fa-info-circle me-2 text-primary"></i>Informasi Lainnya</h5>
    </div>
    <div class="card-body-custom p-0">
      <div class="d-flex align-items-center p-3 border-bottom">
        <div class="avatar-circle avatar-blue me-3" style="width: 40px; height: 40px; border-radius: 10px; opacity: 0.1;"></div>
        <div class="flex-grow-1">
          <div class="user-meta" style="font-size: 0.75rem;">NIK Anak</div>
          <div class="fw-bold">{{ $anak->nik_anak ?? '-' }}</div>
        </div>
        <i class="fas fa-id-card text-muted opacity-50"></i>
      </div>
      <div class="d-flex align-items-center p-3 border-bottom">
        <div class="avatar-circle avatar-green me-3" style="width: 40px; height: 40px; border-radius: 10px; opacity: 0.1;"></div>
        <div class="flex-grow-1">
          <div class="user-meta" style="font-size: 0.75rem;">Puskesmas / Faskes</div>
          <div class="fw-bold">{{ $anak->faskes->nama ?? '-' }}</div>
        </div>
        <i class="fas fa-hospital text-muted opacity-50"></i>
      </div>
      <div class="d-flex align-items-center p-3">
        <div class="avatar-circle avatar-red me-3" style="width: 40px; height: 40px; border-radius: 10px; opacity: 0.1;"></div>
        <div class="flex-grow-1">
          <div class="user-meta" style="font-size: 0.75rem;">Tanggal Lahir</div>
          <div class="fw-bold">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') }}</div>
        </div>
        <i class="fas fa-calendar-alt text-muted opacity-50"></i>
      </div>
    </div>
  </div>
</div>
@endsection
