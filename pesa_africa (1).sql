-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2026 at 05:35 PM
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
-- Database: `pesa_africa`
--

-- --------------------------------------------------------

--
-- Table structure for table `activation_fees`
--

CREATE TABLE `activation_fees` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `amount` int(11) DEFAULT 0,
  `status` varchar(30) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activation_fees`
--

INSERT INTO `activation_fees` (`id`, `username`, `phone`, `amount`, `status`, `created_at`) VALUES
(1, 'bb', '0782008061', 5000, 'Approved', '2026-10-30 15:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `task_balance` decimal(12,2) DEFAULT 0.00,
  `bonus_balance` decimal(12,2) DEFAULT 0.00,
  `isActivated` tinyint(1) DEFAULT 0,
  `hasPaidToken` tinyint(1) DEFAULT 0,
  `hasClaimedBonus` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `welcome_claimed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `mobile`, `password`, `task_balance`, `bonus_balance`, `isActivated`, `hasPaidToken`, `hasClaimedBonus`, `status`, `created_at`, `welcome_claimed`) VALUES
(2, '0782008066', '0783008000', '$2y$10$7SY3CklGkJwx3QojMJQAmuLGBJNo1JOvYluTbaWxK9ZoW2qlPMY6C', 0.00, 0.00, 1, 0, 0, 'active', '2026-10-30 13:04:54', 0),
(4, 'yop', '0782008065', '$2y$10$Ow45QjoL9OP.Md2moGC8L.sQPmnrz5xTnSKffd3CFuLpCUS02/dG2', 0.00, 0.00, 0, 0, 0, 'active', '2026-10-30 13:29:39', 0),
(5, 'Mukarugira', '0782008066', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0.00, 15000.00, 1, 1, 0, 'active', '2026-10-30 13:33:54', 1),
(6, 'bvb', '0782008077', '$2y$10$zfx7ULfHLKGG9JOpGGGb7OguFVmnJczZTIuvdQydwti1RvyPoxMIa', 0.00, 0.00, 0, 0, 0, 'active', '2026-10-30 13:35:51', 0),
(7, 'nana', '0782008061', '$2y$10$fpExyY7zIPHVdWrYq2DTVu2C.Fx5pMYSK8Pd4BnqRpWQsmGaHRMwG', 0.00, 0.00, 1, 0, 0, 'inactive', '2026-10-30 13:52:57', 0),
(8, 'mm', '0782008062', '$2y$10$vBNeeJLDdhz5yjWcgSbSMeRByoEV4IOmIlsxL8.BXCjC2TwFV7olC', 0.00, 9000.00, 1, 1, 0, 'active', '2026-10-30 13:57:08', 1),
(9, 'bb', '0782008063', '131313', 0.00, 0.00, 1, 1, 0, 'active', '2026-10-30 15:31:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `username`, `type`, `amount`, `phone`, `status`, `created_at`) VALUES
(1, 'bb', 'bonus', 10000.00, '0782008088', 'Approved', '2026-10-30 16:15:37'),
(3, 'mm', 'bonus', 6000.00, '0782008000', 'Rejected', '2026-10-30 16:30:20');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_tokens`
--

CREATE TABLE `withdrawal_tokens` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `amount` int(11) DEFAULT 0,
  `status` varchar(30) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdrawal_tokens`
--

INSERT INTO `withdrawal_tokens` (`id`, `username`, `phone`, `amount`, `status`, `created_at`) VALUES
(1, 'bb', '0782008061', 4000, 'Approved', '2026-10-30 16:13:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activation_fees`
--
ALTER TABLE `activation_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal_tokens`
--
ALTER TABLE `withdrawal_tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activation_fees`
--
ALTER TABLE `activation_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `withdrawal_tokens`
--
ALTER TABLE `withdrawal_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
