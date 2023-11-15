-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2023 at 02:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `code` varchar(222) NOT NULL,
  `u_role` text NOT NULL,
  `store` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `u_role`, `store`, `date`) VALUES
(1, 'seller1', '$2y$10$X0dzPMCT.LLM0kFzdh5Kh.MeJPrPPiIM75yPoa52C9j5I/pgLXLaK', '1@seller.com', 'SUPP', 'SELLER', 49, '2023-11-15 13:28:49'),
(2, 'seller2', '$2y$10$zr7aEeS60EBONqCa7JzyUOJDNbZ.UowpfmstsrpJy6f9LH3K1CuK2', '2@seller.com', 'SUPP', 'SELLER', 48, '2023-11-15 13:28:53'),
(11, 'admin', '$2y$10$1DDpFR6LxgwRafFmzgcyxOLbcCk2NH0yEJ4683y/LbQ0c31haoWGe', 'super@admin.com', 'SUPA', 'ADMIN', 50, '2023-11-15 13:28:45');

-- --------------------------------------------------------

--
-- Table structure for table `admin_codes`
--

CREATE TABLE `admin_codes` (
  `id` int(222) NOT NULL,
  `codes` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_codes`
--

INSERT INTO `admin_codes` (`id`, `codes`) VALUES
(1, 'SUPA'),
(2, 'SUPP');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL,
  `categories_name` varchar(255) NOT NULL,
  `categories_active` int(11) NOT NULL DEFAULT 0,
  `categories_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `categories_active`, `categories_status`) VALUES
