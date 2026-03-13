@extends('admin.layout.master')

@section('title', 'Tambah Pemeriksaan')

@section('content')
<div class="page-header">
  <div>
    <h1 class="page-title">Tambah Pemeriksaan</h1>
    <p class="page-subtitle">Catat pemeriksaan anak baru</p>
  </div>
  <a href="{{ route('admin.pemeriksaan.index') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left me-2"></i>Kembali
  </a>
</div>

<div class="card">
  <div class="card-header bg-white border-bottom py-3">
    <h5 class="mb-0">
      <i class="fas fa-stethoscope text-primary me-2"></i>Form Pemeriksaan
    </h5>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.pemeriksaan.store') }}" method="POST">
      @csrf
      <div class="row g-4">
        <div class="col-md-6">
          <div class="card bg-light border-0">
            <div class="card-body">
              <h6 class="text-primary mb-3"><i class="fas fa-child me-2"></i>Data Anak</h6>
              <div class="mb-3">
                <label class="form-label">Pilih Anak <span class="text-danger">*</span></label>
                <select name="anak_id" class="form-select" required>
                  <option value="">-- Pilih Anak --</option>
                  @foreach($anaks as $anak)
                  <option value="{{ $anak->id }}">{{ $anak->nama }} ({{ $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}) - {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bln</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Tanggal Periksa <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_periksa" class="form-control" value="{{ date('Y-m-d') }}" required>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="card bg-light border-0">
            <div class="card-body">
              <h6 class="text-success mb-3"><i class="fas fa-ruler-vertical me-2"></i>Ukuran Antropometri</h6>
              <div class="row g-3">
                <div class="col-6">
                  <label class="form-label">Berat Badan <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="number" step="0.01" name="berat_badan" class="form-control" placeholder="0.00" required>
                    <span class="input-group-text">kg</span>
                  </div>
                </div>
                <div class="col-6">
                  <label class="form-label">Tinggi Badan <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="number" step="0.1" name="tinggi_badan" class="form-control" placeholder="0.0" required>
                    <span class="input-group-text">cm</span>
                  </div>
                </div>
                <div class="col-6">
                  <label class="form-label">Lingkar Kepala</label>
                  <div class="input-group">
                    <input type="number" step="0.1" name="lingkar_kepala" class="form-control" placeholder="0.0">
                    <span class="input-group-text">cm</span>
                  </div>
                </div>
                <div class="col-6">
                  <label class="form-label">Lingkar Lengan</label>
                  <div class="input-group">
                    <input type="number" step="0.1" name="lingkar_lengan" class="form-control" placeholder="0.0">
                    <span class="input-group-text">cm</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="card bg-light border-0">
            <div class="card-body">
              <h6 class="text-info mb-3"><i class="fas fa-heartbeat me-2"></i>Kondisi Lainnya</h6>
              <div class="row g-3">
                <div class="col-md-3">
                  <label class="form-label">Suhu Tubuh</label>
                  <div class="input-group">
                    <input type="number" step="0.1" name="suhu_tubuh" class="form-control" placeholder="36.5">
                    <span class="input-group-text">°C</span>
                  </div>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Lingkar Perut</label>
                  <div class="input-group">
                    <input type="number" step="0.1" name="lingkar_perut" class="form-control" placeholder="0.0">
                    <span class="input-group-text">cm</span>
                  </div>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Lingkar Dada</label>
                  <div class="input-group">
                    <input type="number" step="0.1" name="lingkar_dada" class="form-control" placeholder="0.0">
                    <span class="input-group-text">cm</span>
                  </div>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Kondisi Umum</label>
                  <select name="kondisi_umum" class="form-select">
                    <option value="baik">Baik</option>
                    <option value="sedang">Sedang</option>
                    <option value="buruk">Buruk</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="card bg-light border-0">
            <div class="card-body">
              <h6 class="text-warning mb-3"><i class="fas fa-pills me-2"></i>Pelayanan</h6>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Catatan</label>
                  <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan jika ada..."></textarea>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Pemberian Vitamin/Obat</label>
                  <div class="d-flex flex-wrap gap-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="diberikan_vit_a" value="1" id="vit_a">
                      <label class="form-check-label" for="vit_a">Vitamin A</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="diberikan_fe" value="1" id="fe">
                      <label class="form-check-label" for="fe">Fe</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="diberikan_zinc" value="1" id="zinc">
                      <label class="form-check-label" for="zinc">Zinc</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="diberikan_pmt" value="1" id="pmt">
                      <label class="form-check-label" for="pmt">PMT</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.pemeriksaan.index') }}" class="btn btn-secondary">
              <i class="fas fa-times me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save me-2"></i>Simpan Pemeriksaan
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
