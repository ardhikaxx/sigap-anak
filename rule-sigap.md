# SIGAP Anak — Sistem Informasi Gizi dan Pertumbuhan Anak
## Panduan Pengembangan Sistem Berbasis Web untuk Pemantauan dan Deteksi Dini Gangguan Gizi pada Anak

---

## 🎯 Gambaran Umum Sistem

**SIGAP Anak** adalah sistem informasi berbasis web yang dirancang untuk membantu tenaga kesehatan dan orang tua dalam memantau pertumbuhan anak, mendeteksi dini gangguan gizi, serta memberikan rekomendasi tindak lanjut yang tepat dan terstruktur.

### Tujuan Sistem
- Mempermudah pencatatan dan pemantauan data gizi anak secara digital
- Mendeteksi dini gangguan gizi (stunting, wasting, obesitas, dll)
- Memfasilitasi komunikasi antara tenaga kesehatan dan orang tua
- Menghasilkan laporan dan analitik berbasis data real-time
- Mendukung program posyandu dan puskesmas berbasis digital

---

## 🏗️ Arsitektur & Teknologi

### Stack Frontend
```
- HTML5 + CSS3 + Vanilla JavaScript (atau PHP templating)
- Bootstrap 5 via CDN
- Font Awesome 6 via CDN
- SweetAlert2 via CDN
- Chart.js via CDN (untuk grafik pertumbuhan)
- Custom CSS dengan CSS Variables
```

### CDN yang Digunakan
```html
<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Google Fonts (Nunito + Poppins) -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
```

### Backend (Rekomendasi)
```
- PHP 8.x / Laravel 10 / CodeIgniter 4
- MySQL 8.x / MariaDB
- RESTful API (untuk komunikasi mobile view)
- Session-based Auth atau JWT
```

---

## 🎨 Desain & Styling

### Palet Warna Sistem
```css
:root {
  /* Primary Brand */
  --sigap-primary: #2E86AB;        /* Biru Kesehatan */
  --sigap-primary-dark: #1A5F7A;
  --sigap-primary-light: #A8DADC;

  /* Secondary */
  --sigap-secondary: #57CC99;      /* Hijau Sehat */
  --sigap-secondary-dark: #38A169;
  --sigap-secondary-light: #C7F2DC;

  /* Accent */
  --sigap-accent: #FF6B6B;         /* Merah Alert */
  --sigap-warning: #FFB347;        /* Oranye Warning */
  --sigap-info: #74C0FC;           /* Biru Info */
  --sigap-purple: #9B59B6;         /* Ungu Statistik */

  /* Neutral */
  --sigap-dark: #1A1D2E;
  --sigap-gray: #6C757D;
  --sigap-light-bg: #F0F4F8;
  --sigap-white: #FFFFFF;
  --sigap-border: #E2E8F0;

  /* Status Gizi */
  --status-normal: #57CC99;
  --status-warning: #FFB347;
  --status-danger: #FF6B6B;
  --status-severe: #C0392B;
  --status-overweight: #E67E22;
  --status-obese: #8E44AD;

  /* Shadow */
  --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
  --shadow-md: 0 4px 15px rgba(0,0,0,0.10);
  --shadow-lg: 0 10px 40px rgba(0,0,0,0.15);

  /* Border Radius */
  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 20px;
  --radius-xl: 30px;
  --radius-pill: 50px;

  /* Transition */
  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
```

### Typography
```css
/* Tenaga Kesehatan (Desktop Admin) */
body.role-nakes {
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  color: var(--sigap-dark);
}

/* Orang Tua (Mobile View) */
body.role-orangtua {
  font-family: 'Nunito', sans-serif;
  font-size: 15px;
  color: var(--sigap-dark);
}

h1 { font-size: 1.8rem; font-weight: 700; }
h2 { font-size: 1.5rem; font-weight: 600; }
h3 { font-size: 1.2rem; font-weight: 600; }

.text-gradient {
  background: linear-gradient(135deg, var(--sigap-primary), var(--sigap-secondary));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
```

---

## 👥 Peran & Akses (Role Management)

### 1. Tenaga Kesehatan (Nakes)
**Sub-role:**
- `superadmin` — Akses penuh, manajemen sistem
- `dokter` — Input diagnosis, akses semua data pasien
- `bidan` — Input pemeriksaan, akses wilayah kerjanya
- `ahli_gizi` — Konsultasi gizi, rekomendasi diet
- `kader` — Input pengukuran posyandu, akses terbatas

**Tampilan:** Website Admin (Desktop-first, sidebar navigation)

### 2. Orang Tua / Wali
**Sub-role:**
- `ayah` / `ibu` / `wali` — Akses data anak yang terdaftar

**Tampilan:** Mobile Web App (Mobile-first, bottom navigation bar)

---

## 🗄️ SKEMA DATABASE (Relasi Kompleks)

### Tabel Utama

#### `users` — Data Pengguna
```sql
CREATE TABLE users (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  name            VARCHAR(100) NOT NULL,
  email           VARCHAR(100) UNIQUE NOT NULL,
  phone           VARCHAR(20),
  password        VARCHAR(255) NOT NULL,
  role            ENUM('superadmin','dokter','bidan','ahli_gizi','kader','orangtua') NOT NULL,
  avatar          VARCHAR(255),
  is_active       TINYINT(1) DEFAULT 1,
  email_verified  TINYINT(1) DEFAULT 0,
  last_login      DATETIME,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME ON UPDATE CURRENT_TIMESTAMP
);
```

