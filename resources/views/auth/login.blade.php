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
      --primary: #0ea5e9;
      --primary-dark: #0284c7;
      --primary-light: #e0f2fe;
      --dark: #0f172a;
      --dark-secondary: #334155;
      --gray-500: #64748b;
      --gray-400: #94a3b8;
      --gray-100: #f1f5f9;
      --white: #ffffff;
      --danger: #ef4444;
    }

    * {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body {
      background: var(--gray-100);
      min-height: 100vh;
    }

    .auth-container {
      min-height: 100vh;
      display: flex;
    }

    .auth-sidebar {
      width: 45%;
      background: var(--primary);
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

    .auth-sidebar::after {
      content: '';
      position: absolute;
      bottom: -150px;
      left: -150px;
      width: 500px;
      height: 500px;
      background: rgba(255,255,255,0.05);
      border-radius: 50%;
    }

    .sidebar-content {
      position: relative;
      z-index: 2;
      text-align: center;
      color: white;
    }

    .sidebar-icon {
      width: 120px;
      height: 120px;
      background: rgba(255,255,255,0.15);
      border-radius: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 32px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.2);
    }

    .sidebar-icon i {
      font-size: 48px;
    }

    .sidebar-title {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 12px;
      letter-spacing: -1px;
    }

    .sidebar-subtitle {
      font-size: 1.1rem;
      opacity: 0.85;
      font-weight: 400;
    }

    .sidebar-feature {
      margin-top: 48px;
      text-align: left;
      background: rgba(255,255,255,0.1);
      padding: 24px;
      border-radius: 16px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.15);
    }

    .sidebar-feature-item {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 14px;
      font-weight: 500;
    }

    .sidebar-feature-item:last-child {
      margin-bottom: 0;
    }

    .sidebar-feature-item i {
      width: 24px;
    }

    .auth-main {
      width: 55%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .auth-card {
      background: var(--white);
      border-radius: 24px;
      padding: 48px;
      width: 100%;
      max-width: 440px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.08);
    }

    .auth-logo {
      text-align: center;
      margin-bottom: 36px;
    }

    .auth-logo h1 {
      font-size: 2rem;
      font-weight: 800;
      color: var(--primary);
      margin-bottom: 6px;
    }

    .auth-logo span {
      color: var(--dark);
    }

    .auth-logo p {
      color: var(--gray-500);
      font-size: 0.95rem;
      margin: 0;
    }

    .auth-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 8px;
    }

    .auth-subtitle {
      color: var(--gray-500);
      font-size: 0.9rem;
      margin-bottom: 32px;
    }

    .form-label {
      font-weight: 600;
      font-size: 0.85rem;
      color: var(--dark-secondary);
      margin-bottom: 8px;
    }

    .form-input {
      padding: 14px 16px;
      border: 2px solid var(--gray-100);
      border-radius: 12px;
      font-size: 0.95rem;
      transition: all 0.25s ease;
      background: var(--gray-100);
    }

    .form-input:focus {
      border-color: var(--primary);
      background: var(--white);
      box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
      outline: none;
    }

    .input-group-text {
      background: var(--gray-100);
      border: 2px solid var(--gray-100);
      border-radius: 12px;
      padding: 0 16px;
      color: var(--gray-500);
    }

    .input-group .form-input {
      border-left: none;
      border-radius: 0 12px 12px 0;
    }

    .input-group .input-group-text {
      border-right: none;
      border-radius: 12px 0 0 12px;
    }

    .input-group:focus-within .input-group-text {
      border-color: var(--primary);
    }

    .input-group:focus-within .form-input {
      border-left: 2px solid var(--primary);
    }

    .password-toggle-btn {
      background: var(--gray-100);
      border: 2px solid var(--gray-100);
      border-left: none;
      border-radius: 0 12px 12px 0;
      padding: 0 16px;
      color: var(--gray-500);
      cursor: pointer;
      transition: all 0.25s ease;
    }

    .password-toggle-btn:hover {
      background: var(--primary-light);
      color: var(--primary);
    }

    .form-check-input {
      width: 20px;
      height: 20px;
      border: 2px solid var(--gray-300);
      border-radius: 6px;
    }

    .form-check-input:checked {
      background-color: var(--primary);
      border-color: var(--primary);
    }

    .form-check-label {
      color: var(--gray-500);
      font-size: 0.9rem;
    }

    .btn-submit {
      background: var(--primary);
      border: none;
      border-radius: 12px;
      padding: 16px 24px;
      font-weight: 700;
      font-size: 1rem;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35);
    }

    .btn-submit:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(14, 165, 233, 0.45);
      color: white;
    }

    .auth-footer {
      text-align: center;
      margin-top: 28px;
    }

    .auth-footer p {
      color: var(--gray-500);
      font-size: 0.9rem;
      margin: 0;
    }

    .auth-footer a {
      color: var(--primary);
      font-weight: 600;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .auth-footer a:hover {
      color: var(--primary-dark);
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 28px 0;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--gray-100);
    }

    .divider span {
      padding: 0 16px;
      color: var(--gray-400);
      font-size: 0.85rem;
    }

    .social-login {
      display: flex;
      gap: 12px;
    }

    .social-btn {
      flex: 1;
      padding: 14px;
      border: 2px solid var(--gray-100);
      border-radius: 12px;
      background: var(--white);
      color: var(--dark-secondary);
      font-weight: 600;
      transition: all 0.25s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .social-btn:hover {
      border-color: var(--gray-300);
      background: var(--gray-100);
      color: var(--dark);
    }

    @media (max-width: 992px) {
      .auth-sidebar {
        display: none;
      }

      .auth-main {
        width: 100%;
      }

      .auth-card {
        padding: 32px;
      }
    }

    @media (max-width: 480px) {
      .auth-main {
        padding: 20px;
      }

      .auth-card {
        padding: 24px;
        border-radius: 20px;
      }

      .social-login {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-sidebar">
      <div class="sidebar-content">
        <div class="sidebar-icon">
          <i class="fas fa-baby"></i>
        </div>
        <h1 class="sidebar-title">SIGAP Anak</h1>
        <p class="sidebar-subtitle">Sistem Informasi Gizi dan Pertumbuhan Anak</p>
        
        <div class="sidebar-feature">
          <div class="sidebar-feature-item">
            <i class="fas fa-chart-line"></i>
            <span>Pantau pertumbuhan anak</span>
          </div>
          <div class="sidebar-feature-item">
            <i class="fas fa-stethoscope"></i>
            <span>Konsultasi dengan nakes</span>
          </div>
          <div class="sidebar-feature-item">
            <i class="fas fa-bell"></i>
            <span>Notifikasi jadwal posyandu</span>
          </div>
        </div>
      </div>
    </div>

    <div class="auth-main">
      <div class="auth-card">
        <div class="auth-logo">
          <h1>SIGAP <span>Anak</span></h1>
          <p>Sistem Informasi Gizi dan Pertumbuhan Anak</p>
        </div>

        <h2 class="auth-title">Selamat Datang</h2>
        <p class="auth-subtitle">Masukkan email dan password untuk masuk</p>

        <form method="POST" action="{{ route('login') }}">
          @csrf
          
          <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              <input type="email" class="form-control" id="email" name="email" required autofocus placeholder="nama@email.com">
            </div>
          </div>

          <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password">
              <button type="button" class="password-toggle-btn" id="togglePassword">
                <i class="fas fa-eye" id="eyeIcon"></i>
              </button>
            </div>
          </div>

          <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="remember" name="remember">
              <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            <a href="#" style="color: var(--primary); font-size: 0.9rem; font-weight: 600; text-decoration: none;">Lupa password?</a>
          </div>

          <button type="submit" class="btn btn-submit w-100">
            <i class="fas fa-sign-in-alt me-2"></i>Masuk
          </button>
        </form>

        <div class="auth-footer">
          <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
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

      if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function() {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          
          if (type === 'text') {
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
          } else {
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
          }
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
      confirmButtonColor: '#0ea5e9'
    });
  </script>
  @endif
</body>
</html>
