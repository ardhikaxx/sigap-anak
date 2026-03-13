@extends('admin.layout.master')

@section('title', 'Konsultasi')

@section('content')
<div class="page-header">
  <div>
    <h1 class="page-title">Konsultasi</h1>
    <p class="page-subtitle">Kelola konsultasi dengan orang tua</p>
  </div>
</div>

<div class="card">
  <div class="card-header bg-white border-bottom py-3">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="fas fa-comments text-primary me-2"></i>Daftar Konsultasi
        <span class="badge bg-secondary ms-2">{{ $konsultasis->total() }}</span>
      </h5>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4" style="width: 50px;">No</th>
            <th>Topik</th>
            <th>Anak</th>
            <th>Orang Tua</th>
            <th>Nakes</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Rating</th>
            <th class="text-center" style="width: 100px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($konsultasis as $index => $konsultasi)
          <tr>
            <td class="ps-4 text-muted">{{ $konsultasis->firstItem() + $index }}</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="avatar-circle bg-{{ $konsultasi->status === 'menunggu' ? 'warning' : ($konsultasi->status === 'selesai' ? 'success' : 'info') }} text-white me-3">
                  <i class="fas fa-comment"></i>
                </div>
                <div>
                  <h6 class="mb-0">{{ $konsultasi->topik }}</h6>
                  <small class="text-muted">{{ Str::limit($konsultasi->pertanyaan, 40) }}</small>
                </div>
              </div>
            </td>
            <td>
              <i class="fas fa-child text-muted me-2"></i>
              {{ $konsultasi->anak->nama ?? '-' }}
            </td>
            <td>
              <div class="d-flex align-items-center">
                <div class="avatar-circle bg-secondary text-white me-2" style="width: 28px; height: 28px; font-size: 11px;">
                  {{ substr($konsultasi->orangtua->name ?? 'O', 0, 1) }}
                </div>
                {{ $konsultasi->orangtua->name ?? '-' }}
              </div>
            </td>
            <td>{{ $konsultasi->nakes->name ?? '-' }}</td>
            <td>
              <small class="text-muted">{{ $konsultasi->created_at->format('d M Y') }}</small>
            </td>
            <td>
              <span class="badge bg-{{ $konsultasi->status === 'menunggu' ? 'warning' : ($konsultasi->status === 'selesai' ? 'success' : 'info') }}">
                <i class="fas fa-{{ $konsultasi->status === 'menunggu' ? 'clock' : ($konsultasi->status === 'selesai' ? 'check' : 'spinner') }} me-1"></i>
                {{ ucfirst($konsultasi->status) }}
              </span>
            </td>
            <td>
              @if($konsultasi->rating)
              <span class="text-warning">
                @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star{{ $i <= $konsultasi->rating ? '' : '-o' }}"></i>
                @endfor
              </span>
              @else
              <span class="text-muted">-</span>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.konsultasi.show', $konsultasi->id) }}" class="btn btn-sm btn-outline-info" title="Detail">
                <i class="fas fa-eye"></i>
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-center py-5">
              <i class="fas fa-comments fa-4x text-muted mb-3 d-block"></i>
              <h5 class="text-muted">Tidak ada data konsultasi</h5>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($konsultasis->hasPages())
  <div class="card-footer bg-white py-3">
    {{ $konsultasis->links() }}
  </div>
  @endif
</div>
@endsection
