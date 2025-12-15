<?php
session_start();
require_once '../config/db_connect.php';

// Cek Login Mitra
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mitra') {
    header("Location: ../login.php");
    exit;
}

$id_rs = $_SESSION['id_rs'];

// --- QUERY DATA LAYANAN ---
$query = mysqli_query($conn, "
    SELECT l.*, 
    (SELECT COUNT(*) FROM data_jadwal_layanan j WHERE j.id_layanan = l.id_layanan) as total_jadwal
    FROM data_layanan_rs l 
    WHERE l.id_rs = '$id_rs' 
    ORDER BY l.nama_layanan ASC
");

$page_title = "Kelola Layanan & Poli";
$page_subtitle = "Atur ketersediaan dan jam operasional layanan medis.";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Layanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Toggle Switch - Fixed positioning */
        .toggle-container {
            position: relative;
            width: 52px;
            height: 28px;
            flex-shrink: 0;
        }
        
        .toggle-label {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 9999px;
            cursor: pointer;
            transition: background-color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .toggle-checkbox {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            appearance: none;
            border: none;
        }
        
        .toggle-checkbox:checked {
            left: 26px;
        }
        
        .toggle-checkbox:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .toggle-label.bg-gray-300 {
            background-color: #d1d5db;
        }
        
        .toggle-label.bg-emerald-500 {
            background-color: #10b981;
        }
        
        /* Card hover effect */
        .service-card {
            transition: all 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-2px);
        }
        
        /* Loading state */
        .loading-overlay {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(4px);
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800">

    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto flex flex-col md:pl-20">
        <div class="flex-1 p-4 lg:p-8 w-full">
            
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight"><?= $page_title ?></h2>
                    <p class="text-sm text-slate-500 mt-1"><?= $page_subtitle ?></p>
                </div>
                <button onclick="openModalTambahLayanan()" 
                        class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Layanan Baru
                </button>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                
                <?php if(mysqli_num_rows($query) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($query)): ?>
                        <?php 
                            $is_active = ($row['ketersediaan_layanan'] == 'Tersedia'); 
                            $text_status = $is_active ? 'text-emerald-600' : 'text-gray-500';
                            $icon_status = $is_active ? 'fa-circle-check' : 'fa-circle-xmark';
                        ?>

                        <!-- Service Card dengan Design Sama -->
                        <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300 service-card">
                            
                            <!-- Header Card -->
                            <div class="p-5 flex justify-between items-start border-b border-gray-200 bg-white">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                        <i class="fa-solid fa-stethoscope text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-base"><?= htmlspecialchars($row['nama_layanan']) ?></h3>
                                        <p class="text-xs text-gray-500 mt-0.5"><?= htmlspecialchars($row['kategori']) ?></p>
                                    </div>
                                </div>
                                
                                <!-- Toggle Switch -->
                                <div class="toggle-container" id="toggle-container-<?= $row['id_layanan'] ?>">
                                    <label for="toggle-<?= $row['id_layanan'] ?>" 
                                           class="toggle-label <?= $is_active ? 'bg-emerald-500' : 'bg-gray-300' ?>"></label>
                                    <input type="checkbox" 
                                           name="toggle-<?= $row['id_layanan'] ?>" 
                                           id="toggle-<?= $row['id_layanan'] ?>" 
                                           class="toggle-checkbox" 
                                           <?= $is_active ? 'checked' : '' ?>
                                           onchange="updateStatus(<?= $row['id_layanan'] ?>, this.checked)">
                                </div>
                            </div>

                            <!-- Body Card -->
                            <div class="p-5">
                                <div class="flex items-center justify-between text-sm mb-3">
                                    <span class="text-gray-500 font-medium">Status Saat Ini</span>
                                    <span class="font-bold flex items-center gap-1.5 <?= $text_status ?>" id="status-text-<?= $row['id_layanan'] ?>">
                                        <i class="fa-solid <?= $icon_status ?>"></i> 
                                        <?= $row['ketersediaan_layanan'] ?>
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-sm mb-5">
                                    <span class="text-gray-500 font-medium">Jadwal Aktif</span>
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-xs font-bold" id="jadwal-count-<?= $row['id_layanan'] ?>">
                                        <?= $row['total_jadwal'] ?> Hari
                                    </span>
                                </div>

                                <button onclick="openModalJadwal(<?= $row['id_layanan'] ?>, '<?= htmlspecialchars($row['nama_layanan']) ?>')" 
                                        class="w-full py-2.5 rounded-lg bg-white border-2 text-blue-600 font-semibold hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center gap-2">
                                    <i class="fa-regular fa-calendar-days"></i> Atur Jadwal & Kuota
                                </button>
                            </div>
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-span-full py-16 text-center text-gray-500 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                        <i class="fa-solid fa-box-open text-5xl mb-4 opacity-20"></i>
                        <p class="text-lg font-medium mb-2">Belum ada layanan yang terdaftar untuk Rumah Sakit ini.</p>
                        <p class="text-sm mb-6">Mulai tambahkan layanan medis yang tersedia di rumah sakit Anda.</p>
                        <button onclick="openModalTambahLayanan()" 
                                class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition inline-flex items-center gap-2">
                            <i class="fa-solid fa-plus"></i> Tambah Layanan Pertama
                        </button>
                    </div>
                <?php endif; ?>

            </div>

        </div>
        <?php include 'includes/footer.php'; ?>
    </main>

    <div id="modalJadwal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl h-[90vh] flex flex-col">
            
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-2xl">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Atur Jadwal & Kuota</h3>
                    <p class="text-sm text-gray-500">Layanan: <span id="modalLayananNama" class="text-blue-600 font-bold"></span></p>
                </div>
                <button onclick="closeModal('modalJadwal')" class="w-8 h-8 flex items-center justify-center bg-white rounded-full text-gray-400 hover:text-red-500 hover:bg-red-50 transition shadow-sm border border-gray-200">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 bg-white custom-scrollbar">
                <form id="formJadwal" method="post" onsubmit="saveJadwal(event)">
                    <input type="hidden" name="id_layanan" id="modalIdLayanan">
                    
                    <div class="space-y-4">
                        <?php 
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        foreach ($days as $day): 
                        ?>
                        <div class="p-4 rounded-xl border border-gray-200 hover:border-blue-200 transition bg-gray-50/50">
                            <div class="flex flex-col md:flex-row gap-4 items-center">
                                
                                <div class="w-full md:w-32 flex items-center gap-3">
                                    <input type="checkbox" name="hari[<?= $day ?>][aktif]" id="hari_<?= $day ?>" value="1" 
                                           class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                           onchange="toggleDayInput('<?= $day ?>')">
                                    <label for="hari_<?= $day ?>" class="font-bold text-gray-700"><?= $day ?></label>
                                </div>

                                <div id="inputs_<?= $day ?>" class="flex-1 grid grid-cols-3 gap-4 opacity-50 pointer-events-none transition-all">
                                    <div>
                                        <label class="text-xs text-gray-500 font-semibold mb-1 block">Buka</label>
                                        <input type="time" name="hari[<?= $day ?>][buka]" class="w-full px-3 py-2 border rounded-lg text-sm bg-white">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 font-semibold mb-1 block">Tutup</label>
                                        <input type="time" name="hari[<?= $day ?>][tutup]" class="w-full px-3 py-2 border rounded-lg text-sm bg-white">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 font-semibold mb-1 block">Kuota/Sesi</label>
                                        <input type="number" name="hari[<?= $day ?>][kuota]" class="w-full px-3 py-2 border rounded-lg text-sm bg-white" placeholder="10">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="p-6 border-t border-gray-100 bg-gray-50 rounded-b-2xl flex justify-end gap-3 -mx-6 -mb-6 mt-6">
                        <button type="button" onclick="closeModal('modalJadwal')" class="px-6 py-2.5 border border-gray-300 text-gray-600 font-semibold rounded-xl hover:bg-white transition">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition flex items-center gap-2">
                            <i class="fa-solid fa-save"></i> Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal Tambah Layanan Baru -->
    <div id="modalTambahLayanan" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
            
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-2xl">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Tambah Layanan Baru</h3>
                    <p class="text-sm text-gray-500">Tambahkan layanan medis untuk rumah sakit Anda</p>
                </div>
                <button onclick="closeModal('modalTambahLayanan')" class="w-8 h-8 flex items-center justify-center bg-white rounded-full text-gray-400 hover:text-red-500 hover:bg-red-50 transition shadow-sm border border-gray-200">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="formTambahLayanan" method="post" onsubmit="simpanLayananBaru(event)">
                <div class="p-6 space-y-4">
                    
                    <div>
                        <label for="nama_layanan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Layanan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="nama_layanan" 
                               name="nama_layanan" 
                               required
                               placeholder="Contoh: Poliklinik Umum, UGD 24 Jam"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="kategori" 
                                name="kategori" 
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Poliklinik">Poliklinik</option>
                            <option value="Spesialis">Spesialis</option>
                            <option value="Penunjang">Penunjang</option>
                            <option value="Rawat Inap">Rawat Inap</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="ketersediaan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status Ketersediaan
                        </label>
                        <select id="ketersediaan" 
                                name="ketersediaan" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                        </select>
                    </div>

                </div>

                <div class="p-6 border-t border-gray-100 bg-gray-50 rounded-b-2xl flex justify-end gap-3">
                    <button type="button" 
                            onclick="closeModal('modalTambahLayanan')" 
                            class="px-6 py-2.5 border border-gray-300 text-gray-600 font-semibold rounded-xl hover:bg-white transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Layanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Buka Modal Tambah Layanan
        function openModalTambahLayanan() {
            const modal = document.getElementById('modalTambahLayanan');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            // Reset form
            document.getElementById('formTambahLayanan').reset();
        }

        // Simpan Layanan Baru
        function simpanLayananBaru(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            
            // Tampilkan loading state
            const modal = document.getElementById('modalTambahLayanan');
            const btnSimpan = modal.querySelector('button[type="submit"]');
            const btnBatal = modal.querySelector('button[type="button"]');
            const originalText = btnSimpan.innerHTML;
            
            btnSimpan.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...';
            btnSimpan.disabled = true;
            btnBatal.disabled = true;

            fetch('/finders/api/mitra/tambah_layanan.php', { 
                method: 'POST',
                body: formData
            })
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(data => {
                if(data.success) {
                    showNotification('Layanan berhasil ditambahkan!', 'success');
                    
                    setTimeout(() => {
                        closeModal('modalTambahLayanan');
                        // Reload halaman untuk menampilkan layanan baru
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification('Gagal menambahkan layanan: ' + (data.message || 'Unknown error'), 'error');
                    btnSimpan.innerHTML = originalText;
                    btnSimpan.disabled = false;
                    btnBatal.disabled = false;
                }
            })
            .catch(err => {
                console.error('Error:', err);
                showNotification('Terjadi kesalahan koneksi', 'error');
                btnSimpan.innerHTML = originalText;
                btnSimpan.disabled = false;
                btnBatal.disabled = false;
            });
        }

        // Update Status Layanan dengan Loading & Animation
        function updateStatus(id, isChecked) {
            const status = isChecked ? 'Tersedia' : 'Tidak Tersedia';
            const checkbox = document.getElementById('toggle-' + id);
            const toggleContainer = document.getElementById('toggle-container-' + id);
            const toggleLabel = toggleContainer.querySelector('.toggle-label');
            const textEl = document.getElementById('status-text-' + id);
            const cardParent = checkbox.closest('.service-card');
            
            // Disable checkbox sementara
            checkbox.disabled = true;
            
            // Tambahkan efek loading
            toggleContainer.style.opacity = '0.6';
            cardParent.style.pointerEvents = 'none';
            
            const formData = new FormData();
            formData.append('id_layanan', id);
            formData.append('status_baru', status);

            fetch('/finders/api/mitra/update_status_layanan.php', { method: 'POST', body: formData })
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    if (!data.success) throw new Error(data.message || 'Unknown error');
                    
                    // Update UI dengan animasi
                    setTimeout(() => {
                        if (isChecked) {
                            textEl.className = 'font-bold flex items-center gap-1.5 text-emerald-600';
                            textEl.innerHTML = '<i class="fa-solid fa-circle-check"></i> Tersedia';
                            toggleLabel.className = 'toggle-label bg-emerald-500';
                        } else {
                            textEl.className = 'font-bold flex items-center gap-1.5 text-gray-500';
                            textEl.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Tidak Tersedia';
                            toggleLabel.className = 'toggle-label bg-gray-300';
                        }
                        
                        // Enable kembali
                        checkbox.disabled = false;
                        toggleContainer.style.opacity = '1';
                        cardParent.style.pointerEvents = 'auto';
                        
                        // Tampilkan notifikasi sukses
                        showNotification(`Layanan berhasil diubah menjadi ${status}`, 'success');
                    }, 200);
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Kembalikan checkbox ke posisi semula jika gagal
                    checkbox.checked = !isChecked;
                    checkbox.disabled = false;
                    toggleContainer.style.opacity = '1';
                    cardParent.style.pointerEvents = 'auto';
                    showNotification('Gagal mengubah status layanan', 'error');
                });
        }

        // Buka Modal & Load Data Jadwal
        function openModalJadwal(id, nama) {
            const modal = document.getElementById('modalJadwal');
            modal.classList.remove('hidden');
            document.getElementById('modalLayananNama').textContent = nama;
            document.getElementById('modalIdLayanan').value = id;
            document.body.style.overflow = 'hidden';

            // Reset form dulu
            document.getElementById('formJadwal').reset();
            document.querySelectorAll('[id^="inputs_"]').forEach(el => {
                el.classList.add('opacity-50', 'pointer-events-none');
            });

            // Tampilkan loading state
            const formContent = document.querySelector('#modalJadwal .overflow-y-auto');
            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'absolute inset-0 loading-overlay flex items-center justify-center z-10';
            loadingOverlay.innerHTML = '<div class="text-center"><i class="fa-solid fa-circle-notch fa-spin text-3xl text-blue-600 mb-2"></i><p class="text-sm text-gray-600">Memuat jadwal...</p></div>';
            formContent.style.position = 'relative';
            formContent.appendChild(loadingOverlay);

            // Fetch Data Jadwal dari API baru
            fetch('/finders/api/mitra/get_jadwal_layanan.php?id_layanan=' + id)
                .then(res => {
                    if (!res.ok) throw new Error('Network error');
                    return res.json();
                })
                .then(data => {
                    // Hapus loading overlay
                    loadingOverlay.remove();
                    
                    if(data.success && data.jadwal && data.jadwal.length > 0) {
                        data.jadwal.forEach(j => {
                            const day = j.hari;
                            const checkbox = document.getElementById('hari_' + day);
                            if(checkbox) {
                                checkbox.checked = true;
                                toggleDayInput(day);
                                document.querySelector(`input[name="hari[${day}][buka]"]`).value = j.jam_buka;
                                document.querySelector(`input[name="hari[${day}][tutup]"]`).value = j.jam_tutup;
                                document.querySelector(`input[name="hari[${day}][kuota]"]`).value = j.kuota;
                            }
                        });
                        showNotification('Jadwal berhasil dimuat', 'success');
                    } else {
                        showNotification('Belum ada jadwal tersimpan', 'info');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingOverlay.remove();
                    showNotification('Gagal memuat jadwal', 'error');
                });
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function toggleDayInput(day) {
            const checkbox = document.getElementById('hari_' + day);
            const inputs = document.getElementById('inputs_' + day);
            
            if (checkbox.checked) {
                inputs.classList.remove('opacity-50', 'pointer-events-none');
                inputs.classList.add('bg-white');
                // Set default value if empty
                const bukaInput = inputs.querySelector('input[name*="[buka]"]');
                const tutupInput = inputs.querySelector('input[name*="[tutup]"]');
                const kuotaInput = inputs.querySelector('input[name*="[kuota]"]');
                
                if(!bukaInput.value) bukaInput.value = "08:00";
                if(!tutupInput.value) tutupInput.value = "16:00";
                if(!kuotaInput.value) kuotaInput.value = "10";
            } else {
                inputs.classList.add('opacity-50', 'pointer-events-none');
                inputs.classList.remove('bg-white');
            }
        }

        function saveJadwal(e) {
            e.preventDefault();
            console.log('saveJadwal called, event:', e);
            
            const form = e.target;
            const formData = new FormData(form);
            
            console.log('Form data entries:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            
            // Validasi minimal 1 hari dipilih
            const checkedDays = form.querySelectorAll('input[type="checkbox"]:checked').length;
            if (checkedDays === 0) {
                showNotification('Pilih minimal satu hari untuk jadwal', 'error');
                return;
            }
            
            console.log('Sending POST request to /finders/api/mitra/save_jadwal.php');
            
            // Tampilkan loading state
            const modal = document.getElementById('modalJadwal');
            const btnSimpan = modal.querySelector('.bg-blue-600');
            const btnBatal = modal.querySelector('.border-gray-300');
            const originalText = btnSimpan.innerHTML;
            
            btnSimpan.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...';
            btnSimpan.disabled = true;
            btnBatal.disabled = true;

            fetch('/finders/api/mitra/save_jadwal.php', { 
                method: 'POST',
                body: formData
            })
            .then(res => {
                console.log('Response received:', res);
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(data => {
                if(data.success) {
                    showNotification('Jadwal berhasil disimpan!', 'success');
                    
                    // Update jumlah jadwal di card
                    const idLayanan = formData.get('id_layanan');
                    const countEl = document.getElementById('jadwal-count-' + idLayanan);
                    if (countEl && data.total_jadwal !== undefined) {
                        countEl.textContent = data.total_jadwal + ' Hari';
                    }
                    
                    setTimeout(() => {
                        closeModal('modalJadwal');
                        // Optional: reload halaman jika perlu
                        // window.location.reload();
                    }, 1000);
                } else {
                    showNotification('Gagal menyimpan: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(err => {
                console.error('Error:', err);
                showNotification('Terjadi kesalahan koneksi', 'error');
            })
            .finally(() => {
                btnSimpan.innerHTML = originalText;
                btnSimpan.disabled = false;
                btnBatal.disabled = false;
            });
        }

        // Notification helper
        function showNotification(message, type = 'info') {
            const colors = {
                success: 'bg-emerald-500',
                error: 'bg-red-500',
                info: 'bg-blue-500',
                warning: 'bg-yellow-500'
            };
            
            const icons = {
                success: 'fa-circle-check',
                error: 'fa-circle-xmark',
                info: 'fa-circle-info',
                warning: 'fa-triangle-exclamation'
            };
            
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-xl shadow-lg z-50 flex items-center gap-3 animate-slide-in`;
            notification.innerHTML = `<i class="fa-solid ${icons[type]}"></i> <span>${message}</span>`;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                notification.style.transition = 'all 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
        
        // Add animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slide-in {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            .animate-slide-in {
                animation: slide-in 0.3s ease-out;
            }
        `;
        document.head.appendChild(style);
    </script>

</body>
</html>