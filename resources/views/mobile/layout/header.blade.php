<div class="topbar">
  <div class="topbar-left">
    <a href="{{ route('mobile.home') }}" class="sidebar-logo">
      <div class="logo-icon">
        <i class="fas fa-baby"></i>
      </div>
      <span class="sidebar-logo-text">SIGAP <span>Anak</span></span>
    </a>
  </div>

  <div class="topbar-right">
    <div class="d-flex align-items-center gap-2">
      <!-- Notification -->
      <div class="dropdown">
        <div class="topbar-icon-btn" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-bell"></i>
          @php
            $notifCount = \App\Models\Notifikasi::where('user_id', auth()->id())->where('dibaca', false)->count();
          @endphp
          @if($notifCount > 0)
            <span class="notification-dot"></span>
          @endif
        </div>
        <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0" style="width: 320px; border-radius: 20px; overflow: hidden;">
          <div class="bg-primary p-3 text-white">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-0 fw-bold">Notifikasi</h6>
              <span class="badge bg-white text-primary rounded-pill" style="font-size: 0.7rem;">{{ $notifCount }} Baru</span>
            </div>
          </div>
          <div class="p-2" style="max-height: 350px; overflow-y: auto;">
            @php
              $notifications = \App\Models\Notifikasi::where('user_id', auth()->id())->latest()->take(5)->get();
            @endphp
            @forelse($notifications as $notif)
              <a href="#" class="dropdown-item p-3 border-bottom-0 rounded-3 mb-1 {{ !$notif->dibaca ? 'bg-light' : '' }}">
                <div class="d-flex gap-3">
                  <div class="avatar-circle @if($notif->tipe == 'info') avatar-blue @elseif($notif->tipe == 'warning') avatar-yellow @else avatar-red @endif" style="width: 35px; height: 35px; font-size: 12px; flex-shrink: 0;">
                    <i class="fas @if($notif->tipe == 'info') fa-info-circle @elseif($notif->tipe == 'warning') fa-exclamation-triangle @else fa-bell @endif"></i>
                  </div>
                  <div>
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $notif->judul }}</div>
                    <div class="text-muted text-truncate" style="font-size: 0.75rem; max-width: 200px;">{{ $notif->pesan }}</div>
                    <div class="user-meta mt-1" style="font-size: 0.65rem;">{{ $notif->created_at->diffForHumans() }}</div>
                  </div>
                </div>
              </a>
            @empty
              <div class="text-center py-4">
                <i class="fas fa-bell-slash text-muted mb-2 fs-4"></i>
                <div class="text-muted small">Tidak ada notifikasi baru</div>
              </div>
            @endforelse
          </div>
          <a href="#" class="dropdown-item text-center py-3 border-top text-primary fw-bold" style="font-size: 0.8rem;">Lihat Semua Notifikasi</a>
        </div>
      </div>

      <!-- User Dropdown -->
      <div class="dropdown">
        <div class="user-dropdown-premium" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="{{ auth()->user()->orangtuaProfile->avatar ? asset('storage/'.auth()->user()->orangtuaProfile->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2E86AB&color=fff&bold=true' }}" 
               class="user-avatar-premium" 
               alt="{{ auth()->user()->name }}">
        </div>
        
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-premium shadow-lg animate slideIn">
          <li class="px-3 py-2 border-bottom mb-2 text-center">
            <div class="fw-bold text-dark">{{ auth()->user()->name }}</div>
            <div class="text-muted small">{{ ucfirst(auth()->user()->role) }}</div>
          </li>
          <li>
            <a class="dropdown-item dropdown-item-premium" href="#">
              <i class="fas fa-user-circle text-primary"></i> Profil Saya
            </a>
          </li>
          <li>
            <a class="dropdown-item dropdown-item-premium" href="#">
              <i class="fas fa-gear text-primary"></i> Pengaturan
            </a>
          </li>
          <li><hr class="dropdown-divider opacity-50"></li>
          <li>
            <a class="dropdown-item dropdown-item-premium text-danger" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form-topbar').submit();">
              <i class="fas fa-right-from-bracket"></i> Keluar
            </a>
            <form id="logout-form-topbar" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<style>
  .topbar {
    padding: 0 15px; /* Reduced padding for mobile */
  }
  .sidebar-logo {
    padding-left: 0; /* remove padding */
  }
  .user-dropdown-premium {
      padding: 5px;
  }
  /* Dropdown animations */
  .animate { animation-duration: 0.2s; -webkit-animation-duration: 0.2s; animation-fill-mode: both; -webkit-animation-fill-mode: both; }
  @keyframes slideIn { 0% { transform: translateY(1rem); opacity: 0; } 100% { transform: translateY(0rem); opacity: 1; } }
  .slideIn { animation-name: slideIn; }
</style>
