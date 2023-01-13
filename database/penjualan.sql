-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2023 at 08:24 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `nama_admin` varchar(50) NOT NULL,
  `alamat_admin` text NOT NULL,
  `tlp_admin` varchar(13) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`nama_admin`, `alamat_admin`, `tlp_admin`, `email`) VALUES
('Satrio', 'Bendan', '08156673219', 'satrio@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `faktur`
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
  `konfirm` enum('Sudah','Belum','Tunda') NOT NULL DEFAULT 'Belum',
  `bukti_transfer` varchar(100) DEFAULT NULL,
  `tgl_kirim` datetime DEFAULT NULL,
  `resi` tinytext DEFAULT NULL,
  `tgl_terima` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faktur`
--

INSERT INTO `faktur` (`kd_faktur`, `userid`, `total_biaya_barang`, `tgl`, `pembayaran`, `kurir`, `lama_kirim`, `biaya_pengiriman`, `konfirm`, `bukti_transfer`, `tgl_kirim`, `resi`, `tgl_terima`) VALUES
(1670731740, 'robba@gmail.com', 270000, '2022-12-11 04:09:00', 'Transfer', 'jne', '3-6', 8000, 'Sudah', '1670731740.jpg', '2022-12-14 13:11:00', '12345678', '2022-12-11 11:16:05'),
(1671539854, 'robba@gmail.com', 270000, '2022-12-20 12:37:34', 'Transfer', 'jnt', '3-6', 8000, 'Belum', NULL, NULL, NULL, NULL),
(1671624257, 'hawari@gmail.com', 270000, '2022-12-21 12:04:17', 'COD', 'sanggar kicau', '2', 10000, 'Sudah', NULL, '2022-12-22 22:10:00', 'COD', '2022-12-21 07:10:53'),
(1671624633, 'hawari@gmail.com', 270000, '2022-12-21 12:10:33', 'Transfer', 'jne', '3-6', 8000, 'Sudah', '1671624633.jpg', '2022-12-22 23:19:00', '122333445566', NULL),
(1673122327, 'hawari@gmail.com', 135000, '2023-01-07 20:12:07', 'Transfer', 'jne', '3-6', 40000, 'Tunda', NULL, NULL, NULL, NULL),
(1673578974, 'hawari@gmail.com', 1350000, '2023-01-13 03:02:54', 'Transfer', 'jne', '3-6', 8000, 'Sudah', '1673578974.jpg', '2023-01-13 10:08:00', '999i99999', NULL),
(1673579122, 'hawari@gmail.com', 446250, '2023-01-13 03:05:22', 'Transfer', 'jne', '3-6', 8000, 'Tunda', NULL, NULL, NULL, NULL),
(1673580945, 'hawari@gmail.com', 7000, '2023-01-13 03:35:45', 'Transfer', 'jne', '3-6', 8000, 'Tunda', NULL, NULL, NULL, NULL),
(1673581060, 'hawari@gmail.com', 14000, '2023-01-13 03:37:40', 'Transfer', 'jne', '3-6', 16000, 'Tunda', NULL, NULL, NULL, NULL),
(1673582002, 'hawari@gmail.com', 446250, '2023-01-13 03:53:22', 'Transfer', 'jne', '3-6', 8000, 'Belum', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `foto_produk`
--

CREATE TABLE `foto_produk` (
  `kd_produk` int(11) NOT NULL,
  `foto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foto_produk`
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
(7, 'produk2212221111091.jpg .png');

-- --------------------------------------------------------

--
-- Table structure for table `halaman`
--

CREATE TABLE `halaman` (
  `kd_halaman` int(11) NOT NULL,
  `nama_halaman` text NOT NULL,
  `isi_halaman` longtext NOT NULL,
  `admin` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `halaman`
--

INSERT INTO `halaman` (`kd_halaman`, `nama_halaman`, `isi_halaman`, `admin`) VALUES
(1, 'Tentang', '<p>Sanggar Kicau merupakan toko yang menjual berbagai jenis burung, aksesoris burung, pakan burung, sangkar burung dan lain sebagainya.</p>\r\n', 'satrio@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `kd_inbox` int(11) NOT NULL,
  `pengirim` varchar(30) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `tujuan` enum('Admin','Pelanggan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inbox`
--

INSERT INTO `inbox` (`kd_inbox`, `pengirim`, `judul`, `tujuan`) VALUES
(1, 'hawari@gmail.com', 'Pesanan Sudah dikirim', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `inbox_detail`
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
-- Dumping data for table `inbox_detail`
--

INSERT INTO `inbox_detail` (`kd_inbox_detail`, `kd_inbox`, `userid`, `pesan`, `tgl`, `status`) VALUES
(2, 1, 'hawari@gmail.com', 'Sangat memuaskan\r\nPengirimannya cepat', '2022-12-21 13:46:11', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kd_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kd_kategori`, `nama_kategori`) VALUES
(1, 'Burung'),
(2, 'Sangkar Burung'),
(3, 'Pakan Burung'),
(4, 'Aksesoris Burung');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `kd_kontak` int(11) NOT NULL,
  `kontak` varchar(30) NOT NULL,
  `isi_kontak` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`kd_kontak`, `kontak`, `isi_kontak`) VALUES
(2, 'SMS (Only)', '0857 4337 1776'),
(3, 'Telepon', '0285 427 313'),
(4, 'Email', 'sanggar.kicau@gmail.com'),
(5, 'Instagram', '@sanggar.kicaupkl');

-- --------------------------------------------------------

--
-- Table structure for table `lap_labarugi`
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
-- Table structure for table `lap_penjualan`
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
-- Table structure for table `pelanggan`
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
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`nama_plg`, `alamat_plg`, `kd_provinsi`, `kd_kota`, `kodepos_plg`, `tlp_plg`, `email_plg`) VALUES
('Muhammad Hawari', 'Pekalongan', 10, 348, 51113, '0815673219', 'hawari@gmail.com'),
('Muhammad Robba Maulana', 'Jl. KHM Mansur Kergon Gg. 04 Pekalongan', 10, 348, 5111, '085867236412', 'robba@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
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
-- Dumping data for table `pengiriman`
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
(1673582002, 'Muhammad Hawari', 10, 348, 'Pekalongan', 51113, '0815673219');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `kd_penjualan` int(11) NOT NULL,
  `kd_faktur` int(30) NOT NULL,
  `kd_produk` int(11) NOT NULL,
  `harga_produk` double NOT NULL,
  `jml_beli` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`kd_penjualan`, `kd_faktur`, `kd_produk`, `harga_produk`, `jml_beli`) VALUES
(14, 1669464680, 1, 169999.15, 1),
(15, 1670452243, 2, 11400, 5),
(16, 1670731740, 1, 270000, 1),
(22, 1671624257, 1, 270000, 1),
(23, 1671624633, 1, 270000, 1),
(24, 1671539854, 3, 135000, 1),
(25, 1673122327, 3, 135000, 1),
(26, 1673578974, 1, 270000, 5),
(27, 1673579122, 7, 446250, 1),
(28, 1673580945, 6, 7000, 1),
(29, 1673581060, 6, 7000, 2),
(30, 1673582002, 7, 446250, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
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
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`kd_produk`, `nama_produk`, `kd_kategori`, `kondisi`, `warna`, `ukuran`, `berat`, `harga`, `stok`, `deskripsi`, `foto`, `tgl_produk`, `diskon`, `hargabeli`) VALUES
(1, 'Burung Love Bird Sepasang', 1, '', 'Biru, Putih', '0', 40, 300000, 0, '', 'produk1112221107461.jpg .png', '2023-01-13 03:03:26', 10, 0),
(2, 'VOER BURUNG TOP SONG TOPSONG COKLAT', 3, '', 'Coklat', '0', 550, 12000, 30, '<p>Deskripsi pur top song / top song coklat makanan burung murai jalak c.ijo trucuk anis<br />\r\n<br />\r\n<strong>Top Song Coklat</strong><br />\r\n<br />\r\nMakanan Burung merk Top song 3 in 1, diracik agar pencernaan burung kesayangan anda lebih lancar dan sehat. Apalagi dengan ekstra madu dan telor yang diramu khusus agar burung kesayangan rajin berkicau.</p>\r\n', 'produk2212221034461.jpg .png', '2022-12-22 15:37:21', 5, 0),
(3, 'Sangkar Kandang Large Burung Lovebird Kapsul Warna Merk Boom', 2, '', 'Kuning, Biru, Hitam', 'Diamter 30 cm, Tingg', 5000, 150000, 15, '<p>Kandang burung kapsul besi, biasa di pakai untuk burung&nbsp;Lovebird, Kenari, Parkit, Kacer, dll<br />\r\nbahan besi lebih tebal jari-jari lebih kuat tidak cepat karat,,<br />\r\nharga premium..<br />\r\n<br />\r\nukuran 30x60</p>\r\n\r\n<p>Haturnuhun terimaksi.<br />\r\nsalam kicau mania sejati,,</p>\r\n', 'produk2212221047321.jpg .png', '2023-01-07 20:12:14', 10, 0),
(4, 'Tangkringan Burung Nuri Kakatua Gantung', 4, '', 'Coklat', '40X40X40', 2000, 459500, 3, '<p>Dibuat dari Bahan berkualitas<br />\r\nKepuasan anda adalah kepuasan kami<br />\r\nJika ada kendala pada paket yang diterima , silahkan infokan ke kami sebelum memberi rating / ulasan</p>\r\n', 'produk2212221056231.jpg .png', '2022-12-22 15:56:23', 10, 0),
(5, '969 pion kandang burung lovebird gantungan fiber kandang asesoris ', 4, '', 'Putih Corak Hitam', '0', 300, 44000, 6, '<p>TERSEDIA<br />\r\n<br />\r\nPion sangat bagus dari motip dan warna sert bahan nya yang membuat kandang biasa terlihat kandang kelas atas<br />\r\nCat.. Hanya pion</p>\r\n', 'produk2212221100531.jpg .png', '2022-12-22 16:00:53', 0, 0),
(6, 'Klem kawat 1saset 3bh kawat asesoris jepitan kandang burung lovebird', 4, '', 'Hitam', '0', 750, 7000, 32, '<p>Klem kawat 1saset 3bh kawat asesoris jepitan kandang burung lovebird</p>\r\n\r\n<hr />\r\n<p>Nama Produk : <strong>KLEM KAWAT</strong><br />\r\nKategori : Aksesoris Burung<br />\r\nIsi : 1pcs -&gt; 3 biji</p>\r\n\r\n<hr />\r\n<p>klem atau penjepit tebok ini terdiri dari 3 buah dengan kawat tebal...</p>\r\n', 'produk2212221103551.jpg .png', '2023-01-13 03:37:41', 0, 0),
(7, 'Kenari Af Super Afs Rasa F1Ys Jantan Bunyi Gacor Banyak Pilihan', 1, '', 'Kuning', '0', 20, 525000, 3, '<p>KUALITAS DIJAMIN GACOR</p>\r\n', 'produk2212221111091.jpg .png', '2023-01-13 03:53:30', 15, 0);

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `kd_promo` int(11) NOT NULL,
  `isi` longtext DEFAULT NULL,
  `kd_produk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promo`
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
(24, '1', 7);

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `kd_rekening` int(11) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `no_rek` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`kd_rekening`, `bank`, `no_rek`) VALUES
(1, 'BNI', '0230-077-532'),
(2, 'BCA', '7990-877-566'),
(3, 'BRI', '0034-755-532');

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `tipe` enum('Admin','Pelanggan') NOT NULL,
  `status` enum('Y','N') NOT NULL,
  `kode` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
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
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `faktur`
--
ALTER TABLE `faktur`
  ADD PRIMARY KEY (`kd_faktur`);

--
-- Indexes for table `halaman`
--
ALTER TABLE `halaman`
  ADD PRIMARY KEY (`kd_halaman`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`kd_inbox`);

--
-- Indexes for table `inbox_detail`
--
ALTER TABLE `inbox_detail`
  ADD PRIMARY KEY (`kd_inbox_detail`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kd_kategori`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`kd_kontak`);

--
-- Indexes for table `lap_labarugi`
--
ALTER TABLE `lap_labarugi`
  ADD PRIMARY KEY (`kd_laplabarugi`);

--
-- Indexes for table `lap_penjualan`
--
ALTER TABLE `lap_penjualan`
  ADD PRIMARY KEY (`kd_lappenjualan`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`email_plg`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`kd_faktur`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`kd_penjualan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kd_produk`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`kd_promo`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`kd_rekening`);

--
-- Indexes for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`kd_testimoni`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `halaman`
--
ALTER TABLE `halaman`
  MODIFY `kd_halaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `kd_inbox` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inbox_detail`
--
ALTER TABLE `inbox_detail`
  MODIFY `kd_inbox_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kd_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `kd_kontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lap_labarugi`
--
ALTER TABLE `lap_labarugi`
  MODIFY `kd_laplabarugi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lap_penjualan`
--
ALTER TABLE `lap_penjualan`
  MODIFY `kd_lappenjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `kd_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `kd_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `kd_promo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `kd_rekening` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `kd_testimoni` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
