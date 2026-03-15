@extends('mobile.layout.master')

@section('title', 'Riwayat Konsultasi')

@push('styles')
<style>
    .konsultasi-header {
        background: var(--sigap-dark);
        padding: 24px 20px 48px;
        margin-bottom: -24px;
        border-radius: 0 0 28px 28px;
    }
    .btn-new {
        background: linear-gradient(135deg, var(--sigap-primary), var(--sigap-primary-dark));
        color: white;
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(46, 134, 171, 0.3);
        transition: all 0.2s;
    }
    .btn-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(46, 134, 171, 0.4);
        color: white;
    }
    .konsultasi-card {
        background: white;
        border-radius: 16px;
        margin-bottom: 14px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--sigap-border);
        text-decoration: none;
        color: inherit;
        display: block;
        transition: all 0.2s ease;
        overflow: hidden;
    }
    .konsultasi-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--sigap-primary-light);
    }
    .konsultasi-card .card-inner {
        padding: 16px;
    }
    .avatar-status {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: white;
    }
    .avatar-status.waiting { background: linear-gradient(135deg, var(--sigap-warning), #e67e22); }
    .avatar-status.done { background: linear-gradient(135deg, var(--sigap-secondary), var(--sigap-secondary-dark)); }
    .avatar-status.reply { background: linear-gradient(135deg, var(--sigap-primary), var(--sigap-primary-dark)); }
    .konsultasi-card .topic {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--sigap-dark);
        margin-bottom: 4px;
    }
    .konsultasi-card .child-name {
        font-size: 0.75rem;
        color: var(--sigap-gray);
    }
    .konsultasi-card .status-badge {
        padding: 5px 12px;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 700;
    }
    .status-badge.waiting { background: rgba(255, 179, 71, 0.15); color: #e67e22; }
    .status-badge.done { background: rgba(87, 204, 153, 0.15); color: #38A169; }
    .status-badge.reply { background: rgba(46, 134, 171, 0.15); color: var(--sigap-primary); }
    .konsultasi-card .meta-info {
        font-size: 0.7rem;
        color: var(--sigap-gray);
        padding-top: 12px;
        border-top: 1px solid var(--sigap-gray-light);
        margin-top: 12px;
        display: flex;
        align-items: center;
    }
    .konsultasi-card .rating {
        color: var(--sigap-warning);
        font-size: 0.75rem;
    }
    .konsultasi-card .arrow-icon {
        color: var(--sigap-gray);
        font-size: 0.8rem;
    }
    .info-card {
        background: linear-gradient(135deg, rgba(46, 134, 171, 0.08), rgba(87, 204, 153, 0.08));
        border-radius: 16px;
        padding: 16px;
        margin-top: 20px;
    }
    .info-card .info-icon {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--sigap-primary);
        font-size: 1rem;
        flex-shrink: 0;
    }
    .info-card .info-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--sigap-dark);
        margin-bottom: 4px;
    }
    .info-card .info-text {
        font-size: 0.75rem;
        color: var(--sigap-gray);
        line-height: 1.5;
    }
    .empty-konsultasi {
        background: white;
        border-radius: 20px;
        padding: 50px 30px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--sigap-border);
        text-align: center;
    }
    .empty-konsultasi-icon {
        width: 80px;
        height: 80px;
        background: var(--sigap-gray-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .empty-konsultasi-icon i {
        font-size: 2rem;
        color: var(--sigap-gray);
    }
    .empty-konsultasi-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--sigap-dark);
        margin-bottom: 6px;
    }
    .empty-konsultasi-text {
        font-size: 0.85rem;
        color: var(--sigap-gray);
        margin-bottom: 16px;
    }
</style>
@endpush


@section('content')
<div class="konsultasi-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="section-title text-white mb-1">
                Konsultasi
            </h4>
            <p class="user-meta mb-0 text-white opacity-75">{{ $konsultasis->count() }} diskusi kesehatan</p>
        </div>
        <a href="{{ route('mobile.konsultasi.create') }}" class="btn-new">
            <i class="fas fa-plus"></i> Baru
        </a>
    </div>
</div>

<div class="main-dashboard-content mt-5">

  @forelse($konsultasis as $konsultasi)
  <a href="{{ route('mobile.konsultasi.show', $konsultasi->id) }}" class="konsultasi-card">
    <div class="card-inner">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar-status 
            @if($konsultasi->status === 'menunggu') waiting 
            @elseif($konsultasi->status === 'selesai') done 
            @else reply @endif">
            <i class="fas fa-comment-medical"></i>
          </div>
          <div>
            <div class="topic">{{ $konsultasi->topik }}</div>
            <div class="child-name">
              <i class="fas fa-child me-1"></i>{{ $konsultasi->anak->nama ?? 'Umum' }}
            </div>
          </div>
        </div>
        <span class="status-badge 
          @if($konsultasi->status === 'menunggu') waiting 
          @elseif($konsultasi->status === 'selesai') done 
          @else reply @endif text-capitalize">
          {{ $konsultasi->status }}
        </span>
      </div>
      
      <div class="d-flex justify-content-between align-items-center meta-info">
        <div>
          <i class="far fa-calendar-alt me-1"></i>{{ $konsultasi->created_at->format('d M Y') }}
          <span class="mx-2 text-muted opacity-25">|</span>
          <i class="far fa-clock me-1"></i>{{ $konsultasi->created_at->format('H:i') }}
        </div>
        
        @if($konsultasi->rating)
          <div class="rating">
            @for($i = 1; $i <= 5; $i++)
              <i class="fa{{ $i <= $konsultasi->rating ? 's' : 'r' }} fa-star"></i>
            @endfor
          </div>
        @else
          <i class="fas fa-chevron-right arrow-icon"></i>
        @endif
      </div>
    </div>
  </a>
  @empty
  <div class="empty-konsultasi">
    <div class="empty-konsultasi-icon">
      <i class="fas fa-comments"></i>
    </div>
    <h5 class="empty-konsultasi-title">Belum ada konsultasi</h5>
    <p class="empty-konsultasi-text">Tanyakan keluhan kesehatan anak langsung kepada tenaga kesehatan kami</p>
    <a href="{{ route('mobile.konsultasi.create') }}" class="btn-new">
      <i class="fas fa-plus"></i> Mulai Konsultasi
    </a>
  </div>
  @endforelse

  <div class="info-card">
    <div class="d-flex gap-3 align-items-start">
      <div class="info-icon">
        <i class="fas fa-shield-halved"></i>
      </div>
      <div>
        <div class="info-title">Privasi Terjaga</div>
        <div class="info-text">Konsultasi Anda hanya dapat dilihat oleh tenaga kesehatan yang bertugas dan bersifat rahasia.</div>
      </div>
    </div>
  </div>

  <div style="height: 30px;"></div>
</div>
@endsection
