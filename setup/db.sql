CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `jenis_usaha` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jenis_usaha` varchar(100) NOT NULL,
  `jenis_alat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `pengajuan_surat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `surat_rekomendasi_id` int DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pengajuan_surat_surat_rekomendasi_FK` (`surat_rekomendasi_id`),
  KEY `pengajuan_surat_admin_FK` (`updated_by`),
  CONSTRAINT `pengajuan_surat_admin_FK` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`),
  CONSTRAINT `pengajuan_surat_surat_rekomendasi_FK` FOREIGN KEY (`surat_rekomendasi_id`) REFERENCES `surat_rekomendasi` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `perpanjangan_surat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `surat_rekomendasi_id` int DEFAULT NULL,
  `foto_keterangan` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `perpanjangan_surat_surat_rekomendasi_FK` (`surat_rekomendasi_id`),
  KEY `perpanjangan_surat_admin_FK` (`updated_by`),
  CONSTRAINT `perpanjangan_surat_admin_FK` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`),
  CONSTRAINT `perpanjangan_surat_surat_rekomendasi_FK` FOREIGN KEY (`surat_rekomendasi_id`) REFERENCES `surat_rekomendasi` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `surat_rekomendasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_input` varchar(18) NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `no_hp` varchar(100) DEFAULT NULL,
  `jenis_bbm` varchar(100) DEFAULT NULL,
  `volume_bbm_harian` int DEFAULT NULL,
  `jenis_usaha_id` int DEFAULT NULL,
  `nama_usaha` varchar(100) DEFAULT NULL,
  `nomor_induk_spbu` varchar(100) DEFAULT NULL,
  `alamat_spbu` varchar(100) DEFAULT NULL,
  `nomor_rangka_mesin` varchar(100) DEFAULT NULL,
  `foto_mesin` varchar(100) DEFAULT NULL,
  `foto_ktp` varchar(100) DEFAULT NULL,
  `foto_domisili` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `surat_rekomendasi_unique` (`id_input`),
  KEY `surat_rekomendasi_jenis_usaha_FK` (`jenis_usaha_id`),
  CONSTRAINT `surat_rekomendasi_jenis_usaha_FK` FOREIGN KEY (`jenis_usaha_id`) REFERENCES `jenis_usaha` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO admin
(nama, password)
VALUES('admin', '$2y$10$PtezJNsSspox7Fwkwhln2OkfXarFryM6zJVtVZjq/mJQmqebv0DoO');

INSERT INTO jenis_usaha
(id, jenis_usaha, jenis_alat)
VALUES(1, 'Usaha Mikro', 'Mesin Perkakas');
INSERT INTO jenis_usaha
(id, jenis_usaha, jenis_alat)
VALUES(2, 'Usaha Pertanian', 'Traktor');
INSERT INTO jenis_usaha
(id, jenis_usaha, jenis_alat)
VALUES(3, 'Usaha Pertanian', 'Genzet');
INSERT INTO jenis_usaha
(id, jenis_usaha, jenis_alat)
VALUES(4, 'Usaha Pertanian', 'Huller');
INSERT INTO jenis_usaha
(id, jenis_usaha, jenis_alat)
VALUES(5, 'Usaha Perikanan', 'Mesin Tempel Perahu');
INSERT INTO jenis_usaha
(id, jenis_usaha, jenis_alat)
VALUES(6, 'Usaha Perikanan', 'Kincir');
INSERT INTO jenis_usaha
(id, jenis_usaha, jenis_alat)
VALUES(7, 'Usaha Pelayanan', 'Sosial');
INSERT INTO jenis_usaha
(id, jenis_usaha, jenis_alat)
VALUES(8, 'Usaha Pelayanan', 'Kesehatan');
