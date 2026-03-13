@extends('admin.layout.master')

@section('title', 'Edit Edukasi')

@section('content')
<div class="content-header">
    <h1>Edit Edukasi</h1>
    <a href="{{ route('admin.edukasi.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.edukasi.update', $edukasi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ $edukasi->judul }}" required>
                </div>
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ $edukasi->slug }}" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="nutrisi" {{ $edukasi->kategori == 'nutrisi' ? 'selected' : '' }}>Nutrisi</option>
                        <option value="imunisasi" {{ $edukasi->kategori == 'imunisasi' ? 'selected' : '' }}>Imunisasi</option>
                        <option value="perkembangan" {{ $edukasi->kategori == 'perkembangan' ? 'selected' : '' }}>Perkembangan</option>
                        <option value="penyakit" {{ $edukasi->kategori == 'penyakit' ? 'selected' : '' }}>Penyakit</option>
                        <option value="ibu_hamil" {{ $edukasi->kategori == 'ibu_hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                        <option value="lainnya" {{ $edukasi->kategori == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Konten</label>
                    <textarea name="konten" class="form-control" rows="10" required>{{ $edukasi->konten }}</textarea>
                </div>
                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                    @if($edukasi->gambar)
                    <img src="{{ asset('storage/' . $edukasi->gambar) }}" alt="" style="max-width: 200px; margin-top: 10px;">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </form>
        </div>
    </div>
</div>
@endsection
