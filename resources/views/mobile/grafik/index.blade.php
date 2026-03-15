@extends('mobile.layout.master')

@section('title', 'Grafik Pertumbuhan')

@push('styles')
<style>
    .content-body {
        padding: 0;
    }
    .grafik-header {
        background: var(--sigap-dark);
        padding: 24px 20px 48px;
        margin-bottom: -24px;
        border-radius: 0 0 28px 28px;
    }
    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
    }
    .child-card-select {
        background: white;
        border-radius: 20px;
        margin-bottom: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--sigap-border);
        text-decoration: none;
        color: inherit;
        display: block;
        transition: all 0.2s ease;
        overflow: hidden;
    }
    .child-card-select:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--sigap-primary);
    }
    .child-card-select.active {
        border-color: var(--sigap-primary);
        box-shadow: 0 0 0 3px rgba(46, 134, 171, 0.15);
    }
    .card-select-flex {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
    }
    .avatar-select {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1rem;
        color: white;
        flex-shrink: 0;
    }
    .avatar-select.l { background: linear-gradient(135deg, var(--sigap-primary), var(--sigap-primary-dark)); }
    .avatar-select.p { background: linear-gradient(135deg, var(--sigap-accent), #c0392b); }
    .child-select-info .name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--sigap-dark);
    }
    .child-select-info .meta {
        font-size: 0.75rem;
        color: var(--sigap-gray);
    }
    .indicator-tabs {
        display: flex;
        gap: 8px;
        background: white;
        padding: 8px;
        border-radius: 16px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--sigap-border);
    }
    .indicator-tab {
        flex: 1;
        padding: 12px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        color: var(--sigap-gray);
        transition: all 0.2s;
    }
    .indicator-tab:hover {
        background: var(--sigap-gray-light);
        color: var(--sigap-dark);
    }
    .indicator-tab.active {
        background: var(--sigap-primary);
        color: white;
        box-shadow: var(--shadow-md);
    }
    .chart-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--sigap-border);
        margin-bottom: 20px;
        position: relative;
    }
    .chart-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--sigap-primary), var(--sigap-secondary));
    }
    .chart-header-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--sigap-dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .chart-header-title i {
        color: var(--sigap-primary);
    }
    .chart-wrapper {
        position: relative;
        height: 280px;
    }
    .chart-legend-custom {
        display: flex;
        gap: 16px;
        margin-top: 16px;
        flex-wrap: wrap;
    }
    .legend-custom-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.7rem;
        color: var(--sigap-gray);
    }
    .legend-custom-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    .floating-info {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--sigap-gray-light);
        border-radius: 12px;
        padding: 10px 14px;
        z-index: 10;
    }
    .floating-info .label {
        font-size: 0.65rem;
        font-weight: 700;
        color: var(--sigap-gray);
        text-transform: uppercase;
    }
    .floating-info .value {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--sigap-primary);
    }
    .history-section {
        margin-top: 8px;
    }
    .history-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--sigap-dark);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .history-title i {
        color: var(--sigap-primary);
    }
    .history-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .history-item {
        background: white;
        border-radius: 16px;
        padding: 14px 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--sigap-border);
        display: grid;
        grid-template-columns: 1fr 1fr 0.8fr;
        align-items: center;
        gap: 12px;
        transition: all 0.2s;
    }
    .history-item:hover {
        transform: translateX(4px);
        border-color: var(--sigap-primary-light);
    }
    .history-date {
        display: flex;
        flex-direction: column;
    }
    .history-date .date {
        font-weight: 700;
        color: var(--sigap-dark);
        font-size: 0.85rem;
    }
    .history-date .age {
        font-size: 0.7rem;
        color: var(--sigap-gray);
        background: var(--sigap-gray-light);
        padding: 2px 8px;
        border-radius: 6px;
        display: inline-block;
        margin-top: 4px;
    }
    .history-measure {
        text-align: center;
    }
    .history-measure .value {
        font-weight: 700;
        color: var(--sigap-dark);
        font-size: 0.95rem;
    }
    .history-zscore {
        text-align: right;
    }
    .history-zscore .value {
        font-weight: 800;
        font-size: 0.95rem;
    }
    .history-zscore .value.normal { color: var(--sigap-secondary); }
    .history-zscore .value.warning { color: var(--sigap-warning); }
    .history-zscore .value.danger { color: var(--sigap-accent); }
    .empty-grafik {
        background: white;
        border-radius: 20px;
        padding: 50px 30px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--sigap-border);
        text-align: center;
    }
    .empty-grafik-icon {
        width: 80px;
        height: 80px;
        background: var(--sigap-gray-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .empty-grafik-icon i {
        font-size: 2rem;
        color: var(--sigap-gray);
    }
    .empty-grafik-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--sigap-dark);
        margin-bottom: 6px;
    }
    .empty-grafik-text {
        font-size: 0.85rem;
        color: var(--sigap-gray);
    }
    .stat-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }
    .stat-box {
        background: white;
        border-radius: 14px;
        padding: 14px 10px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--sigap-border);
    }
    .stat-box .icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-size: 0.9rem;
    }
    .stat-box .icon.blue { background: rgba(46, 134, 171, 0.1); color: var(--sigap-primary); }
    .stat-box .icon.green { background: rgba(87, 204, 153, 0.1); color: var(--sigap-secondary); }
    .stat-box .icon.orange { background: rgba(255, 179, 71, 0.1); color: var(--sigap-warning); }
    .stat-box .label {
        font-size: 0.65rem;
        font-weight: 700;
        color: var(--sigap-gray);
        text-transform: uppercase;
    }
    .stat-box .value {
        font-size: 1rem;
        font-weight: 800;
        color: var(--sigap-dark);
    }
