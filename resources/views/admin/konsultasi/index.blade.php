@extends('admin.layout.master')

@section('title', 'Konsultasi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Konsultasi</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css">
<style>
  :root {
    --primary: #0ea5e9; --primary-dark: #0284c7; --dark: #0f172a;
    --gray-600: #475569; --gray-500: #64748b; --gray-400: #94a3b8;
    --gray-100: #f1f5f9; --white: #ffffff;
    --success: #22c55e; --warning: #f59e0b; --danger: #ef4444;
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

  .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }
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
    display: flex; align-items: center; justify-content: center; font-size: 22px;
    margin-bottom: 16px; background: var(--stat-bg); color: var(--stat-color);
  }
  .stat-number { font-size: 2.5rem; font-weight: 800; color: var(--dark); line-height: 1; margin-bottom: 4px; }
  .stat-label { font-size: 0.9rem; color: var(--gray-500); font-weight: 500; }

  .content-card {
    background: var(--white); border-radius: 22px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px;
  }
  .card-header-section { padding: 22px 28px; border-bottom: 1px solid #f1f5f9; }
  .card-title-section { font-size: 1.1rem; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 12px; margin: 0; }
  .card-title-section i { color: var(--primary); }

  .table-main { width: 100%; border-collapse: collapse; }
  .table-main thead th {
    background: #f8fafc; padding: 14px 16px; font-weight: 600; font-size: 0.7rem;
    text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray-500); border: none; border-bottom: 2px solid #e2e8f0;
  }
  .table-main tbody tr { transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9; }
  .table-main tbody tr:hover { background: var(--gray-100); }
  .table-main tbody td { padding: 16px; vertical-align: middle; border: none; }

  .topic-cell { display: flex; align-items: center; gap: 12px; }
  .topic-icon {
    width: 42px; height: 42px; border-radius: 12px; display: flex;
    align-items: center; justify-content: center; font-size: 16px; color: white;
  }
  .topic-info strong { display: block; color: var(--dark); font-weight: 600; font-size: 0.9rem; }
  .topic-info small { color: var(--gray-400); font-size: 0.75rem; }

  .badge-status { padding: 7px 13px; border-radius: 10px; font-weight: 600; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 6px; }
  .badge-menang { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .badge-dibalas { background: rgba(6, 182, 212, 0.1); color: #0891b2; }
  .badge-selesai { background: rgba(34, 197, 94, 0.1); color: #16a34a; }

  .rating-stars { color: #f59e0b; font-size: 0.85rem; }

  .action-group { display: flex; gap: 6px; justify-content: center; }
  .btn-icon { width: 36px; height: 36px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; border: none; transition: all 0.2s ease; cursor: pointer; }
  .btn-icon:hover { transform: scale(1.1); }
  .btn-lihat { background: rgba(14, 165, 233, 0.1); color: var(--primary); }
  .btn-lihat:hover { background: var(--primary); color: var(--white); }

  .empty-state { text-align: center; padding: 80px 24px; }
  .empty-visual { width: 150px; height: 150px; background: var(--gray-100); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; border: 3px solid #e2e8f0; }
  .empty-visual i { font-size: 60px; color: var(--gray-400); }
  .empty-heading { font-size: 1.3rem; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
  .empty-desc { color: var(--gray-500); margin-bottom: 24px; }

  @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 768px) {
    .hero-section { padding: 28px; text-align: center; }
    .hero-title { font-size: 1.75rem; }
    .stats-grid { grid-template-columns: 1fr; }
    .stat-number { font-size: 2rem; }
  }
</style>
@endsection

@section('content')
<div class="hero-section">
  <h1 class="hero-title"><i class="fas fa-comments me-3"></i>Konsultasi</h1>
  <p class="hero-subtitle">Kelola konsultasi dengan orang tua dengan lebih mudah</p>
</div>

<div class="stats-grid">
  <div class="stat-card" style="--stat-color: #0ea5e9; --stat-bg: rgba(14, 165, 233, 0.1);">
    <div class="stat-icon"><i class="fas fa-comments"></i></div>
    <div class="stat-number">{{ $konsultasis->total() }}</div>
    <div class="stat-label">Total Konsultasi</div>
  </div>
  <div class="stat-card" style="--stat-color: #f59e0b; --stat-bg: rgba(245, 158, 11, 0.1);">
    <div class="stat-icon"><i class="fas fa-clock"></i></div>
    <div class="stat-number">{{ $konsultasis->where('status', 'menunggu')->count() }}</div>
    <div class="stat-label">Menunggu</div>
  </div>
  <div class="stat-card" style="--stat-color: #06b6d4; --stat-bg: rgba(6, 182, 212, 0.1);">
    <div class="stat-icon"><i class="fas fa-reply"></i></div>
    <div class="stat-number">{{ $konsultasis->where('status', 'dibalas')->count() }}</div>
    <div class="stat-label">Dibalas</div>
  </div>
  <div class="stat-card" style="--stat-color: #22c55e; --stat-bg: rgba(34, 197, 94, 0.1);">
    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
    <div class="stat-number">{{ $konsultasis->where('status', 'selesai')->count() }}</div>
    <div class="stat-label">Selesai</div>
  </div>
</div>

<div class="content-card">
  <div class="card-header-section">
    <h5 class="card-title-section"><i class="fas fa-list"></i> Daftar Konsultasi</h5>
  </div>
  <div style="padding: 0; overflow-x: auto;">
    @if($konsultasis->count() > 0)
    <table class="table-main">
      <thead>
        <tr>
          <th>Topik</th>
          <th>Anak</th>
          <th>Orang Tua</th>
          <th>Nakes</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th>Rating</th>
          <th style="text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($konsultasis as $konsultasi)
        <tr>
          <td>
            <div class="topic-cell">
              <div class="topic-icon" style="background: @switch($konsultasi->status) @case('menunggu') #f59e0b @case('dibalas') #06b6d4 @case('selesai') #22c55e @default #64748b @endswitch;">
                <i class="fas fa-comment"></i>
              </div>
              <div class="topic-info">
                <strong>{{ $konsultasi->topik }}</strong>
                <small>{{ Str::limit($konsultasi->pertanyaan, 40) }}</small>
              </div>
            </div>
          </td>
          <td><strong>{{ $konsultasi->anak->nama ?? '-' }}</strong></td>
          <td>{{ $konsultasi->user->name ?? '-' }}</td>
          <td>{{ $konsultasi->nakes->name ?? '-' }}</td>
          <td>{{ \Carbon\Carbon::parse($konsultasi->tanggal)->format('d M Y') }}</td>
          <td>
            @switch($konsultasi->status)
              @case('menunggu')
              <span class="badge-status badge-menang"><i class="fas fa-clock"></i>Menunggu</span>
              @break
              @case('dibalas')
              <span class="badge-status badge-dibalas"><i class="fas fa-reply"></i>Dibalas</span>
              @break
              @case('selesai')
              <span class="badge-status badge-selesai"><i class="fas fa-check"></i>Selesai</span>
              @break
            @endswitch
          </td>
          <td>
            @if($konsultasi->rating)
            <span class="rating-stars">
              @for($i = 1; $i <= 5; $i++)
              <i class="fas fa-star{{ $i <= $konsultasi->rating ? '' : '-o' }}"></i>
              @endfor
            </span>
            @else
            <span style="color: var(--gray-400);">-</span>
            @endif
          </td>
          <td>
            <div class="action-group">
              <a href="{{ route('admin.konsultasi.show', $konsultasi->id) }}" class="btn-icon btn-lihat" title="Lihat">
                <i class="fas fa-eye"></i>
              </a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <div class="empty-state">
      <div class="empty-visual"><i class="fas fa-comments"></i></div>
      <h4 class="empty-heading">Belum Ada Konsultasi</h4>
      <p class="empty-desc">Konsultasi akan muncul di sini</p>
    </div>
    @endif
  </div>
</div>
@endsection
