<div class="sidebar">
  <div class="sidebar-header">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
      <div class="logo-icon">
        <i class="fas fa-baby"></i>
      </div>
      <span class="sidebar-logo-text">SIGAP <span>Anak</span></span>
    </a>
  </div>

  <nav class="sidebar-menu">
    <div class="menu-section">Menu Utama</div>
    
    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <div class="menu-icon"><i class="fas fa-house"></i></div>
      <span>Dashboard</span>
    </a>

    <a href="{{ route('admin.anak.index') }}" class="menu-item {{ request()->routeIs('admin.anak.*') ? 'active' : '' }}">
      <div class="menu-icon"><i class="fas fa-children"></i></div>
      <span>Data Anak</span>
    </a>

    <a href="{{ route('admin.pemeriksaan.index') }}" class="menu-item {{ request()->routeIs('admin.pemeriksaan.*') ? 'active' : '' }}">
      <div class="menu-icon"><i class="fas fa-stethoscope"></i></div>
      <span>Pemeriksaan</span>
    </a>

    <div class="menu-section">Layanan</div>

    <a href="{{ route('admin.posyandu.index') }}" class="menu-item {{ request()->routeIs('admin.posyandu.*') ? 'active' : '' }}">
      <div class="menu-icon"><i class="fas fa-calendar-check"></i></div>
      <span>Posyandu</span>
    </a>

    <a href="{{ route('admin.konsultasi.index') }}" class="menu-item {{ request()->routeIs('admin.konsultasi.*') ? 'active' : '' }}">
      <div class="menu-icon"><i class="fas fa-comments"></i></div>
      <span>Konsultasi</span>
    </a>

    <a href="{{ route('admin.edukasi.index') }}" class="menu-item {{ request()->routeIs('admin.edukasi.*') ? 'active' : '' }}">
      <div class="menu-icon"><i class="fas fa-book-medical"></i></div>
      <span>Edukasi</span>
    </a>

    <a href="{{ route('admin.laporan.index') }}" class="menu-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
      <div class="menu-icon"><i class="fas fa-chart-bar"></i></div>
      <span>Laporan</span>
    </a>

    @if(Auth::user()->role === 'superadmin')
    <div class="menu-section">Manajemen</div>

    <a href="{{ route('admin.manajemen.users') }}" class="menu-item {{ request()->routeIs('admin.manajemen.*') ? 'active' : '' }}">
      <div class="menu-icon"><i class="fas fa-users-gear"></i></div>
      <span>Manajemen User</span>
    </a>

    <a href="{{ route('admin.manajemen.wilayah') }}" class="menu-item">
      <div class="menu-icon"><i class="fas fa-map-location-dot"></i></div>
      <span>Wilayah</span>
    </a>

    <a href="{{ route('admin.manajemen.faskes') }}" class="menu-item">
      <div class="menu-icon"><i class="fas fa-hospital"></i></div>
      <span>Faskes</span>
    </a>
    @endif
  </nav>

  <div class="sidebar-footer">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-item logout-item">
      <div class="menu-icon"><i class="fas fa-right-from-bracket"></i></div>
      <span>Logout</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
  </div>
</div>