</style>
@endpush


@section('content')
<div class="grafik-header">
    <h4 class="section-title text-white mb-1">
        Grafik Pertumbuhan
    </h4>
    <p class="user-meta mb-0 text-white opacity-75">Pantau tumbuh kembang anak Anda</p>
</div>

<div class="main-dashboard-content mt-5">
    
    @if($selectedAnak)
    <div class="stat-summary">
        <div class="stat-box">
            <div class="icon blue"><i class="fas fa-baby"></i></div>
            <div class="label">Umur</div>
            <div class="value">{{ $selectedAnak->umur_tahun }} th {{ $selectedAnak->umur_bulan }} bln</div>
        </div>
        <div class="stat-box">
            <div class="icon green"><i class="fas fa-weight"></i></div>
            <div class="label">BB</div>
            <div class="value">{{ $pemeriksaan->last()->berat_badan ?? '-' }} kg</div>
        </div>
        <div class="stat-box">
            <div class="icon orange"><i class="fas fa-ruler-vertical"></i></div>
            <div class="label">TB</div>
            <div class="value">{{ $pemeriksaan->last()->tinggi_badan ?? '-' }} cm</div>
        </div>
    </div>
    @endif

    <div class="child-selector-label mb-2" style="font-size: 0.75rem; font-weight: 700; color: var(--sigap-gray); text-transform: uppercase; letter-spacing: 0.5px;">Pilih Anak</div>
    <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
    @foreach($anak as $a)
    <a href="{{ route('mobile.grafik.index', ['anak_id' => $a->id, 'indikator' => $indikator]) }}" class="child-card-select {{ $selectedAnak && $selectedAnak->id == $a->id ? 'active' : '' }}">
        <div class="card-select-flex">
            <div class="avatar-select {{ strtolower($a->jenis_kelamin) }}">
                {{ substr($a->nama, 0, 1) }}
            </div>
            <div class="child-select-info">
                <div class="name">{{ $a->nama }}</div>
                <div class="meta">
                    {{ \Carbon\Carbon::parse($a->tanggal_lahir)->diffInMonths(now()) }} bulan • {{ $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </div>
            </div>
            @if($selectedAnak && $selectedAnak->id == $a->id)
            <i class="fas fa-check-circle text-primary ms-auto" style="font-size: 1.2rem;"></i>
            @endif
        </div>
    </a>
    @endforeach
    </div>

    @if($selectedAnak)
    <div class="indicator-tabs">
        <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'bb_u']) }}" class="indicator-tab {{ $indikator == 'bb_u' ? 'active' : '' }}">BB/U</a>
        <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'tb_u']) }}" class="indicator-tab {{ $indikator == 'tb_u' ? 'active' : '' }}">TB/U</a>
        <a href="{{ route('mobile.grafik.index', ['anak_id' => $selectedAnak->id, 'indikator' => 'bb_tb']) }}" class="indicator-tab {{ $indikator == 'bb_tb' ? 'active' : '' }}">BB/TB</a>
    </div>

    <div class="chart-card">
        <div class="chart-header-title">
            <i class="fas fa-chart-area"></i>
            @if($indikator == 'bb_u') Berat Badan / Umur
            @elseif($indikator == 'tb_u') Tinggi Badan / Umur
            @else Berat Badan / Tinggi
            @endif
        </div>
        <div class="chart-wrapper">
            <canvas id="growthChart"></canvas>
            @if($pemeriksaan->last())
            <div class="floating-info">
                <div class="label">Terakhir</div>
                <div class="value">
                    @php $lastPemeriksaan = $pemeriksaan->last(); @endphp
                    {{ $indikator == 'tb_u' ? $lastPemeriksaan->tinggi_badan.' kg' : $lastPemeriksaan->berat_badan.' kg' }}
                </div>
            </div>
            @endif
        </div>
        <div class="chart-legend-custom">
            <div class="legend-custom-item">
                <span class="legend-custom-dot" style="background: var(--sigap-primary);"></span>
                <span>{{ $selectedAnak->nama }}</span>
            </div>
            <div class="legend-custom-item">
                <span class="legend-custom-dot" style="background: var(--sigap-secondary);"></span>
                <span>Median</span>
            </div>
            <div class="legend-custom-item">
                <span class="legend-custom-dot" style="background: var(--sigap-warning);"></span>
                <span>Batas Normal</span>
            </div>
        </div>
    </div>

    <div class="history-section">
        <div class="history-title">
            <i class="fas fa-history"></i>
            Riwayat Pengukuran
        </div>
        <div class="history-list">
            @forelse($pemeriksaan->sortByDesc('tanggal_periksa') as $p)
            <div class="history-item">
                <div class="history-date">
                    <span class="date">{{ \Carbon\Carbon::parse($p->tanggal_periksa)->format('d M Y') }}</span>
                    <span class="age">{{ $p->umur_bulan }} bulan</span>
                </div>
                <div class="history-measure">
                    <span class="value">
                        @if($indikator == 'bb_u') {{ $p->berat_badan }} kg
                        @elseif($indikator == 'tb_u') {{ $p->tinggi_badan }} cm
                        @else {{ $p->berat_badan }} kg
                        @endif
                    </span>
                </div>
                <div class="history-zscore">
                    @php 
                        $zscore = $p->{$indikator.'_zscore'};
                        $zscoreClass = $zscore >= 2 || $zscore <= -2 ? 'danger' : ($zscore >= -1 && $zscore <= 1 ? 'normal' : 'warning');
                    @endphp
                    <span class="value {{ $zscoreClass }}">{{ number_format($zscore, 2) }}</span>
                </div>
            </div>
            @empty
            <div class="text-center py-4">
                <p class="user-meta">Belum ada riwayat pengukuran.</p>
            </div>
            @endforelse
        </div>
    </div>
    @else
    <div class="empty-grafik">
        <div class="empty-grafik-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <h5 class="empty-grafik-title">Pilih Anak</h5>
        <p class="empty-grafik-text">Pilih nama anak Anda di atas untuk melihat grafik pertumbuhannya.</p>
    </div>
    @endif

    <div style="height: 30px;"></div>
