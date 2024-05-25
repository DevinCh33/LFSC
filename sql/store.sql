-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2024 at 10:38 AM
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
  `token_expiration` datetime DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `adm_Name`, `username`, `password`, `email`, `contact_num`, `code`, `u_role`, `store`, `date`, `storeStatus`, `chat_id`, `email_token`, `token_expiration`, `email_verified`) VALUES
(11, 'Wong ', 'admin', '$2y$10$vg.3MfpjSjJTpPI09uAopOwev2j7r5DV3AvweyJ0vj43aOhd0w1Me', 'ryan@gmail.com', '01151385427', 'SUPA', 'ADMIN', 0, '2024-04-25 13:55:20', 1, NULL, '', NULL, 1),
(12, 'seller1', 'seller1', '$2y$10$Y0km5qMfclCCZZkV1d2pae2RholqmoUoRRnSCubbUOjG6FkvzhKAu', 'gary@gmail.com', '0824191000', 'SUPP', 'SELLER', 52, '2024-05-06 06:28:57', 1, NULL, '', NULL, 1),
(13, 'Fresh Food', 'seller2', '$2y$10$2EW2Ly7HAoVbF4ElZhXw6edycO5cT/f7qQkFoOf6jkfLW.9OaZuaq', 'arthur@gmail.com', '01235632345', 'SUPP', 'SELLER', 53, '2024-05-24 17:08:07', 1, NULL, '', NULL, 1),
(14, 'Canned', 'seller3', '$2y$10$m233uylckhgVjLfZVGjnS.xCkFcmiQsZp0Ra0YhzROgbrrY3hIvw6', 'baron@gmail.com', '0132341356', 'SUPP', 'SELLER', 54, '2024-05-24 17:08:54', 1, NULL, '', NULL, 1),
(15, 'Eurobeat', 'seller4', '$2y$10$O718h9GzhI9bHdJ2uz5qc.Get1hgjeQqs6DnERF.xLh8DN/cnY2Bi', 'ricky@gmail.com', '0132453647', 'SUPP', 'SELLER', 55, '2024-05-24 17:10:24', 1, NULL, '', NULL, 1),
(16, 'Sydneyyegws', 'seller5', '$2y$10$24yfPOHwly.E1EXRFAc7aeuPrbJGfdTc0yAmFqaWyw5LlHsmVs9Fq', 'greg@gmail.com', '01423124356', 'SUPP', 'SELLER', 56, '2024-05-24 17:10:51', 1, NULL, '', NULL, 1),
(17, 'susamongus', 'scientist', '$2y$10$V6uvYI7.V7OPphipVrxPheFxgF5z./9Awu4PDbAaxIJxRGYL5WcWm', 'scientist@happyfoods.com', '01324536346', 'SUPP', 'SELLER', 57, '2024-05-24 17:16:19', 1, NULL, '', NULL, 1),
(18, 'John michael', 'michael', '$2y$10$BXuUzFFhom.idRwxXKiz1.adJ4mKCuxbHS8WDiS5fTbuwzw48uIDa', 'michael@gmail.com', '0132453547', 'SUPP', 'SELLER', 51, '2024-05-25 03:48:26', 1, NULL, '', NULL, 1),
(21, 'seller11', 'seller11', '$2y$10$FSlcxKmyl4spff8GD4wEgOke0xsSJHcMr6TnceE0EjtUMGFqd.5Y6', '1cockaricka@gmail.com', '0123541467', 'SUPP', 'SELLER', 60, '2024-05-15 04:05:27', 1, NULL, '', NULL, 1),
(22, 'Amy', 'seller12', '$2y$10$El.OX0dGY5ThxT.7K1Lqjewz9q6Y88WN95gZfzPzVefIizTXAjgXi', '100083603@students.swinburne.edu.my', '0143547869', 'SUPP', 'SELLER', 61, '2024-05-15 05:07:35', 1, NULL, '', NULL, 1),
(23, 'John Beverage', 'seller13', '$2y$10$JrtMaYwI2.l7J5wJnIFIyuC08KEhHOaPMTKePmjaf5w7EDrOITmc6', 'hijarajar@gmail.com', '0145328946', 'SUPP', 'SELLER', 62, '2024-05-15 05:41:09', 1, NULL, '', NULL, 1),
(24, 'John Balko', 'seller14', '$2y$10$MjYUjkfjzft5yj0hjA7Dx.H3oGmkbXJNWtUvn6WrbztLy1FDm7gDy', 'allianzwierdchamp@gmail.com', '0132354539', 'SUPP', 'SELLER', 63, '2024-05-15 06:06:39', 1, NULL, '', NULL, 1),
(25, 'seller15', 'seller15', '$2y$10$FFjB6xjahLpvrg6sBcX3aORiGSkmFW5V7tnwc95RzS9hcrCtZOXJu', 'devinchp@gmail.com', '0132122356', 'SUPP', 'SELLER', 64, '2024-05-15 06:33:18', 1, NULL, '', NULL, 1);

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
(6, 'Spices', 1, 1),
(7, 'Meat', 1, 1),
(8, 'Seafood', 1, 1),
(9, 'Dairy', 1, 1),
(11, 'Grains', 1, 1),
(12, 'Pasta', 1, 1),
(13, 'Bread', 1, 1),
(14, 'Bakery Items', 1, 1),
(15, 'Canned Goods', 1, 1),
(16, 'Frozen Foods', 1, 1),
(17, 'Condiments', 1, 1),
(18, 'Cooking Oils', 1, 1),
(19, 'Sauces', 1, 1),
(20, 'Breakfast Foods', 1, 1),
(21, 'Desserts', 1, 1),
(22, 'Baby Food', 1, 1),
(23, 'Water', 1, 1),
(24, 'Soft Drinks', 1, 1),
(25, 'Juice', 1, 1),
(26, ' Coffee', 1, 1),
(27, 'Tea', 1, 1),
(28, 'Sports Drinks', 1, 1),
(29, 'Alcoholic Beverages', 1, 1),
(30, 'Energy Drinks', 1, 1),
(31, 'Smoothies', 1, 1);

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
(9, '2024-04-22', 'Michael Chai', '0128789600', '66.15', '66.15', '0', '66.15', 1, 2, 35, 52, '2024-04-22 10:45:33', 0),
(10, '2024-04-22', 'Michael Chai', '0128789600', '4.7', '4.7', '4.7', '0', 1, 3, 35, 51, '2024-04-22 10:48:15', 0),
(11, '2024-04-30', 'Jason Lim', '0218882102', '12.6', '12.6', '0', '12.6', 2, 3, 2, 52, '2024-04-30 07:59:40', 0),
(12, '2024-05-13', 'Jason Lim', '0218882102', '14.74', '14.74', '0', '14.74', 1, 3, 2, 51, '2024-05-13 11:29:35', 0),
(13, '2024-05-13', 'Jason Lim', '0218882102', '30.62', '30.62', '0', '30.62', 1, 3, 2, 51, '2024-05-13 11:43:04', 0),
(14, '2024-05-13', 'Jason Lim', '0218882102', '68.25', '68.25', '0', '68.25', 1, 3, 2, 52, '2024-05-13 11:43:04', 0),
(15, '2024-05-13', 'Jason Lim', '0218882102', '14.74', '14.74', '0', '14.74', 1, 3, 2, 51, '2024-05-13 11:53:50', 0),
(16, '2024-05-13', 'Jason Lim', '0218882102', '2.1', '2.1', '0', '2.1', 1, 3, 2, 52, '2024-05-13 11:53:50', 0),
(17, '2024-05-25', 'Ashley Tan', '0217719273', '230', '230', '0', '230', 1, 1, 3, 64, '2024-05-25 08:21:08', 0),
(18, '2024-05-25', 'Ashley Tan', '0217719273', '799', '799', '0', '799', 1, 2, 3, 61, '2024-05-25 08:21:08', 0),
(19, '2024-05-25', 'Ashley Tan', '0217719273', '20', '20', '0', '20', 1, 2, 3, 60, '2024-05-25 08:21:08', 0),
(20, '2024-05-25', 'William Donald', '0123456789', '4', '4', '0', '4', 1, 1, 4, 60, '2024-05-25 08:22:50', 0),
(21, '2024-05-25', 'William Donald', '0123456789', '334', '334', '0', '334', 1, 3, 4, 62, '2024-05-25 08:22:50', 0),
(22, '2024-05-25', 'William Donald', '0123456789', '102', '102', '0', '102', 1, 3, 4, 63, '2024-05-25 08:22:50', 0),
(23, '2024-05-25', ' ', '', '252', '252', '0', '252', 1, 3, 31, 56, '2024-05-25 08:34:02', 0),
(24, '2024-05-25', ' ', '', '20.85', '20.85', '0', '20.85', 1, 1, 31, 54, '2024-05-25 08:34:02', 0),
(25, '2024-05-25', ' ', '', '200', '200', '0', '200', 1, 3, 31, 63, '2024-05-25 08:34:02', 0),
(26, '2024-05-25', ' ', '', '92', '92', '0', '92', 1, 3, 31, 53, '2024-05-25 08:34:02', 0),
(27, '2024-05-25', ' ', '', '3', '3', '0', '3', 1, 1, 31, 62, '2024-05-25 08:34:02', 0),
(28, '2024-05-25', ' ', '', '1.25', '1.25', '0', '1.25', 1, 1, 32, 51, '2024-05-25 08:35:06', 0),
(29, '2024-05-25', ' ', '', '40', '40', '0', '40', 1, 1, 32, 64, '2024-05-25 08:35:06', 0),
(30, '2024-05-25', ' ', '', '162', '162', '0', '162', 1, 1, 32, 60, '2024-05-25 08:35:07', 0),
(31, '2024-05-25', ' ', '', '603', '603', '0', '603', 1, 1, 32, 61, '2024-05-25 08:35:07', 0),
(32, '2024-05-25', ' ', '', '2.1', '2.1', '0', '2.1', 1, 1, 33, 52, '2024-05-25 08:36:32', 0),
(33, '2024-05-25', ' ', '', '0.85', '0.85', '0', '0.85', 1, 1, 33, 53, '2024-05-25 08:36:32', 0),
(34, '2024-05-25', ' ', '', '12.55', '12.55', '0', '12.55', 1, 1, 33, 54, '2024-05-25 08:36:32', 0),
(35, '2024-05-25', ' ', '', '80', '80', '0', '80', 1, 1, 33, 55, '2024-05-25 08:36:32', 0),
(36, '2024-05-25', ' ', '', '31.5', '31.5', '0', '31.5', 1, 1, 33, 56, '2024-05-25 08:36:32', 0),
(37, '2024-05-25', ' ', '', '126', '126', '0', '126', 1, 1, 33, 61, '2024-05-25 08:36:32', 0),
(38, '2024-05-25', ' ', '', '30', '30', '0', '30', 1, 1, 33, 64, '2024-05-25 08:36:32', 0);

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
(15, 11, 22, '6'),
(16, 12, 35, '1'),
(17, 12, 19, '1'),
(18, 12, 17, '3'),
(19, 13, 19, '1'),
(20, 13, 17, '1'),
(21, 13, 34, '1'),
(22, 13, 37, '1'),
(23, 14, 22, '1'),
(24, 14, 23, '1'),
(25, 15, 20, '1'),
(26, 15, 21, '1'),
(27, 15, 18, '3'),
(28, 16, 22, '1'),
(29, 17, 72, '1'),
(30, 17, 73, '2'),
(31, 18, 48, '1'),
(32, 18, 54, '1'),
(33, 18, 56, '1'),
(34, 19, 45, '1'),
(35, 20, 46, '1'),
(36, 21, 59, '1'),
(37, 21, 62, '3'),
(38, 21, 63, '1'),
(39, 22, 70, '1'),
(40, 22, 68, '1'),
(41, 23, 76, '4'),
(42, 24, 26, '1'),
(43, 25, 66, '20'),
(44, 26, 25, '20'),
(45, 27, 58, '1'),
(46, 28, 16, '1'),
(47, 29, 75, '1'),
(48, 29, 74, '1'),
(49, 30, 44, '1'),
(50, 31, 48, '1'),
(51, 32, 22, '1'),
(52, 33, 24, '1'),
(53, 34, 27, '1'),
(54, 35, 38, '1'),
(55, 36, 79, '1'),
(56, 37, 54, '1'),
(57, 38, 72, '1');

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
(37, 'L0002', 'Extra Sweet and Spicy Chili', 'http://localhost/lfsc/seller/images/product/663316cbdc711.jpg', 'Thai chili sauce added with our experimental spicy sugar.', 6, '57', '2024-05-02', 30, 1),
(38, 'G0002', 'Just Bread', 'http://localhost/lfsc/seller/images/product/6638d9879351c.jpeg', 'Literally just bread ', 6, '55', '2024-05-06', 60, 1),
(39, 'G0003', 'Super bread', 'http://localhost/lfsc/seller/images/product/6638dafd322dd.jpeg', 'Super breadSuper breadSuper bread', 13, '55', '2024-05-06', 60, 1),
(40, 'R0003', 'testbrad', 'http://localhost/lfsc/seller/images/product/663c5e1b9095a.', 'testbrad', 1, '52', '2024-05-09', 30, 3),
(41, '123', 'help', 'http://localhost/lfsc/seller/images/product/663c64c28ac33.jpg', 'help', 9, '52', '2024-05-09', 30, 3),
(42, 'M0001', 'Fresh Milk (250ml)', 'http://localhost/lfsc/seller/images/product/66443ee85ca81.jpg', 'Fresh Milk sold in 250ml bottle. Weight is reflective of quantity sold in the case of this product and not the weight of each bottle.', 1, '60', '2024-05-15', 50, 1),
(43, 'M0002', 'Sundarini Whole Milk (500ml)', 'http://localhost/lfsc/seller/images/product/66443f5d844cb.jpg', 'Sundarini Whole Milk sold in 500ml bottle. Weight is reflective of quantity sold in the case of this product and not the weight of each bottle.', 9, '60', '2024-05-15', 50, 1),
(44, 'M0003', 'Soya Bean Milk', 'http://localhost/lfsc/seller/images/product/6644405bd6995.jpg', 'Soya Bean Milk sold in 150ml bottle. Weight is reflective of quantity sold in the case of this product and not the weight of each bottle.', 9, '60', '2024-05-15', 100, 1),
(45, 'm0004', 'dd', 'http://localhost/lfsc/seller/images/product/6644411dd5d37.', 'dd', 9, '60', '2024-05-15', 50, 3),
(46, 'B0001', 'Macarons', 'http://localhost/lfsc/seller/images/product/66444769aacd1.jpg', 'Made to order! Recommended serving: 200g per 10 people.', 21, '61', '2024-05-15', 20, 1),
(47, 'B0002', 'Garlic Bread', 'http://localhost/lfsc/seller/images/product/664447cdc745c.jpg', 'Made to order! Recommended serving: 2000g per 10 people.', 14, '61', '2024-05-15', 20, 1),
(48, 'B0003', 'Cream Pie Rolls', 'http://localhost/lfsc/seller/images/product/664448371f809.jpg', 'Made to order! Recommended serving: 500g per 5 people.', 21, '61', '2024-05-15', 50, 1),
(49, 'B0004', 'American Pie', 'http://localhost/lfsc/seller/images/product/664448a732b03.jpg', 'Made to order! 100g represents 1 pie which is about 10 inches.', 14, '61', '2024-05-15', 10, 1),
(50, 'R0005', 'Sausage Rolls', 'http://localhost/lfsc/seller/images/product/664449231338d.jpg', 'Made to order! Recommended serving: 300g per 10 people.', 14, '61', '2024-05-15', 20, 1),
(51, 'R0006', 'Bread', 'http://localhost/lfsc/seller/images/product/664449a1c28e8.jpg', 'Made to order! 2000g per loaf.', 13, '61', '2024-05-15', 10, 1),
(52, 'D0001', 'Canned Milo (100ml)', 'http://localhost/lfsc/seller/images/product/66444ea0622d9.jpg', 'Canned Milo (100ml). 100g = 1 can.', 28, '62', '2024-05-15', 50, 1),
(53, 'D0002', 'Arizona Tea', 'http://localhost/lfsc/seller/images/product/66444ecf6658a.jpg', '100g = 1 can.', 27, '62', '2024-05-15', 50, 1),
(54, 'D0003', 'Water', 'http://localhost/lfsc/seller/images/product/66444efa6e2dd.jpg', '100g = 1 bottle.', 23, '62', '2024-05-15', 50, 1),
(55, 'D0004', 'Sangkoh Langkau', 'http://localhost/lfsc/seller/images/product/66444f39efd34.', '100g = 1 bottle. 45% alc. content.', 1, '62', '2024-05-15', 30, 3),
(56, 'D0004', 'Sangkoh Langkau', 'http://localhost/lfsc/seller/images/product/66444fb0dd72a.jpg', '100g = 1 bottle. 45% alc. content.', 29, '62', '2024-05-15', 20, 1),
(57, 'D0005', 'Cider', 'http://localhost/lfsc/seller/images/product/66444feee29ce.jpeg', '100g = 1 bottle. 3% alc. content.', 29, '62', '2024-05-15', 50, 1),
(58, 'P0001', 'Frozen Pizza', 'http://localhost/lfsc/seller/images/product/664453cf28a48.jpg', '500g Pepperoni Pizza', 14, '63', '2024-05-15', 20, 3),
(59, 'P0001', 'Frozen Pizza', 'http://localhost/lfsc/seller/images/product/6644542e94299.jpg', '500g Pepperoni Pizza', 16, '63', '2024-05-15', 20, 1),
(60, 'P0002', 'Pizza Sauce', 'http://localhost/lfsc/seller/images/product/6644548b48adb.jpg', 'Home made pizza sauce!', 17, '63', '2024-05-15', 20, 1),
(61, 'R0003', 'Cheese Pizza', 'http://localhost/lfsc/seller/images/product/664454d0cdafd.jpg', 'Our famous cheese pizza! 100g = one 12 inch pizza.', 14, '63', '2024-05-15', 30, 1),
(62, 'P0004', 'Fried Octopus', 'http://localhost/lfsc/seller/images/product/664455a1641de.jpg', 'Cooked to order Fried Octopus!', 8, '63', '2024-05-15', 20, 1),
(63, 'P0005', 'Pasta', 'http://localhost/lfsc/seller/images/product/664455ce36f50.jpg', 'Pasta! Pasta! Pasta!', 12, '63', '2024-05-15', 5, 1),
(64, 'A0001', 'Aussie Jerky', 'http://localhost/lfsc/seller/images/product/664458c7b9d86.jpg', 'Aussie Imported Jerky. 100g per packet', 5, '64', '2024-05-15', 20, 1),
(65, 'A0002', 'Luxury Saffron', 'http://localhost/lfsc/seller/images/product/6644590b94d44.jpg', 'Locally grown saffron!', 6, '64', '2024-05-15', 5, 1),
(66, 'A0003', 'Caviar', 'http://localhost/lfsc/seller/images/product/6644593c9b3fc.jpg', 'Local caviar', 15, '64', '2024-05-15', 20, 1),
(67, 'A0004', 'Thai Jasmin Rice', 'http://localhost/lfsc/seller/images/product/6644599b1da49.jpg', '5000g bag of rice.', 11, '64', '2024-05-15', 20, 1),
(68, 'A0005', 'Cooking Oil', 'http://localhost/lfsc/seller/images/product/664459d33fa0d.jpg', 'Home made cooking oil. 100g = 500ml.', 18, '64', '2024-05-15', 20, 1),
(69, 'V0001', 'Vegan choco Cookies', 'http://localhost/lfsc/seller/images/product/6651a0f5f41c4.jpg', 'Gluten free vegan choco cookies', 14, '56', '2024-05-25', 1000, 1),
(70, 'V0002', 'Poke bowl', 'http://localhost/lfsc/seller/images/product/6651a1cfb1586.jpg', 'Fit and healthy. 100g = 1 bowl', 11, '56', '2024-05-25', 30, 1),
(71, 'V0003', 'Granola', 'http://localhost/lfsc/seller/images/product/6651a20eb2893.jpg', 'Baked to order', 14, '56', '2024-05-25', 30, 1);

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
(51, 1, 'Little Farmer', 'littlefarmer@gmail.com', '0102170960', 'littlefarmerenterprise.justorder.today/v2', '12am', '12am', 'Everday', 'AB102 Ground Floor Parcel 2586-1-9 Lorong Persiaran Bandar Baru Batu Kawa 3D Batu Kawah New Township Jalan Batu Kawa 93250 Kuching Sarawak', 'Res_img/66515f8a29188.png', '2024-05-25 03:48:26', 'Little Farmer has been cultivating organic produce for over two decades. Our commitment to fresh and sustainable farming has made us the choice of many households. Dive in to know more about our journey and values.'),
(52, 1, 'The Green Grocer', 'greengrocer@gmail.com', '0824191000', 'gg.com', '8am', '8pm', 'Mon-Thu', 'Lot 299-303,Section 49 KTLD Jalan Abell, 93000, Kuching, Sarawak\n\n', 'Res_img/6650c9584f289.png', '2024-05-24 17:07:36', 'The Green Grocer is your one stop shop for all things fresh and healthy!'),
(53, 1, 'Fresh Food Sdn Bhd', 'freshfood@gmail.com', '0105093311', 'ff.com', '6am', '6pm', 'Mon-Thu', 'Bangunan Kepli Holdings,No.139, Jalan Satok, 93400, Kuching, Sarawak\n', 'Res_img/6650c977e6267.jpg', '2024-05-24 17:08:07', 'Prices you can\'t beat!'),
(54, 4, 'Always Fresh Canned Goods', 'africano@gmail.com', '0147142029', 'africano.com', '6am', '6pm', 'Tue-Sun', 'Ground Floor, Lot G-38, The Spring Shopping Mall, Jalan Simpang Tiga,  93350, Kuching, Sarawak\n', 'Res_img/6650c9a6138ed.jpg', '2024-05-24 17:08:54', 'Produced and canned locally! Freshness guaranteed or your money back!'),
(55, 5, 'Prime Euro Import Market', 'peim@gmail.com', '0148007125', 'peim.com', '7am', '5pm', 'Thu-Fri', 'Lot 880 A, Lorong Song 3 E 2, Jalan Song, 93350, Kuching, Sarawak\n', 'Res_img/6650ca00862d6.gif', '2024-05-24 17:10:24', 'We import euro plant based goods at a cheap price!'),
(56, 5, 'Sydney Vegan Market (Malaysia Branch)', 'svm@gmail.com', '0198288790', 'svm.com', '8am', '5pm', 'Sat-Sun', '1, Huo Ping Road, P.O.Box, Sibu, 96008, Sibu, Sarawak\n', 'Res_img/6650ca1b0983c.jpg', '2024-05-24 17:10:51', 'Award winning global vegan franchise!'),
(57, 2, 'Lab of Happy Foods', 'lab@happyfoods.com', '0218991141', 'happyfoodslab.com', '6am', '1pm', 'Tue', 'Raia Hotel', 'Res_img/6650cb6384031.jpg', '2024-05-24 17:16:19', 'We buy products from other markets and experiment on them. Thus, we will sell them at an even lower price.'),
(60, 0, 'The Milk Shop', '1cockaricka@gmail.com', '0123541467', '', '', '', '', 'Ground Floor, Crown Towers, Jalan Pending, 93450, Kuching, Sarawak', 'Res_img/6650c6e437eb8.jpg', '2024-05-25 06:37:25', 'Got Milk?'),
(61, 0, 'Amy Catering Bakery', 'amy@gmail.com', '0123424578', '', '', '', '', 'Lot 9808, Section 65, KTLD, Lee Ling Comm. Centre, 93050, Kuching, Sarawak', 'Res_img/6650ca7fcd713.jpg', '2024-05-25 06:38:11', 'Best catering bakery in town!'),
(62, 0, 'The Soda Depot', 'thirst@gmail.com', '0122342364', '', '', '', '', '	LOT 214, 2nd Floor, The spring shopping Mall, Jalan Simpang Tiga 93300 Kuching, Sarawak, 93300, Kuching, Sarawak', 'Res_img/6650cab24c004.jpg', '2024-05-25 06:38:22', 'You Thirst We Quench! We provide fresh and canned drinks!'),
(63, 0, 'Balkaniko Pizza', 'pizzahuy@gmail.com', '0132343421', '', '', '', '', 'No.266, Taman Sri Dagang Jalan Masjid 97000 Bintulu, Sarawak, Malaysia', 'Res_img/6650cae68cf2e.jpg', '2024-05-25 06:38:35', 'We make the best pizza!'),
(64, 0, 'The Anything Everything Shop', 'lux@gmail.com', '0132122356', '', '', '', '', 'Ground Floor, 157, Jalan Kampung Nyabor, 96000, Sibu, Sarawak', 'Res_img/6650cb10ca055.jpg', '2024-05-25 06:38:49', 'My husband goes travelling a lot and brings back a lot of stuff. ');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_categories`
--

CREATE TABLE `restaurant_categories` (
  `rs_id` int(222) NOT NULL,
  `c_id` int(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(5, 'Other', '2023-11-15 13:11:23'),
(6, 'Fruits', '2024-05-06 06:05:19'),
(7, 'Vegetables', '2024-05-06 06:05:33'),
(8, 'Dairy Products', '2024-05-06 06:05:42'),
(9, 'Baked Goods', '2024-05-06 06:05:50'),
(10, 'Preserves and Jams', '2024-05-06 06:06:00'),
(11, 'Artisanal Cheeses', '2024-05-06 06:06:05'),
(12, 'Handcrafted Beverages', '2024-05-06 06:06:08'),
(13, 'Homemade Sauces and Condiments', '2024-05-06 06:06:12'),
(14, 'Organic Meats', '2024-05-06 06:06:16'),
(15, 'Specialty Grains and Legumes', '2024-05-06 06:06:20'),
(16, 'Fresh Herbs and Spices', '2024-05-06 06:06:24'),
(17, 'Natural Sweeteners', '2024-05-06 06:06:27'),
(18, 'Farm-Fresh Eggs', '2024-05-06 06:06:30'),
(19, 'Locally Sourced Honey', '2024-05-06 06:06:34'),
(20, 'Small Batch Wines', '2024-05-06 06:06:37'),
(21, 'Craft Beers and Ales', '2024-05-06 06:06:40'),
(22, 'Herbal Teas and Infusions', '2024-05-06 06:06:44'),
(23, 'Handcrafted Chocolates and Confections', '2024-05-06 06:06:47'),
(24, 'Specialty Oils and Vinegars', '2024-05-06 06:06:50'),
(25, 'Homemade Pickles and Fermented Foods', '2024-05-06 06:06:54');

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
(16, '26', 19, 200, 1.25, 0),
(17, '26', 364, 400, 2.5, 5),
(18, '26', 330, 600, 3.75, 10),
(19, '27', 458, 500, 1, 90),
(20, '25', 400, 900, 6, 40),
(21, '28', 126, 500, 1, 0),
(22, '29', 127, 120, 2.1, 0),
(23, '30', 171, 1000, 73.5, 10),
(24, '31', 366, 140, 0.85, 0),
(25, '32', 400, 250, 4.6, 0),
(26, '33', 496, 500, 20.85, 0),
(27, '34', 325, 425, 12.55, 0),
(28, '35', 441, 340, 12.55, 30),
(29, '36', 324, 375, 3, 0),
(30, '36', 197, 500, 4, 0),
(31, '37', 316, 100, 2, 15),
(34, '24', 485, 300, 2.1, 0),
(35, '23', 181, 300, 7.5, 0),
(36, '23', 154, 500, 14, 0),
(37, '23', 122, 1000, 28, 7),
(38, '38', 44, 355, 80, 0),
(39, '39', 234, 234, 234, 234),
(40, '40', 12, 12, 12, 0),
(41, '41', 80, 80, 80, 0),
(42, '42', 100, 10, 130, 10),
(43, '42', 200, 1, 15, 0),
(44, '43', 49, 10, 180, 10),
(45, '43', 199, 1, 20, 0),
(46, '44', 299, 1, 4, 0),
(47, '45', 100, 1, 35, 0),
(48, '46', 98, 1000, 670, 10),
(49, '46', 200, 200, 120, 0),
(50, '47', 100, 4000, 220, 16),
(51, '47', 200, 500, 30, 0),
(52, '48', 100, 100, 70, 10),
(53, '48', 200, 500, 40, 0),
(54, '49', 18, 500, 140, 10),
(55, '49', 30, 100, 30, 0),
(56, '50', 99, 300, 70, 0),
(57, '51', 50, 2000, 40, 0),
(58, '52', 299, 100, 3, 0),
(59, '53', 199, 100, 10, 0),
(60, '54', 300, 100, 2, 0),
(61, '55', 100, 100, 68, 0),
(62, '56', 65, 100, 98, 0),
(63, '57', 199, 100, 30, 0),
(64, '58', 100, 500, 25, 0),
(65, '59', 100, 500, 25, 0),
(66, '60', 80, 50, 10, 0),
(67, '61', 100, 100, 40, 0),
(68, '62', 29, 100, 100, 10),
(69, '62', 120, 500, 55, 0),
(70, '63', 59, 600, 12, 0),
(71, '64', 200, 100, 20, 0),
(72, '65', 98, 10, 30, 0),
(73, '66', 198, 50, 100, 0),
(74, '67', 99, 5000, 20, 0),
(75, '68', 119, 100, 20, 0),
(76, '69', 1496, 400, 70, 10),
(77, '69', 2000, 150, 30, 0),
(78, '70', 200, 100, 20, 0),
(79, '71', 99, 400, 35, 10),
(80, '71', 300, 200, 20, 0);

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
(7, '../images/verify/664443085bd48.jpg', '../images/verify/664443085ee71.jpg', '../images/verify/664443085f2aa.jpg', 3, '', '61'),
(8, '../images/verify/66444ae145496.jpg', '../images/verify/66444ae145ea3.jpg', '../images/verify/66444ae14608c.jpg', 3, '', '62'),
(9, '../images/verify/664450aa0a58f.jpg', '../images/verify/664450aa0d941.jpg', '../images/verify/664450aa0db3e.jpeg', 3, '', '63'),
(10, '../images/verify/664456aaefe60.jpg', '../images/verify/664456aaf0037.jpg', '../images/verify/664456aaf020d.jpg', 3, '', '64');

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

--
-- Dumping data for table `tg_verification`
--

INSERT INTO `tg_verification` (`id`, `userId`, `code`, `chatId`, `expiration`) VALUES
(1, 2, 'da3150a8', '', '2024-05-25 16:11:29');

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
  `token_expiration` datetime DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `fullName`, `gender`, `dob`, `email`, `phone`, `password`, `address`, `status`, `date`, `chat_id`, `notifications_enabled`, `email_token`, `token_expiration`, `email_verified`) VALUES
(2, 'cust1', 'Jason', 'Lim', 'Jason Lim', 'male', '2000-01-24', 'gerdenremseyjr@hotmail.com', '0218882102', '$2y$10$n8zOEwX0Ar7fGlTV1Hxi.OVCGwOG9PMxLsDGe2wZ.nys2i4gpNL4S', '82 Saradise', 1, '2024-05-01 23:27:29', 0, 1, '', NULL, 1),
(3, 'cust2', 'Ashley', 'Tan', 'Ashley Tan', 'female', '2004-08-12', 'heyitsashleytanxd@gmail.com', '0217719273', '$2y$10$fbEIRMnpFGJoD7dNhUvFNuF9Qz62fj0CMutGXVTAKw99lspODNxu.', '1024 Saberkas', 1, '2024-05-01 23:31:51', 0, 1, '', NULL, 1),
(4, 'cust3', 'William', 'Donald', 'William Donald', 'other', '0000-00-00', 'willdona@youtube.com', '0123456789', '$2y$10$uB.HAMXvQWCOn7CqpL/iTuoBW1L.jTCMWIM.2L8OdOHx72BHRcQna', 'YouTube headquarters at the Spring', 1, '2024-05-25 08:21:50', 0, 1, '', NULL, 1),
(5, 'stephentan44', 'Stephen', 'Tan', 'Stephen Tan', '', NULL, 'stephentan44@gmail.com', '0102170960', '$2y$10$a3.38jkGAaxGdGS9QD1mseDhmU7WYKEc0qNIkVGfPcT4R5j3bPbFy', '547 Lorong 3 Rose Garden\n93250 Kuching Sarawak', 1, '2024-05-01 23:34:20', 0, 1, '', NULL, 1),
(6, 'angrychef', 'John', 'Divasukarno', 'John Divasukarno', '', NULL, 'john@dailychefshow.net', '0134569780', '$2y$10$hZ3zlibC0LRIEmM62txjWe15HLPzJniYYrTpyc0GH/py4ObjuNtx2', '347 CityOne', 1, '2024-05-01 23:36:21', 0, 1, '', NULL, 1),
(31, 'cust4', '', '', '', '', NULL, 'devinchp@gmail.com', '', '$2y$10$yNAWOf8N1IcDAWT6J2iLrOitTY0SeSStA3HtB0LY./Sm3jR6sDIqy', '', 1, '2024-04-04 04:21:18', 0, 1, '', NULL, 1),
(32, 'cust5', '', '', '', '', NULL, 'allianzwierdchamp@gmail.com', '', '$2y$10$v4AjaNSxSEWcoA1bYhMWhOTW8UH7l7Xc43Vj0o7zxJB57K45sd1t6', '', 1, '2024-04-04 04:22:12', 0, 1, '', NULL, 1),
(33, 'cust6', '', '', '', '', NULL, 'polarsxorion@gmail.com', '', '$2y$10$ZJ9ud7I5od18Waqeet3uXOKYCop7U3V880wBvekUa.qJ47TMozbZy', '', 1, '2024-04-04 04:23:10', 0, 1, '', NULL, 1),
(35, 'skyfarm96', 'Michael', 'Chai', 'Michael Chai', 'male', '1977-02-13', 'skyangel77@gmail.com', '0128789600', '$2y$10$dQ4qx3F1HUMi605PVdtZv.7J8SKjaBIb9ebDkQC8WPwYP/g6OHemC', 'Eden 2, MeiMei Road', 1, '2024-05-01 23:41:36', 0, 1, '', NULL, 1),
(38, 'emtskw2m', '', '', '', '', NULL, 'ganedison99@hotmail.com', '', '$2y$10$dlaBftm0GZDOC6.psb3XyOmA82hef6XU7OE7sMUFVGzr7DHy.pk5W', '', 1, '2024-04-23 15:04:01', 0, 1, '', NULL, 1),
(39, 'www', 'Ryan', 'WhoopWhoopWin', 'Ryan WhoopWhoopWin', 'male', '1989-02-09', 'ryan@gmail.com', '', '$2y$10$r3zyPKHW6CDmR1u9Y2PYvu0Y9lF2W3VDSh68bFf9GqZ2p1hXWid1u', '', 1, '2024-05-01 23:39:43', 0, 1, '', NULL, 1),
(43, 'NewCust', '', '', '', '', NULL, '1cockaricka@gmail.com', '', '$2y$10$N3Xrub7unY4j1/Cs44RjGOfVHLwPbyJEgQuXfyo7qtthefkLTUoxO', '', 1, '2024-05-13 11:20:59', 0, 1, '', NULL, 1),
(44, 'cust7', '', '', '', '', NULL, 'hijarajar@gmail.com', '', '$2y$10$PB9Swjs9Oi2pQHZsGjswxO1qN9..UyBjRUmeLns1wwAibCOFj8cbK', '', 1, '2024-05-15 06:47:11', 0, 1, '', NULL, 1);

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
(2, 6, 57, 'I have reported you to the authorities for selling illegal drugs', '2024-04-25 05:26:39'),
(3, 2, 52, 'new comment', '2024-05-06 08:14:37'),
(4, 3, 52, 'thank you', '2024-05-06 09:35:33'),
(5, 4, 52, 'cust3', '2024-05-06 09:39:31'),
(6, 31, 52, 'cust4', '2024-05-06 09:39:47'),
(7, 32, 52, 'cust5', '2024-05-06 09:40:07'),
(9, 2, 53, 'test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment test comment', '2024-05-13 11:29:10'),
(10, 3, 61, 'Good and fresh!', '2024-05-25 08:21:00'),
(11, 4, 63, 'Best in town!', '2024-05-25 08:22:37'),
(12, 31, 56, 'it\\\'s so so', '2024-05-25 08:33:19'),
(13, 33, 61, 'it\\\'s gr8', '2024-05-25 08:36:00');

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
(1, 2, 51, 3),
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
(22, 4, 57, 5),
(23, 2, 53, 3),
(24, 2, 52, 5),
(25, 3, 60, 4),
(26, 3, 61, 3),
(27, 3, 62, 5),
(28, 3, 63, 4),
(29, 3, 64, 4),
(30, 31, 56, 4),
(31, 33, 54, 3),
(32, 33, 55, 4),
(33, 33, 56, 4),
(34, 33, 64, 3),
(35, 33, 63, 4),
(36, 33, 62, 4),
(37, 33, 61, 4),
(38, 33, 60, 3);

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
-- Indexes for table `restaurant_categories`
--
ALTER TABLE `restaurant_categories`
  ADD PRIMARY KEY (`rs_id`,`c_id`),
  ADD KEY `c_id` (`c_id`);

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
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `payment_receipts`
--
ALTER TABLE `payment_receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `seller_tg_verification`
--
ALTER TABLE `seller_tg_verification`
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
  MODIFY `priceNo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `tblvalidation`
--
ALTER TABLE `tblvalidation`
  MODIFY `validNo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tg_verification`
--
ALTER TABLE `tg_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `user_comments`
--
ALTER TABLE `user_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_ratings`
--
ALTER TABLE `user_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `restaurant_categories`
--
ALTER TABLE `restaurant_categories`
  ADD CONSTRAINT `restaurant_categories_ibfk_1` FOREIGN KEY (`rs_id`) REFERENCES `restaurant` (`rs_id`),
  ADD CONSTRAINT `restaurant_categories_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `res_category` (`c_id`);

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
