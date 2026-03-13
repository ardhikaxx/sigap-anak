# SIGAP Anak

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.x-00758F?style=for-the-badge&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap" alt="Bootstrap">
</p>

> **Sistem Informasi Gizi dan Pertumbuhan Anak** - Aplikasi berbasis web untuk membantu tenaga kesehatan dan orang tua dalam memantau pertumbuhan anak, mendeteksi dini gangguan gizi, serta memberikan rekomendasi tindak lanjut yang tepat dan terstruktur.

---

## 📋 Fitur Utama

### 👨‍⚕️ Untuk Tenaga Kesehatan (Admin)

| Fitur | Deskripsi |
|-------|-----------|
| 📋 Manajemen Data Anak | Pencatatan dan pengelolaan data anak berdasarkan faskes |
| 🩺 Pemeriksaan Berkala | Pencatatan berat badan, tinggi badan, dan pengukuran antropometri lainnya |
| 📊 Kalkulasi Z-Score | Otomatis menghitung status gizi berdasarkan standar WHO |
| 📅 Jadwal Posyandu | Pengelolaan jadwal dan kehadiran anak posyandu |
| 💬 Konsultasi | Manajemen konsultasi antara nakes dan orang tua |
| 📚 Edukasi | Manajemen artikel edukasi untuk orang tua |
| 📈 Laporan | Generate laporan bulanan (pemeriksaan, pertumbuhan, posyandu, konsultasi, status gizi) |
| ⚙️ Manajemen User | Pengeloaan user, wilayah, dan fasilitas kesehatan |

### 👪 Untuk Orang Tua (Mobile View)

| Fitur | Deskripsi |
|-------|-----------|
| 👶 Data Anak | Lihat data dan riwayat pertumbuhan anak |
| 📉 Grafik Pertumbuhan | Visualisasi pertumbuhan anak dengan grafik |
| 💬 Konsultasi | Konsultasi dengan tenaga kesehatan |
| 🔔 Notifikasi | Pemberitahuan terkait status gizi dan jadwal posyandu |

---

## 🛠️ Teknologi yang Digunakan

```
┌─────────────────────────────────────────────────────────────┐
│  Backend        │  Laravel 12          │  PHP 8.2+        │
├─────────────────────────────────────────────────────────────┤
│  Database       │  MySQL (XAMPP)      │                  │
├─────────────────────────────────────────────────────────────┤
│  Frontend       │  Bootstrap 5         │  Font Awesome 6  │
│                 │  Chart.js            │  Custom CSS       │
├─────────────────────────────────────────────────────────────┤
│  Auth           │  Laravel Session     │                  │
└─────────────────────────────────────────────────────────────┘
```

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

Edit file `.env`:
```env
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

🔗 Akses: **http://127.0.0.1:8000**

---

## 👤 Akun Default

| Role | Email | Password |
|------|-------|----------|
| 🔴 Admin | admin@sigap.com | password |
| 🟢 Nakes | nakes@sigap.com | password |
| 🔵 Orang Tua | ortu@sigap.com | password |

---

## 📁 Struktur Folder

```
sigap-anak/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          → Controller fitur admin
│   │   ├── Mobile/         → Controller fitur mobile
│   │   └── Auth/           → Controller autentikasi
│   └── Models/             → Eloquent Models
├── database/
│   ├── migrations/          → Database migrations
│   └── seeders/            → Database seeders
├── public/assets/
│   ├── css/                → Custom CSS
│   └── js/                 → Custom JS
├── resources/views/
│   ├── admin/              → View admin/nakes
│   ├── mobile/             → View mobile/orang tua
│   └── auth/               → View login
├── routes/web.php          → Route definitions
└── rule-sigap.md           → Spesifikasi lengkap
```

---

## 📊 Status Gizi (Standar WHO)

| Status | Warna | Keterangan |
|--------|-------|------------|
| ✅ Normal | Hijau | Status gizi baik |
| ⚠️ Stunting | Oranye | Tinggi badan menurut umur di bawah standar |
| ⚠️ Wasting | Merah | Berat badan menurut tinggi badan di bawah standar |
| ⚠️ Underweight | Kuning | Berat badan menurut umur di bawah standar |
| 🚨 Obesitas | Ungu | Berat badan menurut tinggi badan di atas standar |

---

## 🔗 Link Terkait

[![Laravel](https://img.shields.io/badge/Documentation-Laravel-FF2D20?style=flat&logo=laravel)](https://laravel.com/docs)
[![Bootstrap](https://img.shields.io/badge/Documentation-Bootstrap-7952B3?style=flat&logo=bootstrap)](https://getbootstrap.com/docs)
[![WHO Standards](https://img.shields.io/badge/WHO-Child%20Growth-004730?style=flat)](https://www.who.int/tools/child-growth-standards)

---

## 📝 Lisensi

Proyek open source untuk kepentingan kesehatan masyarakat.

---

## 👨‍💻 Kontributor

Tim Pengembang SIGAP Anak
