-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2022 at 03:36 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `modify` varchar(255) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `open_time` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  `share` int(11) NOT NULL,
  `folder` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `username`, `file_name`, `type`, `size`, `modify`, `deleted`, `open_time`, `image`, `priority`, `share`, `folder`) VALUES
(76, 'quang9angoquyen@gmail.com', 'external.jpg', 'jpg', 24062, '22-12-16 12:42:03', 0, '22-12-16 12:42:03', 'files/quang9angoquyen@gmail.com/external.jpg', 1, 1, NULL),
(83, 'vyy2903@gmail.com', 'readme.txt', 'txt', 1164, '22-12-16 07:34:03', 1, '22-12-16 03:05:53', 'CSS/images/txt.png', 1, 0, NULL),
(84, 'vyy2903@gmail.com', 'quanlykho (3).pdf', 'pdf', 119932, '22-12-16 03:06:32', 0, '22-12-16 03:06:32', 'CSS/images/pdf.png', 0, 0, 'check'),
(85, 'vyy2903@gmail.com', 'grow1.png', 'png', 1372, '22-12-16 07:58:59', 0, '22-12-16 03:11:23', 'files/vyy2903@gmail.com/grow1.png', 0, 1, NULL),
(86, 'vyy2903@gmail.com', 'don-de-nghi-hoan-thi 1.doc', 'doc', 44032, '22-12-16 08:13:13', 0, '22-12-16 03:49:53', 'CSS/images/doc.png', 1, 1, NULL),
(87, 'vyy2903@gmail.com', 'PhieuGhiNhanDieuChinh_DAMH.docx', 'docx', 16732, '22-12-16 08:33:13', 0, '22-12-16 08:33:13', 'CSS/images/doc.png', 0, 1, NULL),
(88, 'vytuong2903@gmail.com', 'documents.png', 'png', 13682, '22-12-16 09:08:35', 0, '22-12-16 09:08:35', 'files/vytuong2903@gmail.com/documents.png', 0, 0, NULL),
(89, 'vytuong2903@gmail.com', 'PL 6_LDT.BM.03_BAO CAO THUC HANH_OK_20210111_133701_936_20220412_101825_686.pptx', 'pptx', 299487, '22-12-16 09:08:49', 0, '22-12-16 09:08:49', 'CSS/images/ppt.png', 0, 0, NULL),
(90, 'vytuong2903@gmail.com', 'MYoung.png', 'png', 34452, '22-12-16 09:09:34', 0, '22-12-16 09:09:34', 'files/vytuong2903@gmail.com/MYoung.png', 0, 0, NULL),
(91, 'vyy2903@gmail.com', '52000170_52000149.pdf', 'pdf', 3898057, '22-12-16 09:10:25', 0, '22-12-16 09:10:25', 'CSS/images/pdf.png', 0, 0, NULL),
(92, 'vytuong2903@gmail.com', 'BaibaoK-meanvaf-SVM.pdf', 'pdf', 841306, '22-12-16 09:11:01', 0, '22-12-16 09:11:01', 'CSS/images/pdf.png', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `folder`
--

CREATE TABLE `folder` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `parent` varchar(50) DEFAULT NULL,
  `date_create` date NOT NULL,
  `modify` date NOT NULL,
  `deleted` int(11) NOT NULL,
  `share` int(11) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `folder`
--

INSERT INTO `folder` (`id`, `username`, `name`, `parent`, `date_create`, `modify`, `deleted`, `share`, `priority`) VALUES
(37, 'quang9angoquyen@gmail.com', 'level1', NULL, '2022-12-16', '2022-12-16', 0, 0, 0),
(38, 'quang9angoquyen@gmail.com', 'level22', 'level1', '2022-12-16', '2022-12-16', 0, 0, 0),
(40, 'quang9angoquyen@gmail.com', 'gfsdfg', 'level22', '2022-12-16', '2022-12-16', 0, 0, 0),
(41, 'vyy2903@gmail.com', 'check', NULL, '2022-12-16', '2022-12-16', 1, 0, 0),
(42, 'vyy2903@gmail.com', 'tempx1', NULL, '2022-12-16', '2022-12-16', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password`
--

CREATE TABLE `forgot_password` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `ma_bc` varchar(255) NOT NULL,
  `id_file` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `own` varchar(255) NOT NULL,
  `who_report` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `ma_bc`, `id_file`, `type`, `own`, `who_report`) VALUES
(2, 'BC001', 34, 'Vi phạm bản quyền', 'quang9angoquyen@gmail.com', 'vyy2903@gmail.com'),
(4, 'BC002', 35, 'Thông tin cá nhân và bí mật', 'quang9angoquyen@gmail.com', 'vyy2903@gmail.com'),
(5, 'BC003', 76, 'Thông tin cá nhân và bí mật', 'quang9angoquyen@gmail.com', 'vyy2903@gmail.com'),
(6, 'BC004', 92, 'Nguy hiểm cho trẻ em', 'vytuong2903@gmail.com', 'vyy2903@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `share`
--

CREATE TABLE `share` (
  `id` int(11) NOT NULL,
  `id_file` int(11) NOT NULL,
  `users` varchar(255) NOT NULL,
  `keyShare` varchar(255) NOT NULL,
  `isAll` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `share`
--

INSERT INTO `share` (`id`, `id_file`, `users`, `keyShare`, `isAll`) VALUES
(27, 85, '[]', 'ad17ce89115a191b433f0b4680eb71f5a4a78636ce5a20dfb1b2804a31e40cbc', 1),
(28, 86, '[]', '671bc14f6dc44d553cf2ec6398e3dc6385ab6a64b1e03de02bc573deeae37c44', 1),
(29, 87, '[\"vytuong2903@gmail.com\",\"quang9angoquyen@gmail.com\"]', '9a713647c3eb3796549e63ffc1a63755c2345912441d1fc3a3fa0c6df20c2661', 0),
(30, 92, '[]', 'c8671e7463a1437a583deecc91e5c36886d2c3499e59c8504eb9f4d046895937', 1);

-- --------------------------------------------------------

--
-- Table structure for table `share_with_me`
--

CREATE TABLE `share_with_me` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `id_file` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `share_with_me`
--

INSERT INTO `share_with_me` (`id`, `username`, `id_file`) VALUES
(11, 'vyy2903@gmail.com', 76),
(12, 'vytuong2903@gmail.com', 87),
(13, 'quang9angoquyen@gmail.com', 87),
(14, 'vyy2903@gmail.com', 92);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` int(11) NOT NULL,
  `size_page` int(11) DEFAULT NULL,
  `use_size` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `size_page`, `use_size`, `name`, `gender`, `phone`, `token`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 0, 100000000, 0, 'admin', 0, '0384708803', ''),
(3, 'vytg2903@gmail.com', '5a44030af59b98301ab128f4fdc9cfb2', 1, 100000000, 8022807, 'Huỳnh Nguyễn Tường Vy', 0, '0384708003', ''),
(5, 'p.thihc@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', 1, 104857600, 0, 'Pham Hoc', 1, NULL, '8c56f5a3a755580c65bbe3bf16b2aa9a'),
(7, 'vyy2903@gmail.com', '5a44030af59b98301ab128f4fdc9cfb2', 1, 209715200, 4080125, 'Huỳnh Nguyễn Tường Vy', 0, '0384708803', '25c10fc3aeff46febfa3a9c79fa0af3a'),
(8, 'huynhnguyentuongvy293@gmail.com', '5a44030af59b98301ab128f4fdc9cfb2', 0, 104857600, 0, 'Huỳnh Nguyễn Tường Vy', 0, NULL, '712eb8314e08aced5b80081e7eb167d0'),
(9, 'vytuong2903@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 104857600, 1188927, 'Huỳnh Nguyễn Tường Vy', 0, NULL, '8defc6b311fff90a8bb860366445ad1c'),
(10, 'quang9angoquyen@gmail.com', 'e13fb571df4e603a9647ef48c4cce730', 1, 104857600, 2849739, 'Dang Quang', 1, '0', '618aadfcf7b80895a53d722f493dea7f');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folder`
--
ALTER TABLE `folder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `share`
--
ALTER TABLE `share`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `share_with_me`
--
ALTER TABLE `share_with_me`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `folder`
--
ALTER TABLE `folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `forgot_password`
--
ALTER TABLE `forgot_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `share`
--
ALTER TABLE `share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `share_with_me`
--
ALTER TABLE `share_with_me`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
