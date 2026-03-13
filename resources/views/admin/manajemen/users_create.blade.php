@extends('admin.layout.master')

@section('title', 'Tambah User')

@section('content')
<div class="content-header">
    <h1>Tambah User</h1>
    <a href="{{ route('admin.manajemen.users') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.manajemen.users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">Pilih Role</option>
                        <option value="superadmin">Superadmin</option>
                        <option value="dokter">Dokter</option>
                        <option value="bidan">Bidan</option>
                        <option value="ahli_gizi">Ahli Gizi</option>
                        <option value="kader">Kader</option>
                        <option value="orangtua">Orang Tua</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
