@extends('mobile.layout.master')

@section('title', 'Buat Konsultasi')

@section('content')
<div class="mobile-header">
    <a href="{{ route('mobile.konsultasi.index') }}" class="back-link">← Kembali</a>
    <h1>Buat Konsultasi</h1>
</div>

<div class="mobile-content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mobile.konsultasi.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Pilih Anak</label>
                    <select name="anak_id" class="form-control" required>
                        <option value="">Pilih Anak</option>
                        @foreach($anaks as $anak)
                        <option value="{{ $anak->id }}">{{ $anak->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Topik</label>
                    <input type="text" name="topik" class="form-control" placeholder="Contoh: Masalah Makan" required>
                </div>
                <div class="form-group">
                    <label>Tipe Konsultasi</label>
                    <select name="tipe" class="form-control" required>
                        <option value="chat">Chat</option>
                        <option value="video_call">Video Call</option>
                        <option value="tatap_muka">Tatap Muka</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Kirim</button>
            </form>
        </div>
    </div>
</div>
@endsection
