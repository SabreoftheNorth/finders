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
-- Password: password (Hash SHA256: 5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8)
--

INSERT INTO `akun_admin` (`id_admin`, `username`, `email`, `password`, `role`) VALUES
(1, 'superadmin', 'admin@example.com', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'super');

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
(3, 'RS Pondok Indah', 'Jl. Metro Duta Kav. UE, Pondok Indah, Jakarta Selatan', 'Jakarta Selatan', '(021) 7657525', 'Rumah sakit swasta premium yang mengedepankan teknologi medis terkini dan kenyamanan pasien. Memiliki pusat layanan jantung dan vaskular terpadu.', 1, 'rs_pondok_indah.jpg'),
(4, 'RS Siloam Kebon Jeruk', 'Jl. Raya Perjuangan Kav. 8, Kebon Jeruk, Jakarta Barat', 'Jakarta Barat', '(021) 25677888', 'Bagian dari Siloam Hospitals Group, RS ini dikenal dengan layanan unggulan di bidang Urologi, Ortopedi, dan Jantung.', 1, 'rs_siloam_kj.jpg'),
(5, 'RS Mitra Keluarga Kelapa Gading', 'Jl. Bukit Gading Raya Kav. 2, Kelapa Gading, Jakarta Utara', 'Jakarta Utara', '(021) 45852700', 'Menyediakan layanan kesehatan komprehensif bagi masyarakat Jakarta Utara dengan fasilitas modern dan dokter spesialis berpengalaman.', 1, 'rs_mitra_kg.jpg'),
(6, 'RS Premier Jatinegara', 'Jl. Jatinegara Timur No. 85-87, Bali Mester, Jakarta Timur', 'Jakarta Timur', '(021) 2800888', 'RS swasta terkemuka di Jakarta Timur dengan standar internasional JCI. Unggulan dalam layanan Bedah Jantung dan Stroke Unit.', 1, 'rs_premier_jatinegara.jpg'),
(7, 'RS Pusat Pertamina (RSPP)', 'Jl. Kyai Maja No.43, Gunung, Kec. Kby. Baru, Kota Jakarta Selatan', 'Jakarta Selatan', '(021) 7219000', 'Rumah sakit BUMN yang memiliki unit luka bakar (Burn Unit) terbaik dan layanan kesehatan okupasi yang lengkap.', 1, 'rspp.jpg'),
(8, 'RSUD Tarakan', 'Jl. Kyai Caringin No.7, Cideng, Kec. Gambir, Kota Jakarta Pusat', 'Jakarta Pusat', '(021) 3503003', 'Rumah Sakit Umum Daerah tipe A milik Pemprov DKI Jakarta. Pusat rujukan penyakit jantung dan kanker bagi warga Jakarta.', 1, 'rsud_tarakan.jpg'),
(9, 'RS Dharmais (Pusat Kanker Nasional)', 'Jl. Letjen S. Parman No.84-86, Slipi, Jakarta Barat', 'Jakarta Barat', '(021) 5681570', 'Pusat Kanker Nasional yang menjadi rujukan utama penanganan kanker di Indonesia dengan pendekatan multidisiplin.', 1, 'rs_dharmais.jpg'),
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
-- Password: password (Hash SHA256: 5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8)
--

INSERT INTO `akun_rumah_sakit` (`id_rs`, `username`, `password`, `email`, `status_akun`) VALUES
(1, 'admin_rscm', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'admin@rscm.co.id', 'aktif'),
(2, 'admin_fatmawati', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'admin@fatmawati.id', 'aktif'),
(3, 'admin_pi', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'admin@rspondokindah.co.id', 'aktif'),
(4, 'admin_siloam', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'admin@siloam.co.id', 'aktif'),
(5, 'admin_mitra', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'admin@mitrakeluarga.com', 'aktif'),
(6, 'admin_premier', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'admin@rs-premier.co.id', 'aktif'),
(7, 'admin_rspp', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'admin@rspp.co.id', 'aktif'),
(8, 'admin_tarakan', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'admin@rsudtarakan.jakarta.go.id', 'aktif'),
(9, 'admin_dharmais', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'admin@dharmais.co.id', 'aktif'),
(10, 'admin_sulianti', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'admin@rspisuliantisaroso.co.id', 'aktif');

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
-- Password: password (Hash SHA256: 5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8)
--

