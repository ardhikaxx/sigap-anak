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
    <div class="menu-section">Utama</div>
    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="fas fa-th-large"></i>
      <span>Dashboard</span>
    </a>

    <div class="menu-section">Data & Medis</div>
    <a href="{{ route('admin.anak.index') }}" class="menu-item {{ request()->routeIs('admin.anak.*') ? 'active' : '' }}">
      <i class="fas fa-children"></i>
      <span>Data Anak</span>
    </a>
    <a href="{{ route('admin.pemeriksaan.index') }}" class="menu-item {{ request()->routeIs('admin.pemeriksaan.*') ? 'active' : '' }}">
      <i class="fas fa-stethoscope"></i>
      <span>Pemeriksaan</span>
    </a>
    <a href="{{ route('admin.posyandu.index') }}" class="menu-item {{ request()->routeIs('admin.posyandu.*') ? 'active' : '' }}">
      <i class="fas fa-calendar-check"></i>
      <span>Posyandu</span>
    </a>

    <div class="menu-section">Komunikasi</div>
    <a href="{{ route('admin.konsultasi.index') }}" class="menu-item {{ request()->routeIs('admin.konsultasi.*') ? 'active' : '' }}">
      <i class="fas fa-comments"></i>
      <span>Konsultasi</span>
    </a>
    <a href="{{ route('admin.edukasi.index') }}" class="menu-item {{ request()->routeIs('admin.edukasi.*') ? 'active' : '' }}">
      <i class="fas fa-book-open-reader"></i>
      <span>Edukasi</span>
    </a>

    <div class="menu-section">Sistem</div>
    <a href="{{ route('admin.laporan.index') }}" class="menu-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
      <i class="fas fa-chart-pie"></i>
      <span>Laporan</span>
    </a>

    @if(Auth::user()->role === 'superadmin')
    <a href="{{ route('admin.manajemen.users') }}" class="menu-item {{ request()->routeIs('admin.manajemen.users*') ? 'active' : '' }}">
      <i class="fas fa-users-gear"></i>
      <span>Manajemen User</span>
    </a>
    <a href="{{ route('admin.manajemen.wilayah') }}" class="menu-item {{ request()->routeIs('admin.manajemen.wilayah*') ? 'active' : '' }}">
      <i class="fas fa-map-location-dot"></i>
      <span>Wilayah</span>
    </a>
    @endif
  </nav>

  <div class="sidebar-profile">
    <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2E86AB&color=fff&bold=true' }}" alt="Profile">
    <div class="profile-info">
      <div class="profile-name">{{ auth()->user()->name }}</div>
      <div class="profile-role">{{ ucfirst(auth()->user()->role) }}</div>
    </div>
    <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();" class="text-danger opacity-50 hover-opacity-100" title="Logout">
      <i class="fas fa-right-from-bracket"></i>
    </a>
    <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
    </form>
  </div>
</div>

<style>
  .hover-opacity-100:hover { opacity: 1 !important; transition: 0.2s; }
  /* Custom scrollbar for sidebar-menu */
  .sidebar-menu::-webkit-scrollbar { width: 4px; }
  .sidebar-menu::-webkit-scrollbar-track { background: transparent; }
  .sidebar-menu::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>
