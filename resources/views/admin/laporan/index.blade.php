@extends('admin.layout.master')

@section('title', 'Laporan')

@section('content')
<div class="content-header">
    <h1>Laporan</h1>
</div>

<div class="content">
    <div class="card mb-4">
        <div class="card-header">
            <form method="GET" class="d-flex gap-2 align-items-center">
                <label>Filter:</label>
                <select name="tipe" class="form-control" style="width: auto;">
                    <option value="pemeriksaan" {{ $tipe == 'pemeriksaan' ? 'selected' : '' }}>Pemeriksaan</option>
                    <option value="pertumbuhan" {{ $tipe == 'pertumbuhan' ? 'selected' : '' }}>Pertumbuhan</option>
                    <option value="posyandu" {{ $tipe == 'posyandu' ? 'selected' : '' }}>Posyandu</option>
                    <option value="konsultasi" {{ $tipe == 'konsultasi' ? 'selected' : '' }}>Konsultasi</option>
                    <option value="gizi" {{ $tipe == 'gizi' ? 'selected' : '' }}>Status Gizi</option>
                </select>
                <select name="bulan" class="form-control" style="width: auto;">
                    @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->format('F') }}</option>
                    @endfor
                </select>
                <select name="tahun" class="form-control" style="width: auto;">
                    @for($i = 2023; $i <= 2026; $i++)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-primary">Tampilkan</button>
                <a href="{{ route('admin.laporan.export', ['tipe' => $tipe, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-success">Export PDF</a>
            </form>
        </div>
    </div>

    @if($tipe == 'pemeriksaan')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['total'] ?? 0 }}</h3>
                    <p>Total Pemeriksaan</p>
                </div>
            </div>
        </div>
        @if(isset($data['status_gizi']))
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>Status Gizi</h4></div>
                <div class="card-body">
                    @foreach($data['status_gizi'] as $status => $jumlah)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ ucfirst($status) }}</span>
                        <strong>{{ $jumlah }}</strong>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    @if($tipe == 'pertumbuhan')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['rerata_berat'] ?? 0 }} kg</h3>
                    <p>Rata-rata Berat Badan</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['rerata_tinggi'] ?? 0 }} cm</h3>
                    <p>Rata-rata Tinggi Badan</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($tipe == 'posyandu')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['total_jadwal'] ?? 0 }}</h3>
                    <p>Total Jadwal</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['total_hadir'] ?? 0 }}</h3>
                    <p>Total Kehadiran</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($tipe == 'konsultasi')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['total'] ?? 0 }}</h3>
                    <p>Total Konsultasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['selesai'] ?? 0 }}</h3>
                    <p>Selesai</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['rating_rata'] ?? 0 }}/5</h3>
                    <p>Rating Rata-rata</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($tipe == 'gizi')
    <div class="card">
        <div class="card-header"><h4>Distribusi Status Gizi</h4></div>
        <div class="card-body">
            @if(isset($data['status']))
            @foreach($data['status'] as $status => $jumlah)
            <div class="d-flex justify-content-between mb-2">
                <span>{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                <strong>{{ $jumlah }} ({{ round($jumlah / max($data['total'], 1) * 100, 1) }}%)</strong>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
