@extends('mobile.layout.master')

@section('title', 'Beranda')

@section('content')
<div class="mobile-content">
  <div class="greeting-card mb-4">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <p class="greeting-text">{{ $greeting }},</p>
        <h1 class="greeting-name">{{ $user->name }}</h1>
      </div>
      <div class="avatar-circle bg-glass" style="width: 50px; height: 50px; border-radius: 15px; color: var(--sigap-primary);">
        {{ substr($user->name, 0, 1) }}
      </div>
    </div>
  </div>

  <div class="quick-actions">
    <a href="{{ route('mobile.anak.index') }}" class="quick-action-btn">
      <div class="action-icon" style="background: var(--sigap-primary);">
        <i class="fas fa-child"></i>
      </div>
      <span>Anak Saya</span>
    </a>
    <a href="{{ route('mobile.grafik.index') }}" class="quick-action-btn">
      <div class="action-icon" style="background: var(--sigap-secondary);">
        <i class="fas fa-chart-line"></i>
      </div>
      <span>Grafik</span>
    </a>
    <a href="{{ route('mobile.konsultasi.index') }}" class="quick-action-btn">
      <div class="action-icon" style="background: var(--sigap-warning);">
        <i class="fas fa-comments"></i>
      </div>
      <span>Konsultasi</span>
    </a>
    <a href="#" class="quick-action-btn">
      <div class="action-icon" style="background: var(--sigap-info);">
        <i class="fas fa-utensils"></i>
      </div>
      <span>Makan</span>
    </a>
  </div>

  @if($anak->count() > 0)
  <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
    <h4 class="section-title mb-0">
      <i class="fas fa-child text-primary"></i> Anak Saya
    </h4>
    <span class="badge-custom badge-info">{{ $anak->count() }} Anak</span>
  </div>
  
  @foreach($anak as $item)
  <a href="{{ route('mobile.anak.show', $item->id) }}" class="mobile-anak-card">
    <div class="avatar-circle avatar-{{ $item->jenis_kelamin == 'L' ? 'blue' : 'pink' }}" style="width: 56px; height: 56px; border-radius: 16px;">
      {{ substr($item->nama, 0, 1) }}
    </div>
    <div class="flex-grow-1">
      <h4 class="nama mb-1">{{ $item->nama }}</h4>
      <div class="usia">
        <i class="fas fa-birthday-cake me-1"></i>
        {{ \Carbon\Carbon::parse($item->tanggal_lahir)->diffInMonths(now()) }} Bulan
      </div>
      <div class="mt-2">
        @if($item->latestPemeriksaan && $item->latestPemeriksaan->status_gizi_akhir)
        <span class="badge-custom @if($item->latestPemeriksaan->status_gizi_akhir == 'normal') badge-normal @elseif($item->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $item->latestPemeriksaan->status_gizi_akhir == 'wasting') badge-danger @else badge-warning @endif">
          {{ ucfirst(str_replace('_', ' ', $item->latestPemeriksaan->status_gizi_akhir)) }}
        </span>
        @else
        <span class="badge-custom badge-default">Belum Periksa</span>
        @endif
      </div>
    </div>
    <i class="fas fa-chevron-right text-muted"></i>
  </a>
  @endforeach
  @else
  <div class="card-custom py-5 text-center mt-4">
    <div class="empty-icon"><i class="fas fa-child"></i></div>
    <div class="empty-title">Belum Ada Data Anak</div>
    <div class="empty-text">Hubungi nakes untuk mendaftarkan anak</div>
  </div>
  @endif

  @if($jadwalMendatang->count() > 0)
  <h4 class="section-title mb-3 mt-4">
    <i class="fas fa-calendar-check text-secondary"></i> Jadwal Posyandu
  </h4>
  <div class="card-custom p-2">
    @foreach($jadwalMendatang->take(3) as $jadwal)
    <div class="d-flex align-items-center p-3 @if(!$loop->last) border-bottom @endif">
      <div class="avatar-circle avatar-green me-3" style="width: 44px; height: 44px; border-radius: 12px; background: rgba(87, 204, 153, 0.1); color: var(--sigap-secondary);">
        <i class="fas fa-calendar-day"></i>
      </div>
      <div class="flex-grow-1">
        <div style="font-weight: 700; font-size: 0.95rem;">{{ $jadwal->tema ?? 'Posyandu' }}</div>
        <div style="font-size: 0.8rem; color: var(--sigap-gray);">
          {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} • {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
        </div>
      </div>
      <i class="fas fa-angle-right text-muted"></i>
    </div>
    @endforeach
  </div>
  @endif

  @if($artikel->count() > 0)
  <h4 class="section-title mb-3 mt-4">
    <i class="fas fa-book-medical text-info"></i> Artikel Edukasi
  </h4>
  @foreach($artikel->take(3) as $article)
  <a href="#" class="mobile-anak-card">
    <div class="avatar-circle avatar-purple" style="width: 48px; height: 48px; border-radius: 14px;">
      <i class="fas fa-book-open"></i>
    </div>
    <div class="flex-grow-1">
      <h4 class="nama mb-1" style="font-size: 1rem;">{{ $article->judul }}</h4>
      <span class="badge-custom badge-info">{{ ucfirst($article->kategori) }}</span>
    </div>
    <i class="fas fa-chevron-right text-muted"></i>
  </a>
  @endforeach
  @endif
</div>
@endsection
