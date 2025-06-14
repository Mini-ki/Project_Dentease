-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2025 at 07:36 AM
-- Server version: 8.4.3
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dentease`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `nama_admin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `noHP` varchar(20) DEFAULT NULL,
  `role` enum('super_admin','admin','operator','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `noHP`, `role`) VALUES
(1, 'Superrr', '081933902561', 'super_admin');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` int NOT NULL,
  `foto_profil` mediumblob NOT NULL,
  `nama_panggilan` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `umur` int NOT NULL,
  `spesialis` varchar(255) NOT NULL,
  `id_layanan` int DEFAULT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id_dokter`, `foto_profil`, `nama_panggilan`, `nama_lengkap`, `umur`, `spesialis`, `id_layanan`, `alamat`) VALUES
(2, '', 'Dr. Mutia', 'Dr. Baiq Mutia Dewi Edelweis', 20, 'Spesialis Gigi Anak', 2, 'Jl. Drs Said nomor 14, Montong Sari Gerung'),
(3, '', 'Dr. Jaye', 'Dr. I Nyoman Swardi Jaya Putra', 20, 'Spesialis Bedah Gigi', 1, 'Jl. Kera Sakti No 21, Mataram '),
(4, '', 'Dr. Fiana', 'Dr. Lutfiana', 20, 'Spesialis Gigi anak', 2, 'Jl. JempongBaru No 2'),
(52, '', 'Dr. Nita', 'Dr. Ni Luh Nita Mahardika', 28, 'Spesialis Ortodonti', 4, 'Jl. Cakranegara No 9'),
(53, '', 'Dr. Agus', 'Dr. I Ketut Agus Pratama', 35, 'Spesialis Periodonsia', 1, 'Jl. Selong Belanak No 3'),
(54, '', 'Dr. Lani', 'Dr. Lani Setiawan', 31, 'Spesialis Konservasi Gigi', 5, 'Jl. Panji Tilar No 12'),
(55, '', 'Dr. Rama', 'Dr. I Made Rama Wijaya', 29, 'Spesialis Bedah Mulut', 6, 'Jl. Rambutan No 14'),
(56, '', 'Dr. Vina', 'Dr. Vina Andriani', 33, 'Spesialis Gigi Anak', 2, 'Jl. Merdeka No 20'),
(57, '', 'Dr. Yoga', 'Dr. I Wayan Yoga P.', 36, 'Spesialis Prostodonsia', 3, 'Jl. Brawijaya No 1'),
(58, '', 'Dr. Arti', 'Dr. Arti Kusuma', 30, 'Spesialis Endodonsia', 5, 'Jl. Drupadi No 7'),
(59, '', 'Dr. Edo', 'Dr. Edo Wirawan', 27, 'Spesialis Periodonsia', 1, 'Jl. Kenanga No 18'),
(60, '', 'Dr. Dina', 'Dr. Dina Prameswari', 32, 'Spesialis Ortodonti', 4, 'Jl. Palapa No 2'),
(61, '', 'Dr. Rizal', 'Dr. Rizal Mahendra', 34, 'Spesialis Bedah Mulut', 6, 'Jl. Sultan No 12'),
(62, '', 'Dr. Kaziya', 'Dr. Kaziya Putri', 20, 'Spesialis Gigi Anak', 2, 'JL.Pejanggik No.28'),
(64, '', 'Dr. Anis', 'Dr. Syazwani', 20, 'Spesialis Umum', NULL, 'Jl. Angkasa Raya No 1');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id_feed` int NOT NULL,
  `judul_feed` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('Pengumuman','Artikel','Diskon') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image` mediumblob NOT NULL,
  `id_admin` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id_feed`, `judul_feed`, `deskripsi`, `status`, `image`, `id_admin`, `created_at`, `update_at`) VALUES
(5, 'Penyakit Gigi Berlubang', 'Gigi berlubang bukan sekadar masalah estetika—jika dibiarkan, kondisi ini bisa menyebabkan nyeri hebat, infeksi serius, bahkan kerusakan permanen pada jaringan gigi dan saraf. Artikel ini membahas penyebab utama gigi berlubang, gejala yang harus diwaspadai, serta dampak jangka panjang terhadap kesehatan mulut dan tubuh secara keseluruhan. Temukan juga tips pencegahan efektif agar Anda terhindar dari risiko gigi berlubang.', 'Artikel', 0x315f506c61744e6f6d6f725f312e6a7067, 1, '2025-06-09 09:56:16', '2025-05-29 09:18:40');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_dokter`
--

