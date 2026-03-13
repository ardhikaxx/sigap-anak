@extends('admin.layout.master')

@php
use Illuminate\Support\Str;
@endphp

@section('title', 'Konsultasi')

@section('content')
<div class="content-header">
    <h1>Konsultasi</h1>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Topik</th>
                        <th>Nama Anak</th>
                        <th>Orang Tua</th>
                        <th>Nakes</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Rating</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konsultasis as $index => $konsultasi)
                    <tr>
                        <td>{{ $konsultasis->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $konsultasi->topik }}</strong>
                            <br><small class="text-muted">{{ Str::limit($konsultasi->pertanyaan, 40) }}</small>
                        </td>
                        <td>{{ $konsultasi->anak->nama ?? '-' }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-secondary text-white me-2">{{ substr($konsultasi->orangtua->name ?? 'O', 0, 1) }}</div>
                                {{ $konsultasi->orangtua->name ?? '-' }}
                            </div>
                        </td>
                        <td>{{ $konsultasi->nakes->name ?? '-' }}</td>
                        <td>{{ $konsultasi->created_at->format('d-m-Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $konsultasi->status === 'menunggu' ? 'warning' : ($konsultasi->status === 'selesai' ? 'success' : 'info') }}">
                                {{ ucfirst($konsultasi->status) }}
                            </span>
                        </td>
                        <td>
                            @if($konsultasi->rating)
                            <span class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $konsultasi->rating ? '' : '-o' }}"></i>
                                @endfor
                            </span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.konsultasi.show', $konsultasi->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <i class="fas fa-comments fa-3x text-muted mb-3 d-block"></i>
                            <span class="text-muted">Tidak ada data konsultasi</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{ $konsultasis->links() }}
        </div>
    </div>
</div>
@endsection
