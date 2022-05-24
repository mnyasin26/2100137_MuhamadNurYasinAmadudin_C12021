-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2022 at 06:52 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `praktikum_tp7`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_databuku`
--

CREATE TABLE `t_databuku` (
  `id_databuku` int(11) NOT NULL,
  `judul_buku` varchar(100) NOT NULL,
  `kategori_buku` varchar(100) NOT NULL,
  `nama_penulis` varchar(100) NOT NULL,
  `tahun_terbit` varchar(10) NOT NULL,
  `image` varchar(256) NOT NULL,
  `id_akun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_databuku`
--

INSERT INTO `t_databuku` (`id_databuku`, `judul_buku`, `kategori_buku`, `nama_penulis`, `tahun_terbit`, `image`, `id_akun`) VALUES
(1, 'Bumi', 'Novel', 'Tere Liye', '2022', 'dummy.jpg', 2),
(2, 'Bulan', 'Novel', 'Tere Liye', '2022', 'dummy.jpg', 4),
(4, 'Mars: Tempat Hidup Masa Depan', 'Ensiklopedia', 'Ahmad Sanusi', '2019', 'dummy.jpg', 1),
(5, 'Matematika Diskrit', 'Text Book', 'Rinaldi Munir', '2012', 'dummy.jpg', 1),
(7, 'Buku Pintar Pengetahuan Umum', 'Ensiklopedia', 'Robert Oeban', '2001', 'dummy.jpg', 2),
(8, 'Membaca Pikiran Orang Lewat Bahasa Tubuh', 'Entertainment', 'Dianata Eka Putra', '1999', 'dummy.jpg', 3),
(9, 'Koca', 'Gaming', 'Lol', '2022', 'dummy.jpg', 1),
(10, 'tak kita coba ges', 'apakah bisa', 'atau tidak', '2022', 'dummy.jpg', 1),
(11, 'sdfads', 'sdfga', 'qwer', 'adf', 'dummy.jpg', 1),
(12, '1', '1', '1', '1', 'Screenshot 2022-05-18 093522.pngpng', 1),
(13, '1', '1', '1', '1', 'dummy.jpg', 1),
(14, '2', '2', '2', '2', 'Progress2.png', 1),
(15, '3', '3', '3', '3', 'dummy.jpg', 1),
(16, '4', '4', '4', '4', 'Implement.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id`, `username`, `password`, `email`, `nama`) VALUES
(1, 'yasin', '$2y$10$JvPcx1SPvbLfAwwtMUbi0epKjkrxMh09LR3xPzrCCGpCMZwTXc8CO', 'yasin@gmail.com', 'Muhamad Nur Yasin Amadudin'),
(2, 'torn', '123', 'torn@gmail.com', 'Torn The Future'),
(3, 'hamzah', '123', 'hamzah@gmail.com', 'Hamzah Sidqi'),
(4, 'rexux', '123', 'rexus@gmail.com', 'Rexus Daxa'),
(5, 'test', '$2y$10$JvPcx1SPvbLfAwwtMUbi0epKjkrxMh09LR3xPzrCCGpCMZwTXc8CO', 'test@gmail.com', 'Muhamad Nur Salman');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_databuku`
--
ALTER TABLE `t_databuku`
  ADD PRIMARY KEY (`id_databuku`),
  ADD KEY `id_akun` (`id_akun`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_databuku`
--
ALTER TABLE `t_databuku`
  MODIFY `id_databuku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_databuku`
--
ALTER TABLE `t_databuku`
  ADD CONSTRAINT `t_databuku_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `t_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
