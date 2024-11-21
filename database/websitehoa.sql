-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 06:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

CREATE DATABASE websitehoa;
USE websitehoa;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websitehoa`
--

-- --------------------------------------------------------
-- thêm bảng comments
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code INT(11),
    product_id INT(11),
    user_id INT(11),
    rating INT(1),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_code) REFERENCES order_items(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` varchar(10) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
('1', 'Hoa Cao Cấp'),
('2', 'Hoa Tết'),
('3', 'Hoa Sinh Viên');

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_submissions`
--

INSERT INTO `contact_submissions` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'namu', 'nam@1', '1', '2024-11-10 17:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_code` varchar(8) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_code` varchar(8) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale` int(3) DEFAULT NULL,
  `price_sale` decimal(10,2) GENERATED ALWAYS AS (`price` - `price` * `sale` / 100) STORED,
  `stock` int(11) NOT NULL,
  `remark` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `image`, `description`, `price`, `sale`, `stock`, `remark`, `category_id`) VALUES
(1, 'Khoe sắc 2', '13182_khoe-sac-2.jpg', 'Colorful bouquet', 1300000.00, 50, 355, 0, '1'),
(2, 'Pink Lady', '7240_pink-lady.png', 'Elegant pink rose bouquet', 2400000.00, 30, 67, 0, '1'),
(3, 'Pink baby', '10693_pink-baby.png', 'Soft pink bouquet', 1350000.00, 10, 46, 0, '1'),
(4, 'Tình Yêu Vĩnh Cửu 2', '6020_tinh-yeu-vinh-cuu-2.jpg', 'Red and romantic bouquet', 2500000.00, 75, 19, 0, '1'),
(5, 'A Thousand roses', '12994_a-thousand-roses.jpg', 'Large arrangement of red roses', 28000000.00, 4, 88, 1, '1'),
(6, 'Luxury vase 22', '13312_luxury-vase-22.jpg', 'White and yellow vase arrangement', 1700000.00, 12, 98, 0, '1'),
(7, 'Luxury vase 21', '13311_luxury-vase-21.jpg', 'Pink and white flower vase', 2000000.00, 10, 676, 1, '1'),
(8, 'Luxury vase 23', '13313_luxury-vase-23.jpg', 'Blue-themed floral vase', 1000000.00, 1, 88, 0, '1'),
(9, 'Premium vase 5', '13310_premium-vase-5.jpg', 'Red and purple premium vase', 120000.00, 20, 88, 1, '1'),
(10, 'Premium vase 3', '13308_premium-vase-3.jpg', 'Elegant arrangement with a classic touch', 100000.00, 15, 99, 0, '1'),
(11, 'Premium vase 2', '13307_premium-vase-2.jpg', 'Luxurious multi-colored arrangement', 2000000.00, 18, 12, 0, '1'),
(12, 'Luxury vase 20', '12672_luxury-vase-20.jpg', 'Special arrangement with various colors', 500000.00, 55, 56, 0, '1'),
(13, 'Premium vase 6', '12349_premium-vase-6.jpg', 'Orange-themed premium floral vase', 7500000.00, 99, 44, 1, '2'),
(14, 'Bùng cháy 4', '13211_bung-chay-4.jpg', 'Vibrant arrangement with sunflowers', 1150000.00, 60, 454, 1, '2'),
(15, 'Dancing lady', '12668_dancing-lady.jpg', 'Bright yellow flower arrangement', 4000000.00, 8, 1, 1, '2'),
(16, 'Luxury vase 6', '12483_luxury-vase-6.jpg', 'Red-themed luxury vase', 3500000.00, 20, 66, 1, '2'),
(17, 'Tiền tài như nước', '8021_tien-tai-nhu-nuoc.jpg', 'Orange and green arrangement', 1500000.00, 76, 34, 1, '2'),
(18, 'Yellow mokara vase', '12495_yellow-mokara-vase.jpg', 'Yellow orchid vase arrangement', 1800000.00, 15, 3, 1, '2'),
(19, 'Luxury vase 20', '12672_luxury-vase-20.jpg', 'Elegant pastel floral vase', 10000000.00, 37, 55, 1, '2'),
(20, 'Red mokara vase', '12494_red-mokara-vase.jpg', 'Red orchid flower vase', 1800000.00, 10, 11, 1, '2'),
(21, 'Tinh hoa', '14691_tinh-hoa.jpg', 'Yellow and green floral vase', 2300000.00, 12, 56, 1, '2'),
(22, 'Premium vase 6', '14945_premium-vase-6.jpg', 'Elegant pink and white premium vase', 8500000.00, 18, 12, 1, '2'),
(23, 'Premium vase 8', '14661_premium-vase-8.jpg', 'Mixed-color premium arrangement', 8000000.00, 10, 2, 1, '2'),
(24, 'Luxury vase 29', '13645_luxury-vase-29.jpg', 'Yellow floral arrangement', 4200000.00, 14, 5, 1, '2'),
(25, 'Gặp gỡ', '5598_gap-go.jpg', 'Simple and elegant pink bouquet', 150000.00, 5, 9, 1, '3'),
(26, 'Kem hoa', '11739_kem-hoa.png', 'Cream-themed flower arrangement', 280000.00, 7, 14, 0, '3'),
(27, 'Only You', '4840_only-you.jpg', 'White and purple bouquet', 280000.00, 10, 5, 0, '3'),
(28, 'Chỉ mình em', '12585_chi-minh-em.jpg', 'Soft pink bouquet', 350000.00, 15, 99, 1, '3'),
(29, 'Điều bất ngờ', '11740_dieu-bat-ngo.png', 'Orange and white bouquet', 350000.00, 78, 167, 0, '3'),
(30, 'Tana Baby', '11868_tana-baby.jpg', 'Green-themed small bouquet', 550000.00, 12, 164, 1, '3'),
(31, 'Tình', '10704_tinh.jpg', 'Soft pink rose bouquet', 500000.00, 10, 66, 1, '3'),
(32, 'Có em', '13084_co-em.jpg', 'Delicate bouquet with roses', 330000.00, 59, 4, 0, '3'),
(33, 'Chilling', '8441_chilling.png', 'Colorful arrangement of mixed flowers', 560185.00, 15, 34, 1, '3'),
(34, 'Mây ngàn', '11613_may-ngan.jpg', 'Red and white floral arrangement', 550000.00, 51, 33, 1, '3'),
(35, 'Hy Vọng', '5129_hy-vong.jpg', 'Yellow and white sunflower arrangement', 650000.00, 20, 121, 1, '3'),
(36, 'Sound of love', '11610_sound-of-love.jpg', 'Pastel-themed flower basket', 450000.00, 81, 100, 0, '3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `phone`, `address`, `role`, `created_at`) VALUES
(2, 'customer', 'test@1', '1', '0366379629', 'Việt Nam', 'customer', NOW()),
(1, 'admin', 'admin@1', '1', NULL, NULL, 'admin', NOW());

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
