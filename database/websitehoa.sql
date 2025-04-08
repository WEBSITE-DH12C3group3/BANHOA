-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 07:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
('2', 'Hoa Sinh Nhật'),
('3', 'Hoa Sinh Viên');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `rating` int(1) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`id`, `user_id`, `email`, `name`, `phone`, `address`, `note`) VALUES
(1, 1, 'admin@gmail.com', 'admin', '1', '1', '1'),
(2, 4, 'anhha19052004@gmail.com', 'hoangvanha', '0366379629', 'Việt Nam', '...');

-- --------------------------------------------------------

--
-- Table structure for table `favourite`
--

CREATE TABLE `favourite` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favourite`
--

INSERT INTO `favourite` (`id`, `product_id`, `user_id`) VALUES
(1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `momo`
--

CREATE TABLE `momo` (
  `id_momo` int(11) NOT NULL,
  `partner_code` varchar(50) NOT NULL,
  `order_code` varchar(8) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `order_info` varchar(100) NOT NULL,
  `order_type` varchar(50) NOT NULL,
  `trans_id` int(11) NOT NULL,
  `pay_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `total` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `id_delivery` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `user_id`, `order_date`, `status`, `total`, `payment_method`, `id_delivery`) VALUES
(1, '674aeeab', 1, '2024-11-30 10:53:31', 'Đã nhận', 650000.00, 'cash', 1),
(2, '674aef98', 1, '2024-11-30 10:57:28', 'Đã thanh toán', 1800000.00, 'vnpay', 1),
(3, '674af037', 1, '2024-11-30 11:00:10', 'Đã thanh toán', 1800000.00, 'momo', 1),
(4, '674af0a3', 4, '2024-11-30 11:01:56', 'Đã thanh toán', 96000.00, 'momo', 2),
(5, '674af100', 4, '2024-11-30 11:03:28', 'Đã thanh toán', 1680000.00, 'momo_atm', 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_code` varchar(8) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_code`, `product_id`, `quantity`) VALUES
(1, '674aeeab', 1, 1),
(2, '674aef98', 7, 1),
(3, '674af037', 7, 1),
(4, '674af0a3', 9, 1),
(5, '674af100', 2, 1);

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
  `sold` int(11) NOT NULL DEFAULT 0,
  `remark` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `image`, `description`, `price`, `sale`, `stock`, `sold`, `remark`, `category_id`) VALUES
