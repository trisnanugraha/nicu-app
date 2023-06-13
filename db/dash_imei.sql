-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2023 at 12:06 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dash_imei`
--

-- --------------------------------------------------------

--
-- Table structure for table `aplikasi`
--

CREATE TABLE `aplikasi` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_owner` varchar(100) DEFAULT NULL,
  `alamat` text,
  `tlp` varchar(50) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `nama_aplikasi` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `copy_right` varchar(50) DEFAULT NULL,
  `versi` varchar(20) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `aplikasi`
--

INSERT INTO `aplikasi` (`id`, `nama_owner`, `alamat`, `tlp`, `title`, `nama_aplikasi`, `logo`, `copy_right`, `versi`, `tahun`) VALUES
(1, 'Kementerian Perindustrian RI', 'Jl. Tirtayasa No.6, RW.4, Melawai, Kec. Kby. Baru, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12160', '(021)-1234-5678', 'SIM IMEI Kemenperin', 'SIM IMEI Kemenperin', 'logo.png', 'Copy Right &copy; ', '1.0.0.0', 2022);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_akses_menu`
--

CREATE TABLE `tbl_akses_menu` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `view_level` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_akses_menu`
--

INSERT INTO `tbl_akses_menu` (`id`, `id_level`, `id_menu`, `view_level`) VALUES
(1, 1, 1, 'Y'),
(2, 1, 2, 'Y'),
(69, 6, 1, 'N'),
(70, 6, 2, 'N'),
(182, 15, 1, 'N'),
(183, 15, 2, 'N'),
(219, 16, 1, 'N'),
(220, 16, 2, 'N'),
(232, 1, 74, 'Y'),
(233, 6, 74, 'N'),
(234, 15, 74, 'N'),
(235, 16, 74, 'N'),
(236, 1, 75, 'N'),
(237, 6, 75, 'N'),
(238, 15, 75, 'N'),
(239, 16, 75, 'Y'),
(240, 17, 1, 'N'),
(241, 17, 2, 'N'),
(242, 17, 74, 'N'),
(243, 17, 75, 'N'),
(244, 18, 1, 'Y'),
(245, 18, 2, 'N'),
(246, 18, 74, 'Y'),
(247, 18, 75, 'N'),
(248, 19, 1, 'N'),
(249, 19, 2, 'N'),
(250, 19, 74, 'N'),
(251, 19, 75, 'N'),
(252, 1, 76, 'N'),
(253, 16, 76, 'N'),
(254, 17, 76, 'N'),
(255, 18, 76, 'N'),
(256, 19, 76, 'Y'),
(257, 1, 77, 'N'),
(258, 16, 77, 'N'),
(259, 17, 77, 'Y'),
(260, 18, 77, 'N'),
(261, 19, 77, 'N'),
(262, 1, 78, 'Y'),
(263, 16, 78, 'N'),
(264, 17, 78, 'N'),
(265, 18, 78, 'N'),
(266, 19, 78, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_akses_submenu`
--

CREATE TABLE `tbl_akses_submenu` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_level` int(11) NOT NULL,
  `id_submenu` int(11) NOT NULL,
  `view_level` enum('Y','N') DEFAULT 'N',
  `add_level` enum('Y','N') DEFAULT 'N',
  `edit_level` enum('Y','N') DEFAULT 'N',
  `delete_level` enum('Y','N') DEFAULT 'N',
  `print_level` enum('Y','N') DEFAULT 'N',
  `upload_level` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_akses_submenu`
--

INSERT INTO `tbl_akses_submenu` (`id`, `id_level`, `id_submenu`, `view_level`, `add_level`, `edit_level`, `delete_level`, `print_level`, `upload_level`) VALUES
(2, 1, 2, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(4, 1, 1, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(6, 1, 7, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(7, 1, 8, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(9, 1, 10, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(13, 1, 14, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(26, 1, 15, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(30, 1, 17, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(32, 1, 18, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(34, 1, 19, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(36, 1, 20, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(83, 6, 1, 'N', 'N', 'N', 'N', 'N', 'N'),
(84, 6, 2, 'N', 'N', 'N', 'N', 'N', 'N'),
(85, 6, 7, 'N', 'N', 'N', 'N', 'N', 'N'),
(86, 6, 8, 'N', 'N', 'N', 'N', 'N', 'N'),
(87, 6, 10, 'N', 'N', 'N', 'N', 'N', 'N'),
(88, 6, 15, 'N', 'N', 'N', 'N', 'N', 'N'),
(89, 6, 17, 'N', 'N', 'N', 'N', 'N', 'N'),
(90, 6, 18, 'N', 'N', 'N', 'N', 'N', 'N'),
(91, 6, 19, 'N', 'N', 'N', 'N', 'N', 'N'),
(92, 6, 20, 'N', 'N', 'N', 'N', 'N', 'N'),
(116, 1, 24, 'N', 'N', 'N', 'N', 'N', 'N'),
(117, 6, 24, 'N', 'N', 'N', 'N', 'N', 'N'),
(191, 15, 1, 'N', 'N', 'N', 'N', 'N', 'N'),
(192, 15, 2, 'N', 'N', 'N', 'N', 'N', 'N'),
(193, 15, 7, 'N', 'N', 'N', 'N', 'N', 'N'),
(194, 15, 8, 'N', 'N', 'N', 'N', 'N', 'N'),
(195, 15, 10, 'N', 'N', 'N', 'N', 'N', 'N'),
(196, 15, 15, 'N', 'N', 'N', 'N', 'N', 'N'),
(197, 15, 17, 'N', 'N', 'N', 'N', 'N', 'N'),
(198, 15, 18, 'N', 'N', 'N', 'N', 'N', 'N'),
(199, 15, 19, 'N', 'N', 'N', 'N', 'N', 'N'),
(200, 15, 20, 'N', 'N', 'N', 'N', 'N', 'N'),
(201, 15, 24, 'N', 'N', 'N', 'N', 'N', 'N'),
(202, 16, 1, 'N', 'N', 'N', 'N', 'N', 'N'),
(203, 16, 2, 'N', 'N', 'N', 'N', 'N', 'N'),
(204, 16, 7, 'N', 'N', 'N', 'N', 'N', 'N'),
(205, 16, 8, 'N', 'N', 'N', 'N', 'N', 'N'),
(206, 16, 10, 'N', 'N', 'N', 'N', 'N', 'N'),
(207, 16, 15, 'N', 'N', 'N', 'N', 'N', 'N'),
(208, 16, 17, 'N', 'N', 'N', 'N', 'N', 'N'),
(209, 16, 18, 'N', 'N', 'N', 'N', 'N', 'N'),
(210, 16, 19, 'N', 'N', 'N', 'N', 'N', 'N'),
(211, 16, 20, 'N', 'N', 'N', 'N', 'N', 'N'),
(212, 16, 24, 'N', 'N', 'N', 'N', 'N', 'N'),
(213, 1, 25, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(214, 6, 25, 'N', 'N', 'N', 'N', 'N', 'N'),
(215, 15, 25, 'N', 'N', 'N', 'N', 'N', 'N'),
(216, 16, 25, 'N', 'N', 'N', 'N', 'N', 'N'),
(217, 1, 26, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(218, 16, 26, 'N', 'N', 'N', 'N', 'N', 'N'),
(219, 17, 1, 'N', 'N', 'N', 'N', 'N', 'N'),
(220, 17, 2, 'N', 'N', 'N', 'N', 'N', 'N'),
(221, 17, 7, 'N', 'N', 'N', 'N', 'N', 'N'),
(222, 17, 8, 'N', 'N', 'N', 'N', 'N', 'N'),
(223, 17, 10, 'N', 'N', 'N', 'N', 'N', 'N'),
(224, 17, 15, 'N', 'N', 'N', 'N', 'N', 'N'),
(225, 17, 17, 'N', 'N', 'N', 'N', 'N', 'N'),
(226, 17, 18, 'N', 'N', 'N', 'N', 'N', 'N'),
(227, 17, 19, 'N', 'N', 'N', 'N', 'N', 'N'),
(228, 17, 20, 'N', 'N', 'N', 'N', 'N', 'N'),
(229, 17, 24, 'N', 'N', 'N', 'N', 'N', 'N'),
(230, 17, 25, 'N', 'N', 'N', 'N', 'N', 'N'),
(231, 17, 26, 'N', 'N', 'N', 'N', 'N', 'N'),
(232, 18, 1, 'N', 'N', 'N', 'N', 'N', 'N'),
(233, 18, 2, 'N', 'N', 'N', 'N', 'N', 'N'),
(234, 18, 7, 'N', 'N', 'N', 'N', 'N', 'N'),
(235, 18, 8, 'N', 'N', 'N', 'N', 'N', 'N'),
(236, 18, 10, 'N', 'N', 'N', 'N', 'N', 'N'),
(237, 18, 15, 'N', 'N', 'N', 'N', 'N', 'N'),
(238, 18, 17, 'N', 'N', 'N', 'N', 'N', 'N'),
(239, 18, 18, 'N', 'N', 'N', 'N', 'N', 'N'),
(240, 18, 19, 'N', 'N', 'N', 'N', 'N', 'N'),
(241, 18, 20, 'N', 'N', 'N', 'N', 'N', 'N'),
(242, 18, 24, 'N', 'N', 'N', 'N', 'N', 'N'),
(243, 18, 25, 'N', 'N', 'N', 'N', 'N', 'N'),
(244, 18, 26, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(245, 19, 1, 'N', 'N', 'N', 'N', 'N', 'N'),
(246, 19, 2, 'N', 'N', 'N', 'N', 'N', 'N'),
(247, 19, 7, 'N', 'N', 'N', 'N', 'N', 'N'),
(248, 19, 8, 'N', 'N', 'N', 'N', 'N', 'N'),
(249, 19, 10, 'N', 'N', 'N', 'N', 'N', 'N'),
(250, 19, 15, 'N', 'N', 'N', 'N', 'N', 'N'),
(251, 19, 17, 'N', 'N', 'N', 'N', 'N', 'N'),
(252, 19, 18, 'N', 'N', 'N', 'N', 'N', 'N'),
(253, 19, 19, 'N', 'N', 'N', 'N', 'N', 'N'),
(254, 19, 20, 'N', 'N', 'N', 'N', 'N', 'N'),
(255, 19, 24, 'N', 'N', 'N', 'N', 'N', 'N'),
(256, 19, 25, 'N', 'N', 'N', 'N', 'N', 'N'),
(257, 19, 26, 'N', 'N', 'N', 'N', 'N', 'N'),
(258, 1, 27, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(259, 16, 27, 'N', 'N', 'N', 'N', 'N', 'N'),
(260, 17, 27, 'N', 'N', 'N', 'N', 'N', 'N'),
(261, 18, 27, 'N', 'N', 'N', 'N', 'N', 'N'),
(262, 19, 27, 'N', 'N', 'N', 'N', 'N', 'N'),
(263, 1, 28, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(264, 16, 28, 'N', 'N', 'N', 'N', 'N', 'N'),
(265, 17, 28, 'N', 'N', 'N', 'N', 'N', 'N'),
(266, 18, 28, 'N', 'N', 'N', 'N', 'N', 'N'),
(267, 19, 28, 'N', 'N', 'N', 'N', 'N', 'N'),
(268, 1, 29, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(269, 16, 29, 'N', 'N', 'N', 'N', 'N', 'N'),
(270, 17, 29, 'N', 'N', 'N', 'N', 'N', 'N'),
(271, 18, 29, 'N', 'N', 'N', 'N', 'N', 'N'),
(272, 19, 29, 'N', 'N', 'N', 'N', 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE `tbl_faq` (
  `id_faq` varchar(50) NOT NULL,
  `pertanyaan` text NOT NULL,
  `respon` text NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_diubah` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_faq`
--

INSERT INTO `tbl_faq` (`id_faq`, `pertanyaan`, `respon`, `tgl_dibuat`, `tgl_diubah`) VALUES
('FAQ-2023-Jun-647c2c4349526', 'Apakah HP black market (BM) yang dibeli sebelum tanggal 17 Agustus 2019 akan langsung diblokir?', 'Tidak langsung diblokir, tetapi ketentuan atas masa pakainya akan ditentukan kemudian sesuai dengan peraturan perundang-undangan yang berlaku.', '2023-06-04 06:16:35', NULL),
('FAQ-2023-Jun-647c2c5605c1b', 'Bagaimana jika membeli HP dari luar negeri setelah tanggal 17 Agustus 2019? Apakah nantinya bisa dipakai di Indonesia', 'Tetap bisa dipakai, selama importasinya mengikuti ketentuan peraturan perundang-undangan yg berlaku.', '2023-06-04 06:16:54', NULL),
('FAQ-2023-Jun-647c2c843e3a0', 'Apa peran Kementerian Perindustrian dalam regulasi ini?', 'Kementerian Perindustrian mengumpulkan data IMEI yang diperoleh dari proses pendaftaran telepon seluler, komputer genggam, dan komputer tablet, sebagaimana diatur dalam <b><a href=\"http://regulasi.kemenperin.go.id/site/download_peraturan/1393\">Peraturan Menteri Perindustrian RI No. 108/M-IND/PER/11/2012.</a></b>', '2023-06-04 06:17:40', NULL),
('FAQ-2023-Jun-647c2ca8b6189', 'Apa yang dapat saya periksa dengan nomor IMEI?', 'Dengan menggunakan Nomor IMEI yang unik ini Anda dapat mengetahui data seperti: jaringan dan negara asal perangkat Anda, informasi jaminan tanggal pembelian, informasi operator, versi sistem, spesifikasi perangkat, dan informasi detail lainnya. Kapan disarankan untuk memeriksa Informasi IMEI? Anda harus menggunakan Pemeriksa IMEI sebelum membeli perangkat bekas atau baru. Hasilnya, Anda akan melihat apakah perangkat tersebut valid dan asli. Terlebih lagi, Anda juga dapat memeriksa apakah spesifikasinya sesuai dengan penawaran jual. Kami juga mendorong Anda untuk menggunakan Informasi IMEI hanya untuk mengetahui ponsel Anda lebih baik dan membaca informasi penting tentang Perangkat. IMEI.info menawarkan juga beberapa layanan lanjutan (tersedia untuk beberapa produsen) misalnya: Status Temukan iPhone Saya, Status iCloud, Status Daftar Hitam, Informasi Penjual, Pemeriksaan Jaringan & Simlock, Daftar Hitam Telepon, Pemeriksaan Operator, Buka Kunci Simlock, Pemeriksaan Garansi. Mari periksa IMEI dan pastikan ponsel Anda tidak terkunci. Cek IMEI!', '2023-06-04 06:18:16', NULL);

--
-- Triggers `tbl_faq`
--
DELIMITER $$
CREATE TRIGGER `update_tanggal_faq` BEFORE UPDATE ON `tbl_faq` FOR EACH ROW BEGIN
	SET new.tgl_diubah = NOW();
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_imei`
--

CREATE TABLE `tbl_imei` (
  `no_imei` varchar(16) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `no_passport` varchar(50) NOT NULL,
  `no_penerbangan` varchar(50) DEFAULT NULL,
  `tipe_hp` varchar(50) DEFAULT NULL,
  `model_hp` varchar(50) DEFAULT NULL,
  `is_vip` tinyint(1) DEFAULT NULL,
  `expired_date` enum('3','6','12','1','0') DEFAULT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('Aktif Permanen','Aktif Berjangka','Terblokir','Tidak Terdaftar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_imei`
--

INSERT INTO `tbl_imei` (`no_imei`, `nik`, `no_passport`, `no_penerbangan`, `tipe_hp`, `model_hp`, `is_vip`, `expired_date`, `created_by`, `created_at`, `updated_by`, `updated_at`, `status`) VALUES
('111111111111111', '1111111111111111', '1111111111111111', '1111111111111111', 'Apple', 'Iphone 14 Pro Max', 0, '', 186, '2023-01-27 01:49:23', NULL, NULL, 'Aktif Permanen'),
('222222222222222', '2222222222222222', '2222222222222222', '2222222222222222', 'Oppo', 'Oppo Find X', 0, '', 186, '2023-01-27 02:20:20', 186, NULL, 'Aktif Permanen'),
('333333333333333', '', '333333333333333', NULL, NULL, NULL, NULL, '3', 188, '2023-01-27 02:21:17', NULL, NULL, 'Aktif Berjangka');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_laporan`
--

CREATE TABLE `tbl_laporan` (
  `id_laporan` varchar(32) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `imei` varchar(15) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_laporan`
--

INSERT INTO `tbl_laporan` (`id_laporan`, `nama_lengkap`, `imei`, `no_telepon`, `email`, `deskripsi`, `created_at`) VALUES
('63d72b6b0b6319.15476762', 'John Doe', '123456789123456', '123456789', 'johndoe@example.com', 'IMEI Tidak Ditemukan', '2023-01-30 02:28:59'),
('63d72c0300bbf5.90240148', 'John Wick', '123456789121231', '123456789', 'johmwick@example.com', 'IMEI Tidak Ditemukan', '2023-01-30 02:31:31'),
('63d72fada93566.98063268', 'Somebody', '999999999999999', '08123456789', 'somebody@example.com', 'IMEI Diblokir', '2023-01-30 02:47:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log`
--

CREATE TABLE `tbl_log` (
  `log_id` int(11) NOT NULL,
  `log_username` varchar(50) NOT NULL,
  `log_type` varchar(50) NOT NULL,
  `log_desc` text NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_ip` varchar(50) NOT NULL,
  `log_browser` varchar(50) NOT NULL,
  `log_os` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_log`
--

INSERT INTO `tbl_log` (`log_id`, `log_username`, `log_type`, `log_desc`, `log_time`, `log_ip`, `log_browser`, `log_os`) VALUES
(105, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 00:49:46', '127.0.0.1', 'Chrome', 'Windows 10'),
(106, 'manufaktur', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 00:49:58', '127.0.0.1', 'Chrome', 'Windows 10'),
(107, 'manufaktur', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 00:50:16', '127.0.0.1', 'Chrome', 'Windows 10'),
(108, 'Manufaktur', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 00:51:28', '127.0.0.1', 'Chrome', 'Windows 10'),
(109, 'manufaktur', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 00:51:38', '127.0.0.1', 'Chrome', 'Windows 10'),
(110, 'manufaktur', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 00:51:40', '127.0.0.1', 'Chrome', 'Windows 10'),
(111, 'manufaktur', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 01:05:24', '127.0.0.1', 'Firefox', 'Windows 10'),
(112, 'Manufaktur', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 01:35:43', '127.0.0.1', 'Firefox', 'Windows 10'),
(113, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 01:35:49', '127.0.0.1', 'Firefox', 'Windows 10'),
(114, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 01:36:26', '127.0.0.1', 'Firefox', 'Windows 10'),
(115, 'manufaktur2', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 01:36:33', '127.0.0.1', 'Firefox', 'Windows 10'),
(116, 'Manufaktur2', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 01:39:03', '127.0.0.1', 'Firefox', 'Windows 10'),
(117, 'manufaktur', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 01:39:18', '127.0.0.1', 'Firefox', 'Windows 10'),
(118, 'Manufaktur', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 01:50:31', '127.0.0.1', 'Firefox', 'Windows 10'),
(119, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 01:50:36', '127.0.0.1', 'Firefox', 'Windows 10'),
(120, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 01:58:57', '127.0.0.1', 'Firefox', 'Windows 10'),
(121, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 01:59:11', '127.0.0.1', 'Firefox', 'Windows 10'),
(122, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 01:59:14', '127.0.0.1', 'Firefox', 'Windows 10'),
(123, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 01:59:15', '127.0.0.1', 'Firefox', 'Windows 10'),
(124, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 02:15:11', '127.0.0.1', 'Firefox', 'Windows 10'),
(125, 'manufaktur', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 02:15:18', '127.0.0.1', 'Firefox', 'Windows 10'),
(126, 'Manufaktur', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 02:15:24', '127.0.0.1', 'Firefox', 'Windows 10'),
(127, 'manufaktur2', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 02:15:30', '127.0.0.1', 'Firefox', 'Windows 10'),
(128, 'Manufaktur2', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 02:15:36', '127.0.0.1', 'Firefox', 'Windows 10'),
(129, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 02:15:52', '127.0.0.1', 'Firefox', 'Windows 10'),
(130, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 02:18:56', '127.0.0.1', 'Firefox', 'Windows 10'),
(131, 'manufaktur', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 02:19:02', '127.0.0.1', 'Firefox', 'Windows 10'),
(132, 'Manufaktur', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 02:19:10', '127.0.0.1', 'Firefox', 'Windows 10'),
(133, 'manufaktur2', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 02:19:29', '127.0.0.1', 'Firefox', 'Windows 10'),
(134, 'Manufaktur2', 'logout', ' Berhasil Keluar Dari Sistem', '2022-11-22 02:19:35', '127.0.0.1', 'Firefox', 'Windows 10'),
(135, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 02:19:40', '127.0.0.1', 'Firefox', 'Windows 10'),
(136, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 02:19:43', '127.0.0.1', 'Firefox', 'Windows 10'),
(137, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 02:19:44', '127.0.0.1', 'Firefox', 'Windows 10'),
(138, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-11-22 02:19:45', '127.0.0.1', 'Firefox', 'Windows 10'),
(139, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-12-21 07:48:41', '127.0.0.1', 'Chrome', 'Windows 10'),
(140, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2022-12-21 07:48:43', '127.0.0.1', 'Chrome', 'Windows 10'),
(141, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-19 04:10:42', '127.0.0.1', 'Firefox', 'Windows 10'),
(142, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-19 04:11:23', '127.0.0.1', 'Firefox', 'Windows 10'),
(143, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-19 04:11:29', '127.0.0.1', 'Firefox', 'Windows 10'),
(144, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-19 04:12:58', '127.0.0.1', 'Firefox', 'Windows 10'),
(145, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-19 04:13:03', '127.0.0.1', 'Firefox', 'Windows 10'),
(146, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-19 04:13:06', '127.0.0.1', 'Firefox', 'Windows 10'),
(147, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-19 04:13:53', '127.0.0.1', 'Firefox', 'Windows 10'),
(148, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-19 04:16:09', '127.0.0.1', 'Firefox', 'Windows 10'),
(149, 'manufaktur', 'login', ' Gagal Masuk Ke Sistem', '2023-01-19 04:16:16', '127.0.0.1', 'Firefox', 'Windows 10'),
(150, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-19 04:16:22', '127.0.0.1', 'Firefox', 'Windows 10'),
(151, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-19 04:16:38', '127.0.0.1', 'Firefox', 'Windows 10'),
(152, '', 'login', 'manufaktur1 Gagal Masuk Ke Sistem (User Tidak Terdaftar)', '2023-01-19 04:16:43', '127.0.0.1', 'Firefox', 'Windows 10'),
(153, 'manufaktur', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-19 04:16:47', '127.0.0.1', 'Firefox', 'Windows 10'),
(154, 'Manufaktur', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-19 05:15:02', '127.0.0.1', 'Firefox', 'Windows 10'),
(155, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-19 05:15:10', '127.0.0.1', 'Firefox', 'Windows 10'),
(156, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-19 05:30:21', '127.0.0.1', 'Firefox', 'Windows 10'),
(157, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-19 05:30:27', '127.0.0.1', 'Firefox', 'Windows 10'),
(158, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-19 05:35:28', '127.0.0.1', 'Firefox', 'Windows 10'),
(159, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-19 05:35:33', '127.0.0.1', 'Firefox', 'Windows 10'),
(160, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-19 05:37:15', '127.0.0.1', 'Firefox', 'Windows 10'),
(161, 'admin', 'login', ' Gagal Masuk Ke Sistem', '2023-01-19 05:37:20', '127.0.0.1', 'Firefox', 'Windows 10'),
(162, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-19 05:37:32', '127.0.0.1', 'Firefox', 'Windows 10'),
(163, 'admin', 'login', ' Gagal Masuk Ke Sistem', '2023-01-20 04:17:26', '127.0.0.1', 'Firefox', 'Windows 10'),
(164, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-20 04:17:32', '127.0.0.1', 'Firefox', 'Windows 10'),
(165, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-20 06:39:28', '127.0.0.1', 'Firefox', 'Windows 10'),
(166, 'Beacukai', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-20 06:40:54', '127.0.0.1', 'Firefox', 'Windows 10'),
(167, 'beacukai', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-20 06:41:01', '127.0.0.1', 'Firefox', 'Windows 10'),
(168, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-20 10:05:04', '127.0.0.1', 'Firefox', 'Windows 10'),
(169, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-20 10:14:40', '127.0.0.1', 'Firefox', 'Windows 10'),
(170, 'manufaktur', 'login', ' Gagal Masuk Ke Sistem', '2023-01-20 10:14:47', '127.0.0.1', 'Firefox', 'Windows 10'),
(171, 'manufaktur', 'login', ' Gagal Masuk Ke Sistem', '2023-01-20 10:14:53', '127.0.0.1', 'Firefox', 'Windows 10'),
(172, 'manufaktur', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-20 10:14:59', '127.0.0.1', 'Firefox', 'Windows 10'),
(173, 'Manufaktur', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-20 10:15:04', '127.0.0.1', 'Firefox', 'Windows 10'),
(174, 'admin', 'login', ' Gagal Masuk Ke Sistem', '2023-01-20 10:15:19', '127.0.0.1', 'Firefox', 'Windows 10'),
(175, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-20 10:15:25', '127.0.0.1', 'Firefox', 'Windows 10'),
(176, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-20 10:16:45', '127.0.0.1', 'Firefox', 'Windows 10'),
(177, 'provider', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-20 10:16:52', '127.0.0.1', 'Firefox', 'Windows 10'),
(178, 'Provider', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-20 10:33:38', '127.0.0.1', 'Firefox', 'Windows 10'),
(179, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-20 10:33:43', '127.0.0.1', 'Firefox', 'Windows 10'),
(180, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-20 10:35:13', '127.0.0.1', 'Firefox', 'Windows 10'),
(181, 'provider', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-20 10:35:20', '127.0.0.1', 'Firefox', 'Windows 10'),
(182, 'Provider', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-20 10:36:29', '127.0.0.1', 'Firefox', 'Windows 10'),
(183, 'provider', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-20 10:36:34', '127.0.0.1', 'Firefox', 'Windows 10'),
(184, 'provider', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-25 08:28:05', '127.0.0.1', 'Chrome', 'Windows 10'),
(185, 'Provider', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-25 08:44:10', '127.0.0.1', 'Chrome', 'Windows 10'),
(186, 'manufaktur', 'login', ' Gagal Masuk Ke Sistem', '2023-01-25 08:44:15', '127.0.0.1', 'Chrome', 'Windows 10'),
(187, 'manufaktur', 'login', ' Gagal Masuk Ke Sistem', '2023-01-25 08:44:19', '127.0.0.1', 'Chrome', 'Windows 10'),
(188, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-25 08:44:23', '127.0.0.1', 'Chrome', 'Windows 10'),
(189, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-25 08:44:38', '127.0.0.1', 'Chrome', 'Windows 10'),
(190, 'manufaktur', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-25 08:44:44', '127.0.0.1', 'Chrome', 'Windows 10'),
(191, 'Manufaktur', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-25 08:51:36', '127.0.0.1', 'Chrome', 'Windows 10'),
(192, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-25 08:51:42', '127.0.0.1', 'Chrome', 'Windows 10'),
(193, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-25 08:55:46', '127.0.0.1', 'Chrome', 'Windows 10'),
(194, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-25 08:55:51', '127.0.0.1', 'Chrome', 'Windows 10'),
(195, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-25 08:57:58', '127.0.0.1', 'Chrome', 'Windows 10'),
(196, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-25 08:58:03', '127.0.0.1', 'Chrome', 'Windows 10'),
(197, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-26 00:17:29', '127.0.0.1', 'Chrome', 'Windows 10'),
(198, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-26 00:17:36', '127.0.0.1', 'Chrome', 'Windows 10'),
(199, 'Beacukai', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-26 00:17:57', '127.0.0.1', 'Chrome', 'Windows 10'),
(200, 'Beacukai', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-26 00:22:20', '127.0.0.1', 'Chrome', 'Windows 10'),
(201, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-26 00:30:14', '127.0.0.1', 'Chrome', 'Windows 10'),
(202, 'Admin', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-26 00:31:32', '127.0.0.1', 'Chrome', 'Windows 10'),
(203, 'Beacukai', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-26 00:31:45', '127.0.0.1', 'Chrome', 'Windows 10'),
(204, 'Beacukai', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-26 00:32:38', '127.0.0.1', 'Chrome', 'Windows 10'),
(205, 'beacukai', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-26 00:33:34', '127.0.0.1', 'Chrome', 'Windows 10'),
(206, 'Beacukai', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-26 00:44:11', '127.0.0.1', 'Chrome', 'Windows 10'),
(207, 'admin', 'login', ' Gagal Masuk Ke Sistem', '2023-01-26 00:44:16', '127.0.0.1', 'Chrome', 'Windows 10'),
(208, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-26 00:44:19', '127.0.0.1', 'Chrome', 'Windows 10'),
(209, 'beacukai', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-26 22:59:40', '127.0.0.1', 'Chrome', 'Windows 10'),
(210, 'Beacukai', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-27 02:18:50', '127.0.0.1', 'Chrome', 'Windows 10'),
(211, 'beacukai', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-27 02:18:58', '127.0.0.1', 'Chrome', 'Windows 10'),
(212, 'Beacukai', 'logout', ' Berhasil Keluar Dari Sistem', '2023-01-27 02:20:42', '127.0.0.1', 'Chrome', 'Windows 10'),
(213, 'provider', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-27 02:20:54', '127.0.0.1', 'Chrome', 'Windows 10'),
(214, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-01-30 02:31:44', '127.0.0.1', 'Chrome', 'Windows 10'),
(215, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-06-04 05:09:56', '127.0.0.1', 'Chrome', 'Windows 10'),
(216, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-06-04 05:54:42', '127.0.0.1', 'Firefox', 'Windows 10'),
(217, 'admin', 'login', 'Berhasil Masuk Ke Sistem', '2023-06-04 22:19:42', '127.0.0.1', 'Firefox', 'Windows 10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufaktur_imei`
--

CREATE TABLE `tbl_manufaktur_imei` (
  `id_data_imei` varchar(50) NOT NULL,
  `id_manufaktur` int(11) UNSIGNED NOT NULL,
  `merk` varchar(50) NOT NULL,
  `no_model` varchar(50) NOT NULL,
  `total` bigint(20) NOT NULL,
  `file` text,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_diubah` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_manufaktur_imei`
--

INSERT INTO `tbl_manufaktur_imei` (`id_data_imei`, `id_manufaktur`, `merk`, `no_model`, `total`, `file`, `tgl_dibuat`, `tgl_diubah`) VALUES
('M-2023-Jan-63c8ca3664e48', 184, 'Xiaomi', 'T123', 123, '2023-Jan-19--11-42_manufaktur.xlsx', '2023-01-19 04:42:30', '2023-01-19 04:56:50'),
('M-2023-Jan-63c8cada9ab9f', 184, 'Nokia', 'T456', 456, '2023-Jan-19--11-45_manufaktur.xlsx', '2023-01-19 04:45:14', NULL);

--
-- Triggers `tbl_manufaktur_imei`
--
DELIMITER $$
CREATE TRIGGER `update_manufaktur_imei` BEFORE UPDATE ON `tbl_manufaktur_imei` FOR EACH ROW BEGIN
	SET new.tgl_diubah = NOW();
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(50) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `urutan` bigint(11) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `parent` enum('Y') DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`id_menu`, `nama_menu`, `link`, `icon`, `urutan`, `is_active`, `parent`) VALUES
(1, 'Dashboard', 'dashboard', 'fas fa-tachometer-alt', 1, 'Y', 'Y'),
(2, 'Pengaturan', '#', 'fas fa-cogs', 8, 'Y', 'Y'),
(74, 'Data Master', '#', 'fas fa-database', 1, 'Y', 'Y'),
(75, 'Data IMEI', 'data-imei', 'fas fa-database', 1, 'Y', 'Y'),
(76, 'Data Provider', 'data-provider', 'fas fa-database', 1, 'Y', 'Y'),
(77, 'Data Beacukai', 'data-beacukai', 'fas fa-database', 1, 'Y', 'Y'),
(78, 'Landing Page', '#', 'fas fa-window-restore', 2, 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pending_user`
--

CREATE TABLE `tbl_pending_user` (
  `id_pending_user` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_diubah` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `tbl_pending_user`
--
DELIMITER $$
CREATE TRIGGER `update_tanggal_pending_user` BEFORE UPDATE ON `tbl_pending_user` FOR EACH ROW BEGIN
	SET new.tgl_diubah = NOW();
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_submenu`
--

CREATE TABLE `tbl_submenu` (
  `id_submenu` int(11) UNSIGNED NOT NULL,
  `nama_submenu` varchar(50) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_submenu`
--

INSERT INTO `tbl_submenu` (`id_submenu`, `nama_submenu`, `link`, `icon`, `id_menu`, `is_active`) VALUES
(1, 'Menu', 'menu', 'fas fa-bars', 2, 'Y'),
(2, 'Sub Menu', 'submenu', 'fas fa-caret-square-down', 2, 'Y'),
(7, 'Aplikasi', 'aplikasi', 'fas fa-globe', 2, 'Y'),
(8, 'Manajemen User', 'user', 'fas fa-users', 2, 'Y'),
(10, 'Hak Akses', 'userlevel', 'fas fa-users-cog', 2, 'Y'),
(15, 'Barang', 'barang', 'far fa-circle', 32, 'Y'),
(17, 'Kategori', 'kategori', 'far fa-circle', 32, 'Y'),
(18, 'Satuan', 'satuan', 'far fa-circle', 32, 'Y'),
(19, 'Pembelian', 'pembelian', 'far fa-circle', 41, 'Y'),
(20, 'Penjualan', 'penjualan', 'far fa-circle', 41, 'Y'),
(24, 'Aktivasi User', 'aktivasi-user', 'fas fa-user-check', 2, 'N'),
(25, 'Manufaktur', 'manufaktur', 'fas fa-database', 74, 'Y'),
(26, 'Daftar IMEI', 'daftar-imei', 'fas fa-table', 74, 'Y'),
(27, 'Bea Cukai', 'beacukai', 'fas fa-database', 74, 'Y'),
(28, 'Laporan', 'laporan', 'fas fa-paper-plane', 74, 'Y'),
(29, 'FAQ', 'faq', 'fas fa-question-circle', 78, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) UNSIGNED NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_level` int(11) UNSIGNED NOT NULL DEFAULT '6',
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `tgl_buat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_diubah` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `full_name`, `password`, `id_level`, `is_active`, `tgl_buat`, `tgl_diubah`) VALUES
(1, 'admin', 'Administrator', '$2y$05$3oQlxl8wMGd8VecO4nFXre3SjeHWqFN79oMy/.pdEj5Q89xopj4oi', 1, 'Y', '2022-01-25 23:50:59', '2022-05-16 02:58:05'),
(184, 'manufaktur', 'PT Manufaktur 1', '$2y$05$njkSGwz9ezts7lQEdIa3N.oOr4D1NIJXuJFpeizAHLsmmpRwqmtgK', 16, 'Y', '2022-11-15 02:16:23', '2023-01-25 08:44:37'),
(185, 'manufaktur2', 'PT Manufaktur 2', '$2y$05$vnUbh41Koglg79Ng9/qWjeB1V48j6u0gZc7/3saFFw5BcrdwgUmDa', 16, 'Y', '2022-11-22 01:36:22', NULL),
(186, 'beacukai', 'Bea Cukai', '$2y$05$nibTA1qR8Fe3rgU9f/iQwOgAZ2Nw.24AD0gekNN2XAmIauQISf7gO', 17, 'Y', '2023-01-20 06:38:54', NULL),
(187, 'kominfo', 'Kominfo', '$2y$05$WGenGS0t2jblqMT2PMj/7uNtBwG2Www5w3aY1L7dg8be/sIa0WD2.', 18, 'Y', '2023-01-20 06:39:09', NULL),
(188, 'provider', 'Provider 1', '$2y$05$CjAr1J4lIToI3oJzk2sqY.8niyE0J8jxQG27q9OWvuTnj5zi0xTHW', 19, 'Y', '2023-01-20 10:15:55', '2023-01-20 10:16:44');

--
-- Triggers `tbl_user`
--
DELIMITER $$
CREATE TRIGGER `update_tanggal_user` BEFORE UPDATE ON `tbl_user` FOR EACH ROW BEGIN
	SET new.tgl_diubah = NOW();
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userlevel`
--

CREATE TABLE `tbl_userlevel` (
  `id_level` int(11) UNSIGNED NOT NULL,
  `nama_level` varchar(50) DEFAULT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_diubah` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_userlevel`
--

INSERT INTO `tbl_userlevel` (`id_level`, `nama_level`, `tgl_dibuat`, `tgl_diubah`) VALUES
(1, 'Admin', '2021-11-03 23:55:16', NULL),
(16, 'Manufaktur', '2022-11-15 01:14:57', NULL),
(17, 'Bea Cukai', '2023-01-20 04:48:39', NULL),
(18, 'Kominfo', '2023-01-20 06:24:20', NULL),
(19, 'Provider', '2023-01-20 10:16:06', NULL);

--
-- Triggers `tbl_userlevel`
--
DELIMITER $$
CREATE TRIGGER `update_tanggal_user_level` BEFORE UPDATE ON `tbl_userlevel` FOR EACH ROW BEGIN
	SET new.tgl_diubah = NOW();
    END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aplikasi`
--
ALTER TABLE `aplikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_akses_menu`
--
ALTER TABLE `tbl_akses_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_akses_submenu`
--
ALTER TABLE `tbl_akses_submenu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  ADD PRIMARY KEY (`id_faq`);

--
-- Indexes for table `tbl_imei`
--
ALTER TABLE `tbl_imei`
  ADD PRIMARY KEY (`no_imei`);

--
-- Indexes for table `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `tbl_log`
--
ALTER TABLE `tbl_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tbl_manufaktur_imei`
--
ALTER TABLE `tbl_manufaktur_imei`
  ADD PRIMARY KEY (`id_data_imei`),
  ADD KEY `fk_manufaktur_user` (`id_manufaktur`);

--
-- Indexes for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `tbl_pending_user`
--
ALTER TABLE `tbl_pending_user`
  ADD PRIMARY KEY (`id_pending_user`);

--
-- Indexes for table `tbl_submenu`
--
ALTER TABLE `tbl_submenu`
  ADD PRIMARY KEY (`id_submenu`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_userlevel` (`id_level`);

--
-- Indexes for table `tbl_userlevel`
--
ALTER TABLE `tbl_userlevel`
  ADD PRIMARY KEY (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aplikasi`
--
ALTER TABLE `aplikasi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_akses_menu`
--
ALTER TABLE `tbl_akses_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT for table `tbl_akses_submenu`
--
ALTER TABLE `tbl_akses_submenu`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `tbl_log`
--
ALTER TABLE `tbl_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `tbl_pending_user`
--
ALTER TABLE `tbl_pending_user`
  MODIFY `id_pending_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_submenu`
--
ALTER TABLE `tbl_submenu`
  MODIFY `id_submenu` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `tbl_userlevel`
--
ALTER TABLE `tbl_userlevel`
  MODIFY `id_level` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_manufaktur_imei`
--
ALTER TABLE `tbl_manufaktur_imei`
  ADD CONSTRAINT `fk_manufaktur_user` FOREIGN KEY (`id_manufaktur`) REFERENCES `tbl_user` (`id_user`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `fk_userlevel` FOREIGN KEY (`id_level`) REFERENCES `tbl_userlevel` (`id_level`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
