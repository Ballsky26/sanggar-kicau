-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Des 2022 pada 16.12
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
('Satrio', 'Bendan', '08156673219', 'habib@gmail.com');

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
  `konfirm` enum('Sudah','Belum','Tunda') NOT NULL DEFAULT 'Belum',
  `bukti_transfer` varchar(100) DEFAULT NULL,
  `tgl_kirim` datetime DEFAULT NULL,
  `resi` tinytext DEFAULT NULL,
  `tgl_terima` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `faktur`
--

INSERT INTO `faktur` (`kd_faktur`, `userid`, `total_biaya_barang`, `tgl`, `pembayaran`, `kurir`, `lama_kirim`, `biaya_pengiriman`, `konfirm`, `bukti_transfer`, `tgl_kirim`, `resi`, `tgl_terima`) VALUES
(1664543756, 'satriomimoho2@gmail.com', 250000, '2022-09-30 13:15:56', 'Transfer', 'jne', '3-6', 8000, 'Belum', NULL, NULL, NULL, NULL),
(1669302738, 'salma@gmail.com', 300000, '2022-11-24 15:12:18', 'COD', 'Flanel', '2', 10000, 'Sudah', NULL, '2022-11-25 22:15:00', 'COD', NULL),
(1669305770, 'salma@gmail.com', NULL, '2022-11-24 16:02:50', 'Transfer', 'jne', NULL, NULL, 'Belum', NULL, NULL, NULL, NULL);

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
(1, 'produk1901180412541.jpg'),
(2, 'produk1901180422081.jpg'),
(2, 'produk1901180422082.jpg'),
(2, 'produk1901180422083.jpg'),
(3, 'produk2503180838081.jpg'),
(3, 'produk2503180838501.jpg'),
(3, 'produk2503180839151.jpg'),
(3, 'produk2503180839371.jpg'),
(5, 'produk2503180854201.jpg'),
(5, 'produk2503180854381.jpg'),
(5, 'produk2503180854561.jpg'),
(5, 'produk2503180855101.jpg'),
(6, 'produk2503180902321.jpg'),
(6, 'produk2503180902521.jpg'),
(6, 'produk2503180903061.jpg'),
(6, 'produk2503180904031.jpg'),
(7, 'produk2503180910271.jpg'),
(7, 'produk2503180910431.jpg'),
(7, 'produk2503180911001.jpg'),
(7, 'produk2503180911191.jpg'),
(9, 'produk2603181111381.jpg'),
(9, 'produk2603181111521.jpg'),
(9, 'produk2603181112071.jpg'),
(9, 'produk2603181112211.jpg'),
(10, 'produk2603181115291.jpg'),
(10, 'produk2603181115441.jpg'),
(10, 'produk2603181116011.jpg'),
(10, 'produk2603181116161.jpg'),
(11, 'produk2603181150341.jpg'),
(11, 'produk2603181151021.jpg'),
(11, 'produk2603181151191.jpg'),
(11, 'produk2603181151421.jpg'),
(12, 'produk2603181155551.jpg'),
(12, 'produk2603181156131.jpg'),
(12, 'produk2603181156331.jpg'),
(12, 'produk2603181156571.jpg'),
(12, 'produk2603181157151.jpg'),
(4, 'produk3009220847501.jpg'),
(13, 'produk2411220916091.jpg'),
(13, 'produk2411221053281.jpg'),
(14, 'produk2511220925361.jpg');

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
(3, 'Tentang', '<p>Sanggar Kicau merupakan toko yang menjual berbagai jenis burung, aksesoris burung, pakan burung, sangkar burung dan lain sebagainya.</p>\r\n', 'arie@gmail.com');

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
(1, 'budi@gmail.com', 'Orderan', 'Admin');

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
(1, 1, 'budi@gmail.com', 'Orderan saya sudah dikirim belum ya?', '2018-01-18 21:39:11', 'R');

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
(13, 'Burung'),
(15, 'Sangkar Burung'),
(16, 'Pakan Burung'),
(17, 'Aksesoris Burung');

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

--
-- Dumping data untuk tabel `lap_labarugi`
--

