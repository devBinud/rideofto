-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2023 at 09:57 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rideofto`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `phone`, `email`, `role`, `password`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'admin', '9706400183', 'admin@gmail.com', 1, '$2y$10$ib8TcavwxCewBhapMmMj8uTNZnPVHfKV6JqoApD8Z5Kn6bZV8xbRi', '2023-02-10 09:22:39', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_city_town`
--

CREATE TABLE `master_city_town` (
  `id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `city_town` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_city_town`
--

INSERT INTO `master_city_town` (`id`, `region_id`, `city_town`) VALUES
(1, 2, 'Guwahati'),
(2, 3, 'Jorhat');

-- --------------------------------------------------------

--
-- Table structure for table `master_product_attr`
--

CREATE TABLE `master_product_attr` (
  `id` int(11) NOT NULL,
  `product_attr_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_admin` int(11) DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_product_attr`
--

INSERT INTO `master_product_attr` (`id`, `product_attr_name`, `product_type_id`, `created_at`, `updated_at`, `created_by_admin`, `updated_by_admin`) VALUES
(1, 'Color', 1, '2023-03-12 22:38:50', NULL, NULL, NULL),
(2, 'Height', 1, '2023-03-12 22:38:57', NULL, NULL, NULL),
(4, 'Size', 2, '2023-03-13 11:39:25', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_product_category`
--

CREATE TABLE `master_product_category` (
  `id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `product_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_product_category`
--

INSERT INTO `master_product_category` (`id`, `product_type_id`, `product_category`, `category_slug`) VALUES
(1, 2, 'Mountain Bike', 'mountain-bike'),
(2, 1, 'Rural Bikes', 'rural-bikes'),
(4, 2, 'Classic bike', 'classic-bike'),
(6, 1, 'BIKE WITH PARKING SPOT', 'bike-with-parking-spot'),
(7, 1, 'City Bikes', 'city-bikes'),
(8, 1, 'MOUNTAIN BIKES', 'mountain-bikes'),
(9, 2, 'ROAD BIKES', 'road-bikes'),
(12, 2, 'BIKE', 'bike');

-- --------------------------------------------------------

--
-- Table structure for table `master_product_type`
--

CREATE TABLE `master_product_type` (
  `id` int(11) NOT NULL,
  `product_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_product_type`
--

INSERT INTO `master_product_type` (`id`, `product_type`) VALUES
(1, 'Cycle'),
(2, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `master_region`
--

CREATE TABLE `master_region` (
  `id` int(11) NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_region`
--

INSERT INTO `master_region` (`id`, `region`) VALUES
(1, 'Vetapara'),
(2, 'Sixmile'),
(3, 'Ulubari');

-- --------------------------------------------------------

--
-- Table structure for table `master_unit`
--

CREATE TABLE `master_unit` (
  `id` int(11) NOT NULL,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_unit`
--

INSERT INTO `master_unit` (`id`, `unit`) VALUES
(2, 'inch'),
(4, 'Meter');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `vendor_id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `product_category_ids` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_thumbnail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `initial_stock` int(11) NOT NULL DEFAULT 0,
  `remaining_stock` int(11) NOT NULL DEFAULT 0,
  `related_accessories` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_home_delivery` tinyint(1) DEFAULT NULL,
  `max_delivery_distance` float(11,2) DEFAULT NULL,
  `delivery_charge` float(11,2) DEFAULT NULL,
  `min_charge` float(11,2) DEFAULT NULL,
  `deposite_price` float(11,2) DEFAULT NULL,
  `insurance_price` float(11,2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_admin` int(11) DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `is_active`, `vendor_id`, `product_type_id`, `product_category_ids`, `product_name`, `product_slug`, `product_description`, `product_thumbnail`, `product_images`, `initial_stock`, `remaining_stock`, `related_accessories`, `is_home_delivery`, `max_delivery_distance`, `delivery_charge`, `min_charge`, `deposite_price`, `insurance_price`, `created_at`, `updated_at`, `created_by_admin`, `updated_by_admin`) VALUES
(1, '1', 6, 1, '2,7', 'CR001 Street Bicycle', 'cr001-street-bicycle', 'ptate sint incidunt explicabo eligendi', 'h2G46PnJDjxCLUFmUx8Sym.jpg', 'h2G46PnJDjxCLUFmUx8Sym.jpg', 3, 3, '', 0, 20000.00, 0.00, 1.00, NULL, NULL, '2023-03-15 16:33:28', '2023-04-11 05:52:38', NULL, NULL),
(2, '1', 6, 1, '7', 'Mountain Bike', 'mountain-bike', 'Mountain bikes for off roading', 'IMG_Thumbnail1679033171.jpg', 'IMG_ProductImage1679033171.jpg', 2, 2, '', 1, 20000.00, 20.00, 1.00, NULL, NULL, '2023-03-17 11:36:11', NULL, NULL, NULL),
(3, '1', 6, 1, '7', 'Honda CBR', 'hinda-cbr', 'Ride this bike with your partner', 'IMG_Thumbnail1679033327.jpg', 'IMG_ProductImage1679033327.jpg', 3, 3, '', 0, 20000.00, 0.00, 1.00, NULL, NULL, '2023-03-17 11:38:47', '2023-03-31 12:21:11', NULL, NULL),
(5, '1', 6, 2, '1', 'Helmet', 'helmet', 'avbvv', 'IMG_Thumbnail1679328450.jpg', 'IMG_PQXBH1679328450.jpg', 3, 3, '', 0, 20000.00, 0.00, 1.00, NULL, NULL, '2023-03-20 21:37:30', NULL, NULL, NULL),
(6, '1', 6, 2, '9', 'water bottle', 'water-bottle', '<p>A water battle can full fill your energy.</p>', 'IMG_Thumbnail1679382634.jpg', 'IMG_TFROH1679382635.jpg', 5, 5, '', 0, 20000.00, 0.00, 1.00, NULL, NULL, '2023-03-21 12:40:35', NULL, NULL, NULL),
(7, '1', 6, 2, '4', 'Riding Mask', 'riding-mask', '<p>RIding mask&nbsp;</p>', 'IMG_Thumbnail1679382934.jpg', 'IMG_OSLGC1679382934.jpg', 3, 3, '', 0, 20000.00, 0.00, 1.00, NULL, NULL, '2023-03-21 12:45:34', NULL, NULL, NULL),
(8, '1', 6, 2, '4', 'Jacket', 'jacket', '<p>faffa</p>', 'IMG_Thumbnail1679383069.jpg', 'IMG_ZJUEI1679383069.jpg', 3, 3, '', 0, 20000.00, 0.00, 1.00, NULL, NULL, '2023-03-21 12:47:49', '2023-04-11 05:58:38', NULL, NULL),
(10, '1', 6, 1, '6', 'kkkkkkkkkkkk', 'kkkkkkkkkkkk', '<p>cccc</p>', 'IMG_Thumbnail1679662529.jpg', '', 12, 12, '7', 1, 20000.00, 222.00, 1.00, NULL, NULL, '2023-03-24 18:25:29', NULL, NULL, NULL),
(11, '1', 6, 1, '7', 'cccc', 'cccc', '<p>cccc</p>', 'IMG_Thumbnail1679662615.jpg', 'IMG_ZIVLJ1679662615.jpg', 11, 11, '5', 1, 20000.00, 123.00, 1.00, NULL, NULL, '2023-03-24 18:26:55', '2023-03-31 13:09:20', NULL, NULL),
(21, '1', 6, 1, '7,8', 'Royel Enfield', 'royel-enfield', '<p>Royel enfield is good for long jurney. Wish you a joyful jurney with your partner.&nbsp;</p>', 'IMG_Thumbnail1680766445.jpg', '', 5, 5, '7,6', 0, 0.00, 0.00, 0.00, NULL, NULL, '2023-04-06 07:34:05', '2023-04-06 08:29:20', NULL, NULL),
(24, '0', 6, 2, NULL, 'Riding Glove', 'riding-glove', '<p>Riding glove is useful for smoth driving experience.</p>', 'IMG_Thumbnail1680770813.jpg', 'IMG_IOXGG1680770813.jpg', 10, 10, '', 1, 20000.00, 1.00, 0.00, NULL, NULL, '2023-04-06 08:46:53', '2023-04-11 05:58:13', NULL, NULL),
(51, '0', 6, 2, '', 'GPS Tracker', 'gps-tracker', '<p>Useful accessories for riding</p>', 'IMG_Thumbnail1681191970.jpg', '', 5, 5, '', 1, 20000.00, 1.00, 0.00, 0.00, 0.00, '2023-04-11 05:46:10', '2023-04-11 05:57:54', NULL, NULL),
(63, '0', 6, 2, '4', 'Wallet', 'wallet', '<p>Yourdfdf</p>', 'IMG_Thumbnail1681279936.jpg', '', 5, 5, '', 0, 20000.00, 0.00, NULL, NULL, NULL, '2023-04-12 06:12:16', '2023-04-12 06:12:30', NULL, NULL),
(72, '1', 6, 1, '2,6', 'Hero Honda', 'hero-honda', '<p>Want to smooth ride between villages..This is the best choice.</p>', 'IMG_Thumbnail1681280897.jpg', '', 5, 5, '', 1, 20000.00, 0.00, 1.00, 0.00, 0.00, '2023-04-12 06:28:17', '2023-04-12 07:56:13', NULL, NULL),
(84, '0', 6, 2, '1', 'albow gard', 'albow-gard', '<p>Sfcgsfgs</p>', 'IMG_Thumbnail1681284025.jpg', '', 20, 20, '', 0, 20000.00, 0.00, 20.00, NULL, NULL, '2023-04-12 07:20:25', '2023-04-12 07:27:33', NULL, NULL),
(86, '0', 6, 2, '', 'Knee guard', 'knee-guard', '<p>Knee guard is useful for long distance cycling.</p>', 'IMG_Thumbnail1681284413.png', '', 20, 20, '', 0, 20000.00, 0.00, 0.00, 0.00, 0.00, '2023-04-12 07:26:53', '2023-04-12 07:56:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_attr_id` int(11) DEFAULT NULL,
  `attribute_value` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_value_unit_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `vendor_id`, `product_id`, `product_attr_id`, `attribute_value`, `attribute_value_unit_id`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 1, 'black', NULL, '2023-03-15 16:33:28', NULL),
(2, 6, 2, 4, '2', 4, '2023-03-17 11:36:11', NULL),
(3, 6, 2, 1, 'Black', NULL, '2023-03-17 11:36:11', NULL),
(4, 6, 3, 1, 'green', NULL, '2023-03-17 11:38:47', NULL),
(5, 6, 3, 4, '1', 4, '2023-03-17 11:38:47', NULL),
(6, 6, 5, 1, 'yellow', NULL, '2023-03-20 21:37:30', NULL),
(7, 6, 6, 1, 'green', NULL, '2023-03-21 12:40:35', NULL),
(8, 6, 7, 1, 'green', NULL, '2023-03-21 12:45:34', NULL),
(9, 6, 8, 2, '2', 4, '2023-03-21 12:47:49', NULL),
(11, 6, 10, 4, '12', 4, '2023-03-24 18:25:29', NULL),
(12, 6, 11, 4, '12', 4, '2023-03-24 18:26:55', NULL),
(19, 6, 21, 1, 'Black', NULL, '2023-04-06 07:34:05', NULL),
(20, 6, 24, 4, 'xl', NULL, '2023-04-06 08:46:53', NULL),
(21, 6, 24, 1, 'Black', NULL, '2023-04-06 08:46:53', NULL),
(30, 6, 72, 2, '1', 4, '2023-04-12 06:28:17', NULL),
(31, 6, 72, 1, 'Black', NULL, '2023-04-12 06:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_module`
--

CREATE TABLE `system_module` (
  `id` int(11) NOT NULL,
  `module_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_role`
--

CREATE TABLE `system_role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_pic` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address01` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address02` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL,
  `updated_at_admin` datetime DEFAULT NULL,
  `admin_remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `phone`, `email`, `profile_pic`, `address01`, `address02`, `is_active`, `password`, `created_at`, `updated_at`, `updated_by_admin`, `updated_at_admin`, `admin_remark`) VALUES
(2, 'Prakash Boul', '87773 71219', 'Prakash@gmaiul.com', NULL, '', '', '1', '$2y$10$8blIN6IpHN9YtPSNGIx7z.SlgPG84IQQZF.j.72NsHji512IAAqoq', '2023-03-06 16:04:06', NULL, NULL, NULL, NULL),
(3, 'Ab de villiers', '7002415428', 'dasparthapratim@gmail.com', 'p__1679390168.png', 'Nybrogade 2 1203 Copenhagen', 'Nybrogade 2 1203 Copenhagen', '1', '$2y$10$.amUc6O8eJglREVQFredIeJoAqW5B/DwmNRET.rLQZRE6tfePcNFK', '2023-03-16 12:26:10', '2023-03-28 12:21:54', NULL, NULL, NULL),
(4, 'Priyabrat Das', '8486530626', 'priyabrat@gmail.com', NULL, NULL, NULL, '1', '$2y$10$j/lrfbojfRdT/DMl7COmNupJj8Y57Qj2v7etrClFyeboWfQ0ypOYO', '2023-03-22 20:18:02', '2023-04-06 14:27:38', NULL, NULL, NULL),
(5, 'Faf Duplesis', '9613027840', 'faf@gmail.com', 'p__1681223817.jpg', 'Denmark', 'House No 5', '1', '$2y$10$kAKAE.3/nFTSdewnu5Z6POUuR.Fr8rogo4iJDQN5zezfJ47RdQIVC', '2023-04-11 10:27:26', '2023-04-11 20:06:58', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_booking`
--

CREATE TABLE `user_booking` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `pricing_plan_id` int(11) NOT NULL,
  `booking_price` float(11,2) NOT NULL,
  `discount_amount` float(11,2) DEFAULT NULL,
  `final_booking_price` float(11,2) DEFAULT NULL,
  `currency` enum('DKK','EUR') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time` time DEFAULT NULL,
  `return_date` date NOT NULL,
  `return_time` time DEFAULT NULL,
  `insurance_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insurance_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','canceled','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reject_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cencel_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cencel_by_user` int(11) DEFAULT NULL,
  `cenceled_at` datetime DEFAULT NULL,
  `delivery_add_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `approve_reject_at` datetime DEFAULT NULL,
  `approve_rejected_by` int(11) DEFAULT NULL,
  `returned_at` datetime DEFAULT NULL,
  `addn_charge` float(11,2) DEFAULT NULL,
  `addn_charge_payment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_booking`
--

INSERT INTO `user_booking` (`id`, `vendor_id`, `user_id`, `product_id`, `pricing_plan_id`, `booking_price`, `discount_amount`, `final_booking_price`, `currency`, `payment_id`, `pickup_date`, `pickup_time`, `return_date`, `return_time`, `insurance_no`, `insurance_file`, `status`, `reject_reason`, `cencel_reason`, `cencel_by_user`, `cenceled_at`, `delivery_add_id`, `created_at`, `updated_at`, `approve_reject_at`, `approve_rejected_by`, `returned_at`, `addn_charge`, `addn_charge_payment_id`) VALUES
(35, 6, 3, 1, 1, 1.00, NULL, NULL, 'DKK', NULL, '2023-03-22', '12:28:00', '2023-03-22', '13:28:00', NULL, NULL, 'rejected', 'Profile picture is something else', NULL, NULL, NULL, NULL, '2023-03-22 12:31:04', '2023-03-23 21:41:00', '2023-03-23 21:41:00', 6, NULL, NULL, NULL),
(36, 6, 3, 3, 6, 2503.00, NULL, NULL, 'DKK', NULL, '2023-03-22', '14:14:00', '2023-03-23', '14:14:00', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, '2023-03-22 14:14:52', NULL, NULL, NULL, NULL, NULL, NULL),
(37, 6, 4, 2, 5, 253.00, NULL, NULL, 'DKK', NULL, '2023-03-23', '20:18:00', '2023-03-23', '21:18:00', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, NULL, '2023-03-22 20:19:04', '2023-03-23 21:40:50', '2023-03-23 21:40:50', 6, NULL, NULL, NULL),
(38, 6, 3, 2, 5, 253.00, NULL, NULL, 'DKK', NULL, '2023-03-24', '10:35:00', '2023-03-24', '11:35:00', NULL, NULL, 'canceled', NULL, 'changed my mind', 3, '2023-03-24 10:40:27', NULL, '2023-03-24 10:35:17', '2023-03-24 10:40:27', NULL, NULL, NULL, NULL, NULL),
(39, 6, 3, 1, 4, 5.00, NULL, NULL, 'DKK', NULL, '2023-03-28', '12:22:00', '2023-03-29', '12:22:00', NULL, NULL, 'rejected', 'We are closing the company', NULL, NULL, NULL, NULL, '2023-03-28 12:50:27', '2023-04-11 08:49:22', '2023-04-11 08:49:22', 6, NULL, NULL, NULL),
(40, 6, 3, 1, 1, 4.00, NULL, NULL, 'DKK', NULL, '2023-04-04', '13:29:00', '2023-04-04', '14:29:00', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, NULL, '2023-04-04 13:29:46', '2023-04-11 08:48:32', '2023-04-11 08:48:32', 6, NULL, NULL, NULL),
(41, 6, 5, 3, 6, 5001.00, 0.00, NULL, 'DKK', NULL, '2023-04-11', '16:04:00', '2023-04-13', '16:04:00', NULL, NULL, 'canceled', NULL, 'Oparation is very late.', 5, '2023-04-11 20:07:20', NULL, '2023-04-11 10:37:12', '2023-04-11 20:07:20', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_booking_details`
--

CREATE TABLE `user_booking_details` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` float(11,2) NOT NULL,
  `discount_type` enum('flat','percentage') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` float(11,2) DEFAULT NULL,
  `final_product_price` float(11,2) DEFAULT NULL,
  `pricing_plan_id` int(11) DEFAULT NULL,
  `currency` enum('DKK','EUR') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_booking_details`
--

INSERT INTO `user_booking_details` (`id`, `vendor_id`, `user_id`, `booking_id`, `product_id`, `product_price`, `discount_type`, `discount_amount`, `final_product_price`, `pricing_plan_id`, `currency`) VALUES
(29, 6, 3, 35, 1, 1.00, NULL, NULL, NULL, 1, 'DKK'),
(30, 6, 3, 36, 3, 2500.00, NULL, NULL, NULL, 6, 'DKK'),
(31, 6, 3, 36, 5, 1.00, NULL, NULL, NULL, 6, 'DKK'),
(32, 6, 3, 36, 6, 2.00, NULL, NULL, NULL, 6, 'DKK'),
(33, 6, 4, 37, 2, 250.00, NULL, NULL, NULL, 5, 'DKK'),
(34, 6, 4, 37, 6, 1.00, NULL, NULL, NULL, 5, 'DKK'),
(35, 6, 4, 37, 8, 2.00, NULL, NULL, NULL, 5, 'DKK'),
(36, 6, 3, 38, 2, 250.00, NULL, NULL, NULL, 5, 'DKK'),
(37, 6, 3, 38, 6, 1.00, NULL, NULL, NULL, 5, 'DKK'),
(38, 6, 3, 38, 7, 2.00, NULL, NULL, NULL, 5, 'DKK'),
(39, 6, 3, 39, 1, 4.00, NULL, NULL, NULL, 4, 'DKK'),
(40, 6, 3, 39, 5, 1.00, NULL, NULL, NULL, 4, 'DKK'),
(41, 6, 3, 40, 1, 1.00, NULL, NULL, NULL, 1, 'DKK'),
(42, 6, 3, 40, 5, 1.00, NULL, NULL, NULL, 1, 'DKK'),
(43, 6, 3, 40, 6, 2.00, NULL, NULL, NULL, 1, 'DKK'),
(44, 6, 5, 41, 3, 5000.00, NULL, 0.00, 5000.00, 6, 'DKK'),
(45, 6, 5, 41, 5, 1.00, NULL, 0.00, 1.00, 6, 'DKK');

-- --------------------------------------------------------

--
-- Table structure for table `user_delivery_address`
--

CREATE TABLE `user_delivery_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `city_town_id` int(11) NOT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `landmark` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_payment`
--

CREATE TABLE `user_payment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_type` enum('booking_charge','addn_charge') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` enum('pending','success','fail') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_amount` float(11,2) NOT NULL,
  `currency` enum('DKK','EUR') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `tnc_agree_at` datetime DEFAULT NULL,
  `store_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_image` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_town_id` int(11) NOT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_delivery_available` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `max_delivery_distance` float(11,2) DEFAULT NULL COMMENT 'In metre',
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `admin_commission` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `tnc_agree_at`, `store_name`, `password`, `store_image`, `store_phone`, `store_email`, `owner_name`, `owner_phone`, `owner_email`, `bank_details`, `city_town_id`, `postal_code`, `address`, `latitude`, `longitude`, `is_delivery_available`, `max_delivery_distance`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`, `admin_commission`) VALUES
(6, '2023-04-07 06:19:42', 'Prakash Bike Store', '$2y$10$l85t6FH1Wwp5v5RUgjiwpe1N7RIG1XWR62HfGtTBSsWbErf/TM2Lq', 'v__1677841694.png', '9876543210', 'Prakash@gmaiul.com', '', '', '', '', 1, '781026', 'Guwahati', '343253555', '2434353545', 'yes', 20.00, '1', '2023-03-03 16:38:14', 1, '2023-04-11 08:35:25', NULL, 20),
(7, NULL, 'Rup Bike Store', '$2y$10$SAkYcDwWoBBD/H4FN8wCle3PYokHvXq8G.HpYTaud6f/o0ev8Nebi', 'v__1677911186.png', '9101776425', 'aka@gmail.com', '', '', '', '', 2, '781027', 'Jorhat', '343253555', '2434353545', 'yes', 2.00, '0', '2023-03-04 11:56:27', 1, '2023-04-06 08:55:08', 1, 20),
(8, NULL, 'Aadi Bike Store', '$2y$10$aI631NmyeM6yONOTVBoa/.7MFTnV6JeGLWEs66cwJGtzE3FNel4aS', 's__1680761771.jpg', '9101776426', 'aaadi@gmail.com', '4513233333', '4513233333', '', '', 1, '7810', 'Narengi', '343253555', '343253555', 'yes', 25.00, '1', '2023-03-04 17:35:39', 1, '2023-04-06 06:16:11', 1, 20),
(9, NULL, 'Ride Zone', '$2y$10$O4oaHT8JAVQ.KH.0gf8kiuJr4WD6moJpHzY3GIxJODGl9qoyWdOMm', 'v__1675948400.jpg', '9874561200', 'das@gmail.com', '4512333333', '4512333333', 'james@xyz.com', '', 1, '7813', 'North Island', '123333', '323244', 'yes', 6.00, '1', '2023-04-05 10:18:52', 1, '2023-04-06 14:54:06', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_block_date`
--

CREATE TABLE `vendor_block_date` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `block_date` date DEFAULT NULL,
  `start_date_range` datetime DEFAULT NULL,
  `end_date_range` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_block_date`
--

INSERT INTO `vendor_block_date` (`id`, `vendor_id`, `block_date`, `start_date_range`, `end_date_range`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(14, 6, '2023-04-06', NULL, NULL, '2023-04-03 15:27:59', 6, NULL, NULL),
(15, 6, '2023-04-08', NULL, NULL, '2023-04-03 15:27:59', 6, NULL, NULL),
(16, 6, '2023-04-12', NULL, NULL, '2023-04-03 15:27:59', 6, NULL, NULL),
(17, 6, '2023-04-25', NULL, NULL, '2023-04-03 15:27:59', 6, NULL, NULL),
(19, 6, NULL, '2023-04-20 00:00:00', '2023-04-30 00:00:00', '2023-04-04 16:15:10', 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_date_range`
--

CREATE TABLE `vendor_date_range` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `dates` date NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_date_range`
--

INSERT INTO `vendor_date_range` (`id`, `vendor_id`, `dates`, `created_at`, `created_by`) VALUES
(5, 6, '2023-04-20', '2023-04-04 16:15:10', 6),
(6, 6, '2023-04-21', '2023-04-04 16:15:10', 6),
(7, 6, '2023-04-22', '2023-04-04 16:15:10', 6),
(8, 6, '2023-04-23', '2023-04-04 16:15:10', 6),
(9, 6, '2023-04-24', '2023-04-04 16:15:10', 6),
(10, 6, '2023-04-25', '2023-04-04 16:15:10', 6),
(11, 6, '2023-04-26', '2023-04-04 16:15:10', 6),
(12, 6, '2023-04-27', '2023-04-04 16:15:10', 6),
(13, 6, '2023-04-28', '2023-04-04 16:15:10', 6),
(14, 6, '2023-04-29', '2023-04-04 16:15:10', 6),
(15, 6, '2023-04-30', '2023-04-04 16:15:10', 6);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_product_discount`
--

CREATE TABLE `vendor_product_discount` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_ids` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_cat_ids` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_product_pricing_id` int(11) DEFAULT NULL,
  `discount_type` enum('flat','percentage') COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_product_or_category` enum('Category','Product') COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` float(11,2) NOT NULL,
  `starting_from` datetime NOT NULL,
  `valid_till` datetime DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_product_discount`
--

INSERT INTO `vendor_product_discount` (`id`, `vendor_id`, `product_ids`, `product_cat_ids`, `vendor_product_pricing_id`, `discount_type`, `discount_product_or_category`, `discount`, `starting_from`, `valid_till`, `is_active`, `created_at`, `updated_at`) VALUES
(6, 6, NULL, '9,12', NULL, 'flat', 'Category', 2.00, '2023-04-01 18:34:00', '2023-04-04 18:34:00', '1', '2023-04-03 15:52:07', '2023-04-03 12:36:05'),
(7, 6, '2,1', NULL, NULL, 'percentage', 'Product', 3.00, '2023-04-01 18:35:00', '2023-04-04 18:35:00', '1', '2023-04-01 18:35:20', '2023-04-11 08:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_product_pricing`
--

CREATE TABLE `vendor_product_pricing` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `pricing_plan_value` int(11) DEFAULT NULL,
  `pricing_plan_unit` enum('hour','day','week','month') COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float(11,2) NOT NULL,
  `addn_charge` float(11,2) DEFAULT NULL,
  `currency` enum('DKK','EUR') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_product_pricing`
--

INSERT INTO `vendor_product_pricing` (`id`, `vendor_id`, `product_id`, `pricing_plan_value`, `pricing_plan_unit`, `price`, `addn_charge`, `currency`, `created_at`, `updated_at`) VALUES
(1, 6, 1, NULL, 'hour', 1.00, NULL, 'DKK', '2023-03-15 16:33:28', NULL),
(2, 6, 1, NULL, 'day', 2.00, NULL, 'DKK', '2023-03-15 16:33:28', NULL),
(3, 6, 1, NULL, 'week', 3.00, NULL, 'DKK', '2023-03-15 16:33:28', NULL),
(4, 6, 1, NULL, 'month', 4.00, NULL, 'DKK', '2023-03-15 16:33:28', NULL),
(5, 6, 2, NULL, 'hour', 250.00, NULL, 'DKK', '2023-03-17 11:36:11', NULL),
(6, 6, 3, NULL, 'day', 2500.00, 200.00, 'DKK', '2023-03-17 11:38:47', NULL),
(7, 6, 5, NULL, 'hour', 1.00, NULL, 'DKK', '2023-03-20 21:37:30', NULL),
(8, 6, 6, NULL, 'hour', 2.00, NULL, 'DKK', '2023-03-21 12:40:35', NULL),
(9, 6, 7, NULL, 'hour', 3.00, NULL, 'DKK', '2023-03-21 12:45:34', NULL),
(10, 6, 8, NULL, 'hour', 2.00, NULL, 'DKK', '2023-03-21 12:47:49', NULL),
(15, 6, 10, NULL, 'day', 12.00, 12.00, 'EUR', '2023-03-24 18:25:29', NULL),
(16, 6, 11, NULL, 'day', 12.00, 12.00, 'DKK', '2023-03-24 18:26:55', NULL),
(18, 6, 21, NULL, 'hour', 20.00, NULL, 'DKK', '2023-04-06 07:34:05', NULL),
(19, 6, 24, NULL, 'hour', 20.00, NULL, 'DKK', '2023-04-06 08:46:53', NULL),
(36, 6, 51, 1, 'hour', 0.00, NULL, 'DKK', '2023-04-11 05:46:10', NULL),
(37, 6, 51, 1, 'day', 0.00, NULL, 'DKK', '2023-04-11 05:46:10', NULL),
(38, 6, 51, 1, 'week', 0.00, NULL, 'DKK', '2023-04-11 05:46:10', NULL),
(39, 6, 51, 1, 'month', 0.00, NULL, 'DKK', '2023-04-11 05:46:10', NULL),
(40, 6, 63, 1, 'hour', 12.00, NULL, 'DKK', '2023-04-12 06:12:16', NULL),
(41, 6, 63, 1, 'day', 0.00, NULL, 'DKK', '2023-04-12 06:12:16', NULL),
(42, 6, 63, 1, 'week', 0.00, NULL, 'DKK', '2023-04-12 06:12:16', NULL),
(43, 6, 63, 1, 'month', 0.00, NULL, 'DKK', '2023-04-12 06:12:16', NULL),
(44, 6, 72, 1, 'hour', 20.00, NULL, 'DKK', '2023-04-12 06:28:17', NULL),
(45, 6, 72, 1, 'day', 30.00, NULL, 'DKK', '2023-04-12 06:28:17', NULL),
(46, 6, 72, 1, 'week', 40.00, NULL, 'DKK', '2023-04-12 06:28:17', NULL),
(47, 6, 72, 1, 'month', 50.00, NULL, 'DKK', '2023-04-12 06:28:17', NULL),
(52, 6, 84, 1, 'hour', 20.00, NULL, 'DKK', '2023-04-12 07:20:25', NULL),
(53, 6, 86, 1, 'hour', 25.00, NULL, 'DKK', '2023-04-12 07:26:53', '2023-04-12 07:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_timing`
--

CREATE TABLE `vendor_timing` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `monday_opening` time NOT NULL,
  `monday_closing` time NOT NULL,
  `tuesday_opening` time NOT NULL,
  `tuesday_closing` time NOT NULL,
  `wednesday_opening` time NOT NULL,
  `wednesday_closing` time NOT NULL,
  `thursday_opening` time NOT NULL,
  `thursday_closing` time NOT NULL,
  `friday_opening` time NOT NULL,
  `friday_closing` time NOT NULL,
  `saturday_opening` time NOT NULL,
  `saturday_closing` time NOT NULL,
  `sunday_opening` time NOT NULL,
  `sunday_closing` time NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_timing`
--

INSERT INTO `vendor_timing` (`id`, `vendor_id`, `monday_opening`, `monday_closing`, `tuesday_opening`, `tuesday_closing`, `wednesday_opening`, `wednesday_closing`, `thursday_opening`, `thursday_closing`, `friday_opening`, `friday_closing`, `saturday_opening`, `saturday_closing`, `sunday_opening`, `sunday_closing`, `created_at`, `updated_at`) VALUES
(5, 6, '09:00:00', '21:00:00', '09:02:00', '22:00:00', '07:00:00', '19:00:00', '09:00:00', '21:00:00', '10:00:00', '18:00:00', '09:00:00', '21:00:00', '11:00:00', '19:00:00', '2023-04-11 08:21:47', '2023-04-11 08:21:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `master_city_town`
--
ALTER TABLE `master_city_town`
  ADD PRIMARY KEY (`id`),
  ADD KEY `region_id` (`region_id`);

--
-- Indexes for table `master_product_attr`
--
ALTER TABLE `master_product_attr`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by_admin` (`created_by_admin`),
  ADD KEY `updated_by_admin` (`updated_by_admin`),
  ADD KEY `product_type_id` (`product_type_id`);

--
-- Indexes for table `master_product_category`
--
ALTER TABLE `master_product_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_slug` (`category_slug`),
  ADD KEY `product_type_id` (`product_type_id`);

--
-- Indexes for table `master_product_type`
--
ALTER TABLE `master_product_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_region`
--
ALTER TABLE `master_region`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_unit`
--
ALTER TABLE `master_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_slug` (`product_slug`),
  ADD KEY `created_by_admin` (`created_by_admin`),
  ADD KEY `product_type_id` (`product_type_id`),
  ADD KEY `updated_by_admin` (`updated_by_admin`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_value_unit_id` (`attribute_value_unit_id`),
  ADD KEY `product_attr_id` (`product_attr_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `system_module`
--
ALTER TABLE `system_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_role`
--
ALTER TABLE `system_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updated_by_admin` (`updated_by_admin`);

--
-- Indexes for table `user_booking`
--
ALTER TABLE `user_booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addn_charge_payment_id` (`addn_charge_payment_id`),
  ADD KEY `delivery_add_id` (`delivery_add_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `pricing_plan_id` (`pricing_plan_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `rejected_by_user` (`cencel_by_user`),
  ADD KEY `approve_rejected_by` (`approve_rejected_by`);

--
-- Indexes for table `user_booking_details`
--
ALTER TABLE `user_booking_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `pricing_plan_id` (`pricing_plan_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `user_delivery_address`
--
ALTER TABLE `user_delivery_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_town_id` (`city_town_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_payment`
--
ALTER TABLE `user_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_town_id` (`city_town_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `vendor_block_date`
--
ALTER TABLE `vendor_block_date`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `vendor_date_range`
--
ALTER TABLE `vendor_date_range`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_product_discount`
--
ALTER TABLE `vendor_product_discount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `vendor_product_pricing_id` (`vendor_product_pricing_id`);

--
-- Indexes for table `vendor_product_pricing`
--
ALTER TABLE `vendor_product_pricing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `vendor_timing`
--
ALTER TABLE `vendor_timing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_city_town`
--
ALTER TABLE `master_city_town`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_product_attr`
--
ALTER TABLE `master_product_attr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `master_product_category`
--
ALTER TABLE `master_product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `master_product_type`
--
ALTER TABLE `master_product_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_region`
--
ALTER TABLE `master_region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_unit`
--
ALTER TABLE `master_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `system_module`
--
ALTER TABLE `system_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_role`
--
ALTER TABLE `system_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_booking`
--
ALTER TABLE `user_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user_booking_details`
--
ALTER TABLE `user_booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user_delivery_address`
--
ALTER TABLE `user_delivery_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_payment`
--
ALTER TABLE `user_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vendor_block_date`
--
ALTER TABLE `vendor_block_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vendor_date_range`
--
ALTER TABLE `vendor_date_range`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vendor_product_discount`
--
ALTER TABLE `vendor_product_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vendor_product_pricing`
--
ALTER TABLE `vendor_product_pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `vendor_timing`
--
ALTER TABLE `vendor_timing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `master_city_town`
--
ALTER TABLE `master_city_town`
  ADD CONSTRAINT `master_city_town_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `master_region` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `master_product_attr`
--
ALTER TABLE `master_product_attr`
  ADD CONSTRAINT `master_product_attr_ibfk_1` FOREIGN KEY (`created_by_admin`) REFERENCES `admin` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `master_product_attr_ibfk_2` FOREIGN KEY (`updated_by_admin`) REFERENCES `admin` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `master_product_attr_ibfk_4` FOREIGN KEY (`product_type_id`) REFERENCES `master_product_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `master_product_category`
--
ALTER TABLE `master_product_category`
  ADD CONSTRAINT `master_product_category_ibfk_2` FOREIGN KEY (`product_type_id`) REFERENCES `master_product_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`created_by_admin`) REFERENCES `admin` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`product_type_id`) REFERENCES `master_product_type` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`updated_by_admin`) REFERENCES `admin` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_4` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_ibfk_1` FOREIGN KEY (`attribute_value_unit_id`) REFERENCES `master_unit` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `product_details_ibfk_2` FOREIGN KEY (`product_attr_id`) REFERENCES `master_product_attr` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `product_details_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_details_ibfk_4` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`updated_by_admin`) REFERENCES `admin` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_booking`
--
ALTER TABLE `user_booking`
  ADD CONSTRAINT `user_booking_ibfk_1` FOREIGN KEY (`addn_charge_payment_id`) REFERENCES `user_payment` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_ibfk_2` FOREIGN KEY (`delivery_add_id`) REFERENCES `user_delivery_address` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `user_payment` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_ibfk_4` FOREIGN KEY (`pricing_plan_id`) REFERENCES `vendor_product_pricing` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_ibfk_6` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_ibfk_7` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_ibfk_8` FOREIGN KEY (`cencel_by_user`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_ibfk_9` FOREIGN KEY (`approve_rejected_by`) REFERENCES `vendor` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_booking_details`
--
ALTER TABLE `user_booking_details`
  ADD CONSTRAINT `user_booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `user_booking` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_details_ibfk_2` FOREIGN KEY (`pricing_plan_id`) REFERENCES `vendor_product_pricing` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_details_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_details_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_booking_details_ibfk_5` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_delivery_address`
--
ALTER TABLE `user_delivery_address`
  ADD CONSTRAINT `user_delivery_address_ibfk_1` FOREIGN KEY (`city_town_id`) REFERENCES `master_city_town` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_delivery_address_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_payment`
--
ALTER TABLE `user_payment`
  ADD CONSTRAINT `user_payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `user_booking` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_payment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `vendor`
--
ALTER TABLE `vendor`
  ADD CONSTRAINT `vendor_ibfk_1` FOREIGN KEY (`city_town_id`) REFERENCES `master_city_town` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vendor_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `admin` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vendor_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `vendor_block_date`
--
ALTER TABLE `vendor_block_date`
  ADD CONSTRAINT `vendor_block_date_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `vendor_product_discount`
--
ALTER TABLE `vendor_product_discount`
  ADD CONSTRAINT `vendor_product_discount_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vendor_product_discount_ibfk_2` FOREIGN KEY (`vendor_product_pricing_id`) REFERENCES `vendor_product_pricing` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `vendor_product_pricing`
--
ALTER TABLE `vendor_product_pricing`
  ADD CONSTRAINT `vendor_product_pricing_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vendor_product_pricing_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `vendor_timing`
--
ALTER TABLE `vendor_timing`
  ADD CONSTRAINT `vendor_timing_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
