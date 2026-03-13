@extends('admin.layout.master')

@section('title', 'Tambah Faskes')

@section('content')
<div class="content-header">
    <h1>Tambah Fasilitas Kesehatan</h1>
    <a href="{{ route('admin.manajemen.faskes') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.manajemen.faskes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="kode" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="tipe" class="form-control" required>
                                <option value="">Pilih Tipe</option>
                                <option value="rs">Rumah Sakit</option>
                                <option value="puskesmas">Puskesmas</option>
                                <option value="posyandu">Posyandu</option>
                                <option value="polindes">Polindes</option>
                                <option value="klinik">Klinik</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="telepon" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Wilayah</label>
                            <select name="wilayah_id" class="form-control" required>
                                <option value="">Pilih Wilayah</option>
                                @foreach($wilayahs as $w)
                                <option value="{{ $w->id }}">{{ $w->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
