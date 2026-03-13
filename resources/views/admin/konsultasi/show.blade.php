@extends('admin.layout.master')

@section('title', 'Detail Konsultasi')

@section('content')
<div class="content-header">
    <h1>Detail Konsultasi</h1>
    <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3>{{ $konsultasi->topik }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Anak:</strong> {{ $konsultasi->anak->nama ?? '-' }}</p>
                    <p><strong>Orang Tua:</strong> {{ $konsultasi->orangtua->name ?? '-' }}</p>
                    <p><strong>Nakes:</strong> {{ $konsultasi->nakes->name ?? '-' }}</p>
                    <p><strong>Tipe:</strong> {{ ucfirst($konsultasi->tipe) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong> 
                        <span class="badge badge-{{ $konsultasi->status === 'menunggu' ? 'warning' : ($konsultasi->status === 'selesai' ? 'success' : 'info') }}">
                            {{ ucfirst($konsultasi->status) }}
                        </span>
                    </p>
                    <p><strong>Tanggal:</strong> {{ $konsultasi->created_at->format('d-m-Y H:i') }}</p>
                    <p><strong>Rating:</strong> {{ $konsultasi->rating ? $konsultasi->rating . '/5' : '-' }}</p>
                </div>
            </div>
            
            @if($konsultasi->ulasan)
            <div class="mt-3">
                <p><strong>Ulasan:</strong></p>
                <p>{{ $konsultasi->ulasan }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
