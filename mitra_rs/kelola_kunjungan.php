<?php
session_start();
require_once '../config/db_connect.php';

// 1. Cek Keamanan
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mitra') {
    header("Location: ../login.php");
    exit;
}

$id_rs = $_SESSION['id_rs'];

// Fungsi untuk mengubah nama hari ke bahasa Indonesia
function getNamaHari($tanggal) {
    $hari_inggris = date('l', strtotime($tanggal));
    $hari_indonesia = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];
    return $hari_indonesia[$hari_inggris] ?? $hari_inggris;
}

// --- LOGIKA FILTER & PENCARIAN ---
$filter_tanggal = $_GET['tanggal'] ?? ''; 
$filter_status = $_GET['status'] ?? 'Semua';
$search = $_GET['search'] ?? '';

$sql = "SELECT p.*, l.nama_layanan 
        FROM data_penjadwalan p
        JOIN data_layanan_rs l ON p.id_layanan = l.id_layanan
        WHERE p.id_rs = '$id_rs'";

if ($filter_tanggal !== '') {
    $sql .= " AND p.tanggal_kunjungan = '$filter_tanggal'";
}
if ($filter_status !== 'Semua') {
    $sql .= " AND p.status = '$filter_status'";
}
if ($search) {
    $sql .= " AND (p.nama_pasien LIKE '%$search%' OR p.no_telpon LIKE '%$search%')";
}

$sql .= " ORDER BY p.jam_mulai ASC, p.dibuat_pada ASC";
$result = mysqli_query($conn, $sql);

// Hitung statistik untuk cards
$stats_sql = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'Menunggu' THEN 1 ELSE 0 END) as menunggu,
    SUM(CASE WHEN status = 'Dikonfirmasi' THEN 1 ELSE 0 END) as dikonfirmasi,
    SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai,
    SUM(CASE WHEN status = 'Dibatalkan' THEN 1 ELSE 0 END) as dibatalkan
    FROM data_penjadwalan 
    WHERE id_rs = '$id_rs'";

if ($filter_tanggal !== '') {
    $stats_sql .= " AND tanggal_kunjungan = '$filter_tanggal'";
}

$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);

