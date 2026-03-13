<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar - SIGAP Anak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sigap-main.css') }}">
  <style>
    body {
      background: linear-gradient(135deg, var(--sigap-primary), var(--sigap-primary-dark));
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px 0;
    }
    .register-card {
      background: var(--sigap-white);
      border-radius: var(--radius-lg);
      padding: 40px;
      box-shadow: var(--shadow-lg);
      max-width: 500px;
      width: 100%;
    }
    .register-logo {
      text-align: center;
      margin-bottom: 30px;
    }
    .register-logo h1 {
      color: var(--sigap-primary);
      font-size: 28px;
    }
    .register-logo span {
      color: var(--sigap-secondary);
    }
    .password-toggle {
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="register-card">
    <div class="register-logo">
      <h1>SIGAP <span>Anak</span></h1>
      <p class="text-muted">Daftar Akun Orang Tua</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
      @csrf
      
      <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
          <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        @error('name')
          <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        @error('email')
          <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="nik" class="form-label">NIK (16 Digit)</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
          <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" required>
        </div>
        @error('nik')
          <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="no_hp" class="form-label">Nomor HP</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-phone"></i></span>
          <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
        </div>
        @error('no_hp')
          <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-home"></i></span>
          <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ old('alamat') }}</textarea>
        </div>
        @error('alamat')
          <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" class="form-control" id="password" name="password" required>
          <button type="button" class="btn btn-outline-secondary password-toggle" id="togglePassword">
            <i class="fas fa-eye" id="eyeIcon"></i>
          </button>
        </div>
        @error('password')
          <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
          <button type="button" class="btn btn-outline-secondary password-toggle" id="togglePasswordConfirm">
            <i class="fas fa-eye" id="eyeIconConfirm"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100 py-2">Daftar</button>
    </form>

    <div class="text-center mt-4">
      <p class="text-muted">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Toggle Password
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

      // Toggle Confirm Password
      const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
      const passwordConfirmInput = document.getElementById('password_confirmation');
      const eyeIconConfirm = document.getElementById('eyeIconConfirm');

      if (togglePasswordConfirm && passwordConfirmInput && eyeIconConfirm) {
        togglePasswordConfirm.addEventListener('click', function() {
          const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordConfirmInput.setAttribute('type', type);
          
          if (type === 'text') {
            eyeIconConfirm.classList.remove('fa-eye');
            eyeIconConfirm.classList.add('fa-eye-slash');
          } else {
            eyeIconConfirm.classList.remove('fa-eye-slash');
            eyeIconConfirm.classList.add('fa-eye');
          }
        });
      }
    });
  </script>
</body>
</html>
