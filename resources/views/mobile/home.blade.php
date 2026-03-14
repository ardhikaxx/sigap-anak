@extends('mobile.layout.master')

@section('title', 'Beranda')

@push('styles')
<style>
  .premium-header {
    background: linear-gradient(135deg, #0F172A 0%, #1E3A5F 50%, #2E86AB 100%);
    border-radius: 0 0 32px 32px;
    padding: 32px 20px 48px;
    color: white;
    position: relative;
    margin: -16px -16px 24px;
  }

  .premium-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    border-radius: 0 0 32px 32px;
  }

  .header-content {
    position: relative;
    z-index: 1;
  }

  .user-greeting {
    font-size: 0.9rem;
    opacity: 0.85;
    margin-bottom: 2px;
    font-weight: 500;
  }

  .user-name {
    font-size: 1.6rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    margin: 0 0 8px;
  }

  .header-stats {
    display: flex;
    gap: 16px;
    margin-top: 16px;
  }

  .stat-item {
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(10px);
    border-radius: 14px;
    padding: 12px 16px;
    flex: 1;
    border: 1px solid rgba(255,255,255,0.1);
  }

  .stat-value {
    font-size: 1.4rem;
    font-weight: 800;
    display: block;
  }

  .stat-label {
    font-size: 0.7rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .main-menu-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-bottom: 24px;
  }

  .menu-btn {
    background: white;
    border: none;
    border-radius: 20px;
    padding: 16px 8px 14px;
    text-align: center;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
  }

  .menu-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: transparent;
    transition: all 0.25s;
  }

  .menu-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
  }

  .menu-btn:hover::before {
    height: 100%;
    opacity: 0.05;
  }

  .menu-btn.anak::before { background: #2E86AB; }
  .menu-btn.grafik::before { background: #10B981; }
  .menu-btn.konsultasi::before { background: #F59E0B; }
  .menu-btn.makan::before { background: #8B5CF6; }

  .menu-icon {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .menu-btn.anak .menu-icon { background: linear-gradient(135deg, #2E86AB, #1A5F7A); }
  .menu-btn.grafik .menu-icon { background: linear-gradient(135deg, #10B981, #059669); }
  .menu-btn.konsultasi .menu-icon { background: linear-gradient(135deg, #F59E0B, #D97706); }
  .menu-btn.makan .menu-icon { background: linear-gradient(135deg, #8B5CF6, #6D28D9); }

  .menu-text {
    font-size: 0.7rem;
    font-weight: 700;
    color: #374151;
    line-height: 1.2;
  }

  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
  }

  .section-title {
    font-size: 1rem;
    font-weight: 800;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
  }

  .section-badge {
    background: linear-gradient(135deg, #2E86AB, #1A5F7A);
    color: white;
    font-size: 0.65rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    box-shadow: 0 2px 8px rgba(46, 134, 171, 0.25);
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
    border: 1px solid #F1F5F9;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    transition: all 0.25s ease;
  }

  .child-card:hover {
    border-color: #CBD5E1;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    transform: translateY(-2px);
  }

  .child-avatar {
    width: 60px;
    height: 60px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    font-weight: 800;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .child-avatar.laki { background: linear-gradient(135deg, #3B82F6, #1D4ED8); }
  .child-avatar.perempuan { background: linear-gradient(135deg, #EC4899, #BE185D); }

  .child-details { flex: 1; min-width: 0; }

  .child-name {
    font-size: 1.1rem;
    font-weight: 800;
    color: #1E293B;
    margin-bottom: 3px;
  }

  .child-meta {
    font-size: 0.8rem;
    color: #64748B;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
  }

  .child-meta i {
    font-size: 0.75rem;
  }

  .status-pill {
    display: inline-flex;
    align-items: center;
    padding: 5px 12px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
  }

  .status-pill.normal { background: rgba(16, 185, 129, 0.12); color: #059669; }
  .status-pill.warning { background: rgba(245, 158, 11, 0.12); color: #D97706; }
  .status-pill.danger { background: rgba(239, 68, 68, 0.12); color: #DC2626; }
  .status-pill.default { background: rgba(148, 163, 184, 0.12); color: #64748B; }

  .child-arrow {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    background: #F8FAFC;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94A3B8;
    transition: all 0.2s;
  }

  .child-card:hover .child-arrow {
    background: #2E86AB;
    color: white;
  }

  .schedule-card {
    background: white;
    border-radius: 20px;
    border: 1px solid #F1F5F9;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
  }

  .schedule-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px;
    border-bottom: 1px solid #F1F5F9;
    transition: background 0.2s;
  }

  .schedule-row:last-child { border-bottom: none; }
  .schedule-row:hover { background: #F8FAFC; }

  .schedule-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
  }

  .schedule-icon.green { background: rgba(16, 185, 129, 0.12); color: #059669; }
  .schedule-icon.blue { background: rgba(59, 130, 246, 0.12); color: #2563EB; }
  .schedule-icon.purple { background: rgba(139, 92, 246, 0.12); color: #7C3AED; }

  .schedule-info { flex: 1; }

  .schedule-title {
    font-weight: 700;
    font-size: 0.95rem;
    color: #1E293B;
    margin-bottom: 3px;
  }

  .schedule-time {
    font-size: 0.75rem;
    color: #64748B;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .arrow-icon {
    color: #CBD5E1;
  }

  .empty-container {
    background: white;
    border-radius: 24px;
    padding: 48px 24px;
    text-align: center;
    border: 1px solid #F1F5F9;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
  }

  .empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 24px;
    background: linear-gradient(135deg, rgba(46, 134, 171, 0.1), rgba(16, 185, 129, 0.1));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 18px;
    font-size: 2rem;
    color: #2E86AB;
  }

  .empty-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #1E293B;
    margin-bottom: 6px;
  }

  .empty-desc {
    font-size: 0.85rem;
    color: #64748B;
    line-height: 1.5;
  }

  .article-list {
    background: white;
    border-radius: 20px;
    border: 1px solid #F1F5F9;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
  }

  .article-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px;
    text-decoration: none;
    color: inherit;
    border-bottom: 1px solid #F1F5F9;
    transition: background 0.2s;
  }

  .article-item:last-child { border-bottom: none; }
  .article-item:hover { background: #F8FAFC; }

  .article-img {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.12), rgba(109, 40, 217, 0.12));
    color: #7C3AED;
  }

  .article-text { flex: 1; min-width: 0; }

  .article-title {
    font-weight: 700;
    font-size: 0.9rem;
    color: #1E293B;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .article-cat {
    font-size: 0.7rem;
    font-weight: 600;
    color: #7C3AED;
    background: rgba(139, 92, 246, 0.1);
    padding: 4px 10px;
    border-radius: 8px;
    display: inline-block;
  }
</style>
@endpush

@section('content')
<div class="mobile-content">
  <div class="premium-header">
    <div class="header-content">
      <p class="user-greeting">{{ $greeting }}</p>
      <h1 class="user-name">{{ $user->name }}</h1>
      <div class="header-stats">
        <div class="stat-item">
          <span class="stat-value">{{ $anak->count() }}</span>
          <span class="stat-label">Anak</span>
        </div>
        <div class="stat-item">
          <span class="stat-value">{{ $jadwalMendatang->count() }}</span>
          <span class="stat-label">Jadwal</span>
        </div>
        <div class="stat-item">
          <span class="stat-value">{{ $artikel->count() }}</span>
          <span class="stat-label">Artikel</span>
        </div>
      </div>
    </div>
  </div>

  <div class="main-menu-grid">
    <a href="{{ route('mobile.anak.index') }}" class="menu-btn anak">
      <div class="menu-icon"><i class="fas fa-child"></i></div>
      <span class="menu-text">Anak Saya</span>
    </a>
    <a href="{{ route('mobile.grafik.index') }}" class="menu-btn grafik">
      <div class="menu-icon"><i class="fas fa-chart-line"></i></div>
      <span class="menu-text">Grafik</span>
    </a>
    <a href="{{ route('mobile.konsultasi.index') }}" class="menu-btn konsultasi">
      <div class="menu-icon"><i class="fas fa-comments"></i></div>
      <span class="menu-text">Konsultasi</span>
    </a>
    <a href="#" class="menu-btn makan">
      <div class="menu-icon"><i class="fas fa-utensils"></i></div>
      <span class="menu-text">Makanan</span>
    </a>
  </div>

  @if($anak->count() > 0)
  <div class="section-header">
    <h4 class="section-title">
      <i class="fas fa-child" style="color: #2E86AB;"></i> Anak Saya
    </h4>
    <span class="section-badge">{{ $anak->count() }} Anak</span>
  </div>

  @foreach($anak as $item)
  <a href="{{ route('mobile.anak.show', $item->id) }}" class="child-card">
    <div class="child-avatar {{ $item->jenis_kelamin == 'L' ? 'laki' : 'perempuan' }}">
      {{ substr($item->nama, 0, 1) }}
    </div>
    <div class="child-details">
      <h4 class="child-name">{{ $item->nama }}</h4>
      <div class="child-meta">
        <span><i class="fas fa-birthday-cake"></i> {{ \Carbon\Carbon::parse($item->tanggal_lahir)->diffInMonths(now()) }} Bulan</span>
        <span>•</span>
        <span><i class="fas fa-{{ $item->jenis_kelamin == 'L' ? 'mars' : 'venus' }}"></i> {{ $item->jenis_kelamin == 'L' ? 'Laki' : 'Peremp' }}</span>
      </div>
      @if($item->latestPemeriksaan && $item->latestPemeriksaan->status_gizi_akhir)
      <span class="status-pill @if($item->latestPemeriksaan->status_gizi_akhir == 'normal') normal @elseif($item->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $item->latestPemeriksaan->status_gizi_akhir == 'wasting') danger @else warning @endif">
        {{ ucfirst(str_replace('_', ' ', $item->latestPemeriksaan->status_gizi_akhir)) }}
      </span>
      @else
      <span class="status-pill default">Belum Periksa</span>
      @endif
    </div>
    <div class="child-arrow"><i class="fas fa-chevron-right"></i></div>
  </a>
  @endforeach
  @else
  <div class="empty-container">
    <div class="empty-icon"><i class="fas fa-baby"></i></div>
    <div class="empty-title">Belum Ada Data Anak</div>
    <div class="empty-desc">Silakan hubungi petugas kesehatan<br>untuk mendaftarkan anak Anda</div>
  </div>
  @endif

  @if($jadwalMendatang->count() > 0)
  <h4 class="section-title mb-3 mt-4">
    <i class="fas fa-calendar-check" style="color: #10B981;"></i> Jadwal Posyandu
  </h4>
  <div class="schedule-card mb-4">
    @foreach($jadwalMendatang->take(3) as $jadwal)
    <div class="schedule-row">
      <div class="schedule-icon green">
        <i class="fas fa-calendar-day"></i>
      </div>
      <div class="schedule-info">
        <div class="schedule-title">{{ $jadwal->tema ?? 'Posyandu' }}</div>
        <div class="schedule-time">
          <i class="far fa-clock"></i>
          {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} • {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
        </div>
      </div>
      <i class="fas fa-chevron-right arrow-icon"></i>
    </div>
    @endforeach
  </div>
  @endif

  @if($artikel->count() > 0)
  <h4 class="section-title mb-3 mt-4">
    <i class="fas fa-book-medical" style="color: #8B5CF6;"></i> Artikel Edukasi
  </h4>
  <div class="article-list mb-4">
    @foreach($artikel->take(3) as $article)
    <a href="#" class="article-item">
      <div class="article-img">
        <i class="fas fa-book-open"></i>
      </div>
      <div class="article-text">
        <div class="article-title">{{ $article->judul }}</div>
      </div>
      <span class="article-cat">{{ ucfirst($article->kategori) }}</span>
    </a>
    @endforeach
  </div>
  @endif

  <div style="height: 20px;"></div>
</div>
@endsection
