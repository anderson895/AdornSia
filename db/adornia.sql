-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 04:20 AM
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
(4, 'sweater', 'wadawd', 1);

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
(4, '00001', 'Shades', 300.00, 1, 1000, 'Shades', 1, 'product_6730aa5fab2941.49463037.png', '2024-11-10 20:50:04', 1, 45),
(5, '0002', 'product 88', 400.00, 2, 19, '', NULL, 'product_6730aa7cf16c52.90921138.png', '2024-11-10 20:51:46', 1, 10),
(6, '00003', 'Bag', 150.00, 2, 10, '', NULL, 'product_6730c69b798d70.40938167.png', '2024-11-10 22:43:39', 1, 8),
(7, '00005', 'Collection 1', 500.00, 2, 20, '', 1, 'product_6730ab28d9f315.89349768.png', '2024-11-10 20:46:32', 1, 58),
(8, '0006', 'Tshirt', 1500.00, 2, 44, 'qS', 1, 'product_6730abcc3bce93.50677965.png', '2024-11-10 21:37:09', 1, 10),
(9, '00006', 'Tshirt 1', 50.00, 3, 10, 'fsefesf', 2, 'product_6730ac31bacc99.31214733.png', '2024-11-10 20:50:57', 1, 5),
(10, '000042', 'produc 505', 100.00, 3, 5, '', NULL, 'product_6730c6bfd551a4.36366372.png', '2024-11-10 22:44:15', 1, 70);

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `promo_id` int(11) NOT NULL,
  `promo_name` varchar(60) NOT NULL,
  `promo_description` text NOT NULL,
  `promo_rate` float NOT NULL,
  `promo_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`promo_id`, `promo_name`, `promo_description`, `promo_rate`, `promo_status`) VALUES
(1, 'Christmas bonus', ' Christmas Bonus constitutes additional compensation provided to employees by their employer. The management holds complete discretion in determining the ', 0.5, 1),
(2, 'Valentines Day', '', 0.2, 1);

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
(64, 'joshua padilla', 'andersonandy046@gmail.com', '09454454744', 'andersonandy046@gmail.com', 1, NULL, '2024-11-11 11:24:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
