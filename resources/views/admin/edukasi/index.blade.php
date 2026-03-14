@extends('admin.layout.master')

@section('title', 'Manajemen Konten Edukasi')

@push('styles')
<style>
  /* Reuse consistent premium styles */
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

  .article-preview-img {
    width: 80px; height: 55px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }
  .category-pill {
    padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase;
  }
  .cat-nutrisi { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
  .cat-imunisasi { background: rgba(14, 165, 233, 0.1); color: #0284c7; }
  .cat-perkembangan { background: rgba(168, 85, 247, 0.1); color: #9333ea; }
  .cat-penyakit { background: rgba(239, 68, 68, 0.1); color: #dc2626; }
</style>
@endpush

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Konten Edukasi</li>
@endsection

@section('content')
<div class="page-header-premium">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <h1 class="display-5 fw-800 text-white mb-1">Pusat Informasi</h1>
      <p class="text-white opacity-60 fs-5">Kelola artikel kesehatan dan tips pengasuhan untuk orang tua.</p>
      
      <div class="header-stats-mini">
        <div class="header-stat-item">
          <div class="header-stat-label">Total Artikel</div>
          <div class="header-stat-value">{{ $edukasis->total() }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Total Views</div>
          <div class="header-stat-value text-info">{{ number_format($edukasis->sum('views')) }}</div>
        </div>
        <div class="header-stat-item">
          <div class="header-stat-label">Aktif</div>
          <div class="header-stat-value text-success">{{ $edukasis->where('is_active', true)->count() }}</div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
      <a href="{{ route('admin.edukasi.create') }}" class="btn btn-premium-action btn-gradient-add">
        <i class="fas fa-edit me-2"></i> Tulis Artikel Baru
      </a>
    </div>
  </div>
</div>

<div class="filter-container-glass mx-3">
  <form method="GET" action="{{ route('admin.edukasi.index') }}" class="row g-3">
    <div class="col-lg-6">
      <input type="text" name="search" class="form-control border-0 bg-light rounded-4 py-3 px-4" placeholder="Cari Judul Artikel..." value="{{ request('search') }}">
    </div>
    <div class="col-lg-4">
      <select name="kategori" class="form-select border-0 bg-light rounded-4 py-3 px-4 fw-bold">
        <option value="">Semua Kategori</option>
        <option value="nutrisi" {{ request('kategori') == 'nutrisi' ? 'selected' : '' }}>Nutrisi & Gizi</option>
        <option value="imunisasi" {{ request('kategori') == 'imunisasi' ? 'selected' : '' }}>Imunisasi</option>
        <option value="perkembangan" {{ request('kategori') == 'perkembangan' ? 'selected' : '' }}>Perkembangan</option>
        <option value="penyakit" {{ request('kategori') == 'penyakit' ? 'selected' : '' }}>Informasi Penyakit</option>
      </select>
    </div>
    <div class="col-lg-2">
      <button type="submit" class="btn btn-primary w-100 rounded-4 py-3 fw-bold shadow-sm">
        <i class="fas fa-search me-1"></i> Filter
      </button>
    </div>
  </form>
</div>

<div class="table-premium-container px-3">
  <div class="table-responsive">
    <table class="table-modern">
      <thead>
        <tr>
          <th style="width: 45%;">Judul & Pratinjau</th>
          <th>Kategori</th>
          <th>Pembaca</th>
          <th>Status</th>
          <th class="text-end">Opsi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($edukasis as $e)
        <tr>
          <td>
            <div class="d-flex align-items-center gap-3">
              @if($e->image)
                <img src="{{ asset('storage/'.$e->image) }}" class="article-preview-img">
              @else
                <div class="article-preview-img bg-light d-flex align-items-center justify-content-center">
                  <i class="fas fa-image text-muted opacity-30"></i>
                </div>
              @endif
              <div>
                <div class="fw-800 text-dark mb-0 fs-6 line-clamp-1">{{ $e->judul }}</div>
                <div class="user-meta small">{{ \Carbon\Carbon::parse($e->created_at)->format('d M Y') }}</div>
              </div>
            </div>
          </td>
          <td>
            <span class="category-pill cat-{{ $e->kategori }}">
              {{ ucfirst($e->kategori) }}
            </span>
          </td>
          <td>
            <div class="fw-bold text-dark"><i class="far fa-eye me-1 text-muted"></i> {{ number_format($e->views ?: 0) }}</div>
          </td>
          <td>
            @if($e->is_active)
              <span class="badge-custom badge-normal py-1 px-3">Publik</span>
            @else
              <span class="badge-custom badge-default py-1 px-3">Draft</span>
            @endif
          </td>
          <td class="text-end">
            <div class="d-flex gap-2 justify-content-end">
              <a href="{{ route('admin.edukasi.show', $e->id) }}" class="btn btn-light btn-sm rounded-3 border">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{ route('admin.edukasi.edit', $e->id) }}" class="btn btn-light btn-sm rounded-3 border">
                <i class="fas fa-edit"></i>
              </a>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="py-5 text-center">
            <div class="empty-state py-5">
              <i class="fas fa-book-open fa-3x opacity-20 mb-3"></i>
              <h5 class="fw-800 text-dark">Belum Ada Artikel</h5>
              <p class="user-meta small">Mulai tulis artikel edukasi pertama Anda.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-4 mb-5">
  {{ $edukasis->links('vendor.pagination.sigap-premium') }}
</div>
@endsection
