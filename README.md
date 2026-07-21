# 📅 Mini SIAKAD — Modul Jadwal Kuliah

> **Kalla Institute** — Prototipe sistem informasi akademik berbasis Laravel 13 yang mencakup manajemen jadwal kuliah, dosen, mata kuliah, ruangan, dan program studi, lengkap dengan validasi bentrok otomatis dan tampilan grid mingguan.

---

## ✨ Fitur Utama

| Modul | Fitur |
|---|---|
| **Grid Jadwal** | Tampilan jadwal mingguan (Senin–Jumat) per kolom hari, dengan filter kelas & semester |
| **Jadwal (CRUD)** | Tambah, edit, hapus jadwal kuliah dengan pagination 20 item/hal; filter kelas, semester & prodi |
| **Dosen (CRUD)** | Manajemen data dosen (nama, NIDN, email); validasi NIDN & email unik |
| **Mata Kuliah (CRUD)** | Manajemen mata kuliah (kode, nama, SKS, prodi); relasi ke Prodi |
| **Ruangan (CRUD)** | Manajemen ruangan (kode, nama, kapasitas, gedung); validasi kode unik |
| **Validasi Bentrok** | Deteksi otomatis bentrok ruangan & dosen pada hari & rentang waktu yang sama |
| **Export CSV** | Unduh jadwal ke file `.csv` dengan filter kelas & semester yang aktif |

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|---|---|
| **Framework** | Laravel 13 (PHP >= 8.3) |
| **Templating** | Blade |
| **Database** | MySQL / SQLite |
| **CSS** | Vanilla CSS (tanpa framework UI), Google Fonts — Inter |
| **Build Tool** | Vite 8 + laravel-vite-plugin |
| **Dev Tools** | Tailwind CSS 4 (via Vite), concurrently, Laravel Pail, Laravel Pint |

---

## 🗂️ ERD — Entity Relationship Diagram

```
Prodi(id, nama)
    |
    +--< MataKuliah(id, kode, nama, sks, prodi_id)
                |
                +--< Jadwal(id, mata_kuliah_id, dosen_id, ruangan_id,
                            hari, mulai, selesai, kelas, semester)
                           /                       \
               Dosen(id, nama, nidn, email)    Ruangan(id, kode, nama, kapasitas, gedung)
```

**Relasi:**
- `Prodi` → `MataKuliah` : HasMany
- `MataKuliah` → `Jadwal` : HasMany
- `Dosen` → `Jadwal` : HasMany
- `Ruangan` → `Jadwal` : HasMany
- `Jadwal` → `MataKuliah`, `Dosen`, `Ruangan` : BelongsTo

---

## 🚀 Cara Menjalankan

### Prasyarat

- PHP >= 8.3
- Composer
- Node.js & npm
- MySQL atau SQLite
- Laragon / XAMPP / PHP built-in server

---

### 1. Clone & Install Dependencies

```bash
git clone <repo-url>
cd SIAKAD
composer install
npm install
```

> **Shortcut:** Jalankan semuanya sekaligus dengan script `setup`:
> ```bash
> composer run setup
> ```

---

### 2. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` sesuai database yang digunakan:

