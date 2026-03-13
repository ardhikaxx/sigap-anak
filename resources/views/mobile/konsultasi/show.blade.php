@extends('mobile.layout.master')

@section('title', 'Detail Konsultasi')

@section('content')
<div class="mobile-header">
    <a href="{{ route('mobile.konsultasi.index') }}" class="back-link">← Kembali</a>
    <h1>Konsultasi</h1>
</div>

<div class="mobile-content">
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5>{{ $konsultasi->topik }}</h5>
                <span class="badge badge-{{ $konsultasi->status === 'selesai' ? 'success' : ($konsultasi->status === 'menunggu' ? 'warning' : 'info') }}">
                    {{ ucfirst($konsultasi->status) }}
                </span>
            </div>
            <hr>
            <p><strong>Anak:</strong> {{ $konsultasi->anak->nama ?? '-' }}</p>
            <p><strong>Tipe:</strong> {{ ucfirst(str_replace('_', ' ', $konsultasi->tipe)) }}</p>
            <p><strong>Tanggal:</strong> {{ $konsultasi->created_at->format('d-m-Y H:i') }}</p>
        </div>
    </div>

    @if($konsultasi->pesan->count() > 0)
    <div class="card mb-3">
        <div class="card-header"><h6>Pesan</h6></div>
        <div class="card-body">
            @foreach($konsultasi->pesan as $pesan)
            <div class="mb-3">
                <strong>{{ $pesan->pengirim->name }}</strong>
                <small class="text-muted">{{ $pesan->created_at->format('H:i') }}</small>
                <p class="mb-0">{{ $pesan->pesan }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($konsultasi->status !== 'selesai')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mobile.konsultasi.message', $konsultasi->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Kirim Pesan</label>
                    <textarea name="pesan" class="form-control" rows="3" placeholder="Tulis pesan..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Kirim</button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
