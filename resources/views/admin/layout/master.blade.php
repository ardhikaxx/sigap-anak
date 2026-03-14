<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'SIGAP Anak') - Admin Dashboard</title>
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/sigap-main.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sigap-admin.css') }}">
  
  <!-- Page Specific Styles Stack -->
  @stack('styles')

  <style>
    /* Professional Layout Fixes */
    body {
      background-color: var(--sigap-light-bg);
      overflow-x: hidden;
    }
    
    .admin-wrapper {
      display: flex;
      width: 100%;
      align-items: stretch;
    }
    
    .main-content {
      width: calc(100% - 260px);
      margin-left: 260px;
      min-height: 100vh;
      transition: all 0.3s;
      display: flex;
      flex-direction: column;
    }
    
    .content-body {
      padding: 30px;
      flex: 1;
    }

    @media (max-width: 991.98px) {
      .main-content {
        width: 100%;
        margin-left: 0;
      }
      .sidebar.active {
        margin-left: 0;
      }
      .sidebar {
        margin-left: -260px;
      }
    }
  </style>
</head>
<body>
  <div class="admin-wrapper">
    <!-- Sidebar -->
    @include('admin.layout.sidebar')

    <!-- Page Content -->
    <div class="main-content">
      <!-- Topbar -->
      @include('admin.layout.topbar')

      <!-- Content Body -->
      <main class="content-body">
        @yield('content')
      </main>

      <!-- Footer -->
      <footer class="py-4 bg-white border-top mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small text-muted">
            <div>Copyright &copy; SIGAP Anak {{ date('Y') }}</div>
            <div>
              <a href="#" class="text-decoration-none text-muted me-3">Privacy Policy</a>
              <a href="#" class="text-decoration-none text-muted">Terms &amp; Conditions</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <!-- Core JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Global Admin Scripts -->
  <script>
    $(document).ready(function() {
      // Sidebar Toggle
      $('#sidebarToggle').on('click', function() {
        $('.sidebar').toggleClass('active');
        if($(window).width() > 991) {
          if($('.sidebar').hasClass('active')) {
            $('.main-content').css('margin-left', '0');
            $('.main-content').css('width', '100%');
          } else {
            $('.main-content').css('margin-left', '260px');
            $('.main-content').css('width', 'calc(100% - 260px)');
          }
        }
      });

      // Active Menu Auto Scroll
      const activeMenu = document.querySelector('.menu-item.active');
      if (activeMenu) {
        activeMenu.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
  </script>

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

  <!-- Page Specific Scripts Stack -->
  @stack('scripts')
</body>
</html>
