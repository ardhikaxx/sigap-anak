@extends('admin.layout.master')

@section('title', 'Buat Jadwal Posyandu')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.posyandu.index') }}">Posyandu</a></li>
  <li class="breadcrumb-item active">Buat Jadwal</li>
@endsection

@section('content')
<div class="page-header">
  <div>
    <h1 class="page-title">Buat Jadwal Posyandu</h1>
    <p class="page-subtitle">Tambah jadwal kegiatan posyandu</p>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('admin.posyandu.store') }}">
      @csrf
      
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Posyandu <span class="text-danger">*</span></label>
            <select name="faskes_id" class="form-select @error('faskes_id') is-invalid @enderror" required>
              <option value="">Pilih Posyandu</option>
              @foreach($faskes as $f)
              <option value="{{ $f->id }}">{{ $f->nama }}</option>
              @endforeach
            </select>
            @error('faskes_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" required min="{{ date('Y-m-d') }}">
            @error('tanggal')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Jam Mulai</label>
            <input type="time" name="jam_mulai" class="form-control" value="08:00">
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Jam Selesai</label>
            <input type="time" name="jam_selesai" class="form-control" value="12:00">
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Tema</label>
        <input type="text" name="tema" class="form-control" placeholder="Contoh: Penimbangan Balita">
      </div>

      <div class="mb-3">
        <label class="form-label">Lokasi</label>
        <textarea name="lokasi" class="form-control" rows="2" placeholder="Alamat lokasi posyandu"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="2"></textarea>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save me-2"></i>Simpan
        </button>
        <a href="{{ route('admin.posyandu.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
