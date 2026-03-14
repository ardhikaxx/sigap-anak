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

  .page-header {
    background: var(--primary);
    border-radius: 24px;
    padding: 36px 40px;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 28px;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -60px;
    right: -60px;
    width: 250px;
    height: 250px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
  }

  .page-header::after {
    content: '';
    position: absolute;
    bottom: -80px;
    left: -80px;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
  }

  .header-content {
    position: relative;
    z-index: 2;
  }

  .page-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 6px;
  }

  .page-subtitle {
    font-size: 1rem;
    opacity: 0.9;
  }

  .btn-add {
    background: var(--white);
    color: var(--primary);
    border: none;
    border-radius: 14px;
    padding: 14px 24px;
    font-weight: 700;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }

  .btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    color: var(--primary-dark);
    background: var(--white);
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 28px;
  }

  .stat-card {
    background: var(--white);
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--stat-color);
  }

  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1);
  }

  .stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 14px;
    background: var(--stat-bg);
    color: var(--stat-color);
  }

  .stat-number {
    font-size: 2.25rem;
    font-weight: 800;
    color: var(--dark);
    line-height: 1;
    margin-bottom: 4px;
  }

  .stat-label {
    font-size: 0.85rem;
    color: var(--gray-500);
    font-weight: 500;
  }

  .filter-section {
    background: var(--white);
    border-radius: 18px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
  }

  .search-input {
    width: 100%;
    padding: 14px 16px 14px 48px;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    font-size: 0.95rem;
    transition: all 0.25s ease;
    background: var(--gray-100);
  }

  .search-input:focus {
    border-color: var(--primary);
    background: var(--white);
    outline: none;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
  }

  .search-wrapper {
    position: relative;
  }

  .search-wrapper i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
  }

  .filter-select {
    padding: 14px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    font-size: 0.95rem;
    transition: all 0.25s ease;
    background: var(--gray-100);
    cursor: pointer;
  }

  .filter-select:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
  }

  .btn-filter {
    background: var(--gray-100);
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    padding: 14px 22px;
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

  .table-card {
    background: var(--white);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,0,0,0.08);
    border: 1px solid #e2e8f0;
  }

  .table-header {
    background: var(--dark);
    padding: 18px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .table-title {
    color: var(--white);
    font-weight: 700;
    font-size: 1rem;
    margin: 0;
  }

  .table-count {
    background: rgba(255,255,255,0.15);
    padding: 6px 14px;
    border-radius: 20px;
    color: rgba(255,255,255,0.9);
    font-size: 0.85rem;
    font-weight: 600;
  }

  .data-table {
    width: 100%;
    border-collapse: collapse;
  }

  .data-table thead th {
    background: #f8fafc;
    padding: 16px 20px;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gray-500);
    border: none;
    border-bottom: 2px solid #e2e8f0;
  }

  .data-table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f1f5f9;
  }

  .data-table tbody tr:hover {
    background: var(--gray-100);
  }

  .data-table tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    border: none;
  }

  .child-profile {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .child-avatar {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 18px;
    color: var(--white);
  }

  .avatar-boy {
    background: var(--primary);
  }

  .avatar-girl {
    background: #ec4899;
  }

  .child-info strong {
    display: block;
    color: var(--dark);
    font-weight: 600;
    margin-bottom: 2px;
  }

  .child-info small {
    color: var(--gray-400);
    font-size: 0.8rem;
  }

  .gender-badge {
    padding: 8px 14px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.8rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .badge-boy {
    background: rgba(14, 165, 233, 0.1);
    color: var(--primary-dark);
  }

  .badge-girl {
    background: rgba(236, 72, 153, 0.1);
    color: #be185d;
  }

  .status-badge {
    padding: 8px 14px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.8rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .badge-active {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
  }

  .badge-moved {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
  }

  .badge-passed {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
  }

  .gizi-badge {
    padding: 8px 14px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.8rem;
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

  .faskes-tag {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 8px 14px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--gray-600);
  }

  .action-buttons {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
  }

  .btn-action {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .btn-action:hover {
    transform: scale(1.1);
  }

  .btn-view {
    background: rgba(14, 165, 233, 0.1);
    color: var(--primary);
  }

  .btn-view:hover {
    background: var(--primary);
    color: var(--white);
  }

  .btn-edit {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
  }

  .btn-edit:hover {
    background: var(--warning);
    color: var(--white);
  }

  .btn-delete {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
  }

  .btn-delete:hover {
    background: var(--danger);
    color: var(--white);
  }

  .empty-state {
    text-align: center;
    padding: 80px 24px;
  }

  .empty-illustration {
    width: 140px;
    height: 140px;
    background: var(--gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
  }

  .empty-illustration i {
    font-size: 56px;
    color: var(--gray-400);
  }

  .empty-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 8px;
  }

  .empty-text {
    color: var(--gray-500);
    margin-bottom: 24px;
  }

  .export-btn {
    background: var(--primary) !important;
    border: none !important;
    border-radius: 12px !important;
    color: var(--white) !important;
    padding: 12px 20px !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3) !important;
    transition: all 0.3s ease !important;
  }

  .export-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4) !important;
  }

  .dt-search input {
    border: 2px solid #e2e8f0 !important;
    border-radius: 10px !important;
    padding: 10px 14px !important;
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
    padding: 8px 12px !important;
    background: var(--gray-100) !important;
  }

  .dt-info {
    color: var(--gray-500) !important;
    font-weight: 500 !important;
  }

  .dt-paging-button {
    border-radius: 8px !important;
    margin: 0 4px !important;
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

  @media (max-width: 1200px) {
    .stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 768px) {
    .page-header {
      padding: 28px;
      text-align: center;
    }

    .page-title {
      font-size: 1.5rem;
    }

    .stats-grid {
      grid-template-columns: 1fr;
    }

    .stat-number {
      font-size: 1.75rem;
    }

    .filter-section .row {
      gap: 12px;
    }

    .table-header {
      flex-direction: column;
      gap: 12px;
      text-align: center;
    }
  }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="header-content">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="page-title">
          <i class="fas fa-children me-2"></i>Data Anak
        </h1>
        <p class="page-subtitle">Kelola data tumbuh kembang anak dengan lebih mudah</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <a href="{{ route('admin.anak.create') }}" class="btn-add">
          <i class="fas fa-user-plus"></i>
          Tambah Anak
        </a>
      </div>
    </div>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card" style="--stat-color: #0ea5e9; --stat-bg: rgba(14, 165, 233, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-users"></i>
    </div>
    <div class="stat-number">{{ $anak->total() }}</div>
    <div class="stat-label">Total Anak</div>
  </div>
  <div class="stat-card" style="--stat-color: #22c55e; --stat-bg: rgba(34, 197, 94, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-circle-check"></i>
    </div>
    <div class="stat-number">{{ $anak->where('status', 'aktif')->count() }}</div>
    <div class="stat-label">Anak Aktif</div>
  </div>
  <div class="stat-card" style="--stat-color: #0ea5e9; --stat-bg: rgba(14, 165, 233, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-person"></i>
    </div>
    <div class="stat-number">{{ $anak->where('jenis_kelamin', 'L')->count() }}</div>
    <div class="stat-label">Laki-laki</div>
  </div>
  <div class="stat-card" style="--stat-color: #ec4899; --stat-bg: rgba(236, 72, 153, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-person-dress"></i>
    </div>
    <div class="stat-number">{{ $anak->where('jenis_kelamin', 'P')->count() }}</div>
    <div class="stat-label">Perempuan</div>
  </div>
</div>

<div class="filter-section">
  <div class="row g-3 align-items-center">
    <div class="col-lg-4">
      <div class="search-wrapper">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" id="tableSearch" class="search-input" placeholder="Cari nama atau ibu...">
      </div>
    </div>
    <div class="col-lg-8">
      <form method="GET" class="d-flex gap-2 justify-content-lg-end flex-wrap">
        <select name="jenis_kelamin" class="filter-select">
          <option value="">Semua Jenis Kelamin</option>
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
        <a href="{{ route('admin.anak.index') }}" class="btn btn-outline-secondary" style="border-radius: 14px; padding: 14px 16px;">
          <i class="fas fa-xmark"></i>
        </a>
        @endif
      </form>
    </div>
  </div>
</div>

<div class="table-card">
  @if($anak->count() > 0)
  <div class="table-header">
    <h5 class="table-title"><i class="fas fa-list me-2"></i>Daftar Data Anak</h5>
    <span class="table-count">{{ $anak->total() }} Data</span>
  </div>
  <div style="padding: 0; overflow-x: auto;">
    <table id="anakTable" class="data-table" style="width: 100%">
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
            <div class="child-profile">
              <div class="child-avatar avatar-{{ $item->jenis_kelamin == 'L' ? 'boy' : 'girl' }}">
                {{ strtoupper(substr($item->nama, 0, 1)) }}
              </div>
              <div class="child-info">
                <strong>{{ $item->nama }}</strong>
                <small>{{ $item->ibu->name ?? '-' }}</small>
              </div>
            </div>
          </td>
          <td>
            <span class="gender-badge badge-{{ $item->jenis_kelamin == 'L' ? 'boy' : 'girl' }}">
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
            <span class="faskes-tag">
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
              <span class="gizi-badge {{ $badgeClass }}">
                <i class="{{ $badgeIcon }}"></i>{{ $badgeText }}
              </span>
            @else
              <span class="gizi-badge gizi-none">
                <i class="fas fa-minus"></i>-
              </span>
            @endif
          </td>
          <td>
            @if($item->status == 'aktif')
            <span class="status-badge badge-active">
              <i class="fas fa-circle-check"></i>Aktif
            </span>
            @elseif($item->status == 'pindah')
            <span class="status-badge badge-moved">
              <i class="fas fa-arrow-right"></i>Pindah
            </span>
            @else
            <span class="status-badge badge-passed">
              <i class="fas fa-circle-xmark"></i>Meninggal
            </span>
            @endif
          </td>
          <td>
            <div class="action-buttons">
              <a href="{{ route('admin.anak.show', $item->id) }}" class="btn-action btn-view" title="Detail">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{ route('admin.anak.edit', $item->id) }}" class="btn-action btn-edit" title="Edit">
                <i class="fas fa-pen-to-square"></i>
              </a>
              <form action="{{ route('admin.anak.destroy', $item->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action btn-delete btn-delete" data-title="Hapus Data Anak" data-text="Apakah Anda yakin ingin menghapus {{ $item->nama }}?" title="Hapus">
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
  @else
  <div class="empty-state">
    <div class="empty-illustration">
      <i class="fas fa-children"></i>
    </div>
    <h4 class="empty-title">Belum Ada Data Anak</h4>
    <p class="empty-text">Silakan tambah data anak terlebih dahulu untuk memulai</p>
    <a href="{{ route('admin.anak.create') }}" class="btn-add">
      <i class="fas fa-plus"></i> Tambah Anak Pertama
    </a>
  </div>
  @endif
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
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6]
        }
      },
      {
        extend: 'pdfHtml5',
        text: '<i class="fas fa-file-pdf me-1"></i> PDF',
        className: 'export-btn',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6]
        }
      },
      {
        extend: 'print',
        text: '<i class="fas fa-print me-1"></i> Print',
        className: 'export-btn',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6]
        }
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
