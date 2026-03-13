@extends('admin.layout.master')

@section('title', 'Edit User')

@section('content')
<div class="content-header">
    <h1>Edit User</h1>
    <a href="{{ route('admin.manajemen.users') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.manajemen.users.update', $user->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                        <option value="dokter" {{ $user->role == 'dokter' ? 'selected' : '' }}>Dokter</option>
                        <option value="bidan" {{ $user->role == 'bidan' ? 'selected' : '' }}>Bidan</option>
                        <option value="ahli_gizi" {{ $user->role == 'ahli_gizi' ? 'selected' : '' }}>Ahli Gizi</option>
                        <option value="kader" {{ $user->role == 'kader' ? 'selected' : '' }}>Kader</option>
                        <option value="orangtua" {{ $user->role == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control" minlength="6">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}> Aktif
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </form>
        </div>
    </div>
</div>
@endsection
