-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 02, 2023 at 08:28 AM
-- Server version: 8.1.0
-- PHP Version: 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bill_payment`
--

-- --------------------------------------------------------

--
-- Table structure for table `billers`
--

CREATE TABLE `billers` (
  `id` int NOT NULL,
  `accountno` varchar(15) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billers`
--

INSERT INTO `billers` (`id`, `accountno`, `name`) VALUES
(1, '204100193156004', 'CEB'),
(2, '204100193156005', 'Mobitel'),
(3, '204100193156006', 'Hutch'),
(4, '204100193156007', 'Etisalat');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int NOT NULL,
  `biller_id` int NOT NULL DEFAULT '0',
  `reference` varchar(16) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `amount` double(10,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `response` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `user` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dbacc` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cracc` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile` varchar(12) COLLATE utf8mb4_general_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `biller_id`, `reference`, `amount`, `date`, `response`, `user`, `dbacc`, `cracc`, `mobile`) VALUES
(1, 1, '2112091004', 12500.00, '2023-09-29 14:09:29', 'success', 'chamara', '204100193156004', '204200100091326', ' '),
(2, 2, '2112091030', 13500.00, '2023-09-29 14:10:01', 'success', 'chamara', '204100193156005', '204200100091326', ' '),
(3, 3, '2112091006', 14500.00, '2023-09-29 14:11:28', 'success', 'chamara', '204100193156006', '204200100091326', ' '),
(4, 3, '2112091007', 15250.00, '2023-09-29 14:11:51', 'success', 'chamara', '204100193156006', '204200100091326', ' '),
(5, 4, '2112091008', 16750.00, '2023-09-29 14:12:13', 'success', 'chamara', '204100193156007', '204200100091326', ' '),
(6, 1, '2112091009', 17560.00, '2023-10-02 02:26:40', 'success', 'chamara', '204200100091326', '204100193156004', ' '),
(7, 1, '2112091010', 18370.00, '2023-10-02 02:35:01', 'success', 'chamara', '204200100091326', '204100193156004', '761234567'),
(8, 1, '2112091011', 19250.00, '2023-10-02 02:41:55', 'success', 'chamara', '204200100091326', '204100193156004', ''),
(9, 1, '2112091012', 20980.00, '2023-10-02 02:46:24', 'success', 'chamara', '204200100091326', '204100193156004', '0761234568');

-- --------------------------------------------------------

--
-- Table structure for table `institute`
--

CREATE TABLE `institute` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accno` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `institute`
--

INSERT INTO `institute` (`id`, `name`, `accno`) VALUES
(1, 'cooperative1', '204200100091326'),
(2, 'ruralbank', '204200100091327');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `institute_id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `role` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'external',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `institute_id`, `role`, `created_at`) VALUES
(10781, 'chamara', '6526560', '1', 'external', '2023-09-29 14:08:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billers`
--
ALTER TABLE `billers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `reference` (`reference`),
  ADD KEY `amt` (`amount`) USING BTREE,
  ADD KEY `biller_id` (`biller_id`);

--
-- Indexes for table `institute`
--
ALTER TABLE `institute`
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
-- AUTO_INCREMENT for table `billers`
--
ALTER TABLE `billers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `institute`
--
ALTER TABLE `institute`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10782;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
