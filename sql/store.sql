-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2023 at 08:56 AM
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
(11, 'admin', '$2y$10$1DDpFR6LxgwRafFmzgcyxOLbcCk2NH0yEJ4683y/LbQ0c31haoWGe', 'super@admin.com', 'SUPA', 'ADMIN', 50, '2023-11-15 13:28:45'),
(12, 'seller1', '$2y$10$Y0km5qMfclCCZZkV1d2pae2RholqmoUoRRnSCubbUOjG6FkvzhKAu', 'qwe@gmail.com', 'SUPP', 'SELLER', 52, '2023-11-19 06:55:25'),
(13, 'seller2', '$2y$10$2EW2Ly7HAoVbF4ElZhXw6edycO5cT/f7qQkFoOf6jkfLW.9OaZuaq', 'qweasd@gmail.com', 'SUPP', 'SELLER', 53, '2023-11-19 07:02:23'),
(14, 'seller3', '$2y$10$m233uylckhgVjLfZVGjnS.xCkFcmiQsZp0Ra0YhzROgbrrY3hIvw6', 'asdzxc@gmail.com', 'SUPP', 'SELLER', 54, '2023-11-19 07:13:53'),
(15, 'seller4', '$2y$10$O718h9GzhI9bHdJ2uz5qc.Get1hgjeQqs6DnERF.xLh8DN/cnY2Bi', 'dfgadsg@gmail.com', 'SUPP', 'SELLER', 55, '2023-11-19 07:21:25'),
(16, 'seller5', '$2y$10$i1zV.FtHg2MCr7uD8TDINuVEkgAmcExPH/esJ3oBDRfnMySXo8s9q', 'safqeg@gmail.com', 'SUPP', 'SELLER', 56, '2023-11-19 07:30:42'),
(17, 'Little Farmer', '$2y$10$aRI0T5A58P15co/vP9KXa.cDkXraVa9s.ZbvbEVYWzZlNf/ie7Gju', 'micheal@gmail.com', 'SUPP', 'SELLER', 51, '2023-11-19 06:32:30'),
(18, 'TESTSELLER', '$2y$10$BAX.3Nmy.g.6XMVz6lIIluxesIRvmKqRDmmzg/sUbiddKV1W9nGrW', 'qweq@gmail.com', 'SUPP', 'SELLER', 57, '2023-11-19 08:33:17');

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

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` text NOT NULL,
  `descr` varchar(500) NOT NULL,
  `weight` int(5) NOT NULL,
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

INSERT INTO `product` (`product_id`, `product_name`, `product_image`, `descr`, `weight`, `categories_id`, `quantity`, `price`, `owner`, `active`, `status`) VALUES
(25, 'Cabbage (50g)', 'http://localhost/lfsc/inventory/assets/images/stock/796992726559adc32b426.jpg', 'Fresh cabbage grown without any pesticides. Sold in packs of (50g)', 50, 5, 28.000, 5.00, '51', 1, 1),
(26, 'Carrot (10g)', 'http://localhost/lfsc/inventory/assets/images/stock/11820960376559ae3774fc1.jpg', 'Grown locally without any pesticides. Sold in packs of 10g', 10, 6, 16.000, 5.00, '51', 1, 1),
(27, 'Green Apple (5g)', 'http://localhost/lfsc/inventory/assets/images/stock/7703864506559ae7169855.jpg', 'Freshest apples in Malaysia. Sold in packs of 5g.', 5, 7, 51.000, 3.00, '51', 1, 1),
(28, 'Red Apple (5g)', 'http://localhost/lfsc/inventory/assets/images/stock/4244744986559af281aa94.jpg', 'Freshest apples in Malaysia. Sold in packs of 5g.', 5, 7, 64.000, 4.00, '51', 1, 1),
(29, 'Turnip (20g)', 'http://localhost/lfsc/inventory/assets/images/stock/5428402576559b19e51b9b.jpg', 'Fresh and pesticide free turnips. Sold in packs of 20g.', 20, 6, 44.000, 3.00, '52', 1, 1),
(30, 'Durians (30g)', 'http://localhost/lfsc/inventory/assets/images/stock/6561151846559b1ed89b94.jpg', 'Out of season durians, selling out fast! (sold in packs of 30g)', 30, 8, 15.000, 80.00, '52', 1, 1),
(31, 'Potato (10g)', 'http://localhost/lfsc/inventory/assets/images/stock/19212838836559b3b045f68.jpg', 'Fresh potatoes! Sold in packs of 10g.', 10, 6, 35.000, 20.00, '53', 1, 1),
(32, 'Red Strawberries (15g)', 'http://localhost/lfsc/inventory/assets/images/stock/6497565306559b43c4bbfb.jpg', 'Fresh! Fresh Fresh! No Pesticides! Sold in packs of 15g.', 15, 8, 55.000, 9.00, '53', 1, 1),
(33, 'Jongga Kimchi (15g)', 'http://localhost/lfsc/inventory/assets/images/stock/19839973516559b66d35dde.jpg', 'Our best selling Kimchi! 15g per can.', 15, 8, 49.000, 15.00, '54', 1, 1),
(34, 'Sunmaid Raisins (30g)', 'http://localhost/lfsc/inventory/assets/images/stock/14213419816559b6dbbcc8f.jpg', 'Our most popular raisins. 30g per can.', 30, 8, 69.000, 10.00, '54', 1, 1),
(35, 'Organic Blue Berries (500g)', 'http://localhost/lfsc/inventory/assets/images/stock/15243408556559b8327cfb8.jpg', 'Imported Swedish Blue Berries.', 500, 8, 42.000, 15.00, '55', 1, 1),
(36, 'Suyob Lingon Berry (1000g)', 'http://localhost/lfsc/inventory/assets/images/stock/5488666076559b8df951d0.jpg', 'Imported from Sweden. 1kg per pack.', 1000, 8, 100.000, 53.00, '55', 1, 1),
(37, 'Ph Dried Banana (100g)', 'http://localhost/lfsc/inventory/assets/images/stock/11535282526559ba1c506f5.jpg', 'Buy this world renowned snack today! Sold in 100g packs.', 100, 8, 299.000, 5.00, '56', 1, 1),
(38, 'Southern Grove Mix Berries (141g)', 'http://localhost/lfsc/inventory/assets/images/stock/11065128226559bac10586d.jpg', 'Our famous mix berries! Perfect for your trail walk! sold in packs of 141g', 141, 8, 30.000, 40.00, '56', 1, 1);

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
(70, 37, 'closed', 'delivered success', '2018-04-18 19:51:50'),
(71, 13, 'closed', 'no things', '2023-11-17 04:45:05'),
(72, 13, 'closed', 'finished', '2023-11-17 04:47:07'),
(73, 13, 'closed', 'aaa', '2023-11-17 04:51:17'),
(74, 13, 'closed', 'd', '2023-11-17 04:54:37'),
(75, 13, '', '11', '2023-11-17 04:57:17'),
(76, 13, '', 'ss', '2023-11-17 04:57:28'),
(77, 13, '', 'aaa', '2023-11-17 04:58:29'),
(78, 13, '', 'aaa', '2023-11-17 04:59:02'),
(79, 13, '', 'aaa', '2023-11-17 04:59:37'),
(80, 13, '3', 'aa', '2023-11-17 05:00:12'),
(81, 13, '', 'aaa', '2023-11-17 05:00:28'),
(82, 13, '', 'aaa', '2023-11-17 05:00:36'),
(83, 13, '', 'aaa', '2023-11-17 05:01:13'),
(84, 13, '', 'aaa', '2023-11-17 05:01:28'),
(85, 13, '2', 'aaa', '2023-11-17 05:01:44'),
(86, 13, '3', 'aaa', '2023-11-17 05:02:02'),
(87, 13, '4', 'aaa', '2023-11-17 05:02:13'),
(88, 13, '3', 'aaa', '2023-11-17 05:02:39'),
(89, 13, '2', '111', '2023-11-17 05:04:11'),
(90, 13, '4', '123', '2023-11-17 05:05:01'),
(91, 13, '2', '123', '2023-11-17 05:05:07'),
(92, 16, '3', 'delivered', '2023-11-20 05:14:04'),
(93, 21, '3', 'deliver', '2023-11-22 03:31:10'),
(94, 23, '2', 'delivery in process', '2023-11-22 03:48:28'),
(95, 23, '3', 'delivered', '2023-11-22 03:48:58'),
(96, 27, '3', 'right now', '2023-11-22 05:21:26'),
(97, 37, '3', 'delivered', '2023-11-22 12:33:19'),
(98, 41, '3', 'delivered.', '2023-11-24 07:12:56');

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
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `c_id`, `title`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `image`, `date`, `description`) VALUES
(51, 5, 'Little Farmer', 'littlefarmer@gmail.com', '010-217 0960', 'dbsd.com', '6am', '6pm', '24hr-x7', ' AB102 Ground Floor Parcel 2586-1-9 Lorong Persiaran Bandar Baru Batu Kawa 3D Batu Kawah New Township Jalan Batu Kawa 93250 Kuching Sarawak ', '655ae7ad8ca9c.png', '2023-11-20 05:00:04', 'Little Farmer has been cultivating organic produce for over two decades. Our commitment to fresh and sustainable farming has made us the choice of many households. Dive in to know more about our journey and values.'),
(52, 5, 'The Green Grocer', 'greengrocer@gmail.com', '082-419 100\n', 'gg.com', '8am', '8pm', 'mon-wed', 'Lot 299-303,Section 49 KTLD Jalan Abell, 93000, Kuching, Sarawak\n\n', '6559b15ddab32.png', '2023-11-20 04:47:03', 'The Green Grocer is your one stop shop for all things fresh and healthy!'),
(53, 8, 'Fresh Food sdn bhd', 'FF@gmail.com', '010-509 3311', 'ff.com', '6am', '6pm', 'mon-thu', 'Bangunan Kepli Holdings,No.139, Jalan Satok, 93400, Kuching, Sarawak\n', '6559b2ffe9dcb.jpg', '2023-11-20 04:48:00', 'Prices you can\'t beat!'),
(54, 8, 'Always Fresh Canned Goods', 'AF@gmail.com', '014-714 2029', 'af.com', '6am', '6pm', 'mon-wed', 'Ground Floor, Lot G-38, The Spring Shopping Mall, Jalan Simpang 3,[], 93350, Kuching, Sarawak\n', '6559b5b11a1d4.jpg', '2023-11-20 04:48:12', 'Produced and canned locally! Freshness guaranteed or your money back!'),
(55, 6, 'Prime Euro Import Market', 'PEIM@gmail.com', '014-800 7125', 'peim.com', '7am', '5pm', 'mon-thu', 'Lot 880 A, Lorong Song 3 E 2, Jalan Song, 93350, Kuching, Sarawak\n', '6559b77536d01.gif', '2023-11-20 04:48:27', 'We import euro plant based goods at a cheap price!'),
(56, 7, 'Sydney Vegan Market (Malaysia Branch)', 'svm@gmail.com', '019-828 8790', 'svm.com', '8am', '5pm', 'mon-wed', '1, Huo Ping Road, P.O.Box, Sibu, 96008, Sibu, Sarawak\n', '6559b9a2142c4.jpg', '2023-11-20 04:48:39', 'Award winning global vegan franchise!');

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
(2, 'cust1', 'cust', 'one', 'cust one', 'qweq@gmail.com', '1232343456', '$2y$10$n8zOEwX0Ar7fGlTV1Hxi.OVCGwOG9PMxLsDGe2wZ.nys2i4gpNL4S', 'afqwe123', 1, '2023-11-19 06:29:17'),
(3, 'cust2', 'cust', 'two', 'cust two', 'qweqwr@gmail.com', '1231231235', '$2y$10$fbEIRMnpFGJoD7dNhUvFNuF9Qz62fj0CMutGXVTAKw99lspODNxu.', 'werb123', 1, '2023-11-19 06:29:54'),
(4, 'cust3', 'cust', 'three', 'cust three', 'sdvsd@gmail.com', '1231345234', '$2y$10$uB.HAMXvQWCOn7CqpL/iTuoBW1L.jTCMWIM.2L8OdOHx72BHRcQna', 'qwe1231', 1, '2023-11-19 06:30:31');

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
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
