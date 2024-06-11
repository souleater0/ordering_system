-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2024 at 12:17 PM
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
-- Database: `ordersystem_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Grill'),
(2, 'Solo Order'),
(3, 'Bilao Set'),
(4, 'Pulutan Package'),
(5, 'Palayok Bundle'),
(6, 'Putok Batok Bundle'),
(7, 'Beverages'),
(8, 'Alcohol Beverages'),
(9, 'A'),
(10, 'B'),
(11, 'C'),
(12, 'D'),
(13, 'E'),
(14, 'F'),
(15, 'G'),
(16, 'H');

-- --------------------------------------------------------

--
-- Table structure for table `customer_canceled`
--

CREATE TABLE `customer_canceled` (
  `order_no` int(11) NOT NULL,
  `table_no` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_canceled`
--

INSERT INTO `customer_canceled` (`order_no`, `table_no`, `customer_name`, `created_at`) VALUES
(1, 2, 'jerome', '2024-06-11 09:39:48'),
(2, 3, 'jhondell', '2024-06-11 09:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `customer_detail`
--

CREATE TABLE `customer_detail` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_contact` varchar(11) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_detail`
--

INSERT INTO `customer_detail` (`customer_id`, `customer_name`, `customer_contact`, `customer_email`, `created_at`) VALUES
(1, 'Jhondell Richards', '09123456789', 'jdr@gmail.com', '2024-06-04 17:07:00'),
(2, 'Thea Palintino', '09123456786', 'thea@gmail.com', '2024-06-04 17:07:43'),
(3, 'Louise Oliver', '09234561878', 'lo@gmail.com', '2024-06-04 17:08:07'),
(4, 'Jerome De Lara', '09123897564', 'jdl@gmail.com', '2024-06-04 17:08:37');

-- --------------------------------------------------------

--
-- Table structure for table `customer_feedback`
--

CREATE TABLE `customer_feedback` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_rate` int(11) DEFAULT NULL,
  `customer_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_feedback`
--

INSERT INTO `customer_feedback` (`id`, `customer_name`, `customer_rate`, `customer_remarks`, `created_at`) VALUES
(1, 'Jerome De Lara', 10, 'Good Job', '2024-06-04 17:18:47');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `order_no` int(11) NOT NULL,
  `table_no` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`order_no`, `table_no`, `customer_name`, `created_at`) VALUES
(1, 2, 'jerome', '2024-06-11 09:39:48'),
(2, 3, 'jhondell', '2024-06-11 09:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `customer_process`
--

CREATE TABLE `customer_process` (
  `order_no` int(11) NOT NULL,
  `table_no` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_process`
--

INSERT INTO `customer_process` (`order_no`, `table_no`, `customer_name`, `created_at`) VALUES
(1, 2, 'jerome', '2024-06-11 09:39:48'),
(2, 3, 'jhondell', '2024-06-11 09:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `isArchive` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `menu_name`, `menu_price`, `category_id`, `isArchive`, `created_at`, `updated_at`) VALUES
(1, 'Chicken Inasal', 70.00, 1, 0, '2024-06-04 15:41:44', '2024-06-04 15:51:27'),
(2, 'Food A', 60.00, 1, 0, '2024-06-04 15:46:47', '2024-06-04 15:51:27'),
(3, 'Food B', 50.00, 1, 0, '2024-06-04 15:47:02', '2024-06-04 15:51:27'),
(4, 'Food C', 55.00, 1, 0, '2024-06-04 15:47:25', '2024-06-04 15:51:27'),
(6, 'Food D', 20.00, 2, 0, '2024-06-04 15:47:53', '2024-06-06 08:43:01'),
(7, 'Food E', 80.00, 2, 0, '2024-06-04 15:48:05', '2024-06-06 08:43:01'),
(8, 'Food F', 50.00, 2, 0, '2024-06-04 15:48:16', '2024-06-06 08:43:01'),
(9, 'Food G', 60.00, 2, 0, '2024-06-04 15:49:03', '2024-06-06 08:43:01'),
(10, 'Food H', 90.00, 3, 0, '2024-06-04 15:49:12', '2024-06-06 08:43:03'),
(11, 'Food I', 120.00, 3, 0, '2024-06-04 15:49:20', '2024-06-06 08:43:03');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_menu`
--

CREATE TABLE `ordered_menu` (
  `id` int(11) NOT NULL,
  `order_no` int(11) DEFAULT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `isArchive` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordered_menu`
--

INSERT INTO `ordered_menu` (`id`, `order_no`, `menu_name`, `menu_price`, `category_id`, `isArchive`, `created_at`, `updated_at`) VALUES
(1, 1, 'Chicken Inasal', 70.00, 1, 0, '2024-06-04 15:41:44', '2024-06-11 10:13:17'),
(2, 1, 'Food A', 60.00, 1, 0, '2024-06-04 15:46:47', '2024-06-11 10:13:17'),
(3, 1, 'Food B', 50.00, 1, 0, '2024-06-04 15:47:02', '2024-06-11 10:13:17'),
(4, 1, 'Food C', 55.00, 1, 0, '2024-06-04 15:47:25', '2024-06-11 10:13:17'),
(6, 1, 'Food D', 20.00, 2, 0, '2024-06-04 15:47:53', '2024-06-11 10:13:17'),
(7, 2, 'Food E', 80.00, 2, 0, '2024-06-04 15:48:05', '2024-06-11 10:13:24'),
(8, 2, 'Food F', 50.00, 2, 0, '2024-06-04 15:48:16', '2024-06-11 10:13:21'),
(9, 2, 'Food G', 60.00, 2, 0, '2024-06-04 15:49:03', '2024-06-11 10:13:21'),
(10, 2, 'Food H', 90.00, 3, 0, '2024-06-04 15:49:12', '2024-06-11 10:13:21'),
(11, 2, 'Food I', 120.00, 3, 0, '2024-06-04 15:49:20', '2024-06-11 10:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Cashier');

-- --------------------------------------------------------

--
-- Table structure for table `table`
--

CREATE TABLE `table` (
  `id` int(11) NOT NULL,
  `table_no` int(11) DEFAULT NULL,
  `is_occupied` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table`
--

INSERT INTO `table` (`id`, `table_no`, `is_occupied`, `updated_at`) VALUES
(1, 1, 1, '2024-06-06 04:37:21'),
(2, 2, 0, NULL),
(3, 3, 0, NULL),
(4, 4, 0, NULL),
(5, 5, 0, NULL),
(6, 6, 0, NULL),
(7, 7, 0, NULL),
(8, 8, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `isEnabled` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `display_name`, `role_id`, `isEnabled`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$Yvn5wPKG1D1ovcMe5wM2lemqHaX40cKBJ7ybknP0rtYFkVSYt0MmK', 'Jerome De Lara', 1, 1, '2024-05-08 12:30:37', '2024-05-24 03:49:31'),
(3, 'jhondell', '$2y$10$JRSUatHPUFuxnBTk2t1PzeHke3itwMQXgGiKJrvWT.55bKynetknq', 'Jhondell', 2, 1, '2024-05-22 07:11:58', '2024-05-24 03:50:30'),
(4, 'test', '$2y$10$F9iTNImdi7zYnh7Isqzy8uPGaj2akWWtxOErWQxKrC4VpHCxGQeBW', 'test', 1, 1, '2024-06-10 12:52:00', '2024-06-10 12:52:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer_canceled`
--
ALTER TABLE `customer_canceled`
  ADD PRIMARY KEY (`order_no`) USING BTREE;

--
-- Indexes for table `customer_detail`
--
ALTER TABLE `customer_detail`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_feedback`
--
ALTER TABLE `customer_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`order_no`) USING BTREE;

--
-- Indexes for table `customer_process`
--
ALTER TABLE `customer_process`
  ADD PRIMARY KEY (`order_no`) USING BTREE;

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fr_category` (`category_id`);

--
-- Indexes for table `ordered_menu`
--
ALTER TABLE `ordered_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fr_category` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table`
--
ALTER TABLE `table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fr_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `customer_canceled`
--
ALTER TABLE `customer_canceled`
  MODIFY `order_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_detail`
--
ALTER TABLE `customer_detail`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_feedback`
--
ALTER TABLE `customer_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `order_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_process`
--
ALTER TABLE `customer_process`
  MODIFY `order_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ordered_menu`
--
ALTER TABLE `ordered_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table`
--
ALTER TABLE `table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fr_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ordered_menu`
--
ALTER TABLE `ordered_menu`
  ADD CONSTRAINT `ordered_menu_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
