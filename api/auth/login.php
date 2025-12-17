<?php
session_start();
require_once '../../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier']); // Email
    $password = $_POST['password'];
    
    // Hash password input user untuk dicocokkan dengan database
    $password_hash = hash('sha256', $password);

    // 1. Cek di tabel USER (Pasien/Umum)
    $query_user = "SELECT * FROM akun_user WHERE email = '$identifier' AND password = '$password_hash'";
    $result_user = mysqli_query($conn, $query_user);

    if (mysqli_num_rows($result_user) > 0) {
        // Login Berhasil sebagai User
        $data = mysqli_fetch_assoc($result_user);
        
        // Set Session
        $_SESSION['user_id'] = $data['id_user'];
        $_SESSION['user_name'] = $data['nama'];
        $_SESSION['role'] = 'pasien';
        
        // Redirect ke Halaman Utama
        header("Location: ../../index.php");
        exit;
    }

    // 2. Cek di tabel ADMIN (Opsional, jika login admin lewat pintu yang sama)
    $query_admin = "SELECT * FROM akun_admin WHERE (email = '$identifier' OR username = '$identifier') AND password = '$password_hash'";
    $result_admin = mysqli_query($conn, $query_admin);

    if (mysqli_num_rows($result_admin) > 0) {
        $data = mysqli_fetch_assoc($result_admin);
        
        $_SESSION['admin_id'] = $data['id_admin'];
        $_SESSION['admin_name'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        header("Location: ../../admin/index.php");
        exit;
    }

    // 3. Cek di tabel AKUN_RUMAH_SAKIT (Mitra RS)
    $query_mitra = "SELECT ars.*, rs.nama_rs 
                    FROM akun_rumah_sakit ars 
                    JOIN data_rumah_sakit rs ON ars.id_rs = rs.id_rs 
                    WHERE (ars.email = '$identifier' OR ars.username = '$identifier') 
                    AND ars.password = '$password_hash' 
                    AND ars.status_akun = 'aktif'";
    $result_mitra = mysqli_query($conn, $query_mitra);

    if (mysqli_num_rows($result_mitra) > 0) {
        $data = mysqli_fetch_assoc($result_mitra);
        
        $_SESSION['mitra_id'] = $data['id_rs_akun'];
        $_SESSION['id_rs'] = $data['id_rs'];
        $_SESSION['mitra_name'] = $data['nama_rs'];
        $_SESSION['role'] = 'mitra';

        header("Location: ../../mitra_rs/index.php");
        exit;
    }

    // Jika Gagal Login
    echo "<script>
        alert('Email atau Password salah!'); 
        window.location.href='../../login.php';
    </script>";

} else {
    header("Location: ../../login.php");
}
?>