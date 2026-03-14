<div class="topbar">
  <div class="topbar-left">
    <button class="mobile-toggle" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        @yield('breadcrumb')
      </ol>
    </nav>
  </div>

  <div class="topbar-right">
    <div class="topbar-notification">
      <button class="btn position-relative">
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
        <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0ea5e9&color=fff&bold=true' }}" 
             class="user-avatar" 
             alt="{{ auth()->user()->name }}">
        <div class="user-info">
          <div class="user-name">{{ auth()->user()->name }}</div>
          <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
        </div>
        <i class="fas fa-chevron-down dropdown-arrow"></i>
      </div>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="#">
            <i class="fas fa-user"></i>
            Profil
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="#">
            <i class="fas fa-gear"></i>
            Pengaturan
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-top').submit();">
            <i class="fas fa-right-from-bracket"></i>
            Logout
          </a>
          <form id="logout-form-top" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </div>
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
    font-size: 18px;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .mobile-toggle:hover {
    background: var(--primary-light);
    color: var(--primary);
  }

  .breadcrumb {
    margin-bottom: 0;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
    background: none;
    padding: 0;
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
    font-size: 16px;
    position: relative;
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
    padding: 6px 14px 6px 6px;
    background: var(--gray-100);
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
  }

  .user-dropdown:hover {
    background: var(--primary-light);
  }

  .dropdown-arrow {
    font-size: 12px;
    color: var(--gray-500);
    transition: transform 0.2s ease;
  }

  .user-dropdown:hover .dropdown-arrow {
    color: var(--primary);
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
    border-radius: 16px;
    padding: 10px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.12);
    margin-top: 14px;
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
    text-decoration: none;
  }

  .dropdown-item:hover {
    background: var(--gray-100);
    color: var(--primary);
  }

  .dropdown-item i {
    width: 18px;
    color: var(--gray-500);
    font-size: 14px;
  }

  .dropdown-item:hover i {
    color: var(--primary);
  }

  .dropdown-item.text-danger {
    color: #ef4444;
  }

  .dropdown-item.text-danger i {
    color: #ef4444;
  }

  .dropdown-item.text-danger:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
  }

  .dropdown-divider {
    margin: 8px 0;
    border-color: var(--gray-100);
  }

  @media (max-width: 992px) {
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
      gap: 0;
    }

    .dropdown-arrow {
      display: none;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (sidebarToggle && sidebar) {
      sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('active');
      });

      document.addEventListener('click', function(e) {
        if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
          sidebar.classList.remove('active');
        }
      });
    }
  });
</script>