<style>
  :root {
    --primary: #0ea5e9;
    --primary-dark: #0284c7;
    --primary-light: #e0f2fe;
    --dark: #0f172a;
    --dark-secondary: #1e293b;
    --gray-500: #64748b;
    --gray-400: #94a3b8;
    --gray-100: #f1f5f9;
    --white: #ffffff;
  }

  .sidebar {
    width: 270px;
    background: var(--dark);
    color: var(--white);
    position: fixed;
    height: 100vh;
    overflow-y: auto;
    z-index: 1000;
    display: flex;
    flex-direction: column;
  }

  .sidebar::-webkit-scrollbar {
    width: 6px;
  }

  .sidebar::-webkit-scrollbar-track {
    background: var(--dark-secondary);
  }

  .sidebar::-webkit-scrollbar-thumb {
    background: var(--gray-500);
    border-radius: 3px;
  }

  .sidebar-header {
    padding: 24px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
  }

  .sidebar-logo {
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: var(--white);
  }

  .logo-icon {
    width: 44px;
    height: 44px;
    background: var(--primary);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35);
  }

  .sidebar-logo-text {
    font-size: 18px;
    font-weight: 700;
    letter-spacing: -0.5px;
  }

  .sidebar-logo-text span {
    color: var(--primary);
  }

  .sidebar-menu {
    padding: 16px 12px;
    flex: 1;
  }

  .menu-section {
    padding: 8px 12px 10px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--gray-500);
    font-weight: 600;
    margin-top: 8px;
  }

  .menu-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    color: var(--gray-400);
    text-decoration: none;
    transition: all 0.2s ease;
    border-radius: 12px;
    margin-bottom: 4px;
  }

  .menu-item:hover {
    background: rgba(255,255,255,0.06);
    color: var(--white);
  }

  .menu-item.active {
    background: var(--primary);
    color: var(--white);
    box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35);
  }

  .menu-item.active .menu-icon {
    background: rgba(255,255,255,0.2);
  }

  .menu-icon {
    width: 36px;
    height: 36px;
    background: rgba(255,255,255,0.06);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }

  .menu-item span {
    font-size: 14px;
    font-weight: 500;
  }

  .sidebar-footer {
    padding: 16px 12px;
    border-top: 1px solid rgba(255,255,255,0.08);
  }

  .logout-item {
    color: #f87171;
  }

  .logout-item:hover {
    background: rgba(248, 113, 113, 0.1);
    color: #f87171;
  }

  .logout-item .menu-icon {
    background: rgba(248, 113, 113, 0.1);
    color: #f87171;
  }

  .main-content {
    flex: 1;
    margin-left: 270px;
    min-height: 100vh;
    background: var(--gray-100);
  }

  .topbar {
    background: var(--white);
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 32px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    position: sticky;
    top: 0;
    z-index: 100;
  }

  .topbar-left {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .breadcrumb {
    margin-bottom: 0;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .breadcrumb-item a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
  }

  .breadcrumb-item a:hover {
    color: var(--primary-dark);
  }

  .breadcrumb-item.active {
    color: var(--gray-500);
    font-weight: 500;
  }

  .breadcrumb-item + .breadcrumb-item::before {
    content: '/';
    color: var(--gray-400);
    padding: 0 4px;
  }

  .topbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .topbar-notification {
    position: relative;
  }

  .topbar-notification .btn {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--gray-100);
    border: none;
    color: var(--gray-500);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
  }

  .topbar-notification .btn:hover {
    background: var(--primary-light);
    color: var(--primary);
  }

  .notification-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    width: 20px;
    height: 20px;
    background: #ef4444;
    color: white;
    font-size: 11px;
    font-weight: 700;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--white);
  }

  .user-dropdown {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 6px 12px 6px 6px;
    background: var(--gray-100);
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .user-dropdown:hover {
    background: var(--primary-light);
  }

  .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
  }

  .user-info {
    display: flex;
    flex-direction: column;
  }

  .user-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--dark);
    line-height: 1.2;
  }

  .user-role {
    font-size: 12px;
    color: var(--gray-500);
    font-weight: 500;
  }

  .dropdown-menu {
    border: none;
    border-radius: 14px;
    padding: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.12);
    margin-top: 12px;
    min-width: 200px;
  }

  .dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    color: var(--dark-secondary);
    transition: all 0.2s ease;
  }

  .dropdown-item:hover {
    background: var(--gray-100);
    color: var(--primary);
  }

  .dropdown-item i {
    width: 20px;
    color: var(--gray-500);
  }

  .dropdown-item:hover i {
    color: var(--primary);
  }

  .dropdown-divider {
    margin: 8px 0;
    border-color: var(--gray-100);
  }

  .mobile-toggle {
    display: none;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--gray-100);
    border: none;
    color: var(--gray-500);
    align-items: center;
    justify-content: center;
    font-size: 20px;
  }

  @media (max-width: 992px) {
    .sidebar {
      transform: translateX(-100%);
    }

    .sidebar.active {
      transform: translateX(0);
    }

    .main-content {
      margin-left: 0;
    }

    .mobile-toggle {
      display: flex;
    }
  }

  @media (max-width: 576px) {
    .topbar {
      padding: 0 16px;
    }

    .user-info {
      display: none;
    }

    .user-dropdown {
      padding: 4px;
    }
  }
</style>
