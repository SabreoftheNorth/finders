<?php
session_start();
require_once '../../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Konfirmasi password tidak cocok!";
        header("Location: ../../reset-password.php?email=" . urlencode($email));
        exit;
    }

    $password_hash = hash('sha256', $password);

    // Cek di tabel mana email terdaftar dan update
    $found = false;

    // 1. Akun User
    $check_user = mysqli_query($conn, "SELECT id_user FROM akun_user WHERE email = '$email'");
    if (mysqli_num_rows($check_user) > 0) {
        $update = mysqli_query($conn, "UPDATE akun_user SET password = '$password_hash' WHERE email = '$email'");
        $found = true;
    }

    // 2. Akun Admin
    if (!$found) {
        $check_admin = mysqli_query($conn, "SELECT id_admin FROM akun_admin WHERE email = '$email'");
        if (mysqli_num_rows($check_admin) > 0) {
            $update = mysqli_query($conn, "UPDATE akun_admin SET password = '$password_hash' WHERE email = '$email'");
            $found = true;
        }
    }

    // 3. Akun Rumah Sakit
    if (!$found) {
        $check_rs = mysqli_query($conn, "SELECT id_rs_akun FROM akun_rumah_sakit WHERE email = '$email'");
        if (mysqli_num_rows($check_rs) > 0) {
            $update = mysqli_query($conn, "UPDATE akun_rumah_sakit SET password = '$password_hash' WHERE email = '$email'");
            $found = true;
        }
    }

    if ($found) {
        echo "<script>
            alert('Password berhasil diperbarui! Silakan login kembali.');
            window.location.href = '../../login.php';
        </script>";
        exit;
    } else {
        $_SESSION['error'] = "Terjadi kesalahan. Email tidak ditemukan saat proses reset.";
        header("Location: ../../forgot-password.php");
        exit;
    }
} else {
    header("Location: ../../login.php");
    exit;
}
?>

