@extends('admin.layout.master')

@section('title', 'Detail Faskes')

@section('content')
<div class="content-header">
    <h1>{{ $faskes->nama }}</h1>
    <a href="{{ route('admin.manajemen.faskes') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Informasi Faskes</h4></div>
                <div class="card-body">
                    <p><strong>Kode:</strong> {{ $faskes->kode }}</p>
                    <p><strong>Nama:</strong> {{ $faskes->nama }}</p>
                    <p><strong>Tipe:</strong> {{ strtoupper($faskes->tipe) }}</p>
                    <p><strong>Alamat:</strong> {{ $faskes->alamat }}</p>
                    <p><strong>Telepon:</strong> {{ $faskes->telepon ?? '-' }}</p>
                    <p><strong>Email:</strong> {{ $faskes->email ?? '-' }}</p>
                    <p><strong>Status:</strong> {{ $faskes->is_active ? 'Aktif' : 'Nonaktif' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Wilayah</h4></div>
                <div class="card-body">
                    <p><strong>Provinsi:</strong> {{ $faskes->wilayah->provinsi ?? '-' }}</p>
                    <p><strong>Kabupaten:</strong> {{ $faskes->wilayah->kabupaten ?? '-' }}</p>
                    <p><strong>Kecamatan:</strong> {{ $faskes->wilayah->kecamatan ?? '-' }}</p>
                    <p><strong>Kelurahan:</strong> {{ $faskes->wilayah->kelurahan ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
