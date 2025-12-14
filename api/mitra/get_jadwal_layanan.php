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
$id_layanan = isset($_GET['id_layanan']) ? intval($_GET['id_layanan']) : 0;

if (!$id_layanan) {
    echo json_encode(['success' => false, 'message' => 'ID Layanan tidak valid']);
    exit;
}

// Ambil data jadwal untuk layanan tertentu
$query = "SELECT 
    id_jadwal,
    hari,
    jam_buka_praktek,
    jam_tutup_praktek,
    kuota_per_sesi
FROM data_jadwal_layanan
WHERE id_layanan = '$id_layanan'
ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
    exit;
}

$jadwal = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jadwal[] = [
        'id_jadwal' => $row['id_jadwal'],
        'hari' => $row['hari'],
        'jam_buka' => substr($row['jam_buka_praktek'], 0, 5), // HH:MM
        'jam_tutup' => substr($row['jam_tutup_praktek'], 0, 5), // HH:MM
        'kuota' => $row['kuota_per_sesi']
    ];
}

echo json_encode([
    'success' => true,
    'jadwal' => $jadwal
]);
?>
