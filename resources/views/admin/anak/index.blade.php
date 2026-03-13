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
    <p class="page-subtitle">Kelola data anak yang terdaftar</p>
  </div>
  <a href="{{ route('admin.anak.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Tambah Anak
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="GET" class="mb-4">
      <div class="row g-3">
        <div class="col-md-3">
          <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIK..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
          <select name="jenis_kelamin" class="form-select">
            <option value="">Semua Jenis Kelamin</option>
            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
        </div>
        <div class="col-md-2">
          <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
            <option value="meninggal" {{ request('status') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
          </select>
        </div>
        <div class="col-md-2">
          <select name="faskes_id" class="form-select">
            <option value="">Semua Faskes</option>
            @foreach($faskes as $f)
            <option value="{{ $f->id }}" {{ request('faskes_id') == $f->id ? 'selected' : '' }}>{{ $f->nama }}</option>
            @endforeach
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
            <th>Nama</th>
            <th>NIK</th>
            <th>Jenis Kelamin</th>
            <th>Tanggal Lahir</th>
            <th>Usia</th>
            <th>Status Gizi</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($anak as $index => $item)
          <tr>
            <td>{{ $anak->firstItem() + $index }}</td>
            <td>
              <div class="d-flex align-items-center">
                <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://via.placeholder.com/40' }}" 
                     class="rounded-circle me-2" width="40" height="40" alt="{{ $item->nama }}">
                <div>
                  <strong>{{ $item->nama }}</strong>
                  <br><small class="text-muted">{{ $item->ibu->name ?? '-' }}</small>
                </div>
              </div>
            </td>
            <td>{{ $item->nik_anak ?? '-' }}</td>
            <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->diffInMonths(now()) }} bln</td>
            <td>
              @if($item->latestPemeriksaan)
              <span class="status-badge {{ $item->latestPemeriksaan->status_gizi_akhir }}">
                {{ ucfirst($item->latestPemeriksaan->status_gizi_akhir ?? 'belum') }}
              </span>
              @else
              <span class="badge bg-secondary">Belum</span>
              @endif
            </td>
            <td>
              @if($item->status == 'aktif')
              <span class="badge bg-success">Aktif</span>
              @elseif($item->status == 'pindah')
              <span class="badge bg-warning">Pindah</span>
              @else
              <span class="badge bg-danger">Meninggal</span>
              @endif
            </td>
            <td>
              <div class="action-buttons">
                <a href="{{ route('admin.anak.show', $item->id) }}" class="btn btn-sm btn-info" title="Lihat">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.anak.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.anak.destroy', $item->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger btn-delete" title="Hapus" data-title="Hapus Data Anak" data-text="Apakah Anda yakin ingin menghapus data {{ $item->nama }}?">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-center py-4">
              <i class="fas fa-child fa-3x text-muted mb-3"></i>
              <p class="text-muted">Tidak ada data anak</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $anak->links() }}
    </div>
  </div>
</div>
@endsection
