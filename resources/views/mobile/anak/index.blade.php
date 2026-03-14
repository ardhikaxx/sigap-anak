@extends('mobile.layout.master')

@section('title', 'Data Anak Saya')

@section('content')
<div class="mobile-content pt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="section-title mb-1">
        <i class="fas fa-children text-primary"></i> Data Anak
      </h4>
      <p class="user-meta mb-0">{{ $anaks->count() }} anak terdaftar</p>
    </div>
    <div class="avatar-circle avatar-blue shadow-sm" style="width: 44px; height: 44px; opacity: 0.1;"></div>
  </div>

  @forelse($anaks as $anak)
  <a href="{{ route('mobile.anak.show', $anak->id) }}" class="mobile-anak-card p-0 overflow-hidden d-block">
    <div class="p-3 d-flex align-items-center gap-3">
      <div class="avatar-circle avatar-{{ $anak->jenis_kelamin == 'L' ? 'blue' : 'pink' }}" style="width: 60px; height: 60px; border-radius: 18px; font-size: 1.5rem; flex-shrink: 0;">
        {{ substr($anak->nama, 0, 1) }}
      </div>
      <div class="flex-grow-1">
        <h5 class="nama mb-1">{{ $anak->nama }}</h5>
        <div class="usia mb-2">
          <i class="fas fa-birthday-cake me-1"></i>
          {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} Bulan
          <span class="mx-1">•</span>
          <i class="fas fa-{{ $anak->jenis_kelamin == 'L' ? 'mars' : 'venus' }} me-1"></i>
          {{ $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
        </div>
        <div class="d-flex gap-2">
          @if($anak->latestPemeriksaan && $anak->latestPemeriksaan->status_gizi_akhir)
            <span class="badge-custom @if($anak->latestPemeriksaan->status_gizi_akhir == 'normal') badge-normal @elseif($anak->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $anak->latestPemeriksaan->status_gizi_akhir == 'wasting') badge-danger @else badge-warning @endif">
              {{ ucfirst(str_replace('_', ' ', $anak->latestPemeriksaan->status_gizi_akhir)) }}
            </span>
          @else
            <span class="badge-custom badge-default">Belum Periksa</span>
          @endif
        </div>
      </div>
      <i class="fas fa-chevron-right text-muted me-3 opacity-50"></i>
    </div>
    
    @if($anak->latestPemeriksaan)
    <div class="bg-light bg-opacity-50 p-3 border-top d-flex justify-content-around text-center">
      <div>
        <div class="user-meta" style="font-size: 0.7rem;">Berat</div>
        <div class="fw-bold text-dark">{{ $anak->latestPemeriksaan->berat_badan }} <small class="fw-normal text-muted">kg</small></div>
      </div>
      <div class="vr opacity-10"></div>
      <div>
        <div class="user-meta" style="font-size: 0.7rem;">Tinggi</div>
        <div class="fw-bold text-dark">{{ $anak->latestPemeriksaan->tinggi_badan }} <small class="fw-normal text-muted">cm</small></div>
      </div>
      <div class="vr opacity-10"></div>
      <div>
        <div class="user-meta" style="font-size: 0.7rem;">Update</div>
        <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($anak->latestPemeriksaan->tanggal_periksa)->format('d/m') }}</div>
      </div>
    </div>
    @endif
  </a>
  @empty
  <div class="empty-state py-5 mt-4 card-custom border-dashed">
    <div class="empty-icon shadow-none" style="background: var(--sigap-gray-light);"><i class="fas fa-child"></i></div>
    <h5 class="empty-title">Tidak ada data anak</h5>
    <p class="empty-text px-4">Silakan hubungi tenaga kesehatan untuk mendaftarkan anak Anda ke sistem</p>
  </div>
  @endforelse

  <div class="card-custom bg-glass mt-4 p-4 text-center border-0 shadow-sm" style="background: linear-gradient(135deg, rgba(46, 134, 171, 0.05), rgba(87, 204, 153, 0.05));">
    <i class="fas fa-info-circle text-primary mb-2 fs-4"></i>
    <p class="user-meta mb-0">Butuh bantuan pendaftaran? <br> <a href="{{ route('mobile.konsultasi.index') }}" class="text-primary fw-bold text-decoration-none">Hubungi Petugas Kesehatan</a></p>
  </div>
</div>
@endsection
