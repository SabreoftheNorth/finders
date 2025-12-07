<?php
// config/db_connect.php

// Konfigurasi Database (Sesuaikan dengan settingan XAMPP/Localhost kamu)
$host = "localhost";
$user = "root";       // Default user XAMPP biasanya 'root'
$pass = "";           // Default password XAMPP biasanya kosong
$db   = "finder_rs";  // Nama database yang kamu buat

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    // Jika gagal, tampilkan pesan error
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

// Opsional: Set timezone agar waktu transaksi (created_at) sesuai WIB
date_default_timezone_set('Asia/Jakarta');
?>