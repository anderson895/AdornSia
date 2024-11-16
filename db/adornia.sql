-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 08:12 AM
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
-- Database: `adornia`
--

-- --------------------------------------------------------

--
-- Table structure for table `address_user`
--

CREATE TABLE `address_user` (
  `ad_id` int(11) NOT NULL,
  `ad_user_id` int(11) NOT NULL,
  `ad_address_code` varchar(255) NOT NULL,
  `ad_complete_address` varchar(255) NOT NULL,
  `ad_status` int(11) NOT NULL COMMENT '0=disable, 1=enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address_user`
--

INSERT INTO `address_user` (`ad_id`, `ad_user_id`, `ad_address_code`, `ad_complete_address`, `ad_status`) VALUES
(26, 64, '012801001', 'Region I (Ilocos Region) Ilocos Norte Adams Adams (Pob.) tibagan', 1),
(27, 64, '012802008', 'Region I (Ilocos Region) Ilocos Norte Bacarra Casilian dddd', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(60) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_fullname` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`, `admin_fullname`) VALUES
(1, 'admin', 'admin', 'Juan Dela Cruz');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `cart_user_id` int(11) NOT NULL,
  `cart_prod_id` int(11) NOT NULL,
  `cart_Qty` int(11) NOT NULL,
  `cart_prod_size` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(60) NOT NULL,
  `category_description` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=InActive 1=Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_description`, `status`) VALUES
(1, 'accessories', 'ACCESSORY is an object or device that is not essential in it', 1),
(2, 'hoodies', 'Hoodies & Sweatshirts at Nike.com. Free delivery and returns on select orders.', 1),
(3, 'short', 'sell (stocks or other securities or commodities) in advance of acquiring them, with the aim of making a profit when the price falls.', 1),
(4, 'sweater', 'A sweater (North American English) or pullover, also called a jersey or jumper (British English and Australian English), is a piece of clothing, typically with long sleeves, made of knitted or crocheted material that covers the upper part of the body.', 1),
(5, 'tees', 'A T-shirt (also spelled tee shirt, or tee for short) is a style of fabric shirt named after the T shape of its body and sleeves. Traditionally, it has short sleeves and a round neckline, known as a crew neck, which lacks a collar.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ewallet`
--

CREATE TABLE `ewallet` (
  `e_id` int(11) NOT NULL,
  `e_wallet_name` varchar(60) NOT NULL,
  `e_img` varchar(255) NOT NULL,
  `e_wallet_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=disabled, 1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ewallet`
--

INSERT INTO `ewallet` (`e_id`, `e_wallet_name`, `e_img`, `e_wallet_status`) VALUES
(1, 'Gcash', 'Gcash.webp', 1),
(2, 'maya', 'maya.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_code` varchar(255) NOT NULL,
  `order_user_id` int(11) NOT NULL,
  `mode_of_payment` varchar(255) NOT NULL,
  `proof_of_payment` varchar(255) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `vat` float NOT NULL,
  `sf` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL,
  `delivered_date` decimal(10,2) DEFAULT NULL,
  `order_status` varchar(60) NOT NULL,
  `reject_reason` varchar(255) DEFAULT NULL,
  `proof_of_del` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `order_user_id`, `mode_of_payment`, `proof_of_payment`, `subtotal`, `vat`, `sf`, `total`, `delivery_address`, `order_date`, `delivered_date`, `order_status`, `reject_reason`, `proof_of_del`) VALUES
(114, '39FBA927', 64, 'Gcash', 'proof_6738139fb960b1.66859655.jpeg', 470.00, 56.4, NULL, 526.40, 'Region I (Ilocos Region) Ilocos Norte Adams Adams (Pob.) tibagan', '2024-11-16 11:38:07', NULL, 'Accept', NULL, NULL),
(115, '99CD5031', 64, 'cod', NULL, 651.00, 78.12, NULL, 729.12, 'Region I (Ilocos Region) Ilocos Norte Adams Adams (Pob.) tibagan', '2024-11-16 13:11:56', NULL, 'Pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders_item`
--

CREATE TABLE `orders_item` (
  `item_id` int(11) NOT NULL,
  `item_order_id` int(11) NOT NULL,
  `item_product_id` int(11) NOT NULL,
  `item_size` varchar(60) DEFAULT NULL,
  `item_qty` int(11) NOT NULL,
  `item_product_price` decimal(10,0) NOT NULL,
  `promo_discount` varchar(255) DEFAULT NULL,
  `item_total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_item`
--

INSERT INTO `orders_item` (`item_id`, `item_order_id`, `item_product_id`, `item_size`, `item_qty`, `item_product_price`, `promo_discount`, `item_total`) VALUES
(165, 114, 18, 'SM', 1, 150, '{\"promoName\":\"Christmas bonus\",\"promoRate\":\"0.5\"}', 150),
(166, 114, 19, 'L', 1, 320, '{\"promoName\":\"Valentines Day\",\"promoRate\":\"0.2\"}', 320),
(167, 115, 15, 'Not Selected', 2, 250, '{\"promoName\":\"Christmas bonus\",\"promoRate\":\"0.5\"}', 500),
(168, 115, 18, 'SM', 1, 150, '{\"promoName\":\"Christmas bonus\",\"promoRate\":\"0.5\"}', 150),
(169, 115, 26, 'Not Selected', 1, 1, '{\"promoName\":\"Christmas bonus\",\"promoRate\":\"0.5\"}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_id` int(11) NOT NULL,
  `prod_code` varchar(60) NOT NULL,
  `prod_name` varchar(60) NOT NULL,
  `prod_currprice` decimal(10,2) NOT NULL,
  `prod_category_id` int(11) NOT NULL,
  `prod_critical` int(11) NOT NULL,
  `prod_description` text NOT NULL,
  `prod_promo_id` int(11) DEFAULT NULL,
  `prod_image` varchar(255) NOT NULL,
  `prod_added` datetime NOT NULL,
  `prod_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=Not Active,\r\n1=Active,\r\n3=Archive',
  `product_stocks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_code`, `prod_name`, `prod_currprice`, `prod_category_id`, `prod_critical`, `prod_description`, `prod_promo_id`, `prod_image`, `prod_added`, `prod_status`, `product_stocks`) VALUES
(15, '0001', 'shades', 250.00, 1, 10, 'Shades Accessories · Sunglasses Chain Diy, Glasses Frames Trendy, Festival Sunglasses, Sunglasses Chain, Fashion Eye · Kacamata Fashion, Celebrity Casual', 1, 'product_67356084abb416.35727954.png', '2024-11-14 10:29:24', 1, 5),
(16, '0002', 'Bag 1', 300.00, 1, 50, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', 1, 'product_673560e2e77e51.22127315.png', '2024-11-14 10:30:58', 1, 100),
(17, '0003', 'Bag 2', 300.00, 1, 10, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', NULL, 'product_67356121cfe654.79399269.png', '2024-11-14 10:32:01', 1, 10),
(18, '0004', 'Bag 4', 300.00, 1, 15, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', 1, 'product_6735615876d684.97140108.png', '2024-11-14 10:32:56', 1, 15),
(19, '0005', 'White Bags', 400.00, 1, 10, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', 2, 'product_6735618f606390.62713720.png', '2024-11-14 10:33:51', 1, 50),
(20, '0006', 'The Accent Bag', 1500.00, 2, 10, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', 1, 'product_673561bd2c3605.83231922.png', '2024-11-14 10:34:37', 1, 50),
(21, '0007', 'Hood 1', 3500.00, 2, 10, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', 1, 'product_673561ef5a2965.37814696.png', '2024-11-14 10:35:27', 1, 99),
(22, '0008', 'Hood 2', 4500.00, 2, 10, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', NULL, 'product_6735622c58f638.21901723.png', '2024-11-14 10:36:28', 1, 10),
(23, '0009', 'White Hoodies', 5000.00, 2, 10, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', 1, 'product_6735625fddc5a1.20092356.png', '2024-11-14 10:37:19', 1, 100),
(24, '0010', 'Short 1', 150.00, 3, 10, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', NULL, 'product_67356292281fc9.44794739.png', '2024-11-14 10:38:10', 1, 10),
(25, '0011', 'short 2', 160.00, 3, 10, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', NULL, 'product_673562b7399d94.75187942.png', '2024-11-14 10:38:47', 1, 66),
(26, '0012', 'Sweeter 1', 3000.00, 4, 50, '', 1, 'product_673562de1eb309.51891056.png', '2024-11-14 10:39:26', 1, 100),
(27, '0013', 'Tees 1', 1300.00, 5, 50, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', 1, 'product_67356306c468c5.02306630.png', '2024-11-14 10:40:06', 1, 15),
(28, '0014', 'Black Tees', 2500.00, 5, 10, 'Purse accessories are fashion accessories that are made specifically for handbags, to enhance their functionality or appearance.', 2, 'product_6735633bc0b540.00223420.png', '2024-11-14 10:40:59', 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(60) NOT NULL,
  `size_prod_id` int(11) NOT NULL,
  `size_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`size_id`, `size_name`, `size_prod_id`, `size_status`) VALUES
(7, 'SM', 16, 1),
(8, 'L', 16, 1),
(9, 'XL', 16, 1),
(10, 'SM', 17, 1),
(11, 'M', 17, 1),
(12, 'L', 17, 1),
(13, 'XL', 17, 1),
(14, 'SM', 18, 1),
(15, 'S', 19, 1),
(16, 'L', 19, 1),
(17, 'XL', 20, 1),
(18, 'SM', 21, 1),
(19, 'L', 21, 1),
(20, 'SM', 22, 1),
(21, 'L', 22, 1),
(22, 'M', 22, 1),
(23, 'XL', 22, 1),
(24, 'S', 23, 1),
(25, 'M', 23, 1),
(26, 'L', 23, 1),
(27, 'XL', 23, 1),
(28, 'SM', 24, 1),
(29, 'M', 24, 1),
(30, 'SM', 27, 1);

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `promo_id` int(11) NOT NULL,
  `promo_name` varchar(60) NOT NULL,
  `promo_description` text NOT NULL,
  `promo_rate` float NOT NULL,
  `promo_status` int(11) NOT NULL DEFAULT 1,
  `promo_expiration` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`promo_id`, `promo_name`, `promo_description`, `promo_rate`, `promo_status`, `promo_expiration`) VALUES
(1, 'Christmas bonus', ' Christmas Bonus constitutes additional compensation provided to employees by their employer. The management holds complete discretion in determining the ', 0.5, 1, '2024-12-09'),
(2, 'Valentines Day', '', 0.2, 1, '2024-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `Fullname` varchar(60) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Phone` varchar(60) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Not Verified,1=Verified',
  `verificationKey` varchar(255) DEFAULT NULL,
  `link_expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `Fullname`, `Email`, `Phone`, `Password`, `status`, `verificationKey`, `link_expiration`) VALUES
(64, 'joshua padilla', 'andersonandy046@gmail.com', '09454454744', 'andersonandy046@gmail.com', 1, NULL, '2024-11-11 11:24:29'),
(66, 'joshua padilla', 'joshuaandersonpadilla8@gmail.com', '09454454744', 'joshuaandersonpadilla8@gmail.com', 1, NULL, '2024-11-12 19:37:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address_user`
--
ALTER TABLE `address_user`
  ADD PRIMARY KEY (`ad_id`),
  ADD KEY `ad_user_id` (`ad_user_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cart_prod_id` (`cart_prod_id`),
  ADD KEY `cart_user_id` (`cart_user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `ewallet`
--
ALTER TABLE `ewallet`
  ADD PRIMARY KEY (`e_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `item_order_id` (`item_order_id`),
  ADD KEY `item_product_id` (`item_product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`size_id`),
  ADD KEY `size_prod_id` (`size_prod_id`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`promo_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address_user`
--
ALTER TABLE `address_user`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ewallet`
--
ALTER TABLE `ewallet`
  MODIFY `e_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `orders_item`
--
ALTER TABLE `orders_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address_user`
--
ALTER TABLE `address_user`
  ADD CONSTRAINT `address_user_ibfk_1` FOREIGN KEY (`ad_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`cart_prod_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`cart_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD CONSTRAINT `orders_item_ibfk_1` FOREIGN KEY (`item_order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_item_ibfk_2` FOREIGN KEY (`item_product_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`size_prod_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
