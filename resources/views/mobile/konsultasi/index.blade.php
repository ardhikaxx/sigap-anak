@extends('mobile.layout.master')

@section('title', 'Riwayat Konsultasi')

@section('content')
<div class="mobile-content pt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="section-title mb-1">
        <i class="fas fa-comments text-primary"></i> Konsultasi
      </h4>
      <p class="user-meta mb-0">{{ $konsultasis->count() }} diskusi kesehatan</p>
    </div>
    <a href="{{ route('mobile.konsultasi.create') }}" class="btn-action btn-primary-action px-3 py-2 shadow-sm">
      <i class="fas fa-plus"></i> Baru
    </a>
  </div>

  @forelse($konsultasis as $konsultasi)
  <a href="{{ route('mobile.konsultasi.show', $konsultasi->id) }}" class="card-custom mb-3 p-3 d-block text-decoration-none border-0">
    <div class="d-flex justify-content-between align-items-start mb-3">
      <div class="d-flex align-items-center gap-3">
        <div class="avatar-circle @if($konsultasi->status === 'menunggu') avatar-yellow @elseif($konsultasi->status === 'selesai') avatar-green @else avatar-blue @endif" style="width: 48px; height: 48px; border-radius: 14px;">
          <i class="fas fa-comment-medical"></i>
        </div>
        <div>
          <h6 class="fw-bold text-dark mb-1">{{ $konsultasi->topik }}</h6>
          <div class="user-meta" style="font-size: 0.75rem;">
            <i class="fas fa-child me-1"></i>{{ $konsultasi->anak->nama ?? 'Umum' }}
          </div>
        </div>
      </div>
      <span class="badge-custom @if($konsultasi->status === 'menunggu') badge-warning @elseif($konsultasi->status === 'selesai') badge-normal @else badge-info @endif bg-opacity-10 text-capitalize">
        {{ $konsultasi->status }}
      </span>
    </div>
    
    <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-1">
      <div class="user-meta" style="font-size: 0.7rem;">
        <i class="far fa-calendar-alt me-1"></i>{{ $konsultasi->created_at->format('d M Y') }}
        <span class="mx-2 text-muted opacity-25">|</span>
        <i class="far fa-clock me-1"></i>{{ $konsultasi->created_at->format('H:i') }}
      </div>
      
      @if($konsultasi->rating)
        <div class="text-warning" style="font-size: 0.7rem;">
          @for($i = 1; $i <= 5; $i++)
            <i class="fa{{ $i <= $konsultasi->rating ? 's' : 'r' }} fa-star"></i>
          @endfor
        </div>
      @else
        <i class="fas fa-chevron-right text-muted opacity-50" style="font-size: 0.8rem;"></i>
      @endif
    </div>
  </a>
  @empty
  <div class="empty-state py-5 mt-4 card-custom border-dashed">
    <div class="empty-icon shadow-none" style="background: var(--sigap-gray-light);"><i class="fas fa-comments"></i></div>
    <h5 class="empty-title">Belum ada konsultasi</h5>
    <p class="empty-text px-4">Tanyakan keluhan kesehatan anak langsung kepada tenaga kesehatan kami</p>
    <a href="{{ route('mobile.konsultasi.create') }}" class="btn-action btn-primary-action px-4 py-2 mt-2">
      <i class="fas fa-plus"></i> Mulai Konsultasi
    </a>
  </div>
  @endforelse

  <div class="card-custom bg-glass mt-4 p-4 border-0 shadow-sm" style="background: linear-gradient(135deg, rgba(46, 134, 171, 0.05), rgba(87, 204, 153, 0.05));">
    <div class="d-flex gap-3 align-items-start">
      <i class="fas fa-shield-halved text-primary fs-4 mt-1"></i>
      <div>
        <h6 class="fw-bold text-dark mb-1">Privasi Terjaga</h6>
        <p class="user-meta mb-0" style="font-size: 0.8rem;">Konsultasi Anda hanya dapat dilihat oleh tenaga kesehatan yang bertugas dan bersifat rahasia.</p>
      </div>
    </div>
  </div>
</div>
@endsection
