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
    --dark: #0f172a;
    --gray-600: #475569;
    --gray-500: #64748b;
    --gray-400: #94a3b8;
    --gray-100: #f1f5f9;
    --white: #ffffff;
    --success: #22c55e;
    --warning: #f59e0b;
    --danger: #ef4444;
  }

  * {
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
  }

  .header-wrapper {
    background: var(--primary);
    border-radius: 20px;
    padding: 32px 36px;
    color: white;
    margin-bottom: 24px;
    box-shadow: 0 8px 30px rgba(14, 165, 233, 0.3);
  }

  .page-title-display {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 4px;
  }

  .page-subtitle-display {
    font-size: 1rem;
    opacity: 0.9;
  }

  .stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
  }

  .stat-tile {
    background: var(--white);
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
  }

  .stat-tile:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  }

  .stat-icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 12px;
  }

  .stat-value-display {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1;
    margin-bottom: 2px;
  }

  .stat-label-display {
    font-size: 0.85rem;
    color: var(--gray-500);
    font-weight: 500;
  }

  .filter-bar {
    background: var(--white);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
  }

  .search-field {
    position: relative;
  }

  .search-field i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
  }

  .search-field input {
    width: 100%;
    padding: 12px 14px 12px 42px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.25s ease;
    background: var(--gray-100);
  }

  .search-field input:focus {
    border-color: var(--primary);
    background: var(--white);
    outline: none;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
  }

  .filter-dropdown {
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.25s ease;
    background: var(--gray-100);
    cursor: pointer;
  }

  .filter-dropdown:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
  }

  .btn-add-new {
    background: var(--primary);
    border: none;
    border-radius: 10px;
    padding: 12px 22px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35);
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-add-new:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(14, 165, 233, 0.45);
    color: white;
  }

  .btn-filter-action {
    background: var(--gray-100);
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 20px;
    font-weight: 500;
    color: var(--gray-600);
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .btn-filter-action:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
  }

  .table-card {
    background: var(--white);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
  }

  .table-heading-bar {
    background: var(--dark);
    padding: 18px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .table-heading-bar h5 {
    margin: 0;
    color: white;
    font-weight: 600;
    font-size: 1rem;
  }

  .table-count-badge {
    background: rgba(255,255,255,0.15);
    padding: 5px 12px;
    border-radius: 20px;
    color: rgba(255,255,255,0.85);
    font-size: 0.8rem;
    font-weight: 500;
  }

  .data-table-custom {
    width: 100%;
    border-collapse: collapse;
  }

  .data-table-custom thead th {
    background: #f8fafc;
    padding: 14px 18px;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gray-500);
    border: none;
    border-bottom: 2px solid #e2e8f0;
  }

  .data-table-custom tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f1f5f9;
  }

  .data-table-custom tbody tr:hover {
    background: rgba(14, 165, 233, 0.03);
  }

  .data-table-custom tbody td {
    padding: 16px 18px;
    vertical-align: middle;
    border: none;
  }

  .child-profile {
    display: flex;
    align-items: center;
  }

  .profile-avatar {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
    color: white;
    margin-right: 12px;
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
    font-size: 0.95rem;
  }

  .child-info small {
    color: var(--gray-400);
    font-size: 0.8rem;
  }

  .gender-tag {
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }

  .tag-boy {
    background: rgba(14, 165, 233, 0.1);
    color: var(--primary-dark);
  }

  .tag-girl {
    background: rgba(236, 72, 153, 0.1);
    color: #be185d;
  }

  .status-indicator {
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }

  .status-active {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
  }

  .status-moved {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
  }

  .status-passed {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
  }

  .nutrition-badge {
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }

  .nutrition-normal {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
  }

  .nutrition-bad {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
  }

  .nutrition-stunting {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
  }

  .nutrition-underweight {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
  }

  .nutrition-overweight {
    background: rgba(6, 182, 212, 0.1);
    color: #0891b2;
  }

  .nutrition-none {
    background: var(--gray-100);
    color: var(--gray-400);
  }

  .faskes-tag {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--gray-600);
  }

  .action-group {
    display: flex;
    gap: 6px;
    justify-content: flex-end;
  }

  .btn-icon-action {
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

  .btn-icon-action:hover {
    transform: scale(1.1);
  }

  .btn-view-action {
    background: rgba(14, 165, 233, 0.1);
    color: var(--primary);
  }

  .btn-view-action:hover {
    background: var(--primary);
    color: white;
  }

  .btn-edit-action {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
  }

  .btn-edit-action:hover {
    background: var(--warning);
    color: white;
  }

  .btn-delete-action {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
  }

  .btn-delete-action:hover {
    background: var(--danger);
    color: white;
  }

  .no-data-state {
    text-align: center;
    padding: 60px 20px;
  }

  .no-data-illustration {
    width: 120px;
    height: 120px;
    background: var(--gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
  }

  .no-data-illustration i {
    font-size: 48px;
    color: var(--gray-400);
  }

  .export-btn {
    background: var(--primary) !important;
    border: none !important;
    border-radius: 10px !important;
    color: white !important;
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
    border-radius: 8px !important;
    padding: 8px 12px !important;
    background: var(--gray-100) !important;
  }

  .dt-search input:focus {
    border-color: var(--primary) !important;
    outline: none;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
  }

  .dt-length select {
    border: 2px solid #e2e8f0 !important;
    border-radius: 8px !important;
    padding: 6px 10px !important;
    background: var(--gray-100) !important;
  }

  .dt-info {
    color: var(--gray-500) !important;
    font-weight: 500 !important;
  }

  .dt-paging-button {
    border-radius: 6px !important;
    margin: 0 3px !important;
    border: none !important;
  }

  .dt-paging-button.current {
    background: var(--primary) !important;
    color: white !important;
  }

  .dt-paging-button:hover:not(.current) {
    background: var(--gray-100) !important;
    color: var(--primary) !important;
  }

  @media (max-width: 1200px) {
    .stats-row {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 768px) {
    .header-wrapper {
      padding: 24px;
      text-align: center;
    }

    .page-title-display {
      font-size: 1.5rem;
    }

    .stats-row {
      grid-template-columns: 1fr;
    }

    .stat-value-display {
      font-size: 1.75rem;
    }

    .filter-bar .row {
      gap: 10px;
    }

    .table-heading-bar {
      flex-direction: column;
      gap: 10px;
      text-align: center;
    }
  }
</style>
@endsection

@section('content')
<div class="header-wrapper">
  <div class="row align-items-center">
    <div class="col-lg-8">
      <h1 class="page-title-display">
        <i class="fas fa-children me-2"></i>Data Anak
      </h1>
      <p class="page-subtitle-display">Kelola data tumbuh kembang anak dengan lebih mudah</p>
    </div>
    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
      <a href="{{ route('admin.anak.create') }}" class="btn-add-new">
        <i class="fas fa-user-plus"></i>
        Tambah Anak
      </a>
    </div>
  </div>
</div>

<div class="stats-row">
  <div class="stat-tile">
    <div class="stat-icon-wrapper" style="background: rgba(14, 165, 233, 0.1); color: var(--primary);">
      <i class="fas fa-users-viewfinder"></i>
    </div>
    <div class="stat-value-display">{{ $anak->total() }}</div>
    <div class="stat-label-display">Total Anak</div>
  </div>
  <div class="stat-tile">
    <div class="stat-icon-wrapper" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
      <i class="fas fa-circle-check"></i>
    </div>
    <div class="stat-value-display">{{ $anak->where('status', 'aktif')->count() }}</div>
    <div class="stat-label-display">Anak Aktif</div>
  </div>
  <div class="stat-tile">
    <div class="stat-icon-wrapper" style="background: rgba(14, 165, 233, 0.1); color: var(--primary);">
      <i class="fas fa-person"></i>
    </div>
    <div class="stat-value-display">{{ $anak->where('jenis_kelamin', 'L')->count() }}</div>
    <div class="stat-label-display">Laki-laki</div>
  </div>
  <div class="stat-tile">
    <div class="stat-icon-wrapper" style="background: rgba(236, 72, 153, 0.1); color: #ec4899;">
      <i class="fas fa-person-dress"></i>
    </div>
    <div class="stat-value-display">{{ $anak->where('jenis_kelamin', 'P')->count() }}</div>
    <div class="stat-label-display">Perempuan</div>
  </div>
</div>

<div class="filter-bar">
  <div class="row g-3 align-items-center">
    <div class="col-lg-4">
      <div class="search-field">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" id="tableSearch" placeholder="Cari nama atau ibu...">
      </div>
    </div>
    <div class="col-lg-8">
      <form method="GET" class="d-flex gap-2 justify-content-lg-end flex-wrap">
        <select name="jenis_kelamin" class="filter-dropdown">
          <option value="">Semua Jenis Kelamin</option>
          <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
          <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        <select name="status" class="filter-dropdown">
          <option value="">Semua Status</option>
          <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
          <option value="meninggal" {{ request('status') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
        </select>
        <button type="submit" class="btn-filter-action">
          <i class="fas fa-filter"></i> Filter
        </button>
        @if(request()->hasAny(['jenis_kelamin', 'status', 'search']))
        <a href="{{ route('admin.anak.index') }}" class="btn btn-outline-secondary" style="border-radius: 10px; padding: 12px 14px;">
          <i class="fas fa-xmark"></i>
        </a>
        @endif
      </form>
    </div>
  </div>
</div>

<div class="table-card">
  @if($anak->count() > 0)
  <div class="table-heading-bar">
    <h5><i class="fas fa-table-list me-2"></i>Daftar Data Anak</h5>
    <span class="table-count-badge">{{ $anak->total() }} Data</span>
  </div>
  <div style="padding: 0;">
    <table id="anakTable" class="data-table-custom" style="width: 100%">
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
              <div class="profile-avatar avatar-{{ $item->jenis_kelamin == 'L' ? 'boy' : 'girl' }}">
                {{ strtoupper(substr($item->nama, 0, 1)) }}
              </div>
              <div class="child-info">
                <strong>{{ $item->nama }}</strong>
                <small>{{ $item->ibu->name ?? '-' }}</small>
              </div>
            </div>
          </td>
          <td>
            <span class="gender-tag tag-{{ $item->jenis_kelamin == 'L' ? 'boy' : 'girl' }}">
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
                $badgeClass = 'nutrition-none';
                $badgeIcon = 'fas fa-minus';
                $badgeText = '-';
                
                if($status == 'normal') {
                  $badgeClass = 'nutrition-normal';
                  $badgeIcon = 'fas fa-check';
                  $badgeText = 'Normal';
                } elseif($status == 'gizi_buruk' || $status == 'wasting') {
                  $badgeClass = 'nutrition-bad';
                  $badgeIcon = 'fas fa-triangle-exclamation';
                  $badgeText = 'Gizi Buruk';
                } elseif($status == 'stunting') {
                  $badgeClass = 'nutrition-stunting';
                  $badgeIcon = 'fas fa-arrow-down';
                  $badgeText = 'Stunting';
                } elseif($status == 'underweight') {
                  $badgeClass = 'nutrition-underweight';
                  $badgeIcon = 'fas fa-minus';
                  $badgeText = 'Underweight';
                } elseif($status == 'overweight') {
                  $badgeClass = 'nutrition-overweight';
                  $badgeIcon = 'fas fa-arrow-up';
                  $badgeText = 'Overweight';
                }
              @endphp
              <span class="nutrition-badge {{ $badgeClass }}">
                <i class="{{ $badgeIcon }}"></i>{{ $badgeText }}
              </span>
            @else
              <span class="nutrition-badge nutrition-none">
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
            <div class="action-group">
              <a href="{{ route('admin.anak.show', $item->id) }}" class="btn-icon-action btn-view-action" title="Detail">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{ route('admin.anak.edit', $item->id) }}" class="btn-icon-action btn-edit-action" title="Edit">
                <i class="fas fa-pen-to-square"></i>
              </a>
              <form action="{{ route('admin.anak.destroy', $item->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-icon-action btn-delete-action btn-delete" data-title="Hapus Data Anak" data-text="Apakah Anda yakin ingin menghapus {{ $item->nama }}?" title="Hapus">
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
  <div class="no-data-state">
    <div class="no-data-illustration">
      <i class="fas fa-children"></i>
    </div>
    <h4 style="color: var(--gray-600); margin-bottom: 8px; font-weight: 600;">Belum Ada Data Anak</h4>
    <p style="color: var(--gray-400); margin-bottom: 24px;">Silakan tambah data anak terlebih dahulu untuk memulai</p>
    <a href="{{ route('admin.anak.create') }}" class="btn-add-new">
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
