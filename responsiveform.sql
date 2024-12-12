-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Generation Time: Dec 11, 2024 at 11:03 PM
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
-- Database: `responsiveform`
--

-- --------------------------------------------------------

--
-- Table structure for table `form1`
--

CREATE TABLE `form1` (
  `id` int(11) NOT NULL,
  `cname` varchar(20) NOT NULL,
  `sname` varchar(20) NOT NULL,
  `pname` varchar(15) NOT NULL,
  `selname` varchar(30) NOT NULL,
  `kname` varchar(30) NOT NULL,
  `sename` varchar(30) NOT NULL,
  `hname` varchar(20) NOT NULL,
  `rname` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form1`
--

INSERT INTO `form1` (`id`, `cname`, `sname`, `pname`, `selname`, `kname`, `sename`, `hname`, `rname`) VALUES
(2, 'om@gmail.com', '123651', '9823565241', 'Khopat', '', 'Premium Pack', 'Om@123', 'Om@12345'),
(6, 'Harshal@123', '458563', '4585659823', 'ShivajiNagar', '', 'Premium Pack', 'Harshal@123', 'Harshal@123');

-- --------------------------------------------------------

--
-- Table structure for table `form2`
--

CREATE TABLE `form2` (
  `id` int(10) NOT NULL,
  `plname` varchar(15) NOT NULL,
  `pcname` varchar(15) NOT NULL,
  `prname` varchar(15) NOT NULL,
  `qname` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form2`
--

INSERT INTO `form2` (`id`, `plname`, `pcname`, `prname`, `qname`) VALUES
(1, 'Sony Pack', '1011', '50', 'SD Pack'),
(2, 'Sony Marathi', '1012', '8', 'SD Pack'),
(3, 'Colors Pack', '1012', '9', 'SD Pack'),
(4, 'Zee Pack', '1014', '11', 'SD Pack'),
(5, 'Colors Hindi', '1016', '7', 'SD Pack'),
(6, 'News pack', '1018', '5', 'SD Pack'),
(7, 'Zee Pack', '1020', '12', 'SD Pack'),
(8, 'Set Max', '1021', '7', 'SD Pack'),
(9, 'Star Sports', '1014', '13', 'SD Pack'),
(10, 'Ten Sports', '1024', '13', 'SD Pack'),
(11, '& TV', '1025', '9', 'SD Pack'),
(12, 'Cartoon Network', '1017', '9', 'SD Pack'),
(13, 'B4U Music', '1028', '4', 'SD Pack'),
(14, 'Discovery Chann', '1030', '9', 'SD Pack'),
(15, 'Nat Geo Wild', '1032', '5', 'SD Pack'),
(0, 'Onida', '452', '45', 'HD Pack'),
(0, 'SONYHD', '4523', '45', 'SD Pack'),
(0, 'SONYHD', '452', '454', 'Select');

-- --------------------------------------------------------

--
-- Table structure for table `form3`
--

CREATE TABLE `form3` (
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form3`
--

INSERT INTO `form3` (`username`, `password`) VALUES
('Saylicable@99', 'Sayli@123');

-- --------------------------------------------------------

--
-- Table structure for table `form4`
--

CREATE TABLE `form4` (
  `user` varchar(25) NOT NULL,
  `pass` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form4`
--

INSERT INTO `form4` (`user`, `pass`) VALUES
('Admin@123', 'Admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `form5`
--

CREATE TABLE `form5` (
  `id` int(10) NOT NULL,
  `mname` varchar(15) NOT NULL,
  `aname` varchar(15) NOT NULL,
  `yname` varchar(15) NOT NULL,
  `uname` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form5`
--

INSERT INTO `form5` (`id`, `mname`, `aname`, `yname`, `uname`) VALUES
(1, 'Sony Pack', '1001', '45', 'HD Pack'),
(2, 'Sony Marathi', '1002', '11', 'HD Pack'),
(3, 'Colors Pack', '1003', '13', 'HD Pack'),
(4, 'Zee Pack', '1004', '13', 'HD Pack'),
(5, 'Colors Hindi', '1005', '9', 'HD Pack'),
(6, 'News Pack', '1006', '7', 'HD Pack'),
(7, 'Zee Tv Pack', '1007', '15', 'HD Pack'),
(8, 'Set Max', '1008', '10', 'HD Pack'),
(9, 'Star Sports ', '1009', '15', 'HD Pack'),
(10, 'Ten Sports', '1010', '15', 'HD Pack'),
(11, '& TV', '1011', '11', 'HD Pack'),
(12, 'Cartoon Netword', '1012', '12', 'HD Pack'),
(13, 'B4U music', '1013', '8', 'HD Pack'),
(14, 'Discovery Chann', '1014', '13', 'HD Pack'),
(15, 'Nat Geo wild', '1015', '8', 'HD Pack'),
(0, 'SONY452', '452', '56', 'HD Pack'),
(0, 'SONY452', '452', '45', 'Select');

-- --------------------------------------------------------

--
-- Table structure for table `form6`
--

CREATE TABLE `form6` (
  `id` int(100) NOT NULL,
  `sname` varchar(15) NOT NULL,
  `uname` varchar(15) NOT NULL,
  `dname` varchar(15) NOT NULL,
  `hname` int(15) NOT NULL,
  `iname` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form6`
--

INSERT INTO `form6` (`id`, `sname`, `uname`, `dname`, `hname`, `iname`) VALUES
(3, 'Mohan Singh', '9847366633', 'office staff', 9000, ''),
(6, 'mayur Kumar', '983727721', 'mechanic', 8000, '');

-- --------------------------------------------------------

--
-- Table structure for table `form7`
--

CREATE TABLE `form7` (
  `yname` varchar(20) NOT NULL,
  `oname` varchar(20) NOT NULL,
  `gname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form7`
--

INSERT INTO `form7` (`yname`, `oname`, `gname`) VALUES
('jrr', 'mamma', '728283nfjf'),
('mddkd', '34', 'jddkdkd'),
('mddkd', '34', 'jddkdkd'),
('mddkd', '34', 'jddkdkd'),
('mddkd', '34', 'jddkdkd'),
('mddkd', '34', 'jddkdkd'),
('mayur', 'mayur.musale', 'heeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee'),
('mayur', 'mayur.musale', 'heeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee'),
('mayur', 'jdjjdj', '838383'),
('mayur', 'jdjjdj', '838383'),
('mayur', 'jdjjdj', '838383'),
('Mayur', '152552', 'kk');

-- --------------------------------------------------------

--
-- Table structure for table `form8`
--

CREATE TABLE `form8` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `UPI_name` varchar(255) NOT NULL,
  `Package_name` varchar(255) NOT NULL,
  `month` varchar(2) NOT NULL,
  `Mode_name` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Transaction_ID` varchar(255) NOT NULL,
  `payment_status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form8`
--

INSERT INTO `form8` (`id`, `user_id`, `UPI_name`, `Package_name`, `month`, `Mode_name`, `Price`, `Transaction_ID`, `payment_status`) VALUES
(17, 2, 'omgawali-1@okaxis', 'Premium Pack', '01', 'Monthly', '650', '4521456', 'Pending'),
(18, 2, 'omgawali-1@okaxis', 'Premium Pack', '06', 'Monthly', '650', '85452365415', 'Pending'),
(19, 2, 'omgawali-1@okaxis', 'Premium Pack', '08', 'Monthly', '650', '856954521', 'Pending'),
(20, 2, 'omgawali-1@okaxis', 'Premium Pack', '08', 'Monthly', '650', '856954521', 'Pending'),
(21, 2, 'omgawali-1@okaxis', 'Premium Pack', '08', 'Monthly', '650', '8569545214565465', 'Pending'),
(22, 2, 'omgawali-1@okaxis', 'Premium Pack', '08', 'Monthly', '650', '8569545214565465', 'Pending'),
(23, 2, 'omgawali-1@okaxis', 'Premium Pack', '08', 'Monthly', '650', '8569545214565465', 'Pending'),
(24, 2, 'omgawali-1@okaxis', 'Premium Pack', '01', 'Monthly', '650', '8569545214565465', 'Pending'),
(25, 2, 'omgawali-1@okaxis', 'Premium Pack', '01', 'Monthly', '650', '4521456', 'Pending'),
(26, 2, 'omgawali-1@okaxis', 'Premium Pack', '01', 'Monthly', '650', '4521456', 'Pending'),
(27, 2, 'omgawali-1@okaxis', 'Premium Pack', '01', 'Monthly', '650', '85452365415', 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form1`
--
ALTER TABLE `form1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form8`
--
ALTER TABLE `form8`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form1`
--
ALTER TABLE `form1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `form8`
--
ALTER TABLE `form8`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `form8`
--
ALTER TABLE `form8`
  ADD CONSTRAINT `form8_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `form1` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
