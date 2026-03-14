@extends('admin.layout.master')

@section('title', 'Data Anak')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Data Anak</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.3/css/buttons.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css">
<style>
  :root {
    --primary: #0ea5e9;
    --primary-dark: #0284c7;
    --primary-light: #e0f2fe;
    --dark: #0f172a;
    --dark-secondary: #1e293b;
    --gray-600: #475569;
    --gray-500: #64748b;
    --gray-400: #94a3b8;
    --gray-100: #f1f5f9;
    --white: #ffffff;
    --success: #22c55e;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #06b6d4;
  }

  * {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  .auth-wrapper {
    display: flex;
    min-height: calc(100vh - 140px);
    background: var(--white);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 50px rgba(0,0,0,0.08);
    margin-bottom: 24px;
  }

  .auth-sidebar-section {
    width: 35%;
    background: var(--primary);
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

  .auth-sidebar-section::before {
    content: '';
    position: absolute;
    top: -80px;
    right: -80px;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
  }

  .auth-sidebar-section::after {
    content: '';
    position: absolute;
    bottom: -100px;
    left: -100px;
    width: 350px;
    height: 350px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
  }

  .sidebar-content {
    position: relative;
    z-index: 2;
  }

  .sidebar-logo {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.15);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 28px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
  }

  .sidebar-logo i {
    font-size: 36px;
    color: var(--white);
  }

  .sidebar-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--white);
    margin-bottom: 8px;
  }

  .sidebar-subtitle {
    font-size: 1rem;
    color: rgba(255,255,255,0.85);
    margin-bottom: 36px;
  }

  .sidebar-stats {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .sidebar-stat-item {
    background: rgba(255,255,255,0.1);
    padding: 16px 20px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 14px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.15);
  }

  .sidebar-stat-icon {
    width: 44px;
    height: 44px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-size: 18px;
  }

  .sidebar-stat-info {
    flex: 1;
  }

  .sidebar-stat-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--white);
    line-height: 1;
  }

  .sidebar-stat-label {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.75);
    font-weight: 500;
  }

  .auth-main-section {
    width: 65%;
    padding: 32px;
  }

  .main-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }

  .main-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
  }

  .btn-add-new {
    background: var(--primary);
    border: none;
    border-radius: 12px;
    padding: 12px 22px;
    font-weight: 600;
    color: var(--white);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35);
  }

  .btn-add-new:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(14, 165, 233, 0.45);
    color: var(--white);
    background: var(--primary);
  }

  .filter-bar {
    background: var(--gray-100);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
  }

  .search-box {
    flex: 1;
    min-width: 250px;
    position: relative;
  }

  .search-box i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
  }

  .search-box input {
    width: 100%;
    padding: 12px 16px 12px 46px;
    border: 2px solid transparent;
    border-radius: 12px;
    font-size: 0.9rem;
    background: var(--white);
    transition: all 0.25s ease;
  }

  .search-box input:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
  }

  .filter-select {
    padding: 12px 16px;
    border: 2px solid transparent;
    border-radius: 12px;
    font-size: 0.9rem;
    background: var(--white);
    cursor: pointer;
    transition: all 0.25s ease;
    min-width: 150px;
  }

  .filter-select:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
  }

  .btn-filter {
    background: var(--white);
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 20px;
    font-weight: 600;
    color: var(--gray-600);
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-filter:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--white);
  }

  .data-table-card {
    background: var(--white);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  }

  .table-header-bar {
    background: var(--dark);
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .table-header-title {
    color: var(--white);
    font-weight: 600;
    font-size: 0.95rem;
    margin: 0;
  }

  .table-header-count {
    background: rgba(255,255,255,0.15);
    padding: 5px 12px;
    border-radius: 20px;
    color: rgba(255,255,255,0.9);
    font-size: 0.8rem;
    font-weight: 600;
  }

  .modern-table {
    width: 100%;
    border-collapse: collapse;
  }

  .modern-table thead th {
    background: #f8fafc;
    padding: 14px 18px;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gray-500);
    border: none;
    border-bottom: 2px solid #e2e8f0;
  }

  .modern-table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f1f5f9;
  }

  .modern-table tbody tr:hover {
    background: var(--gray-100);
  }

  .modern-table tbody td {
    padding: 16px 18px;
    vertical-align: middle;
    border: none;
  }

  .profile-cell {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .profile-img {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
    color: var(--white);
  }

  .img-boy { background: var(--primary); }
  .img-girl { background: #ec4899; }

  .profile-name {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9rem;
  }

  .profile-meta {
    font-size: 0.8rem;
    color: var(--gray-400);
  }

  .tag-badge {
    padding: 7px 13px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .tag-boy { background: rgba(14, 165, 233, 0.1); color: var(--primary-dark); }
  .tag-girl { background: rgba(236, 72, 153, 0.1); color: #be185d; }

  .status-indicator {
    padding: 7px 13px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .status-active { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
  .status-moved { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .status-passed { background: rgba(239, 68, 68, 0.1); color: #dc2626; }

  .gizi-indicator {
    padding: 7px 13px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .gizi-normal { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
  .gizi-buruk { background: rgba(239, 68, 68, 0.1); color: #dc2626; }
  .gizi-stunting { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .gizi-underweight { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .gizi-overweight { background: rgba(6, 182, 212, 0.1); color: #0891b2; }
  .gizi-none { background: var(--gray-100); color: var(--gray-500); }

  .faskes-label {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 7px 13px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--gray-600);
  }

  .action-btns {
    display: flex;
    gap: 6px;
    justify-content: flex-end;
  }

  .btn-action {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .btn-action:hover { transform: scale(1.1); }

  .btn-see { background: rgba(14, 165, 233, 0.1); color: var(--primary); }
  .btn-see:hover { background: var(--primary); color: var(--white); }

  .btn-pen { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
  .btn-pen:hover { background: var(--warning); color: var(--white); }

  .btn-trash { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
  .btn-trash:hover { background: var(--danger); color: var(--white); }

  .empty-box {
    text-align: center;
    padding: 60px 20px;
  }

  .empty-img {
    width: 120px;
    height: 120px;
    background: var(--gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
  }

  .empty-img i {
    font-size: 48px;
    color: var(--gray-400);
  }

  .empty-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 6px;
  }

  .empty-msg {
    color: var(--gray-500);
    margin-bottom: 20px;
  }

  .export-btn {
    background: var(--primary) !important;
    border: none !important;
    border-radius: 10px !important;
    color: var(--white) !important;
    padding: 10px 16px !important;
    font-weight: 600 !important;
    box-shadow: 0 3px 12px rgba(14, 165, 233, 0.3) !important;
    transition: all 0.3s ease !important;
  }

  .export-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 18px rgba(14, 165, 233, 0.4) !important;
  }

  .dt-search input {
    border: 2px solid #e2e8f0 !important;
    border-radius: 10px !important;
    padding: 8px 12px !important;
    background: var(--gray-100) !important;
  }

  .dt-search input:focus {
    border-color: var(--primary) !important;
    outline: none;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1) !important;
  }

  .dt-length select {
    border: 2px solid #e2e8f0 !important;
    border-radius: 10px !important;
    padding: 6px 10px !important;
    background: var(--gray-100) !important;
  }

  .dt-info { color: var(--gray-500) !important; font-weight: 500 !important; }

  .dt-paging-button {
    border-radius: 8px !important;
    margin: 0 3px !important;
    border: none !important;
  }

  .dt-paging-button.current {
    background: var(--primary) !important;
    color: var(--white) !important;
  }

  .dt-paging-button:hover:not(.current) {
    background: var(--gray-100) !important;
    color: var(--primary) !important;
  }

  @media (max-width: 1100px) {
    .auth-wrapper { flex-direction: column; }
    .auth-sidebar-section { width: 100%; padding: 32px; }
    .auth-main-section { width: 100%; }
    .sidebar-stats { flex-direction: row; flex-wrap: wrap; }
    .sidebar-stat-item { flex: 1; min-width: 140px; }
  }

  @media (max-width: 768px) {
    .auth-sidebar-section { padding: 24px; }
    .auth-main-section { padding: 20px; }
    .main-header { flex-direction: column; gap: 16px; align-items: stretch; }
    .filter-bar { flex-direction: column; }
    .search-box { width: 100%; }
    .filter-select { width: 100%; }
  }
</style>
@endsection

@section('content')
<div class="auth-wrapper">
  <div class="auth-sidebar-section">
    <div class="sidebar-content">
      <div class="sidebar-logo">
        <i class="fas fa-children"></i>
      </div>
      <h1 class="sidebar-title">Data Anak</h1>
      <p class="sidebar-subtitle">Kelola data tumbuh kembang anak dengan lebih mudah</p>
      
      <div class="sidebar-stats">
        <div class="sidebar-stat-item">
          <div class="sidebar-stat-icon">
            <i class="fas fa-users"></i>
          </div>
          <div class="sidebar-stat-info">
            <div class="sidebar-stat-value">{{ $anak->total() }}</div>
            <div class="sidebar-stat-label">Total Anak</div>
          </div>
        </div>
        <div class="sidebar-stat-item">
          <div class="sidebar-stat-icon">
            <i class="fas fa-circle-check"></i>
          </div>
          <div class="sidebar-stat-info">
            <div class="sidebar-stat-value">{{ $anak->where('status', 'aktif')->count() }}</div>
            <div class="sidebar-stat-label">Anak Aktif</div>
          </div>
        </div>
        <div class="sidebar-stat-item">
          <div class="sidebar-stat-icon">
            <i class="fas fa-person"></i>
          </div>
          <div class="sidebar-stat-info">
            <div class="sidebar-stat-value">{{ $anak->where('jenis_kelamin', 'L')->count() }}</div>
            <div class="sidebar-stat-label">Laki-laki</div>
          </div>
        </div>
        <div class="sidebar-stat-item">
          <div class="sidebar-stat-icon">
            <i class="fas fa-person-dress"></i>
          </div>
          <div class="sidebar-stat-info">
            <div class="sidebar-stat-value">{{ $anak->where('jenis_kelamin', 'P')->count() }}</div>
            <div class="sidebar-stat-label">Perempuan</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="auth-main-section">
    <div class="main-header">
      <h2 class="main-title"><i class="fas fa-list me-2"></i>Daftar Data Anak</h2>
      <a href="{{ route('admin.anak.create') }}" class="btn-add-new">
        <i class="fas fa-user-plus"></i> Tambah Anak
      </a>
    </div>

    <div class="filter-bar">
      <div class="search-box">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" id="tableSearch" placeholder="Cari nama atau ibu...">
      </div>
      <form method="GET" class="d-flex gap-2 flex-wrap">
        <select name="jenis_kelamin" class="filter-select">
          <option value="">Semua JK</option>
          <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
          <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        <select name="status" class="filter-select">
          <option value="">Semua Status</option>
          <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
          <option value="meninggal" {{ request('status') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
        </select>
        <button type="submit" class="btn-filter">
          <i class="fas fa-filter"></i> Filter
        </button>
        @if(request()->hasAny(['jenis_kelamin', 'status', 'search']))
        <a href="{{ route('admin.anak.index') }}" class="btn btn-outline-secondary" style="border-radius: 12px; padding: 12px 14px;">
          <i class="fas fa-xmark"></i>
        </a>
        @endif
      </form>
    </div>

    @if($anak->count() > 0)
    <div class="data-table-card">
      <div class="table-header-bar">
        <h5 class="table-header-title"><i class="fas fa-table me-2"></i>Data</h5>
        <span class="table-header-count">{{ $anak->total() }} Items</span>
      </div>
      <div style="overflow-x: auto;">
        <table id="anakTable" class="modern-table" style="width: 100%">
          <thead>
            <tr>
              <th>Anak</th>
              <th>Jenis Kelamin</th>
              <th>Tanggal Lahir</th>
              <th>Usia</th>
              <th>Faskes</th>
              <th>Status Gizi</th>
              <th>Status</th>
              <th style="text-align: right;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($anak as $item)
            <tr>
              <td>
                <div class="profile-cell">
                  <div class="profile-img img-{{ $item->jenis_kelamin == 'L' ? 'boy' : 'girl' }}">
                    {{ strtoupper(substr($item->nama, 0, 1)) }}
                  </div>
                  <div>
                    <div class="profile-name">{{ $item->nama }}</div>
                    <div class="profile-meta">{{ $item->ibu->name ?? '-' }}</div>
                  </div>
                </div>
              </td>
              <td>
                <span class="tag-badge tag-{{ $item->jenis_kelamin == 'L' ? 'boy' : 'girl' }}">
                  <i class="fas fa-{{ $item->jenis_kelamin == 'L' ? 'person' : 'person-dress' }}"></i>
                  {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>
              </td>
              <td>
                <span style="color: var(--gray-600); font-weight: 500;">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</span>
              </td>
              <td>
                @php
                  $usia = \Carbon\Carbon::parse($item->tanggal_lahir)->diff(now());
                  $usiaText = $usia->y > 0 ? $usia->y . ' th ' . $usia->m . ' bln' : ($usia->m > 0 ? $usia->m . ' bln' : $usia->d . ' hr');
                @endphp
                <span style="font-weight: 600; color: var(--primary);">{{ $usiaText }}</span>
              </td>
              <td>
                <span class="faskes-label">
                  <i class="fas fa-hospital me-1" style="color: var(--gray-400);"></i>
                  {{ $item->faskes->nama ?? '-' }}
                </span>
              </td>
              <td>
                @if($item->latestPemeriksaan && $item->latestPemeriksaan->status_gizi_akhir)
                  @php
                    $status = $item->latestPemeriksaan->status_gizi_akhir;
                    $badgeClass = 'gizi-none';
                    $badgeIcon = 'fas fa-minus';
                    $badgeText = '-';
                    
                    if($status == 'normal') {
                      $badgeClass = 'gizi-normal';
                      $badgeIcon = 'fas fa-check';
                      $badgeText = 'Normal';
                    } elseif($status == 'gizi_buruk' || $status == 'wasting') {
                      $badgeClass = 'gizi-buruk';
                      $badgeIcon = 'fas fa-triangle-exclamation';
                      $badgeText = 'Gizi Buruk';
                    } elseif($status == 'stunting') {
                      $badgeClass = 'gizi-stunting';
                      $badgeIcon = 'fas fa-arrow-down';
                      $badgeText = 'Stunting';
                    } elseif($status == 'underweight') {
                      $badgeClass = 'gizi-underweight';
                      $badgeIcon = 'fas fa-minus';
                      $badgeText = 'Underweight';
                    } elseif($status == 'overweight') {
                      $badgeClass = 'gizi-overweight';
                      $badgeIcon = 'fas fa-arrow-up';
                      $badgeText = 'Overweight';
                    }
                  @endphp
                  <span class="gizi-indicator {{ $badgeClass }}">
                    <i class="{{ $badgeIcon }}"></i>{{ $badgeText }}
                  </span>
                @else
                  <span class="gizi-indicator gizi-none">
                    <i class="fas fa-minus"></i>-
                  </span>
                @endif
              </td>
              <td>
                @if($item->status == 'aktif')
                <span class="status-indicator status-active">
                  <i class="fas fa-circle-check"></i>Aktif
                </span>
                @elseif($item->status == 'pindah')
                <span class="status-indicator status-moved">
                  <i class="fas fa-arrow-right"></i>Pindah
                </span>
                @else
                <span class="status-indicator status-passed">
                  <i class="fas fa-circle-xmark"></i>Meninggal
                </span>
                @endif
              </td>
              <td>
                <div class="action-btns">
                  <a href="{{ route('admin.anak.show', $item->id) }}" class="btn-action btn-see" title="Detail">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.anak.edit', $item->id) }}" class="btn-action btn-pen" title="Edit">
                    <i class="fas fa-pen-to-square"></i>
                  </a>
                  <form action="{{ route('admin.anak.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-trash btn-delete" data-title="Hapus Data Anak" data-text="Apakah Anda yakin ingin menghapus {{ $item->nama }}?" title="Hapus">
                      <i class="fas fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @else
    <div class="empty-box">
      <div class="empty-img">
        <i class="fas fa-children"></i>
      </div>
      <h4 class="empty-title">Belum Ada Data Anak</h4>
      <p class="empty-msg">Silakan tambah data anak terlebih dahulu</p>
      <a href="{{ route('admin.anak.create') }}" class="btn-add-new">
        <i class="fas fa-plus"></i> Tambah Anak Pertama
      </a>
    </div>
    @endif
  </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.3/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.3/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
  var table = $('#anakTable').DataTable({
    responsive: true,
    language: {
      search: "Cari:",
      lengthMenu: "Tampilkan _MENU_ data",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
      infoEmpty: "Tidak ada data",
      infoFiltered: "(disaring dari _MAX_ total data)",
      zeroRecords: "Tidak ditemukan data yang sesuai",
      emptyTable: "Tidak ada data di tabel",
      paginate: {
        first: "Pertama",
        last: "Terakhir",
        next: "Selanjutnya",
        previous: "Sebelumnya"
      }
    },
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="fas fa-file-excel me-1"></i> Excel',
        className: 'export-btn',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
      },
      {
        extend: 'pdfHtml5',
        text: '<i class="fas fa-file-pdf me-1"></i> PDF',
        className: 'export-btn',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
      },
      {
        extend: 'print',
        text: '<i class="fas fa-print me-1"></i> Print',
        className: 'export-btn',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
      }
    ],
    columnDefs: [
      { responsivePriority: 1, targets: 0 },
      { responsivePriority: 2, targets: 6 },
      { responsivePriority: 3, targets: 1 }
    ]
  });

  $('#tableSearch').on('keyup', function() {
    table.search($(this).val()).draw();
  });
});
</script>
@endsection
