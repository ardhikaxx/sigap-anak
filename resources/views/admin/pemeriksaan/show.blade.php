@extends('admin.layout.master')

@section('title', 'Detail Pemeriksaan')

@section('content')
<div class="content-header">
    <h1>Detail Pemeriksaan</h1>
    <a href="{{ route('admin.pemeriksaan.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3>Pemeriksaan {{ $pemeriksaan->anak->nama ?? '-' }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Anak:</strong> {{ $pemeriksaan->anak->nama ?? '-' }}</p>
                    <p><strong>Tanggal Periksa:</strong> {{ \Carbon\Carbon::parse($pemeriksaan->tanggal_periksa)->format('d-m-Y') }}</p>
                    <p><strong>Umur:</strong> {{ $pemeriksaan->umur_bulan }} bulan</p>
                    <p><strong>Berat Badan:</strong> {{ $pemeriksaan->berat_badan }} kg</p>
                    <p><strong>Tinggi Badan:</strong> {{ $pemeriksaan->tinggi_badan }} cm</p>
                    <p><strong>Lingkar Kepala:</strong> {{ $pemeriksaan->lingkar_kepala ?? '-' }} cm</p>
                    <p><strong>Lingkar Lengan:</strong> {{ $pemeriksaan->lingkar_lengan ?? '-' }} cm</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status Gizi Akhir:</strong> {{ ucfirst(str_replace('_', ' ', $pemeriksaan->status_gizi_akhir ?? '-')) }}</p>
                    <p><strong>Nakes:</strong> {{ $pemeriksaan->nakes->name ?? '-' }}</p>
                    <p><strong>Faskes:</strong> {{ $pemeriksaan->posyandu->nama ?? '-' }}</p>
                    <p><strong>Kondisi Umum:</strong> {{ ucfirst($pemeriksaan->kondisi_umum ?? '-') }}</p>
                    <p><strong>Dirujuk:</strong> {{ $pemeriksaan->dirujuk ? 'Ya' : 'Tidak' }}</p>
                    <p><strong>Catatan:</strong> {{ $pemeriksaan->catatan ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
