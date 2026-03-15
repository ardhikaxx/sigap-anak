@extends('mobile.layout.master')

@section('title', 'Profil Saya')

@push('styles')
<style>
    .profil-header {
        background: var(--sigap-dark);
        padding: 24px 20px 60px;
        margin: -15px -15px 0;
        border-radius: 0 0 28px 28px;
        position: relative;
        overflow: hidden;
    }
    .profil-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(46, 134, 171, 0.3) 0%, transparent 70%);
        border-radius: 50%;
    }
    .profil-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(87, 204, 153, 0.2) 0%, transparent 70%);
        border-radius: 50%;
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
        position: relative;
        z-index: 1;
    }
    .back-btn:hover {
        background: rgba(255,255,255,0.2);
        color: white;
    }
    .avatar-profil {
        width: 110px;
        height: 110px;
        border-radius: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 2.8rem;
        color: white;
        margin: 0 auto 16px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        border: 4px solid rgba(255,255,255,0.3);
        position: relative;
        z-index: 1;
        background: linear-gradient(135deg, var(--sigap-primary), var(--sigap-primary-dark));
    }
    .avatar-profil .edit-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 36px;
        height: 36px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--sigap-primary);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        font-size: 0.9rem;
        cursor: pointer;
    }
    .profil-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 6px;
        position: relative;
        z-index: 1;
    }
    .profil-email {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.7);
        margin-bottom: 12px;
        position: relative;
        z-index: 1;
    }
    .profil-stats {
        display: flex;
        justify-content: center;
        gap: 30px;
        position: relative;
        z-index: 1;
    }
    .profil-stat {
        text-align: center;
    }
    .profil-stat .value {
        font-size: 1.3rem;
        font-weight: 800;
        color: white;
    }
    .profil-stat .label {
        font-size: 0.7rem;
        color: rgba(255,255,255,0.6);
        text-transform: uppercase;
    }
    .menu-section {
        background: white;
        border-radius: 20px;
        margin: -30px 15px 15px;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--sigap-border);
        overflow: hidden;
        position: relative;
        z-index: 2;
    }
    .menu-section-header {
        background: var(--sigap-gray-light);
        padding: 14px 18px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--sigap-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .menu-item {
        display: flex;
        align-items: center;
        padding: 16px 18px;
        text-decoration: none;
        border-bottom: 1px solid var(--sigap-gray-light);
        transition: all 0.2s;
    }
    .menu-item:last-child {
        border-bottom: none;
    }
    .menu-item:hover {
        background: var(--sigap-gray-light);
        padding-left: 22px;
    }
    .menu-item .menu-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        margin-right: 14px;
        flex-shrink: 0;
    }
    .menu-item .menu-icon.akun { background: rgba(46, 134, 171, 0.1); color: var(--sigap-primary); }
    .menu-item .menu-icon.notif { background: rgba(87, 204, 153, 0.1); color: var(--sigap-secondary); }
    .menu-item .menu-icon.anak { background: rgba(255, 179, 71, 0.1); color: var(--sigap-warning); }
    .menu-item .menu-icon.bantuan { background: rgba(255, 107, 107, 0.1); color: var(--sigap-accent); }
    .menu-item .menu-icon.logout { background: rgba(155, 89, 182, 0.1); color: var(--sigap-purple); }
    .menu-item .menu-text {
        flex: 1;
    }
    .menu-item .menu-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--sigap-dark);
    }
    .menu-item .menu-subtitle {
        font-size: 0.7rem;
        color: var(--sigap-gray);
    }
    .menu-item .menu-arrow {
        color: var(--sigap-gray);
        font-size: 0.85rem;
    }
    .logout-item {
        background: rgba(255, 107, 107, 0.05);
    }
    .logout-item:hover {
        background: rgba(255, 107, 107, 0.1);
    }
    .logout-item .menu-icon {
        background: rgba(255, 107, 107, 0.1);
        color: var(--sigap-accent);
    }
    .logout-item .menu-title {
        color: var(--sigap-accent);
    }
    .app-info {
        text-align: center;
        padding: 20px;
        color: var(--sigap-gray);
        font-size: 0.75rem;
    }
    .app-info .app-name {
        font-weight: 700;
        color: var(--sigap-dark);
        margin-bottom: 4px;
    }
    .app-info .app-version {
        opacity: 0.7;
    }
    .setting-card {
        background: white;
        border-radius: 20px;
        margin: 15px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--sigap-border);
        overflow: hidden;
    }
    .setting-row {
        display: flex;
        align-items: center;
        padding: 16px 18px;
        border-bottom: 1px solid var(--sigap-gray-light);
    }
    .setting-row:last-child {
        border-bottom: none;
    }
    .setting-row .setting-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
        font-size: 1rem;
    }
    .setting-row .setting-text {
        flex: 1;
    }
    .setting-row .setting-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--sigap-dark);
    }
    .toggle-switch {
        width: 50px;
        height: 28px;
        background: var(--sigap-gray-light);
        border-radius: 14px;
        position: relative;
        cursor: pointer;
        transition: all 0.3s;
    }
    .toggle-switch.active {
        background: var(--sigap-primary);
    }
    .toggle-switch::after {
        content: '';
        position: absolute;
        width: 22px;
        height: 22px;
        background: white;
        border-radius: 50%;
        top: 3px;
        left: 3px;
        transition: all 0.3s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .toggle-switch.active::after {
        left: 25px;
    }
</style>
@endpush


@section('content')
<div class="profil-header">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div></div>
        <span class="text-white opacity-75" style="font-size: 0.85rem;">Profil</span>
        <a href="#" class="back-btn">
            <i class="fas fa-cog"></i>
        </a>
    </div>
    
    <div class="text-center">
        <div class="avatar-profil">
            {{ substr($user->name, 0, 1) }}
            <div class="edit-badge">
                <i class="fas fa-camera"></i>
            </div>
        </div>
        <h1 class="profil-name">{{ $user->name }}</h1>
        <div class="profil-email">{{ $user->email }}</div>
        
        <div class="profil-stats">
            <div class="profil-stat">
                <div class="value">{{ $anakCount }}</div>
                <div class="label">Anak</div>
            </div>
            <div class="profil-stat">
                <div class="value">-</div>
                <div class="label">Konsultasi</div>
            </div>
            <div class="profil-stat">
                <div class="value">-</div>
                <div class="label">Artikel</div>
            </div>
        </div>
    </div>
</div>

<div class="menu-section">
    <div class="menu-section-header">
        Akun
    </div>
    <a href="#" class="menu-item">
        <div class="menu-icon akun">
            <i class="fas fa-user"></i>
        </div>
        <div class="menu-text">
            <div class="menu-title">Edit Profil</div>
            <div class="menu-subtitle">Ubah nama, email, atau foto</div>
        </div>
        <i class="fas fa-chevron-right menu-arrow"></i>
    </a>
    <a href="#" class="menu-item">
        <div class="menu-icon notif">
            <i class="fas fa-bell"></i>
        </div>
        <div class="menu-text">
            <div class="menu-title">Notifikasi</div>
            <div class="menu-subtitle">Pengaturan notifikasi aplikasi</div>
        </div>
        <i class="fas fa-chevron-right menu-arrow"></i>
    </a>
    <a href="#" class="menu-item">
        <div class="menu-icon">
            <i class="fas fa-lock"></i>
        </div>
        <div class="menu-text">
            <div class="menu-title">Ubah Password</div>
            <div class="menu-subtitle">Ganti kata sandi akun</div>
        </div>
        <i class="fas fa-chevron-right menu-arrow"></i>
    </a>
</div>

<div class="setting-card">
    <div class="setting-row">
        <div class="setting-icon" style="background: rgba(46, 134, 171, 0.1); color: var(--sigap-primary);">
            <i class="fas fa-moon"></i>
        </div>
        <div class="setting-text">
            <div class="setting-label">Mode Gelap</div>
        </div>
        <div class="toggle-switch" onclick="this.classList.toggle('active')"></div>
    </div>
    <div class="setting-row">
        <div class="setting-icon" style="background: rgba(87, 204, 153, 0.1); color: var(--sigap-secondary);">
            <i class="fas fa-language"></i>
        </div>
        <div class="setting-text">
            <div class="setting-label">Bahasa</div>
        </div>
        <span style="font-size: 0.85rem; color: var(--sigap-gray);">Indonesia</span>
    </div>
</div>

<div class="menu-section">
    <div class="menu-section-header">
        Lainnya
    </div>
    <a href="#" class="menu-item">
        <div class="menu-icon bantuan">
            <i class="fas fa-question-circle"></i>
        </div>
        <div class="menu-text">
            <div class="menu-title">Bantuan & FAQ</div>
            <div class="menu-subtitle">Panduan penggunaan aplikasi</div>
        </div>
        <i class="fas fa-chevron-right menu-arrow"></i>
    </a>
    <a href="#" class="menu-item">
        <div class="menu-icon">
            <i class="fas fa-shield-alt"></i>
        </div>
        <div class="menu-text">
            <div class="menu-title">Kebijakan Privasi</div>
            <div class="menu-subtitle">Baca kebijakan privasi kami</div>
        </div>
        <i class="fas fa-chevron-right menu-arrow"></i>
    </a>
    <a href="#" class="menu-item">
        <div class="menu-icon">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="menu-text">
            <div class="menu-title">Tentang Aplikasi</div>
            <div class="menu-subtitle">Informasi versi aplikasi</div>
        </div>
        <i class="fas fa-chevron-right menu-arrow"></i>
    </a>
</div>

<a href="{{ route('logout') }}" class="menu-section" style="display: block; text-decoration: none; margin-top: 15px;">
    <div class="menu-item logout-item">
        <div class="menu-icon">
            <i class="fas fa-sign-out-alt"></i>
        </div>
        <div class="menu-text">
            <div class="menu-title">Keluar</div>
            <div class="menu-subtitle">Log out dari akun Anda</div>
        </div>
    </div>
</a>

<div class="app-info">
    <div class="app-name">SIGAP Anak</div>
    <div class="app-version">Versi 1.0.0</div>
</div>

<div style="height: 30px;"></div>
@endsection
