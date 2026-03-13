@extends('admin.layout.master')

@section('title', 'Data Anak')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Data Anak</li>
@endsection

@section('content')
<div class="page-header mb-4">
  <div class="row align-items-center">
    <div class="col-lg-6">
      <h1 class="page-title">Data Anak</h1>
      <p class="page-subtitle">Kelola data anak yang terdaftar di sistem</p>
    </div>
    <div class="col-lg-6 text-lg-end">
      <a href="{{ route('admin.anak.create') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-plus me-2"></i>Tambah Anak
      </a>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm mb-4">
  <div class="card-header bg-white border-0 py-3">
    <div class="row align-items-center g-3">
      <div class="col-lg-4">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIK..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-lg-8">
        <form method="GET" class="d-flex gap-2 justify-content-lg-end">
          <select name="jenis_kelamin" class="form-select">
            <option value="">Semua JK</option>
            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
          <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
            <option value="meninggal" {{ request('status') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
          </select>
          <button type="submit" class="btn btn-secondary">
            <i class="fas fa-filter me-1"></i> Filter
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  @forelse($anak as $index => $item)
  <div class="col-md-6 col-xl-4">
    <div class="anak-card border-0 shadow-sm h-100">
      <div class="anak-card-header bg-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'info' }} bg-opacity-10 p-3">
        <div class="d-flex justify-content-between align-items-start">
          <div class="d-flex align-items-center">
            <div class="avatar-circle bg-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'info' }} text-white me-3" style="width: 50px; height: 50px; font-size: 20px;">
              {{ substr($item->nama, 0, 1) }}
            </div>
            <div>
              <h5 class="mb-0 fw-bold">{{ $item->nama }}</h5>
              <small class="text-muted">{{ $item->ibu->name ?? '-' }}</small>
            </div>
          </div>
          @if($item->status == 'aktif')
          <span class="badge bg-success"><i class="fas fa-check me-1"></i>Aktif</span>
          @elseif($item->status == 'pindah')
          <span class="badge bg-warning"><i class="fas fa-arrow-right me-1"></i>Pindah</span>
          @else
          <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Meninggal</span>
          @endif
        </div>
      </div>
      <div class="card-body p-3">
        <div class="anak-info mb-3">
          <div class="info-row">
            <div class="info-icon bg-light rounded">
              <i class="fas fa-id-card text-muted"></i>
            </div>
            <div class="info-content">
              <small class="text-muted d-block">NIK</small>
              <span class="fw-medium">{{ $item->nik_anak ?? '-' }}</span>
            </div>
          </div>
          <div class="info-row">
            <div class="info-icon bg-light rounded">
              <i class="fas fa-venus-mars text-muted"></i>
            </div>
            <div class="info-content">
              <small class="text-muted d-block">Jenis Kelamin</small>
              <span class="fw-medium">{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
          </div>
          <div class="info-row">
            <div class="info-icon bg-light rounded">
              <i class="fas fa-birthday-cake text-muted"></i>
            </div>
            <div class="info-content">
              <small class="text-muted d-block">Tanggal Lahir</small>
              <span class="fw-medium">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</span>
            </div>
          </div>
          <div class="info-row">
            <div class="info-icon bg-light rounded">
              <i class="fas fa-clock text-muted"></i>
            </div>
            <div class="info-content">
              <small class="text-muted d-block">Usia</small>
              <span class="fw-medium">
                @php
                  $usia = \Carbon\Carbon::parse($item->tanggal_lahir)->diff(now());
                  $usiaText = $usia->y > 0 ? $usia->y . ' tahun ' . $usia->m . ' bulan' : ($usia->m > 0 ? $usia->m . ' bulan' : $usia->d . ' hari');
                @endphp
                {{ $usiaText }}
              </span>
            </div>
          </div>
        </div>
        
        <div class="pemeriksaan-preview mb-3">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted small"><i class="fas fa-stethoscope me-1"></i>Pemeriksaan Terakhir</span>
          </div>
          @if($item->latestPemeriksaan)
          <div class="d-flex gap-2">
            <div class="flex-grow-1 text-center p-2 bg-light rounded">
              <div class="text-muted small">Berat</div>
              <div class="fw-bold text-primary">{{ $item->latestPemeriksaan->berat_badan }} <small class="text-muted">kg</small></div>
            </div>
            <div class="flex-grow-1 text-center p-2 bg-light rounded">
              <div class="text-muted small">Tinggi</div>
              <div class="fw-bold text-success">{{ $item->latestPemeriksaan->tinggi_badan }} <small class="text-muted">cm</small></div>
            </div>
            <div class="flex-grow-1 text-center p-2 bg-light rounded">
              <div class="text-muted small">Status</div>
              <span class="badge bg-{{ 
                  $item->latestPemeriksaan->status_gizi_akhir == 'normal' ? 'success' : 
                  ($item->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $item->latestPemeriksaan->status_gizi_akhir == 'wasting' ? 'danger' : 
                  ($item->latestPemeriksaan->status_gizi_akhir == 'stunting' || $item->latestPemeriksaan->status_gizi_akhir == 'underweight' ? 'warning' : 'primary'))
              }}">
                {{ ucfirst(str_replace('_', ' ', substr($item->latestPemeriksaan->status_gizi_akhir, 0, 6)) }}
              </span>
            </div>
          </div>
          @else
          <div class="text-center p-3 bg-light rounded">
            <i class="fas fa-clipboard-list text-muted fs-4 mb-2 d-block"></i>
            <span class="text-muted">Belum ada pemeriksaan</span>
          </div>
          @endif
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.anak.show', $item->id) }}" class="btn btn-outline-info flex-grow-1">
            <i class="fas fa-eye me-1"></i> Detail
          </a>
          <a href="{{ route('admin.anak.edit', $item->id) }}" class="btn btn-outline-warning">
            <i class="fas fa-edit"></i>
          </a>
          <form action="{{ route('admin.anak.destroy', $item->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-delete" data-title="Hapus Data Anak" data-text="Apakah Anda yakin ingin menghapus {{ $item->nama }}?">
              <i class="fas fa-trash"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div class="col-12">
    <div class="empty-state text-center py-5">
      <div class="empty-icon bg-light rounded-circle mx-auto mb-4">
        <i class="fas fa-child text-muted fs-1"></i>
      </div>
      <h4 class="text-muted mb-2">Tidak Ada Data Anak</h4>
      <p class="text-muted mb-4">Silakan tambah data anak terlebih dahulu untuk memulai</p>
      <a href="{{ route('admin.anak.create') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-plus me-2"></i>Tambah Anak Pertama
      </a>
    </div>
  </div>
  @endforelse
</div>

@if($anak->hasPages())
<div class="d-flex justify-content-center mt-4">
  {{ $anak->links() }}
</div>
@endif

<style>
.search-box {
  position: relative;
}
.search-box i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #6c757d;
}
.search-box input {
  padding-left: 40px;
  border-radius: 10px;
}

.anak-card {
  border-radius: 16px;
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.anak-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.anak-info {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}

.info-row {
  display: flex;
  align-items: center;
  gap: 10px;
}

.info-icon {
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.info-content {
  min-width: 0;
}

.info-content .fw-medium {
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.pemeriksaan-preview {
  padding: 12px;
  background: #f8f9fa;
  border-radius: 12px;
}

.empty-state {
  padding: 60px 20px;
}

.empty-icon {
  width: 120px;
  height: 120px;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
@endsection
