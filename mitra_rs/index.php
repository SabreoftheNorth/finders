<?php
session_start();
include '../config/db_connect.php';

// 1. Cek Login & Role
if(!isset($_SESSION['mitra_id']) || $_SESSION['role'] != 'mitra') {
    header("Location: ../login.php");
    exit;
}

$id_rs_saya = $_SESSION['id_rs']; // Ambil ID RS dari session

// 2. Query Data (HANYA milik RS ini)
// Hitung Pasien Menunggu
$q_menunggu = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_penjadwalan WHERE id_rs = '$id_rs_saya' AND status = 'Menunggu'");
$total_menunggu = mysqli_fetch_assoc($q_menunggu)['total'];

// Hitung Pasien Hari Ini
$hari_ini = date('Y-m-d');
$q_today = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_penjadwalan WHERE id_rs = '$id_rs_saya' AND tanggal_kunjungan = '$hari_ini'");
$total_today = mysqli_fetch_assoc($q_today)['total'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Mitra Dashboard - FindeRS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden">

    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Rumah Sakit</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-l-4 border-l-yellow-500">
                <p class="text-gray-500">Perlu Konfirmasi</p>
                <p class="text-3xl font-bold"><?= $total_menunggu ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-l-4 border-l-blue-500">
                <p class="text-gray-500">Kunjungan Hari Ini</p>
                <p class="text-3xl font-bold"><?= $total_today ?></p>
            </div>
        </div>
    </main>

</body>
</html>