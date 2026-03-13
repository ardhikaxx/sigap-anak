@extends('mobile.layout.master')

@section('title', 'Konsultasi')

@section('content')
<div class="mobile-header">
    <h1>Konsultasi</h1>
</div>

<div class="mobile-content">
    <a href="{{ route('mobile.konsultasi.create') }}" class="btn btn-primary btn-block mb-3">
        <i class="fas fa-plus"></i> Buat Konsultasi Baru
    </a>

    @forelse($konsultasis as $konsultasi)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-1">{{ $konsultasi->topik }}</h5>
                    <small class="text-muted">{{ $konsultasi->anak->nama ?? '-' }}</small>
                </div>
                <span class="badge badge-{{ $konsultasi->status === 'selesai' ? 'success' : ($konsultasi->status === 'menunggu' ? 'warning' : 'info') }}">
                    {{ ucfirst($konsultasi->status) }}
                </span>
            </div>
            <hr>
            <small class="text-muted">{{ $konsultasi->created_at->format('d-m-Y H:i') }}</small>
            <a href="{{ route('mobile.konsultasi.show', $konsultasi->id) }}" class="btn btn-sm btn-outline-primary btn-block mt-2">Lihat</a>
        </div>
    </div>
    @empty
    <div class="text-center p-4">
        <p>Belum ada konsultasi</p>
    </div>
    @endforelse
</div>
@endsection
