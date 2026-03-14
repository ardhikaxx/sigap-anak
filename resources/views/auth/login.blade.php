<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SIGAP Anak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --sigap-primary: #2E86AB;
      --sigap-primary-dark: #1A5F7A;
      --sigap-primary-light: #e0f2fe;
      --sigap-dark: #1A1D2E;
      --sigap-gray: #64748b;
      --sigap-gray-light: #f1f5f9;
      --sigap-white: #FFFFFF;
    }

    * {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body {
      background: var(--sigap-gray-light);
      min-height: 100vh;
    }

    .auth-container {
      min-height: 100vh;
      display: flex;
    }

    .auth-sidebar {
      width: 45%;
      background: linear-gradient(135deg, var(--sigap-primary), var(--sigap-primary-dark));
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 60px;
      position: relative;
      overflow: hidden;
    }

    .auth-sidebar::before {
      content: '';
      position: absolute;
      top: -100px;
      right: -100px;
      width: 400px;
      height: 400px;
      background: rgba(255,255,255,0.08);
      border-radius: 50%;
    }

    .sidebar-content {
      position: relative;
      z-index: 2;
      text-align: center;
      color: white;
    }

    .sidebar-icon {
      width: 100px;
      height: 100px;
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(10px);
      border-radius: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 32px;
      border: 1px solid rgba(255,255,255,0.2);
      font-size: 40px;
    }

    .sidebar-title {
      font-size: 2.8rem;
      font-weight: 800;
      margin-bottom: 8px;
      letter-spacing: -1px;
    }

    .sidebar-subtitle {
      font-size: 1.1rem;
      opacity: 0.9;
      font-weight: 400;
    }

    .sidebar-feature {
      margin-top: 48px;
      text-align: left;
      background: rgba(255,255,255,0.1);
      padding: 24px;
      border-radius: 20px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.15);
      max-width: 380px;
    }

    .sidebar-feature-item {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 14px;
      font-weight: 600;
      font-size: 0.95rem;
    }

    .sidebar-feature-item:last-child {
      margin-bottom: 0;
    }

    .auth-main {
      width: 55%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .auth-card {
      background: var(--sigap-white);
      border-radius: 30px;
      padding: 48px;
      width: 100%;
      max-width: 460px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.05);
      border: 1px solid var(--sigap-gray-light);
    }

    .auth-logo {
      text-align: center;
      margin-bottom: 40px;
    }

    .auth-logo h1 {
      font-size: 2.2rem;
      font-weight: 800;
      color: var(--sigap-primary);
      margin-bottom: 4px;
    }

    .auth-logo span {
      color: var(--sigap-dark);
    }

    .auth-logo p {
      color: var(--sigap-gray);
      font-size: 0.9rem;
      margin: 0;
    }

    .auth-title {
      font-size: 1.6rem;
      font-weight: 800;
      color: var(--sigap-dark);
      margin-bottom: 8px;
    }

    .auth-subtitle {
      color: var(--sigap-gray);
      font-size: 0.95rem;
      margin-bottom: 32px;
    }

    .form-label {
      font-weight: 700;
      font-size: 0.85rem;
      color: var(--sigap-dark);
      margin-bottom: 8px;
    }

    .input-group-custom {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group-custom i.prefix-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--sigap-gray);
      z-index: 10;
      transition: all 0.2s;
    }

    .form-control-custom {
      width: 100%;
      padding: 14px 16px 14px 44px;
      background: var(--sigap-gray-light);
      border: 2px solid var(--sigap-gray-light);
      border-radius: 14px;
      font-size: 0.95rem;
      font-weight: 500;
      transition: all 0.25s ease;
    }

    .form-control-custom:focus {
      background: white;
      border-color: var(--sigap-primary);
      box-shadow: 0 0 0 4px rgba(46, 134, 171, 0.1);
      outline: none;
    }

    .form-control-custom:focus + i.prefix-icon {
      color: var(--sigap-primary);
    }

    .password-toggle {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--sigap-gray);
      cursor: pointer;
      z-index: 10;
      background: none;
      border: none;
      padding: 0;
    }

    .password-toggle:hover {
      color: var(--sigap-primary);
    }

    .btn-submit {
      background: var(--sigap-primary);
      color: white;
      border: none;
      border-radius: 14px;
      padding: 16px;
      font-weight: 700;
      font-size: 1rem;
      width: 100%;
      margin-top: 10px;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(46, 134, 171, 0.25);
    }

    .btn-submit:hover {
      background: var(--sigap-primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(46, 134, 171, 0.35);
      color: white;
    }

    .auth-footer {
      text-align: center;
      margin-top: 32px;
      font-size: 0.95rem;
      color: var(--sigap-gray);
    }

    .auth-footer a {
      color: var(--sigap-primary);
      font-weight: 700;
      text-decoration: none;
    }

    @media (max-width: 992px) {
      .auth-sidebar { display: none; }
      .auth-main { width: 100%; }
      .auth-card { padding: 32px; }
    }

    @media (max-width: 480px) {
      .auth-main { padding: 16px; }
      .auth-card { padding: 24px; border-radius: 24px; }
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-sidebar">
      <div class="sidebar-content">
        <div class="sidebar-icon"><i class="fas fa-baby"></i></div>
        <h1 class="sidebar-title">SIGAP Anak</h1>
        <p class="sidebar-subtitle">Sistem Informasi Gizi & Pertumbuhan Anak</p>
        
        <div class="sidebar-feature">
          <div class="sidebar-feature-item">
            <i class="fas fa-chart-line text-white"></i>
            <span>Pantau pertumbuhan anak real-time</span>
          </div>
          <div class="sidebar-feature-item">
            <i class="fas fa-stethoscope text-white"></i>
            <span>Konsultasi ahli gizi & dokter</span>
          </div>
          <div class="sidebar-feature-item">
            <i class="fas fa-bell text-white"></i>
            <span>Pengingat posyandu & imunisasi</span>
          </div>
        </div>
      </div>
    </div>

    <div class="auth-main">
      <div class="auth-card">
        <div class="auth-logo">
          <h1>SIGAP <span>Anak</span></h1>
          <p>Memantau Tumbuh Kembang dengan SIGAP</p>
        </div>

        <h2 class="auth-title">Selamat Datang</h2>
        <p class="auth-subtitle">Silakan masuk untuk melanjutkan akses sistem</p>

        <form method="POST" action="{{ route('login') }}">
          @csrf
          
          <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <div class="input-group-custom">
              <i class="fas fa-envelope prefix-icon"></i>
              <input type="email" class="form-control-custom" id="email" name="email" required autofocus placeholder="nama@email.com">
            </div>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group-custom">
              <i class="fas fa-lock prefix-icon"></i>
              <input type="password" class="form-control-custom" id="password" name="password" required placeholder="Masukkan password">
              <button type="button" class="password-toggle" id="togglePassword">
                <i class="fas fa-eye" id="eyeIcon"></i>
              </button>
            </div>
          </div>

          <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="remember" name="remember" style="cursor: pointer;">
              <label class="form-check-label" for="remember" style="cursor: pointer; font-size: 0.9rem; font-weight: 500;">Ingat saya</label>
            </div>
            <a href="#" style="color: var(--sigap-primary); font-size: 0.9rem; font-weight: 700; text-decoration: none;">Lupa Password?</a>
          </div>

          <button type="submit" class="btn btn-submit">
            Masuk Sekarang <i class="fas fa-arrow-right ms-2"></i>
          </button>
        </form>

        <div class="auth-footer">
          Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');

      if (togglePassword) {
        togglePassword.addEventListener('click', function() {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          eyeIcon.classList.toggle('fa-eye');
          eyeIcon.classList.toggle('fa-eye-slash');
        });
      }
    });
  </script>
  
  @if($errors->any())
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Login Gagal',
      text: '{{ $errors->first() }}',
      confirmButtonColor: '#2E86AB',
      timer: 3000,
      timerProgressBar: true
    });
  </script>
  @endif
</body>
</html>
