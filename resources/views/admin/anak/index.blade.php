@extends('admin.layout.master')

@section('title', 'Data Anak')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Data Anak</li>
@endsection

@section('content')
<div class="page-header">
  <div>
    <h1 class="page-title">Data Anak</h1>
    <p class="page-subtitle">Kelola data anak yang terdaftar di sistem</p>
  </div>
  <a href="{{ route('admin.anak.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Tambah Anak
  </a>
</div>

<div class="card">
  <div class="card-header bg-white border-bottom py-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <h5 class="mb-0">
        <i class="fas fa-users text-primary me-2"></i>Daftar Anak
        <span class="badge bg-secondary ms-2">{{ $anak->total() }}</span>
      </h5>
      <form method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau NIK..." value="{{ request('search') }}" style="width: 180px;">
        <select name="jenis_kelamin" class="form-select form-select-sm" style="width: 140px;">
          <option value="">Semua JK</option>
          <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
          <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        <select name="status" class="form-select form-select-sm" style="width: 120px;">
          <option value="">Semua Status</option>
          <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
          <option value="meninggal" {{ request('status') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
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
            <th>Nama Anak</th>
            <th>NIK</th>
            <th>JK</th>
            <th>Tanggal Lahir</th>
            <th>Usia</th>
            <th>BB</th>
            <th>TB</th>
            <th>Status Gizi</th>
            <th>Faskes</th>
            <th>Status</th>
            <th class="text-center" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($anak as $index => $item)
          <tr>
            <td class="ps-4 text-muted">{{ $anak->firstItem() + $index }}</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="avatar-circle bg-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'info' }} text-white me-3">
                  {{ substr($item->nama, 0, 1) }}
                </div>
                <div>
                  <h6 class="mb-0">{{ $item->nama }}</h6>
                  <small class="text-muted">{{ $item->ibu->name ?? '-' }}</small>
                </div>
              </div>
            </td>
            <td><code>{{ $item->nik_anak ?? '-' }}</code></td>
            <td>
              <span class="badge bg-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'info' }}">
                {{ $item->jenis_kelamin == 'L' ? 'L' : 'P' }}
              </span>
            </td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</td>
            <td>
              @php
                $usia = \Carbon\Carbon::parse($item->tanggal_lahir)->diff(now());
                $usiaText = $usia->y > 0 ? $usia->y . ' thn' : ($usia->m > 0 ? $usia->m . ' bln' : $usia->d . ' hr');
              @endphp
              {{ $usiaText }}
            </td>
            <td class="text-center">
              @if($item->latestPemeriksaan)
              <strong>{{ $item->latestPemeriksaan->berat_badan }}</strong> <small class="text-muted">kg</small>
              @else
              <span class="text-muted">-</span>
              @endif
            </td>
            <td class="text-center">
              @if($item->latestPemeriksaan)
              <strong>{{ $item->latestPemeriksaan->tinggi_badan }}</strong> <small class="text-muted">cm</small>
              @else
              <span class="text-muted">-</span>
              @endif
            </td>
            <td>
              @if($item->latestPemeriksaan && $item->latestPemeriksaan->status_gizi_akhir)
              <span class="badge bg-{{ 
                  $item->latestPemeriksaan->status_gizi_akhir == 'normal' ? 'success' : 
                  ($item->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $item->latestPemeriksaan->status_gizi_akhir == 'wasting' ? 'danger' : 
                  ($item->latestPemeriksaan->status_gizi_akhir == 'stunting' || $item->latestPemeriksaan->status_gizi_akhir == 'underweight' ? 'warning' : 'primary'))
              }}">
                {{ ucfirst(str_replace('_', ' ', $item->latestPemeriksaan->status_gizi_akhir)) }}
              </span>
              @else
              <span class="badge bg-secondary">Belum</span>
              @endif
            </td>
            <td>
              <small>{{ $item->faskes->nama ?? '-' }}</small>
            </td>
            <td>
              @if($item->status == 'aktif')
              <span class="badge bg-success"><i class="fas fa-check me-1"></i>Aktif</span>
              @elseif($item->status == 'pindah')
              <span class="badge bg-warning"><i class="fas fa-arrow-right me-1"></i>Pindah</span>
              @else
              <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Meninggal</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1 justify-content-center">
                <a href="{{ route('admin.anak.show', $item->id) }}" class="btn btn-sm btn-outline-info" title="Lihat">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.anak.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.anak.destroy', $item->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger btn-delete" title="Hapus" data-title="Hapus Data Anak" data-text="Apakah Anda yakin ingin menghapus data {{ $item->nama }}?">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="12" class="text-center py-5">
              <i class="fas fa-child fa-4x text-muted mb-3 d-block"></i>
              <h5 class="text-muted">Tidak ada data anak</h5>
              <p class="text-muted">Silakan tambah data anak terlebih dahulu</p>
              <a href="{{ route('admin.anak.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Anak
              </a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($anak->hasPages())
  <div class="card-footer bg-white py-3">
    {{ $anak->links() }}
  </div>
  @endif
</div>
@endsection
