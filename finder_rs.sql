-- Database: finder_rs
CREATE DATABASE IF NOT EXISTS finder_rs CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE finder_rs;

-- Table akun_user
CREATE TABLE IF NOT EXISTS akun_user (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  no_telpon VARCHAR(30),
  tanggal_daftar DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table akun_admin
CREATE TABLE IF NOT EXISTS akun_admin (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(150),
  password VARCHAR(255),
  role VARCHAR(50) DEFAULT 'admin'
) ENGINE=InnoDB;

-- Table data_rumah_sakit
CREATE TABLE IF NOT EXISTS data_rumah_sakit (
  id_rs INT AUTO_INCREMENT PRIMARY KEY,
  nama_rs VARCHAR(200) NOT NULL,
  alamat TEXT,
  wilayah VARCHAR(100),
  no_telpon VARCHAR(50),
  deskripsi TEXT,
  dibuat_pada DATETIME DEFAULT CURRENT_TIMESTAMP,
  diperbarui_pada DATETIME DEFAULT NULL,
  create_by INT DEFAULT NULL,
  id_admin INT DEFAULT NULL,
  FOREIGN KEY (id_admin) REFERENCES akun_admin(id_admin) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Table akun_rumah_sakit (credential RS)
CREATE TABLE IF NOT EXISTS akun_rumah_sakit (
  id_rs_akun INT AUTO_INCREMENT PRIMARY KEY,
  id_rs INT NOT NULL,
  username VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(150),
  status_akun VARCHAR(30) DEFAULT 'aktif',
  role_rs VARCHAR(50) DEFAULT 'rs',
  FOREIGN KEY (id_rs) REFERENCES data_rumah_sakit(id_rs) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table data_layanan_rs
CREATE TABLE IF NOT EXISTS data_layanan_rs (
  id_layanan INT AUTO_INCREMENT PRIMARY KEY,
  id_rs INT NOT NULL,
  nama_layanan VARCHAR(150) NOT NULL,
  kategori VARCHAR(100),
  ketersediaan_layanan VARCHAR(100) DEFAULT 'Tersedia',
  create_by INT DEFAULT NULL,
  id_admin INT DEFAULT NULL,
  id_rs_akun INT DEFAULT NULL,
  FOREIGN KEY (id_rs) REFERENCES data_rumah_sakit(id_rs) ON DELETE CASCADE,
  FOREIGN KEY (id_admin) REFERENCES akun_admin(id_admin) ON DELETE SET NULL,
  FOREIGN KEY (id_rs_akun) REFERENCES akun_rumah_sakit(id_rs_akun) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Table data_penjadwalan
CREATE TABLE IF NOT EXISTS data_penjadwalan (
  id_penjadwalan INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT NOT NULL,
  id_rs INT NOT NULL,
  id_layanan INT NOT NULL,
  no_nik VARCHAR(50),
  nama_pasien VARCHAR(150) NOT NULL,
  tanggal_kunjungan DATE NOT NULL,
  status ENUM('Menunggu','Dikonfirmasi','Dibatalkan','Selesai') DEFAULT 'Menunggu',
  catatan TEXT,
  dibuat_pada DATETIME DEFAULT CURRENT_TIMESTAMP,
  queue_number VARCHAR(50) DEFAULT NULL,
  FOREIGN KEY (id_user) REFERENCES akun_user(id_user) ON DELETE CASCADE,
  FOREIGN KEY (id_rs) REFERENCES data_rumah_sakit(id_rs) ON DELETE CASCADE,
  FOREIGN KEY (id_layanan) REFERENCES data_layanan_rs(id_layanan) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Sample data: admin, users, hospitals, services
INSERT INTO akun_admin (username,email,password,role) VALUES
('superadmin','admin@example.com',SHA2('admin123',256),'super');

INSERT INTO akun_user (nama,email,password,no_telpon) VALUES
('Budi Santoso','budi@example.com',SHA2('password',256),'081234567890'),
('Siti Aminah','siti@example.com',SHA2('password',256),'081298765432');

INSERT INTO data_rumah_sakit (nama_rs,alamat,wilayah,no_telpon,deskripsi,id_admin) VALUES
('RSUP Fatmawati','Jl. RS Fatmawati No.1, Jakarta','Jakarta Selatan','021-555-0123','Rumah Sakit Umum Daerah',1),
('RS Cipto Mangunkusumo (RSCM)','Jl. Diponegoro, Jakarta Pusat','Jakarta Pusat','021-555-0456','Rumah Sakit Rujukan',1);

INSERT INTO akun_rumah_sakit (id_rs,username,password,email) VALUES
(1,'rs_fatma','rs_pw', 'contact@fatmawati.id'),
(2,'rs_rcm','rs_pw', 'contact@rscm.id');

INSERT INTO data_layanan_rs (id_rs,nama_layanan,kategori,ketersediaan_layanan,id_admin) VALUES
(1,'UGD 24 Jam','Gawat Darurat','Tersedia',1),
(1,'Onkologi','Spesialis','Tersedia',1),
(2,'Bedah Jantung','Bedah','Tersedia',1),
(2,'Radiologi','Penunjang','Tersedia',1);

-- Example schedule
INSERT INTO data_penjadwalan (id_user,id_rs,id_layanan,no_nik,nama_pasien,tanggal_kunjungan,status,catatan,queue_number)
VALUES (1,1,1,'1234567890123456','Budi Santoso','2025-12-04','Menunggu','Catatan contoh','F-001');