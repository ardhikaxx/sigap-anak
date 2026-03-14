@extends('admin.layout.master')

@section('title', 'Edukasi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Edukasi</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css">
<style>
  :root {
    --primary: #0ea5e9; --primary-dark: #0284c7; --dark: #0f172a;
    --gray-600: #475569; --gray-500: #64748b; --gray-400: #94a3b8;
    --gray-100: #f1f5f9; --white: #ffffff;
    --success: #22c55e; --warning: #f59e0b; --danger: #ef4444; --info: #06b6d4;
  }
  * { font-family: 'Plus Jakarta Sans', -apple-system, sans-serif; }

  .hero-section {
    background: var(--primary); border-radius: 24px; padding: 40px 44px;
    color: white; position: relative; overflow: hidden; margin-bottom: 28px;
  }
  .hero-section::before {
    content: ''; position: absolute; top: -50%; right: -10%; width: 320px; height: 320px;
    background: rgba(255,255,255,0.08); border-radius: 50%;
  }
  .hero-title { font-size: 2.25rem; font-weight: 800; margin-bottom: 6px; }
  .hero-subtitle { font-size: 1.05rem; opacity: 0.9; }

  .btn-add-hero {
    background: var(--white); color: var(--primary); border: none; border-radius: 14px;
    padding: 14px 26px; font-weight: 700; font-size: 0.95rem; transition: all 0.3s ease;
    display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 6px 20px rgba(0,0,0,0.15);
  }
  .btn-add-hero:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.2); color: var(--primary-dark); background: var(--white); }

  .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 28px; }
  .stat-card {
    background: var(--white); border-radius: 20px; padding: 26px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;
    transition: all 0.35s ease; position: relative; overflow: hidden;
  }
  .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 5px; height: 100%; background: var(--stat-color); }
  .stat-card:hover { transform: translateY(-6px); box-shadow: 0 16px 45px rgba(0,0,0,0.12); }
  .stat-icon {
    width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center;
    font-size: 22px; margin-bottom: 16px; background: var(--stat-bg); color: var(--stat-color);
  }
  .stat-number { font-size: 2.5rem; font-weight: 800; color: var(--dark); line-height: 1; margin-bottom: 4px; }
  .stat-label { font-size: 0.9rem; color: var(--gray-500); font-weight: 500; }

  .content-card {
    background: var(--white); border-radius: 22px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px;
  }
  .card-header-section { padding: 22px 28px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
  .card-title-section { font-size: 1.1rem; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 12px; margin: 0; }
  .card-title-section i { color: var(--primary); }

  .filter-row { display: flex; gap: 12px; flex-wrap: wrap; }
  .filter-dropdown {
    padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px;
    font-size: 0.9rem; background: var(--gray-100); cursor: pointer; min-width: 140px;
  }
  .filter-dropdown:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1); }
  .btn-filter { background: var(--gray-100); border: 2px solid #e2e8f0; border-radius: 12px; padding: 12px 20px; font-weight: 600; color: var(--gray-600); transition: all 0.25s ease; display: inline-flex; align-items: center; gap: 8px; }
  .btn-filter:hover { background: var(--primary); border-color: var(--primary); color: var(--white); }

  .table-main { width: 100%; border-collapse: collapse; }
  .table-main thead th {
    background: #f8fafc; padding: 14px 16px; font-weight: 600; font-size: 0.7rem;
    text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray-500); border: none; border-bottom: 2px solid #e2e8f0;
  }
  .table-main tbody tr { transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9; }
  .table-main tbody tr:hover { background: var(--gray-100); }
  .table-main tbody td { padding: 16px; vertical-align: middle; border: none; }

  .title-cell strong { display: block; color: var(--dark); font-weight: 600; font-size: 0.95rem; }
  .title-cell small { color: var(--gray-400); font-size: 0.8rem; }

  .badge-kategori { padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.75rem; }
  .badge-nutrisi { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
  .badge-imunisasi { background: rgba(14, 165, 233, 0.1); color: #0284c7; }
  .badge-perkembangan { background: rgba(168, 85, 247, 0.1); color: #9333ea; }
  .badge-penyakit { background: rgba(239, 68, 68, 0.1); color: #dc2626; }

  .badge-status { padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.75rem; }
  .badge-aktif { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
  .badge-nonaktif { background: var(--gray-100); color: var(--gray-500); }

  .action-group { display: flex; gap: 6px; justify-content: center; }
  .btn-icon { width: 34px; height: 34px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; border: none; transition: all 0.2s ease; cursor: pointer; }
  .btn-icon:hover { transform: scale(1.1); }
  .btn-lihat { background: rgba(14, 165, 233, 0.1); color: var(--primary); }
  .btn-lihat:hover { background: var(--primary); color: var(--white); }
  .btn-ubah { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
  .btn-ubah:hover { background: var(--warning); color: var(--white); }
  .btn-hapus { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
  .btn-hapus:hover { background: var(--danger); color: var(--white); }

  .empty-state { text-align: center; padding: 80px 24px; }
  .empty-visual { width: 150px; height: 150px; background: var(--gray-100); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; border: 3px solid #e2e8f0; }
  .empty-visual i { font-size: 60px; color: var(--gray-400); }
  .empty-heading { font-size: 1.3rem; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
  .empty-desc { color: var(--gray-500); margin-bottom: 24px; }

  @media (max-width: 992px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 768px) {
    .hero-section { padding: 28px; text-align: center; }
    .hero-title { font-size: 1.75rem; }
    .stats-grid { grid-template-columns: 1fr; }
    .card-header-section { flex-direction: column; gap: 14px; align-items: flex-start; }
    .filter-row { width: 100%; }
    .filter-dropdown { width: 100%; }
  }
</style>
@endsection

@section('content')
<div class="hero-section">
  <div class="row align-items-center">
    <div class="col-lg-8">
      <h1 class="hero-title"><i class="fas fa-book-medical me-3"></i>Edukasi</h1>
      <p class="hero-subtitle">Kelola konten edukasi kesehatan anak dengan lebih mudah</p>
    </div>
    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
      <a href="{{ route('admin.edukasi.create') }}" class="btn-add-hero">
        <i class="fas fa-plus"></i> Tambah Edukasi
      </a>
    </div>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card" style="--stat-color: #0ea5e9; --stat-bg: rgba(14, 165, 233, 0.1);">
    <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
    <div class="stat-number">{{ $edukasis->total() }}</div>
    <div class="stat-label">Total Artikel</div>
  </div>
  <div class="stat-card" style="--stat-color: #22c55e; --stat-bg: rgba(34, 197, 94, 0.1);">
    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
    <div class="stat-number">{{ $edukasis->where('is_active', true)->count() }}</div>
    <div class="stat-label">Artikel Aktif</div>
  </div>
  <div class="stat-card" style="--stat-color: #06b6d4; --stat-bg: rgba(6, 182, 212, 0.1);">
    <div class="stat-icon"><i class="fas fa-eye"></i></div>
    <div class="stat-number">{{ $edukasis->sum('views') }}</div>
    <div class="stat-label">Total Views</div>
  </div>
</div>

<div class="content-card">
  <div class="card-header-section">
    <h5 class="card-title-section"><i class="fas fa-list"></i> Daftar Artikel Edukasi</h5>
    <form method="GET" class="filter-row">
      <select name="kategori" class="filter-dropdown">
        <option value="">Semua Kategori</option>
        <option value="nutrisi" {{ request('kategori') == 'nutrisi' ? 'selected' : '' }}>Nutrisi</option>
        <option value="imunisasi" {{ request('kategori') == 'imunisasi' ? 'selected' : '' }}>Imunisasi</option>
        <option value="perkembangan" {{ request('kategori') == 'perkembangan' ? 'selected' : '' }}>Perkembangan</option>
        <option value="penyakit" {{ request('kategori') == 'penyakit' ? 'selected' : '' }}>Penyakit</option>
      </select>
      <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filter</button>
      @if(request()->hasAny(['kategori', 'search']))
      <a href="{{ route('admin.edukasi.index') }}" class="btn-filter"><i class="fas fa-xmark"></i></a>
      @endif
    </form>
  </div>
  <div style="padding: 0; overflow-x: auto;">
    @if($edukasis->count() > 0)
    <table class="table-main">
      <thead>
        <tr>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Views</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th style="text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($edukasis as $e)
        <tr>
          <td>
            <div class="title-cell">
              <strong>{{ $e->judul }}</strong>
              <small>{{ Illuminate\Support\Str::limit(strip_tags($e->konten), 50) }}</small>
            </div>
          </td>
          <td>
            <span class="badge-kategori badge-{{ $e->kategori }}">
              <i class="fas @switch($e->kategori) @case('nutrisi') fa-apple-alt @case('imunisasi') fa-syringe @case('perkembangan') fa-baby @case('penyakit') fa-virus @endswitch me-1"></i>
              {{ ucfirst($e->kategori) }}
            </span>
          </td>
          <td><strong>{{ $e->views ?? 0 }}</strong></td>
          <td>{{ \Carbon\Carbon::parse($e->created_at)->format('d M Y') }}</td>
          <td>
            <span class="badge-status {{ $e->is_active ? 'badge-aktif' : 'badge-nonaktif' }}">
              {{ $e->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
          </td>
          <td>
            <div class="action-group">
              <a href="{{ route('admin.edukasi.show', $e->id) }}" class="btn-icon btn-lihat"><i class="fas fa-eye"></i></a>
              <a href="{{ route('admin.edukasi.edit', $e->id) }}" class="btn-icon btn-ubah"><i class="fas fa-edit"></i></a>
              <form action="{{ route('admin.edukasi.destroy', $e->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn-icon btn-hapus btn-delete"><i class="fas fa-trash-can"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <div class="empty-state">
      <div class="empty-visual"><i class="fas fa-book-medical"></i></div>
      <h4 class="empty-heading">Belum Ada Artikel</h4>
      <p class="empty-desc">Silakan tambah artikel edukasi terlebih dahulu</p>
      <a href="{{ route('admin.edukasi.create') }}" class="btn-add-hero"><i class="fas fa-plus"></i> Tambah Edukasi</a>
    </div>
    @endif
  </div>
</div>
@endsection
