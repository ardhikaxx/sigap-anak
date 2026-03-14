@extends('admin.layout.master')

@section('title', 'Tambah Edukasi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.edukasi.index') }}">Edukasi</a></li>
  <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css">
<style>
  :root {
    --primary: #0ea5e9; --primary-dark: #0284c7; --dark: #0f172a;
    --gray-600: #475569; --gray-500: #64748b; --gray-400: #94a3b8;
    --gray-100: #f1f5f9; --white: #ffffff; --danger: #ef4444;
  }
  * { font-family: 'Plus Jakarta Sans', -apple-system, sans-serif; }

  .hero-section {
    background: var(--primary); border-radius: 24px; padding: 36px 40px;
    color: white; position: relative; overflow: hidden; margin-bottom: 28px;
  }
  .hero-section::before {
    content: ''; position: absolute; top: -50%; right: -10%; width: 280px; height: 280px;
    background: rgba(255,255,255,0.08); border-radius: 50%;
  }
  .hero-title { font-size: 2rem; font-weight: 800; margin-bottom: 4px; }
  .hero-subtitle { font-size: 1rem; opacity: 0.9; }

  .content-card { background: var(--white); border-radius: 22px; box-shadow: 0 8px 32px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; overflow: hidden; }
  .card-header-custom { padding: 22px 28px; border-bottom: 1px solid #f1f5f9; }
  .card-title-custom { font-size: 1.1rem; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 12px; margin: 0; }
  .card-title-custom i { color: var(--primary); }
  .card-body-custom { padding: 28px; }

  .form-label-custom { font-weight: 600; font-size: 0.9rem; color: var(--dark); margin-bottom: 8px; display: block; }
  .form-control-custom {
    width: 100%; padding: 14px 18px; border: 2px solid #e2e8f0; border-radius: 14px;
    font-size: 0.95rem; transition: all 0.25s ease; background: var(--gray-100);
  }
  .form-control-custom:focus { border-color: var(--primary); background: var(--white); outline: none; box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1); }
  .form-select-custom {
    width: 100%; padding: 14px 18px; border: 2px solid #e2e8f0; border-radius: 14px;
    font-size: 0.95rem; transition: all 0.25s ease; background: var(--gray-100); cursor: pointer;
  }
  .form-select-custom:focus { border-color: var(--primary); background: var(--white); outline: none; box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1); }
  .form-check-custom { display: flex; align-items: center; gap: 10px; }
  .form-check-input { width: 20px; height: 20px; }
  .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }

  .btn-save { background: var(--primary); border: none; border-radius: 14px; padding: 14px 28px; font-weight: 700; color: white; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35); display: inline-flex; align-items: center; gap: 8px; }
  .btn-save:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(14, 165, 233, 0.45); color: white; }
  .btn-back { background: var(--gray-100); border: none; border-radius: 14px; padding: 14px 22px; font-weight: 600; color: var(--gray-600); transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; }
  .btn-back:hover { background: var(--gray-100); color: var(--dark); }
  .invalid-feedback { color: var(--danger); font-size: 0.8rem; font-weight: 500; margin-top: 6px; }

  @media (max-width: 768px) { .hero-section { padding: 24px; text-align: center; } .hero-title { font-size: 1.5rem; } }
</style>
@endsection

@section('content')
<div class="hero-section">
  <div class="row align-items-center">
    <div class="col-lg-8">
      <h1 class="hero-title"><i class="fas fa-plus-circle me-2"></i>Tambah Artikel Edukasi</h1>
      <p class="hero-subtitle">Buat konten edukasi kesehatan anak baru</p>
    </div>
  </div>
</div>

<div class="content-card">
  <div class="card-header-custom">
    <h5 class="card-title-custom"><i class="fas fa-file-edit"></i>Form Artikel Edukasi</h5>
  </div>
  <div class="card-body-custom">
    <form action="{{ route('admin.edukasi.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      
      <div class="row g-4">
        <div class="col-md-8">
          <label class="form-label-custom">Judul <span class="text-danger">*</span></label>
          <input type="text" name="judul" class="form-control-custom @error('judul') is-invalid @enderror" required placeholder="Judul artikel">
          @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
          <label class="form-label-custom">Kategori <span class="text-danger">*</span></label>
          <select name="kategori" class="form-select-custom @error('kategori') is-invalid @enderror" required>
            <option value="">Pilih Kategori</option>
            <option value="nutrisi">Nutrisi</option>
            <option value="imunisasi">Imunisasi</option>
            <option value="perkembangan">Perkembangan</option>
            <option value="penyakit">Penyakit</option>
            <option value="ibu_hamil">Ibu Hamil</option>
            <option value="lainnya">Lainnya</option>
          </select>
          @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="mt-4">
        <label class="form-label-custom">Konten <span class="text-danger">*</span></label>
        <textarea name="konten" class="form-control-custom @error('konten') is-invalid @enderror" rows="8" required placeholder="Isi artikel edukasi..."></textarea>
        @error('konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="row g-4 mt-2">
        <div class="col-md-6">
          <label class="form-label-custom">Gambar</label>
          <input type="file" name="gambar" class="form-control-custom" accept="image/*">
        </div>
        <div class="col-md-6">
          <label class="form-label-custom">Status</label>
          <div class="form-check-custom mt-2">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
            <label class="form-check-label" for="is_active">Artikel aktif</label>
          </div>
        </div>
      </div>

      <div class="d-flex gap-3 mt-5">
        <a href="{{ route('admin.edukasi.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
        <button type="submit" class="btn-save"><i class="fas fa-save"></i> Simpan Artikel</button>
      </div>
    </form>
  </div>
</div>
@endsection
