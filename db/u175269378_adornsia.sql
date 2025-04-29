-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 06:59 AM
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
-- Database: `u175269378_adornsia`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL,
  `log_name` varchar(60) NOT NULL,
  `log_role` varchar(60) NOT NULL,
  `log_date` datetime NOT NULL,
  `log_activity` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`log_id`, `log_name`, `log_role`, `log_date`, `log_activity`) VALUES
(3, 'admin', 'Administrator', '2024-11-25 22:45:34', 'Update CLASSIC TOTE BAG'),
(10, 'admin', 'Administrator', '2024-11-25 23:30:13', 'LVZ HOODIE StockIn + 6'),
(11, 'admin', 'Administrator', '2024-11-25 23:30:57', 'LVZ TOTE StockOut - 24'),
(13, 'andy', 'Administrator', '2024-11-25 23:51:27', 'LVZ TOTE StockIn + 5'),
(14, 'andy', 'Administrator', '2024-11-25 23:52:39', 'Update LVZ TOTE'),
(15, 'admin', 'Administrator', '2024-11-25 23:55:01', 'Update LVZ TOTE'),
(16, 'admin', 'Administrator', '2024-11-25 23:56:44', 'Update LVZ TOTE'),
(17, 'admin', 'Administrator', '2024-11-25 23:57:04', 'Update LVZ TOTE'),
(18, 'admin', 'Administrator', '2024-11-25 23:58:02', 'Update LFFP TOTE'),
(19, 'admin', 'Administrator', '2024-11-26 00:02:07', 'Update Emblem Crewneck'),
(20, 'admin', 'Administrator', '2024-11-26 00:02:44', 'Update Emblem Crewneck'),
(21, 'admin', 'Administrator', '2024-11-26 00:03:04', 'Update Emblem Crewneck'),
(22, 'admin', 'Administrator', '2024-11-26 00:03:18', 'Update TEN TOES DOWN HOODIE'),
(23, 'admin', 'Administrator', '2024-11-26 00:03:29', 'Update LVZ HOODIE'),
(24, 'admin', 'Administrator', '2024-11-26 00:03:37', 'Update WE BE ALRIGHT HOODIE'),
(25, 'admin', 'Administrator', '2024-11-26 00:04:19', 'Update WE BE ALRIGHT HOODIE'),
(26, 'admin', 'Administrator', '2024-11-26 00:04:36', 'Update LVZ HOODIE'),
(27, 'admin', 'Administrator', '2024-11-26 00:06:46', 'Update SINNERS HOODIE'),
(28, 'andy', 'Administrator', '2024-11-26 00:07:19', 'Added test'),
(29, 'admin', 'Administrator', '2024-11-26 00:15:43', 'Added STRAWBERRY HOODIE'),
(30, 'admin', 'Administrator', '2024-11-26 00:19:59', 'Added test1'),
(31, 'admin', 'Administrator', '2024-11-26 00:20:45', 'Added STRAWBERRY HOODIE'),
(32, 'admin', 'Administrator', '2024-11-26 00:21:40', 'Added test2'),
(33, 'admin', 'Administrator', '2024-11-26 00:56:29', 'FYP Tee StockOut - 1'),
(34, 'admin', 'Administrator', '2025-04-29 12:57:28', 'LVZ TOTE StockOut - 1'),
(35, 'admin', 'Administrator', '2025-04-29 12:57:28', 'The 1983 StockOut - 1'),
(36, 'admin', 'Administrator', '2025-04-29 12:57:44', 'Vultures Tee StockOut - 1');

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
(27, 64, '012802008', 'Region I (Ilocos Region) Ilocos Norte Bacarra Casilian dddd', 0),
(28, 66, '031411011', 'Region III (Central Luzon) Bulacan Marilao Prenza I bayan bayanan street', 1),
(29, 69, '031423005', 'Region III (Central Luzon) Bulacan Santa Maria Camangyanan ', 1),
(30, 67, '012802008', 'Region I (Ilocos Region) Ilocos Norte Bacarra Casilian ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(60) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_fullname` varchar(60) NOT NULL,
  `admin_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`, `admin_fullname`, `admin_status`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Juan Dela Cruz', 1),
(7, 'andy', '6177321eac992341d1ad0823a07e76bfc4ee6909db120e377ea303fdc216756c', 'Joshua Padilla', 1);

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

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `cart_user_id`, `cart_prod_id`, `cart_Qty`, `cart_prod_size`) VALUES
(230, 69, 21, 2, 'SM');

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
(146, '70C44C0C', 64, 'cod', NULL, 650.00, 78, 50.00, 778.00, 'Region I (Ilocos Region) Ilocos Norte Adams Adams (Pob.) tibagan', '2023-11-22 22:37:00', NULL, 'Shipped', NULL, NULL),
(156, '673D734B', 64, 'cod', NULL, 19500.00, 2340, 50.00, 21890.00, 'Region I (Ilocos Region) Ilocos Norte Adams Adams (Pob.) tibagan', '2024-11-22 23:42:43', NULL, 'Pending', NULL, NULL),
(157, 'E83DF642', 67, 'cod', NULL, 7200.00, 864, 50.00, 8114.00, 'Region I (Ilocos Region) Ilocos Norte Bacarra Casilian ', '2024-11-25 09:10:27', NULL, 'Accept', NULL, NULL),
(159, 'BD39823D', 67, 'cod', NULL, 908.60, 109.03, 50.00, 1067.63, 'Region I (Ilocos Region) Ilocos Norte Bacarra Casilian ', '2024-11-26 00:54:43', NULL, 'Delivered', NULL, NULL),
(160, 'BF417EC8', 67, 'Gcash', 'proof_6744abf417e5f9.68956097.jpg', 559.30, 67.12, 50.00, 676.42, 'Region I (Ilocos Region) Ilocos Norte Bacarra Casilian ', '2024-11-26 00:55:16', NULL, 'Shipped', NULL, NULL);

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
  `item_product_price` decimal(10,2) NOT NULL,
  `promo_discount` varchar(255) DEFAULT NULL,
  `item_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_item`