(1, 'Organic', 1, 1),
(2, 'Recommended', 1, 1),
(3, 'Fake', 1, 1),
(4, 'Artificial', 1, 1),
(5, 'Leafy Green', 1, 1),
(6, 'Root Vegetables', 1, 1),
(7, 'Pome Fruits', 1, 1),
(8, 'Others', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_contact` varchar(255) NOT NULL,
  `sub_total` varchar(255) NOT NULL,
  `vat` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `paid` varchar(255) NOT NULL,
  `due` varchar(255) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `payment_place` int(11) NOT NULL,
  `gstn` varchar(255) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `order_belong` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `client_name`, `client_contact`, `sub_total`, `vat`, `total_amount`, `discount`, `grand_total`, `paid`, `due`, `payment_type`, `payment_status`, `payment_place`, `gstn`, `order_status`, `user_id`, `order_belong`) VALUES
(1, '2023-11-12', 'aaa aaa', '01151385427', '44.24', '0', '44.24', '0', '0', '0', '', 1, 1, 1, '1', 1, 34, 51),
(2, '2023-11-12', 'aaa aaa', '01151385427', '44.67', '0', '44.67', '0', '0', '0', '', 1, 1, 1, '1', 1, 34, 48),
(3, '2023-11-12', 'aaa aaa', '01151385427', '22.12', '0', '22.12', '0', '0', '0', '', 1, 1, 1, '1', 1, 34, 51),
(4, '2023-11-12', 'aaa aaa', '01151385427', '12.35', '0', '12.35', '0', '0', '0', '22.12', 1, 1, 1, '1', 1, 34, 48),
(5, '2023-11-12', 'aaa aaa', '01151385427', '22.55', '0', '22.55', '0', '0', '0', '', 1, 1, 1, '1', 1, 34, 51),
(6, '2023-11-12', 'aaa aaa', '01151385427', '12.35', '0', '12.35', '0', '0', '0', '22.55', 1, 1, 1, '1', 1, 34, 48),
(7, '2023-11-12', 'aaa aaa', '01151385427', '22.12', '0', '22.12', '0', '0', '0', '', 1, 1, 1, '1', 1, 34, 48),
(8, '2023-11-12', 'aaa aaa', '01151385427', '24.34', '0', '24.34', '0', '0', '0', '24.34', 1, 1, 1, '1', 1, 34, 48),
(9, '2023-11-12', 'aaa aaa', '01151385427', '44.67', '0', '44.67', '0', '0', '0', '44.67', 1, 1, 1, '1', 1, 12, 48),
(10, '2023-11-12', 'aaa aaa', '01151385427', '17.99', '3.24', '21.23', '0', '21.23', '0', '21.23', 1, 1, 1, '3.24', 1, 10, 0),
(11, '2023-11-12', 'aaa aaa', '01151385427', '17.99', '3.24', '21.23', '0', '21.23', '0', '21.23', 1, 1, 2, '3.24', 1, 34, 10),
(12, '2023-11-12', 'aaa aaa', '01151385427', '17.99', '3.24', '21.23', '0', '21.23', '0', '21.23', 1, 1, 1, '3.24', 1, 34, 51),
(13, '2023-11-13', 'fyp fyp', '0198186518', '17.99', '3.24', '21.23', '88', '-66.77', '0', '-66.77', 1, 1, 2, '3.24', 1, 33, 51);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `quantity` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `order_item_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`, `total`, `order_item_status`) VALUES
(1, 1, 12, '2', '22.12', '44.24', 1),
(2, 2, 12, '1', '22.12', '22.12', 1),
(3, 2, 16, '1', '22.55', '44.67', 1),
(4, 3, 12, '1', '22.12', '22.12', 1),
(5, 4, 13, '1', '12.35', '12.35', 1),
(6, 5, 12, '1', '22.12', '22.12', 1),
(7, 5, 16, '1', '22.55', '22.55', 1),
(8, 6, 13, '1', '12.35', '12.35', 1),
(9, 7, 12, '1', '22.12', '22.12', 1),
(10, 8, 13, '1', '12.35', '12.35', 1),
(11, 8, 15, '1', '11.99', '11.99', 1),
(16, 10, 17, '1', '17.99', '17.99', 1),
(17, 11, 17, '1', '17.99', '17.99', 1),
(18, 12, 17, '1', '17.99', '17.99', 1),
(19, 9, 12, '1', '22.12', '22.12', 1),
(20, 9, 16, '1', '22.55', '22.55', 1),
(21, 13, 17, '1', '17.99', '17.99', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` text NOT NULL,
  `categories_id` int(11) NOT NULL,
  `quantity` decimal(11,3) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `owner` text NOT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_image`, `categories_id`, `quantity`, `price`, `owner`, `active`, `status`) VALUES
(11, 'Carrot', 'http://localhost/lfsc/inventory/assets/images/stock/652d4383278bd.jpg', 3, 52.000, 22.12, '48', 1, 1),
(13, 'Mango', 'http://localhost/lfsc/inventory/assets/images/stock/652d43db19251.jpg', 1, 75.000, 12.35, '49', 1, 1),
(15, 'Power-up Mango', 'http://localhost/lfsc/inventory/assets/images/stock/652d42d37a242.jpg', 4, 25.000, 11.99, '49', 1, 1),
(16, 'Ultra Carrot', 'http://localhost/lfsc/inventory/assets/images/stock/652d42bfc10ce.jpg', 4, 28.000, 22.55, '48', 1, 1),
(17, 'Chilli', 'http://localhost/lfsc/inventory/assets/images/stock/15461769106548c4cd82e3d.png', 2, 61.000, 12.00, '50', 1, 1),
(19, 'Corn', 'http://localhost/lfsc/inventory/assets/images/stock/1154826493654b38a43e286.jpg', 6, 123.000, 6.00, '50', 1, 1),
(20, 'Cabbage', 'http://localhost/lfsc/inventory/assets/images/stock/424624986654b38b5db833.jpg', 5, 321.000, 5.00, '50', 1, 1),
(21, 'Carrot', 'http://localhost/lfsc/inventory/assets/images/stock/318972849654b38c80c89f.jpg', 6, 69.000, 8.00, '50', 1, 1),
(22, 'Apple', 'http://localhost/lfsc/inventory/assets/images/stock/400964473654b38dbc5023.jpg', 7, 420.000, 12.00, '50', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `remark`
--

INSERT INTO `remark` (`id`, `frm_id`, `status`, `remark`, `remarkDate`) VALUES
(62, 32, 'in process', 'hi', '2018-04-18 17:35:52'),
(63, 32, 'closed', 'cc', '2018-04-18 17:36:46'),
(64, 32, 'in process', 'fff', '2018-04-18 18:01:37'),
(65, 32, 'closed', 'its delv', '2018-04-18 18:08:55'),
(66, 34, 'in process', 'on a way', '2018-04-18 18:56:32'),
(67, 35, 'closed', 'ok', '2018-04-18 18:59:08'),
(68, 37, 'in process', 'on the way!', '2018-04-18 19:50:06'),
(69, 37, 'rejected', 'if admin cancel for any reason this box is for remark only for buter perposes', '2018-04-18 19:51:19'),
(70, 37, 'closed', 'delivered success', '2018-04-18 19:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `rs_id` int(222) NOT NULL,
  `c_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `url` varchar(222) NOT NULL,
  `o_hr` varchar(222) NOT NULL,
  `c_hr` varchar(222) NOT NULL,
  `o_days` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `image` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `c_id`, `title`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `image`, `date`) VALUES