#### MySQL (Laragon/XAMPP)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siakad
DB_USERNAME=root
DB_PASSWORD=
```

#### SQLite (alternatif cepat)

```env
DB_CONNECTION=sqlite
# DB_DATABASE tidak perlu diisi (default: database/database.sqlite)
```

---

### 3. Buat Database & Jalankan Migrasi + Seeder

```bash
php artisan migrate --seed
```

Seeder akan mengisi data awal:
- **DosenSeeder** — beberapa data dosen contoh
- **MataKuliahSeeder** — 8 mata kuliah (IF101–IF601, MA101, MA201)
- **RuanganSeeder** — beberapa ruang kelas
- **JadwalSeeder** — jadwal contoh untuk grid mingguan

---

### 4. Build Aset Frontend

```bash
npm run build
```

Atau untuk development (hot reload):

```bash
npm run dev
```

---

### 5. Jalankan Server Lokal

```bash
php artisan serve
```

Akses di: **[http://localhost:8000](http://localhost:8000)**

> Root URL (`/`) akan otomatis redirect ke **Grid Jadwal**.

#### Jalankan semua sekaligus (server + queue + log + vite)

```bash
composer run dev
```

---

## 🗺️ Daftar Route

| Method | URL | Route Name | Keterangan |
|---|---|---|---|
| GET | `/` | — | Redirect ke `jadwal.grid` |
| GET | `/jadwal-grid` | `jadwal.grid` | Grid jadwal mingguan |
| GET | `/jadwal-export` | `jadwal.export` | Download CSV jadwal |
| GET | `/jadwal` | `jadwal.index` | Daftar jadwal (list + filter) |
| GET | `/jadwal/create` | `jadwal.create` | Form tambah jadwal |
| POST | `/jadwal` | `jadwal.store` | Simpan jadwal baru |
| GET | `/jadwal/{id}/edit` | `jadwal.edit` | Form edit jadwal |
| PUT/PATCH | `/jadwal/{id}` | `jadwal.update` | Update jadwal |
| DELETE | `/jadwal/{id}` | `jadwal.destroy` | Hapus jadwal |
| GET/POST/PUT/DELETE | `/dosen/...` | `dosen.*` | CRUD dosen |
| GET/POST/PUT/DELETE | `/mata-kuliah/...` | `mata-kuliah.*` | CRUD mata kuliah |
| GET/POST/PUT/DELETE | `/ruangan/...` | `ruangan.*` | CRUD ruangan |

---

## 🔒 Logika Validasi Bentrok

Fungsi `cekBentrok()` di `JadwalController` mendeteksi jadwal yang bertabrakan secara waktu pada hari yang sama menggunakan tiga kondisi overlap:

```
Jadwal A overlaps Jadwal B jika:
  A.mulai   ada dalam [B.mulai, B.selesai], atau
  A.selesai ada dalam [B.mulai, B.selesai], atau
  A.mulai <= B.mulai DAN A.selesai >= B.selesai
```

Jika **ruangan** atau **dosen** yang sama sudah terjadwal pada rentang waktu tersebut, sistem akan melempar `ValidationException` dengan pesan error yang spesifik.

---

## 📁 Struktur Folder

```
SIAKAD/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DosenController.php
│   │   │   ├── JadwalController.php       ← berisi cekBentrok() & exportCsv()
│   │   │   ├── MataKuliahController.php
│   │   │   └── RuanganController.php
│   │   └── Requests/
│   │       ├── StoreJadwalRequest.php
│   │       └── UpdateJadwalRequest.php
│   └── Models/
│       ├── Dosen.php
│       ├── Jadwal.php                     ← relasi ke MataKuliah, Dosen, Ruangan
│       ├── MataKuliah.php                 ← relasi ke Prodi & Jadwal
│       ├── Prodi.php
│       ├── Ruangan.php
│       └── User.php
│
├── database/
│   ├── migrations/
│   │   ├── ..._create_dosens_table.php
│   │   ├── ..._create_mata_kuliahs_table.php
│   │   ├── ..._create_ruangans_table.php
│   │   ├── ..._create_jadwals_table.php
│   │   ├── ..._create_prodis_table.php
│   │   └── ..._add_prodi_id_to_mata_kuliahs_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── DosenSeeder.php
│       ├── JadwalSeeder.php
│       ├── MataKuliahSeeder.php
│       └── RuanganSeeder.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php              ← sidebar nav, topbar, flash alert
│       ├── jadwal/
│       │   ├── index.blade.php            ← tabel + filter + pagination
│       │   ├── grid.blade.php             ← grid mingguan per hari
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── dosen/
│       ├── mata-kuliah/
│       ├── ruangan/
│       └── welcome.blade.php
│
├── routes/
│   └── web.php
│
├── public/
│   ├── css/app.css                        ← stylesheet utama (Vanilla CSS)
│   ├── js/app.js
│   └── images/logo.png
│
├── vite.config.js
├── composer.json
└── package.json
```

---

## 📊 Kriteria Penilaian

| Aspek | Bobot | Implementasi |
|---|---|---|
| **Fungsional** | 40 | CRUD lengkap 5 entitas (Dosen, MataKuliah, Ruangan, Jadwal, Prodi) |
| **Validasi** | 20 | Bentrok ruangan & dosen via `cekBentrok()`, validasi form tiap controller |
| **Kualitas Kode** | 20 | Arsitektur MVC, Eloquent ORM, Resource Controller, PSR-4 autoload |
| **UI/UX** | 10 | Grid mingguan, filter multi-kriteria (kelas/semester/prodi), sidebar navigasi, responsive |
| **Dokumentasi** | 10 | README ini |
| **Bonus** | +5 | Export CSV jadwal dengan filter aktif |

---

## 👤 Informasi Proyek

- **Institusi:** Kalla Institute
- **Dibuat dengan:** Laravel 13 + Blade + Vanilla CSS
- **Lisensi:** MIT