(1, 'Summer', 'bo-hoa-summer.jpg.webp', 'Mùa hè là mùa rực rỡ nhất trong năm, nhiều loài hoa như được thức giấc sau giấc ngủ dài và bừng rộ sắc hè. Cũng như tình yêu của những đôi trẻ, đầy mãnh liệt và cháy bỏng nhưng cũng phảng phất sự dịu dàng, quan tâm đối phương. Bó hoa Summer phù hợp để tặng người yêu hay bạn bè, những người mà bạn dành nhiều tình cảm nhất.', 1300000.00, 50, 354, 1, 0, '1'),
(2, 'Peaceful Dream', 'NEWBOUQUET_075.jpg.webp', 'Hãy tưởng tượng một bó hoa kết hợp hoàn hảo giữa các sắc màu dịu dàng như trắng, xanh nhạt và hồng phấn, gợi lên cảm giác thanh thoát, yên bình và thư thái. Peaceful Dream không chỉ là một món quà, mà còn là một lời chúc phúc, thể hiện sự trân trọng và tình yêu thương.', 2400000.00, 30, 67, 0, 0, '1'),
(3, ' Ẩn Dấu', 'an-dau.jpg.webp', 'Bình hoa hồng đỏ kết hợp cùng các loại hoa phụ đầy dễ thương và tinh tế. Hãy cùng FlowerCorner nói lời yêu thương đến một người đặc biệt đã luôn ở cạnh bên, quan tâm chia sẻ và động viên bạn nhé.', 1350000.00, 10, 46, 0, 0, '1'),
(4, 'Ngỏ Lời', 'bo-hoa-ngo-loi.jpg.webp', 'Ngỏ Lời là một bó hoa đầy cảm xúc, là cầu nối để bạn thể hiện tâm tư và tình cảm sâu sắc đến những người mà bạn yêu thương. Với sự kết hợp của những bông hoa mang sắc đỏ quyến rũ và những chi tiết tinh tế, bó hoa này chính là thông điệp về tình yêu, sự đam mê và chân thành.', 2500000.00, 75, 19, 0, 0, '1'),
(5, 'Khoe Sắc', 'bo-hoa-hong-pastel-khoe-sac.jpg.webp', 'Hoa hồng luôn là loài hoa được yêu thích nhất, không phải chỉ vì vẻ đẹp và hương thơm mà còn vì hoa hồng đại diện cho loại hoa của tình yêu. Bó hoa hồng nhỏ xinh được thiết kế từ 5 bông hồng kem dâu phun màu kết hợp với cúc tana và các loại lá phụ là lựa chọn hoàn hảo để làm hoa tặng sinh nhật vợ, bạn gái.', 1300000.00, 50, 354, 1, 0, '1'),
(6, ' Chào em!', 'bo-hoa-nay-em.jpg.webp', 'Là sự kết hợp cực kỳ truyền thống giữa hoa hồng đỏ và baby trắng. Chắc chắn sẽ làm xao động trái tim người nhận được ', 2400000.00, 30, 67, 0, 0, '1'),
(7, 'Luxury vase 21', '13311_luxury-vase-21.jpg', 'Pink and white flower vase', 2000000.00, 10, 676, 0, 0, '1'),
(8, 'Luxury vase 23', '13313_luxury-vase-23.jpg', 'Blue-themed floral vase', 1000000.00, 1, 88, 0, 0, '1'),
(9, 'Premium vase 5', '13310_premium-vase-5.jpg', 'Red and purple premium vase', 120000.00, 20, 88, 0, 0, '1'),
(10, 'Premium vase 3', '13308_premium-vase-3.jpg', 'Elegant arrangement with a classic touch', 100000.00, 15, 99, 0, 0, '1'),
(11, 'Premium vase 2', '13307_premium-vase-2.jpg', 'Luxurious multi-colored arrangement', 2000000.00, 18, 12, 0, 0, '1'),
(12, 'Luxury vase 20', '12672_luxury-vase-20.jpg', 'Special arrangement with various colors', 500000.00, 55, 56, 0, 0, '1'),
(13, ' Only Love', 'bo-hoa-hong-do-only-love.jpg.webp', 'Chỉ mang hình bóng một người trong tim là lời nhắn mà bó hoa Only Love muốn gửi gắn. Được thiết kế chỉ từ 10 một bông hồng đỏ thắm thể hiện cho một tình yêu nồng nhiệt cháy bỏng và cũng rất chân thành. Yêu thương là luôn chia sẻ, quan tâm và thấu hiểu người mình thương bạn nhé. Đừng chần chừ mà hãy gửi đến họ một chút yêu thương đầy chân thành nhất cùng đóa hồng đỏ được tô điểm bằng những loại hoa phụ dễ thương khác nhé.', 7500000.00, 99, 44, 0, 1, '2'),
(14, ' Thiên Thần', 'thien-than.jpg.webp', 'Những bông cúc tana nhỏ xinh như những mặt trời tí hon sẽ là lựa chọn hoàn hảo để dành tặng những cô gái dễ thương xinh đẹp vào mỗi dịp đặc biệt. Làm nàng mỉm cười mỗi ngày hay trong những dịp đặc biệt với bó cúc tana thiên thần xinh xắn', 1150000.00, 60, 454, 0, 1, '2'),
(15, ' Hội Ngộ', 'hoi-ngo.jpg.webp', 'Bó hoa Hội ngộ mang tone màu kem thật thơ mộng, Tượng trưng cho niềm nhớ thương của những người thân yêu khi đi xa luôn nhớ về, mong ngày gặp lại nhau.', 4000000.00, 8, 1, 0, 1, '2'),
(16, ' Ineffable', 'hi-vong-nang-mai-1.jpg.webp', 'Bó hoa Ineffabl được thiết kế với hoa hướng dương làm chủ đạo, như ánh mặt trời tỏa sáng ước vọng.', 3500000.00, 20, 66, 0, 1, '2'),
(17, 'Simple', 'bo-hoa-hong-simple.jpg.webp', 'Bó hoa Simple được thiết kế dành cho những ai yêu thích sự nhẹ nhàng, mộc mạc nhưng không kém phần sang trọng. Với cách kết hợp tối giản, sản phẩm này tôn vinh vẻ đẹp tự nhiên của hoa và mang đến cảm giác thoải mái, thư thái cho người nhận.', 1500000.00, 76, 34, 0, 1, '2'),
(18, ' Your Day', 'your-day-1.jpg.webp', 'Hạnh phúc đôi khi không được tính bằng năm, bằng tháng mà hạnh phúc có thể đong đầy dù trong một khoảnh khắc. Hãy gửi đến người bạn yêu thương nhất những khoảnh khắc chứa đựng đầy yêu thương nhé. Bó hoa gồm tông màu hồng lãng mạn của hồng kem kết hợp với vẻ đẹp đầy đáng yêu của cẩm chướng trắng.', 1800000.00, 15, 3, 0, 1, '2'),
(19, 'Luxury vase 20', '12672_luxury-vase-20.jpg', 'Elegant pastel floral vase', 10000000.00, 37, 55, 0, 1, '2'),
(20, 'Red mokara vase', '12494_red-mokara-vase.jpg', 'Red orchid flower vase', 1800000.00, 10, 11, 0, 1, '2'),
(21, 'Tinh hoa', '14691_tinh-hoa.jpg', 'Yellow and green floral vase', 2300000.00, 12, 56, 0, 1, '2'),
(22, 'Premium vase 6', '14945_premium-vase-6.jpg', 'Elegant pink and white premium vase', 8500000.00, 18, 12, 0, 1, '2'),
(23, 'Premium vase 8', '14661_premium-vase-8.jpg', 'Mixed-color premium arrangement', 8000000.00, 10, 2, 0, 1, '2'),
(24, 'Luxury vase 29', '13645_luxury-vase-29.jpg', 'Yellow floral arrangement', 4200000.00, 14, 5, 0, 1, '2'),
(25, 'Vintage Love', 'bo-hoa-vintage-love.jpg.webp', 'Không cần cầu kì, bó hoa từ các loại hoa nhí trắng kết hợp tinh tế cùng giấy gói màu trắng hiện đại, tinh tế. Bó hoa mang phong cách vintage mà mọi cô gái đều yêu thích.', 150000.00, 5, 9, 0, 1, '3'),
(26, 'Da Diết', 'da-diet.jpg.webp', 'Một bó hoa xinh xắn thương được thiết kế từ những bông hoa cát tường trắng dễ thương sẽ là lựa chọn mới lạ để tặng một nửa của bạn vào những dịp đặc biệt. ', 280000.00, 7, 14, 0, 0, '3'),
(27, ' Pure Enchantment', 'pure-enchantment-1.jpg.webp', 'Tại Việt Nam, hoa mẫu đơn được xem là loài hoa của sự vương giả, giàu sang phú quý và quyền lực. Với vẻ đẹp nồng nàn, hấp dẫn, hoa mẫu đơn được tin rằng sẽ đem đến cho thân chủ nhiều may mắn và thuận lợi trong tình yêu. Một bó hoa mẫu đơn hồng nhạt thật to sẽ là món quà vô cùng sang trọng và đặc biệt, hơn nữa lại mang nhiều ý nghĩa tốt đẹp. Đừng quên gửi tặng kèm một lời chúc xinh xắn đến cho người nhận nhé.', 280000.00, 10, 5, 0, 0, '3'),
(28, 'Dáng Xinh', 'dang-xinh.jpg.webp', 'Sự kết hợp hài hòa giữa hoa mẫu đơn và hoa tulip xanh cùng hoa hồng và các loại hoa lá phụ cao cấp tạo nên một bó hoa đẹp xuất sắc. Bó hoa Dáng Xinh là lựa chọn hoàn hảo để gửi tặng vợ, Mẹ, bạn gái hoặc cấp trên vào những dịp đặc biệt.', 350000.00, 15, 99, 0, 1, '3'),
(29, 'Đỏ Thắm', 'bo-hoa-mau-don-do-tham.jpg.webp', 'Là sự kết hợp giữa hoa hồng đỏ nhập khẩu và hoa mẫu đơn hà lan. Nếu bạn cần một bó hoa sang trọng, cao cấp để tặng vợ, bạn gái hay người thân vào những dịp đặc biệt chắc chắn không thể bỏ qua mẫu hoa này.', 350000.00, 78, 167, 0, 0, '3'),
(30, 'Nồng Thắm', 'bo-hoa-hong-nong-tham.jpg.webp', 'Được tạo thành từ những bông hoa hồng kem nhã nhặn và dễ thương điểm xuyến thêm hoa baby trắng, bó hoa Nồng Thắm sẽ là một món quà đặc biệt dành tặng cho những người yêu thương.', 550000.00, 12, 164, 0, 1, '3'),
(31, ' Sắc Hoa', 'sac-hoa-1.jpg.webp', 'Sắc Hoa là sự kết hợp tuyệt đẹp của các loài hoa đầy sắc màu, mang đến vẻ đẹp rực rỡ và sống động. Bó hoa này tượng trưng cho niềm vui, hạnh phúc và hy vọng, như một bức tranh thiên nhiên tràn đầy năng lượng.', 500000.00, 10, 66, 0, 1, '3'),
(32, 'Có em', '13084_co-em.jpg', 'Delicate bouquet with roses', 330000.00, 59, 4, 0, 0, '3'),
(33, 'Chilling', '8441_chilling.png', 'Colorful arrangement of mixed flowers', 560185.00, 15, 34, 0, 1, '3'),
(34, 'Mây ngàn', '11613_may-ngan.jpg', 'Red and white floral arrangement', 550000.00, 51, 33, 0, 1, '3'),
(35, 'Hy Vọng', '5129_hy-vong.jpg', 'Yellow and white sunflower arrangement', 650000.00, 20, 121, 0, 1, '3'),
(36, 'Sound of love', '11610_sound-of-love.jpg', 'Pastel-themed flower basket', 450000.00, 81, 100, 0, 0, '3');

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
(1, 'admin', 'admin@gmail.com', '$2y$10$EEJca52zNM4q5dGaDxQNa.gB7Er9a9BG99oKLLkE64A.6dKIt4ETW', NULL, NULL, 'admin', '2024-11-10 17:32:49'),
(2, 'doan hong quan', 'quan@gmail.com', '$2y$10$EEJca52zNM4q5dGaDxQNa.gB7Er9a9BG99oKLLkE64A.6dKIt4ETW', '2', '1', 'customer', '2024-11-10 18:26:45'),
(4, 'hoang va ha', 'anhha19052004@gmail.com', '$2y$10$X/bje.DmXGcZ39GuBQE8BeK3fwXuWKJ6EGhR22vahkYQe10hct.Kq', '0366379629', 'Việt Nam', 'customer', '2024-11-30 10:42:25');

