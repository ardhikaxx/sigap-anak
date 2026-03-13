@extends('admin.layout.master')

@section('title', 'Detail User')

@section('content')
<div class="content-header">
    <h1>{{ $user->name }}</h1>
    <a href="{{ route('admin.manajemen.users') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Informasi User</h4></div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
                    <p><strong>Role:</strong> {{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                    <p><strong>Status:</strong> {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</p>
                </div>
            </div>
        </div>
        @if($user->nakesProfile)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Profil Nakes</h4></div>
                <div class="card-body">
                    <p><strong>NIP:</strong> {{ $user->nakesProfile->nip }}</p>
                    <p><strong>STR:</strong> {{ $user->nakesProfile->str_number }}</p>
                    <p><strong>Spesialisasi:</strong> {{ $user->nakesProfile->spesialisasi }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
