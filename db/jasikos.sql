-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2025 at 12:37 PM
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
-- Database: `jasikos`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 3, '2025-08-14 06:56:21', '2025-08-14 06:56:21'),
(2, 4, '2025-08-14 20:00:48', '2025-08-14 20:00:48'),
(3, 6, '2025-08-27 15:55:21', '2025-08-27 15:55:21');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `design_id` bigint(20) UNSIGNED NOT NULL,
  `designer_id` bigint(20) UNSIGNED NOT NULL,
  `price_snapshot` bigint(20) UNSIGNED NOT NULL,
  `qty` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Female', 'female', '2025-08-13 20:30:35', '2025-08-13 20:30:35'),
(2, 'Male', 'male', '2025-08-13 20:30:35', '2025-08-13 20:30:35'),
(3, 'Fullset', 'fullset', '2025-08-13 20:30:35', '2025-08-13 20:30:35'),
(4, 'Kids', 'kids', '2025-08-13 20:30:35', '2025-08-13 20:30:35'),
(5, 'Armored', 'armored', '2025-08-13 20:30:35', '2025-08-13 20:30:35'),
(6, 'Wig', 'wig', '2025-08-13 20:30:35', '2025-08-13 20:30:35'),
(7, 'Accessories', 'accessories', '2025-08-13 20:30:35', '2025-08-13 20:30:35'),
(8, 'Kelapa', 'kelapa', '2025-08-17 19:43:24', '2025-08-17 19:43:40'),
(9, 'Berat', 'b', '2025-08-23 10:15:54', '2025-08-23 10:15:54');

-- --------------------------------------------------------

--
-- Table structure for table `category_design`
--

CREATE TABLE `category_design` (
  `design_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_design`
--

INSERT INTO `category_design` (`design_id`, `category_id`) VALUES
(1, 2),
(1, 4),
(2, 6),
(2, 7),
(3, 2),
(3, 4),
(4, 3),
(5, 3),
(6, 2),
(6, 3),
(7, 2),
(7, 5),
(8, 4),
(8, 9),
(9, 5),
(9, 7),
(9, 8);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commentable_type` varchar(255) NOT NULL,
  `commentable_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `commentable_type`, `commentable_id`, `user_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\OrderItem', 2, 6, 'adnakwdnadwadawdada', '2025-08-15 03:48:39', '2025-08-15 03:48:39'),
(2, 'App\\Models\\OrderItem', 2, 7, 'akdwalkdnawdad', '2025-08-15 03:50:35', '2025-08-15 03:50:35'),
(3, 'App\\Models\\OrderItem', 2, 6, 'ladmalkdmalwwdka', '2025-08-15 04:01:55', '2025-08-15 04:01:55'),
(4, 'App\\Models\\CustomRequest', 1, 7, 'Designer: alwdknalkd', '2025-08-16 07:47:49', '2025-08-16 07:47:49'),
(5, 'App\\Models\\OrderItem', 5, 6, 'lkdlawdald', '2025-08-16 07:54:29', '2025-08-16 07:54:29'),
(6, 'App\\Models\\OrderItem', 5, 7, 'adwlada', '2025-08-16 07:55:10', '2025-08-16 07:55:10'),
(7, 'App\\Models\\OrderItem', 5, 7, 'adwada', '2025-08-16 07:55:21', '2025-08-16 07:55:21'),
(8, 'App\\Models\\CustomRequest', 2, 7, 'Quote: Rp 2.000.000 — adalkdjald', '2025-08-16 19:31:19', '2025-08-16 19:31:19'),
(9, 'App\\Models\\OrderItem', 6, 6, 'lakdlawkdad', '2025-08-16 19:35:07', '2025-08-16 19:35:07'),
(10, 'App\\Models\\OrderItem', 8, 6, 'adwadadawdadadw', '2025-08-20 06:21:18', '2025-08-20 06:21:18'),
(11, 'App\\Models\\OrderItem', 8, 7, 'adwawdadw', '2025-08-20 06:22:21', '2025-08-20 06:22:21'),
(12, 'App\\Models\\OrderItem', 8, 7, 'adwadw', '2025-08-20 06:22:27', '2025-08-20 06:22:27'),
(13, 'App\\Models\\CustomRequest', 5, 7, 'Designer: awdawdada', '2025-08-20 06:27:48', '2025-08-20 06:27:48'),
(14, 'App\\Models\\OrderItem', 9, 6, 'Revisiii', '2025-08-20 06:31:33', '2025-08-20 06:31:33'),
(15, 'App\\Models\\OrderItem', 9, 7, 'dadadadwada', '2025-08-20 06:32:25', '2025-08-20 06:32:25'),
(16, 'App\\Models\\OrderItem', 15, 10, 'lkndladnawd', '2025-08-28 07:29:45', '2025-08-28 07:29:45'),
(17, 'App\\Models\\OrderItem', 15, 7, 'adwlada', '2025-08-28 07:30:27', '2025-08-28 07:30:27'),
(18, 'App\\Models\\CustomRequest', 11, 7, 'Quote: Rp 2.000.000 | Info ongkir (perkiraan): 20000 — ongkir resmi akan ditentukan di Order setelah Anda ACC.', '2025-08-28 17:56:18', '2025-08-28 17:56:18'),
(19, 'App\\Models\\CustomRequest', 12, 7, 'Quote: Rp 1.200.000 | Info ongkir (perkiraan): 1200000 — ongkir resmi akan ditentukan di Order setelah Anda ACC.', '2025-08-28 19:16:31', '2025-08-28 19:16:31'),
(20, 'App\\Models\\CustomRequest', 13, 10, 'DELIVERY: ship\nName: hilman ardiansyah\nPhone: 0895626141738\nAddress: KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', '2025-08-28 19:43:33', '2025-08-28 19:43:33'),
(21, 'App\\Models\\CustomRequest', 13, 7, 'Quote: Rp 120.000 | Note: lkadmlkawd | Info ongkir (perkiraan): 20000 — ongkir resmi akan ditentukan di Order setelah Anda ACC.', '2025-08-28 19:44:41', '2025-08-28 19:44:41'),
(22, 'App\\Models\\CustomRequest', 14, 10, 'DELIVERY: ship\nName: hilman ardiansyah\nPhone: 0895626141738\nAddress: KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', '2025-08-30 02:52:14', '2025-08-30 02:52:14'),
(23, 'App\\Models\\CustomRequest', 14, 7, 'Quote: Rp 200.000 | Info ongkir (perkiraan): 200000 — ongkir resmi akan ditentukan di Order setelah Anda ACC.', '2025-08-30 02:54:03', '2025-08-30 02:54:03'),
(24, 'App\\Models\\CustomRequest', 15, 10, 'DELIVERY: ship\nName: hilman ardiansyah\nPhone: 0895626141738\nAddress: KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', '2025-08-30 02:55:51', '2025-08-30 02:55:51'),
(25, 'App\\Models\\CustomRequest', 15, 7, 'Designer: kawndkadnawd', '2025-08-30 02:56:39', '2025-08-30 02:56:39'),
(26, 'App\\Models\\CustomRequest', 15, 7, 'Quote: Rp 2.000.000 | Note: aldmadlkw | Info ongkir (perkiraan): 2000000 — ongkir resmi akan ditentukan di Order setelah Anda ACC.', '2025-08-30 02:56:54', '2025-08-30 02:56:54'),
(27, 'App\\Models\\CustomRequest', 16, 10, 'DELIVERY: ship\nName: hilman ardiansyah\nPhone: 0895626141738\nAddress: KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', '2025-08-30 03:20:13', '2025-08-30 03:20:13'),
(28, 'App\\Models\\CustomRequest', 16, 7, 'Quote: Rp 2.000.000 | Info ongkir (perkiraan): 2000000 — ongkir resmi akan ditentukan di Order setelah Anda ACC.', '2025-08-30 03:21:02', '2025-08-30 03:21:02'),
(29, 'App\\Models\\CustomRequest', 17, 10, 'DELIVERY: ship\nName: hilman ardiansyah\nPhone: 0895626141738\nAddress: KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', '2025-08-30 03:39:36', '2025-08-30 03:39:36'),
(30, 'App\\Models\\CustomRequest', 17, 7, 'Quote: Rp 12.000.000 | Info ongkir (perkiraan): Ongkir jnt 2000000 — ongkir resmi akan ditentukan di Order setelah Anda ACC. | Ongkir: Rp 2.000.000 | SHIPFEE=2000000', '2025-08-30 03:40:58', '2025-08-30 03:40:58'),
(31, 'App\\Models\\CustomRequest', 18, 10, 'DELIVERY: digital', '2025-08-30 03:44:42', '2025-08-30 03:44:42'),
(32, 'App\\Models\\CustomRequest', 18, 7, 'Quote: Rp 12.000.000', '2025-08-30 03:57:29', '2025-08-30 03:57:29'),
(33, 'App\\Models\\CustomRequest', 19, 10, 'DELIVERY: digital', '2025-08-30 03:58:22', '2025-08-30 03:58:22'),
(34, 'App\\Models\\CustomRequest', 19, 7, 'Designer: adadadwad', '2025-08-30 03:59:10', '2025-08-30 03:59:10'),
(35, 'App\\Models\\CustomRequest', 19, 7, 'Quote: Rp 12.000.000', '2025-08-30 03:59:25', '2025-08-30 03:59:25'),
(36, 'App\\Models\\CustomRequest', 20, 10, 'DELIVERY: ship\nName: hilman ardiansyah\nPhone: 0895626141738\nAddress: KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', '2025-08-30 04:00:35', '2025-08-30 04:00:35'),
(37, 'App\\Models\\CustomRequest', 20, 7, 'Quote: Rp 12.000.000 | Ongkir: Rp 2.000.000 | SHIPFEE=2000000', '2025-08-30 04:01:44', '2025-08-30 04:01:44'),
(38, 'App\\Models\\CustomRequest', 21, 10, 'DELIVERY: digital', '2025-08-30 04:11:27', '2025-08-30 04:11:27'),
(39, 'App\\Models\\CustomRequest', 22, 10, 'DELIVERY: ship\nName: hilman ardiansyah\nPhone: 0895626141738\nAddress: KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', '2025-08-30 04:16:14', '2025-08-30 04:16:14'),
(40, 'App\\Models\\CustomRequest', 23, 10, 'DELIVERY: ship\nName: hilman ardiansyah\nPhone: 0895626141738\nAddress: KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', '2025-08-30 04:33:34', '2025-08-30 04:33:34'),
(41, 'App\\Models\\CustomRequest', 23, 7, 'Quote: Rp 1.000.000 | Shipping fee: Rp 120.000 | SHIPFEE=120000', '2025-08-30 04:34:32', '2025-08-30 04:34:32'),
(42, 'App\\Models\\CustomRequest', 24, 10, 'DELIVERY: digital', '2025-08-30 04:38:03', '2025-08-30 04:38:03'),
(43, 'App\\Models\\CustomRequest', 24, 7, 'Quote: Rp 12.000.000', '2025-08-30 04:39:01', '2025-08-30 04:39:01'),
(44, 'App\\Models\\CustomRequest', 25, 10, 'DELIVERY: ship\nName: hilman ardiansyah\nPhone: 0895626141738\nAddress: KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', '2025-08-30 04:50:32', '2025-08-30 04:50:32'),
(45, 'App\\Models\\CustomRequest', 25, 7, 'Quote: Rp 100.000 | Shipping fee: Rp 10.000 | SHIPFEE=10000', '2025-08-30 04:51:24', '2025-08-30 04:51:24'),
(46, 'App\\Models\\CustomRequest', 26, 10, 'DELIVERY: digital', '2025-08-30 04:52:18', '2025-08-30 04:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `address`, `city`, `province`, `postal_code`, `created_at`, `updated_at`) VALUES
(1, 3, 'Cimahi', NULL, NULL, NULL, '2025-08-13 20:30:37', '2025-08-13 20:30:37'),
(2, 4, NULL, NULL, NULL, NULL, '2025-08-13 21:06:25', '2025-08-13 21:06:25'),
(3, 5, NULL, NULL, NULL, NULL, '2025-08-13 21:11:41', '2025-08-13 21:11:41'),
(4, 6, 'KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006', 'Kota Cimahi', 'Jawa Baratt', '40522', '2025-08-13 21:13:01', '2025-08-15 06:38:00'),
(5, 9, NULL, NULL, NULL, NULL, '2025-08-21 10:06:15', '2025-08-21 10:06:15'),
(6, 10, 'KP.CILEMBER GG TUNGGAL BHAKTI I RT 007 RW 006', 'Cimahi', 'Jawa barat', NULL, '2025-08-27 15:54:25', '2025-08-27 15:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `custom_requests`
--

CREATE TABLE `custom_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `designer_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `brief` longtext DEFAULT NULL,
  `reference_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`reference_links`)),
  `revisions_allowed` tinyint(3) UNSIGNED NOT NULL DEFAULT 2,
  `revisions_used` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `price_offer` bigint(20) UNSIGNED DEFAULT NULL,
  `price_agreed` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('submitted','quoted','awaiting_payment','in_progress','delivered','completed','declined','cancelled') NOT NULL DEFAULT 'submitted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_requests`
