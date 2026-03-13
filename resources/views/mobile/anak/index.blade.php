@extends('mobile.layout.master')

@section('title', 'Data Anak')

@section('header')
  @include('mobile.layout.header')
@endsection

@section('content')
<div class="mobile-content pb-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-1">Data Anak</h4>
      <p class="text-muted small mb-0">{{ $anaks->count() }} anak terdaftar</p>
    </div>
  </div>

  @forelse($anaks as $anak)
  <div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
      <div class="d-flex align-items-start">
        <div class="avatar-circle bg-{{ $anak->jenis_kelamin == 'L' ? 'primary' : 'info' }} text-white me-3" style="width: 64px; height: 64px; font-size: 28px;">
          {{ substr($anak->nama, 0, 1) }}
        </div>
        <div class="flex-grow-1">
          <h5 class="mb-1">{{ $anak->nama }}</h5>
          <p class="text-muted small mb-2">
            <i class="fas fa-venus-mars me-1"></i>
            {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
            <span class="mx-2">|</span>
            <i class="fas fa-birthday-cake me-1"></i>
            {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d M Y') }}
          </p>
          <div class="d-flex gap-2">
            <span class="badge bg-secondary">
              <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bulan
            </span>
            @if($anak->latestPemeriksaan && $anak->latestPemeriksaan->status_gizi_akhir)
            <span class="badge bg-{{ 
                $anak->latestPemeriksaan->status_gizi_akhir == 'normal' ? 'success' : 
                ($anak->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $anak->latestPemeriksaan->status_gizi_akhir == 'wasting' ? 'danger' : 
                ($anak->latestPemeriksaan->status_gizi_akhir == 'stunting' || $anak->latestPemeriksaan->status_gizi_akhir == 'underweight' ? 'warning' : 'primary'))
            }}">
              {{ ucfirst(str_replace('_', ' ', $anak->latestPemeriksaan->status_gizi_akhir)) }}
            </span>
            @else
            <span class="badge bg-secondary">Belum</span>
            @endif
          </div>
        </div>
      </div>
      
      @if($anak->latestPemeriksaan)
      <hr class="my-3">
      <div class="row text-center">
        <div class="col-4">
          <div class="p-2 bg-light rounded">
            <div class="text-muted small">Berat</div>
            <div class="fw-bold text-primary">{{ $anak->latestPemeriksaan->berat_badan }} <small class="text-muted">kg</small></div>
          </div>
        </div>
        <div class="col-4">
          <div class="p-2 bg-light rounded">
            <div class="text-muted small">Tinggi</div>
            <div class="fw-bold text-success">{{ $anak->latestPemeriksaan->tinggi_badan }} <small class="text-muted">cm</small></div>
          </div>
        </div>
        <div class="col-4">
          <div class="p-2 bg-light rounded">
            <div class="text-muted small">Terakhir</div>
            <div class="fw-bold text-info">{{ \Carbon\Carbon::parse($anak->latestPemeriksaan->tanggal_periksa)->format('d/m') }}</div>
          </div>
        </div>
      </div>
      @endif
      
      <a href="{{ route('mobile.anak.show', $anak->id) }}" class="btn btn-primary w-100 mt-3">
        <i class="fas fa-eye me-2"></i>Lihat Detail
      </a>
    </div>
  </div>
  @empty
  <div class="text-center py-5">
    <div class="avatar-circle bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 36px;">
      <i class="fas fa-child"></i>
    </div>
    <h5 class="text-muted">Tidak ada data anak</h5>
    <p class="text-muted small">Silakan hubungi tenaga kesehatan untuk mendaftarkan anak Anda</p>
  </div>
  @endforelse
</div>
@endsection