CREATE TABLE `jadwal_dokter` (
  `id_jadwal` int NOT NULL,
  `id_dokter` int NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `change_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jadwal_dokter`
--

INSERT INTO `jadwal_dokter` (`id_jadwal`, `id_dokter`, `hari`, `change_date`, `jam_mulai`, `jam_selesai`) VALUES
(16, 2, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(17, 2, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(18, 2, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(19, 2, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(20, 2, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(21, 3, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(22, 3, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(23, 3, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(24, 3, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(25, 3, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(26, 4, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(27, 4, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(28, 4, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(29, 4, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(30, 4, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(31, 52, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(32, 52, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(33, 52, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(34, 52, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(35, 52, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(36, 53, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(37, 53, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(38, 53, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(39, 53, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(40, 53, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(41, 54, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(42, 54, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(43, 54, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(44, 54, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(45, 54, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(46, 55, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(47, 55, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(48, 55, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(49, 55, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(50, 55, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(51, 56, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(52, 56, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(53, 56, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(54, 56, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(55, 56, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(56, 57, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(57, 57, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(58, 57, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(59, 57, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(60, 57, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(61, 58, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(62, 58, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(63, 58, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(64, 58, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(65, 58, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(66, 59, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(67, 59, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(68, 59, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(69, 59, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(70, 59, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(71, 60, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(72, 60, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(73, 60, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(74, 60, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(75, 60, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(76, 61, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(77, 61, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(78, 61, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(79, 61, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(80, 61, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(81, 62, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(82, 62, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(83, 62, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(84, 62, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(85, 62, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(86, 64, 'Senin', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(87, 64, 'Selasa', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(88, 64, 'Rabu', '2025-06-09 00:30:55', '08:00:00', '12:00:00'),
(89, 64, 'Kamis', '2025-06-09 00:30:55', '13:00:00', '17:00:00'),
(90, 64, 'Jumat', '2025-06-09 00:30:55', '08:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi`
--

CREATE TABLE `konsultasi` (
  `id_konsultasi` int NOT NULL,
  `id_dokter` int NOT NULL,
  `id_pasien` int NOT NULL,
  `keluhan` text NOT NULL,
  `tanggal_konsultasi` date NOT NULL,
  `status` enum('Belum','Sudah Selesai','Sedang Konsultasi') NOT NULL,
  `status_pembayaran` enum('Sudah','Belum') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `konsultasi`
--

INSERT INTO `konsultasi` (`id_konsultasi`, `id_dokter`, `id_pasien`, `keluhan`, `tanggal_konsultasi`, `status`, `status_pembayaran`) VALUES
(1, 2, 31, 'cabut gigi susu', '2025-05-27', 'Belum', 'Sudah'),
(2, 4, 28, 'gusi berdarah', '2025-05-15', 'Sudah Selesai', 'Sudah'),
(3, 3, 28, 'Sakit Gigi', '2025-05-20', 'Sedang Konsultasi', 'Sudah'),
(92, 4, 29, 'Anak susah makan karena sakit gigi', '2024-08-10', 'Sudah Selesai', 'Sudah'),
(93, 52, 30, 'Ingin merapikan susunan gigi', '2024-06-25', 'Belum', 'Sudah'),
(94, 53, 31, 'Gigi berlubang dan nyeri', '2024-07-05', 'Sedang Konsultasi', 'Sudah'),
(95, 54, 32, 'Gigi patah dan perlu tambal', '2024-08-15', 'Sudah Selesai', 'Sudah'),
(96, 55, 33, 'Gigi terasa goyang dan sakit', '2024-06-18', 'Belum', 'Sudah'),
(97, 56, 34, 'Gigi terasa kuning dan berkarang', '2024-07-22', 'Sedang Konsultasi', 'Sudah'),
(98, 57, 35, 'Gigi berlubang dan nyeri', '2024-08-12', 'Sudah Selesai', 'Sudah'),
(99, 58, 36, 'Anak susah makan karena sakit gigi', '2024-06-28', 'Belum', 'Sudah'),
(100, 59, 37, 'Ingin merapikan susunan gigi', '2024-07-08', 'Sedang Konsultasi', 'Sudah'),
(101, 60, 38, 'Gigi patah dan perlu tambal', '2024-08-18', 'Sudah Selesai', 'Sudah'),
(102, 61, 39, 'Gigi terasa goyang dan sakit', '2024-06-30', 'Belum', 'Sudah'),
(103, 2, 40, 'Gigi berlubang dan nyeri', '2024-07-10', 'Sudah Selesai', 'Sudah'),
(104, 3, 41, 'Anak susah makan karena sakit gigi', '2024-08-20', 'Sudah Selesai', 'Sudah'),
(105, 4, 42, 'Gigi terasa kuning dan berkarang', '2024-06-16', 'Sudah Selesai', 'Sudah'),
(106, 52, 43, 'Ingin merapikan susunan gigi', '2024-07-21', 'Sedang Konsultasi', 'Sudah'),
(107, 53, 44, 'Gigi patah dan perlu tambal', '2024-08-11', 'Sudah Selesai', 'Sudah'),
(108, 54, 45, 'Gigi terasa goyang dan sakit', '2024-06-26', 'Belum', 'Sudah'),
(109, 55, 46, 'Gigi berlubang dan nyeri', '2024-07-06', 'Sedang Konsultasi', 'Sudah'),
(110, 56, 47, 'Anak susah makan karena sakit gigi', '2024-08-16', 'Sudah Selesai', 'Sudah'),
(111, 57, 48, 'Gigi terasa kuning dan berkarang', '2024-06-19', 'Belum', 'Sudah'),
(112, 53, 28, 'ai', '2025-06-10', 'Belum', 'Belum'),
(113, 59, 28, 'atit', '2025-06-19', 'Belum', 'Belum'),
(114, 55, 28, 'ak', '2025-06-24', 'Belum', 'Belum');

-- --------------------------------------------------------

--
-- Table structure for table `layanan_dokter`
--

CREATE TABLE `layanan_dokter` (
  `id_layanan` int NOT NULL,
  `nama_layanan` varchar(255) NOT NULL,
  `biaya_layanan` int NOT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `layanan_dokter`
--

INSERT INTO `layanan_dokter` (`id_layanan`, `nama_layanan`, `biaya_layanan`, `status`) VALUES
(1, 'Perawatan Gigi', 500000, 'Aktif'),
(2, 'Pemeriksaan Gigi Anak', 300000, 'Aktif'),
(3, 'Pembersihan Gigi', 400000, 'Aktif'),
(4, 'Pasang Behel', 2500000, 'Aktif'),
(5, 'Tambal Gigi', 600000, 'Aktif'),
(6, 'Cabut Gigi', 700000, 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_06_12_110846_create_sessions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int NOT NULL,
  `foto_profil` mediumblob NOT NULL,
  `nama_panggilan` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `umur` int NOT NULL,
  `alamat` text NOT NULL,
  `noHp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `foto_profil`, `nama_panggilan`, `nama_lengkap`, `umur`, `alamat`, `noHp`) VALUES
(28, '', 'Mutia', 'Baiq Mutia Dewi Edelweis', 20, 'Jl. Gerung Kesasar No 21', '087124567121'),
(29, '', 'Fiana', 'Lutfiana', 20, 'Jl. JempongBaru No 12', '087123665512'),
(30, '', 'Jayee', 'I Nyoman Swardi Jaya Putra', 20, 'Jl. GunungSari No 1', '08533441201'),
(31, '', 'Eka', 'Ni Wayan Eka Aprilianti', 19, 'Jl. Tanjung No 21', '081921765100'),
(32, '', 'Wulan', 'Ni Luh Wulan Sari', 22, 'Jl. Mawar No?9', '081211110001'),
(33, '', 'Adi', 'I Putu Adi Wijaya', 28, 'Jl. Surya No?4', '081211110002'),
(34, '', 'Maya', 'Maya Rahmawati', 25, 'Jl. Udayana No?6', '081211110003'),
(35, '', 'Tono', 'I Made Tono Saputra', 31, 'Jl. Hasanudin No?2', '081211110004'),
(36, '', 'Ayu', 'Ni Luh Ayu Kencana', 24, 'Jl. Seruni No?3', '081211110005'),
(37, '', 'Rama', 'I Wayan Rama Pratama', 26, 'Jl. Nusa No?8', '081211110006'),
(38, '', 'Selvi', 'Selvi Oktaviani', 29, 'Jl. Anggrek No?12', '081211110007'),
(39, '', 'Farid', 'Farid Akbar', 27, 'Jl. Pisang No?15', '081211110008'),
(40, '', 'Galuh', 'Ni Putu Galuh Suryani', 23, 'Jl. Seroja No?5', '081211110009'),
(41, '', 'Lisa', 'Lisa Pratiwi', 30, 'Jl. Pahlawan No?7', '081211110010'),
(42, '', 'Rangga', 'I Ketut Rangga', 28, 'Jl. Rajawali No?1', '081211110011'),
(43, '', 'Yani', 'Yani Astuti', 24, 'Jl. Sakura No?14', '081211110012'),
(44, '', 'Rio', 'Rio Pratama', 26, 'Jl. Kemuning No?9', '081211110013'),
(45, '', 'Santi', 'Santi Widya', 25, 'Jl. Sanggul No?11', '081211110014'),
(46, '', 'Dwi', 'Dwi Prasetyo', 29, 'Jl. Sutra No?6', '081211110015'),
(47, '', 'Indra', 'I Gede Indra Putra', 27, 'Jl. Anyelir No?2', '081211110016'),
(48, '', 'Oki', 'Oki Firmansyah', 28, 'Jl. Palapa No?13', '081211110017'),
(49, '', 'Tari', 'Ni Kadek Tari Kusuma', 23, 'Jl. Kenari No?10', '081211110018'),
(50, '', 'Agus B', 'I Putu Agus Budiman', 30, 'Jl. Gajah Mada No?4', '081211110019');

-- --------------------------------------------------------

--
-- Table structure for table `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `id_rekam_medis` int NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `diagnose` text NOT NULL,
  `tindakan` text NOT NULL,
  `obat` text NOT NULL,
  `id_konsultasi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rekam_medis`
--

INSERT INTO `rekam_medis` (`id_rekam_medis`, `tanggal`, `diagnose`, `tindakan`, `obat`, `id_konsultasi`) VALUES
(1, '2025-06-13 21:32:37', 'atit gigi', 'suntik', 'cinta', 1),
(2, '2025-06-13 21:33:12', 'atit gigi', 'suntik', 'cinta', 1),
(3, '2025-06-13 21:44:11', 'boong', 'ngk ad', 'cinta', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('R6bWNTcqPmZpBtXLt28sogunZR2xUKBtgue7ixrJ', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicEQzRWpjZDZtVHBpcGxJbFlPNURQOGdwMXRBWmk4VmdSZUI0U1JqQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7czo1MzoibG9naW5fZG9rdGVyXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1749886365),
('Vo6as4PSl5RLoX7Lsano5cQ2qO7wlr0y3vlTAsjs', 28, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidTloN3k2NVBtSE12aHJFVENzN01JME5WN2tGNWUyMTVWNnA1ZjZOYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9maWxlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjg7czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NTM6ImxvZ2luX3Bhc2llbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI4O30=', 1749883187);

-- --------------------------------------------------------

--
-- Table structure for table `ulasan_dokter`
--

CREATE TABLE `ulasan_dokter` (
  `id_ulasan` int NOT NULL,
  `id_konsultasi` int NOT NULL,
  `id_dokter` int NOT NULL,
  `ulasan` text,
  `rating` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ulasan_dokter`
--

INSERT INTO `ulasan_dokter` (`id_ulasan`, `id_konsultasi`, `id_dokter`, `ulasan`, `rating`) VALUES
(23, 2, 4, '\"bawu kentut\"', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('admin','dokter','pasien') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$12$PUpc6B15H2ljFUTJ/LDt9uA6avUVAUBzt.Kma6AWFHuPfQ0c3VLnu', 'admin'),
(2, 'doktermutia', 'doktermutia@gmail.com', '$2y$12$INov75pkxfrDwtYJfHdZOeGNN9myBh5FHKDJrbknuE4BNqt4Ez6Kq', 'dokter'),
(3, 'dokterjaye', 'dokterjaye@gmail.com', '$2y$10$AFQQNeAniYZ1lHeVj/AFtOK1g6Nf1xZ3rwQNp02b.nBtIYHad4hfW', 'dokter'),
(4, 'dokterfiana', 'dokterfiana@gmail.com', '$2y$12$cP04LXM2XGH6rOd8.hOgFuJTd8W13YpWh1o6Ba5PcehrUOAYn/haC', 'dokter'),
(27, 'Misuky', 'Misuky@gmail.com', '$2y$10$qdMiN1TZCBSAgf9MkDzNgOz2bci1rJhFOUgu8AFdJvLkKyQ0cQRZa', 'pasien'),
(28, 'Mutia', 'Mutia@gmail.com', '$2y$12$vsBG84LdC.OkzCSNOATkq.TJNqPZ5A0NwFKx4XsNAXNgNk3NlfWOK', 'pasien'),
(29, 'Fiana', 'Fiana@gmail.com', '$2y$10$P8q0YrJYPlxhcZcyS4KVA.vKWukw3CCtJ6TPrfzAkgx2C4Kg4m3Wq', 'pasien'),
(30, 'Jaye', 'Jaye@gmail.com', '$2y$10$srHz5mgY9Ea4MZB9DoY9hOJXEjAsy4W9LSnRUw0NdGsgCaVx590sq', 'pasien'),
(31, 'Eka', 'Eka@gmail.com', '$2y$10$8vFZ9et/6x5A5Vd.et5pAOZOt9Fdm9S5I.0gUkwpqsZRyDRx3mfkW', 'pasien'),
(32, 'wulan', 'wulan@gmail.com', 'demo123', 'pasien'),
(33, 'adi', 'adi@gmail.com', 'demo123', 'pasien'),
(34, 'maya', 'maya@gmail.com', 'demo123', 'pasien'),
(35, 'tono', 'tono@gmail.com', 'demo123', 'pasien'),
(36, 'ayu', 'ayu@gmail.com', 'demo123', 'pasien'),
(37, 'rama', 'ramap@gmail.com', 'demo123', 'pasien'),
(38, 'selvi', 'selvi@gmail.com', 'demo123', 'pasien'),
(39, 'farid', 'farid@gmail.com', 'demo123', 'pasien'),
(40, 'galuh', 'galuh@gmail.com', 'demo123', 'pasien'),
(41, 'lisa', 'lisa@gmail.com', 'demo123', 'pasien'),
(42, 'rangga', 'rangga@gmail.com', 'demo123', 'pasien'),
(43, 'yani', 'yani@gmail.com', 'demo123', 'pasien'),
(44, 'rio', 'rio@gmail.com', 'demo123', 'pasien'),
(45, 'santi', 'santi@gmail.com', 'demo123', 'pasien'),
(46, 'dwi', 'dwi@gmail.com', 'demo123', 'pasien'),
(47, 'indra', 'indra@gmail.com', 'demo123', 'pasien'),
(48, 'oki', 'oki@gmail.com', 'demo123', 'pasien'),
(49, 'tari2', 'tari2@gmail.com', 'demo123', 'pasien'),
(50, 'agus2', 'agus2@gmail.com', 'demo123', 'pasien'),
(51, 'sari', 'sari@gmail.com', 'demo123', 'pasien'),
(52, 'dokternita', 'nita@gmail.com', 'demo123', 'dokter'),
(53, 'dokteragus', 'agus@gmail.com', 'demo123', 'dokter'),
(54, 'dokterlani', 'lani@gmail.com', 'demo123', 'dokter'),
(55, 'dokterrama', 'rama@gmail.com', 'demo123', 'dokter'),
(56, 'doktervina', 'vina@gmail.com', 'demo123', 'dokter'),
(57, 'dokteryoga', 'yoga@gmail.com', 'demo123', 'dokter'),
(58, 'dokterarti', 'arti@gmail.com', 'demo123', 'dokter'),
(59, 'dokteredo', 'edo@gmail.com', 'demo123', 'dokter'),
(60, 'dokterdina', 'dina@gmail.com', 'demo123', 'dokter'),
(61, 'dokterrizal', 'rizal@gmail.com', 'demo123', 'dokter'),
(62, 'Kaziya', 'Kaziya@gmail.com', '$2y$10$M3WHvOiTJ8KE9sABEBReOuONu16OnEqR8cn/cQNgQ8KM8aWFw9Brq', 'dokter'),
(63, 'Kaziya', 'DrKaziya@gmail.com', '$2y$10$YxIAdPTg19Ms6.DIhswUDOOuYxLs.nenmyMin630zq8uZ8zwTq.XS', 'dokter'),
(64, 'DrAnis', 'DrAnis@gmail.com', '$2y$10$ky0YhJo3YMnsJa7EUvygxevyGhpoRtHBf9AJVNi0mlAohXEezpfVG', 'dokter'),
(65, 'DrAnis', 'DrAnis@gmail.com', '$2y$10$ZTjLBzicb0pcopwFBjofxuQVpNTqkCAh1ToO2LCRLytv/o4ZeGOpi', 'dokter');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `foreign_key_layanan` (`id_layanan`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id_feed`),
  ADD KEY `foreign_key_id_admin` (`id_admin`);

--
-- Indexes for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `foreign_key_jadwal_id_dokter` (`id_dokter`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`id_konsultasi`),
  ADD KEY `foreign_key_dokter` (`id_dokter`),
  ADD KEY `foreign_key_pasien` (`id_pasien`);

--
-- Indexes for table `layanan_dokter`
--
ALTER TABLE `layanan_dokter`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`id_rekam_medis`),
  ADD KEY `fk_id_konsultasi` (`id_konsultasi`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `ulasan_dokter`
--
ALTER TABLE `ulasan_dokter`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD UNIQUE KEY `unique_konsultasi` (`id_konsultasi`),
  ADD KEY `foreign_key_ulasan_id_dokter` (`id_dokter`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id_dokter` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id_feed` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `id_konsultasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `layanan_dokter`
--
ALTER TABLE `layanan_dokter`
  MODIFY `id_layanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id_rekam_medis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ulasan_dokter`
--
ALTER TABLE `ulasan_dokter`
  MODIFY `id_ulasan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `foreign_key_id_admin_users` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `foreign_key_id_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `foreign_key_layanan` FOREIGN KEY (`id_layanan`) REFERENCES `layanan_dokter` (`id_layanan`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `feed`
--
ALTER TABLE `feed`
  ADD CONSTRAINT `foreign_key_id_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD CONSTRAINT `foreign_key_jadwal_id_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD CONSTRAINT `foreign_key_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `foreign_key_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `fk_pasien_users` FOREIGN KEY (`id_pasien`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `fk_id_konsultasi` FOREIGN KEY (`id_konsultasi`) REFERENCES `konsultasi` (`id_konsultasi`);

--
-- Constraints for table `ulasan_dokter`
--
ALTER TABLE `ulasan_dokter`
  ADD CONSTRAINT `foreign_key_ulasan_id_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
