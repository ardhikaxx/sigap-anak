@extends('mobile.layout.master')

@section('title', 'Konsultasi')

@section('content')
<div class="mobile-content pb-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-1">Konsultasi</h4>
      <p class="text-muted small mb-0">{{ $konsultasis->count() }} konsultasi</p>
    </div>
    <a href="{{ route('mobile.konsultasi.create') }}" class="btn btn-primary btn-sm">
      <i class="fas fa-plus me-1"></i> Baru
    </a>
  </div>

  @forelse($konsultasis as $konsultasi)
  <a href="{{ route('mobile.konsultasi.show', $konsultasi->id) }}" class="card mb-3 border-0 shadow-sm text-decoration-none">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <div class="d-flex align-items-center">
          <div class="avatar-circle bg-{{ $konsultasi->status === 'menunggu' ? 'warning' : ($konsultasi->status === 'selesai' ? 'success' : 'info') }} text-white me-3" style="width: 44px; height: 44px; font-size: 18px;">
            <i class="fas fa-comment"></i>
          </div>
          <div>
            <h6 class="mb-0 text-dark">{{ $konsultasi->topik }}</h6>
            <small class="text-muted">
              <i class="fas fa-child me-1"></i>{{ $konsultasi->anak->nama ?? '-' }}
            </small>
          </div>
        </div>
        <span class="badge bg-{{ $konsultasi->status === 'menunggu' ? 'warning' : ($konsultasi->status === 'selesai' ? 'success' : 'info') }}">
          {{ ucfirst($konsultasi->status) }}
        </span>
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted">
          <i class="fas fa-calendar me-1"></i>{{ $konsultasi->created_at->format('d M Y') }}
          <span class="mx-2">|</span>
          <i class="fas fa-clock me-1"></i>{{ $konsultasi->created_at->format('H:i') }}
        </small>
        @if($konsultasi->rating)
        <span class="text-warning">
          @for($i = 1; $i <= 5; $i++)
          <i class="fas fa-star{{ $i <= $konsultasi->rating ? '' : '-o' }}"></i>
          @endfor
        </span>
        @endif
      </div>
    </div>
  </a>
  @empty
  <div class="text-center py-5">
    <div class="avatar-circle bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 36px;">
      <i class="fas fa-comments"></i>
    </div>
    <h5 class="text-muted">Belum ada konsultasi</h5>
    <p class="text-muted small">Konsultasikan kesehatan anak Anda dengan tenaga kesehatan</p>
    <a href="{{ route('mobile.konsultasi.create') }}" class="btn btn-primary">
      <i class="fas fa-plus me-2"></i>Buat Konsultasi
    </a>
  </div>
  @endforelse
</div>
@endsection
