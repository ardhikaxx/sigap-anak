@extends('admin.layout.master')

@section('title', 'Edit Wilayah')

@section('content')
<div class="content-header">
    <h1>Edit Wilayah</h1>
    <a href="{{ route('admin.manajemen.wilayah') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.manajemen.wilayah.update', $wilayah->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="kode" class="form-control" value="{{ $wilayah->kode }}" required>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $wilayah->nama }}" required>
                        </div>
                        <div class="form-group">
                            <label>Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" value="{{ $wilayah->provinsi }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control" value="{{ $wilayah->kabupaten }}">
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" value="{{ $wilayah->kecamatan }}">
                        </div>
                        <div class="form-group">
                            <label>Kelurahan</label>
                            <input type="text" name="kelurahan" class="form-control" value="{{ $wilayah->kelurahan }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </form>
        </div>
    </div>
</div>
@endsection
