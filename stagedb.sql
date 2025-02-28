-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2025 at 01:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stagedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `return_date` timestamp NULL DEFAULT NULL,
  `status` enum('assigned','returned') DEFAULT 'assigned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `equipment_id`, `user_id`, `assigned_date`, `return_date`, `status`) VALUES
(10, 19, 6, '2005-02-09 23:00:00', NULL, 'assigned'),
(11, 2, 7, '2025-01-03 23:00:00', NULL, 'assigned'),
(13, 20, 6, '2025-01-04 23:00:00', NULL, 'assigned');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `status` enum('available','assigned','maintenance','retired') DEFAULT 'available',
  `purchase_date` date DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `equipment_image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `category`, `brand`, `model`, `serial_number`, `status`, `purchase_date`, `supplier_id`, `created_at`, `equipment_image`, `price`) VALUES
(1, 'Laptop HP', 'Laptop', 'Hp', 'G8', 'HP-1', 'available', NULL, NULL, '2025-02-23 15:09:53', 'uploads/67bb7c88393403.17737398.png', 0.00),
(2, 'Monitor Samsung', 'Laptop', 'Xiaomi', '2020', 'SM-7812368961Y', 'available', NULL, NULL, '2025-02-23 15:09:53', 'uploads/67bb7c970907a4.27905217.png', 0.00),
(11, 'Tablet', 'Monitors', 'Samsung', '2020', 'Tablet-0112345500', 'assigned', '2020-01-05', NULL, '2025-02-23 18:41:53', 'uploads/67bb6bf1f001a2.88467782.png', 0.00),
(17, 'Tablet', 'Laptop', 'Nokia', '2024', 'Tablet-0112345500009', 'available', '2024-01-04', NULL, '2025-02-24 10:16:06', 'uploads/67bc46e61ce566.73579814.png', 0.00),
(19, 'Camera', 'Laptop', 'Samsung', '2024', 'CM-175178t13189', 'available', '2025-01-04', 4, '2025-02-25 00:56:27', 'uploads/67bd153b0ea852.46685361.png', 0.00),
(20, 'Ecran', 'Monitors', 'Samsung', '2024', 'Ecran-12345678', 'assigned', '2022-01-04', NULL, '2025-02-25 12:03:05', 'uploads/67bdb179745034.37788005.png', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `informations`
--

CREATE TABLE `informations` (
  `id` int(11) NOT NULL,
  `Full_Name` varchar(55) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `Terms_And_Conditions` tinyint(1) NOT NULL DEFAULT 0,
  `role` enum('admin','user','technician') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `informations`
--

INSERT INTO `informations` (`id`, `Full_Name`, `Email`, `Password`, `Terms_And_Conditions`, `role`) VALUES
(21, 'Younes Ouba', 'oubayounesouba@gmail.com', '$2y$10$osvRDfKShQrDuMpMfbsN.uY.l.wqlSNYCiRfQI5ezqAoJgnoCmWkG', 1, 'user'),
(24, 'Zouhir Azdouz', 'zouhirazdouz@gmail.com', '$2y$10$hV6JDZzIxHombHK78kIk/.jGUukLuvsF5JOsEjbNpWTjnvrb/VcEu', 1, 'user'),
(25, 'Karimi karim', 'karimi@gmail.com', '$2y$10$ZisFtvAQu3MRn6mTiX9VsuL4CgGEZXWJQXsz4yMJYIcMid2nFIuCS', 0, 'technician'),
(26, 'Hafidi Hafid', 'hafidi@gmail.com', '$2y$10$hv.GqbXJnYPsBvyXGrjjz.FA8inFutx4XqsIsfOSYObBHBOMlgfqy', 0, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `technician_id` int(11) NOT NULL,
  `issue_description` text NOT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `start_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `equipment_id`, `technician_id`, `issue_description`, `status`, `start_date`, `end_date`) VALUES
(16, 1, 8, 'Disque dur Three9', 'in_progress', '2025-02-27 20:55:00', NULL),
(19, 2, 8, 'Tv is Thersaat', 'in_progress', '2025-02-27 20:58:13', NULL),
(20, 19, 8, 'Ther9aaat', 'pending', '2025-02-27 23:15:15', NULL),
(22, 17, 8, 'l\'afficheur mchaat', 'pending', '2025-02-27 23:42:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','shipped','received','canceled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `supplier_id`, `order_date`, `total_amount`, `status`) VALUES
(1, 4, '2025-01-03 23:00:00', 10.00, 'received'),
(2, 4, '2025-01-02 23:00:00', 100.00, 'pending'),
(3, 4, '2025-01-01 23:00:00', 0.00, 'pending'),
(4, 4, '2025-01-01 23:00:00', 0.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `equipment_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `equipment_id`, `quantity`, `unit_price`, `equipment_name`) VALUES
(1, 4, 2, 19, 0.00, ''),
(2, 4, 1, 22, 0.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `phone`, `email`, `address`, `created_at`) VALUES
(4, 'Younes Ouba', 'Younes Ouba', '0636401454', 'younes123ouba@gmail.com', 'Tounfite Midelt', '2025-02-24 12:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','technician') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(6, 'Younes Ouba', 'younes123ouba@gmail.com', '$2y$10$Sj2jMV6uoktAhYPw2XLgn.Bo/zsHwNyKkj2s7t7zNNqXlxl2pTwpq', 'user', '2025-02-24 19:51:30'),
(7, 'Zouhir Azdouz', 'zouhirazdouz8@gmail.com', '$2y$10$Bj9M2aDdVg4RM/pp0gfoUuGEzUzI5DscdWvNEpHmWoHbT1fAeXEXW', 'admin', '2025-02-25 01:00:00'),
(8, 'Karimi karim', 'karimi@gmail.com', '$2y$10$ZisFtvAQu3MRn6mTiX9VsuL4CgGEZXWJQXsz4yMJYIcMid2nFIuCS', 'technician', '2025-02-26 17:19:16'),
(10, 'Hafidi Hafid', 'hafidi@gmail.com', '$2y$10$hv.GqbXJnYPsBvyXGrjjz.FA8inFutx4XqsIsfOSYObBHBOMlgfqy', 'admin', '2025-02-28 11:16:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_id` (`equipment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_id` (`equipment_id`),
  ADD KEY `technician_id` (`technician_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `equipment_id` (`equipment_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `informations`
--
ALTER TABLE `informations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
