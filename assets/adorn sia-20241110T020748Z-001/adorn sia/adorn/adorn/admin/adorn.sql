-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2024 at 03:29 PM
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
-- Database: `adorn`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(10) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_category_name` varchar(50) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_description` TEXT NOT NULL,  -- Changed to TEXT
  `product_price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_image`, `product_category_name`, `product_name`, `product_description`, `product_price`) VALUES
(5, 'sdasdasd', '14', 'gin', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 1000),
(7, 'drink3.png', '15', 'gfgh', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 100000),
(9, 'Screenshot 2023-03-10 104358.png', '15', 'kjk', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 30),
(10, 'upgrade.jpg', '16', 'kjk', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 69),
(14, 'play.png', '16', 'kiffy', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 65),
(15, 'products/7a8320159289f93dae589fae75dc90a5img.png', '14', 'try', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 123),
(16, 'products/63571e42f70ab585e4208af377aacafbzoefront.png', '16', 'juweh', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 548),
(17, 'products/5d30ad17c48df345021ec4854ab41911WIN_20240318_19_14_17_Pro.jpg', '16', 'lablab', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 1216),
(18, 'products/1add3061091f91301b43efb5594802eedouble.png', '14', 'kjfsd', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 84),
(19, 'products/c70208a47b026c1866039430d52b6348tutorial__1_.png', '14', 'sdfs,fdm', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 342),
(20, 'products/34d3e3c41f7629fda9287a60e58082b4poster.png', '15', 'poster', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 65),
(21, 'products/d64825773062c2afaa0632e5e836938amoveinout.png', '15', 'black label', 'hjahkajhkjshkjhsjgjhakjahjkahjhahja', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_category_id` int(10) NOT NULL,
  `product_category_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_category_id`, `product_category_name`) VALUES
(14, 'Tees'),
(15, 'Shorts'),
(16, 'Hoodies')
(17, 'Sweaters'),
(18, 'Hoodies'),
(19, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `datecreated` varchar(20) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middle` varchar(5) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `birthday` date NOT NULL,
  `age` int(5) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id_type` varchar(20) NOT NULL,
  `id_number` varchar(25) NOT NULL,
  `front_id` varchar(255) NOT NULL,
  `back_id` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `datecreated`, `firstname`, `middle`, `lastname`, `username`, `birthday`, `age`, `email`, `phone`, `password`, `id_type`, `id_number`, `front_id`, `back_id`, `status`) VALUES
(13, '2024-10-20 08:34:05', 'Zoe', 'J', 'Zamora', 'zandrellez', '2005-05-21', 19, 'zoejzamora@gmail.com', '09298280425', 'shapot', '', '', '', '', 'pending'),
(14, '2024-10-20 10:57:50', 'Michael', 'T', 'Rola', 'maki', '2003-07-29', 21, 'rolamaki@gmail.com', '1233456', 'makirola123', '', '', '', '', 'pending'),
(15, '2024-10-20 20:31:25', 'Anna', 'B', 'Vida', 'apvida', '2002-03-08', 22, 'apvida01@gmail.com', '09836201657', 'juweh', '', '', '', '', 'pending'),
(17, '2024-10-22 02:25:52', 'Zoe', 'L', 'Vida', 'awe2323', '2005-05-21', 19, 'zzamora@gmail.com', '09352132156', 'aws', '', '', '', '', 'approved'),
(19, '2024-10-22 04:30:05', 'Lisa', '', 'Manoban', 'lalisa', '1997-01-04', 27, 'llisa@gmail.com', '09646323653', 'asdasdasda', 'Postal ID', 'AB123456', 'verify_id/2a4c8e42c8ab35db30e8f1e8ce8717d1', 'verify_id/2a4c8e42c8ab35db30e8f1e8ce8717d1profile.jpg', 'pending'),
(20, '2024-10-22 10:04:59', 'Patricia', 'B', 'Vida', 'username', '1998-03-05', 26, 'vidavida@gmail.com', '09836201657', 'SDFADFASA', 'SSS ID', '01-2345678-9', 'verify_id/e39f5abfb294029638bfa242564f64b3Untitled.png', 'verify_id/e39f5abfb294029638bfa242564f64b3zoefront.png', 'pending'),
(22, '2024-10-23 10:40:04', 'Michael', '', 'Rola', 'MAKII', '2003-06-17', 21, 'andyzamora969@gmail.com', '63929828023', 'kathleen', 'National ID', '1234-5678-9012-3456', 'verify/7fbabfc9566c78aae07d2cff79d82848aeanfront.png', 'verify/7fbabfc9566c78aae07d2cff79d82848maxxfront.png', 'approved'),
(23, '2024-10-23 10:45:07', 'Ron', '', 'Alimurung', 'ronron', '2003-02-22', 21, 'alimurung@gmail.com', '09631332230', 'bastapassword', 'SSS ID', '01-2345678-9', 'verify/d614859db6eb9f27a8e462609f3644a6drink2.png', 'verify/d614859db6eb9f27a8e462609f3644a6drink5.png', 'approved'),
(24, '2024-10-23 10:50:17', 'Vandrei', '', 'Cupla', 'BOSSV', '2003-11-25', 20, 'vcupla@gmail.com', '0935326523', 'KATEMANIBO', 'SSS ID', '01-2345678-9', 'verify/1f5da14a6b3aae43982a06a9edf6421afooter-logo.png', 'verify/1f5da14a6b3aae43982a06a9edf6421acollection3.png', 'approved');

--
-- Indexes for dumped tables
--
ALTER TABLE `products`
MODIFY `product_description` TEXT NOT NULL;
--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2024;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