--

INSERT INTO `custom_requests` (`id`, `code`, `customer_id`, `designer_id`, `title`, `brief`, `reference_links`, `revisions_allowed`, `revisions_used`, `price_offer`, `price_agreed`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CR-202508-DSNPP', 4, 2, 'aldmwadl;mad', 'LAKDMALKDALDAWD', '[\"https:\\/\\/pentagram.com\\/\",null]', 2, 0, NULL, 2000000, 'in_progress', '2025-08-16 07:31:20', '2025-08-16 07:53:09'),
(2, 'CR-202508-KFSGR', 4, 2, 'alkwmadlad', 'lakdnlwakdadw', '[\"https:\\/\\/pentagram.com\\/\"]', 2, 1, NULL, 2000000, 'completed', '2025-08-16 19:26:22', '2025-08-16 19:36:45'),
(3, 'CR-202508-IHHBS', 4, 1, 'lmwdlkadmlaw', 'alwkdaldaw', '[null]', 2, 0, NULL, NULL, 'submitted', '2025-08-16 19:26:51', '2025-08-16 19:26:51'),
(4, 'CR-202508-NWUR2', 4, 1, 'lawdlkandlad', 'adanldkanwd', '[null]', 2, 0, NULL, NULL, 'submitted', '2025-08-18 09:09:07', '2025-08-18 09:09:07'),
(5, 'CR-202508-1LTHO', 4, 2, 'Saya mau buat desain gambar', 'kebutuhan desain gambar deadline 10 hari', '[\"https:\\/\\/pentagram.com\\/\"]', 2, 1, NULL, 12000000, 'completed', '2025-08-20 06:26:20', '2025-08-20 06:33:31'),
(6, 'CR-202508-UJVML', 4, 3, 'adawdadad', 'awdwadadw', '[null]', 2, 0, NULL, NULL, 'submitted', '2025-08-23 23:00:17', '2025-08-23 23:00:17'),
(7, 'CR-202508-G89YQ', 4, 2, 'aldkwalwkdad', 'AKDNAKWDNAKDAKWD', '[\"https:\\/\\/pentagram.com\\/\"]', 2, 0, NULL, NULL, 'submitted', '2025-08-26 22:47:39', '2025-08-26 22:47:39'),
(8, 'CR-202508-OTQWS', 6, 2, 'Mau custom req', 'awdandwkand', '[\"https:\\/\\/pentagram.com\\/\"]', 2, 0, NULL, 12000000, 'completed', '2025-08-28 06:58:13', '2025-08-28 07:02:36'),
(9, 'CR-202508-FOXYM', 6, 2, 'lkdlkawd', 'awdnawdn', '[null]', 2, 0, NULL, 1000000, 'quoted', '2025-08-28 08:28:53', '2025-08-28 08:29:49'),
(10, 'CR-202508-KQ7G6', 6, 3, 'adwawdawd', 'adwawdwad', '[null]', 2, 0, NULL, NULL, 'submitted', '2025-08-28 17:54:14', '2025-08-28 17:54:14'),
(11, 'CR-202508-BEUHI', 6, 2, 'adwada', 'adawdaad', '[null]', 2, 0, NULL, 2000000, 'completed', '2025-08-28 17:54:31', '2025-08-28 18:03:15'),
(12, 'CR-202508-D3XCT', 6, 2, 'caawdad', 'adwadad', '[null]', 2, 0, NULL, 1200000, 'awaiting_payment', '2025-08-28 19:12:13', '2025-08-28 19:20:29'),
(13, 'CR-202508-TBQGI', 6, 2, 'ADKWJNAKDJANDWAK', NULL, '[null]', 2, 0, NULL, 120000, 'quoted', '2025-08-28 19:43:32', '2025-08-28 19:44:41'),
(14, 'CR-202508-FUHGK', 6, 2, 'adnladna', 'aldklakwdkad', '[null]', 2, 0, NULL, 200000, 'awaiting_payment', '2025-08-30 02:52:12', '2025-08-30 02:54:38'),
(15, 'CR-202508-ZXEDS', 6, 2, 'lakdlakdnw', 'aldkalkdwawd', '[null]', 2, 0, NULL, 2000000, 'awaiting_payment', '2025-08-30 02:55:51', '2025-08-30 02:57:41'),
(16, 'CR-202508-JWWCV', 6, 2, 'LAKWDLAKDAD', 'ADMLAKDAD', '[null]', 2, 0, NULL, 2000000, 'awaiting_payment', '2025-08-30 03:20:13', '2025-08-30 03:21:37'),
(17, 'CR-202508-5AF6Z', 6, 2, 'ladalkdnalsddddddd', 'aldaldkaldwaadadadw', '[null]', 2, 0, NULL, 12000000, 'completed', '2025-08-30 03:39:36', '2025-08-30 03:44:15'),
(18, 'CR-202508-LKNRG', 6, 2, 'dddddddddddd', NULL, '[null]', 2, 0, NULL, 12000000, 'awaiting_payment', '2025-08-30 03:44:41', '2025-08-30 03:58:05'),
(19, 'CR-202508-XKTYE', 6, 2, 'lkMDLKADLKAD', 'ADMLKADLKADW', '[null]', 2, 0, NULL, 12000000, 'awaiting_payment', '2025-08-30 03:58:22', '2025-08-30 03:59:54'),
(20, 'CR-202508-2NZXJ', 6, 2, 'adkwalkdn', NULL, '[null]', 2, 0, NULL, 12000000, 'awaiting_payment', '2025-08-30 04:00:35', '2025-08-30 04:02:09'),
(21, 'CR-202508-MOZWJ', 6, 3, 'akldwnlkawdnaw', NULL, '[null]', 2, 0, NULL, NULL, 'submitted', '2025-08-30 04:11:27', '2025-08-30 04:11:27'),
(22, 'CR-202508-7IAQA', 6, 2, 'lakdlakdalda', NULL, '[null]', 2, 0, NULL, NULL, 'submitted', '2025-08-30 04:16:14', '2025-08-30 04:16:14'),
(23, 'CR-202508-XUMDI', 6, 2, 'adkjakjdnawd', NULL, '[null]', 2, 0, NULL, 1000000, 'completed', '2025-08-30 04:33:34', '2025-08-30 04:37:27'),
(24, 'CR-202508-NEYMG', 6, 2, 'kjbbbb', NULL, '[null]', 2, 0, NULL, 12000000, 'completed', '2025-08-30 04:38:03', '2025-08-30 04:41:42'),
(25, 'CR-202508-XVOES', 6, 2, 'knaldad', NULL, '[null]', 2, 0, NULL, 100000, 'awaiting_payment', '2025-08-30 04:50:32', '2025-08-30 04:51:59'),
(26, 'CR-202508-P3XJG', 6, 2, 'lkandlkawndlawdaw', NULL, '[null]', 2, 0, NULL, NULL, 'submitted', '2025-08-30 04:52:18', '2025-08-30 04:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `custom_request_files`
--

CREATE TABLE `custom_request_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `custom_request_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('reference','work_in_progress','final') NOT NULL DEFAULT 'reference',
  `path` varchar(255) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_request_files`
--

INSERT INTO `custom_request_files` (`id`, `custom_request_id`, `type`, `path`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 'reference', 'custom_requests/1/references/jmKlwqi6YoPhts6nCTiwynWsmffudRcokxipi4Cj.jpg', NULL, '2025-08-16 07:31:23', '2025-08-16 07:31:23'),
(2, 2, 'reference', 'custom_requests/2/references/zNUObBwjVewrfuH4v4plA7XohQp9BWfSsAQCmnST.jpg', NULL, '2025-08-16 19:26:22', '2025-08-16 19:26:22'),
(3, 3, 'reference', 'custom_requests/3/references/5GroO5RL5KWalAh3QK0bHps6z1FUZlQPWVmSvumN.jpg', NULL, '2025-08-16 19:26:51', '2025-08-16 19:26:51'),
(4, 5, 'reference', 'custom_requests/5/references/6b1MsiwdgEWPNTT0uDyYMOziX5REyudoY3zPyhep.jpg', NULL, '2025-08-20 06:26:20', '2025-08-20 06:26:20'),
(5, 7, 'reference', 'custom_requests/7/references/gKDPuHAZvhcbixlhmcolRXDpqNJmjfNaMoendSbg.jpg', NULL, '2025-08-26 22:47:41', '2025-08-26 22:47:41'),
(6, 14, 'reference', 'custom_requests/14/references/Q6gUwqU1KCudfctsNx0EvjYAPFB13itp6tklBHvI.jpg', NULL, '2025-08-30 02:52:13', '2025-08-30 02:52:13');

-- --------------------------------------------------------

--
-- Table structure for table `designers`
--

CREATE TABLE `designers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `bank_account_name` varchar(255) DEFAULT NULL,
  `qris_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designers`
--

INSERT INTO `designers` (`id`, `user_id`, `display_name`, `bio`, `bank_name`, `bank_account_no`, `bank_account_name`, `qris_image`, `created_at`, `updated_at`) VALUES
(1, 2, 'KOPRO', 'Cosplay designer', 'BCA', '13332929302321', 'KOPRO', 'qris/tep4eVITENUJj49J5Y9urUEi58haimFMlfjWn6JP.jpg', '2025-08-13 20:30:37', '2025-08-23 09:37:09'),
(2, 7, 'supri', 'Designer yang handal', 'BCA', '13332929302321', 'SUPRIANTO', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', '2025-08-13 21:17:23', '2025-08-18 08:24:57'),
(3, 8, 'dodo', 'Aku adalah designer handal', 'BCA', '133320002133202', 'DODO WIDARTO', 'qris/9AFEsAcwGTkP3N8vpnXGOgkDvs6ZZAGyMHBZibrH.jpg', '2025-08-14 07:05:12', '2025-08-14 07:33:08'),
(4, 11, 'hilman', NULL, NULL, NULL, NULL, NULL, '2025-09-03 02:28:55', '2025-09-03 02:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE `designs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designer_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `thumbnail` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designs`
--

INSERT INTO `designs` (`id`, `designer_id`, `slug`, `title`, `description`, `price`, `status`, `thumbnail`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 1, 'sample-design-1', 'Sample Design 1', 'Contoh deskripsi', 393462, 'published', 'design_thumbs/uAWhUJZyufvTlwLKoj7sHCwOTYghsQvk3mRR3jq9.jpg', 0, '2025-08-13 20:30:37', '2025-08-23 09:42:03'),
(2, 1, 'sample-design-2', 'Sample Design 2', 'Contoh deskripsi', 233196, 'published', 'design_thumbs/cfROm6Xu7S6nPzFBJQZdyb49qC7zCK1kpGLwwrdl.jpg', 0, '2025-08-13 20:40:48', '2025-08-23 09:39:47'),
(3, 1, 'sample-design-3', 'Sample Design 3', 'Contoh deskripsi', 253850, 'published', 'design_thumbs/kxsdHt5t7hsSUB3wA5clkl6aimYV4av4OVeXre9Y.jpg', 0, '2025-08-13 20:40:48', '2025-08-23 09:40:26'),
(4, 2, 'designer-logo', 'Designer Logo', 'Ini adalah desiner logo', 2000000, 'published', 'design_thumbs/kCSv81JYDrbqxMICnYMBYeX3B0HFIBYzGPkDm1XQ.jpg', 0, '2025-08-13 23:59:17', '2025-08-13 23:59:17'),
(5, 3, 'design-3d', 'Design 3D', 'KALDNALKDNWALDA', 12000000, 'published', 'design_thumbs/GVMRU7u7jW59lvF0wiMMRvNkidxnBasFy1vSq0LT.jpg', 0, '2025-08-14 07:34:27', '2025-08-17 19:53:54'),
(6, 2, 'cr-cr-202508-dsnpp-aldmwadlmad-fh5n', 'Desain Custom 3D', 'Jasa Desain Custom 3D', 2000000, 'published', 'design_thumbs/gJBnlBzREsN1tlrSxnixNOcinxre4fxZrT4GPK8R.jpg', 0, '2025-08-16 07:51:21', '2025-08-21 00:40:06'),
(7, 2, 'cr-cr-202508-kfsgr-alkwmadlad-nak9', 'Custom: Desain Jasikos', 'Custom request Desain JASIKOS', 2000000, 'published', 'design_thumbs/cr8m1YLf4ARopiM9ksALEyC0Ig1bLllVlTipnMhU.jpg', 0, '2025-08-16 19:32:16', '2025-08-23 10:16:31'),
(8, 2, 'cr-cr-202508-1ltho-saya-mau-buat-desain-gambar-yaib', 'Custom: Saya mau buat desain gambar', 'Custom request CR-202508-1LTHO', 12000000, 'published', 'design_thumbs/F4v3ldApyFUJ3J27E805BbcgeCHJdTN1Yx1vuRox.jpg', 0, '2025-08-20 06:28:55', '2025-08-26 19:41:02'),
(9, 2, 'aldwaldwmad', 'ALDWA;LDWMAD', 'AWDMKADLMALKD', 120000000, 'published', 'design_thumbs/zprWxNSoJENKWGEdMBwfnINLEHGm9zEw5hG6cqLc.jpg', 0, '2025-08-26 20:27:48', '2025-08-26 21:40:21'),
(10, 2, 'cr-cr-202508-otqws-mau-custom-req-zpfh', 'Custom: Mau custom req', 'Custom request CR-202508-OTQWS', 12000000, 'draft', NULL, 0, '2025-08-28 06:59:50', '2025-08-28 06:59:50'),
(11, 2, 'cr-cr-202508-foxym-lkdlkawd-jfwz', 'Custom: lkdlkawd', 'Custom request CR-202508-FOXYM', 1000000, 'draft', NULL, 0, '2025-08-28 08:30:20', '2025-08-28 08:30:20'),
(12, 2, 'cr-cr-202508-foxym-lkdlkawd-s7t5', 'Custom: lkdlkawd', 'Custom request CR-202508-FOXYM', 1000000, 'draft', NULL, 0, '2025-08-28 08:31:14', '2025-08-28 08:31:14'),
(13, 2, 'cr-cr-202508-foxym-lkdlkawd-wpeq', 'Custom: lkdlkawd', 'Custom request CR-202508-FOXYM', 1000000, 'draft', NULL, 0, '2025-08-28 08:31:32', '2025-08-28 08:31:32'),
(14, 2, 'cr-cr-202508-beuhi-adwada-84qr', 'Custom: adwada', 'Custom request CR-202508-BEUHI', 2000000, 'draft', NULL, 0, '2025-08-28 17:57:46', '2025-08-28 17:57:46'),
(15, 2, 'cr-cr-202508-d3xct-caawdad-f86d', 'Custom: caawdad', 'Custom request CR-202508-D3XCT', 1200000, 'draft', NULL, 0, '2025-08-28 19:20:28', '2025-08-28 19:20:28'),
(16, 2, 'cr-cr-202508-fuhgk-adnladna-oaqh', 'Custom: adnladna', 'Custom request CR-202508-FUHGK', 200000, 'draft', NULL, 0, '2025-08-30 02:54:38', '2025-08-30 02:54:38'),
(17, 2, 'cr-cr-202508-zxeds-lakdlakdnw-uvh8', 'Custom: lakdlakdnw', 'Custom request CR-202508-ZXEDS', 2000000, 'draft', NULL, 0, '2025-08-30 02:57:41', '2025-08-30 02:57:41'),
(18, 2, 'cr-cr-202508-jwwcv-lakwdlakdad-iugk', 'Custom: LAKWDLAKDAD', 'Custom request CR-202508-JWWCV', 2000000, 'draft', NULL, 0, '2025-08-30 03:21:37', '2025-08-30 03:21:37'),
(19, 2, 'cr-cr-202508-5af6z-ladalkdnalsddddddd-t0m6', 'Custom: ladalkdnalsddddddd', 'Custom request CR-202508-5AF6Z', 12000000, 'draft', NULL, 0, '2025-08-30 03:41:27', '2025-08-30 03:41:27'),
(20, 2, 'cr-cr-202508-lknrg-dddddddddddd-ax4u', 'Custom: dddddddddddd', 'Custom request CR-202508-LKNRG', 12000000, 'draft', NULL, 0, '2025-08-30 03:58:05', '2025-08-30 03:58:05'),
(21, 2, 'cr-cr-202508-xktye-lkmdlkadlkad-jmlg', 'Custom: lkMDLKADLKAD', 'Custom request CR-202508-XKTYE', 12000000, 'draft', NULL, 0, '2025-08-30 03:59:54', '2025-08-30 03:59:54'),
(22, 2, 'cr-cr-202508-2nzxj-adkwalkdn-tdsj', 'Custom: adkwalkdn', 'Custom request CR-202508-2NZXJ', 12000000, 'draft', NULL, 0, '2025-08-30 04:02:09', '2025-08-30 04:02:09'),
(23, 2, 'cr-cr-202508-xumdi-adkjakjdnawd-eay6', 'Custom: adkjakjdnawd', 'Custom request CR-202508-XUMDI', 1000000, 'draft', NULL, 0, '2025-08-30 04:35:18', '2025-08-30 04:35:18'),
(24, 2, 'cr-cr-202508-neymg-kjbbbb-78on', 'Custom: kjbbbb', 'Custom request CR-202508-NEYMG', 12000000, 'draft', NULL, 0, '2025-08-30 04:39:40', '2025-08-30 04:39:40'),
(25, 2, 'cr-cr-202508-xvoes-knaldad-uwnb', 'Custom: knaldad', 'Custom request CR-202508-XVOES', 100000, 'draft', NULL, 0, '2025-08-30 04:51:59', '2025-08-30 04:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `design_media`
--

CREATE TABLE `design_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `design_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('image','video') NOT NULL DEFAULT 'image',
  `path` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `design_media`
--

INSERT INTO `design_media` (`id`, `design_id`, `type`, `path`, `sort_order`, `created_at`, `updated_at`) VALUES
(4, 4, 'image', 'designs/4/OeBRxcbvLFWMBMgASc8UmWdg6ddmfLNUnJw1PzR1.jpg', 1, '2025-08-14 00:00:02', '2025-08-14 00:00:02'),
(5, 5, 'image', 'designs/5/lTep02HzjwOnkyEXSTwp334nsBCj63t4nLqJ8rcG.jpg', 1, '2025-08-14 07:34:48', '2025-08-14 07:34:48'),
(6, 5, 'image', 'designs/5/cHAjhTolx1BzJOBneKeq47kCvNYklZXUAFmSnZqT.jpg', 2, '2025-08-14 07:35:03', '2025-08-14 07:35:03'),
(7, 4, 'image', 'designs/4/hyIDw417e34WhNyRqySBJ5P3atx34thSQApM2mdr.jpg', 2, '2025-08-15 04:45:35', '2025-08-15 04:45:35'),
(8, 6, 'image', 'designs/6/apQdbS1pNjk672v0BYRhbwfWQRGaS4cWnEzCxgXU.jpg', 1, '2025-08-21 00:38:37', '2025-08-21 00:38:37'),
(9, 6, 'image', 'designs/6/5gJOalcbX9aDzntD6gLQ0rXqWLu3WfUlEJByscWW.jpg', 2, '2025-08-21 00:38:52', '2025-08-21 00:38:52'),
(10, 7, 'image', 'designs/7/5FO7yPJJp9B1MpvOqibNeFMWeTYtHxUaH709kB5D.jpg', 1, '2025-08-21 00:41:01', '2025-08-21 00:41:01'),
(11, 7, 'video', 'designs/7/D9Xv96lW6nXl3ZNQ2Wm16qbWQEnGScZuMwGsVbMa.mp4', 2, '2025-08-21 00:41:26', '2025-08-21 00:41:26'),
(12, 7, 'image', 'designs/7/Mj1RN1aWITUpNgpzv8YqXad2CZeiYyI3sVgY7hOP.jpg', 3, '2025-08-21 00:41:40', '2025-08-21 00:41:40'),
(13, 7, 'image', 'designs/7/1oVe0SfxglT4PkARkRD62xepsd0RMECiIcDfyoPh.jpg', 4, '2025-08-21 04:48:20', '2025-08-21 04:48:20'),
(14, 7, 'image', 'designs/7/05DIHHueXJFI37F9U5p5yDb7LOlqbOpoDObZmSth.jpg', 5, '2025-08-21 04:48:35', '2025-08-21 04:48:35'),
(15, 2, 'image', 'designs/2/xEFsU5u6HGlGsGVNSEgHFMrx98D4Od3eblSNpL7U.jpg', 1, '2025-08-23 09:38:57', '2025-08-23 09:38:57'),
(16, 2, 'image', 'designs/2/fZpNELYccYSM1t5vHRv23ApRWxwg2AtPLnp8VJAw.jpg', 2, '2025-08-23 09:39:11', '2025-08-23 09:39:11'),
(17, 2, 'image', 'designs/2/8xf092tNjIEmcDoHzUVeQelqboX2VSVMYJ9wcRXf.jpg', 3, '2025-08-23 09:39:30', '2025-08-23 09:39:30'),
(18, 3, 'image', 'designs/3/mw36HgPjv5DfUvfAVoZfmak8TZkmMAZ5f4CgaOlW.jpg', 1, '2025-08-23 09:41:00', '2025-08-23 09:41:00'),
(19, 3, 'image', 'designs/3/NPKFiDBqUp6QHP5xo4PvI4FJvChWGDe4f4sq8ej1.jpg', 2, '2025-08-23 09:41:17', '2025-08-23 09:41:17'),
(20, 3, 'image', 'designs/3/EwIvuHVqklae4fdpFPlXvyCTIPEXAI6QlXdOzPBg.jpg', 3, '2025-08-23 09:41:34', '2025-08-23 09:41:34'),
(21, 1, 'image', 'designs/1/QOPBocllCS2aoaBoSBfa7maGQT5RB1sTROI2Loeq.jpg', 1, '2025-08-23 09:42:19', '2025-08-23 09:42:19'),
(22, 1, 'image', 'designs/1/wN4w8Sf5RwfB5j4E5tYKuKJS59mtRLiLnchQy8Sj.jpg', 2, '2025-08-23 09:42:37', '2025-08-23 09:42:37'),
(23, 8, 'image', 'designs/8/T5kyGkIMIvJbSvS6DeUriq6sEbK4CMaqVTQJpzMS.jpg', 1, '2025-08-26 19:40:01', '2025-08-26 19:40:01'),
(24, 9, 'image', 'designs/9/Vc4ncvG9Y1D3IOeQTnBuIXlUuOV6gAQE5oHylx6H.jpg', 1, '2025-08-26 20:29:29', '2025-08-26 20:29:29'),
(25, 9, 'image', 'designs/9/DMVxN5jzcsZtMluWkvdBjcZtPR3BbtBuqgu8gE4f.jpg', 2, '2025-08-26 20:29:46', '2025-08-26 20:29:46');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_08_14_020912_add_role_phone_avatar_whatsapp_last_login_at_to_users_table', 2),
(6, '2025_08_14_021054_create_designers_table', 2),
(7, '2025_08_14_021105_create_customers_table', 2),
(8, '2025_08_14_021441_create_designs_table', 2),
(9, '2025_08_14_021454_create_design_media_table', 2),
(10, '2025_08_14_025432_categories_and_pivot', 2),
(11, '2025_08_14_025448_create_carts_table', 2),
(12, '2025_08_14_025451_create_orders_table', 2),
(13, '2025_08_14_025454_custom_requests_and_files', 2),
(14, '2025_08_14_025458_comments_and_ratings', 2),
(15, '2025_08_15_112058_add_delivered_at_to_order_items', 3),
(16, '2025_08_23_033842_add_shipping_to_orders', 4),
(17, '2025_08_26_073913_create_settings_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `designer_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('awaiting_payment','processing','delivered','completed','cancelled','declined') NOT NULL DEFAULT 'awaiting_payment',
  `payment_status` enum('unpaid','submitted','paid','rejected') NOT NULL DEFAULT 'unpaid',
  `shipping_method` enum('digital','ship') NOT NULL DEFAULT 'digital',
  `shipping_status` enum('pending','packed','shipped','delivered') DEFAULT NULL,
  `pay_bank_name` varchar(255) DEFAULT NULL,
  `pay_bank_account_no` varchar(255) DEFAULT NULL,
  `pay_qris_image` varchar(255) DEFAULT NULL,
  `subtotal` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `fee` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `total` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `note` text DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ship_name` varchar(255) DEFAULT NULL,
  `ship_phone` varchar(255) DEFAULT NULL,
  `ship_address` varchar(255) DEFAULT NULL,
  `ship_city` varchar(255) DEFAULT NULL,
  `ship_province` varchar(255) DEFAULT NULL,
  `ship_postal_code` varchar(10) DEFAULT NULL,
  `shipping_courier` varchar(255) DEFAULT NULL,
  `shipping_tracking_no` varchar(255) DEFAULT NULL,
  `shipping_fee` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `code`, `customer_id`, `designer_id`, `status`, `payment_status`, `shipping_method`, `shipping_status`, `pay_bank_name`, `pay_bank_account_no`, `pay_qris_image`, `subtotal`, `fee`, `total`, `note`, `paid_at`, `created_at`, `updated_at`, `ship_name`, `ship_phone`, `ship_address`, `ship_city`, `ship_province`, `ship_postal_code`, `shipping_courier`, `shipping_tracking_no`, `shipping_fee`, `shipped_at`, `delivered_at`) VALUES
(1, 'JAS-202508-DNTDU', 4, 3, 'completed', 'paid', 'digital', NULL, 'BCA', '133320002133202', 'qris/9AFEsAcwGTkP3N8vpnXGOgkDvs6ZZAGyMHBZibrH.jpg', 12000000, 0, 12000000, NULL, '2025-08-14 20:45:13', '2025-08-14 20:01:47', '2025-08-14 23:17:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(2, 'JAS-202508-3ELAN', 4, 2, 'processing', 'paid', 'digital', NULL, 'BCA', '13332929302322', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 2000000, NULL, '2025-08-15 00:30:42', '2025-08-15 00:27:53', '2025-08-15 00:30:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(3, 'JAS-202508-WWGOG', 4, 2, 'completed', 'paid', 'digital', NULL, 'BCA', '13332929302322', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 2000000, NULL, '2025-08-15 04:39:06', '2025-08-15 04:37:44', '2025-08-15 04:42:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(4, 'JAS-202508-ZVDJE', 4, 2, 'awaiting_payment', 'submitted', 'digital', NULL, 'BCA', '13332929302322', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 2000000, NULL, NULL, '2025-08-15 06:35:36', '2025-08-15 06:37:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(5, 'JAS-202508-1N53P', 4, 2, 'completed', 'paid', 'digital', NULL, 'BCA', '13332929302322', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 2000000, 'CR: CR-202508-DSNPP', '2025-08-16 07:53:09', '2025-08-16 07:51:21', '2025-08-16 07:56:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(6, 'JAS-202508-X5B5T', 4, 2, 'completed', 'paid', 'digital', NULL, 'BCA', '13332929302322', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 2000000, 'CR: CR-202508-KFSGR', '2025-08-16 19:33:49', '2025-08-16 19:32:16', '2025-08-16 19:36:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(7, 'JAS-202508-BJZMV', 4, 2, 'awaiting_payment', 'submitted', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 2000000, NULL, NULL, '2025-08-18 09:01:52', '2025-08-18 09:02:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(8, 'JAS-202508-KYX9L', 4, 2, 'completed', 'paid', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 2000000, NULL, '2025-08-20 06:19:34', '2025-08-20 06:17:08', '2025-08-20 06:23:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(9, 'JAS-202508-9URNY', 4, 2, 'completed', 'paid', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 12000000, 0, 12000000, 'CR: CR-202508-1LTHO', '2025-08-20 06:30:19', '2025-08-20 06:28:55', '2025-08-20 06:33:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(10, 'JAS-202508-FTDBL', 4, 2, 'delivered', 'paid', 'ship', 'shipped', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 4000000, NULL, '2025-08-23 09:04:13', '2025-08-23 08:59:20', '2025-08-23 09:13:09', 'Kuro', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I', 'CIMAHI', 'Jawa barat', '40522', 'SUPRIANTO', 'ZMK-110-NOOW', 2000000, '2025-08-23 09:13:09', NULL),
(11, 'JAS-202508-MYLJ8', 4, 1, 'completed', 'paid', 'ship', 'delivered', 'BCA', '13332929302321', 'qris/tep4eVITENUJj49J5Y9urUEi58haimFMlfjWn6JP.jpg', 253850, 0, 12253850, NULL, '2025-08-23 10:10:54', '2025-08-23 10:06:51', '2025-08-23 22:58:34', 'KURO', '089662712281', 'JL.ABDUL HALIM NO,1', 'BANDUNG', 'JAWA BARAT', '40021', 'SUPRIANTO(JNE)', 'X-JJNT-2201-DA', 12000000, '2025-08-23 10:13:33', '2025-08-23 10:14:13'),
(12, 'JAS-202508-QMIEK', 4, 2, 'awaiting_payment', 'unpaid', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 2000000, NULL, NULL, '2025-08-23 22:59:49', '2025-08-23 22:59:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(13, 'JAS-202508-34ZOF', 4, 2, 'awaiting_payment', 'unpaid', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 12000000, 0, 12000000, NULL, NULL, '2025-08-26 22:27:15', '2025-08-26 22:27:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(14, 'JAS-202508-XRJAF', 6, 2, 'processing', 'paid', 'ship', 'pending', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 4000000, 0, 16000000, NULL, '2025-08-27 16:16:07', '2025-08-27 15:58:41', '2025-08-27 16:16:48', 'hilman ardiansyah', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006', 'Kota Cimahi', 'Jawa Barat', '40522', 'SUPRIANTO', 'ZMK-110-NOOW', 12000000, NULL, NULL),
(15, 'JAS-202508-9NIRE', 6, 2, 'completed', 'paid', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 120000000, 0, 120000000, NULL, '2025-08-28 07:06:18', '2025-08-27 16:34:11', '2025-08-28 07:49:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(16, 'JAS-202508-Z279T', 6, 2, 'completed', 'paid', 'ship', 'delivered', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 120000000, 0, 122000000, NULL, '2025-08-27 18:36:19', '2025-08-27 17:22:48', '2025-08-27 18:45:23', 'Hilman Ardiansyah', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I RT 007 RW 006', 'Cimahi', 'Jawa barat', NULL, 'SUPRIANTO', 'ZMK-110-NOOW', 2000000, '2025-08-27 18:41:53', '2025-08-27 18:42:45'),
(17, 'JAS-202508-C7LZ4', 6, 2, 'completed', 'paid', 'ship', 'delivered', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 120000000, 0, 125000000, NULL, '2025-08-28 06:52:18', '2025-08-28 06:48:01', '2025-08-28 06:56:39', 'KRUCIL', '089662721221', 'JL.JENDRAL SUDIRMAN', 'BANDUNG', 'JAWA BARAT', '40552', 'SUPRIANTO', 'JNT-445-002', 5000000, '2025-08-28 06:54:31', '2025-08-28 06:55:13'),
(18, 'JAS-202508-3I33S', 6, 2, 'completed', 'paid', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 12000000, 0, 12000000, 'CR: CR-202508-OTQWS', '2025-08-28 07:00:51', '2025-08-28 06:59:50', '2025-08-28 07:02:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(19, 'JAS-202508-NDXVA', 6, 2, 'awaiting_payment', 'unpaid', 'ship', 'pending', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 120000000, 0, 121000000, NULL, NULL, '2025-08-28 08:41:19', '2025-08-28 08:42:31', 'hilman ardiansyah', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006', 'Kota Cimahi', 'Jawa Barat', '40522', NULL, NULL, 1000000, NULL, NULL),
(20, 'JAS-202508-STYJ2', 6, 2, 'completed', 'paid', 'ship', 'delivered', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 14000000, 'CR: CR-202508-BEUHI', '2025-08-28 18:01:49', '2025-08-28 17:57:46', '2025-08-28 18:03:15', 'hilman ardiansyah', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006', 'Kota Cimahi', 'Jawa Barat', '40522', 'SUPRIANTO', 'JNT-445-002', 12000000, '2025-08-28 18:02:19', '2025-08-28 18:03:12'),
(21, 'JAS-202508-FGMTG', 6, 2, 'awaiting_payment', 'unpaid', 'ship', 'pending', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 1200000, 0, 1200000, 'CR: CR-202508-D3XCT', NULL, '2025-08-28 19:20:29', '2025-08-28 19:20:29', 'hilman ardiansyah', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006', 'Kota Cimahi', 'Jawa Barat', '40522', NULL, NULL, 0, NULL, NULL),
(22, 'JAS-202508-LMDWQ', 6, 2, 'awaiting_payment', 'unpaid', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 200000, 0, 200000, 'CR: CR-202508-FUHGK', NULL, '2025-08-30 02:54:38', '2025-08-30 02:54:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(23, 'JAS-202508-MRYPC', 6, 2, 'awaiting_payment', 'unpaid', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 2000000, 'CR: CR-202508-ZXEDS', NULL, '2025-08-30 02:57:41', '2025-08-30 02:57:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(24, 'JAS-202508-E16YS', 6, 2, 'awaiting_payment', 'unpaid', 'ship', 'pending', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 2000000, 0, 2000000, 'CR: CR-202508-JWWCV', NULL, '2025-08-30 03:21:37', '2025-08-30 03:21:37', 'hilman ardiansyah', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', 'Kota Cimahi', 'Jawa Barat', '40522', NULL, NULL, 0, NULL, NULL),
(25, 'JAS-202508-H1TEF', 6, 2, 'completed', 'paid', 'ship', 'delivered', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 12000000, 0, 14000000, 'CR: CR-202508-5AF6Z', '2025-08-30 03:42:39', '2025-08-30 03:41:27', '2025-08-30 03:44:15', 'hilman ardiansyah', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', 'Kota Cimahi', 'Jawa Barat', '40522', 'SUPRIANTO', 'ZMK-110-NOOW', 2000000, '2025-08-30 03:42:58', '2025-08-30 03:44:11'),
(26, 'JAS-202508-TVMQO', 6, 2, 'awaiting_payment', 'unpaid', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 12000000, 0, 12000000, 'CR: CR-202508-LKNRG', NULL, '2025-08-30 03:58:05', '2025-08-30 03:58:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(27, 'JAS-202508-E6BNV', 6, 2, 'awaiting_payment', 'submitted', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 12000000, 0, 12000000, 'CR: CR-202508-XKTYE', NULL, '2025-08-30 03:59:54', '2025-08-30 04:00:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(28, 'JAS-202508-4EDT8', 6, 2, 'awaiting_payment', 'unpaid', 'ship', 'pending', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 12000000, 0, 14000000, 'CR: CR-202508-2NZXJ', NULL, '2025-08-30 04:02:09', '2025-08-30 04:02:09', 'hilman ardiansyah', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', 'Kota Cimahi', 'Jawa Barat', '40522', NULL, NULL, 2000000, NULL, NULL),
(29, 'JAS-202508-W1FKD', 6, 2, 'completed', 'paid', 'ship', 'delivered', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 120000000, 0, 120120000, NULL, '2025-08-30 04:27:30', '2025-08-30 04:23:57', '2025-08-30 04:30:02', 'hilman ardiansyah', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006', 'Kota Cimahi', 'Jawa Barat', '40522', 'SUPRIANTO', 'ZMK-110-NOOW', 120000, '2025-08-30 04:29:07', '2025-08-30 04:29:57'),
(30, 'JAS-202508-IQU2P', 6, 2, 'completed', 'paid', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 12000000, 0, 12000000, NULL, '2025-08-30 04:31:52', '2025-08-30 04:30:45', '2025-08-30 04:33:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(31, 'JAS-202508-U8HYC', 6, 2, 'completed', 'paid', 'ship', 'delivered', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 1000000, 0, 1120000, 'CR: CR-202508-XUMDI', '2025-08-30 04:36:13', '2025-08-30 04:35:18', '2025-08-30 04:37:27', 'hilman ardiansyah', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', 'Kota Cimahi', 'Jawa Barat', '40522', 'SUPRIANTO(JNT)', 'ZMK-110-NOOOO', 120000, '2025-08-30 04:36:40', '2025-08-30 04:37:23'),
(32, 'JAS-202508-A3BAN', 6, 2, 'completed', 'paid', 'digital', NULL, 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 12000000, 0, 12000000, 'CR: CR-202508-NEYMG', '2025-08-30 04:40:23', '2025-08-30 04:39:40', '2025-08-30 04:41:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(33, 'JAS-202508-I6WT7', 6, 2, 'awaiting_payment', 'unpaid', 'ship', 'pending', 'BCA', '13332929302321', 'qris/KXhbmtCzexEAlGBE5352Sq5HR6OMNAsJiESjHhmb.jpg', 100000, 0, 110000, 'CR: CR-202508-XVOES', NULL, '2025-08-30 04:51:59', '2025-08-30 04:51:59', 'hilman ardiansyah', '0895626141738', 'KP.CILEMBER GG TUNGGAL BHAKTI I RT007 RW006, Kota Cimahi, Jawa Barat 40522', 'Kota Cimahi', 'Jawa Barat', '40522', NULL, NULL, 10000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_deliverables`
--

CREATE TABLE `order_deliverables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `visible_after` enum('paid','delivered','completed') NOT NULL DEFAULT 'paid',
  `download_limit` smallint(5) UNSIGNED DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_deliverables`
--

INSERT INTO `order_deliverables` (`id`, `order_item_id`, `file_path`, `visible_after`, `download_limit`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'deliverables/order_1/item_1/txJIdXDKdpL2vogrivZSEf9S2ly3NHUPSqYc2rFS.jpg', 'delivered', NULL, NULL, '2025-08-14 20:47:19', '2025-08-14 20:47:19'),
(2, 2, 'deliverables/order_2/item_2/Srk1BwkCsXAog5VNTLqMb1ZNOIZuQRSSvSokxdvK.jpg', 'delivered', NULL, NULL, '2025-08-15 00:31:03', '2025-08-15 00:31:03'),
(3, 2, 'deliverables/order_2/item_2/u8KOEP5fxQ8sLPqN9nGX0DCXDKPf5RrqiTl7s9Jy.jpg', 'delivered', NULL, NULL, '2025-08-15 04:00:48', '2025-08-15 04:00:48'),
(4, 2, 'deliverables/order_2/item_2/GfdDoA4LMyv3TQdk3vLueIbDBN1vbwJ6GI9mZw4Q.jpg', 'completed', NULL, NULL, '2025-08-15 04:02:43', '2025-08-15 04:02:43'),
(5, 3, 'deliverables/order_3/item_3/4PA0sc4GLHPuPRyanX0uCsZ4A6oYveFxeCej36lf.jpg', 'delivered', NULL, NULL, '2025-08-15 04:40:52', '2025-08-15 04:40:52'),
(6, 3, 'deliverables/order_3/item_3/tmFl69RMA9liidV1jskZcOanoqXKUlK20yo7Hje5.jpg', 'completed', NULL, NULL, '2025-08-15 04:41:04', '2025-08-15 04:41:04'),
(7, 5, 'deliverables/order_5/item_5/ELEMew4EPkm4vL2oroFCgxkN6ERdxqYbYWyITmo9.jpg', 'completed', NULL, NULL, '2025-08-16 07:53:32', '2025-08-16 07:53:32'),
(8, 5, 'deliverables/order_5/item_5/QsBKPYEagbHYg807W8E90DSnLSwtz1qPPtypODOR.jpg', 'completed', NULL, NULL, '2025-08-16 07:55:38', '2025-08-16 07:55:38'),
(9, 6, 'deliverables/order_6/item_6/UstIncXxoGtCASfQyFFUEQ1r8ub5qzcfXg83gB2f.jpg', 'delivered', NULL, NULL, '2025-08-16 19:34:08', '2025-08-16 19:34:08'),
(10, 6, 'deliverables/order_6/item_6/XNITmwiYvVi2GjeZsBvXJy0JjTlClNmTCwIaIivX.jpg', 'completed', NULL, NULL, '2025-08-16 19:35:58', '2025-08-16 19:35:58'),
(11, 8, 'deliverables/order_8/item_8/VHFVSWEtIsECKuRvJpulAYhJxARW3tPnU54CitJ7.jpg', 'delivered', NULL, NULL, '2025-08-20 06:20:01', '2025-08-20 06:20:01'),
(12, 8, 'deliverables/order_8/item_8/9yOFZ1SxWefqsPyQhuAakVySeMTsUixNPksaTJ6s.jpg', 'completed', NULL, NULL, '2025-08-20 06:23:05', '2025-08-20 06:23:05'),
(13, 9, 'deliverables/order_9/item_9/Hlw7WkvHoK0fFAnbCFuyI0a1SQw8oyYZqspuFkQP.jpg', 'delivered', NULL, NULL, '2025-08-20 06:30:44', '2025-08-20 06:30:44'),
(14, 9, 'deliverables/order_9/item_9/BXa9g1oRzxCG7mr8iA8hy8XxVugdORkZG9bbD5iN.jpg', 'completed', NULL, NULL, '2025-08-20 06:32:42', '2025-08-20 06:32:42'),
(15, 11, 'deliverables/order_11/item_11/oplWs6qPQ6MTqGN0ffLmzKBGU7Fbmab0B9XrxOYX.jpg', 'delivered', NULL, NULL, '2025-08-23 10:11:21', '2025-08-23 10:11:21'),
(16, 16, 'deliverables/order_16/item_16/GYzjfmS3hp4q4Y18nrQuegHWNGg1z2BqQv8N2m0c.jpg', 'completed', NULL, NULL, '2025-08-27 18:44:45', '2025-08-27 18:44:45'),
(17, 18, 'deliverables/order_18/item_18/yBwzknwoQvOAeRaUiOafdOJXnsz5O9FK19rJPBXm.jpg', 'completed', NULL, NULL, '2025-08-28 07:01:33', '2025-08-28 07:01:33'),
(18, 15, 'deliverables/order_15/item_15/dByK1euJFUY1BfRbMQz5Ltt1Mb3HpNMcTRROjAZH.jpg', 'completed', NULL, NULL, '2025-08-28 07:06:36', '2025-08-28 07:06:36'),
(19, 15, 'deliverables/order_15/item_15/amciBKt9Fb2m3lZG7GAVnbXRk0glFaKkixM8cwuj.jpg', 'delivered', NULL, NULL, '2025-08-28 07:30:42', '2025-08-28 07:30:42'),
(20, 30, 'deliverables/order_30/item_30/rGjNSt81lSoQpQ7kjWposZwFjdS3591M8g6q3Ie7.jpg', 'delivered', NULL, NULL, '2025-08-30 04:32:11', '2025-08-30 04:32:11'),
(21, 32, 'deliverables/order_32/item_32/wPZ0oAUzsGcQ44VnDaNKDHXUzUXTqjpwxqnIMDXk.jpg', 'delivered', NULL, NULL, '2025-08-30 04:40:53', '2025-08-30 04:40:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `design_id` bigint(20) UNSIGNED NOT NULL,
  `designer_id` bigint(20) UNSIGNED NOT NULL,
  `title_snapshot` varchar(255) NOT NULL,
  `price_snapshot` bigint(20) UNSIGNED NOT NULL,
  `qty` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `item_status` enum('processing','delivered','revised','completed','cancelled') NOT NULL DEFAULT 'processing',
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `design_id`, `designer_id`, `title_snapshot`, `price_snapshot`, `qty`, `item_status`, `delivered_at`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 3, 'Design 3D', 12000000, 1, 'completed', NULL, '2025-08-14 20:01:47', '2025-08-14 23:17:00'),
(2, 2, 4, 2, 'Designer Logo', 2000000, 1, 'completed', NULL, '2025-08-15 00:27:53', '2025-08-15 04:04:32'),
(3, 3, 4, 2, 'Designer Logo', 2000000, 1, 'completed', '2025-08-15 04:39:27', '2025-08-15 04:37:44', '2025-08-15 04:42:02'),
(4, 4, 4, 2, 'Designer Logo', 2000000, 1, 'processing', NULL, '2025-08-15 06:35:36', '2025-08-15 06:35:36'),
(5, 5, 6, 2, 'Custom: aldmwadl;mad', 2000000, 1, 'completed', '2025-08-16 07:55:39', '2025-08-16 07:51:21', '2025-08-16 07:56:24'),
(6, 6, 7, 2, 'Custom: alkwmadlad', 2000000, 1, 'completed', '2025-08-16 19:35:58', '2025-08-16 19:32:16', '2025-08-16 19:36:45'),
(7, 7, 4, 2, 'Designer Logo', 2000000, 1, 'processing', NULL, '2025-08-18 09:01:53', '2025-08-18 09:01:53'),
(8, 8, 4, 2, 'Designer Logo', 2000000, 1, 'completed', '2025-08-20 06:23:05', '2025-08-20 06:17:08', '2025-08-20 06:23:49'),
(9, 9, 8, 2, 'Custom: Saya mau buat desain gambar', 12000000, 1, 'completed', '2025-08-20 06:32:43', '2025-08-20 06:28:55', '2025-08-20 06:33:31'),
(10, 10, 6, 2, 'Desain Custom 3D', 2000000, 1, 'processing', NULL, '2025-08-23 08:59:20', '2025-08-23 08:59:20'),
(11, 11, 3, 1, 'Sample Design 3', 253850, 1, 'completed', '2025-08-23 10:11:21', '2025-08-23 10:06:51', '2025-08-23 10:12:43'),
(12, 12, 7, 2, 'Custom: Desain Jasikos', 2000000, 1, 'processing', NULL, '2025-08-23 22:59:49', '2025-08-23 22:59:49'),
(13, 13, 8, 2, 'Custom: Saya mau buat desain gambar', 12000000, 1, 'processing', NULL, '2025-08-26 22:27:16', '2025-08-26 22:27:16'),
(14, 14, 7, 2, 'Custom: Desain Jasikos', 2000000, 2, 'processing', NULL, '2025-08-27 15:58:41', '2025-08-27 15:58:41'),
(15, 15, 9, 2, 'ALDWA;LDWMAD', 120000000, 1, 'completed', '2025-08-28 07:30:42', '2025-08-27 16:34:11', '2025-08-28 07:49:17'),
(16, 16, 9, 2, 'ALDWA;LDWMAD', 120000000, 1, 'completed', '2025-08-27 18:44:31', '2025-08-27 17:22:48', '2025-08-27 18:45:23'),
(17, 17, 9, 2, 'ALDWA;LDWMAD', 120000000, 1, 'completed', '2025-08-28 06:56:01', '2025-08-28 06:48:01', '2025-08-28 06:56:39'),
(18, 18, 10, 2, 'Custom: Mau custom req', 12000000, 1, 'completed', '2025-08-28 07:01:33', '2025-08-28 06:59:50', '2025-08-28 07:02:36'),
(19, 19, 9, 2, 'ALDWA;LDWMAD', 120000000, 1, 'processing', NULL, '2025-08-28 08:41:19', '2025-08-28 08:41:19'),
(20, 20, 14, 2, 'Custom: adwada', 2000000, 1, 'completed', '2025-08-28 18:02:23', '2025-08-28 17:57:46', '2025-08-28 18:03:15'),
(21, 21, 15, 2, 'Custom: caawdad', 1200000, 1, 'processing', NULL, '2025-08-28 19:20:29', '2025-08-28 19:20:29'),
(22, 22, 16, 2, 'Custom: adnladna', 200000, 1, 'processing', NULL, '2025-08-30 02:54:38', '2025-08-30 02:54:38'),
(23, 23, 17, 2, 'Custom: lakdlakdnw', 2000000, 1, 'processing', NULL, '2025-08-30 02:57:41', '2025-08-30 02:57:41'),
(24, 24, 18, 2, 'Custom: LAKWDLAKDAD', 2000000, 1, 'processing', NULL, '2025-08-30 03:21:37', '2025-08-30 03:21:37'),
(25, 25, 19, 2, 'Custom: ladalkdnalsddddddd', 12000000, 1, 'completed', '2025-08-30 03:43:06', '2025-08-30 03:41:27', '2025-08-30 03:44:15'),
(26, 26, 20, 2, 'Custom: dddddddddddd', 12000000, 1, 'processing', NULL, '2025-08-30 03:58:05', '2025-08-30 03:58:05'),
(27, 27, 21, 2, 'Custom: lkMDLKADLKAD', 12000000, 1, 'processing', NULL, '2025-08-30 03:59:54', '2025-08-30 03:59:54'),
(28, 28, 22, 2, 'Custom: adkwalkdn', 12000000, 1, 'processing', NULL, '2025-08-30 04:02:09', '2025-08-30 04:02:09'),
(29, 29, 9, 2, 'ALDWA;LDWMAD', 120000000, 1, 'completed', '2025-08-30 04:29:16', '2025-08-30 04:23:57', '2025-08-30 04:30:02'),
(30, 30, 8, 2, 'Custom: Saya mau buat desain gambar', 12000000, 1, 'completed', '2025-08-30 04:32:11', '2025-08-30 04:30:45', '2025-08-30 04:33:04'),
(31, 31, 23, 2, 'Custom: adkjakjdnawd', 1000000, 1, 'completed', '2025-08-30 04:36:45', '2025-08-30 04:35:18', '2025-08-30 04:37:27'),
(32, 32, 24, 2, 'Custom: kjbbbb', 12000000, 1, 'completed', '2025-08-30 04:40:53', '2025-08-30 04:39:40', '2025-08-30 04:41:42'),
(33, 33, 25, 2, 'Custom: knaldad', 100000, 1, 'processing', NULL, '2025-08-30 04:51:59', '2025-08-30 04:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `order_status_logs`
--

CREATE TABLE `order_status_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `from_status` varchar(255) DEFAULT NULL,
  `to_status` varchar(255) NOT NULL,
  `changed_by` bigint(20) UNSIGNED NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_status_logs`
--

INSERT INTO `order_status_logs` (`id`, `order_id`, `from_status`, `to_status`, `changed_by`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 'awaiting_payment', 'processing', 8, 'Payment confirmed by designer', '2025-08-14 20:45:13', '2025-08-14 20:45:13'),
(2, 1, 'processing', 'processing', 6, 'Customer meminta revisi: adadadwad', '2025-08-14 23:16:08', '2025-08-14 23:16:08'),
(3, 1, 'processing', 'completed', 6, 'Order selesai: semua item diterima customer', '2025-08-14 23:17:00', '2025-08-14 23:17:00'),
(4, 2, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-15 00:30:42', '2025-08-15 00:30:42'),
(5, 2, 'processing', 'processing', 6, 'Customer meminta revisi: Tambahkan logonya', '2025-08-15 00:31:47', '2025-08-15 00:31:47'),
(6, 2, 'processing', 'processing', 6, 'Customer meminta revisi: adnakwdnadwadawdada', '2025-08-15 03:48:39', '2025-08-15 03:48:39'),
(7, 2, 'processing', 'processing', 6, 'Customer meminta revisi: ladmalkdmalwwdka', '2025-08-15 04:01:55', '2025-08-15 04:01:55'),
(8, 3, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-15 04:39:06', '2025-08-15 04:39:06'),
(9, 3, 'processing', 'completed', 6, 'Order selesai: semua item diterima customer', '2025-08-15 04:42:02', '2025-08-15 04:42:02'),
(10, 5, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-16 07:53:09', '2025-08-16 07:53:09'),
(11, 5, 'processing', 'processing', 6, 'Customer meminta revisi: lkdlawdald', '2025-08-16 07:54:29', '2025-08-16 07:54:29'),
(12, 5, 'processing', 'completed', 6, 'Order selesai: semua item diterima customer', '2025-08-16 07:56:24', '2025-08-16 07:56:24'),
(13, 6, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-16 19:33:49', '2025-08-16 19:33:49'),
(14, 6, 'processing', 'processing', 6, 'Customer meminta revisi: lakdlawkdad', '2025-08-16 19:35:07', '2025-08-16 19:35:07'),
(15, 6, 'processing', 'completed', 6, 'Order selesai: semua item diterima customer', '2025-08-16 19:36:45', '2025-08-16 19:36:45'),
(16, 8, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-20 06:19:34', '2025-08-20 06:19:34'),
(17, 8, 'processing', 'processing', 6, 'Customer meminta revisi: adwadadawdadadw', '2025-08-20 06:21:18', '2025-08-20 06:21:18'),
(18, 8, 'processing', 'completed', 6, 'Order selesai: semua item diterima customer', '2025-08-20 06:23:49', '2025-08-20 06:23:49'),
(19, 9, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-20 06:30:19', '2025-08-20 06:30:19'),
(20, 9, 'processing', 'processing', 6, 'Customer meminta revisi: Revisiii', '2025-08-20 06:31:33', '2025-08-20 06:31:33'),
(21, 9, 'processing', 'completed', 6, 'Order selesai: semua item diterima customer', '2025-08-20 06:33:31', '2025-08-20 06:33:31'),
(22, 10, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-23 09:04:13', '2025-08-23 09:04:13'),
(23, 11, 'awaiting_payment', 'processing', 2, 'Payment confirmed by designer', '2025-08-23 10:10:54', '2025-08-23 10:10:54'),
(24, 11, 'processing', 'completed', 6, 'Order selesai: semua item diterima customer', '2025-08-23 10:12:44', '2025-08-23 10:12:44'),
(25, 11, 'delivered', 'completed', 1, 'Admin update', '2025-08-23 22:58:34', '2025-08-23 22:58:34'),
(26, 14, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-27 16:16:07', '2025-08-27 16:16:07'),
(27, 16, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-27 18:36:19', '2025-08-27 18:36:19'),
(28, 16, 'delivered', 'completed', 10, 'Order completed: all items accepted by the customer', '2025-08-27 18:45:23', '2025-08-27 18:45:23'),
(29, 17, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-28 06:52:18', '2025-08-28 06:52:18'),
(30, 17, 'delivered', 'completed', 10, 'Order completed: all items accepted by the customer', '2025-08-28 06:56:39', '2025-08-28 06:56:39'),
(31, 18, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-28 07:00:51', '2025-08-28 07:00:51'),
(32, 18, 'processing', 'completed', 10, 'Order completed: all items accepted by the customer', '2025-08-28 07:02:36', '2025-08-28 07:02:36'),
(33, 15, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-28 07:06:18', '2025-08-28 07:06:18'),
(34, 15, 'processing', 'processing', 10, 'Customer requested a revision: lkndladnawd', '2025-08-28 07:29:45', '2025-08-28 07:29:45'),
(35, 15, 'processing', 'completed', 10, 'Order completed: all items accepted by the customer', '2025-08-28 07:49:17', '2025-08-28 07:49:17'),
(36, 20, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-28 18:01:49', '2025-08-28 18:01:49'),
(37, 20, 'delivered', 'completed', 10, 'Order completed: all items accepted by the customer', '2025-08-28 18:03:15', '2025-08-28 18:03:15'),
(38, 25, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-30 03:42:39', '2025-08-30 03:42:39'),
(39, 25, 'delivered', 'completed', 10, 'Order completed: all items accepted by the customer', '2025-08-30 03:44:15', '2025-08-30 03:44:15'),
(40, 29, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-30 04:27:30', '2025-08-30 04:27:30'),
(41, 29, 'delivered', 'completed', 10, 'Order completed: all items accepted by the customer', '2025-08-30 04:30:02', '2025-08-30 04:30:02'),
(42, 30, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-30 04:31:52', '2025-08-30 04:31:52'),
(43, 30, 'processing', 'completed', 10, 'Order completed: all items accepted by the customer', '2025-08-30 04:33:04', '2025-08-30 04:33:04'),
(44, 31, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-30 04:36:13', '2025-08-30 04:36:13'),
(45, 31, 'delivered', 'completed', 10, 'Order completed: all items accepted by the customer', '2025-08-30 04:37:27', '2025-08-30 04:37:27'),
(46, 32, 'awaiting_payment', 'processing', 7, 'Payment confirmed by designer', '2025-08-30 04:40:23', '2025-08-30 04:40:23'),
(47, 32, 'processing', 'completed', 10, 'Order completed: all items accepted by the customer', '2025-08-30 04:41:42', '2025-08-30 04:41:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_proofs`
--

CREATE TABLE `payment_proofs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `uploader_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `amount` bigint(20) UNSIGNED DEFAULT NULL,
  `payer_name` varchar(255) DEFAULT NULL,
  `status` enum('submitted','accepted','rejected') NOT NULL DEFAULT 'submitted',
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_proofs`
--

INSERT INTO `payment_proofs` (`id`, `order_id`, `uploader_id`, `image_path`, `amount`, `payer_name`, `status`, `reviewed_by`, `reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'payment_proofs/1/kjnWG9VsRyQ2nmyOb9ZkWQOl4nixRfWTxBAe3Ns3.png', 12000000, 'DODO WIDARTO', 'accepted', 8, '2025-08-14 20:45:13', '2025-08-14 20:03:53', '2025-08-14 20:45:13'),
(2, 2, 6, 'payment_proofs/2/RKAt5c9fh9nCNcFmnglzBAmBOpOxAWZycyr1C7NG.png', 2000000, 'SUPRIANTO', 'accepted', 7, '2025-08-15 00:30:42', '2025-08-15 00:28:29', '2025-08-15 00:30:42'),
(3, 3, 6, 'payment_proofs/3/2vELhWDJHpGgu8CV3aCx4CWO3TArMD6JmjDlxrkO.png', 2000000, 'KURO', 'accepted', 7, '2025-08-15 04:39:06', '2025-08-15 04:38:22', '2025-08-15 04:39:06'),
(4, 4, 6, 'payment_proofs/4/yhOv8DYF8CPi5PdVXKL8yIN5zbN0XmjAGjJHY8L6.png', 2000000, 'kuro', 'submitted', NULL, NULL, '2025-08-15 06:37:23', '2025-08-15 06:37:23'),
(5, 5, 6, 'payment_proofs/5/QIVJ9gPfk4TbDlRgW2nis7N8aWmH7erZNGnpuUz9.png', 2000000, NULL, 'accepted', 7, '2025-08-16 07:53:09', '2025-08-16 07:51:55', '2025-08-16 07:53:09'),
(6, 6, 6, 'payment_proofs/6/H9R0S0yHmEFcHMLLuX1bg3TZgxvPrunAobtk3dnT.jpg', 2000000, NULL, 'accepted', 7, '2025-08-16 19:33:49', '2025-08-16 19:32:46', '2025-08-16 19:33:49'),
(7, 7, 6, 'payment_proofs/7/Osd10ZeTSyws50dMtqtodKRlovzRO1hGYVXTIm8B.png', 2000000, NULL, 'submitted', NULL, NULL, '2025-08-18 09:02:29', '2025-08-18 09:02:29'),
(8, 8, 6, 'payment_proofs/8/cdWcGAJp6oSdHcXUhhHSg5GZHG17KRmQ1JNAb1j0.png', 2000000, 'KUROO', 'accepted', 7, '2025-08-20 06:19:34', '2025-08-20 06:18:19', '2025-08-20 06:19:34'),
(9, 9, 6, 'payment_proofs/9/pZzIZpE1Ux2du9wQINNjqSaZjXD7f5QkbnVuNTVN.png', 12000000, 'KUROW', 'accepted', 7, '2025-08-20 06:30:19', '2025-08-20 06:29:18', '2025-08-20 06:30:19'),
(10, 10, 6, 'payment_proofs/10/PaQGXnYDcQbAT8IRotKnSmt6FA2bmvr1CVoMNaEV.png', 4000000, 'KUROOO', 'accepted', 7, '2025-08-23 09:04:13', '2025-08-23 09:03:39', '2025-08-23 09:04:13'),
(11, 11, 6, 'payment_proofs/11/iz01TCsQCIXb4F9MsYObCWPQDhrNmppt7C3MZSfw.png', 13000000, 'KURO', 'accepted', 2, '2025-08-23 10:10:54', '2025-08-23 10:09:55', '2025-08-23 10:10:54'),
(12, 14, 10, 'payment_proofs/14/aRXHgo1Ah8ylML6nMIA4gqnrUyMQo9HYIBKpIwKS.jpg', 4000000, NULL, 'accepted', 7, '2025-08-27 16:16:07', '2025-08-27 16:15:30', '2025-08-27 16:16:07'),
(13, 16, 10, 'payment_proofs/16/GDlANJj5f96SyDbVQSbfWgFaO9IFtgPoH8R4yNvU.png', 120000000, NULL, 'accepted', 7, '2025-08-27 18:36:19', '2025-08-27 18:35:05', '2025-08-27 18:36:19'),
(14, 17, 10, 'payment_proofs/17/8JKdDDcrQk4Nmbmo4zKM7OjEF2D7fZdz9PBZBl4A.png', 125000000, NULL, 'accepted', 7, '2025-08-28 06:52:17', '2025-08-28 06:51:20', '2025-08-28 06:52:17'),
(15, 18, 10, 'payment_proofs/18/iZekrF5pUyyLia5k0aNnsxrfXa4pBQiKOkf6gVNH.png', 12000000, NULL, 'accepted', 7, '2025-08-28 07:00:51', '2025-08-28 07:00:13', '2025-08-28 07:00:51'),
(16, 15, 10, 'payment_proofs/15/Y64cQeoY7cDDPeeW4ck9QGfSZxas9RqilDNMmcmA.jpg', NULL, NULL, 'accepted', 7, '2025-08-28 07:06:17', '2025-08-28 07:05:50', '2025-08-28 07:06:17'),
(17, 20, 10, 'payment_proofs/20/87uBvPPeAMnqX4UbOVUBzKJe3Gb4CmHFhIgBpeHf.jpg', NULL, NULL, 'accepted', 7, '2025-08-28 18:01:49', '2025-08-28 18:01:02', '2025-08-28 18:01:49'),
(18, 25, 10, 'payment_proofs/25/ia6kSIor5TFmb6jdFxVz0OByOH39U1jCvOKZgQiG.jpg', NULL, NULL, 'accepted', 7, '2025-08-30 03:42:39', '2025-08-30 03:42:09', '2025-08-30 03:42:39'),
(19, 27, 10, 'payment_proofs/27/aKIXAejM9wVlSiz192QpnF4AhrT5JSnjpz6PmhNh.jpg', NULL, NULL, 'submitted', NULL, NULL, '2025-08-30 04:00:06', '2025-08-30 04:00:06'),
(20, 29, 10, 'payment_proofs/29/BKSLQ7jTrw9N69Qqb2OARn3727y0xVXmBgwGGtBb.png', NULL, NULL, 'accepted', 7, '2025-08-30 04:27:30', '2025-08-30 04:26:45', '2025-08-30 04:27:30'),
(21, 30, 10, 'payment_proofs/30/ksc4OuNNk8eBOPmxuaozaO037AvhNwRGTmDxjPD4.png', NULL, NULL, 'accepted', 7, '2025-08-30 04:31:52', '2025-08-30 04:31:16', '2025-08-30 04:31:52'),
(22, 31, 10, 'payment_proofs/31/G3bjT5QHvUuQPw2XsdbfthvTENKbtaTwg3q6IoUk.jpg', NULL, NULL, 'accepted', 7, '2025-08-30 04:36:13', '2025-08-30 04:35:41', '2025-08-30 04:36:13'),
(23, 32, 10, 'payment_proofs/32/bvMNB9Jf1KMPNQTIWhKjqptHMaWX0AK41LwjWJRK.jpg', NULL, NULL, 'accepted', 7, '2025-08-30 04:40:23', '2025-08-30 04:39:53', '2025-08-30 04:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `designer_id` bigint(20) UNSIGNED NOT NULL,
  `stars` tinyint(3) UNSIGNED NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `order_id`, `customer_id`, `designer_id`, `stars`, `review`, `created_at`, `updated_at`) VALUES
(1, 3, 4, 2, 5, 'Bagus', '2025-08-16 06:18:28', '2025-08-16 06:18:28'),
(2, 5, 4, 2, 5, 'bagus', '2025-08-16 07:56:36', '2025-08-16 07:56:36'),
(3, 8, 4, 2, 5, 'Bagus', '2025-08-20 06:24:06', '2025-08-20 06:24:06'),
(4, 16, 6, 2, 5, NULL, '2025-08-27 18:45:33', '2025-08-27 18:45:33'),
(5, 17, 6, 2, 5, 'bagus', '2025-08-28 06:56:49', '2025-08-28 06:56:49'),
(6, 20, 6, 2, 5, NULL, '2025-08-28 18:03:36', '2025-08-28 18:03:36'),
(7, 25, 6, 2, 5, NULL, '2025-08-30 03:44:31', '2025-08-30 03:44:31'),
(8, 29, 6, 2, 5, NULL, '2025-08-30 04:30:10', '2025-08-30 04:30:10'),
(9, 30, 6, 2, 5, NULL, '2025-08-30 04:33:14', '2025-08-30 04:33:14'),
(10, 32, 6, 2, 5, NULL, '2025-08-30 04:42:02', '2025-08-30 04:42:02');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'home_about_blurb', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to', '2025-08-26 01:08:28', '2025-08-26 02:37:29'),
(2, 'about_hero_title', 'About Jasikos', '2025-08-26 01:08:28', '2025-08-26 02:37:29'),
(3, 'about_hero_sub', 'a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their', '2025-08-26 01:08:28', '2025-08-26 02:37:29'),
(4, 'about_body_html', 'a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their', '2025-08-26 01:08:28', '2025-08-26 02:37:30'),
(5, 'about_service_1_t', 'five centuries, but', '2025-08-26 01:08:28', '2025-08-26 02:37:30'),
(6, 'about_service_1_d', 'A design catalog that can be purchased directly—convenient.', '2025-08-26 01:08:28', '2025-08-26 02:37:30'),
(7, 'about_service_2_t', 'Custom Requestt', '2025-08-26 01:08:28', '2025-08-26 01:14:59'),
(8, 'about_service_2_d', 'Design from your brief', '2025-08-26 01:08:28', '2025-08-26 02:37:30'),
(9, 'about_service_3_t', 'Production Supportt', '2025-08-26 01:08:28', '2025-08-26 01:14:59'),
(10, 'about_service_3_d', 'Final file with detailed description.', '2025-08-26 01:08:28', '2025-08-26 02:37:30'),
(11, 'about_stat_1_n', '150++', '2025-08-26 01:08:28', '2025-08-26 01:14:59'),
(12, 'about_stat_1_l', 'Project completed', '2025-08-26 01:08:28', '2025-08-26 02:37:30'),
(13, 'about_stat_2_n', '5/5', '2025-08-26 01:08:28', '2025-08-26 01:14:59'),
(14, 'about_stat_2_l', 'Average designer rating', '2025-08-26 01:08:28', '2025-08-26 02:37:30'),
(15, 'about_whatsapp', '62895626141738', '2025-08-26 01:08:28', '2025-08-26 01:08:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','designer','customer') NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `phone`, `avatar`, `whatsapp`, `last_login_at`) VALUES
(1, 'Admin Jasikos', 'admin@jasikos.test', NULL, '$2y$12$O1yR2OHCWvfUuuySVnlW1.Fu5iG1XHl7kmBcEZ3.qzTMUuwK/eYkq', 'admin', NULL, '2025-08-13 20:30:36', '2025-08-13 20:30:36', NULL, NULL, NULL, NULL),
(2, 'Designer Satu', 'designer@jasikos.test', NULL, '$2y$12$eJ/IZQXfc9c1QgfcJf.ws.t0KlQcUGi9VU51IBEXo5g04j0PJwbh2', 'designer', NULL, '2025-08-13 20:30:37', '2025-08-23 09:37:09', NULL, 'avatars/1ffBGQGG1KJzty3czM2TJa8VNaO3YcypWPWKbA42.png', '628111111111', NULL),
(3, 'Customer Satu', 'customer@jasikos.test', NULL, '$2y$12$E0aDAq4cSsnaZ2cdNLGJQ.NZwFYdBYVXYMjaoTmFDomI5Y8Y0bFSq', 'customer', NULL, '2025-08-13 20:30:37', '2025-08-13 20:30:37', NULL, NULL, '628122222222', NULL),
(4, 'hilman', 'hilman@example.com', NULL, '$2y$12$iGtpFBs.oKKqMlnBI41qA.nvh7mFdpPdNICtpVxnuBPPvq4HlMlGK', 'customer', NULL, '2025-08-13 21:06:25', '2025-08-17 20:53:26', '0895626141738', NULL, '62895626141738', NULL),
(5, 'annisa', 'annisa@example.com', NULL, '$2y$12$O2zuMx3UCmNroGEVY89mDOkoDu3wh3FzJ03AGcXJR2tH04Qu4/hja', 'customer', NULL, '2025-08-13 21:11:41', '2025-08-17 19:42:44', '0895626141738', NULL, '62895626141738', NULL),
(6, 'kuro', 'kuro@example.com', NULL, '$2y$12$4Wkrj30fmFYsNBvqwt356uIoCVYpDpwyDN1QvKzbmhUURB7ACilsK', 'customer', NULL, '2025-08-13 21:13:01', '2025-08-14 20:00:36', '0895626141738', 'avatars/EHARgMAjBzmAf04XBKfPmsGBKFXCvQ5QH0AOm4ZW.png', '6289562614771', NULL),
(7, 'supri', 'supri@example.com', NULL, '$2y$12$yaJ/i7TgfMICvJLcgw2ShupXuPZNMNszzzBVRfFEB.Mz8Spgpl.Fy', 'designer', NULL, '2025-08-13 21:17:23', '2025-08-21 05:19:51', NULL, 'avatars/ZBm4BcbsxXgvIknlqiHrJ7IU2Dxybfg9Oitx22eO.jpg', NULL, NULL),
(8, 'dodo', 'dodo@example.com', NULL, '$2y$12$ywzYWenjAXLHroEdx/L6HeE4GAgDgHLzWEjGjDkDgLZwuBBwQArVS', 'designer', NULL, '2025-08-14 07:05:12', '2025-08-14 07:05:12', NULL, NULL, NULL, NULL),
(9, 'hilman ardiansyah', 'hilmanardiansyah751@gmail.com', NULL, '$2y$12$oHumUO3P3FvqpAk6XowBsOYi9L.IGwPJqkUQUer4MJy4dNVWWx7We', 'customer', 'jcQ6D6CUenkZsap71euTAsIfoTsxVHtds7ZArWAGJqo4oW4taSYXBu7JzRaX', '2025-08-21 10:06:15', '2025-08-23 23:28:18', NULL, NULL, NULL, NULL),
(10, 'krucil', 'krucilhisa@gmail.com', NULL, '$2y$12$s6ewJQAQCviAzN9ZhIHyR.6RMgHt8cREX3nuf8YL3zWI9CM2Odrk6', 'customer', 'X18kKpdGLyPbKrL2FoxrEq6Dg8F4FRMg43G3E1hosm9IvnsAuZUxSHKVgiJD', '2025-08-27 15:54:25', '2025-08-27 16:13:20', '0895626141738', 'avatars/ttnCfwEssQZj9M2MTAOyC8IYPYhQGWWQhNRHEFxB.jpg', '08223456789', NULL),
(11, 'hilman', 'hilmanardian@gmail.com', NULL, '$2y$12$YZBxOqTls4U3MgO6GyDN/.ATwDbQWczcINEk3vNX10fylUtcnN5IG', 'designer', NULL, '2025-09-03 02:28:55', '2025-09-03 02:28:55', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_cart_id_design_id_unique` (`cart_id`,`design_id`),
  ADD KEY `cart_items_design_id_foreign` (`design_id`),
  ADD KEY `cart_items_designer_id_foreign` (`designer_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `category_design`
--
ALTER TABLE `category_design`
  ADD PRIMARY KEY (`design_id`,`category_id`),
  ADD KEY `category_design_category_id_foreign` (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_user_id_unique` (`user_id`);

--
-- Indexes for table `custom_requests`
--
ALTER TABLE `custom_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `custom_requests_code_unique` (`code`),
  ADD KEY `custom_requests_customer_id_foreign` (`customer_id`),
  ADD KEY `custom_requests_designer_id_foreign` (`designer_id`);

--
-- Indexes for table `custom_request_files`
--
ALTER TABLE `custom_request_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_request_files_custom_request_id_foreign` (`custom_request_id`);

--
-- Indexes for table `designers`
--
ALTER TABLE `designers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `designers_user_id_unique` (`user_id`);

--
-- Indexes for table `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `designs_slug_unique` (`slug`),
  ADD KEY `designs_designer_id_foreign` (`designer_id`);

--
-- Indexes for table `design_media`
--
ALTER TABLE `design_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `design_media_design_id_foreign` (`design_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_code_unique` (`code`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_designer_id_foreign` (`designer_id`);

--
-- Indexes for table `order_deliverables`
--
ALTER TABLE `order_deliverables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_deliverables_order_item_id_foreign` (`order_item_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_design_id_foreign` (`design_id`),
  ADD KEY `order_items_designer_id_foreign` (`designer_id`);

--
-- Indexes for table `order_status_logs`
--
ALTER TABLE `order_status_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_status_logs_order_id_foreign` (`order_id`),
  ADD KEY `order_status_logs_changed_by_foreign` (`changed_by`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_proofs`
--
ALTER TABLE `payment_proofs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_proofs_order_id_foreign` (`order_id`),
  ADD KEY `payment_proofs_uploader_id_foreign` (`uploader_id`),
  ADD KEY `payment_proofs_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ratings_order_id_unique` (`order_id`),
  ADD KEY `ratings_customer_id_foreign` (`customer_id`),
  ADD KEY `ratings_designer_id_foreign` (`designer_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `custom_requests`
--
ALTER TABLE `custom_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `custom_request_files`
--
ALTER TABLE `custom_request_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `designers`
--
ALTER TABLE `designers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `designs`
--
ALTER TABLE `designs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `design_media`
--
ALTER TABLE `design_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `order_deliverables`
--
ALTER TABLE `order_deliverables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `order_status_logs`
--
ALTER TABLE `order_status_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `payment_proofs`
--
ALTER TABLE `payment_proofs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_design_id_foreign` FOREIGN KEY (`design_id`) REFERENCES `designs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_designer_id_foreign` FOREIGN KEY (`designer_id`) REFERENCES `designers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_design`
--
ALTER TABLE `category_design`
  ADD CONSTRAINT `category_design_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_design_design_id_foreign` FOREIGN KEY (`design_id`) REFERENCES `designs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_requests`
--
ALTER TABLE `custom_requests`
  ADD CONSTRAINT `custom_requests_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_requests_designer_id_foreign` FOREIGN KEY (`designer_id`) REFERENCES `designers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_request_files`
--
ALTER TABLE `custom_request_files`
  ADD CONSTRAINT `custom_request_files_custom_request_id_foreign` FOREIGN KEY (`custom_request_id`) REFERENCES `custom_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `designers`
--
ALTER TABLE `designers`
  ADD CONSTRAINT `designers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `designs`
--
ALTER TABLE `designs`
  ADD CONSTRAINT `designs_designer_id_foreign` FOREIGN KEY (`designer_id`) REFERENCES `designers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `design_media`
--
ALTER TABLE `design_media`
  ADD CONSTRAINT `design_media_design_id_foreign` FOREIGN KEY (`design_id`) REFERENCES `designs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_designer_id_foreign` FOREIGN KEY (`designer_id`) REFERENCES `designers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_deliverables`
--
ALTER TABLE `order_deliverables`
  ADD CONSTRAINT `order_deliverables_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_design_id_foreign` FOREIGN KEY (`design_id`) REFERENCES `designs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_designer_id_foreign` FOREIGN KEY (`designer_id`) REFERENCES `designers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_status_logs`
--
ALTER TABLE `order_status_logs`
  ADD CONSTRAINT `order_status_logs_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_status_logs_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_proofs`
--
ALTER TABLE `payment_proofs`
  ADD CONSTRAINT `payment_proofs_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_proofs_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payment_proofs_uploader_id_foreign` FOREIGN KEY (`uploader_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_designer_id_foreign` FOREIGN KEY (`designer_id`) REFERENCES `designers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
