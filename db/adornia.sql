-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 01:23 AM
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
(20, 64, '031411014', 'Region III (Central Luzon) Bulacan Marilao Santa Rosa II', 0),
(21, 64, '012809029', 'Region I (Ilocos Region) Ilocos Norte Dingras San Francisco (Surrate)', 0),
(22, 64, '042105064', 'Region IV-A (CALABARZON) Cavite Cavite City Barangay 10-B (Kingfisher-B)', 1),
(23, 64, '031411001', 'Region III (Central Luzon) Bulacan Marilao Abangan Norte cornbeef', 0),
(24, 66, '031411014', 'Region III (Central Luzon) Bulacan Marilao Santa Rosa II tibagan', 1),
(25, 66, '031411004', 'Region III (Central Luzon) Bulacan Marilao Lambakin ilang ilang street', 0);

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

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `cart_user_id`, `cart_prod_id`, `cart_Qty`, `cart_prod_size`) VALUES
(12, 0, 0, 1, ''),
(16, 64, 10, 4, 'Not Selected'),
(17, 64, 5, 8, 'Not Selected'),
(18, 64, 7, 1, 'Not Selected'),
(22, 66, 14, 12, '5 feet'),
(23, 66, 14, 1, '10 feet'),
(24, 66, 14, 1, '2 feet');

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
  `order_mode_of_payment` varchar(255) NOT NULL,
  `proof of payment` varchar(255) NOT NULL,
  `subtotal` decimal(10,3) NOT NULL,
  `vat` float NOT NULL,
  `sf` int(11) NOT NULL,
  `total` decimal(10,3) NOT NULL,
  `order_date` decimal(10,3) NOT NULL,
  `delivered_date` decimal(10,3) NOT NULL,
  `status` int(11) NOT NULL,
  `reject_reason` varchar(255) NOT NULL,
  `proof_of_del` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, '00001', 'Shades', 300.00, 1, 1000, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore recusandae consequuntur numquam assumenda at, voluptates rem ad. Ducimus et aspernatur eligendi in ipsa adipisci eaque, dicta consequatur harum eveniet. Totam corrupti, perspiciatis, nobis beatae autem assumenda architecto non illum consectetur a eveniet hic. Eius officiis dignissimos aliquid est labore nesciunt quidem deserunt reiciendis dolores consequuntur laboriosam qui porro nulla assumenda sunt fuga cumque fugiat, numquam, quae voluptatem soluta. Ipsam, nulla? Itaque velit, fugiat illo reprehenderit nulla veritatis alias similique! Sit voluptatibus mollitia quasi temporibus dicta voluptas nemo quis?', 1, 'product_6730aa5fab2941.49463037.png', '2024-11-12 19:40:54', 1, 50),
