<?php
header('Content-Type: application/json');
session_start();
require_once '../../config/db_connect.php';

// Cek login mitra
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mitra') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$id_rs = $_SESSION['id_rs'];
$id_layanan = isset($_POST['id_layanan']) ? intval($_POST['id_layanan']) : 0;
$status_baru = isset($_POST['status_baru']) ? $_POST['status_baru'] : '';

// Validasi
if (!$id_layanan) {
    echo json_encode(['success' => false, 'message' => 'ID Layanan tidak valid']);
    exit;
}

if (!in_array($status_baru, ['Tersedia', 'Tidak Tersedia'])) {
    echo json_encode(['success' => false, 'message' => 'Status tidak valid']);
    exit;
}

// Verifikasi layanan milik RS ini
$check = mysqli_query($conn, "SELECT id_layanan FROM data_layanan_rs WHERE id_layanan = '$id_layanan' AND id_rs = '$id_rs'");
if (mysqli_num_rows($check) == 0) {
    echo json_encode(['success' => false, 'message' => 'Layanan tidak ditemukan']);
    exit;
}

// Update status
$status_escaped = mysqli_real_escape_string($conn, $status_baru);
$query = "UPDATE data_layanan_rs SET ketersediaan_layanan = '$status_escaped' WHERE id_layanan = '$id_layanan' AND id_rs = '$id_rs'";

if (mysqli_query($conn, $query)) {
    echo json_encode([
        'success' => true, 
        'message' => 'Status berhasil diubah',
        'new_status' => $status_baru
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal mengubah status: ' . mysqli_error($conn)]);
}
?>
