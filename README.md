# Mini SIAKAD — Modul Jadwal Kuliah

Prototipe modul jadwal kuliah yang rapi, valid, dan siap tumbuh jadi bagian dari SIAKAD penuh.

## Fitur

- CRUD Dosen, Mata Kuliah, Ruangan, Jadwal
- Grid jadwal mingguan (Senin–Sabtu) dengan filter kelas & semester
- Validasi bentrok ruangan dan dosen secara otomatis
- Export CSV jadwal

## Stack

- **Laravel 11** (PHP 8.2+)
- **Blade** templating
- **MySQL** database
- **Vanilla CSS** (tanpa framework UI)

## ERD Ringkas

```
Dosen(id, nama, nidn, email)
MataKuliah(id, kode, nama, sks)
Ruangan(id, kode, nama, kapasitas, gedung)
Jadwal(id, mata_kuliah_id, dosen_id, ruangan_id, hari, mulai, selesai, kelas, semester)
```

## Cara Menjalankan

### 1. Clone & install dependencies

```bash
git clone <repo-url>
cd siakad
composer install
```

### 2. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siakad
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Buat database & jalankan migrasi

```bash
php artisan migrate --seed
```

### 4. Jalankan server lokal

```bash
php artisan serve
```

Akses di: [http://localhost:8000](http://localhost:8000)

## Struktur Folder

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── DosenController.php
│   │   ├── JadwalController.php
│   │   ├── MataKuliahController.php
│   │   └── RuanganController.php
│   └── Requests/
│       ├── StoreJadwalRequest.php
│       └── UpdateJadwalRequest.php
└── Models/
    ├── Dosen.php
    ├── Jadwal.php
    ├── MataKuliah.php
    └── Ruangan.php

database/
├── migrations/
│   ├── ..._create_dosens_table.php
│   ├── ..._create_mata_kuliahs_table.php
│   ├── ..._create_ruangans_table.php
│   └── ..._create_jadwals_table.php
└── seeders/
    ├── DatabaseSeeder.php
    ├── DosenSeeder.php
    ├── JadwalSeeder.php
    ├── MataKuliahSeeder.php
    └── RuanganSeeder.php

resources/views/
├── layouts/app.blade.php
├── dosen/
├── jadwal/
├── mata-kuliah/
└── ruangan/
```

## Kriteria Penilaian

| Aspek | Implementasi |
|---|---|
| Fungsional (40) | CRUD lengkap 4 entitas |
| Validasi (20) | Bentrok ruangan & dosen via `cekBentrok()` |
| Kualitas Kode (20) | MVC, Eloquent, Resource Controller |
| UI/UX (10) | Grid mingguan, filter, responsive |
| Dokumentasi (10) | README ini |
| Bonus | Export CSV |
