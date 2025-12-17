<?php
session_start();
require_once '../../config/db_connect.php'; // Panggil file koneksi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form & amankan input (mencegah SQL Injection)
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $no_telpon = mysqli_real_escape_string($conn, $_POST['no_telpon']);
    
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi_password'];

    // 1. Validasi Password Match
    if ($password !== $konfirmasi) {
        echo "<script>alert('Konfirmasi password tidak cocok!'); window.history.back();</script>";
        exit;
    }

    // 2. Cek apakah email sudah terdaftar
    $cek_email = mysqli_query($conn, "SELECT email FROM akun_user WHERE email = '$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Email sudah terdaftar! Gunakan email lain.'); window.history.back();</script>";
        exit;
    }

    // 3. Enkripsi Password (SHA256 sesuai database kamu)
    $password_hash = hash('sha256', $password);

    // 4. Masukkan ke Database
    $query = "INSERT INTO akun_user (nama, email, password, no_telpon) 
              VALUES ('$nama', '$email', '$password_hash', '$no_telpon')";

    if (mysqli_query($conn, $query)) {
        echo "<script>
            alert('Pendaftaran Berhasil! Silakan Login.');
            window.location.href = '../../login.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Jika file diakses langsung tanpa submit form
    header("Location: ../../register.php");
}
?>