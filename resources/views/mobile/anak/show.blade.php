@extends('mobile.layout.master')

@section('title', 'Profil ' . $anak->nama)

@php
$latestPemeriksaan = $pemeriksaan->first();
@endphp

@push('styles')
<style>
    .profil-header {
        background: var(--sigap-dark);
        padding: 20px 20px 50px;
        margin: -15px -15px 0;
        border-radius: 0 0 28px 28px;
    }
    .back-btn {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.2s;
    }
    .back-btn:hover {
        background: rgba(255,255,255,0.2);
        color: white;
    }
    .avatar-profil {
        width: 100px;
        height: 100px;
        border-radius: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 2.5rem;
        color: white;
        margin: 0 auto 16px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        border: 4px solid rgba(255,255,255,0.3);
    }
    .avatar-profil.l { background: linear-gradient(135deg, var(--sigap-primary), var(--sigap-primary-dark)); }
    .avatar-profil.p { background: linear-gradient(135deg, var(--sigap-accent), #c0392b); }
    .profil-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 8px;
    }
    .profil-badges {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .profil-badge {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .stat-cards-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: -30px;
        padding: 0 15px;
    }
    .stat-card {
        background: white;
        border-radius: 18px;
        padding: 16px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--sigap-border);
        text-align: center;
    }
    .stat-card .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 1rem;
    }
    .stat-card .stat-icon.berat { background: rgba(46, 134, 171, 0.1); color: var(--sigap-primary); }
    .stat-card .stat-icon.tinggi { background: rgba(87, 204, 153, 0.1); color: var(--sigap-secondary); }
    .stat-card .label {
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--sigap-gray);
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .stat-card .value {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--sigap-dark);
    }
    .stat-card .unit {
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--sigap-gray);
    }
    .status-gizi-card {
        background: white;
        border-radius: 18px;
        padding: 20px;
        margin: 20px 15px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--sigap-border);
        position: relative;
        overflow: hidden;
    }
    .status-gizi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--sigap-primary), var(--sigap-secondary));
    }
    .status-gizi-card .card-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--sigap-dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .status-gizi-card .card-title i {
        color: var(--sigap-accent);
    }
    .status-badge-large {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 24px;
        border-radius: 14px;
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .status-badge-large.normal { background: rgba(87, 204, 153, 0.15); color: #38A169; }
    .status-badge-large.warning { background: rgba(255, 179, 71, 0.15); color: #e67e22; }
    .status-badge-large.danger { background: rgba(255, 107, 107, 0.15); color: #e53e3e; }
    .status-gizi-card .tanggal-periksa {
        font-size: 0.75rem;
        color: var(--sigap-gray);
    }
    .empty-status {
        text-align: center;
        padding: 20px;
    }
    .empty-status-icon {
        width: 60px;
        height: 60px;
        background: var(--sigap-gray-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }
    .empty-status-icon i {
        font-size: 1.5rem;
        color: var(--sigap-gray);
    }
    .menu-section-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--sigap-dark);
        margin: 0 15px 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .menu-section-title i {
        color: var(--sigap-primary);
    }
    .menu-container {
        padding: 0 15px;
        margin-bottom: 20px;
    }
    .menu-card {
        background: white;
        border-radius: 20px;
        padding: 8px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--sigap-border);
    }
    .menu-item {
        background: var(--sigap-gray-light);
        border-radius: 16px;
        padding: 16px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 8px;
        position: relative;
        overflow: hidden;
    }
    .menu-item:last-child {
        margin-bottom: 0;
    }
    .menu-item:hover {
        transform: translateX(8px);
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .menu-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--sigap-primary);
        border-radius: 0 4px 4px 0;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .menu-item:hover::before {
        opacity: 1;
    }
    .menu-item .menu-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: transform 0.3s;
    }
    .menu-item:hover .menu-icon {
        transform: scale(1.1) rotate(5deg);
    }
    .menu-item .menu-icon.grafik { background: linear-gradient(135deg, #2E86AB, #1A5F7A); }
    .menu-item .menu-icon.konsultasi { background: linear-gradient(135deg, #FFB347, #e67e22); }
    .menu-item .menu-icon.imunisasi { background: linear-gradient(135deg, #57CC99, #38A169); }
    .menu-item .menu-icon.gizi { background: linear-gradient(135deg, #74C0FC, #4a90d9); }
    .menu-item .menu-text {
        flex: 1;
    }
    .menu-item .menu-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--sigap-dark);
        margin-bottom: 2px;
    }
    .menu-item .menu-subtitle {
        font-size: 0.7rem;
        color: var(--sigap-gray);
        font-weight: 500;
    }
    .menu-item .menu-arrow {
        width: 32px;
        height: 32px;
        background: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--sigap-gray);
        font-size: 0.8rem;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .menu-item:hover .menu-arrow {
        transform: translateX(4px);
        background: var(--sigap-primary);
        color: white;
    }
    .quick-stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        padding: 0 15px;
        margin-bottom: 20px;
    }
    .quick-stat {
        background: white;
        border-radius: 14px;
        padding: 12px 8px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--sigap-border);
    }
    .quick-stat .qs-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-size: 0.9rem;
    }
    .quick-stat .qs-icon.berat { background: rgba(46, 134, 171, 0.1); color: var(--sigap-primary); }
    .quick-stat .qs-icon.tinggi { background: rgba(87, 204, 153, 0.1); color: var(--sigap-secondary); }
    .quick-stat .qs-icon.lingkar { background: rgba(255, 179, 71, 0.1); color: var(--sigap-warning); }
    .quick-stat .qs-icon.suhu { background: rgba(255, 107, 107, 0.1); color: var(--sigap-accent); }
    .quick-stat .qs-label {
        font-size: 0.6rem;
        font-weight: 700;
        color: var(--sigap-gray);
        text-transform: uppercase;
    }
    .quick-stat .qs-value {
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--sigap-dark);
    }
    .info-card {
        background: white;
        border-radius: 18px;
        margin: 0 15px 20px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--sigap-border);
        overflow: hidden;
    }
    .info-card .info-header {
        background: var(--sigap-gray-light);
        padding: 14px 18px;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--sigap-dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .info-card .info-header i {
        color: var(--sigap-primary);
    }
    .info-card .info-row {
        display: flex;
        align-items: center;
        padding: 14px 18px;
        border-bottom: 1px solid var(--sigap-gray-light);
    }
    .info-card .info-row:last-child {
        border-bottom: none;
    }
    .info-card .info-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .info-card .info-icon.nik { background: rgba(46, 134, 171, 0.1); color: var(--sigap-primary); }
    .info-card .info-icon.faskes { background: rgba(87, 204, 153, 0.1); color: var(--sigap-secondary); }
    .info-card .info-icon.lahir { background: rgba(255, 107, 107, 0.1); color: var(--sigap-accent); }
    .info-card .info-icon.darah { background: rgba(155, 89, 182, 0.1); color: var(--sigap-purple); }
    .info-card .info-content {
        flex: 1;
    }
    .info-card .info-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--sigap-gray);
        text-transform: uppercase;
        margin-bottom: 2px;
    }
    .info-card .info-value {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--sigap-dark);
    }
</style>
@endpush


@section('content')
<div class="profil-header">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('mobile.anak.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <span class="text-white opacity-75" style="font-size: 0.85rem;">Profil Anak</span>
        <div style="width: 40px;"></div>
    </div>
    
    <div class="text-center">
        <div class="avatar-profil {{ strtolower($anak->jenis_kelamin) }}">
            {{ substr($anak->nama, 0, 1) }}
        </div>
        <h1 class="profil-name">{{ $anak->nama }}</h1>
        <div class="profil-badges">
            <span class="profil-badge">
                <i class="fas fa-{{ $anak->jenis_kelamin == 'L' ? 'mars' : 'venus' }}"></i>
                {{ $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
            </span>
            <span class="profil-badge">
                <i class="fas fa-birthday-cake"></i>
                {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bulan
            </span>
        </div>
    </div>
</div>

<div class="stat-cards-row">
    <div class="stat-card">
        <div class="stat-icon berat">
            <i class="fas fa-weight"></i>
        </div>
        <div class="label">Berat Badan</div>
        <div class="value">{{ $latestPemeriksaan->berat_badan ?? '-' }} <span class="unit">kg</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon tinggi">
            <i class="fas fa-ruler-vertical"></i>
        </div>
        <div class="label">Tinggi Badan</div>
        <div class="value">{{ $latestPemeriksaan->tinggi_badan ?? '-' }} <span class="unit">cm</span></div>
    </div>
</div>

<div class="status-gizi-card">
    <div class="card-title">
        <i class="fas fa-heartbeat"></i>
        Status Gizi Terbaru
    </div>
    @if($latestPemeriksaan && $latestPemeriksaan->status_gizi_akhir)
        @php
            $statusClass = match($latestPemeriksaan->status_gizi_akhir) {
                'normal' => 'normal',
                'gizi_buruk', 'wasting', 'stunting' => 'danger',
                default => 'warning'
            };
        @endphp
        <div class="status-badge-large {{ $statusClass }}">
            {{ ucfirst(str_replace('_', ' ', $latestPemeriksaan->status_gizi_akhir)) }}
        </div>
        <div class="tanggal-periksa">
            Diperiksa pada {{ \Carbon\Carbon::parse($latestPemeriksaan->tanggal_periksa)->format('d M Y') }}
        </div>
    @else
        <div class="empty-status">
            <div class="empty-status-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <p class="mb-0" style="font-size: 0.85rem; color: var(--sigap-gray);">Belum ada data pemeriksaan</p>
        </div>
    @endif
</div>

<div class="menu-section-title">
    <i class="fas fa-th-large"></i>
    Menu Anak
</div>

<div class="quick-stats-row">
    <div class="quick-stat">
        <div class="qs-icon berat">
            <i class="fas fa-weight"></i>
        </div>
        <div class="qs-label">BB</div>
        <div class="qs-value">{{ $latestPemeriksaan->berat_badan ?? '-' }} kg</div>
    </div>
    <div class="quick-stat">
        <div class="qs-icon tinggi">
            <i class="fas fa-ruler-vertical"></i>
        </div>
        <div class="qs-label">TB</div>
        <div class="qs-value">{{ $latestPemeriksaan->tinggi_badan ?? '-' }} cm</div>
    </div>
    <div class="quick-stat">
        <div class="qs-icon lingkar">
            <i class="fas fa-ruler"></i>
        </div>
        <div class="qs-label">LK</div>
        <div class="qs-value">{{ $latestPemeriksaan->lingkar_kepala ?? '-' }} cm</div>
    </div>
    <div class="quick-stat">
        <div class="qs-icon suhu">
            <i class="fas fa-thermometer-half"></i>
        </div>
        <div class="qs-label">Suhu</div>
        <div class="qs-value">{{ $latestPemeriksaan->suhu ?? '-' }}°C</div>
    </div>
</div>

<div class="menu-container">
    <div class="menu-card">
        <a href="{{ route('mobile.grafik.index', ['anak' => $anak->id]) }}" class="menu-item">
            <div class="menu-icon grafik">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="menu-text">
                <div class="menu-title">Grafik Pertumbuhan</div>
                <div class="menu-subtitle">Lihat grafik tumbuh kembang anak</div>
            </div>
            <div class="menu-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        <a href="{{ route('mobile.konsultasi.create', ['anak' => $anak->id]) }}" class="menu-item">
            <div class="menu-icon konsultasi">
                <i class="fas fa-comments"></i>
            </div>
            <div class="menu-text">
                <div class="menu-title">Konsultasi</div>
                <div class="menu-subtitle">Tanya langsung ke tenaga kesehatan</div>
            </div>
            <div class="menu-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon imunisasi">
                <i class="fas fa-syringe"></i>
            </div>
            <div class="menu-text">
                <div class="menu-title">Imunisasi</div>
                <div class="menu-subtitle">Riwayat vaksin anak</div>
            </div>
            <div class="menu-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon gizi">
                <i class="fas fa-utensils"></i>
            </div>
            <div class="menu-text">
                <div class="menu-title">Nutrisi & Makanan</div>
                <div class="menu-subtitle">Pola makan sehat anak</div>
            </div>
            <div class="menu-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
    </div>
</div>

<div class="info-card">
    <div class="info-header">
        <i class="fas fa-info-circle"></i>
        Informasi Anak
    </div>
    <div class="info-row">
        <div class="info-icon nik">
            <i class="fas fa-id-card"></i>
        </div>
        <div class="info-content">
            <div class="info-label">NIK Anak</div>
            <div class="info-value">{{ $anak->nik_anak ?? '-' }}</div>
        </div>
    </div>
    <div class="info-row">
        <div class="info-icon faskes">
            <i class="fas fa-hospital"></i>
        </div>
        <div class="info-content">
            <div class="info-label">Puskesmas / Faskes</div>
            <div class="info-value">{{ $anak->faskes->nama ?? '-' }}</div>
        </div>
    </div>
    <div class="info-row">
        <div class="info-icon lahir">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="info-content">
            <div class="info-label">Tanggal Lahir</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') }}</div>
        </div>
    </div>
    <div class="info-row">
        <div class="info-icon darah">
            <i class="fas fa-tint"></i>
        </div>
        <div class="info-content">
            <div class="info-label">Golongan Darah</div>
            <div class="info-value">{{ $anak->golongan_darah ?? '-' }}</div>
        </div>
    </div>
</div>

<div style="height: 30px;"></div>
@endsection
