-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jan 2023 pada 07.54
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `nama_admin` varchar(50) NOT NULL,
  `alamat_admin` text NOT NULL,
  `tlp_admin` varchar(13) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`nama_admin`, `alamat_admin`, `tlp_admin`, `email`) VALUES
('Satrio', 'Bendan', '08156673219', 'satrio@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `faktur`
--

CREATE TABLE `faktur` (
  `kd_faktur` int(30) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `total_biaya_barang` double DEFAULT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp(),
  `pembayaran` enum('COD','Transfer') NOT NULL DEFAULT 'Transfer',
  `kurir` varchar(20) NOT NULL DEFAULT 'jne',
  `lama_kirim` varchar(10) DEFAULT NULL,
  `biaya_pengiriman` double DEFAULT NULL,
  `konfirm` enum('Dikirim','Belum','Menunggu Pembayaran') NOT NULL DEFAULT 'Belum',
  `bukti_transfer` varchar(100) DEFAULT NULL,
  `tgl_kirim` datetime DEFAULT NULL,
  `resi` tinytext DEFAULT NULL,
  `tgl_terima` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `faktur`
--

INSERT INTO `faktur` (`kd_faktur`, `userid`, `total_biaya_barang`, `tgl`, `pembayaran`, `kurir`, `lama_kirim`, `biaya_pengiriman`, `konfirm`, `bukti_transfer`, `tgl_kirim`, `resi`, `tgl_terima`) VALUES
(1674197138, 'robba@gmail.com', 11400, '2023-01-20 06:45:38', 'Transfer', 'jne', '3-6', 8000, 'Dikirim', '1674197138.jpg', NULL, NULL, NULL),
(1674197172, 'robba@gmail.com', 105600, '2023-01-20 06:46:12', 'Transfer', 'jne', '3-6', 8000, 'Dikirim', '1674197172.jpg', NULL, NULL, NULL),
(1674197284, 'robba@gmail.com', 7000, '2023-01-20 06:48:04', 'COD', 'sanggar kicau', '2', 10000, 'Dikirim', NULL, NULL, NULL, NULL),
(1674197410, 'robba@gmail.com', 135000, '2023-01-20 06:50:10', 'Transfer', 'jne', '3-6', 40000, 'Dikirim', '1674197410.jpg', NULL, NULL, NULL),
(1674197477, 'robba@gmail.com', 135000, '2023-01-20 06:51:17', 'Transfer', 'jne', '3-6', 40000, 'Dikirim', '1674197477.PNG', NULL, NULL, NULL),
(1674197514, 'robba@gmail.com', 105600, '2023-01-20 06:51:54', 'Transfer', 'jne', '3-6', 8000, 'Dikirim', '1674197514.jpg', NULL, NULL, NULL),
(1674197609, 'robba@gmail.com', 7000, '2023-01-20 06:53:29', 'COD', 'sanggar kicau', '2', 10000, 'Dikirim', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto_produk`
--

CREATE TABLE `foto_produk` (
  `kd_produk` int(11) NOT NULL,
  `foto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `foto_produk`
--

INSERT INTO `foto_produk` (`kd_produk`, `foto`) VALUES
(1, 'produk1112221107461.jpg .png'),
(2, 'produk2212221034461.jpg .png'),
(2, 'produk2212221034462.jpg .png'),
(2, 'produk2212221034463.jpg .png'),
(3, 'produk2212221047321.jpg .png'),
(3, 'produk2212221048051.jpg'),
(3, 'produk2212221048052.jpg'),
(3, 'produk2212221048053.jpg'),
(4, 'produk2212221056231.jpg .png'),
(4, 'produk2212221056481.jpg'),
(4, 'produk2212221056482.jpg'),
(5, 'produk2212221100531.jpg .png'),
(6, 'produk2212221103551.jpg .png'),
(7, 'produk2212221111091.jpg .png'),
(8, 'produk2001230137581.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `halaman`
--

CREATE TABLE `halaman` (
  `kd_halaman` int(11) NOT NULL,
  `nama_halaman` text NOT NULL,
  `isi_halaman` longtext NOT NULL,
  `admin` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `halaman`
--

INSERT INTO `halaman` (`kd_halaman`, `nama_halaman`, `isi_halaman`, `admin`) VALUES
(1, 'Tentang', '<p>Sanggar Kicau merupakan toko yang menjual berbagai jenis burung, aksesoris burung, pakan burung, sangkar burung dan lain sebagainya.</p>\r\n', 'satrio@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inbox`
--

CREATE TABLE `inbox` (
  `kd_inbox` int(11) NOT NULL,
  `pengirim` varchar(30) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `tujuan` enum('Admin','Pelanggan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `inbox`
--

INSERT INTO `inbox` (`kd_inbox`, `pengirim`, `judul`, `tujuan`) VALUES
(1, 'hawari@gmail.com', 'Pesanan Sudah dikirim', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inbox_detail`
--

CREATE TABLE `inbox_detail` (
  `kd_inbox_detail` int(11) NOT NULL,
  `kd_inbox` int(11) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `pesan` text NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('N','R') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `inbox_detail`
--

INSERT INTO `inbox_detail` (`kd_inbox_detail`, `kd_inbox`, `userid`, `pesan`, `tgl`, `status`) VALUES
(2, 1, 'hawari@gmail.com', 'Sangat memuaskan\r\nPengirimannya cepat', '2022-12-21 13:46:11', 'R');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `kd_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`kd_kategori`, `nama_kategori`) VALUES
(1, 'Burung'),
(2, 'Sangkar Burung'),
(3, 'Pakan Burung'),
(4, 'Aksesoris Burung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `kd_kontak` int(11) NOT NULL,
  `kontak` varchar(30) NOT NULL,
  `isi_kontak` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kontak`
--

INSERT INTO `kontak` (`kd_kontak`, `kontak`, `isi_kontak`) VALUES
(2, 'SMS (Only)', '0857 4337 1776'),
(3, 'Telepon', '0285 427 313'),
(4, 'Email', 'sanggar.kicau@gmail.com'),
(5, 'Instagram', '@sanggar.kicaupkl');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lap_labarugi`
--

CREATE TABLE `lap_labarugi` (
  `kd_laplabarugi` int(11) NOT NULL,
  `kd_penjualan` int(30) NOT NULL,
  `total_beli` double NOT NULL,
  `total_jual` double NOT NULL,
  `laba_rugi` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lap_penjualan`
--

CREATE TABLE `lap_penjualan` (
  `kd_lappenjualan` int(11) NOT NULL,
  `kd_penjualan` int(30) NOT NULL,
  `kd_produk` int(11) NOT NULL,
  `jml_beli` int(11) NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `nama_plg` varchar(50) NOT NULL,
  `alamat_plg` text NOT NULL,
  `kd_provinsi` int(11) DEFAULT NULL,
  `kd_kota` int(11) NOT NULL,
  `kodepos_plg` int(5) NOT NULL,
  `tlp_plg` varchar(13) NOT NULL,
  `email_plg` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`nama_plg`, `alamat_plg`, `kd_provinsi`, `kd_kota`, `kodepos_plg`, `tlp_plg`, `email_plg`) VALUES
('Muhammad Hawari', 'Pekalongan', 10, 348, 51113, '0815673219', 'hawari@gmail.com'),
('Muhammad Robba Maulana', 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 10, 348, 5111, '085867236412', 'robba@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengiriman`
--

CREATE TABLE `pengiriman` (
  `kd_faktur` int(30) NOT NULL,
  `penerima` varchar(50) DEFAULT NULL,
  `kd_provinsi` int(11) DEFAULT NULL,
  `kd_kota` int(11) DEFAULT NULL,
  `alamat_penerima` text DEFAULT NULL,
  `kdpos_penerima` int(5) DEFAULT NULL,
  `tlp_penerima` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengiriman`
--

INSERT INTO `pengiriman` (`kd_faktur`, `penerima`, `kd_provinsi`, `kd_kota`, `alamat_penerima`, `kdpos_penerima`, `tlp_penerima`) VALUES
(0, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1669464680, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1670452243, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1670731740, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1671539854, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1671624257, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1671624633, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1673122327, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1673578974, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1673579122, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1673580945, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1673581060, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1673582002, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674186222, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674186291, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674186425, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674186738, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674186795, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674186890, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674187299, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674187331, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674187746, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674187887, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674187994, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188090, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188180, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188206, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188286, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188432, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188554, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188599, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188616, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188667, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188716, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188841, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674188958, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674189179, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674189640, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674189825, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674189884, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674189941, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674189970, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674190024, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219'),
(1674196655, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1674196874, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1674196920, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1674196977, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1674197056, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1674197138, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1674197172, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1674197284, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1674197410, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1674197477, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1674197514, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412'),
(1674197609, 'Muhammad Robba Maulana', 10, 348, 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 5111, '085867236412');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `kd_penjualan` int(11) NOT NULL,
  `kd_faktur` int(30) NOT NULL,
  `kd_produk` int(11) NOT NULL,
  `harga_produk` double NOT NULL,
  `jml_beli` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`kd_penjualan`, `kd_faktur`, `kd_produk`, `harga_produk`, `jml_beli`) VALUES
(14, 1669464680, 1, 169999.15, 1),
(15, 1670452243, 2, 11400, 5),
(16, 1670731740, 1, 270000, 1),
(23, 1671624633, 1, 270000, 1),
(26, 1673578974, 1, 270000, 5),
(27, 1673579122, 7, 446250, 1),
(28, 1673580945, 6, 7000, 1),
(29, 1673581060, 6, 7000, 2),
(35, 1671539854, 4, 413550, 1),
(37, 1671624257, 8, 105600, 1),
(38, 1673122327, 8, 105600, 1),
(39, 1673582002, 8, 105600, 1),
(41, 1674186222, 8, 105600, 5),
(42, 1674186291, 5, 44000, 6),
(43, 1674186425, 3, 135000, 1),
(44, 1674186738, 3, 135000, 1),
(45, 1674186795, 7, 446250, 1),
(46, 1674186890, 2, 11400, 1),
(47, 1674187299, 2, 11400, 4),
(48, 1674187331, 1, 270000, 1),
(49, 1674187746, 8, 105600, 1),
(50, 1674187887, 8, 105600, 1),
(53, 1674187994, 3, 135000, 1),
(54, 1674187994, 7, 446250, 1),
(55, 1674188090, 6, 7000, 1),
(56, 1674188180, 6, 7000, 1),
(57, 1674188206, 7, 446250, 1),
(58, 1674188286, 3, 135000, 1),
(61, 1674188432, 3, 135000, 1),
(62, 1674188554, 7, 446250, 1),
(63, 1674188599, 3, 135000, 1),
(64, 1674188616, 8, 105600, 1),
(65, 1674188667, 8, 105600, 1),
(67, 1674188716, 4, 413550, 1),
(68, 1674188841, 6, 7000, 1),
(70, 1674188958, 6, 7000, 10),
(73, 1674189179, 4, 413550, 1),
(74, 1674189179, 8, 105600, 1),
(75, 1674189179, 2, 11400, 1),
(76, 1674189640, 2, 11400, 1),
(78, 1674189640, 3, 135000, 1),
(79, 1674189825, 3, 135000, 1),
(80, 1674189884, 3, 135000, 1),
(81, 1674189941, 2, 11400, 1),
(82, 1674189970, 6, 7000, 1),
(83, 1674190024, 8, 105600, 1),
(84, 1674196655, 8, 105600, 1),
(85, 1674196874, 1, 270000, 2),
(86, 1674196920, 8, 105600, 1),
(87, 1674196977, 2, 11400, 1),
(88, 1674197056, 2, 11400, 1),
(89, 1674197138, 2, 11400, 1),
(90, 1674197172, 8, 105600, 1),
(91, 1674197284, 6, 7000, 1),
(92, 1674197410, 3, 135000, 1),
(93, 1674197477, 3, 135000, 1),
(94, 1674197514, 8, 105600, 1),
(95, 1674197609, 6, 7000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `kd_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `kd_kategori` int(11) NOT NULL,
  `kondisi` varchar(30) NOT NULL,
  `warna` varchar(20) NOT NULL,
  `ukuran` varchar(20) NOT NULL,
  `berat` double NOT NULL,
  `harga` double NOT NULL,
  `stok` int(5) NOT NULL,
  `deskripsi` longtext DEFAULT NULL,
  `foto` varchar(30) DEFAULT 'produk.png',
  `tgl_produk` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `diskon` double DEFAULT NULL,
  `hargabeli` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`kd_produk`, `nama_produk`, `kd_kategori`, `kondisi`, `warna`, `ukuran`, `berat`, `harga`, `stok`, `deskripsi`, `foto`, `tgl_produk`, `diskon`, `hargabeli`) VALUES
(1, 'Burung Love Bird Sepasang', 1, '', 'Biru, Putih', '0', 40, 300000, 865, '', 'produk1112221107461.jpg .png', '2023-01-20 06:41:14', 10, 0),
(2, 'VOER BURUNG TOP SONG TOPSONG COKLAT', 3, '', 'Coklat', '0', 550, 12000, 19, '<p>Deskripsi pur top song / top song coklat makanan burung murai jalak c.ijo trucuk anis<br />\r\n<br />\r\n<strong>Top Song Coklat</strong><br />\r\n<br />\r\nMakanan Burung merk Top song 3 in 1, diracik agar pencernaan burung kesayangan anda lebih lancar dan sehat. Apalagi dengan ekstra madu dan telor yang diramu khusus agar burung kesayangan rajin berkicau.</p>\r\n', 'produk2212221034461.jpg .png', '2023-01-20 06:45:38', 5, 0),
(3, 'Sangkar Kandang Large Burung Lovebird Kapsul Warna Merk Boom', 2, '', 'Kuning, Biru, Hitam', 'Diamter 30 cm, Tingg', 5000, 150000, 6, '<p>Kandang burung kapsul besi, biasa di pakai untuk burung&nbsp;Lovebird, Kenari, Parkit, Kacer, dll<br />\r\nbahan besi lebih tebal jari-jari lebih kuat tidak cepat karat,,<br />\r\nharga premium..<br />\r\n<br />\r\nukuran 30x60</p>\r\n\r\n<p>Haturnuhun terimaksi.<br />\r\nsalam kicau mania sejati,,</p>\r\n', 'produk2212221047321.jpg .png', '2023-01-20 06:51:17', 10, 0),
(4, 'Tangkringan Burung Nuri Kakatua Gantung', 4, '', 'Coklat', '40X40X40', 2000, 459500, 0, '<p>Dibuat dari Bahan berkualitas<br />\r\nKepuasan anda adalah kepuasan kami<br />\r\nJika ada kendala pada paket yang diterima , silahkan infokan ke kami sebelum memberi rating / ulasan</p>\r\n', 'produk2212221056231.jpg .png', '2023-01-20 04:33:48', 10, 0),
(5, '969 pion kandang burung lovebird gantungan fiber kandang asesoris ', 4, '', 'Putih Corak Hitam', '0', 300, 44000, 0, '<p>TERSEDIA<br />\r\n<br />\r\nPion sangat bagus dari motip dan warna sert bahan nya yang membuat kandang biasa terlihat kandang kelas atas<br />\r\nCat.. Hanya pion</p>\r\n', 'produk2212221100531.jpg .png', '2023-01-20 03:44:51', 0, 0),
(6, 'Klem kawat 1saset 3bh kawat asesoris jepitan kandang burung lovebird', 4, '', 'Hitam', '0', 750, 7000, 16, '<p>Klem kawat 1saset 3bh kawat asesoris jepitan kandang burung lovebird</p>\r\n\r\n<hr />\r\n<p>Nama Produk : <strong>KLEM KAWAT</strong><br />\r\nKategori : Aksesoris Burung<br />\r\nIsi : 1pcs -&gt; 3 biji</p>\r\n\r\n<hr />\r\n<p>klem atau penjepit tebok ini terdiri dari 3 buah dengan kawat tebal...</p>\r\n', 'produk2212221103551.jpg .png', '2023-01-20 06:53:29', 0, 0),
(7, 'Kenari Af Super Afs Rasa F1Ys Jantan Bunyi Gacor Banyak Pilihan', 1, '', 'Kuning', '0', 20, 525000, 0, '<p>KUALITAS DIJAMIN GACOR</p>\r\n', 'produk2212221111091.jpg .png', '2023-01-20 04:22:34', 15, 0),
(8, 'Burungmu', 1, '', 'Hijau', '12', 12, 120000, 63, '<p>asfasfasf</p>\r\n', 'produk2001230137581.jpg', '2023-01-20 06:51:54', 12, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `promo`
--

CREATE TABLE `promo` (
  `kd_promo` int(11) NOT NULL,
  `isi` longtext DEFAULT NULL,
  `kd_produk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `promo`
--

INSERT INTO `promo` (`kd_promo`, `isi`, `kd_produk`) VALUES
(1, '10', 1),
(17, '5', 2),
(18, '10', 1),
(19, '5', 2),
(20, '3', 3),
(21, '1', 4),
(22, '0', 5),
(23, '', 6),
(24, '1', 7),
(25, '100000', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening`
--

CREATE TABLE `rekening` (
  `kd_rekening` int(11) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `no_rek` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rekening`
--

INSERT INTO `rekening` (`kd_rekening`, `bank`, `no_rek`) VALUES
(1, 'BNI', '0230-077-532'),
(2, 'BCA', '7990-877-566'),
(3, 'BRI', '0034-755-532');

-- --------------------------------------------------------

--
-- Struktur dari tabel `testimoni`
--

CREATE TABLE `testimoni` (
  `kd_testimoni` int(11) NOT NULL,
  `kd_produk` int(11) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `isi_testimoni` mediumtext NOT NULL,
  `tgl_testimoni` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `userid` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `tipe` enum('Admin','Pelanggan') NOT NULL,
  `status` enum('Y','N') NOT NULL,
  `kode` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userid`, `password`, `tipe`, `status`, `kode`) VALUES
('hawari@gmail.com', 'hawari', 'Pelanggan', 'Y', '2627479936'),
('robba@gmail.com', 'robba', 'Pelanggan', 'Y', '5275859195'),
('satrio@gmail.com', '1234', 'Admin', 'Y', NULL),
('satriomimoho2@gmail.com', 'satrio5329', 'Pelanggan', 'Y', '1234');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `faktur`
--
ALTER TABLE `faktur`
  ADD PRIMARY KEY (`kd_faktur`);

--
-- Indeks untuk tabel `halaman`
--
ALTER TABLE `halaman`
  ADD PRIMARY KEY (`kd_halaman`);

--
-- Indeks untuk tabel `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`kd_inbox`);

--
-- Indeks untuk tabel `inbox_detail`
--
ALTER TABLE `inbox_detail`
  ADD PRIMARY KEY (`kd_inbox_detail`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kd_kategori`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`kd_kontak`);

--
-- Indeks untuk tabel `lap_labarugi`
--
ALTER TABLE `lap_labarugi`
  ADD PRIMARY KEY (`kd_laplabarugi`);

--
-- Indeks untuk tabel `lap_penjualan`
--
ALTER TABLE `lap_penjualan`
  ADD PRIMARY KEY (`kd_lappenjualan`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`email_plg`);

--
-- Indeks untuk tabel `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`kd_faktur`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`kd_penjualan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kd_produk`);

--
-- Indeks untuk tabel `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`kd_promo`);

--
-- Indeks untuk tabel `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`kd_rekening`);

--
-- Indeks untuk tabel `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`kd_testimoni`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `halaman`
--
ALTER TABLE `halaman`
  MODIFY `kd_halaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `inbox`
--
ALTER TABLE `inbox`
  MODIFY `kd_inbox` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `inbox_detail`
--
ALTER TABLE `inbox_detail`
  MODIFY `kd_inbox_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kd_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `kd_kontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `lap_labarugi`
--
ALTER TABLE `lap_labarugi`
  MODIFY `kd_laplabarugi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `lap_penjualan`
--
ALTER TABLE `lap_penjualan`
  MODIFY `kd_lappenjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `kd_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `kd_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `promo`
--
ALTER TABLE `promo`
  MODIFY `kd_promo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `rekening`
--
ALTER TABLE `rekening`
  MODIFY `kd_rekening` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `kd_testimoni` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
