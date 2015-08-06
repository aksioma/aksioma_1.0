-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 06, 2015 at 04:56 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bmt_v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `menuapp`
--

DROP TABLE IF EXISTS `menuapp`;
CREATE TABLE IF NOT EXISTS `menuapp` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `href` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `css` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sub` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `groups` text COLLATE utf8_unicode_ci,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=71 ;

--
-- Dumping data for table `menuapp`
--

INSERT INTO `menuapp` (`menu_id`, `nama`, `href`, `icon`, `css`, `sub`, `parent`, `urutan`, `groups`, `active`) VALUES
(1, 'Dashboard', '.', '<i class="icon-home"></i>', 'index', '', 0, 1, 'a:8:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:9:"MARKETING";i:6;s:20:"Operasional & Keuang";i:7;s:6:"TELLER";}', 1),
(2, 'Parameter', 'root', '<i class="icon-cog"></i>', 'param', '', 0, 2, 'a:4:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:7:"MANAGER";i:3;s:20:"Operasional & Keuang";}', 1),
(3, 'Akuntansi', 'root', '<i class="icon-barcode"></i> ', 'akun', '', 0, 6, 'a:3:{i:0;s:5:"Admin";i:1;s:9:"AKUNTANSi";i:2;s:20:"Operasional & Keuang";}', 1),
(4, 'Data dasar', 'j', '<i class="icon-pencil"></i>', 'base', '', 0, 3, 'a:7:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:20:"Operasional & Keuang";i:6;s:6:"TELLER";}', 1),
(5, 'Transaksi Teller', 'j', '<i class="icon-edit"></i>', 'transaksiumum', '', 0, 4, 'a:1:{i:0;s:6:"TELLER";}', 1),
(6, 'Transaksi Umum', '[removed];', '<i class="icon-adjust"></i>', 'transaksikas', '', 0, 5, 'a:2:{i:0;s:5:"Admin";i:1;s:6:"TELLER";}', 1),
(60, 'Distribusi Profit', 'param/distribusiprofit', '', 'param', 'distribusiprofit', 2, 11, 'a:3:{i:0;s:5:"Admin";i:1;s:7:"MANAGER";i:2;s:20:"Operasional & Keuang";}', 1),
(8, 'Monitor', 'javascript:;', '<i class="icon-bar-chart"></i>', 'monitor', '', 0, 8, 'a:8:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:9:"MARKETING";i:6;s:20:"Operasional & Keuang";i:7;s:6:"TELLER";}', 1),
(9, 'Otomasi', '[removed];', '<i class="icon-briefcase"></i>', 'tools', '', 0, 9, 'a:4:{i:0;s:5:"Admin";i:1;s:9:"AKUNTANSi";i:2;s:2:"CS";i:3;s:20:"Operasional & Keuang";}', 1),
(11, 'Wewenang', 'param/user', '', 'param', 'user', 2, 1, 'a:3:{i:0;s:5:"Admin";i:1;s:7:"MANAGER";i:2;s:20:"Operasional & Keuang";}', 1),
(13, 'Pegawai', 'param/pegawai', '', 'param', 'pegawai', 2, 4, 'a:3:{i:0;s:5:"Admin";i:1;s:7:"MANAGER";i:2;s:20:"Operasional & Keuang";}', 1),
(64, 'Sampul tabungan', 'setting/sampultab', '', 'setting', 'sampultab', 61, 3, 'a:2:{i:0;s:5:"Admin";i:1;s:20:"Operasional & Keuang";}', 1),
(14, 'Tentang BMT', 'param/bmt', '', 'param', 'bmt', 2, 5, 'a:3:{i:0;s:5:"Admin";i:1;s:7:"MANAGER";i:2;s:20:"Operasional & Keuang";}', 1),
(15, 'List Akun', 'param/listakun', '', 'param', 'listakun', 2, 6, 'a:3:{i:0;s:5:"Admin";i:1;s:7:"MANAGER";i:2;s:20:"Operasional & Keuang";}', 1),
(16, 'Nasabah', 'param/nasabah', '', 'param', 'nasabah', 2, 7, 'a:3:{i:0;s:5:"Admin";i:1;s:7:"MANAGER";i:2;s:20:"Operasional & Keuang";}', 1),
(17, 'Tabungan', 'param/tabungan', '', 'param', 'tabungan', 2, 8, 'a:3:{i:0;s:5:"Admin";i:1;s:7:"MANAGER";i:2;s:20:"Operasional & Keuang";}', 1),
(18, 'Pembiayaan', 'param/pembiayaan', '', 'param', 'pembiayaan', 2, 9, 'a:3:{i:0;s:5:"Admin";i:1;s:7:"MANAGER";i:2;s:20:"Operasional & Keuang";}', 1),
(19, 'Deposito', 'param/deposito', '', 'param', 'deposito', 2, 10, 'a:3:{i:0;s:5:"Admin";i:1;s:7:"MANAGER";i:2;s:20:"Operasional & Keuang";}', 1),
(20, 'Masukkan Jurnal', 'akunting/jurnal', '', 'akun', 'jurnal', 3, 1, 'a:3:{i:0;s:5:"Admin";i:1;s:9:"AKUNTANSi";i:2;s:20:"Operasional & Keuang";}', 1),
(21, 'Jurnal umum', 'akunting/posting', '', 'akun', 'posting', 3, 2, 'a:3:{i:0;s:5:"Admin";i:1;s:9:"AKUNTANSi";i:2;s:20:"Operasional & Keuang";}', 1),
(22, 'Laporan Neraca', 'akunting/neraca', '', 'akun', 'neraca', 3, 3, 'a:3:{i:0;s:5:"Admin";i:1;s:9:"AKUNTANSi";i:2;s:20:"Operasional & Keuang";}', 1),
(23, 'Laporan Laba Rugi', 'akunting/labarugi', '', 'akun', 'labarugi', 3, 4, 'a:3:{i:0;s:5:"Admin";i:1;s:9:"AKUNTANSi";i:2;s:20:"Operasional & Keuang";}', 1),
(24, 'Nasabah', 'base/nasabah', '', 'base', 'nasabah', 4, 1, 'a:6:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:2:"CS";i:3;s:7:"MANAGER";i:4;s:20:"Operasional & Keuang";i:5;s:6:"TELLER";}', 1),
(25, 'Tabungan', 'base/tabungan', '', 'base', 'tabungan', 4, 2, 'a:6:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:2:"CS";i:3;s:7:"MANAGER";i:4;s:9:"MARKETING";i:5;s:6:"TELLER";}', 1),
(26, 'Jaminan', 'base/jaminan', '', 'base', 'jaminan', 4, 3, 'a:6:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:2:"CS";i:3;s:7:"MANAGER";i:4;s:9:"MARKETING";i:5;s:6:"TELLER";}', 1),
(27, 'Pembiayaan', 'base/pembiayaan', '', 'base', 'pembiayaan', 4, 4, 'a:6:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:2:"CS";i:3;s:7:"MANAGER";i:4;s:20:"Operasional & Keuang";i:5;s:6:"TELLER";}', 1),
(28, 'Deposito', 'base/deposito', '', 'base', 'deposito', 4, 5, 'a:6:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:2:"CS";i:3;s:7:"MANAGER";i:4;s:20:"Operasional & Keuang";i:5;s:6:"TELLER";}', 1),
(29, 'Setor Tunai', 'setortunai', '', 'transaksiumum', 'setortunai', 5, 1, 'a:1:{i:0;s:6:"TELLER";}', 1),
(30, 'Tarik Tunai', 'tariktunai', '', 'transaksiumum', 'tariktunai', 5, 2, 'a:1:{i:0;s:6:"TELLER";}', 1),
(31, 'Setor Tunai Deposito', 'setordeposito', '', 'transaksiumum', 'setordeposito', 5, 3, 'a:1:{i:0;s:6:"TELLER";}', 1),
(32, 'Pencairan Deposito', 'pencairandeposito', '', 'transaksiumum', 'pencairandeposito', 5, 4, 'a:1:{i:0;s:6:"TELLER";}', 1),
(33, 'Pencairan Pembiayaan', 'pencairanpembiayaan', '', 'transaksiumum', 'pencairanpembiayaan', 5, 5, 'a:1:{i:0;s:6:"TELLER";}', 1),
(34, 'Setor Angsuran', 'angsuran', '', 'transaksiumum', 'angsuran', 5, 6, 'a:1:{i:0;s:6:"TELLER";}', 1),
(35, 'Laporan Mutasi', 'lapmutasi', '', 'transaksiumum', 'lapmutasi', 5, 7, 'a:1:{i:0;s:6:"TELLER";}', 1),
(36, 'Hapus Transaksi', 'hapustransaksi', '', 'transaksiumum', 'hapustransaksi', 5, 8, 'a:1:{i:0;s:6:"TELLER";}', 1),
(37, 'Kas keluar / masuk', 'trans/kaskeluarmasuk', '', 'transaksikas', 'kaskeluarmasuk', 6, 1, 'a:3:{i:0;s:10:"ACCOUNTING";i:1;s:5:"Admin";i:2;s:6:"TELLER";}', 1),
(39, 'Selisih Kurang', 'trans/selisihkuranglebih', '', 'transaksikas', 'selisihkuranglebih', 6, 2, 'a:2:{i:0;s:5:"Admin";i:1;s:6:"TELLER";}', 1),
(57, 'Report Transaksi', 'trans/reporttransaksi', '', 'transaksikas', 'reporttransaksi', 6, 4, 'a:1:{i:0;s:6:"TELLER";}', 1),
(58, 'Plugin', '#', '<i class="icon-signin"></i>', 'plugin', '', 0, 11, 'a:8:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:9:"MARKETING";i:6;s:20:"Operasional & Keuang";i:7;s:6:"TELLER";}', 1),
(59, 'Simulasi Emas', 'plugin/simulasiemas', '', 'plugin', 'simulasiemas', 58, 1, 'a:8:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:9:"MARKETING";i:6;s:20:"Operasional & Keuang";i:7;s:6:"TELLER";}', 1),
(61, 'Setting', 'javascript:;', '<i class="icon-wrench"></i>', 'setting', '', 0, 10, 'a:2:{i:0;s:5:"Admin";i:1;s:20:"Operasional & Keuang";}', 1),
(65, 'Tema tampilan', 'setting/theme', '', 'setting', 'theme', 61, 4, 'a:2:{i:0;s:5:"Admin";i:1;s:20:"Operasional & Keuang";}', 1),
(67, 'Tentang AKSIOMA', 'help', '', 'help', 'help', 66, 1, 'a:8:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:9:"MARKETING";i:6;s:20:"Operasional & Keuang";i:7;s:6:"TELLER";}', 1),
(68, 'Info Pegadaian Syariah', 'pegadaian', '', 'help', 'pegadaian', 66, 2, 'a:8:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:9:"MARKETING";i:6;s:20:"Operasional & Keuang";i:7;s:6:"TELLER";}', 1),
(45, 'Cetak Tabungan', 'monitor/cetaktabungan', '', 'monitor', 'cetaktabungan', 5, 9, 'a:3:{i:0;s:10:"ACCOUNTING";i:1;s:5:"Admin";i:2;s:6:"TELLER";}', 1),
(46, 'Aktivasi Tabungan', 'monitor/aktivasitabungan', '', 'monitor', 'aktivasitabungan', 4, 6, 'a:4:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:2:"CS";i:3;s:20:"Operasional & Keuang";}', 1),
(47, 'Tabungan', 'monitor/listtabungan', '', 'monitor', 'listtabungan', 8, 3, 'a:8:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:9:"MARKETING";i:6;s:20:"Operasional & Keuang";i:7;s:6:"TELLER";}', 1),
(48, 'Pembiayaan', 'monitor/pembiayaan', '', 'monitor', 'pembiayaan', 8, 4, 'a:8:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:9:"MARKETING";i:6;s:20:"Operasional & Keuang";i:7;s:6:"TELLER";}', 1),
(49, 'NPF', 'monitor/npf', '', 'monitor', 'npf', 8, 6, 'a:7:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:9:"MARKETING";i:6;s:20:"Operasional & Keuang";}', 1),
(63, 'Cetak tabungan', 'setting/cetaktabungan', '', 'setting', 'cetaktabungan', 61, 2, 'a:2:{i:0;s:5:"Admin";i:1;s:20:"Operasional & Keuang";}', 1),
(50, 'Deposito', 'monitor/deposito', '', 'monitor', 'deposito', 8, 5, 'a:8:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:9:"MARKETING";i:6;s:20:"Operasional & Keuang";i:7;s:6:"TELLER";}', 1),
(66, 'Bantuan', '#', '<i class="icon-search"></i>', 'help', '', 0, 12, 'a:8:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSi";i:3;s:2:"CS";i:4;s:7:"MANAGER";i:5;s:9:"MARKETING";i:6;s:20:"Operasional & Keuang";i:7;s:6:"TELLER";}', 1),
(51, 'Data cadangan', 'tool/backupdata', '', 'tools', 'backupdata', 9, 1, 'a:3:{i:0;s:5:"Admin";i:1;s:9:"AKUNTANSi";i:2;s:2:"CS";}', 1),
(52, 'Perhitungan Bagi Hasil', 'tool/hitungbasil', '', 'tools', 'hitungbasil', 9, 2, 'a:3:{i:0;s:5:"Admin";i:1;s:2:"CS";i:2;s:20:"Operasional & Keuang";}', 1),
(62, 'Logo', 'setting/logo', '', 'setting', 'logo', 61, 1, 'a:1:{i:0;s:5:"Admin";}', 1),
(54, 'Informasi Basil', '#', '', 'tools', 'informasibasil', 9, 3, 'a:1:{i:0;s:5:"Admin";}', 0),
(55, 'Kesehatan', '#', '', 'tools', 'kesehatan', 9, 4, 'a:1:{i:0;s:5:"Admin";}', 0),
(56, 'Kolektibilitas', 'param/kolektibilitas', '', 'param', 'kolektibilitas', 2, 11, 'a:3:{i:0;s:5:"Admin";i:1;s:7:"MANAGER";i:2;s:20:"Operasional & Keuang";}', 1),
(69, 'Report Teller', 'trans/reportteller', '', 'transaksikas', 'reportteller', 6, 5, 'a:4:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSI";i:3;s:6:"TELLER";}', 1),
(70, 'Transaksi Lain', 'trans/transaksilain', '', 'transaksikas', 'transaksilain', 6, 3, 'a:6:{i:0;s:9:"ADM LEGAL";i:1;s:5:"Admin";i:2;s:9:"AKUNTANSI";i:3;s:7:"MANAGER";i:4;s:9:"MARKETING";i:5;s:6:"TELLER";}', 1);