INSERT INTO `akun_user` (`nama`, `email`, `password`, `no_telpon`) VALUES
('Budi Santoso', 'budi@gmail.com', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', '081234567890'),
('Siti Aminah', 'siti@yahoo.com', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', '089876543211'),
('Ahmad Rizki', 'ahmad@gmail.com', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', '085612345678'),
('Dewi Sartika', 'dewi@gmail.com', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', '081122334455'),
('Eko Prasetyo', 'eko@gmail.com', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', '087788990011');
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

INSERT INTO `data_jadwal_layanan` (`id_layanan`, `hari`, `jam_buka_praktek`, `jam_tutup_praktek`, `kuota_per_sesi`) VALUES
-- RSCM (ID 1, 2, 3)
(1, 'Senin', '08:00:00', '10:00:00', 20), (1, 'Senin', '10:15:00', '12:15:00', 20), (1, 'Senin', '13:00:00', '15:00:00', 15), (1, 'Senin', '15:15:00', '17:15:00', 15),
(1, 'Rabu', '08:00:00', '10:00:00', 20), (1, 'Rabu', '10:15:00', '12:15:00', 20), (1, 'Rabu', '13:00:00', '15:00:00', 15), (1, 'Rabu', '15:15:00', '17:15:00', 15),
(1, 'Jumat', '08:00:00', '10:00:00', 20), (1, 'Jumat', '10:15:00', '12:15:00', 20), (1, 'Jumat', '13:30:00', '15:30:00', 15), (1, 'Jumat', '15:45:00', '17:45:00', 15),
(2, 'Senin', '08:00:00', '10:00:00', 20), (2, 'Senin', '10:15:00', '12:15:00', 20), (2, 'Senin', '13:00:00', '15:00:00', 15), (2, 'Senin', '15:15:00', '17:15:00', 15),
(2, 'Rabu', '08:00:00', '10:00:00', 20), (2, 'Rabu', '10:15:00', '12:15:00', 20), (2, 'Rabu', '13:00:00', '15:00:00', 15), (2, 'Rabu', '15:15:00', '17:15:00', 15),
(2, 'Jumat', '08:00:00', '10:00:00', 20), (2, 'Jumat', '10:15:00', '12:15:00', 20), (2, 'Jumat', '13:30:00', '15:30:00', 15), (2, 'Jumat', '15:45:00', '17:45:00', 15),
(3, 'Senin', '08:00:00', '10:00:00', 30), (3, 'Senin', '10:30:00', '12:30:00', 30), (3, 'Senin', '13:30:00', '15:30:00', 30), (3, 'Senin', '16:00:00', '18:00:00', 30),
(3, 'Selasa', '08:00:00', '10:00:00', 30), (3, 'Selasa', '10:30:00', '12:30:00', 30), (3, 'Selasa', '13:30:00', '15:30:00', 30), (3, 'Selasa', '16:00:00', '18:00:00', 30),
(3, 'Rabu', '08:00:00', '10:00:00', 30), (3, 'Rabu', '10:30:00', '12:30:00', 30), (3, 'Rabu', '13:30:00', '15:30:00', 30), (3, 'Rabu', '16:00:00', '18:00:00', 30),
-- Fatmawati (ID 4, 5, 6)
(4, 'Senin', '09:00:00', '11:00:00', 15), (4, 'Senin', '11:00:00', '13:00:00', 15), (4, 'Senin', '14:00:00', '16:00:00', 15), (4, 'Senin', '16:00:00', '18:00:00', 15),
(4, 'Rabu', '09:00:00', '11:00:00', 15), (4, 'Rabu', '11:00:00', '13:00:00', 15), (4, 'Rabu', '14:00:00', '16:00:00', 15), (4, 'Rabu', '16:00:00', '18:00:00', 15),
(4, 'Jumat', '09:00:00', '11:00:00', 15), (4, 'Jumat', '13:00:00', '15:00:00', 15), (4, 'Jumat', '15:00:00', '17:00:00', 15), (4, 'Jumat', '17:00:00', '19:00:00', 15),
(5, 'Senin', '08:00:00', '10:00:00', 10), (5, 'Senin', '10:00:00', '12:00:00', 10), (5, 'Senin', '13:00:00', '15:00:00', 10), (5, 'Senin', '15:00:00', '17:00:00', 10),
(5, 'Rabu', '08:00:00', '10:00:00', 10), (5, 'Rabu', '10:00:00', '12:00:00', 10), (5, 'Rabu', '13:00:00', '15:00:00', 10), (5, 'Rabu', '15:00:00', '17:00:00', 10),
(6, 'Senin', '07:30:00', '09:30:00', 25), (6, 'Senin', '09:30:00', '11:30:00', 25), (6, 'Senin', '13:00:00', '15:00:00', 25), (6, 'Senin', '15:00:00', '17:00:00', 25),
(6, 'Selasa', '07:30:00', '09:30:00', 25), (6, 'Selasa', '09:30:00', '11:30:00', 25), (6, 'Selasa', '13:00:00', '15:00:00', 25), (6, 'Selasa', '15:00:00', '17:00:00', 25),
(6, 'Rabu', '07:30:00', '09:30:00', 25), (6, 'Rabu', '09:30:00', '11:30:00', 25), (6, 'Rabu', '13:00:00', '15:00:00', 25), (6, 'Rabu', '15:00:00', '17:00:00', 25),
-- RSPI (ID 7, 8, 9)
(7, 'Senin', '09:00:00', '11:00:00', 15), (7, 'Senin', '11:00:00', '13:00:00', 15), (7, 'Senin', '14:00:00', '16:00:00', 15), (7, 'Senin', '17:00:00', '19:00:00', 15),
(7, 'Rabu', '09:00:00', '11:00:00', 15), (7, 'Rabu', '11:00:00', '13:00:00', 15), (7, 'Rabu', '14:00:00', '16:00:00', 15), (7, 'Rabu', '17:00:00', '19:00:00', 15),
(7, 'Jumat', '09:00:00', '11:00:00', 15), (7, 'Jumat', '11:00:00', '13:00:00', 15), (7, 'Jumat', '14:00:00', '16:00:00', 15), (7, 'Jumat', '17:00:00', '19:00:00', 15),
(8, 'Senin', '08:00:00', '10:00:00', 20), (8, 'Senin', '10:30:00', '12:30:00', 20), (8, 'Senin', '13:30:00', '15:30:00', 20), (8, 'Senin', '16:00:00', '18:00:00', 20),
(8, 'Selasa', '08:00:00', '10:00:00', 20), (8, 'Selasa', '10:30:00', '12:30:00', 20), (8, 'Selasa', '13:30:00', '15:30:00', 20), (8, 'Selasa', '16:00:00', '18:00:00', 20),
(9, 'Senin', '07:00:00', '09:00:00', 50), (9, 'Senin', '09:00:00', '11:00:00', 50), (9, 'Senin', '11:00:00', '13:00:00', 50), (9, 'Senin', '13:00:00', '15:00:00', 50),
(9, 'Selasa', '07:00:00', '09:00:00', 50), (9, 'Selasa', '09:00:00', '11:00:00', 50), (9, 'Selasa', '11:00:00', '13:00:00', 50), (9, 'Selasa', '13:00:00', '15:00:00', 50),
(9, 'Rabu', '07:00:00', '09:00:00', 50), (9, 'Rabu', '09:00:00', '11:00:00', 50), (9, 'Rabu', '11:00:00', '13:00:00', 50), (9, 'Rabu', '13:00:00', '15:00:00', 50),
-- Siloam (ID 10, 11, 12)
(10, 'Senin', '09:00:00', '11:00:00', 10), (10, 'Senin', '11:00:00', '13:00:00', 10), (10, 'Senin', '14:00:00', '16:00:00', 10), (10, 'Senin', '16:00:00', '18:00:00', 10),
(10, 'Rabu', '09:00:00', '11:00:00', 10), (10, 'Rabu', '11:00:00', '13:00:00', 10), (10, 'Rabu', '14:00:00', '16:00:00', 10), (10, 'Rabu', '16:00:00', '18:00:00', 10),
(11, 'Selasa', '10:00:00', '12:00:00', 12), (11, 'Selasa', '13:00:00', '15:00:00', 12), (11, 'Selasa', '15:00:00', '17:00:00', 12), (11, 'Selasa', '17:00:00', '19:00:00', 12),
(11, 'Kamis', '10:00:00', '12:00:00', 12), (11, 'Kamis', '13:00:00', '15:00:00', 12), (11, 'Kamis', '15:00:00', '17:00:00', 12), (11, 'Kamis', '17:00:00', '19:00:00', 12),
(12, 'Senin', '08:00:00', '10:00:00', 20), (12, 'Senin', '10:00:00', '12:00:00', 20), (12, 'Senin', '13:00:00', '15:00:00', 20), (12, 'Senin', '15:00:00', '17:00:00', 20),
(12, 'Rabu', '08:00:00', '10:00:00', 20), (12, 'Rabu', '10:00:00', '12:00:00', 20), (12, 'Rabu', '13:00:00', '15:00:00', 20), (12, 'Rabu', '15:00:00', '17:00:00', 20),
-- Mitra KG (ID 13, 14)
(13, 'Senin', '09:00:00', '11:00:00', 10), (13, 'Senin', '11:00:00', '13:00:00', 10), (13, 'Senin', '14:00:00', '16:00:00', 10), (13, 'Senin', '17:00:00', '19:00:00', 10),
(13, 'Rabu', '09:00:00', '11:00:00', 10), (13, 'Rabu', '11:00:00', '13:00:00', 10), (13, 'Rabu', '14:00:00', '16:00:00', 10), (13, 'Rabu', '17:00:00', '19:00:00', 10),
(14, 'Selasa', '09:00:00', '11:00:00', 15), (14, 'Selasa', '11:00:00', '13:00:00', 15), (14, 'Selasa', '14:00:00', '16:00:00', 15), (14, 'Selasa', '16:00:00', '18:00:00', 15),
(14, 'Kamis', '09:00:00', '11:00:00', 15), (14, 'Kamis', '11:00:00', '13:00:00', 15), (14, 'Kamis', '14:00:00', '16:00:00', 15), (14, 'Kamis', '16:00:00', '18:00:00', 15),
-- Premier (ID 15, 16)
(15, 'Senin', '10:00:00', '12:00:00', 10), (15, 'Senin', '13:00:00', '15:00:00', 10), (15, 'Senin', '15:00:00', '17:00:00', 10), (15, 'Senin', '17:00:00', '19:00:00', 10),
(15, 'Jumat', '10:00:00', '12:00:00', 10), (15, 'Jumat', '13:00:00', '15:00:00', 10), (15, 'Jumat', '15:00:00', '17:00:00', 10), (15, 'Jumat', '17:00:00', '19:00:00', 10),
(16, 'Selasa', '08:00:00', '10:00:00', 8), (16, 'Selasa', '10:00:00', '12:00:00', 8), (16, 'Selasa', '13:00:00', '15:00:00', 8), (16, 'Selasa', '15:00:00', '17:00:00', 8),
-- RSPP (ID 17, 18)
(17, 'Senin', '08:00:00', '10:00:00', 20), (17, 'Senin', '10:00:00', '12:00:00', 20), (17, 'Senin', '13:00:00', '15:00:00', 20), (17, 'Senin', '15:00:00', '17:00:00', 20),
(17, 'Rabu', '08:00:00', '10:00:00', 20), (17, 'Rabu', '10:00:00', '12:00:00', 20), (17, 'Rabu', '13:00:00', '15:00:00', 20), (17, 'Rabu', '15:00:00', '17:00:00', 20),
(18, 'Senin', '07:00:00', '09:00:00', 30), (18, 'Senin', '09:00:00', '11:00:00', 30), (18, 'Senin', '13:00:00', '15:00:00', 30), (18, 'Senin', '15:00:00', '17:00:00', 30),
(18, 'Selasa', '07:00:00', '09:00:00', 30), (18, 'Selasa', '09:00:00', '11:00:00', 30), (18, 'Selasa', '13:00:00', '15:00:00', 30), (18, 'Selasa', '15:00:00', '17:00:00', 30),
(18, 'Rabu', '07:00:00', '09:00:00', 30), (18, 'Rabu', '09:00:00', '11:00:00', 30), (18, 'Rabu', '13:00:00', '15:00:00', 30), (18, 'Rabu', '15:00:00', '17:00:00', 30),
-- Tarakan (ID 19, 20)
(19, 'Senin', '08:00:00', '10:00:00', 15), (19, 'Senin', '10:30:00', '12:30:00', 15), (19, 'Senin', '13:30:00', '15:30:00', 15), (19, 'Senin', '16:00:00', '18:00:00', 15),
(19, 'Kamis', '08:00:00', '10:00:00', 15), (19, 'Kamis', '10:30:00', '12:30:00', 15), (19, 'Kamis', '13:30:00', '15:30:00', 15), (19, 'Kamis', '16:00:00', '18:00:00', 15),
(20, 'Selasa', '09:00:00', '11:00:00', 15), (20, 'Selasa', '11:00:00', '13:00:00', 15), (20, 'Selasa', '14:00:00', '16:00:00', 15), (20, 'Selasa', '16:00:00', '18:00:00', 15),
(20, 'Jumat', '09:00:00', '11:00:00', 15), (20, 'Jumat', '11:00:00', '13:00:00', 15), (20, 'Jumat', '14:00:00', '16:00:00', 15), (20, 'Jumat', '16:00:00', '18:00:00', 15),
-- Dharmais (ID 21, 22)
(21, 'Senin', '08:00:00', '10:00:00', 20), (21, 'Senin', '10:00:00', '12:00:00', 20), (21, 'Senin', '13:00:00', '15:00:00', 20), (21, 'Senin', '15:00:00', '17:00:00', 20),
(21, 'Rabu', '08:00:00', '10:00:00', 20), (21, 'Rabu', '10:00:00', '12:00:00', 20), (21, 'Rabu', '13:00:00', '15:00:00', 20), (21, 'Rabu', '15:00:00', '17:00:00', 20),
(21, 'Jumat', '08:00:00', '10:00:00', 20), (21, 'Jumat', '10:00:00', '12:00:00', 20), (21, 'Jumat', '13:00:00', '15:00:00', 20), (21, 'Jumat', '15:00:00', '17:00:00', 20),
(22, 'Senin', '07:00:00', '09:00:00', 15), (22, 'Senin', '09:00:00', '11:00:00', 15), (22, 'Senin', '11:00:00', '13:00:00', 15), (22, 'Senin', '13:00:00', '15:00:00', 15),
(22, 'Selasa', '07:00:00', '09:00:00', 15), (22, 'Selasa', '09:00:00', '11:00:00', 15), (22, 'Selasa', '11:00:00', '13:00:00', 15), (22, 'Selasa', '13:00:00', '15:00:00', 15),
(22, 'Rabu', '07:00:00', '09:00:00', 15), (22, 'Rabu', '09:00:00', '11:00:00', 15), (22, 'Rabu', '11:00:00', '13:00:00', 15), (22, 'Rabu', '13:00:00', '15:00:00', 15),
-- Sulianti Saroso (ID 23, 24)
(23, 'Senin', '09:00:00', '11:00:00', 10), (23, 'Senin', '11:00:00', '13:00:00', 10), (23, 'Senin', '14:00:00', '16:00:00', 10), (23, 'Senin', '16:00:00', '18:00:00', 10),
(23, 'Rabu', '09:00:00', '11:00:00', 10), (23, 'Rabu', '11:00:00', '13:00:00', 10), (23, 'Rabu', '14:00:00', '16:00:00', 10), (23, 'Rabu', '16:00:00', '18:00:00', 10),
(24, 'Selasa', '09:00:00', '11:00:00', 15), (24, 'Selasa', '11:00:00', '13:00:00', 15), (24, 'Selasa', '14:00:00', '16:00:00', 15), (24, 'Selasa', '16:00:00', '18:00:00', 15),
(24, 'Kamis', '09:00:00', '11:00:00', 15), (24, 'Kamis', '11:00:00', '13:00:00', 15), (24, 'Kamis', '14:00:00', '16:00:00', 15), (24, 'Kamis', '16:00:00', '18:00:00', 15);
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

INSERT INTO `data_penjadwalan` (`id_user`, `id_rs`, `id_layanan`, `nama_pasien`, `tanggal_kunjungan`, `jam_mulai`, `jam_selesai`, `status`, `catatan`, `queue_number`) VALUES
-- Riwayat Masa Lalu (Status: Selesai)
(1, 1, 1, 'Budi Santoso', '2025-11-10', '08:00:00', '10:00:00', 'Selesai', 'Kontrol gula darah, hasil normal', 'A-005'),
(2, 2, 4, 'Siti Aminah', '2025-11-12', '09:00:00', '11:00:00', 'Selesai', 'Fisioterapi lutut sesi 1', 'B-012'),
(3, 4, 10, 'Ahmad Rizki', '2025-11-15', '09:00:00', '11:00:00', 'Selesai', 'Cek jantung rutin', 'J-003'),
(4, 7, 18, 'Dewi Sartika', '2025-11-20', '07:00:00', '09:00:00', 'Selesai', 'MCU Karyawan Masuk', 'M-001'),
(1, 5, 13, 'Budi Santoso', '2025-12-01', '09:00:00', '11:00:00', 'Selesai', 'Tambal gigi geraham', 'G-008'),
(5, 6, 15, 'Eko Prasetyo', '2025-12-05', '10:00:00', '12:00:00', 'Selesai', 'Konsultasi sakit kepala', 'S-010'),
-- Jadwal Bulan Ini (Status: Dikonfirmasi / Menunggu)
(1, 1, 1, 'Budi Santoso', '2025-12-20', '08:00:00', '10:00:00', 'Dikonfirmasi', 'Kontrol rutin diabetes bulanan', 'A-022'),
(2, 2, 6, 'Siti Aminah', '2025-12-22', '13:00:00', '15:00:00', 'Dikonfirmasi', 'Fisioterapi lanjutan', 'F-009'),
(3, 3, 8, 'Anak Ahmad', '2025-12-23', '08:00:00', '10:00:00', 'Menunggu', 'Imunisasi campak', 'K-015'),
(4, 3, 7, 'Dewi Sartika', '2025-12-24', '09:00:00', '11:00:00', 'Dikonfirmasi', 'USG 4D Kehamilan', 'OB-004'),
(5, 9, 21, 'Keluarga Eko', '2025-12-25', '08:00:00', '10:00:00', 'Menunggu', 'Konsultasi awal benjolan', 'ON-002'),
(1, 10, 23, 'Budi Santoso', '2025-12-26', '09:00:00', '11:00:00', 'Menunggu', 'Cek demam berkepanjangan', 'INF-001'),
(2, 4, 12, 'Siti Aminah', '2025-12-27', '08:00:00', '10:00:00', 'Dikonfirmasi', 'Rontgen Thorax', 'RAD-011'),
(3, 8, 20, 'Ahmad Rizki', '2025-12-28', '09:00:00', '11:00:00', 'Menunggu', 'Cek fungsi paru', 'P-007'),
-- Jadwal Masa Depan (Status: Menunggu / Dikonfirmasi)
(1, 1, 2, 'Budi Santoso', '2026-01-05', '08:00:00', '10:00:00', 'Menunggu', 'Rujukan dari poli dalam ke saraf', 'SR-005'),
(4, 5, 14, 'Dewi Sartika', '2026-01-07', '09:00:00', '11:00:00', 'Dikonfirmasi', 'Ganti kacamata minus', 'MT-003'),
(5, 7, 17, 'Eko Prasetyo', '2026-01-10', '08:00:00', '10:00:00', 'Menunggu', 'Surat keterangan sehat kerja', 'OK-010'),
(2, 6, 16, 'Siti Aminah', '2026-01-12', '08:00:00', '10:00:00', 'Menunggu', 'Konsultasi bedah saraf', 'BS-001'),
-- Status Dibatalkan
(3, 9, 22, 'Ahmad Rizki', '2025-12-15', '07:00:00', '09:00:00', 'Dibatalkan', 'Pasien berhalangan hadir (sakit)', 'RAD-X01'),
(4, 1, 3, 'Dewi Sartika', '2025-12-18', '10:30:00', '12:30:00', 'Dibatalkan', 'Reschedule ke minggu depan', 'RAD-X02'),
(5, 2, 4, 'Eko Prasetyo', '2025-12-19', '09:00:00', '11:00:00', 'Dibatalkan', 'Dokter cuti mendadak', 'ORT-X05');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;