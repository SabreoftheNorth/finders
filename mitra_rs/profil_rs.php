<?php
session_start();
require_once '../config/db_connect.php';

// 1. Cek Keamanan
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mitra') {
    header("Location: ../login.php");
    exit;
}

$id_rs = $_SESSION['id_rs'];

// 2. Ambil Data Rumah Sakit
$query = mysqli_query($conn, "SELECT * FROM data_rumah_sakit WHERE id_rs = '$id_rs'");
$rs = mysqli_fetch_assoc($query);

$page_title = "Profil Rumah Sakit";
$page_subtitle = "Informasi detail instansi Anda yang tampil di aplikasi.";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Rumah Sakit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800">

    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto flex flex-col md:pl-20">
        <div class="flex-1 p-6 lg:p-8 w-full">
            
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight"><?= $page_title ?></h2>
                    <p class="text-sm text-slate-500 mt-1"><?= $page_subtitle ?></p>
                </div>
            </header>

            <div class="bg-blue-50 p-4 mb-8 rounded-r-xl shadow-sm flex items-start gap-3">
                <div class="p-1"><i class="fa-solid fa-circle-info text-blue-600 text-lg"></i></div>
                <div>
                    <h4 class="font-bold text-blue-800 text-sm">Pemberitahuan</h4>
                    <p class="text-sm text-blue-700 mt-1">
                        Demi menjaga validitas data, perubahan informasi Rumah Sakit (Nama, Alamat, Wilayah) hanya dapat dilakukan oleh <strong>Admin Pusat FindeRS</strong>. 
                        Jika terdapat kesalahan data, silakan hubungi tim support kami.
                    </p>
                </div>
            </div>

            <div class="flex flex-col xl:flex-row gap-6">
                
                <div class="w-full xl:w-5/12">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-full">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-regular fa-image text-blue-500"></i> Foto Instansi
                        </h3>
                        <div class="rounded-xl overflow-hidden shadow-inner border border-gray-100 aspect-video relative group">
                            <img src="../assets/img/<?= htmlspecialchars($rs['foto']) ?>" 
                                 alt="Foto Rumah Sakit" 
                                 class="w-full h-full object-cover transition transform group-hover:scale-105 duration-700"
                                 onerror="this.src='../assets/img/default_rs.jpg'">
                        </div>
                    </div>
                </div>

                <div class="w-full xl:w-7/12">
                    <div class="bg-white p-6 lg:p-8 rounded-2xl shadow-sm border border-gray-100 h-full">
                        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2 pb-4 border-b border-gray-50">
                            <i class="fa-regular fa-building text-blue-500"></i> Detail Instansi
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nama Rumah Sakit</label>
                                <div class="text-lg font-bold text-gray-800 flex items-center gap-3">
                                    <?= htmlspecialchars($rs['nama_rs']) ?>
                                    <i class="fa-solid fa-circle-check text-blue-500 text-sm" title="Terverifikasi"></i>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Wilayah Operasional</label>
                                <div class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-50 text-gray-700 font-medium border border-gray-200">
                                    <i class="fa-solid fa-map-location-dot mr-2 text-gray-400"></i>
                                    <?= htmlspecialchars($rs['wilayah']) ?>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Kontak Darurat / Hotline</label>
                                <div class="text-lg font-medium text-gray-700 font-mono flex items-center gap-2">
                                    <i class="fa-solid fa-phone-volume text-green-500"></i>
                                    <?= htmlspecialchars($rs['no_telpon']) ?>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Status Akun</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                    AKTIF & TERVERIFIKASI
                                </span>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-gray-700 leading-relaxed text-sm">
                                    <i class="fa-solid fa-location-dot mr-2 text-red-400"></i>
                                    <?= htmlspecialchars($rs['alamat']) ?>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi</label>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-gray-600 leading-relaxed text-sm text-justify">
                                    <?= nl2br(htmlspecialchars($rs['deskripsi'])) ?>
                                </div>
                            </div>

                        </div>

                        <div class="mt-8 pt-6 border-t border-dashed border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <p class="text-xs text-gray-400 italic">Terakhir diperbarui: <?= date('d F Y', strtotime($rs['diperbarui_pada'] ?? $rs['dibuat_pada'])) ?></p>
                            
                            <a href="https://wa.me/02112345678 " target="_blank" class="flex items-center gap-2 px-5 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-blue-600 hover:border-blue-300 transition-all shadow-sm">
                                <i class="fa-solid fa-phone text-green-500 text-lg"></i>
                                Hubungi Admin FindeRS
                            </a>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        
        <?php include 'includes/footer.php'; ?>
    </main>

</body>
</html>