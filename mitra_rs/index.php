<?php
session_start();
require_once '../config/db_connect.php';

// 1. Cek Keamanan: Apakah yang login benar-benar Mitra?
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mitra') {
    header("Location: ../login.php");
    exit;
}

$id_rs = $_SESSION['id_rs']; // ID RS milik akun yang login
$hari_ini = date('Y-m-d');

// --- QUERY STATISTIK ---

// 1. Pasien Hari Ini
$q_today = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_penjadwalan WHERE id_rs = '$id_rs' AND tanggal_kunjungan = '$hari_ini' AND status != 'Dibatalkan'");
$total_today = mysqli_fetch_assoc($q_today)['total'];

// 2. Menunggu Konfirmasi
$q_pending = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_penjadwalan WHERE id_rs = '$id_rs' AND status = 'Menunggu'");
$total_pending = mysqli_fetch_assoc($q_pending)['total'];

// 3. Total Layanan Aktif
$q_layanan = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_layanan_rs WHERE id_rs = '$id_rs' AND ketersediaan_layanan = 'Tersedia'");
$total_layanan = mysqli_fetch_assoc($q_layanan)['total'];

// 4. Total Pasien Selesai
$q_selesai = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_penjadwalan WHERE id_rs = '$id_rs' AND status = 'Selesai'");
$total_selesai = mysqli_fetch_assoc($q_selesai)['total'];


// --- QUERY TABEL PASIEN TERBARU ---
$q_recent = mysqli_query($conn, "
    SELECT p.*, l.nama_layanan 
    FROM data_penjadwalan p
    JOIN data_layanan_rs l ON p.id_layanan = l.id_layanan
    WHERE p.id_rs = '$id_rs'
    ORDER BY p.dibuat_pada DESC 
    LIMIT 5
");

$page_title = "Dashboard Mitra";
$page_subtitle = "Ringkasan aktivitas rumah sakit Anda";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Custom scrollbar untuk tabel */
        .custom-scrollbar::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800">

    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto flex flex-col md:pl-20">
        <div class="flex-1 p-6 lg:p-10 w-full">
            
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight"><?= $page_title ?? 'Dashboard' ?></h2>
                    <p class="text-sm text-slate-500 mt-1"><?= $page_subtitle ?? 'Overview operasional rumah sakit.' ?></p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-slate-200 shadow-sm text-sm text-slate-600">
                        <i class="fa-regular fa-calendar text-slate-400"></i>
                        <span><?= date('d F Y') ?></span>
                    </div>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

                <a href="kelola_kunjungan.php" class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group cursor-pointer">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pasien Hari Ini</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-1"><?= $total_today ?></h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-700 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-calendar-day text-xl"></i>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-xs text-gray-400"><?= date('d M Y') ?></span>
                        <i class="fa-solid fa-arrow-right text-xs text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>
                
                <a href="kelola_kunjungan.php" class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group cursor-pointer">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Perlu Konfirmasi</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-1"><?= $total_pending ?></h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-700 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-user-clock text-xl"></i>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-xs text-gray-400">Menunggu respons</span>
                        <i class="fa-solid fa-arrow-right text-xs text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>

                <a href="kelola_layanan.php" class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group cursor-pointer">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Layanan Aktif</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-1"><?= $total_layanan ?></h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-700 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-stethoscope text-xl"></i>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-xs text-gray-400">Poli & Fasilitas</span>
                        <i class="fa-solid fa-arrow-right text-xs text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>

                <a href="kelola_kunjungan.php" class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group cursor-pointer">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Pasien Selesai</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-1"><?= $total_selesai ?></h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-700 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-clipboard-check text-xl"></i>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-xs text-gray-400">Akumulasi Total</span>
                        <i class="fa-solid fa-arrow-right text-xs text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </a>


            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Pendaftaran Terbaru</h3>
                        <p class="text-xs text-gray-500 mt-1">5 pasien terakhir yang mendaftar</p>
                    </div>
                    <a href="jadwal_kelola.php" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-4 py-2 rounded-lg transition-colors">
                        Lihat Semua
                    </a>
                </div>
                
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold tracking-wider">
                            <tr>
                                <th class="px-8 py-4">Pasien</th>
                                <th class="px-6 py-4">Layanan</th>
                                <th class="px-6 py-4">Jadwal</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm text-gray-600">
                            <?php if(mysqli_num_rows($q_recent) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($q_recent)): ?>
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="px-8 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-xs">
                                                    <?= strtoupper(substr($row['nama_pasien'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-800"><?= htmlspecialchars($row['nama_pasien']) ?></p>
                                                    <p class="text-xs text-gray-400"><?= $row['no_telpon'] ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                                                <span><?= htmlspecialchars($row['nama_layanan']) ?></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="font-medium text-gray-700"><?= date('d M Y', strtotime($row['tanggal_kunjungan'])) ?></span>
                                                <span class="text-xs text-gray-400">
                                                    <?= $row['jam_mulai'] ? date('H:i', strtotime($row['jam_mulai'])) . ' - ' . date('H:i', strtotime($row['jam_selesai'])) : 'Belum set jam' ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php 
                                                $status_classes = [
                                                    'Menunggu' => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
                                                    'Dikonfirmasi' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                                    'Selesai' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                                    'Dibatalkan' => 'bg-red-50 text-red-700 border border-red-200'
                                                ];
                                                $class = $status_classes[$row['status']] ?? 'bg-gray-50 text-gray-600';
                                            ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $class ?>">
                                                <?= $row['status'] ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="jadwal_kelola.php?id=<?= $row['id_penjadwalan'] ?>" class="text-gray-400 hover:text-blue-600 transition p-2 rounded-lg hover:bg-blue-50 inline-block" title="Kelola">
                                                <i class="fa-solid fa-pen-to-square text-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fa-regular fa-folder-open text-4xl mb-3 opacity-30"></i>
                                            <p>Belum ada pendaftaran pasien terbaru.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        
        <?php include 'includes/footer.php'; ?>
    </main>

</body>
</html>