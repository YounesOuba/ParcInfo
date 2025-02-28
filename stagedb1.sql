-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 12:30 PM
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
(4, 11, 2, '2005-01-01 23:00:00', NULL, 'assigned'),
(8, 17, 2, '2025-01-03 23:00:00', NULL, 'assigned'),
(10, 19, 6, '2005-02-09 23:00:00', NULL, 'assigned'),
(11, 2, 7, '2025-01-03 23:00:00', NULL, 'assigned'),
(12, 12, 6, '2022-01-04 23:00:00', NULL, 'assigned');

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
  `equipment_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `category`, `brand`, `model`, `serial_number`, `status`, `purchase_date`, `supplier_id`, `created_at`, `equipment_image`) VALUES
(1, 'Laptop HP', 'Laptop', 'Hp', 'G8', NULL, 'maintenance', NULL, NULL, '2025-02-23 15:09:53', 'uploads/67bb7c88393403.17737398.png'),
(2, 'Monitor Samsung', 'Laptop', 'Samsung', '2020', NULL, 'assigned', NULL, NULL, '2025-02-23 15:09:53', 'uploads/67bb7c970907a4.27905217.png'),
(11, 'Tablet', 'Monitors', 'Samsung', '2020', 'Tablet-0112345500', 'assigned', '2020-01-05', NULL, '2025-02-23 18:41:53', 'uploads/67bb6bf1f001a2.88467782.png'),
(12, 'Test', 'Speakers', 'Samsung', '2024', 'Test-66378129861', 'assigned', '2025-01-12', 2, '2025-02-23 20:06:18', 'uploads/67bb7fba286e17.45165134.jpg'),
(17, 'Tablet', 'Laptop', 'Nokia', '2024', 'Tablet-0112345500009', 'maintenance', '2024-01-04', 2, '2025-02-24 10:16:06', 'uploads/67bc46e61ce566.73579814.png'),
(19, 'Camera', 'Laptop', 'Samsung', '2024', 'Camera1234567890', 'maintenance', '2025-01-04', 4, '2025-02-25 00:56:27', 'uploads/67bd153b0ea852.46685361.png');

-- --------------------------------------------------------

--
-- Table structure for table `informations`
--

CREATE TABLE `informations` (
  `id` int(11) NOT NULL,
  `Full_Name` varchar(55) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `Terms_And_Conditions` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `informations`
--

INSERT INTO `informations` (`id`, `Full_Name`, `Email`, `Password`, `Terms_And_Conditions`) VALUES
(11, 'Cristiano Ronaldo', 'ronaldo@gmail.com', '$2y$10$koxB7ZuJ7XiP4tbJvqrsAuHwsZdBRFLluT.PFS2oGh8Fb39JvQ0eq', 1),
(12, 'Luka Modric', 'Modric@gmail.com', '$2y$10$Ap6zhfgYBW768nqkQZbuieaSURbiJYPJDB77EIZzxd4q9cICY4vU2', 1),
(13, 'Karim Benzema', 'Benzema@gmail.com', '$2y$10$ul7Hf3.FPH/e0hge5AwZ2OlaoaPzUL06HQcKdiLZyn8oLuVJaqTkm', 1),
(14, 'Karimi karim', 'younesouba66@gmail.com', '$2y$10$VW2owY5Wm3pUNbqTn1hqVuQV8e7zJgHyG2epawOrWsVTTyg0qIZfa', 1),
(15, 'Mohamed Bouincha', 'bouinchamohamed1@gmail.com', '$2y$10$FN.qso6kj67pkJWspmNiHuhe53dZnX0q4tbi1jBNeQTZw8rPgmePK', 1),
(16, 'ssi mohmmad ', 'bouinchamohamed02@gmail.com', '$2y$10$Ax0hFvYnilISFpM7bMz7Zur3JR6TjtLBt5yJADXpwaXVBJ8UW6K8m', 1),
(18, 'Younes Ouba', 'younes123ouba@gmail.com', '$2y$10$qlA2HUSq0heK8Q1tGFwVc.BQbujxcn5xPGqINi1T4ckYhvB4Def6q', 1),
(19, 'Zouhir Azdouz', 'zouhirazdouz8@gmail.com', '$2y$10$5H4XK0xId18ZMBiStoYZ.emD1C8xswd5JNfXwxeM0KF.QWcnBz1ya', 1),
(21, 'Younes Ouba', 'oubayounesouba@gmail.com', '$2y$10$osvRDfKShQrDuMpMfbsN.uY.l.wqlSNYCiRfQI5ezqAoJgnoCmWkG', 1),
(24, 'Zouhir Azdouz', 'zouhirazdouz@gmail.com', '$2y$10$hV6JDZzIxHombHK78kIk/.jGUukLuvsF5JOsEjbNpWTjnvrb/VcEu', 1);

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

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `table_name`, `record_id`, `description`, `timestamp`) VALUES
(1, 1, '/target.php', 'Table', 777, 'jhvds', '2025-02-25 02:34:17'),
(2, 1, '/target.php', 'Table', 777, 'jhvds', '2025-02-25 02:34:41'),
(3, 1, '/target.php', 'Table', 778, 'jhgjhgjhgv', '2025-02-25 02:34:53');

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
(1, 19, 5, 'the camera is in a mess', 'in_progress', '2025-02-25 01:08:28', NULL),
(2, 19, 5, 'the camera is in a mess', 'in_progress', '2025-02-25 01:09:28', NULL),
(3, 1, 5, 'disque dur missed', 'pending', '2025-02-25 01:10:26', NULL),
(4, 1, 5, 'disque dur missed', 'pending', '2025-02-25 01:12:41', NULL),
(5, 19, 5, 'camera man', 'pending', '2025-02-25 01:12:56', NULL),
(6, 19, 5, 'camera man', 'pending', '2025-02-25 01:13:02', NULL),
(7, 19, 5, 'camera man', 'pending', '2025-02-25 01:13:34', NULL),
(8, 19, 5, 'camera man', 'pending', '2025-02-25 01:13:46', NULL),
(9, 19, 5, 'camera man', 'pending', '2025-02-25 01:15:09', NULL),
(10, 19, 5, 'camera man', 'pending', '2025-02-25 01:16:25', NULL),
(11, 1, 3, 'uuuuuiojxcvyufv', 'in_progress', '2025-02-25 01:16:44', NULL),
(12, 19, 5, 'hjfvcjhvghc', 'completed', '2025-02-25 11:21:54', NULL),
(13, 19, 5, 'hjfvcjhvghc', 'completed', '2025-02-25 11:22:15', NULL),
(14, 19, 5, 'hjfvcjhvghc', 'completed', '2025-02-25 11:22:43', NULL),
(15, 19, 5, 'hjfvcjhvghc', 'completed', '2025-02-25 11:22:55', NULL);

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
(1, 4, '2025-01-03 23:00:00', 10.00, 'received');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `equipment_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 'Supplier B', 'Jane Smith', '987-654-3210', 'jane.smith@supplier.com', '456 Supplier Ave, City, Country', '2025-02-23 18:41:07'),
(3, 'Supplier C', 'Alice Johnson', '555-123-4567', 'alice.johnson@supplier.com', '789 Supplier Blvd, City, Country', '2025-02-23 18:41:07'),
(4, 'Younes Ouba', 'Younes Ouba', '0636401454', 'younes123ouba@gmail.com', 'Tounfite Midelt', '2025-02-24 12:05:40'),
(5, 'Mohamed Ait Boussata', 'Mohamed Ait Boussata', '0652522199', 'mbouccta@gmail.com', 'Tounfite Midelt', '2025-02-25 01:00:44');

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
(1, 'John Doe', 'john.doe@example.com', 'password_hash', 'user', '2025-02-23 21:07:53'),
(2, 'Jane Smith', 'jane.smith@example.com', 'password_hash', 'admin', '2025-02-23 21:07:53'),
(3, 'Alice Johnson', 'alice.johnson@example.com', 'password_hash', 'technician', '2025-02-23 21:07:53'),
(4, 'Bob Brown', 'bob.brown@example.com', 'password_hash', 'user', '2025-02-23 21:07:53'),
(5, 'Charlie Davis', 'charlie.davis@example.com', 'password_hash', 'technician', '2025-02-23 21:07:53'),
(6, 'Younes Ouba', 'younes123ouba@gmail.com', '$2y$10$Sj2jMV6uoktAhYPw2XLgn.Bo/zsHwNyKkj2s7t7zNNqXlxl2pTwpq', 'user', '2025-02-24 19:51:30'),
(7, 'Zouhir Azdouz', 'zouhirazdouz8@gmail.com', '$2y$10$Bj9M2aDdVg4RM/pp0gfoUuGEzUzI5DscdWvNEpHmWoHbT1fAeXEXW', 'admin', '2025-02-25 01:00:00');

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
  ADD KEY `order_id` (`order_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `informations`
--
ALTER TABLE `informations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
