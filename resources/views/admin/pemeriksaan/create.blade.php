@extends('admin.layout.master')

@section('title', 'Tambah Pemeriksaan')

@section('content')
<div class="content-header">
    <h1>Tambah Pemeriksaan</h1>
    <a href="{{ route('admin.pemeriksaan.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pemeriksaan.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Anak</label>
                            <select name="anak_id" class="form-control" required>
                                <option value="">Pilih Anak</option>
                                @foreach($anaks as $anak)
                                <option value="{{ $anak->id }}">{{ $anak->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Periksa</label>
                            <input type="date" name="tanggal_periksa" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Berat Badan (kg)</label>
                            <input type="number" step="0.01" name="berat_badan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tinggi Badan (cm)</label>
                            <input type="number" step="0.1" name="tinggi_badan" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Lingkar Kepala (cm)</label>
                            <input type="number" step="0.1" name="lingkar_kepala" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Lingkar Lengan (cm)</label>
                            <input type="number" step="0.1" name="lingkar_lengan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Kondisi Umum</label>
                            <select name="kondisi_umum" class="form-control">
                                <option value="baik">Baik</option>
                                <option value="sedang">Sedang</option>
                                <option value="buruk">Buruk</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
