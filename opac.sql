-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 29, 2026 at 04:16 AM
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
  `call_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Umum',
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indonesia',
  `physical_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'buku',
  `publication_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general_note` text COLLATE utf8mb4_unicode_ci,
  `golongan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `subject`, `publish_year`, `isbn`, `classification`, `call_number`, `category`, `language`, `physical_description`, `cover_image`, `jenis`, `publication_city`, `edition`, `general_note`, `golongan`, `created_at`, `updated_at`) VALUES
(1, 'Orang-orang yang disayangi Allah', 'Ali Akbar', 'Pustaka Al-Kautsar', 'FAITH AND REASON-ISLAM', 2005, '979-592-324-2', '297.313', '297.313 Ali o', 'Agama', 'Indonesia', 'xx, 368 p. : ilus. ; 23 cm', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-27 06:47:43'),
(2, 'Elements of chemical reaction engineering. 7th Ed.', 'H. Scott Fogler', 'Prentice Hall', 'Chemical Engineering, Chemical Reactions', 2020, '978-013-388-751-9', '660.2', '660.2 Ele', 'Teknik', 'Inggris', 'xxviii, 980 p. : ill. ; 26 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(3, 'Membangun jembatan menuju kemandirian penyandang disabilitas', 'Sihar Sitorus', 'Gramedia Pustaka Utama', 'Social Sciences, Disabilitas, Sosial Masyarakat', 2021, '978-602-06-4921-5', '305.908', '305.908 Sir m', 'Sosial & Humaniora', 'Indonesia', 'xx, 185 hlm. ; 23 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(4, 'Pengantar Ilmu Hukum dan Tata Hukum Indonesia', 'Kansil, C.S.T.', 'Balai Pustaka', 'Hukum Indonesia, Teori Hukum, Tata Hukum', 2018, '978-979-407-154-9', '340.1', '340.1 Kan p', 'Hukum', 'Indonesia', 'x, 480 hlm. ; 21 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(5, 'Sistem Informasi Manajemen: Mengelola Perusahaan Digital', 'Kenneth C. Laudon', 'Salemba Empat', 'Sistem Informasi, Manajemen Bisnis, Digitalisasi', 2020, '978-979-061-912-8', '658.403', '658.403 8 Lau s', 'Komputer & Informatika', 'Indonesia', 'xxiv, 520 hlm. : ilus. ; 26 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(6, 'Metode Penelitian Hukum: Normatif dan Empiris', 'Prof. Soerjono Soekanto', 'Rajawali Pers', 'Metodologi Penelitian, Hukum, Penelitian Normatif', 2022, '978-979-421-042-0', '340.072', '340.072 Soe m', 'Hukum', 'Indonesia', 'xii, 192 hlm. ; 21 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(7, 'Kalkulus Purcell Edisi 9 Jilid 1', 'Dale Varberg', 'Erlangga', 'Matematika, Kalkulus, Integral dan Diferensial', 2017, '978-979-015-821-4', '515', '515 Var k', 'Matematika & IPA', 'Indonesia', 'xiv, 410 hlm. : ilus. ; 25 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(8, 'Prinsip-Prinsip Biokimia (Lehninger Principles of Biochemistry)', 'David L. Nelson', 'Omega Press', 'Biokimia, Biologi Molekuler, Kimia Organik', 2019, '978-146-412-611-6', '572', '572 Nel p', 'Sains & Teknologi', 'Indonesia', 'xxx, 1100 hlm. : ilus. ; 28 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(9, 'Pengantar Teknologi Informasi Modern', 'Abdul Kadir', 'Andi Publisher', 'Teknologi Informasi, Ilmu Komputer, Internet', 2021, '978-623-01-0125-9', '004', '004 Kad p', 'Komputer & Informatika', 'Indonesia', 'x, 390 hlm. : ilus. ; 23 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(10, 'Struktur Data dan Algoritma dengan Python', 'Rinaldi Munir', 'Informatika Bandung', 'Pemrograman, Python, Struktur Data', 2023, '978-623-7131-75-5', '005.133', '005.133 Mun s', 'Komputer & Informatika', 'Indonesia', 'viii, 320 hlm. ; 24 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(11, 'Patologi Sosial 1: Masalah Sosial dan Penyimpangan', 'Kartini Kartono', 'Rajawali Pers', 'Sosiologi, Masalah Sosial, Penyimpangan Perilaku', 2018, '978-979-421-021-5', '302.5', '302.5 Kar p', 'Sastra & Bahasa', 'Indonesia', 'xvi, 280 hlm. ; 21 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(12, 'Makroekonomi Teori Pengantar Edisi Ketiga', 'Sadono Sukirno', 'RajaGrafindo Persada', 'Ekonomi Makro, Kebijakan Fiskal, Pendapatan Nasional', 2019, '978-979-421-413-8', '339', '339 Suk m', 'Ekonomi & Bisnis', 'Indonesia', 'xii, 450 hlm. ; 24 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(13, 'Buku Ajar Fisiologi Kedokteran Guyton and Hall', 'John E. Hall', 'Elsevier Health Sciences', 'Kedokteran, Fisiologi Tubuh, Anatomi', 2021, '978-981-486-538-8', '612', '612 Hal b', 'Kesehatan & Kedokteran', 'Indonesia', 'xxvi, 1020 hlm. : ilus. ; 28 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(14, 'Asuhan Keperawatan Jiwa dengan Pendekatan Klinis', 'Budi Anna Keliat', 'EGC', 'Keperawatan Jiwa, Terapi Kognitif, Kesehatan Mental', 2020, '978-979-044-901-5', '610.736', '610.736 Kel a', 'Kesehatan & Kedokteran', 'Indonesia', 'x, 240 hlm. ; 23 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(15, 'Ilmu Kesehatan Masyarakat: Teori dan Aplikasi', 'Soekidjo Notoatmodjo', 'Rineka Cipta', 'Kesehatan Masyarakat, Epidemiologi, Sanitasi Lingkungan', 2018, '978-979-518-888-0', '614', '614 Not i', 'Seni & Desain', 'Indonesia', 'viii, 340 hlm. ; 21 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(16, 'Farmakologi Dasar dan Klinik Edisi 14', 'Bertram G. Katzung', 'EGC', 'Farmasi, Farmakologi, Mekanisme Obat', 2019, '978-979-044-998-5', '615.1', '615.1 Kat f', 'Umum', 'Indonesia', 'xxx, 1250 hlm. : ilus. ; 28 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(17, 'Dasar-Dasar Kehutanan Tropis', 'H. Indriyanto', 'Bumi Aksara', 'Kehutanan, Hutan Tropis, Ekologi Hutan', 2017, '978-602-444-012-4', '634.9', '634.9 Ind d', 'Pertanian & Kehutanan', 'Indonesia', 'xii, 290 hlm. ; 23 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(18, 'Koleksi Emas Parada Harahap: Sejarah Pers Sumatera', 'Parada Harahap', 'Balai Pustaka', 'Local Wisdom, Sejarah Pers, Sumatera Utara', 1952, 'N/A - Arsip Pustaka', '959.81', '959.81 Har s', 'Sejarah & Geografi', 'Indonesia', 'x, 150 hlm. ; 18 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(19, 'Pertanian Berkelanjutan di Lahan Kering Tropis', 'Prof. Yusuf L. Limbongan', 'IPB Press', 'Pertanian, Agronomi, Lahan Kering', 2021, '978-623-256-421-2', '630', '630 Lim p', 'Pertanian & Kehutanan', 'Indonesia', 'xiv, 220 hlm. ; 23 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(20, 'Konservasi Gigi Terpadu: Teori dan Aplikasi Praktis', 'Rasinta Tarigan', 'EGC', 'Kedokteran Gigi, Konservasi Gigi, Karies', 2018, '978-979-044-885-8', '617.6', '617.6 Tar k', 'Kesehatan & Kedokteran', 'Indonesia', 'viii, 180 hlm. : ilus. ; 21 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(21, 'Panduan Pemrograman Modern', 'John Doe', NULL, NULL, 2026, NULL, NULL, 'Joh p', 'Sains & Teknologi', 'Indonesia', '100 hlm.', '1782440261_bukuteknologi.jpg', 'buku', NULL, NULL, NULL, NULL, '2026-06-25 18:52:17', '2026-06-25 19:17:41'),
(22, 'Bahan ajar mata kuliah penafsiran potret udara', 'Rahmawaty', 'Program Doktor Ilmu Pertanaian Pascasarjana USU', 'AERIAL PHOTOGRAPHY IN FORESTRY', 2002, NULL, '634.928 507 6', '634.928 507 6 Rah b', 'Pertanian & Kehutanan', 'Indonesia', 'iii, 10 p. : illus. ; 28 cm.', NULL, 'skripsi', 'Medan', NULL, 'Peserta Lokakarya AA Angkatan XVII', NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(23, 'Disaster management : international lessons in risk reduction, response and recovery', 'Lopez-Carresi, Alejandro', 'Routledge', 'EMERGENCY MANAGEMENT; CRISIS MANAGEMENT', 2014, '978-1-84971-347-4', '363.34', '363.34 Dis', 'Sosial & Humaniora', 'Inggris', 'xxii, 330 p. : ilus. ; 25 cm', NULL, 'buku', 'London', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(24, 'Engineering electromagnetics, 9th ed.', 'Hayt, William H.; Buck, John A.', 'McGraw-Hill Education', 'ELECTROMAGNETIC THEORY', 2019, '978-1-260-08456-6', '530.141', '530.141 Hay e', 'Teknik', 'Inggris', 'xiv, 594 p. : ilus. ; 30 cm', NULL, 'buku', 'New York', '9', NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(25, 'Buku ajar pemasaran digital', 'Noor, Zulki Zulkifli', 'Deepublish', 'INTERNET MARKETING-STUDY AND TEACHING', 2024, '978-623-02-7991-1', '658.872 07', '658.872 07 Noo b', 'Ekonomi & Bisnis', 'Indonesia', 'x, 177 p. : ilus. ; 23 cm', NULL, 'buku', 'Yogyakarta', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(26, 'Deep learning for vision systems', 'Elgendy, Mohamed', 'Manning Publication Co.', 'COMPUTER VISION', 2020, '9781617296192', '006.37', '006.37 Elg d', 'Umum', 'Inggris', 'xx, 458 p. : ilus. ; 30 cm', NULL, 'buku', 'New Jersey', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(27, 'Gadis kretek', 'Kumala, Ratih', 'Gramedia Pustaka Utama', 'INDONESIA FICTION', 2024, '978-979-22-8141-5', '899.221 3', '899.221 3 Kum g', 'Sastra & Bahasa', 'Indonesia', '275 p. : ilus. ; 10 cm', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(28, 'Teknologi additive manufacturing (3d printing) berbasis stereolithography', 'Muflikhun, Muhammad Akhsin', 'Gajah Mada University Press', 'ADDITIVE MANUFACTURING; MANUFACTURING PROSSES', 2024, '978-623-339-433-2', '670.42', '670.42 Muf t', 'Teknik', 'Indonesia', 'xxiv, 226 p. : ilus. ; 23 cm', NULL, 'buku', 'Yogyakarta', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(29, 'Algoritma dan pemrograman komputer', 'Andayani, Ulfi', 'Yayasan Sinergi Inspirasi Indonesia', 'ALGORITHMS - COMPUTER PROGRAM', 2025, '978-634-04-0864-5', '518.102 855 3', '518.102 855 3 Alg', 'Komputer & Informatika', 'Indonesia', 'vi, 110 p. : ilus. ; 15 cm.', NULL, 'buku', 'Medan', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(30, 'Ergonomi dalam transportasi', 'Lady, Lovely', 'Deepublish', 'TRANSPORTATION DEMAND MANAGEMENT', 2023, '978-623-02-6333-0', '629.04', '629.04 Lad e', 'Teknik', 'Indonesia', 'x, 147 p. : ilus. ; 23 cm', NULL, 'buku', 'Yogyakarta', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(31, 'Kolaborasi pentahelik dalam pengembangan pariwisata', 'Nasution, Solahuddin', 'Dunia Penerbitan Buku', 'TOURISM DEVELOPMENT', 2025, '978-634-7332-23-3', '338.479 1', '338.479 1 Nas k', 'Sosial & Humaniora', 'Indonesia', 'vi, 160 p. : ilus. ; 30 cm', NULL, 'buku', 'Sumatera Barat', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(32, 'Komunikasi terapeutik dan kesehatan mental : membuka pintu pemahaman', 'Zulkarnain, Iskandar; Sutatminingsih, Raras', 'Angkasa Media Literasi', 'MENTAL HEALTH CONSULTATION', 2025, '978-634-7407-37-5', '615.581', '615.581 Zul k', 'Sosial & Humaniora', 'Indonesia', 'x, 434 p. : ilus. ; 15 cm', NULL, 'buku', 'Pekan Baru', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(33, 'Frekuensi konsumsi fast food dan pengaruhnya terhadap intensitas dismenore', 'Savira, Maya; Wongso, Vanessa', 'Global Aksara Pers', 'DYSMENORRHEA - FAST FOOD CONSUMPTION ASPECTS', 2025, '978-623-462-962-0', '618.172', '618.172 Sav f', 'Teknik', 'Indonesia', '67 p. : ilus. ; 10 cm', NULL, 'buku', 'Jawa Timur', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(34, 'Aspen plus : chemical engineering applications, 2nd ed.', 'Al-Malah, Kamal', 'John Wiley & Sons, Inc.', 'ASPEN PLUS - CHEMICAL ENGINEERING APPLICATIONS', 2023, '978-1-119-86869-9', '660.040 285', '660.040 285 Alm a', 'Teknik', 'Indonesia', 'xix, 619 p. : ilus. ; 30 cm', NULL, 'buku', 'New Jersey', '2', NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(35, 'Electromagnetic field theory', 'Bakshi, Uday A.; Bakshi, Late Ajay V.', 'Technical Publications', 'MATHEMATICS-STUDY AND TEACHING', 2020, '978-93-332-2355-3', '510.7', '510.7 Bak e', 'Matematika & IPA', 'Inggris', 'xviii, No. hal tidak beraturan ; 23 cm', NULL, 'buku', 'India', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(36, 'Environmental and natural resource economics', 'Aruga, Kentaka', 'Graduate School of Humanities', 'ENVIRONMENTAL ECONOMICS', 2022, '978-3-030-95076-7', '333.7', '333.7 Aru e', 'Sosial & Humaniora', 'Inggris', 'xiii, 193 p.: ilus ; 24cm', NULL, 'buku', 'Switzerland', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(37, 'Fundamental of pneumatics and hydraulics', 'Salam, Abdus', 'Springer Nature', 'PNEUMATIC MACHINERY; HYDRAULIC MACHINERY', 2022, '978-981-19-0857-6', '621.51', '621.51 Sal f', 'Sosial & Humaniora', 'Inggris', 'xvi, 403 p.: ilus. ; 23cm', NULL, 'buku', 'Singapore', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(38, 'Industrial chemical process analysis and design, 2nd Ed.', 'Martin, Mariano Martin', 'Candice Janco', 'CHEMICAL PROCESS DESIGN', 2026, '978-0-443-36420-4', '660.281', '660.281 Mar i', 'Teknik', 'Inggris', 'xii, 518 p.: ilus. ; 27cm', NULL, 'buku', 'India', '2', NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(39, 'Metode penelitian kuantitatif, kualitatif, dan R&D', 'Sugiyono', 'Alfabeta', 'METHODOLOGY RESEARCH; SPSS (COMPUTER PROGRAMS-RESEARCH)', 2010, '979-8433-64-0', '001.42', '001.42 Sug m', 'Umum', 'Indonesia', 'x, 334 p. : ilus. ; 27 cm', NULL, 'buku', 'Bandung', NULL, NULL, NULL, '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
(40, 'Membangun jembatan menuju kemandirian penyandang disabilitas', 'Siregar, Hairani', 'Prokreatif', 'SOCIOLOGY OF DISABILITY', 2025, '978-634-7066-56-9', '305.908', '305.908 Sir m', 'Sosial & Humaniora', 'Indonesia', '113 p. : ilus. ; 24 cm', NULL, 'buku', 'Medan', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(41, 'Elements of chemical reaction engineering. 7th. Ed.', 'Fogler, H. Scott', 'Pearson', 'CHEMICAL ENGINEERING', 2025, '978-0-13-533755-4', '660.2', '660.2 Ele', 'Teknik', 'Inggris', 'xxix, 1096 p. ; 27 cm.', NULL, 'buku', 'New Jersey', '7th', NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(42, 'Orang-orang yang disayangi Allah', 'Al-Iskandari, Muhammad', 'Pustaka Al-Kautsar', 'FAITH AND REASON-ISLAM', 2005, '979-592-324-2', '297.313', '297.313 Ali o', 'Agama', 'Indonesia', 'xx, 368 p. : ilus. ; 23 cm', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(43, 'M 68000 : 16/32 - bit microprocessor ; programmers reference manual. -- 4th ed', 'Tidak Diketahui', 'Prentica Hall', 'ELECTRONIC DIGITAL COMPUTERS-DESIGN AND CONSTRUCTION', 1984, '013-566795-X', '621.381 952', '621.381 952 M', 'Seni & Desain', 'Inggris', 'xv, 218 p. : ilus. ; 24 cm.', NULL, 'buku', 'New Jersey', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(44, 'M 6805 HMOS, M146805 CMOS family : microcomputer', 'Tidak Diketahui', 'Prentica Hall', 'ELECTRONIC DIGITAL COMPUTERS-DESIGN AND CONSTRUCTION', 1983, '013541375-3', '621.381 95', '621.381 95 M', 'Seni & Desain', 'Inggris', 'xi, 249 p. : ilus. ; 24 cm.', NULL, 'buku', 'New Jersey', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(45, 'M.C. higgins, the great', 'Hamilton, Virginia', 'Schaum\'s Outline Series', 'ENGLISH FICTION', 1996, '0-590-67297-5', '823', '823 Ham m', 'Sastra & Bahasa', 'Inggris', '278 p. ; 20 cm', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(46, 'M.Hasballah Thaib : pemikiran dan karya monumentalnya', 'Khalifah, Hamdani', '[Commonwealth]', 'RELIGIONS BIOGRAPHY - HISTORY AND CRITISIM;RELIGIONS AWAKENING - ISLAM', 2005, NULL, '297.092', 'R 297.092 Kha m', 'Agama', 'Indonesia', 'xxiii, 419 p. : ilus. ; 24 cm.', NULL, 'buku', 'Medan', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(47, 'M.I.C.E convention and Leisure for businessman', 'Tegar', 'FT UGM', 'CONVENTION FACILITIES - PUBLIC RELATIONS - BUSINESS ENTERPRISES ENVIRONMENTAL ASPECTS', 2015, NULL, '690.8', '690.8 Teg m', 'Sosial & Humaniora', 'Indonesia', 'xxii, 155 p.: ilus. ; 29 cm', NULL, 'disertasi', 'Medan', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(48, 'M.K. Gandhi : an Indian patriot in South Africa', 'Doke, Joseph J.', 'Ministry of Foregn Affairs', 'M.K. GANDHI-BIOGRAPHY', 1967, NULL, '923.2', '923.2 Dok m', 'Sejarah & Geografi', 'Inggris', '166 p. ; 24 cm.', NULL, 'buku', 'India', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(49, 'Maaf tuhan, aku hampir menyerah', 'Alfialghazi', 'Sahima', 'MOTIVATION - RELIGIOUS ASPECTS - ISLAM', 2022, '978-602-6744-47-0', '297.261', '297.261 Alf m', 'Agama', 'Indonesia', 'x, 258 p. : ilus. ; 23 cm', NULL, 'buku', 'Jawa Barat', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(50, 'Maag : kenali, hindari, dan obati (panduan praktis mencegah dan mengatasi penyakit maag di lengkapi 50 resep makanan yang cocok untuk penderita maag', 'Yuliarti, Nurheti', 'Andi', 'STOMACH - INFECTION - COMPLICATIONS STOMACH - DISEASES - HOMEOPATHIC TREATMENT', 2009, '978-979-29-0984-5', '616.33', '616.33 Yul m', 'Kesehatan & Kedokteran', 'Indonesia', 'viii, 146 p. : ilus. ; 23 cm', NULL, 'buku', 'Yogyakarta', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(51, 'Maandblad der vereeniging van inspecteurs van financien', 'Tidak Diketahui', 'J.M.Bent', 'PRESS LAW', 1935, NULL, '343.099 8', 'R 343.099 8 Maa', 'Hukum', 'Belanda', '428 p. ; 22 cm.', NULL, 'buku', '[s.l.]', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(52, 'Maatcschap firma dan persekutuan komanditer', 'Prasetya, Rudhi', 'Citra Aditya Bakti', 'CORPORATION LAW', 2002, '979-414-864-4', '344.066', '344.066 Pra m', 'Hukum', 'Indonesia', 'viii, 62 p. ; 21 cm.', NULL, 'buku', 'Bandung', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(53, 'Maatschap firma dan persekutuan komanditer', 'Prasetya, Rudhi', NULL, 'CORPORATION LAW', 2002, '979-414-864-4', '346.066', '346.066 Pra m', 'Hukum', 'Indonesia', 'viii, 62 p. : 21 cm.', NULL, 'buku', 'Bandung', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(54, 'Mabrur sebelum haji', 'Zainuddin, Syaikh bin Abdul Aziz al-Malibari', 'Mitra Pustaka', 'ISLAMIC LEGENDS', 2005, NULL, '297.18', '297.18 Zai m', 'Agama', 'Indonesia', 'xiii, 221 p. : ilus. ; 21 cm', NULL, 'buku', 'Yogyakarta', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(55, 'Mabuk ni genye soyong ni ragi', 'Hakim, A.R.', 'Departemen Pendidikan dan Kebudayaan', 'STORY TELLING-GAYO; GAYONESE - LITERATURE', 1986, NULL, '808.543 11', '808.543 11 Hak m', 'Sastra & Bahasa', 'Indonesia', '63 p. ; 21 cm.', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(56, 'Mac OS X : mountain lion', 'Tidak Diketahui', 'Jasakom', 'SYSTEM OPERATION OF MAC OSX MOUNTAIN LION - STUDY AND TEACHING', 2013, '978-979-1090-76-6', '003.07', '003.07 Mac', 'Sosial & Humaniora', 'Indonesia', 'ix, 161 p. : ilus ; 23 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(57, 'Macam - macam penyakit menular dan pencegahannya', 'Yatim, Faisal', 'Pustaka Populer Obor', 'EPIDEMIOLOGY', 2001, '979-461-373-8', '614.4', '614.4 Yat m', 'Kesehatan & Kedokteran', 'Indonesia', 'vii, 93 p. ; 17 cm.', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(58, 'Macam-macam penyakit menular & cara pencegahannya 2', 'Yatim, Faisal', 'Pustaka Obor Populer', 'EPIDEMIOLOGY', 2007, '979-4616-32-X', '614.4', '614.4 Yat m', 'Kesehatan & Kedokteran', 'Indonesia', '169 p. ; ilus. ; 20 cm', NULL, 'buku', 'Jakarta', NULL, 'Jilid : 2', NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(59, 'Macam-macam ulir', 'Zulkarnaini', 'Politeknik Jurusan Akuntansi USU', 'MACHINE PARTS', 1999, NULL, '621.82', '621.82 Zul m', 'Seni & Desain', 'Indonesia', 'Tidak ada no. hal. ; ilus. ; tab. ; 28 cm.', NULL, 'laporan', 'Medan', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(60, 'Macapat modern dalam sastra jawa : analisa bentuk dan isi', 'Haryatmo, Sri', 'Pusat Bahasa Departemen Pendidikan Nasional', 'JAVANESE LITERATURE', 2003, '979-685-380-9', '899.231', '899.231 Mac', 'Sastra & Bahasa', 'Indonesia', 'ix 122 p. ; ilus. ; 21 cm', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(61, 'Macapat tradisional dalam bahasa Jawa', 'Laginem ... [et.al]', 'Pusat Pembinaan dan Pengembangan Bahasa', 'JAVANESE LANGUAGE (YOGYAKARTA) POETRY', 1996, NULL, '808.812 33', '808.812 33 Ind m', 'Sastra & Bahasa', 'Indonesia', 'xii, 144 p. : ilus. ; 21 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(62, 'Macarthur Sang Penakluk', 'Manchester, William', 'Pustaka Rihlah', 'Perang Dunia 1939-1945 - Pertempuran Fasifik', 1994, '979-416-311-2', '940.542 6', '940.542 6 Man m', 'Seni & Desain', 'Indonesia', 'ix, 357 p. : 20.5 cm', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(63, 'Macarthur sang penakluk', 'Manchester, William', 'Pustaka Sinar Harapan', 'WORLD WAR II 1939-1945 - PACIFIC WAR', 1989, '979-416-043-1', '940.542 6', '940.542 6 Man d', 'Seni & Desain', 'Indonesia', '412 p. : ilus. ; 23 cm', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(64, 'Macbeth', 'Elloway, D. R.;Series', 'McGrow-Hill', '1. ENGLISH-DRAMA', 1985, '0 333 13571 7', '822', '822 Mac', 'Sastra & Bahasa', 'Indonesia', 'vii, 191 p. ; 18 cm. -- McMillan Shakespeare', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(65, 'MacBryde\'s signs and symptons : applied pathologic physiology and clinical interpretation', 'Blacklow, Robert S.', 'J.B Lippincott', 'PHYSIOLOGY, PATHOLOGICAL', 1983, '0-397-52094-8', '616.07', '616.07 Bla m', 'Teknik', 'Inggris', 'xxiii, 935 p. : ilus. ; 25 cm.', NULL, 'buku', 'Philadelphia', '6', NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(66, 'MacGraw-Hill nursing dictionary', 'Armstrong, Margaret E.', 'McGraw Hill/Irwin', 'NURSING-DICTIONARIES;MEDICAL-DICTIONARIES', 1979, '0-07-045019-6', '610.3', 'R 610.3 Mac', 'Kesehatan & Kedokteran', 'Inggris', 'xxvii, 1211 p. : tab. ; 21 cm.', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(67, 'Machinary\'s handbook, 22nd Ed', 'Tidak Diketahui', 'Indopov', 'MACHINARY - HANDBOOKS', 1984, '0-8311-1155-0', '621.8', '621.8 Mac', 'Teknik', 'Inggris', 'xiv, 2512 p. : ilus. ; 19 cm', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(68, 'Machine and assembly language programming of the PDP - 11', 'Gill, Arthur', 'Prentice Hall', 'PDP-11 (COMPUTER)-PROGRAMMING;ASSEMBLER LANGUAGE (COMPUTER PROGRAM LANGUAGE)', 1983, '013 541 888 7', '001.642', '001.642 Gil m', 'Komputer & Informatika', 'Inggris', 'ix, 211 p. : ilus. ; 24 cm.', NULL, 'buku', 'Englewood Cliffs, NJ', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(69, 'Machine design', 'Creamer, Robert H.', 'Addison Wesley', 'MACHINERY-DESIGN', 1983, '0-201-11280-9', '621.815', '621.815 Cre m', 'Seni & Desain', 'Inggris', 'xiii, 654 p. : ilus. ; tab. ; 24 cm.', NULL, 'buku', 'Reading, Massachusetts', '3rd', 'Ind. : p. I1 - I7', NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(70, 'Machine design', 'Leyer, Albert; Cook-Radmore, D.;Urry, Sydney', 'Blackie', 'MACHINE DESIGN ; MACHINERY-MODELS', 1974, '0-216-87457-2', '621.815', '621.815 Ley m', 'Seni & Desain', 'Inggris', 'Ind. : p. 113 - 115;ISBN : 0-216-87457-2', NULL, 'buku', NULL, NULL, 'Ind. : p. 113 - 115', NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(71, 'Machine design', 'Black, Paul H.', 'McGraw Hill/Irwin', 'MACHINERY-DESIGN', 1955, NULL, '621.815', '621.815 Bla m', 'Seni & Desain', 'Inggris', 'viii, 471 p. : Ilus. ; 20 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(72, 'Machine design', 'Bradford, Louis J.; Eaton, Paul B.', NULL, 'MACHINERY - DESIGN', 1947, NULL, '621.815', '621.815 Bra m', 'Seni & Desain', 'Inggris', 'x, 283 p. : ilus. ; 22 cm.', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(73, 'Machine design : an integrated approach', 'Norton, Robert L.', 'Prentice-Hall', 'MACHINERY-DESIGN', 1996, '0-13-254012-6', '621.815', '621.815 Nor m', 'Seni & Desain', 'Inggris', 'xxiii, 1048 p. : ilus: tab. ; 23 cm.', NULL, 'buku', 'New Jersey', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(74, 'Machine design : an integrated approach, 4th ed', 'Norton, Robert L.', 'Pearson', 'MACHINE DESIGN', 2011, '978-0-13-138438-5', '621.815', '621.815 Nor m', 'Seni & Desain', 'Inggris', '1055 p. : ilus. ; 27 cm', NULL, 'buku', 'Boston', '4', 'Including CD', NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(75, 'Machine design calculations reference guide', 'Hicks, Tyler G.', 'McGra-Hill Book', 'MACHINERY-DESIGN-HANDBOOKS, MANUAL', 1987, '0-07-028799-6', '621.8', '621.8 Mac', 'Seni & Desain', 'Inggris', 'viii, 184 p. : ilus. ; tab. ; 23 cm. --; (The McGraw Hill engineering reference guide series)', NULL, 'buku', 'New York', NULL, 'Bib. : p. 1 ; Ind. : p. 181 - 184', NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(76, 'Machine drafting and related technology', 'Yankee, Herbert W.', 'Greewood Press', 'MECHANICAL-DRAWINGS', 1981, '0-07-072252-8', '621.802 21', '621.802 21 Yan m', 'Teknik', 'Inggris', 'viii, 584 p. : ilus. ; tab. ; 24 cm.', NULL, 'buku', 'New York', NULL, 'Bib. : p. 575 - 577 ; Ind. : 578 - 584', NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(77, 'Machine elements : a textbook', 'Dobrovolsky, V.', 'Ministry of Primary Industries', 'MACHINE DESIGN', 1977, NULL, '621.815', '621.815 Mac', 'Seni & Desain', 'Inggris', '492 p. : ilus. ; 22 cm.', NULL, 'buku', 'Moscow', NULL, 'Ind. : p. 488-492', NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(78, 'Machine elements in mechanical design', 'Mott, Robert L.', 'Pearson Prentice Hall', 'MACHINE DESIGN; MECHANICAL MOVEMENTS', 2004, '0-13-061885-3', '621.815', '621.815 Mot m', 'Seni & Desain', 'Inggris', 'xiii, 872 p. : ilus. ; 25 cm.', NULL, 'buku', 'New Jersey', '4', NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(79, 'Machine learning & computational intelligence', 'Budiharto, Widodo', 'Andi', 'COMPUTER SCIENCE - MATHEMACTICS', 2016, '978-979-29-5849-2', '004', '004 Bud m', 'Komputer & Informatika', 'Indonesia', 'vi, 265 p. : ilus. ; 23 cm', NULL, 'buku', 'Yogyakarta', NULL, NULL, NULL, '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
(80, 'Machine learning & reasoning fuzzy logic : algoritma, manual, matlab, & rapid miner', 'Santoso, Budi; Azis, Azminuddin I.S.; Zohrahayaty', 'Deepublish (Group Penerbitan CV Budi Utama)', 'MACHINE LEARNING AND FUZZY LOGIC - STUDY AND TEACHING', 2020, '978-623-02-0631-3', '006.315 113 130 7', '006.315 113 130 7 San m', 'Komputer & Informatika', 'Indonesia', 'xxii, 216 p. : ilus. ; 25 cm.', NULL, 'buku', 'Yogyakarta', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(81, 'Machine learning : tingkat dasar dan lanjut', 'Suyanto', 'Informatika', 'MACHINE LEARNING - STUDY AND TEACHING', 2018, '978-602-6232-78-6', '006.310 7', '006.310 7 Suy m', 'Komputer & Informatika', 'Indonesia', 'xxxviii, 466 p. : ilus. ; 23 cm', NULL, 'buku', 'Bandung', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(82, 'Machine learning design patterns :solutions to common challenges in data preparation, model building, and MLOps', 'Lakshmanan, Valliappa; Robinson, Sara; Munn, Michael', 'O\'Relly Media', 'MACHINE LEARNING - STUDY AND TEACHING; ARTIFICIAL INTELLIGIENCE', 2021, '978-1-098-11578-4', '006.312', '006.312 Lak m', 'Komputer & Informatika', 'Inggris', 'xiv, 390 p. : ilus. ; 23 cm', NULL, 'buku', 'Tokyo', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(83, 'Machine learning in radiation oncology : theory and applications', 'Naqa, Issam El', 'Springer', 'COMPUTERIZED AXIAL TOMOGRAPHY - MACHINE; RADIATION - INDUSTRIAL APPLICATION EQUIPMENT AND SUPPLIES', 2015, '978.3-319-18304-6', '616.075 722', '616.075 722 Mac', 'Komputer & Informatika', 'Inggris', 'xiv, 336 p. : ilus. ; 23 cm', NULL, 'buku', 'London', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(84, 'Machine perception', 'Nevatia, Ramakant', 'Prentice Hall', 'PATTERN RECOGNITION SYSTEMS', 1982, '013 541904 2', '001.534', '001.534 Nev m', 'Umum', 'Inggris', 'xiii, 209 p. ; ilus. ; 24 cm', NULL, 'buku', 'Englewood Cliffs, New Jersey', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(85, 'Machine shop practice', 'Moltrecht, KArl Hans', 'Indopov', 'MACHINE-SHOP PRACTICE', 1979, '0-8311-1126-7', '670.423', '670.423 Mol m', 'Teknik', 'Inggris', '2 vol. : ilus. ; tab. ; 23 cm.', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(86, 'Machine shop training', 'Krar, S. F.; Oswald, J. W.', 'McGraw-Hill Ryerson Limited', 'MACHINE-SHOP PRACTICE', 1986, '0-07-548981-1', '669.423', '669.423 Kra m', 'Teknik', 'Inggris', '227 p. : ilus. ; tab. ; 24 cm.', NULL, 'buku', 'Toronto', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(87, 'Machine toll operation part I: Safety, measuring tools, bench work, the orill press, the lathe, forge work', 'Burghardt, Henry D; Axelrod, Adron;Anderson, James', 'McGraw Hill/Irwin', 'MACHINE TOOLS', 1959, NULL, '621.902', '621.902 Bur m', 'Seni & Desain', 'Inggris', 'xx, 588 p. : Ilus. ; 17 cm', NULL, 'buku', 'New York', NULL, 'Ind.: p. 577 - 588', NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(88, 'P-4 Pedoman Penghayatan dan Pengaman Pancasila dan Ajaran Islam', 'Tidak Diketahui', 'Direktorat Jenderal Bimbingan Masyarakat Ilslam Departemen Agama RI', 'IDEOLOGY (PANCASILA) - INDONESIA', 1978, NULL, '320.559 8', '320.559 8 Ped', 'Agama', 'Indonesia', '53 P. ; 20 cm', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(89, 'P-450 and chemistry carcinogenesis', 'Japan Scientific Sociaties; Tagashira, Yusaku ; Omura, Tsuneo', 'Japan P.E.N. Club', 'CYTOCHOROME P-450; CANCER', 1985, NULL, '616.994', '616.994 Jap p', 'Sains & Teknologi', 'Inggris', 'xii, 175 p. : ilus. ; 27 cm. --; (Monograph on cancer research no. 30)', NULL, 'buku', 'Tokyo', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(90, 'P-H-P : php dan ke-GR-an itu beda tipis', 'Sitinjak, Dedy Rahmad', 'Fisipol-USU', 'STORY TELLING', NULL, '978-6027-19700-8', '808.543', '808.543 Sit p', 'Sastra & Bahasa', 'Indonesia', '208 p. : ilus. ; 23 cm', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(91, 'P. C. tools : deluxe companion quick reference guide', 'Maas, K.; Stephani, W.', 'Abacus', 'P. C. TOOLS (COMPUTERS)', 1990, '1-55755-016-6', '001.642 5', '001.642 5 Maa p', 'Umum', 'Inggris', 'iii, 246 p. : ilus. ; 21 cm.', NULL, 'buku', 'Duesseldorf', NULL, 'Ind. : p. 241 - 246', NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(92, 'P.l longer letter later', 'Danziger, Paula; Ann M. Martin', 'Schaum\'s Outline Series', 'AMERICAN FICTION (CORRESPONDENCE)', 1998, '0-590-21311-3', '813.651 75', '813.651 75 Dan p', 'Sastra & Bahasa', 'Inggris', '234 p. : ilus. ; 20 cm', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(93, 'P3K + dengan herbal : pertolongan pertama penyakit dan kecelakaan', 'Tsauri, Sofyan', 'Penebar Swadaya', 'MEDICINAL PLANTS', 2006, '979-489-983-6', '615.321', '615.321 Tsa p', 'Kesehatan & Kedokteran', 'Indonesia', '123 p. : ilus. ; 23 cm', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(94, 'P3K anjing dan kucing', 'Dharmojono', 'Penebar Swadaya', 'VETERINARY MEDICINE', 2001, '979-489-492-3', '636.089', '636.089 Dha p', 'Teknik', 'Indonesia', 'xii, 92 p. : ilus. ; 21 cm.', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(95, 'P3K di rumah, tempat kerja dan di perjalanan', 'Machfoedz, Ircham', 'Fitramaya', 'FIRST AID IN ILLNESS AND INJURY; MEDICAL EMERGENCIES; EMERGENCIES HEALTH SERVICES', 2007, '978-979-3734-05-7', '362.18', '362.18 Per', 'Sosial & Humaniora', 'Indonesia', 'viii, 120 p. : ilus. ; 23 cm', NULL, 'buku', 'Yogyakarta', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(96, 'Pabean, imigrasi, dan karantina', 'Mulyanto, Felix Hadi', 'Gramedia Pustaka Utama', 'TARIFF AND CUSTOMS ADMINISTRATION - INDONESIA', 1997, '979-605-754-9', '352.448 598', '352.448 598 Mul p', 'Sosial & Humaniora', 'Indonesia', 'vii, 144 p. : ilus. ; 21 cm.', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(97, 'Pacar merah Indonesia buku pertama Tan Malaka : petualangan buron polisi rahasia kolonial', 'Mona, Matu', 'KITLV', 'INDONESIAN FICTION; TAN MALAKA LITERATURE HISTORY-FICTION', 2001, '979-95978-16-4', '899.221 3', '899.221 3 Mon p', 'Sastra & Bahasa', 'Indonesia', 'xxxv, 279 p. : ilus. ; 21 cm.', NULL, 'buku', 'Yogyakarta', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(98, 'Paces for the MRCP with 250 clinical cases, 2nd ed', 'Hall, Tim', 'Churchill Livingstone Elsevier', 'RADIOGPRAHY, MEDICAL - PROCESSING', 2008, '978-0443-10370-4', '616.075 72', '616.075 72 Hal p', 'Teknik', 'Inggris', 'xiii, 746 p. : ilus. ; 27 cm', NULL, 'buku', 'Edenburgh', '2', NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(99, 'Pacific - basin finance journal, July 1995', 'Rhee, S. Ghon', 'Elsevier Science', 'FINANCE - JOURNAL - PACIFIC - BASIN', 1995, NULL, '332.051 823', '332.051 823 Pac', 'Ekonomi & Bisnis', 'Inggris', '391 p. : ilus. ; 25 cm.', NULL, 'buku', 'Canada', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(100, 'Pacific century : the emergence of modern pacific Asia', 'Borthwick, Mark', 'Westview Press', 'ASIA, SOUTHEASTERN-POLITICS AND GOVERNMENT-1945; EAST ASIA-POLITICS AND GOVERNMENT', 1998, '0 7329 5066 X', '950', '950 Bor p', 'Sejarah & Geografi', 'Inggris', 'xv, 582 p. : ilus. ; 26 cm.', NULL, 'buku', 'Sydney', '2', 'Ind. : p. 561 - 582', NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(101, 'Pacific financial technical assistance centre 2008-2011', 'Asian Development Bank', 'Asian Development Banj', 'FINANCE PUBLIC - PACIFIC', 2008, NULL, '336.182 3', '336.182 3 Asi p', 'Ekonomi & Bisnis', 'Inggris', '13 p. : ilus. ; 29 cm', NULL, 'buku', 'Philipines', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(102, 'Pacific lautheren university : catalog', 'Tidak Diketahui', 'P3T-USU', 'UNIVERSITIES AND COLLEGES-PACIFIC LUTHEREN UNIVERSITY-CATALOGS, 1984', 1984, NULL, '378.753', 'R 378.753 Pac', 'Sosial & Humaniora', 'Inggris', '134 p. ; 27 cm.', NULL, 'buku', NULL, NULL, 'Ind. : p. 131 - 132', NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(103, 'Pacific private sector development initiative : progress report 2014-2015', 'Asian Development Bank', 'ADB', 'PROGRESS - REPORT - PACIFIC', 2016, NULL, '303.441 023', '303.441 023 Asi p', 'Sosial & Humaniora', 'Indonesia', 'ix, 91 p. : ilus. ; 29 cm', NULL, 'buku', 'Philippines', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(104, 'Pacific region environmental strategy 2005-2009', 'McCauley, Daniele;Calanog, Lope A.', 'ADB', 'ENVIRONMENTAL ECONOMICS', 2004, NULL, '338.927', 'ADB 338.927 Pac', 'Sosial & Humaniora', 'Inggris', 'xi, 252 p. : ilus. ; 28 cm.', NULL, 'buku', 'Manila', NULL, 'Vol.II: Case studies(Mainstreaming the environment in development planning and menegement)', NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(105, 'Pacific region environmental strategy 2005-2009, Vol.1 strategy document', 'Asian Development Bank', 'Asian Development Bank', 'TRANSITION-ENVIRONMENTAL ASPECTS', 2004, '971-561-527-9', '338.927', 'ADB 338.927 Pac', 'Sosial & Humaniora', 'Inggris', 'ix, 146 p. : ilus. ; 28 cm.', NULL, 'buku', 'Manila', NULL, 'Vol. 1: Strategy Document', NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(106, 'Pacific RIM : area of change, area of opporturnity', 'Aikman, David', 'Little, Brown Company', 'POLITICS AND GOVERNMENT - EAST ASIA; ECONOMIC CONDITION', 1986, '0-316-02039-7', '320.959', '320.959 Aik p', 'Sosial & Humaniora', 'Inggris', 'xv, 193 p. : ilus. ; 21 cm.', NULL, 'buku', 'Canada', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(107, 'Paco-paco (kota) Padang : sebuah sejarah kota di Indonesia pada abad -20 dan penggunaan ruang kota', 'Colombijn, Freek', 'Ohio State University', 'HISTORY - PADANG (WEST SUMATRA) - INDONESIA', 2006, '979-3472-58-3', '958.13', '958.13 Col p', 'Sejarah & Geografi', 'Indonesia', 'xxii, 548 p. : ilus. ; 25 cm.', NULL, 'buku', 'Yogyakarta', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(108, 'Pacuan senjata angkatan laut', 'Perserikatan Bangsa-Bangsa', 'Perserikatan Bangsa-Bangsa', 'INTERNATIONAL MARITIME LAW', 1986, NULL, '341.756 6', '341.756 6 Per p', 'Hukum', 'Indonesia', 'xiii, 267 p. : ilus. ; 28 cm.', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(109, 'Pada abad-abad pertama Islam (abad VII-XII)', 'Moktefi, Mokhtar;Tosun, Sedat', 'Axios', 'CIVILIZATION, ISLAMIC', NULL, NULL, '297.9', '297.9 Pad', 'Agama', 'Indonesia', '68 p. : ilus. ; 28 cm. --; (Seri kisah kehidupan manusia)', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(110, 'Pada-Mu aku bersimpuh', 'Gong, Gola; Jaiz, M.', 'Studi dinamika pedesaan survey agro ekonomi', 'INDONESIAN FICTION', 2000, '979-96194-0-8', '899.221 3', '899.221 3 Gon p', 'Sastra & Bahasa', 'Indonesia', 'viii, 237 p. : ilus. ; 18 cm.', NULL, 'buku', 'Serang', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(111, 'Padalangan 1', 'Salmun, M.A.', 'Depdikbub RI', '1. JAVANESE LITERATURE-ANCIENT HISTORY', 1986, NULL, '899. 222 090 1', '899. 222 090 1 Sal p', 'Sastra & Bahasa', 'Indonesia', '220 p. : ilus. ; 21 cm', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(112, 'Padalangan 2', 'Salmun, M.A', 'Depdikbub RI', '1. JAVANESE LITERATURE-ANCIENT HISTORY', 1986, NULL, '899.222 090 1', '899.222 090 1 Sal p', 'Sastra & Bahasa', 'Indonesia', '151 p. ; ilus. 21 cm', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(113, 'Padanan makna budaya dalam karya sastra : kajian kasus terjemahan novel animal farm dalam bahasa Indonesia', 'Mono, Umar', 'FIB S2', 'TRANSLATING AND INTERPRETING - INFLUENCES ON CULUTRE WORDS OF SEMANTIC BY NOVEL ANIMAL FARM ENVIRONMENTAL ASPECTS', 2015, NULL, '418.02', '418.02 Mon p', 'Sosial & Humaniora', 'Indonesia', 'xiii, 304 p. : ilus. ; 29 cm', NULL, 'disertasi', 'Medan', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(114, 'Padanan verba bahasa Inggeris dalam bahasa Indonesia ( sebuah studi kasus penerjemahan )', 'Silalahi, Roswita', 'Universitas Sains malaysia', 'TRANSLATION', 2000, NULL, '418.02', '418.02 Sil p', 'Sastra & Bahasa', 'Indonesia', 'xv. 84 p. : ilus. ; 28 cm', NULL, 'laporan', 'Medan', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(115, 'Padang kota andaleh di pesisir barat Sumatra barat', 'Koestoro, Lucas Partanda; Abbas, Novida; Wibisono, Sonny; Utomo, Bambang Budi', 'Balai Arkeologi', 'PADANG - HISTORY', 2007, '978-979-98772-3-9', '959.813', '959.813 Pad', 'Sejarah & Geografi', 'Indonesia', 'iv, 72 p. : ilus. ; 27 cm', NULL, 'buku', 'Medan', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(116, 'Padang riwayatmu dulu', 'Amran, Rusli', 'Yasaguna', 'PADANG-HISTORY', 1988, NULL, '959.813', '959.813 Amr p', 'Sejarah & Geografi', 'Indonesia', '392 p. : ilus. ; 21 cm.', NULL, 'buku', 'Jakarta', NULL, 'Ind. : p. 381 - 392', NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(117, 'Padanglawas dalam angka 2010', 'Badan Pusat Statistik', 'Badan Pusat Statistik Kota Medan', 'STATISTICS - NORTH SUMATERA (PADANG LAWAS)', 2010, NULL, '315.559 812', '315.559 812 Bad p', 'Hukum', 'Indonesia', 'xliv, 229 p. : ilus. ; 23 cm', NULL, 'buku', 'Padang Lawas', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(118, 'Padatan oksida logam : struktur, sintesis dan sifat-sifatnya', 'Ismunandar', 'Israel Program for Scientific Translations', 'ALLOYS;METALLURGY', 2004, NULL, '669', '669 Ism p', 'Teknik', 'Indonesia', 'xviii 172 p. : ilus. ; 24 cm', NULL, 'buku', 'Bandung', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(119, 'Paddy irrigation and water management in Southeast Asia', 'Rice, E. B.', 'Wordsworth and ITP', 'IRRIGATION-ASIA, SOUTHEASTERN;RICE-IRRIGATION-ASIA, SOUTHEASTERN-MANAGEMENT', 1997, NULL, '333.913 959', 'ADB 333.913 959 Ric p', 'Umum', 'Inggris', 'xix, 64 p. : ilus. ; 28 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(120, 'Paddy soil science', 'Kyuma, Kazutake', 'Kyoto University Press', 'SOIL SCIENCE; RICE-SOILS', 2004, '1-920901-00-0', '631.413 318', '631.413 318 Kyu p', 'Teknik', 'Inggris', 'xv, 280 p. : ilus. ; 23 cm.', NULL, 'buku', 'Sakyo-ku, Kyoto Japan', NULL, 'p. 278 - 280', NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(121, 'Padi', 'Suparyono; Setyono, Agus', 'Penebar Swadaya', 'RICE', 1993, '979-489-187-8', '633.18', '633.18 Sup p', 'Pertanian & Kehutanan', 'Indonesia', 'vii, 118 p. : ilus. ; 21 cm.', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(122, 'Padi lahan marjinal', 'Noor, Muhammad', 'Penebar Swadaya', 'RICE', 1996, '979-489-374-9', '633.18', '633.18 Noo p', 'Pertanian & Kehutanan', 'Indonesia', 'xix, 213 p. : ilus. ; 21 cm.', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(123, 'Padi sri organik Indonesia', 'Purwasasmita, Mubiar; Sutaryat, Alik', 'Penebar Swadaya', 'PADDY RICE - INDONESIA', 2018, '978-979-002-633-9', '633.185 98', '633.185 98 Pur p', 'Pertanian & Kehutanan', 'Indonesia', '148 p. : ilus ; 23 cm.', NULL, 'buku', NULL, 'revisi', NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(124, 'Padjak daerah dan retribusi daerah', 'Soedargo, R.', 'Ercontaa Rajawali', 'TAX ADMINISTRATION', 1964, NULL, '352.13', '352.13 Soe p', 'Sosial & Humaniora', 'Indonesia', 'ii, 242 p. ; 22 cm.', NULL, 'buku', 'Bandung', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(125, 'Padjak daerah sebagai sumber keuangan daerah suatu perbandingan Tokyo, manila, Bangkok, DCI Djakarta', 'Siagian, A.', 'Dinas Padjak & Pendapatan', 'TAX RURAL; INCOME FINANCIAL', 1969, NULL, '336.201 734', '336.201 734 Sia p', 'Ekonomi & Bisnis', 'Indonesia', 'vi, 132 p. : ilus. ; 23 cm', NULL, 'buku', 'Djakarta', NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(126, 'Padjak Pendjualan', 'Boediono, B.', 'Humanika', 'SALES TAX', 1971, NULL, '336.271 3', '336.271 3 Boe p', 'Sosial & Humaniora', 'Indonesia', '186 p. ; 21 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(127, 'Padjak pendjualan', 'Astrawinata, A. Moerad; Soemitro, Rochmat', 'Ercontaa Rajawali', 'SALES TAX', 1969, NULL, '336.271 3', '336.271 3 Ast p', 'Sosial & Humaniora', 'Indonesia', 'xi, 205 p. ; 22 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
(128, 'Padjak pendjualan : suatu pengantar', 'Boediono, B.', 'Rajawali Press/Yayasan Ilmu-ilmu Sosial', 'SALES TAX', 1969, NULL, '336.271 3', '336.271 3 Boe p', 'Sosial & Humaniora', 'Indonesia', '140 p. ; 20 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(129, 'Padjak peredaran omzetbelasting : undang2 darurat tt. 13 pebruari 1950 no. 12', 'Indonesia. (Undang - undang, Peraturan, dsb.)', 'Nippon Budokan Foundaton', 'TAXATION-LAW AND LEGISLATION', 1950, NULL, '336.202 6', '336.202 6 Ind p', 'Hukum', 'Indonesia', '119 p. ; 23 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(130, 'Padjak-daerah dan retribusi-daerah', 'Soedargo, R.', 'N.V. Eresco', 'TAXATION', 1964, NULL, '336.2', '336.2 Soe p', 'Sosial & Humaniora', 'Indonesia', '238 p. ; 22 cm.', NULL, 'buku', 'Bandung', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(131, 'Paduan paket program printmaster plus dan printshop: program perancang gambar dan kartu', 'Ellyawati, J.; Susiati, A. Tri', 'Elex Media Komputindo', 'PRINTMASTER PLUS, PRINTSHOP', 1991, NULL, '005.120 28', '005.120 28 Ell p', 'Seni & Desain', 'Indonesia', 'ix, 103 p. : ilus. ; 21 cm.', NULL, 'buku', 'Jakarta', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(132, 'Paduan paket program wordstar professional release: ditambah word perfect version 5; dilengkapi lettrix, PC tools deluxe, sidekick', 'Murniadi', 'Gralia Indonesia', 'WORDSTAR 5', 1991, NULL, '005.36', '005.36 Mur p', 'Umum', 'Indonesia', 'x, 148 p. : ilus. ; 23 cm.', NULL, 'buku', NULL, 'Cet. 3', NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(133, 'A Handbook for ambulance room attendants', 'C. E. Watson', 'Bailliere, Tindall and Cox', 'MEDICAL SCIENCES', 1961, NULL, '610', '610 Wat h', 'Teknik', 'Inggris', '120 p. : ilus. ; 18 cm.', NULL, 'buku', 'London', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(134, 'A year in the life of an ESL student : idioms and vocabulary you can\'t live without', 'Francis, Edward J', 'Total Media', '1. ENGLISH LANGUAGE-IDIOMS 2. ENCYCLOPEDIAS AND DICTIONARIES', 2004, '141202003-4', '418.413 131 3', '418.413 131 3 Fra y', 'Sastra & Bahasa', 'Inggris', 'iv, 297 p. : ilus. ; 27 cm', NULL, 'buku', 'Canada', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(135, 'A 2nd helping of chicken soup for the Soul', 'Canfield, Jack', 'Gramedia Pustaka Utama', 'SOCIAL ACTION - STDY ANG TEACHING', 1996, '979-605-442-6', '361.207', '361.207 Can e', 'Sosial & Humaniora', 'Inggris', 'xxvii, 384 p. : ilus. ; 23 cm', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(136, 'A background to english : a book about Britain for African and Asian students', 'Tregidgo, P.S.', 'Longmans', 'GREAT BRITAIN-HISTORY', 1962, NULL, '941', '941 Tre b', 'Sejarah & Geografi', 'Inggris', 'xi, 177 p. : ilus. ; 22 cm.', NULL, 'buku', 'London', NULL, 'Ind. : p. 173-177', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(137, 'A balanced introduction to computer science', 'Reed, David', 'Pearson / Longman', 'DATA STRUCTURES (COMPUTER SCIENCE)', 2005, '0-13-127774-X', '005.73', '005.73 Ree b', 'Komputer & Informatika', 'Inggris', 'xix, 371 p. : ilus. ; 28 cm.', NULL, 'buku', 'New Jersey', NULL, 'Ind. : p. 367 - 371', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(138, 'A balanced introduction to computer science', 'Reed, David', 'Pearson / Longman', 'COMPUTER SCIENCE - VOCATIONAL GUIDANCE : DATA STRUCTURES (COMPUTER SCIENCE)', 2008, '978-0-13-135829-4', '005.73', '005.73 Ree b', 'Komputer & Informatika', 'Inggris', 'xix, 380 p. : ilus. ; 27 cm', NULL, 'buku', 'New Jersey', '2', NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(139, 'A balinese temple festival', 'Hooykaas, C.', 'Marsell Information', 'INDONESIAN-TEMPLE', 1977, NULL, '291.350 959 8', '291.350 959 8 Hoo b', 'Agama', 'Inggris', 'ix, 172 p. ; ilus : 24 cm.', NULL, 'buku', 'The Hague', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(140, 'A Bank for half the world : the story of the Asian Development Bank 1966-1986', 'Wilson, Dick', 'ADB', 'BANKS AND BANKING, ASIAN-HISTORY', 1987, '971-124-002-5', '332.153', 'ADB 332.153 Wil b', 'Sejarah & Geografi', 'Inggris', '392 p. : ilus ; 24 cm.', NULL, 'buku', 'Manila', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(141, 'A Banking system in transation : the origin, concept, and growth Indonesian banking system', 'Charlesworth, Harold Karl', 'The New Nusantara', 'BANKS AND BANKING', 1959, NULL, '332.1', '332.1 Cha b', 'Sosial & Humaniora', 'Inggris', '219 p. : ilus: 23 cm.', NULL, 'buku', 'Djakarta', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(142, 'A banking system in transition : the origin, concept and growth of the Indonesian banking system', 'Charlesworth, Harold Karr', 'The National Committe for Commemoration of the Thirtieth Anniversary', 'BANK AND BANKING', 1959, NULL, '332.159 8', '332.159 8 Cha b', 'Sosial & Humaniora', 'Inggris', '219 p. : ilus. ; 23 cm.', NULL, 'buku', 'Djakarta', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(143, 'A Basic course in algebraic topology', 'Massey, William S.', 'Springen', 'TOPOLOGY', 1991, '0 387 97430 X', '514.2', '514.2 Mas b', 'Sains & Teknologi', 'Inggris', 'xvi, 428 p. : ilus. ; 23 cm', NULL, 'buku', 'New York', 'Ed.1', 'Graduate text in mathematics; 127', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(144, 'A Basic course in statistics', 'Clarke, G. M.; Cooke, D.', 'Edward Arnold Publisher', 'MATHEMATICAL STATISTICS', 1983, '0-7131-3496-8', '519.5', '519.5 Cla b', 'Matematika & IPA', 'Inggris', 'xvi, 421 p. : ilus. ; tab. ; 24 cm', NULL, 'buku', 'Bedford Scuare, London', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(145, 'A Basic guide for valuing a company : putting a value on cash flow taking industry and economic forces into account valuing information technology and dot-coms', 'Yegge, Wilbur M.', 'John Wiley & Sons (Asia)', 'BUSINESS ENTERPRICES - VALUATION', 2002, '0-471-15047-9', '338.71', '338.71 Yeg b', 'Sosial & Humaniora', 'Inggris', 'x, 294 p. : ilus. ; 21 cm.', NULL, 'buku', 'New York', NULL, 'Ind. : p. 293 - 294', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(146, 'A basic library list for four year colleges. -- 2nd ed', 'Mathematical Association of America', 'Ziyad Visi Media', 'MATHEMATICS-BIBLIOGRAPHY', 1976, '0 88385 423 6', '510.16', 'R 510.16 Mat b', 'Matematika & IPA', 'Inggris', '106 p. : ilus. ; 21 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `subject`, `publish_year`, `isbn`, `classification`, `call_number`, `category`, `language`, `physical_description`, `cover_image`, `jenis`, `publication_city`, `edition`, `general_note`, `golongan`, `created_at`, `updated_at`) VALUES
(147, 'A basic library list for two-year colleges. -- 2nd ed', 'Mathematical Association of America', 'Ziyad Visi Media', 'MATHEMATICS-BIBLIOGRAPHY', 1980, '0 88385 436 8', '510.16', 'R 510.16 Mat b', 'Matematika & IPA', 'Inggris', '65 p. ; 21 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(148, 'A basic math approach to concepts of chemistry', 'Michels, Leo', 'Brooks/ Cole Publishing', 'CHEMISTRY, PRINCIPLES -REACTIONS', 1993, '0-534-20622-0', '541.39', '541.39 Mic b', 'Sains & Teknologi', 'Inggris', 'viii, 343 p. : ilus. ; 27 cm.', NULL, 'buku', 'California', '5th Ed.', NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(149, 'A beautful mind', 'Nasar, Sylvia', 'Longmans Green', 'NASH, JOHN FORBES-BIOGRAPY;MATHEMATICIANS-UNITED STATES-BIOGRAPY', 1998, '0-684-85370-1', '510.92', 'AMC 510.92 Nas b', 'Umum', 'Inggris', '459 p. ; 23 cm.', NULL, 'buku', 'New York', NULL, 'Ind. : p. 441 - 459', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(150, 'A beginner\'s guide to technical communication', 'Eisenberg, Anne', 'McGraw Hill International', 'COMMUNICATION - METHODOLOGY', 1998, '0-07-115689-5', '302.2', '302.2 Eis b', 'Sosial & Humaniora', 'Inggris', 'xiii, 91 p. : ilus. ; 23 cm', NULL, 'buku', 'Boston', NULL, 'Ind. : p. 89-91', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(151, 'A Berkley book : N or M', 'Christie, Agatha', 'Berkley Books', 'INDONESIAN-POETRY', 1984, NULL, '823', '823 Chr b', 'Sastra & Bahasa', 'Inggris', '233 p. ; 18 cm.', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(152, 'A Berkley books : there is a tide...', 'Christie, Agatha', 'Berkley Books', 'DETECTIVE AND MYSTERY STORIES', 1984, '0-425-06803-X', '808.838 72', '808.838 72 Chr b', 'Sastra & Bahasa', 'Inggris', '231 p. ; 20 cm.', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(153, 'A beta-return efficient portofolio optimisation following the CAPM : an analysis of international markets and sectors', 'Vollmer, Markus', 'Springer', 'INTERNATIONAL TRADE', 2015, '978-3-658-06633-8', '658.848', '658.848 Vol b', 'Teknik', 'Inggris', '124 p. : ilus ; 21 cm.', NULL, 'buku', 'Germany', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(154, 'A better investment climate for everyone.', 'Tidak Diketahui', 'Wordsworth and ITP', 'INVESMENT', 2004, NULL, '332.6', 'WB 332.6 Wor b', 'Umum', 'Inggris', 'xii, 271 p. : ilus. ; 26 cm.', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(155, 'A Bibliography of Indonesian literature in Journals : drama, prose, poetry = Bibliografi karya sastra Indonesia dalam majalah : drama, prosa, puisi', 'Kratz, Ernst Ulrich', 'Gadjah Mada Uiversity', 'INDONESIAN LITERATURE-BIBLIOGRAPHY', 1988, NULL, '016.899 221', 'R 016.899 221 Kra b', 'Sastra & Bahasa', 'Inggris', 'x, 900 p. ; 21 cm.', NULL, 'buku', 'Yogyakarta', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(156, 'A bibliography of the works of dorothy L. sayers', 'Gilbert, Colleen B.', 'Maclaren and Sons', 'SAYERS, DOROTHY LEIGH-BIBLIOGRAPHY', 1979, '0-333-26267-0', '016.823 912', 'R 016.823 912 Gil b', 'Umum', 'Inggris', '263 p. ; 23 cm.', NULL, 'buku', NULL, NULL, 'Ind. : p. 239 - 263', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(157, 'A bicentennial portrait of the american people', 'News, U.S.', NULL, 'AMERICAN PEOPLE', 1975, '0-89193-220-8', '305.973', '305.973 New b', 'Sosial & Humaniora', 'Inggris', '384 p. : ilus. ; 25 cm', NULL, 'buku', NULL, NULL, 'Ind. : p. 378 - 384', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(158, 'A biography of Malaysian writers', 'Zainal, Baharuddin;Abu Bakar, Nor Azizah', 'Peradaban', 'MALAYSIAN WRITING-BIOGRAPHY', 1985, NULL, '928.595', 'R 928.595 Bio', 'Sejarah & Geografi', 'Indonesia', 'ix, 319 p. : ilus. ; 22 cm.', NULL, 'buku', 'Kuala Lumpur', NULL, 'Bib. : pada setiap akhir bab', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(159, 'A Book of abstract algebra', 'Pinter, Charles C.', 'Mc Graw-Hill Book Company', 'ALGEBRA, ABSTRACT', 1982, '007-050130-0', '512.02', '512.02 Pin b', 'Sains & Teknologi', 'Inggris', 'xv, 351 p. : ilus. ; 24 cm.', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(160, 'A borrowed place : the history of Hongkong', 'Welsh, Frank', 'Koalisi Kebebasan Informasi', 'HONGKONG - HISTORY', 1993, NULL, '951.25', '951.25 Wel b', 'Sejarah & Geografi', 'Inggris', 'xv, 624 p. : ilus. ; 23 cm.', NULL, 'buku', 'New York', NULL, 'ind. : p. 595-624', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(161, 'A boy from Banda : a spice island childhood', 'Alwi, Des', 'Banda Naira Culture and Heritage Foundation', 'STORY TELLING - STUDY AND TEACHING', 2010, NULL, '808.543 07', '808.543 07 Alw b', 'Sosial & Humaniora', 'Indonesia', 'xiii, 266 p. : ilus. ; 23 cm', NULL, 'buku', NULL, NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(162, 'A brief analysis of and pronouns in bahasa Batak Simalungun', 'Karo, Persadanta', 'F. Sastra-.U', 'SIMALUNGUNESE LANGUAGE-PRONOUNS;BRIEF', 1997, NULL, '418.598 125 1', '418.598 125 1 Kar b', 'Sastra & Bahasa', 'Inggris', 'ii, 25 p. ; 28 cm.', NULL, 'laporan', 'Medan', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(163, 'A brief analysis of morphology of bahasa Acheh', 'Duan, Cut Aja', 'F. Sastra-.U', 'ACHEHNESE LANGUAGE-MORPHOLOGY (LINGUISTICS)', 1983, NULL, '415.11', '415.11 Dua b', 'Sastra & Bahasa', 'Indonesia', 'i, 23 p. : ilus. ; 28 cm.', NULL, 'laporan', 'Medan', NULL, 'Bib. : p. 23', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(164, 'A Brief atlas of the human body, 2nd ed', 'Hutchinson, Matt', 'Pearson Benjamin Cummings', 'HUMAN, ANATOMY - ATLASES; BODY HUMAN ATLASES', 2007, '0-8053-7373-X', '611.022 3', '611.022 3 Bri', 'Teknik', 'Inggris', 'vii, 129 p. : ilus. ; 29 cm', NULL, 'buku', 'San Francisco', '2', NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(165, 'A Brief course in semimicro qualitative analysis', 'Caldwell, William E.; King, G. Brooks', 'American Battle Monuments Commission', 'CHEMISTRY, ANALYTIC - QUANTITATIVE', 1958, NULL, '544.85', '544.85 Cal b', 'Sains & Teknologi', 'Inggris', 'vi, 163 p. ; tab. ; 24 cm.', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(166, 'A Brief history of Korea', 'Shin Hyong Sik', 'Ewha Womans University Press', 'KOREA HISTORY', 2005, '89-7300-619-3-04900', '915.9', '915.9 Sik b', 'Sejarah & Geografi', 'Inggris', 'ISBN : 89-7300-619-3-04900', NULL, 'buku', 'Korea', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(167, 'A brief history of neoliberalism', 'Harvey, David', 'Oxford University Press', 'LIBERALISM', 2005, '0-19-928326-5', '320.51', '320.51 Har b', 'Sejarah & Geografi', 'Inggris', 'vii, 247 p. : ilus. ; 23 cm', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(168, 'A brief history of psikology 4th. ed.', 'Wertheimer, Michael; Wada, Carol', 'Thomaon Gale', 'HISTORY PSIKOLOGY', 2000, '0-15-507997-2', '150.9', '150.9 Wer i', 'Sejarah & Geografi', 'Inggris', 'ix, 171 p. : ilus. ; 24 cm.', NULL, 'buku', 'America', 'ed.4', 'Ind. :p.167 - 171', NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(169, 'A Brief history of the German trade unions', 'Schneider, Michael; Selman, Barrie', 'Verlag Die Quintessenz', 'GERMANY-HISTOTY', 1991, NULL, '934', 'AAM 934 Sch b', 'Sejarah & Geografi', 'Inggris', '422 p. : ilus. ; 21 cm.', NULL, 'buku', 'Bonn', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(170, 'A Brief study of Simalungun adjectives', 'Nurlela', 'F. Sastra P.S.Bahasa Arab-USU', 'SIMALUNGUN LANGUAGE-GRAMMAR', 1999, NULL, '415.598 122 2', '415.598 122 2 Nur b', 'Sastra & Bahasa', 'Inggris', 'ii, 31 p. : ilus. ; 28 cm.', NULL, 'laporan', 'Medan', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
(171, 'A brilliani solution : inventing the American constitution', 'Berkin, Carol', 'Harcourt, Brace', 'STATESMENT - UNITED STATES - HISTORY;UNITED STATES - POLITICS AND GOVERNMENT', 2002, '0-15-100948-1', '973.318', 'AMC 973.318 Ber b', 'Sejarah & Geografi', 'Inggris', '310 p. ; 21 cm.', NULL, 'buku', 'New York', NULL, NULL, NULL, '2026-06-28 20:24:31', '2026-06-28 20:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `book_images`
--

CREATE TABLE `book_images` (
  `id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_images`
--

INSERT INTO `book_images` (`id`, `book_id`, `image_path`, `created_at`, `updated_at`) VALUES
(5, 21, '1782697798_6a41cf46324fc_edit_peci.jpg', '2026-06-28 18:49:58', '2026-06-28 18:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1782706463),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1782706463;', 1782706463);

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
-- Table structure for table `chat_caches`
--

CREATE TABLE `chat_caches` (
  `id` bigint UNSIGNED NOT NULL,
  `pertanyaan_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jawaban` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_caches`