-- --------------------------------------------------------

--
-- Table structure for table `vnpay`
--

CREATE TABLE `vnpay` (
  `vnpay_id` int(11) NOT NULL,
  `vnpay_amount` varchar(50) NOT NULL,
  `vnpay_bankcode` varchar(50) NOT NULL,
  `vnpay_banktranno` varchar(50) NOT NULL,
  `vnpay_cardtype` varchar(50) NOT NULL,
  `vnpay_orderinfo` varchar(100) NOT NULL,
  `vnpay_paydate` varchar(50) NOT NULL,
  `vnpay_tmncode` varchar(50) NOT NULL,
  `vnpay_transactionno` varchar(50) NOT NULL,
  `order_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vnpay`
--

INSERT INTO `vnpay` (`vnpay_id`, `vnpay_amount`, `vnpay_bankcode`, `vnpay_banktranno`, `vnpay_cardtype`, `vnpay_orderinfo`, `vnpay_paydate`, `vnpay_tmncode`, `vnpay_transactionno`, `order_code`) VALUES
(1, '180000000', 'NCB', 'VNP14709755', 'ATM', 'Thanh toán đơn hàng qua VNPAY', '20241130175919', 'ZNFL1K4D', '14709755', '674aef98');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourite`
--
ALTER TABLE `favourite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `momo`
--
ALTER TABLE `momo`
  ADD PRIMARY KEY (`id_momo`);

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
-- Indexes for table `vnpay`
--
ALTER TABLE `vnpay`
  ADD PRIMARY KEY (`vnpay_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `favourite`
--
ALTER TABLE `favourite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `momo`
--
ALTER TABLE `momo`
  MODIFY `id_momo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vnpay`
--
ALTER TABLE `vnpay`
  MODIFY `vnpay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

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
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
