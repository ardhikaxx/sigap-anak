@extends('admin.layout.master')

@section('title', 'Pemeriksaan')

@section('content')
<div class="content-header">
    <h1>Pemeriksaan</h1>
    <a href="{{ route('admin.pemeriksaan.create') }}" class="btn btn-primary">Tambah Pemeriksaan</a>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3>Daftar Pemeriksaan</h3>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Anak</th>
                        <th>Tanggal</th>
                        <th>Umur</th>
                        <th>Berat (kg)</th>
                        <th>Tinggi (cm)</th>
                        <th>LP</th>
                        <th>LILA</th>
                        <th> Suhu</th>
                        <th>Status Gizi</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemeriksaans as $index => $p)
                    <tr>
                        <td>{{ $pemeriksaans->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-primary text-white me-2">{{ substr($p->anak->nama ?? 'A', 0, 1) }}</div>
                                <div>
                                    <strong>{{ $p->anak->nama ?? '-' }}</strong>
                                    <br><small class="text-muted">{{ $p->anak->nik_anak ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_periksa)->format('d-m-Y') }}</td>
                        <td>{{ $p->umur_bulan }} bln</td>
                        <td>{{ $p->berat_badan ?? '-' }}</td>
                        <td>{{ $p->tinggi_badan ?? '-' }}</td>
                        <td>{{ $p->lingkar_kepala ?? '-' }}</td>
                        <td>{{ $p->lingkar_lengan ?? '-' }}</td>
                        <td>{{ $p->suhu_tubuh ? $p->suhu_tubuh . '°C' : '-' }}</td>
                        <td>
                            @if($p->status_gizi_akhir)
                            <span class="badge bg-{{ 
                                $p->status_gizi_akhir == 'normal' ? 'success' : 
                                ($p->status_gizi_akhir == 'gizi_buruk' || $p->status_gizi_akhir == 'wasting' ? 'danger' : 
                                ($p->status_gizi_akhir == 'stunting' || $p->status_gizi_akhir == 'underweight' ? 'warning' : 'primary'))
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $p->status_gizi_akhir)) }}
                            </span>
                            @else
                            <span class="badge bg-secondary">Belum Ada</span>
                            @endif
                        </td>
                        <td>{{ $p->nakes->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.pemeriksaan.show', $p->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3 d-block"></i>
                            <span class="text-muted">Tidak ada data pemeriksaan</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{ $pemeriksaans->links() }}
        </div>
    </div>
</div>
@endsection