(48, 7, 'Carrot Seller', 'carrot@gmail.com', ' 090412 64676', 'carrotseller.com', '--Select your Hours--', '--Select your Hours--', '--Select your Days--', 'Palace, Natwar Jalandhar ', '652d4258ec2f2.jpg', '2023-11-15 13:13:57'),
(49, 6, 'Mango Seller', 'mango@gmail.com', '011 2677 9070', 'mangoseller.com', '--Select your Hours--', '--Select your Hours--', '--Select your Days--', 'Radisson Blu Plaza Hotel, Delhi Airport, NH-8, New Delhi, 110037 ', '652d4237604a0.jpg', '2023-11-15 13:14:17'),
(50, 5, 'Little Farmer', 'michael@gmail.com', '+60102170960', 'www.littlefarmer.com', '6am', '6pm', '24hr-x7', 'AB102 Ground Floor Parcel 2586-1-9 Lorong Persiaran Bandar Baru Batu Kawa 3D Batu Kawah New Township Jalan Batu Kawa 93250 Kuching Sarawak', '654b38481b1d1.png', '2023-11-15 13:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(222) NOT NULL,
  `c_name` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `res_category`
--

INSERT INTO `res_category` (`c_id`, `c_name`, `date`) VALUES
(5, 'Fresh', '2023-11-15 13:10:58'),
(6, 'Frozen', '2023-11-15 13:11:04'),
(7, 'Dried', '2023-11-15 13:11:10'),
(8, 'Canned', '2023-11-15 13:11:17'),
(9, 'Other', '2023-11-15 13:11:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `fullName` varchar(50) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int(222) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `fullName`, `email`, `phone`, `password`, `address`, `status`, `date`) VALUES
(1, 'customer1', 'Cust', 'Omer', 'Cust Omer', '1@customer.com', '9126347212', '$2y$10$SqOKooVJ.stcK0F2SXnaMeMCe8ovWj/4i3mQSEgkVg1yGcbwUw/H6', 'Timberland', 1, '2023-11-15 13:17:38');

-- --------------------------------------------------------

--
-- Table structure for table `users_orders`
--

CREATE TABLE `users_orders` (
  `o_id` int(222) NOT NULL,
  `u_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `quantity` int(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(222) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_orders`
--

INSERT INTO `users_orders` (`o_id`, `u_id`, `title`, `quantity`, `price`, `status`, `date`) VALUES
(37, 31, 'Apple', 5, 17.99, 'closed', '2023-10-21 08:14:27'),
(38, 31, 'Power-up Mango', 2, 11.99, NULL, '2023-10-21 08:15:02'),
(39, 32, 'Ultra Carrot', 1, 22.55, NULL, '2023-10-21 08:16:10'),
(40, 33, 'Carrot', 1, 22.12, NULL, '2023-10-21 08:16:03'),
(41, 33, 'Apple', 2, 17.99, NULL, '2023-10-21 08:16:00'),
(42, 34, 'Carrot', 1, 22.12, NULL, '2023-10-31 05:38:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `admin_codes`
--
ALTER TABLE `admin_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `users_orders`
--
ALTER TABLE `users_orders`
  ADD PRIMARY KEY (`o_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_codes`
--
ALTER TABLE `admin_codes`
  MODIFY `id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
