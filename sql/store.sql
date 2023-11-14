-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2023 at 05:17 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `u_role`, `store`, `date`) VALUES
(10, 'admin', '202cb962ac59075b964b07152d234b70', 'admin@lf.net', 'SUPA', 'ADMIN', 51, '2023-11-11 02:12:03'),
(11, 'aaa', '202cb962ac59075b964b07152d234b70', 'aaa@gmail.com', 'SUPP', 'SELLER', 49, '2023-11-07 15:25:03'),
(12, 'wcs', '202cb962ac59075b964b07152d234b70', 'wcswong@gmail.com', 'SUPP', 'SELLER', 48, '2023-11-08 00:32:26'),
(13, 'specialMicheal', '202cb962ac59075b964b07152d234b70', 'specialMicheal@gmail.com', 'SUPP', 'SELLER', 50, '2023-11-08 07:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `admin_codes`
--

CREATE TABLE `admin_codes` (
  `id` int(222) NOT NULL,
  `codes` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `categories_active`, `categories_status`) VALUES
(1, 'Organic', 1, 1),
(2, 'Recommended', 1, 1),
(3, 'Fake', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`d_id`, `rs_id`, `title`, `slogan`, `price`, `img`) VALUES
(12, 48, 'Carrot', 'A classic carrot', '22.12', '652d4383278bd.jpg'),
(13, 49, 'Mango', 'Less popular than power-up mango', '12.35', '652d43db19251.jpg'),
(15, 49, 'Power-up Mango', 'Subsidized by government', '11.99', '652d42d37a242.jpg'),
(16, 48, 'Ultra Carrot', 'Grown only in Dreamland', '22.55', '652d42bfc10ce.jpg'),
(17, 10, 'Apple', 'Great taste', '17.99', '652d429436b21.jpg');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_image`, `categories_id`, `quantity`, `price`, `owner`, `active`, `status`) VALUES
(12, 'Carrot', 'http://localhost/lfsc/inventory/assets/images/stock/652d4383278bd.jpg', 1, '-52.000', '22.12', '48', 1, 1),
(13, 'Mango', 'http://localhost/lfsc/inventory/assets/images/stock/652d43db19251.jpg', 1, '-75.000', '12.35', '49', 1, 1),
(15, 'Power-up Mango', 'http://localhost/lfsc/inventory/assets/images/stock/652d42d37a242.jpg', 3, '19.000', '11.99', '49', 1, 1),
(16, 'Ultra Carrot', 'http://localhost/lfsc/inventory/assets/images/stock/652d42bfc10ce.jpg', 1, '-28.000', '22.55', '48', 1, 1),
(17, 'Apple', 'http://localhost/lfsc/inventory/assets/images/stock/652d429436b21.jpg', 1, '1195.000', '17.99', '51', 1, 1),
(18, 'Chilli', 'http://localhost/lfsc/inventory/assets/images/stock/15461769106548c4cd82e3d.png', 2, '61.000', '12.00', '51', 1, 1),
(19, 'Corn', 'http://localhost/lfsc/inventory/assets/images/stock/1154826493654b38a43e286.jpg', 1, '123.000', '6.00', '50', 1, 1),
(20, 'Cabbage', 'http://localhost/lfsc/inventory/assets/images/stock/424624986654b38b5db833.jpg', 1, '321.000', '5.00', '50', 1, 1),
(21, 'Carrot', 'http://localhost/lfsc/inventory/assets/images/stock/318972849654b38c80c89f.jpg', 1, '69.000', '8.00', '50', 1, 1),
(22, 'Apple', 'http://localhost/lfsc/inventory/assets/images/stock/400964473654b38dbc5023.jpg', 1, '420.000', '12.00', '50', 1, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `c_id`, `title`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `image`, `date`) VALUES
(48, 0, 'Carrot Seller', 'carrot@gmail.com', ' 090412 64676', 'carrotseller.com', '--Select your Hours--', '--Select your Hours--', '--Select your Days--', 'Palace, Natwar Jalandhar ', '652d4258ec2f2.jpg', '2023-10-21 08:17:21'),
(49, 0, 'Mango Seller', 'mango@gmail.com', '011 2677 9070', 'mangoseller.com', '--Select your Hours--', '--Select your Hours--', '--Select your Days--', 'Radisson Blu Plaza Hotel, Delhi Airport, NH-8, New Delhi, 110037 ', '652d4237604a0.jpg', '2023-10-21 08:17:25'),
(50, 0, 'Little Farmer', 'gg@gmail,com', '+60111626597', 'www.litterfarmer.com', '6am', '6pm', '24hr-x7', '123131233123', '654b38481b1d1.png', '2023-11-08 07:27:04'),
(51, 0, '1', '1', '1', '1', '10am', '6pm', 'mon-fri', '1', '654ee2f3258a8.jpg', '2023-11-11 02:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(222) NOT NULL,
  `c_name` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_category`
--

INSERT INTO `res_category` (`c_id`, `c_name`, `date`) VALUES
(5, 'grill', '2018-04-14 18:45:28'),
(6, 'pizza', '2018-04-14 18:44:56'),
(7, 'pasta', '2018-04-14 18:45:13'),
(8, 'thaifood', '2018-04-14 18:32:56'),
(9, 'fish', '2018-04-14 18:44:33');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `fullName`, `email`, `phone`, `password`, `address`, `status`, `date`) VALUES
(31, 'navjot789', 'navjot', 'singh', '', 'ns949405@gmail.com', '9041240385', '202cb962ac59075b964b07152d234b70', 'badri col phase 2', 1, '2023-10-16 06:34:53'),
(32, 'navjot890', 'nav', 'singh', '', 'nds949405@gmail.com', '6232125458', '6d0361d5777656072438f6e314a852bc', 'badri col phase 1', 1, '2018-04-18 09:50:56'),
(33, 'fyp', 'fyp', 'fyp', 'fyp fyp', 'devinchp@gmail.com', '0198186518', '46f94c8de14fb36680850768ff1b7f2a', '3828 Piermont Dr, Albuquerque, NM', 1, '2023-11-14 15:45:32'),
(34, 'aaa', 'aaa', 'aaa', 'aaa aaa', 'a@gmail.com', '01151385427', '$2y$10$e02vnxMwGpigjxJtFV/dFOkTaYZvo9ekikJA9wZ/yK2C3sNt3ODY2', '', 1, '2023-11-14 15:45:40'),
(35, 'emt', 'g', 'g', '', 'gg@gmail.com', '+60112345678', '$2y$10$jusF.hKYFn15nfgl7Wm8pOZObDh1fKvS20liil2svrRKkR8dBYwCO', '123131231313', 1, '2023-11-08 07:23:37'),
(36, '1', '1', '1', '', 'a@b.com', '112121212121', '$2y$10$r1aHXngz5.OHEExLOvZZPeREYbxMpMguxI1nhoWukJFMC09j0USPa', '1', 1, '2023-11-11 08:15:13'),
(37, 'abc', 'abc', 'def', 'abc def', 'a@c.com', '1159888888', '$2y$10$jnGDfo./wKHdePm6pxn.fOmLsnfYiEnmqZlr3H/dGmsUlEx8jW.0q', '1', 1, '2023-11-14 15:42:41');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_orders`
--

INSERT INTO `users_orders` (`o_id`, `u_id`, `title`, `quantity`, `price`, `status`, `date`) VALUES
(37, 31, 'Apple', 5, '17.99', 'closed', '2023-10-21 08:14:27'),
(38, 31, 'Power-up Mango', 2, '11.99', NULL, '2023-10-21 08:15:02'),
(39, 32, 'Ultra Carrot', 1, '22.55', NULL, '2023-10-21 08:16:10'),
(40, 33, 'Carrot', 1, '22.12', NULL, '2023-10-21 08:16:03'),
(41, 33, 'Apple', 2, '17.99', NULL, '2023-10-21 08:16:00'),
(42, 34, 'Carrot', 1, '22.12', NULL, '2023-10-31 05:38:56'),
(44, 36, '', 1, '22.12', NULL, '2023-11-11 08:16:32');

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
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

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
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `admin_codes`
--
ALTER TABLE `admin_codes`
  MODIFY `id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