(5, '0002', 'product 88', 400.00, 2, 19, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore recusandae consequuntur numquam assumenda at, voluptates rem ad. Ducimus et aspernatur eligendi in ipsa adipisci eaque, dicta consequatur harum eveniet. Totam corrupti, perspiciatis, nobis beatae autem assumenda architecto non illum consectetur a eveniet hic. Eius officiis dignissimos aliquid est labore nesciunt quidem deserunt reiciendis dolores consequuntur laboriosam qui porro nulla assumenda sunt fuga cumque fugiat, numquam, quae voluptatem soluta. Ipsam, nulla? Itaque velit, fugiat illo reprehenderit nulla veritatis alias similique! Sit voluptatibus mollitia quasi temporibus dicta voluptas nemo quis?', NULL, 'product_6730aa7cf16c52.90921138.png', '2024-11-11 13:24:40', 1, 10),
(6, '00003', 'Bag', 150.00, 2, 10, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore recusandae consequuntur numquam assumenda at, voluptates rem ad. Ducimus et aspernatur eligendi in ipsa adipisci eaque, dicta consequatur harum eveniet. Totam corrupti, perspiciatis, nobis beatae autem assumenda architecto non illum consectetur a eveniet hic. Eius officiis dignissimos aliquid est labore nesciunt quidem deserunt reiciendis dolores consequuntur laboriosam qui porro nulla assumenda sunt fuga cumque fugiat, numquam, quae voluptatem soluta. Ipsam, nulla? Itaque velit, fugiat illo reprehenderit nulla veritatis alias similique! Sit voluptatibus mollitia quasi temporibus dicta voluptas nemo quis?', NULL, 'product_6730c69b798d70.40938167.png', '2024-11-12 19:40:56', 1, 8),
(7, '00005', 'Collection 1', 500.00, 2, 20, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore recusandae consequuntur numquam assumenda at, voluptates rem ad. Ducimus et aspernatur eligendi in ipsa adipisci eaque, dicta consequatur harum eveniet. Totam corrupti, perspiciatis, nobis beatae autem assumenda architecto non illum consectetur a eveniet hic. Eius officiis dignissimos aliquid est labore nesciunt quidem deserunt reiciendis dolores consequuntur laboriosam qui porro nulla assumenda sunt fuga cumque fugiat, numquam, quae voluptatem soluta. Ipsam, nulla? Itaque velit, fugiat illo reprehenderit nulla veritatis alias similique! Sit voluptatibus mollitia quasi temporibus dicta voluptas nemo quis?', 1, 'product_6730ab28d9f315.89349768.png', '2024-11-11 13:24:46', 1, 58),
(8, '0006', 'Tshirt', 1500.00, 4, 44, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore recusandae consequuntur numquam assumenda at, voluptates rem ad. Ducimus et aspernatur eligendi in ipsa adipisci eaque, dicta consequatur harum eveniet. Totam corrupti, perspiciatis, nobis beatae autem assumenda architecto non illum consectetur a eveniet hic. Eius officiis dignissimos aliquid est labore nesciunt quidem deserunt reiciendis dolores consequuntur laboriosam qui porro nulla assumenda sunt fuga cumque fugiat, numquam, quae voluptatem soluta. Ipsam, nulla? Itaque velit, fugiat illo reprehenderit nulla veritatis alias similique! Sit voluptatibus mollitia quasi temporibus dicta voluptas nemo quis?', 1, 'product_6730abcc3bce93.50677965.png', '2024-11-12 19:41:06', 1, 10),
(9, '00006', 'Tshirt 1', 50.00, 3, 10, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore recusandae consequuntur numquam assumenda at, voluptates rem ad. Ducimus et aspernatur eligendi in ipsa adipisci eaque, dicta consequatur harum eveniet. Totam corrupti, perspiciatis, nobis beatae autem assumenda architecto non illum consectetur a eveniet hic. Eius officiis dignissimos aliquid est labore nesciunt quidem deserunt reiciendis dolores consequuntur laboriosam qui porro nulla assumenda sunt fuga cumque fugiat, numquam, quae voluptatem soluta. Ipsam, nulla? Itaque velit, fugiat illo reprehenderit nulla veritatis alias similique! Sit voluptatibus mollitia quasi temporibus dicta voluptas nemo quis?', 2, 'product_6730ac31bacc99.31214733.png', '2024-11-11 13:24:52', 1, 5),
(10, '000042', 'produc 505', 100.00, 3, 5, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore recusandae consequuntur numquam assumenda at, voluptates rem ad. Ducimus et aspernatur eligendi in ipsa adipisci eaque, dicta consequatur harum eveniet. Totam corrupti, perspiciatis, nobis beatae autem assumenda architecto non illum consectetur a eveniet hic. Eius officiis dignissimos aliquid est labore nesciunt quidem deserunt reiciendis dolores consequuntur laboriosam qui porro nulla assumenda sunt fuga cumque fugiat, numquam, quae voluptatem soluta. Ipsam, nulla? Itaque velit, fugiat illo reprehenderit nulla veritatis alias similique! Sit voluptatibus mollitia quasi temporibus dicta voluptas nemo quis?', NULL, 'product_6730c6bfd551a4.36366372.png', '2024-11-11 13:24:55', 1, 70),
(12, '00006', 'Boxer Shorts', 150.00, 3, 10, 'The world\'s largest selection of products at your fingertips. ... Order before 12NN and get your package on the same day in select stores. ... Have your items ...', 2, 'product_67319bd1054c89.00751699.png', '2024-11-11 13:53:21', 1, 50),
(13, 'test', 'test', 234.00, 1, 234, 'test', 1, 'product_6731a82c6f2047.42594182.png', '2024-11-11 14:46:04', 1, 234),
(14, '050505', 'HAZEL', 500.00, 2, 10, 'gdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhggdzrkjhg', 1, 'product_67333fcdd53c37.86791080.jpg', '2024-11-12 19:45:17', 1, 50);

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
(1, 'XL', 12, 1),
(2, 'S', 12, 1),
(3, 'SM', 12, 1),
(4, '10 feet', 14, 1),
(5, '2 feet', 14, 1),
(6, '5 feet', 14, 1);

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
(1, 'Christmas bonus', ' Christmas Bonus constitutes additional compensation provided to employees by their employer. The management holds complete discretion in determining the ', 0.5, 1, '2024-11-09'),
(2, 'Valentines Day', '', 0.2, 1, '2024-11-12');

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
  ADD PRIMARY KEY (`cart_id`);

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
  ADD PRIMARY KEY (`proof of payment`);

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
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ewallet`
--
ALTER TABLE `ewallet`
  MODIFY `e_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`size_prod_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
