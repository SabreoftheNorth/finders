<?php
session_start();
header('Content-Type: application/json');
require_once '../../config/db_connect.php';

// 1. Cek Keamanan: Wajib Login sebagai Mitra
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mitra') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// 2. Validasi Request Method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$id_rs = $_SESSION['id_rs']; // ID RS dari session untuk keamanan data
$id_layanan = mysqli_real_escape_string($conn, $_POST['id_layanan']);

// 3. Verifikasi Kepemilikan Layanan
// Pastikan layanan yang diedit benar-benar milik RS yang sedang login
$check_query = mysqli_query($conn, "SELECT id_layanan FROM data_layanan_rs WHERE id_layanan = '$id_layanan' AND id_rs = '$id_rs'");
if (mysqli_num_rows($check_query) == 0) {
    echo json_encode(['success' => false, 'message' => 'Layanan tidak ditemukan atau bukan milik Anda']);
    exit;
}

// 4. Proses Simpan Jadwal (Metode: Hapus Lama -> Simpan Baru)
// Kita gunakan Transaction agar data aman (semua sukses atau semua batal)
mysqli_begin_transaction($conn);

try {
    // A. Hapus semua jadwal lama untuk layanan ini
    $delete_query = "DELETE FROM data_jadwal_layanan WHERE id_layanan = '$id_layanan'";
    if (!mysqli_query($conn, $delete_query)) {
        throw new Exception("Gagal menghapus jadwal lama");
    }

    // B. Masukkan jadwal baru yang dicentang
    if (isset($_POST['hari']) && is_array($_POST['hari'])) {
        
        $stmt = mysqli_prepare($conn, "INSERT INTO data_jadwal_layanan (id_layanan, hari, jam_buka_praktek, jam_tutup_praktek, kuota_per_sesi) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($_POST['hari'] as $nama_hari => $data) {
            // Cek apakah hari tersebut dicentang (aktif)
            if (isset($data['aktif']) && $data['aktif'] == '1') {
                
                $jam_buka = !empty($data['buka']) ? $data['buka'] : '08:00';
                $jam_tutup = !empty($data['tutup']) ? $data['tutup'] : '16:00';
                $kuota = !empty($data['kuota']) ? (int)$data['kuota'] : 10;

                // Bind parameter & Execute
                mysqli_stmt_bind_param($stmt, "isssi", $id_layanan, $nama_hari, $jam_buka, $jam_tutup, $kuota);
                
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Gagal menyimpan jadwal hari $nama_hari");
                }
            }
        }
        mysqli_stmt_close($stmt);
    }

    // Jika semua lancar, commit perubahan
    mysqli_commit($conn);
    echo json_encode(['success' => true, 'message' => 'Jadwal berhasil diperbarui']);

} catch (Exception $e) {
    // Jika ada error, batalkan semua perubahan
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>