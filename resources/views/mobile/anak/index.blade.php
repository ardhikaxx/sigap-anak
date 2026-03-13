@extends('mobile.layout.master')

@section('title', 'Data Anak')

@section('content')
<div class="mobile-header">
    <h1>Data Anak</h1>
</div>

<div class="mobile-content">
    @forelse($anaks as $anak)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="avatar-circle bg-primary text-white">
                    {{ substr($anak->nama, 0, 1) }}
                </div>
                <div class="ml-3">
                    <h5 class="mb-0">{{ $anak->nama }}</h5>
                    <small class="text-muted">{{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                </div>
                @if($anak->latestPemeriksaan && $anak->latestPemeriksaan->status_gizi_akhir)
                <span class="badge bg-{{ 
                    $anak->latestPemeriksaan->status_gizi_akhir == 'normal' ? 'success' : 
                    ($anak->latestPemeriksaan->status_gizi_akhir == 'gizi_buruk' || $anak->latestPemeriksaan->status_gizi_akhir == 'wasting' ? 'danger' : 
                    ($anak->latestPemeriksaan->status_gizi_akhir == 'stunting' || $anak->latestPemeriksaan->status_gizi_akhir == 'underweight' ? 'warning' : 'primary'))
                }} ms-auto">
                    {{ ucfirst(str_replace('_', ' ', $anak->latestPemeriksaan->status_gizi_akhir)) }}
                </span>
                @endif
            </div>
            <hr>
            <div class="row">
                <div class="col-6">
                    <small class="text-muted">Tanggal Lahir</small>
                    <p class="mb-0">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d-m-Y') }}</p>
                </div>
                <div class="col-6">
                    <small class="text-muted">Usia</small>
                    <p class="mb-0">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bulan</p>
                </div>
            </div>
            @if($anak->latestPemeriksaan)
            <div class="row mt-2">
                <div class="col-4">
                    <small class="text-muted">Berat</small>
                    <p class="mb-0 fw-bold">{{ $anak->latestPemeriksaan->berat_badan }} kg</p>
                </div>
                <div class="col-4">
                    <small class="text-muted">Tinggi</small>
                    <p class="mb-0 fw-bold">{{ $anak->latestPemeriksaan->tinggi_badan }} cm</p>
                </div>
                <div class="col-4">
                    <small class="text-muted">Terakhir</small>
                    <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($anak->latestPemeriksaan->tanggal_periksa)->format('d/m') }}</p>
                </div>
            </div>
            @endif
            <a href="{{ route('mobile.anak.show', $anak->id) }}" class="btn btn-primary btn-block mt-3">Lihat Detail</a>
        </div>
    </div>
    @empty
    <div class="text-center p-4">
        <i class="fas fa-child fa-3x text-muted mb-3 d-block"></i>
        <p class="text-muted">Tidak ada data anak</p>
    </div>
    @endforelse
</div>
@endsection