</div>

@if($selectedAnak && $pemeriksaan->count() > 0)
    @php
        $standarData = \App\Models\StandarWho::where('jenis_kelamin', $selectedAnak->jenis_kelamin)
            ->where('indikator', strtoupper($indikator))
            ->orderBy('umur_bulan', 'asc')
            ->get();
        $standarLabels = $standarData->pluck('umur_bulan');
        $medianData = $standarData->pluck('median');
        $sd2negData = $standarData->pluck('sd_minus2');
        $sd2posData = $standarData->pluck('sd_plus2');
    @endphp
@endif
@endsection

@push('scripts')
@if($selectedAnak && $pemeriksaan->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
$(document).ready(function() {
    const ctx = document.getElementById('growthChart').getContext('2d');
    const childLabels = {!! json_encode($pemeriksaan->pluck('umur_bulan')) !!};
    const childData = {!! json_encode($pemeriksaan->pluck($indikator == 'tb_u' ? 'tinggi_badan' : 'berat_badan')) !!};
    const standarLabels = {!! json_encode($standarLabels) !!};
    const medianData = {!! json_encode($medianData) !!};
    const sd2negData = {!! json_encode($sd2negData) !!};
    const sd2posData = {!! json_encode($sd2posData) !!};
    const indicatorLabel = "{{ $indikator == 'bb_u' ? 'Berat (kg)' : ($indikator == 'tb_u' ? 'Tinggi (cm)' : 'Berat (kg)') }}";

    const gradient = ctx.createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(46, 134, 171, 0.25)');
    gradient.addColorStop(1, 'rgba(46, 134, 171, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: standarLabels,
            datasets: [
            {
                label: 'Batas Atas',
                data: sd2posData,
                borderColor: 'rgba(255, 179, 71, 0.6)',
                borderWidth: 2,
                pointRadius: 0,
                borderDash: [6, 4],
                fill: false,
            },
            {
                label: 'Batas Bawah',
                data: sd2negData,
                borderColor: 'rgba(255, 179, 71, 0.6)',
                backgroundColor: 'rgba(87, 204, 153, 0.08)',
                borderWidth: 2,
                pointRadius: 0,
                borderDash: [6, 4],
                fill: '-1',
            },
            {
                label: 'Median',
                data: medianData,
                borderColor: 'rgba(87, 204, 153, 1)',
                borderWidth: 2.5,
                pointRadius: 0,
                fill: false,
                tension: 0.4,
            },
            {
                type: 'line',
                label: '{{ $selectedAnak->nama }}',
                data: childLabels.map((month, index) => ({x: month, y: childData[index]})),
                borderColor: '#2E86AB',
                backgroundColor: gradient,
                borderWidth: 3,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointBackgroundColor: '#2E86AB',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    padding: 12, 
                    cornerRadius: 10,
                    backgroundColor: 'rgba(26, 29, 46, 0.95)',
                    titleColor: '#fff', 
                    bodyColor: '#fff',
                    boxPadding: 5,
                    titleFont: { family: 'Plus Jakarta Sans', weight: 'bold' },
                    bodyFont: { family: 'Plus Jakarta Sans' }
                }
            },
            scales: {
                x: {
                    type: 'linear',
                    title: { display: true, text: 'Umur (Bulan)', font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 11 }, color: '#64748b' },
                    grid: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 10 }, color: '#64748b' }
                },
                y: {
                    title: { display: true, text: indicatorLabel, font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 11 }, color: '#64748b' },
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 10 }, color: '#64748b' }
                }
            }
        }
    });
});
</script>
@endif
@endpush
