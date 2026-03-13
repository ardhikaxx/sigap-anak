<div class="topbar">
  <div class="topbar-left">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        @yield('breadcrumb')
      </ol>
    </nav>
  </div>

  <div class="topbar-right">
    <div class="topbar-notification">
      <button class="btn btn-light position-relative">
        <i class="fas fa-bell"></i>
        @php
          $notifCount = \App\Models\Notifikasi::where('user_id', auth()->id())->where('dibaca', false)->count();
        @endphp
        @if($notifCount > 0)
        <span class="notification-badge">{{ $notifCount }}</span>
        @endif
      </button>
    </div>

    <div class="dropdown">
      <div class="user-dropdown" data-bs-toggle="dropdown">
        <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://via.placeholder.com/40' }}" 
             class="user-avatar" 
             alt="{{ auth()->user()->name }}">
        <div class="user-info">
          <div class="user-name">{{ auth()->user()->name }}</div>
          <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
        </div>
      </div>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-top').submit();">
            <i class="fas fa-sign-out-alt me-2"></i>Logout
          </a>
          <form id="logout-form-top" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </div>
  </div>
</div>
