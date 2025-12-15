<?php
session_start();
require_once '../config/db_connect.php';

if(!isset($_GET['id'])) {
    echo '<div class="text-red-500 text-center py-8">
            <i class="fa-solid fa-exclamation-triangle text-5xl mb-3"></i>
            <p class="text-lg font-semibold">ID rumah sakit tidak ditemukan</p>
          </div>';
    exit;
}

$id_rs = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM data_rumah_sakit WHERE id_rs = '$id_rs'");

if(!$query) {
    echo '<div class="text-red-500 text-center py-8">
            <i class="fa-solid fa-exclamation-triangle text-5xl mb-3"></i>
            <p class="text-lg font-semibold">Error Query</p>
            <p class="text-sm mt-2">' . mysqli_error($conn) . '</p>
          </div>';
    exit;
}

if(mysqli_num_rows($query) == 0) {
    echo '<div class="text-red-500 text-center py-8">
            <i class="fa-solid fa-hospital-slash text-5xl mb-3"></i>
            <p class="text-lg font-semibold">Data rumah sakit tidak ditemukan</p>
            <p class="text-sm text-gray-500 mt-2">ID: ' . htmlspecialchars($id_rs) . '</p>
          </div>';
    exit;
}

$rs = mysqli_fetch_assoc($query);

// Get layanan count
$query_layanan = mysqli_query($conn, "SELECT COUNT(*) as total FROM layanan_rs WHERE id_rs = '$id_rs'");
$layanan_count = $query_layanan ? mysqli_fetch_assoc($query_layanan)['total'] : 0;

// Get jadwal count
$query_jadwal = mysqli_query($conn, "SELECT COUNT(*) as total FROM jadwal_layanan WHERE id_rs = '$id_rs'");
$jadwal_count = $query_jadwal ? mysqli_fetch_assoc($query_jadwal)['total'] : 0;

// Get booking count
$query_booking = mysqli_query($conn, "SELECT COUNT(*) as total FROM booking b 
                                      JOIN jadwal_layanan jl ON b.id_jadwal = jl.id_jadwal 
                                      WHERE jl.id_rs = '$id_rs'");
$booking_count = $query_booking ? mysqli_fetch_assoc($query_booking)['total'] : 0;
?>

<!-- Header Modal Simpel -->
<div class="bg-white -mx-8 -mt-8 mb-6 pb-5 border-b border-gray-200">
    <div class="px-8 pt-6 flex items-center gap-3">
        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
            <i class="fa-solid fa-hospital text-blue-600 text-xl"></i>
        </div>
        <h2 class="text-xl font-bold text-gray-800">Edit Data Rumah Sakit</h2>
    </div>
</div>

<div class="space-y-5 -mx-8 px-8 -mb-8 pb-8">
    <!-- Foto & Info Utama -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <img src="../assets/img/<?= htmlspecialchars($rs['foto']) ?>" 
                     alt="<?= htmlspecialchars($rs['nama_rs']) ?>"
                     class="w-full h-64 object-cover"
                     onerror="this.src='../assets/img/default_rs.jpg'">
            </div>
        </div>

        <!-- Info Utama -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fa-solid fa-id-card text-blue-600"></i>
                    <h3 class="font-semibold text-gray-800">Identitas</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">ID Rumah Sakit</p>
                        <p class="text-lg font-bold text-gray-800">#<?= $rs['id_rs'] ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Nama Rumah Sakit</p>
                        <p class="text-base font-semibold text-gray-800"><?= htmlspecialchars($rs['nama_rs']) ?></p>
                    </div>
                </div>
            </div>

            <!-- Alamat & Wilayah -->
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fa-solid fa-location-dot text-blue-600"></i>
                    <h3 class="font-semibold text-gray-800">Lokasi</h3>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Alamat Lengkap</p>
                        <p class="text-sm text-gray-700"><?= htmlspecialchars($rs['alamat']) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Wilayah</p>
                        <span class="inline-block px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-md text-sm font-medium">
                            <?= htmlspecialchars($rs['wilayah']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Kontak -->
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fa-solid fa-phone text-blue-600"></i>
                    <h3 class="font-semibold text-gray-800">Kontak</h3>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Nomor Telepon</p>
                    <p class="text-base text-gray-800 font-medium"><?= htmlspecialchars($rs['no_telpon']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    <?php if(!empty($rs['deskripsi'])): ?>
    <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
        <div class="flex items-center gap-2 mb-3">
            <i class="fa-solid fa-file-lines text-blue-600"></i>
            <h3 class="font-semibold text-gray-800">Deskripsi</h3>
        </div>
        <p class="text-gray-700 leading-relaxed text-sm"><?= nl2br(htmlspecialchars($rs['deskripsi'])) ?></p>
    </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="flex gap-3 pt-4 sticky bottom-0 bg-white pb-4 border-t border-gray-200 mt-4">
        <button onclick="closeModal()" 
                class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
            <i class="fa-solid fa-xmark"></i>
            Tutup
        </button>
        <button onclick="editRS(<?= $rs['id_rs'] ?>)" 
                class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2 shadow-sm">
            <i class="fa-solid fa-pen-to-square"></i>
            Edit Data RS
        </button>
    </div>
</div>
