@extends('mobile.layout.master')

@section('title', 'Detail Anak - ' . $anak->nama)

@section('content')
<div class="mobile-header">
    <a href="{{ route('mobile.anak.index') }}" class="back-link">← Kembali</a>
    <h1>{{ $anak->nama }}</h1>
</div>

<div class="mobile-content">
    <div class="card mb-3">
        <div class="card-body">
            <div class="text-center mb-3">
                <div class="avatar-circle-lg bg-primary text-white mx-auto">
                    {{ substr($anak->nama, 0, 1) }}
                </div>
            </div>
            <div class="row text-center">
                <div class="col-4">
                    <small class="text-muted">Jenis Kelamin</small>
                    <p class="mb-0">{{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
                <div class="col-4">
                    <small class="text-muted">Tanggal Lahir</small>
                    <p class="mb-0">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d-m-Y') }}</p>
                </div>
                <div class="col-4">
                    <small class="text-muted">Usia</small>
                    <p class="mb-0">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bln</p>
                </div>
            </div>
        </div>
    </div>

    @if($latestPemeriksaan)
    <div class="card mb-3">
        <div class="card-header">
            <h5>Pemeriksaan Terakhir</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <small class="text-muted">Berat Badan</small>
                    <p class="mb-0">{{ $latestPemeriksaan->berat_badan }} kg</p>
                </div>
                <div class="col-6">
                    <small class="text-muted">Tinggi Badan</small>
                    <p class="mb-0">{{ $latestPemeriksaan->tinggi_badan }} cm</p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <span class="badge badge-{{ $latestPemeriksaan->status_gizi_akhir == 'normal' ? 'success' : 'warning' }}">
                    {{ ucfirst(str_replace('_', ' ', $latestPemeriksaan->status_gizi_akhir ?? '-')) }}
                </span>
            </div>
        </div>
    </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <h5>Menu</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('mobile.grafik.index', ['anak' => $anak->id]) }}" class="btn btn-outline-primary">Lihat Grafik Pertumbuhan</a>
                <a href="{{ route('mobile.konsultasi.create', ['anak' => $anak->id]) }}" class="btn btn-outline-success">Konsultasi Nakes</a>
            </div>
        </div>
    </div>
</div>
@endsection
