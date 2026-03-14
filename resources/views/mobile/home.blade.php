@extends('mobile.layout.master')

@section('title', 'Beranda')

@push('styles')
<style>
  .greeting-card {
    background: linear-gradient(135deg, #2E86AB 0%, #1A5F7A 50%, #57CC99 100%);
    border-radius: 24px;
    padding: 24px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 32px rgba(46, 134, 171, 0.35);
  }

  .greeting-card::before {
    content: '';
    position: absolute;
    top: -30px;
    right: -30px;
    width: 120px;
    height: 120px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
  }

  .greeting-card::after {
    content: '';
    position: absolute;
    bottom: -20px;
    left: -20px;
    width: 80px;
    height: 80px;
    background: rgba(87, 204, 153, 0.2);
    border-radius: 50%;
  }

  .greeting-text {
    font-size: 0.95rem;
    opacity: 0.9;
    margin-bottom: 2px;
    font-weight: 500;
  }

  .greeting-name {
    font-size: 1.4rem;
    font-weight: 800;
    letter-spacing: -0.3px;
    margin: 0;
  }

  .greeting-avatar {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 700;
    border: 2px solid rgba(255,255,255,0.3);
  }

  .quick-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    padding: 14px 8px;
    border-radius: 18px;
    background: white;
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .quick-action-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  }

  .action-icon {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .quick-action-btn span {
    font-size: 0.75rem;
    font-weight: 700;
    color: #374151;
  }

  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
  }

  .section-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
  }

  .badge-count {
    background: linear-gradient(135deg, #2E86AB, #1A5F7A);
    color: white;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    box-shadow: 0 2px 8px rgba(46, 134, 171, 0.3);
  }

  .mobile-anak-card {
    background: white;
    border-radius: 20px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: inherit;
    margin-bottom: 12px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.2s ease;
  }

  .mobile-anak-card:hover {
    border-color: #2E86AB;
    box-shadow: 0 4px 16px rgba(46, 134, 171, 0.12);
  }

  .avatar-circle {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    font-weight: 700;
    color: white;
    flex-shrink: 0;
  }

  .avatar-blue { background: linear-gradient(135deg, #3B82F6, #1D4ED8); }
  .avatar-pink { background: linear-gradient(135deg, #EC4899, #BE185D); }
  .avatar-green { background: linear-gradient(135deg, #10B981, #059669); }
  .avatar-purple { background: linear-gradient(135deg, #8B5CF6, #6D28D9); }

  .child-info { flex: 1; min-width: 0; }

  .child-name {
    font-size: 1.05rem;
    font-weight: 800;
    color: #111827;
    margin-bottom: 2px;
  }

  .child-age {
    font-size: 0.8rem;
    color: #6B7280;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .badge-custom {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
  }

  .badge-normal { background: rgba(16, 185, 129, 0.12); color: #059669; }
  .badge-warning { background: rgba(245, 158, 11, 0.12); color: #D97706; }
  .badge-danger { background: rgba(239, 68, 68, 0.12); color: #DC2626; }
  .badge-default { background: rgba(156, 163, 175, 0.12); color: #6B7280; }
  .badge-info { background: rgba(59, 130, 246, 0.12); color: #2563EB; }

  .chevron-right {
    color: #D1D5DB;
    font-size: 0.9rem;
  }

  .card-custom {
    background: white;
    border-radius: 18px;
    border: 1px solid #E5E7EB;
    overflow: hidden;
  }

  .schedule-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-bottom: 1px solid #F3F4F6;
  }

  .schedule-item:last-child { border-bottom: none; }

  .schedule-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(16, 185, 129, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #059669;
    font-size: 1rem;
  }

  .schedule-content { flex: 1; }

  .schedule-title {
    font-weight: 700;
    font-size: 0.9rem;
    color: #111827;
    margin-bottom: 2px;
  }

  .schedule-time {
    font-size: 0.75rem;
    color: #6B7280;
  }

  .empty-state {
    background: white;
    border-radius: 20px;
    padding: 40px 24px;
    text-align: center;
    border: 1px solid #E5E7EB;
  }

  .empty-icon {
    width: 72px;
    height: 72px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(46, 134, 171, 0.1), rgba(87, 204, 153, 0.1));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    font-size: 1.75rem;
    color: #2E86AB;
  }

  .empty-title {
    font-size: 1rem;
    font-weight: 800;
    color: #111827;
    margin-bottom: 4px;
  }

  .empty-text {
    font-size: 0.85rem;
    color: #6B7280;
  }

  .article-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    text-decoration: none;
    color: inherit;
    border-bottom: 1px solid #F3F4F6;
  }

  .article-card:last-child { border-bottom: none; }

  .article-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(109, 40, 217, 0.1));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #7C3AED;
    font-size: 1rem;
    flex-shrink: 0;
  }

  .article-content { flex: 1; min-width: 0; }

  .article-title {
    font-weight: 700;
    font-size: 0.85rem;
    color: #111827;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .article-category {
    font-size: 0.7rem;
    font-weight: 600;
    color: #7C3AED;
    background: rgba(139, 92, 246, 0.1);
    padding: 3px 8px;
    border-radius: 6px;
  }
</style>
@endpush

@section('content')
<div class="mobile-content">
  <div class="greeting-card mb-4">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <p class="greeting-text">{{ $greeting }},</p>
        <h1 class="greeting-name">{{ $user->name }}</h1>
      </div>
      <div class="greeting-avatar">{{ substr($user->name, 0, 1) }}</div>
    </div>
  </div>

  <div class="row g-2 mb-4">
    <div class="col-3">
      <a href="{{ route('mobile.anak.index') }}" class="quick-action-btn">
        <div class="action-icon" style="background: linear-gradient(135deg, #2E86AB, #1A5F7A);">
          <i class="fas fa-child"></i>
        </div>
        <span>Anak Saya</span>
      </a>
    </div>
    <div class="col-3">
      <a href="{{ route('mobile.grafik.index') }}" class="quick-action-btn">
        <div class="action-icon" style="background: linear-gradient(135deg, #10B981, #059669);">
          <i class="fas fa-chart-line"></i>
        </div>
        <span>Grafik</span>
      </a>
    </div>
    <div class="col-3">
      <a href="{{ route('mobile.konsultasi.index') }}" class="quick-action-btn">
        <div class="action-icon" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
          <i class="fas fa-comments"></i>
        </div>
        <span>Konsultasi</span>
      </a>
    </div>
    <div class="col-3">
      <a href="#" class="quick-action-btn">
        <div class="action-icon" style="background: linear-gradient(135deg, #8B5CF6, #6D28D9);">
          <i class="fas fa-utensils"></i>
        </div>
        <span>Makan</span>
      </a>
    </div>
  </div>

  @if($anak->count() > 0)
  <div class="section-header">
    <h4 class="section-title">
      <i class="fas fa-child text-primary"></i> Anak Saya
    </h4>
    <span class="badge-count">{{ $anak->count() }} Anak</span>
  </div>
  
  @foreach($anak as $item)
  <a href="{{ route('mobile.anak.show', $item->id) }}" class="mobile-anak-card">
    <div class="avatar-circle avatar-{{ $item->jenis_kelamin == 'L' ? 'blue' : 'pink' }}">
      {{ substr($item->nama, 0, 1) }}
    </div>
    <div class="child-info">
      <h4 class="child-name">{{ $item->nama }}</h4>
      <div class="child-age">
        <i class="fas fa-birthday-cake"></i>
        {{ \Carbon\Carbon::parse($item->tanggal_lahir)->diffInMonths(now()) }} Bulan
        <span>•</span>
        <i class="fas fa-{{ $item->jenis_kelamin == 'L' ? 'mars' : 'venus' }}"></i>
        {{ $item->jenis_kelamin == 'L' ? 'Laki' : 'Perempuan' }}
      </div>
      @if($item->latestPemeriksaan && $item->latestPemeriksaan->status_gizi_akhir)
      <span class="badge-custom @if($item->latestPemeriksaan->status_gizi_akhir == 'normal') badge-normal @elseif($item->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $item->latestPemeriksaan->status_gizi_akhir == 'wasting') badge-danger @else badge-warning @endif">
        {{ ucfirst(str_replace('_', ' ', $item->latestPemeriksaan->status_gizi_akhir)) }}
      </span>
      @else
      <span class="badge-custom badge-default">Belum Periksa</span>
      @endif
    </div>
    <i class="fas fa-chevron-right chevron-right"></i>
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
    <i class="fas fa-calendar-check" style="color: #10B981;"></i> Jadwal Posyandu
  </h4>
  <div class="card-custom">
    @foreach($jadwalMendatang->take(3) as $jadwal)
    <div class="schedule-item">
      <div class="schedule-icon">
        <i class="fas fa-calendar-day"></i>
      </div>
      <div class="schedule-content">
        <div class="schedule-title">{{ $jadwal->tema ?? 'Posyandu' }}</div>
        <div class="schedule-time">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} • {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</div>
      </div>
      <i class="fas fa-angle-right text-muted"></i>
    </div>
    @endforeach
  </div>
  @endif

  @if($artikel->count() > 0)
  <h4 class="section-title mb-3 mt-4">
    <i class="fas fa-book-medical" style="color: #8B5CF6;"></i> Artikel Edukasi
  </h4>
  <div class="card-custom">
    @foreach($artikel->take(3) as $article)
    <a href="#" class="article-card">
      <div class="article-icon">
        <i class="fas fa-book-open"></i>
      </div>
      <div class="article-content">
        <div class="article-title">{{ $article->judul }}</div>
      </div>
      <span class="article-category">{{ ucfirst($article->kategori) }}</span>
    </a>
    @endforeach
  </div>
  @endif
</div>
@endsection
