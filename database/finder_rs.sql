-- phpMyAdmin SQL Dump
-- Version 5.2.1
-- Generation Time: Dec 16, 2025
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00"; -- Waktu Indonesia Barat (WIB)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finder_rs`
--
DROP DATABASE IF EXISTS `finder_rs`;
CREATE DATABASE IF NOT EXISTS `finder_rs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `finder_rs`;

-- --------------------------------------------------------

--
-- Table structure for table `akun_admin`
--

CREATE TABLE `akun_admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'admin',
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `akun_admin`
-- Password: 123 (Hash: $2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0)
--

INSERT INTO `akun_admin` (`id_admin`, `username`, `email`, `password`, `role`) VALUES
(1, 'superadmin', 'admin@finders.id', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', 'super');

-- --------------------------------------------------------

--
-- Table structure for table `data_rumah_sakit`
--

CREATE TABLE `data_rumah_sakit` (
  `id_rs` int(11) NOT NULL AUTO_INCREMENT,
  `nama_rs` varchar(200) NOT NULL,
  `alamat` text DEFAULT NULL,
  `wilayah` varchar(100) DEFAULT NULL,
  `no_telpon` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `dibuat_pada` datetime DEFAULT current_timestamp(),
  `diperbarui_pada` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default_rs.jpg',
  PRIMARY KEY (`id_rs`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `data_rumah_sakit_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `akun_admin` (`id_admin`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_rumah_sakit`
--

INSERT INTO `data_rumah_sakit` (`id_rs`, `nama_rs`, `alamat`, `wilayah`, `no_telpon`, `deskripsi`, `id_admin`, `foto`) VALUES
(1, 'RSUPN Dr. Cipto Mangunkusumo', 'Jl. Pangeran Diponegoro No.71, Kenari, Kec. Senen, Kota Jakarta Pusat', 'Jakarta Pusat', '1500135', 'Rumah Sakit Umum Pusat Nasional Dr. Cipto Mangunkusumo adalah rumah sakit pemerintah yang menjadi rujukan nasional (Top Referral Hospital) untuk pelayanan kesehatan. Memiliki fasilitas medis terlengkap di Indonesia.', 1, 'rs_cipto.jpg'),
(2, 'RSUP Fatmawati', 'Jl. RS. Fatmawati Raya No.4, Cilandak Bar., Kec. Cilandak, Kota Jakarta Selatan', 'Jakarta Selatan', '(021) 7660552', 'Rumah Sakit Umum Pusat Fatmawati adalah rumah sakit rujukan nasional dengan layanan unggulan Ortopedi dan Rehabilitasi Medik.', 1, 'rsup_fatmawati.jpg'),
(3, 'RS Pondok Indah', 'Jl. Metro Duta Kav. UE, Pondok Indah, Jakarta Selatan', 'Jakarta Selatan', '(021) 7657525', 'Rumah sakit swasta premium yang mengedepankan teknologi medis terkini dan kenyamanan pasien. Memiliki pusat layanan jantung dan vaskular terpadu.', 1, 'rs_pondok_indah.jpeg'),
(4, 'RS Siloam Kebon Jeruk', 'Jl. Raya Perjuangan Kav. 8, Kebon Jeruk, Jakarta Barat', 'Jakarta Barat', '(021) 25677888', 'Bagian dari Siloam Hospitals Group, RS ini dikenal dengan layanan unggulan di bidang Urologi, Ortopedi, dan Jantung.', 1, 'rs_siloam_kj.jpeg'),
(5, 'RS Mitra Keluarga Kelapa Gading', 'Jl. Bukit Gading Raya Kav. 2, Kelapa Gading, Jakarta Utara', 'Jakarta Utara', '(021) 45852700', 'Menyediakan layanan kesehatan komprehensif bagi masyarakat Jakarta Utara dengan fasilitas modern dan dokter spesialis berpengalaman.', 1, 'rs_mitra_kg.jpeg'),
(6, 'RS Premier Jatinegara', 'Jl. Jatinegara Timur No. 85-87, Bali Mester, Jakarta Timur', 'Jakarta Timur', '(021) 2800888', 'RS swasta terkemuka di Jakarta Timur dengan standar internasional JCI. Unggulan dalam layanan Bedah Jantung dan Stroke Unit.', 1, 'rs_premier_jatinegara.jpeg'),
(7, 'RS Pusat Pertamina (RSPP)', 'Jl. Kyai Maja No.43, Gunung, Kec. Kby. Baru, Kota Jakarta Selatan', 'Jakarta Selatan', '(021) 7219000', 'Rumah sakit BUMN yang memiliki unit luka bakar (Burn Unit) terbaik dan layanan kesehatan okupasi yang lengkap.', 1, 'rspp.jpeg'),
(8, 'RSUD Tarakan', 'Jl. Kyai Caringin No.7, Cideng, Kec. Gambir, Kota Jakarta Pusat', 'Jakarta Pusat', '(021) 3503003', 'Rumah Sakit Umum Daerah tipe A milik Pemprov DKI Jakarta. Pusat rujukan penyakit jantung dan kanker bagi warga Jakarta.', 1, 'rsud_tarakan.jpeg'),
(9, 'RS Dharmais (Pusat Kanker Nasional)', 'Jl. Letjen S. Parman No.84-86, Slipi, Jakarta Barat', 'Jakarta Barat', '(021) 5681570', 'Pusat Kanker Nasional yang menjadi rujukan utama penanganan kanker di Indonesia dengan pendekatan multidisiplin.', 1, 'rs_dharmais.jpeg'),
(10, 'RSPI Sulianti Saroso', 'Jl. Sunter Permai Raya No.2, Papanggo, Jakarta Utara', 'Jakarta Utara', '(021) 6506559', 'Pusat Infeksi Nasional. Rumah sakit rujukan utama untuk penyakit infeksi menular (seperti COVID-19, Flu Burung) dan riset penyakit tropis.', 1, 'rspi_sulianti.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `akun_rumah_sakit`
--

CREATE TABLE `akun_rumah_sakit` (
  `id_rs_akun` int(11) NOT NULL AUTO_INCREMENT,
  `id_rs` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `status_akun` varchar(30) DEFAULT 'aktif',
  `role_rs` varchar(50) DEFAULT 'rs',
  PRIMARY KEY (`id_rs_akun`),
  KEY `id_rs` (`id_rs`),
  CONSTRAINT `akun_rumah_sakit_ibfk_1` FOREIGN KEY (`id_rs`) REFERENCES `data_rumah_sakit` (`id_rs`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `akun_rumah_sakit`
-- Password: 123 (Hash: $2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0)
--

INSERT INTO `akun_rumah_sakit` (`id_rs`, `username`, `password`, `email`, `status_akun`) VALUES
(1, 'admin_rscm', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', 'admin@rscm.co.id', 'aktif'),
(2, 'admin_fatmawati', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', 'admin@fatmawati.id', 'aktif'),
(3, 'admin_pi', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', 'admin@rspondokindah.co.id', 'aktif'),
(4, 'admin_siloam', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', 'admin@siloam.co.id', 'aktif'),
(5, 'admin_mitra', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', 'admin@mitrakeluarga.com', 'aktif'),
(6, 'admin_premier', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', 'admin@rs-premier.co.id', 'aktif'),
(7, 'admin_rspp', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', 'admin@rspp.co.id', 'aktif'),
(8, 'admin_tarakan', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', 'admin@rsudtarakan.jakarta.go.id', 'aktif'),
(9, 'admin_dharmais', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', 'admin@dharmais.co.id', 'aktif'),
(10, 'admin_sulianti', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', 'admin@rspisuliantisaroso.co.id', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `akun_user`
--

CREATE TABLE `akun_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telpon` varchar(30) DEFAULT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `akun_user`
-- Password: 123 (Hash: $2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0)
--

INSERT INTO `akun_user` (`nama`, `email`, `password`, `no_telpon`) VALUES
('Budi Santoso', 'budi@gmail.com', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', '081234567890'),
('Siti Aminah', 'siti@yahoo.com', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', '089876543211'),
('Ahmad Rizki', 'ahmad@gmail.com', '$2y$10$5.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0/2.0', '085612345678');

-- --------------------------------------------------------

--
-- Table structure for table `data_layanan_rs`
--

CREATE TABLE `data_layanan_rs` (
  `id_layanan` int(11) NOT NULL AUTO_INCREMENT,
  `id_rs` int(11) NOT NULL,
  `nama_layanan` varchar(150) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `butuh_rujukan` enum('Ya','Tidak') DEFAULT 'Tidak',
  `ketersediaan_layanan` varchar(100) DEFAULT 'Tersedia',
  `create_by` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `id_rs_akun` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_layanan`),
  KEY `id_rs` (`id_rs`),
  KEY `id_admin` (`id_admin`),
  KEY `id_rs_akun` (`id_rs_akun`),
  CONSTRAINT `data_layanan_rs_ibfk_1` FOREIGN KEY (`id_rs`) REFERENCES `data_rumah_sakit` (`id_rs`) ON DELETE CASCADE,
  CONSTRAINT `data_layanan_rs_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `akun_admin` (`id_admin`) ON DELETE SET NULL,
  CONSTRAINT `data_layanan_rs_ibfk_3` FOREIGN KEY (`id_rs_akun`) REFERENCES `akun_rumah_sakit` (`id_rs_akun`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_layanan_rs`
--

INSERT INTO `data_layanan_rs` (`id_layanan`, `id_rs`, `nama_layanan`, `kategori`, `butuh_rujukan`, `ketersediaan_layanan`, `id_rs_akun`) VALUES
-- RSCM (ID: 1)
(1, 1, 'Poli Penyakit Dalam', 'Spesialis', 'Tidak', 'Tersedia', 1),
(2, 1, 'Poli Saraf', 'Spesialis', 'Tidak', 'Tersedia', 1),
(3, 1, 'Radiologi', 'Penunjang', 'Ya', 'Tersedia', 1),
-- Fatmawati (ID: 2)
(4, 2, 'Poli Ortopedi', 'Spesialis', 'Tidak', 'Tersedia', 2),
(5, 2, 'Poli Rehabilitasi Medik', 'Spesialis', 'Tidak', 'Tersedia', 2),
(6, 2, 'Fisioterapi', 'Penunjang', 'Ya', 'Tersedia', 2),
-- RSPI (ID: 3)
(7, 3, 'Poli Kebidanan & Kandungan', 'Spesialis', 'Tidak', 'Tersedia', 3),
(8, 3, 'Poli Anak', 'Spesialis', 'Tidak', 'Tersedia', 3),
(9, 3, 'Laboratorium', 'Penunjang', 'Ya', 'Tersedia', 3),
-- Siloam (ID: 4)
(10, 4, 'Poli Jantung', 'Spesialis', 'Tidak', 'Tersedia', 4),
(11, 4, 'Poli Urologi', 'Spesialis', 'Tidak', 'Tersedia', 4),
(12, 4, 'Radiologi', 'Penunjang', 'Ya', 'Tersedia', 4),
-- Mitra KG (ID: 5)
(13, 5, 'Poli Gigi', 'Spesialis', 'Tidak', 'Tersedia', 5),
(14, 5, 'Poli Mata', 'Spesialis', 'Tidak', 'Tersedia', 5),
-- Premier (ID: 6)
(15, 6, 'Poli Saraf', 'Spesialis', 'Tidak', 'Tersedia', 6),
(16, 6, 'Poli Bedah Saraf', 'Spesialis', 'Tidak', 'Tersedia', 6),
-- RSPP (ID: 7)
(17, 7, 'Poli Okupasi', 'Spesialis', 'Tidak', 'Tersedia', 7),
(18, 7, 'Medical Check Up', 'Umum', 'Tidak', 'Tersedia', 7),
-- Tarakan (ID: 8)
(19, 8, 'Poli Jantung', 'Spesialis', 'Tidak', 'Tersedia', 8),
(20, 8, 'Poli Paru', 'Spesialis', 'Tidak', 'Tersedia', 8),
-- Dharmais (ID: 9)
(21, 9, 'Poli Onkologi', 'Spesialis', 'Tidak', 'Tersedia', 9),
(22, 9, 'Radioterapi', 'Penunjang', 'Ya', 'Tersedia', 9),
-- Sulianti Saroso (ID: 10)
(23, 10, 'Poli Penyakit Infeksi', 'Spesialis', 'Tidak', 'Tersedia', 10),
(24, 10, 'Poli Paru', 'Spesialis', 'Tidak', 'Tersedia', 10);

-- --------------------------------------------------------

--
-- Table structure for table `data_jadwal_layanan`
--

CREATE TABLE `data_jadwal_layanan` (
  `id_jadwal` int(11) NOT NULL AUTO_INCREMENT,
  `id_layanan` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_buka_praktek` time NOT NULL DEFAULT '08:00:00',
  `jam_tutup_praktek` time NOT NULL DEFAULT '16:00:00',
  `kuota_per_sesi` int(11) DEFAULT 10,
  PRIMARY KEY (`id_jadwal`),
  KEY `id_layanan` (`id_layanan`),
  CONSTRAINT `data_jadwal_layanan_ibfk_1` FOREIGN KEY (`id_layanan`) REFERENCES `data_layanan_rs` (`id_layanan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_jadwal_layanan`
--

INSERT INTO `data_jadwal_layanan` (`id_jadwal`, `id_layanan`, `hari`, `jam_buka_praktek`, `jam_tutup_praktek`, `kuota_per_sesi`) VALUES
-- RSCM Penyakit Dalam (ID 1)
(1, 1, 'Senin', '08:00:00', '14:00:00', 20),
(2, 1, 'Rabu', '08:00:00', '14:00:00', 20),
-- RSCM Radiologi (ID 3)
(3, 3, 'Senin', '08:00:00', '20:00:00', 50),
(4, 3, 'Selasa', '08:00:00', '20:00:00', 50),
-- Fatmawati Ortopedi (ID 4)
(5, 4, 'Selasa', '09:00:00', '14:00:00', 15),
(6, 4, 'Kamis', '09:00:00', '14:00:00', 15),
-- Siloam Jantung (ID 10)
(7, 10, 'Jumat', '13:00:00', '17:00:00', 10),
-- Dharmais Radioterapi (ID 22)
(8, 22, 'Senin', '07:00:00', '15:00:00', 30);

-- --------------------------------------------------------

--
-- Table structure for table `data_penjadwalan`
--

CREATE TABLE `data_penjadwalan` (
  `id_penjadwalan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_rs` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `nama_pasien` varchar(150) NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `status` enum('Menunggu','Dikonfirmasi','Dibatalkan','Selesai') DEFAULT 'Menunggu',
  `catatan` text DEFAULT NULL,
  `dibuat_pada` datetime DEFAULT current_timestamp(),
  `queue_number` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_penjadwalan`),
  KEY `id_user` (`id_user`),
  KEY `id_rs` (`id_rs`),
  KEY `id_layanan` (`id_layanan`),
  CONSTRAINT `data_penjadwalan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `akun_user` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `data_penjadwalan_ibfk_2` FOREIGN KEY (`id_rs`) REFERENCES `data_rumah_sakit` (`id_rs`) ON DELETE CASCADE,
  CONSTRAINT `data_penjadwalan_ibfk_3` FOREIGN KEY (`id_layanan`) REFERENCES `data_layanan_rs` (`id_layanan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_penjadwalan`
--

INSERT INTO `data_penjadwalan` (`id_user`, `id_rs`, `id_layanan`, `nama_pasien`, `tanggal_kunjungan`, `status`, `catatan`, `queue_number`) VALUES
(1, 1, 1, 'Budi Santoso', '2025-12-20', 'Menunggu', 'Kontrol rutin diabetes', 'A-001'),
(1, 2, 4, 'Budi Santoso', '2025-12-25', 'Dikonfirmasi', 'Konsultasi nyeri lutut', 'B-005'),
(2, 4, 10, 'Siti Aminah', '2025-12-21', 'Menunggu', 'Keluhan berdebar', 'C-012'),
(2, 9, 22, 'Siti Aminah', '2025-12-28', 'Dikonfirmasi', 'Jadwal radioterapi sesi 1', 'D-020');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;