--

INSERT INTO `orders_item` (`item_id`, `item_order_id`, `item_product_id`, `item_size`, `item_qty`, `item_product_price`, `promo_discount`, `item_total`) VALUES
(215, 146, 27, 'SM', 1, 1300.00, '{\"promoName\":\"Christmas bonus\",\"promoRate\":0.5}', 650.00),
(230, 156, 23, 'M', 4, 5000.00, '{\"promoName\":\"Christmas bonus\",\"promoRate\":0.5}', 10000.00),
(231, 156, 28, 'N/A', 4, 2500.00, '{\"promoName\":\"Valentines Day\",\"promoRate\":0.2}', 8000.00),
(232, 156, 24, 'M', 10, 150.00, '{\"promoName\":\"\",\"promoRate\":\"\"}', 1500.00),
(233, 157, 16, 'XL', 24, 300.00, '{\"promoName\":\"Christmas bonus\",\"promoRate\":0.6}', 7200.00),
(235, 159, 16, 'XL', 1, 649.00, '{\"promoName\":\"Christmas bonus\",\"promoRate\":0.6}', 259.60),
(236, 159, 15, 'N/A', 1, 649.00, '{\"promoName\":\"\",\"promoRate\":\"\"}', 649.00),
(237, 160, 28, 'N/A', 1, 799.00, '{\"promoName\":\"Valentines Day\",\"promoRate\":0.3}', 559.30);

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
(15, '0001', 'The 1983', 649.00, 1, 10, 'Unequaled confidence and rebelliousness.', NULL, 'product_67356084abb416.35727954.png', '2024-11-25 22:44:40', 1, 69),
(16, '0002', 'LVZ TOTE', 649.00, 1, 50, 'Love Yourz; a tribute to authenticity. Embrace who you are.', 1, 'product_673560e2e77e51.22127315.png', '2024-11-25 23:57:04', 1, 16),
(17, '0003', 'WE BE ALRIGHT TOTE', 649.00, 1, 10, '\"Finding strength in unity; embracing resilience. Together, we rise.\"', NULL, 'product_67356121cfe654.79399269.png', '2024-11-25 20:51:33', 1, 20),
(18, '0004', 'NOIR TOTE BAG', 649.00, 1, 15, '\"NOIR\" Tote bag. For your daily needs.', 1, 'product_6735615876d684.97140108.png', '2024-11-25 20:52:15', 1, 3),
(19, '0005', 'Suede Large Shell Bag', 749.00, 1, 10, 'A minimalist.', 2, 'product_6735618f606390.62713720.png', '2024-11-25 20:52:40', 1, 39),
(20, '0006', 'CLASSIC TOTE BAG', 649.00, 1, 11, '\r\nClassic Tote bag. For your daily needs.\r\n', 1, 'product_673561bd2c3605.83231922.png', '2024-11-25 22:45:34', 1, 46),
(21, '0007', 'WE BE ALRIGHT HOODIE', 1699.00, 2, 10, '\r\n\"Finding strength in unity; embracing resilience. Together, we rise.\"', 1, 'product_673561ef5a2965.37814696.png', '2024-11-26 00:04:19', 1, 100),
(22, '0008', 'LVZ HOODIE', 1699.00, 2, 10, '\r\n\r\n\"Love Yourz; a tribute to authenticity. Embrace who you are.\"\r\n', NULL, 'product_6735622c58f638.21901723.png', '2024-11-26 00:04:36', 1, 8),
(23, '0009', 'TEN TOES DOWN HOODIE', 1699.00, 2, 10, 'Sit down, be humble.', 1, 'product_6735625fddc5a1.20092356.png', '2024-11-26 00:03:18', 1, 78),
(24, '0010', 'LFFP SHORT', 599.00, 3, 10, 'Losing friends; finding peace. Honestly, never mind', NULL, 'product_67356292281fc9.44794739.png', '2024-11-25 20:57:58', 1, 0),
(25, '0011', 'HUMAN BEING SHORT', 599.00, 3, 10, '\"Celebrating individuality; embracing our shared journey. Just be you.\"', NULL, 'product_673562b7399d94.75187942.png', '2024-11-25 20:58:22', 1, 66),
(26, '0012', 'Emblem Crewneck', 1699.00, 4, 50, 'Our emblem logo is the streetwear stamp of approval.', 1, 'product_673562de1eb309.51891056.png', '2024-11-26 00:03:04', 1, 99),
(27, '0013', 'Vultures Tee', 899.00, 5, 50, 'Destroy culture vultures.', 1, 'product_67356306c468c5.02306630.png', '2024-11-25 21:00:36', 1, 12),
(28, '0014', 'FYP Tee', 799.00, 5, 10, 'Find the balance, find your peace.', 2, 'product_6735633bc0b540.00223420.png', '2024-11-25 20:59:44', 1, 0),
(29, '0015', 'LFFP TOTE', 649.00, 1, 10, 'Losing friends; finding peace. Honestly, never mind.', NULL, 'product_674473a7db6de0.35179487.png', '2024-11-25 23:58:02', 1, 50),
(32, '0016', 'SINNERS HOODIE', 1699.00, 2, 333, 'Within the chambers of introspection, sinners grapple with the resonances of their transgressions, nuanced shadows cast by the complexity of their deeds that persist as spectral echoes within the depths of their souls.', NULL, 'product_6744a0968033f0.97984351.png', '2024-11-26 00:06:46', 1, 33),
(33, 'test', 'test', 0.00, 1, 44, 'Price', 1, 'product_6744a0b7d20cc4.61909596.png', '2024-11-26 00:07:19', 0, 23),
(34, '00017', 'test1', 1997.00, 4, 5, '', 0, 'product_6744a3af08ae27.04236974.png', '2024-11-26 00:19:59', 1, 20),
(35, '00018', 'test2', 1876.00, 1, 5, '', 0, 'product_6744a414571467.82170271.png', '2024-11-26 00:21:40', 1, 20);

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
(30, 'SM', 27, 1),
(31, '35', 32, 1),
(32, '333', 33, 1);

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
(1, 'Christmas bonus', ' Christmas Bonus constitutes additional compensation provideds', 0.6, 1, '2024-12-09'),
(2, 'Valentines Day', 'wadawd', 0.3, 1, '2024-12-12'),
(3, 'awd', 'awdawdwa', 0.3, 0, '2024-11-27');

