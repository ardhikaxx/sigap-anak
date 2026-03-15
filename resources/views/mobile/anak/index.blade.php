@extends('mobile.layout.master')

@section('title', 'Data Anak Saya')

@push('styles')
<style>
    .content-body {
        padding: 0;
    }
    .data-anak-header {
        background: var(--sigap-dark);
        padding: 24px 20px 48px;
        margin-bottom: -24px;
        border-radius: 0 0 28px 28px;
    }
    .child-card-premium {
        background: white;
        border-radius: 24px;
        margin-bottom: 16px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--sigap-border);
        text-decoration: none;
        color: inherit;
        display: block;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
    }
    .child-card-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, var(--sigap-primary), var(--sigap-secondary));
        opacity: 0;
        transition: opacity 0.3s;
    }
    .child-card-premium:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 20px 40px rgba(46, 134, 171, 0.15);
        border-color: var(--sigap-primary-light);
    }
    .child-card-premium:hover::before {
        opacity: 1;
    }
    .card-header-flex {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px;
    }
    .avatar-premium {
        width: 60px;
        height: 60px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.4rem;
        color: white;
        flex-shrink: 0;
        position: relative;
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
    .avatar-premium::after {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 24px;
        border: 2px solid transparent;
        background: linear-gradient(135deg, var(--sigap-primary), var(--sigap-secondary)) border-box;
        -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .child-card-premium:hover .avatar-premium::after {
        opacity: 1;
    }
    .avatar-premium.l { 
        background: linear-gradient(135deg, #2E86AB, #1A5F7A); 
    }
    .avatar-premium.p { 
        background: linear-gradient(135deg, #FF6B6B, #c0392b); 
    }
    .avatar-premium .avatar-icon {
        position: absolute;
        bottom: -4px;
        right: -4px;
        width: 22px;
        height: 22px;
        border-radius: 8px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .avatar-premium.l .avatar-icon { color: var(--sigap-primary); }
    .avatar-premium.p .avatar-icon { color: var(--sigap-accent); }
    .child-info {
        flex: 1;
    }
    .child-info .name {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--sigap-dark);
        margin-bottom: 4px;
    }
    .child-info .meta {
        font-size: 0.8rem;
        color: var(--sigap-gray);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .child-info .meta .age-badge {
        background: var(--sigap-gray-light);
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: 600;
    }
    .card-stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1px;
        background: var(--sigap-gray-light);
        padding: 1px;
        border-top: 1px solid var(--sigap-border);
        border-bottom: 1px solid var(--sigap-border);
    }
    .stat-block {
        background: white;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .stat-block .stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }
    .stat-block .stat-icon.berat { 
        background: rgba(46, 134, 171, 0.1); 
        color: var(--sigap-primary); 
    }
    .stat-block .stat-icon.tinggi { 
        background: rgba(87, 204, 153, 0.1); 
        color: var(--sigap-secondary); 
    }
    .stat-block .stat-content {
        flex: 1;
    }
    .stat-block .label {
        font-size: 0.65rem;
        font-weight: 700;
        color: var(--sigap-gray);
        text-transform: uppercase;
        margin-bottom: 2px;
    }
    .stat-block .value {
        font-size: 1rem;
        font-weight: 800;
        color: var(--sigap-dark);
    }
    .card-footer-status {
        padding: 14px 18px;
    }
    .status-badge-custom {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 700;
    }
    .status-badge-custom.normal { 
        background: rgba(87, 204, 153, 0.15); 
        color: #38A169; 
    }
    .status-badge-custom.warning { 
        background: rgba(255, 179, 71, 0.15); 
        color: #e67e22; 
    }
    .status-badge-custom.danger { 
        background: rgba(255, 107, 107, 0.15); 
        color: #e53e3e; 
    }
    .status-badge-custom.default { 
        background: var(--sigap-gray-light); 
        color: var(--sigap-gray); 
    }
    .status-badge-custom i {
        font-size: 0.85rem;
    }
</style>
@endpush


@section('content')
<div class="data-anak-header">
    <h4 class="section-title text-white mb-1">
        Data Anak
    </h4>
    <p class="user-meta mb-0 text-white opacity-75">{{ $anaks->count() }} anak terdaftar</p>
</div>

<div class="main-dashboard-content mt-5">
    @forelse($anaks as $anak)
    <a href="{{ route('mobile.anak.show', $anak->id) }}" class="child-card-premium">
        <div class="card-header-flex">
            <div class="avatar-premium {{ strtolower($anak->jenis_kelamin) }}">
                {{ substr($anak->nama, 0, 1) }}
                <div class="avatar-icon">
                    <i class="fas fa-{{ $anak->jenis_kelamin == 'L' ? 'mars' : 'venus' }}"></i>
                </div>
            </div>
            <div class="child-info">
                <div class="name">{{ $anak->nama }}</div>
                <div class="meta">
                    <span class="age-badge">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bln</span>
                    <span>{{ $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
            </div>
        </div>
        
        @if($anak->latestPemeriksaan)
        <div class="card-stats-grid">
            <div class="stat-block">
                <div class="stat-icon berat">
                    <i class="fas fa-weight"></i>
                </div>
                <div class="stat-content">
                    <div class="label">Berat Badan</div>
                    <div class="value">{{ $anak->latestPemeriksaan->berat_badan }} kg</div>
                </div>
            </div>
            <div class="stat-block">
                <div class="stat-icon tinggi">
                    <i class="fas fa-ruler-vertical"></i>
                </div>
                <div class="stat-content">
                    <div class="label">Tinggi Badan</div>
                    <div class="value">{{ $anak->latestPemeriksaan->tinggi_badan }} cm</div>
                </div>
            </div>
        </div>
        @endif
        
        <div class="card-footer-status">
            @php
                $status = optional($anak->latestPemeriksaan)->status_gizi_akhir ?? 'belum_diperiksa';
                $badgeClass = match($status) {
                    'normal' => 'normal',
                    'gizi_buruk', 'wasting', 'stunting' => 'danger',
                    'underweight' => 'warning',
                    default => 'default'
                };
                $statusIcon = match($status) {
                    'normal' => 'fa-check-circle',
                    'gizi_buruk', 'wasting', 'stunting' => 'fa-exclamation-circle',
                    'underweight' => 'fa-exclamation-triangle',
                    default => 'fa-clock'
                };
            @endphp
            <div class="status-badge-custom {{ $badgeClass }}">
                <i class="fas {{ $statusIcon }}"></i>
                {{ ucfirst(str_replace('_', ' ', $status)) }}
            </div>
        </div>
    </a>
    @empty
    <div class="empty-state py-5 mt-4 card-custom border-dashed">
        <div class="empty-icon shadow-none" style="background: var(--sigap-gray-light);"><i class="fas fa-child"></i></div>
        <h5 class="empty-title">Tidak ada data anak</h5>
        <p class="empty-text px-4">Silakan hubungi tenaga kesehatan untuk mendaftarkan anak Anda ke sistem</p>
    </div>
    @endforelse

    <div class="card-custom bg-glass mt-4 p-4 text-center border-0 shadow-sm" style="background: linear-gradient(135deg, rgba(46, 134, 171, 0.05), rgba(87, 204, 153, 0.05));">
        <p class="user-meta mb-0">Butuh bantuan pendaftaran atau koreksi data? <br> <a href="{{ route('mobile.konsultasi.index') }}" class="text-primary fw-bold text-decoration-none">Hubungi Petugas Kesehatan</a></p>
    </div>

    <div style="height: 30px;"></div>
</div>
@endsection
