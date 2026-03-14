@extends('admin.layout.master')

@section('title', 'Buat Jadwal Posyandu')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.posyandu.index') }}">Posyandu</a></li>
  <li class="breadcrumb-item active">Buat Jadwal</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css">
<style>
  :root {
    --primary: #0ea5e9;
    --primary-dark: #0284c7;
    --dark: #0f172a;
    --gray-600: #475569;
    --gray-500: #64748b;
    --gray-400: #94a3b8;
    --gray-100: #f1f5f9;
    --white: #ffffff;
    --danger: #ef4444;
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

  .content-card {
    background: var(--white); border-radius: 22px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;
    overflow: hidden;
  }

  .card-header-custom {
    padding: 22px 28px; border-bottom: 1px solid #f1f5f9;
  }

  .card-title-custom {
    font-size: 1.1rem; font-weight: 700; color: var(--dark);
    display: flex; align-items: center; gap: 12px; margin: 0;
  }
  .card-title-custom i { color: var(--primary); }

  .card-body-custom { padding: 28px; }

  .form-label-custom {
    font-weight: 600; font-size: 0.9rem; color: var(--dark); margin-bottom: 8px;
    display: block;
  }

  .form-control-custom {
    width: 100%; padding: 14px 18px;
    border: 2px solid #e2e8f0; border-radius: 14px;
    font-size: 0.95rem; transition: all 0.25s ease; background: var(--gray-100);
  }

  .form-control-custom:focus {
    border-color: var(--primary); background: var(--white);
    outline: none; box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
  }

  .form-select-custom {
    width: 100%; padding: 14px 18px;
    border: 2px solid #e2e8f0; border-radius: 14px;
    font-size: 0.95rem; transition: all 0.25s ease; background: var(--gray-100);
    cursor: pointer;
  }

  .form-select-custom:focus {
    border-color: var(--primary); background: var(--white);
    outline: none; box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
  }

  .btn-save {
    background: var(--primary); border: none; border-radius: 14px;
    padding: 14px 28px; font-weight: 700; color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35);
    display: inline-flex; align-items: center; gap: 8px;
  }

  .btn-save:hover {
    background: var(--primary-dark); transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(14, 165, 233, 0.45); color: white;
  }

  .btn-back {
    background: var(--gray-100); border: none; border-radius: 14px;
    padding: 14px 22px; font-weight: 600; color: var(--gray-600);
    transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;
  }

  .btn-back:hover { background: var(--gray-100); color: var(--dark); }

  .invalid-feedback { color: var(--danger); font-size: 0.8rem; font-weight: 500; margin-top: 6px; }

  @media (max-width: 768px) {
    .hero-section { padding: 24px; text-align: center; }
    .hero-title { font-size: 1.5rem; }
  }
</style>
@endsection

@section('content')
<div class="hero-section">
  <div class="row align-items-center">
    <div class="col-lg-8">
      <h1 class="hero-title"><i class="fas fa-calendar-plus me-2"></i>Buat Jadwal Posyandu</h1>
      <p class="hero-subtitle">Tambah jadwal kegiatan posyandu baru</p>
    </div>
  </div>
</div>

<div class="content-card">
  <div class="card-header-custom">
    <h5 class="card-title-custom"><i class="fas fa-plus-circle"></i>Form Jadwal Posyandu</h5>
  </div>
  <div class="card-body-custom">
    <form method="POST" action="{{ route('admin.posyandu.store') }}">
      @csrf
      
      <div class="row g-4">
        <div class="col-md-6">
          <label class="form-label-custom">Posyandu <span class="text-danger">*</span></label>
          <select name="faskes_id" class="form-select-custom @error('faskes_id') is-invalid @enderror" required>
            <option value="">Pilih Posyandu</option>
            @foreach($faskes as $f)
            <option value="{{ $f->id }}">{{ $f->nama }}</option>
            @endforeach
          </select>
          @error('faskes_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        
        <div class="col-md-6">
          <label class="form-label-custom">Tanggal <span class="text-danger">*</span></label>
          <input type="date" name="tanggal" class="form-control-custom @error('tanggal') is-invalid @enderror" required min="{{ date('Y-m-d') }}">
          @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="row g-4 mt-2">
        <div class="col-md-6">
          <label class="form-label-custom">Jam Mulai</label>
          <input type="time" name="jam_mulai" class="form-control-custom" value="08:00">
        </div>
        
        <div class="col-md-6">
          <label class="form-label-custom">Jam Selesai</label>
          <input type="time" name="jam_selesai" class="form-control-custom" value="12:00">
        </div>
      </div>

      <div class="mt-4">
        <label class="form-label-custom">Tema</label>
        <input type="text" name="tema" class="form-control-custom" placeholder="Contoh: Penimbangan Balita">
      </div>

      <div class="mt-4">
        <label class="form-label-custom">Lokasi</label>
        <textarea name="lokasi" class="form-control-custom" rows="2" placeholder="Alamat lokasi posyandu"></textarea>
      </div>

      <div class="mt-4">
        <label class="form-label-custom">Keterangan</label>
        <textarea name="keterangan" class="form-control-custom" rows="2"></textarea>
      </div>

      <div class="d-flex gap-3 mt-5">
        <a href="{{ route('admin.posyandu.index') }}" class="btn-back">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn-save">
          <i class="fas fa-save"></i> Simpan Jadwal
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