$page_title = "Kelola Kunjungan";
$page_subtitle = "Verifikasi dan atur antrean pasien.";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kunjungan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { height: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        table td, table th {
            border-right: 1px solid #f3f4f6;
        }
        table td:last-child, table th:last-child {
            border-right: none;
        }
        
        table tbody tr {
            border-bottom: 1px solid #f3f4f6;
        }
        
        /* Responsive table headers */
        @media (min-width: 1536px) {
            table th, table td {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        /* Hide date input calendar icon and placeholder */
        #dateInput::-webkit-calendar-picker-indicator {
            opacity: 0;
            cursor: pointer;
            position: absolute;
            right: 0;
            width: 100%;
            height: 100%;
        }
        
        #dateInput::-webkit-datetime-edit {
            opacity: 0;
        }
        
        #dateInput::-webkit-datetime-edit-fields-wrapper {
            opacity: 0;
        }
        
        #dateInput::-webkit-datetime-edit-text {
            opacity: 0;
        }
        
        #dateInput::-webkit-datetime-edit-month-field {
            opacity: 0;
        }
        
        #dateInput::-webkit-datetime-edit-day-field {
            opacity: 0;
        }
        
        #dateInput::-webkit-datetime-edit-year-field {
            opacity: 0;
        }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800">

    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto flex flex-col md:pl-20">
        <div class="flex-1 p-4 md:p-6 lg:p-8 xl:px-12 w-full">
            
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight"><?= $page_title ?></h2>
                    <p class="text-sm text-slate-500 mt-1"><?= $page_subtitle ?></p>
                </div>
            </header>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal</label>
                        <div class="relative">
                            <input type="date" name="tanggal" id="dateInput" value="<?= $filter_tanggal ?>" 
                                   class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                            <input type="text" id="dateDisplay" placeholder="Pilih tanggal (dd-mm-yyyy)" readonly
                                   class="absolute inset-0 w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl pointer-events-none text-sm text-gray-700 z-10">
                        </div>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Status</label>
                        <select name="status" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                            <option value="Semua">Semua Status</option>
                            <option value="Menunggu" <?= $filter_status == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                            <option value="Dikonfirmasi" <?= $filter_status == 'Dikonfirmasi' ? 'selected' : '' ?>>Dikonfirmasi</option>
                            <option value="Selesai" <?= $filter_status == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="Dibatalkan" <?= $filter_status == 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Cari Pasien</label>
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Nama / No. HP"
                               class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    </div>

                    <div class="flex gap-2">
                        <a href="kelola_kunjungan.php" class="inline-flex items-center justify-center py-2 px-8 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition text-sm font-semibold">
                            <i class="fa-solid fa-rotate-right mr-1.5"></i> Reset
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-8 rounded-xl transition text-sm">
                            <i class="fa-solid fa-filter mr-1.5"></i> Filter
                        </button>
                    </div>

                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse min-w-[1200px]">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 text-gray-600 text-xs uppercase font-semibold tracking-wider">
                            <tr>
                                <th class="px-4 xl:px-6 py-4 text-center w-32">Tanggal</th>
                                <th class="px-4 xl:px-6 py-4 text-center w-36">Sesi Jam</th>
                                <th class="px-4 xl:px-6 py-4 text-left">Pasien</th>
                                <th class="px-4 xl:px-6 py-4 text-left">Catatan</th>
                                <th class="px-4 xl:px-6 py-4 text-center w-36">Layanan</th>
                                <th class="px-4 xl:px-6 py-4 text-center w-20">Antrean</th>
                                <th class="px-4 xl:px-6 py-4 text-center w-32">Status</th>
                                <th class="px-4 xl:px-6 py-4 text-center w-36">Kelola</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm text-gray-600">
                            <?php if(mysqli_num_rows($result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr class="hover:bg-blue-50/30 transition-colors">
                                        <td class="px-4 xl:px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col items-center">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <p class="font-bold text-gray-700">
                                                        <?= $row['tanggal_kunjungan'] ? date('d/m/Y', strtotime($row['tanggal_kunjungan'])) : '-' ?>
                                                    </p>
                                                </div>
                                                <p class="text-xs text-gray-400">
                                                    <?= $row['tanggal_kunjungan'] ? getNamaHari($row['tanggal_kunjungan']) : '' ?>
                                                </p>
                                            </div>
                                        </td>

                                        <td class="px-4 xl:px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-regular fa-clock text-blue-500"></i>
                                                <span class="font-bold text-gray-700">
                                                    <?= $row['jam_mulai'] ? date('H:i', strtotime($row['jam_mulai'])) : '-' ?>
                                                </span>
                                            </div>
                                            <span class="text-xs text-gray-700 pl-6">
                                                s/d <?= $row['jam_selesai'] ? date('H:i', strtotime($row['jam_selesai'])) : '-' ?>
                                            </span>
                                        </td>

                                        <td class="px-4 xl:px-6 py-4">
                                            <p class="font-bold text-gray-800"><?= htmlspecialchars($row['nama_pasien']) ?></p>
                                            <p class="text-xs text-gray-400"><?= $row['no_telpon'] ?></p>
                                        </td>

                                        <td class="px-4 xl:px-6 py-4">
                                            <?php if($row['catatan']): ?>
                                                <div class="max-w-xs">
                                                    <span class="inline-block px-2 py-1 bg-yellow-50 text-yellow-700 text-xs rounded border border-yellow-200">
                                                        <i class="fa-solid fa-note-sticky mr-1"></i>
                                                        <?= htmlspecialchars($row['catatan']) ?>
                                                    </span>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400">-</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="px-4 xl:px-6 py-4 text-center">
                                            <span class="bg-blue-50 text-blue-700 py-1 px-3 rounded-full text-xs font-semibold inline-block">
                                                <?= htmlspecialchars($row['nama_layanan']) ?>
                                            </span>
                                        </td>

                                        <td class="px-4 xl:px-6 py-4 text-center">
                                            <?php if($row['queue_number']): ?>
                                                <span class="text-lg font-bold text-slate-700"><?= $row['queue_number'] ?></span>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400">-</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="px-4 xl:px-6 py-4 text-center">
                                            <?php 
                                                $status_classes = [
                                                    'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                                    'Dikonfirmasi' => 'bg-blue-100 text-blue-800',
                                                    'Selesai' => 'bg-emerald-100 text-emerald-800',
                                                    'Dibatalkan' => 'bg-red-100 text-red-800'
                                                ];
                                                $class = $status_classes[$row['status']] ?? 'bg-gray-100 text-gray-600';
                                            ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold <?= $class ?>">
                                                <?= $row['status'] ?>
                                            </span>
                                        </td>

                                        <td class="px-4 xl:px-6 py-4 text-center">
                                            <?php if($row['status'] == 'Menunggu'): ?>
                                                <div class="flex justify-center gap-2">
                                                    <button onclick="openModalKonfirmasi(<?= $row['id_penjadwalan'] ?>, '<?= htmlspecialchars($row['nama_pasien']) ?>')" 
                                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition min-w-[40px]" title="Terima">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                    <button onclick="openModalTolak(<?= $row['id_penjadwalan'] ?>, '<?= htmlspecialchars($row['nama_pasien']) ?>')"
                                                            class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-2 rounded-lg transition min-w-[40px]" title="Tolak">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </div>
                                            <?php elseif($row['status'] == 'Dikonfirmasi'): ?>
                                                <button onclick="openModalSelesai(<?= $row['id_penjadwalan'] ?>, '<?= htmlspecialchars($row['nama_pasien']) ?>')"
                                                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition inline-flex items-center gap-2">
                                                    <i class="fa-solid fa-flag-checkered"></i> Selesai
                                                </button>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400">Selesai</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="px-4 xl:px-6 py-12 text-center text-gray-500">
                                        <i class="fa-regular fa-folder-open text-4xl mb-3 opacity-30 block"></i>
                                        Tidak ada data kunjungan yang sesuai filter.
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

    <div id="modalKonfirmasi" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-check-circle text-2xl text-blue-600"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Terima Kunjungan?</h3>
            <p class="text-sm text-gray-500 mt-2 mb-6">Pasien <span id="konfirmNama" class="font-bold text-blue-600"></span> akan dikonfirmasi untuk sesi jam yang telah dipilih.</p>
            
            <form id="formKonfirmasi" onsubmit="handleSubmit(event, 'konfirmasi')">
                <input type="hidden" name="aksi" value="konfirmasi">
                <input type="hidden" name="id_penjadwalan" id="konfirmId">

                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('modalKonfirmasi')" class="flex-1 py-2 border border-gray-300 rounded-xl text-gray-600">Batal</button>
                    <button type="submit" class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold">Ya, Terima</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalTolak" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-triangle-exclamation text-2xl text-red-600"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Tolak Kunjungan?</h3>
            <p class="text-sm text-gray-500 mt-2 mb-6">Pasien <span id="tolakNama" class="font-bold"></span> akan menerima notifikasi pembatalan.</p>
            
            <form id="formTolak" onsubmit="handleSubmit(event, 'tolak')">
                <input type="hidden" name="aksi" value="tolak">
                <input type="hidden" name="id_penjadwalan" id="tolakId">
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('modalTolak')" class="flex-1 py-2 border border-gray-300 rounded-xl text-gray-600">Batal</button>
                    <button type="submit" class="flex-1 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold">Ya, Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalSelesai" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
            <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-check text-2xl text-emerald-600"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Selesaikan Kunjungan?</h3>
            <p class="text-sm text-gray-500 mt-2 mb-6">Pastikan pasien <span id="selesaiNama" class="font-bold"></span> telah selesai dilayani.</p>
            
            <form id="formSelesai" onsubmit="handleSubmit(event, 'selesai')">
                <input type="hidden" name="aksi" value="selesai">
                <input type="hidden" name="id_penjadwalan" id="selesaiId">
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('modalSelesai')" class="flex-1 py-2 border border-gray-300 rounded-xl text-gray-600">Batal</button>
                    <button type="submit" class="flex-1 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold">Selesaikan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Format tanggal dd-mm-yyyy untuk input date
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('dateInput');
            const dateDisplay = document.getElementById('dateDisplay');
            
            // Fungsi untuk format tanggal dari yyyy-mm-dd ke dd-mm-yyyy
            function formatDateToDDMMYYYY(dateString) {
                if (!dateString) return '';
                const [year, month, day] = dateString.split('-');
                return `${day}-${month}-${year}`;
            }
            
            // Set nilai awal jika ada
            if (dateInput.value) {
                dateDisplay.value = formatDateToDDMMYYYY(dateInput.value);
            }
            
            // Event ketika tanggal dipilih
            dateInput.addEventListener('change', function() {
                if (this.value) {
                    dateDisplay.value = formatDateToDDMMYYYY(this.value);
                } else {
                    dateDisplay.value = '';
                }
            });
            
            // Event ketika dateDisplay diklik, trigger date picker
            dateDisplay.parentElement.addEventListener('click', function() {
                dateInput.showPicker ? dateInput.showPicker() : dateInput.focus();
            });
        });
    
        function openModalKonfirmasi(id, nama) {
            document.getElementById('konfirmId').value = id;
            document.getElementById('konfirmNama').innerText = nama;
            document.getElementById('modalKonfirmasi').classList.remove('hidden');
        }

        function openModalTolak(id, nama) {
            document.getElementById('tolakId').value = id;
            document.getElementById('tolakNama').innerText = nama;
            document.getElementById('modalTolak').classList.remove('hidden');
        }

        function openModalSelesai(id, nama) {
            document.getElementById('selesaiId').value = id;
            document.getElementById('selesaiNama').innerText = nama;
            document.getElementById('modalSelesai').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Handle form submission via AJAX
        function handleSubmit(event, aksi) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            // Disable button dan tampilkan loading
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Memproses...';
            
            // Kirim request ke API
            fetch('../api/booking/update_status.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tutup modal
                    if (aksi === 'konfirmasi') closeModal('modalKonfirmasi');
                    else if (aksi === 'tolak') closeModal('modalTolak');
                    else if (aksi === 'selesai') closeModal('modalSelesai');
                    
                    // Reload halaman untuk menampilkan perubahan
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses permintaan');
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            });
        }
    </script>

</body>
</html>