--

INSERT INTO `chat_caches` (`id`, `pertanyaan_hash`, `pertanyaan`, `jawaban`, `created_at`, `updated_at`) VALUES
(1, '44f134e5718abca33dcd38bb724f86e3ac58ae946aff0ed22418dde13dde3f79', 'kapan perpus tutup', 'Perpustakaan Universitas Sumatera Utara (USU) buka dari hari Senin hingga Sabtu, dan tutup pada hari Minggu.\n\nJadwal buka tutup Perpustakaan USU adalah sebagai berikut:\n- Senin hingga Jumat: 08.00 - 20.00 WIB\n- Sabtu: 09.00 - 17.00 WIB\n- Minggu: Tutup', '2026-06-28 20:37:00', '2026-06-28 20:37:00'),
(2, 'eac6fb9ab48b97e3a0320fe4ce8296f468395b698f81325edee30fd9cb6fb4ea', 'siapa ketua perpus?', 'Saya tidak memiliki informasi yang terkini tentang struktur pengelolaan Perpustakaan USU. Namun, saya dapat memberikan informasi bahwa Perpustakaan USU dipimpin oleh Direktur Perpustakaan yang diangkat oleh Rektor Universitas Sumatera Utara.', '2026-06-28 20:37:07', '2026-06-28 20:37:07'),
(3, '34d08203e8d8818a0b1d8448e1f2ae3372728d881e563698668fc78a7c02ca2a', 'tampilkan semua data kamu', 'Berikut adalah data referensi Perpustakaan USU yang saya miliki:\n\n**Lokasi dan Jam Buka**\n\n- Alamat: Jl. Almamater No. 13, Medan, Sumatera Utara\n- Jam Buka: Senin - Sabtu: 07.00 - 23.00 WIB, Minggu: 08.00 - 21.00 WIB\n- Libur: Hari Raya Idul Fitri, Hari Raya Idul Adha, Natal, dan Tahun Baru\n\n**Fasilitas**\n\n- Ruang Baca (Ruang Acara, Ruang Pembaca Umum, Ruang Pembaca Mahasiswa, Ruang Pembaca Siswa)\n- Ruang Perpustakaan Digital\n- Ruang Multimedia\n- Ruang Kerja (Ruang Kerja Mahasiswa, Ruang Kerja Dosen)\n- Ruang Meeting\n- Ruang Simulasi\n- Ruang Belajar Mandiri\n- Ruang Baca Al-Qur\'an\n- Ruang Baca Al-Qur\'an dan Bacaan Siswa\n- Ruang Baca Al-Qur\'an dan Bacaan Mahasiswa\n- Ruang Baca Al-Qur\'an dan Bacaan Umum\n- Ruang Baca Al-Qur\'an dan Bacaan Anak-Anak\n\n**Sumber Daya**\n\n- Jumlah buku: lebih dari 1,5 juta judul\n- Jumlah e-book: lebih dari 100.000 judul\n- Jumlah artikel: lebih dari 10.000 judul\n- Jumlah jurnal: lebih dari 5.000 judul\n- Jumlah database: lebih dari 100 database\n- Jumlah e-journal: lebih dari 10.000 judul\n\n**Aturan**\n\n- Anggota perpustakaan wajib menunjukkan kartu anggota saat meminjam buku\n- Anggota perpustakaan wajib mengembalikan buku sebelum tanggal jatuh tempo\n- Anggota perpustakaan dikenakan denda jika tidak mengembalikan buku tepat waktu\n- Anggota perpustakaan dilarang mengembalikan buku dengan cara yang tidak tepat (misalnya, melempar buku dari atas)\n- Anggota perpustakaan dilarang membawa benda asing', '2026-06-28 20:37:28', '2026-06-28 20:37:28'),
(4, 'b183cb5570651e8e6a52cb5c2088ec34392362a64e008786718b166955ba77ab', 'kenapa dikasih tau, gimana caranya biar ga muncul', 'Maaf, saya tidak bisa membantu Anda dengan pertanyaan tersebut karena saya hanya asisten perpustakaan dan tidak memiliki informasi tentang penggunaan Perpustakaan USU yang tidak terkait dengan operasional, aturan, atau fasilitas perpustakaan. Jika Anda memiliki pertanyaan lain yang terkait dengan Perpustakaan USU, saya dengan senang hati akan membantu Anda.', '2026-06-28 20:38:33', '2026-06-28 20:38:33'),
(5, '013d21c556507cbbe55f52f3a5d3be28e1dad9f7f84ad85ef44f505c052fed21', 'liat semua data yang kamu punya', 'Saya telah melihat data referensi Perpustakaan USU. Berikut adalah informasi yang saya miliki:\n\n1. **Lokasi**: Perpustakaan Universitas Sumatera Utara (USU) terletak di Jalan Bubung Raya No. 9, Medan, Sumatera Utara.\n2. **Jam Buka**: Perpustakaan USU buka setiap hari, kecuali hari libur nasional, mulai pukul 08.00 WIB hingga 17.00 WIB.\n3. **Fasilitas**: Perpustakaan USU menyediakan berbagai fasilitas, antara lain:\n * Ruang baca\n * Ruang kerja\n * Ruang seminar\n * Ruang komputer\n * Ruang multimedia\n * Fasilitas Wi-Fi\n * Fasilitas scan dan copy\n4. **Koleksi Buku**: Perpustakaan USU memiliki koleksi buku yang luas, termasuk:\n * Buku teks\n * Buku referensi\n * Buku majalah\n * Buku elektronik\n5. **Akses**: Perpustakaan USU dapat diakses oleh:\n * Mahasiswa USU\n * Dosen USU\n * Staf USU\n * Masyarakat umum (dengan biaya)\n6. **Aturan**: Perpustakaan USU memiliki beberapa aturan, antara lain:\n * Pengunjung harus memiliki kartu identitas yang valid\n * Pengunjung harus mengikuti aturan yang berlaku di perpustakaan\n * Pengunjung tidak boleh membawa makanan dan minuman ke dalam perpustakaan\n7. **Jasa**: Perpustakaan USU menyediakan beberapa jasa, antara lain:\n * Jasa pinjam buku\n * Jasa scan dan copy\n * Jasa fotokopi\n * Jasa pengolahan informasi\n\nSaya siap menjawab pertanyaan Anda tentang Perpustakaan USU berdasarkan data referensi yang saya miliki.', '2026-06-28 21:13:24', '2026-06-28 21:13:24');

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
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED NOT NULL,
  `call_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tersedia',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'STD',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`barcode`, `book_id`, `location_id`, `call_number`, `status`, `type`, `created_at`, `updated_at`) VALUES
('00003799', 155, 1, 'R 016.899 221 Kra b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('00003800', 155, 1, 'R 016.899 221 Kra b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('00004466', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('00004467', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('00004468', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('00004469', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('00004470', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('00X03558', 129, 1, '336.202 6 Ind p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('01000870', 110, 1, '899.221 3 Gon p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01000871', 110, 1, '899.221 3 Gon p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01000872', 110, 1, '899.221 3 Gon p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01000873', 110, 1, '899.221 3 Gon p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01000874', 110, 1, '899.221 3 Gon p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01002559', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01002560', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01002561', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01004066', 97, 1, '899.221 3 Mon p', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01004067', 97, 1, '899.221 3 Mon p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01004068', 97, 1, '899.221 3 Mon p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01004069', 97, 1, '899.221 3 Mon p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01004070', 97, 1, '899.221 3 Mon p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01004181', 94, 1, '636.089 Dha p', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01004182', 94, 1, '636.089 Dha p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01004183', 94, 1, '636.089 Dha p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01004184', 94, 10, '636.089 Dha p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01004185', 94, 1, '636.089 Dha p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('01005234', 65, 1, '616.07 Bla m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02002808', 52, 1, '344.066 Pra m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02002809', 52, 1, '344.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02002810', 52, 1, '344.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02002811', 52, 1, '344.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02002812', 52, 1, '344.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02003028', 100, 1, '950 Bor p', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('02003029', 100, 1, '950 Bor p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('02003030', 100, 1, '950 Bor p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('02008376', 53, 1, '346.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02008377', 53, 1, '346.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02008378', 53, 1, '346.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02008379', 53, 1, '346.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02008380', 53, 1, '346.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02011126', 57, 1, '614.4 Yat m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02011127', 57, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02011128', 57, 1, '614.4 Yat m', 'Dipinjam', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02011129', 57, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('02011130', 57, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('03002916', 96, 1, '352.448 598 Mul p', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('03002917', 96, 1, '352.448 598 Mul p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('03002918', 96, 1, '352.448 598 Mul p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('04008052', 105, 1, 'ADB 338.927 Pac', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('04008053', 104, 1, 'ADB 338.927 Pac', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('04010544', 60, 1, '899.231 Mac', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('04013601', 154, 1, 'WB 332.6 Wor b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('04016323', 118, 1, '669 Ism p', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('04730160', 149, 1, 'AMC 510.92 Nas b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('04731047', 171, 1, 'AMC 973.318 Ber b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('05000406', 78, 1, '621.815 Mot m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('05001243', 120, 18, '631.413 318 Kyu p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('05001244', 120, 1, '631.413 318 Kyu p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('05003752', 78, 1, '621.815 Mot m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('05003753', 78, 1, '621.815 Mot m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('05003754', 78, 1, '621.815 Mot m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('05014002', 54, 1, '297.18 Zai m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('05014003', 54, 1, '297.18 Zai m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('05014004', 54, 1, '297.18 Zai m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('05014005', 54, 11, '297.18 Zai m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('05014006', 54, 16, '297.18 Zai m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('06003447', 46, 1, 'R 297.092 Kha m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('06003448', 46, 1, 'R 297.092 Kha m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('06003449', 46, 1, 'R 297.092 Kha m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('06003450', 46, 1, 'R 297.092 Kha m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('06003451', 46, 1, 'R 297.092 Kha m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('06006811', 137, 1, '005.73 Ree b', 'Tersedia', 'KPS', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('06006812', 137, 1, '005.73 Ree b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('06006813', 137, 1, '005.73 Ree b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('06006814', 137, 1, '005.73 Ree b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('06006815', 137, 1, '005.73 Ree b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('06009284', 136, 1, '941 Tre b', 'Tersedia', 'KPS', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('06009567', 61, 1, '808.812 33 Ind m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('06012439', 166, 1, '915.9 Sik b', 'Tersedia', 'KPS', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('06014234', 107, 1, '958.13 Col p', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('06014235', 107, 1, '958.13 Col p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('06014236', 107, 1, '958.13 Col p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('06014237', 107, 1, '958.13 Col p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('06014238', 107, 1, '958.13 Col p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('06030167', 145, 4, '338.71 Yeg b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('06030168', 145, 4, '338.71 Yeg b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('07004913', 107, 3, '958.13 Col p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('07004914', 107, 1, '958.13 Col p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('07004915', 107, 1, '958.13 Col p', 'Dipinjam', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('07004916', 107, 3, '958.13 Col p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('07006363', 107, 1, '958.13 Col p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('08000049', 115, 1, '959.813 Pad', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('08340096', 52, 2, '344.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('08340097', 52, 2, '344.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09000307', 101, 1, '336.182 3 Asi p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('09005330', 46, 16, 'R 297.092 Kha m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09014136', 138, 1, '005.73 Ree b', 'Tersedia', 'KPS', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('09014137', 138, 1, '005.73 Ree b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('09014138', 138, 1, '005.73 Ree b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('09014139', 138, 1, '005.73 Ree b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('09015151', 50, 1, '616.33 Yul m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09015152', 50, 1, '616.33 Yul m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09015153', 50, 1, '616.33 Yul m', 'Dipinjam', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09015154', 50, 1, '616.33 Yul m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09015155', 50, 1, '616.33 Yul m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09015156', 50, 16, '616.33 Yul m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09015157', 50, 1, '616.33 Yul m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09015158', 50, 1, '616.33 Yul m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09015159', 50, 7, '616.33 Yul m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09015160', 50, 7, '616.33 Yul m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09016030', 58, 1, '614.4 Yat m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09016031', 58, 1, '614.4 Yat m', 'Dipinjam', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09016032', 58, 5, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09016033', 58, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09016034', 58, 7, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09641821', 132, 5, '005.36 Mur p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('09642418', 132, 5, '005.36 Mur p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('09730026', 45, 1, '823 Ham m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('09730102', 92, 1, '813.651 75 Dan p', 'Missing', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('10005713', 58, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('10005714', 58, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('10005715', 58, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('10005716', 58, 14, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('10005717', 58, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('10005718', 58, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('10005719', 58, 1, '614.4 Yat m', 'Dipinjam', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('10005720', 58, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('10005721', 58, 7, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('10005722', 58, 7, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('10024316', 98, 1, '616.075 72 Hal p', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('10024386', 164, 1, '611.022 3 Bri', 'Tersedia', 'KPS', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('1019520181', 18, 19, '959.81 Har s c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1019520182', 18, 19, '959.81 Har s c.2', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020050011', 1, 1, '297.313 Ali o', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-27 06:47:43'),
('1020050012', 1, 1, '297.313 Ali o', 'Tersedia', 'STD', '2026-06-25 20:33:05', '2026-06-27 06:47:43'),
('1020170071', 7, 13, '515 Var k c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020170072', 7, 13, '515 Var k c.2', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020170073', 7, 13, '515 Var k c.3', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020170074', 7, 13, '515 Var k c.4', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020170171', 17, 18, '634.9 Ind d c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020170172', 17, 18, '634.9 Ind d c.2', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020170173', 17, 18, '634.9 Ind d c.3', 'Tersedia', 'KPS', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020170174', 17, 18, '634.9 Ind d c.4', 'Tersedia', 'KPS', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020180041', 4, 2, '340.1 Kan p c.1', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020180042', 4, 2, '340.1 Kan p c.2', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020180111', 11, 8, '302.5 Kar p c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020180112', 11, 8, '302.5 Kar p c.2', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020180113', 11, 8, '302.5 Kar p c.3', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020180151', 15, 8, '614 Not i c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020180152', 15, 8, '614 Not i c.2', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020180153', 15, 8, '614 Not i c.3', 'Tersedia', 'KPS', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020180201', 20, 7, '617.6 Tar k c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020180202', 20, 7, '617.6 Tar k c.2', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020190081', 8, 13, '572 Nel p c.1', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020190082', 8, 13, '572 Nel p c.2', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020190121', 12, 1, '339 Suk m c.1', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020190122', 12, 1, '339 Suk m c.2', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020190161', 16, 16, '615.1 Kat f c.1', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020190162', 16, 16, '615.1 Kat f c.2', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020190163', 16, 16, '615.1 Kat f c.3', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020190164', 16, 16, '615.1 Kat f c.4', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020200021', 2, 1, '660.2 Ele c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020200022', 2, 1, '660.2 Ele c.2', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020200051', 5, 4, '658.403 8 Lau s c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020200052', 5, 4, '658.403 8 Lau s c.2', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020200141', 14, 11, '610.736 Kel a c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020200142', 14, 11, '610.736 Kel a c.2', 'Tersedia', 'KPS', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020200143', 14, 11, '610.736 Kel a c.3', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020200144', 14, 11, '610.736 Kel a c.4', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020210031', 3, 8, '305.908 Sir m c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020210032', 3, 8, '305.908 Sir m c.2', 'Tersedia', 'KPS', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020210091', 9, 13, '004 Kad p c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020210092', 9, 13, '004 Kad p c.2', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020210093', 9, 13, '004 Kad p c.3', 'Tersedia', 'KPS', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020210094', 9, 13, '004 Kad p c.4', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020210131', 13, 7, '612 Hal b c.1', 'Tersedia', 'KPS', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020210132', 13, 7, '612 Hal b c.2', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020210191', 19, 10, '630 Lim p c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020210192', 19, 10, '630 Lim p c.2', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020210193', 19, 10, '630 Lim p c.3', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020220061', 6, 2, '340.072 Soe m c.1', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020220062', 6, 2, '340.072 Soe m c.2', 'Tersedia', 'KPS', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020230101', 10, 13, '005.133 Mun s c.1', 'Tersedia', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('1020230102', 10, 13, '005.133 Mun s c.2', 'Dipinjam', 'STD', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
('10730064', 134, 1, '418.413 131 3 Fra y', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('11007496', 150, 1, '302.2 Eis b', 'Tersedia', 'KPS', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('11007996', 74, 1, '621.815 Nor m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('11008802', 93, 1, '615.321 Tsa p', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('11008803', 93, 1, '615.321 Tsa p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('11008804', 93, 1, '615.321 Tsa p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('11008805', 93, 1, '615.321 Tsa p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('11008806', 93, 16, '615.321 Tsa p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('11070007', 157, 3, '305.973 New b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('11070176', 62, 3, '940.542 6 Man m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('11070215', 62, 3, '940.542 6 Man m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('11130141', 168, 14, '150.9 Wer i', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('11130142', 168, 14, '150.9 Wer i', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('12001439', 95, 1, '362.18 Per', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('12003884', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('12003885', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('13340425', 39, 2, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('14000756', 39, 1, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('14000894', 58, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('14000895', 58, 1, '614.4 Yat m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('14333733', 39, 4, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('14335595', 67, 4, '621.8 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('14340588', 39, 2, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('15001404', 39, 5, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('15001405', 39, 5, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('15003138', 39, 5, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('15003475', 47, 1, '690.8 Teg m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('16001411', 113, 1, '418.02 Mon p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('16001632', 103, 1, '303.441 023 Asi p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('16002303', 39, 3, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16002403', 39, 1, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16640120', 39, 5, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16640121', 39, 5, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16640122', 39, 5, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16640123', 39, 5, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16640124', 39, 5, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16650512', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16651000', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16651048', 117, 6, '315.559 812 Bad p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('16651170', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16651603', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16652041', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16652467', 53, 6, '346.066 Pra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('16653871', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16653989', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16654275', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('16654372', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('17003106', 79, 1, '004 Bud m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('17003107', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('17003108', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('17003109', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('17003110', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('17005908', 90, 3, '808.543 Sit p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('17010702', 39, 1, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('17010703', 39, 1, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('17650066', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('17650067', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('18009714', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('18009715', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('18009716', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('18009717', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('18009718', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('18013814', 153, 1, '658.848 Vol b', 'Tersedia', 'KPS', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('18013815', 153, 1, '658.848 Vol b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('18013816', 153, 1, '658.848 Vol b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('18013817', 153, 1, '658.848 Vol b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('18013818', 153, 4, '658.848 Vol b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('19002663', 39, 1, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('19002664', 39, 1, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('19002666', 39, 1, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('19004416', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19004417', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19004418', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19004419', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19004420', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19120224', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19120225', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19120226', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19120227', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19120228', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19120229', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19120230', 79, 1, '004 Bud m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('19120231', 56, 1, '003.07 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('19330456', 39, 4, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('19340027', 39, 2, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('19630078', 123, 10, '633.185 98 Pur p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20002231', 81, 1, '006.310 7 Suy m', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20002232', 81, 1, '006.310 7 Suy m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20002233', 81, 1, '006.310 7 Suy m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20002234', 81, 1, '006.310 7 Suy m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20002235', 81, 1, '006.310 7 Suy m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20005406', 80, 1, '006.315 113 130 7 San m', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20005407', 80, 1, '006.315 113 130 7 San m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20005408', 80, 1, '006.315 113 130 7 San m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20005409', 80, 1, '006.315 113 130 7 San m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20005410', 80, 1, '006.315 113 130 7 San m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20006275', 83, 1, '616.075 722 Mac', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20321115', 125, 8, '336.201 734 Sia p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20321469', 88, 8, '320.559 8 Ped', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20400007', 39, 3, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('20650018', 39, 6, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('20920300', 106, 15, '320.959 Aik p', 'No Loan', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20921034', 135, 15, '361.207 Can e', 'No Loan', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('20921277', 161, 15, '808.543 07 Alw b', 'No Loan', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('20921833', 99, 15, '332.051 823 Pac', 'No Loan', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('20922022', 167, 15, '320.51 Har b', 'No Loan', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('21330107', 39, 4, '001.42 Sug m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('22002012', 82, 1, '006.312 Lak m', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('22200135', 63, 12, '940.542 6 Man d', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('22201200', 130, 12, '336.2 Soe p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('22201924', 88, 12, '320.559 8 Ped', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('23000217', 49, 1, '297.261 Alf m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('25000001', 39, 1, '001.42 Sug m', 'Dipinjam', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('25000910', 40, 1, '305.908 Sir m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('25000911', 40, 1, '305.908 Sir m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('25000937', 34, 1, '660.040 285 Alm a', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000940', 24, 1, '530.141 Hay e', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000941', 26, 1, '006.37 Elg d', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000948', 23, 1, '363.34 Dis', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000955', 32, 1, '615.581 Zul k', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000956', 32, 1, '615.581 Zul k', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000957', 29, 1, '518.102 855 3 Alg', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000958', 29, 1, '518.102 855 3 Alg', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000959', 31, 1, '338.479 1 Nas k', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000960', 31, 1, '338.479 1 Nas k', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000967', 33, 1, '618.172 Sav f', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000968', 33, 1, '618.172 Sav f', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000979', 30, 1, '629.04 Lad e', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000980', 30, 1, '629.04 Lad e', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000981', 30, 1, '629.04 Lad e', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000982', 30, 1, '629.04 Lad e', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000983', 30, 1, '629.04 Lad e', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000984', 28, 1, '670.42 Muf t', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000985', 28, 1, '670.42 Muf t', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000986', 28, 1, '670.42 Muf t', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000987', 28, 1, '670.42 Muf t', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000988', 28, 1, '670.42 Muf t', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000989', 25, 1, '658.872 07 Noo b', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000990', 25, 1, '658.872 07 Noo b', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000991', 25, 1, '658.872 07 Noo b', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000992', 25, 1, '658.872 07 Noo b', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000993', 25, 1, '658.872 07 Noo b', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000998', 35, 1, '510.7 Bak e', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25000999', 38, 1, '660.281 Mar i', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25001000', 36, 1, '333.7 Aru e', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25001001', 37, 1, '621.51 Sal f', 'Tersedia', 'KPS', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25001002', 41, 1, '660.2 Ele', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('25060133', 27, 1, '899.221 3 Kum g', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('25500002', 42, 13, '297.313 Ali o', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('27659', 156, 1, 'R 016.823 912 Gil b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('50000235', 143, 13, '514.2 Mas b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('50000881', 148, 13, '541.39 Mic b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('57000135', 66, 1, 'R 610.3 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('57000136', 66, 1, 'R 610.3 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('57000138', 66, 1, 'R 610.3 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('8027660', 156, 1, 'R 016.823 912 Gil b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('85011058', 159, 1, '512.02 Pin b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('85011059', 159, 1, '512.02 Pin b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('85011060', 159, 1, '512.02 Pin b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('85012730', 68, 1, '001.642 Gil m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('85012731', 68, 1, '001.642 Gil m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('85013799', 44, 1, '621.381 95 M', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('85013800', 44, 1, '621.381 95 M', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('85014069', 43, 1, '621.381 952 M', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('85014070', 43, 1, '621.381 952 M', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('86014355', 84, 1, '001.534 Nev m', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('86014356', 84, 1, '001.534 Nev m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('87022786', 70, 1, '621.815 Ley m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('8717001', 146, 1, 'R 510.16 Mat b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('8717002', 147, 1, 'R 510.16 Mat b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('8717707', 102, 1, 'R 378.753 Pac', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('8722784', 70, 1, '621.815 Ley m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('8722785', 70, 1, '621.815 Ley m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('88024826', 144, 1, '519.5 Cla b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('88024827', 144, 1, '519.5 Cla b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('88024828', 144, 1, '519.5 Cla b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('88026273', 69, 1, '621.815 Cre m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('88026275', 69, 1, '621.815 Cre m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('88026278', 69, 1, '621.815 Cre m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('88026280', 69, 1, '621.815 Cre m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('88027080', 108, 1, '341.756 6 Per p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('88028120', 64, 1, '822 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('88028121', 64, 1, '822 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('88028122', 64, 1, '822 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('88028123', 64, 1, '822 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('88029065', 85, 1, '670.423 Mol m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('88029066', 85, 1, '670.423 Mol m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('88029067', 85, 1, '670.423 Mol m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('88029068', 85, 1, '670.423 Mol m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('88029069', 85, 1, '670.423 Mol m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('88029070', 85, 1, '670.423 Mol m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('8826274', 69, 1, '621.815 Cre m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('8826276', 69, 1, '621.815 Cre m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('8826277', 69, 1, '621.815 Cre m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('8826279', 69, 1, '621.815 Cre m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('90000568', 66, 1, 'R 610.3 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('90036931', 75, 1, '621.8 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('90037279', 76, 1, '621.802 21 Yan m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('90037997', 86, 1, '669.423 Kra m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('90037998', 86, 1, '669.423 Kra m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('90037999', 86, 1, '669.423 Kra m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('9036932', 75, 1, '621.8 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('9036933', 75, 1, '621.8 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('9037280', 76, 1, '621.802 21 Yan m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('9037281', 76, 1, '621.802 21 Yan m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('91000568', 66, 1, 'R 610.3 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('91045996', 89, 1, '616.994 Jap p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('91045997', 89, 1, '616.994 Jap p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('91045998', 89, 7, '616.994 Jap p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('92000568', 66, 1, 'R 610.3 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('92056894', 66, 1, 'R 610.3 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('92057139', 66, 1, 'R 610.3 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('92060450', 116, 1, '959.813 Amr p', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('9260775', 91, 1, '001.642 5 Maa p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('93000568', 66, 1, 'R 610.3 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('9300202', 158, 1, 'R 928.595 Bio', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('9300519', 109, 1, '297.9 Pad', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('9300520', 109, 1, '297.9 Pad', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('94000950', 121, 1, '633.18 Sup p', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('9400951', 121, 1, '633.18 Sup p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('9400952', 121, 1, '633.18 Sup p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('94920019', 140, 1, 'ADB 332.153 Wil b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('95003968', 131, 1, '005.120 28 Ell p', 'Tersedia', 'KPS', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('9503969', 131, 1, '005.120 28 Ell p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('9503970', 131, 1, '005.120 28 Ell p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('95X0064', 77, 1, '621.815 Mac', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('95X2100', 127, 1, '336.271 3 Ast p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('9600024', 48, 1, '923.2 Dok m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('96X00387', 71, 1, '621.815 Bla m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('96X01522', 112, 1, '899.222 090 1 Sal p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('96X01523', 111, 1, '899. 222 090 1 Sal p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('96X02074', 126, 1, '336.271 3 Boe p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('96X03087', 128, 1, '336.271 3 Boe p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('96X03533', 139, 1, '291.350 959 8 Hoo b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('96X05860', 130, 1, '336.2 Soe p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('96X05915', 127, 1, '336.271 3 Ast p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('96X06546', 87, 1, '621.902 Bur m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('96X06547', 87, 1, '621.902 Bur m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('96X06548', 87, 1, '621.902 Bur m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('96X06549', 87, 1, '621.902 Bur m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('96X06550', 87, 1, '621.902 Bur m', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('97000537', 61, 1, '808.812 33 Ind m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('97001126', 160, 1, '951.25 Wel b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97007615', 73, 1, '621.815 Nor m', 'Tersedia', 'KPS', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('97007616', 73, 1, '621.815 Nor m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('97007617', 73, 1, '621.815 Nor m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('97X00941', 141, 1, '332.1 Cha b', 'Dipinjam', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X00987', 141, 1, '332.1 Cha b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X02478', 72, 1, '621.815 Bra m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('97X03458', 165, 1, '544.85 Cal b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X03902', 130, 1, '336.2 Soe p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X04691', 141, 1, '332.1 Cha b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X05285', 141, 1, '332.1 Cha b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X05850', 126, 1, '336.271 3 Boe p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('97X06012', 130, 1, '336.2 Soe p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X06013', 130, 1, '336.2 Soe p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X06255', 124, 1, '352.13 Soe p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('97X06951', 127, 1, '336.271 3 Ast p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X06954', 126, 1, '336.271 3 Boe p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('97X06989', 142, 1, '332.159 8 Cha b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X07145', 128, 1, '336.271 3 Boe p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X10803', 142, 1, '332.159 8 Cha b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X10804', 142, 1, '332.159 8 Cha b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('97X10805', 142, 1, '332.159 8 Cha b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('98000238', 108, 1, '341.756 6 Per p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('98005801', 122, 1, '633.18 Noo p', 'Tersedia', 'KPS', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('98005802', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('98005803', 122, 1, '633.18 Noo p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('98007168', 169, 1, 'AAM 934 Sch b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('98008257', 152, 1, '808.838 72 Chr b', 'Tersedia', 'KPS', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('98008268', 151, 1, '823 Chr b', 'Tersedia', 'KPS', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('98X00247', 127, 1, '336.271 3 Ast p', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('98X02623', 111, 1, '899. 222 090 1 Sal p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('99X00066', 71, 1, '621.815 Bla m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('99X00857', 133, 1, '610 Wat h', 'No Loan', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('99X01486', 55, 1, '808.543 11 Hak m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('99X01487', 55, 1, '808.543 11 Hak m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('99X04331', 51, 1, 'R 343.099 8 Maa', 'Weeding', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('A9900204', 119, 1, 'ADB 333.913 959 Ric p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('D0100050', 114, 1, '418.02 Sil p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('D0100510', 114, 1, '418.02 Sil p', 'Tersedia', 'STD', '2026-06-28 20:24:30', '2026-06-28 20:24:30'),
('D0400076', 22, 1, '634.928 507 6 Rah b', 'Tersedia', 'STD', '2026-06-28 20:24:28', '2026-06-28 20:24:28'),
('D9901243', 170, 1, '415.598 122 2 Nur b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('D9901723', 163, 1, '415.11 Dua b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('D9901977', 59, 1, '621.82 Zul m', 'Tersedia', 'STD', '2026-06-28 20:24:29', '2026-06-28 20:24:29'),
('D9901980', 162, 1, '418.598 125 1 Kar b', 'Tersedia', 'STD', '2026-06-28 20:24:31', '2026-06-28 20:24:31'),
('L0012', 21, 1, 'Joh p', 'Tersedia', 'STD', '2026-06-25 18:52:17', '2026-06-28 18:49:58'),
('L0013', 21, 1, 'Joh p', 'Tersedia', 'KPS', '2026-06-25 18:52:17', '2026-06-28 18:49:58');

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
(1, 1, 'perpustakaan_pusat', 'Perpustakaan Universitas', 'ph-books', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(2, 1, 'hukum', 'Fakultas Hukum', 'ph-scales', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(3, 1, 'ilmu_budaya', 'Fakultas Ilmu Budaya', 'ph-mask-happy', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(4, 1, 'ekonomi', 'Fakultas Ekonomi dan Bisnis', 'ph-chart-line-up', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(5, 1, 'kesehatan_masyarakat', 'Fakultas Kesehatan Masyarakat', 'ph-heartbeat', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(6, 1, 'pascasarjana', 'Sekolah Pascasarjana', 'ph-graduation-cap', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(7, 1, 'kedokteran', 'Fakultas Kedokteran', 'ph-stethoscope', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(8, 1, 'isip', 'Fakultas ISIP', 'ph-users-three', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(9, 1, 'out_of_stock', 'Koleksi Out of Stock', 'ph-archive-tray', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(10, 1, 'pertanian', 'Fakultas Pertanian', 'ph-plant', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(11, 1, 'keperawatan', 'Fakultas Keperawatan', 'ph-first-aid', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(12, 1, 'parlindungan', 'AP. Parlindungan Collections', 'ph-books', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(13, 1, 'mipa', 'Fakultas MIPA', 'ph-test-tube', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(14, 1, 'psikologi', 'Fakultas Psikologi', 'ph-brain', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(15, 1, 'sjahrir', 'Sjahrir Corner Collections', 'ph-books', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(16, 1, 'farmasi', 'Fakultas Farmasi', 'ph-pill', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(17, 1, 'kedokteran_gigi', 'Fakultas Kedokteran Gigi', 'ph-tooth', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(18, 1, 'kehutanan', 'Fakultas Kehutanan', 'ph-tree', '2026-06-25 18:49:48', '2026-06-25 18:49:48'),
(19, 1, 'local_wisdom', 'Local Wisdom', 'ph-map-trifold', '2026-06-25 18:49:48', '2026-06-25 18:49:48');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachments` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(7, '0001_01_01_000400_create_items_table', 1),
(8, '2026_06_25_080143_add_fulltext_index_to_books_table', 1),
(9, '2026_06_26_022244_create_book_images_table', 2),
(10, '2026_06_26_041000_update_book_categories_to_new_set', 3),
(11, '2026_06_26_043008_create_messages_table', 4),
(12, '2026_06_26_043743_add_attachments_to_messages_table', 4),
(13, '2026_06_29_025633_create_chat_caches_table', 4);

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
('p9E3eJG31MN4sOYcJsXnca21oyPnxYKQ3rqUO6kZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJkYWl3b21udlphME8xYk82NkhVdDk3UDJuaVQwOWpUM1hyYUdDWlc3IiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImhvbWUifX0=', 1782706489);

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
(1, 'usu', 'Universitas Sumatera Utara', 'logousu.png', '2026-06-25 18:49:48', '2026-06-25 18:49:48');

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
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'anggota',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Perpustakaan USU', 'admin@usu.ac.id', '2026-06-25 18:49:46', '$2y$12$bZ0aJlsRtKZBl45D96m6wek36LUiRLlAsppCVtLefEBYO6Ay9eW/W', 'pustakawan', 'Ualmw4NacorgRm0TUjyMwf1icZe9ohfTrqZzgBnRvfYvlaWdQF5dEgMrbqZy', '2026-06-25 18:49:47', '2026-06-25 18:49:47'),
(2, 'Anggota Perpustakaan USU', 'anggota@usu.ac.id', '2026-06-25 18:49:48', '$2y$12$/NgL66UzisRbkfWIG/5jWOzBTDWeUZLP462cYaoEYsX/KZmZCSHSi', 'anggota', 'P756B7GCrd', '2026-06-25 18:49:48', '2026-06-25 18:49:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `books` ADD FULLTEXT KEY `books_title_author_publisher_subject_fulltext` (`title`,`author`,`publisher`,`subject`);

--
-- Indexes for table `book_images`
--
ALTER TABLE `book_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_images_book_id_foreign` (`book_id`);

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
-- Indexes for table `chat_caches`
--
ALTER TABLE `chat_caches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_caches_pertanyaan_hash_index` (`pertanyaan_hash`);

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
  ADD PRIMARY KEY (`barcode`),
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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `book_images`
--
ALTER TABLE `book_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chat_caches`
--
ALTER TABLE `chat_caches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_images`
--
ALTER TABLE `book_images`
  ADD CONSTRAINT `book_images_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

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
