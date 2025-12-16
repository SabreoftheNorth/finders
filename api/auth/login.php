<?php

session_start();
require_once '../../config/db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Email dan Password wajib diisi']);
    exit;
}

// --- LOGIKA LOGIN BERTINGKAT (Sesuai Database Baru) ---

// 1. Cek User Biasa (akun_user)
$stmt = $conn->prepare("SELECT id_user, nama, password FROM akun_user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        // Set Session User
        $_SESSION['user_id'] = $row['id_user'];
        $_SESSION['nama']    = $row['nama'];
        $_SESSION['role']    = 'user';
        
        echo json_encode(['status' => 'success', 'message' => 'Login Berhasil', 'redirect' => 'index.php']);
        exit;
    }
}
$stmt->close();

// 2. Cek Admin (akun_admin)
$stmt = $conn->prepare("SELECT id_admin, username, password, role FROM akun_admin WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id_admin'];
        $_SESSION['nama']    = $row['username'];
        $_SESSION['role']    = $row['role']; // 'admin' atau 'super'
        
        echo json_encode(['status' => 'success', 'message' => 'Login Admin Berhasil', 'redirect' => 'admin/index.php']);
        exit;
    }
}
$stmt->close();

// 3. Cek Mitra Rumah Sakit (akun_rumah_sakit)
$stmt = $conn->prepare("SELECT id_rs_akun, id_rs, username, password FROM akun_rumah_sakit WHERE email = ? AND status_akun = 'aktif'");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id_rs_akun'];
        $_SESSION['id_rs']   = $row['id_rs']; // Simpan ID RS untuk akses data RS
        $_SESSION['nama']    = $row['username'];
        $_SESSION['role']    = 'rs';
        
        echo json_encode(['status' => 'success', 'message' => 'Login Mitra RS Berhasil', 'redirect' => 'mitra_rs/index.php']);
        exit;
    }
}
$stmt->close();

// Jika tidak ditemukan di semua tabel
echo json_encode(['status' => 'error', 'message' => 'Email atau Password salah']);
$conn->close();
?>