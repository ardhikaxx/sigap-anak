@extends('admin.layout.master')

@section('title', 'Edit Faskes')

@section('content')
<div class="content-header">
    <h1>Edit Fasilitas Kesehatan</h1>
    <a href="{{ route('admin.manajemen.faskes') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.manajemen.faskes.update', $faskes->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="kode" class="form-control" value="{{ $faskes->kode }}" required>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $faskes->nama }}" required>
                        </div>
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="tipe" class="form-control" required>
                                <option value="rs" {{ $faskes->tipe == 'rs' ? 'selected' : '' }}>Rumah Sakit</option>
                                <option value="puskesmas" {{ $faskes->tipe == 'puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                                <option value="posyandu" {{ $faskes->tipe == 'posyandu' ? 'selected' : '' }}>Posyandu</option>
                                <option value="polindes" {{ $faskes->tipe == 'polindes' ? 'selected' : '' }}>Polindes</option>
                                <option value="klinik" {{ $faskes->tipe == 'klinik' ? 'selected' : '' }}>Klinik</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" required>{{ $faskes->alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="{{ $faskes->telepon }}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $faskes->email }}">
                        </div>
                        <div class="form-group">
                            <label>Wilayah</label>
                            <select name="wilayah_id" class="form-control" required>
                                @foreach($wilayahs as $w)
                                <option value="{{ $w->id }}" {{ $faskes->wilayah_id == $w->id ? 'selected' : '' }}>{{ $w->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </form>
        </div>
    </div>
</div>
@endsection