-- --------------------------------------------------------

--
-- Table structure for table `refund`
--

CREATE TABLE `refund` (
  `ref_id` int(11) NOT NULL,
  `ref_item_id` int(11) NOT NULL,
  `ref_reason` varchar(60) NOT NULL,
  `ref_date` datetime NOT NULL,
  `ref_status` varchar(60) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Profile_images` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Not Verified,1=Verified',
  `verificationKey` varchar(255) DEFAULT NULL,
  `link_expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `Fullname`, `Email`, `Phone`, `Password`, `Profile_images`, `status`, `verificationKey`, `link_expiration`) VALUES
(64, 'joshua padilla', 'andersonandy@gmail.com', '09454454745', 'andersonandy@gmail.com', 'profile_673e9ca87af7e9.06053758.jpg', 1, NULL, '2024-11-11 11:24:29'),
(66, 'Maloi Ricalde', 'maloiricalde@gmail.com', '09454454744', 'joshuaandersonpadilla8@gmail.com', 'profile_673c3064c21b99.86614197.jpg', 1, NULL, '2024-11-12 19:37:50'),
(67, 'Joshua Anderson Raymundo Padilla', 'andersonandy046@gmail.com', '(0977) 098-7020', 'andersonandy046@gmail.com', NULL, 1, '990ff230d647f77391f9a7074be734d7', '2024-11-21 23:11:16'),
(68, 'Hazel Ann', 'annzeap@gmail.com', '09183169001', 'hazelannp', NULL, 0, 'cb6da45b14c5568a913dd15eddb62a2b', '2024-11-22 00:24:16'),
(69, 'April Jane De Leon', 'apriljane@gmail.com', '094544547444', 'apriljane@gmail.com', 'profile_673fe5203248d2.43088624.jpg', 1, NULL, '2024-11-22 07:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wish_id` int(11) NOT NULL,
  `wish_user_id` int(11) NOT NULL,
  `wish_prod_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wish_id`, `wish_user_id`, `wish_prod_id`) VALUES
(10, 64, 16),
(11, 69, 17),
(12, 67, 28);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`);

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
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_user_id` (`order_user_id`);

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
-- Indexes for table `refund`
--
ALTER TABLE `refund`
  ADD PRIMARY KEY (`ref_id`),
  ADD KEY `ref_item_id` (`ref_item_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wish_id`),
  ADD KEY `wish_prod_id` (`wish_prod_id`),
  ADD KEY `wish_user_id` (`wish_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `address_user`
--
ALTER TABLE `address_user`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `orders_item`
--
ALTER TABLE `orders_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `refund`
--
ALTER TABLE `refund`
  MODIFY `ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`order_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Constraints for table `refund`
--
ALTER TABLE `refund`
  ADD CONSTRAINT `refund_ibfk_1` FOREIGN KEY (`ref_item_id`) REFERENCES `orders_item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`wish_prod_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`wish_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
