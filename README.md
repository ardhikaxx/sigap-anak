# SIGAP Anak

Sistem Informasi Gizi dan Pertumbuhan Anak - Aplikasi berbasis web untuk membantu tenaga kesehatan dan orang tua dalam memantau pertumbuhan anak, mendeteksi dini gangguan gizi, serta memberikan rekomendasi tindak lanjut yang tepat dan terstruktur.

---

## 📋 Fitur Utama

### Untuk Tenaga Kesehatan (Admin)
- **Manajemen Data Anak** - Pencatatan dan pengelolaan data anak berdasarkan faskes
- **Pemeriksaan Berkala** - Pencatatan berat badan, tinggi badan, dan pengukuran antropometri lainnya
- **Kalkulasi Z-Score** - Otomatis menghitung status gizi berdasarkan standar WHO
- **Jadwal Posyandu** - Pengelolaan jadwal dan kehadiran anak posyandu
- **Konsultasi** - Manajemen konsultasi antara nakes dan orang tua
- **Edukasi** - Manajemen artikel edukasi untuk orang tua
- **Laporan** - Generate laporan bulanan (pemeriksaan, pertumbuhan, posyandu, konsultasi, status gizi)
- **Manajemen User** - Pengeloaan user, wilayah, dan fasilitas kesehatan

### Untuk Orang Tua (Mobile View)
- **Data Anak** - Lihat data dan riwayat pertumbuhan anak
- **Grafik Pertumbuhan** - Visualisasi pertumbuhan anak dengan grafik
- **Konsultasi** - Konsultasi dengan tenaga kesehatan
- **Notifikasi** - Pemberitahuan terkait status gizi dan jadwal posyandu

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 12
- **Database**: MySQL (XAMPP)
- **Frontend**: Bootstrap 5, Font Awesome 6, Chart.js
- **Authentication**: Laravel Auth (Session-based)
- **PHP**: 8.2+

---

## 📦 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/ardhikaxx/sigap-anak.git
cd sigap-anak
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
```

Edit file `.env` sesuai konfigurasi database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sigap_anak
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Database
```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Assets
```bash
npm run build
```

### 6. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di `http://127.0.0.1:8000`

---

## 👤 Akun Default

Setelah menjalankan seeder, login dengan:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@sigap.com | password |
| Nakes | nakes@sigap.com | password |
| Orang Tua | ortu@sigap.com | password |

---

## 📁 Struktur Folder

```
sigap-anak/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/        # Controller untuk fitur admin
│   │   │   ├── Mobile/       # Controller untuk fitur mobile
│   │   │   └── Auth/         # Controller untuk autentikasi
│   │   └── Middleware/
│   ├── Models/               # Eloquent Models
│   └── Providers/
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/
│   ├── assets/
│   │   ├── css/              # Custom CSS
│   │   └── js/               # Custom JS
│   └── uploads/              # File uploads
├── resources/
│   └── views/
│       ├── admin/            # View untuk admin/nakes
│       ├── mobile/           # View untuk mobile/orang tua
│       ├── auth/             # View untuk login
│       └── layouts/          # Master layouts
├── routes/
│   └── web.php               # Route definitions
├── rule-sigap.md             # Spesifikasi lengkap sistem
└── README.md                 # Dokumentasi ini
```

---

## 🎨 Desain & Warna

Sistem menggunakan palet warna berikut:

| Warna | Kode | Penggunaan |
|-------|------|------------|
| Primary | `#2E86AB` | Biru utama (navigasi, tombol) |
| Secondary | `#57CC99` | Hijau sehat (status normal) |
| Warning | `#FFB347` | Oranye (peringatan) |
| Danger | `#FF6B6B` | Merah (gizi buruk, wasting) |

---

## 📊 Status Gizi

Sistem mendeteksi status gizi berdasarkan standar WHO:

- **Normal** - Status gizi baik
- **Stunting** - Tinggi badan menurut umur di bawah standar
- **Wasting** - Berat badan menurut tinggi badan di bawah standar
- **Underweight** - Berat badan menurut umur di bawah standar
- **Overweight/Obesitas** - Berat badan menurut tinggi badan di atas standar

---

## 📝 Lisensi

Proyek ini adalah proyek open source untuk kepentingan kesehatan masyarakat.

---

## 👨‍💻 Kontributor

- Tim Pengembang SIGAP Anak

---

## 🔗 Link Terkait

- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap 5](https://getbootstrap.com/docs/5.3/)
- [WHO Child Growth Standards](https://www.who.int/tools/child-growth-standards)
