<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'SIGAP Anak')</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/sigap-main.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sigap-admin.css') }}">

  @stack('styles')

  <style>
    :root {
      --bottom-nav-height: 65px;
    }
    body {
      background-color: var(--sigap-light-bg);
      padding-bottom: var(--bottom-nav-height); /* Space for bottom nav */
      overflow-x: hidden;
    }
    .main-content {
      padding: 15px;
      padding-top: 80px; /* Space for topbar */
    }
    .topbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
    }
    .bottom-nav-container {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      height: var(--bottom-nav-height);
      background: var(--sigap-white);
      box-shadow: 0 -2px 15px rgba(0,0,0,0.08);
      display: flex;
      justify-content: space-around;
      align-items: center;
      border-top: 1px solid var(--sigap-border);
    }
    .bottom-nav-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      color: var(--sigap-gray);
      font-size: 0.7rem;
      font-weight: 600;
      transition: all 0.2s ease-in-out;
      padding: 8px 0;
      flex-grow: 1;
    }
    .bottom-nav-item i {
      font-size: 1.3rem;
      margin-bottom: 4px;
    }
    .bottom-nav-item.active {
      color: var(--sigap-primary);
      transform: translateY(-3px);
    }
    .bottom-nav-item:not(.active):hover {
        color: var(--sigap-primary-dark);
    }
    .content-body {
        min-height: calc(100vh - var(--bottom-nav-height) - 80px);
    }
  </style>
</head>
<body class="role-orangtua">

  @include('mobile.layout.header')

  <div class="main-content">
      <main class="content-body">
        @yield('content')
      </main>
  </div>

  @include('mobile.layout.bottom-nav')

  <!-- Core JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Alerts Handling -->
  @if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: "{{ session('success') }}",
      confirmButtonColor: '#2E86AB',
      timer: 3000
    });
  </script>
  @endif

  @if(session('error'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: "{{ session('error') }}",
      confirmButtonColor: '#FF6B6B'
    });
  </script>
  @endif

  @stack('scripts')
</body>
</html>
