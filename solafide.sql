-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table toko_solafide.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `id_barang` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `id_supplier` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_barang`),
  KEY `barang_id_supplier_foreign` (`id_supplier`),
  CONSTRAINT `barang_id_supplier_foreign` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko_solafide.barang: ~3 rows (approximately)
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga`, `stok`, `id_supplier`, `created_at`, `updated_at`) VALUES
	(1, 'Beras Lahap 10Kg', 100000, 45, 1, '2022-01-09 07:56:03', '2022-01-09 07:56:03'),
	(2, 'Sabun Lifebuoy', 3000, 45, 2, '2022-01-09 07:56:10', '2022-01-09 15:44:06'),
	(3, 'Susu Beruang', 12000, 45, 3, '2022-01-09 07:56:22', '2022-01-09 15:44:10');
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;

-- Dumping structure for table toko_solafide.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko_solafide.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table toko_solafide.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko_solafide.migrations: ~6 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2022_01_04_134133_semua_tabel', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table toko_solafide.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko_solafide.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table toko_solafide.pembayaran
CREATE TABLE IF NOT EXISTS `pembayaran` (
  `id_pembayaran` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tgl_bayar` date NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `kode_transaksi` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pembayaran`),
  KEY `kode_transaksi_bayar` (`kode_transaksi`),
  CONSTRAINT `kode_transaksi_bayar` FOREIGN KEY (`kode_transaksi`) REFERENCES `transaksi` (`kode_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko_solafide.pembayaran: ~0 rows (approximately)
/*!40000 ALTER TABLE `pembayaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembayaran` ENABLE KEYS */;

-- Dumping structure for table toko_solafide.pembeli
CREATE TABLE IF NOT EXISTS `pembeli` (
  `id_pembeli` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_pembeli` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jk` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pembeli`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko_solafide.pembeli: ~1 rows (approximately)
/*!40000 ALTER TABLE `pembeli` DISABLE KEYS */;
INSERT INTO `pembeli` (`id_pembeli`, `nama_pembeli`, `jk`, `no_telp`, `alamat`, `created_at`, `updated_at`) VALUES
	(1, 'Jeky', 'L', '083008', 'Jember', '2022-01-09 07:55:54', '2022-01-09 07:55:54'),
	(2, 'Siti', 'P', '8678767', 'Lowokwaru', '2022-01-09 15:43:37', '2022-01-09 15:43:37'),
	(3, 'Andi', 'L', '3423', 'Mega Mendung', '2022-01-09 15:43:49', '2022-01-09 15:43:49');
/*!40000 ALTER TABLE `pembeli` ENABLE KEYS */;

-- Dumping structure for table toko_solafide.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko_solafide.personal_access_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Dumping structure for table toko_solafide.supplier
CREATE TABLE IF NOT EXISTS `supplier` (
  `id_supplier` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko_solafide.supplier: ~1 rows (approximately)
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `no_telp`, `alamat`, `created_at`, `updated_at`) VALUES
	(1, 'Evan', '083008', 'Mega Mendung', '2022-01-09 07:55:45', '2022-01-09 15:42:53'),
	(2, 'Simon', '3423', 'Klojen', '2022-01-09 15:43:01', '2022-01-09 15:43:01'),
	(3, 'Yeris', '5546', 'Sukun', '2022-01-09 15:43:10', '2022-01-09 15:43:10');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;

-- Dumping structure for table toko_solafide.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_transaksi` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_barang` int(10) unsigned DEFAULT NULL,
  `id_pembeli` int(10) unsigned DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `transaksi_id_barang_foreign` (`id_barang`),
  KEY `transaksi_id_pembeli_foreign` (`id_pembeli`),
  KEY `transaksi_kode_transaksi_index` (`kode_transaksi`),
  CONSTRAINT `transaksi_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  CONSTRAINT `transaksi_id_pembeli_foreign` FOREIGN KEY (`id_pembeli`) REFERENCES `pembeli` (`id_pembeli`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko_solafide.transaksi: ~2 rows (approximately)
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;

-- Dumping structure for table toko_solafide.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table toko_solafide.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'evan', 'admin@solafide.com', NULL, '$2y$10$Lo2/SaAItk.M0gYH/GtuB.gTc8NOWLnBUk3u6RKc9EuePjvYewlDC', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
