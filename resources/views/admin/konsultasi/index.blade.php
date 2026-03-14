@extends('admin.layout.master')

@section('title', 'Layanan Konsultasi Nakes')

@push('styles')
<style>
  /* Premium styles specific to consultation */
  .page-header-premium {
    background: #1A1D2E;
    background-image: radial-gradient(at 0% 0%, rgba(46, 134, 171, 0.15) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(87, 204, 153, 0.1) 0px, transparent 50%);
    border-radius: 35px; padding: 60px 40px 100px; margin-bottom: -60px; position: relative;
  }
  .header-stats-mini { display: flex; gap: 30px; margin-top: 25px; }
  .header-stat-item { padding-left: 15px; border-left: 2px solid rgba(255,255,255,0.1); }
  .header-stat-label { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.5); margin-bottom: 2px; }
  .header-stat-value { font-size: 1.2rem; font-weight: 800; color: white; }
  .filter-container-glass {
    background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5); border-radius: 28px; padding: 25px; box-shadow: 0 20px 40px rgba(0,0,0,0.04); position: relative; z-index: 5;
  }
  .table-modern { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
  .table-modern thead th { padding: 15px 25px; font-size: 0.75rem; font-weight: 800; color: var(--sigap-gray); text-transform: uppercase; letter-spacing: 1px; border: none; }
  .table-modern tbody tr { background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.02); transition: all 0.3s ease; }
  .table-modern tbody tr:hover { transform: translateY(-3px) scale(1.005); box-shadow: 0 15px 30px rgba(0,0,0,0.06); }
  .table-modern td { padding: 20px 25px; vertical-align: middle; border: none; }
  .table-modern td:first-child { border-radius: 24px 0 0 24px; border-left: 1px solid #f1f5f9; }
  .table-modern td:last-child { border-radius: 0 24px 24px 0; border-right: 1px solid #f1f5f9; }

  .chat-preview {
    font-size: 0.85rem; color: #64748b; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
  }
  .status-pill {
    padding: 6px 12px; border-radius: 10px; font-weight: 700; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 6px;
  }
  .status-menunggu { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .status-dibalas { background: rgba(6, 182, 212, 0.1); color: #0891b2; }
  .status-selesai { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
</style>
@endpush

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Konsultasi</li>
@endsection

@section('content')
<div class="page-header-premium">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <h1 class="display-5 fw-800 text-white mb-1">Pusat Diskusi</h1>
      <p class="text-white opacity-60 fs-5">Berikan respon dan solusi kesehatan cepat kepada orang tua.</p>
      
      <div class="header-stats-mini">
        <div class="header-stat-item">
          <div class="header-stat-label">Pending</div>
          <div class="header-stat-value text-warning">{{ $konsultasis->where('status', 'menunggu')->count() }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Total Diskusi</div>
          <div class="header-stat-value">{{ $konsultasis->total() }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Avg. Rating</div>
          <div class="header-stat-value text-info"><i class="fas fa-star small"></i> 4.8</div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
      <div class="p-3 bg-white bg-opacity-10 rounded-4 d-inline-block border border-white border-opacity-10">
        <div class="small text-white opacity-70">Waktu Respon Rata-rata</div>
        <div class="h4 fw-800 text-white mb-0">15 <span class="fs-6 fw-normal">Menit</span></div>
      </div>
    </div>
  </div>
</div>

<div class="filter-container-glass mx-3">
  <form method="GET" action="{{ route('admin.konsultasi.index') }}" class="row g-3">
    <div class="col-lg-6">
      <input type="text" name="search" class="form-control border-0 bg-light rounded-4 py-3 px-4" placeholder="Cari Topik atau Nama Orang Tua..." value="{{ request('search') }}">
    </div>
    <div class="col-lg-4">
      <select name="status" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold">
        <option value="">Semua Status</option>
        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Balasan</option>
        <option value="dibalas" {{ request('status') == 'dibalas' ? 'selected' : '' }}>Sudah Dibalas</option>
        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
      </select>
    </div>
    <div class="col-lg-2">
      <button type="submit" class="btn btn-primary w-100 rounded-4 py-3 fw-bold shadow-sm">
        <i class="fas fa-filter"></i> Saring
      </button>
    </div>
  </form>
</div>

<div class="table-premium-container px-3">
  <div class="table-responsive">
    <table class="table-modern">
      <thead>
        <tr>
          <th style="width: 35%;">Topik Konsultasi</th>
          <th>Pasien (Anak)</th>
          <th>Waktu</th>
          <th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($konsultasis as $k)
        <tr>
          <td>
            <div class="d-flex align-items-start gap-3">
              <div class="avatar-circle bg-primary bg-opacity-10 text-primary" style="width: 45px; height: 45px; border-radius: 12px; flex-shrink: 0;">
                <i class="fas fa-comment-dots"></i>
              </div>
              <div>
                <div class="fw-800 text-dark mb-1">{{ $k->topik }}</div>
                <div class="chat-preview">{{ $k->pertanyaan }}</div>
              </div>
            </div>
          </td>
          <td>
            <div class="fw-bold text-dark">{{ $k->anak->nama ?? '-' }}</div>
            <div class="user-meta small">{{ $k->user->name ?? '-' }}</div>
          </td>
          <td>
            <div class="fw-bold text-dark small">{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</div>
            <div class="user-meta" style="font-size: 10px;">{{ \Carbon\Carbon::parse($k->created_at)->diffForHumans() }}</div>
          </td>
          <td>
            <span class="status-pill status-{{ $k->status }}">
              {{ ucfirst($k->status) }}
            </span>
          </td>
          <td class="text-end">
            <a href="{{ route('admin.konsultasi.show', $k->id) }}" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
              Balas <i class="fas fa-paper-plane ms-1 small"></i>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="py-5 text-center">
            <div class="empty-state py-5">
              <i class="fas fa-comments fa-3x opacity-20 mb-3"></i>
              <h5 class="fw-800 text-dark">Tidak Ada Konsultasi</h5>
              <p class="user-meta small">Pertanyaan dari orang tua akan muncul di sini.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4 mb-5">
  {{ $konsultasis->links('vendor.pagination.sigap-premium') }}
</div>
@endsection
