<nav class="bottom-nav-container">
  <a href="{{ route('mobile.home') }}" class="bottom-nav-item {{ request()->routeIs('mobile.home') ? 'active' : '' }}">
    <i class="fas fa-home"></i>
    <span>Beranda</span>
  </a>
  <a href="{{ route('mobile.anak.index') }}" class="bottom-nav-item {{ request()->routeIs('mobile.anak.*') ? 'active' : '' }}">
    <i class="fas fa-child"></i>
    <span>Anak</span>
  </a>
  <a href="{{ route('mobile.grafik.index') }}" class="bottom-nav-item {{ request()->routeIs('mobile.grafik.*') ? 'active' : '' }}">
    <i class="fas fa-chart-line"></i>
    <span>Grafik</span>
  </a>
  <a href="{{ route('mobile.konsultasi.index') }}" class="bottom-nav-item {{ request()->routeIs('mobile.konsultasi.*') ? 'active' : '' }}">
    <i class="fas fa-comments"></i>
    <span>Konsultasi</span>
  </a>
  <a href="{{ route('mobile.profile.index') }}" class="bottom-nav-item {{ request()->routeIs('mobile.profile.*') ? 'active' : '' }}">
    <i class="fas fa-user-circle"></i>
    <span>Profil</span>
  </a>
</nav>
