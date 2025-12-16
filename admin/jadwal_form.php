<?php
require_once '../config/db_connect.php';

// Ambil ID dari URL
$id_jadwal = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

if(!$id_jadwal) {
    echo '<div class="text-red-500 text-center py-8">ID Penjadwalan tidak valid</div>';
    exit;
}

// Query data penjadwalan
$query = mysqli_query($conn, "
    SELECT p.*, rs.nama_rs, l.nama_layanan,
           u.nama as nama_user, u.email, u.no_telpon as telpon_user
    FROM data_penjadwalan p
    JOIN data_rumah_sakit rs ON p.id_rs = rs.id_rs
    JOIN data_layanan_rs l ON p.id_layanan = l.id_layanan
    JOIN akun_user u ON p.id_user = u.id_user
    WHERE p.id_penjadwalan = '$id_jadwal'
");

if(mysqli_num_rows($query) == 0) {
    echo '<div class="text-red-500 text-center py-8">Data tidak ditemukan</div>';
    exit;
}

$data = mysqli_fetch_assoc($query);

// =============================
// Handle form submit (AJAX / normal)
// =============================
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status_baru   = mysqli_real_escape_string($conn, $_POST['status']);
    $queue_number  = mysqli_real_escape_string($conn, $_POST['queue_number']);
    $catatan_admin = mysqli_real_escape_string($conn, $_POST['catatan_admin']);

    // PERBAIKAN: pakai jam_mulai & jam_selesai
    $jam_mulai   = !empty($_POST['jam_mulai']) 
                    ? "'" . mysqli_real_escape_string($conn, $_POST['jam_mulai']) . "'" 
                    : "NULL";

    $jam_selesai = !empty($_POST['jam_selesai']) 
                    ? "'" . mysqli_real_escape_string($conn, $_POST['jam_selesai']) . "'" 
                    : "NULL";

    // Append catatan admin
    $catatan_update = $data['catatan'];
    if(!empty($catatan_admin)) {
        $catatan_update .= "\n[Admin] " . $catatan_admin;
    }

    // QUERY UPDATE (SUDAH SESUAI DB)
    $update_query = "UPDATE data_penjadwalan SET
        status = '$status_baru',
        queue_number = " . (!empty($queue_number) ? "'$queue_number'" : "NULL") . ",
        jam_mulai = $jam_mulai,
        jam_selesai = $jam_selesai,
        catatan = '$catatan_update'
    WHERE id_penjadwalan = '$id_jadwal'";

    if(mysqli_query($conn, $update_query)) {
        echo '<script>
            alert("Status penjadwalan berhasil diupdate!");
            window.parent.location.reload();
        </script>';
        exit;
    } else {
        $error_message = "Gagal update: " . mysqli_error($conn);
    }
}
?>

<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-pen-to-square text-blue-600"></i>
        </div>
        Update Status Penjadwalan
    </h2>

    <?php if(isset($error_message)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
            <p class="text-red-700"><?= $error_message ?></p>
        </div>
    <?php endif; ?>

    <!-- Informasi Penjadwalan -->
    <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl p-6 mb-6 border border-blue-200">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-info-circle text-blue-600"></i>
            Informasi Penjadwalan
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs text-gray-600 font-semibold uppercase">ID Penjadwalan</label>
                <p class="text-sm font-medium text-gray-800">#<?= $data['id_penjadwalan'] ?></p>
            </div>
            <div>
                <label class="text-xs text-gray-600 font-semibold uppercase">Tanggal Kunjungan</label>
                <p class="text-sm font-medium text-gray-800">
                    <?= date('d F Y', strtotime($data['tanggal_kunjungan'])) ?>
                </p>
            </div>
            <div>
                <label class="text-xs text-gray-600 font-semibold uppercase">Nama Pasien</label>
                <p class="text-sm font-medium text-gray-800">
                    <?= htmlspecialchars($data['nama_pasien']) ?>
                </p>
            </div>
            <div>
                <label class="text-xs text-gray-600 font-semibold uppercase">NIK</label>
                <p class="text-sm font-medium text-gray-800">
                    <?= $data['no_nik'] ?? '-' ?>
                </p>
            </div>
            <div>
                <label class="text-xs text-gray-600 font-semibold uppercase">Rumah Sakit</label>
                <p class="text-sm font-medium text-gray-800">
                    <?= htmlspecialchars($data['nama_rs']) ?>
                </p>
            </div>
            <div>
                <label class="text-xs text-gray-600 font-semibold uppercase">Layanan</label>
                <p class="text-sm font-medium text-gray-800">
                    <?= htmlspecialchars($data['nama_layanan']) ?>
                </p>
            </div>

            <?php if(!empty($data['catatan'])): ?>
            <div class="md:col-span-2">
                <label class="text-xs text-gray-600 font-semibold uppercase">Catatan Pasien</label>
                <p class="text-sm text-gray-700 bg-white p-3 rounded-lg">
                    <?= nl2br(htmlspecialchars($data['catatan'])) ?>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Form Update Status -->
    <form id="formUpdateJadwal"
          onsubmit="submitUpdateJadwal(event, <?= $id_jadwal ?>)"
          class="space-y-6">

        <input type="hidden" name="id_penjadwalan" value="<?= $id_jadwal ?>">

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Status Jadwal <span class="text-red-500">*</span>
            </label>
            <select name="status" required
                class="w-full px-4 py-3 border border-gray-300 rounded-xl">
                <option value="Menunggu" <?= $data['status']=='Menunggu'?'selected':'' ?>>Menunggu Konfirmasi</option>
                <option value="Dikonfirmasi" <?= $data['status']=='Dikonfirmasi'?'selected':'' ?>>Dikonfirmasi</option>
                <option value="Selesai" <?= $data['status']=='Selesai'?'selected':'' ?>>Selesai</option>
                <option value="Dibatalkan" <?= $data['status']=='Dibatalkan'?'selected':'' ?>>Dibatalkan</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Antrian</label>
                <input type="text" name="queue_number"
                    value="<?= htmlspecialchars($data['queue_number']) ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                <input type="time" name="jam_mulai"
                    value="<?= $data['jam_mulai'] ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Selesai</label>
                <input type="time" name="jam_selesai"
                    value="<?= $data['jam_selesai'] ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Admin</label>
            <textarea name="catatan_admin" rows="3"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl resize-none"></textarea>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl">
                <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
            </button>
            <button type="button" onclick="window.parent.closeModal()"
                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 rounded-xl">
                <i class="fa-solid fa-times mr-2"></i> Batal
            </button>
        </div>
    </form>
</div>
