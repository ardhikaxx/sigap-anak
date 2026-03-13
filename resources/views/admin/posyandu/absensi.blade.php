@extends('admin.layout.master')

@section('title', 'Absensi Posyandu')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Absensi Posyandu</h1>
        <a href="{{ route('admin.posyandu.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="content">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i>
                {{ $jadwal->tema ?? 'Posyandu' }}
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-1"><strong>Tanggal:</strong></p>
                    <p>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong>Jam:</strong></p>
                    <p>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong>Posyandu:</strong></p>
                    <p>{{ $jadwal->faskes->nama ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Hadir Anak</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.posyandu.absensi.store', $jadwal->id) }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Anak</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Usia</th>
                                <th width="100" class="text-center">Hadir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anakTerdaftar as $index => $anak)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white me-2">{{ substr($anak->nama, 0, 1) }}</div>
                                        <strong>{{ $anak->nama }}</strong>
                                    </div>
                                </td>
                                <td>{{ $anak->nik_anak ?? '-' }}</td>
                                <td>{{ $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bln</td>
                                <td class="text-center">
                                    <div class="form-check d-inline-block">
                                        <input type="checkbox" 
                                               name="kehadiran[{{ $anak->id }}]" 
                                               value="1" 
                                               class="form-check-input" 
                                               id="hadir_{{ $anak->id }}"
                                               {{ isset($kehadiran[$anak->id]) && $kehadiran[$anak->id] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hadir_{{ $anak->id }}"></label>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-child fa-3x text-muted mb-3 d-block"></i>
                                    <span class="text-muted">Tidak ada anak terdaftar di posyandu ini</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($anakTerdaftar->count() > 0)
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Kehadiran
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
