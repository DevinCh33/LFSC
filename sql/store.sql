-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2024 at 10:32 AM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `adm_Name`, `username`, `password`, `email`, `contact_num`, `code`, `u_role`, `store`, `date`, `storeStatus`, `chat_id`, `email_token`, `email_verified`) VALUES
(11, 'Wong ', 'admin', '$2y$10$vg.3MfpjSjJTpPI09uAopOwev2j7r5DV3AvweyJ0vj43aOhd0w1Me', 'ryan@gmail.com', '01151385427', 'SUPA', 'ADMIN', 0, '2024-04-25 13:55:20', 1, NULL, '', 1),
(12, '', 'seller1', '$2y$10$Y0km5qMfclCCZZkV1d2pae2RholqmoUoRRnSCubbUOjG6FkvzhKAu', 'gary@gmail.com', '', 'SUPP', 'SELLER', 52, '2024-05-02 03:21:39', 1, NULL, '', 1),
(13, '', 'seller2', '$2y$10$2EW2Ly7HAoVbF4ElZhXw6edycO5cT/f7qQkFoOf6jkfLW.9OaZuaq', 'arthur@gmail.com', '', 'SUPP', 'SELLER', 53, '2024-05-02 03:21:55', 1, NULL, '', 1),
(14, '', 'seller3', '$2y$10$m233uylckhgVjLfZVGjnS.xCkFcmiQsZp0Ra0YhzROgbrrY3hIvw6', 'baron@gmail.com', '', 'SUPP', 'SELLER', 54, '2024-05-02 03:22:08', 1, NULL, '', 1),
(15, '', 'seller4', '$2y$10$O718h9GzhI9bHdJ2uz5qc.Get1hgjeQqs6DnERF.xLh8DN/cnY2Bi', 'ricky@gmail.com', '', 'SUPP', 'SELLER', 55, '2024-05-02 03:22:21', 1, NULL, '', 1),
(16, '', 'seller5', '$2y$10$24yfPOHwly.E1EXRFAc7aeuPrbJGfdTc0yAmFqaWyw5LlHsmVs9Fq', 'greg@gmail.com', '', 'SUPP', 'SELLER', 56, '2024-05-02 03:23:01', 1, NULL, '', 1),
(17, '', 'scientist', '$2y$10$V6uvYI7.V7OPphipVrxPheFxgF5z./9Awu4PDbAaxIJxRGYL5WcWm', 'scientist@happyfoods.com', '', 'SUPP', 'SELLER', 57, '2024-05-02 04:00:12', 1, NULL, '', 1),
(18, '', 'lfschain', '$2y$10$BXuUzFFhom.idRwxXKiz1.adJ4mKCuxbHS8WDiS5fTbuwzw48uIDa', 'michael@gmail.com', '', 'SUPP', 'SELLER', 51, '2024-05-02 04:35:41', 1, NULL, '', 1);

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
(1, 'Vegetables', 1, 1),
(2, 'Fruits', 1, 1),
(3, 'Specialty Fruits', 1, 1),
(4, 'Fermented Foods', 1, 1),
(5, 'Dried Foods', 1, 1),
(6, 'Spices', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `custom_prices`
--

CREATE TABLE `custom_prices` (
  `price_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `client_name`, `client_contact`, `sub_total`, `total_amount`, `paid`, `due`, `payment_type`, `order_status`, `user_id`, `order_belong`, `last_updated`, `is_seen`) VALUES
(1, '2023-12-28', 'Jason Lim', '0218882102', '5.76', '5.76', '5.75', '0', 1, 3, 2, 51, '2024-03-22 16:17:30', 0),
(2, '2023-12-28', 'Jason Lim', '0218882102', '5.98', '5.98', '5.98', '0', 1, 3, 2, 51, '2024-03-22 16:17:30', 0),
(4, '2024-04-20', 'Ashley Tan', '0217719273', '4.2', '4.2', '4.2', '0', 2, 3, 3, 52, '2024-04-20 15:28:45', 0),
(5, '2024-04-20', 'Ashley Tan', '0217719273', '66.15', '66.15', '66.15', '0', 2, 3, 3, 52, '2024-04-20 15:29:23', 0),
(6, '2024-04-21', 'Ashley Tan', '0217719273', '3.60', '3.60', '0', '3.60', 1, 2, 3, 51, '2024-04-20 18:05:43', 0),
(7, '2024-04-21', 'Michael Chai', '0128789600', '4.38', '4.38', '4.38', '0', 1, 3, 35, 51, '2024-04-21 06:20:13', 0),
(8, '2024-04-21', 'Michael Chai', '0128789600', '66.15', '66.15', '0', '66.15', 2, 3, 35, 52, '2024-04-21 06:20:13', 0),
(9, '2024-04-22', 'Michael Chai', '0128789600', '66.15', '66.15', '0', '66.15', 1, 1, 35, 52, '2024-04-22 10:45:33', 0),
(10, '2024-04-22', 'Michael Chai', '0128789600', '4.7', '4.7', '4.7', '0', 1, 3, 35, 51, '2024-04-22 10:48:15', 0),
(11, '2024-04-30', 'Jason Lim', '0218882102', '12.6', '12.6', '0', '12.6', 2, 1, 2, 52, '2024-04-30 07:59:40', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_receipts`
--

INSERT INTO `payment_receipts` (`receipt_id`, `order_id`, `receipt_path`, `upload_date`, `status`) VALUES
(1, 5, 'receipts/Screenshot (415).png', '2024-04-26 16:09:09', 1),
(2, 4, 'receipts/Screenshot (328).png', '2024-04-26 16:12:55', 1),
(3, 8, 'receipts/Screenshot (328).png', '2024-04-26 16:13:04', 1);

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
  `owner` text NOT NULL,
  `product_date` text NOT NULL,
  `lowStock` int(5) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `productCode`, `product_name`, `product_image`, `descr`, `categories_id`, `owner`, `product_date`, `lowStock`, `status`) VALUES
(23, 'A0003', 'Avocado', 'http://localhost/lfsc/seller/images/product/6633193e5a98e.jpg', 'Healthy fat for healthy dishes!', 2, '51', '2024-05-02', 30, 1),
(24, 'C0032', 'Fruit Cucumber', 'http://localhost/lfsc/seller/images/product/6633189a0c1ce.png', 'Timun for dishes.', 1, '51', '2024-05-02', 30, 1),
(25, 'C0012', 'Cabbage', 'http://localhost/lfsc/inventory/assets/images/stock/796992726559adc32b426.jpg', 'Fresh cabbage grown without any pesticides.', 1, '51', '2023-12-15', 30, 1),
(26, 'C0022', 'Carrot', 'http://localhost/lfsc/inventory/assets/images/stock/11820960376559ae3774fc1.jpg', 'Grown locally without any pesticides.', 1, '51', '2023-12-15', 30, 1),
(27, 'A0001', 'Green Apple', 'http://localhost/lfsc/inventory/assets/images/stock/7703864506559ae7169855.jpg', 'Freshest apples in Malaysia. Sold in packs of 500g.', 2, '51', '2023-12-15', 30, 1),
(28, 'A0002', 'Red Apple', 'http://localhost/lfsc/inventory/assets/images/stock/656955591157b.jpg', 'Freshest apples in Malaysia. Sold in packs of 500g.', 2, '51', '2023-12-15', 30, 1),
(29, 'R0001', 'Turnip', 'http://localhost/lfsc/inventory/assets/images/stock/5428402576559b19e51b9b.jpg', 'Fresh and pesticide free turnips.', 1, '52', '2023-12-15', 30, 1),
(30, 'R0002', 'Durians', 'http://localhost/lfsc/inventory/assets/images/stock/6561151846559b1ed89b94.jpg', 'Out of season durians, selling out fast! ', 3, '52', '2023-12-15', 30, 1),
(31, 'Z0001', 'Potato', 'http://localhost/lfsc/inventory/assets/images/stock/19212838836559b3b045f68.jpg', 'Fresh potatoes!', 1, '53', '2023-12-15', 30, 1),
(32, 'Z0002', 'Red Strawberries', 'http://localhost/lfsc/inventory/assets/images/stock/6497565306559b43c4bbfb.jpg', 'Fresh! Fresh! Fresh! No Pesticides!', 2, '53', '2023-12-15', 30, 1),
(33, 'K0001', 'Jongga Kimchi', 'http://localhost/lfsc/inventory/assets/images/stock/19839973516559b66d35dde.jpg', 'Our best selling Kimchi!', 4, '54', '2023-12-15', 30, 1),
(34, 'K0002', 'Sunmaid Raisins', 'http://localhost/lfsc/inventory/assets/images/stock/14213419816559b6dbbcc8f.jpg', 'Our most popular raisins!', 5, '54', '2023-12-15', 30, 1),
(35, 'G0001', 'Organic Blue Berries', 'http://localhost/lfsc/inventory/assets/images/stock/15243408556559b8327cfb8.jpg', 'Imported Swedish Blue Berries.', 1, '55', '2023-12-15', 30, 1),
(36, 'L0001', 'Experimented Lemons', 'http://localhost/lfsc/seller/images/product/6633107e940f0.jpg', 'Bought from Everwin and experimented to cure fever immediately. Has an 80% chance to cause sore throat for a day.', 1, '57', '2024-05-02', 30, 1),
(37, 'L0002', 'Extra Sweet and Spicy Chili', 'http://localhost/lfsc/seller/images/product/663316cbdc711.jpg', 'Thai chili sauce added with our experimental spicy sugar.', 6, '57', '2024-05-02', 30, 1);

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
(51, 1, 'Little Farmer', 'littlefarmer@gmail.com', '0102170960', 'littlefarmerenterprise.justorder.today/v2', '12am', '12am', 'Everday', 'AB102 Ground Floor Parcel 2586-1-9 Lorong Persiaran Bandar Baru Batu Kawa 3D Batu Kawah New Township Jalan Batu Kawa 93250 Kuching Sarawak', '655ae7ad8ca9c.png', '2024-05-02 07:41:18', 'Little Farmer has been cultivating organic produce for over two decades. Our commitment to fresh and sustainable farming has made us the choice of many households. Dive in to know more about our journey and values.'),
(52, 1, 'The Green Grocer', 'greengrocer@gmail.com', '0824191000', 'gg.com', '8am', '8pm', 'Mon-Thu', 'Lot 299-303,Section 49 KTLD Jalan Abell, 93000, Kuching, Sarawak\n\n', '6559b15ddab32.png', '2024-05-02 07:41:22', 'The Green Grocer is your one stop shop for all things fresh and healthy!'),
(53, 1, 'Fresh Food Sdn Bhd', 'freshfood@gmail.com', '0105093311', 'ff.com', '6am', '6pm', 'Mon-Thu', 'Bangunan Kepli Holdings,No.139, Jalan Satok, 93400, Kuching, Sarawak\n', '6559b2ffe9dcb.jpg', '2024-05-02 07:41:00', 'Prices you can\'t beat!'),
(54, 4, 'Always Fresh Canned Goods', 'africano@gmail.com', '0147142029', 'africano.com', '6am', '6pm', 'Tue-Sun', 'Ground Floor, Lot G-38, The Spring Shopping Mall, Jalan Simpang Tiga,  93350, Kuching, Sarawak\n', '6559b5b11a1d4.jpg', '2024-05-02 07:40:57', 'Produced and canned locally! Freshness guaranteed or your money back!'),
(55, 5, 'Prime Euro Import Market', 'peim@gmail.com', '0148007125', 'peim.com', '7am', '5pm', 'Thu-Fri', 'Lot 880 A, Lorong Song 3 E 2, Jalan Song, 93350, Kuching, Sarawak\n', '6559b77536d01.gif', '2024-05-02 07:41:49', 'We import euro plant based goods at a cheap price!'),
(56, 5, 'Sydney Vegan Market (Malaysia Branch)', 'svm@gmail.com', '0198288790', 'svm.com', '8am', '5pm', 'Sat-Sun', '1, Huo Ping Road, P.O.Box, Sibu, 96008, Sibu, Sarawak\n', '6559b9a2142c4.jpg', '2024-05-02 07:41:41', 'Award winning global vegan franchise!'),
(57, 2, 'Lab of Happy Foods', 'lab@happyfoods.com', '0218991141', 'happyfoodslab.com', '6am', '1pm', 'Tue', 'Raia Hotel', 'happyfoodslab.jpg', '2024-05-02 07:41:53', 'We buy products from other markets and experiment on them. Thus, we will sell them at an even lower price.');

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
(1, 'Fresh', '2023-11-15 13:10:58'),
(2, 'Frozen', '2023-11-15 13:11:04'),
(3, 'Dried', '2023-11-15 13:11:10'),
(4, 'Canned', '2023-11-15 13:11:17'),
(5, 'Other', '2023-11-15 13:11:23');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(18, '0240426012326', 'emp', '$2y$10$2H36VLSDLHCZo1qfRcgOtOlHNWhOTb3ggy1TBaBokzQtjzzMv3eGO', '021111111111', 'Kelvin', '1', '01111111111', 'tehaccountantkelvin@gmail.com', 1, 'VSUPP', 'VSELLER', 0, 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblprice`
--

CREATE TABLE `tblprice` (
  `priceNo` int(10) NOT NULL,
  `productID` varchar(30) NOT NULL,
  `proQuant` int(11) NOT NULL,
  `proWeight` int(20) NOT NULL,
  `proPrice` float NOT NULL,
  `proDisc` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblprice`
--

INSERT INTO `tblprice` (`priceNo`, `productID`, `proQuant`, `proWeight`, `proPrice`, `proDisc`) VALUES
(16, '26', 20, 200, 1.25, 0),
(17, '26', 368, 400, 2.5, 5),
(18, '26', 333, 600, 3.75, 10),
(19, '27', 460, 500, 1, 90),
(20, '25', 401, 900, 6, 40),
(21, '28', 127, 500, 1, 0),
(22, '29', 130, 120, 2.1, 0),
(23, '30', 172, 1000, 73.5, 10),
(24, '31', 367, 140, 0.85, 0),
(25, '32', 420, 250, 4.6, 0),
(26, '33', 497, 500, 20.85, 0),
(27, '34', 326, 425, 12.55, 0),
(28, '35', 441, 340, 12.55, 30),
(29, '36', 324, 375, 3, 0),
(30, '36', 197, 500, 4, 0),
(31, '37', 316, 100, 2, 15),
(34, '24', 486, 300, 2.1, 0),
(35, '23', 182, 300, 7.5, 0),
(36, '23', 154, 500, 14, 0),
(37, '23', 123, 1000, 28, 7);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `fullName`, `gender`, `dob`, `email`, `phone`, `password`, `address`, `status`, `date`, `chat_id`, `notifications_enabled`, `email_token`, `email_verified`) VALUES
(2, 'cust1', 'Jason', 'Lim', 'Jason Lim', 'male', '2000-01-24', 'gerdenremseyjr@hotmail.com', '0218882102', '$2y$10$n8zOEwX0Ar7fGlTV1Hxi.OVCGwOG9PMxLsDGe2wZ.nys2i4gpNL4S', '82 Saradise', 1, '2024-05-01 23:27:29', 0, 1, '', 1),
(3, 'cust2', 'Ashley', 'Tan', 'Ashley Tan', 'female', '2004-08-12', 'heyitsashleytanxd@gmail.com', '0217719273', '$2y$10$fbEIRMnpFGJoD7dNhUvFNuF9Qz62fj0CMutGXVTAKw99lspODNxu.', '1024 Saberkas', 1, '2024-05-01 23:31:51', 0, 1, '', 1),
(4, 'cust3', 'William', 'Donald', 'William Donald', 'other', '0000-00-00', 'willdona@youtube.com', '0123456789', '$2y$10$uB.HAMXvQWCOn7CqpL/iTuoBW1L.jTCMWIM.2L8OdOHx72BHRcQna', 'YouTube headquarters at the Spring', 1, '2024-05-01 23:47:19', 0, 1, '', 0),
(5, 'stephentan44', 'Stephen', 'Tan', 'Stephen Tan', '', NULL, 'stephentan44@gmail.com', '0102170960', '$2y$10$a3.38jkGAaxGdGS9QD1mseDhmU7WYKEc0qNIkVGfPcT4R5j3bPbFy', '547 Lorong 3 Rose Garden\n93250 Kuching Sarawak', 1, '2024-05-01 23:34:20', 0, 1, '', 1),
(6, 'angrychef', 'John', 'Divasukarno', 'John Divasukarno', '', NULL, 'john@dailychefshow.net', '0134569780', '$2y$10$hZ3zlibC0LRIEmM62txjWe15HLPzJniYYrTpyc0GH/py4ObjuNtx2', '347 CityOne', 1, '2024-05-01 23:36:21', 0, 1, '', 1),
(31, 'cust4', '', '', '', '', NULL, 'devinchp@gmail.com', '', '$2y$10$yNAWOf8N1IcDAWT6J2iLrOitTY0SeSStA3HtB0LY./Sm3jR6sDIqy', '', 1, '2024-04-04 04:21:18', 0, 1, '', 1),
(32, 'cust5', '', '', '', '', NULL, 'allianzwierdchamp@gmail.com', '', '$2y$10$v4AjaNSxSEWcoA1bYhMWhOTW8UH7l7Xc43Vj0o7zxJB57K45sd1t6', '', 1, '2024-04-04 04:22:12', 0, 1, '', 1),
(33, 'cust6', '', '', '', '', NULL, 'polarsxorion@gmail.com', '', '$2y$10$ZJ9ud7I5od18Waqeet3uXOKYCop7U3V880wBvekUa.qJ47TMozbZy', '', 1, '2024-04-04 04:23:10', 0, 1, '', 1),
(35, 'skyfarm96', 'Michael', 'Chai', 'Michael Chai', 'male', '1977-02-13', 'skyangel77@gmail.com', '0128789600', '$2y$10$dQ4qx3F1HUMi605PVdtZv.7J8SKjaBIb9ebDkQC8WPwYP/g6OHemC', 'Eden 2, MeiMei Road', 1, '2024-05-01 23:41:36', 0, 1, '', 1),
(38, 'emtskw2m', '', '', '', '', NULL, 'ganedison99@hotmail.com', '', '$2y$10$dlaBftm0GZDOC6.psb3XyOmA82hef6XU7OE7sMUFVGzr7DHy.pk5W', '', 1, '2024-04-23 15:04:01', 0, 1, '', 1),
(39, 'www', 'Ryan', 'WhoopWhoopWin', 'Ryan WhoopWhoopWin', 'male', '1989-02-09', 'ryan@gmail.com', '', '$2y$10$r3zyPKHW6CDmR1u9Y2PYvu0Y9lF2W3VDSh68bFf9GqZ2p1hXWid1u', '', 1, '2024-05-01 23:39:43', 0, 1, '', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_comments`
--

INSERT INTO `user_comments` (`id`, `user_id`, `res_id`, `comment`, `created_at`) VALUES
(1, 2, 51, 'Freshest in town!', '2024-03-24 14:41:52'),
(2, 6, 57, 'I have reported you to the authorities for selling illegal drugs', '2024-04-25 05:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_ratings`
--

CREATE TABLE `user_ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_ratings`
--

INSERT INTO `user_ratings` (`id`, `user_id`, `res_id`, `rating`) VALUES
(1, 2, 51, 5),
(2, 3, 51, 5),
(3, 4, 51, 5),
(4, 5, 51, 5),
(5, 6, 51, 5),
(6, 31, 51, 5),
(7, 32, 51, 5),
(8, 33, 51, 5),
(9, 35, 51, 5),
(10, 38, 51, 5),
(11, 39, 51, 5),
(12, 3, 52, 5),
(13, 3, 53, 5),
(14, 4, 52, 5),
(15, 4, 53, 5),
(16, 3, 54, 4),
(17, 3, 55, 3),
(18, 4, 54, 5),
(19, 4, 55, 3),
(20, 2, 57, 1),
(21, 3, 57, 1),
(22, 4, 57, 5);

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
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seller_tg_verification`
--
ALTER TABLE `seller_tg_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tblemployee`
--
ALTER TABLE `tblemployee`
  MODIFY `empNo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tblprice`
--
ALTER TABLE `tblprice`
  MODIFY `priceNo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tblvalidation`
--
ALTER TABLE `tblvalidation`
  MODIFY `validNo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tg_verification`
--
ALTER TABLE `tg_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user_comments`
--
ALTER TABLE `user_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_ratings`
--
ALTER TABLE `user_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
