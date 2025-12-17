# FindeRS - Healthcare Booking System

## Instalasi dan Konfigurasi Database

Langkah ini berlaku baik untuk Windows maupun Linux.

1.  **Siapkan Database**
    - Buka browser dan akses phpMyAdmin di `http://localhost/phpmyadmin`.
    - Klik tab **Databases**.
    - Buat database baru dengan nama: `finder_rs`.
    - Klik tombol **Create**.

2.  **Impor Struktur dan Data**
    - Pilih database `finder_rs` yang baru dibuat di sidebar kiri.
    - Klik tab **Import** di menu atas.
    - Klik **Choose File** dan cari file `finder_rs.sql` yang berada di dalam folder `database/` di repositori ini.
    - Klik tombol **Go** atau **Kirim** di bagian bawah halaman.
    - Pastikan impor berhasil ditandai dengan pesan sukses berwarna hijau.

3.  **Konfigurasi Koneksi**
    - Buka file `config/db_connect.php` di text editor.
    - Pastikan konfigurasi sesuai dengan setting XAMPP Anda (default biasanya):
      ```php
      $host = "localhost";
      $user = "root";
      $pass = "";
      $db   = "finder_rs";
      ```

---

## Cara Menjalankan di Windows (XAMPP)

1.  **Persiapan Folder**
    - Salin atau pindahkan folder project `finders` ke dalam direktori instalasi XAMPP, biasanya di `C:\xampp\htdocs\`.
    - Struktur akhir harusnya: `C:\xampp\htdocs\finders\`.

2.  **Jalankan Server**
    - Buka aplikasi **XAMPP Control Panel**.
    - Klik tombol **Start** pada modul **Apache** dan **MySQL**.

3.  **Akses Aplikasi**
    - Buka browser (Chrome/Edge/Firefox).
    - Akses URL: `http://localhost/PHP/finders/finders/` atau `http://localhost/finders/` (sesuai struktur folder Anda).

---

## Cara Menjalankan di Linux (XAMPP / LAMPP)

1.  **Persiapan Folder**
    - Salin folder project ke direktori htdocs XAMPP (biasanya di `/opt/lampp/htdocs/`).

2.  **Jalankan Server**
    - Jalankan XAMPP melalui terminal:
      ```bash
      sudo /opt/lampp/lampp start
      ```

3.  **Akses Aplikasi**
    - Buka browser dan akses URL: `http://localhost/finders/` (sesuai struktur folder Anda).

---

## Akun Demo (Data Dummy)

Setelah import database, Anda dapat menggunakan kredensial berikut untuk pengujian sistem:

### 1. Akun Super Admin
- **Email/Username**: `admin@example.com` atau `superadmin`
- **Password**: `password`
- **Akses**: Dashboard Admin (`/admin/index.php`)
- **Fitur**: Mengelola data rumah sakit, layanan, jadwal, dan user

### 2. Akun Mitra Rumah Sakit
Anda dapat login menggunakan **email** atau **username** dari akun rumah sakit berikut:

**RS Fatmawati (Contoh):**
- **Email**: `admin@fatmawati.id`
- **Username**: `admin_fatmawati`
- **Password**: `password`
- **Akses**: Dashboard Mitra RS (`/mitra_rs/index.php`)

**Akun Rumah Sakit Lainnya:**
- RS Cipto Mangunkusumo: `admin@rscm.co.id` / `admin_rscm`
- RS Pondok Indah: `admin@rspondokindah.co.id` / `admin_pi`
- RS Siloam: `admin@siloam.co.id` / `admin_siloam`
- RS Mitra Keluarga: `admin@mitrakeluarga.com` / `admin_mitra`
- RS Premier: `admin@rs-premier.co.id` / `admin_premier`
- RS Pusat Pertamina: `admin@rspp.co.id` / `admin_rspp`
- RSUD Tarakan: `admin@rsudtarakan.jakarta.go.id` / `admin_tarakan`
- RS Dharmais: `admin@dharmais.co.id` / `admin_dharmais`
- RSPI Sulianti: `admin@rspisuliantisaroso.co.id` / `admin_sulianti`

*Semua akun rumah sakit menggunakan password: `password`*

