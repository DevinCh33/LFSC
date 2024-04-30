-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 10:08 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.2.12

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
  `adm_Name` text NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `contact_num` text NOT NULL,
  `code` varchar(222) NOT NULL,
  `u_role` text NOT NULL,
  `store` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `storeStatus` int(3) NOT NULL,
  `chat_id` bigint(20) DEFAULT NULL,
  `email_token` varchar(255) NOT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `adm_Name`, `username`, `password`, `email`, `contact_num`, `code`, `u_role`, `store`, `date`, `storeStatus`, `chat_id`, `email_token`, `email_verified`) VALUES
(11, 'Wong ', 'admin', '$2y$10$vg.3MfpjSjJTpPI09uAopOwev2j7r5DV3AvweyJ0vj43aOhd0w1Me', 'ryan@gmail.com', '01151385427', 'SUPA', 'ADMIN', 0, '2024-04-25 13:55:20', 1, NULL, '', 1),
(12, '', 'seller1', '$2y$10$Y0km5qMfclCCZZkV1d2pae2RholqmoUoRRnSCubbUOjG6FkvzhKAu', 'qwe@gmail.com', '', 'SUPP', 'SELLER', 52, '2024-04-25 13:55:20', 1, 5964495496, '', 1),
(13, '', 'seller2', '$2y$10$2EW2Ly7HAoVbF4ElZhXw6edycO5cT/f7qQkFoOf6jkfLW.9OaZuaq', 'qweasd@gmail.com', '', 'SUPP', 'SELLER', 53, '2024-04-25 13:55:20', 1, NULL, '', 1),
(14, '', 'seller3', '$2y$10$m233uylckhgVjLfZVGjnS.xCkFcmiQsZp0Ra0YhzROgbrrY3hIvw6', 'asdzxc@gmail.com', '', 'SUPP', 'SELLER', 54, '2024-04-25 13:55:20', 1, NULL, '', 1),
(15, '', 'seller4', '$2y$10$O718h9GzhI9bHdJ2uz5qc.Get1hgjeQqs6DnERF.xLh8DN/cnY2Bi', 'dfgadsg@gmail.com', '', 'SUPP', 'SELLER', 55, '2024-04-25 13:55:20', 1, NULL, '', 1),
(16, '', 'seller5', '$2y$10$24yfPOHwly.E1EXRFAc7aeuPrbJGfdTc0yAmFqaWyw5LlHsmVs9Fq', 'safqeg@gmail.com', '', 'SUPP', 'SELLER', 56, '2024-04-25 13:55:20', 1, NULL, '', 1),
(17, '', 'Little Farmer', '$2y$10$SWzNRnTKoT09/gV4LJIVLOOd8q4QjDzfDnUj.cLLm./dwE9QFpD1C', 'ryanwong179@gmail.com', '', 'SUPP', 'SELLER', 51, '2024-04-25 17:58:08', 1, NULL, '', 1);

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
(5, 'Leafy Green', 1, 1),
(6, 'Root Vegetables', 1, 1),
(7, 'Pome Fruits', 1, 1),
(8, 'Others', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `custom_prices`
--

CREATE TABLE `custom_prices` (
  `price_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `custom_prices`
--

INSERT INTO `custom_prices` (`price_id`, `user_id`, `price`) VALUES
(16, 2, 1.5),
(17, 2, 7),
(20, 2, 300);

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
  `total_amount` varchar(255) NOT NULL,
  `paid` varchar(255) NOT NULL,
  `due` varchar(255) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `order_belong` int(15) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_seen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `client_name`, `client_contact`, `sub_total`, `total_amount`, `paid`, `due`, `payment_type`, `order_status`, `user_id`, `order_belong`, `last_updated`, `is_seen`) VALUES
(1, '2023-12-28', 'cust one', '1232343456', '25', '25', '0', '25', 1, 1, 2, 51, '2024-03-22 16:17:30', 0),
(2, '2023-12-28', 'cust one', '1232343456', '25', '25', '0', '25', 1, 2, 2, 51, '2024-03-22 16:17:30', 0),
(3, '2024-03-27', 'cust two', '123123123123123', '30', '30', '30', '0', 1, 1, 3, 51, '2024-03-27 16:20:00', 0),
(4, '2024-04-20', 'cust two', '1231231235', '90', '90', '0', '90', 1, 3, 3, 52, '2024-04-20 15:28:45', 0),
(5, '2024-04-20', 'cust two', '1231231235', '240', '240', '0', '240', 1, 1, 3, 52, '2024-04-20 15:29:23', 0),
(6, '2024-04-21', 'cust two', '1231231235', '80', '80', '0', '80', 1, 1, 3, 51, '2024-04-20 18:05:43', 0),
(7, '2024-04-21', ' ', '', '43.5', '43.5', '0', '43.5', 1, 1, 35, 51, '2024-04-21 06:20:13', 0),
(8, '2024-04-21', ' ', '', '240', '240', '0', '240', 1, 2, 35, 52, '2024-04-21 06:20:13', 0),
(9, '2024-04-22', ' ', '0128789600', '240', '240', '0', '240', 1, 1, 35, 52, '2024-04-22 10:45:33', 0),
(10, '2024-04-22', ' ', '0128789600', '76', '76', '0', '76', 1, 2, 35, 51, '2024-04-22 10:48:15', 0),
(11, '2024-04-30', 'cust one', '1232343456', '270', '270', '0', '270', 2, 1, 2, 52, '2024-04-30 07:59:40', 0);

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `reset_is_seen_before_order_status_update` BEFORE UPDATE ON `orders` FOR EACH ROW IF OLD.order_status <> NEW.order_status THEN
    SET NEW.is_seen = 0;
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `priceID` int(10) NOT NULL,
  `quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `priceID`, `quantity`) VALUES
(1, 1, 17, '1'),
(2, 1, 18, '1'),
(3, 2, 17, '1'),
(4, 2, 20, '1'),
(5, 4, 22, '2'),
(6, 5, 23, '1'),
(7, 6, 20, '1'),
(8, 7, 18, '1'),
(9, 7, 21, '1'),
(10, 8, 23, '1'),
(11, 9, 23, '1'),
(12, 10, 16, '2'),
(13, 10, 19, '2'),
(14, 10, 21, '2'),
(15, 11, 22, '6');

-- --------------------------------------------------------

--
-- Table structure for table `payment_receipts`
--

CREATE TABLE `payment_receipts` (
  `receipt_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `receipt_path` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_receipts`
--

INSERT INTO `payment_receipts` (`receipt_id`, `order_id`, `receipt_path`, `upload_date`, `status`) VALUES
(1, 5, 'receipts/Screenshot (415).png', '2024-04-26 16:09:09', 1),
(2, 4, 'receipts/Screenshot (328).png', '2024-04-26 16:12:55', 1),
(3, 8, 'receipts/Screenshot (328).png', '2024-04-26 16:13:04', 1),
(4, 13, 'receipts/Screenshot (333).png', '2024-04-26 16:15:26', 1),
(5, 15, 'Screenshot (327).png', '2024-04-26 16:24:53', 0),
(6, 16, 'receipts/Screenshot (354).png', '2024-04-26 16:30:33', 0),
(7, 17, 'receipts/payment.png', '2024-04-26 18:00:10', 0),
(8, 18, 'payment.png', '2024-04-26 18:14:04', 0),
(9, 19, 'Screenshot (333).png', '2024-04-26 18:18:28', 1),
(10, 11, 'Screenshot (380).png', '2024-04-30 07:59:50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `productCode` varchar(30) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` text NOT NULL,
  `descr` varchar(500) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `owner` text NOT NULL,
  `product_date` text NOT NULL,
  `lowStock` int(5) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `productCode`, `product_name`, `product_image`, `descr`, `categories_id`, `quantity`, `owner`, `product_date`, `lowStock`, `status`) VALUES
(25, 'C0012', 'Cabbage', 'http://localhost/lfsc/inventory/assets/images/stock/796992726559adc32b426.jpg', 'Fresh cabbage grown without any pesticides.', 5, 680, '51', '2023-12-15', 30, 6),
(26, 'C0022', 'Carrot', 'http://localhost/lfsc/inventory/assets/images/stock/11820960376559ae3774fc1.jpg', 'Grown locally without any pesticides.', 6, 900, '51', '2023-12-15', 30, 1),
(27, 'A0001', 'Green Apple', 'http://localhost/lfsc/inventory/assets/images/stock/7703864506559ae7169855.jpg', 'Freshest apples in Malaysia. Sold in packs of 500g.', 7, 8000, '51', '2023-12-15', 30, 1),
(28, 'A0002', 'Red Apple', 'http://localhost/lfsc/inventory/assets/images/stock/656955591157b.jpg', 'Freshest apples in Malaysia. Sold in packs of 500g.', 7, 0, '51', '2023-12-15', 30, 1),
(29, 'R0001', 'Turnip', 'http://localhost/lfsc/inventory/assets/images/stock/5428402576559b19e51b9b.jpg', 'Fresh and pesticide free turnips.', 6, 200, '52', '2023-12-15', 0, 1),
(30, 'R0002', 'Durians', 'http://localhost/lfsc/inventory/assets/images/stock/6561151846559b1ed89b94.jpg', 'Out of season durians, selling out fast! ', 8, 0, '52', '2023-12-15', 0, 3),
(31, 'Z0001', 'Potato', 'http://localhost/lfsc/inventory/assets/images/stock/19212838836559b3b045f68.jpg', 'Fresh potatoes!', 6, 400, '53', '2023-12-15', 0, 3),
(32, 'Z0002', 'Red Strawberries', 'http://localhost/lfsc/inventory/assets/images/stock/6497565306559b43c4bbfb.jpg', 'Fresh! Fresh! Fresh! No Pesticides!', 8, 300, '53', '2023-12-15', 0, 1),
(33, 'K0001', 'Jongga Kimchi', 'http://localhost/lfsc/inventory/assets/images/stock/19839973516559b66d35dde.jpg', 'Our best selling Kimchi!', 8, 900, '54', '2023-12-15', 0, 3),
(34, 'K0002', 'Sunmaid Raisins', 'http://localhost/lfsc/inventory/assets/images/stock/14213419816559b6dbbcc8f.jpg', 'Our most popular raisins!', 8, 500, '54', '2023-12-15', 0, 1),
(35, 'G0001', 'Organic Blue Berries', 'http://localhost/lfsc/inventory/assets/images/stock/15243408556559b8327cfb8.jpg', 'Imported Swedish Blue Berries.', 8, 600, '55', '2023-12-15', 0, 3);

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
(93, 18, '2', 'delivery on the way', '2023-11-26 06:12:22'),
(94, 18, '3', 'closed', '2023-11-26 06:14:14'),
(95, 21, '2', 'Packed', '2023-12-01 08:54:14'),
(96, 21, '3', 'Delivered 1/12/2023', '2023-12-01 08:54:40');

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
  `description` text NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `avg_rating` decimal(3,1) DEFAULT 0.0,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `c_id`, `title`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `image`, `date`, `description`, `rating`, `avg_rating`, `comment`) VALUES
(51, 5, 'Little Farmer', 'littlefarmer@gmail.com', '010-217 0960', 'dbsd.com', '6am', '6pm', '24hr-x7', ' AB102 Ground Floor Parcel 2586-1-9 Lorong Persiaran Bandar Baru Batu Kawa 3D Batu Kawah New Township Jalan Batu Kawa 93250 Kuching Sarawak ', '655ae7ad8ca9c.png', '2024-03-20 13:53:52', 'Little Farmer has been cultivating organic produce for over two decades. Our commitment to fresh and sustainable farming has made us the choice of many households. Dive in to know more about our journey and values.', 5, 0.0, NULL),
(52, 5, 'The Green Grocer', 'greengrocer@gmail.com', '082-419 100\n', 'gg.com', '8am', '8pm', 'mon-wed', 'Lot 299-303,Section 49 KTLD Jalan Abell, 93000, Kuching, Sarawak\n\n', '6559b15ddab32.png', '2024-03-20 13:40:58', 'The Green Grocer is your one stop shop for all things fresh and healthy!', 1, 0.0, NULL),
(53, 8, 'Fresh Food Sdn Bhd', 'FF@gmail.com', '010-509 3311', 'ff.com', '6am', '6pm', 'mon-thu', 'Bangunan Kepli Holdings,No.139, Jalan Satok, 93400, Kuching, Sarawak\n', '6559b2ffe9dcb.jpg', '2023-11-24 08:14:05', 'Prices you can\'t beat!', NULL, 0.0, NULL),
(54, 8, 'Always Fresh Canned Goods', 'AF@gmail.com', '014-714 2029', 'af.com', '6am', '6pm', 'mon-wed', 'Ground Floor, Lot G-38, The Spring Shopping Mall, Jalan Simpang 3,[], 93350, Kuching, Sarawak\n', '6559b5b11a1d4.jpg', '2023-11-20 04:48:12', 'Produced and canned locally! Freshness guaranteed or your money back!', NULL, 0.0, NULL),
(55, 6, 'Prime Euro Import Market', 'PEIM@gmail.com', '014-800 7125', 'peim.com', '7am', '5pm', 'mon-thu', 'Lot 880 A, Lorong Song 3 E 2, Jalan Song, 93350, Kuching, Sarawak\n', '6559b77536d01.gif', '2023-11-20 04:48:27', 'We import euro plant based goods at a cheap price!', NULL, 0.0, NULL),
(56, 7, 'Sydney Vegan Market (Malaysia Branch)', 'svm@gmail.com', '019-828 8790', 'svm.com', '8am', '5pm', 'mon-wed', '1, Huo Ping Road, P.O.Box, Sibu, 96008, Sibu, Sarawak\n', '6559b9a2142c4.jpg', '2023-11-20 04:48:39', 'Award winning global vegan franchise!', NULL, 0.0, NULL);

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
(5, 'Fresh', '2023-11-15 13:10:58'),
(6, 'Frozen', '2023-11-15 13:11:04'),
(7, 'Dried', '2023-11-15 13:11:10'),
(8, 'Canned', '2023-11-15 13:11:17'),
(9, 'Other', '2023-11-15 13:11:23');

-- --------------------------------------------------------

--
-- Table structure for table `seller_tg_verification`
--

CREATE TABLE `seller_tg_verification` (
  `id` int(11) NOT NULL,
  `adm_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `chatId` varchar(255) NOT NULL,
  `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seller_tg_verification`
--

INSERT INTO `seller_tg_verification` (`id`, `adm_id`, `code`, `chatId`, `expiration`) VALUES
(1, 12, 'f111d51b', '', '2024-04-20 16:09:08'),
(2, 12, '267bee8e', '', '2024-04-20 16:10:21'),
(3, 12, 'fe8bbad6', '', '2024-04-20 16:25:14'),
(4, 12, 'a272c713', '', '2024-04-20 16:26:12'),
(5, 12, '7ddf46cf', '', '2024-04-20 16:55:58'),
(6, 12, 'bee44e63', '', '2024-04-20 17:13:53'),
(7, 12, '3a377248', '', '2024-04-20 17:15:17'),
(8, 12, 'e37f3c2b', '', '2024-04-20 17:17:44'),
(9, 12, '89286a1e', '', '2024-04-20 17:24:10'),
(10, 12, '3abfd1a3', '', '2024-04-20 17:42:51'),
(11, 12, 'dc7c29be', '', '2024-04-20 17:48:15'),
(12, 12, 'c94680e8', '', '2024-04-20 17:49:02'),
(13, 12, '5246513e', '', '2024-04-20 17:59:46'),
(14, 12, '177bea0f', '', '2024-04-20 18:04:56'),
(15, 12, 'dafe9329', '', '2024-04-20 18:07:00'),
(16, 12, '235d1303', '', '2024-04-30 16:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `stars`
--

CREATE TABLE `stars` (
  `id` int(11) NOT NULL,
  `rateIndex` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblemployee`
--

CREATE TABLE `tblemployee` (
  `empNo` int(10) NOT NULL,
  `empID` varchar(30) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `icNo` varchar(15) NOT NULL,
  `empname` varchar(100) NOT NULL,
  `empgender` varchar(2) NOT NULL,
  `empcontact` varchar(12) NOT NULL,
  `empemail` varchar(30) NOT NULL,
  `empjob` int(10) NOT NULL,
  `code` varchar(10) NOT NULL,
  `u_role` varchar(10) NOT NULL,
  `empstore` int(10) NOT NULL,
  `empstatus` int(11) NOT NULL,
  `email_token` varchar(255) NOT NULL,
  `email_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblemployee`
--

INSERT INTO `tblemployee` (`empNo`, `empID`, `username`, `password`, `icNo`, `empname`, `empgender`, `empcontact`, `empemail`, `empjob`, `code`, `u_role`, `empstore`, `empstatus`, `email_token`, `email_verified`) VALUES
(1, '51231221124541', '', '', '214748364719', 'Haill', '2', '01234567891', '4@gmail.com', 1, '0', '0', 0, 1, '', 0),
(2, '51231221125016', '', '', '3', '4', '2', '1', '6', 1, '0', '0', 0, 1, '', 0),
(3, '51231221125018', '', '', '3', '4', '2', '1', '6', 1, '0', '0', 51, 1, '', 0),
(4, '51231221125255', '', '', '1', '2', '2', '1', 'ryanwong179@gmail.com', 2, '0', '0', 51, 1, '', 0),
(5, '51231221125305', '', '', '1', '2', '1', '3', '4', 2, '0', '0', 51, 1, '', 0),
(6, '51231221125125', '', '', '3', '4', '1', '5', '6', 1, '0', '0', 51, 1, '', 0),
(7, '51231221125453', '', '', '444', '333', '1', '666', '777', 1, '0', '0', 51, 1, '', 0),
(8, '51231221125459', '', '', '444', '333', '1', '666', '777', 1, '0', '0', 51, 1, '', 0),
(9, '51231221125505', '', '', '444', '333', '1', '666', '777', 1, '0', '0', 51, 1, '', 0),
(10, '51231221125508', '', '', '444', '333', '1', '666', '777', 1, '0', '0', 51, 1, '', 0),
(11, '51231221125513', '', '', '444', '333', '1', '666', '777', 1, '0', '0', 51, 1, '', 0),
(12, '51231221125624', '', '', '123', '2', '1', '3', '4', 1, '0', '0', 51, 1, '', 0),
(13, '51231221125635', '', '', '3', '4', '1', '5', '6', 1, '0', '0', 51, 1, '', 0),
(14, '51231221130452', '', '', '1', '2', '1', '3', '4', 1, '0', '0', 51, 1, '', 0),
(16, '51231221130518', '', '', '1', '2', '2', '3', '4', 2, '0', '0', 51, 1, '', 0),
(17, '51231223223851', '', '', '255', 'www ccc', '2', '51288', 'r@b.d', 3, '0', '0', 51, 1, '', 0),
(52, '0240426012326', 'emp', '$2y$10$2H36VLSDLHCZo1qfRcgOtOlHNWhOTb3ggy1TBaBokzQtjzzMv3eGO', '021111111111', 'kelvin', '1', '01111111111', 'codingtesting280622@gmail.com', 1, 'VSUPP', 'VSELLER', 0, 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblprice`
--

CREATE TABLE `tblprice` (
  `priceNo` int(10) NOT NULL,
  `productID` varchar(30) NOT NULL,
  `proQuant` int(11) NOT NULL DEFAULT 15,
  `proWeight` int(20) NOT NULL,
  `proPrice` float NOT NULL,
  `proDisc` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblprice`
--

INSERT INTO `tblprice` (`priceNo`, `productID`, `proQuant`, `proWeight`, `proPrice`, `proDisc`) VALUES
(16, '26', 15, 100, 5, 0),
(17, '26', 15, 200, 10, 0),
(18, '26', 15, 300, 15, 10),
(19, '27', 15, 500, 30, 90),
(20, '25', 15, 120, 160, 50),
(21, '28', 15, 500, 30, 0),
(22, '29', 9, 200, 45, 0),
(23, '30', 15, 1000, 400, 40),
(24, '31', 15, 100, 4, 0),
(25, '32', 15, 100, 90, 0),
(26, '33', 15, 15, 9, 0),
(27, '34', 15, 30, 7, 0),
(28, '35', 15, 500, 1800.99, 70);

-- --------------------------------------------------------

--
-- Table structure for table `tblvalidation`
--

CREATE TABLE `tblvalidation` (
  `validNo` int(10) NOT NULL,
  `frontImg` varchar(200) NOT NULL,
  `backImg` varchar(200) NOT NULL,
  `faceImg` varchar(200) NOT NULL,
  `imgStatus` int(10) NOT NULL,
  `comment` varchar(10000) NOT NULL,
  `storeID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblvalidation`
--

INSERT INTO `tblvalidation` (`validNo`, `frontImg`, `backImg`, `faceImg`, `imgStatus`, `comment`, `storeID`) VALUES
(6, 'http://localhost/lfsc/seller/images/verify/661b5128e34ec.JPG', 'http://localhost/lfsc/seller/images/verify/661b5128e372c.JPG', 'http://localhost/lfsc/seller/images/verify/661b5128e38e2.JPG', 3, '', '52');

-- --------------------------------------------------------

--
-- Table structure for table `tg_verification`
--

CREATE TABLE `tg_verification` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `chatId` varchar(255) NOT NULL,
  `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tg_verification`
--

INSERT INTO `tg_verification` (`id`, `userId`, `code`, `chatId`, `expiration`) VALUES
(1, 2, 'b6029bf2', '', '2024-03-27 00:11:37'),
(2, 2, 'f7c8eb15', '', '2024-03-28 00:30:46'),
(3, 2, '4918b98a', '', '2024-04-16 17:27:46'),
(4, 2, '693b2379', '', '2024-04-16 17:46:51'),
(5, 2, '421073cd', '', '2024-04-20 11:59:00'),
(6, 2, 'ca7f426a', '', '2024-04-20 12:03:10'),
(7, 2, '89e163b1', '', '2024-04-20 12:21:16'),
(8, 2, '59588028', '', '2024-04-20 12:47:03'),
(9, 2, '6e2bc1b6', '', '2024-04-20 12:51:05'),
(10, 2, 'caccc690', '', '2024-04-20 12:52:29'),
(11, 2, 'ddb516b9', '', '2024-04-20 13:03:14'),
(12, 2, '141c2711', '', '2024-04-20 16:56:32'),
(13, 2, 'bc505ad2', '', '2024-04-20 17:14:35'),
(14, 35, '36c3363b', '', '2024-04-21 14:43:46'),
(15, 35, 'df85c302', '', '2024-04-21 14:45:06'),
(16, 2, '7aa21c00', '', '2024-04-30 16:08:17');

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
  `gender` varchar(20) NOT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int(222) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `chat_id` bigint(20) NOT NULL,
  `notifications_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `email_token` varchar(255) NOT NULL DEFAULT '',
  `email_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `fullName`, `gender`, `dob`, `email`, `phone`, `password`, `address`, `status`, `date`, `chat_id`, `notifications_enabled`, `email_token`, `email_verified`) VALUES
(2, 'cust1', 'cust', 'one', 'cust one', '', NULL, 'qweqwe123@hotmail.com', '1232343456', '$2y$10$n8zOEwX0Ar7fGlTV1Hxi.OVCGwOG9PMxLsDGe2wZ.nys2i4gpNL4S', 'afqwe123', 1, '2024-04-25 17:34:04', 0, 1, '', 0),
(3, 'cust2', 'cust', 'two', 'cust two', '', NULL, 'qweqwr@gmail.com', '1231231235', '$2y$10$fbEIRMnpFGJoD7dNhUvFNuF9Qz62fj0CMutGXVTAKw99lspODNxu.', 'werb123', 1, '2023-11-19 06:29:54', 0, 1, '', 0),
(4, 'cust3', 'cust', 'three', 'cust three', '', NULL, 'sdvsd@gmail.com', '1231345234', '$2y$10$uB.HAMXvQWCOn7CqpL/iTuoBW1L.jTCMWIM.2L8OdOHx72BHRcQna', 'qwe1231', 1, '2023-11-19 06:30:31', 0, 1, '', 0),
(5, 'StephenTan95', 'Tan', 'Stephen ', 'Tan Stephen ', '', NULL, 'stephentan44@gmail.com', '0102170960', '$2y$10$a3.38jkGAaxGdGS9QD1mseDhmU7WYKEc0qNIkVGfPcT4R5j3bPbFy', '547 lorong 3 rose garden\r\n93250 kuching Sarawak', 1, '2023-11-26 06:05:31', 0, 1, '', 0),
(6, 'John Doe', 'John', 'Doe', 'John Doe', '', NULL, 'jdoe@gmail.com', '0134569780', '$2y$10$hZ3zlibC0LRIEmM62txjWe15HLPzJniYYrTpyc0GH/py4ObjuNtx2', '123 jeline street', 1, '2023-12-01 01:44:03', 0, 1, '', 0),
(31, 'cust4', '', '', '', '', NULL, 'devinchp@gmail.com', '', '$2y$10$yNAWOf8N1IcDAWT6J2iLrOitTY0SeSStA3HtB0LY./Sm3jR6sDIqy', '', 1, '2024-04-04 04:21:18', 0, 1, '', 1),
(32, 'cust5', '', '', '', '', NULL, 'allianzwierdchamp@gmail.com', '', '$2y$10$v4AjaNSxSEWcoA1bYhMWhOTW8UH7l7Xc43Vj0o7zxJB57K45sd1t6', '', 1, '2024-04-04 04:22:12', 0, 1, '', 1),
(33, 'cust6', '', '', '', '', NULL, 'polarsxorion@gmail.com', '', '$2y$10$ZJ9ud7I5od18Waqeet3uXOKYCop7U3V880wBvekUa.qJ47TMozbZy', '', 1, '2024-04-04 04:23:10', 0, 1, '', 1),
(35, 'skyfarm96', '', '', 'MICHAEL CHAI', 'male', '1977-02-13', 'skyangel77@gmail.com', '0128789600', '$2y$10$dQ4qx3F1HUMi605PVdtZv.7J8SKjaBIb9ebDkQC8WPwYP/g6OHemC', 'Eden 2, MeiMei Road', 1, '2024-04-22 16:49:12', 5964495496, 1, '', 1),
(38, 'emtskw2m', '', '', '', '', NULL, 'ganedison99@hotmail.com', '', '$2y$10$dlaBftm0GZDOC6.psb3XyOmA82hef6XU7OE7sMUFVGzr7DHy.pk5W', '', 1, '2024-04-23 15:04:01', 0, 1, '', 1),
(39, 'www', '', '', '', '', NULL, 'ryan@gmail.com', '', '$2y$10$r3zyPKHW6CDmR1u9Y2PYvu0Y9lF2W3VDSh68bFf9GqZ2p1hXWid1u', '', 1, '2024-04-25 14:12:47', 0, 1, '', 1),
(45, 'cust', '', '', '', '', NULL, 'codingtesting280622@gmail.com', '', '$2y$10$4cmaz7Z1tgn2zNi3I4HOReBISRRDNIpySTpMCza1hSrE9NFgSmDqK', '', 10, '2024-04-25 15:11:07', 0, 1, 'dce91a988301270edf091bdc4163b47623bd8985cd42fb14316cf9d6906c2015eb463a0168345186c170b2d38bf43f31ac77', 0),
(46, 'cust', '', '', '', '', NULL, 'codingtesting280622@gmail.com', '', '$2y$10$bIIJibF5NZtvNXZAxVaBAuAJjAYKmXi8Qbi7tSU584ocuzW3cRW4S', '', 0, '2024-04-25 15:19:16', 0, 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_comments`
--

CREATE TABLE `user_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_comments`
--

INSERT INTO `user_comments` (`id`, `user_id`, `res_id`, `comment`, `created_at`) VALUES
(1, 2, 51, 'test 69', '2024-03-24 14:41:52'),
(2, 39, 51, 'abcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjjabcjjjj', '2024-04-25 05:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_ratings`
--

CREATE TABLE `user_ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_ratings`
--

INSERT INTO `user_ratings` (`id`, `user_id`, `res_id`, `rating`) VALUES
(1, 3, 51, 4),
(2, 2, 51, 1),
(3, 2, 52, 5),
(4, 2, 54, 4),
(5, 2, 53, 1),
(6, 39, 51, 4),
(7, 39, 52, 4),
(8, 39, 53, 4),
(9, 39, 54, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Indexes for table `custom_prices`
--
ALTER TABLE `custom_prices`
  ADD PRIMARY KEY (`price_id`,`user_id`);

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
-- Indexes for table `payment_receipts`
--
ALTER TABLE `payment_receipts`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `order_id` (`order_id`);

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
-- Indexes for table `seller_tg_verification`
--
ALTER TABLE `seller_tg_verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adm_id_index` (`adm_id`);

--
-- Indexes for table `stars`
--
ALTER TABLE `stars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblemployee`
--
ALTER TABLE `tblemployee`
  ADD PRIMARY KEY (`empNo`);

--
-- Indexes for table `tblprice`
--
ALTER TABLE `tblprice`
  ADD PRIMARY KEY (`priceNo`);

--
-- Indexes for table `tblvalidation`
--
ALTER TABLE `tblvalidation`
  ADD PRIMARY KEY (`validNo`);

--
-- Indexes for table `tg_verification`
--
ALTER TABLE `tg_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `user_comments`
--
ALTER TABLE `user_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `res_id` (`id`) USING BTREE;

--
-- Indexes for table `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_restaurant_unique` (`user_id`,`res_id`),
  ADD KEY `res_id` (`res_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payment_receipts`
--
ALTER TABLE `payment_receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seller_tg_verification`
--
ALTER TABLE `seller_tg_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `stars`
--
ALTER TABLE `stars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblemployee`
--
ALTER TABLE `tblemployee`
  MODIFY `empNo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tblprice`
--
ALTER TABLE `tblprice`
  MODIFY `priceNo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tblvalidation`
--
ALTER TABLE `tblvalidation`
  MODIFY `validNo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tg_verification`
--
ALTER TABLE `tg_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user_comments`
--
ALTER TABLE `user_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_ratings`
--
ALTER TABLE `user_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD CONSTRAINT `user_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`),
  ADD CONSTRAINT `user_ratings_ibfk_2` FOREIGN KEY (`res_id`) REFERENCES `restaurant` (`rs_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
