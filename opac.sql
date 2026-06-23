-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 23, 2026 at 08:42 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opac`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publisher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_year` int DEFAULT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indonesia',
  `physical_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'buku',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `subject`, `publish_year`, `isbn`, `classification`, `category`, `language`, `physical_description`, `cover_image`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Orang-orang yang disayangi Allah', 'Ali Akbar', 'Erlangga', 'Islam, Karakter Islami, Keagamaan', 2019, '978-602-241-112-3', '297.313 Ali o', 'FAITH AND REASON ISLAM', 'Indonesia', 'xvi, 210 hlm. : ilus. ; 21 cm.', NULL, 'buku', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(2, 'Elements of chemical reaction engineering. 7th Ed.', 'H. Scott Fogler', 'Prentice Hall', 'Chemical Engineering, Chemical Reactions', 2020, '978-013-388-751-9', '660.2 Ele', 'CHEMICAL ENGINEERING', 'Inggris', 'xxviii, 980 p. : ill. ; 26 cm.', NULL, 'buku', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(3, 'Membangun jembatan menuju kemandirian penyandang disabilitas', 'Sihar Sitorus', 'Gramedia Pustaka Utama', 'Social Sciences, Disabilitas, Sosial Masyarakat', 2021, '978-602-06-4921-5', '305.908 Sir m', 'SOCIAL SCIENCE', 'Indonesia', 'xx, 185 hlm. ; 23 cm.', NULL, 'buku', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(4, 'Pengantar Ilmu Hukum dan Tata Hukum Indonesia', 'Kansil, C.S.T.', 'Balai Pustaka', 'Hukum Indonesia, Teori Hukum, Tata Hukum', 2018, '978-979-407-154-9', '340.1 Kan p', 'LAW', 'Indonesia', 'x, 480 hlm. ; 21 cm.', NULL, 'buku', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(5, 'Sistem Informasi Manajemen: Mengelola Perusahaan Digital', 'Kenneth C. Laudon', 'Salemba Empat', 'Sistem Informasi, Manajemen Bisnis, Digitalisasi', 2020, '978-979-061-912-8', '658.403 8 Lau s', 'MANAGEMENT', 'Indonesia', 'xxiv, 520 hlm. : ilus. ; 26 cm.', NULL, 'buku', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(6, 'Metode Penelitian Hukum: Normatif dan Empiris', 'Prof. Soerjono Soekanto', 'Rajawali Pers', 'Metodologi Penelitian, Hukum, Penelitian Normatif', 2022, '978-979-421-042-0', '340.072 Soe m', 'LAW', 'Indonesia', 'xii, 192 hlm. ; 21 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(7, 'Kalkulus Purcell Edisi 9 Jilid 1', 'Dale Varberg', 'Erlangga', 'Matematika, Kalkulus, Integral dan Diferensial', 2017, '978-979-015-821-4', '515 Var k', 'MATHEMATICS', 'Indonesia', 'xiv, 410 hlm. : ilus. ; 25 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(8, 'Prinsip-Prinsip Biokimia (Lehninger Principles of Biochemistry)', 'David L. Nelson', 'Omega Press', 'Biokimia, Biologi Molekuler, Kimia Organik', 2019, '978-146-412-611-6', '572 Nel p', 'BIOLOGY', 'Indonesia', 'xxx, 1100 hlm. : ilus. ; 28 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(9, 'Pengantar Teknologi Informasi Modern', 'Abdul Kadir', 'Andi Publisher', 'Teknologi Informasi, Ilmu Komputer, Internet', 2021, '978-623-01-0125-9', '004 Kad p', 'COMPUTER SCIENCE', 'Indonesia', 'x, 390 hlm. : ilus. ; 23 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(10, 'Struktur Data dan Algoritma dengan Python', 'Rinaldi Munir', 'Informatika Bandung', 'Pemrograman, Python, Struktur Data', 2023, '978-623-7131-75-5', '005.133 Mun s', 'COMPUTER SCIENCE', 'Indonesia', 'viii, 320 hlm. ; 24 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(11, 'Patologi Sosial 1: Masalah Sosial dan Penyimpangan', 'Kartini Kartono', 'Rajawali Pers', 'Sosiologi, Masalah Sosial, Penyimpangan Perilaku', 2018, '978-979-421-021-5', '302.5 Kar p', 'SOCIAL SCIENCE', 'Indonesia', 'xvi, 280 hlm. ; 21 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(12, 'Makroekonomi Teori Pengantar Edisi Ketiga', 'Sadono Sukirno', 'RajaGrafindo Persada', 'Ekonomi Makro, Kebijakan Fiskal, Pendapatan Nasional', 2019, '978-979-421-413-8', '339 Suk m', 'ECONOMICS', 'Indonesia', 'xii, 450 hlm. ; 24 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(13, 'Buku Ajar Fisiologi Kedokteran Guyton and Hall', 'John E. Hall', 'Elsevier Health Sciences', 'Kedokteran, Fisiologi Tubuh, Anatomi', 2021, '978-981-486-538-8', '612 Hal b', 'MEDICINE', 'Indonesia', 'xxvi, 1020 hlm. : ilus. ; 28 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(14, 'Asuhan Keperawatan Jiwa dengan Pendekatan Klinis', 'Budi Anna Keliat', 'EGC', 'Keperawatan Jiwa, Terapi Kognitif, Kesehatan Mental', 2020, '978-979-044-901-5', '610.736 Kel a', 'NURSING', 'Indonesia', 'x, 240 hlm. ; 23 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(15, 'Ilmu Kesehatan Masyarakat: Teori dan Aplikasi', 'Soekidjo Notoatmodjo', 'Rineka Cipta', 'Kesehatan Masyarakat, Epidemiologi, Sanitasi Lingkungan', 2018, '978-979-518-888-0', '614 Not i', 'PUBLIC HEALTH', 'Indonesia', 'viii, 340 hlm. ; 21 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(16, 'Farmakologi Dasar dan Klinik Edisi 14', 'Bertram G. Katzung', 'EGC', 'Farmasi, Farmakologi, Mekanisme Obat', 2019, '978-979-044-998-5', '615.1 Kat f', 'PHARMACY', 'Indonesia', 'xxx, 1250 hlm. : ilus. ; 28 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(17, 'Dasar-Dasar Kehutanan Tropis', 'H. Indriyanto', 'Bumi Aksara', 'Kehutanan, Hutan Tropis, Ekologi Hutan', 2017, '978-602-444-012-4', '634.9 Ind d', 'FORESTRY', 'Indonesia', 'xii, 290 hlm. ; 23 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(18, 'Koleksi Emas Parada Harahap: Sejarah Pers Sumatera', 'Parada Harahap', 'Balai Pustaka', 'Local Wisdom, Sejarah Pers, Sumatera Utara', 1952, 'N/A - Arsip Pustaka', '959.81 Har s', 'LOCAL WISDOM', 'Indonesia', 'x, 150 hlm. ; 18 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(19, 'Pertanian Berkelanjutan di Lahan Kering Tropis', 'Prof. Yusuf L. Limbongan', 'IPB Press', 'Pertanian, Agronomi, Lahan Kering', 2021, '978-623-256-421-2', '630 Lim p', 'AGRICULTURE', 'Indonesia', 'xiv, 220 hlm. ; 23 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(20, 'Konservasi Gigi Terpadu: Teori dan Aplikasi Praktis', 'Rasinta Tarigan', 'EGC', 'Kedokteran Gigi, Konservasi Gigi, Karies', 2018, '978-979-044-885-8', '617.6 Tar k', 'DENTISTRY', 'Indonesia', 'viii, 180 hlm. : ilus. ; 21 cm.', NULL, 'buku', '2026-06-23 00:23:14', '2026-06-23 00:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `call_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `book_id`, `location_id`, `barcode`, `call_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '1020190011', '297.313 Ali o c.1', 'Tersedia', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(2, 1, 1, '1020190012', '297.313 Ali o c.2', 'Tersedia', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(3, 1, 1, '1020190013', '297.313 Ali o c.3', 'Tersedia', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(4, 1, 1, '1020190014', '297.313 Ali o c.4', 'Dipinjam', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(5, 2, 1, '1020200021', '660.2 Ele c.1', 'Tersedia', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(6, 2, 1, '1020200022', '660.2 Ele c.2', 'Tersedia', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(7, 3, 8, '1020210031', '305.908 Sir m c.1', 'Tersedia', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(8, 3, 1, '1020210032', '305.908 Sir m c.2', 'Tersedia', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(9, 4, 2, '1020180041', '340.1 Kan p c.1', 'Tersedia', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(10, 4, 1, '1020180042', '340.1 Kan p c.2', 'Dipinjam', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(11, 4, 1, '1020180043', '340.1 Kan p c.3', 'Tersedia', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(12, 5, 4, '1020200051', '658.403 8 Lau s c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(13, 5, 1, '1020200052', '658.403 8 Lau s c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(14, 6, 2, '1020220061', '340.072 Soe m c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(15, 6, 1, '1020220062', '340.072 Soe m c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(16, 6, 1, '1020220063', '340.072 Soe m c.3', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(17, 6, 1, '1020220064', '340.072 Soe m c.4', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(18, 7, 13, '1020170071', '515 Var k c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(19, 7, 1, '1020170072', '515 Var k c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(20, 8, 13, '1020190081', '572 Nel p c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(21, 8, 1, '1020190082', '572 Nel p c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(22, 9, 13, '1020210091', '004 Kad p c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(23, 9, 1, '1020210092', '004 Kad p c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(24, 9, 1, '1020210093', '004 Kad p c.3', 'Dipinjam', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(25, 10, 13, '1020230101', '005.133 Mun s c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(26, 10, 1, '1020230102', '005.133 Mun s c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(27, 11, 8, '1020180111', '302.5 Kar p c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(28, 11, 1, '1020180112', '302.5 Kar p c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(29, 11, 1, '1020180113', '302.5 Kar p c.3', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(30, 11, 1, '1020180114', '302.5 Kar p c.4', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(31, 12, 4, '1020190121', '339 Suk m c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(32, 12, 1, '1020190122', '339 Suk m c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(33, 13, 7, '1020210131', '612 Hal b c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(34, 13, 1, '1020210132', '612 Hal b c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(35, 14, 11, '1020200141', '610.736 Kel a c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(36, 14, 1, '1020200142', '610.736 Kel a c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(37, 14, 1, '1020200143', '610.736 Kel a c.3', 'Dipinjam', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(38, 14, 1, '1020200144', '610.736 Kel a c.4', 'Dipinjam', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(39, 15, 5, '1020180151', '614 Not i c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(40, 15, 1, '1020180152', '614 Not i c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(41, 15, 1, '1020180153', '614 Not i c.3', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(42, 15, 1, '1020180154', '614 Not i c.4', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(43, 16, 16, '1020190161', '615.1 Kat f c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(44, 16, 1, '1020190162', '615.1 Kat f c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(45, 16, 1, '1020190163', '615.1 Kat f c.3', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(46, 16, 1, '1020190164', '615.1 Kat f c.4', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(47, 17, 18, '1020170171', '634.9 Ind d c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(48, 17, 1, '1020170172', '634.9 Ind d c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(49, 18, 19, '1019520181', '959.81 Har s c.1', 'Dipinjam', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(50, 18, 1, '1019520182', '959.81 Har s c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(51, 18, 1, '1019520183', '959.81 Har s c.3', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(52, 19, 10, '1020210191', '630 Lim p c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(53, 19, 1, '1020210192', '630 Lim p c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(54, 19, 1, '1020210193', '630 Lim p c.3', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(55, 20, 17, '1020180201', '617.6 Tar k c.1', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(56, 20, 1, '1020180202', '617.6 Tar k c.2', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(57, 20, 1, '1020180203', '617.6 Tar k c.3', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14'),
(58, 20, 1, '1020180204', '617.6 Tar k c.4', 'Tersedia', '2026-06-23 00:23:14', '2026-06-23 00:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `university_id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `university_id`, `code`, `name`, `icon`, `created_at`, `updated_at`) VALUES
(1, 1, 'perpustakaan_pusat', 'Perpustakaan Universitas', 'ph-books', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(2, 1, 'hukum', 'Fakultas Hukum', 'ph-scales', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(3, 1, 'ilmu_budaya', 'Fakultas Ilmu Budaya', 'ph-mask-happy', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(4, 1, 'ekonomi', 'Fakultas Ekonomi dan Bisnis', 'ph-chart-line-up', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(5, 1, 'kesehatan_masyarakat', 'Fakultas Kesehatan Masyarakat', 'ph-heartbeat', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(6, 1, 'pascasarjana', 'Sekolah Pascasarjana', 'ph-graduation-cap', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(7, 1, 'kedokteran', 'Fakultas Kedokteran', 'ph-stethoscope', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(8, 1, 'isip', 'Fakultas ISIP', 'ph-users-three', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(9, 1, 'out_of_stock', 'Koleksi Out of Stock', 'ph-archive-tray', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(10, 1, 'pertanian', 'Fakultas Pertanian', 'ph-plant', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(11, 1, 'keperawatan', 'Fakultas Keperawatan', 'ph-first-aid', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(12, 1, 'parlindungan', 'AP. Parlindungan Collections', 'ph-books', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(13, 1, 'mipa', 'Fakultas MIPA', 'ph-test-tube', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(14, 1, 'psikologi', 'Fakultas Psikologi', 'ph-brain', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(15, 1, 'sjahrir', 'Sjahrir Corner Collections', 'ph-books', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(16, 1, 'farmasi', 'Fakultas Farmasi', 'ph-pill', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(17, 1, 'kedokteran_gigi', 'Fakultas Kedokteran Gigi', 'ph-tooth', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(18, 1, 'kehutanan', 'Fakultas Kehutanan', 'ph-tree', '2026-06-23 00:23:13', '2026-06-23 00:23:13'),
(19, 1, 'local_wisdom', 'Local Wisdom', 'ph-map-trifold', '2026-06-23 00:23:13', '2026-06-23 00:23:13');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '0001_01_01_000100_create_universities_table', 1),
(5, '0001_01_01_000200_create_locations_table', 1),
(6, '0001_01_01_000300_create_books_table', 1),
(7, '0001_01_01_000400_create_items_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('s7dJBOoAwsKI4di0WDc0Hh8jK2u3bgFZzuXplKdg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.8655', 'eyJfdG9rZW4iOiJDcHBqZE82ckxBc0RrOXQ2T2pKRWZIMnRtakFqcEsxMGdlOGRQOU5KIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1782200409),
('V1d5535SCJpzZD9rW2VgHgi1HQo3DkaijDuMfEiX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI5Z3ZKakJsMmxnWG9Kb01NVWNWRlgzM3VRUGRxa3pLdkhVUGo3MEJaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1782204082),
('vc4MiLPI8ah2f8xLLGtzbjy0eg4nUqiSJQOssk2w', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.8655', 'eyJfdG9rZW4iOiJwUzhJdktWU3BMOHBFUlhWVE5xV1dlQlpORjVkdE12cGxSYTdSTTBEIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9zZWFyY2giLCJyb3V0ZSI6InNlYXJjaCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1782203240);

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

CREATE TABLE `universities` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`id`, `code`, `name`, `logo_path`, `created_at`, `updated_at`) VALUES
(1, 'usu', 'Universitas Sumatera Utara', 'logousu.jpeg', '2026-06-23 00:23:13', '2026-06-23 00:23:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Perpustakaan USU', 'admin@usu.ac.id', '2026-06-23 00:23:13', '$2y$12$TjG1E5h8vF/Ch7z7EzAR3eKeG5QcxCwSxt5Upji3/Bk4hXEQU/NwW', 'mVl11d3s0V', '2026-06-23 00:23:13', '2026-06-23 00:23:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_barcode_unique` (`barcode`),
  ADD KEY `items_book_id_foreign` (`book_id`),
  ADD KEY `items_location_id_foreign` (`location_id`);

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
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_code_unique` (`code`),
  ADD KEY `locations_university_id_foreign` (`university_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `universities_code_unique` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
