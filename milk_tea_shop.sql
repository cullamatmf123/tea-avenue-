-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 07:10 AM
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
-- Database: `milk_tea_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `role`) VALUES
(2, 'admin', 'admin123', 'admin'),
(6, 'francis', '123', 'user'),
(7, 'mark23', '123', 'user'),
(8, 'adminmark', '123', 'admin'),
(9, 'user', 'user123', 'user'),
(10, 'stephen', '123', 'admin'),
(12, 'nazz', '$2y$10$3ywcRbjd9ciCZQradfr4SuhQQ6RpshxAFxJquJnqsHROrZghKuy.G', 'user'),
(13, 'naze', '$2y$10$Z.ZvF6BVu.cAqcNqvnMec.H9JOTLjUIeV4EyFUz0Yz6l.3aZ0bcBS', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `username`, `total_price`, `order_date`, `status`, `user_id`) VALUES
(3, 'user', 400.00, '2024-11-17 16:02:34', 'Pending', NULL),
(4, 'user', 400.00, '2024-11-17 16:04:47', 'Completed', NULL),
(5, 'user', 400.00, '2024-11-17 16:04:51', 'Completed', NULL),
(6, 'francis', 1530.00, '2024-11-17 17:46:19', 'Completed', NULL),
(7, 'francis', 80.00, '2024-11-17 17:48:14', 'Completed', NULL),
(8, 'francis', 160.00, '2024-11-17 17:51:47', 'Pending', NULL),
(9, 'admin', 320.00, '2024-11-17 18:02:09', 'Pending', NULL),
(10, 'admin', 0.00, '2024-11-17 18:04:10', 'Cancelled', NULL),
(11, 'user', 0.00, '2024-11-17 18:12:37', 'Cancelled', NULL),
(12, 'user', 0.00, '2024-11-17 18:13:26', 'Pending', NULL),
(13, 'user', 0.00, '2024-11-17 18:15:06', 'Pending', NULL),
(15, 'user', 400.00, '2024-11-17 18:21:16', 'Pending', NULL),
(16, 'user', 1365.00, '2024-11-18 05:56:07', 'Completed', NULL),
(17, 'admin', 1170.00, '2024-11-18 06:28:33', 'Completed', NULL),
(18, 'francis', 1355.00, '2024-11-19 04:21:47', 'Completed', NULL),
(19, 'francis', 590.00, '2024-11-19 15:14:46', 'Completed', NULL),
(20, 'francis', 80.00, '2024-11-20 14:10:23', 'Pending', NULL),
(21, 'francis', 700.00, '2024-11-20 14:20:26', 'Completed', NULL),
(22, 'francis', 2340.00, '2024-11-20 14:56:21', 'Completed', NULL),
(23, 'francis', 460.00, '2024-11-21 03:18:44', 'Pending', NULL),
(24, 'francis', 1305.00, '2024-11-21 03:22:43', 'Cancelled', NULL),
(25, 'user', 85.00, '2024-11-21 04:58:58', 'Pending', NULL),
(26, 'user', 80.00, '2024-11-21 05:25:40', 'Completed', NULL),
(27, 'francis', 80.00, '2024-11-21 06:12:50', 'Pending', NULL),
(28, 'francis', 75.00, '2024-11-21 06:15:50', 'Pending', NULL),
(29, 'francis', 1100.00, '2024-11-21 06:16:26', 'Completed', NULL),
(30, 'francis', 80.00, '2024-11-21 06:18:56', 'Pending', NULL),
(31, 'francis', 80.00, '2024-11-21 06:24:22', 'Completed', NULL),
(32, 'francis', 85.00, '2024-11-21 06:24:42', 'Pending', NULL),
(33, 'francis', 80.00, '2024-11-21 06:24:55', 'Pending', NULL),
(34, 'francis', 80.00, '2024-11-21 06:25:15', 'Completed', NULL),
(35, 'francis', 85.00, '2024-11-21 06:28:04', 'Pending', NULL),
(36, 'francis', 80.00, '2024-11-21 06:29:01', 'Completed', NULL),
(37, 'francis', 90.00, '2024-11-23 13:16:28', 'Cancelled', NULL),
(38, 'francis', 960.00, '2024-11-24 05:01:54', 'Completed', NULL),
(39, 'francis', 555.00, '2024-11-25 08:21:11', 'Completed', NULL),
(40, 'francis', 240.00, '2024-11-25 08:21:24', 'Completed', NULL),
(41, 'francis', 255.00, '2024-11-25 08:21:51', 'Completed', NULL),
(42, 'francis', 2710.00, '2024-11-25 09:42:15', 'Completed', NULL),
(43, 'francis', 1395.00, '2024-11-28 12:13:01', 'Completed', NULL),
(44, 'francis', 1430.00, '2024-11-28 17:07:13', 'Completed', NULL),
(45, 'francis', 85.00, '2024-11-28 17:35:22', 'Completed', NULL),
(46, 'user', 745.00, '2024-11-29 20:53:03', 'Completed', NULL),
(47, 'user', 1670.00, '2024-11-29 21:41:09', 'Completed', NULL),
(48, 'user', 2630.00, '2024-11-29 21:44:34', 'Completed', NULL),
(49, 'user', 3360.00, '2024-11-29 22:07:44', 'Completed', NULL),
(50, 'user', 980.00, '2024-11-30 05:49:03', 'Completed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(1, 15, 'Caramel', 5, 80.00),
(2, 16, 'Brown Sugar', 7, 85.00),
(3, 16, 'Strawberry', 6, 75.00),
(4, 16, 'Caramel', 4, 80.00),
(5, 17, 'Taro', 13, 90.00),
(6, 18, 'Caramel', 6, 80.00),
(7, 18, 'Strawberry', 6, 75.00),
(8, 18, 'Brown Sugar', 5, 85.00),
(9, 19, 'Caramel', 1, 80.00),
(10, 19, 'Brown Sugar', 6, 85.00),
(11, 20, 'Caramel', 1, 80.00),
(12, 21, 'Special Item 4', 5, 140.00),
(13, 22, 'Caramel', 8, 80.00),
(14, 22, 'Strawberry', 5, 75.00),
(15, 22, 'Brown Sugar', 10, 85.00),
(16, 22, 'Chocolate', 5, 95.00),
(17, 23, 'Caramel', 1, 80.00),
(18, 23, 'Citrus', 4, 95.00),
(19, 24, 'Chocolate', 9, 95.00),
(20, 24, 'Strawberry', 6, 75.00),
(21, 25, 'Brown Sugar', 1, 85.00),
(22, 26, 'Caramel', 1, 80.00),
(23, 27, 'Caramel', 1, 80.00),
(24, 28, 'Strawberry', 1, 75.00),
(25, 29, 'Strawberry', 9, 75.00),
(26, 29, 'Brown Sugar', 5, 85.00),
(27, 30, 'Caramel', 1, 80.00),
(28, 31, 'Caramel', 1, 80.00),
(29, 32, 'Brown Sugar', 1, 85.00),
(30, 33, 'Caramel', 1, 80.00),
(31, 34, 'Caramel', 1, 80.00),
(32, 35, 'Brown Sugar', 1, 85.00),
(33, 36, 'Caramel', 1, 80.00),
(34, 37, 'Taro', 1, 90.00),
(35, 38, 'Strawberry', 6, 75.00),
(36, 38, 'Brown Sugar', 6, 85.00),
(37, 39, 'Strawberry', 1, 75.00),
(38, 39, 'Caramel', 6, 80.00),
(39, 40, 'Caramel', 3, 80.00),
(40, 41, 'Brown Sugar', 3, 85.00),
(41, 42, 'Honeydew Milk Tea', 14, 150.00),
(42, 42, 'Brown Sugar', 1, 85.00),
(43, 42, 'Strawberry', 7, 75.00),
(44, 43, 'Caramel', 9, 80.00),
(45, 43, 'Strawberry', 9, 75.00),
(46, 44, 'Caramel', 1, 80.00),
(47, 44, 'Strawberry', 1, 75.00),
(48, 44, 'Brown Sugar', 15, 85.00),
(49, 45, 'Brown Sugar', 1, 85.00),
(50, 46, 'Caramel', 4, 80.00),
(51, 46, 'Brown Sugar', 5, 85.00),
(52, 47, 'Caramel', 7, 80.00),
(53, 47, 'milktea', 6, 100.00),
(54, 47, 'Brown Sugar', 6, 85.00),
(55, 48, 'Caramel', 7, 80.00),
(56, 48, 'Honeydew Milk Tea', 6, 150.00),
(57, 48, 'milktea', 6, 100.00),
(58, 48, 'Citrus', 6, 95.00),
(59, 49, 'Caramel', 10, 80.00),
(60, 49, 'Honeydew Milk Tea', 7, 150.00),
(61, 49, 'milktea', 6, 100.00),
(62, 49, 'Okinawa Milk Tea', 7, 130.00),
(63, 50, 'Caramel', 6, 80.00),
(64, 50, 'milktea', 5, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `rating` float NOT NULL,
  `total_ratings` int(11) NOT NULL,
  `rating_count` int(11) DEFAULT 0,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `image`, `rating`, `total_ratings`, `rating_count`, `description`) VALUES
(1, 'Caramel', 80.00, 'images/caramel.jpg\n\n', 4.88235, 102, 32, 'sweet and yummy caramel'),
(2, 'Strawberry', 75.00, 'images/strawberry.jpg', 6.2, 31, 5, 'strawberry yummy'),
(3, 'Brown Sugar', 85.00, 'images/brownsugar.jpg', 5, 12, 6, ''),
(4, 'Chocolate', 95.00, 'images/choco.jpg', 4, 20, 1, ''),
(5, 'Citrus', 95.00, 'images/Citrus.jpg', 4.02222, 9, 0, ''),
(6, 'Mango', 80.00, 'images/Mango.jpg', 4.7, 14, 0, ''),
(7, 'Matcha', 95.00, 'images/1matcha.jpg', 4.9, 25, 0, ''),
(8, 'Taro', 90.00, 'images/Taro.jpg', 4.5, 18, 0, ''),
(9, 'Avocado', 95.00, 'images/avocado.jpg', 4.6, 11, 0, ''),
(10, 'Thai Milk Tea', 120.00, 'images/thai.jpg', 4.8, 22, 0, ''),
(11, 'Honeydew Milk Tea', 150.00, 'images/honey.jpg', 4.71667, 18, 0, ''),
(12, 'Okinawa Milk Tea', 130.00, 'images/0kinawa.jpg', 4.8, 19, 0, 'unique and yummy'),
(24, 'milktea', 100.00, 'images/signature_tea_3.jpg', 4.23077, 13, 0, 'ang sarap neto promise'),
(28, 'milk tea new', 100.00, 'images/signature_tea_1.jpg', 0.55, 2, 0, 'lami');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
