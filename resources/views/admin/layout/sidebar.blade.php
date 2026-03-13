<div class="sidebar">
  <div class="sidebar-header">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
      <i class="fas fa-baby fa-lg"></i>
      <span class="sidebar-logo-text">SIGAP <span>Anak</span></span>
    </a>
  </div>

  <nav class="sidebar-menu">
    <div class="menu-section">Menu Utama</div>
    
    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="fas fa-home"></i>
      <span>Dashboard</span>
    </a>

    <a href="{{ route('admin.anak.index') }}" class="menu-item {{ request()->routeIs('admin.anak.*') ? 'active' : '' }}">
      <i class="fas fa-child"></i>
      <span>Data Anak</span>
    </a>

    <a href="{{ route('admin.pemeriksaan.index') }}" class="menu-item {{ request()->routeIs('admin.pemeriksaan.*') ? 'active' : '' }}">
      <i class="fas fa-stethoscope"></i>
      <span>Pemeriksaan</span>
    </a>

    <div class="menu-section">Layanan</div>

    <a href="{{ route('admin.posyandu.index') }}" class="menu-item {{ request()->routeIs('admin.posyandu.*') ? 'active' : '' }}">
      <i class="fas fa-calendar-check"></i>
      <span>Posyandu</span>
    </a>

    <a href="{{ route('admin.konsultasi.index') }}" class="menu-item {{ request()->routeIs('admin.konsultasi.*') ? 'active' : '' }}">
      <i class="fas fa-comments"></i>
      <span>Konsultasi</span>
    </a>

    <a href="{{ route('admin.edukasi.index') }}" class="menu-item {{ request()->routeIs('admin.edukasi.*') ? 'active' : '' }}">
      <i class="fas fa-book-medical"></i>
      <span>Edukasi</span>
    </a>

    <a href="{{ route('admin.laporan.index') }}" class="menu-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
      <i class="fas fa-chart-bar"></i>
      <span>Laporan</span>
    </a>

    @if(Auth::user()->role === 'superadmin')
    <div class="menu-section">Manajemen</div>

    <a href="{{ route('admin.manajemen.users') }}" class="menu-item {{ request()->routeIs('admin.manajemen.*') ? 'active' : '' }}">
      <i class="fas fa-users-cog"></i>
      <span>Manajemen User</span>
    </a>

    <a href="{{ route('admin.manajemen.wilayah') }}" class="menu-item">
      <i class="fas fa-map-marked-alt"></i>
      <span>Wilayah</span>
    </a>

    <a href="{{ route('admin.manajemen.faskes') }}" class="menu-item">
      <i class="fas fa-hospital"></i>
      <span>Faskes</span>
    </a>
    @endif
  </nav>

  <div style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-item">
      <i class="fas fa-sign-out-alt"></i>
      <span>Logout</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
  </div>
</div>
