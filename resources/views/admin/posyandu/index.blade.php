@extends('admin.layout.master')

@section('title', 'Manajemen Posyandu')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Posyandu</li>
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
    --gray-600: #475569;
    --gray-500: #64748b;
    --gray-400: #94a3b8;
    --gray-100: #f1f5f9;
    --white: #ffffff;
    --success: #22c55e;
    --warning: #f59e0b;
    --danger: #ef4444;
  }

  * { font-family: 'Plus Jakarta Sans', -apple-system, sans-serif; }

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
    content: ''; position: absolute; top: -50%; right: -10%; width: 320px; height: 320px;
    background: rgba(255,255,255,0.08); border-radius: 50%;
  }

  .hero-section::after {
    content: ''; position: absolute; bottom: -40%; left: -5%; width: 280px; height: 280px;
    background: rgba(255,255,255,0.05); border-radius: 50%;
  }

  .hero-content { position: relative; z-index: 2; }

  .hero-title { font-size: 2.25rem; font-weight: 800; margin-bottom: 6px; }
  .hero-subtitle { font-size: 1.05rem; opacity: 0.9; }

  .btn-add-hero {
    background: var(--white); color: var(--primary);
    border: none; border-radius: 14px; padding: 14px 26px;
    font-weight: 700; font-size: 0.95rem; transition: all 0.3s ease;
    display: inline-flex; align-items: center; gap: 10px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
  }

  .btn-add-hero:hover {
    transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    color: var(--primary-dark); background: var(--white);
  }

  .stats-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px;
  }

  .stat-card {
    background: var(--white); border-radius: 20px; padding: 26px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;
    transition: all 0.35s ease; position: relative; overflow: hidden;
  }

  .stat-card::before {
    content: ''; position: absolute; top: 0; left: 0; width: 5px; height: 100%;
    background: var(--stat-color);
  }

  .stat-card:hover { transform: translateY(-6px); box-shadow: 0 16px 45px rgba(0,0,0,0.12); }

  .stat-icon {
    width: 56px; height: 56px; border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; margin-bottom: 16px;
    background: var(--stat-bg); color: var(--stat-color);
  }

  .stat-number { font-size: 2.5rem; font-weight: 800; color: var(--dark); line-height: 1; margin-bottom: 4px; }
  .stat-label { font-size: 0.9rem; color: var(--gray-500); font-weight: 500; }

  .content-card {
    background: var(--white); border-radius: 22px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;
    overflow: hidden; margin-bottom: 24px;
  }

  .card-header-section {
    padding: 22px 28px; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
  }

  .card-title-section {
    font-size: 1.1rem; font-weight: 700; color: var(--dark);
    display: flex; align-items: center; gap: 12px; margin: 0;
  }

  .card-title-section i { color: var(--primary); }

  .filter-row {
    display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin-bottom: 20px;
  }

  .filter-dropdown {
    padding: 14px 18px; border: 2px solid #e2e8f0; border-radius: 14px;
    font-size: 0.95rem; transition: all 0.25s ease; background: var(--gray-100);
    cursor: pointer; min-width: 150px;
  }

  .filter-dropdown:focus {
    border-color: var(--primary); outline: none;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
  }

  .btn-filter-action {
    background: var(--gray-100); border: 2px solid #e2e8f0; border-radius: 14px;
    padding: 14px 22px; font-weight: 600; color: var(--gray-600);
    transition: all 0.25s ease; display: inline-flex; align-items: center; gap: 8px;
  }

  .btn-filter-action:hover { background: var(--primary); border-color: var(--primary); color: var(--white); }

  .table-main { width: 100%; border-collapse: collapse; }

  .table-main thead th {
    background: #f8fafc; padding: 14px 16px; font-weight: 600;
    font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;
    color: var(--gray-500); border: none; border-bottom: 2px solid #e2e8f0;
  }

  .table-main tbody tr {
    transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9;
  }

  .table-main tbody tr:hover { background: var(--gray-100); }
  .table-main tbody td { padding: 16px; vertical-align: middle; border: none; }

  .date-cell { display: flex; align-items: center; gap: 14px; }

  .date-box {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    color: white; flex-shrink: 0;
  }

  .date-day { font-size: 1.35rem; font-weight: 800; line-height: 1; }
  .date-month { font-size: 0.7rem; text-transform: uppercase; font-weight: 600; }

  .date-info strong { display: block; color: var(--dark); font-weight: 600; font-size: 0.9rem; }
  .date-info small { color: var(--gray-400); font-size: 0.8rem; }

  .badge-status {
    padding: 7px 13px; border-radius: 10px; font-weight: 600; font-size: 0.75rem;
    display: inline-flex; align-items: center; gap: 6px;
  }

  .badge-terjadwal { background: rgba(14, 165, 233, 0.1); color: var(--primary-dark); }
  .badge-berlangsung { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
  .badge-selesai { background: var(--gray-100); color: var(--gray-500); }
  .badge-batal { background: rgba(239, 68, 68, 0.1); color: #dc2626; }

  .faskes-pill {
    background: #f8fafc; border: 1px solid #e2e8f0; padding: 7px 14px;
    border-radius: 10px; font-size: 0.85rem; font-weight: 500; color: var(--gray-600);
  }

  .action-group { display: flex; gap: 6px; justify-content: center; }

  .btn-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: inline-flex; align-items: center; justify-content: center;
    border: none; transition: all 0.2s ease; cursor: pointer;
  }

  .btn-icon:hover { transform: scale(1.1); }

  .btn-lihat { background: rgba(14, 165, 233, 0.1); color: var(--primary); }
  .btn-lihat:hover { background: var(--primary); color: var(--white); }

  .btn-absensi { background: rgba(34, 197, 94, 0.1); color: var(--success); }
  .btn-absensi:hover { background: var(--success); color: var(--white); }

  .btn-hapus { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
  .btn-hapus:hover { background: var(--danger); color: var(--white); }

  .empty-state { text-align: center; padding: 80px 24px; }

  .empty-visual {
    width: 150px; height: 150px; background: var(--gray-100); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px; border: 3px solid #e2e8f0;
  }

  .empty-visual i { font-size: 60px; color: var(--gray-400); }

  .empty-heading { font-size: 1.3rem; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
  .empty-desc { color: var(--gray-500); margin-bottom: 24px; }

  .export-btn-new {
    background: var(--primary) !important; border: none !important; border-radius: 12px !important;
    color: var(--white) !important; padding: 12px 20px !important; font-weight: 600 !important;
    box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35) !important; transition: all 0.3s ease !important;
  }

  .export-btn-new:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(14, 165, 233, 0.45) !important; }

  @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 768px) {
    .hero-section { padding: 28px; text-align: center; }
    .hero-title { font-size: 1.75rem; }
    .stats-grid { grid-template-columns: 1fr; }
    .stat-number { font-size: 2rem; }
    .card-header-section { flex-direction: column; gap: 14px; align-items: flex-start; }
    .filter-row { flex-direction: column; }
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
          <i class="fas fa-calendar-check me-3"></i>Posyandu
        </h1>
        <p class="hero-subtitle">Kelola jadwal dan kehadiran posyandu dengan lebih mudah</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <a href="{{ route('admin.posyandu.create') }}" class="btn-add-hero">
          <i class="fas fa-plus"></i> Buat Jadwal
        </a>
      </div>
    </div>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card" style="--stat-color: #0ea5e9; --stat-bg: rgba(14, 165, 233, 0.1);">
    <div class="stat-icon"><i class="fas fa-calendar"></i></div>
    <div class="stat-number">{{ $jadwal->total() }}</div>
    <div class="stat-label">Total Jadwal</div>
  </div>
  <div class="stat-card" style="--stat-color: #22c55e; --stat-bg: rgba(34, 197, 94, 0.1);">
    <div class="stat-icon"><i class="fas fa-play"></i></div>
    <div class="stat-number">{{ $jadwal->where('status', 'sedang_berlangsung')->count() }}</div>
    <div class="stat-label">Berlangsung</div>
  </div>
  <div class="stat-card" style="--stat-color: #0ea5e9; --stat-bg: rgba(14, 165, 233, 0.1);">
    <div class="stat-icon"><i class="fas fa-clock"></i></div>
    <div class="stat-number">{{ $jadwal->where('status', 'terjadwal')->count() }}</div>
    <div class="stat-label">Terjadwal</div>
  </div>
  <div class="stat-card" style="--stat-color: #64748b; --stat-bg: rgba(100, 116, 139, 0.1);">
    <div class="stat-icon"><i class="fas fa-check"></i></div>
    <div class="stat-number">{{ $jadwal->where('status', 'selesai')->count() }}</div>
    <div class="stat-label">Selesai</div>
  </div>
</div>

<div class="content-card">
  <div class="card-header-section">
    <h5 class="card-title-section">
      <i class="fas fa-list"></i> Daftar Jadwal Posyandu
    </h5>
  </div>
  <div style="padding: 24px;">
    <form method="GET" class="filter-row">
      <input type="date" name="tanggal" class="filter-dropdown" value="{{ request('tanggal') }}" style="min-width: 160px;">
      <select name="bulan" class="filter-dropdown">
        <option value="">Semua Bulan</option>
        @for($i = 1; $i <= 12; $i++)
        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
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
      @if(request()->hasAny(['tanggal', 'bulan', 'tahun']))
      <a href="{{ route('admin.posyandu.index') }}" class="btn-filter-action">
        <i class="fas fa-xmark"></i> Clear
      </a>
      @endif
    </form>

    @if($jadwal->count() > 0)
    <div style="overflow-x: auto;">
      <table class="table-main">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Posyandu</th>
            <th>Jam</th>
            <th>Tema</th>
            <th>Status</th>
            <th style="text-align: center;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($jadwal as $item)
          <tr>
            <td>
              <div class="date-cell">
                <div class="date-box" style="background: @switch($item->status) @case('sedang_berlangsung') #22c55e @case('selesai') #64748b @case('dibatalkan') #ef4444 @default #0ea5e9 @endswitch;">
                  <span class="date-day">{{ \Carbon\Carbon::parse($item->tanggal)->format('d') }}</span>
                  <span class="date-month">{{ \Carbon\Carbon::parse($item->tanggal)->format('M') }}</span>
                </div>
                <div class="date-info">
                  <strong>{{ \Carbon\Carbon::parse($item->tanggal)->format('l') }}</strong>
                  <small>{{ \Carbon\Carbon::parse($item->tanggal)->format('Y') }}</small>
                </div>
              </div>
            </td>
            <td>
              <span class="faskes-pill">
                <i class="fas fa-hospital me-1" style="color: var(--gray-400);"></i>
                {{ $item->faskes->nama ?? '-' }}
              </span>
            </td>
            <td>
              <span style="color: var(--gray-600); font-weight: 500;">
                <i class="fas fa-clock me-1" style="color: var(--gray-400);"></i>
                {{ $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-' }}
              </span>
            </td>
            <td><strong>{{ $item->tema ?? '-' }}</strong></td>
            <td>
              @switch($item->status)
                @case('terjadwal')
                <span class="badge-status badge-terjadwal"><i class="fas fa-clock"></i>Terjadwal</span>
                @break
                @case('sedang_berlangsung')
                <span class="badge-status badge-berlangsung"><i class="fas fa-play"></i>Berlangsung</span>
                @break
                @case('selesai')
                <span class="badge-status badge-selesai"><i class="fas fa-check"></i>Selesai</span>
                @break
                @case('dibatalkan')
                <span class="badge-status badge-batal"><i class="fas fa-times"></i>Dibatalkan</span>
                @break
              @endswitch
            </td>
            <td>
              <div class="action-group">
                <a href="{{ route('admin.posyandu.show', $item->id) }}" class="btn-icon btn-lihat" title="Lihat">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.posyandu.absensi', $item->id) }}" class="btn-icon btn-absensi" title="Absensi">
                  <i class="fas fa-clipboard-check"></i>
                </a>
                <form action="{{ route('admin.posyandu.destroy', $item->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-icon btn-hapus btn-delete" title="Hapus">
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
      <div class="empty-visual"><i class="fas fa-calendar-xmark"></i></div>
      <h4 class="empty-heading">Belum Ada Jadwal Posyandu</h4>
      <p class="empty-desc">Silakan buat jadwal posyandu terlebih dahulu</p>
      <a href="{{ route('admin.posyandu.create') }}" class="btn-add-hero">
        <i class="fas fa-plus"></i> Buat Jadwal
      </a>
    </div>
    @endif
  </div>
</div>
@endsection
