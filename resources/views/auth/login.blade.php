<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SIGAP Anak</title>
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
    }
    .login-card {
      background: var(--sigap-white);
      border-radius: var(--radius-lg);
      padding: 40px;
      box-shadow: var(--shadow-lg);
      max-width: 420px;
      width: 100%;
    }
    .login-logo {
      text-align: center;
      margin-bottom: 30px;
    }
    .login-logo h1 {
      color: var(--sigap-primary);
      font-size: 28px;
    }
    .login-logo span {
      color: var(--sigap-secondary);
    }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="login-logo">
      <h1>SIGAP <span>Anak</span></h1>
      <p class="text-muted">Sistem Informasi Gizi dan Pertumbuhan Anak</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          <input type="email" class="form-control" id="email" name="email" required autofocus>
        </div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" class="form-control" id="password" name="password" required>
          <button type="button" class="btn btn-outline-secondary" id="togglePassword">
            <i class="fas fa-eye" id="eyeIcon"></i>
          </button>
        </div>
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Ingat saya</label>
      </div>

      <button type="submit" class="btn btn-primary w-100 py-2">Masuk</button>
    </form>

    <div class="text-center mt-4">
      <p class="text-muted">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

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
  </script>
  
  @if($errors->any())
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal Masuk',
      text: '{{ $errors->first() }}',
      confirmButtonColor: '#2E86AB'
    });
  </script>
  @endif
</body>
</html>
