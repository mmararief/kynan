-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2024 at 06:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kynan`
--

-- --------------------------------------------------------

--
-- Table structure for table `detailtransaksi`
--

CREATE TABLE `detailtransaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detailtransaksi`
--

INSERT INTO `detailtransaksi` (`id_detail`, `id_transaksi`, `id_produk`, `jumlah`, `harga`, `subtotal`) VALUES
(12, 8, 27, 1, 50000.00, 50000.00),
(28, 17, 26, 2, 20000.00, 40000.00),
(29, 17, 5, 3, 100000.00, 300000.00),
(30, 18, 25, 1, 5000.00, 5000.00),
(31, 19, 26, 1, 20000.00, 20000.00),
(32, 19, 24, 1, 1000.00, 1000.00),
(33, 19, 23, 1, 5000.00, 5000.00),
(34, 19, 15, 1, 5000.00, 5000.00),
(35, 19, 4, 1, 5000.00, 5000.00);

-- --------------------------------------------------------

--
-- Table structure for table `identitas`
--

CREATE TABLE `identitas` (
  `id` int(11) NOT NULL,
  `logo` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `an` varchar(191) NOT NULL,
  `bank` varchar(191) NOT NULL,
  `rekening` varchar(191) NOT NULL,
  `hp` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `pajak` varchar(191) NOT NULL,
  `jasa` varchar(191) NOT NULL,
  `alamat` varchar(191) NOT NULL,
  `map` varchar(191) NOT NULL,
  `ig` varchar(191) NOT NULL,
  `dev` varchar(191) NOT NULL,
  `wa` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `identitas`
--

INSERT INTO `identitas` (`id`, `logo`, `title`, `an`, `bank`, `rekening`, `hp`, `email`, `pajak`, `jasa`, `alamat`, `map`, `ig`, `dev`, `wa`) VALUES
(1, 'logo kynan.png', 'Dapur Kynan', 'Dapur Kynan', 'Bank Mandiri', '1670001843779', '081233245579', 'kynan@gmail.com', '', '', 'Jl. Pakis 8C No. 3 Blok BB11, RT.006/RW.012, Pekayon Jaya, Kec. Bekasi Selatan, Kota Bekasi, Jawa Barat 17148', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6124.59535975474!2d106.9613255!3d-6.2622594!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698d73d186319d%3A0x7a781b706b80dd5c!2sDapur', 'https://www.instagram.com/dapur.kynan/', 'Dapur Kynan', 'https://api.whatsapp.com/send?phone=6281233245579');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(191) NOT NULL,
  `tgl_input` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `tgl_input`) VALUES
(1, 'Cake dan Roti', '28 April 2024, 23:57'),
(8, 'Cemilan', '16 May 2024, 13:15'),
(9, 'Healthy Drink', '16 May 2024, 13:15'),
(10, 'Sambal dan Bumbu', '16 May 2024, 13:15'),
(12, 'Minuman', '16 May 2024, 13:17');

-- --------------------------------------------------------

--
-- Table structure for table `landingpage`
--

CREATE TABLE `landingpage` (
  `id` int(11) NOT NULL,
  `title` varchar(191) NOT NULL,
  `subtitle` varchar(191) NOT NULL,
  `prom` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landingpage`
--

INSERT INTO `landingpage` (`id`, `title`, `subtitle`, `prom`) VALUES
(1, 'Dapur kynan', 'Temani Harimu dengan Cemilan Istimewa', 'Berbagai macam cemilan homemade dari bahan pilihan hadir disini');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `nama_pengguna` varchar(191) NOT NULL,
  `username` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `level` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `nama_pengguna`, `username`, `password`, `level`) VALUES
