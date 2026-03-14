@extends('admin.layout.master')

@section('title', 'Tambah Pemeriksaan')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.pemeriksaan.index') }}">Pemeriksaan</a></li>
  <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="welcome-hero mb-4">
  <div class="welcome-content">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="welcome-title">
          <i class="fas fa-file-medical me-2"></i>Tambah Pemeriksaan
        </h1>
        <p class="welcome-subtitle">Input data antropometri dan kondisi kesehatan anak terbaru</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <a href="{{ route('admin.pemeriksaan.index') }}" class="btn-action btn-outline-action bg-white border-0 shadow-sm">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </div>
    </div>
  </div>
</div>

<form action="{{ route('admin.pemeriksaan.store') }}" method="POST">
  @csrf
  <div class="row g-4">
    <div class="col-lg-4">
      <div class="card-custom h-100">
        <div class="card-header-custom p-4 bg-light bg-opacity-50">
          <h5 class="mb-0"><i class="fas fa-child me-2 text-primary"></i>Data Anak & Waktu</h5>
        </div>
        <div class="card-body-custom p-4">
          <div class="mb-4">
            <label class="form-label fw-bold">Pilih Anak <span class="text-danger">*</span></label>
            <select name="anak_id" class="form-select border-0 bg-light py-3 rounded-3" required>
              <option value="">-- Cari Nama Anak --</option>
              @foreach($anaks as $anak)
              <option value="{{ $anak->id }}">{{ $anak->nama }} ({{ $anak->jenis_kelamin == 'L' ? 'L' : 'P' }}) - {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bln</option>
              @endforeach
            </select>
          </div>
          <div class="mb-0">
            <label class="form-label fw-bold">Tanggal Periksa <span class="text-danger">*</span></label>
            <input type="date" name="tanggal_periksa" class="form-control border-0 bg-light py-3 rounded-3" value="{{ date('Y-m-d') }}" required>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card-custom">
        <div class="card-header-custom p-4 bg-light bg-opacity-50">
          <h5 class="mb-0"><i class="fas fa-ruler-vertical me-2 text-success"></i>Ukuran Antropometri</h5>
        </div>
        <div class="card-body-custom p-4">
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label fw-bold">Berat Badan (kg) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text border-0 bg-light px-3"><i class="fas fa-weight-hanging text-muted"></i></span>
                <input type="number" step="0.01" name="berat_badan" class="form-control border-0 bg-light py-3" placeholder="Contoh: 12.50" required>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Tinggi/Panjang Badan (cm) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text border-0 bg-light px-3"><i class="fas fa-ruler-vertical text-muted"></i></span>
                <input type="number" step="0.1" name="tinggi_badan" class="form-control border-0 bg-light py-3" placeholder="Contoh: 85.5" required>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold text-muted">Lingkar Kepala (cm)</label>
              <input type="number" step="0.1" name="lingkar_kepala" class="form-control border-0 bg-light py-3 rounded-3" placeholder="Opsional">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold text-muted">Lingkar Lengan Atas (cm)</label>
              <input type="number" step="0.1" name="lingkar_lengan" class="form-control border-0 bg-light py-3 rounded-3" placeholder="Opsional">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card-custom">
        <div class="card-header-custom p-4 bg-light bg-opacity-50">
          <h5 class="mb-0"><i class="fas fa-notes-medical me-2 text-info"></i>Kondisi Klinis & Pelayanan</h5>
        </div>
        <div class="card-body-custom p-4">
          <div class="row g-4">
            <div class="col-md-3">
              <label class="form-label fw-bold text-muted">Suhu Tubuh (°C)</label>
              <input type="number" step="0.1" name="suhu_tubuh" class="form-control border-0 bg-light py-3 rounded-3" placeholder="36.5">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold text-muted">Kondisi Umum</label>
              <select name="kondisi_umum" class="form-select border-0 bg-light py-3 rounded-3">
                <option value="baik">Baik</option>
                <option value="sedang">Sedang</option>
                <option value="buruk">Buruk</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold text-muted">Intervensi / Pemberian</label>
              <div class="d-flex flex-wrap gap-3 py-2">
                <div class="form-check custom-check">
                  <input class="form-check-input" type="checkbox" name="diberikan_vit_a" value="1" id="vit_a">
                  <label class="form-check-label fw-semibold" for="vit_a">Vit A</label>
                </div>
                <div class="form-check custom-check">
                  <input class="form-check-input" type="checkbox" name="diberikan_fe" value="1" id="fe">
                  <label class="form-check-label fw-semibold" for="fe">Zat Besi (Fe)</label>
                </div>
                <div class="form-check custom-check">
                  <input class="form-check-input" type="checkbox" name="diberikan_zinc" value="1" id="zinc">
                  <label class="form-check-label fw-semibold" for="zinc">Zinc</label>
                </div>
                <div class="form-check custom-check">
                  <input class="form-check-input" type="checkbox" name="diberikan_pmt" value="1" id="pmt">
                  <label class="form-check-label fw-semibold" for="pmt">PMT</label>
                </div>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label fw-bold text-muted">Catatan Tambahan</label>
              <textarea name="catatan" class="form-control border-0 bg-light py-3 rounded-3" rows="3" placeholder="Masukkan keterangan rujukan atau catatan lainnya jika ada..."></textarea>
            </div>
          </div>
        </div>
        <div class="card-footer p-4 bg-white border-top">
          <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.pemeriksaan.index') }}" class="btn-action btn-outline-action px-4 py-3">
              <i class="fas fa-times"></i> Batal
            </a>
            <button type="submit" class="btn-action btn-primary-action px-5 py-3 shadow-sm">
              <i class="fas fa-save"></i> Simpan Data Pemeriksaan
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<style>
  .custom-check .form-check-input {
    width: 22px;
    height: 22px;
    border: 2px solid var(--sigap-border);
    cursor: pointer;
  }
  .custom-check .form-check-input:checked {
    background-color: var(--sigap-primary);
    border-color: var(--sigap-primary);
  }
  .custom-check .form-check-label {
    margin-top: 3px;
    cursor: pointer;
  }
</style>
@endsection
