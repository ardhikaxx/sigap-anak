@extends('admin.layout.master')

@section('title', 'Pemeriksaan')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Pemeriksaan</li>
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

  .hero-section {
    background: var(--primary);
    border-radius: 24px;
    padding: 40px 44px;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 28px;
  }

  .hero-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 320px;
    height: 320px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
  }

  .hero-section::after {
    content: '';
    position: absolute;
    bottom: -40%;
    left: -5%;
    width: 280px;
    height: 280px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
  }

  .hero-content {
    position: relative;
    z-index: 2;
  }

  .hero-title {
    font-size: 2.25rem;
    font-weight: 800;
    margin-bottom: 6px;
  }

  .hero-subtitle {
    font-size: 1.05rem;
    opacity: 0.9;
  }

  .btn-add-hero {
    background: var(--white);
    color: var(--primary);
    border: none;
    border-radius: 14px;
    padding: 14px 26px;
    font-weight: 700;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
  }

  .btn-add-hero:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
    border-radius: 20px;
    padding: 26px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    transition: all 0.35s ease;
    position: relative;
    overflow: hidden;
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: var(--stat-color);
  }

  .stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 45px rgba(0,0,0,0.12);
  }

  .stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 16px;
    background: var(--stat-bg);
    color: var(--stat-color);
  }

  .stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--dark);
    line-height: 1;
    margin-bottom: 4px;
  }

  .stat-label {
    font-size: 0.9rem;
    color: var(--gray-500);
    font-weight: 500;
  }

  .content-card {
    background: var(--white);
    border-radius: 22px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    margin-bottom: 24px;
  }

  .card-header-section {
    padding: 22px 28px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .card-title-section {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
  }

  .card-title-section i {
    color: var(--primary);
  }

  .card-body-section {
    padding: 24px;
  }

  .filter-row {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 20px;
  }

  .search-field {
    flex: 1;
    min-width: 280px;
    position: relative;
  }

  .search-field i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
  }

  .search-field input {
    width: 100%;
    padding: 14px 18px 14px 50px;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    font-size: 0.95rem;
    transition: all 0.25s ease;
    background: var(--gray-100);
  }

  .search-field input:focus {
    border-color: var(--primary);
    background: var(--white);
    outline: none;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
  }

  .filter-dropdown {
    padding: 14px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    font-size: 0.95rem;
    transition: all 0.25s ease;
    background: var(--gray-100);
    cursor: pointer;
    min-width: 150px;
  }

  .filter-dropdown:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
  }

  .btn-filter-action {
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

  .btn-filter-action:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--white);
  }

  .table-section {
    overflow-x: auto;
  }

  .table-main {
    width: 100%;
    border-collapse: collapse;
  }

  .table-main thead th {
    background: #f8fafc;
    padding: 14px 16px;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gray-500);
    border: none;
    border-bottom: 2px solid #e2e8f0;
  }

  .table-main tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f1f5f9;
  }

  .table-main tbody tr:hover {
    background: var(--gray-100);
  }

  .table-main tbody td {
    padding: 16px;
    vertical-align: middle;
    border: none;
  }

  .profile-section {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .profile-avatar {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
    color: var(--white);
  }

  .avatar-boy { background: var(--primary); }
  .avatar-girl { background: #ec4899; }

  .profile-details strong {
    display: block;
    color: var(--dark);
    font-weight: 600;
    font-size: 0.9rem;
  }

  .profile-details small {
    color: var(--gray-400);
    font-size: 0.75rem;
  }

  .badge-gizi {
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
  .gizi-under { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .gizi-over { background: rgba(6, 182, 212, 0.1); color: #0891b2; }
  .gizi-kosong { background: var(--gray-100); color: var(--gray-500); }

  .measurement-pill {
    background: var(--gray-100);
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--gray-600);
  }

  .action-group {
    display: flex;
    gap: 6px;
    justify-content: flex-end;
  }

  .btn-icon {
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

  .btn-icon:hover { transform: scale(1.1); }

  .btn-lihat { background: rgba(14, 165, 233, 0.1); color: var(--primary); }
  .btn-lihat:hover { background: var(--primary); color: var(--white); }

  .empty-state {
    text-align: center;
    padding: 80px 24px;
  }

  .empty-visual {
    width: 150px;
    height: 150px;
    background: var(--gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    border: 3px solid #e2e8f0;
  }

  .empty-visual i {
    font-size: 60px;
    color: var(--gray-400);
  }

  .empty-heading {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 8px;
  }

  .empty-desc {
    color: var(--gray-500);
    margin-bottom: 24px;
  }

  .export-btn-new {
    background: var(--primary) !important;
    border: none !important;
    border-radius: 12px !important;
    color: var(--white) !important;
    padding: 12px 20px !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35) !important;
    transition: all 0.3s ease !important;
  }

  .export-btn-new:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(14, 165, 233, 0.45) !important;
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

  .dt-info { color: var(--gray-500) !important; font-weight: 500 !important; }

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
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
  }

  @media (max-width: 768px) {
    .hero-section { padding: 28px; text-align: center; }
    .hero-title { font-size: 1.75rem; }
    .stats-grid { grid-template-columns: 1fr; }
    .stat-number { font-size: 2rem; }
    .card-header-section { flex-direction: column; gap: 14px; align-items: flex-start; }
    .filter-row { flex-direction: column; }
    .search-field { width: 100%; }
    .filter-dropdown { width: 100%; }
  }
</style>
@endsection

@section('content')
<div class="hero-section">
  <div class="hero-content">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="hero-title">
          <i class="fas fa-stethoscope me-3"></i>Pemeriksaan
        </h1>
        <p class="hero-subtitle">Kelola data pemeriksaan tumbuh kembang anak dengan lebih mudah</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <a href="{{ route('admin.pemeriksaan.create') }}" class="btn-add-hero">
          <i class="fas fa-plus"></i>
          Tambah Pemeriksaan
        </a>
      </div>
    </div>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card" style="--stat-color: #0ea5e9; --stat-bg: rgba(14, 165, 233, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-clipboard-list"></i>
    </div>
    <div class="stat-number">{{ $pemeriksaans->total() }}</div>
    <div class="stat-label">Total Pemeriksaan</div>
  </div>
  <div class="stat-card" style="--stat-color: #22c55e; --stat-bg: rgba(34, 197, 94, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-calendar-check"></i>
    </div>
    <div class="stat-number">{{ $pemeriksaans->where('tanggal_periksa', '>=', now()->startOfDay())->count() }}</div>
    <div class="stat-label">Hari Ini</div>
  </div>
  <div class="stat-card" style="--stat-color: #22c55e; --stat-bg: rgba(34, 197, 94, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-check-circle"></i>
    </div>
    <div class="stat-number">{{ $pemeriksaans->where('status_gizi_akhir', 'normal')->count() }}</div>
    <div class="stat-label">Gizi Normal</div>
  </div>
  <div class="stat-card" style="--stat-color: #ef4444; --stat-bg: rgba(239, 68, 68, 0.1);">
    <div class="stat-icon">
      <i class="fas fa-triangle-exclamation"></i>
    </div>
    <div class="stat-number">{{ $pemeriksaans->whereIn('status_gizi_akhir', ['gizi_buruk', 'wasting'])->count() }}</div>
    <div class="stat-label">Gizi Buruk</div>
  </div>
</div>

<div class="content-card">
  <div class="card-header-section">
    <h5 class="card-title-section">
      <i class="fas fa-list"></i>
      Daftar Pemeriksaan
    </h5>
    <div class="d-flex gap-2">
      @if(request()->hasAny(['bulan', 'tahun']))
      <a href="{{ route('admin.pemeriksaan.index') }}" class="btn-filter-action">
        <i class="fas fa-xmark"></i> Clear
      </a>
      @endif
    </div>
  </div>
  <div class="card-body-section">
    <div class="filter-row">
      <div class="search-field">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" id="tableSearch" placeholder="Cari nama anak...">
      </div>
      <form method="GET" class="d-flex gap-2 flex-wrap">
        <select name="bulan" class="filter-dropdown">
          <option value="">Semua Bulan</option>
          @for($i = 1; $i <= 12; $i++)
          <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->format('F') }}</option>
          @endfor
        </select>
        <select name="tahun" class="filter-dropdown">
          <option value="">Semua Tahun</option>
          @for($i = now()->year; $i >= now()->year - 5; $i--)
          <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
          @endfor
        </select>
        <button type="submit" class="btn-filter-action">
          <i class="fas fa-filter"></i> Filter
        </button>
      </form>
    </div>

    @if($pemeriksaans->count() > 0)
    <div class="table-section">
      <table id="pemeriksaanTable" class="table-main" style="width: 100%">
        <thead>
          <tr>
            <th>Anak</th>
            <th>Tanggal</th>
            <th>Umur</th>
            <th>Berat</th>
            <th>Tinggi</th>
            <th>LP</th>
            <th>LILA</th>
            <th>Suhu</th>
            <th>Status Gizi</th>
            <th>Petugas</th>
            <th style="text-align: right;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pemeriksaans as $p)
          <tr>
            <td>
              <div class="profile-section">
                <div class="profile-avatar avatar-{{ $p->anak->jenis_kelamin == 'L' ? 'boy' : 'girl' }}">
                  {{ strtoupper(substr($p->anak->nama ?? 'A', 0, 1)) }}
                </div>
                <div class="profile-details">
                  <strong>{{ $p->anak->nama ?? '-' }}</strong>
                  <small>{{ \Carbon\Carbon::parse($p->tanggal_periksa)->format('d M Y') }}</small>
                </div>
              </div>
            </td>
            <td>
              <span style="color: var(--gray-600); font-weight: 500;">{{ \Carbon\Carbon::parse($p->tanggal_periksa)->format('d M Y') }}</span>
            </td>
            <td>
              <span style="font-weight: 600; color: var(--primary);">{{ $p->umur_bulan }} bln</span>
            </td>
            <td>
              <span class="measurement-pill"><i class="fas fa-weight me-1"></i>{{ $p->berat_badan ?? '-' }} kg</span>
            </td>
            <td>
              <span class="measurement-pill"><i class="fas fa-ruler me-1"></i>{{ $p->tinggi_badan ?? '-' }} cm</span>
            </td>
            <td>
              <span class="measurement-pill">{{ $p->lingkar_kepala ?? '-' }} cm</span>
            </td>
            <td>
              <span class="measurement-pill">{{ $p->lingkar_lengan ?? '-' }} cm</span>
            </td>
            <td>
              <span class="measurement-pill">{{ $p->suhu_tubuh ? $p->suhu_tubuh . '°C' : '-' }}</span>
            </td>
            <td>
              @if($p->status_gizi_akhir)
                @php
                  $status = $p->status_gizi_akhir;
                  $badgeClass = 'gizi-kosong';
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
                    $badgeClass = 'gizi-under';
                    $badgeIcon = 'fas fa-minus';
                    $badgeText = 'Underweight';
                  } elseif($status == 'overweight') {
                    $badgeClass = 'gizi-over';
                    $badgeIcon = 'fas fa-arrow-up';
                    $badgeText = 'Overweight';
                  }
                @endphp
                <span class="badge-gizi {{ $badgeClass }}">
                  <i class="{{ $badgeIcon }}"></i>{{ $badgeText }}
                </span>
              @else
                <span class="badge-gizi gizi-kosong">
                  <i class="fas fa-minus"></i>Belum
                </span>
              @endif
            </td>
            <td>
              <span style="color: var(--gray-600); font-weight: 500;">{{ $p->nakes->name ?? '-' }}</span>
            </td>
            <td>
              <div class="action-group">
                <a href="{{ route('admin.pemeriksaan.show', $p->id) }}" class="btn-icon btn-lihat" title="Detail">
                  <i class="fas fa-eye"></i>
                </a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @else
    <div class="empty-state">
      <div class="empty-visual">
        <i class="fas fa-clipboard-list"></i>
      </div>
      <h4 class="empty-heading">Belum Ada Pemeriksaan</h4>
      <p class="empty-desc">Silakan tambah pemeriksaan terlebih dahulu</p>
      <a href="{{ route('admin.pemeriksaan.create') }}" class="btn-add-hero">
        <i class="fas fa-plus"></i> Tambah Pemeriksaan
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
  var table = $('#pemeriksaanTable').DataTable({
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
        className: 'export-btn-new',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] }
      },
      {
        extend: 'pdfHtml5',
        text: '<i class="fas fa-file-pdf me-1"></i> PDF',
        className: 'export-btn-new',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] }
      },
      {
        extend: 'print',
        text: '<i class="fas fa-print me-1"></i> Print',
        className: 'export-btn-new',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] }
      }
    ],
    columnDefs: [
      { responsivePriority: 1, targets: 0 },
      { responsivePriority: 2, targets: 8 },
      { responsivePriority: 3, targets: 10 }
    ]
  });

  $('#tableSearch').on('keyup', function() {
    table.search($(this).val()).draw();
  });
});
</script>
@endsection
