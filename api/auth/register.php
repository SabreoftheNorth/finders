<?php
// api/auth/register.php
session_start();
require_once '../../config/db_connect.php';

header('Content-Type: application/json');

// Validasi method request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

// Ambil input dengan aman
$nama    = trim($_POST['nama'] ?? '');
$email   = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$no_telpon = trim($_POST['no_telp'] ?? ''); // Sesuaikan name di form HTML (no_telp)

// Validasi input kosong
if (empty($nama) || empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Nama, Email, dan Password wajib diisi']);
    exit;
}

// 1. Cek apakah email sudah ada di tabel 'akun_user'
$checkQuery = "SELECT id_user FROM akun_user WHERE email = ?";
$stmt = $conn->prepare($checkQuery);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    exit;
}
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email sudah terdaftar, silakan gunakan email lain.']);
    $stmt->close();
    exit;
}
$stmt->close();

// 2. Hash Password (Keamanan)
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// 3. Insert ke tabel 'akun_user' (Kolom: nama, email, password, no_telpon)
$insertQuery = "INSERT INTO akun_user (nama, email, password, no_telpon) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($insertQuery);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Prepare statement failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("ssss", $nama, $email, $passwordHash, $no_telpon);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Registrasi berhasil! Silakan login.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mendaftar: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>