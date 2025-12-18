<?php
session_start();
require_once '../../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // 1. Cek di tabel akun_user
    $query_user = "SELECT email FROM akun_user WHERE email = '$email'";
    $result_user = mysqli_query($conn, $query_user);

    // 2. Cek di tabel akun_admin
    $query_admin = "SELECT email FROM akun_admin WHERE email = '$email'";
    $result_admin = mysqli_query($conn, $query_admin);

    // 3. Cek di tabel akun_rumah_sakit
    $query_rs = "SELECT email FROM akun_rumah_sakit WHERE email = '$email'";
    $result_rs = mysqli_query($conn, $query_rs);

    if (mysqli_num_rows($result_user) > 0 || mysqli_num_rows($result_admin) > 0 || mysqli_num_rows($result_rs) > 0) {
        // Email ditemukan, redirect ke halaman reset password
        // Dalam produksi, harusnya kirim email dengan token.
        // Untuk demo, kita langsung redirect dengan email di parameter (TIDAK AMAN untuk produksi)
        header("Location: ../../reset-password.php?email=" . urlencode($email));
        exit;
    } else {
        $_SESSION['error'] = "Email tidak terdaftar dalam sistem!";
        header("Location: ../../forgot-password.php");
        exit;
    }
} else {
    header("Location: ../../forgot-password.php");
    exit;
}
?>

