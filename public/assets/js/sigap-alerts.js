function showSuccessAlert(title, text) {
  Swal.fire({
    icon: 'success',
    title: title,
    text: text,
    confirmButtonColor: '#2E86AB',
    timer: 2500,
    timerProgressBar: true,
    showConfirmButton: false
  });
}

function showErrorAlert(title, text) {
  Swal.fire({
    icon: 'error',
    title: title,
    text: text,
    confirmButtonColor: '#FF6B6B',
    confirmButtonText: 'Coba Lagi'
  });
}

function showWarningAlert(title, text) {
  Swal.fire({
    icon: 'warning',
    title: title,
    text: text,
    confirmButtonColor: '#FFB347',
    confirmButtonText: 'OK'
  });
}

function showInfoAlert(title, text) {
  Swal.fire({
    icon: 'info',
    title: title,
    text: text,
    confirmButtonColor: '#2E86AB',
    confirmButtonText: 'OK'
  });
}

function showConfirmDelete(title, text, callback) {
  Swal.fire({
    title: title,
    text: text,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#FF6B6B',
    cancelButtonColor: '#6c757d',
    confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
    cancelButtonText: 'Batal',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      callback();
    }
  });
}

function showConfirmLogout() {
  Swal.fire({
    title: 'Keluar dari SIGAP?',
    text: 'Anda akan keluar dari sistem.',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#2E86AB',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Keluar',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '/logout';
    }
  });
}

function showStatusGiziAlert(namaAnak, statusGizi, linkKonsultasi) {
  Swal.fire({
    icon: 'warning',
    title: '⚠️ Perhatian Khusus!',
    html: `
      <div class="text-start">
        <p>Status gizi <strong>${namaAnak}</strong> terdeteksi:</p>
        <span class="badge bg-danger fs-6">${statusGizi}</span>
        <p class="mt-3">Disarankan untuk segera berkonsultasi dengan tenaga kesehatan.</p>
      </div>
    `,
    confirmButtonColor: '#FF6B6B',
    confirmButtonText: 'Hubungi Nakes Sekarang',
    showCancelButton: true,
    cancelButtonText: 'Nanti'
  }).then((result) => {
    if (result.isConfirmed && linkKonsultasi) {
      window.location.href = linkKonsultasi;
    }
  });
}

function showLoading() {
  Swal.fire({
    title: 'Memuat...',
    allowEscapeKey: false,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });
}

function hideLoading() {
  Swal.close();
}

function showToast(type, message) {
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

  Toast.fire({
    icon: type,
    title: message
  })
}

function initDeleteButtons() {
  document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const form = this.closest('form');
      const title = this.getAttribute('data-title') || 'Hapus Data?';
      const text = this.getAttribute('data-text') || 'Data yang dihapus tidak dapat dikembalikan!';
      
      showConfirmDelete(title, text, () => {
        form.submit();
      });
    });
  });
}

function initLogoutButton() {
  const logoutBtn = document.getElementById('logout-btn');
  if (logoutBtn) {
    logoutBtn.addEventListener('click', function(e) {
      e.preventDefault();
      showConfirmLogout();
    });
  }
}

document.addEventListener('DOMContentLoaded', function() {
  initDeleteButtons();
  initLogoutButton();
});

if (typeof module !== 'undefined' && module.exports) {
  module.exports = {
    showSuccessAlert,
    showErrorAlert,
    showWarningAlert,
    showInfoAlert,
    showConfirmDelete,
    showConfirmLogout,
    showStatusGiziAlert,
    showLoading,
    hideLoading,
    showToast
  };
}
