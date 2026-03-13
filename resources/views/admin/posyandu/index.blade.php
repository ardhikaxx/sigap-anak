@extends('admin.layout.master')

@section('title', 'Manajemen Posyandu')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Posyandu</li>
@endsection

@section('content')
<div class="page-header">
  <div>
    <h1 class="page-title">Manajemen Posyandu</h1>
    <p class="page-subtitle">Kelola jadwal dan kehadiran posyandu</p>
  </div>
  <a href="{{ route('admin.posyandu.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Buat Jadwal
  </a>
</div>

<div class="card">
  <div class="card-header bg-white border-bottom py-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <h5 class="mb-0">
        <i class="fas fa-calendar-check text-primary me-2"></i>Daftar Jadwal Posyandu
        <span class="badge bg-secondary ms-2">{{ $jadwal->total() }}</span>
      </h5>
      <form method="GET" class="d-flex gap-2">
        <input type="date" name="tanggal" class="form-control form-control-sm" value="{{ request('tanggal') }}" style="width: 140px;">
        <select name="bulan" class="form-select form-select-sm" style="width: 120px;">
          <option value="">Semua Bulan</option>
          @for($i = 1; $i <= 12; $i++)
          <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
          @endfor
        </select>
        <select name="tahun" class="form-select form-select-sm" style="width: 100px;">
          <option value="">Semua</option>
          @for($i = now()->year; $i >= now()->year - 5; $i--)
          <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
          @endfor
        </select>
        <button type="submit" class="btn btn-sm btn-secondary">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4" style="width: 50px;">No</th>
            <th>Tanggal</th>
            <th>Posyandu</th>
            <th>Jam</th>
            <th>Tema</th>
            <th>Status</th>
            <th class="text-center" style="width: 150px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($jadwal as $index => $item)
          <tr>
            <td class="ps-4 text-muted">{{ $jadwal->firstItem() + $index }}</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded p-2 text-center me-3" style="min-width: 50px;">
                  <div class="text-primary fw-bold">{{ \Carbon\Carbon::parse($item->tanggal)->format('d') }}</div>
                  <div class="text-muted small">{{ \Carbon\Carbon::parse($item->tanggal)->format('M') }}</div>
                </div>
                <div>
                  <div class="fw-semibold">{{ \Carbon\Carbon::parse($item->tanggal)->format('l') }}</div>
                  <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal)->format('Y') }}</small>
                </div>
              </div>
            </td>
            <td>
              <i class="fas fa-hospital text-muted me-2"></i>
              {{ $item->faskes->nama ?? '-' }}
            </td>
            <td>
              <i class="fas fa-clock text-muted me-1"></i>
              {{ $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-' }}
            </td>
            <td>{{ $item->tema ?? '-' }}</td>
            <td>
              @switch($item->status)
                @case('terjadwal')
                <span class="badge bg-primary"><i class="fas fa-clock me-1"></i>Terjadwal</span>
                @break
                @case('sedang_berlangsung')
                <span class="badge bg-success"><i class="fas fa-play me-1"></i>Berlangsung</span>
                @break
                @case('selesai')
                <span class="badge bg-secondary"><i class="fas fa-check me-1"></i>Selesai</span>
                @break
                @case('dibatalkan')
                <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Dibatalkan</span>
                @break
              @endswitch
            </td>
            <td>
              <div class="d-flex gap-1 justify-content-center">
                <a href="{{ route('admin.posyandu.show', $item->id) }}" class="btn btn-sm btn-outline-info" title="Lihat">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.posyandu.absensi', $item->id) }}" class="btn btn-sm btn-outline-success" title="Absensi">
                  <i class="fas fa-clipboard-check"></i>
                </a>
                <form action="{{ route('admin.posyandu.destroy', $item->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger btn-delete" title="Hapus">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
              <i class="fas fa-calendar-times fa-4x text-muted mb-3 d-block"></i>
              <h5 class="text-muted">Tidak ada jadwal posyandu</h5>
              <p class="text-muted">Silakan buat jadwal posyandu terlebih dahulu</p>
              <a href="{{ route('admin.posyandu.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Buat Jadwal
              </a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($jadwal->hasPages())
  <div class="card-footer bg-white py-3">
    {{ $jadwal->links() }}
  </div>
  @endif
</div>
@endsection
