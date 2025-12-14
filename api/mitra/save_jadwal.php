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
$id_layanan = isset($_POST['id_layanan']) ? intval($_POST['id_layanan']) : 0;
$hari_data = isset($_POST['hari']) ? $_POST['hari'] : [];

if (!$id_layanan) {
    echo json_encode(['success' => false, 'message' => 'ID Layanan tidak valid']);
    exit;
}

// Verifikasi layanan milik RS ini
$check = mysqli_query($conn, "SELECT id_layanan FROM data_layanan_rs WHERE id_layanan = '$id_layanan' AND id_rs = '$id_rs'");
if (mysqli_num_rows($check) == 0) {
    echo json_encode(['success' => false, 'message' => 'Layanan tidak ditemukan atau bukan milik RS Anda']);
    exit;
}

// Mulai transaksi
mysqli_begin_transaction($conn);

try {
    // Hapus semua jadwal lama untuk layanan ini
    mysqli_query($conn, "DELETE FROM data_jadwal_layanan WHERE id_layanan = '$id_layanan'");
    
    // Insert jadwal baru
    $inserted = 0;
    foreach ($hari_data as $hari => $data) {
        if (isset($data['aktif']) && $data['aktif'] == '1') {
            $jam_buka = isset($data['buka']) ? mysqli_real_escape_string($conn, $data['buka']) : '';
            $jam_tutup = isset($data['tutup']) ? mysqli_real_escape_string($conn, $data['tutup']) : '';
            $kuota = isset($data['kuota']) ? intval($data['kuota']) : 0;
            
            // Validasi
            if (empty($jam_buka) || empty($jam_tutup) || $kuota <= 0) {
                throw new Exception("Data tidak lengkap untuk hari $hari");
            }
            
            if ($jam_buka >= $jam_tutup) {
                throw new Exception("Jam buka harus lebih awal dari jam tutup untuk hari $hari");
            }
            
            $hari_esc = mysqli_real_escape_string($conn, $hari);
            $query = "INSERT INTO data_jadwal_layanan 
                     (id_layanan, hari, jam_buka_praktek, jam_tutup_praktek, kuota_per_sesi) 
                     VALUES 
                     ('$id_layanan', '$hari_esc', '$jam_buka', '$jam_tutup', '$kuota')";
            
            if (!mysqli_query($conn, $query)) {
                throw new Exception("Gagal menyimpan jadwal untuk hari $hari");
            }
            $inserted++;
        }
    }
    
    // Commit transaksi
    mysqli_commit($conn);
    
    echo json_encode([
        'success' => true, 
        'message' => "Berhasil menyimpan $inserted jadwal",
        'total_jadwal' => $inserted
    ]);
    
} catch (Exception $e) {
    // Rollback jika ada error
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
