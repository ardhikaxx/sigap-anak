@extends('admin.layout.master')

@section('title', 'Detail Edukasi')

@section('content')
<div class="content-header">
    <h1>{{ $edukasi->judul }}</h1>
    <a href="{{ route('admin.edukasi.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <span class="badge badge-info">{{ ucfirst($edukasi->kategori) }}</span>
                <span class="ml-2">Views: {{ $edukasi->views }}</span>
            </div>
            <div class="edukasi-konten">
                {!! $edukasi->konten !!}
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.edukasi.edit', $edukasi->id) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
</div>
@endsection
