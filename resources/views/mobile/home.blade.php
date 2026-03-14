@extends('mobile.layout.master')

@section('title', 'Beranda')

@push('styles')
<style>
  .premium-hero {
    background: linear-gradient(135deg, #1A1D2E 0%, #2E86AB 50%, #57CC99 100%);
    border-radius: 28px;
    padding: 28px 24px;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
    box-shadow: 0 12px 32px rgba(46, 134, 171, 0.35);
  }

  .premium-hero::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;
    width: 140px;
    height: 140px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
  }

  .premium-hero::after {
    content: '';
    position: absolute;
    bottom: -30px;
    left: -30px;
    width: 100px;
    height: 100px;
    background: rgba(87, 204, 153, 0.15);
    border-radius: 50%;
  }

  .hero-content {
    position: relative;
    z-index: 1;
  }

  .hero-greeting {
    font-size: 0.9rem;
    opacity: 0.85;
    margin-bottom: 4px;
    font-weight: 500;
  }

  .hero-name {
    font-size: 1.5rem;
    font-weight: 800;
    letter-spacing: -0.3px;
    margin-bottom: 0;
  }

  .hero-avatar {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 700;
    border: 2px solid rgba(255,255,255,0.3);
  }

  .menu-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 28px;
  }

  .menu-item {
    background: white;
    border-radius: 20px;
    padding: 16px 8px;
    text-align: center;
    text-decoration: none;
    color: var(--sigap-dark);
    border: 1px solid var(--sigap-border);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
  }

  .menu-item:hover {
    transform: translateY(-4px);
    border-color: var(--sigap-primary);
    box-shadow: 0 8px 20px rgba(46, 134, 171, 0.15);
  }

  .menu-item i {
    font-size: 22px;
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
  }

  .menu-item span {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.2px;
  }

  .menu-item.anak i { background: linear-gradient(135deg, #2E86AB, #1A5F7A); }
  .menu-item.grafik i { background: linear-gradient(135deg, #57CC99, #38A169); }
  .menu-item.konsultasi i { background: linear-gradient(135deg, #F6AD55, #DD6B20); }
  .menu-item.makan i { background: linear-gradient(135deg, #9F7AEA, #6B46C1); }

  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  .section-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--sigap-dark);
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
  }

  .section-badge {
    background: var(--sigap-primary);
    color: white;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
  }

  .child-card {
    background: white;
    border-radius: 22px;
    padding: 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: inherit;
    margin-bottom: 12px;
    border: 1px solid var(--sigap-border);
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    transition: all 0.3s ease;
  }

  .child-card:hover {
    border-color: var(--sigap-primary-light);
    transform: scale(1.01);
    box-shadow: 0 8px 20px rgba(46, 134, 171, 0.12);
  }

  .child-avatar {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    font-weight: 700;
    color: white;
    flex-shrink: 0;
  }

  .child-avatar.laki { background: linear-gradient(135deg, #2E86AB, #1A5F7A); }
  .child-avatar.perempuan { background: linear-gradient(135deg, #EC4899, #BE185D); }

  .child-info { flex: 1; min-width: 0; }

  .child-name {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--sigap-dark);
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .child-age {
    font-size: 0.8rem;
    color: var(--sigap-gray);
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 8px;
  }

  .status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
  }

  .status-badge.normal { background: rgba(87, 204, 153, 0.15); color: #38A169; }
  .status-badge.warning { background: rgba(246, 173, 85, 0.15); color: #DD6B20; }
  .status-badge.danger { background: rgba(245, 101, 101, 0.15); color: #E53E3E; }
  .status-badge.default { background: rgba(160, 174, 192, 0.15); color: #718096; }

  .chevron-icon {
    color: #CBD5E0;
    font-size: 1rem;
  }

  .schedule-card {
    background: white;
    border-radius: 18px;
    padding: 14px;
    margin-bottom: 10px;
    border: 1px solid var(--sigap-border);
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .schedule-icon {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    background: rgba(87, 204, 153, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--sigap-secondary);
    font-size: 1.1rem;
  }

  .schedule-info { flex: 1; }

  .schedule-title {
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--sigap-dark);
    margin-bottom: 2px;
  }

  .schedule-time {
    font-size: 0.75rem;
    color: var(--sigap-gray);
  }

  .empty-state {
    background: white;
    border-radius: 24px;
    padding: 48px 24px;
    text-align: center;
    border: 1px solid var(--sigap-border);
  }

  .empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 24px;
    background: linear-gradient(135deg, rgba(46, 134, 171, 0.1), rgba(87, 204, 153, 0.1));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 2rem;
    color: var(--sigap-primary);
  }

  .empty-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--sigap-dark);
    margin-bottom: 4px;
  }

  .empty-text {
    font-size: 0.85rem;
    color: var(--sigap-gray);
  }

  .article-card {
    background: white;
    border-radius: 18px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: inherit;
    margin-bottom: 10px;
    border: 1px solid var(--sigap-border);
    transition: all 0.2s;
  }

  .article-card:hover {
    border-color: var(--sigap-primary-light);
    transform: translateX(4px);
  }

  .article-icon {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: linear-gradient(135deg, rgba(159, 122, 234, 0.15), rgba(107, 70, 193, 0.15));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6B46C1;
    font-size: 1.1rem;
    flex-shrink: 0;
  }

  .article-title {
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--sigap-dark);
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .article-badge {
    font-size: 0.65rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 8px;
    background: rgba(159, 122, 234, 0.12);
    color: #6B46C1;
    text-transform: uppercase;
  }
</style>
@endpush

@section('content')
<div class="mobile-content">
  <div class="premium-hero mb-4">
    <div class="hero-content d-flex justify-content-between align-items-center">
      <div>
        <p class="hero-greeting">{{ $greeting }}</p>
        <h1 class="hero-name">{{ $user->name }}</h1>
      </div>
      <div class="hero-avatar">{{ substr($user->name, 0, 1) }}</div>
    </div>
  </div>

  <div class="menu-grid">
    <a href="{{ route('mobile.anak.index') }}" class="menu-item anak">
      <i class="fas fa-child"></i>
      <span>Anak Saya</span>
    </a>
    <a href="{{ route('mobile.grafik.index') }}" class="menu-item grafik">
      <i class="fas fa-chart-line"></i>
      <span>Grafik</span>
    </a>
    <a href="{{ route('mobile.konsultasi.index') }}" class="menu-item konsultasi">
      <i class="fas fa-comments"></i>
      <span>Konsultasi</span>
    </a>
    <a href="#" class="menu-item makan">
      <i class="fas fa-utensils"></i>
      <span>Makan</span>
    </a>
  </div>

  @if($anak->count() > 0)
  <div class="section-header">
    <h4 class="section-title">
      <i class="fas fa-child text-primary"></i> Anak Saya
    </h4>
    <span class="section-badge">{{ $anak->count() }} Anak</span>
  </div>
  
  @foreach($anak as $item)
  <a href="{{ route('mobile.anak.show', $item->id) }}" class="child-card">
    <div class="child-avatar {{ $item->jenis_kelamin == 'L' ? 'laki' : 'perempuan' }}">
      {{ substr($item->nama, 0, 1) }}
    </div>
    <div class="child-info">
      <h5 class="child-name">{{ $item->nama }}</h5>
      <div class="child-age">
        <i class="fas fa-birthday-cake"></i>
        {{ \Carbon\Carbon::parse($item->tanggal_lahir)->diffInMonths(now()) }} Bulan
        <span>•</span>
        <i class="fas fa-{{ $item->jenis_kelamin == 'L' ? 'mars' : 'venus' }}"></i>
        {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
      </div>
      @if($item->latestPemeriksaan && $item->latestPemeriksaan->status_gizi_akhir)
      <span class="status-badge @if($item->latestPemeriksaan->status_gizi_akhir == 'normal') normal @elseif($item->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $item->latestPemeriksaan->status_gizi_akhir == 'wasting') danger @else warning @endif">
        {{ ucfirst(str_replace('_', ' ', $item->latestPemeriksaan->status_gizi_akhir)) }}
      </span>
      @else
      <span class="status-badge default">Belum Periksa</span>
      @endif
    </div>
    <i class="fas fa-chevron-right chevron-icon"></i>
  </a>
  @endforeach
  @else
  <div class="empty-state">
    <div class="empty-icon"><i class="fas fa-child"></i></div>
    <div class="empty-title">Belum Ada Data Anak</div>
    <div class="empty-text">Hubungi nakes untuk mendaftarkan anak</div>
  </div>
  @endif

  @if($jadwalMendatang->count() > 0)
  <h4 class="section-title mb-3 mt-4">
    <i class="fas fa-calendar-check text-secondary"></i> Jadwal Posyandu
  </h4>
  @foreach($jadwalMendatang->take(3) as $jadwal)
  <div class="schedule-card">
    <div class="schedule-icon">
      <i class="fas fa-calendar-day"></i>
    </div>
    <div class="schedule-info">
      <div class="schedule-title">{{ $jadwal->tema ?? 'Posyandu' }}</div>
      <div class="schedule-time">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} • {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</div>
    </div>
    <i class="fas fa-angle-right text-muted"></i>
  </div>
  @endforeach
  @endif

  @if($artikel->count() > 0)
  <h4 class="section-title mb-3 mt-4">
    <i class="fas fa-book-medical text-info"></i> Artikel Edukasi
  </h4>
  @foreach($artikel->take(3) as $article)
  <a href="#" class="article-card">
    <div class="article-icon">
      <i class="fas fa-book-open"></i>
    </div>
    <div class="article-title">{{ $article->judul }}</div>
    <span class="article-badge">{{ ucfirst($article->kategori) }}</span>
  </a>
  @endforeach
  @endif
</div>
@endsection