(1, 'Kynan', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_produk` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL,
  `gambar` varchar(191) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `hpp` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `status`, `gambar`, `harga_jual`, `hpp`) VALUES
(1, 1, 'Bolu Pelangi', 'PO', '1715091332.png', 50000.00, 40000.00),
(2, 1, 'Marmer Cake', 'Tidak PO', '1715091561.png', 10000.00, 8000.00),
(3, 1, 'CurryPuff Isi 10', 'PO', '1715090407.png', 45000.00, 36000.00),
(4, 1, 'Curry Puff', 'PO', '1715090462.png', 5000.00, 4000.00),
(5, 1, 'Vanilla cream puff', 'Tidak PO', '1715090496.png', 100000.00, 80000.00),
(6, 1, 'Roti sisir', 'Tidak PO', '1715090541.png', 10000.00, 8000.00),
(7, 1, 'Roti goreng isi daging', 'PO', '1715090565.png', 30000.00, 24000.00),
(8, 1, 'Roti goreng kacang hijau', 'Tidak PO', '1715784533.png', 15000.00, 12000.00),
(13, 8, 'Bongko pisang', 'PO', '1715858480.png', 30000.00, 24000.00),
(14, 8, 'Bubur sumsum', 'Tidak PO', '1715858521.png', 3000.00, 2400.00),
(15, 8, 'Lapis Pelangi', 'Tidak PO', '1715858538.png', 5000.00, 4000.00),
(16, 8, 'Pukis', 'Tidak PO', '1715858605.png', 4000.00, 3200.00),
(17, 8, 'Ketan serundeng', 'Tidak PO', '1715858649.png', 6000.00, 4800.00),
(19, 8, 'Arem arem mie', 'Tidak PO', '1715858782.png', 30000.00, 24000.00),
(20, 8, 'Risol mlepuh', 'PO', '1715858820.png', 2000.00, 1600.00),
(21, 8, 'Pastel bihun', 'PO', '1715858843.png', 3000.00, 2400.00),
(22, 8, 'Lumpia Semarang', 'Tidak PO', '1715858878.png', 10000.00, 8000.00),
(23, 8, 'Sosis solo', 'Tidak PO', '1715858921.png', 5000.00, 4000.00),
(24, 8, 'Sempol ayam', 'Tidak PO', '1715858939.png', 1000.00, 800.00),
(25, 8, 'peyek kacang dan rebon', 'Tidak PO', '1715858954.png', 5000.00, 4000.00),
(26, 8, 'mac n cheese', 'PO', '1715858970.png', 20000.00, 16000.00),
(27, 9, 'kunyit asemm', 'PO', '1715858990.png', 50000.00, 40000.00),
(28, 10, 'sambal cumi baby', 'PO', '1715859009.png', 60000.00, 48000.00);

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `id` int(11) NOT NULL,
  `nama_bank` varchar(191) NOT NULL,
  `no_rekening` varchar(191) NOT NULL,
  `nama_pemilik` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`id`, `nama_bank`, `no_rekening`, `nama_pemilik`) VALUES
(1, 'BCA', '3431108079', 'Arie Sutrisno'),
(2, 'Mandiri', '1670001843779', 'Arie Sutrisno'),
(3, 'BSI', '7124518258', 'Arie Sutrisno');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tanggal` datetime(3) NOT NULL,
  `via` varchar(191) NOT NULL,
  `nama` varchar(191) NOT NULL,
  `whatsapp` varchar(191) NOT NULL,
  `alamat` varchar(191) DEFAULT NULL,
  `metode_pembayaran` varchar(191) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tanggal`, `via`, `nama`, `whatsapp`, `alamat`, `metode_pembayaran`, `total`, `status`) VALUES
(8, '2024-07-22 20:48:05.000', 'Online', 'ammar', '628872588744', 'asdasd', 'BCA - 3431108079 - Arie Sutrisno', 50000.00, 'Selesai'),
(17, '2024-06-12 00:00:00.000', 'online', 'Sukirman', '628872588744', 'Prima', 'BCA', 340000.00, 'Selesai'),
(18, '2024-07-23 18:56:36.000', 'Online', 'adila', '6285711778593', 'Duta', 'Mandiri - 1670001843779 - Arie Sutrisno', 5000.00, 'Selesai'),
(19, '2024-07-23 19:03:44.000', 'Online', 'Slamet', '6285711778593', 'Jakarta selatan', 'BCA - 3431108079 - Arie Sutrisno', 36000.00, 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `_prisma_migrations`
--

CREATE TABLE `_prisma_migrations` (
  `id` varchar(36) NOT NULL,
  `checksum` varchar(64) NOT NULL,
  `finished_at` datetime(3) DEFAULT NULL,
  `migration_name` varchar(255) NOT NULL,
  `logs` text DEFAULT NULL,
  `rolled_back_at` datetime(3) DEFAULT NULL,
  `started_at` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `applied_steps_count` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `_prisma_migrations`
--

INSERT INTO `_prisma_migrations` (`id`, `checksum`, `finished_at`, `migration_name`, `logs`, `rolled_back_at`, `started_at`, `applied_steps_count`) VALUES
('27926202-2b88-4d51-aad6-dd4044bec41e', '0862e3a76501d54d181e0fa529bb39dc7a4e509026d588571f5d987da040948a', '2024-07-23 08:12:43.537', '20240715101215_init', NULL, NULL, '2024-07-23 08:12:43.523', 1),
('3e162427-92bb-42a8-af98-fd033d54347c', '9af3acfc0f7507868be25b292619724e2a71384f4b8c67ae9e9b5cc203bd3910', '2024-07-23 08:12:43.708', '20240722175901_init', NULL, NULL, '2024-07-23 08:12:43.637', 1),
('7928c3dd-676c-4d12-a128-5b48c9febba7', 'a775f6eb0252e58a24bf81bf84c1fcfa173a11e797f45a624c7ed22019e59afb', '2024-07-23 08:12:44.203', '20240723081244_make_hpp_nullable', NULL, NULL, '2024-07-23 08:12:44.173', 1),
('df2f40ac-986e-4dea-8b16-18317fa6f620', '1d950cda033f1ffec91c2657f7a2286d3b79785976cd371f90035c2785a5888e', '2024-07-23 08:12:43.635', '20240715103426_baru', NULL, NULL, '2024-07-23 08:12:43.538', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detailtransaksi`
--
ALTER TABLE `detailtransaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `DetailTransaksi_id_transaksi_fkey` (`id_transaksi`),
  ADD KEY `DetailTransaksi_id_produk_fkey` (`id_produk`);

--
-- Indexes for table `identitas`
--
ALTER TABLE `identitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `landingpage`
--
ALTER TABLE `landingpage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `Produk_id_kategori_fkey` (`id_kategori`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `_prisma_migrations`
--
ALTER TABLE `_prisma_migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detailtransaksi`
--
ALTER TABLE `detailtransaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `identitas`
--
ALTER TABLE `identitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `landingpage`
--
ALTER TABLE `landingpage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailtransaksi`
--
ALTER TABLE `detailtransaksi`
  ADD CONSTRAINT `DetailTransaksi_id_produk_fkey` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON UPDATE CASCADE,
  ADD CONSTRAINT `DetailTransaksi_id_transaksi_fkey` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `Produk_id_kategori_fkey` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
