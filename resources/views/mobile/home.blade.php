@extends('mobile.layout.master')

@section('title', 'Beranda')
@section('header')
  @include('mobile.layout.header')
@endsection

@section('content')
<div class="mobile-content">
  <div class="greeting-card">
    <p class="greeting-text">{{ $greeting }},</p>
    <h1 class="greeting-name">{{ $user->name }}</h1>
  </div>

  <div class="quick-actions">
    <a href="{{ route('mobile.anak.index') }}" class="quick-action-btn">
      <i class="fas fa-child"></i>
      <span>Anak Saya</span>
    </a>
    <a href="{{ route('mobile.grafik.index') }}" class="quick-action-btn">
      <i class="fas fa-chart-line"></i>
      <span>Grafik</span>
    </a>
    <a href="{{ route('mobile.konsultasi.index') }}" class="quick-action-btn">
      <i class="fas fa-comments"></i>
      <span>Konsultasi</span>
    </a>
    <a href="#" class="quick-action-btn">
      <i class="fas fa-utensils"></i>
      <span>Makan</span>
    </a>
  </div>

  <h3 class="section-title">Anak Saya</h3>
  <div class="mobile-anak-list">
    @forelse($anak as $item)
    <a href="{{ route('mobile.anak.show', $item->id) }}" class="mobile-anak-card">
      <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://via.placeholder.com/100' }}" 
           class="avatar" 
           alt="{{ $item->nama }}"
           onerror="this.src='https://via.placeholder.com/100'">
      <div class="info">
        <h4 class="nama">{{ $item->nama }}</h4>
        <p class="usia">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->diffInMonths(now()) }} bulan</p>
        @if($item->latestPemeriksaan)
        <span class="status-badge {{ $item->latestPemeriksaan->status_gizi_akhir }}">
          {{ ucfirst($item->latestPemeriksaan->status_gizi_akhir ?? 'belum') }}
        </span>
        @else
        <span class="status-badge">Belum periksa</span>
        @endif
      </div>
      <i class="fas fa-chevron-right arrow"></i>
    </a>
    @empty
    <div class="text-center py-4">
      <i class="fas fa-child fa-3x text-muted mb-3"></i>
      <p class="text-muted">Belum ada data anak</p>
      <a href="#" class="btn btn-primary">Tambah Anak</a>
    </div>
    @endforelse
  </div>

  @if($jadwalMendatang->count() > 0)
  <h3 class="section-title mt-4">Jadwal Posyandu</h3>
  @foreach($jadwalMendatang as $jadwal)
  <div class="mobile-list-item">
    <div class="icon">
      <i class="fas fa-calendar"></i>
    </div>
    <div style="flex: 1;">
      <div class="label">{{ $jadwal->tema ?? 'Posyandu' }}</div>
      <div class="value">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} - {{ $jadwal->jam_mulai }}</div>
    </div>
  </div>
  @endforeach
  @endif

  @if($artikel->count() > 0)
  <h3 class="section-title mt-4">Artikel Edukasi</h3>
  <div class="mobile-anak-list">
    @foreach($artikel as $article)
    <a href="#" class="mobile-anak-card">
      <img src="{{ $article->gambar ? asset('storage/'.$article->gambar) : 'https://via.placeholder.com/100' }}" 
           class="avatar" 
           alt="{{ $article->judul }}"
           onerror="this.src='https://via.placeholder.com/100'">
      <div class="info">
        <h4 class="nama">{{ $article->judul }}</h4>
        <p class="usia">{{ $article->kategori }}</p>
      </div>
      <i class="fas fa-chevron-right arrow"></i>
    </a>
    @endforeach
  </div>
  @endif
</div>
@endsection
