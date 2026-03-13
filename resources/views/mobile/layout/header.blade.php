<div class="mobile-header">
  <div class="mobile-header-content">
    <a href="{{ route('mobile.home') }}" class="mobile-logo">
      <span class="mobile-logo-text">SIGAP <span>Anak</span></span>
    </a>
    <button class="mobile-notification-btn">
      <i class="fas fa-bell"></i>
      @php
        $notifCount = \App\Models\Notifikasi::where('user_id', auth()->id())->where('dibaca', false)->count();
      @endphp
      @if($notifCount > 0)
      <span class="badge bg-danger">{{ $notifCount }}</span>
      @endif
    </button>
  </div>
</div>