INSERT INTO `lap_labarugi` (`kd_laplabarugi`, `kd_penjualan`, `total_beli`, `total_jual`, `laba_rugi`) VALUES
(1, 1516311357, 2, 250000, 1),
(2, 1516311413, 1, 210000, 1);

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

--
-- Dumping data untuk tabel `lap_penjualan`
--

INSERT INTO `lap_penjualan` (`kd_lappenjualan`, `kd_penjualan`, `kd_produk`, `jml_beli`, `total`) VALUES
(1, 1516311357, 2, 250000, 1),
(2, 1516311413, 1, 210000, 1),
(3, 1521724670, 6, 165000, 1),
(4, 1521944737, 7, 134000, 1);

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
('AHMAD YANI', 'JL. DENPASAR NO.45 SEMARANG BARAT', 10, 398, 54222, '08194567888', 'ahmad@gmail.com'),
('M. Akmal Fahmi', 'JL. CEMPAKA NO. 28A PEKALONGAN', 10, 348, 51133, '8156956278', 'akmal@gmail.com'),
('Ali Zaenal Abidin', 'Jalan Singkarak No.10 Kauman Pekalongan', 10, 348, 51128, '8157607305', 'alizaenal@gmail.com'),
('Ani Werdaya', 'Jl. Bebas Tulis Rt.02/02 No.04 Kraton Lor', 10, 348, 51145, '085640000001', 'ani@gmail.com'),
('M. Arda Farhani', 'JL. SUTAN SYAHRIR NO. 3 PEKALONGAN', 10, 348, 51134, '85842299242', 'arda@gmail.com'),
('M. Arvyanda Dava Sangga P.', 'WIRSARI 2 JL. SUNAN GUNUNG JATI NO. 8 BATANG', 10, 348, 51135, '85742744834', 'arvyanda@gmail.com'),
('Muhammad Ashlih Zurya', 'JL. HAYAM WURUK PESINDON I/221 PEKALONGAN', 10, 348, 51144, '85712947666', 'ashlih@gmail.com'),
('Azka Zirly Aulia Rahman', 'JL. TERATAI GG. 5 NO. 38 PEKALONGAN', 10, 348, 51129, '87832586175', 'azka@gmail.com'),
('Budi Santosa', 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 10, 348, 51145, '085640000002', 'budi@gmail.com'),
('Muchammad Dalil Adnan', 'PONCOL GG. 4 ANGGERK NO. 58 PEKALONGAN', 10, 348, 51141, '85869031882', 'dalil@gmail.com'),
('Achmad Ezra Saquelle DJ', 'PESINDON GG.1/17 PEKALONGAN', 10, 348, 51127, '87830630410', 'ezra@gmail.com'),
('M. Farda Iyad Robbani', 'PONCOL GG. KATALIA 24C PEKALONGAN', 10, 348, 51136, '816677905', 'farda@gmail.com'),
('Fariq Kholish', 'NOYONTAAN GG. 15A NO.16', 10, 348, 51130, '81548074103', 'fariq@gmail.com'),
('Ghulam Muhammad', 'JL. CEMPAKA NO. 68 PEKALONGAN', 10, 348, 51131, '81542003941', 'ghulam@gmail.com'),
('M. Hawari Nusantara Azizi', 'Jl. Kanfer  4 No.134 Perum Slamaran Pekalongan', 10, 348, 51137, '82325785959', 'hawari@gmail.com'),
('Muchammad Heydar Ali Yusuf', 'Jl. Raya Pringgosari No.109 Kalibanger Sokorejo', 10, 348, 51142, '81325655765', 'heydar@gmail.com'),
('Ibni Zakii', 'JL. ULIN 4/9 PERUM SLAMARAN', 10, 348, 51132, '8156909910', 'ibnii@gmail.com'),
('Dwi Lestari', 'Jl. Bahagia No.67 purwokerto', 10, 41, 45671, '0822225467', 'lestari@gmail.com'),
('Mohammad Majdan', 'JL. KARTINI GG. 5 NO. 10 PEKALONGAN', 10, 348, 51139, '85865520021', 'majdan@gmail.com'),
('Primadina Zahrani', 'JL. PEMUDA GG. 32 RT. 01 RW. 07 KAUMAN', 10, 348, 51120, '811278885', 'prima@gmail.com'),
('Razita Zarli Marsya', 'KRAPYAK KIDUL GG. V NO. 79 PEKALONGAN', 10, 348, 51114, '85865495471', 'razita@gmail.com'),
('Rizky Novia Fitri', 'SLAMARAN PEKALONGAN', 10, 348, 51121, '87857993060', 'rizky@gmail.com'),
('Salma Diena Syakira', 'JL. HAYAMWURUK PESINDON GG. I PEKALONGAN', 10, 348, 51122, '8164886437', 'salma@gmail.com'),
('Mohammad Sammy Hibban Ardia', 'PESINDON GG. 1 NO. 3 RT.05 RW.13 PEKALONGAN', 10, 348, 51140, '85869167742', 'sammy@gmail.com'),
('mochammad satrio utomo', 'pekalongan', 10, 348, 5111, '08156673219', 'satriomimoho2@gmail.com'),
('Shafira Az Zahra', 'Pondok Sriwijaya Jl. Mutiara 22 Podosugih Pekalongan', 10, 348, 51123, '817432255', 'shafira@gmail.com'),
('Sofia Sanabila', 'JL. TRAPESIUM II NO. 13 LIMAS PEKALONGAN', 10, 348, 51124, '87733327888', 'sofia@gmail.com'),
('Syahar Banu', 'JL. TERATE KLEGO GG. 4 PEKALONGAN', 10, 348, 51125, '85866636383', 'syahar@gmail.com'),
('Muhamad Taqi', 'JL. TOBA II/21 PEKALONGAN', 10, 348, 51143, '8156594953', 'taqi@gmail.com'),
('M. Yoga Ardhian Maulana', 'Desa Menguneng Rt 02/01 Warungasem Batang', 10, 348, 51138, '85869286969', 'yoga@gmail.com'),
('Yusmar Amelia Solekha', 'KRAPYAK KIDUL GG. V NO. 77A PEKALONGAN', 10, 348, 51126, '85786230975', 'yusmar@gmail.com');

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
(0, 'Budi Santosa', 10, 348, 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 51145, '085640000002'),
(1516311357, 'Budi Santosa', 10, 348, 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 51145, '085640000002'),
(1516311413, 'Budi Santosa', 10, 348, 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 51145, '085640000002'),
(1521721490, 'AHMAD YANI', 10, 398, 'JL. DENPASAR NO.45 SEMARANG BARAT', 54222, '08194567888'),
(1521724670, 'Budi Santosa', 10, 348, 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 51145, '085640000002'),
(1521944737, 'Budi Santosa', 10, 348, 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 51145, '085640000002'),
(1521945503, 'Budi Santosa', 10, 348, 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 51145, '085640000002'),
(1521998843, 'Budi Santosa', 10, 348, 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 51145, '085640000002'),
(1522035512, 'Budi Santosa', 10, 348, 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 51145, '085640000002'),
(1539752537, 'Budi Santosa', 10, 348, 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 51145, '085640000002'),
(1539769399, 'Budi Santosa', 10, 348, 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 51145, '085640000002'),
(1551934726, 'Budi Santosa', 10, 348, 'Jl. Bebas Tulis Rt.01/01 No.01 Kraton Lor', 51145, '085640000002'),
(1664543756, 'mochammad satrio utomo', 10, 348, 'pekalongan', 5111, '08156673219'),
(1669302738, 'Salma Diena Syakira', 10, 348, 'JL. HAYAMWURUK PESINDON GG. I PEKALONGAN', 51122, '8164886437');

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
(1, 1516311357, 2, 250000, 1),
(2, 1516311413, 1, 210000, 1),
(3, 1521724670, 6, 165000, 1),
(4, 1521944737, 7, 134000, 1),
(5, 1521945503, 4, 240000, 1),
(6, 1522035512, 11, 240000, 1),
(7, 1521998843, 9, 195000, 1),
(8, 1539769399, 1, 168000, 1);

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
(13, 'Pakan Manuk', 16, '', 'Hijau', '12', 1222, 15000, 31, '<p>Pakan Manuk Berkualitas dan murah BANGET</p>\r\n', 'produk2411220916091.jpg', '2022-11-24 15:53:28', 23, 0),
(14, 'Pakan Manuk 2', 16, '', 'afsafasf', '1221', 122, 5000, 12, '<p>sfdsfdsfdsa</p>\r\n', 'produk2511220925361.jpg', '2022-11-25 14:26:07', 12, 0);

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
(1, '', 1),
(2, '', 2),
(3, '0', 3),
(4, '0', 4),
(5, '0', 5),
(6, '0', 6),
(7, '0', 7),
(8, '0', 8),
(9, '0', 9),
(10, '0', 10),
(11, '0', 11),
(12, '0', 12),
(13, '10000', 13),
(14, '10000', 13),
(15, '4222', 14);

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
(5, 'BNI', '0400-288-470');

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
('ahmad@gmail.com', 'ahmad', 'Pelanggan', 'Y', NULL),
('akmal@gmail.com', 'akmal', 'Pelanggan', 'Y', NULL),
('alizaenal@gmail.com', 'alizaenal', 'Pelanggan', 'Y', NULL),
('ani@gmail.com', 'ani', 'Pelanggan', 'Y', NULL),
('arda@gmail.com', 'arda', 'Pelanggan', 'Y', NULL),
('arvyanda@gmail.com', 'arvyanda', 'Pelanggan', 'Y', NULL),
('ashlih@gmail.com', 'ashlih', 'Pelanggan', 'Y', NULL),
('azka@gmail.com', 'azka', 'Pelanggan', 'Y', NULL),
('budi@gmail.com', 'budi', 'Pelanggan', 'Y', NULL),
('dalil@gmail.com', 'dalil', 'Pelanggan', 'Y', NULL),
('ezra@gmail.com', 'ezra', 'Pelanggan', 'Y', NULL),
('farda@gmail.com', 'farda', 'Pelanggan', 'Y', NULL),
('fariq@gmail.com', 'fariq', 'Pelanggan', 'Y', NULL),
('ghulam@gmail.com', 'ghulam', 'Pelanggan', 'Y', NULL),
('habib@gmail.com', '1234', 'Admin', 'Y', NULL),
('hawari@gmail.com', 'hawari', 'Pelanggan', 'Y', NULL),
('heydar@gmail.com', 'heydar', 'Pelanggan', 'Y', NULL),
('ibnii@gmail.com', 'ibnii', 'Pelanggan', 'Y', NULL),
('lestari@gmail.com', 'lestari', 'Pelanggan', 'Y', NULL),
('majdan@gmail.com', 'majdan', 'Pelanggan', 'Y', NULL),
('prima@gmail.com', 'prima', 'Pelanggan', 'Y', NULL),
('razita@gmail.com', 'razita', 'Pelanggan', 'Y', NULL),
('rizky@gmail.com', 'rizky', 'Pelanggan', 'Y', NULL),
('salma@gmail.com', 'salma', 'Pelanggan', 'Y', NULL),
('sammy@gmail.com', 'sammy', 'Pelanggan', 'Y', NULL),
('satriomimoho2@gmail.com', 'satrio5329', 'Pelanggan', 'Y', '7253073679'),
('shafira@gmail.com', 'shafira', 'Pelanggan', 'Y', NULL),
('sofia@gmail.com', 'sofia', 'Pelanggan', 'Y', NULL),
('syahar@gmail.com', 'syahar', 'Pelanggan', 'Y', NULL),
('taqi@gmail.com', 'taqi', 'Pelanggan', 'Y', NULL),
('yoga@gmail.com', 'yoga', 'Pelanggan', 'Y', NULL),
('yusmar@gmail.com', 'yusmar', 'Pelanggan', 'Y', NULL);

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
  MODIFY `kd_inbox_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `kd_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `kd_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `promo`
--
ALTER TABLE `promo`
  MODIFY `kd_promo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
