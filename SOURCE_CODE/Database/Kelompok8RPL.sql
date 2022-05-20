-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2022 at 04:31 AM
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
-- Database: `esp32_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `device_smart_knock_lock`
--

CREATE TABLE `device_smart_knock_lock` (
  `ID_PERANGKAT` int(11) NOT NULL,
  `ID_MASTER` int(11) DEFAULT NULL,
  `KAPASITAS_BATERAI` int(11) DEFAULT NULL,
  `IS_PRESSED` tinyint(1) NOT NULL,
  `POLA_KUNCI` varchar(200) DEFAULT NULL,
  `KODE_PERANGKAT` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `device_smart_knock_lock`
--

INSERT INTO `device_smart_knock_lock` (`ID_PERANGKAT`, `ID_MASTER`, `KAPASITAS_BATERAI`, `IS_PRESSED`, `POLA_KUNCI`, `KODE_PERANGKAT`) VALUES
(1, 1, 36, 0, '50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1', 'AB21'),
(2, 2, 45, 0, '50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.', 'AB22');

-- --------------------------------------------------------

--
-- Table structure for table `master`
--

CREATE TABLE `master` (
  `ID_MASTER` int(11) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `USERNAME` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master`
--

INSERT INTO `master` (`ID_MASTER`, `NAMA`, `EMAIL`, `USERNAME`, `PASSWORD`) VALUES
(1, 'Yasin', 'mnyasin26@gmail.com', 'mnyasin26', '12345678'),
(2, 'Rafly', 'rafly@example.com', 'rafly', '12345678'),
(3, 'virza', 'virza@exmaple.com', 'virza', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_brankas`
--

CREATE TABLE `riwayat_brankas` (
  `ID_RIWAYAT` int(11) NOT NULL,
  `ID_PERANGKAT` int(11) DEFAULT NULL,
  `RIWAYAT_BRANKAS` datetime DEFAULT NULL,
  `STATUS_RIWAYAT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `riwayat_brankas`
--

INSERT INTO `riwayat_brankas` (`ID_RIWAYAT`, `ID_PERANGKAT`, `RIWAYAT_BRANKAS`, `STATUS_RIWAYAT`) VALUES
(1, 1, '2022-05-14 09:15:05', 1),
(2, 1, '2022-05-14 11:01:20', 0),
(3, 1, '2022-05-14 11:01:20', 1),
(4, 1, '2022-05-14 12:52:31', 0),
(5, 1, '2022-05-14 11:53:31', 1),
(6, 1, '2022-05-16 17:39:07', 0),
(7, 1, '2022-05-16 17:39:07', 1),
(8, 1, '2022-05-16 17:39:07', 1),
(9, 1, '2022-05-16 17:39:07', 1),
(10, 1, '2022-05-16 17:39:07', 0),
(11, 1, '2022-05-16 17:39:07', 0),
(12, 1, '2022-05-16 17:43:02', 0),
(13, 1, '2022-05-16 17:43:02', 0),
(14, 1, '2022-05-16 17:43:02', 1),
(15, 1, '2022-05-16 17:43:02', 0),
(16, 1, '2022-05-16 17:43:02', 0),
(17, 1, '2022-05-16 17:52:07', 1),
(18, 1, '2022-05-16 17:52:13', 0),
(19, 1, '2022-05-16 17:52:20', 1),
(20, 1, '2022-05-16 17:52:25', 0),
(21, 1, '2022-05-16 17:52:29', 0),
(22, 1, '2022-05-16 17:52:32', 1),
(23, 1, '2022-05-16 19:08:25', 1),
(24, 1, '2022-05-16 19:08:58', 0),
(25, 1, '2022-05-16 19:09:15', 1),
(26, 1, '2022-05-16 19:09:21', 1),
(27, 1, '0000-00-00 00:00:00', 0),
(28, 1, '2022-05-17 08:15:07', 0),
(29, 1, '2022-05-17 08:15:45', 1),
(30, 1, '2022-05-17 08:17:15', 0),
(31, 1, '2022-05-17 08:20:20', 1),
(32, 1, '2022-05-17 08:20:37', 0),
(33, 1, '2022-05-17 08:21:10', 0),
(34, 1, '2022-05-17 08:21:18', 0),
(35, 1, '2022-05-17 08:22:29', 0),
(36, 1, '2022-05-14 11:53:31', 1),
(37, 1, '2022-05-17 08:23:40', 0),
(38, 1, '2022-05-17 08:26:50', 0),
(39, 1, '2022-05-14 11:53:31', 1),
(40, 1, '2022-05-17 08:37:45', 0),
(41, 1, '2022-05-17 08:38:00', 0),
(42, 1, '2022-05-17 08:38:12', 0),
(43, 1, '2022-05-17 08:38:27', 0),
(44, 1, '2022-05-17 08:38:36', 1),
(45, 1, '2022-05-17 08:39:20', 1),
(46, 1, '2022-05-17 08:39:39', 0),
(47, 1, '2022-05-17 08:39:55', 0),
(48, 1, '2022-05-17 08:40:08', 1),
(49, 1, '2022-05-17 08:41:09', 0),
(50, 1, '2022-05-17 08:41:48', 0),
(51, 1, '2022-05-17 08:43:34', 1),
(52, 1, '2022-05-17 08:43:40', 0),
(53, 1, '2022-05-17 08:44:10', 1),
(54, 1, '2022-05-17 08:44:15', 0),
(55, 1, '2022-05-17 08:44:38', 1),
(56, 1, '2022-05-17 08:44:43', 0),
(57, 1, '2022-05-17 08:46:51', 1),
(58, 1, '2022-05-17 08:46:57', 0),
(59, 1, '2022-05-17 08:47:45', 1),
(60, 1, '2022-05-17 08:47:51', 0),
(61, 1, '2022-05-17 08:49:50', 0),
(62, 1, '2022-05-17 08:50:08', 0),
(63, 1, '2022-05-17 08:50:32', 1),
(64, 1, '2022-05-17 08:51:01', 0),
(65, 1, '2022-05-14 11:53:31', 1),
(66, 1, '2022-05-14 11:53:31', 1),
(67, 1, '2022-05-14 11:53:31', 1),
(68, 1, '2022-05-17 09:13:37', 0),
(69, 1, '2022-05-17 09:13:47', 0),
(70, 1, '2022-05-17 09:13:57', 0),
(71, 1, '2022-05-17 09:14:07', 0),
(72, 1, '2022-05-17 09:14:18', 0),
(73, 1, '2022-05-17 09:14:28', 0),
(74, 1, '2022-05-17 09:14:50', 1),
(75, 1, '2022-05-17 09:15:35', 1),
(76, 1, '2022-05-14 11:53:31', 1),
(77, 1, '2022-05-17 09:16:21', 1),
(78, 1, '2022-05-17 09:17:26', 1),
(79, 1, '2022-05-17 09:19:16', 1),
(80, 1, '2022-05-17 09:19:33', 0),
(81, 1, '2022-05-17 09:24:28', 1),
(82, 1, '2022-05-17 09:25:01', 1),
(83, 1, '2022-05-17 09:25:58', 1),
(84, 1, '2022-05-17 09:26:17', 0),
(85, 1, '2022-05-17 09:26:50', 0),
(86, 1, '2022-05-14 11:53:31', 1),
(87, 1, '2022-05-14 11:53:31', 1),
(88, 1, '2022-05-14 11:53:31', 1),
(89, 1, '2022-05-14 11:53:31', 1),
(90, 1, '2022-05-14 11:53:31', 1),
(91, 1, '2022-05-14 11:53:31', 1),
(92, 1, '2022-05-14 11:53:31', 1),
(93, 1, '2022-05-14 11:53:31', 1),
(94, 1, '2022-05-14 11:53:31', 1),
(95, 1, '2022-05-14 11:53:31', 1),
(96, 1, '2022-05-14 11:53:31', 1),
(97, 1, '2022-05-14 11:53:31', 1),
(98, 1, '2022-05-14 11:53:31', 1),
(99, 1, '2022-05-14 11:53:31', 1),
(100, 1, '2022-05-14 11:53:31', 1),
(101, 1, '2022-05-14 11:53:31', 1),
(102, 1, '2022-05-14 11:53:31', 1),
(103, 1, '2022-05-14 11:53:31', 1),
(104, 1, '2022-05-14 11:53:31', 1),
(105, 1, '2022-05-14 11:53:31', 1),
(106, 1, '2022-05-14 11:53:31', 1),
(107, 1, '2022-05-14 11:53:31', 1),
(108, 1, '2022-05-14 11:53:31', 1),
(109, 1, '2022-05-14 11:53:31', 1),
(110, 1, '2022-05-14 11:53:31', 1),
(111, 1, '2022-05-14 11:53:31', 1),
(112, 1, '2022-05-14 11:53:31', 1),
(113, 1, '2022-05-14 11:53:31', 1),
(114, 1, '2022-05-14 11:53:31', 1),
(115, 1, '2022-05-14 11:53:31', 1),
(116, 1, '2022-05-14 11:53:31', 1),
(117, 1, '2022-05-14 11:53:31', 1),
(118, 1, '2022-05-14 11:53:31', 1),
(119, 1, '2022-05-14 11:53:31', 1),
(120, 1, '2022-05-14 11:53:31', 0),
(121, 1, '2022-05-14 11:53:31', 0),
(122, 1, '2022-05-14 11:53:31', 0),
(123, 1, '2022-05-14 11:53:31', 0),
(124, 1, '2022-05-14 11:53:31', 0),
(125, 2, '2022-05-18 04:21:33', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `device_smart_knock_lock`
--
ALTER TABLE `device_smart_knock_lock`
  ADD PRIMARY KEY (`ID_PERANGKAT`),
  ADD KEY `FK_DEVICE_S_MEMILIKI1_MASTER` (`ID_MASTER`);

--
-- Indexes for table `master`
--
ALTER TABLE `master`
  ADD PRIMARY KEY (`ID_MASTER`);

--
-- Indexes for table `riwayat_brankas`
--
ALTER TABLE `riwayat_brankas`
  ADD PRIMARY KEY (`ID_RIWAYAT`),
  ADD KEY `FK_RIWAYAT__MEMILIKI_DEVICE_S` (`ID_PERANGKAT`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `device_smart_knock_lock`
--
ALTER TABLE `device_smart_knock_lock`
  MODIFY `ID_PERANGKAT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master`
--
ALTER TABLE `master`
  MODIFY `ID_MASTER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `riwayat_brankas`
--
ALTER TABLE `riwayat_brankas`
  MODIFY `ID_RIWAYAT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `device_smart_knock_lock`
--
ALTER TABLE `device_smart_knock_lock`
  ADD CONSTRAINT `FK_DEVICE_S_MEMILIKI1_MASTER` FOREIGN KEY (`ID_MASTER`) REFERENCES `master` (`ID_MASTER`);

--
-- Constraints for table `riwayat_brankas`
--
ALTER TABLE `riwayat_brankas`
  ADD CONSTRAINT `FK_RIWAYAT__MEMILIKI_DEVICE_S` FOREIGN KEY (`ID_PERANGKAT`) REFERENCES `device_smart_knock_lock` (`ID_PERANGKAT`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
