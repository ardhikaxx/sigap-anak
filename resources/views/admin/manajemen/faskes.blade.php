@extends('admin.layout.master')

@section('title', 'Manajemen Fasilitas Kesehatan')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Faskes</li>
@endsection

@section('content')
<div class="welcome-hero mb-4">
  <div class="welcome-content">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="welcome-title">
          <i class="fas fa-hospital me-2"></i>Fasilitas Kesehatan
        </h1>
        <p class="welcome-subtitle">Kelola data pusat layanan kesehatan dan posyandu yang terintegrasi</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <a href="{{ route('admin.manajemen.faskes.create') }}" class="btn-action btn-primary-action px-4 py-3 shadow-lg">
          <i class="fas fa-plus"></i> Tambah Faskes Baru
        </a>
      </div>
    </div>
  </div>
</div>

<div class="card-custom">
  <div class="card-header-custom p-4">
    <h5 class="mb-0"><i class="fas fa-list-check me-2 text-primary"></i>Daftar Fasilitas Kesehatan</h5>
    <div class="d-flex gap-2">
      <form method="GET" class="d-flex gap-2">
        <select name="tipe" class="form-select bg-light border-0 py-2" onchange="this.form.submit()">
          <option value="">Semua Tipe</option>
          <option value="rs" {{ request('tipe') == 'rs' ? 'selected' : '' }}>Rumah Sakit</option>
          <option value="puskesmas" {{ request('tipe') == 'puskesmas' ? 'selected' : '' }}>Puskesmas</option>
          <option value="posyandu" {{ request('tipe') == 'posyandu' ? 'selected' : '' }}>Posyandu</option>
          <option value="polindes" {{ request('tipe') == 'polindes' ? 'selected' : '' }}>Polindes</option>
          <option value="klinik" {{ request('tipe') == 'klinik' ? 'selected' : '' }}>Klinik</option>
        </select>
      </form>
    </div>
  </div>
  <div class="card-body-custom p-0">
    <div class="table-responsive">
      <table class="table-custom w-100">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Nama Fasilitas</th>
            <th>Jenis / Tipe</th>
            <th>Kontak & Alamat</th>
            <th>Status</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($faskes as $f)
          <tr>
            <td><code class="fw-bold text-primary">{{ $f->kode }}</code></td>
            <td>
              <div class="fw-bold text-dark">{{ $f->nama }}</div>
            </td>
            <td>
              @php
                $tipeColor = match($f->tipe) {
                  'rs' => 'badge-danger',
                  'puskesmas' => 'badge-info',
                  'posyandu' => 'badge-normal',
                  'klinik' => 'badge-warning',
                  default => 'badge-default',
                };
              @endphp
              <span class="badge-custom {{ $tipeColor }} bg-opacity-10 text-uppercase">
                {{ $f->tipe }}
              </span>
            </td>
            <td>
              <div class="user-meta fw-semibold text-dark"><i class="fas fa-phone-alt me-1" style="font-size: 0.7rem;"></i> {{ $f->telepon ?? '-' }}</div>
              <div class="user-meta" style="font-size: 0.75rem;"><i class="fas fa-location-dot me-1" style="font-size: 0.7rem;"></i> {{ Str::limit($f->alamat, 30) }}</div>
            </td>
            <td>
              @if($f->is_active ?? true)
                <span class="badge-custom badge-normal">Aktif</span>
              @else
                <span class="badge-custom badge-default">Nonaktif</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1 justify-content-end">
                <a href="{{ route('admin.manajemen.faskes.show', $f->id) }}" class="btn-action btn-outline-action px-2 py-2" title="Detail">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.manajemen.faskes.edit', $f->id) }}" class="btn-action btn-outline-action px-2 py-2 text-warning" title="Edit">
                  <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('admin.manajemen.faskes.destroy', $f->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-action btn-outline-action px-2 py-2 text-danger btn-delete" title="Hapus">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="py-5 text-center">
              <div class="empty-state py-0">
                <div class="empty-icon"><i class="fas fa-hospital-user"></i></div>
                <div class="empty-title">Belum Ada Faskes</div>
                <div class="empty-text">Daftar fasilitas kesehatan akan muncul di sini</div>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-4 d-flex justify-content-center">
      {{ $faskes->links() }}
    </div>
  </div>
</div>
@endsection