#### `wilayah` — Hierarki Wilayah
```sql
CREATE TABLE wilayah (
  id          INT PRIMARY KEY AUTO_INCREMENT,
  nama        VARCHAR(100) NOT NULL,
  tipe        ENUM('provinsi','kabupaten','kecamatan','kelurahan','rw','rt') NOT NULL,
  parent_id   INT REFERENCES wilayah(id),
  kode_pos    VARCHAR(10),
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `fasilitas_kesehatan` — Puskesmas / Posyandu
```sql
CREATE TABLE fasilitas_kesehatan (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  nama            VARCHAR(150) NOT NULL,
  tipe            ENUM('puskesmas','posyandu','klinik','rumah_sakit') NOT NULL,
  wilayah_id      INT REFERENCES wilayah(id),
  alamat          TEXT,
  telepon         VARCHAR(20),
  email           VARCHAR(100),
  kepala_id       INT REFERENCES users(id),
  latitude        DECIMAL(10,8),
  longitude       DECIMAL(11,8),
  is_active       TINYINT(1) DEFAULT 1,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `nakes_profile` — Profil Tenaga Kesehatan
```sql
CREATE TABLE nakes_profile (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  user_id         INT UNIQUE REFERENCES users(id) ON DELETE CASCADE,
  nip             VARCHAR(30) UNIQUE,
  str_number      VARCHAR(30),
  spesialisasi    VARCHAR(100),
  faskes_id       INT REFERENCES fasilitas_kesehatan(id),
  wilayah_id      INT REFERENCES wilayah(id),
  jadwal_praktek  JSON,
  foto_ktp        VARCHAR(255),
  verified_at     DATETIME,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `orangtua_profile` — Profil Orang Tua
```sql
CREATE TABLE orangtua_profile (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  user_id         INT UNIQUE REFERENCES users(id) ON DELETE CASCADE,
  nik             VARCHAR(20) UNIQUE,
  tanggal_lahir   DATE,
  jenis_kelamin   ENUM('L','P'),
  alamat          TEXT,
  wilayah_id      INT REFERENCES wilayah(id),
  pekerjaan       VARCHAR(100),
  pendidikan      ENUM('SD','SMP','SMA','D3','S1','S2','S3','Lainnya'),
  penghasilan     ENUM('<1jt','1-3jt','3-5jt','5-10jt','>10jt'),
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `anak` — Data Anak
```sql
CREATE TABLE anak (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  nama            VARCHAR(100) NOT NULL,
  nik_anak        VARCHAR(20),
  tanggal_lahir   DATE NOT NULL,
  jenis_kelamin   ENUM('L','P') NOT NULL,
  berat_lahir     DECIMAL(5,2),
  panjang_lahir   DECIMAL(5,2),
  golongan_darah  ENUM('A','B','AB','O','A+','A-','B+','B-','AB+','AB-','O+','O-'),
  foto            VARCHAR(255),
  nomor_bpjs      VARCHAR(30),
  nomor_kartu_anak VARCHAR(30),
  ibu_id          INT REFERENCES users(id),
  ayah_id         INT REFERENCES users(id),
  wali_id         INT REFERENCES users(id),
  faskes_id       INT REFERENCES fasilitas_kesehatan(id),
  nakes_pj_id     INT REFERENCES users(id),
  wilayah_id      INT REFERENCES wilayah(id),
  status          ENUM('aktif','pindah','meninggal') DEFAULT 'aktif',
  catatan_khusus  TEXT,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME ON UPDATE CURRENT_TIMESTAMP
);
```

#### `pemeriksaan` — Data Pemeriksaan Antropometri
```sql
CREATE TABLE pemeriksaan (
  id                  INT PRIMARY KEY AUTO_INCREMENT,
  anak_id             INT REFERENCES anak(id) ON DELETE CASCADE,
  nakes_id            INT REFERENCES users(id),
  posyandu_id         INT REFERENCES fasilitas_kesehatan(id),
  tanggal_periksa     DATE NOT NULL,
  umur_bulan          INT NOT NULL,
  berat_badan         DECIMAL(5,2) NOT NULL,
  tinggi_badan        DECIMAL(5,2) NOT NULL,
  lingkar_kepala      DECIMAL(5,2),
  lingkar_lengan      DECIMAL(5,2),
  lingkar_perut       DECIMAL(5,2),
  lingkar_dada        DECIMAL(5,2),
  -- Indeks Z-Score
  bb_u_zscore         DECIMAL(6,3),      -- BB/U
  tb_u_zscore         DECIMAL(6,3),      -- TB/U
  bb_tb_zscore        DECIMAL(6,3),      -- BB/TB
  imt_u_zscore        DECIMAL(6,3),      -- IMT/U
  -- Status Gizi (otomatis dari z-score)
  status_bb_u         ENUM('gizi_buruk','gizi_kurang','gizi_baik','gizi_lebih','obesitas'),
  status_tb_u         ENUM('sangat_pendek','pendek','normal','tinggi'),
  status_bb_tb        ENUM('sangat_kurus','kurus','normal','gemuk','obesitas'),
  status_gizi_akhir   ENUM('normal','berisiko','stunting','wasting','underweight','overweight','obesitas','gizi_buruk'),
  -- Tanda Vital
  suhu_tubuh          DECIMAL(4,1),
  tekanan_darah       VARCHAR(20),
  -- Kondisi Klinis
  kondisi_umum        ENUM('baik','sedang','buruk'),
  edema               TINYINT(1) DEFAULT 0,
  -- Intervensi
  diberikan_vit_a     TINYINT(1) DEFAULT 0,
  diberikan_fe        TINYINT(1) DEFAULT 0,
  diberikan_zinc      TINYINT(1) DEFAULT 0,
  diberikan_pmt       TINYINT(1) DEFAULT 0,
  -- Referral
  dirujuk             TINYINT(1) DEFAULT 0,
  tujuan_rujukan      VARCHAR(255),
  alasan_rujukan      TEXT,
  catatan             TEXT,
  created_at          DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at          DATETIME ON UPDATE CURRENT_TIMESTAMP
);
```

#### `riwayat_gizi` — Rekam Medis Gizi
```sql
CREATE TABLE riwayat_gizi (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  anak_id         INT REFERENCES anak(id) ON DELETE CASCADE,
  pemeriksaan_id  INT REFERENCES pemeriksaan(id),
  nakes_id        INT REFERENCES users(id),
  diagnosis_gizi  VARCHAR(255),
  kode_icd        VARCHAR(20),
  intervensi      TEXT,
  rekomendasi     TEXT,
  target_bb       DECIMAL(5,2),
  target_tb       DECIMAL(5,2),
  follow_up_date  DATE,
  status_kasus    ENUM('baru','dalam_penanganan','membaik','sembuh','dirujuk','dropout'),
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `konsumsi_makanan` — Recall 24 Jam / Food Diary
```sql
CREATE TABLE konsumsi_makanan (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  anak_id         INT REFERENCES anak(id) ON DELETE CASCADE,
  tanggal         DATE NOT NULL,
  waktu_makan     ENUM('pagi','selingan_pagi','siang','selingan_sore','malam','tengah_malam'),
  nama_makanan    VARCHAR(150) NOT NULL,
  porsi           DECIMAL(6,2),
  satuan          VARCHAR(50),
  kalori          DECIMAL(8,2),
  protein         DECIMAL(6,2),
  lemak           DECIMAL(6,2),
  karbohidrat     DECIMAL(6,2),
  serat           DECIMAL(6,2),
  vitamin_a       DECIMAL(8,4),
  vitamin_c       DECIMAL(8,4),
  kalsium         DECIMAL(8,2),
  zat_besi        DECIMAL(8,4),
  zinc            DECIMAL(8,4),
  inputter_role   ENUM('orangtua','nakes'),
  inputter_id     INT REFERENCES users(id),
  catatan         TEXT,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `imunisasi` — Riwayat Imunisasi
```sql
CREATE TABLE imunisasi (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  anak_id         INT REFERENCES anak(id) ON DELETE CASCADE,
  jenis_vaksin    VARCHAR(100) NOT NULL,
  dosis           VARCHAR(20),
  tanggal         DATE NOT NULL,
  umur_saat_ini   INT,
  nakes_id        INT REFERENCES users(id),
  faskes_id       INT REFERENCES fasilitas_kesehatan(id),
  nomor_batch     VARCHAR(50),
  reaksi          TEXT,
  next_schedule   DATE,
  status          ENUM('terjadwal','selesai','terlambat','tidak_ada') DEFAULT 'selesai',
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `riwayat_penyakit` — Riwayat Penyakit Anak
```sql
CREATE TABLE riwayat_penyakit (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  anak_id         INT REFERENCES anak(id) ON DELETE CASCADE,
  nama_penyakit   VARCHAR(150) NOT NULL,
  kode_icd        VARCHAR(20),
  tanggal_mulai   DATE,
  tanggal_selesai DATE,
  gejala          TEXT,
  pengobatan      TEXT,
  nakes_id        INT REFERENCES users(id),
  faskes_id       INT REFERENCES fasilitas_kesehatan(id),
  status          ENUM('aktif','sembuh','kronis','rawat_inap'),
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `jadwal_posyandu` — Jadwal Kegiatan Posyandu
```sql
CREATE TABLE jadwal_posyandu (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  faskes_id       INT REFERENCES fasilitas_kesehatan(id),
  tanggal         DATE NOT NULL,
  jam_mulai       TIME,
  jam_selesai     TIME,
  tema            VARCHAR(200),
  lokasi          TEXT,
  keterangan      TEXT,
  nakes_pj_id     INT REFERENCES users(id),
  status          ENUM('terjadwal','sedang_berlangsung','selesai','dibatalkan') DEFAULT 'terjadwal',
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `kehadiran_posyandu` — Presensi Posyandu
```sql
CREATE TABLE kehadiran_posyandu (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  jadwal_id       INT REFERENCES jadwal_posyandu(id),
  anak_id         INT REFERENCES anak(id),
  hadir           TINYINT(1) DEFAULT 0,
  keterangan      VARCHAR(255),
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_kehadiran (jadwal_id, anak_id)
);
```

#### `konsultasi` — Konsultasi Gizi Online
```sql
CREATE TABLE konsultasi (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  anak_id         INT REFERENCES anak(id),
  orangtua_id     INT REFERENCES users(id),
  nakes_id        INT REFERENCES users(id),
  tipe            ENUM('chat','video_call','tatap_muka'),
  topik           VARCHAR(255),
  status          ENUM('menunggu','aktif','selesai','dibatalkan') DEFAULT 'menunggu',
  jadwal          DATETIME,
  durasi_menit    INT,
  rating          TINYINT(1),
  ulasan          TEXT,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
  selesai_at      DATETIME
);
```

#### `pesan_konsultasi` — Chat Konsultasi
```sql
CREATE TABLE pesan_konsultasi (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  konsultasi_id   INT REFERENCES konsultasi(id) ON DELETE CASCADE,
  pengirim_id     INT REFERENCES users(id),
  pesan           TEXT NOT NULL,
  tipe            ENUM('text','image','file','voice') DEFAULT 'text',
  file_path       VARCHAR(255),
  dibaca          TINYINT(1) DEFAULT 0,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `notifikasi` — Notifikasi Sistem
```sql
CREATE TABLE notifikasi (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  user_id         INT REFERENCES users(id) ON DELETE CASCADE,
  judul           VARCHAR(200) NOT NULL,
  pesan           TEXT NOT NULL,
  tipe            ENUM('info','warning','danger','success','reminder') DEFAULT 'info',
  ikon            VARCHAR(50),
  link            VARCHAR(255),
  dibaca          TINYINT(1) DEFAULT 0,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `edukasi` — Konten Edukasi Gizi
```sql
CREATE TABLE edukasi (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  judul           VARCHAR(255) NOT NULL,
  slug            VARCHAR(255) UNIQUE,
  konten          LONGTEXT,
  ringkasan       TEXT,
  gambar          VARCHAR(255),
  kategori        ENUM('nutrisi','pola_makan','stimulasi','imunisasi','penyakit','resep_mpasi','tips_parenting'),
  tag             JSON,
  penulis_id      INT REFERENCES users(id),
  target_usia     VARCHAR(50),
  is_published    TINYINT(1) DEFAULT 0,
  views           INT DEFAULT 0,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME ON UPDATE CURRENT_TIMESTAMP
);
```

#### `resep_mpasi` — Resep MPASI
```sql
CREATE TABLE resep_mpasi (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  nama_resep      VARCHAR(200) NOT NULL,
  deskripsi       TEXT,
  gambar          VARCHAR(255),
  usia_minimal    INT,
  usia_maksimal   INT,
  tingkat_alergen ENUM('rendah','sedang','tinggi'),
  bahan           JSON,
  langkah         JSON,
  nilai_gizi      JSON,
  waktu_memasak   INT,
  porsi           INT,
  penulis_id      INT REFERENCES users(id),
  is_published    TINYINT(1) DEFAULT 0,
  likes           INT DEFAULT 0,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `pengaturan_standar` — Standar Antropometri WHO
```sql
CREATE TABLE standar_who (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  jenis_kelamin   ENUM('L','P') NOT NULL,
  umur_bulan      INT NOT NULL,
  indikator       ENUM('BB_U','TB_U','BB_TB','IMT_U') NOT NULL,
  sd_minus3       DECIMAL(6,3),
  sd_minus2       DECIMAL(6,3),
  sd_minus1       DECIMAL(6,3),
  median          DECIMAL(6,3),
  sd_plus1        DECIMAL(6,3),
  sd_plus2        DECIMAL(6,3),
  sd_plus3        DECIMAL(6,3),
  UNIQUE KEY unique_standar (jenis_kelamin, umur_bulan, indikator)
);
```

#### `laporan` — Laporan Periodik
```sql
CREATE TABLE laporan (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  judul           VARCHAR(255),
  tipe            ENUM('bulanan','triwulan','tahunan','khusus'),
  periode_mulai   DATE,
  periode_selesai DATE,
  faskes_id       INT REFERENCES fasilitas_kesehatan(id),
  wilayah_id      INT REFERENCES wilayah(id),
  pembuat_id      INT REFERENCES users(id),
  data_laporan    JSON,
  file_path       VARCHAR(255),
  status          ENUM('draft','final','disetujui') DEFAULT 'draft',
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### `audit_log` — Log Aktivitas
```sql
CREATE TABLE audit_log (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  user_id         INT REFERENCES users(id),
  aksi            VARCHAR(100) NOT NULL,
  tabel           VARCHAR(50),
  record_id       INT,
  data_lama       JSON,
  data_baru       JSON,
  ip_address      VARCHAR(45),
  user_agent      TEXT,
  created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

## 📱 TAMPILAN TENAGA KESEHATAN (Desktop Admin)

### Layout Utama
```
┌─────────────────────────────────────────────────────────────────┐
│  TOPBAR: Logo | Breadcrumb | Notifikasi | Profile Dropdown      │
├──────────────┬──────────────────────────────────────────────────┤
│              │                                                  │
│   SIDEBAR    │              MAIN CONTENT                        │
│   (240px)    │              (fluid)                             │
│              │                                                  │
│  - Dashboard │                                                  │
│  - Data Anak │                                                  │
│  - Pemeriksaan│                                                  │
│  - Posyandu  │                                                  │
│  - Konsultasi│                                                  │
│  - Edukasi   │                                                  │
│  - Laporan   │                                                  │
│  - Manajemen │                                                  │
│  - Pengaturan│                                                  │
│              │                                                  │
└──────────────┴──────────────────────────────────────────────────┘
```

### Halaman & Fitur Admin

#### 1. 📊 Dashboard Nakes
- **Ringkasan Statistik:**
  - Total anak terdaftar (dengan tren perubahan)
  - Anak status gizi normal / berisiko / gangguan
  - Pemeriksaan hari ini / bulan ini
  - Jumlah konsultasi pending
- **Grafik:**
  - Distribusi status gizi (Pie Chart — Chart.js)
  - Tren pemeriksaan 6 bulan terakhir (Line Chart)
  - Prevalensi stunting per wilayah (Bar Chart)
  - Heatmap kehadiran posyandu
- **Tabel Terkini:**
  - Pemeriksaan terbaru (5 data)
  - Anak berisiko / kasus aktif
  - Jadwal posyandu mendatang
- **Widget Cuaca / Tanggal Posyandu Berikutnya**
- **Alert Anak Tidak Datang 2 Bulan Berturut-turut**

#### 2. 👧 Manajemen Data Anak
- **Tabel Data Anak** dengan filter:
  - Nama, NIK, usia, jenis kelamin
  - Status gizi, wilayah, faskes
  - Tanggal lahir range
  - Search real-time
- **Aksi Per Baris:**
  - Lihat profil lengkap
  - Tambah pemeriksaan
  - Riwayat lengkap
  - Edit data
  - Nonaktifkan / arsip
- **Form Tambah / Edit Anak:**
  - Data identitas lengkap
  - Upload foto anak
  - Pilih orang tua (autocomplete)
  - Riwayat lahir
  - Nomor BPJS / KIA
- **Profil Detail Anak:**
  - Header: Foto, nama, usia, status gizi badge
  - Tab: Pemeriksaan | Imunisasi | Konsumsi Makanan | Riwayat Penyakit | Konsultasi | Edukasi
  - Grafik pertumbuhan interaktif (BB/U, TB/U, BB/TB, IMT/U) dengan garis referensi WHO
  - Timeline riwayat pemeriksaan

#### 3. 📏 Pemeriksaan Antropometri
- **Form Input Pemeriksaan:**
  - Pilih anak (autocomplete dengan foto preview)
  - Input BB, TB, LiLA, LK, lingkar perut, lingkar dada
  - Kalkulasi otomatis Z-score berdasarkan standar WHO
  - Preview status gizi real-time saat input
  - Input tanda vital
  - Checklist intervensi (Vit A, Fe, Zinc, PMT)
  - Toggle rujukan dengan tujuan
  - Catatan pemeriksaan
- **Tabel Riwayat Pemeriksaan:**
  - Filter periode, status gizi, nakes, posyandu
  - Export ke Excel/PDF
  - Print kartu KMS digital

#### 4. 🏥 Manajemen Posyandu
- **Jadwal Posyandu:** Kalender view + list view
- **Form Buat Jadwal:** Tanggal, jam, lokasi, tema, petugas
- **Absensi Digital:**
  - QR Code scan untuk anak hadir
  - Manual toggle per anak
  - Statistik kehadiran vs target
- **Laporan Hasil Posyandu:**
  - D/S, N/D, K/S ratio (indikator posyandu)
  - Distribusi status gizi hari ini
  - Daftar anak tidak hadir

#### 5. 💬 Konsultasi Gizi
- **Inbox Konsultasi:** List pertanyaan/chat dari orang tua
- **Chat Interface:** Real-time-like chat (polling/SSE)
- **Jadwal Video Call:** Booking, reminder
- **Template Jawaban:** Jawaban cepat untuk pertanyaan umum
- **Status Kasus:** Buka / Tutup konsultasi

#### 6. 📚 Konten Edukasi
- **Manajemen Artikel:** CRUD artikel gizi/kesehatan
- **Manajemen Resep MPASI:** CRUD resep dengan nilai gizi
- **Rich Text Editor** (Quill.js atau TinyMCE via CDN)
- **Publish / Draft / Preview**

#### 7. 📈 Laporan & Analitik
- **Laporan Bulanan Posyandu** (D/S, N/D, BGM, BMS)
- **Laporan Prevalensi Stunting** per wilayah
- **Laporan Gizi Mikro** (defisiensi besi, vitamin A)
- **Export:** PDF, Excel, CSV
- **Print Preview**
- **Kirim ke Puskesmas / Dinas Kesehatan**

#### 8. ⚙️ Manajemen Sistem (Superadmin)
- **Manajemen User:** CRUD nakes, verifikasi akun
- **Manajemen Wilayah:** Hierarki administratif
- **Manajemen Faskes:** Puskesmas, posyandu
- **Standar Antropometri:** Input/update tabel WHO
- **Pengaturan Notifikasi Otomatis**
- **Audit Log:** Semua aktivitas sistem
- **Backup Data**

---

## 📱 TAMPILAN ORANG TUA (Mobile Web App)

### Layout Mobile
```
┌─────────────────────┐
│  STATUSBAR          │
│  Header (Logo+Notif)│
├─────────────────────┤
│                     │
│    KONTEN UTAMA     │
│    (scrollable)     │
│                     │
│                     │
│                     │
│                     │
├─────────────────────┤
│  BOTTOM NAVIGATION  │
│  🏠  👧  📊  💬  👤 │
│ Home Anak Grafik Chat Profil│
└─────────────────────┘
```

### Bottom Navigation Bar
```html
<nav class="bottom-nav">
  <a href="#home" class="nav-item active">
    <i class="fas fa-home"></i>
    <span>Beranda</span>
  </a>
  <a href="#anak" class="nav-item">
    <i class="fas fa-child"></i>
    <span>Anak Saya</span>
  </a>
  <a href="#grafik" class="nav-item">
    <i class="fas fa-chart-line"></i>
    <span>Grafik</span>
  </a>
  <a href="#konsultasi" class="nav-item">
    <i class="fas fa-comments"></i>
    <span>Konsultasi</span>
  </a>
  <a href="#profil" class="nav-item">
    <i class="fas fa-user-circle"></i>
    <span>Profil</span>
  </a>
</nav>
```

### CSS Bottom Navigation
```css
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  height: 65px;
  background: var(--sigap-white);
  display: flex;
  align-items: center;
  justify-content: space-around;
  box-shadow: 0 -4px 20px rgba(0,0,0,0.12);
  border-top: 1px solid var(--sigap-border);
  z-index: 1000;
  padding-bottom: env(safe-area-inset-bottom);
}

.bottom-nav .nav-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 3px;
  padding: 8px 16px;
  color: var(--sigap-gray);
  text-decoration: none;
  font-size: 11px;
  font-weight: 600;
  transition: var(--transition);
  position: relative;
}

.bottom-nav .nav-item i {
  font-size: 22px;
  transition: var(--transition);
}

.bottom-nav .nav-item.active {
  color: var(--sigap-primary);
}

.bottom-nav .nav-item.active i {
  transform: translateY(-2px);
}

.bottom-nav .nav-item.active::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 40px;
  height: 3px;
  background: var(--sigap-primary);
  border-radius: 0 0 4px 4px;
}

/* Badge notifikasi */
.bottom-nav .nav-item .badge-dot {
  position: absolute;
  top: 6px;
  right: 12px;
  width: 8px;
  height: 8px;
  background: var(--sigap-accent);
  border-radius: 50%;
  border: 2px solid var(--sigap-white);
}
```

### Halaman & Fitur Orang Tua

#### 1. 🏠 Beranda
- **Greeting Card:** Halo [Nama], [Waktu] - Selamat Pagi/Siang/Sore/Malam
- **Pilih Anak** (jika lebih dari 1 anak) — Horizontal scroll card
- **Kartu Status Anak:**
  - Foto, nama, usia, berat terakhir, tinggi terakhir
  - Badge status gizi berwarna
  - Tanggal pemeriksaan terakhir
- **Shortcut Aksi:**
  - Input makan hari ini
  - Lihat jadwal posyandu
  - Konsultasi nakes
- **Artikel Edukasi Terkini** (Horizontal scroll)
- **Pengingat:**
  - Imunisasi berikutnya
  - Jadwal posyandu
  - Kontrol gizi

#### 2. 👧 Data Anak Saya
- **List Anak Terdaftar** (Card per anak)
- **Detail Anak:**
  - Foto + info dasar
  - Status gizi saat ini (visual badge besar)
  - Pemeriksaan terakhir
  - Grafik BB mini preview
- **Tambah Anak Baru** (dengan persetujuan nakes)
- **Tab Detail:**
  - Riwayat pengukuran
  - Jadwal imunisasi
  - Food diary
  - Riwayat konsultasi

#### 3. 📊 Grafik Pertumbuhan
- **Pilih Anak & Indikator** (BB/U, TB/U, BB/TB, IMT/U)
- **Grafik Interaktif** dengan garis referensi WHO (z-score -3,-2,-1,0,+1,+2,+3)
- **Plot titik pengukuran** dengan tooltip tanggal + nilai
- **Interpretasi Grafik** (keterangan sederhana untuk orang tua)
- **Bandingkan dengan Usia** (rata-rata anak sebaya)

#### 4. 💬 Konsultasi Gizi
- **Daftar Konsultasi** (aktif & riwayat)
- **Buat Konsultasi Baru:**
  - Pilih anak
  - Pilih nakes / biarkan sistem menugaskan
  - Tulis pertanyaan / topik
  - Pilih tipe (chat / jadwal tatap muka)
- **Chat Interface:** Bubble chat simpel dan bersih
- **Rating & Ulasan** setelah konsultasi selesai

#### 5. 🍽️ Catatan Makan (Food Diary)
- **Input Makan Harian:** Form simpel dengan pilihan waktu makan
- **Autocomplete** nama makanan dari database TKPI
- **Estimasi Gizi Otomatis** dari input makanan
- **Ringkasan Harian:** Total kalori, protein, karbohidrat, lemak
- **Perbandingan dengan AKG** usia anak

#### 6. 👤 Profil & Pengaturan
- **Data Profil Orang Tua** (edit nama, foto, nomor HP)
- **Ubah Password**
- **Pengaturan Notifikasi** (push/email toggle)
- **Bahasa** (Indonesia / lokal)
- **Kebijakan Privasi / Tentang Aplikasi**
- **Tombol Logout** (dengan konfirmasi SweetAlert)

---

## 🔔 SWEETALERT2 — PANDUAN PENGGUNAAN

### Notifikasi Berhasil
```javascript
Swal.fire({
  icon: 'success',
  title: 'Berhasil!',
  text: 'Data pemeriksaan berhasil disimpan.',
  confirmButtonColor: '#2E86AB',
  timer: 2500,
  timerProgressBar: true,
  showConfirmButton: false
});
```

### Notifikasi Gagal
```javascript
Swal.fire({
  icon: 'error',
  title: 'Gagal!',
  text: 'Terjadi kesalahan. Silakan coba lagi.',
  confirmButtonColor: '#FF6B6B',
  confirmButtonText: 'Coba Lagi'
});
```

### Konfirmasi Hapus Data
```javascript
Swal.fire({
  title: 'Hapus Data Anak?',
  text: 'Data yang dihapus tidak dapat dikembalikan!',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#FF6B6B',
  cancelButtonColor: '#6c757d',
  confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
  cancelButtonText: 'Batal',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
    // Jalankan fungsi hapus
    deleteRecord(id);
    Swal.fire({
      icon: 'success',
      title: 'Terhapus!',
      text: 'Data berhasil dihapus.',
      timer: 1800,
      showConfirmButton: false
    });
  }
});
```

### Konfirmasi Logout
```javascript
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
```

### Alert Status Gizi Kritis
```javascript
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
});
```

---

## 🧮 LOGIKA KALKULASI Z-SCORE & STATUS GIZI

### Algoritma Z-Score WHO
```javascript
/**
 * Hitung Z-score menggunakan metode LMS WHO
 * @param {number} measurement - Nilai pengukuran
 * @param {number} median - Nilai median standar WHO (M)
 * @param {number} sd - Standar deviasi (SD)
 * @returns {number} z-score
 */
function calculateZScore(measurement, median, sd) {
  return (measurement - median) / sd;
}

/**
 * Tentukan status gizi berdasarkan Z-score BB/U
 */
function statusBBU(zscore) {
  if (zscore < -3)       return { status: 'Gizi Buruk',   class: 'danger',   color: '#C0392B' };
  if (zscore < -2)       return { status: 'Gizi Kurang',  class: 'warning',  color: '#FFB347' };
  if (zscore <= 1)       return { status: 'Gizi Baik',    class: 'success',  color: '#57CC99' };
  if (zscore <= 2)       return { status: 'Berisiko Lebih', class: 'info',   color: '#74C0FC' };
  return                        { status: 'Gizi Lebih',   class: 'orange',   color: '#E67E22' };
}

/**
 * Tentukan status gizi berdasarkan Z-score TB/U
 */
function statusTBU(zscore) {
  if (zscore < -3)  return { status: 'Sangat Pendek (Severely Stunted)', class: 'danger' };
  if (zscore < -2)  return { status: 'Pendek (Stunted)',                 class: 'warning' };
  if (zscore <= 3)  return { status: 'Normal',                           class: 'success' };
  return                   { status: 'Tinggi',                           class: 'info' };
}

/**
 * Tentukan status gizi berdasarkan Z-score BB/TB
 */
function statusBBTB(zscore) {
  if (zscore < -3)  return { status: 'Sangat Kurus (Severely Wasted)', class: 'danger' };
  if (zscore < -2)  return { status: 'Kurus (Wasted)',                 class: 'warning' };
  if (zscore <= 1)  return { status: 'Normal',                         class: 'success' };
  if (zscore <= 2)  return { status: 'Gemuk (Overweight)',             class: 'orange' };
  return                   { status: 'Obesitas',                       class: 'purple' };
}
```

---

## 🖼️ KOMPONEN UI REUSABLE

### Card Statistik Admin
```html
<div class="stat-card">
  <div class="stat-card-icon bg-primary-light">
    <i class="fas fa-child text-primary"></i>
  </div>
  <div class="stat-card-body">
    <p class="stat-label">Total Anak Terdaftar</p>
    <h3 class="stat-value">1,247</h3>
    <span class="stat-trend up">
      <i class="fas fa-arrow-up"></i> +12 bulan ini
    </span>
  </div>
</div>
```

### Badge Status Gizi
```html
<!-- Normal -->
<span class="status-badge normal">
  <i class="fas fa-check-circle"></i> Gizi Baik
</span>

<!-- Stunting -->
<span class="status-badge stunting">
  <i class="fas fa-exclamation-triangle"></i> Stunting
</span>

<!-- Wasting -->
<span class="status-badge wasting">
  <i class="fas fa-exclamation-circle"></i> Wasting
</span>

<!-- Obesitas -->
<span class="status-badge obesity">
  <i class="fas fa-weight"></i> Obesitas
</span>
```

### CSS Status Badge
```css
.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 4px 12px;
  border-radius: var(--radius-pill);
  font-size: 12px;
  font-weight: 600;
}

.status-badge.normal    { background: #e8faf0; color: #57CC99; }
.status-badge.stunting  { background: #fff3cd; color: #856404; }
.status-badge.wasting   { background: #fde8e8; color: #FF6B6B; }
.status-badge.severe    { background: #f8d7da; color: #C0392B; }
.status-badge.obesity   { background: #f3e8ff; color: #9B59B6; }
.status-badge.overweight{ background: #fff0e0; color: #E67E22; }
```

### Kartu Anak (Mobile)
```html
<div class="anak-card">
  <div class="anak-card-header">
    <img src="foto-anak.jpg" class="anak-avatar" alt="Foto Anak">
    <div class="anak-info">
      <h4 class="anak-nama">Budi Santoso</h4>
      <p class="anak-usia"><i class="fas fa-birthday-cake"></i> 2 tahun 3 bulan</p>
      <span class="status-badge normal">Gizi Baik</span>
    </div>
  </div>
  <div class="anak-card-stats">
    <div class="stat-item">
      <i class="fas fa-weight"></i>
      <span>12.5 kg</span>
      <small>Berat</small>
    </div>
    <div class="stat-item">
      <i class="fas fa-ruler-vertical"></i>
      <span>88 cm</span>
      <small>Tinggi</small>
    </div>
    <div class="stat-item">
      <i class="fas fa-calendar-check"></i>
      <span>15 Des</span>
      <small>Terakhir periksa</small>
    </div>
  </div>
  <a href="#detail-anak" class="btn btn-primary btn-sm w-100 mt-2">
    <i class="fas fa-eye"></i> Lihat Detail
  </a>
</div>
```

---

## 📁 STRUKTUR FOLDER PROYEK

```
sigap-anak/
│
├── assets/
│   ├── css/
│   │   ├── sigap-main.css          # CSS utama + variabel
│   │   ├── sigap-admin.css         # Khusus tampilan nakes
│   │   ├── sigap-mobile.css        # Khusus tampilan ortu (mobile)
│   │   ├── sigap-components.css    # Komponen UI reusable
│   │   └── sigap-charts.css        # Styling grafik
│   ├── js/
│   │   ├── sigap-app.js            # Inisialisasi global
│   │   ├── sigap-charts.js         # Fungsi grafik Chart.js
│   │   ├── sigap-zscore.js         # Kalkulasi Z-score & status gizi
│   │   ├── sigap-alerts.js         # Fungsi SweetAlert2
│   │   ├── sigap-admin.js          # JS khusus admin
│   │   └── sigap-mobile.js         # JS khusus mobile (bottom nav, dll)
│   └── images/
│       ├── logo-sigap.png
│       ├── logo-sigap-white.png
│       └── default-avatar.png
│
├── views/
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   ├── admin/                      # Nakes (Desktop)
│   │   ├── layout/
│   │   │   ├── header.php
│   │   │   ├── sidebar.php
│   │   │   └── footer.php
│   │   ├── dashboard.php
│   │   ├── anak/
│   │   │   ├── index.php           # Daftar anak
│   │   │   ├── detail.php          # Profil anak lengkap
│   │   │   ├── add.php             # Tambah anak
│   │   │   └── edit.php            # Edit data anak
│   │   ├── pemeriksaan/
│   │   │   ├── index.php           # Daftar pemeriksaan
│   │   │   ├── add.php             # Form input pemeriksaan
│   │   │   └── detail.php
│   │   ├── posyandu/
│   │   │   ├── jadwal.php
│   │   │   ├── absensi.php
│   │   │   └── laporan.php
│   │   ├── konsultasi/
│   │   │   ├── index.php
│   │   │   └── chat.php
│   │   ├── edukasi/
│   │   │   ├── artikel/
│   │   │   └── resep/
│   │   ├── laporan/
│   │   │   ├── bulanan.php
│   │   │   ├── prevalensi.php
│   │   │   └── export.php
│   │   └── manajemen/
│   │       ├── users.php
│   │       ├── wilayah.php
│   │       └── faskes.php
│   │
│   └── mobile/                     # Orang Tua (Mobile)
│       ├── layout/
│       │   ├── header.php
│       │   ├── bottom-nav.php
│       │   └── footer.php
│       ├── home.php
│       ├── anak/
│       │   ├── index.php
│       │   └── detail.php
│       ├── grafik.php
│       ├── konsultasi/
│       │   ├── index.php
│       │   └── chat.php
│       ├── food-diary.php
│       └── profil.php
│
├── controllers/
├── models/
├── config/
└── api/
```

---

## 🔐 AUTENTIKASI & OTORISASI

### Login Page (Shared)
- Halaman login tunggal, redirect berdasarkan role
- Fitur:
  - Email + Password
  - "Ingat Saya" (Remember Me)
  - Lupa Password (via email OTP)
  - Login dengan Google (opsional)
- Setelah login:
  - Role `nakes/*` → redirect ke `/admin/dashboard`
  - Role `orangtua` → redirect ke `/mobile/home`

### Middleware / Guard
```php
// Cek role untuk halaman admin
function requireNakes() {
  if (!in_array($_SESSION['role'], ['superadmin','dokter','bidan','ahli_gizi','kader'])) {
    redirect('/login');
  }
}

// Cek role untuk halaman mobile
function requireOrangtua() {
  if ($_SESSION['role'] !== 'orangtua') {
    redirect('/login');
  }
}
```

### Permission Matrix
| Fitur                        | Superadmin | Dokter | Bidan | Ahli Gizi | Kader | Orang Tua |
|------------------------------|:---------:|:------:|:-----:|:---------:|:-----:|:---------:|
| Lihat semua anak             | ✅ | ✅ | Wilayah | Wilayah | Wilayah | Anak sendiri |
| Input pemeriksaan            | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Edit diagnosis gizi          | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| Kelola posyandu              | ✅ | ✅ | ✅ | ❌ | Terbatas | ❌ |
| Konsultasi                   | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ |
| Input food diary             | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Lihat laporan                | ✅ | ✅ | ✅ | ✅ | Terbatas | ❌ |
| Manajemen user               | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Export data                  | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ |

---

## 📣 SISTEM NOTIFIKASI OTOMATIS

### Trigger Notifikasi
| Kondisi | Target | Pesan |
|---------|--------|-------|
| Anak tidak hadir posyandu 2 bulan berturut | Nakes + Orang Tua | "⚠️ [Nama Anak] belum datang posyandu 2 bulan, segera diperiksa" |
| Status gizi berubah menjadi kritis | Nakes + Orang Tua | "🚨 Status gizi [Nama Anak] terdeteksi [Status], perlu penanganan segera" |
| Jadwal imunisasi H-3 | Orang Tua | "💉 Imunisasi [Jenis] [Nama Anak] dijadwalkan 3 hari lagi" |
| Jadwal posyandu besok | Orang Tua di wilayah | "📅 Posyandu besok jam [Jam] di [Lokasi]" |
| Konsultasi baru masuk | Nakes terkait | "💬 Pesan baru dari [Nama Orang Tua] untuk [Nama Anak]" |
| PMT selesai diberikan | Nakes + Orang Tua | "✅ Program PMT [Nama Anak] telah selesai" |

---

## 🔢 INDIKATOR & FORMULA POSYANDU

### Rumus Indikator Posyandu
```
D/S = (Anak ditimbang / Anak terdaftar) × 100%
     Target: ≥ 85%

N/D = (Anak berat naik / Anak ditimbang) × 100%
     Target: ≥ 60%

K/S = (Anak punya KMS / Anak terdaftar) × 100%
     Target: ≥ 100%

BGM = Bawah Garis Merah (BB/U < -3 SD)
BMS = Bawah Minus Standar (BB/U < -2 SD)
```

---

## ✅ FITUR LENGKAP — CHECKLIST

### Tenaga Kesehatan
- [ ] Dashboard statistik real-time
- [ ] Manajemen data anak (CRUD lengkap)
- [ ] Input pemeriksaan + kalkulasi Z-score otomatis
- [ ] Grafik pertumbuhan interaktif (4 indikator WHO)
- [ ] Manajemen posyandu (jadwal, absensi QR, laporan)
- [ ] Rekam medis gizi & diagnosis
- [ ] Catatan konsumsi makanan & analisis gizi
- [ ] Riwayat imunisasi & pengingat
- [ ] Riwayat penyakit anak
- [ ] Konsultasi online (chat + video call booking)
- [ ] Manajemen konten edukasi & resep MPASI
- [ ] Laporan & ekspor (PDF, Excel)
- [ ] Notifikasi otomatis kasus kritis
- [ ] Manajemen wilayah & fasilitas kesehatan
- [ ] Manajemen user & role
- [ ] Audit log aktivitas
- [ ] Backup & restore data

### Orang Tua
- [ ] Beranda dengan status gizi anak terkini
- [ ] Profil detail anak
- [ ] Grafik pertumbuhan interaktif
- [ ] Riwayat pemeriksaan
- [ ] Jadwal & riwayat imunisasi
- [ ] Food diary harian + estimasi gizi
- [ ] Konsultasi gizi dengan nakes
- [ ] Notifikasi jadwal posyandu & imunisasi
- [ ] Artikel & tips edukasi gizi
- [ ] Resep MPASI
- [ ] Riwayat konsultasi
- [ ] Manajemen profil akun
- [ ] Pengaturan notifikasi

---

## 🚀 PANDUAN IMPLEMENTASI

### Prioritas Pengembangan
1. **Phase 1 — Core:** Auth, manajemen anak, input pemeriksaan, kalkulasi Z-score
2. **Phase 2 — Monitoring:** Grafik pertumbuhan, dashboard statistik, laporan
3. **Phase 3 — Communication:** Konsultasi online, notifikasi, posyandu digital
4. **Phase 4 — Content:** Edukasi, resep MPASI, food diary
5. **Phase 5 — Advanced:** Analytics, export, integrasi sistem pemerintah

### Standar Kode
- Gunakan nama variabel dan fungsi dalam **Bahasa Inggris**
- Komentar kode dalam **Bahasa Indonesia** untuk kemudahan tim lokal
- Validasi input sisi klien (JavaScript) + sisi server (PHP)
- Sanitasi semua input sebelum disimpan ke database
- Gunakan prepared statements untuk semua query

### Responsivitas
- Admin: Desktop (1200px+), Tablet (768px+)
- Mobile (Orang Tua): 320px – 480px optimal
- Breakpoint Bootstrap: `sm:576px` `md:768px` `lg:992px` `xl:1200px`

---

*Rule ini adalah panduan hidup — diperbarui setiap ada penambahan fitur atau perubahan desain sistem SIGAP Anak.*

**Versi:** 1.0.0 | **Dibuat:** 2025 | **Oleh:** Tim Pengembang SIGAP Anak
