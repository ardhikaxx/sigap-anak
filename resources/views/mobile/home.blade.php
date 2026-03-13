@extends('mobile.layout.master')

@section('title', 'Beranda')
@section('header')
  @include('mobile.layout.header')
@endsection

@section('content')
<div class="mobile-content pb-5">
  <div class="greeting-card mb-4">
    <div class="d-flex justify-content-between align-items-start">
      <div>
        <p class="greeting-text mb-1">{{ $greeting }},</p>
        <h1 class="greeting-name">{{ $user->name }}</h1>
      </div>
      <div class="avatar-circle bg-white text-primary" style="width: 48px; height: 48px; font-size: 20px;">
        {{ substr($user->name, 0, 1) }}
      </div>
    </div>
    <p class="text-white-50 mt-2 mb-0">Selamat datang di SIGAP Anak</p>
  </div>

  <div class="quick-actions mb-4">
    <a href="{{ route('mobile.anak.index') }}" class="quick-action-btn">
      <div class="action-icon bg-primary">
        <i class="fas fa-child"></i>
      </div>
      <span>Anak Saya</span>
    </a>
    <a href="{{ route('mobile.grafik.index') }}" class="quick-action-btn">
      <div class="action-icon bg-success">
        <i class="fas fa-chart-line"></i>
      </div>
      <span>Grafik</span>
    </a>
    <a href="{{ route('mobile.konsultasi.index') }}" class="quick-action-btn">
      <div class="action-icon bg-warning">
        <i class="fas fa-comments"></i>
      </div>
      <span>Konsultasi</span>
    </a>
    <a href="#" class="quick-action-btn">
      <div class="action-icon bg-info">
        <i class="fas fa-utensils"></i>
      </div>
      <span>Makan</span>
    </a>
  </div>

  @if($anak->count() > 0)
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="section-title mb-0">
      <i class="fas fa-child text-primary me-2"></i>Anak Saya
    </h4>
    <span class="badge bg-primary rounded-pill">{{ $anak->count() }}</span>
  </div>
  
  <div class="mobile-anak-list mb-4">
    @foreach($anak as $item)
    <a href="{{ route('mobile.anak.show', $item->id) }}" class="mobile-anak-card">
      <div class="avatar-circle bg-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'info' }} text-white" style="width: 56px; height: 56px; font-size: 24px;">
        {{ substr($item->nama, 0, 1) }}
      </div>
      <div class="info flex-grow-1">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <h4 class="nama mb-1">{{ $item->nama }}</h4>
            <p class="usia mb-1">
              <i class="fas fa-birthday-cake me-1"></i>
              {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}
            </p>
          </div>
          <i class="fas fa-chevron-right text-muted"></i>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2">
          <span class="text-muted small">
            <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->diffInMonths(now()) }} bulan
          </span>
          @if($item->latestPemeriksaan && $item->latestPemeriksaan->status_gizi_akhir)
          <span class="badge bg-{{ 
              $item->latestPemeriksaan->status_gizi_akhir == 'normal' ? 'success' : 
              ($item->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $item->latestPemeriksaan->status_gizi_akhir == 'wasting' ? 'danger' : 
              ($item->latestPemeriksaan->status_gizi_akhir == 'stunting' || $item->latestPemeriksaan->status_gizi_akhir == 'underweight' ? 'warning' : 'primary'))
          }}">
            {{ ucfirst(str_replace('_', ' ', $item->latestPemeriksaan->status_gizi_akhir)) }}
          </span>
          @else
          <span class="badge bg-secondary">Belum Periksa</span>
          @endif
        </div>
      </div>
    </a>
    @endforeach
  </div>
  @else
  <div class="card text-center py-5 mb-4">
    <i class="fas fa-child fa-4x text-muted mb-3"></i>
    <h5 class="text-muted">Belum ada data anak</h5>
    <p class="text-muted small">Silakan hubungi tenaga kesehatan untuk mendaftarkan anak Anda</p>
  </div>
  @endif

  @if($jadwalMendatang->count() > 0)
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="section-title mb-0">
      <i class="fas fa-calendar-check text-success me-2"></i>Jadwal Posyandu
    </h4>
    <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
  </div>
  
  <div class="card mb-4 border-0 shadow-sm">
    @foreach($jadwalMendatang->take(3) as $jadwal)
    <div class="mobile-list-item border-0">
      <div class="icon bg-success bg-opacity-10">
        <i class="fas fa-calendar text-success"></i>
      </div>
      <div class="flex-grow-1">
        <div class="label fw-semibold">{{ $jadwal->tema ?? 'Posyandu' }}</div>
        <div class="value text-muted small">
          <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endif

  @if($artikel->count() > 0)
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="section-title mb-0">
      <i class="fas fa-book-medical text-info me-2"></i>Artikel Edukasi
    </h4>
    <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
  </div>
  
  <div class="mobile-anak-list mb-4">
    @foreach($artikel->take(3) as $article)
    <a href="#" class="mobile-anak-card">
      <div class="avatar-circle bg-info text-white" style="width: 56px; height: 56px; font-size: 24px;">
        <i class="fas fa-book-open"></i>
      </div>
      <div class="info flex-grow-1">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <h4 class="nama mb-1">{{ $article->judul }}</h4>
            <span class="badge bg-{{ 
                $article->kategori == 'nutrisi' ? 'success' : 
                ($article->kategori == 'imunisasi' ? 'primary' : 
                ($article->kategori == 'perkembangan' ? 'warning' : 'info'))
            }}">{{ ucfirst($article->kategori) }}</span>
          </div>
          <i class="fas fa-chevron-right text-muted"></i>
        </div>
      </div>
    </a>
    @endforeach
  </div>
  @endif
</div>
@endsection
