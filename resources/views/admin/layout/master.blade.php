<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'SIGAP Anak')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sigap-main.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sigap-admin.css') }}">
  @yield('styles')
</head>
<body>
  <div class="admin-layout">
    @include('admin.layout.sidebar')
    
    <div class="main-content">
      @include('admin.layout.topbar')
      
      <div class="content-wrapper">
        @yield('content')
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('assets/js/sigap-zscore.js') }}"></script>
  <script src="{{ asset('assets/js/sigap-charts.js') }}"></script>
  <script src="{{ asset('assets/js/sigap-alerts.js') }}"></script>
  
  @if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{!! session("success") !!}',
      confirmButtonColor: '#2E86AB',
      timer: 2500,
      showConfirmButton: false
    });
  </script>
  @endif

  @if(session('error'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: '{!! session("error") !!}',
      confirmButtonColor: '#FF6B6B'
    });
  </script>
  @endif

  @yield('scripts')
</body>
</html>
