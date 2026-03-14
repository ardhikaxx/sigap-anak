<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun - SIGAP Anak</title>
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
      --sigap-accent: #FF6B6B;
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
      width: 40%;
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

    .auth-main {
      width: 60%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .auth-card {
      background: var(--sigap-white);
      border-radius: 30px;
      padding: 40px;
      width: 100%;
      max-width: 600px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.05);
      border: 1px solid var(--sigap-gray-light);
    }

    .auth-logo {
      text-align: center;
      margin-bottom: 32px;
    }

    .auth-logo h1 {
      font-size: 2rem;
      font-weight: 800;
      color: var(--sigap-primary);
      margin-bottom: 4px;
    }

    .auth-logo span {
      color: var(--sigap-dark);
    }

    .auth-title {
      font-size: 1.5rem;
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
      margin-bottom: 18px;
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
      padding: 12px 16px 12px 44px;
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

    .form-control-custom.is-invalid {
      border-color: var(--sigap-accent);
      background: rgba(255, 107, 107, 0.05);
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
      margin-top: 24px;
      font-size: 0.95rem;
      color: var(--sigap-gray);
    }

    .auth-footer a {
      color: var(--sigap-primary);
      font-weight: 700;
      text-decoration: none;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .invalid-feedback {
      font-size: 0.75rem;
      font-weight: 600;
      margin-left: 4px;
      margin-top: -12px;
      margin-bottom: 12px;
      display: block;
      color: var(--sigap-accent);
    }

    @media (max-width: 992px) {
      .auth-sidebar { display: none; }
      .auth-main { width: 100%; }
      .auth-card { padding: 32px; }
    }

    @media (max-width: 480px) {
      .auth-main { padding: 16px; }
      .auth-card { padding: 24px; border-radius: 24px; }
      .form-row { grid-template-columns: 1fr; gap: 0; }
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-sidebar">
      <div class="sidebar-content">
        <div class="sidebar-icon"><i class="fas fa-user-plus"></i></div>
        <h1 class="sidebar-title">SIGAP Anak</h1>
        <p class="sidebar-subtitle">Mulai monitoring tumbuh kembang anak Anda</p>
      </div>
    </div>

    <div class="auth-main">
      <div class="auth-card">
        <div class="auth-logo">
          <h1>SIGAP <span>Anak</span></h1>
        </div>

        <h2 class="auth-title">Buat Akun Baru</h2>
        <p class="auth-subtitle">Silakan isi data diri Anda untuk mendaftar</p>

        <form method="POST" action="{{ route('register') }}">
          @csrf
          
          <div class="mb-1">
            <label for="name" class="form-label">Nama Lengkap</label>
            <div class="input-group-custom">
              <i class="fas fa-user prefix-icon"></i>
              <input type="text" class="form-control-custom @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap">
            </div>
            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
          </div>

          <div class="mb-1">
            <label for="email" class="form-label">Alamat Email</label>
            <div class="input-group-custom">
              <i class="fas fa-envelope prefix-icon"></i>
              <input type="email" class="form-control-custom @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
            </div>
            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
          </div>

          <div class="form-row">
            <div class="mb-1">
              <label for="nik" class="form-label">NIK (16 Digit)</label>
              <div class="input-group-custom">
                <i class="fas fa-id-card prefix-icon"></i>
                <input type="text" class="form-control-custom @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" required placeholder="1234567890123456">
              </div>
              @error('nik') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-1">
              <label for="no_hp" class="form-label">Nomor HP</label>
              <div class="input-group-custom">
                <i class="fas fa-phone prefix-icon"></i>
                <input type="text" class="form-control-custom @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required placeholder="081234567890">
              </div>
              @error('no_hp') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="mb-1">
            <label for="password" class="form-label">Password</label>
            <div class="input-group-custom">
              <i class="fas fa-lock prefix-icon"></i>
              <input type="password" class="form-control-custom @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimal 8 karakter">
              <button type="button" class="password-toggle" id="togglePassword">
                <i class="fas fa-eye" id="eyeIcon"></i>
              </button>
            </div>
            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group-custom">
              <i class="fas fa-lock prefix-icon"></i>
              <input type="password" class="form-control-custom" id="password_confirmation" name="password_confirmation" required placeholder="Masukkan kembali password">
            </div>
          </div>

          <button type="submit" class="btn btn-submit">
            Daftar Sekarang <i class="fas fa-user-plus ms-2"></i>
          </button>
        </form>

        <div class="auth-footer">
          Sudah punya akun? <a href="{{ route('login') }}">Masuk Sekarang</a>
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
</body>
</html>
