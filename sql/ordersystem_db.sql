-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2024 at 03:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
  `category_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Grill', '2024-06-13 07:36:29', '2024-06-13 07:57:27'),
(2, 'Solo Order', '2024-06-13 07:36:29', NULL),
(3, 'Bilao Set', '2024-06-13 07:36:29', NULL),
(4, 'Pulutan Package', '2024-06-13 07:36:29', NULL),
(5, 'Palayok Bundle', '2024-06-13 07:36:29', NULL),
(6, 'Putok Batok Bundle', '2024-06-13 07:36:29', NULL),
(7, 'Beverages', '2024-06-13 07:36:29', NULL),
(8, 'Alcohol Beverages', '2024-06-13 07:36:29', NULL);

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
  `customer_contact` varchar(11) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_rate` int(11) DEFAULT NULL,
  `customer_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_feedback`
--

INSERT INTO `customer_feedback` (`id`, `customer_name`, `customer_contact`, `customer_email`, `customer_rate`, `customer_remarks`, `created_at`) VALUES
(1, 'Jerome De Lara', NULL, NULL, 10, 'Good Job', '2024-06-04 17:18:47');

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
  `menu_description` varchar(255) DEFAULT NULL,
  `menu_img` varchar(255) DEFAULT 'default.png',
  `category_id` int(11) NOT NULL,
  `isEnabled` tinyint(1) DEFAULT 1,
  `isArchive` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `menu_name`, `menu_description`, `menu_img`, `category_id`, `isEnabled`, `isArchive`, `created_at`, `updated_at`) VALUES
(1, 'Isaw Baboy', NULL, 'default.png', 1, 0, 0, '2024-06-13 05:51:58', '2024-06-17 16:00:57'),
(2, 'Grilled Tilapia', NULL, 'default.png', 2, 0, 0, '2024-06-13 05:52:24', '2024-06-17 16:00:57'),
(3, 'Barbeque', NULL, 'default.png', 1, 0, 0, '2024-06-13 05:52:54', '2024-06-17 16:00:57'),
(4, 'Isaw Manok', NULL, 'default.png', 1, 0, 0, '2024-06-13 05:54:54', '2024-06-17 16:00:57'),
(5, 'Hotdog', NULL, 'default.png', 1, 0, 0, '2024-06-13 05:57:42', '2024-06-17 16:00:57'),
(6, 'Bulaklak', NULL, 'default.png', 1, 0, 0, '2024-06-13 05:57:51', '2024-06-17 16:00:57'),
(7, 'Tenga', NULL, 'default.png', 1, 0, 0, '2024-06-13 05:57:59', '2024-06-17 16:00:57'),
(8, 'Tumbong', NULL, 'default.png', 1, 0, 0, '2024-06-13 05:58:07', '2024-06-17 16:00:57'),
(9, 'Tokong', NULL, 'default.png', 1, 0, 0, '2024-06-13 05:58:17', '2024-06-17 16:00:57'),
(10, 'Rice', NULL, 'default.png', 1, 0, 0, '2024-06-13 05:58:59', '2024-06-17 16:00:57'),
(11, 'Grilled Bangus', NULL, 'default.png', 2, 0, 0, '2024-06-13 06:03:24', '2024-06-17 16:00:57'),
(13, 'Chicharong Bulaklak', NULL, 'default.png', 2, 0, 0, '2024-06-13 06:06:32', '2024-06-17 16:00:57'),
(14, 'Crispy Pata', NULL, 'default.png', 2, 0, 0, '2024-06-13 06:08:15', '2024-06-17 16:00:57'),
(15, 'Grilled Pusit', NULL, 'default.png', 1, 1, 0, '2024-06-14 06:48:06', '2024-06-17 16:01:39'),
(16, 'Fried Chicken', '1 Pc Fried Chicken with Gravy', 'food1.png', 1, 1, 0, '2024-06-14 07:05:41', '2024-06-17 16:01:37'),
(18, 'Tosino', NULL, 'tosino.png', 1, 1, 0, '2024-06-17 16:12:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_variations`
--

CREATE TABLE `menu_variations` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `variation_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_variations`
--

INSERT INTO `menu_variations` (`id`, `menu_id`, `variation_id`, `price`) VALUES
(1, 15, 1, 99.00),
(2, 15, 2, 149.00),
(3, 15, 3, 199.00),
(4, 16, 1, 99.00),
(5, 16, 2, 159.00),
(6, 16, 3, 189.00),
(8, 18, 1, 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `ordered_menu`
--

CREATE TABLE `ordered_menu` (
  `id` int(11) NOT NULL,
  `order_no` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `variation_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordered_menu`
--

INSERT INTO `ordered_menu` (`id`, `order_no`, `menu_id`, `variation_id`, `qty`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 16, 1, 15, 200.00, '2024-06-14 08:55:50', NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` int(11) NOT NULL,
  `variation_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `variations`
--

INSERT INTO `variations` (`id`, `variation_name`, `created_at`, `updated_at`) VALUES
(1, 'Large', '2024-06-14 06:26:44', '2024-06-14 06:32:37'),
(2, 'Extra Large', '2024-06-14 06:32:43', '2024-06-14 06:33:23'),
(3, '2X Extra Large', '2024-06-14 06:32:50', '2024-06-14 06:34:26'),
(4, 'Regular', '2024-06-14 07:38:21', NULL);

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
-- Indexes for table `menu_variations`
--
ALTER TABLE `menu_variations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_menu_variation` (`menu_id`,`variation_id`),
  ADD KEY `fr_variation_id` (`variation_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `ordered_menu`
--
ALTER TABLE `ordered_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fr_order_no` (`order_no`),
  ADD KEY `fr_menu_ids` (`menu_id`),
  ADD KEY `fr_variation_ids` (`variation_id`);

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
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `menu_variations`
--
ALTER TABLE `menu_variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ordered_menu`
--
ALTER TABLE `ordered_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
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
-- Constraints for table `menu_variations`
--
ALTER TABLE `menu_variations`
  ADD CONSTRAINT `fr_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fr_variation_id` FOREIGN KEY (`variation_id`) REFERENCES `variations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ordered_menu`
--
ALTER TABLE `ordered_menu`
  ADD CONSTRAINT `fr_menu_ids` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `fr_order_no` FOREIGN KEY (`order_no`) REFERENCES `customer_order` (`order_no`),
  ADD CONSTRAINT `fr_variation_ids` FOREIGN KEY (`variation_id`) REFERENCES `variations` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
