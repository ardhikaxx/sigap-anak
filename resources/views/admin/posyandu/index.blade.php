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
  <div class="card-body">
    <form method="GET" class="mb-4">
      <div class="row g-3">
        <div class="col-md-3">
          <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-2">
          <select name="bulan" class="form-select">
            <option value="">Semua Bulan</option>
            @for($i = 1; $i <= 12; $i++)
            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
            @endfor
          </select>
        </div>
        <div class="col-md-2">
          <select name="tahun" class="form-select">
            <option value="">Semua Tahun</option>
            @for($i = now()->year; $i >= now()->year - 5; $i--)
            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-secondary w-100">
            <i class="fas fa-search me-2"></i>Cari
          </button>
        </div>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Posyandu</th>
            <th>Jam</th>
            <th>Tema</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($jadwal as $index => $item)
          <tr>
            <td>{{ $jadwal->firstItem() + $index }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
            <td>{{ $item->faskes->nama ?? '-' }}</td>
            <td>{{ $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-' }}</td>
            <td>{{ $item->tema ?? '-' }}</td>
            <td>
              @switch($item->status)
                @case('terjadwal')
                <span class="badge bg-primary">Terjadwal</span>
                @break
                @case('sedang_berlangsung')
                <span class="badge bg-success">Berlangsung</span>
                @break
                @case('selesai')
                <span class="badge bg-secondary">Selesai</span>
                @break
                @case('dibatalkan')
                <span class="badge bg-danger">Dibatalkan</span>
                @break
              @endswitch
            </td>
            <td>
              <div class="action-buttons">
                <a href="{{ route('admin.posyandu.show', $item->id) }}" class="btn btn-sm btn-info" title="Lihat">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.posyandu.absensi', $item->id) }}" class="btn btn-sm btn-success" title="Absensi">
                  <i class="fas fa-clipboard-check"></i>
                </a>
                <form action="{{ route('admin.posyandu.destroy', $item->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-4">
              <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
              <p class="text-muted">Tidak ada jadwal posyandu</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $jadwal->links() }}
    </div>
  </div>
</div>
@endsection
