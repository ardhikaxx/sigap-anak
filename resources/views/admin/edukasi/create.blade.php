@extends('admin.layout.master')

@section('title', 'Tambah Edukasi')

@section('content')
<div class="content-header">
    <h1>Tambah Edukasi</h1>
    <a href="{{ route('admin.edukasi.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.edukasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <option value="nutrisi">Nutrisi</option>
                        <option value="imunisasi">Imunisasi</option>
                        <option value="perkembangan">Perkembangan</option>
                        <option value="penyakit">Penyakit</option>
                        <option value="ibu_hamil">Ibu Hamil</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Konten</label>
                    <textarea name="konten" class="form-control" rows="10" required></textarea>
                </div>
                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