### 3. Akun User (Pasien)
- **Email**: `budi@gmail.com`
- **Password**: `password`
- **Akses**: Halaman Utama User (`/index.php`)
- **Fitur**: Mencari rumah sakit, booking jadwal, melihat riwayat

**Akun User Lainnya:**
- Siti Aminah: `siti@yahoo.com` / `password`
- Ahmad Rizki: `ahmad@gmail.com` / `password`
- Dewi Sartika: `dewi@gmail.com` / `password`
- Eko Prasetyo: `eko@gmail.com` / `password`

**Catatan:** Anda juga dapat mendaftar akun user baru melalui halaman Register.

---

## Cara Login

1. Buka halaman login: `http://localhost/PHP/finders/finders/login.php`
2. Masukkan **email** atau **username** dan **password** sesuai akun yang ingin digunakan
3. Sistem akan otomatis mendeteksi jenis akun dan mengarahkan ke dashboard yang sesuai:
   - **Admin** → Dashboard Admin
   - **Mitra RS** → Dashboard Mitra Rumah Sakit
   - **User** → Halaman Utama User

---

## Troubleshooting

### Masalah: Login Gagal - "Email atau Password salah"

**Solusi:**
1. Pastikan database sudah diimport dengan benar
2. Pastikan password yang digunakan adalah `password` (huruf kecil, tanpa spasi)
3. Untuk Admin, bisa menggunakan email `admin@example.com` atau username `superadmin`
4. Untuk Mitra RS, bisa menggunakan email atau username (contoh: `admin@fatmawati.id` atau `admin_fatmawati`)

### Masalah: Halaman Error 500 atau Database Connection Error

**Solusi:**
1. Pastikan Apache dan MySQL di XAMPP sudah running
2. Periksa konfigurasi di `config/db_connect.php`
3. Pastikan database `finder_rs` sudah dibuat dan diimport
4. Periksa apakah port 80 (Apache) dan 3306 (MySQL) tidak digunakan aplikasi lain

### Masalah: Halaman Tidak Muncul / 404 Not Found

**Solusi:**
1. Pastikan folder project berada di direktori yang benar (`htdocs`)
2. Periksa URL yang digunakan sesuai dengan struktur folder
3. Pastikan file `index.php` ada di root folder project

### Masalah: Password Tidak Bisa Login Setelah Import Database

**Solusi:**
1. Pastikan file `finder_rs.sql` yang diimport adalah versi terbaru (sudah menggunakan SHA256 hash)
2. Jika masih menggunakan versi lama, hapus database dan import ulang file `finder_rs.sql` yang sudah diperbaiki
3. Semua password menggunakan hash SHA256 dari string "password"

---

## Informasi Teknis

- **PHP Version**: 7.4+ (disarankan 8.0+)
- **MySQL Version**: 5.7+ atau MariaDB 10.4+
- **Password Hash**: SHA256
- **Session Management**: PHP Native Session
- **Framework**: Native PHP (tanpa framework)

---

## Struktur Folder

```
finders/
├── admin/              # Dashboard Admin
├── api/                # API Endpoints
│   ├── auth/          # Authentication API
│   ├── booking/       # Booking API
│   └── mitra/         # Mitra RS API
├── assets/            # CSS, JS, Images
├── config/            # Konfigurasi Database
├── database/          # File SQL Database
├── includes/             # Header, Footer, Sidebar
├── mitra_rs/          # Dashboard Mitra Rumah Sakit
├── errors/            # Error Pages
└── index.php          # Halaman Utama
```

---

## Fitur Utama

### Untuk Admin
- Dashboard dengan statistik sistem
- Kelola data rumah sakit
- Kelola layanan rumah sakit
- Kelola jadwal dokter
- Kelola data user

### Untuk Mitra Rumah Sakit
- Dashboard dengan statistik rumah sakit
- Kelola layanan rumah sakit
- Kelola jadwal dokter
- Kelola kunjungan pasien
- Update status booking

### Untuk User (Pasien)
- Pencarian rumah sakit dan layanan
- Booking jadwal dokter
- Lihat riwayat kunjungan
- Profil user
- Detail booking

---

**Selamat menggunakan FindeRS Healthcare Booking System!** 🏥
