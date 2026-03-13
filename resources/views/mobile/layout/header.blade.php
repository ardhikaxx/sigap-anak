<div class="mobile-header">
  <div class="mobile-header-content">
    <a href="{{ route('mobile.home') }}" class="mobile-logo d-flex align-items-center">
      <div class="avatar-circle bg-white text-primary me-2" style="width: 36px; height: 36px; font-size: 16px;">
        <i class="fas fa-baby"></i>
      </div>
      <span class="mobile-logo-text">SIGAP <span>Anak</span></span>
    </a>
    <div class="d-flex align-items-center gap-3">
      @php
        $notifCount = \App\Models\Notifikasi::where('user_id', auth()->id())->where('dibaca', false)->count();
      @endphp
      <button class="mobile-notification-btn position-relative">
        <i class="fas fa-bell fs-5"></i>
        @if($notifCount > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
          {{ $notifCount > 9 ? '9+' : $notifCount }}
        </span>
        @endif
      </button>
      <div class="dropdown">
        <button class="btn p-0" type="button" data-bs-toggle="dropdown">
          <div class="avatar-circle bg-primary text-white" style="width: 36px; height: 36px; font-size: 14px;">
            {{ substr(auth()->user()->name, 0, 1) }}
          </div>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
          </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </div>
  </div>
</div>
