<?php
session_start();
require_once '../config/db_connect.php';

// Cek Login Admin
if(!isset($_SESSION['admin_id'])) {
    // Simpan URL tujuan untuk redirect setelah login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: ../login.php");
    exit;
}

// Handler DELETE
if(isset($_POST['delete_id'])) {
    $id_penjadwalan = mysqli_real_escape_string($conn, $_POST['delete_id']);
    
    $query_delete = mysqli_query($conn, "DELETE FROM data_penjadwalan WHERE id_penjadwalan = '$id_penjadwalan'");
    
    if($query_delete) {
        $_SESSION['success_message'] = "Data penjadwalan berhasil dihapus";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus data: " . mysqli_error($conn);
    }
    
    header("Location: jadwal_data.php");
    exit;
}

// Filter
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$filter_user = isset($_GET['user']) ? mysqli_real_escape_string($conn, $_GET['user']) : '';

// Query dengan filter
$query_sql = "
    SELECT p.*, rs.nama_rs, l.nama_layanan, u.nama as nama_user, u.email as user_email
    FROM data_penjadwalan p
    JOIN data_rumah_sakit rs ON p.id_rs = rs.id_rs
    JOIN data_layanan_rs l ON p.id_layanan = l.id_layanan
    JOIN akun_user u ON p.id_user = u.id_user
    WHERE 1=1
";

if($filter_status) {
    $query_sql .= " AND p.status = '$filter_status'";
}

if($search) {
    $query_sql .= " AND (p.nama_pasien LIKE '%$search%' OR rs.nama_rs LIKE '%$search%' OR p.no_nik LIKE '%$search%')";
}

if($filter_user) {
    $query_sql .= " AND p.id_user = '$filter_user'";
}

$query_sql .= " ORDER BY p.dibuat_pada DESC";

$result = mysqli_query($conn, $query_sql);

$page_title = "Data Penjadwalan";
$page_subtitle = "Kelola semua penjadwalan kunjungan rumah sakit";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjadwalan - Admin FindeRS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden">
    
    <?php include 'includes/sidebar_admin.php'; ?>

    <main class="flex-1 overflow-y-auto">
        <div class="p-6">
            
            <?php include 'includes/header_admin.php'; ?>

            <!-- Filter & Search -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-3">
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                           placeholder="Cari nama pasien, RS, atau NIK..." 
                           class="flex-1 min-w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" <?= $filter_status == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="Dikonfirmasi" <?= $filter_status == 'Dikonfirmasi' ? 'selected' : '' ?>>Dikonfirmasi</option>
                        <option value="Selesai" <?= $filter_status == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="Dibatalkan" <?= $filter_status == 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                    </select>
                    
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                        <i class="fa-solid fa-search mr-2"></i>Cari
                    </button>
                    
                    <a href="jadwal_data.php" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition">
                        Reset
                    </a>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Pasien</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Rumah Sakit</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Layanan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if(mysqli_num_rows($result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                    <?php
                                    $status_class = 'bg-yellow-100 text-yellow-700';
                                    if($row['status'] == 'Dikonfirmasi') $status_class = 'bg-blue-100 text-blue-700';
                                    elseif($row['status'] == 'Selesai') $status_class = 'bg-green-100 text-green-700';
                                    elseif($row['status'] == 'Dibatalkan') $status_class = 'bg-red-100 text-red-700';
                                    ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-800">#<?= $row['id_penjadwalan'] ?></td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-800"><?= htmlspecialchars($row['nama_pasien']) ?></div>
                                            <div class="text-xs text-gray-500">
                                                NIK: <?= $row['no_nik'] ?? '-' ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($row['nama_rs']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($row['nama_layanan']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= date('d M Y', strtotime($row['tanggal_kunjungan'])) ?></td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $status_class ?>">
                                                <?= $row['status'] ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center gap-2">
                                                <button onclick="updateStatus(<?= $row['id_penjadwalan'] ?>)" 
                                                        class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button onclick="deleteJadwal(<?= $row['id_penjadwalan'] ?>)" 
                                                        class="text-red-600 hover:text-red-800 font-medium text-sm">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <i class="fa-solid fa-inbox text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500">Tidak ada data ditemukan</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php include 'includes/footer_admin.php'; ?>
    </main>

    <!-- Modal Overlay untuk Update Status -->
    <div id="modalOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[999] flex items-center justify-center p-4">
        <div id="modalContent" class="bg-white w-[90%] max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl relative">
            <button onclick="closeModal()" 
                class="absolute top-4 right-4 z-10 text-gray-400 hover:text-gray-600 bg-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <div class="p-6">
                Memuat...
            </div>
        </div>
    </div>

    <script>
    // ===== FUNGSI UPDATE STATUS =====
    function updateStatus(id) {
        openModal('jadwal_form.php?id=' + id);
    }

    // ===== FUNGSI DELETE JADWAL =====
    function deleteJadwal(id) {
        if(confirm('Yakin ingin menghapus data penjadwalan ini?\n\nData tidak dapat dikembalikan!')) {
            // Create form untuk POST request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'jadwal_data.php';
            
            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'delete_id';
            inputId.value = id;
            
            form.appendChild(inputId);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // ===== FUNGSI BUKA MODAL =====
    function openModal(url) {
        const overlay = document.getElementById('modalOverlay');
        const content = document.getElementById('modalContent');
        
        if(overlay && content) {
            overlay.classList.remove('hidden');
            
            // Loading state
            content.innerHTML = `
                <div class="bg-white p-6 rounded-2xl shadow-xl flex items-center gap-3 animate-pulse">
                    <div class="w-6 h-6 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                    <span class="font-medium text-gray-600">Memuat data...</span>
                </div>
            `;
            
            // Fetch data
            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.text();
                })
                .then(html => {
                    content.innerHTML = html;
                })
                .catch(err => {
                    console.error('Error:', err);
                    content.innerHTML = `
                        <div class="bg-white p-6 rounded-xl text-red-500 text-center">
                            <i class="fa-solid fa-exclamation-triangle text-4xl mb-3"></i>
                            <p class="font-semibold">Gagal memuat data</p>
                            <p class="text-sm mt-2">${err.message}</p>
                        </div>
                    `;
                });
        }
    }

    // ===== FUNGSI TUTUP MODAL =====
    function closeModal() {
        const overlay = document.getElementById('modalOverlay');
        if(overlay) {
            overlay.classList.add('hidden');
        }
    }

    // Close modal saat klik di luar
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('modalOverlay');
        if(overlay) {
            overlay.addEventListener('click', function(e) {
                if(e.target === this) {
                    closeModal();
                }
            });
        }
    });
    </script>

</body>
</html>
