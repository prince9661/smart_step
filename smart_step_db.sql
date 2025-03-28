-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2025 at 06:27 AM
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
-- Database: `smart_step_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `name`, `description`, `price`, `discount_price`, `quantity`, `image`, `user_id`) VALUES
(4, 3, 'Puma RS-X', 'Casual sneakers with a retro style', 89.99, 109.99, 2, 'puma.jpg', 2),
(7, 4, 'airjorden', 'good shoes', 5000.00, 100.00, 2, 'uploads/sh.jpg', 2),
(8, 5, 'Redtap ', 'he', 100.00, 200.00, 1, 'uploads/red.png', 2),
(9, 4, 'airjorden', 'good shoes', 5000.00, 100.00, 1, 'uploads/sh.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `material_name` varchar(255) NOT NULL,
  `current_stock` int(11) NOT NULL,
  `required_stock` int(11) NOT NULL,
  `unit_type` varchar(50) DEFAULT NULL,
  `min_required_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `material_name`, `current_stock`, `required_stock`, `unit_type`, `min_required_stock`) VALUES
(3, 'Laces', 200, 150, 'Meter(Sq)', 100),
(8, 'Leather', 400, 0, 'meters', 100),
(9, 'pPlastic', 200, 0, 'Kg', 150),
(10, 'Sole', 400, 0, 'pices', 300);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_usage`
--

CREATE TABLE `inventory_usage` (
  `id` int(11) NOT NULL,
  `material_name` varchar(255) NOT NULL,
  `quantity_used` int(11) NOT NULL,
  `wastage_percentage` decimal(5,2) NOT NULL,
  `usage_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `shoe_type` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('Pending','In Production','Completed','Delivered') NOT NULL DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `id` int(11) NOT NULL,
  `shoe_model` varchar(255) NOT NULL,
  `quantity_produced` int(11) NOT NULL,
  `production_time` int(11) NOT NULL,
  `completion_status` enum('On Time','Delayed') NOT NULL,
  `production_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production_schedule`
--

CREATE TABLE `production_schedule` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `shoe_type` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `priority` enum('High','Medium','Low') NOT NULL,
  `status` enum('Scheduled','In Progress','Quality Check','Ready for Dispatch') NOT NULL DEFAULT 'Scheduled',
  `estimated_completion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `production_schedule`
--

INSERT INTO `production_schedule` (`id`, `order_id`, `customer_name`, `shoe_type`, `quantity`, `order_date`, `priority`, `status`, `estimated_completion`) VALUES
(1, 'ORD1234', 'John Doe', 'Sneakers', 10, '2025-03-14', 'High', 'In Progress', '2025-03-16 14:00:00'),
(2, 'ORD1235', 'Jane Smith', 'Boots', 5, '2025-03-13', 'Medium', 'Scheduled', '2025-03-18 10:00:00'),
(3, 'ORD1236', 'Alice Brown', 'Sandals', 20, '2025-03-12', 'Low', 'Scheduled', '2025-03-20 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `reviews` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 50
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `discount_price`, `rating`, `reviews`, `image`, `quantity`) VALUES
(1, 'Nike Air Zoom Pegasus 39', 'Men\'s Road Running Shoes', 129.99, 149.99, 5, 1280, 'sh.jpg', 73),
(2, 'Adidas Ultraboost', 'High-performance running shoes', 159.99, 179.99, 5, 1050, 'adidas.jpg', 96),
(3, 'Puma RS-X', 'Casual sneakers with a retro style', 89.99, 109.99, 4, 750, 'puma.jpg', 71),
(4, 'airjorden', 'good shoes', 5000.00, 100.00, 4, 12, 'uploads/sh.jpg', 47),
(5, 'Redtap ', 'he', 100.00, 200.00, 4, 45, 'uploads/red.png', 49);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `shoe_model` varchar(255) NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `revenue` decimal(10,2) NOT NULL,
  `sale_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Customer','Manager','Admin') NOT NULL DEFAULT 'Customer',
  `status` enum('Active','Suspended','Deleted') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Prince kumar', 'prince1p100@gmail.com', '$2y$10$K4hZ98cyi/nTDLwi0jPAFOb9/82KhODjHxYwSegNVjV6YFiLucdzi', 'Manager', '', '2025-03-15 16:25:55'),
(2, 'prince', 'prince966160@gmail.com', '$2y$10$dcbFouUFsMGoppguAlVP8e8DBV3Hi0b3CIxdPcb8eeaXMmOHS8Lau', 'Customer', 'Active', '2025-03-27 05:16:06'),
(5, 'Harsh Kumar', 'harshkr.agrl@gmail.com', '$2y$10$OK4eKJ9B5OhacFDsU7kMM.U845yGkdrs78z56tOkL6VerIviys0sS', 'Customer', '', '2025-03-27 05:24:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_usage`
--
ALTER TABLE `inventory_usage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_schedule`
--
ALTER TABLE `production_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `inventory_usage`
--
ALTER TABLE `inventory_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_schedule`
--
ALTER TABLE `production_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
