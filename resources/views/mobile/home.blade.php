@extends('mobile.layout.master')

@section('title', 'Beranda')

@push('styles')
<style>
    .content-body {
        padding: 0;
        background: #fcfdff;
    }
    .hero-header {
        background: radial-gradient(at 0% 0%, #2E86AB 0, transparent 50%), 
                    radial-gradient(at 50% 0%, #57CC99 0, transparent 50%), 
                    radial-gradient(at 100% 0%, #1A5F7A 0, transparent 50%);
        background-color: var(--sigap-dark);
        padding: 30px 20px 80px;
        border-radius: 0 0 35px 35px;
        color: white;
    }
    .greeting-text {
        font-weight: 500;
        color: #FFFFFF;
        font-size: 1rem;
        opacity: 0.9;
    }
    .user-name {
        font-weight: 800;
        color: #FFFFFF;
        font-size: 1.8rem;
        letter-spacing: -0.5px;
    }
    .main-dashboard-content {
        margin-top: -60px;
        padding: 0 15px;
    }
    .glass-stat-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 24px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.07);
        text-align: center;
    }
    .glass-stat-card .value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--sigap-dark);
    }
    .glass-stat-card .label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--sigap-gray);
    }
    .section-title-modern {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--sigap-dark);
        margin-bottom: 12px;
        padding: 0 5px;
    }
    .action-app-card {
        background: white;
        border-radius: 18px;
        padding: 18px 15px;
        text-align: center;
        text-decoration: none;
        color: var(--sigap-dark);
        border: 1px solid var(--sigap-border);
        transition: all 0.2s;
        display: block;
    }
    .action-app-card:hover {
        border-color: var(--sigap-primary);
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        color: var(--sigap-primary);
    }
    .action-app-card i {
        font-size: 20px;
        margin-bottom: 8px;
        display: block;
    }
    .chart-legend {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }
    .chart-legend li {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 3px;
    }
    .schedule-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid var(--sigap-border);
    }
    .schedule-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .schedule-item:first-child {
        padding-top: 0;
    }
    .schedule-date-block {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: var(--sigap-primary-light);
        border-radius: 18px;
        width: 65px;
        flex-shrink: 0;
        color: var(--sigap-primary);
        font-weight: 800;
    }
    .schedule-date-block .day {
        font-size: 1.8rem;
        line-height: 1;
    }
    .schedule-date-block .month {
        font-size: 0.8rem;
        text-transform: uppercase;
    }
    .schedule-details .title {
        font-weight: 700;
        color: var(--sigap-dark);
        margin-bottom: 8px;
    }
    .schedule-details .meta {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        font-size: 0.8rem;
        color: var(--sigap-gray);
    }
    .schedule-details .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>
@endpush

@section('content')
<div class="hero-header">
    <div class="greeting-text">{{ $greeting }}</div>
    <h1 class="user-name">{{ $user->name }}</h1>
</div>

<div class="main-dashboard-content">
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="glass-stat-card">
                <div class="value">{{ $anak->count() }}</div>
                <div class="label">Anak</div>
            </div>
        </div>
        <div class="col-4">
            <div class="glass-stat-card">
                <div class="value">{{ $jadwalMendatang->count() }}</div>
                <div class="label">Jadwal</div>
            </div>
        </div>
        <div class="col-4">
            <div class="glass-stat-card">
                <div class="value">{{ $anak->filter(function($a) { return optional($a->latestPemeriksaan)->status_gizi_akhir != 'normal'; })->count() }}</div>
                <div class="label">Berisiko</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6">
            <a href="{{ route('mobile.anak.index') }}" class="action-app-card">
                <i class="fas fa-child text-primary"></i>
                <span class="small fw-bold">Data Anak</span>
            </a>
        </div>
        <div class="col-6">
             <a href="{{ route('mobile.grafik.index') }}" class="action-app-card">
                <i class="fas fa-chart-line text-success"></i>
                <span class="small fw-bold">Grafik</span>
            </a>
        </div>
        <div class="col-6">
            <a href="{{ route('mobile.konsultasi.index') }}" class="action-app-card">
                <i class="fas fa-comments text-warning"></i>
                <span class="small fw-bold">Konsultasi</span>
            </a>
        </div>
        <div class="col-6">
            <a href="#" class="action-app-card">
                <i class="fas fa-book-open-reader text-info"></i>
                <span class="small fw-bold">Edukasi</span>
            </a>
        </div>
    </div>

    @if($anak->count() > 0)
    <div class="card-custom border-0 shadow-sm mb-4">
        <div class="card-body-custom text-center">
            <h5 class="section-title-modern mx-0 mb-3">Ringkasan Gizi Anak</h5>
            <div style="height: 180px; position: relative;">
                <canvas id="statusGiziChart"></canvas>
            </div>
            @php
                $statusGizi = $anak->map(function ($a) {
                    return optional($a->latestPemeriksaan)->status_gizi_akhir ?? 'belum_diperiksa';
                })->countBy();
            @endphp
            <ul class="chart-legend mt-3">
                @foreach($statusGizi as $status => $jumlah)
                <li>
                    <span class="legend-dot" style="background-color: @if($status == 'normal') #22c55e @elseif(in_array($status, ['gizi_buruk', 'wasting', 'stunting'])) #ef4444 @elseif($status == 'belum_diperiksa') #9ca3af @else #f59e0b @endif;"></span>
                    <span class="text-capitalize">{{ str_replace('_', ' ', $status) }} ({{$jumlah}})</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    @if($jadwalMendatang->count() > 0)
    <div class="card-custom border-0 shadow-sm mb-4">
        <div class="card-header-custom">
            <h5 class="section-title-modern mx-0 mb-0">Jadwal Terdekat</h5>
        </div>
        <div class="card-body-custom">
            @foreach($jadwalMendatang->take(2) as $jadwal)
            <div class="schedule-item">
                <div class="schedule-date-block">
                    <span class="day">{{ $jadwal->tanggal->format('d') }}</span>
                    <span class="month">{{ $jadwal->tanggal->format('M') }}</span>
                </div>
                <div class="schedule-details">
                    <div class="title">{{ $jadwal->tema ?? 'Layanan Posyandu' }}</div>
                    <div class="meta">
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $jadwal->lokasi ?? $jadwal->faskes->nama }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <div style="height: 30px;"></div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
$(document).ready(function() {
    @if($anak->count() > 0)
    const statusGiziData = {!! json_encode($statusGizi) !!};
    const ctx = document.getElementById('statusGiziChart').getContext('2d');
    
    const labels = Object.keys(statusGiziData).map(key => key.charAt(0).toUpperCase() + key.slice(1).replace('_', ' '));
    const data = Object.values(statusGiziData);
    const colors = Object.keys(statusGiziData).map(key => {
        if (key === 'normal') return '#22c55e';
        if (key === 'gizi_buruk' || key === 'wasting' || key === 'stunting') return '#ef4444';
        if (key === 'belum_diperiksa') return '#9ca3af';
        return '#f59e0b';
    });

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
                borderColor: '#fcfdff',
                borderWidth: 4,
                hoverOffset: 15,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    padding: 10,
                    cornerRadius: 10,
                }
            },
        }
    });
    @endif
});
</script>
@endpush
