<?php
session_start();
require_once '../../config/db_connect.php';

// Header untuk JSON response
header('Content-Type: application/json');

// Cek keamanan
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mitra') {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit;
}

// Cek method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}

$id_rs = $_SESSION['id_rs'];
$id_penjadwalan = $_POST['id_penjadwalan'] ?? null;
$aksi = $_POST['aksi'] ?? null;

// Validasi input
if (!$id_penjadwalan || !$aksi) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
    exit;
}

// Proses berdasarkan aksi
$query = null;
$message = '';

if ($aksi === 'konfirmasi') {
    // Langsung konfirmasi tanpa perlu input manual, karena pasien sudah pilih sesi jam di booking
    $query = "UPDATE data_penjadwalan SET status='Dikonfirmasi' WHERE id_penjadwalan='$id_penjadwalan' AND id_rs='$id_rs'";
    $message = 'Kunjungan berhasil dikonfirmasi';
} elseif ($aksi === 'selesai') {
    $query = "UPDATE data_penjadwalan SET status='Selesai' WHERE id_penjadwalan='$id_penjadwalan' AND id_rs='$id_rs'";
    $message = 'Kunjungan berhasil diselesaikan';
} elseif ($aksi === 'tolak') {
    $query = "UPDATE data_penjadwalan SET status='Dibatalkan' WHERE id_penjadwalan='$id_penjadwalan' AND id_rs='$id_rs'";
    $message = 'Kunjungan berhasil dibatalkan';
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid action'
    ]);
    exit;
}

// Eksekusi query
if ($query && mysqli_query($conn, $query)) {
    // Cek apakah ada row yang terpengaruh
    if (mysqli_affected_rows($conn) > 0) {
        echo json_encode([
            'success' => true,
            'message' => $message
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Data tidak ditemukan atau tidak ada perubahan'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>
