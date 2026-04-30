-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 12, 2025 at 11:56 AM
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
-- Database: `restaurant2`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesslog`
--

CREATE TABLE `accesslog` (
  `sl_no` bigint(20) NOT NULL,
  `action_page` varchar(50) DEFAULT NULL,
  `action_done` text DEFAULT NULL,
  `remarks` text NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `entry_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `accesslog`
--

INSERT INTO `accesslog` (`sl_no`, `action_page`, `action_done`, `remarks`, `user_name`, `entry_date`) VALUES
(1, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:41:53'),
(2, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:42:36'),
(3, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:43:05'),
(4, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:45:57'),
(5, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:47:50'),
(6, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:48:23'),
(7, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:48:52'),
(8, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:49:18'),
(9, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:49:38'),
(10, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:49:57'),
(11, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:50:16'),
(12, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:50:41'),
(13, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:51:03'),
(14, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:51:30'),
(15, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:51:47'),
(16, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:52:07'),
(17, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:52:32'),
(18, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:52:53'),
(19, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:53:09'),
(20, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:53:29'),
(21, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:53:46'),
(22, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:54:14'),
(23, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:54:36'),
(24, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:55:15'),
(25, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:55:30'),
(26, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:55:46'),
(27, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:56:02'),
(28, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:56:13'),
(29, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:56:30'),
(30, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:59:05'),
(31, 'Add Category', 'Insert Data', 'Category is Created', 'John Doe', '2025-10-30 20:59:29'),
(32, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-30 21:04:28'),
(33, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-30 21:19:47'),
(34, 'Kitchen List', 'Insert Data', 'New Kitchen Created', 'John Doe', '2025-10-30 21:20:53'),
(35, 'Kitchen List', 'Insert Data', 'New Kitchen Created', 'John Doe', '2025-10-30 21:21:03'),
(36, 'Kitchen List', 'Insert Data', 'New Kitchen Created', 'John Doe', '2025-10-30 21:21:10'),
(37, 'Kitchen List', 'Insert Data', 'New Kitchen Created', 'John Doe', '2025-10-30 21:21:17'),
(38, 'Kitchen List', 'Insert Data', 'New Kitchen Created', 'John Doe', '2025-10-30 21:21:24'),
(39, 'Kitchen List', 'Insert Data', 'New Kitchen Created', 'John Doe', '2025-10-30 21:21:31'),
(40, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 05:33:27'),
(41, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 05:35:11'),
(42, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 05:36:27'),
(43, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 05:37:29'),
(44, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 05:38:38'),
(45, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 05:39:14'),
(46, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 05:40:02'),
(47, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 05:40:40'),
(48, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 05:41:39'),
(49, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:44:35'),
(50, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:44:46'),
(51, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:44:59'),
(52, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:45:15'),
(53, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:45:32'),
(54, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:45:45'),
(55, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:45:55'),
(56, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:46:05'),
(57, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:46:15'),
(58, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:46:25'),
(59, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:46:38'),
(60, 'Add Add-ons', 'Insert Data', 'New Add-ons is Created', 'John Doe', '2025-10-31 05:46:52'),
(61, 'Add-ons Assign', 'Insert Data', 'Assign New Add-ons To Menu', 'John Doe', '2025-10-31 05:48:07'),
(62, 'Add-ons Assign', 'Insert Data', 'Assign New Add-ons To Menu', 'John Doe', '2025-10-31 05:48:29'),
(63, 'Add-ons Assign', 'Insert Data', 'Assign New Add-ons To Menu', 'John Doe', '2025-10-31 05:48:49'),
(64, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 11:51:42'),
(65, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 11:52:37'),
(66, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 11:53:03'),
(67, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 11:53:25'),
(68, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 12:01:40'),
(69, 'Food List', 'Update Data', 'Food Updated', 'John Doe', '2025-10-31 12:06:42'),
(70, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:08:22'),
(71, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:09:38'),
(72, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:11:19'),
(73, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:18'),
(74, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:22'),
(75, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:26'),
(76, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:30'),
(77, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:34'),
(78, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:37'),
(79, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:39'),
(80, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:41'),
(81, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:46'),
(82, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:48'),
(83, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:52'),
(84, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:25:54'),
(85, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:26:28'),
(86, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:26:30'),
(87, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:26:34'),
(88, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:26:36'),
(89, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:26:42'),
(90, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:26:44'),
(91, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:26:47'),
(92, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:26:49'),
(93, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:06'),
(94, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:08'),
(95, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:10'),
(96, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:12'),
(97, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:16'),
(98, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:20'),
(99, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:23'),
(100, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:27'),
(101, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:30'),
(102, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:33'),
(103, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:37'),
(104, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:40'),
(105, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:43'),
(106, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:46'),
(107, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:50'),
(108, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:55'),
(109, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:27:58'),
(110, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:28:02'),
(111, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:28:08'),
(112, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:28:12'),
(113, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:28:15'),
(114, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:28:19'),
(115, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:28:33'),
(116, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:28:37'),
(117, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:28:40'),
(118, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:28:43'),
(119, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 12:28:47'),
(120, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:29:40'),
(121, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:29:44'),
(122, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:29:47'),
(123, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:29:52'),
(124, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:29:55'),
(125, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:29:59'),
(126, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:03'),
(127, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:07'),
(128, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:11'),
(129, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:14'),
(130, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:18'),
(131, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:22'),
(132, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:28'),
(133, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:32'),
(134, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:35'),
(135, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:38'),
(136, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:41'),
(137, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:45'),
(138, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:48'),
(139, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:51'),
(140, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:54'),
(141, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:30:59'),
(142, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:31:02'),
(143, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:31:06'),
(144, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:31:09'),
(145, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:31:14'),
(146, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:31:19'),
(147, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:31:23'),
(148, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:31:26'),
(149, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:31:31'),
(150, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:31:34'),
(151, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:31:36'),
(152, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:31:40'),
(153, 'Food List', 'Delete Data', 'Food Deleted', 'John Doe', '2025-10-31 12:34:11'),
(154, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:35:49'),
(155, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:36:31'),
(156, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:37:35'),
(157, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:38:29'),
(158, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:39:03'),
(159, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:39:42'),
(160, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:40:26'),
(161, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:41:02'),
(162, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:41:35'),
(163, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:42:11'),
(164, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:42:46'),
(165, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:43:19'),
(166, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:43:53'),
(167, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:44:27'),
(168, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:44:59'),
(169, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:45:30'),
(170, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:46:03'),
(171, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:46:37'),
(172, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:47:50'),
(173, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:48:30'),
(174, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:49:00'),
(175, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:49:32'),
(176, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:50:29'),
(177, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:51:02'),
(178, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:51:50'),
(179, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:52:30'),
(180, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:53:00'),
(181, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:53:38'),
(182, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:54:11'),
(183, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:55:23'),
(184, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:55:54'),
(185, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 12:56:57'),
(186, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 12:59:18'),
(187, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 12:59:19'),
(188, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 12:59:54'),
(189, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 12:59:57'),
(190, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 13:00:02'),
(191, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 13:00:06'),
(192, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 13:00:10'),
(193, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 13:00:13'),
(194, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 13:00:17'),
(195, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 13:00:20'),
(196, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 13:00:23'),
(197, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 13:00:26'),
(198, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 13:00:29'),
(199, 'Varient List', 'Delete Data', 'Varient Deleted', 'John Doe', '2025-10-31 13:00:33'),
(200, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:01:42'),
(201, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:02:06'),
(202, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:02:39'),
(203, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:03:02'),
(204, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:03:25'),
(205, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:04:31'),
(206, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:04:56'),
(207, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:05:13'),
(208, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:05:32'),
(209, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:05:58'),
(210, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:06:14'),
(211, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:06:32'),
(212, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:06:48'),
(213, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:07:08'),
(214, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:07:24'),
(215, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:07:41'),
(216, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:07:57'),
(217, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:08:12'),
(218, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:08:29'),
(219, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:08:49'),
(220, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:09:23'),
(221, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:09:43'),
(222, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:10:04'),
(223, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:10:19'),
(224, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:10:33'),
(225, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:10:48'),
(226, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:11:14'),
(227, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:11:33'),
(228, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:11:55'),
(229, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:12:16'),
(230, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:12:33'),
(231, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:12:55'),
(232, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:13:24'),
(233, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:13:43'),
(234, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:14:00'),
(235, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:14:19'),
(236, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:14:39'),
(237, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:14:53'),
(238, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:15:18'),
(239, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:15:32'),
(240, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:15:55'),
(241, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:16:16'),
(242, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:16:30'),
(243, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:16:43'),
(244, 'Varient List', 'Insert Data', 'New Varient Created', 'John Doe', '2025-10-31 13:16:58'),
(245, 'Add Food', 'Insert Data', 'New Food Added', 'John Doe', '2025-10-31 21:43:08'),
(246, 'Kitchen List', 'Delete Data', 'Kitchen Deleted', 'John Doe', '2025-10-31 22:27:13'),
(247, 'Kitchen List', 'Delete Data', 'Kitchen Deleted', 'John Doe', '2025-10-31 22:27:18'),
(248, 'Kitchen List', 'Delete Data', 'Kitchen Deleted', 'John Doe', '2025-10-31 22:27:23'),
(249, 'Kitchen List', 'Delete Data', 'Kitchen Deleted', 'John Doe', '2025-10-31 22:27:27'),
(250, 'Kitchen List', 'Delete Data', 'Kitchen Deleted', 'John Doe', '2025-10-31 22:27:31'),
(251, 'Kitchen List', 'Delete Data', 'Kitchen Deleted', 'John Doe', '2025-10-31 22:27:35'),
(252, 'Kitchen List', 'Delete Data', 'Kitchen Deleted', 'John Doe', '2025-10-31 22:27:39'),
(253, 'Kitchen List', 'Delete Data', 'Kitchen Deleted', 'John Doe', '2025-10-31 22:27:43'),
(254, 'Kitchen List', 'Delete Data', 'Kitchen Deleted', 'John Doe', '2025-10-31 22:27:52'),
(255, 'Kitchen List', 'Delete Data', 'Kitchen Deleted', 'John Doe', '2025-10-31 22:27:58'),
(256, 'Kitchen List', 'Insert Data', 'New Kitchen Created', 'John Doe', '2025-10-31 22:28:13'),
(257, 'Currency List', 'Insert Data', 'New Currency Created', 'John Doe', '2025-10-31 22:31:43'),
(258, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-10-31 22:34:21'),
(259, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-10-31 22:34:40'),
(260, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-10-31 22:47:49'),
(261, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-10-31 23:30:21'),
(262, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-10-31 23:31:53'),
(263, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-10-31 23:31:58'),
(264, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-10-31 23:32:02'),
(265, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-10-31 23:32:11'),
(266, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 23:36:35'),
(267, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 23:36:39'),
(268, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 23:36:42'),
(269, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 23:36:47'),
(270, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 23:36:59'),
(271, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 23:37:04'),
(272, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 23:37:08'),
(273, 'Category List', 'Delete Data', 'Category Deleted', 'John Doe', '2025-10-31 23:37:12'),
(274, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 04:17:11'),
(275, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 12:38:34'),
(276, 'Country List', 'Insert Data', 'New Country Created', 'John Doe', '2025-11-01 12:57:08'),
(277, 'State List', 'Insert Data', 'New State Created', 'John Doe', '2025-11-01 12:58:00'),
(278, 'State List', 'Insert Data', 'New State Created', 'John Doe', '2025-11-01 12:58:11'),
(279, 'City List', 'Insert Data', 'New City Created', 'John Doe', '2025-11-01 12:58:28'),
(280, 'City List', 'Insert Data', 'New City Created', 'John Doe', '2025-11-01 12:58:39'),
(281, 'City List', 'Insert Data', 'New City Created', 'John Doe', '2025-11-01 12:58:50'),
(282, 'City List', 'Insert Data', 'New City Created', 'John Doe', '2025-11-01 12:59:12'),
(283, 'City List', 'Insert Data', 'New City Created', 'John Doe', '2025-11-01 12:59:19'),
(284, 'City List', 'Insert Data', 'New City Created', 'John Doe', '2025-11-01 12:59:57'),
(285, 'City List', 'Insert Data', 'New City Created', 'John Doe', '2025-11-01 13:00:06'),
(286, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 13:18:36'),
(287, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 13:18:48'),
(288, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 13:18:56'),
(289, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 13:21:09'),
(290, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 13:22:50'),
(291, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 13:26:44'),
(292, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 13:26:49'),
(293, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 13:26:55'),
(294, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 13:26:59'),
(295, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 13:32:51'),
(296, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 13:34:47'),
(297, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 13:35:23'),
(298, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 13:39:59'),
(299, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 13:46:27'),
(300, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 13:46:45'),
(301, 'Reservation List', 'Update Data', 'Reservation Updated', 'John Doe', '2025-11-01 13:53:24'),
(302, 'Reservation List', 'Update Data', 'Reservation Updated', 'John Doe', '2025-11-01 13:53:34'),
(303, 'Customer List', 'Update Data', 'Customer Updated', 'John Doe', '2025-11-01 13:56:21'),
(304, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:04:42'),
(305, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:05:25'),
(306, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:05:45'),
(307, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:07:03'),
(308, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:07:33'),
(309, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:08:10'),
(310, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:08:33'),
(311, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:11:10'),
(312, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:11:37'),
(313, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:14:20'),
(314, 'Table Floor List', 'Insert Data', 'New table Floor Created', 'John Doe', '2025-11-01 18:17:37'),
(315, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:41:07'),
(316, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:41:36'),
(317, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 18:41:52'),
(318, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 22:37:20'),
(319, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-01 22:37:27'),
(320, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 22:45:00'),
(321, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 22:45:08'),
(322, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-01 22:45:17'),
(323, 'Reservation unavailablity', 'Insert Data', 'New Reservation unavailablity Created', 'John Doe', '2025-11-02 12:42:37'),
(324, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-02 12:48:09'),
(325, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-02 12:48:16'),
(326, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-03 01:01:58'),
(327, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-03 01:02:07'),
(328, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-03 01:02:10'),
(329, 'Pending Order', 'Insert Data', 'Pending Order is Update', 'John Doe', '2025-11-03 01:10:49'),
(330, 'Supplier List', 'Insert Data', 'New Supplier Created', 'John Doe', '2025-11-03 13:21:03'),
(331, 'Pending Order', 'Insert Data', 'Pending Order is Update', 'John Doe', '2025-11-03 20:46:15'),
(332, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-03 20:48:09'),
(333, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-03 20:49:11'),
(334, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-03 20:58:33'),
(335, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-03 21:37:54'),
(336, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:40:59'),
(337, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:41:34'),
(338, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:42:02'),
(339, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:42:36'),
(340, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:42:36'),
(341, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:43:06'),
(342, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:43:29'),
(343, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:43:55'),
(344, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:44:14'),
(345, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:44:15'),
(346, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:44:46'),
(347, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:45:07'),
(348, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:45:26'),
(349, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:45:45'),
(350, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:46:05'),
(351, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:46:25'),
(352, 'Ingredient List', 'Insert Data', 'New Ingredient Created', 'John Doe', '2025-11-03 22:46:45'),
(353, 'Add Purchase', 'Insert Data', 'Item Purchase Created', 'John Doe', '2025-11-03 22:50:44'),
(354, 'set Production Unit', 'Insert Data', 'set Production Unit Created', 'John Doe', '2025-11-03 22:52:25'),
(355, 'Add Production', 'Insert Data', 'Add Production Created', 'John Doe', '2025-11-03 22:53:52'),
(356, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-07 22:01:52'),
(357, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-07 22:05:59'),
(358, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-07 22:06:10'),
(359, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-07 22:06:13'),
(360, 'Supplier List', 'Insert Data', 'New Supplier Created', 'John Doe', '2025-11-07 22:10:23'),
(361, 'Supplier List', 'Update Data', 'Supplier Updated', 'John Doe', '2025-11-07 22:10:42'),
(362, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-08 21:49:40'),
(363, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-08 21:50:59'),
(364, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-08 22:19:28'),
(365, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-08 22:20:09'),
(366, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-08 22:20:17'),
(367, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-08 22:20:25'),
(368, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-08 22:44:47'),
(369, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-08 22:45:10'),
(370, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-09 00:27:04'),
(371, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-09 00:53:53'),
(372, 'Pending Order', 'Insert Data', 'Pending Order is Update', 'John Doe', '2025-11-09 00:54:37'),
(373, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-09 00:56:02'),
(374, 'Pending Order', 'Insert Data', 'Pending Order is Update', 'John Doe', '2025-11-09 02:10:32'),
(375, 'Table List', 'Insert Data', 'New table Created', 'John Doe', '2025-11-09 03:38:02'),
(376, 'Table List', 'Insert Data', 'New table Created', 'John Doe', '2025-11-09 03:39:34'),
(377, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-09 04:54:58'),
(378, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-09 04:56:07'),
(379, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-09 20:51:03'),
(380, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-09 20:51:37'),
(381, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-09 20:56:04'),
(382, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-11 23:54:14'),
(383, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-11 23:54:25'),
(384, 'Add Customer', 'Insert Data', 'Customer is Created', 'John Doe', '2025-11-11 23:59:05'),
(385, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-11 23:59:37'),
(386, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 00:01:35'),
(387, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 00:01:40'),
(388, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:02:29'),
(389, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 00:03:26'),
(390, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:04:00'),
(391, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 00:06:27'),
(392, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:15:23'),
(393, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:22:14'),
(394, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:27:38'),
(395, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:28:10'),
(396, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:28:26'),
(397, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:28:50'),
(398, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:29:06'),
(399, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:33:44'),
(400, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:34:36'),
(401, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:35:25'),
(402, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:39:20'),
(403, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:39:43'),
(404, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:40:09'),
(405, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 00:41:39'),
(406, 'Pending Order', 'Insert Data', 'Pending Order is Update', 'John Doe', '2025-11-12 00:59:20'),
(407, 'Add New Order', 'Insert Data', 'Item New Order Created', 'John Doe', '2025-11-12 01:07:17'),
(408, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:34:30'),
(409, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:34:38'),
(410, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:34:47'),
(411, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:34:53'),
(412, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:34:57'),
(413, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:35:17'),
(414, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:35:22'),
(415, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:35:26'),
(416, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:35:31'),
(417, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:36:17'),
(418, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:36:23'),
(419, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:36:30'),
(420, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:36:34'),
(421, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:40:19'),
(422, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:40:27'),
(423, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:40:46'),
(424, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:40:50'),
(425, 'Order List', 'Insert Data', 'Order is Update', 'John Doe', '2025-11-12 01:40:54'),
(426, 'Pending Order', 'Insert Data', 'Pending Order is Update', 'John Doe', '2025-11-12 01:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `acc_account_name`
--

CREATE TABLE `acc_account_name` (
  `account_id` int(11) UNSIGNED NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `acc_account_name`
--

INSERT INTO `acc_account_name` (`account_id`, `account_name`, `account_type`) VALUES
(1, 'Employee Salary', 0),
(3, 'Example', 1),
(4, 'Loan Expense', 0),
(5, 'Loan Income', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acc_coa`
--

CREATE TABLE `acc_coa` (
  `HeadCode` varchar(50) NOT NULL,
  `HeadName` varchar(100) NOT NULL,
  `PHeadName` varchar(50) NOT NULL,
  `HeadLevel` int(11) NOT NULL,
  `IsActive` tinyint(1) NOT NULL,
  `IsTransaction` tinyint(1) NOT NULL,
  `IsGL` tinyint(1) NOT NULL,
  `HeadType` char(1) NOT NULL,
  `IsBudget` tinyint(1) NOT NULL,
  `IsDepreciation` tinyint(1) NOT NULL,
  `DepreciationRate` decimal(18,2) NOT NULL,
  `CreateBy` varchar(50) NOT NULL,
  `CreateDate` datetime NOT NULL,
  `UpdateBy` varchar(50) NOT NULL,
  `UpdateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acc_coa`
--

INSERT INTO `acc_coa` (`HeadCode`, `HeadName`, `PHeadName`, `HeadLevel`, `IsActive`, `IsTransaction`, `IsGL`, `HeadType`, `IsBudget`, `IsDepreciation`, `DepreciationRate`, `CreateBy`, `CreateDate`, `UpdateBy`, `UpdateDate`) VALUES
('502020000001', '145454-HmIsahaq', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2018-12-17 15:10:19', '', '0000-00-00 00:00:00'),
('4021403', 'AC', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:33:55', '', '0000-00-00 00:00:00'),
('50202', 'Account Payable', 'Current Liabilities', 2, 1, 0, 1, 'L', 0, 0, 0.00, 'admin', '2015-10-15 19:50:43', '', '0000-00-00 00:00:00'),
('10203', 'Account Receivable', 'Current Asset', 2, 1, 0, 0, 'A', 0, 0, 0.00, '', '0000-00-00 00:00:00', 'admin', '2013-09-18 15:29:35'),
('1020201', 'Advance', 'Advance, Deposit And Pre-payments', 3, 1, 0, 1, 'A', 0, 0, 0.00, 'Zoherul', '2015-05-31 13:29:12', 'admin', '2015-12-31 16:46:32'),
('102020103', 'Advance House Rent', 'Advance', 4, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-10-02 16:55:38', 'admin', '2016-10-02 16:57:32'),
('10202', 'Advance, Deposit And Pre-payments', 'Current Asset', 2, 1, 0, 0, 'A', 0, 0, 0.00, '', '0000-00-00 00:00:00', 'admin', '2015-12-31 16:46:24'),
('4020602', 'Advertisement and Publicity', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:51:44', '', '0000-00-00 00:00:00'),
('1010410', 'Air Cooler', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-05-23 12:13:55', '', '0000-00-00 00:00:00'),
('4020603', 'AIT Against Advertisement', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:52:09', '', '0000-00-00 00:00:00'),
('1', 'Assets', 'COA', 0, 1, 0, 0, 'A', 0, 0, 0.00, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('1010204', 'Attendance Machine', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:49:31', '', '0000-00-00 00:00:00'),
('40216', 'Audit Fee', 'Other Expenses', 2, 1, 1, 1, 'E', 0, 0, 0.00, 'admin', '2017-07-18 12:54:30', '', '0000-00-00 00:00:00'),
('4021002', 'Bank Charge', 'Financial Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:21:03', '', '0000-00-00 00:00:00'),
('30203', 'Bank Interest', 'Other Income', 2, 1, 1, 1, 'I', 0, 0, 0.00, 'Obaidul', '2015-01-03 14:49:54', 'admin', '2016-09-25 11:04:19'),
('1010104', 'Book Shelf', 'Furniture & Fixturers', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:46:11', '', '0000-00-00 00:00:00'),
('1010407', 'Books and Journal', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-03-27 10:45:37', '', '0000-00-00 00:00:00'),
('102010207', 'Brac Bank', 'Cash At Bank', 4, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-01-18 10:10:31', '', '0000-00-00 00:00:00'),
('4020604', 'Business Development Expenses', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:52:29', '', '0000-00-00 00:00:00'),
('4020606', 'Campaign Expenses', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:52:57', 'admin', '2016-09-19 14:52:48'),
('4020502', 'Campus Rent', 'House Rent', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:46:53', 'admin', '2017-04-27 17:02:39'),
('40212', 'Car Running Expenses', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:28:43', '', '0000-00-00 00:00:00'),
('10201', 'Cash & Cash Equivalent', 'Current Asset', 2, 1, 0, 1, 'A', 0, 0, 0.00, '', '0000-00-00 00:00:00', 'admin', '2015-10-15 15:57:55'),
('1020102', 'Cash At Bank', 'Cash & Cash Equivalent', 3, 1, 0, 0, 'A', 0, 0, 0.00, '2', '2018-07-19 13:43:59', 'admin', '2015-10-15 15:32:42'),
('1020101', 'Cash In Hand', 'Cash & Cash Equivalent', 3, 1, 1, 1, 'A', 0, 0, 0.00, '2', '2018-07-31 12:56:28', 'admin', '2016-05-23 12:05:43'),
('30101', 'Cash Sale', 'Store Income', 1, 1, 1, 1, 'I', 0, 0, 0.00, '2', '2018-07-08 07:51:26', '', '0000-00-00 00:00:00'),
('1010207', 'CCTV', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:51:24', '', '0000-00-00 00:00:00'),
('102020102', 'CEO Current A/C', 'Advance', 4, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-09-25 11:54:54', '', '0000-00-00 00:00:00'),
('102010206', 'City Bank', 'Cash At Bank', 4, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-01-18 10:09:32', '', '0000-00-00 00:00:00'),
('1010101', 'Class Room Chair', 'Furniture & Fixturers', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:45:29', '', '0000-00-00 00:00:00'),
('4021407', 'Close Circuit Cemera', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:35:35', '', '0000-00-00 00:00:00'),
('4020601', 'Commision on Admission', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:51:21', 'admin', '2016-09-19 14:42:54'),
('1010206', 'Computer', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:51:09', '', '0000-00-00 00:00:00'),
('4021410', 'Computer (R)', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'Zoherul', '2016-03-24 12:38:52', 'Zoherul', '2016-03-24 12:41:40'),
('1010102', 'Computer Table', 'Furniture & Fixturers', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:45:44', '', '0000-00-00 00:00:00'),
('301020401', 'Continuing Registration fee - UoL (Income)', 'Registration Fee (UOL) Income', 4, 1, 1, 0, 'I', 0, 0, 0.00, 'admin', '2015-10-15 17:40:40', '', '0000-00-00 00:00:00'),
('4020904', 'Contratuall Staff Salary', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:12:34', '', '0000-00-00 00:00:00'),
('403', 'Cost of Sale', 'Expence', 0, 1, 1, 0, 'E', 0, 0, 0.00, '2', '2018-07-08 10:37:16', '', '0000-00-00 00:00:00'),
('30102', 'Credit Sale', 'Store Income', 1, 1, 1, 1, 'I', 0, 0, 0.00, '2', '2018-07-08 07:51:34', '', '0000-00-00 00:00:00'),
('4020709', 'Cultural Expense', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'nasmud', '2017-04-29 12:45:10', '', '0000-00-00 00:00:00'),
('102', 'Current Asset', 'Assets', 1, 1, 0, 0, 'A', 0, 0, 0.00, '2', '2018-12-06 13:54:42', 'admin', '2018-07-07 11:23:00'),
('502', 'Current Liabilities', 'Liabilities', 1, 1, 0, 0, 'L', 0, 0, 0.00, 'anwarul', '2014-08-30 13:18:20', 'admin', '2015-10-15 19:49:21'),
('102030101', 'cusL-0001-Walkin', 'Customer Receivable', 4, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2019-01-08 09:14:48', '', '2020-11-17 11:41:07'),
('102030108', 'cusL-0002-joeldytsina', 'Customer Receivable', 4, 1, 1, 0, 'A', 0, 0, 0.00, '34', '2025-09-30 03:50:17', '', '0000-00-00 00:00:00'),
('102030109', 'cusL-0003-joeldytsina242@gmail.com', 'Customer Receivable', 4, 1, 1, 0, 'A', 0, 0, 0.00, '35', '2025-09-30 04:34:50', '', '0000-00-00 00:00:00'),
('102030110', 'cusL-0004-test', 'Customer Receivable', 4, 1, 1, 0, 'A', 0, 0, 0.00, '36', '2025-09-30 17:06:11', '', '0000-00-00 00:00:00'),
('102030111', 'cusL-0005-waiter', 'Customer Receivable', 4, 1, 1, 0, 'A', 0, 0, 0.00, '37', '2025-10-02 01:34:36', '', '0000-00-00 00:00:00'),
('102030112', 'cusL-0006-zédxz', 'Customer Receivable', 4, 1, 1, 0, 'A', 0, 0, 0.00, '177', '2025-10-03 09:09:02', '', '0000-00-00 00:00:00'),
('102030113', 'cusL-0007-sin', 'Customer Receivable', 4, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2025-10-11 14:26:17', '', '0000-00-00 00:00:00'),
('102030104', 'cusL-0018-jamildasd', 'Customer Receivable', 4, 1, 1, 0, 'A', 0, 0, 0.00, '20', '2021-01-05 14:14:11', '', '0000-00-00 00:00:00'),
('102030105', 'cusL-0021-jamil', 'Customer Receivable', 4, 1, 1, 0, 'A', 0, 0, 0.00, '25', '2021-01-31 14:17:07', '', '0000-00-00 00:00:00'),
('102030106', 'cusL-0022-Saiful Hassan', 'Customer Receivable', 4, 1, 1, 0, 'A', 0, 0, 0.00, '26', '2021-01-31 18:18:33', '', '0000-00-00 00:00:00'),
('102030107', 'cusL-0023-jamil', 'Customer Receivable', 4, 1, 1, 0, 'A', 0, 0, 0.00, '27', '2021-02-03 10:12:50', '', '0000-00-00 00:00:00'),
('1020301', 'Customer Receivable', 'Account Receivable', 3, 1, 0, 1, 'A', 0, 0, 0.00, '2', '2019-01-08 09:15:08', 'admin', '2018-07-07 12:31:42'),
('40100002', 'cw-Chichawatni', 'Store Expenses', 2, 1, 1, 0, 'E', 0, 0, 0.00, '2', '2018-08-02 16:30:41', '', '0000-00-00 00:00:00'),
('1020202', 'Deposit', 'Advance, Deposit And Pre-payments', 3, 1, 0, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:40:42', '', '0000-00-00 00:00:00'),
('4020605', 'Design & Printing Expense', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:55:00', '', '0000-00-00 00:00:00'),
('4020404', 'Dish Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:58:21', '', '0000-00-00 00:00:00'),
('40215', 'Dividend', 'Other Expenses', 2, 1, 1, 1, 'E', 0, 0, 0.00, 'admin', '2016-09-25 14:07:55', '', '0000-00-00 00:00:00'),
('4020403', 'Drinking Water Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:58:10', '', '0000-00-00 00:00:00'),
('1010211', 'DSLR Camera', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:53:17', 'admin', '2016-01-02 16:23:25'),
('102010205', 'Dutch-Bangla Bank', 'Cash At Bank', 4, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-01-18 09:49:13', '', '0000-00-00 00:00:00'),
('502020000007', 'E3Y1WJMB-John Maria', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2019-01-27 05:55:58', '', '0000-00-00 00:00:00'),
('502020000010', 'E4Y91CAX-onlineorder', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2019-02-03 11:20:44', '', '0000-00-00 00:00:00'),
('502020000004', 'E97E9SJT-joeldy simon', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2019-01-09 14:32:22', '', '0000-00-00 00:00:00'),
('4020908', 'Earned Leave', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:13:38', '', '0000-00-00 00:00:00'),
('502020000006', 'EBK2UPRA-John Carlos', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2019-01-27 05:51:09', '', '0000-00-00 00:00:00'),
('4020607', 'Education Fair Expenses', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:53:42', '', '0000-00-00 00:00:00'),
('502020000011', 'EK9BYZVY-test sdafdssdfds', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2019-02-24 14:07:53', '', '0000-00-00 00:00:00'),
('1010602', 'Electric Equipment', 'Electrical Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-03-27 10:44:51', '', '0000-00-00 00:00:00'),
('1010203', 'Electric Kettle', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:49:07', '', '0000-00-00 00:00:00'),
('10106', 'Electrical Equipment', 'Non Current Assets', 2, 1, 0, 1, 'A', 0, 0, 0.00, 'admin', '2016-03-27 10:43:44', '', '0000-00-00 00:00:00'),
('4020407', 'Electricity Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:59:31', '', '0000-00-00 00:00:00'),
('10202010501', 'employ', 'Salary', 5, 1, 0, 0, 'A', 0, 0, 0.00, 'admin', '2018-07-05 11:47:10', '', '0000-00-00 00:00:00'),
('405', 'Entertainment', 'Expense', 1, 1, 1, 0, 'E', 1, 1, 1.00, '2', '2020-01-18 07:49:00', '', '0000-00-00 00:00:00'),
('502020000012', 'ENVBUZKE-kabirkhan', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2020-10-12 10:57:33', '', '0000-00-00 00:00:00'),
('502020000002', 'EQLAJFUW-johndoe', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2018-12-17 15:08:43', '', '0000-00-00 00:00:00'),
('2', 'Equity', 'COA', 0, 1, 0, 0, 'L', 0, 0, 0.00, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('502020000009', 'EU3APTYY-JohnDoe', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2019-01-27 06:02:46', '', '0000-00-00 00:00:00'),
('502020000005', 'EW9PM201-test emp', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2019-01-09 14:38:15', '', '0000-00-00 00:00:00'),
('502020000008', 'EXL9WSCL-Mitchel Santner', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2019-01-27 05:58:55', '', '0000-00-00 00:00:00'),
('4', 'Expense', 'COA', 0, 1, 0, 0, 'E', 0, 0, 0.00, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('502020000003', 'EY2T1OWA-jahangirAhmad', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'John Doe', '2018-12-17 15:11:13', '', '0000-00-00 00:00:00'),
('4020903', 'Faculty,Staff Salary & Allowances', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:12:21', '', '0000-00-00 00:00:00'),
('4021404', 'Fax Machine', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:34:15', '', '0000-00-00 00:00:00'),
('4020905', 'Festival & Incentive Bonus', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:12:48', '', '0000-00-00 00:00:00'),
('1010103', 'File Cabinet', 'Furniture & Fixturers', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:46:02', '', '0000-00-00 00:00:00'),
('40210', 'Financial Expenses', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, 0.00, 'anwarul', '2013-08-20 12:24:31', 'admin', '2015-10-15 19:20:36'),
('1010403', 'Fire Extingushier', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-03-27 10:39:32', '', '0000-00-00 00:00:00'),
('4021408', 'Furniture', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:35:47', '', '0000-00-00 00:00:00'),
('10101', 'Furniture & Fixturers', 'Non Current Assets', 2, 1, 0, 1, 'A', 0, 0, 0.00, 'anwarul', '2013-08-20 16:18:15', 'anwarul', '2013-08-21 13:35:40'),
('4020406', 'Gas Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:59:20', '', '0000-00-00 00:00:00'),
('20201', 'General Reserve', 'Reserve & Surplus', 2, 1, 1, 0, 'L', 0, 0, 0.00, 'admin', '2016-09-25 14:07:12', 'admin', '2016-10-02 17:48:49'),
('10105', 'Generator', 'Non Current Assets', 2, 1, 1, 1, 'A', 0, 0, 0.00, 'Zoherul', '2016-02-27 16:02:35', 'admin', '2016-05-23 12:05:18'),
('4021414', 'Generator Repair', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'Zoherul', '2016-06-16 10:21:05', '', '0000-00-00 00:00:00'),
('40213', 'Generator Running Expenses', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:29:29', '', '0000-00-00 00:00:00'),
('10103', 'Groceries and Cutleries', 'Non Current Assets', 2, 1, 1, 1, 'A', 0, 0, 0.00, '2', '2018-07-12 10:02:55', '', '0000-00-00 00:00:00'),
('1010408', 'Gym Equipment', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-03-27 10:46:03', '', '0000-00-00 00:00:00'),
('4020907', 'Honorarium', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:13:26', '', '0000-00-00 00:00:00'),
('40205', 'House Rent', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, 0.00, 'anwarul', '2013-08-24 10:26:56', '', '0000-00-00 00:00:00'),
('40100001', 'HP-Hasilpur', 'Academic Expenses', 2, 1, 1, 0, 'E', 0, 0, 0.00, '2', '2018-07-29 03:44:23', '', '0000-00-00 00:00:00'),
('4020702', 'HR Recruitment Expenses', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2016-09-25 12:55:49', '', '0000-00-00 00:00:00'),
('4020703', 'Incentive on Admission', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2016-09-25 12:56:09', '', '0000-00-00 00:00:00'),
('3', 'Income', 'COA', 0, 1, 0, 0, 'I', 0, 0, 0.00, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('5020302', 'Income Tax Payable', 'Liabilities for Expenses', 3, 1, 0, 1, 'L', 0, 0, 0.00, 'admin', '2016-09-19 11:18:17', 'admin', '2016-09-28 13:18:35'),
('102020302', 'Insurance Premium', 'Prepayment', 4, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-09-19 13:10:57', '', '0000-00-00 00:00:00'),
('4021001', 'Interest on Loan', 'Financial Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:20:53', 'admin', '2016-09-19 14:53:34'),
('4020401', 'Internet Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:56:55', 'admin', '2015-10-15 18:57:32'),
('10107', 'Inventory', 'Non Current Assets', 1, 1, 0, 0, 'A', 0, 0, 0.00, '2', '2018-07-07 15:21:58', '', '0000-00-00 00:00:00'),
('102010309', 'iyzico', 'Online Payment', 2, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-10-18 14:32:35', '', '0000-00-00 00:00:00'),
('10205010101', 'Jahangir', 'Hasan', 1, 1, 0, 0, 'A', 0, 0, 0.00, '2', '2018-07-07 10:40:56', '', '0000-00-00 00:00:00'),
('1010210', 'LCD TV', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:52:27', '', '0000-00-00 00:00:00'),
('30103', 'Lease Sale', 'Store Income', 1, 1, 1, 1, 'I', 0, 0, 0.00, '2', '2018-07-08 07:51:52', '', '0000-00-00 00:00:00'),
('5', 'Liabilities', 'COA', 0, 1, 0, 0, 'L', 0, 0, 0.00, 'admin', '2013-07-04 12:32:07', 'admin', '2015-10-15 19:46:54'),
('50203', 'Liabilities for Expenses', 'Current Liabilities', 2, 1, 0, 0, 'L', 0, 0, 0.00, 'admin', '2015-10-15 19:50:59', '', '0000-00-00 00:00:00'),
('4020707', 'Library Expenses', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2017-01-10 15:34:54', '', '0000-00-00 00:00:00'),
('4021409', 'Lift', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:36:12', '', '0000-00-00 00:00:00'),
('50101', 'Long Term Borrowing', 'Non Current Liabilities', 2, 1, 0, 1, 'L', 0, 0, 0.00, 'admin', '2013-07-04 12:32:26', 'admin', '2015-10-15 19:47:40'),
('4020608', 'Marketing & Promotion Exp.', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:53:59', '', '0000-00-00 00:00:00'),
('4020901', 'Medical Allowance', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:11:33', '', '0000-00-00 00:00:00'),
('1010411', 'Metal Ditector', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'Zoherul', '2016-08-22 10:55:22', '', '0000-00-00 00:00:00'),
('4021413', 'Micro Oven', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'Zoherul', '2016-05-12 14:53:51', '', '0000-00-00 00:00:00'),
('30202', 'Miscellaneous (Income)', 'Other Income', 2, 1, 1, 1, 'I', 0, 0, 0.00, 'anwarul', '2014-02-06 15:26:31', 'admin', '2016-09-25 11:04:35'),
('4020909', 'Miscellaneous Benifit', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:13:53', '', '0000-00-00 00:00:00'),
('4020701', 'Miscellaneous Exp', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2016-09-25 12:54:39', '', '0000-00-00 00:00:00'),
('40207', 'Miscellaneous Expenses', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, 0.00, 'anwarul', '2014-04-26 16:49:56', 'admin', '2016-09-25 12:54:19'),
('1010401', 'Mobile Phone', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-01-29 10:43:30', '', '0000-00-00 00:00:00'),
('102020101', 'Mr Ashiqur Rahman', 'Advance', 4, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-12-31 16:47:23', 'admin', '2016-09-25 11:55:13'),
('1010212', 'Network Accessories', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-01-02 16:23:32', '', '0000-00-00 00:00:00'),
('102020106', 'new head dfhgfh', 'Advance', 3, 1, 0, 0, 'A', 0, 0, 0.00, '2', '2020-01-16 06:25:10', '', '0000-00-00 00:00:00'),
('4020408', 'News Paper Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2016-01-02 15:55:57', '', '0000-00-00 00:00:00'),
('101', 'Non Current Assets', 'Assets', 1, 1, 0, 0, 'A', 0, 0, 0.00, '', '0000-00-00 00:00:00', 'admin', '2015-10-15 15:29:11'),
('501', 'Non Current Liabilities', 'Liabilities', 1, 1, 0, 0, 'L', 0, 0, 0.00, 'anwarul', '2014-08-30 13:18:20', 'admin', '2015-10-15 19:49:21'),
('406', 'Office Accessories', 'Expense', 1, 1, 1, 0, 'E', 1, 1, 1.00, '2', '2020-01-18 07:51:32', '', '0000-00-00 00:00:00'),
('1010404', 'Office Decoration', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-03-27 10:40:02', '', '0000-00-00 00:00:00'),
('10102', 'Office Equipment', 'Non Current Assets', 2, 1, 0, 1, 'A', 0, 0, 0.00, 'anwarul', '2013-12-06 18:08:00', 'admin', '2015-10-15 15:48:21'),
('4021401', 'Office Repair & Maintenance', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:33:15', '', '0000-00-00 00:00:00'),
('30201', 'Office Stationary (Income)', 'Other Income', 2, 1, 1, 1, 'I', 0, 0, 0.00, 'anwarul', '2013-07-17 15:21:06', 'admin', '2016-09-25 11:04:50'),
('1020103', 'Online Payment', 'Cash & Cash Equivalent', 2, 1, 0, 1, 'A', 0, 0, 0.00, '2', '2020-10-18 14:26:41', '', '0000-00-00 00:00:00'),
('102010308', 'Orange Money payment', 'Online Payment', 2, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-10-18 14:32:11', '', '0000-00-00 00:00:00'),
('402', 'Other Expenses', 'Expense', 1, 1, 0, 0, 'E', 0, 0, 0.00, '2', '2018-07-07 14:00:16', 'admin', '2015-10-15 18:37:42'),
('302', 'Other Income', 'Income', 1, 1, 0, 0, 'I', 0, 0, 0.00, '2', '2018-07-07 13:40:57', 'admin', '2016-09-25 11:04:09'),
('40211', 'Others (Non Academic Expenses)', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, 0.00, 'Obaidul', '2014-12-03 16:05:42', 'admin', '2015-10-15 19:22:09'),
('30205', 'Others (Non-Academic Income)', 'Other Income', 2, 1, 0, 1, 'I', 0, 0, 0.00, 'admin', '2015-10-15 17:23:49', 'admin', '2015-10-15 17:57:52'),
('10104', 'Others Assets', 'Non Current Assets', 2, 1, 0, 1, 'A', 0, 0, 0.00, 'admin', '2016-01-29 10:43:16', '', '0000-00-00 00:00:00'),
('4020910', 'Outstanding Salary', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'Zoherul', '2016-04-24 11:56:50', '', '0000-00-00 00:00:00'),
('4021405', 'Oven', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:34:31', '', '0000-00-00 00:00:00'),
('4021412', 'PABX-Repair', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'Zoherul', '2016-04-24 14:40:18', '', '0000-00-00 00:00:00'),
('4020902', 'Part-time Staff Salary', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:12:06', '', '0000-00-00 00:00:00'),
('102010301', 'Paypal', 'Online Payment', 2, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-10-18 14:27:41', '', '0000-00-00 00:00:00'),
('102010306', 'Paystack Payments', 'Online Payment', 2, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-10-18 14:30:55', '', '0000-00-00 00:00:00'),
('102010307', 'Paytm Payments', 'Online Payment', 2, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-10-18 14:31:23', '', '0000-00-00 00:00:00'),
('1010202', 'Photocopy & Fax Machine', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:47:27', 'admin', '2016-05-23 12:14:40'),
('4021411', 'Photocopy Machine Repair', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'Zoherul', '2016-04-24 12:40:02', 'admin', '2017-04-27 17:03:17'),
('3020503', 'Practical Fee', 'Others (Non-Academic Income)', 3, 1, 1, 1, 'I', 0, 0, 0.00, 'admin', '2017-07-22 18:00:37', '', '0000-00-00 00:00:00'),
('1020203', 'Prepayment', 'Advance, Deposit And Pre-payments', 3, 1, 0, 1, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:40:51', 'admin', '2015-12-31 16:49:58'),
('1010201', 'Printer', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:47:15', '', '0000-00-00 00:00:00'),
('407', 'Product Purchase', 'Expense', 0, 1, 0, 0, 'E', 0, 0, 0.00, '2', '2020-01-23 07:09:10', '', '0000-00-00 00:00:00'),
('3020502', 'Professional Training Course(Oracal-1)', 'Others (Non-Academic Income)', 3, 1, 1, 0, 'I', 0, 0, 0.00, 'nasim', '2017-06-22 13:28:05', '', '0000-00-00 00:00:00'),
('30207', 'Professional Training Course(Oracal)', 'Other Income', 2, 1, 0, 1, 'I', 0, 0, 0.00, 'nasim', '2017-06-22 13:24:16', 'nasim', '2017-06-22 13:25:56'),
('1010208', 'Projector', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:51:44', '', '0000-00-00 00:00:00'),
('40206', 'Promonational Expense', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, 0.00, 'anwarul', '2013-07-11 13:48:57', 'anwarul', '2013-07-17 14:23:03'),
('40214', 'Repair and Maintenance', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:32:46', '', '0000-00-00 00:00:00'),
('202', 'Reserve & Surplus', 'Equity', 1, 1, 0, 1, 'L', 0, 0, 0.00, 'admin', '2016-09-25 14:06:34', 'admin', '2016-10-02 17:48:57'),
('20102', 'Retained Earnings', 'Share Holders Equity', 2, 1, 1, 1, 'L', 0, 0, 0.00, 'admin', '2016-05-23 11:20:40', 'admin', '2016-09-25 14:05:06'),
('4020708', 'River Cruse', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2017-04-24 15:35:25', '', '0000-00-00 00:00:00'),
('102010311', 'RMA PAYMENT GATEWAY', 'Online Payment', 2, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-10-18 14:33:12', '', '0000-00-00 00:00:00'),
('102020105', 'Salary', 'Advance', 4, 1, 0, 0, 'A', 0, 0, 0.00, 'admin', '2018-07-05 11:46:44', '', '0000-00-00 00:00:00'),
('40209', 'Salary & Allowances', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, 0.00, 'anwarul', '2013-12-12 11:22:58', '', '0000-00-00 00:00:00'),
('404', 'Sale Discount', 'Expense', 1, 1, 1, 0, 'E', 0, 0, 0.00, '2', '2018-07-19 10:15:11', '', '0000-00-00 00:00:00'),
('303', 'Sale Income', 'Income', 0, 1, 1, 1, 'I', 0, 0, 0.00, '2', '2020-01-23 06:58:20', '', '0000-00-00 00:00:00'),
('1010406', 'Security Equipment', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-03-27 10:41:30', '', '0000-00-00 00:00:00'),
('30104', 'Service Charge Income', 'Store Income', 1, 1, 1, 0, 'I', 0, 0, 0.00, '2', '2020-12-30 11:23:32', '', '0000-00-00 00:00:00'),
('20101', 'Share Capital', 'Share Holders Equity', 2, 1, 0, 1, 'L', 0, 0, 0.00, 'anwarul', '2013-12-08 19:37:32', 'admin', '2015-10-15 19:45:35'),
('201', 'Share Holders Equity', 'Equity', 1, 1, 0, 0, 'L', 0, 0, 0.00, '', '0000-00-00 00:00:00', 'admin', '2015-10-15 19:43:51'),
('50201', 'Short Term Borrowing', 'Current Liabilities', 2, 1, 0, 1, 'L', 0, 0, 0.00, 'admin', '2015-10-15 19:50:30', '', '0000-00-00 00:00:00'),
('102010310', 'SIPS Office', 'Online Payment', 2, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-10-18 14:32:54', '', '0000-00-00 00:00:00'),
('4020906', 'Special Allowances', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:13:13', '', '0000-00-00 00:00:00'),
('50102', 'Sponsors Loan', 'Non Current Liabilities', 2, 1, 0, 1, 'L', 0, 0, 0.00, 'admin', '2015-10-15 19:48:02', '', '0000-00-00 00:00:00'),
('4020706', 'Sports Expense', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'nasmud', '2016-11-09 13:16:53', '', '0000-00-00 00:00:00'),
('102010304', 'Square Payments', 'Online Payment', 2, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-10-18 14:29:32', '', '0000-00-00 00:00:00'),
('102010302', 'SSLCommerz', 'Online Payment', 2, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-10-18 14:28:06', '', '0000-00-00 00:00:00'),
('401', 'Store Expenses', 'Expense', 1, 1, 0, 0, 'E', 0, 0, 0.00, '2', '2018-07-07 13:38:59', 'admin', '2015-10-15 17:58:46'),
('301', 'Store Income', 'Income', 1, 1, 0, 0, 'I', 0, 0, 0.00, '2', '2018-07-07 13:40:37', 'admin', '2015-09-17 17:00:02'),
('102010305', 'Stripe Payment', 'Online Payment', 2, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-10-18 14:29:59', '', '0000-00-00 00:00:00'),
('3020501', 'Students Info. Correction Fee', 'Others (Non-Academic Income)', 3, 1, 1, 0, 'I', 0, 0, 0.00, 'admin', '2015-10-15 17:24:45', '', '0000-00-00 00:00:00'),
('1010601', 'Sub Station', 'Electrical Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-03-27 10:44:11', '', '0000-00-00 00:00:00'),
('502020501', 'sup_002-Kamal Hossain', 'Suppliers', 4, 1, 1, 0, 'L', 0, 0, 0.00, '2', '2020-01-18 10:49:49', '', '0000-00-00 00:00:00'),
('502020504', 'sup_002-Supplier_1', 'Suppliers', 4, 1, 1, 0, 'L', 0, 0, 0.00, '2', '2020-09-08 14:26:40', '', '0000-00-00 00:00:00'),
('502020505', 'sup_003-joeldy', 'Suppliers', 4, 1, 1, 0, 'L', 0, 0, 0.00, '2', '2025-10-03 18:23:11', '', '0000-00-00 00:00:00'),
('502020502', 'sup_003-Maruf', 'Suppliers', 4, 1, 1, 0, 'L', 0, 0, 0.00, '2', '2020-01-18 10:56:31', '', '0000-00-00 00:00:00'),
('502020503', 'sup_004-Saiful', 'Suppliers', 4, 1, 1, 0, 'L', 0, 0, 0.00, '2', '2020-01-18 10:57:04', '2', '2020-01-21 13:10:59'),
('5020205', 'Suppliers', 'Account Payable', 3, 1, 0, 1, 'L', 0, 0, 0.00, '2', '2018-12-15 06:50:12', '', '0000-00-00 00:00:00'),
('4020704', 'TB Care Expenses', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2016-10-08 13:03:04', '', '0000-00-00 00:00:00'),
('4020501', 'TDS on House Rent', 'House Rent', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:44:07', 'admin', '2016-09-19 14:40:16'),
('502030201', 'TDS Payable House Rent', 'Income Tax Payable', 4, 1, 1, 0, 'L', 0, 0, 0.00, 'admin', '2016-09-19 11:19:42', 'admin', '2016-09-28 13:19:37'),
('502030203', 'TDS Payable on Advertisement Bill', 'Income Tax Payable', 4, 1, 1, 0, 'L', 0, 0, 0.00, 'admin', '2016-09-28 13:20:51', '', '0000-00-00 00:00:00'),
('502030202', 'TDS Payable on Salary', 'Income Tax Payable', 4, 1, 1, 0, 'L', 0, 0, 0.00, 'admin', '2016-09-28 13:20:17', '', '0000-00-00 00:00:00'),
('4021402', 'Tea Kettle', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:33:45', '', '0000-00-00 00:00:00'),
('4020402', 'Telephone Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:57:59', '', '0000-00-00 00:00:00'),
('1010209', 'Telephone Set & PABX', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:51:57', 'admin', '2016-10-02 17:10:40'),
('102020104', 'Test', 'Advance', 4, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2018-07-05 11:42:48', '', '0000-00-00 00:00:00'),
('40203', 'Travelling & Conveyance', 'Other Expenses', 2, 1, 1, 1, 'E', 0, 0, 0.00, 'admin', '2013-07-08 16:22:06', 'admin', '2015-10-15 18:45:13'),
('4021406', 'TV', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 19:35:07', '', '0000-00-00 00:00:00'),
('102010303', 'Two Checkout', 'Online Payment', 2, 1, 1, 0, 'A', 0, 0, 0.00, '2', '2020-10-18 14:28:29', '', '0000-00-00 00:00:00'),
('1010205', 'UPS', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:50:38', '', '0000-00-00 00:00:00'),
('40204', 'Utility Expenses', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, 0.00, 'anwarul', '2013-07-11 16:20:24', 'admin', '2016-01-02 15:55:22'),
('4020503', 'VAT on House Rent Exp', 'House Rent', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:49:22', 'admin', '2016-09-25 14:00:52'),
('5020301', 'VAT Payable', 'Liabilities for Expenses', 3, 1, 0, 1, 'L', 0, 0, 0.00, 'admin', '2015-10-15 19:51:11', 'admin', '2016-09-28 13:23:53'),
('502030101', 'VAT- TAX', 'VAT Payable', 3, 1, 1, 0, 'L', 0, 0, 0.00, '2', '2020-12-30 10:58:49', '', '0000-00-00 00:00:00'),
('1010409', 'Vehicle A/C', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'Zoherul', '2016-05-12 12:13:21', '', '0000-00-00 00:00:00'),
('1010405', 'Voltage Stablizer', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-03-27 10:40:59', '', '0000-00-00 00:00:00'),
('1010105', 'Waiting Sofa - Steel', 'Furniture & Fixturers', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2015-10-15 15:46:29', '', '0000-00-00 00:00:00'),
('4020405', 'WASA Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2015-10-15 18:58:51', '', '0000-00-00 00:00:00'),
('1010402', 'Water Purifier', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, 0.00, 'admin', '2016-01-29 11:14:11', '', '0000-00-00 00:00:00'),
('4020705', 'Website Development Expenses', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, 0.00, 'admin', '2016-10-15 12:42:47', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `acc_customer_income`
--

CREATE TABLE `acc_customer_income` (
  `ID` int(11) NOT NULL,
  `Customer_Id` varchar(50) NOT NULL,
  `VNo` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `Amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_glsummarybalance`
--

CREATE TABLE `acc_glsummarybalance` (
  `ID` int(11) NOT NULL,
  `COAID` varchar(50) DEFAULT NULL,
  `Debit` decimal(18,2) DEFAULT NULL,
  `Credit` decimal(18,2) DEFAULT NULL,
  `FYear` int(11) DEFAULT NULL,
  `CreateBy` varchar(50) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_income_expence`
--

CREATE TABLE `acc_income_expence` (
  `ID` int(11) NOT NULL,
  `VNo` varchar(50) NOT NULL,
  `Student_Id` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `Paymode` varchar(50) NOT NULL,
  `Perpose` varchar(50) NOT NULL,
  `Narration` text NOT NULL,
  `StoreID` int(11) NOT NULL,
  `COAID` varchar(50) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `IsApprove` tinyint(4) NOT NULL,
  `CreateBy` varchar(50) NOT NULL,
  `CreateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_temp`
--

CREATE TABLE `acc_temp` (
  `COAID` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Debit` decimal(18,2) NOT NULL,
  `Credit` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_transaction`
--

CREATE TABLE `acc_transaction` (
  `ID` int(11) NOT NULL,
  `VNo` varchar(50) DEFAULT NULL,
  `Vtype` varchar(50) DEFAULT NULL,
  `VDate` date DEFAULT NULL,
  `COAID` varchar(50) NOT NULL,
  `Narration` text DEFAULT NULL,
  `Debit` decimal(18,2) DEFAULT NULL,
  `Credit` decimal(18,2) DEFAULT NULL,
  `StoreID` int(11) NOT NULL,
  `IsPosted` char(10) DEFAULT NULL,
  `CreateBy` varchar(50) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateDate` datetime DEFAULT NULL,
  `IsAppove` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acc_transaction`
--

INSERT INTO `acc_transaction` (`ID`, `VNo`, `Vtype`, `VDate`, `COAID`, `Narration`, `Debit`, `Credit`, `StoreID`, `IsPosted`, `CreateBy`, `CreateDate`, `UpdateBy`, `UpdateDate`, `IsAppove`) VALUES
(1, 'Sale0001', 'Sales Products', '2025-10-02', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', -23.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(2, 'Sale0001', 'Sales Products', '2025-10-02', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', -23.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(3, 'Sale0001', 'Sales Products', '2025-10-02', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', -46.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(4, 'Sale0001', 'Sales Products', '2025-10-02', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', 23.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(5, '0001', 'CIV', '2025-10-02', '102030108', 'Customer debit for Product Invoice#0001', -46.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(6, '0001', 'CIV', '2025-10-02', '10107', 'Inventory Credit for Product Invoice#0001', 0.00, -46.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(7, '0001', 'CIV', '2025-10-02', '102030108', 'Customer Credit for Product Invoice#0001', 0.00, -46.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(8, 'Sale0001', 'Sales Products', '2025-10-02', '303', 'Sale Income For cusL-0002-joeldytsina', 0.00, -46.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(9, 'Sale0001', 'Sales Products Vat', '2025-10-02', '502030101', 'Sale TAX For cusL-0002-joeldytsina', 0.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(10, 'Sale0001', 'Sales Products', '2025-10-02', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', 0.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(11, '0001', 'CIV', '2025-10-02', '102030108', 'Customer debit for Product Invoice#0001', 0.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(12, '0001', 'CIV', '2025-10-02', '10107', 'Inventory Credit for Product Invoice#0001', 0.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(13, '0001', 'CIV', '2025-10-02', '102030108', 'Customer Credit for Product Invoice#0001', 0.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(14, 'Sale0001', 'Sales Products', '2025-10-02', '303', 'Sale Income For cusL-0002-joeldytsina', 0.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(15, 'Sale0001', 'Sales Products Vat', '2025-10-02', '502030101', 'Sale TAX For cusL-0002-joeldytsina', 0.00, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(16, 'Sale0002', 'Sales Products', '2023-01-01', '1020101', 'Sale Income For Online paymentcusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(17, '0002', 'CIV', '2023-01-01', '102030110', 'Customer debit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(18, '0002', 'CIV', '2023-01-01', '10107', 'Inventory Credit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(19, '0002', 'CIV', '2023-01-01', '102030110', 'Customer Credit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(20, 'Sale0002', 'Sales Products', '2023-01-01', '303', 'Sale Income For cusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(21, 'Sale0002', 'Sales Products Vat', '2023-01-01', '502030101', 'Sale TAX For cusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(22, 'Sale0002', 'Sales Products', '2023-01-01', '1020101', 'Sale Income For Online paymentcusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(23, '0002', 'CIV', '2023-01-01', '102030110', 'Customer debit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(24, '0002', 'CIV', '2023-01-01', '10107', 'Inventory Credit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(25, '0002', 'CIV', '2023-01-01', '102030110', 'Customer Credit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(26, 'Sale0002', 'Sales Products', '2023-01-01', '303', 'Sale Income For cusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(27, 'Sale0002', 'Sales Products Vat', '2023-01-01', '502030101', 'Sale TAX For cusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(28, 'Sale0002', 'Sales Products', '2023-01-01', '1020101', 'Sale Income For Online paymentcusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(29, '0002', 'CIV', '2023-01-01', '102030110', 'Customer debit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(30, '0002', 'CIV', '2023-01-01', '10107', 'Inventory Credit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(31, '0002', 'CIV', '2023-01-01', '102030110', 'Customer Credit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(32, 'Sale0002', 'Sales Products', '2023-01-01', '303', 'Sale Income For cusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(33, 'Sale0002', 'Sales Products Vat', '2023-01-01', '502030101', 'Sale TAX For cusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(34, 'Sale0002', 'Sales Products', '2023-01-01', '1020101', 'Sale Income For Online paymentcusL-0004-test', 1.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(35, '0002', 'CIV', '2023-01-01', '102030110', 'Customer debit for Product Invoice#0002', 1.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(36, '0002', 'CIV', '2023-01-01', '10107', 'Inventory Credit for Product Invoice#0002', 0.00, 1.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(37, '0002', 'CIV', '2023-01-01', '102030110', 'Customer Credit for Product Invoice#0002', 0.00, 1.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(38, 'Sale0002', 'Sales Products', '2023-01-01', '303', 'Sale Income For cusL-0004-test', 0.00, 1.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(39, 'Sale0002', 'Sales Products Vat', '2023-01-01', '502030101', 'Sale TAX For cusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(40, 'Sale0002', 'Sales Products', '2023-01-01', '1020101', 'Sale Income For Online paymentcusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(41, '0002', 'CIV', '2023-01-01', '102030110', 'Customer debit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(42, '0002', 'CIV', '2023-01-01', '10107', 'Inventory Credit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(43, '0002', 'CIV', '2023-01-01', '102030110', 'Customer Credit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(44, 'Sale0002', 'Sales Products', '2023-01-01', '303', 'Sale Income For cusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(45, 'Sale0002', 'Sales Products Vat', '2023-01-01', '502030101', 'Sale TAX For cusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(46, 'Sale0002', 'Sales Products', '2023-01-01', '1020101', 'Sale Income For Online paymentcusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(47, '0002', 'CIV', '2023-01-01', '102030110', 'Customer debit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(48, '0002', 'CIV', '2023-01-01', '10107', 'Inventory Credit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(49, '0002', 'CIV', '2023-01-01', '102030110', 'Customer Credit for Product Invoice#0002', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(50, 'Sale0002', 'Sales Products', '2023-01-01', '303', 'Sale Income For cusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(51, 'Sale0002', 'Sales Products Vat', '2023-01-01', '502030101', 'Sale TAX For cusL-0004-test', 0.00, 0.00, 0, '1', '2', '2023-01-01 00:00:00', NULL, NULL, '1'),
(52, '12', 'PO', '2025-10-03', '10107', 'PO Receive Receive No 20251003180034', 0.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(53, '12', 'PO', '2025-10-03', '502020504', 'PO received For PO No.12 Receive No.20251003180034', 0.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(54, '12', 'Purchase', '2025-10-03', '407', 'Company Credit For  502020504', 0.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(55, '12', 'PO', '2025-10-03', '502020504', 'Paid For PO No.12 Receive No.20251003180034', 2.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(56, '12', 'PO', '2025-10-03', '1020101', 'Paid For PO No.12 Receive No.20251003180034', 0.00, 2.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(57, 'sup_003', 'PR Balance', '2025-10-03', '502020505', 'supplier debit For joeldy', 0.00, 12000.00, 0, '1', NULL, '2025-10-03 18:23:11', NULL, NULL, '1'),
(58, 'sup_003', 'PR Balance', '2025-10-03', '10107', 'Inventory credit For  joeldy', 12000.00, 0.00, 0, '1', NULL, '2025-10-03 18:23:11', NULL, NULL, '1'),
(59, '1', 'PO', '2025-10-03', '10107', 'PO Receive Receive No 20251003182645', 0.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(60, '1', 'PO', '2025-10-03', '502020505', 'PO received For PO No.1 Receive No.20251003182645', 0.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(61, '1', 'Purchase', '2025-10-03', '407', 'Company Credit For  502020505', 0.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(62, '1', 'PO', '2025-10-03', '502020505', 'Paid For PO No.1 Receive No.20251003182645', 12.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(63, '1', 'PO', '2025-10-03', '1020101', 'Paid For PO No.1 Receive No.20251003182645', 0.00, 12.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(64, 'Sale0007', 'Sales Products', '2025-10-03', '1020101', 'Sale Income For Online paymentcusL-0001-Walkin', 27.86, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(65, '0007', 'CIV', '2025-10-03', '102030101', 'Customer debit for Product Invoice#0007', 27.86, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(66, '0007', 'CIV', '2025-10-03', '10107', 'Inventory Credit for Product Invoice#0007', 0.00, 27.86, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(67, '0007', 'CIV', '2025-10-03', '102030101', 'Customer Credit for Product Invoice#0007', 0.00, 27.86, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(68, 'Sale0007', 'Sales Products', '2025-10-03', '303', 'Sale Income For cusL-0001-Walkin', 0.00, 26.14, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(69, 'Sale0007', 'Sales Products Vat', '2025-10-03', '502030101', 'Sale TAX For cusL-0001-Walkin', 1.73, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(70, 'Sale0008', 'Sales Products', '2025-10-03', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', -0.97, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(71, 'Sale0008', 'Sales Products', '2025-10-03', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', -0.97, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(72, 'Sale0005', 'Sales Products', '2025-10-02', '1020101', 'Sale Income For Online paymentcusL-0004-test', 14.88, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(73, '0005', 'CIV', '2025-10-02', '102030110', 'Customer debit for Product Invoice#0005', 14.88, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(74, '0005', 'CIV', '2025-10-02', '10107', 'Inventory Credit for Product Invoice#0005', 0.00, 14.88, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(75, '0005', 'CIV', '2025-10-02', '102030110', 'Customer Credit for Product Invoice#0005', 0.00, 14.88, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(76, 'Sale0005', 'Sales Products', '2025-10-02', '303', 'Sale Income For cusL-0004-test', 0.00, 13.01, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(77, 'Sale0005', 'Sales Products Vat', '2025-10-02', '502030101', 'Sale TAX For cusL-0004-test', 1.88, 0.00, 0, '1', '2', '2025-10-02 00:00:00', NULL, NULL, '1'),
(78, 'Sale0010', 'Sales Products', '2025-10-03', '1020101', 'Sale Income For Online paymentcusL-0001-Walkin', 12.11, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(79, '0010', 'CIV', '2025-10-03', '102030101', 'Customer debit for Product Invoice#0010', 12.11, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(80, '0010', 'CIV', '2025-10-03', '10107', 'Inventory Credit for Product Invoice#0010', 0.00, 12.11, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(81, '0010', 'CIV', '2025-10-03', '102030101', 'Customer Credit for Product Invoice#0010', 0.00, 12.11, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(82, 'Sale0010', 'Sales Products', '2025-10-03', '303', 'Sale Income For cusL-0001-Walkin', 0.00, 11.36, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(83, 'Sale0010', 'Sales Products Vat', '2025-10-03', '502030101', 'Sale TAX For cusL-0001-Walkin', 0.75, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(84, 'Sale0010', 'Sales Products', '2025-10-03', '1020101', 'Sale Income For Online paymentcusL-0001-Walkin', -0.61, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(85, 'Sale0010', 'Sales Products', '2025-10-03', '1020101', 'Sale Income For Online paymentcusL-0001-Walkin', -1.50, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(86, 'Sale0009', 'Sales Products', '2025-10-03', '1020101', 'Sale Income For Online paymentcusL-0001-Walkin', 0.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(87, '0009', 'CIV', '2025-10-03', '102030101', 'Customer debit for Product Invoice#0009', 0.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(88, '0009', 'CIV', '2025-10-03', '10107', 'Inventory Credit for Product Invoice#0009', 0.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(89, '0009', 'CIV', '2025-10-03', '102030101', 'Customer Credit for Product Invoice#0009', 0.00, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(90, 'Sale0009', 'Sales Products', '2025-10-03', '303', 'Sale Income For cusL-0001-Walkin', 0.00, -3.15, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(91, 'Sale0009', 'Sales Products Vat', '2025-10-03', '502030101', 'Sale TAX For cusL-0001-Walkin', 3.15, 0.00, 0, '1', '2', '2025-10-03 00:00:00', NULL, NULL, '1'),
(92, 'Sale0011', 'Sales Products', '2025-10-05', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', 27.86, 0.00, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(93, '0011', 'CIV', '2025-10-05', '102030108', 'Customer debit for Product Invoice#0011', 27.86, 0.00, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(94, '0011', 'CIV', '2025-10-05', '10107', 'Inventory Credit for Product Invoice#0011', 0.00, 27.86, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(95, '0011', 'CIV', '2025-10-05', '102030108', 'Customer Credit for Product Invoice#0011', 0.00, 27.86, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(96, 'Sale0011', 'Sales Products', '2025-10-05', '303', 'Sale Income For cusL-0002-joeldytsina', 0.00, 26.14, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(97, 'Sale0011', 'Sales Products Vat', '2025-10-05', '502030101', 'Sale TAX For cusL-0002-joeldytsina', 1.73, 0.00, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(98, 'Sale0011', 'Sales Products', '2025-10-05', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', 27.86, 0.00, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(99, '0011', 'CIV', '2025-10-05', '102030108', 'Customer debit for Product Invoice#0011', 27.86, 0.00, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(100, '0011', 'CIV', '2025-10-05', '10107', 'Inventory Credit for Product Invoice#0011', 0.00, 27.86, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(101, '0011', 'CIV', '2025-10-05', '102030108', 'Customer Credit for Product Invoice#0011', 0.00, 27.86, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(102, 'Sale0011', 'Sales Products', '2025-10-05', '303', 'Sale Income For cusL-0002-joeldytsina', 0.00, 26.14, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(103, 'Sale0011', 'Sales Products Vat', '2025-10-05', '502030101', 'Sale TAX For cusL-0002-joeldytsina', 1.73, 0.00, 0, '1', '2', '2025-10-05 00:00:00', NULL, NULL, '1'),
(104, 'Sale0014', 'Sales Products', '2025-10-11', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', 27.86, 0.00, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(105, '0014', 'CIV', '2025-10-11', '102030108', 'Customer debit for Product Invoice#0014', 27.86, 0.00, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(106, '0014', 'CIV', '2025-10-11', '10107', 'Inventory Credit for Product Invoice#0014', 0.00, 27.86, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(107, '0014', 'CIV', '2025-10-11', '102030108', 'Customer Credit for Product Invoice#0014', 0.00, 27.86, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(108, 'Sale0014', 'Sales Products', '2025-10-11', '303', 'Sale Income For cusL-0002-joeldytsina', 0.00, 26.14, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(109, 'Sale0014', 'Sales Products Vat', '2025-10-11', '502030101', 'Sale TAX For cusL-0002-joeldytsina', 1.73, 0.00, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(110, 'Sale0013', 'Sales Products', '2025-10-11', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', 52.09, 0.00, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(111, '0013', 'CIV', '2025-10-11', '102030108', 'Customer debit for Product Invoice#0013', 52.09, 0.00, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(112, '0013', 'CIV', '2025-10-11', '10107', 'Inventory Credit for Product Invoice#0013', 0.00, 52.09, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(113, '0013', 'CIV', '2025-10-11', '102030108', 'Customer Credit for Product Invoice#0013', 0.00, 52.09, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(114, 'Sale0013', 'Sales Products', '2025-10-11', '303', 'Sale Income For cusL-0002-joeldytsina', 0.00, 48.86, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(115, 'Sale0013', 'Sales Products Vat', '2025-10-11', '502030101', 'Sale TAX For cusL-0002-joeldytsina', 3.23, 0.00, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(116, 'Sale0012', 'Sales Products', '2025-10-11', '1020101', 'Sale Income For Online paymentcusL-0001-Walkin', 3.64, 0.00, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(117, '0012', 'CIV', '2025-10-11', '102030101', 'Customer debit for Product Invoice#0012', 3.64, 0.00, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(118, '0012', 'CIV', '2025-10-11', '10107', 'Inventory Credit for Product Invoice#0012', 0.00, 3.64, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(119, '0012', 'CIV', '2025-10-11', '102030101', 'Customer Credit for Product Invoice#0012', 0.00, 3.64, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(120, 'Sale0012', 'Sales Products', '2025-10-11', '303', 'Sale Income For cusL-0001-Walkin', 0.00, 3.41, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(121, 'Sale0012', 'Sales Products Vat', '2025-10-11', '502030101', 'Sale TAX For cusL-0001-Walkin', 0.23, 0.00, 0, '1', '2', '2025-10-11 00:00:00', NULL, NULL, '1'),
(122, 'Sale0015', 'Sales Products', '2025-10-12', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', 50.03, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(123, '0015', 'CIV', '2025-10-12', '102030108', 'Customer debit for Product Invoice#0015', 50.03, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(124, '0015', 'CIV', '2025-10-12', '10107', 'Inventory Credit for Product Invoice#0015', 0.00, 50.03, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(125, '0015', 'CIV', '2025-10-12', '102030108', 'Customer Credit for Product Invoice#0015', 0.00, 50.03, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(126, 'Sale0015', 'Sales Products', '2025-10-12', '303', 'Sale Income For cusL-0002-joeldytsina', 0.00, 46.93, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(127, 'Sale0015', 'Sales Products Vat', '2025-10-12', '502030101', 'Sale TAX For cusL-0002-joeldytsina', 3.10, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(128, 'Sale0017', 'Sales Products', '2025-10-12', '1020101', 'Sale Income For Online paymentcusL-0001-Walkin', 3.64, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(129, '0017', 'CIV', '2025-10-12', '102030101', 'Customer debit for Product Invoice#0017', 3.64, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(130, '0017', 'CIV', '2025-10-12', '10107', 'Inventory Credit for Product Invoice#0017', 0.00, 3.64, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(131, '0017', 'CIV', '2025-10-12', '102030101', 'Customer Credit for Product Invoice#0017', 0.00, 3.64, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(132, 'Sale0017', 'Sales Products', '2025-10-12', '303', 'Sale Income For cusL-0001-Walkin', 0.00, 3.41, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(133, 'Sale0017', 'Sales Products Vat', '2025-10-12', '502030101', 'Sale TAX For cusL-0001-Walkin', 0.23, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(134, 'Sale0023', 'Sales Products', '2025-10-12', '1020101', 'Sale Income For Online paymentcusL-0003-joeldytsina242@gmail.com', 38.76, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(135, '0023', 'CIV', '2025-10-12', '102030109', 'Customer debit for Product Invoice#0023', 38.76, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(136, '0023', 'CIV', '2025-10-12', '10107', 'Inventory Credit for Product Invoice#0023', 0.00, 38.76, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(137, '0023', 'CIV', '2025-10-12', '102030109', 'Customer Credit for Product Invoice#0023', 0.00, 38.76, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(138, 'Sale0023', 'Sales Products', '2025-10-12', '303', 'Sale Income For cusL-0003-joeldytsina242@gmail.com', 0.00, 36.36, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(139, 'Sale0023', 'Sales Products Vat', '2025-10-12', '502030101', 'Sale TAX For cusL-0003-joeldytsina242@gmail.com', 2.40, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(140, 'Sale0022', 'Sales Products', '2025-10-12', '1020101', 'Sale Income For Online paymentcusL-0004-test', 29.07, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(141, '0022', 'CIV', '2025-10-12', '102030110', 'Customer debit for Product Invoice#0022', 29.07, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(142, '0022', 'CIV', '2025-10-12', '10107', 'Inventory Credit for Product Invoice#0022', 0.00, 29.07, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(143, '0022', 'CIV', '2025-10-12', '102030110', 'Customer Credit for Product Invoice#0022', 0.00, 29.07, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(144, 'Sale0022', 'Sales Products', '2025-10-12', '303', 'Sale Income For cusL-0004-test', 0.00, 27.27, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(145, 'Sale0022', 'Sales Products Vat', '2025-10-12', '502030101', 'Sale TAX For cusL-0004-test', 1.80, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(146, 'Sale0021', 'Sales Products', '2025-10-12', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', 3.64, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(147, '0021', 'CIV', '2025-10-12', '102030108', 'Customer debit for Product Invoice#0021', 3.64, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(148, '0021', 'CIV', '2025-10-12', '10107', 'Inventory Credit for Product Invoice#0021', 0.00, 3.64, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(149, '0021', 'CIV', '2025-10-12', '102030108', 'Customer Credit for Product Invoice#0021', 0.00, 3.64, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(150, 'Sale0021', 'Sales Products', '2025-10-12', '303', 'Sale Income For cusL-0002-joeldytsina', 0.00, 3.41, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(151, 'Sale0021', 'Sales Products Vat', '2025-10-12', '502030101', 'Sale TAX For cusL-0002-joeldytsina', 0.23, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(152, 'Sale0020', 'Sales Products', '2025-10-12', '1020101', 'Sale Income For Online paymentcusL-0004-test', 3.64, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(153, '0020', 'CIV', '2025-10-12', '102030110', 'Customer debit for Product Invoice#0020', 3.64, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(154, '0020', 'CIV', '2025-10-12', '10107', 'Inventory Credit for Product Invoice#0020', 0.00, 3.64, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(155, '0020', 'CIV', '2025-10-12', '102030110', 'Customer Credit for Product Invoice#0020', 0.00, 3.64, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(156, 'Sale0020', 'Sales Products', '2025-10-12', '303', 'Sale Income For cusL-0004-test', 0.00, 3.41, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(157, 'Sale0020', 'Sales Products Vat', '2025-10-12', '502030101', 'Sale TAX For cusL-0004-test', 0.23, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(158, 'Sale0019', 'Sales Products', '2025-10-12', '1020101', 'Sale Income For Online paymentcusL-0001-Walkin', 3.64, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(159, '0019', 'CIV', '2025-10-12', '102030101', 'Customer debit for Product Invoice#0019', 3.64, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(160, '0019', 'CIV', '2025-10-12', '10107', 'Inventory Credit for Product Invoice#0019', 0.00, 3.64, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(161, '0019', 'CIV', '2025-10-12', '102030101', 'Customer Credit for Product Invoice#0019', 0.00, 3.64, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(162, 'Sale0019', 'Sales Products', '2025-10-12', '303', 'Sale Income For cusL-0001-Walkin', 0.00, 3.41, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(163, 'Sale0019', 'Sales Products Vat', '2025-10-12', '502030101', 'Sale TAX For cusL-0001-Walkin', 0.23, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(164, 'Sale0018', 'Sales Products', '2025-10-12', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', 2.42, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(165, '0018', 'CIV', '2025-10-12', '102030108', 'Customer debit for Product Invoice#0018', 2.42, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(166, '0018', 'CIV', '2025-10-12', '10107', 'Inventory Credit for Product Invoice#0018', 0.00, 2.42, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(167, '0018', 'CIV', '2025-10-12', '102030108', 'Customer Credit for Product Invoice#0018', 0.00, 2.42, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(168, 'Sale0018', 'Sales Products', '2025-10-12', '303', 'Sale Income For cusL-0002-joeldytsina', 0.00, 2.27, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(169, 'Sale0018', 'Sales Products Vat', '2025-10-12', '502030101', 'Sale TAX For cusL-0002-joeldytsina', 0.15, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(170, 'Sale0018', 'Sales Products', '2025-10-12', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', 2.42, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(171, '0018', 'CIV', '2025-10-12', '102030108', 'Customer debit for Product Invoice#0018', 2.42, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(172, '0018', 'CIV', '2025-10-12', '10107', 'Inventory Credit for Product Invoice#0018', 0.00, 2.42, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(173, '0018', 'CIV', '2025-10-12', '102030108', 'Customer Credit for Product Invoice#0018', 0.00, 2.42, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(174, 'Sale0018', 'Sales Products', '2025-10-12', '303', 'Sale Income For cusL-0002-joeldytsina', 0.00, 2.27, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(175, 'Sale0018', 'Sales Products Vat', '2025-10-12', '502030101', 'Sale TAX For cusL-0002-joeldytsina', 0.15, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(176, 'Sale0016', 'Sales Products', '2025-10-12', '1020101', 'Sale Income For Online paymentcusL-0002-joeldytsina', 2.42, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(177, '0016', 'CIV', '2025-10-12', '102030108', 'Customer debit for Product Invoice#0016', 2.42, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(178, '0016', 'CIV', '2025-10-12', '10107', 'Inventory Credit for Product Invoice#0016', 0.00, 2.42, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(179, '0016', 'CIV', '2025-10-12', '102030108', 'Customer Credit for Product Invoice#0016', 0.00, 2.42, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(180, 'Sale0016', 'Sales Products', '2025-10-12', '303', 'Sale Income For cusL-0002-joeldytsina', 0.00, 2.27, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(181, 'Sale0016', 'Sales Products Vat', '2025-10-12', '502030101', 'Sale TAX For cusL-0002-joeldytsina', 0.15, 0.00, 0, '1', '2', '2025-10-12 00:00:00', NULL, NULL, '1'),
(182, 'PM-1', 'PM', '2025-11-03', '', '', 2333.00, 0.00, 0, '1', '2', '2025-11-03 13:21:27', NULL, NULL, '1'),
(183, 'PM-1', 'PM', '2025-11-03', '1020101', 'Paid to Kabalan', 0.00, 2333.00, 0, '1', '2', '2025-11-03 13:21:27', NULL, NULL, '1'),
(185, 'Journal-1', 'JV', '2025-11-03', '102030109', '', 123.00, 234.00, 0, '1', NULL, NULL, NULL, '2025-11-03 13:38:49', '1'),
(186, 'Contra-1', 'Contra', '2025-11-03', '1010410', '', 22.00, 3444.00, 0, '1', NULL, '2025-11-03 20:55:21', NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `acn_account_transaction`
--

CREATE TABLE `acn_account_transaction` (
  `account_tran_id` int(11) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `transaction_description` varchar(255) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `tran_date` date NOT NULL,
  `payment_id` int(11) NOT NULL,
  `create_by_id` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `add_ons`
--

CREATE TABLE `add_ons` (
  `add_on_id` int(11) NOT NULL,
  `add_on_name` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `add_ons`
--

INSERT INTO `add_ons` (`add_on_id`, `add_on_name`, `price`, `is_active`) VALUES
(1, 'Mutton Slice', 50.00, 1),
(2, 'Till', 10.00, 1),
(3, 'Medium', 20.00, 1),
(4, 'Large', 30.00, 1),
(5, 'Family Pack', 100.00, 1),
(6, 'Cheese', 20.00, 1),
(7, 'Juicy', 10.00, 1),
(8, 'Spicy+Wonton', 30.00, 1),
(9, 'Wonthon', 10.00, 1),
(10, 'Spicy', 20.00, 1),
(11, 'Chilli', 30.00, 1),
(12, 'Sauce', 20.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `award`
--

CREATE TABLE `award` (
  `award_id` int(11) NOT NULL,
  `award_name` varchar(50) NOT NULL,
  `aw_description` varchar(200) NOT NULL,
  `awr_gift_item` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `employee_id` varchar(30) NOT NULL,
  `awarded_by` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_summary`
--

CREATE TABLE `bank_summary` (
  `bank_id` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `deposite_id` varchar(250) DEFAULT NULL,
  `date` varchar(250) DEFAULT NULL,
  `ac_type` varchar(50) DEFAULT NULL,
  `dr` float DEFAULT NULL,
  `cr` float DEFAULT NULL,
  `ammount` float DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_id` bigint(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `total_amount` float NOT NULL,
  `discount` float NOT NULL,
  `service_charge` float NOT NULL,
  `shipping_type` int(11) DEFAULT NULL COMMENT '1=home,2=pickup,3=none',
  `delivarydate` datetime DEFAULT NULL,
  `VAT` float NOT NULL,
  `bill_amount` float NOT NULL,
  `bill_date` date NOT NULL,
  `bill_time` time NOT NULL,
  `create_at` datetime DEFAULT '1970-01-01 01:01:01',
  `bill_status` tinyint(1) NOT NULL COMMENT '0=unpaid, 1=paid',
  `payment_method_id` tinyint(4) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_date` date NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bill_id`, `customer_id`, `order_id`, `total_amount`, `discount`, `service_charge`, `shipping_type`, `delivarydate`, `VAT`, `bill_amount`, `bill_date`, `bill_time`, `create_at`, `bill_status`, `payment_method_id`, `create_by`, `create_date`, `update_by`, `update_date`) VALUES
(1, 55, 1, 0, 0, 0, 3, NULL, 0, 0, '2025-10-31', '10:05:29', '2025-10-31 22:34:40', 1, 4, 2, '2025-10-31', 0, '0000-00-00'),
(2, 54, 2, 20, 1.275, 4, 1, NULL, 1.5, 24.225, '2025-10-31', '12:18:17', '2025-10-31 23:32:11', 1, 4, 2, '2025-10-31', 0, '0000-00-00'),
(3, 54, 3, 110, 11, 0, 2, NULL, 8.25, 104.5, '2025-10-31', '22:03:33', '2025-10-31 23:32:02', 1, 4, 2, '2025-10-31', 0, '0000-00-00'),
(4, 54, 4, 40, 5, 60, 1, NULL, 3, 95, '2025-10-31', '22:09:05', '2025-10-31 23:31:53', 1, 4, 2, '2025-10-31', 0, '0000-00-00'),
(5, 1, 5, 80, 4.8, 16, NULL, NULL, 6, 91.2, '2025-10-31', '22:47:51', '2025-10-31 23:30:21', 1, 4, 2, '2025-10-31', 0, '0000-00-00'),
(6, 54, 6, 20, 4, 60, 1, NULL, 1.5, 76, '2025-11-01', '03:02:36', '2025-11-01 04:17:11', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(7, 56, 7, 40, 2, 0, 3, NULL, 3, 38, '2025-11-01', '04:37:12', '2025-11-01 12:38:34', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(8, 57, 8, 280, 17.85, 56, 3, NULL, 21, 339.15, '2025-11-01', '12:37:56', '2025-11-01 13:18:56', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(9, 58, 9, 4750, 285, 950, 3, NULL, 356.25, 5415, '2025-11-01', '12:45:24', '2025-11-01 13:18:48', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(10, 58, 10, 2215, 132.9, 443, 3, NULL, 166.125, 2525.1, '2025-11-01', '12:46:28', '2025-11-01 13:18:36', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(11, 36, 11, 100, 12, 20, NULL, NULL, 7.5, 114, '2025-11-01', '13:21:10', '2025-11-01 13:26:59', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(12, 55, 12, 160, 19.2, 32, NULL, NULL, 12, 182.4, '2025-11-01', '13:22:51', '2025-11-01 13:26:49', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(13, 1, 13, 225, 13.5, 45, NULL, NULL, 16.875, 256.5, '2025-11-01', '13:32:53', '2025-11-01 13:46:45', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(14, 56, 14, 200, 12, 40, NULL, NULL, 15, 228, '2025-11-01', '13:34:49', '2025-11-01 13:46:27', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(15, 56, 15, 400, 24, 80, NULL, NULL, 30, 456, '2025-11-01', '13:35:24', '2025-11-01 13:39:59', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(16, 1, 16, 110, 0, 22, NULL, NULL, 8.25, 132, '2025-11-01', '18:04:44', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-01', 0, '0000-00-00'),
(17, 1, 17, 20, 0, 4, NULL, NULL, 1.5, 24, '2025-11-01', '18:05:26', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-01', 0, '0000-00-00'),
(18, 1, 18, 150, 0, 30, NULL, NULL, 11.25, 180, '2025-11-01', '18:05:46', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-01', 0, '0000-00-00'),
(19, 1, 19, 100, 0, 20, NULL, NULL, 7.5, 120, '2025-11-01', '18:07:05', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-01', 0, '0000-00-00'),
(20, 1, 20, 25, 1.5, 5, NULL, NULL, 1.875, 28.5, '2025-11-01', '18:07:34', '2025-11-03 21:37:54', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(21, 1, 21, 40, 2.4, 8, NULL, NULL, 3, 45.6, '2025-11-01', '18:08:11', '2025-11-01 22:37:27', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(22, 1, 22, 150, 9, 30, NULL, NULL, 11.25, 171, '2025-11-01', '18:08:35', '2025-11-01 22:37:20', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(23, 1, 23, 440, 0, 88, NULL, NULL, 33, 528, '2025-11-01', '18:11:11', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-01', 0, '0000-00-00'),
(24, 1, 24, 130, 0, 26, NULL, NULL, 9.75, 156, '2025-11-01', '18:11:39', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-01', 0, '0000-00-00'),
(25, 1, 25, 90, 5.4, 18, NULL, NULL, 6.75, 102.6, '2025-11-01', '18:14:21', '2025-11-03 20:49:11', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(26, 55, 26, 40, 0, 8, NULL, NULL, 3, 48, '2025-11-01', '18:41:08', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-01', 0, '0000-00-00'),
(27, 55, 27, 300, 0, 60, NULL, NULL, 22.5, 360, '2025-11-01', '18:41:38', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-01', 0, '0000-00-00'),
(28, 55, 28, 0, 0, 0, NULL, NULL, 0, 0, '2025-11-01', '18:41:54', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-01', 0, '0000-00-00'),
(29, 54, 29, 540, 156.32, 87.2, NULL, NULL, 32.7, 497.04, '2025-11-01', '22:45:01', '2025-11-03 01:02:10', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(30, 54, 30, 130, 7.8, 26, NULL, NULL, 9.75, 148.2, '2025-11-01', '22:45:09', '2025-11-03 01:01:58', 1, 4, 2, '2025-11-01', 0, '0000-00-00'),
(31, 54, 31, 130, 0, 26, NULL, NULL, 9.75, 156, '2025-11-01', '22:45:19', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-01', 0, '0000-00-00'),
(32, 59, 32, 894, 188.4, 158, 3, NULL, 59.25, 801.8, '2025-11-02', '12:39:10', '2025-11-02 12:48:16', 1, 4, 2, '2025-11-02', 0, '0000-00-00'),
(33, 60, 33, 270, 16.2, 54, 2, NULL, 20.25, 307.8, '2025-11-03', '01:10:06', '2025-11-03 20:48:09', 1, 4, 2, '2025-11-03', 0, '0000-00-00'),
(34, 1, 34, 20, 1.2, 4, NULL, NULL, 1.5, 22.8, '2025-11-03', '20:58:34', '2025-11-07 22:01:52', 1, 4, 2, '2025-11-03', 0, '0000-00-00'),
(35, 54, 35, 20, 2, 0, 3, NULL, 1.5, 19, '2025-11-07', '21:46:52', '2025-11-07 22:06:13', 1, 4, 2, '2025-11-07', 0, '0000-00-00'),
(36, 54, 36, 130, 6.5, 0, 3, NULL, 9.75, 123.5, '2025-11-07', '21:49:15', '2025-11-07 22:05:59', 1, 4, 2, '2025-11-07', 0, '0000-00-00'),
(37, 54, 37, 130, 7.8, 26, NULL, NULL, 9.75, 148.2, '2025-11-08', '21:49:42', '2025-11-08 22:20:25', 1, 4, 2, '2025-11-08', 0, '0000-00-00'),
(38, 1, 38, 20, 1.2, 4, NULL, NULL, 1.5, 22.8, '2025-11-08', '21:51:01', '2025-11-08 22:20:17', 1, 4, 2, '2025-11-08', 0, '0000-00-00'),
(39, 61, 39, 200, 12, 40, 3, NULL, 15, 228, '2025-11-08', '21:51:39', '2025-11-08 22:20:09', 1, 4, 2, '2025-11-08', 0, '0000-00-00'),
(40, 62, 40, 150, 9, 30, 2, NULL, 11.25, 171, '2025-11-08', '21:56:54', '2025-11-08 22:19:28', 1, 4, 2, '2025-11-08', 0, '0000-00-00'),
(41, 63, 41, 315, 18.9, 63, 3, NULL, 23.625, 359.1, '2025-11-08', '22:39:48', '2025-11-08 22:45:10', 1, 4, 2, '2025-11-08', 0, '0000-00-00'),
(42, 64, 42, 540, 32.4, 108, 3, NULL, 40.5, 615.6, '2025-11-08', '22:41:31', '2025-11-08 22:44:47', 1, 4, 2, '2025-11-08', 0, '0000-00-00'),
(43, 65, 43, 270, 16.2, 54, 3, NULL, 20.25, 307.8, '2025-11-08', '23:10:59', '2025-11-09 00:27:04', 1, 4, 2, '2025-11-08', 0, '0000-00-00'),
(44, 66, 44, 980, 0, 0, 3, NULL, 73.5, 1176, '2025-11-08', '23:17:09', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-08', 0, '0000-00-00'),
(45, 36, 45, 20, 1.2, 4, NULL, NULL, 1.5, 22.8, '2025-11-09', '00:53:55', '2025-11-09 00:56:02', 1, 4, 2, '2025-11-09', 0, '0000-00-00'),
(46, 54, 46, 320, 61.5, 55, NULL, NULL, 20.625, 313.5, '2025-11-09', '04:55:02', '2025-11-09 20:51:03', 1, 4, 2, '2025-11-09', 0, '0000-00-00'),
(47, 56, 47, 700, 84, 140, NULL, NULL, 52.5, 798, '2025-11-09', '04:56:09', '2025-11-09 20:56:04', 1, 4, 2, '2025-11-09', 0, '0000-00-00'),
(48, 67, 48, 110, 13.2, 22, NULL, NULL, 8.25, 125.4, '2025-11-11', '23:59:38', '2025-11-12 00:01:40', 1, 4, 2, '2025-11-11', 0, '0000-00-00'),
(49, 56, 49, 20, 1.2, 4, NULL, NULL, 1.5, 22.8, '2025-11-12', '00:02:29', '2025-11-12 00:03:26', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(50, 56, 50, 20, 1.2, 4, NULL, NULL, 1.5, 22.8, '2025-11-12', '00:04:00', '2025-11-12 00:06:27', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(51, 67, 51, 190, 11.4, 38, NULL, NULL, 14.25, 216.6, '2025-11-12', '00:15:23', '2025-11-12 01:40:54', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(52, 67, 52, 350, 19.25, 70, NULL, NULL, 26.25, 365.75, '2025-11-12', '00:22:14', '2025-11-12 01:35:31', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(53, 1, 53, 460, 27.6, 92, NULL, NULL, 34.5, 524.4, '2025-11-12', '00:27:38', '2025-11-12 01:40:50', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(54, 36, 54, 220, 13.2, 44, NULL, NULL, 16.5, 250.8, '2025-11-12', '00:28:10', '2025-11-12 01:40:46', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(55, 36, 55, 1400, 84, 280, NULL, NULL, 105, 1596, '2025-11-12', '00:28:26', '2025-11-12 01:40:27', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(56, 36, 56, 915, 54.9, 183, NULL, NULL, 68.625, 1043.1, '2025-11-12', '00:28:50', '2025-11-12 01:34:57', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(57, 36, 57, 110, 6.6, 22, NULL, NULL, 8.25, 125.4, '2025-11-12', '00:29:06', '2025-11-12 01:34:53', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(58, 36, 58, 180, 10.8, 36, NULL, NULL, 13.5, 205.2, '2025-11-12', '00:33:44', '2025-11-12 01:34:47', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(59, 67, 59, 50, 3, 10, NULL, NULL, 3.75, 57, '2025-11-12', '00:34:36', '2025-11-12 01:35:26', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(60, 67, 60, 620, 134.96, 103.2, NULL, NULL, 38.7, 588.24, '2025-11-12', '00:35:25', '2025-11-12 01:34:38', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(61, 67, 61, 110, 13.2, 22, NULL, NULL, 8.25, 125.4, '2025-11-12', '00:39:20', '2025-11-12 01:40:19', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(62, 67, 62, 20, 1.2, 4, NULL, NULL, 1.5, 22.8, '2025-11-12', '00:39:43', '2025-11-12 01:36:30', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(63, 67, 63, 450, 69.3, 81, NULL, NULL, 30.375, 461.7, '2025-11-12', '00:40:09', '2025-11-12 01:36:23', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(64, 67, 64, 110, 6.6, 22, NULL, NULL, 8.25, 125.4, '2025-11-12', '00:41:39', '2025-11-12 01:34:30', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(65, 68, 65, 0, 0, 0, 3, NULL, 0, 0, '2025-11-12', '01:00:16', '1970-01-01 01:01:01', 0, 4, 2, '2025-11-12', 0, '0000-00-00'),
(66, 68, 66, 470, 66.25, 0, 2, NULL, 31.875, 403.75, '2025-11-12', '01:01:48', '2025-11-12 01:35:22', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(67, 68, 67, 450, 68.25, 60, 1, NULL, 30.375, 441.75, '2025-11-12', '01:04:43', '2025-11-12 01:35:17', 1, 4, 2, '2025-11-12', 0, '0000-00-00'),
(68, 67, 68, 270, 16.2, 54, NULL, NULL, 20.25, 307.8, '2025-11-12', '01:07:18', '2025-11-12 01:36:17', 1, 4, 2, '2025-11-12', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `bill_card_payment`
--

CREATE TABLE `bill_card_payment` (
  `row_id` bigint(20) NOT NULL,
  `bill_id` bigint(20) NOT NULL,
  `multipay_id` int(11) DEFAULT NULL,
  `card_no` varchar(200) DEFAULT NULL,
  `terminal_name` int(11) NOT NULL,
  `bank_name` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_basic_info`
--

CREATE TABLE `candidate_basic_info` (
  `can_id` varchar(20) NOT NULL,
  `first_name` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `last_name` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `alter_phone` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `present_address` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `parmanent_address` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `picture` text DEFAULT NULL,
  `ssn` varchar(50) NOT NULL,
  `state` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `zip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_education_info`
--

CREATE TABLE `candidate_education_info` (
  `can_edu_id` int(11) NOT NULL,
  `can_id` varchar(30) NOT NULL,
  `degree_name` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `university_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cgp` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `comments` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `sequencee` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_interview`
--

CREATE TABLE `candidate_interview` (
  `can_int_id` int(11) NOT NULL,
  `can_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `job_adv_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `interview_date` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `interviewer_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `interview_marks` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `written_total_marks` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `mcq_total_marks` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_marks` varchar(30) NOT NULL,
  `recommandation` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `selection` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `details` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_selection`
--

CREATE TABLE `candidate_selection` (
  `can_sel_id` int(11) NOT NULL,
  `can_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `employee_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pos_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `selection_terms` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_shortlist`
--

CREATE TABLE `candidate_shortlist` (
  `can_short_id` int(11) NOT NULL,
  `can_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `job_adv_id` int(11) NOT NULL,
  `date_of_shortlist` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `interview_date` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_workexperience`
--

CREATE TABLE `candidate_workexperience` (
  `can_workexp_id` int(11) NOT NULL,
  `can_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `company_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `working_period` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `duties` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `supervisor` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `sequencee` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `check_addones`
--

CREATE TABLE `check_addones` (
  `id` int(11) NOT NULL,
  `order_menuid` int(11) NOT NULL,
  `sub_order_id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '1=insert, 0=notinserted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `common_setting`
--

CREATE TABLE `common_setting` (
  `id` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `phone_optional` varchar(30) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `logo_footer` varchar(255) DEFAULT NULL,
  `ismembership` int(11) NOT NULL DEFAULT 0 COMMENT '1=enable,0=disable',
  `powerbytxt` text DEFAULT NULL,
  `web_onoff` int(11) DEFAULT 1 COMMENT '1=enable,0=disable',
  `backgroundcolorweb` varchar(30) DEFAULT NULL,
  `webheaderfontcolor` varchar(20) DEFAULT NULL,
  `backgroundcolorqr` varchar(30) DEFAULT NULL,
  `qrheaderfontcolor` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `common_setting`
--

INSERT INTO `common_setting` (`id`, `address`, `email`, `phone`, `phone_optional`, `logo`, `logo_footer`, `ismembership`, `powerbytxt`, `web_onoff`, `backgroundcolorweb`, `webheaderfontcolor`, `backgroundcolorqr`, `qrheaderfontcolor`) VALUES
(1, '<p>123 Suspendis matti, <br> Visaosang Building VST District, <br>BZ Accums, North Brazzaville</p>\r\n<div id=\"gtx-trans\" xss=removed> </div>', 'support@lumuka.com', '050489037', '+242 064663469', 'assets/img/2021-01-02/b.png', 'assets/img/2021-01-02/b1.png', 1, '© 2025 Hungry All Right Reserved. Developed by LMK Tech.\r\n', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currencyid` int(11) NOT NULL,
  `currencyname` varchar(50) NOT NULL,
  `curr_icon` varchar(50) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 1 COMMENT '1=left.2=right',
  `curr_rate` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currencyid`, `currencyname`, `curr_icon`, `position`, `curr_rate`) VALUES
(1, 'BDT', 'BDT', 2, 83.00),
(2, 'USD', '$', 1, 1.00),
(3, 'INR', 'R', 1, 0.50),
(4, 'fcfa', 'fcfa', 2, 560.00);

-- --------------------------------------------------------

--
-- Table structure for table `customer_info`
--

CREATE TABLE `customer_info` (
  `customer_id` int(11) NOT NULL,
  `cuntomer_no` varchar(120) NOT NULL,
  `facebook_id` varchar(100) DEFAULT NULL,
  `membership_type` int(11) DEFAULT NULL COMMENT '1=bronze,2=silver,3=gold,4=platinum,5vip',
  `customer_name` varchar(150) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `customer_token` text DEFAULT NULL,
  `customer_address` varchar(250) DEFAULT NULL,
  `customer_phone` varchar(200) NOT NULL,
  `customer_picture` varchar(255) DEFAULT NULL,
  `favorite_delivery_address` varchar(200) DEFAULT NULL,
  `crdate` date DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer_info`
--

INSERT INTO `customer_info` (`customer_id`, `cuntomer_no`, `facebook_id`, `membership_type`, `customer_name`, `customer_email`, `password`, `customer_token`, `customer_address`, `customer_phone`, `customer_picture`, `favorite_delivery_address`, `crdate`, `is_active`) VALUES
(1, 'cusL-0001', NULL, 2, 'Walkin', 'test@gmail.com', NULL, 'cO_Sa2fwscE:APA91bEFDD0sbV52pZPwJEl8MEUCcHBg2wIGjKfelfbiytAj4nJlPsKf8sSupfElBq-nm36DCkjYDEoUcA7qvtzKu4vDqjutF23f6Y_0uw4L_PlJIrtl61y4s-t5OKFAmdaU9OUQTtYS', 'dhaka', '8801717426371', NULL, 'ddd', NULL, 1),
(36, 'cusL-0004', NULL, 1, 'Kabir khan', 'kabir@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'DDD sgfsrgrg', '1732432434', 'assets/img/icons/2021-11-10/m.png', NULL, '2021-08-31', 1),
(54, 'cusL-0005', NULL, 0, 'joeldy tsna', 'joeldytsina94@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'Congo Brazzaville', '064663469', 'assets/img/icons/2025-10-31/P.png', NULL, '2025-10-31', 1),
(55, 'cusL-0006', NULL, 0, 'simon', '064663469@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'Not Set', '064663469', NULL, 'Not Set', '2025-10-31', 1),
(56, 'cusL-0007', NULL, 0, 'clavina', 'counter@example.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'la poudriere', '050489037', 'assets/img/user/676447881_1761963839.jpeg', NULL, '2025-11-01', 1),
(57, 'cusL-0008', NULL, 0, 'simon', '06739988747@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'egWXc5aoQO_l4FM4EWk3uy:APA91bGdppgUgWU5nRlXmv0IigH2TMOk6y7p5DAzIk3nvOtW_Tvo4Z_Hrc6PV4hiKzoWEG-xxPHQwAg4-TUcuU4cgtfeYZeMqrCOAjcheatLJc-GZflWSWc', 'Not Set', '06739988747', NULL, 'Not Set', '2025-11-01', 1),
(58, 'cusL-0009', NULL, NULL, 'clavina', '06739988747@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'egWXc5aoQO_l4FM4EWk3uy:APA91bGdppgUgWU5nRlXmv0IigH2TMOk6y7p5DAzIk3nvOtW_Tvo4Z_Hrc6PV4hiKzoWEG-xxPHQwAg4-TUcuU4cgtfeYZeMqrCOAjcheatLJc-GZflWSWc', 'bzv', '06739988747', 'assets/img/icons/2025-11-01/.jpeg', NULL, '2025-11-01', 0),
(59, 'cusL-0010', NULL, 0, 'hemercia', '045467893@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'Not Set', '045467893', NULL, 'Not Set', '2025-11-02', 1),
(60, 'cusL-0011', NULL, 0, 'test@gmail', 'testpghone@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'Not Set', 'testpghone', NULL, 'Not Set', '2025-11-03', 1),
(61, 'cusL-0012', NULL, 0, 'etstqr', '0977376733@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'Not Set', '0977376733', NULL, 'Not Set', '2025-11-08', 1),
(62, 'cusL-0013', NULL, 0, 'simonnn', '0645565372@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'Not Set', '0645565372', NULL, 'Not Set', '2025-11-08', 1),
(63, 'cusL-0014', NULL, 0, 'joeldy qr', '088973824863@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'Not Set', '088973824863', NULL, 'Not Set', '2025-11-08', 1),
(64, 'cusL-0015', NULL, 0, 'joeldy simon pierre', '048329756\"&@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'Not Set', '048329756\"&', NULL, 'Not Set', '2025-11-08', 1),
(65, 'cusL-0016', NULL, 0, 'joeldy simon pierre', '234324524@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'Not Set', '234324524', NULL, 'Not Set', '2025-11-08', 1),
(66, 'cusL-0017', NULL, 0, 'simon', '1324@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'Not Set', '1324', NULL, 'Not Set', '2025-11-08', 1),
(67, 'cusL-0018', NULL, 0, 'tes', 'tes@gmail.com', NULL, NULL, 'Avenue ngamaba', '050489037', NULL, '', NULL, 1),
(68, 'cusL-0019', NULL, 0, 'tes', '0988787287392@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'Not Set', '0988787287392', NULL, 'Not Set', '2025-11-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_membership_map`
--

CREATE TABLE `customer_membership_map` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `active_date` date NOT NULL,
  `active_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `order_id` bigint(20) NOT NULL,
  `saleinvoice` varchar(100) NOT NULL,
  `marge_order_id` varchar(30) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `cutomertype` int(11) NOT NULL,
  `isthirdparty` int(11) NOT NULL DEFAULT 0 COMMENT '0=normal,1>all Third Party',
  `thirdpartyinvoiceid` int(11) DEFAULT NULL,
  `waiter_id` int(11) DEFAULT NULL,
  `kitchen` int(11) DEFAULT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `cookedtime` time NOT NULL DEFAULT '00:15:00',
  `table_no` int(11) DEFAULT NULL,
  `tokenno` varchar(30) DEFAULT NULL,
  `totalamount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `customerpaid` decimal(10,2) DEFAULT 0.00,
  `customer_note` text DEFAULT NULL,
  `anyreason` text DEFAULT NULL,
  `order_status` tinyint(1) NOT NULL COMMENT '1=Pending, 2=Processing, 3=Ready, 4=Served,5=Cancel',
  `nofification` int(11) NOT NULL DEFAULT 0 COMMENT '0=unseen,1=seen',
  `orderacceptreject` int(11) DEFAULT NULL,
  `splitpay_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=no split,1=split',
  `isupdate` int(11) DEFAULT NULL,
  `shipping_date` datetime DEFAULT '1790-01-01 01:01:01',
  `tokenprint` int(11) NOT NULL DEFAULT 0 COMMENT '1=print done,0=not done',
  `invoiceprint` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`order_id`, `saleinvoice`, `marge_order_id`, `customer_id`, `cutomertype`, `isthirdparty`, `thirdpartyinvoiceid`, `waiter_id`, `kitchen`, `order_date`, `order_time`, `cookedtime`, `table_no`, `tokenno`, `totalamount`, `customerpaid`, `customer_note`, `anyreason`, `order_status`, `nofification`, `orderacceptreject`, `splitpay_status`, `isupdate`, `shipping_date`, `tokenprint`, `invoiceprint`) VALUES
(1, '0001', NULL, 55, 99, 0, NULL, 0, NULL, '2025-10-31', '10:05:29', '00:15:00', NULL, NULL, 0.00, 0.00, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(2, '0002', NULL, 54, 2, 0, NULL, 0, NULL, '2025-10-31', '12:18:17', '00:15:00', 0, '01', 24.23, 24.23, '', '', 4, 1, 1, 0, NULL, '2025-10-31 12:17:00', 0, NULL),
(3, '0003', NULL, 54, 2, 0, NULL, 0, NULL, '2025-10-31', '22:03:33', '00:15:00', 0, '02', 104.50, 104.50, '', '', 4, 1, 1, 0, NULL, '2025-10-31 10:01:00', 0, NULL),
(4, '0004', NULL, 54, 2, 0, NULL, 0, NULL, '2025-10-31', '22:09:05', '00:15:00', 0, '03', 95.00, 95.00, '', '', 4, 1, 1, 0, NULL, '2025-10-31 10:08:00', 0, NULL),
(5, '0005', NULL, 1, 1, 0, NULL, 0, NULL, '2025-10-31', '22:47:49', '00:15:00', 2, '04', 91.20, 91.20, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(6, '0006', NULL, 54, 2, 0, NULL, 0, NULL, '2025-11-01', '03:02:36', '00:15:00', 0, '01', 76.00, 76.00, '', '', 4, 1, 1, 0, NULL, '2025-11-01 10:55:00', 0, NULL),
(7, '0007', NULL, 56, 2, 0, NULL, 0, NULL, '2025-11-01', '04:37:12', '00:15:00', 0, '02', 38.00, 38.00, '', '', 4, 1, 1, 0, NULL, '2025-11-01 11:24:00', 0, NULL),
(8, '0008', NULL, 57, 99, 0, NULL, 0, NULL, '2025-11-01', '12:37:56', '00:15:00', NULL, NULL, 339.15, 339.15, '', '', 4, 1, 1, 0, 1, '1790-01-01 01:01:01', 0, NULL),
(9, '0009', NULL, 58, 99, 0, NULL, 0, NULL, '2025-11-01', '12:45:24', '00:15:00', NULL, NULL, 5415.00, 5415.00, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(10, '0010', NULL, 58, 99, 0, NULL, 0, NULL, '2025-11-01', '12:46:28', '00:15:00', NULL, NULL, 2525.10, 2525.10, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(11, '0011', NULL, 36, 99, 0, NULL, 178, NULL, '2025-11-01', '13:21:09', '00:15:00', 2, '01', 114.00, 114.00, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(12, '0012', NULL, 55, 4, 0, NULL, 178, NULL, '2025-11-01', '13:22:50', '00:15:00', 0, '02', 182.40, 182.40, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(13, '0013', NULL, 1, 1, 0, NULL, 178, NULL, '2025-11-01', '13:32:51', '00:15:00', 3, '03', 256.50, 256.50, '', NULL, 4, 1, NULL, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(14, '0014', NULL, 56, 3, 4, NULL, 0, NULL, '2025-11-01', '13:34:47', '00:15:00', 0, '04', 228.00, 228.00, '', NULL, 4, 1, NULL, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(15, '0015', NULL, 56, 2, 0, NULL, 178, NULL, '2025-11-01', '13:35:23', '00:15:00', 0, '05', 456.00, 456.00, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(16, '0016', NULL, 1, 1, 0, NULL, 178, NULL, '2025-11-01', '18:04:42', '00:15:00', 3, '06', 132.00, 0.00, '', '', 5, 1, 0, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(17, '0017', NULL, 1, 1, 0, NULL, 178, NULL, '2025-11-01', '18:05:25', '00:15:00', 2, '07', 24.00, 0.00, '', '', 5, 1, 0, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(18, '0018', NULL, 1, 1, 0, NULL, 178, NULL, '2025-11-01', '18:05:45', '00:15:00', 7, '08', 180.00, 0.00, '', '', 5, 1, 0, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(19, '0019', NULL, 1, 1, 0, NULL, 178, NULL, '2025-11-01', '18:07:03', '00:15:00', 9, '09', 120.00, 0.00, '', '', 5, 1, 0, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(20, '0020', NULL, 1, 1, 0, NULL, 178, NULL, '2025-11-01', '18:07:33', '00:15:00', 6, '10', 28.50, 28.50, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(21, '0021', NULL, 1, 2, 0, NULL, 178, NULL, '2025-11-01', '18:08:10', '00:15:00', 0, '11', 45.60, 45.60, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(22, '0022', NULL, 1, 2, 0, NULL, 178, NULL, '2025-11-01', '18:08:33', '00:15:00', 0, '12', 171.00, 171.00, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(23, '0023', NULL, 1, 1, 0, NULL, 178, NULL, '2025-11-01', '18:11:10', '00:15:00', 10, '13', 528.00, 0.00, '', 'test', 5, 1, 0, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(24, '0024', NULL, 1, 1, 0, NULL, 178, NULL, '2025-11-01', '18:11:37', '00:15:00', 1, '14', 156.00, 0.00, '', '', 5, 1, 0, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(25, '0025', NULL, 1, 1, 0, NULL, 178, NULL, '2025-11-01', '18:14:20', '00:15:00', 8, '15', 102.60, 102.60, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(26, '0026', NULL, 55, 4, 0, NULL, 178, NULL, '2025-11-01', '18:41:07', '00:15:00', 0, '16', 48.00, 0.00, '', '', 5, 1, 0, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(27, '0027', NULL, 55, 4, 0, NULL, 178, NULL, '2025-11-01', '18:41:36', '00:15:00', 0, '17', 360.00, 0.00, '', '', 5, 1, 0, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(28, '0028', NULL, 55, 4, 0, NULL, 178, NULL, '2025-11-01', '18:41:52', '00:15:00', NULL, '18', 0.00, 0.00, '', '', 5, 1, 0, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(29, '0029', NULL, 54, 2, 0, NULL, 178, NULL, '2025-11-01', '22:45:00', '00:15:00', 0, '19', 497.04, 497.04, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(30, '0030', NULL, 54, 2, 0, NULL, 178, NULL, '2025-11-01', '22:45:08', '00:15:00', 0, '20', 148.20, 148.20, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(31, '0031', NULL, 54, 2, 0, NULL, 178, NULL, '2025-11-01', '22:45:17', '00:15:00', 0, '21', 156.00, 0.00, '', 'test', 5, 1, 0, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(32, '0032', NULL, 59, 99, 0, NULL, 0, NULL, '2025-11-02', '12:39:10', '00:15:00', NULL, NULL, 801.80, 801.80, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(33, '0033', NULL, 60, 99, 0, NULL, 0, NULL, '2025-11-03', '01:10:06', '00:15:00', NULL, NULL, 307.80, 307.80, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(34, '0034', NULL, 1, 2, 0, NULL, 179, NULL, '2025-11-03', '20:58:33', '00:15:00', 0, '01', 22.80, 22.80, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(35, '0035', NULL, 54, 2, 0, NULL, 0, NULL, '2025-11-07', '21:46:52', '00:15:00', 0, '01', 19.00, 19.00, '', '', 4, 1, 1, 0, NULL, '2025-11-07 21:40:00', 0, NULL),
(36, '0036', NULL, 54, 2, 0, NULL, 0, NULL, '2025-11-07', '21:49:15', '00:15:00', 0, '02', 123.50, 123.50, '', '', 4, 1, 1, 0, NULL, '2025-11-07 21:48:00', 0, NULL),
(37, '0037', NULL, 54, 99, 0, NULL, 178, NULL, '2025-11-08', '21:49:40', '00:15:00', 2, '01', 148.20, 148.20, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(38, '0038', NULL, 1, 99, 0, NULL, 179, NULL, '2025-11-08', '21:50:59', '00:15:00', 3, '02', 22.80, 22.80, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(39, '0039', NULL, 61, 99, 0, NULL, 0, NULL, '2025-11-08', '21:51:39', '00:15:00', NULL, NULL, 228.00, 228.00, 'tets', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(40, '0040', NULL, 62, 99, 0, NULL, 0, NULL, '2025-11-08', '21:56:54', '00:15:00', NULL, NULL, 171.00, 171.00, 'dzegtbrh', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(41, '0041', NULL, 63, 99, 0, NULL, 0, NULL, '2025-11-08', '22:39:48', '00:15:00', NULL, NULL, 359.10, 359.10, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(42, '0042', NULL, 64, 99, 0, NULL, 0, NULL, '2025-11-08', '22:41:31', '00:15:00', NULL, NULL, 615.60, 615.60, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(43, '0043', NULL, 65, 99, 0, NULL, 0, NULL, '2025-11-08', '23:10:59', '00:15:00', NULL, NULL, 307.80, 307.80, 'do it quick', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(45, '0045', NULL, 36, 1, 0, NULL, 178, NULL, '2025-11-09', '00:53:53', '00:15:00', 3, '01', 22.80, 22.80, '', NULL, 4, 1, NULL, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(46, '0046', NULL, 54, 99, 0, NULL, 178, NULL, '2025-11-09', '04:54:58', '00:15:00', 12, '02', 313.50, 313.50, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(47, '0047', NULL, 56, 2, 0, NULL, 179, NULL, '2025-11-09', '04:56:07', '00:15:00', 0, '03', 798.00, 798.00, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(48, '0048', NULL, 67, 2, 0, NULL, 178, NULL, '2025-11-11', '23:59:37', '00:15:00', 0, '01', 125.40, 125.40, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(49, '0049', NULL, 56, 99, 0, NULL, 179, NULL, '2025-11-12', '00:02:29', '00:15:00', 3, '01', 22.80, 22.80, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(50, '0050', NULL, 56, 1, 0, NULL, 178, NULL, '2025-11-12', '00:04:00', '00:15:00', 6, '02', 22.80, 22.80, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(51, '0051', NULL, 67, 1, 0, NULL, 178, NULL, '2025-11-12', '00:15:23', '00:15:00', 2, '03', 216.60, 216.60, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(52, '0052', NULL, 67, 2, 0, NULL, 178, NULL, '2025-11-12', '00:22:14', '00:15:00', NULL, '04', 365.75, 365.75, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(53, '0053', NULL, 1, 1, 0, NULL, 178, NULL, '2025-11-12', '00:27:38', '00:15:00', 3, '05', 524.40, 524.40, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(54, '0054', NULL, 36, 3, 3, NULL, 0, NULL, '2025-11-12', '00:28:10', '00:15:00', 0, '06', 250.80, 250.80, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(55, '0055', NULL, 36, 4, 0, NULL, 178, NULL, '2025-11-12', '00:28:26', '00:15:00', 0, '07', 1596.00, 1596.00, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(56, '0056', NULL, 36, 99, 0, NULL, 178, NULL, '2025-11-12', '00:28:50', '00:15:00', 6, '08', 1043.10, 1043.10, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(57, '0057', NULL, 36, 99, 0, NULL, 178, NULL, '2025-11-12', '00:29:06', '00:15:00', 7, '09', 125.40, 125.40, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(58, '0058', NULL, 36, 99, 0, NULL, 178, NULL, '2025-11-12', '00:33:44', '00:15:00', 6, '10', 205.20, 205.20, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(59, '0059', NULL, 67, 2, 0, NULL, 178, NULL, '2025-11-12', '00:34:36', '00:15:00', 0, '11', 57.00, 57.00, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(60, '0060', NULL, 67, 99, 0, NULL, 178, NULL, '2025-11-12', '00:35:25', '00:15:00', 7, '12', 588.24, 588.24, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(61, '0061', NULL, 67, 1, 0, NULL, 178, NULL, '2025-11-12', '00:39:20', '00:15:00', 6, '13', 125.40, 125.40, '', NULL, 4, 1, NULL, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(62, '0062', NULL, 67, 1, 0, NULL, 179, NULL, '2025-11-12', '00:39:43', '00:15:00', 9, '14', 22.80, 22.80, '', NULL, 4, 1, NULL, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(63, '0063', NULL, 67, 1, 0, NULL, 179, NULL, '2025-11-12', '00:40:09', '00:15:00', 7, '15', 461.70, 461.70, '', NULL, 4, 1, NULL, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(64, '0064', NULL, 67, 99, 0, NULL, 178, NULL, '2025-11-12', '00:41:39', '00:15:00', 11, '16', 125.40, 125.40, '', '', 4, 1, 1, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(65, '0065', NULL, 68, 99, 0, NULL, 178, NULL, '2025-11-12', '01:00:16', '00:15:00', 2, NULL, 0.00, 0.00, '', '', 5, 1, 0, 0, NULL, '1790-01-01 01:01:01', 0, NULL),
(66, '0066', NULL, 68, 2, 0, NULL, 0, NULL, '2025-11-12', '01:01:48', '00:15:00', 0, '01', 403.75, 403.75, '', '', 4, 1, 1, 0, NULL, '2025-11-12 09:55:00', 0, NULL),
(67, '0067', NULL, 68, 2, 0, NULL, 0, NULL, '2025-11-12', '01:04:43', '00:15:00', 0, '02', 441.75, 441.75, '', '', 4, 1, 1, 0, NULL, '2025-11-12 11:05:00', 0, NULL),
(68, '0068', NULL, 67, 1, 0, NULL, 178, NULL, '2025-11-12', '01:07:17', '00:15:00', 11, '03', 307.80, 307.80, '', NULL, 4, 1, NULL, 0, NULL, '1790-01-01 01:01:01', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_type`
--

CREATE TABLE `customer_type` (
  `customer_type_id` int(11) NOT NULL,
  `customer_type` varchar(100) NOT NULL,
  `ordering` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer_type`
--

INSERT INTO `customer_type` (`customer_type_id`, `customer_type`, `ordering`) VALUES
(1, 'Walk In Customer', 0),
(2, 'Online Customer', 0),
(3, 'Third Party', 0),
(4, 'Take Way', 0),
(99, 'QR Customer', 0);

-- --------------------------------------------------------

--
-- Table structure for table `custom_table`
--

CREATE TABLE `custom_table` (
  `custom_id` int(11) NOT NULL,
  `custom_field` varchar(100) NOT NULL,
  `custom_data_type` int(11) NOT NULL,
  `custom_data` text NOT NULL,
  `employee_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `custom_table`
--

INSERT INTO `custom_table` (`custom_id`, `custom_field`, `custom_data_type`, `custom_data`, `employee_id`) VALUES
(52, 'Chinese Cuisine', 1, 'coffee roastery located on a busy corner site in Farringdon\'s Exmouth Market. With glazed frontage on two sides ', 'EU3APTYY'),
(54, 'French Suicine', 1, 'coffee roastery located on a busy corner site in Farringdon\'s Exmouth Market. With glazed frontage on two sides ', 'EXL9WSCL'),
(55, 'Chinese Cuisine', 1, 'coffee roastery located on a busy corner site in Farringdon\'s Exmouth Market. With glazed frontage on two sides ', 'E3Y1WJMB'),
(56, 'Kitchen Lead', 1, 'coffee roastery located on a busy corner site in Farringdon\'s Exmouth Market. With glazed frontage on two sides ', 'EBK2UPRA');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `department_name`, `parent_id`) VALUES
(8, 'ACCOUNTING', 0),
(9, 'Human Resource', 0),
(10, 'Delivery department', 0),
(11, 'Garage and Parking', 0),
(12, 'Manager', 0),
(13, 'Restaurant', 0),
(14, 'Waiter', 13),
(15, 'Senior Accountant', 8),
(16, 'Kitchen Manager', 12),
(17, 'Chef', 13),
(18, 'Sales Manager', 12);

-- --------------------------------------------------------

--
-- Table structure for table `duty_type`
--

CREATE TABLE `duty_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `duty_type`
--

INSERT INTO `duty_type` (`id`, `type_name`) VALUES
(1, 'Full Time'),
(2, 'Part Time'),
(3, 'Contructual'),
(4, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE `email_config` (
  `email_config_id` int(11) NOT NULL,
  `smtp_host` varchar(200) DEFAULT NULL,
  `smtp_port` varchar(200) DEFAULT NULL,
  `smtp_password` varchar(200) DEFAULT NULL,
  `protocol` text NOT NULL,
  `mailpath` text NOT NULL,
  `mailtype` text NOT NULL,
  `sender` text NOT NULL,
  `api_key` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `email_config`
--

INSERT INTO `email_config` (`email_config_id`, `smtp_host`, `smtp_port`, `smtp_password`, `protocol`, `mailpath`, `mailtype`, `sender`, `api_key`, `status`) VALUES
(1, 'ssl://smtp.googlemail.com', '465', '123456', 'SMTP', '/usr/sbin/sendmail', 'html', 'ainalcse@gmail.com', '22c4c92a-e5a8-4293-b64c-befc9248521e', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_benifit`
--

CREATE TABLE `employee_benifit` (
  `id` int(11) NOT NULL,
  `bnf_cl_code` varchar(100) NOT NULL,
  `bnf_cl_code_des` varchar(250) NOT NULL,
  `bnff_acural_date` date NOT NULL,
  `bnf_status` tinyint(4) NOT NULL,
  `employee_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_history`
--

CREATE TABLE `employee_history` (
  `emp_his_id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL,
  `pos_id` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(32) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `alter_phone` varchar(30) DEFAULT NULL,
  `present_address` varchar(100) DEFAULT NULL,
  `parmanent_address` varchar(100) DEFAULT NULL,
  `picture` text DEFAULT NULL,
  `degree_name` varchar(30) DEFAULT NULL,
  `university_name` varchar(50) DEFAULT NULL,
  `cgp` varchar(30) DEFAULT NULL,
  `passing_year` varchar(30) DEFAULT NULL,
  `company_name` varchar(30) DEFAULT NULL,
  `working_period` varchar(30) DEFAULT NULL,
  `duties` varchar(30) DEFAULT NULL,
  `supervisor` varchar(30) DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `is_admin` int(11) NOT NULL DEFAULT 0,
  `dept_id` int(11) DEFAULT NULL,
  `division_id` int(11) NOT NULL,
  `maiden_name` varchar(50) DEFAULT NULL,
  `state` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `zip` int(11) NOT NULL,
  `citizenship` int(11) NOT NULL,
  `duty_type` int(11) NOT NULL,
  `hire_date` date NOT NULL,
  `original_hire_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `termination_reason` text NOT NULL,
  `voluntary_termination` int(11) NOT NULL,
  `rehire_date` date NOT NULL,
  `rate_type` int(11) NOT NULL,
  `rate` float NOT NULL,
  `pay_frequency` int(11) NOT NULL,
  `pay_frequency_txt` varchar(50) NOT NULL,
  `hourly_rate2` float NOT NULL,
  `hourly_rate3` float NOT NULL,
  `home_department` varchar(100) NOT NULL,
  `department_text` varchar(100) NOT NULL,
  `class_code` varchar(50) DEFAULT NULL,
  `class_code_desc` varchar(100) DEFAULT NULL,
  `class_acc_date` date DEFAULT NULL,
  `class_status` tinyint(4) DEFAULT NULL,
  `is_super_visor` int(11) DEFAULT NULL,
  `super_visor_id` varchar(30) NOT NULL,
  `supervisor_report` text NOT NULL,
  `dob` date NOT NULL,
  `gender` int(11) NOT NULL,
  `country` varchar(120) DEFAULT NULL,
  `marital_status` int(11) NOT NULL,
  `ethnic_group` varchar(100) NOT NULL,
  `eeo_class_gp` varchar(100) NOT NULL,
  `ssn` varchar(50) DEFAULT NULL,
  `work_in_state` int(11) NOT NULL,
  `live_in_state` int(11) NOT NULL,
  `home_email` varchar(50) NOT NULL,
  `business_email` varchar(50) NOT NULL,
  `home_phone` varchar(30) NOT NULL,
  `business_phone` varchar(30) NOT NULL,
  `cell_phone` varchar(30) NOT NULL,
  `emerg_contct` varchar(30) NOT NULL,
  `emrg_h_phone` varchar(30) NOT NULL,
  `emrg_w_phone` varchar(30) NOT NULL,
  `emgr_contct_relation` varchar(50) NOT NULL,
  `alt_em_contct` varchar(30) NOT NULL,
  `alt_emg_h_phone` varchar(30) NOT NULL,
  `alt_emg_w_phone` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `employee_history`
--

INSERT INTO `employee_history` (`emp_his_id`, `employee_id`, `pos_id`, `first_name`, `middle_name`, `last_name`, `email`, `phone`, `alter_phone`, `present_address`, `parmanent_address`, `picture`, `degree_name`, `university_name`, `cgp`, `passing_year`, `company_name`, `working_period`, `duties`, `supervisor`, `signature`, `is_admin`, `dept_id`, `division_id`, `maiden_name`, `state`, `city`, `zip`, `citizenship`, `duty_type`, `hire_date`, `original_hire_date`, `termination_date`, `termination_reason`, `voluntary_termination`, `rehire_date`, `rate_type`, `rate`, `pay_frequency`, `pay_frequency_txt`, `hourly_rate2`, `hourly_rate3`, `home_department`, `department_text`, `class_code`, `class_code_desc`, `class_acc_date`, `class_status`, `is_super_visor`, `super_visor_id`, `supervisor_report`, `dob`, `gender`, `country`, `marital_status`, `ethnic_group`, `eeo_class_gp`, `ssn`, `work_in_state`, `live_in_state`, `home_email`, `business_email`, `home_phone`, `business_phone`, `cell_phone`, `emerg_contct`, `emrg_h_phone`, `emrg_w_phone`, `emgr_contct_relation`, `alt_em_contct`, `alt_emg_h_phone`, `alt_emg_w_phone`) VALUES
(162, 'EY2T1OWA', '4', 'jahangir', NULL, 'Ahmad', 'jahangir@gmail.com', '0195511016', NULL, NULL, NULL, './application/modules/employee/assets/images/2018-09-20/pra.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 15, 3, NULL, 'New York', 'New', 234234, 0, 1, '2018-09-19', '2018-09-19', '2018-09-19', 'sdfasdf', 2, '2018-09-26', 1, 323, 2, '234', 324234, 2523, '234', '234532', '', '', '1970-01-01', 1, NULL, '0', 'dfasdfsdf', '2018-09-19', 1, 'Bangladesh', 2, 'sunni', '234324', '23423', 1, 1, 'u@gmail.com', 'b@gmail.com', 'dsfsdf', 'dsfdsf', 'sdfsdf', '42342323', '234234', '234234', '2343', '234', '324234', '324324'),
(165, '145454', '1', 'Hm', NULL, 'Isahaq', 'hmisahaq@gmail.com', '2344098234', NULL, NULL, NULL, './application/modules/hrm/assets/images/2025-10-31/P1.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 17, 6, NULL, 'Alabama', 'deom', 3243, 0, 1, '2018-09-20', '2018-09-20', '2018-09-29', 'fsdf', 1, '2018-09-29', 1, 234, 3, '234', 0, 0, '', '', '', '', '1970-01-01', 1, NULL, '0', '324', '2018-09-29', 1, 'Bangladesh', 1, 'sdfsdf', '', '23423', 1, 1, '234', 'sd', '82309423', '', '234', '324234', '34242', '546456', '', '', '', ''),
(166, 'EQLAJFUW', '1', 'Ainal', '', 'Haque', 'ainal@gmail.com', '01715234991', NULL, NULL, NULL, './application/modules/hrm/assets/images/2019-01-22/u.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 17, 0, NULL, 'Alabama', '', 0, 1, 1, '2018-11-12', '2018-11-12', '2018-11-12', '', 1, '2018-11-12', 1, 100, 1, '', 0, 0, '', '', '', '', '2018-11-12', 1, NULL, '0', '', '2018-11-12', 1, 'Bangladesh', 1, '', '', '3425', 1, 1, '', '', '017123657332', '', '017123657332', '017123657332', '017123657332', '017123657332', '', '', '', ''),
(168, 'E97E9SJT', '1', 'Manik ', '', 'Hassan', 'manik@gmail.com', '01913251229', NULL, NULL, NULL, './application/modules/hrm/assets/images/2025-10-31/G.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 17, 0, NULL, 'Alabama', 'Dhaka', 143325, 1, 1, '2019-01-01', '2019-01-01', '2021-01-31', 'sdfs', 1, '2022-01-09', 1, 100, 1, '', 0, 0, '', '', '', '', '2019-01-09', 1, NULL, '0', '', '1970-01-01', 1, 'Bangladesh', 1, '', '', 'e4dfg', 1, 1, '', '', '34353636', '', '3636', '345345', '3453', '3453', '', '', '', ''),
(177, 'EZR0A9IB', '1', 'Di', NULL, 'Maria', 'dimaria@gmail.com', '25423456272', NULL, NULL, NULL, './application/modules/hrm/assets/images/2025-10-31/P.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 17, 0, NULL, 'Oklahoma', '', 0, 1, 1, '2021-07-01', '2021-07-01', '2022-02-28', '', 1, '2022-02-28', 1, 200, 1, '', 0, 0, '', '', NULL, NULL, NULL, NULL, NULL, '0', '', '2000-09-01', 1, 'United State', 1, '', '', '', 1, 1, '', '', '457568234', '', '2323223', '366879', '889995454', '234245654', '', '', '', ''),
(178, 'ESBFECDL', '6', 'welcome', NULL, 'marco', 'waiter@example.com', '23', NULL, NULL, NULL, './application/modules/hrm/assets/images/2025-11-01/C.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 14, 0, NULL, 'Brazzaville', 'brazzaville', 0, 1, 1, '2025-11-01', '2025-11-01', '2025-11-01', '', 1, '2025-11-01', 2, 16, 4, '', 0, 0, '', '', NULL, NULL, NULL, NULL, NULL, '1', '', '2020-01-12', 1, 'Congo Brazzaville', 1, '', '', '', 1, 1, '', '', '1234544', '', '3434455', '9876543', '56789988', '45678909776', '', '', '', ''),
(179, 'EIR8IXIS', '6', 'man', NULL, 'maniar', 'mantest@gmail.com', '09876364265', NULL, NULL, NULL, './application/modules/hrm/assets/images/2025-11-03/C.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 14, 0, NULL, '0', 'tourtour', 0, 1, 1, '2025-11-03', '2025-11-03', '2025-11-03', '', 1, '2025-11-03', 1, 12, 2, '', 0, 0, '', '', NULL, NULL, NULL, NULL, NULL, '1', '', '2002-11-03', 2, 'Vietnam', 1, '', '', '', 1, 1, '', '', '0646634692', '', '0646634692', '125657', '27236182787', '8993972', 'my father', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `employee_performance`
--

CREATE TABLE `employee_performance` (
  `emp_per_id` int(10) UNSIGNED NOT NULL,
  `employee_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `note` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `note_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `number_of_star` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `updated_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary_payment`
--

CREATE TABLE `employee_salary_payment` (
  `emp_sal_pay_id` int(10) UNSIGNED NOT NULL,
  `employee_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_salary` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_working_minutes` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `working_period` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `payment_due` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `payment_date` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `paid_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary_setup`
--

CREATE TABLE `employee_salary_setup` (
  `e_s_s_id` int(10) UNSIGNED NOT NULL,
  `employee_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `sal_type` varchar(30) NOT NULL,
  `salary_type_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `amount` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `create_date` date DEFAULT NULL,
  `update_date` datetime(6) DEFAULT NULL,
  `update_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `gross_salary` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `employee_salary_setup`
--

INSERT INTO `employee_salary_setup` (`e_s_s_id`, `employee_id`, `sal_type`, `salary_type_id`, `amount`, `create_date`, `update_date`, `update_id`, `gross_salary`) VALUES
(1, 'EZR0A9IB', '1', '1', '20', '2025-10-30', NULL, '', 400),
(2, 'EZR0A9IB', '1', '2', '80', '2025-10-30', NULL, '', 400);

-- --------------------------------------------------------

--
-- Table structure for table `employee_sal_pay_type`
--

CREATE TABLE `employee_sal_pay_type` (
  `emp_sal_pay_type_id` int(10) UNSIGNED NOT NULL,
  `payment_period` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_attendance`
--

CREATE TABLE `emp_attendance` (
  `att_id` int(10) UNSIGNED NOT NULL,
  `employee_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `sign_in` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `sign_out` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `staytime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `emp_attendance`
--

INSERT INTO `emp_attendance` (`att_id`, `employee_id`, `date`, `sign_in`, `sign_out`, `staytime`) VALUES
(1, 'EY2T1OWA', '2025-10-30', '08:37:05 pm', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(100) NOT NULL,
  `voucher_no` varchar(50) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_item`
--

CREATE TABLE `expense_item` (
  `id` int(11) NOT NULL,
  `expense_item_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facebook_settings`
--

CREATE TABLE `facebook_settings` (
  `id` int(11) NOT NULL,
  `app_id` varchar(100) DEFAULT NULL,
  `app_secret` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `facebook_settings`
--

INSERT INTO `facebook_settings` (`id`, `app_id`, `app_secret`) VALUES
(1, '08650802009429', '37ab16f733c6ec926708b43f9452b8f5');

-- --------------------------------------------------------

--
-- Table structure for table `fcm_token`
--

CREATE TABLE `fcm_token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fcm_tokens`
--

CREATE TABLE `fcm_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fcm_tokens`
--

INSERT INTO `fcm_tokens` (`id`, `user_id`, `token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'egWXc5aoQO_l4FM4EWk3uy:APA91bGdppgUgWU5nRlXmv0IigH2TMOk6y7p5DAzIk3nvOtW_Tvo4Z_Hrc6PV4hiKzoWEG-xxPHQwAg4-TUcuU4cgtfeYZeMqrCOAjcheatLJc-GZflWSWc', '2025-11-01 02:51:06', NULL),
(2, NULL, 'egWXc5aoQO_l4FM4EWk3uy:APA91bGdppgUgWU5nRlXmv0IigH2TMOk6y7p5DAzIk3nvOtW_Tvo4Z_Hrc6PV4hiKzoWEG-xxPHQwAg4-TUcuU4cgtfeYZeMqrCOAjcheatLJc-GZflWSWc', '2025-11-01 03:27:47', NULL),
(3, NULL, 'egWXc5aoQO_l4FM4EWk3uy:APA91bGdppgUgWU5nRlXmv0IigH2TMOk6y7p5DAzIk3nvOtW_Tvo4Z_Hrc6PV4hiKzoWEG-xxPHQwAg4-TUcuU4cgtfeYZeMqrCOAjcheatLJc-GZflWSWc', '2025-11-01 03:43:14', NULL),
(4, NULL, 'egWXc5aoQO_l4FM4EWk3uy:APA91bGdppgUgWU5nRlXmv0IigH2TMOk6y7p5DAzIk3nvOtW_Tvo4Z_Hrc6PV4hiKzoWEG-xxPHQwAg4-TUcuU4cgtfeYZeMqrCOAjcheatLJc-GZflWSWc', '2025-11-01 03:59:32', NULL),
(5, NULL, 'egWXc5aoQO_l4FM4EWk3uy:APA91bGdppgUgWU5nRlXmv0IigH2TMOk6y7p5DAzIk3nvOtW_Tvo4Z_Hrc6PV4hiKzoWEG-xxPHQwAg4-TUcuU4cgtfeYZeMqrCOAjcheatLJc-GZflWSWc', '2025-11-01 04:03:13', NULL),
(6, NULL, 'egWXc5aoQO_l4FM4EWk3uy:APA91bGdppgUgWU5nRlXmv0IigH2TMOk6y7p5DAzIk3nvOtW_Tvo4Z_Hrc6PV4hiKzoWEG-xxPHQwAg4-TUcuU4cgtfeYZeMqrCOAjcheatLJc-GZflWSWc', '2025-11-01 04:03:39', NULL),
(7, NULL, 'egWXc5aoQO_l4FM4EWk3uy:APA91bGdppgUgWU5nRlXmv0IigH2TMOk6y7p5DAzIk3nvOtW_Tvo4Z_Hrc6PV4hiKzoWEG-xxPHQwAg4-TUcuU4cgtfeYZeMqrCOAjcheatLJc-GZflWSWc', '2025-11-01 04:04:06', NULL),
(8, NULL, 'egWXc5aoQO_l4FM4EWk3uy:APA91bGdppgUgWU5nRlXmv0IigH2TMOk6y7p5DAzIk3nvOtW_Tvo4Z_Hrc6PV4hiKzoWEG-xxPHQwAg4-TUcuU4cgtfeYZeMqrCOAjcheatLJc-GZflWSWc', '2025-11-01 04:05:57', NULL),
(9, NULL, 'egWXc5aoQO_l4FM4EWk3uy:APA91bGdppgUgWU5nRlXmv0IigH2TMOk6y7p5DAzIk3nvOtW_Tvo4Z_Hrc6PV4hiKzoWEG-xxPHQwAg4-TUcuU4cgtfeYZeMqrCOAjcheatLJc-GZflWSWc', '2025-11-01 04:07:25', NULL),
(10, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 04:34:38', NULL),
(11, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 04:34:59', NULL),
(12, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 12:14:29', NULL),
(13, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 12:14:33', NULL),
(14, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 12:34:48', NULL),
(15, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 12:35:52', NULL),
(16, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 12:36:58', NULL),
(17, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 12:38:01', NULL),
(18, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 12:41:56', NULL),
(19, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 12:44:07', NULL),
(20, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 12:44:32', NULL),
(21, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 12:45:59', NULL),
(22, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 12:46:31', NULL),
(23, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 13:57:39', NULL),
(24, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 13:58:11', NULL),
(25, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 17:46:36', NULL),
(26, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:10:15', NULL),
(27, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:10:27', NULL),
(28, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:47:07', NULL),
(29, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:47:32', NULL),
(30, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:47:37', NULL),
(31, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:52:55', NULL),
(32, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:53:05', NULL),
(33, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:53:19', NULL),
(34, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:55:25', NULL),
(35, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:58:03', NULL),
(36, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:58:38', NULL),
(37, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:59:32', NULL),
(38, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 21:59:52', NULL),
(39, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 22:00:47', NULL),
(40, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 22:00:52', NULL),
(41, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-01 22:10:03', NULL),
(42, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-02 12:38:24', NULL),
(43, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-02 12:38:34', NULL),
(44, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-02 12:39:15', NULL),
(45, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-02 12:52:43', NULL),
(46, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-02 13:45:10', NULL),
(47, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-02 13:49:47', NULL),
(48, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-02 14:02:32', NULL),
(49, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-02 15:16:24', NULL),
(50, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 00:18:02', NULL),
(51, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 00:18:27', NULL),
(52, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 01:08:36', NULL),
(53, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 01:09:12', NULL),
(54, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 01:10:10', NULL),
(55, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 01:19:55', NULL),
(56, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 01:48:49', NULL),
(57, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 11:45:49', NULL),
(58, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 11:46:04', NULL),
(59, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 11:46:20', NULL),
(60, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 20:11:32', NULL),
(61, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 20:24:08', NULL),
(62, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 20:24:55', NULL),
(63, NULL, 'cM5qypJkyyjRyl2zE10nra:APA91bEEM-WszQTZKyN6PAOyFG7lmQ-tkrDArDNGfOiaEp76W1CKVni6KOpix_MO93UrspXRP9LU8KkNNTexXaXAToiyWK46RQx_eawTVs0uH7KWwlPbgiM', '2025-11-03 21:45:13', NULL),
(64, NULL, 'fBrK3ge_voAMfIcuOhf31G:APA91bEih8L5kZ3bYuOPfVH4M530cyztREp0ap_VBoSv-ZinVsMMmo-oty09bi-fQtI1NSU2X9haA_NRHnR-U6zji_X9OnDSmLjhQFDFv0QnOZrjmS3mK1s', '2025-11-08 09:34:33', NULL),
(65, NULL, 'fzT_zC3z0DprmMaT4Ldrkp:APA91bEKyY3jl5AofvE-1ns_DZfT32I0rbKDadZFV02O_fsbVNnwnfDR-YRA2EjKZYQeVfJPg21VKbe3mcOyamyo67_4jV1VihM9cgFr7ICfpvrwEgePjuo', '2025-11-08 10:13:58', NULL),
(66, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 17:49:22', NULL),
(67, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 21:48:52', NULL),
(68, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 21:51:18', NULL),
(69, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 21:51:44', NULL),
(70, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 21:56:59', NULL),
(71, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 22:20:55', NULL),
(72, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 22:39:18', NULL),
(73, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 22:39:54', NULL),
(74, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 22:40:52', NULL),
(75, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 22:41:35', NULL),
(76, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 22:42:12', NULL),
(77, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 23:10:27', NULL),
(78, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 23:11:03', NULL),
(79, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-08 23:17:12', NULL),
(80, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-09 00:40:59', NULL),
(81, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-09 00:41:07', NULL),
(82, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-09 02:12:56', NULL),
(83, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-09 02:47:01', NULL),
(84, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-09 04:49:55', NULL),
(85, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-09 04:50:02', NULL),
(86, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-09 20:46:01', NULL),
(87, NULL, 'fEbCun9GYYM8Bwg3fmpGdq:APA91bHsKT1rXwJEp1hleLCK2pxTa3GDABznJn88IOQmlnj8dMIGvclg5a0w0VpIzVClHuc6ILAC4cIi7s_3uqL8N4zUERmqq1gNyxdQhR0_TRGCjuAMx7A', '2025-11-09 20:46:24', NULL),
(88, NULL, 'fU2Xl6CFkeyzAjFTo4kFrh:APA91bHGkpD2QTQISVm7tuR9RUv7tP9xJdPkdZn-3RllwyO3tAkMGE6ZXvBdtNUStwKRhVxYg5l-Bez6gN2h3ttSXCz5Vyg_NbTEayOV8LuJVbvXeYqRDxU', '2025-11-12 01:00:20', NULL),
(89, NULL, 'fU2Xl6CFkeyzAjFTo4kFrh:APA91bHGkpD2QTQISVm7tuR9RUv7tP9xJdPkdZn-3RllwyO3tAkMGE6ZXvBdtNUStwKRhVxYg5l-Bez6gN2h3ttSXCz5Vyg_NbTEayOV8LuJVbvXeYqRDxU', '2025-11-12 01:24:51', NULL),
(90, NULL, 'fU2Xl6CFkeyzAjFTo4kFrh:APA91bHGkpD2QTQISVm7tuR9RUv7tP9xJdPkdZn-3RllwyO3tAkMGE6ZXvBdtNUStwKRhVxYg5l-Bez6gN2h3ttSXCz5Vyg_NbTEayOV8LuJVbvXeYqRDxU', '2025-11-12 10:23:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `foodvariable`
--

CREATE TABLE `foodvariable` (
  `availableID` int(11) NOT NULL,
  `foodid` int(11) NOT NULL,
  `availtime` varchar(50) NOT NULL,
  `availday` varchar(30) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `gender_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `gender_name`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `grand_loan`
--

CREATE TABLE `grand_loan` (
  `loan_id` int(11) NOT NULL,
  `employee_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `permission_by` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `loan_details` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `amount` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `interest_rate` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `installment` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `installment_period` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `repayment_amount` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_of_approve` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `repayment_start_date` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_by` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `updated_by` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `loan_status` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `ingredient_name` varchar(250) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `stock_qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `min_stock` decimal(10,2) NOT NULL DEFAULT 1.00,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=kitchenitems,1=otheritems',
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `ingredient_name`, `uom_id`, `stock_qty`, `min_stock`, `status`, `is_active`) VALUES
(1, 'Lemon', 6, 0.00, 0.00, 0, 1),
(2, 'Pepper', 3, 0.00, 0.00, 0, 1),
(3, 'Salt', 1, 0.00, 0.00, 0, 1),
(4, 'Egg', 6, 0.00, 0.00, 0, 1),
(5, 'Egg', 6, 0.00, 0.00, 0, 1),
(6, 'Coffee', 1, 0.00, 0.00, 0, 1),
(7, 'Water', 2, 0.00, 0.00, 0, 1),
(8, 'Chilli', 1, 0.00, 0.00, 0, 1),
(9, 'Potato', 1, 0.00, 0.00, 0, 1),
(10, 'Potato', 1, 0.00, 0.00, 0, 1),
(11, 'Sauce', 1, 0.00, 0.00, 0, 1),
(12, 'Mutton', 1, 0.00, 0.00, 0, 1),
(13, 'Chickens ', 1, 0.00, 0.00, 0, 1),
(14, 'Cheese', 1, 0.00, 0.00, 0, 1),
(15, 'Beef', 1, 0.00, 10.00, 0, 1),
(16, 'Oil', 2, 0.00, 5.00, 0, 1),
(17, 'Onion', 3, 11.00, 1000.00, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `CategoryImage` varchar(255) DEFAULT NULL,
  `Position` int(11) DEFAULT NULL,
  `CategoryIsActive` int(11) DEFAULT NULL,
  `offerstartdate` date DEFAULT '0000-00-00',
  `offerendate` date NOT NULL DEFAULT '0000-00-00',
  `isoffer` int(11) DEFAULT 0,
  `parentid` int(11) DEFAULT 0,
  `UserIDInserted` int(11) NOT NULL DEFAULT 0,
  `UserIDUpdated` int(11) NOT NULL DEFAULT 0,
  `UserIDLocked` int(11) NOT NULL DEFAULT 0,
  `DateInserted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DateUpdated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DateLocked` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`CategoryID`, `Name`, `CategoryImage`, `Position`, `CategoryIsActive`, `offerstartdate`, `offerendate`, `isoffer`, `parentid`, `UserIDInserted`, `UserIDUpdated`, `UserIDLocked`, `DateInserted`, `DateUpdated`, `DateLocked`) VALUES
(1, 'Squid Fry', './application/modules/itemmanage/assets/images/2025-10-30/S.jpg', NULL, 1, '2025-10-31', '2025-11-30', 1, 0, 2, 2, 2, '2025-10-30 20:41:53', '2025-10-30 20:41:53', '2025-10-30 20:41:53'),
(2, 'Vegan Pasta Sauce', './application/modules/itemmanage/assets/images/2025-10-30/G.jpg', NULL, 1, '2025-10-31', '2026-01-30', 1, 0, 2, 2, 2, '2025-10-30 20:42:36', '2025-10-30 20:42:36', '2025-10-30 20:42:36'),
(3, 'Pasta', './application/modules/itemmanage/assets/images/2025-10-30/S1.jpg', NULL, 1, '2025-10-30', '2025-12-27', 1, 0, 2, 2, 2, '2025-10-30 20:43:05', '2025-10-30 20:43:05', '2025-10-30 20:43:05'),
(4, 'Vegetable sharma', './application/modules/itemmanage/assets/images/2025-10-30/.jpeg', NULL, 1, '2025-10-30', '2025-12-31', 1, 0, 2, 2, 2, '2025-10-30 20:45:57', '2025-10-30 20:45:57', '2025-10-30 20:45:57'),
(5, 'Cheese Loven Pizza', './application/modules/itemmanage/assets/images/2025-10-30/C.png', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:47:50', '2025-10-30 20:47:50', '2025-10-30 20:47:50'),
(6, 'Vegetable Pizza', './application/modules/itemmanage/assets/images/2025-10-30/v.png', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:48:23', '2025-10-30 20:48:23', '2025-10-30 20:48:23'),
(7, 'Pizza Amount', './application/modules/itemmanage/assets/images/2025-10-30/C1.png', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:48:52', '2025-10-30 20:48:52', '2025-10-30 20:48:52'),
(8, 'Chicken Swarma Roll', './application/modules/itemmanage/assets/images/2025-10-30/C.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:49:18', '2025-10-30 20:49:18', '2025-10-30 20:49:18'),
(9, 'Beef Swarma', './application/modules/itemmanage/assets/images/2025-10-30/b.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:49:38', '2025-10-30 20:49:38', '2025-10-30 20:49:38'),
(10, 'Swarma', './application/modules/itemmanage/assets/images/2025-10-30/1.jpeg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:49:57', '2025-10-30 20:49:57', '2025-10-30 20:49:57'),
(11, 'Mixed Chowmein', './application/modules/itemmanage/assets/images/2025-10-30/D.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:50:16', '2025-10-30 20:50:16', '2025-10-30 20:50:16'),
(12, 'Chicken Chowmein', './application/modules/itemmanage/assets/images/2025-10-30/C1.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:50:41', '2025-10-30 20:50:41', '2025-10-30 20:50:41'),
(13, 'Chowmein & Noodles', './application/modules/itemmanage/assets/images/2025-10-30/D1.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:51:03', '2025-10-30 20:51:03', '2025-10-30 20:51:03'),
(14, 'Chicken Fry', './application/modules/itemmanage/assets/images/2025-10-30/C2.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:51:30', '2025-10-30 20:51:30', '2025-10-30 20:51:30'),
(15, 'Spring Rolls', './application/modules/itemmanage/assets/images/2025-10-30/S2.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:51:47', '2025-10-30 20:51:47', '2025-10-30 20:51:47'),
(16, 'Special Wonthon', './application/modules/itemmanage/assets/images/2025-10-30/S3.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:52:07', '2025-10-30 20:52:07', '2025-10-30 20:52:07'),
(17, 'Appetizer', './application/modules/itemmanage/assets/images/2025-10-30/A.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:52:32', '2025-10-30 20:52:32', '2025-10-30 20:52:32'),
(18, 'Egg Sandwich', './application/modules/itemmanage/assets/images/2025-10-30/S4.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:52:53', '2025-10-30 20:52:53', '2025-10-30 20:52:53'),
(19, 'Special Sub Sandwich', './application/modules/itemmanage/assets/images/2025-10-30/H.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:53:09', '2025-10-30 20:53:09', '2025-10-30 20:53:09'),
(20, 'Burger', './application/modules/itemmanage/assets/images/2025-10-30/b1.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:53:29', '2025-10-30 20:53:29', '2025-10-30 20:53:29'),
(21, 'Sandwich', './application/modules/itemmanage/assets/images/2025-10-30/H1.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:53:46', '2025-10-30 20:53:46', '2025-10-30 20:53:46'),
(22, 'Water', './application/modules/itemmanage/assets/images/2025-10-30/M.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:54:14', '2025-10-30 20:54:14', '2025-10-30 20:54:14'),
(23, 'Naan Item', './application/modules/itemmanage/assets/images/2025-10-30/1.png', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:54:36', '2025-10-30 20:54:36', '2025-10-30 20:54:36'),
(24, 'Garlic Naan', './application/modules/itemmanage/assets/images/2025-10-30/2.jpeg', NULL, 1, '0000-00-00', '0000-00-00', 0, 23, 2, 2, 2, '2025-10-30 20:55:15', '2025-10-30 20:55:15', '2025-10-30 20:55:15'),
(25, 'Juice', './application/modules/itemmanage/assets/images/2025-10-30/M1.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:55:30', '2025-10-30 20:55:30', '2025-10-30 20:55:30'),
(26, 'Soup', './application/modules/itemmanage/assets/images/2025-10-30/M2.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:55:46', '2025-10-30 20:55:46', '2025-10-30 20:55:46'),
(27, 'Kabab', './application/modules/itemmanage/assets/images/2025-10-30/b2.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:56:02', '2025-10-30 20:56:02', '2025-10-30 20:56:02'),
(28, 'Fast Food', './application/modules/itemmanage/assets/images/2025-10-30/C3.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:56:13', '2025-10-30 20:56:13', '2025-10-30 20:56:13'),
(29, 'Dessert', './application/modules/itemmanage/assets/images/2025-10-30/C4.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:56:30', '2025-10-30 20:56:30', '2025-10-30 20:56:30'),
(30, 'Ice Creams', './application/modules/itemmanage/assets/images/2025-10-30/G1.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:59:05', '2025-10-30 20:59:05', '2025-10-30 20:59:05'),
(31, 'Curry', './application/modules/itemmanage/assets/images/2025-10-30/B3.jpg', NULL, 1, '0000-00-00', '0000-00-00', 0, 0, 2, 2, 2, '2025-10-30 20:59:29', '2025-10-30 20:59:29', '2025-10-30 20:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `item_foods`
--

CREATE TABLE `item_foods` (
  `ProductsID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `ProductName` varchar(255) DEFAULT NULL,
  `ProductImage` varchar(200) DEFAULT NULL,
  `bigthumb` varchar(255) NOT NULL,
  `medium_thumb` varchar(255) NOT NULL,
  `small_thumb` varchar(255) NOT NULL,
  `component` text DEFAULT NULL,
  `descrip` text DEFAULT NULL,
  `itemnotes` varchar(255) DEFAULT NULL,
  `menutype` varchar(25) DEFAULT NULL,
  `productvat` decimal(10,3) DEFAULT 0.000,
  `special` int(11) NOT NULL DEFAULT 0,
  `OffersRate` int(11) NOT NULL DEFAULT 0 COMMENT '1=offer rate',
  `offerIsavailable` int(11) NOT NULL DEFAULT 0 COMMENT '1=offer available,0=No Offer',
  `offerstartdate` date DEFAULT '0000-00-00',
  `offerendate` date DEFAULT '0000-00-00',
  `Position` int(11) DEFAULT NULL,
  `kitchenid` int(11) NOT NULL,
  `isgroup` int(11) DEFAULT NULL,
  `is_customqty` int(11) DEFAULT 0,
  `cookedtime` time NOT NULL DEFAULT '00:00:00',
  `ProductsIsActive` int(11) DEFAULT NULL,
  `UserIDInserted` int(11) NOT NULL DEFAULT 0,
  `UserIDUpdated` int(11) NOT NULL DEFAULT 0,
  `UserIDLocked` int(11) NOT NULL DEFAULT 0,
  `DateInserted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DateUpdated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DateLocked` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tax0` text DEFAULT NULL,
  `tax1` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `item_foods`
--

INSERT INTO `item_foods` (`ProductsID`, `CategoryID`, `ProductName`, `ProductImage`, `bigthumb`, `medium_thumb`, `small_thumb`, `component`, `descrip`, `itemnotes`, `menutype`, `productvat`, `special`, `OffersRate`, `offerIsavailable`, `offerstartdate`, `offerendate`, `Position`, `kitchenid`, `isgroup`, `is_customqty`, `cookedtime`, `ProductsIsActive`, `UserIDInserted`, `UserIDUpdated`, `UserIDLocked`, `DateInserted`, `DateUpdated`, `DateLocked`, `tax0`, `tax1`) VALUES
(1, 2, 'Atlantic Salmon with Sauce', 'application/modules/itemmanage/assets/images/Fast-Food.png', 'application/modules/itemmanage/assets/images/big/Fast-Food.png', 'application/modules/itemmanage/assets/images/medium/Fast-Food.png', 'application/modules/itemmanage/assets/images/small/Fast-Food.png', 'farine,pomme,legume', 'good to eat', '', '5,3,1', 0.000, 1, 0, 1, '2025-10-29', '2025-11-30', NULL, 1, NULL, 1, '01:00:00', 1, 2, 2, 2, '2025-10-30 21:04:28', '2025-10-30 21:04:28', '2025-10-30 21:04:28', NULL, NULL),
(2, 2, 'Free-Range Chicken Supreme', 'application/modules/itemmanage/assets/images/Free-Range-Chicken-Supreme.png', 'application/modules/itemmanage/assets/images/big/Free-Range-Chicken-Supreme.png', 'application/modules/itemmanage/assets/images/medium/Free-Range-Chicken-Supreme.png', 'application/modules/itemmanage/assets/images/small/Free-Range-Chicken-Supreme.png', '', 'Our dishes are full of taste, you must love it. its a new item in our menu.', '', '', 10.000, 1, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, 1, '00:15:00', 1, 2, 2, 2, '2025-10-30 21:19:47', '2025-10-30 21:19:47', '2025-10-30 21:19:47', NULL, NULL),
(3, 5, 'pizza', 'application/modules/itemmanage/assets/images/pizza.png', 'application/modules/itemmanage/assets/images/big/pizza.png', 'application/modules/itemmanage/assets/images/medium/pizza.png', 'application/modules/itemmanage/assets/images/small/pizza.png', '', '', '', '2,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 05:33:27', '2025-10-31 05:33:27', '2025-10-31 05:33:27', NULL, NULL),
(4, 25, 'Avacardo Juice', 'application/modules/itemmanage/assets/images/Avacardo-Juice.png', 'application/modules/itemmanage/assets/images/big/Avacardo-Juice.png', 'application/modules/itemmanage/assets/images/medium/Avacardo-Juice.png', 'application/modules/itemmanage/assets/images/small/Avacardo-Juice.png', '', '', '', '', 10.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 05:35:11', '2025-10-31 05:35:11', '2025-10-31 05:35:11', NULL, NULL),
(5, 22, 'sparkling water', 'application/modules/itemmanage/assets/images/sparkling-water.png', 'application/modules/itemmanage/assets/images/big/sparkling-water.png', 'application/modules/itemmanage/assets/images/medium/sparkling-water.png', 'application/modules/itemmanage/assets/images/small/sparkling-water.png', '', '', '', '1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 05:36:27', '2025-10-31 05:36:27', '2025-10-31 05:36:27', NULL, NULL),
(6, 22, 'Mineral Water', 'application/modules/itemmanage/assets/images/Mineral-Water.png', 'application/modules/itemmanage/assets/images/big/Mineral-Water.png', 'application/modules/itemmanage/assets/images/medium/Mineral-Water.png', 'application/modules/itemmanage/assets/images/small/Mineral-Water.png', '', '', '', '5,3,2,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 05:37:29', '2025-10-31 05:37:29', '2025-10-31 05:37:29', NULL, NULL),
(7, 31, 'Vegetarian Curry', 'application/modules/itemmanage/assets/images/Vegetarian-Curry.png', 'application/modules/itemmanage/assets/images/big/Vegetarian-Curry.png', 'application/modules/itemmanage/assets/images/medium/Vegetarian-Curry.png', 'application/modules/itemmanage/assets/images/small/Vegetarian-Curry.png', '', '', '', '3,1', 20.000, 1, 15, 1, '2025-10-31', '2025-11-26', NULL, 14, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 05:38:38', '2025-10-31 05:38:38', '2025-10-31 05:38:38', NULL, NULL),
(8, 24, 'Tawa Naan', 'application/modules/itemmanage/assets/images/garlic-naan.png', 'application/modules/itemmanage/assets/images/big/garlic-naan.png', 'application/modules/itemmanage/assets/images/medium/garlic-naan.png', 'application/modules/itemmanage/assets/images/small/garlic-naan.png', '', '', '', '1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 16, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 05:39:14', '2025-10-31 12:06:42', '2025-10-31 05:39:14', NULL, NULL),
(9, 8, 'Vegetable sharma', 'application/modules/itemmanage/assets/images/Vegetable-sharma.png', 'application/modules/itemmanage/assets/images/big/Vegetable-sharma.png', 'application/modules/itemmanage/assets/images/medium/Vegetable-sharma.png', 'application/modules/itemmanage/assets/images/small/Vegetable-sharma.png', '', '', '', '5', 0.000, 1, 0, 0, '0000-00-00', '0000-00-00', NULL, 12, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 05:40:02', '2025-10-31 05:40:02', '2025-10-31 05:40:02', NULL, NULL),
(10, 6, 'Cheese Loven Pizza', 'application/modules/itemmanage/assets/images/Cheese-Loven-Pizza.png', 'application/modules/itemmanage/assets/images/big/Cheese-Loven-Pizza.png', 'application/modules/itemmanage/assets/images/medium/Cheese-Loven-Pizza.png', 'application/modules/itemmanage/assets/images/small/Cheese-Loven-Pizza.png', '', '', '', '1', 0.000, 1, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 05:40:40', '2025-10-31 05:40:40', '2025-10-31 05:40:40', NULL, NULL),
(11, 6, 'Vegetable Pizza', 'application/modules/itemmanage/assets/images/Vegetable-Pizza.png', 'application/modules/itemmanage/assets/images/big/Vegetable-Pizza.png', 'application/modules/itemmanage/assets/images/medium/Vegetable-Pizza.png', 'application/modules/itemmanage/assets/images/small/Vegetable-Pizza.png', '', '', '', '1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 05:41:39', '2025-10-31 05:41:39', '2025-10-31 05:41:39', NULL, NULL),
(12, 25, 'Orange juice ', 'application/modules/itemmanage/assets/images/Orange-juice.png', 'application/modules/itemmanage/assets/images/big/Orange-juice.png', 'application/modules/itemmanage/assets/images/medium/Orange-juice.png', 'application/modules/itemmanage/assets/images/small/Orange-juice.png', '', '', '', '3', 0.000, 1, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:08:22', '2025-10-31 12:08:22', '2025-10-31 12:08:22', NULL, NULL),
(13, 2, 'Special Summer', 'application/modules/itemmanage/assets/images/Special-Summer.png', 'application/modules/itemmanage/assets/images/big/Special-Summer.png', 'application/modules/itemmanage/assets/images/medium/Special-Summer.png', 'application/modules/itemmanage/assets/images/small/Special-Summer.png', '', '', '', '4,3', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:09:38', '2025-10-31 12:09:38', '2025-10-31 12:09:38', NULL, NULL),
(14, 2, 'Tomahawk Steak (for 2)', 'application/modules/itemmanage/assets/images/Tomahawk-Steak.png', 'application/modules/itemmanage/assets/images/big/Tomahawk-Steak.png', 'application/modules/itemmanage/assets/images/medium/Tomahawk-Steak.png', 'application/modules/itemmanage/assets/images/small/Tomahawk-Steak.png', '', '', '', '5', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:11:19', '2025-10-31 12:11:19', '2025-10-31 12:11:19', NULL, NULL),
(49, 26, 'Minestrone Soup', 'application/modules/itemmanage/assets/images/Minestrone-Soup.png', 'application/modules/itemmanage/assets/images/big/Minestrone-Soup.png', 'application/modules/itemmanage/assets/images/medium/Minestrone-Soup.png', 'application/modules/itemmanage/assets/images/small/Minestrone-Soup.png', '', '', '', '2', 0.000, 1, 0, 1, '2025-10-31', '2025-12-29', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:35:49', '2025-10-31 12:35:49', '2025-10-31 12:35:49', NULL, NULL),
(50, 26, 'Creamy Potato Soup', 'application/modules/itemmanage/assets/images/Creamy-Potato-Soup.png', 'application/modules/itemmanage/assets/images/big/Creamy-Potato-Soup.png', 'application/modules/itemmanage/assets/images/medium/Creamy-Potato-Soup.png', 'application/modules/itemmanage/assets/images/small/Creamy-Potato-Soup.png', '', '', '', '3', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:36:31', '2025-10-31 12:36:31', '2025-10-31 12:36:31', NULL, NULL),
(51, 2, 'Chicken Angara', 'application/modules/itemmanage/assets/images/Chicken-Angara-Kabab.png', 'application/modules/itemmanage/assets/images/big/Chicken-Angara-Kabab.png', 'application/modules/itemmanage/assets/images/medium/Chicken-Angara-Kabab.png', 'application/modules/itemmanage/assets/images/small/Chicken-Angara-Kabab.png', '', '', '', '3', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 14, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:37:35', '2025-10-31 12:37:35', '2025-10-31 12:37:35', NULL, NULL),
(52, 2, 'Mutton Seekh Kebab', 'application/modules/itemmanage/assets/images/Mutton-Seekh-Kebab.png', 'application/modules/itemmanage/assets/images/big/Mutton-Seekh-Kebab.png', 'application/modules/itemmanage/assets/images/medium/Mutton-Seekh-Kebab.png', 'application/modules/itemmanage/assets/images/small/Mutton-Seekh-Kebab.png', '', '', '', '5,4,3,2,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:38:29', '2025-10-31 12:38:29', '2025-10-31 12:38:29', NULL, NULL),
(53, 2, 'Burger+Potato Fries', 'application/modules/itemmanage/assets/images/Burger-plus-Potato-Fries.png', 'application/modules/itemmanage/assets/images/big/Burger-plus-Potato-Fries.png', 'application/modules/itemmanage/assets/images/medium/Burger-plus-Potato-Fries.png', 'application/modules/itemmanage/assets/images/small/Burger-plus-Potato-Fries.png', '', '', '', '5,4,3,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:39:03', '2025-10-31 12:39:03', '2025-10-31 12:39:03', NULL, NULL),
(54, 2, 'Kerala Fried Prawns with special sauce', 'application/modules/itemmanage/assets/images/King-Prawns.png', 'application/modules/itemmanage/assets/images/big/King-Prawns.png', 'application/modules/itemmanage/assets/images/medium/King-Prawns.png', 'application/modules/itemmanage/assets/images/small/King-Prawns.png', '', '', '', '3,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:39:42', '2025-10-31 12:39:42', '2025-10-31 12:39:42', NULL, NULL),
(55, 2, 'Prime Angus Ribeye (300g)', 'application/modules/itemmanage/assets/images/Prime-Angus-Ribeye.png', 'application/modules/itemmanage/assets/images/big/Prime-Angus-Ribeye.png', 'application/modules/itemmanage/assets/images/medium/Prime-Angus-Ribeye.png', 'application/modules/itemmanage/assets/images/small/Prime-Angus-Ribeye.png', '', '', '', '3,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:40:26', '2025-10-31 12:40:26', '2025-10-31 12:40:26', NULL, NULL),
(56, 2, 'Black Truffle Tagliatelle', 'application/modules/itemmanage/assets/images/Black-Truffle-Tagliatelle.png', 'application/modules/itemmanage/assets/images/big/Black-Truffle-Tagliatelle.png', 'application/modules/itemmanage/assets/images/medium/Black-Truffle-Tagliatelle.png', 'application/modules/itemmanage/assets/images/small/Black-Truffle-Tagliatelle.png', '', '', '', '5,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:41:02', '2025-10-31 12:41:02', '2025-10-31 12:41:02', NULL, NULL),
(57, 2, 'Pasta Full Pack', 'application/modules/itemmanage/assets/images/Pasta-Full-Pack.png', 'application/modules/itemmanage/assets/images/big/Pasta-Full-Pack.png', 'application/modules/itemmanage/assets/images/medium/Pasta-Full-Pack.png', 'application/modules/itemmanage/assets/images/small/Pasta-Full-Pack.png', '', '', '', '1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:41:35', '2025-10-31 12:41:35', '2025-10-31 12:41:35', NULL, NULL),
(58, 2, 'Ice Strawberry Cream', 'application/modules/itemmanage/assets/images/Ice-Strawberry-Cream.png', 'application/modules/itemmanage/assets/images/big/Ice-Strawberry-Cream.png', 'application/modules/itemmanage/assets/images/medium/Ice-Strawberry-Cream.png', 'application/modules/itemmanage/assets/images/small/Ice-Strawberry-Cream.png', '', '', '', '1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:42:11', '2025-10-31 12:42:11', '2025-10-31 12:42:11', NULL, NULL),
(59, 2, 'Butter Queen Vanilla', 'application/modules/itemmanage/assets/images/Butter-Queen-Vanilla.png', 'application/modules/itemmanage/assets/images/big/Butter-Queen-Vanilla.png', 'application/modules/itemmanage/assets/images/medium/Butter-Queen-Vanilla.png', 'application/modules/itemmanage/assets/images/small/Butter-Queen-Vanilla.png', '', '', '', '1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:42:46', '2025-10-31 12:42:46', '2025-10-31 12:42:46', NULL, NULL),
(60, 2, 'Ice Cream Ship', 'application/modules/itemmanage/assets/images/Ice-Cream-Ship.png', 'application/modules/itemmanage/assets/images/big/Ice-Cream-Ship.png', 'application/modules/itemmanage/assets/images/medium/Ice-Cream-Ship.png', 'application/modules/itemmanage/assets/images/small/Ice-Cream-Ship.png', '', '', '', '1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:43:19', '2025-10-31 12:43:19', '2025-10-31 12:43:19', NULL, NULL),
(61, 26, 'Vegetable Beef soup with Noodles', 'application/modules/itemmanage/assets/images/Vegetable-Beef-soup-with-Noodles.png', 'application/modules/itemmanage/assets/images/big/Vegetable-Beef-soup-with-Noodles.png', 'application/modules/itemmanage/assets/images/medium/Vegetable-Beef-soup-with-Noodles.png', 'application/modules/itemmanage/assets/images/small/Vegetable-Beef-soup-with-Noodles.png', '', '', '', '5,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:43:53', '2025-10-31 12:43:53', '2025-10-31 12:43:53', NULL, NULL),
(62, 2, 'Fish Fry', 'application/modules/itemmanage/assets/images/Fish-Fry1.png', 'application/modules/itemmanage/assets/images/big/Fish-Fry1.png', 'application/modules/itemmanage/assets/images/medium/Fish-Fry1.png', 'application/modules/itemmanage/assets/images/small/Fish-Fry1.png', '', '', '', '3,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:44:27', '2025-10-31 12:44:27', '2025-10-31 12:44:27', NULL, NULL),
(63, 2, 'Squid Fry', 'application/modules/itemmanage/assets/images/Squid-Fry.png', 'application/modules/itemmanage/assets/images/big/Squid-Fry.png', 'application/modules/itemmanage/assets/images/medium/Squid-Fry.png', 'application/modules/itemmanage/assets/images/small/Squid-Fry.png', '', '', '', '2,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:44:59', '2025-10-31 12:44:59', '2025-10-31 12:44:59', NULL, NULL),
(64, 2, 'Masala Tea', 'application/modules/itemmanage/assets/images/Masala-Tea.png', 'application/modules/itemmanage/assets/images/big/Masala-Tea.png', 'application/modules/itemmanage/assets/images/medium/Masala-Tea.png', 'application/modules/itemmanage/assets/images/small/Masala-Tea.png', '', '', '', '5,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:45:30', '2025-10-31 12:45:30', '2025-10-31 12:45:30', NULL, NULL),
(65, 2, 'Green Tea Special', 'application/modules/itemmanage/assets/images/Green-Tea-Special.png', 'application/modules/itemmanage/assets/images/big/Green-Tea-Special.png', 'application/modules/itemmanage/assets/images/medium/Green-Tea-Special.png', 'application/modules/itemmanage/assets/images/small/Green-Tea-Special.png', '', '', '', '2,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:46:03', '2025-10-31 12:46:03', '2025-10-31 12:46:03', NULL, NULL),
(66, 2, 'Lemon And Honey Tea', 'application/modules/itemmanage/assets/images/Lemon-And-Honey-Tea.png', 'application/modules/itemmanage/assets/images/big/Lemon-And-Honey-Tea.png', 'application/modules/itemmanage/assets/images/medium/Lemon-And-Honey-Tea.png', 'application/modules/itemmanage/assets/images/small/Lemon-And-Honey-Tea.png', '', '', '', '2,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:46:37', '2025-10-31 12:46:37', '2025-10-31 12:46:37', NULL, NULL),
(67, 2, 'Chicken Patty Burger with double cheese', 'application/modules/itemmanage/assets/images/Chicken-Patty-Burger.png', 'application/modules/itemmanage/assets/images/big/Chicken-Patty-Burger.png', 'application/modules/itemmanage/assets/images/medium/Chicken-Patty-Burger.png', 'application/modules/itemmanage/assets/images/small/Chicken-Patty-Burger.png', '', '', '', '4,3,2,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:47:50', '2025-10-31 12:47:50', '2025-10-31 12:47:50', NULL, NULL),
(68, 2, 'Beef Patty Burger', 'application/modules/itemmanage/assets/images/Beef-Patty-Burger.png', 'application/modules/itemmanage/assets/images/big/Beef-Patty-Burger.png', 'application/modules/itemmanage/assets/images/medium/Beef-Patty-Burger.png', 'application/modules/itemmanage/assets/images/small/Beef-Patty-Burger.png', '', '', '', '2,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:48:30', '2025-10-31 12:48:30', '2025-10-31 12:48:30', NULL, NULL),
(69, 2, 'Chicken BBQ Burger', 'application/modules/itemmanage/assets/images/Chicken-BBQ-Burger.png', 'application/modules/itemmanage/assets/images/big/Chicken-BBQ-Burger.png', 'application/modules/itemmanage/assets/images/medium/Chicken-BBQ-Burger.png', 'application/modules/itemmanage/assets/images/small/Chicken-BBQ-Burger.png', '', '', '', '4,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:49:00', '2025-10-31 12:49:00', '2025-10-31 12:49:00', NULL, NULL),
(70, 2, 'Chicken Naga Sauce Burger', 'application/modules/itemmanage/assets/images/Chicken-Naga-Sauce-Burger.png', 'application/modules/itemmanage/assets/images/big/Chicken-Naga-Sauce-Burger.png', 'application/modules/itemmanage/assets/images/medium/Chicken-Naga-Sauce-Burger.png', 'application/modules/itemmanage/assets/images/small/Chicken-Naga-Sauce-Burger.png', '', '', '', '4,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:49:32', '2025-10-31 12:49:32', '2025-10-31 12:49:32', NULL, NULL),
(71, 19, 'Chicken Sub Sandwich', 'application/modules/itemmanage/assets/images/Chicken-Sub-Sandwich.png', 'application/modules/itemmanage/assets/images/big/Chicken-Sub-Sandwich.png', 'application/modules/itemmanage/assets/images/medium/Chicken-Sub-Sandwich.png', 'application/modules/itemmanage/assets/images/small/Chicken-Sub-Sandwich.png', '', '', '', '4,3,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:50:29', '2025-10-31 12:50:29', '2025-10-31 12:50:29', NULL, NULL),
(72, 19, 'Special Sub Sandwich', 'application/modules/itemmanage/assets/images/Special-Sub-Sandwich.png', 'application/modules/itemmanage/assets/images/big/Special-Sub-Sandwich.png', 'application/modules/itemmanage/assets/images/medium/Special-Sub-Sandwich.png', 'application/modules/itemmanage/assets/images/small/Special-Sub-Sandwich.png', '', '', '', '5,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 12, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:51:02', '2025-10-31 12:51:02', '2025-10-31 12:51:02', NULL, NULL),
(73, 19, 'Egg Sandwich and cold drinks', 'application/modules/itemmanage/assets/images/Egg-Sandwich.png', 'application/modules/itemmanage/assets/images/big/Egg-Sandwich.png', 'application/modules/itemmanage/assets/images/medium/Egg-Sandwich.png', 'application/modules/itemmanage/assets/images/small/Egg-Sandwich.png', '', '', '', '5,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 14, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:51:50', '2025-10-31 12:51:50', '2025-10-31 12:51:50', NULL, NULL),
(74, 16, 'Special Wonthon', 'application/modules/itemmanage/assets/images/Special-Wonthon.png', 'application/modules/itemmanage/assets/images/big/Special-Wonthon.png', 'application/modules/itemmanage/assets/images/medium/Special-Wonthon.png', 'application/modules/itemmanage/assets/images/small/Special-Wonthon.png', '', '', '', '2,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 12, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:52:30', '2025-10-31 12:52:30', '2025-10-31 12:52:30', NULL, NULL),
(75, 2, 'Spring Rolls', 'application/modules/itemmanage/assets/images/spring-rolls-2097978_960_7201.jpg', 'application/modules/itemmanage/assets/images/big/spring-rolls-2097978_960_7201.jpg', 'application/modules/itemmanage/assets/images/medium/spring-rolls-2097978_960_7201.jpg', 'application/modules/itemmanage/assets/images/small/spring-rolls-2097978_960_7201.jpg', '', '', '', '1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:53:00', '2025-10-31 12:53:00', '2025-10-31 12:53:00', NULL, NULL),
(76, 2, 'Chicken Fry and French Fries', 'application/modules/itemmanage/assets/images/Chicken-Fry.png', 'application/modules/itemmanage/assets/images/big/Chicken-Fry.png', 'application/modules/itemmanage/assets/images/medium/Chicken-Fry.png', 'application/modules/itemmanage/assets/images/small/Chicken-Fry.png', '', '', '', '5,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:53:38', '2025-10-31 12:53:38', '2025-10-31 12:53:38', NULL, NULL),
(77, 12, 'Chicken Chowmein', 'application/modules/itemmanage/assets/images/Chicken-Chowmein.png', 'application/modules/itemmanage/assets/images/big/Chicken-Chowmein.png', 'application/modules/itemmanage/assets/images/medium/Chicken-Chowmein.png', 'application/modules/itemmanage/assets/images/small/Chicken-Chowmein.png', '', '', '', '3,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:54:11', '2025-10-31 12:54:11', '2025-10-31 12:54:11', NULL, NULL),
(78, 2, 'Mixed Chowmein and Cold Drinks', 'application/modules/itemmanage/assets/images/Mixed-Chowmein.png', 'application/modules/itemmanage/assets/images/big/Mixed-Chowmein.png', 'application/modules/itemmanage/assets/images/medium/Mixed-Chowmein.png', 'application/modules/itemmanage/assets/images/small/Mixed-Chowmein.png', '', '', '', '5,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 14, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:55:23', '2025-10-31 12:55:23', '2025-10-31 12:55:23', NULL, NULL),
(79, 9, 'Beef Swarma', 'application/modules/itemmanage/assets/images/Beef-Swarma.png', 'application/modules/itemmanage/assets/images/big/Beef-Swarma.png', 'application/modules/itemmanage/assets/images/medium/Beef-Swarma.png', 'application/modules/itemmanage/assets/images/small/Beef-Swarma.png', '', '', '', '1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:55:54', '2025-10-31 12:55:54', '2025-10-31 12:55:54', NULL, NULL),
(80, 2, 'Chicken Swarma Roll', 'application/modules/itemmanage/assets/images/Chicken-Swarma-Roll.png', 'application/modules/itemmanage/assets/images/big/Chicken-Swarma-Roll.png', 'application/modules/itemmanage/assets/images/medium/Chicken-Swarma-Roll.png', 'application/modules/itemmanage/assets/images/small/Chicken-Swarma-Roll.png', '', '', '', '5,1', 0.000, 0, 0, 0, '0000-00-00', '0000-00-00', NULL, 1, NULL, NULL, '00:00:00', 1, 2, 2, 2, '2025-10-31 12:56:57', '2025-10-31 12:56:57', '2025-10-31 12:56:57', NULL, NULL),
(81, 3, 'menu1', 'application/modules/itemmanage/assets/images/O.png', 'application/modules/itemmanage/assets/images/big/O.png', 'application/modules/itemmanage/assets/images/medium/O.png', 'application/modules/itemmanage/assets/images/small/O.png', '', '', '', '5,1', 0.000, 0, 20, 1, '2025-10-31', '2025-11-26', NULL, 0, 1, 0, '00:00:00', 1, 2, 2, 2, '2025-10-31 21:43:08', '2025-10-31 21:43:08', '2025-10-31 21:43:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_advertisement`
--

CREATE TABLE `job_advertisement` (
  `job_adv_id` int(10) UNSIGNED NOT NULL,
  `pos_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `adv_circular_date` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `circular_dadeline` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `adv_file` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `adv_details` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `phrase` varchar(100) NOT NULL,
  `english` varchar(255) NOT NULL,
  `french` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `phrase`, `english`, `french`) VALUES
(2, 'login', 'Login', NULL),
(3, 'email', 'Email Address', NULL),
(4, 'password', 'Password', NULL),
(5, 'reset', 'Reset', NULL),
(6, 'dashboard', 'Dashboard', NULL),
(7, 'home', 'Home', NULL),
(8, 'profile', 'Profile', NULL),
(9, 'profile_setting', 'Profile Setting', NULL),
(10, 'firstname', 'First Name', NULL),
(11, 'lastname', 'Last Name', NULL),
(12, 'about', 'About', NULL),
(13, 'preview', 'Preview', NULL),
(14, 'image', 'Image', NULL),
(15, 'save', 'Save', NULL),
(16, 'upload_successfully', 'Upload Successfully!', NULL),
(17, 'user_added_successfully', 'User Added Successfully!', NULL),
(18, 'please_try_again', 'Please Try Again...', NULL),
(19, 'inbox_message', 'Inbox Messages', NULL),
(20, 'sent_message', 'Sent Message', NULL),
(21, 'message_details', 'Message Details', NULL),
(22, 'new_message', 'New Message', NULL),
(23, 'receiver_name', 'Receiver Name', NULL),
(24, 'sender_name', 'Sender Name', NULL),
(25, 'subject', 'Subject', NULL),
(26, 'message', 'Message', NULL),
(27, 'message_sent', 'Message Sent!', NULL),
(28, 'ip_address', 'IP Address', NULL),
(29, 'last_login', 'Last Login', NULL),
(30, 'last_logout', 'Last Logout', NULL),
(31, 'status', 'Status', NULL),
(33, 'send', 'Send', NULL),
(34, 'date', 'Date', NULL),
(35, 'action', 'Action', NULL),
(36, 'sl_no', 'SL No.', NULL),
(37, 'are_you_sure', 'Are You Sure ? ', NULL),
(38, 'application_setting', 'Application Setting', NULL),
(39, 'application_title', 'Application Title', NULL),
(41, 'phone', 'Phone', NULL),
(42, 'favicon', 'Favicon', NULL),
(43, 'logo', 'Logo', NULL),
(44, 'language', 'Language', NULL),
(45, 'left_to_right', 'Left To Right', NULL),
(46, 'right_to_left', 'Right To Left', NULL),
(47, 'footer_text', 'Footer Text', NULL),
(48, 'site_align', 'Application Alignment', NULL),
(49, 'welcome_back', 'Welcome Back!', NULL),
(50, 'please_contact_with_admin', 'Please Contact With Admin', NULL),
(51, 'incorrect_email_or_password', 'Incorrect Email/Password', NULL),
(52, 'select_option', 'Select Option', NULL),
(53, 'ftp_setting', 'Data Synchronize [FTP Setting]', NULL),
(54, 'hostname', 'Host Name', NULL),
(55, 'username', 'User Name', NULL),
(56, 'ftp_port', 'FTP Port', NULL),
(57, 'ftp_debug', 'FTP Debug', NULL),
(58, 'project_root', 'Project Root', NULL),
(59, 'update_successfully', 'Update Successfully', NULL),
(60, 'save_successfully', 'Save Successfully!', NULL),
(61, 'delete_successfully', 'Delete Successfully!', NULL),
(62, 'internet_connection', 'Internet Connection', NULL),
(63, 'ok', 'Okay', NULL),
(64, 'not_available', 'Not Available', NULL),
(65, 'available', 'Available', NULL),
(66, 'outgoing_file', 'Outgoing File', NULL),
(67, 'incoming_file', 'Incoming File', NULL),
(68, 'data_synchronize', 'Data Synchronize', NULL),
(69, 'unable_to_upload_file_please_check_configuration', 'Unable to upload file! please check configuration', NULL),
(70, 'please_configure_synchronizer_settings', 'Please configure synchronizer settings', NULL),
(71, 'download_successfully', 'Download Successfully', NULL),
(72, 'unable_to_download_file_please_check_configuration', 'Unable to download file! please check configuration', NULL),
(73, 'data_import_first', 'Data Import First', NULL),
(74, 'data_import_successfully', 'Data Import Successfully!', NULL),
(75, 'unable_to_import_data_please_check_config_or_sql_file', 'Unable to Import Data! Please Check Configuration / SQL File.', NULL),
(76, 'download_data_from_server', 'Download Data from Server', NULL),
(77, 'data_import_to_database', 'Data Import To Database', NULL),
(79, 'data_upload_to_server', 'Data Upload to Server', NULL),
(81, 'ooops_something_went_wrong', ' Ops Something Went Wrong...', NULL),
(82, 'module_permission_list', 'Module Permission List', NULL),
(83, 'user_permission', 'User Permission', NULL),
(84, 'add_module_permission', 'Add Module Permission', NULL),
(85, 'module_permission_added_successfully', 'Module Permission Added Successfully!', NULL),
(86, 'update_module_permission', 'Update Module Permission', NULL),
(87, 'download', 'Download', NULL),
(88, 'module_name', 'Module Name', NULL),
(89, 'create', 'Create', NULL),
(90, 'read', 'Read', NULL),
(91, 'update', 'Update', NULL),
(92, 'delete', 'Delete', NULL),
(93, 'module_list', 'Module List', NULL),
(94, 'add_module', 'Add Module', NULL),
(95, 'directory', 'Module Directory', NULL),
(96, 'description', 'Description', NULL),
(97, 'image_upload_successfully', 'Image Upload Successfully!', NULL),
(98, 'module_added_successfully', 'Module Added Successfully', NULL),
(99, 'inactive', 'Inactive', NULL),
(100, 'active', 'Active', NULL),
(101, 'user_list', 'User List', NULL),
(102, 'see_all_message', 'See All Messages', NULL),
(103, 'setting', 'Setting', NULL),
(104, 'logout', 'Logout', NULL),
(105, 'admin', 'Admin', NULL),
(106, 'add_user', 'Add User', NULL),
(107, 'user', 'User', NULL),
(108, 'module', 'Module', NULL),
(109, 'new', 'New', NULL),
(110, 'inbox', 'Inbox', NULL),
(111, 'sent', 'Sent', NULL),
(112, 'synchronize', 'Synchronize', NULL),
(113, 'data_synchronizer', 'Data Synchronizer', NULL),
(114, 'module_permission', 'Module Permission', NULL),
(115, 'backup_now', 'Backup Now!', NULL),
(116, 'restore_now', 'Restore Now!', NULL),
(117, 'backup_and_restore', 'Backup and Restore', NULL),
(118, 'captcha', 'Captcha Word', NULL),
(119, 'database_backup', 'Database Backup', NULL),
(120, 'restore_successfully', 'Restore Successfully', NULL),
(121, 'backup_successfully', 'Backup Successfully', NULL),
(122, 'filename', 'File Name', NULL),
(123, 'file_information', 'File Information', NULL),
(125, 'backup_date', 'Backup Date', NULL),
(126, 'overwrite', 'Overwrite', NULL),
(127, 'invalid_file', 'Invalid File!', NULL),
(128, 'invalid_module', 'Invalid Module', NULL),
(129, 'remove_successfully', 'Remove Successfully!', NULL),
(130, 'install', 'Install', NULL),
(131, 'uninstall', 'Uninstall', NULL),
(132, 'tables_are_not_available_in_database', 'Tables are not available in database.sql', NULL),
(133, 'no_tables_are_registered_in_config', 'No tables are registered in config.php', NULL),
(134, 'enquiry', 'Enquiry', NULL),
(135, 'read_unread', 'Read/Unread', NULL),
(136, 'enquiry_information', 'Enquiry Information', NULL),
(137, 'user_agent', 'User Agent', NULL),
(138, 'checked_by', 'Checked By', NULL),
(139, 'new_enquiry', 'New Enquiry', NULL),
(140, 'crud', 'Crud', NULL),
(141, 'view', 'View', NULL),
(144, 'ph', 'Phone', NULL),
(145, 'cid', 'SL No', NULL),
(146, 'view_atn', 'Attendance View', NULL),
(147, 'mang', 'Employee Management', NULL),
(148, 'designation', 'Designation', NULL),
(149, 'test', 'Test', NULL),
(150, 'sl', 'SL', NULL),
(151, 'bdtask', 'BDTASK', NULL),
(152, 'practice', 'Practice', NULL),
(153, 'branch_name', 'Branch Name', NULL),
(154, 'chairman_name', 'Chairman', NULL),
(155, 'b_photo', 'Photo', NULL),
(156, 'b_address', 'Address', NULL),
(157, 'position', 'Designation', NULL),
(158, 'advertisement', 'Advertisement', NULL),
(159, 'position_name', 'Position', NULL),
(160, 'position_details', 'Details', NULL),
(161, 'circularprocess', 'Recruitment', NULL),
(162, 'pos_id', 'Position', NULL),
(163, 'adv_circular_date', 'Publish Date', NULL),
(164, 'circular_dadeline', 'Deadline', NULL),
(165, 'adv_file', 'Documents', NULL),
(166, 'adv_details', 'Details', NULL),
(167, 'attendance', 'Attendance', NULL),
(168, 'employee', 'Employee', NULL),
(169, 'emp_id', 'Employee Name', NULL),
(170, 'sign_in', 'Sign In', NULL),
(171, 'sign_out', 'Sign Out', NULL),
(172, 'staytime', 'Stay Time', NULL),
(173, 'abc', 'abc', NULL),
(174, 'first_name', 'First Name', NULL),
(175, 'last_name', 'Last Name', NULL),
(176, 'alter_phone', 'Alternative Phone', NULL),
(177, 'present_address', 'Present Address', NULL),
(178, 'parmanent_address', 'Permanent Address', NULL),
(179, 'candidateinfo', 'Candidate Info', NULL),
(180, 'add_advertisement', 'Add Advertisement', NULL),
(181, 'advertisement_list', 'Manage Advertisement ', NULL),
(182, 'candidate_basic_info', 'Candidate Information', NULL),
(183, 'can_basicinfo_list', 'Manage Candidate', NULL),
(184, 'add_canbasic_info', 'Add New Candidate', NULL),
(185, 'candidate_education_info', 'Candidate Educational Info', NULL),
(186, 'can_educationinfo_list', 'Candidate Edu Info List', NULL),
(187, 'add_edu_info', 'Add Educational Info', NULL),
(188, 'can_id', 'Candidate Id', NULL),
(189, 'degree_name', 'Obtained Degree', NULL),
(190, 'university_name', 'University', NULL),
(191, 'cgp', 'CGPA', NULL),
(192, 'comments', 'Comments', NULL),
(193, 'signature', 'Signature', NULL),
(194, 'candidate_workexperience', 'Candidate Work Experience', NULL),
(195, 'can_workexperience_list', 'Work Experience List', NULL),
(196, 'add_can_experience', 'Add Work Experience', NULL),
(197, 'company_name', 'Company Name', NULL),
(198, 'working_period', 'Working Period', NULL),
(199, 'duties', 'Duties', NULL),
(200, 'supervisor', 'Supervisor', NULL),
(201, 'candidate_workexpe', 'Candidate Work Experience', NULL),
(202, 'candidate_shortlist', 'Candidate Shortlist', NULL),
(203, 'shortlist_view', 'Manage Shortlist', NULL),
(204, 'add_shortlist', 'Add Shortlist', NULL),
(205, 'date_of_shortlist', 'Shortlist Date', NULL),
(206, 'interview_date', 'Interview Date', NULL),
(207, 'submit', 'Submit', NULL),
(208, 'candidate_id', 'Your ID', NULL),
(209, 'job_adv_id', 'Job Position', NULL),
(210, 'sequence', 'Sequence', NULL),
(211, 'candidate_interview', 'Interview', NULL),
(212, 'interview_list', 'Interview list', NULL),
(213, 'add_interview', 'Add interview', NULL),
(214, 'interviewer_id', 'Interviewer', NULL),
(215, 'interview_marks', 'Viva Marks', NULL),
(216, 'written_total_marks', 'Written Total Marks', NULL),
(217, 'mcq_total_marks', 'MCQ Total Marks', NULL),
(218, 'recommandation', 'Recommendation', NULL),
(219, 'selection', 'Selection', NULL),
(220, 'details', 'Details', NULL),
(221, 'candidate_selection', 'Candidate Selection', NULL),
(222, 'selection_list', 'Selection List', NULL),
(223, 'add_selection', 'Add Selection', NULL),
(224, 'employee_id', 'Employee Id', NULL),
(225, 'position_id', '1', NULL),
(226, 'selection_terms', 'Selection Terms', NULL),
(227, 'total_marks', 'Total Marks', NULL),
(228, 'photo', 'Picture', NULL),
(229, 'your_id', 'Your ID', NULL),
(230, 'change_image', 'Change Photo', NULL),
(231, 'picture', 'Photograph', NULL),
(232, 'ad', 'Add', NULL),
(233, 'write_y_p_info', 'Write Your Personal Information', NULL),
(234, 'emp_position', 'Employee Position', NULL),
(235, 'add_pos', 'Add Position', NULL),
(236, 'list_pos', 'List of Position', NULL),
(237, 'emp_salary_stup', 'Employee Salary Setup', NULL),
(238, 'add_salary_stup', 'Add Salary Setup', NULL),
(239, 'list_salarystup', 'List of Salary Setup', NULL),
(240, 'emp_sal_name', 'Salary Name', NULL),
(241, 'emp_sal_type', 'Salary Type', NULL),
(242, 'emp_performance', 'Employee Performance', NULL),
(243, 'add_performance', 'Add Performance', NULL),
(244, 'list_performance', 'List of Performance', NULL),
(245, 'note', 'Note', NULL),
(246, 'note_by', 'Note By', NULL),
(247, 'number_of_star', 'Number of Star', NULL),
(248, 'updated_by', 'Updated By', NULL),
(249, 'emp_sal_payment', 'Manage Employee Salary', NULL),
(250, 'add_payment', 'Add Payment', NULL),
(251, 'list_payment', 'List of payment', NULL),
(252, 'total_salary', 'Total Salary', NULL),
(253, 'total_working_minutes', 'Working Hour', NULL),
(254, 'payment_due', 'Payment Type', NULL),
(255, 'payment_date', 'Date', NULL),
(256, 'paid_by', 'Paid By', NULL),
(257, 'view_employee_payment', 'Employee Payment List', NULL),
(258, 'sal_payment_type', 'Salary Payment Type', NULL),
(259, 'add_payment_type', 'Add Payment Type', NULL),
(260, 'list_payment_type', 'List of Payment Type', NULL),
(261, 'payment_period', 'Payment Period', NULL),
(262, 'payment_type', 'Payment Type', NULL),
(263, 'time', 'Punch Time', NULL),
(264, 'shift', 'Shift', NULL),
(265, 'location', 'Location', NULL),
(266, 'logtype', 'Log Type', NULL),
(267, 'branch', 'Location', NULL),
(268, 'student', 'Students', NULL),
(269, 'csv', 'CSV', NULL),
(270, 'save_successfull', 'Your Data Save Successfully', NULL),
(271, 'successfully_updated', 'Your Data Successfully Updated', NULL),
(272, 'atn_form', 'Attendance Form', NULL),
(273, 'atn_report', 'Attendance Report', NULL),
(274, 'end_date', 'To', NULL),
(275, 'start_date', 'From', NULL),
(276, 'done', 'Done', NULL),
(277, 'employee_id_se', 'Write Employee Id or name here ', NULL),
(278, 'attendance_repor', 'Attendance Report', NULL),
(279, 'e_time', 'End Time', NULL),
(280, 's_time', 'Start Time', NULL),
(281, 'atn_datewiserer', 'Date Wise Report', NULL),
(282, 'atn_report_id', 'Date And Id base Report', NULL),
(283, 'atn_report_time', 'Date And Time report', NULL),
(284, 'payroll', 'Payroll', NULL),
(285, 'loan', 'Loan', NULL),
(286, 'loan_grand', 'Grant Loan', NULL),
(287, 'add_loan', 'Add Loan', NULL),
(288, 'loan_list', 'List of Loan', NULL),
(289, 'loan_details', 'Loan Details', NULL),
(290, 'amount', 'Amount', NULL),
(291, 'interest_rate', 'Interest Percentage', NULL),
(292, 'installment_period', 'Installment Period', NULL),
(293, 'repayment_amount', 'Repayment Total', NULL),
(294, 'date_of_approve', 'Approved Date', NULL),
(295, 'repayment_start_date', 'Repayment From', NULL),
(296, 'permission_by', 'Permitted By', NULL),
(297, 'grand', 'Grand', NULL),
(298, 'installment', 'Installment', NULL),
(299, 'loan_status', 'Status', NULL),
(300, 'installment_period_m', 'Installment Period in Month', NULL),
(301, 'successfully_inserted', 'Your loan Successfully Granted', NULL),
(302, 'loan_installment', 'Loan Installment', NULL),
(303, 'add_installment', 'Add Installment', NULL),
(304, 'installment_list', 'List of Installment', NULL),
(305, 'loan_id', 'Loan No', NULL),
(306, 'installment_amount', 'Installment Amount', NULL),
(307, 'payment', 'Payment', NULL),
(308, 'received_by', 'Receiver', NULL),
(309, 'installment_no', 'Install No', NULL),
(310, 'notes', 'Notes', NULL),
(311, 'paid', 'Paid', NULL),
(312, 'loan_report', 'Loan Report', NULL),
(313, 'e_r_id', 'Enter Your Employee ID', NULL),
(314, 'leave', 'Leave', NULL),
(315, 'add_leave', 'Add Leave', NULL),
(316, 'list_leave', 'List of Leave', NULL),
(317, 'dayname', 'Weekly Leave Day', NULL),
(318, 'holiday', 'Holiday', NULL),
(319, 'list_holiday', 'List of Holidays', NULL),
(320, 'no_of_days', 'Number of Days', NULL),
(321, 'holiday_name', 'Holiday Name', NULL),
(322, 'set', 'Set', NULL),
(323, 'tax', 'Tax', NULL),
(324, 'tax_setup', 'Tax Setup', NULL),
(325, 'add_tax_setup', 'Add Tax Setup', NULL),
(326, 'list_tax_setup', 'List of Tax setup', NULL),
(327, 'tax_collection', 'Tax collection', NULL),
(328, 'start_amount', 'Start Amount', NULL),
(329, 'end_amount', 'End Amount', NULL),
(330, 'rate', 'Tax Rate', NULL),
(331, 'date_start', 'Date Start', NULL),
(332, 'amount_tax', 'Tax Amount', NULL),
(333, 'collection_by', 'Collection By', NULL),
(334, 'date_end', 'Date End', NULL),
(335, 'income_net_period', 'Income  Net period', NULL),
(336, 'default_amount', 'Default Amount', NULL),
(337, 'add_sal_type', 'Add Salary Type', NULL),
(338, 'list_sal_type', 'Salary Type List', NULL),
(339, 'salary_type_setup', 'Salary Type Setup', NULL),
(340, 'salary_setup', 'Salary Setup', NULL),
(341, 'add_sal_setup', 'Add Salary Setup', NULL),
(342, 'list_sal_setup', 'Salary Setup List', NULL),
(343, 'salary_type_id', 'Salary Type', NULL),
(344, 'salary_generate', 'Salary Generate', NULL),
(345, 'add_sal_generate', 'Generate Now', NULL),
(346, 'list_sal_generate', 'Generated Salary List', NULL),
(347, 'gdate', 'Generate Date', NULL),
(348, 'start_dates', 'Start Date', NULL),
(349, 'generate', 'Generate ', NULL),
(350, 'successfully_saved_saletup', ' Set up Successful', NULL),
(351, 's_date', 'Start Date', NULL),
(352, 'e_date', 'End Date', NULL),
(353, 'salary_payable', 'Payable Salary', NULL),
(354, 'tax_manager', 'Tax', NULL),
(355, 'generate_by', 'Generated By', NULL),
(356, 'successfully_paid', 'Successfully Paid', NULL),
(357, 'direct_empl', ' Employee', NULL),
(358, 'add_emp_info', 'Add New Employee', NULL),
(359, 'new_empl_pos', 'Add New Employee Position', NULL),
(360, 'manage', 'Manage Designation', NULL),
(361, 'ad_advertisement', 'ADD POSITION', NULL),
(362, 'moduless', 'Modules', NULL),
(363, 'next', 'Next', NULL),
(364, 'finish', 'Finish', NULL),
(365, 'request', 'Request', NULL),
(366, 'successfully_saved', 'Your Data Successfully Saved', NULL),
(367, 'sal_type', 'Salary Type', NULL),
(368, 'sal_name', 'Salary Name', NULL),
(369, 'leave_application', 'Leave Application', NULL),
(370, 'apply_strt_date', 'Application Start Date', NULL),
(371, 'apply_end_date', 'Application End date', NULL),
(372, 'leave_aprv_strt_date', 'Approved Start Date', NULL),
(373, 'leave_aprv_end_date', 'Approved End Date', NULL),
(374, 'num_aprv_day', 'Approved Day', NULL),
(375, 'reason', 'Reason', NULL),
(376, 'approve_date', 'Approved Date', NULL),
(377, 'leave_type', 'Leave Type', NULL),
(378, 'apply_hard_copy', 'Application Hard Copy', NULL),
(379, 'approved_by', 'Approved By', NULL),
(380, 'notice', 'Notice Board', NULL),
(381, 'noticeboard', 'Notice Board', NULL),
(382, 'notice_descriptiion', 'Description', NULL),
(383, 'notice_date', 'Notice Date', NULL),
(384, 'notice_type', 'Notice Type', NULL),
(385, 'notice_by', 'Notice By', NULL),
(386, 'notice_attachment', 'Attachment', NULL),
(387, 'account_name', 'Account Name', NULL),
(388, 'account_type', 'Account Type', NULL),
(389, 'account_id', 'Account Name', NULL),
(390, 'transaction_description', 'Description', NULL),
(391, 'payment_id', 'Payment', NULL),
(392, 'create_by_id', 'Created By', NULL),
(393, 'account', 'Account', NULL),
(394, 'account_add', 'Add Account', NULL),
(395, 'account_transaction', 'Transaction', NULL),
(396, 'award', 'Award', NULL),
(397, 'new_award', 'New Award', NULL),
(398, 'award_name', 'Award Name', NULL),
(399, 'aw_description', 'Award Description', NULL),
(400, 'awr_gift_item', 'Gift Item', NULL),
(401, 'awarded_by', 'Award By', NULL),
(402, 'employee_name', 'Employee Name', NULL),
(403, 'employee_list', 'Atn List', NULL),
(404, 'department', 'Department', NULL),
(405, 'department_name', 'Department Name ', NULL),
(406, 'clockout', 'Clock Out', NULL),
(407, 'se_account_id', 'Select Account Name', NULL),
(408, 'division', 'Division', NULL),
(409, 'add_division', 'Add Division', NULL),
(410, 'update_division', 'Update Division', NULL),
(411, 'division_name', 'Division Name', NULL),
(412, 'division_list', 'Manage Division ', NULL),
(413, 'designation_list', 'Designation List', NULL),
(414, 'manage_designation', 'Manage Designation', NULL),
(415, 'add_designation', 'Add Designation', NULL),
(416, 'select_division', 'Select Division', NULL),
(417, 'select_designation', 'Select Designation', NULL),
(418, 'asset', 'Asset', NULL),
(419, 'asset_type', 'Asset Type', NULL),
(420, 'add_type', 'Add Type', NULL),
(421, 'type_list', 'Type List', NULL),
(422, 'type_name', 'Type Name', NULL),
(423, 'select_type', 'Select Type', NULL),
(424, 'equipment_name', 'Equipment Name', NULL),
(425, 'model', 'Model', NULL),
(426, 'serial_no', 'Serial No', NULL),
(427, 'equipment', 'Equipment', NULL),
(428, 'add_equipment', 'Add Equipment', NULL),
(429, 'equipment_list', 'Equipment List', NULL),
(430, 'type', 'Type', NULL),
(431, 'equipment_maping', 'Equipment Mapping', NULL),
(432, 'add_maping', 'Add Mapping', NULL),
(433, 'maping_list', 'Mapping List', NULL),
(434, 'update_equipment', 'Update Equipment', NULL),
(435, 'select_employee', 'Select Employee', NULL),
(436, 'select_equipment', 'Select Equipment', NULL),
(437, 'basic_info', 'Basic Information', NULL),
(438, 'middle_name', 'Middle Name', NULL),
(441, 'zip_code', 'Zip Code', NULL),
(442, 'maiden_name', 'Maiden Name', NULL),
(443, 'add_employee', 'Add Employee', NULL),
(444, 'manage_employee', 'Manage Employee', NULL),
(445, 'employee_update_form', 'Employee Update Form', NULL),
(446, 'what_you_search', 'What You Search', NULL),
(448, 'duty_type', 'Duty Type', NULL),
(449, 'hire_date', 'Hire Date', NULL),
(450, 'original_h_date', 'Original Hire Date', NULL),
(451, 'voluntary_termination', 'Voluntary Termination', NULL),
(452, 'termination_reason', 'Termination Reason', NULL),
(453, 'termination_date', 'Termination Date', NULL),
(454, 're_hire_date', 'Re Hire Date', NULL),
(455, 'rate_type', 'Rate Type', NULL),
(456, 'pay_frequency', 'Pay Frequency', NULL),
(457, 'pay_frequency_txt', 'Pay Frequency Text', NULL),
(458, 'hourly_rate2', 'Hourly Rate2', NULL),
(459, 'hourly_rate3', 'Hourly Rate3', NULL),
(460, 'home_department', 'Home Department', NULL),
(461, 'department_text', 'Department Text', NULL),
(462, 'benifit_class_code', 'Benefit Class code', NULL),
(463, 'benifit_desc', 'Benefit Description', NULL),
(464, 'benifit_acc_date', 'Benefit Accrual Date', NULL),
(465, 'benifit_sta', 'Benefit Status', NULL),
(466, 'super_visor_name', 'Supervisor Name', NULL),
(467, 'is_super_visor', 'Is Supervisor', NULL),
(468, 'supervisor_report', 'Supervisor Report', NULL),
(469, 'dob', 'Date of Birth', NULL),
(470, 'gender', 'Gender', NULL),
(471, 'marital_stats', 'Marital Status', NULL),
(472, 'ethnic_group', 'Ethnic Group', NULL),
(473, 'eeo_class_gp', 'EEO Class', NULL),
(474, 'ssn', 'SSN', NULL),
(475, 'work_in_state', 'Work in State', NULL),
(476, 'live_in_state', 'Live in State', NULL),
(477, 'home_email', 'Home Email', NULL),
(478, 'business_email', 'Business Email', NULL),
(479, 'home_phone', 'Home Phone', NULL),
(480, 'business_phone', 'Business Phone', NULL),
(481, 'cell_phone', 'Cell Phone', NULL),
(482, 'emerg_contct', 'Emergency Contact', NULL),
(483, 'emerg_home_phone', 'Emergency Home Phone', NULL),
(484, 'emrg_w_phone', 'Emergency Work Phone', NULL),
(485, 'emer_con_rela', 'Emergency Contact Relation', NULL),
(486, 'alt_em_contct', 'Alter Emergency Contact', NULL),
(487, 'alt_emg_h_phone', 'Alt Emergency Home Phone', NULL),
(488, 'alt_emg_w_phone', 'Alt Emergency  Work Phone', NULL),
(489, 'reports', 'Reports', NULL),
(490, 'employee_reports', 'Employee Reports', NULL),
(491, 'demographic_report', 'Demographic Report', NULL),
(492, 'posting_report', 'Positional Report', NULL),
(493, 'custom_report', 'Custom Report', NULL),
(494, 'benifit_report', 'Benefit Report', NULL),
(495, 'demographic_info', 'Demographical Information', NULL),
(496, 'positional_info', 'Positional Info', NULL),
(497, 'assets_info', 'Assets Information', NULL),
(498, 'custom_field', 'Custom Field', NULL),
(499, 'custom_value', 'Custom Data', NULL),
(500, 'adhoc_report', 'Adhoc Report', NULL),
(501, 'asset_assignment', 'Asset Assignment', NULL),
(502, 'assign_asset', 'Assign Assets', NULL),
(503, 'assign_list', 'Assign List', NULL),
(504, 'update_assign', 'Update Assign', NULL),
(505, 'citizenship', 'Citizenship', NULL),
(506, 'class_sta', 'Class status', NULL),
(507, 'class_acc_date', 'Class Accrual date', NULL),
(508, 'class_descript', 'Class Description', NULL),
(509, 'class_code', 'Class Code', NULL),
(510, 'return_asset', 'Return Assets', NULL),
(511, 'dept_id', 'Department ID', NULL),
(512, 'parent_id', 'Parent ID', NULL),
(513, 'equipment_id', 'Equipment ID', NULL),
(514, 'issue_date', 'Issue Date', NULL),
(515, 'damarage_desc', 'Damarage Description', NULL),
(516, 'return_date', 'Return Date', NULL),
(517, 'is_assign', 'Is Assign', NULL),
(518, 'emp_his_id', 'Employee History ID', NULL),
(519, 'damarage_descript', 'Damage Description', NULL),
(520, 'return', 'Return', NULL),
(521, 'return_successfull', 'Return Successful', NULL),
(522, 'return_list', 'Return List', NULL),
(523, 'custom_data', 'Custom Data', NULL),
(524, 'passing_year', 'Passing Year', NULL),
(525, 'is_admin', 'Is Admin', NULL),
(526, 'zip', 'Zip Code', NULL),
(527, 'original_hire_date', 'Original Hire Date', NULL),
(528, 'rehire_date', 'Rehire Date', NULL),
(529, 'class_code_desc', 'Class Code Description', NULL),
(530, 'class_status', 'Class Status', NULL),
(531, 'super_visor_id', 'Supervisor ID', NULL),
(532, 'marital_status', 'Marital Status', NULL),
(533, 'emrg_h_phone', 'Emergency Home Phone', NULL),
(534, 'emgr_contct_relation', 'Emergency Contact Relation', NULL),
(535, 'id', 'ID', NULL),
(536, 'type_id', 'Equipment Type', NULL),
(537, 'custom_id', 'Custom ID', NULL),
(538, 'custom_data_type', 'Custom Data Type', NULL),
(539, 'role_permission', 'Role Permission', NULL),
(540, 'permission_setup', 'Permission Setup', NULL),
(541, 'add_role', 'Add Role', NULL),
(542, 'role_list', 'Role List', NULL),
(543, 'user_access_role', 'User Access Role', NULL),
(544, 'menu_item_list', 'Menu Item List', NULL),
(545, 'ins_menu_for_application', 'Ins Menu  For Application', NULL),
(547, 'page_url', 'Page URL', NULL),
(549, 'role', 'Role', NULL),
(550, 'role_name', 'Role Name', NULL),
(551, 'single_checkin', 'Single Check In', NULL),
(552, 'bulk_checkin', 'Bulk Check In', NULL),
(553, 'manage_attendance', 'Manage Attendance', NULL),
(554, 'attendance_list', 'Attendance List', NULL),
(557, 'stay', 'Stay', NULL),
(558, 'attendance_report', 'Attendance Report', NULL),
(559, 'work_hour', 'Work Hour', NULL),
(560, 'cancel', 'Cancel', NULL),
(561, 'confirm_clock', 'Confirm Checkout', NULL),
(562, 'add_attendance', 'Add Attendance', NULL),
(563, 'upload_csv', 'Upload CSV', NULL),
(564, 'import_attendance', 'Import Attendance', NULL),
(565, 'manage_account', 'Manage Account', NULL),
(566, 'add_account', 'Add Account', NULL),
(567, 'add_new_account', 'Add New Account', NULL),
(568, 'account_details', 'Account Details', NULL),
(569, 'manage_transaction', 'Manage Transaction', NULL),
(570, 'add_expence', 'Add Experience', NULL),
(571, 'add_income', 'Add Income', NULL),
(572, 'return_now', 'Return Now !!', NULL),
(573, 'manage_award', 'Manage Award', NULL),
(574, 'add_new_award', 'Add New Award', NULL),
(575, 'personal_information', 'Personal Information', NULL),
(576, 'educational_information', 'Educational Information', NULL),
(577, 'past_experience', 'Past Experience', NULL),
(578, 'basic_information', 'Basic Information', NULL),
(579, 'result', 'Result', NULL),
(580, 'institute_name', 'Institute Name', NULL),
(581, 'education', 'Education', NULL),
(582, 'manage_shortlist', 'Manage Short List', NULL),
(583, 'manage_interview', 'Manage Interview', NULL),
(584, 'manage_selection', 'Manage Selection', NULL),
(585, 'add_new_dept', 'Add New Department', NULL),
(586, 'manage_dept', 'Manage Department', NULL),
(587, 'successfully_checkout', 'Checkout Successful !', NULL),
(588, 'grant_loan', 'Grant Loan', NULL),
(589, 'successfully_installed', 'Successfully Installed', NULL),
(590, 'total_loan', 'Total Loan', NULL),
(591, 'total_amount', 'Total Amount', NULL),
(592, 'filter', 'Filter', NULL),
(593, 'weekly_holiday', 'Weekly Holiday', NULL),
(594, 'manage_application', 'Manage Application', NULL),
(595, 'add_application', 'Add Application', NULL),
(596, 'manage_holiday', 'Manage Holiday', NULL),
(597, 'add_more_holiday', 'Add More Holiday', NULL),
(598, 'manage_weekly_holiday', 'Manage Weekly Holiday', NULL),
(599, 'add_weekly_holiday', 'Add Weekly Holiday', NULL),
(600, 'manage_granted_loan', 'Manage Granted Loan', NULL),
(601, 'manage_installment', 'Manage Installment', NULL),
(602, 'add_new_notice', 'Add New Notice', NULL),
(603, 'manage_notice', 'Manage Notice', NULL),
(604, 'salary_type', 'Salary Type', NULL),
(605, 'manage_salary_generate', 'Manage Salary Generate', NULL),
(606, 'generate_now', 'Generate Now', NULL),
(607, 'add_salary_setup', 'Add Salary Setup', NULL),
(608, 'manage_salary_setup', 'Manage Salary Setup', NULL),
(609, 'add_salary_type', 'Add Salary Type', NULL),
(610, 'manage_salary_type', 'Manage Salary Type', NULL),
(611, 'manage_tax_setup', 'Manage Tax Setup', NULL),
(612, 'setup_tax', 'Setup Tax', NULL),
(613, 'add_more', 'Add More', NULL),
(614, 'tax_rate', 'Tax Rate', NULL),
(615, 'no', 'No', NULL),
(616, 'setup', 'Setup', NULL),
(617, 'biographicalinfo', 'Bio-Graphical Information', NULL),
(618, 'positional_information', 'Positional Information', NULL),
(620, 'benifits', 'Benefits', NULL),
(621, 'others_leave_application', 'Others Leave', NULL),
(622, 'add_leave_type', 'Add Leave Type', NULL),
(623, 'others_leave', 'Apply Leave', NULL),
(624, 'number_of_leave_days', 'Number of Leave Days', NULL),
(627, 'add_category', 'Add Category', NULL),
(630, 'add_food', 'Add Food', NULL),
(634, 'category_subtitle', 'Category Subtitle', NULL),
(635, 'update_category', 'Update Category', NULL),
(636, 'update_fooditem', 'Update Food Item', NULL),
(713, 'food_list', 'Food List', NULL),
(717, 'category_name', 'Category Name', NULL),
(718, 'category_list', 'Category List', NULL),
(719, 'itemmanage', 'Food Management', NULL),
(720, 'manage_category', 'Manage Category', NULL),
(721, 'manage_food', 'Manage Food', NULL),
(722, 'offerdate', 'Offer Start Date', NULL),
(723, 'manage_addons', 'Manage Add-ons', NULL),
(724, 'add_adons', 'Add Add-ons', NULL),
(725, 'menu_addons', 'Add-ons Menu', NULL),
(726, 'addons_list', 'Add-ons List', NULL),
(727, 'assign_adons', 'Add-ons Assign', NULL),
(728, 'assign_adons_list', 'Add-ons Assign List', NULL),
(729, 'update_adons', 'Update Add-ons', NULL),
(730, 'item_name', 'Food Name', NULL),
(731, 'price', 'Price', NULL),
(732, 'offerenddate', 'Offer End Date', NULL),
(733, 'units', 'Unit and Ingredients', NULL),
(734, 'manage_unitmeasurement', 'Unit Measurement', NULL),
(735, 'unit_list', 'Unit Measurement List', NULL),
(736, 'unit_add', 'Add Unit', NULL),
(737, 'unit_update', 'Unit Update', NULL),
(738, 'unit_name', 'Unit Name', NULL),
(739, 'manage_ingradient', 'Manage Ingredients', NULL),
(740, 'ingradient_list', 'Ingredient List', NULL),
(741, 'add_ingredient', 'Add Ingredient', NULL),
(742, 'ingredient_name', 'Ingredient Name', NULL),
(743, 'unit_short_name', 'Short Name', NULL),
(744, 'update_ingredient', 'Update Ingredient', NULL),
(745, 'component', 'Components', NULL),
(746, 'vat_tax', 'Vat', NULL),
(748, 'food_varient', 'Food Variant', NULL),
(749, 'food_availablity', 'Food Availability', NULL),
(750, 'add_varient', 'Add Variant', NULL),
(751, 'varient_name', 'Variant', NULL),
(752, 'variant_list', 'Variant List', NULL),
(753, 'variant_edit', 'Update Variant', NULL),
(754, 'food_availablelist', 'Food Available List', NULL),
(755, 'add_availablity', 'Add Available Day & Time', NULL),
(756, 'edit_availablity', 'Update Available Day & Time', NULL),
(757, 'available_day', 'Available Day', NULL),
(758, 'available_time', 'Available Time', NULL),
(759, 'membership_management', 'Membership Management', NULL),
(760, 'membership_list', 'Membership List', NULL),
(761, 'membership_name', 'Membership Name', NULL),
(762, 'discount', 'Discount', NULL),
(763, 'other_facilities', 'Other Facilities', NULL),
(764, 'membership_add', 'Add Membership', NULL),
(765, 'membership_edit', 'Update Membership', NULL),
(766, 'payment_setting', 'Payment Method Setting', NULL),
(767, 'paymentmethod_list', 'Payment Method List', NULL),
(768, 'payment_add', 'Add Payment Method', NULL),
(769, 'payment_edit', 'Update Payment Method', NULL),
(770, 'payment_name', 'Payment Method Name', NULL),
(771, 'shipping_setting', 'Shipping Method Setting', NULL),
(772, 'shipping_list', 'Shipping Method List', NULL),
(773, 'shipping_name', 'Shipping Method Name', NULL),
(774, 'shipping_add', 'Add Shipping Method', NULL),
(775, 'shipping_edit', 'Update Shipping Method', NULL),
(776, 'shippingrate', 'Shipping Rate', NULL),
(777, 'supplier_manage', 'Supplier Manage', NULL),
(778, 'supplier_name', 'Supplier Name', NULL),
(779, 'supplier_list', 'Supplier List', NULL),
(780, 'mobile', 'Mobile', NULL),
(781, 'address', 'Address', NULL),
(782, 'supplier_add', 'Add Supplier', NULL),
(783, 'supplier_edit', 'Update Supplier', NULL),
(784, 'purchase_item', 'Purchase Item', NULL),
(785, 'purchase', 'Purchase Manage', NULL),
(786, 'purchase_list', 'Purchase List', NULL),
(787, 'purchase_add', 'Add Purchase', NULL),
(788, 'purchase_edit', 'Update Purchase', NULL),
(789, 'quantity', 'Quantity', NULL),
(790, 'supplier_information', 'Supplier Information', NULL),
(791, 'add_new_order', 'Add New Order', NULL),
(792, 'pending_order', 'Pending Order', NULL),
(793, 'processing_order', 'Processing Order', NULL),
(794, 'cancel_order', 'Cancel Order', NULL),
(795, 'complete_order', 'Complete Order', NULL),
(796, 'pos_invoice', 'POS Invoice', NULL),
(797, 'ordermanage', 'Manage Order', NULL),
(798, 'table_manage', 'Manage Table', NULL),
(799, 'table_edit', 'Update Table', NULL),
(800, 'table_list', 'Table List', NULL),
(801, 'table_name', 'Table Name', NULL),
(802, 'customer_type', 'Customer Type', NULL),
(803, 'customertype_list', 'Customer Type List', NULL),
(804, 'production', 'Production', NULL),
(805, 'add_table', 'Table Add', NULL),
(806, 'table_add', 'Add Table', NULL),
(807, 'add_new_table', 'Add Table', NULL),
(808, 'order_list', 'Order List', NULL),
(809, 'currency', 'Currency', NULL),
(810, 'currency_list', 'Currency List', NULL),
(811, 'currency_name', 'Currency Name', NULL),
(812, 'currency_add', 'Add Currency', NULL),
(813, 'currency_edit', 'Update Currency', NULL),
(814, 'currency_icon', 'Currency Icon', NULL),
(815, 'currency_rate', 'Conversion Rate', NULL),
(816, 'report', 'Report', NULL),
(817, 'purchase_report', 'Purchase Report', NULL),
(818, 'purchase_report_ingredient', 'Stock Report (Kitchen)', NULL),
(819, 'stock_report', 'Stock Report', NULL),
(820, 'sell_report', 'Sales Report', NULL),
(821, 'stock_report_product_wise', 'Stock Report (Food Items)', NULL),
(822, 'accounts', 'Accounts', NULL),
(823, 'c_o_a', 'Chart of Accounts', NULL),
(824, 'debit_voucher', 'Debit Voucher', NULL),
(825, 'credit_voucher', 'Credit Voucher', NULL),
(826, 'contra_voucher', 'Contra Voucher', NULL),
(827, 'journal_voucher', 'Journal Voucher', NULL),
(828, 'voucher_approval', 'Voucher Approval', NULL),
(829, 'account_report', 'Accounts Report', NULL),
(830, 'voucher_report', 'Voucher Report', NULL),
(831, 'cash_book', 'Cash Book', NULL),
(832, 'bank_book', 'Bank Book', NULL),
(833, 'general_ledger', 'General Ledger', NULL),
(834, 'trial_balance', 'Trial Balance', NULL),
(835, 'profit_loss', 'Profit Loss', NULL),
(836, 'cash_flow', 'Cash Flow', NULL),
(837, 'coa_print', 'COA Print', NULL),
(838, 'in_quantity', 'In Quantity', NULL),
(839, 'out_quantity', 'Out Quantity', NULL),
(840, 'stock', 'Stock', NULL),
(841, 'find', 'Find', NULL),
(842, 'from_date', 'From', NULL),
(843, 'to_date', 'To', NULL),
(844, 'approved', 'Approved', NULL),
(845, 'total_ammount', 'Total Amount', NULL),
(846, 'total_purchase', 'Total Purchase', NULL),
(847, 'total_sale', 'Total Sale', NULL),
(848, 'csv_file_informaion', 'CSV File Information', NULL),
(849, 'import_product_csv', 'Import product (CSV)', NULL),
(851, 'production_set_list', 'Production Set List', NULL),
(852, 'production_add', 'Add Production', NULL),
(853, 'production_list', 'Production List', NULL),
(854, 'billing_from', 'Billing From', NULL),
(855, 'invoice', 'Invoice', NULL),
(856, 'invoice_no', 'Invoice No', NULL),
(857, 'billing_date', 'Billing Date', NULL),
(858, 'billing_to', 'Billing To', NULL),
(859, 'reservation', 'Reservation', NULL),
(860, 'take_reservation', 'Take A Reservation', NULL),
(861, 'update_table', 'Table Update', NULL),
(862, 'reserve_time', 'Reservation Table', NULL),
(863, 'reservation_table', 'Add Booking', NULL),
(864, 'table_setting', 'Table Setting', NULL),
(865, 'capacity', 'Capacity', NULL),
(866, 'icon', 'Icon', NULL),
(867, 'purchase_return', 'Purchase Return', NULL),
(868, 'purchase_qty', 'Purchase Qty', NULL),
(869, 'return_qty', 'Return Qty', NULL),
(870, 'total', 'Total', NULL),
(871, 'select', 'Select', NULL),
(872, 'return_invoice', 'Return Invoice', NULL),
(873, 'invoice_view', 'View Invoice', NULL),
(874, 'grand_total', 'Grand Total', NULL),
(875, 'supplier', 'Supplier', NULL),
(876, 'po_no', 'Invoice No', NULL),
(877, 'grant', 'Grant', NULL),
(878, 'hrm', 'Human Resource', NULL),
(879, 'departmentfrm', 'Add Department', NULL),
(880, 'benefits', 'Benefits', NULL),
(881, 'class', 'Class', NULL),
(882, 'biographical_info', 'Biographical Info', NULL),
(883, 'additional_address', 'Additional Address', NULL),
(884, 'custom', 'Custom', NULL),
(885, 'pay_now', 'Pay Now ??', NULL),
(886, 'paymentmethod_setup', 'Payment Setup', NULL),
(887, 'add_paymentsetup', 'Add New Payment Setup', NULL),
(888, 'edit_setup', 'Update Setup', NULL),
(889, 'marchantid', 'Marchant ID', NULL),
(890, 'order_successfully', 'Your Payment was Completed!!!.', NULL),
(891, 'order_fail', 'Payment Incomplete!!!', NULL),
(892, 'voucher_no', 'Voucher No', NULL),
(893, 'remark', 'Remark', NULL),
(894, 'code', 'Code', NULL),
(895, 'debit', 'Debit', NULL),
(896, 'credit', 'Credit', NULL),
(897, 'template_name', 'Template Name ', NULL),
(898, 'sms_template', 'SMS Template', NULL),
(899, 'sms_template_warning', 'Please Use ', NULL),
(900, 'userid', 'User ID', NULL),
(901, 'from', 'From', NULL),
(902, 'opening_cash_and_equivalent', 'Opening Cash & Equivalent', NULL),
(903, 'amount_in_Dollar', 'Amount In Dollar', NULL),
(904, 'pre_balance', 'Pre Balance', NULL),
(905, 'current_balance', 'Current Balance', NULL),
(906, 'with_details', 'With Details', NULL),
(907, 'credit_account_head', 'Credit Account Head', NULL),
(908, 'gl_head', 'GL Head', NULL),
(909, 'transaction_head', 'Transaction Head', NULL),
(910, 'confirm', 'Confirm', NULL),
(911, 's_rate', 'Rate', NULL),
(912, 'web_setting', 'Web Setting', NULL),
(913, 'banner_setting', 'Banner Setting', NULL),
(914, 'menu_setting', 'Menu Setting', NULL),
(915, 'widget_setting', 'Widget Setting', NULL),
(916, 'add_banner', 'Add Banner', NULL),
(917, 'bannertype', 'Add Banner Type', NULL),
(918, 'banner_list', 'Banner List', NULL),
(919, 'title', 'Title', NULL),
(920, 'subtitle', 'Sub Title', NULL),
(921, 'banner_type', 'Banner Type', NULL),
(922, 'link_url', 'Link URL', NULL),
(923, 'banner_edit', 'Banner Update', NULL),
(924, 'menu_name', 'Menu Name', NULL),
(925, 'menu_url', 'Menu Slug', NULL),
(926, 'sub_menu', 'Sub Menu', NULL),
(927, 'add_menu', 'Add Menu', NULL),
(928, 'parent_menu', 'Parent Menu', NULL),
(929, 'widget_name', 'Widget Name', NULL),
(930, 'widget_title', 'Widget Title', NULL),
(931, 'widget_desc', 'Description', NULL),
(932, 'add_widget', 'Add New', NULL),
(933, 'common_setting', 'Common Setting', NULL),
(934, 'bannersize', 'Banner Size', NULL),
(936, 'height', 'Height', NULL),
(937, 'exclusive', 'Exclusive', NULL),
(938, 'best_Offers', 'Best Offer', NULL),
(939, 'invalid_size', 'Invalid Size', NULL),
(940, 'confirm_reservation', 'Confirm Reservation', NULL),
(941, 'food_details', 'Food Details', NULL),
(942, 'email_setting', 'Email Setting', NULL),
(943, 'contact_email_list', 'Contact List', NULL),
(944, 'subscribelist', 'Subscribe List', NULL),
(945, 'contact_send', 'Your Contact Information Send Successfully.', NULL),
(946, 'couponlist', 'Coupon List', NULL),
(947, 'add_coupon', 'Add Coupon', NULL),
(948, 'coupon_Code', 'Coupon Code', NULL),
(949, 'coupon_rate', 'Coupon Value', NULL),
(950, 'coupon_startdate', 'Start Date', NULL),
(951, 'coupon_enddate', 'End Date', NULL),
(952, 'coupon_edit', 'Update Coupon', NULL),
(953, 'rating', 'Rating ', NULL),
(954, 'add_rating', 'Add Rating', NULL),
(955, 'reviewtxt', 'Review Text', NULL),
(956, 'rating_edit', 'Rating Update', NULL),
(957, 'customer_rating', 'Customer Rating', NULL),
(958, 'country_list', 'Country List', NULL),
(959, 'countryname', 'Country Name', NULL),
(960, 'add_country', 'Add Country', NULL),
(961, 'edit_country', 'Update Country', NULL),
(962, 'add_state', 'Add State', NULL),
(963, 'edit_state', 'State Update', NULL),
(964, 'state', 'State', NULL),
(965, 'city', 'City', NULL),
(966, 'add_city', 'Add City', NULL),
(967, 'edit_city', 'City Update', NULL),
(968, 'country', 'Country', NULL),
(969, 'state_list', 'State List', NULL),
(970, 'city_list', 'All City', NULL),
(971, 'server_setting', 'App Setting', NULL),
(972, 'netip', 'Your Local Host Full URL', NULL),
(974, 'onlinebdname', 'Online Database Name', NULL),
(975, 'dbuser', 'Database User', NULL),
(976, 'dbpassword', 'Database Password', NULL),
(977, 'dbhost', 'Database Host Name', NULL),
(978, 'social_setting', 'Social Setting', NULL),
(979, 'url_link', 'URL', NULL),
(980, 'sicon', 'Select Icon', NULL),
(981, 'ord_failed', 'Order Failed!!!', NULL),
(982, 'failed_msg', 'Order not placed due to some reason. Please Try Again!!!. Thank You !!!', NULL),
(983, 'ord_succ', 'Order Placed Successfully!!!', NULL),
(984, 'succ_smg', 'Are you Sure to Print This Invoice????', NULL),
(985, 'no_order_run', 'No Order Running', NULL),
(986, 'thirdpartycustomer_list', 'Third-Party Customers', NULL),
(987, '3rd_customer_list', 'Third-Party Customers List', NULL),
(988, '3rdcompany_name', 'Company Name', NULL),
(989, 'add_3rdparty_comapny', 'Add New Company', NULL),
(990, 'update_3rdparty', 'Update Company', NULL),
(991, 'commision', 'Commission', NULL),
(992, 'list_of_card_terminal', 'Card Terminal List', NULL),
(993, 'add_new_terminal', 'Add New Terminal', NULL),
(994, 'update_terminal', 'Update Terminal', NULL),
(995, 'card_terminal_name', 'Card Terminal Name', NULL),
(996, 'list_of_bank', 'Bank List', NULL),
(997, 'add_bank', 'Add New Bank', NULL),
(998, 'update_bank', 'Update Bank', NULL),
(999, 'bank_name', 'Bank Name', NULL),
(1000, 'sell_report_filter', 'Sale Report Filtering', NULL),
(1001, 'sms_setting', 'SMS Setting', NULL),
(1002, 'sms_configuration', 'SMS Configuration', NULL),
(1003, 'sms_temp', 'SMS Template', NULL),
(1004, 'candidate_name', 'Candidate Name', NULL),
(1005, 'assign1_role', 'Assign Role', NULL),
(1006, 'customer_list', 'Customer List', NULL),
(1007, 'customer_name', 'Customer Name', NULL),
(1008, 'update_ord', 'Update Order', NULL),
(1009, 'final_report', 'Final Report', NULL),
(1010, 'ehrm', 'HRM', NULL),
(1011, 'add_expense_item', 'Add Expense Item', NULL),
(1012, 'manage_expense_item', 'Manage Expense Item', NULL),
(1013, 'add_expense', 'Add Expense', NULL),
(1014, 'manage_expense', 'Manage Expense', NULL),
(1015, 'expense_statement', 'Expense Statement', NULL),
(1016, 'expense_type', 'Expense Type', NULL),
(1017, 'expense_item_name', 'Expense Item Name', NULL),
(1018, 'expense', 'Expense', NULL),
(1020, 'signature_pic', 'Signature Picture', NULL),
(1021, 'branch1', 'Branch', NULL),
(1022, 'ac_no', 'A/C Number', NULL),
(1023, 'ac_name', 'A/C Name', NULL),
(1024, 'bank_transaction', 'Bank Transaction', NULL),
(1025, 'bank', 'Bank', NULL),
(1027, 'bank_ledger', 'Bank Ledger', NULL),
(1028, 'note_name', 'Note Name', NULL),
(1029, 'balance', 'Balance', NULL),
(1030, 'previous_balance', 'Previous Credit Balance', NULL),
(1031, 'manage_supplier_ledger', 'Manage supplier Ledger', NULL),
(1032, 'supplier_ledger', 'Supplier Ledger', NULL),
(1033, 'print', 'Print', NULL),
(1034, 'select_supplier', 'Select Supplier', NULL),
(1035, 'deposite_id', 'Deposit ID', NULL),
(1036, 'print_date', 'Print Date', NULL),
(1037, 'manage_bank', 'Manage Bank', NULL),
(1038, 'add_new_bank', 'Add New Bank', NULL),
(1039, 'bank_list', 'Bank List', NULL),
(1040, 'bank_edit', 'Bank Edit', NULL),
(1041, 'debit_plus', 'Debit (+)', NULL),
(1042, 'credit_minus', 'Credit (-)', NULL),
(1043, 'withdraw_deposite_id', 'Withdraw / Deposit ID', NULL),
(1044, 'cash_adjustment', 'Cash Adjustment', NULL),
(1045, 'adjustment_type', 'Adjustment Type', NULL),
(1046, 'supplier_payment', 'Supplier Payment', NULL),
(1047, 'prepared_by', 'Prepared By', NULL),
(1048, 'authorized_signature', 'Authorized Signature', NULL),
(1049, 'chairman', 'Chairman', NULL),
(1050, 'kitchen_dashboard', 'Kitchen Dashboard', NULL),
(1051, 'counter_dashboard', 'Counter Dashboard', NULL),
(1052, 'nw_order', 'New Order', NULL),
(1053, 'ongoingorder', 'On Going Order', NULL),
(1054, 'tdayorder', 'Today Order', NULL),
(1055, 'onlineord', 'Online Order ', NULL),
(1056, 'table', 'Table', NULL),
(1057, 'waiter', 'Waiter', NULL),
(1058, 'del_company', 'Delivery Company', NULL),
(1059, 'cookedtime', 'Cooking Time', NULL),
(1060, 'ord_num', 'Order Number', NULL),
(1061, 'cmplt', 'Complete', NULL),
(1062, 'sl_payment', 'Select Your Payment Method', NULL),
(1063, 'paymd', 'Payment Method', NULL),
(1064, 'crd_terminal', 'Card Terminal', NULL),
(1065, 'sl_bank', 'Select Bank', NULL),
(1066, 'lstdigit', 'Last 4 Digit', NULL),
(1067, 'cuspayment', 'Customer Payment', NULL),
(1068, 'cng_amount', 'Changes Amount', NULL),
(1069, 'pay_print', 'Pay Now & Print Invoice', NULL),
(1070, 'payn', 'Pay Now', NULL),
(1071, 'ordid', 'Order ID', NULL),
(1072, 'can_reason', 'Cancel Reason', NULL),
(1073, 'can_ord', 'Cancel Order', NULL),
(1074, 'close', 'Close', NULL),
(1075, 'add_customer', 'Add Customer', NULL),
(1076, 'fav_addesrr', 'Favorite Address', NULL),
(1077, 'tabltno', 'Table No', NULL),
(1078, 'ordate', 'Order Date', NULL),
(1079, 'payment_status', 'Payment Status', NULL),
(1080, 'ordtcoun', 'Order Time Countdown Board', NULL),
(1081, 'remtime', 'Remaining Time', NULL),
(1082, 'ordtime', 'Order Time', NULL),
(1083, 'ord', 'Order', NULL),
(1084, 'tok', 'Token', NULL),
(1085, 'view_ord', 'View Order', NULL),
(1086, 'fdready', 'Food Ready', NULL),
(1087, 'fdnready', 'Food Not Ready', NULL),
(1088, 'foodrfs', 'Food is Ready for Served!!', NULL),
(1089, 'foodnrfs', 'Food Not Ready for Served', NULL),
(1090, 'ordready', 'Order Ready', NULL),
(1091, 'sele_by_date', 'Sale By Date', NULL),
(1092, 'withdetails', 'With Details', NULL),
(1093, 'topeneqv', 'Total Opening Cash & Cash Equivalent', NULL),
(1094, 'cashopen', 'Cashflow from Operating Activities', NULL),
(1095, 'payact', 'Payment for Other Operating Activities', NULL),
(1096, 'cash_gand_lie', 'Cash generated from Operating Activities before Changing in Operating Assets & Liabilities', NULL),
(1097, 'casfactive', 'Cashflow from Non Operating Activities', NULL),
(1098, 'cashnonlia', 'Cash generated from Non Operating Activities before Changing in Operating Assets & Liabilities', NULL),
(1099, 'incdre', 'Increase/Decrease in Operating Assets & Liabilities', NULL),
(1100, 'Tincdre', 'Total Increase/Decrease', NULL),
(1101, 'netopenactv', 'Net Cash From Operating/Non Operating Activities', NULL),
(1102, 'cfact', 'Cash Flow from Investing Activities', NULL),
(1103, 'ncuia', 'Net Cash Used Investing Activities', NULL),
(1104, 'cfffa', 'Cash Flow from Financing Activities', NULL),
(1105, 'netcufa', 'Net  Cash Used Financing Activities', NULL),
(1106, 'ncio', 'Net Cash Inflow/Outflow', NULL),
(1107, 'pflos', 'Profit Loss', NULL),
(1108, 'clcEq', 'Closing Cash & Cash Equivalent:', NULL),
(1109, 'TcccE', 'Total Closing Cash & Cash Equivalent', NULL),
(1110, 'pp_by', 'Prepared By', NULL),
(1111, 'act', 'Accounts', NULL),
(1112, 'ausig', 'Authorized Signature', NULL),
(1113, 'particls', 'Particulars', NULL),
(1114, 'back', 'Back', NULL),
(1115, 'bk_vouchar', 'Bank Book Voucher', NULL),
(1116, 'errorajdata', 'Error get data from ajax', NULL),
(1117, 'reach_limit', 'You have reached the limit of adding', NULL),
(1118, 'inpt', 'inputs', NULL),
(1119, 'cantdel', 'There only one row you can\'t delete.', NULL),
(1120, 'slsuplier', 'Select Supplier', NULL),
(1121, 'ptype', 'Payment Type', NULL),
(1122, 'casp', 'Cash Payment', NULL),
(1123, 'bnkp', 'Bank Payment', NULL),
(1124, 'slbank', 'Select Bank', NULL),
(1125, 'cscrv', 'Cash Credit Voucher', NULL),
(1126, 'ac_code', 'Account Code', NULL),
(1127, 'ac_head', 'Account Head', NULL),
(1128, 'iword', 'In word', NULL),
(1129, 'ac_office', 'Accounts Officer', NULL),
(1130, 'latestv', 'Latest version', NULL),
(1131, 'after19', 'Auto Update Feature working On  after 1.9', NULL),
(1132, 'crver', 'Current version', NULL),
(1133, 'notesupdate', 'note: strongly recommended to backup your <b>SOURCE FILE</b> and <b>DATABASE</b> before update.', NULL),
(1134, 'noupdates', 'No Update available', NULL),
(1135, 'lic_pur_key', 'License/Purchase key', NULL),
(1136, 'lifeord', 'Lifetime Orders', NULL),
(1137, 'tdaysell', 'Today Sale', NULL),
(1138, 'tcustomer', 'Total Customer', NULL),
(1139, 'tdeliv', 'Total Delivered', NULL),
(1140, 'treserv', 'Total Reservation', NULL),
(1141, 'latestord', 'Latest Order', NULL),
(1142, 'latest_reser', 'Latest Reservation', NULL),
(1143, 'ord_number', 'Order No.', NULL),
(1144, 'latestolorder', 'Latest Online Order', NULL),
(1145, 'monsalamntorder', 'Monthly Sales Amount and Order', NULL),
(1146, 'onlineofline', 'Online Vs Offline Order & Sales', NULL),
(1147, 'pending_ord', 'Pending Order', NULL),
(1148, 'onlinesamnt', 'Online Sale Amount', NULL),
(1149, 'onlineordnum', 'Online Order Number', NULL),
(1150, 'offsalamnt', 'Offline Sale Amount', NULL),
(1151, 'offlordnum', 'Offline Order Number', NULL),
(1152, 'saleamnt', 'Sale Amount', NULL),
(1153, 'ordnumb', 'Order Number', NULL),
(1154, 'store_name', 'Store Name', NULL),
(1155, 'opent', 'Available On', NULL),
(1156, 'closeTime', 'Closing Time', NULL),
(1157, 'sldistype', 'Select Discount Type', NULL),
(1158, 'distype', 'Discount Type', NULL),
(1159, 'percent', 'Percent', NULL),
(1160, 'sl_se_ch_ty', 'Select Service Charge Type', NULL),
(1161, 'vatset', 'VAT Setting(%)', NULL),
(1162, 'mindeltime', 'Min. Delivery Time', NULL),
(1163, 'dateformat', 'Date Format', NULL),
(1164, 'sedateformat', 'Seletet Date Format', NULL),
(1165, 'add_menu_item', 'Add Menu Item', NULL),
(1166, 'menu_title', 'Menu Title', NULL),
(1167, 'can_create', 'Can Create', NULL),
(1168, 'can_read', 'Can Read', NULL),
(1169, 'can_edit', 'Can Edit', NULL),
(1170, 'can_delete', 'Can Delete', NULL),
(1171, 'smsrankgateway', 'To get <b>50</b> free SMS from smsrank.com click', NULL),
(1172, 'ranktext', ' and register in registration section click Already Envato user and put your envato purchase key and product id  after registration put your username and password into the password and user name field this form.', NULL),
(1173, 'managementsection', 'This Section is Use Only for Store Management.', NULL),
(1174, 'width', 'Width', NULL),
(1175, 'protocal', 'Protocol', NULL),
(1176, 'mailpath', 'Mail Path', NULL),
(1177, 'Mail_type', 'Mail Type', NULL),
(1178, 'smtp_host', 'SMTP Host', NULL),
(1179, 'smtp_post', 'SMTP Port', NULL),
(1180, 'sender_email', 'Sender Email', NULL),
(1181, 'smtp_password', 'SMTP Password', NULL),
(1183, 'powered_by', 'Powered By Text', NULL),
(1184, 'item_information', 'Item Information', NULL),
(1185, 'size', 'Size', NULL),
(1186, 'qty', 'Quantity', NULL),
(1187, 'addons_name', 'Add-ons Name ', NULL),
(1188, 'addons_qty', 'Add-ons Qty', NULL),
(1190, 'item', 'Item', NULL),
(1191, 'unit_price', 'Unit Price', NULL),
(1192, 'total_price', 'Total Price', NULL),
(1193, 'order_status', 'Order Status', NULL),
(1194, 'served', 'Served', NULL),
(1195, 'cancel_reason', 'Cancel Reason', NULL),
(1196, 'customer_order', 'Customer Notes', NULL),
(1197, 'customerpicktime', 'Customer Pick-up Date and time', NULL),
(1199, 'service_chrg', 'Service Charge', NULL),
(1200, 'customer_paid_amount', 'Customer Paid Amount', NULL),
(1201, 'change_due', 'Change Due', NULL),
(1202, 'total_due', 'Total Due', NULL),
(1203, 'powerbybdtask', 'Powered  By: LMK-Tech, www.lamuka-tech.com', NULL),
(1204, 'recept', 'Receipt  No', NULL),
(1205, 'orderno', 'Order No.', NULL),
(1206, 'ref_page', 'Refresh Page', NULL),
(1207, 'orderid', 'Order ID', NULL),
(1208, 'all', 'All', NULL),
(1209, 'vat_tax1', 'Vat/Tax', NULL),
(1210, 'ord_uodate_success', 'Order Update Successfully!!!', NULL),
(1211, 'do_print_token', 'Do you Want to Print Token No.???', NULL),
(1212, 'req_failed', 'Request Failed, Please check your code and try again!', NULL),
(1213, 'ord_places', 'Order Placed Successfully', NULL),
(1214, 'do_print_in', 'Do you Want to Print Invoice???', NULL),
(1215, 'ord_complte', 'Order Completed', NULL),
(1216, 'ord_com_sucs', 'Order Completed Successfully', NULL),
(1217, 'token_no', 'Token NO', NULL),
(1218, 'qr-order', 'QR Order', NULL),
(1219, 'cuschange', 'Customer Change', NULL),
(1220, 'order_successfully_placed', 'Order Has Been Placed Successfully!', NULL),
(1221, 'kitchen_setting', 'kitchen Setting', NULL),
(1222, 'kitchen_name', 'Kitchen Name', NULL),
(1223, 'kitchen_user_assign', 'Assign Kitchen User', NULL),
(1224, 'kitchen_list', 'Kitchen List', NULL);
INSERT INTO `language` (`id`, `phrase`, `english`, `french`) VALUES
(1225, 'add_kitchen', 'Add Kitchen', NULL),
(1226, 'kitchen_assign', 'Kitchen Assign', NULL),
(1227, 'kitchen_edit', 'Kitchen Edit', NULL),
(1228, 'please_try_again_userassign', 'This user is already assign in this kitchen', NULL),
(1229, 'select_kitchen', 'Select Kitchen', NULL),
(1230, 'memberid', 'Member ID', NULL),
(1231, 'member_name', 'Member Name', NULL),
(1232, 'add_member', 'Add New Member', NULL),
(1233, 'update_member', 'Update Member', NULL),
(1234, 'member_list', 'Member List', NULL),
(1236, 'meminfo', 'Member Manage', NULL),
(1237, 'blocked', 'Blocked', NULL),
(1238, 'memberid_exist', 'Member ID Already Exists. Please Try Another.', NULL),
(1239, 'add_new_payment_type', 'Add New Payment Method', NULL),
(1240, 'sell_report_items', 'Items Sales Report', NULL),
(1241, 'sell_report_waiters', 'Waiters Sales Report', NULL),
(1242, 'sell_report_delvirytype', 'Delivery Type Sales Report', NULL),
(1243, 'sell_report_casher', 'Sale Report Cashier', NULL),
(1244, 'ready_all_ietm', 'All Item Ready', NULL),
(1245, 'unpaid_sell', 'Unpaid Sale', NULL),
(1246, 'kitchen_sell', 'Kitchen Sales Report', NULL),
(1247, 'order_total', 'Total Order ', NULL),
(1248, 'scharge_report', 'Service Charge Report ', NULL),
(1249, 'seo_setting', 'SEO Setting', NULL),
(1250, 'seo_title', 'Title', NULL),
(1251, 'seo_keyword', 'Keyword', NULL),
(1252, 'seo_description', 'Description', NULL),
(1257, 'buy_now', 'Buy Now', NULL),
(1264, 'purchase_key', 'Purchase Key', NULL),
(1271, 'kitchen_status', 'Kitchen Status', NULL),
(1278, 'habittrack', 'Customer Habit List', NULL),
(1279, 'review_rating', 'Review & Rating', NULL),
(1280, 'pos_setting', 'POS Setting', NULL),
(1286, 'month', 'Month', NULL),
(1287, 'sl_option', 'Select Option', NULL),
(1288, 'sl_product', 'Search Product', NULL),
(1289, 'quickorder', 'Quick Order', NULL),
(1290, 'placeorder', 'Place Order', NULL),
(1291, 'type_slorder', 'Type and Select Order', NULL),
(1292, 'mergeord', 'Merge Order', NULL),
(1293, 'Processingod', 'Processing...', NULL),
(1294, 'sLengthMenu', 'Display _MENU_ records per page', NULL),
(1295, 'sInfo', 'Showing _START_ to _END_ of _TOTAL_ entries', NULL),
(1296, 'sInfoEmpty', 'Showing 0 to 0 of 0 entries', NULL),
(1297, 'sInfoFiltered', '(Filtered from _MAX_ Total Records)', NULL),
(1298, 'sLoadingRecords', 'Loading...', NULL),
(1299, 'sZeroRecords', 'Nothing found - sorry', NULL),
(1300, 'sEmptyTable', 'No Data Available in Table', NULL),
(1301, 'sFirst', 'First', NULL),
(1302, 'sLast', 'Last', NULL),
(1303, 'sPrevious', 'Previous', NULL),
(1304, 'sNext', 'Next', NULL),
(1305, 'sSortAscending', 'Activate to sort column ascending', NULL),
(1306, 'sSortDescending', 'Activate to Sort Column Descending', NULL),
(1307, '_sign', 'Show %d Rows', NULL),
(1308, '_0sign', 'No Row Selected', NULL),
(1309, '_1sign', '1 Line Selected', NULL),
(1310, 'copy', 'Copy', NULL),
(1312, 'excel', 'Excel', NULL),
(1313, 'pdf', 'Pdf', NULL),
(1314, 'colvis', 'Column Visibility', NULL),
(1316, 'no_orderfound', 'No Order Found!!!', NULL),
(1317, 'prepared', 'Prepared', NULL),
(1318, 'accept', 'Accept', NULL),
(1319, 'reject', 'Reject', NULL),
(1320, 'ready', 'Ready', NULL),
(1321, 'processing', 'Processing', NULL),
(1322, 'kitnotacpt', 'Kitchen Not Accept', NULL),
(1425, 'person', 'Person', NULL),
(1426, 'before_time', 'Running Time', NULL),
(1427, 'select_this_table', 'Select This Table', NULL),
(1428, 'seat', 'Seat', NULL),
(1429, 'seat_time', 'Time', NULL),
(1430, '+', 'Add', NULL),
(1431, 'clear', 'Clear', NULL),
(1432, 'no_customer', 'No Customer', NULL),
(1433, 'table_map', 'Table Map', NULL),
(1434, 'add', 'Add', NULL),
(1435, 'itemsincart', 'Item(s) in Cart', NULL),
(1436, 'view_cart', 'View Cart', NULL),
(1437, 'morderlist', 'My Order List', NULL),
(1438, 'edit', 'Edit', NULL),
(1439, 'foodde', 'Food Details', NULL),
(1440, 'cartlist', 'Cart List', NULL),
(1441, 'subtotal', 'Subtotal', NULL),
(1442, 'ordnote', 'Order Notes', NULL),
(1443, 'upsummery', 'Update Summery', NULL),
(1444, 'upsumlist', 'Update Summery List', NULL),
(1445, 'mkpayment', 'Make Payment', NULL),
(1446, 'foodnote', 'Food Note', NULL),
(1447, 'addnotesi', 'Add Note', NULL),
(1448, 'thirdparty_orderid', 'Third-party Order ID', NULL),
(1456, 'themes', 'Themes', NULL),
(1457, 'menu_type', 'Menu Type', NULL),
(1458, 'add_menu_type', 'Add Menu Type', NULL),
(1459, 'menutype_edit', 'Menu Type Edit', NULL),
(1460, 'menu_type_name', 'Menu Type', NULL),
(1461, 'storetime', 'Manage Store Time', NULL),
(1462, 'day_name', 'Day', NULL),
(1463, 'saturday', 'Saturday', NULL),
(1464, 'sunday', 'Sunday', NULL),
(1465, 'monday', 'Monday', NULL),
(1466, 'tuesday', 'Tuesday', NULL),
(1467, 'wednesday', 'Wednesday', NULL),
(1468, 'thursday', 'Thursday', NULL),
(1469, 'friday', 'Friday', NULL),
(1470, 'footer_logo', 'Footer Logo', NULL),
(1471, 'contact_us', 'Contact Us', NULL),
(1472, 'opening_time', 'Available On', NULL),
(1473, 'ourstore', 'Our Store', NULL),
(1474, 'call_reservation', 'Call for Reservations', NULL),
(1475, 'item_available', 'Items Available', NULL),
(1479, 'membership_card', 'Bar Code', NULL),
(1480, 'barcode_start', 'From Barcode', NULL),
(1481, 'barcode_end', 'To Barcode', NULL),
(1494, 'commission', 'Commission', NULL),
(1495, 'sale_by_table', 'Sale By Table', NULL),
(1496, 'stock_limit', 'Re-Stock Level', NULL),
(1497, 'ingredients', 'Ingredients', NULL),
(1498, 'stock_out_ingredients', 'Stock Out Ingredients', NULL),
(1499, 'office_addres1', 'Office Address', NULL),
(1500, 'call_us', 'Call Us', NULL),
(1501, 'email_us', 'Email Us', NULL),
(1502, 'upload_theme', 'Upload Theme', NULL),
(1503, 'discount_type', 'Discount Type', NULL),
(1504, 'confirm_password', 'Confirm Password', NULL),
(1559, 'wastemangment', 'Waste Management', NULL),
(1590, 'add_group_item', 'Add Group Item', NULL),
(1591, 'update_group_item', 'Update Group Item', NULL),
(1592, 'production_setting', 'Production Setting', NULL),
(1593, 'select_auto', 'Select auto Production', NULL),
(1594, 'split', 'Split', NULL),
(1595, 'tinvat', 'TIN OR VAT NUM.', NULL),
(1596, 'bill', 'Bill', NULL),
(1597, 'checkin', 'Check In', NULL),
(1598, 'checkout', 'Check Out', NULL),
(1599, 'totalpayment', 'Total payment', NULL),
(1600, 'thanssuport', 'Thank You for Your Support', NULL),
(1601, 'thanks_you', 'Thank you very much', NULL),
(1602, 'opening_balance', 'Opening Balance', NULL),
(1603, 'transaction_date', 'Date', NULL),
(1604, 'voucher_type', 'Voucher Type', NULL),
(1605, 'particulars', 'Head Name', NULL),
(1606, 'total_empolyee', 'Total Employee', NULL),
(1607, 'apply_day', 'Days', NULL),
(1608, 'loan_no', 'Loan No.', NULL),
(1609, 'add_floor', 'Add Floor', NULL),
(1610, 'floor_name', 'Floor Name', NULL),
(1611, 'edit_floor', 'Edit Floor', NULL),
(1612, 'floor_list', 'Floor List', NULL),
(1613, 'floor_select', 'Floor Select', NULL),
(1614, 'add_to_cart_more', 'Add Cart & More', NULL),
(1615, 'kitchen_printers', 'Kitchen printer Setting', NULL),
(1616, 'printer_list', 'Printer List', NULL),
(1617, 'add_printer', 'Add Printer', NULL),
(1618, 'ip_port', 'Your Online URL', NULL),
(1625, 'counter_list', 'Counter List', NULL),
(1626, 'add_counter', 'Add Counter', NULL),
(1627, 'edit_counter', 'Edit Counter', NULL),
(1628, 'counter_no', 'Counter Number', NULL),
(1629, 'add_opening_balance', 'Add Opening Balance', NULL),
(1630, 'add_closing_balance', 'Add Closing Balance', NULL),
(1632, 'sell_report_cashregister', 'Cash Register Report', NULL),
(1633, 'closing_balance', 'Closing Balance', NULL),
(1634, 'factory_reset', 'Factory Reset', NULL),
(1635, 'fresettext', 'Note: Strongly recommended to backup your SOURCE file and DATABASE before resetting because all transactional data will be cleared after running the factory reset.', NULL),
(1636, 'bill_by', 'Bill By', NULL),
(1640, 'type_table', 'Type and Select Table', NULL),
(1648, 'sound_setting', 'Sound Setting', NULL),
(1649, 'is_sound', 'Is Sound Enable', NULL),
(1650, 'upload_notify', 'Upload Notification Sound', NULL),
(1651, 'upload_order', 'Upload order Add Sound', NULL),
(1655, 'room_list', 'Room List', NULL),
(1656, 'add_room', 'Add Room', NULL),
(1657, 'room_no', 'Room No', NULL),
(1658, 'room_qr', 'All Room QR', NULL),
(1659, 'restaurant_closed', 'Restaurant is Closed!!', NULL),
(1660, 'closed_msg', 'You order Only when restaurant is open. Our opening and closing Time is:', NULL),
(1661, 'privactp', 'Privacy Policy', NULL),
(1662, 'terms_condition', 'Terms & conditions', NULL),
(1663, 'refundp', 'Refund Policies', NULL),
(1664, 'reservation_on_off', 'Reservation On Off', NULL),
(1665, 'unavailable_day', 'Unavailable Day', NULL),
(1666, 'unavaildate', 'Unavailable Date', NULL),
(1667, 'add_unavailablity', 'Add Unavailability', NULL),
(1668, 'edit_unavailablity', 'Edit Unavailability', NULL),
(1669, 'unavailable_time', 'Unavailable Time', NULL),
(1670, 'max_reserveperson', 'Max Reserve Person', NULL),
(1671, 'reservasetting', 'Reservation Setting', NULL),
(1672, 'webon', 'Website ON', NULL),
(1673, 'weboff', 'Website Off', NULL),
(1674, 'webdisable', 'Web site ON/Off', NULL),
(1675, 'placr_setting', 'Place order Setting', NULL),
(1676, 'quick_ord', 'Quick Order Setting', NULL),
(1677, 'shippingtime', 'Shipping Date & Time', NULL),
(1678, 'search_food_item', 'Search Food Item', NULL),
(1679, 'search_category', 'Search Category', NULL),
(1680, 'check_availablity', 'Check Availability', NULL),
(1681, 'subscribe_paragraph', 'Subscribe to Receive Our Weekly Promotion', NULL),
(1682, 'shipping_method', 'Shipping Method', NULL),
(1683, 'please_select_shipping_method', 'Please Select Shipping Method', NULL),
(1684, 'autoupdate', 'Auto Update', NULL),
(1685, 'coa_head', 'COA Head', NULL),
(1686, 'apps_addons', 'Apps Add-ons', NULL),
(1687, 'download_apps_playstore', 'Please Download Apps on Playstore', NULL),
(1688, 'kitchen_app', 'Kitchen App', NULL),
(1689, 'waiter_app', 'Waiter App', NULL),
(1690, 'customer_app', 'Customer App', NULL),
(1691, 'if_you_need_the_above_all_apps', 'If you need the above all apps, please feel free to contact us.', NULL),
(1692, 'do_you_want_proceed', 'Do You Want to Proceed?', NULL),
(1693, 'is_offer', 'Offer', NULL),
(1694, 'is_special', 'Special', NULL),
(1695, 'is_custome_quantity', 'Custom Quantity', NULL),
(1696, 'kitchenitemsell', 'Kitchen Sell', NULL),
(1697, 'due_marge', 'Due Merge', NULL),
(1698, 'book_table', 'Book Table', NULL),
(1699, 'reserve_table', 'Reserve Table', NULL),
(1700, 'see_more', 'See More', NULL),
(1701, 'food_name', 'Food Name', NULL),
(1702, 'category', 'Category', NULL),
(1703, 'search', 'Search', NULL),
(1704, 'read_more', 'Read more', NULL),
(1705, 'item_has_been_successfully_added', 'Item has been successfully added', NULL),
(1706, 'add_to_cart', 'Add Cart', NULL),
(1707, 'view_full_menu', 'View Full Menu', NULL),
(1709, 'subscribe_to_newsletter', 'Subscribe to Newsletter', NULL),
(1710, 'subscribe', 'subscribe', NULL),
(1711, 'get_directions', 'Get Directions', NULL),
(1712, 'teams_of_use', 'Teams of use', NULL),
(1713, 'privacy_policy', 'Privacy Policy', NULL),
(1714, 'contact', 'Contact', NULL),
(1715, 'please_enter_your_email', 'Please Enter Your email !!', NULL),
(1716, 'please_enter_valid_email', 'Please enter a valid Email', NULL),
(1717, 'thanks_for_subscription', 'Thanks for Subscription', NULL),
(1718, 'note_added', 'Note Added', NULL),
(1719, 'posting_failed', 'Posting failed', NULL),
(1720, 'our_service_is_closed_on_this_date_and_time', 'Our service is Closed on this date and time !!!', NULL),
(1721, 'reservation_time_closed_try_later', 'Reservation Time is closed!! Please try later.', NULL),
(1722, 'select_date', 'Please select date', NULL),
(1723, 'select_time', 'Please select Time', NULL),
(1724, 'enter_number_of_people', 'Please enter the number of people', NULL),
(1725, 'select_after_hour_current_time', 'Please select after 1 hour to Current time', NULL),
(1726, 'no_free_seat_to_the_reservation', 'Currently, there is no free seat to the reservation', NULL),
(1727, 'search_topics_or_keywords', 'Search topics or keywords', NULL),
(1728, 'no_data_found', 'No Data Found', NULL),
(1729, 'please_wait', 'Please Wait', NULL),
(1730, 'reservation_contact', 'Contact No.', NULL),
(1731, 'reservation_time', 'Expected Time', NULL),
(1732, 'reservation_date', 'Expected Date', NULL),
(1733, 'reservation_person', 'Total Person', NULL),
(1734, 'deal_of_the_day', 'Deal of the day', NULL),
(1735, 'cart', 'Cart', NULL),
(1736, 'unavailable', 'Unavailable', NULL),
(1737, 'write_comments', 'Write Your Comments', NULL),
(1738, 'get_in_touch', 'Get In Touch', NULL),
(1739, 'forgot_password', 'Forgot Password', NULL),
(1740, 'shopping_details_information_msg', 'If you have shopped with us before, please enter your details in the boxes below.', NULL),
(1741, 'remember_me', 'Remember Me', NULL),
(1742, 'or', 'OR', NULL),
(1743, 'register', 'Register', NULL),
(1744, 'enter_your_phone_or_email', 'Please enter your Phone or Email.', NULL),
(1745, 'password_not_empty', 'Password Not Empty.', NULL),
(1746, 'failed_login_msg', 'Failed Login: Check your Email and password!', NULL),
(1747, 'email_not_registered_msg', 'Failed: Email has not been registered yet.!!!', NULL),
(1748, 'have_been_sent_email', 'Success: We have been sent an email to this', NULL),
(1749, 'check_your_new_password', 'Email Address. Please check your New Password..!!!', NULL),
(1750, 'profile_picture', 'Profile Picture', NULL),
(1751, 'my_profile', 'My Profile', NULL),
(1752, 'my_reservation', 'My Reservation', NULL),
(1753, 'profile_update', 'Profile Update', NULL),
(1754, 'name', 'Name', NULL),
(1755, 'returning_customer', 'Returning customer?', NULL),
(1756, 'click_login', 'Click here to login', NULL),
(1757, 'checkout_msg', 'If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing & Shipping section.', NULL),
(1758, 'username_or_email', 'Username or Email', NULL),
(1759, 'billing_address', 'Billing Address', NULL),
(1760, 'select_country', 'Select Country', NULL),
(1761, 'select_state', 'Select State', NULL),
(1762, 'town_city', 'Town / City', NULL),
(1763, 'select_city', 'Select City', NULL),
(1764, 'street_address', 'Street Address', NULL),
(1765, 'postcode_zip', 'Postcode / ZIP', NULL),
(1766, 'create_account', 'Create an Account?', NULL),
(1767, 'create_account_password', 'Create account password', NULL),
(1768, 'shipping_different_address', 'Ship to a Different Address?', NULL),
(1769, 'your_order', 'Your Order', NULL),
(1770, 'product', 'Product', NULL),
(1771, 'total_vat', 'Total VAT', NULL),
(1772, 'coupon_discount', 'Coupon Discount', NULL),
(1773, 'service', 'Service', NULL),
(1774, 'tag', 'Tag', NULL),
(1775, 'review', 'Review', NULL),
(1776, 'average_user_rating', 'Average User Rating', NULL),
(1777, 'rating_breakdown', 'Rating Breakdown', NULL),
(1778, 'complete_success', '100% Complete (success)', NULL),
(1779, '80_complete_primary', '80% Complete (primary)', NULL),
(1780, '60_complete_info', '60% Complete (info)', NULL),
(1781, '40_complete_warning', '40% Complete (warning)', NULL),
(1782, '20_complete_danger', '20% Complete (danger)', NULL),
(1783, 'rate_it', 'Rate It', NULL),
(1784, 'french_chicken_burger_tomato_sauce', 'French Chicken Burger With Hot tomato Sauce', NULL),
(1785, 'review_submit', 'Review Submit', NULL),
(1786, 'related_items', 'Related Items', NULL),
(1787, 'pickup', 'Pickup', NULL),
(1788, 'dine_in', 'Dine-in', NULL),
(1789, 'enter_coupon_code', 'Enter coupon code', NULL),
(1790, '00_15_min', '00:15 MIN', NULL),
(1791, 'go_to_checkout', 'Go to Checkout', NULL),
(1798, 'timezone', 'Time Zome', NULL),
(1799, 'discountrate', 'Discount Rate', NULL),
(1800, 'vat', 'Vat', NULL),
(1801, 'loan_issue_id', 'Loan Issue ID', NULL),
(1802, 'repayment', 'Re-payment', NULL),
(1803, 'loan_report_details', 'Loan Details', NULL),
(1804, 'balance_sheet', 'Balance Sheet', NULL),
(1813, 'purdate', 'Purchase Date', NULL),
(1814, 'expdate', 'Expiry Date', NULL),
(1815, 'parent_cat', 'Parent Category', NULL),
(1816, 'set_productioncost', 'Set Production Cost Per Unit', NULL),
(1817, 'set_productionunit', 'Set Production Unit', NULL),
(1818, 'production_set', 'Production Set', NULL),
(1819, 'production_set_for', 'Production Set For', NULL),
(1820, 'serving_unit', 'Serving Unit', NULL),
(1821, 'kit_dashoard_setting', 'Kitchen Dashboard Setting', NULL),
(1822, 'kot_reftime', 'Kitchen Refresh time In Second', NULL),
(1823, 'bulk_upload', 'Bulk Upload', NULL),
(1824, 'upload_food_csv', 'Upload Food Item csv', NULL),
(2202, 'appcartempty', 'Your Cart is empty!!!.Please add some food.', NULL),
(2203, 'apporderempty', 'You Order List is empty!!! Please Place A Order First!!!', NULL),
(2244, 'topselleingitem', 'Top selling Item', NULL),
(2252, 'logininfo', 'Login Info', NULL),
(2253, 'newuser', 'New User', NULL),
(2254, 'orloginwith', 'or login with', NULL),
(2255, 'registerinfo', 'Registration Info', NULL),
(2256, 'register_txt', 'If you have shopped with us before, please enter your details in the boxes below.', NULL),
(2257, 'customerinfo', 'Customer Info', NULL),
(2258, 'delvtype', 'Delivery Type', NULL),
(2259, 'delv_date', 'Delivery Date', NULL),
(2260, 'delvtime', 'Delivery Time', NULL),
(2261, 'yourcart', 'Your Cart', NULL),
(2262, 'items', 'items', NULL),
(2263, 'delivarycrg', 'Delivery charge', NULL),
(2264, 'offercodegift', 'Offer code / gift card code', NULL),
(2265, 'apply', 'Apply', NULL),
(2266, 'proceedtocart', 'Proceed to Checkout', NULL),
(2267, 'delv_address', 'Delivary address List', NULL),
(2268, 'create_address', 'Create Address', NULL),
(2269, 'seeallmenu', 'See all menu', NULL),
(2270, 'sendymsg', 'Send Your Message', NULL),
(2271, 'send_us', 'Send Us Message', NULL),
(2302, 'closing_note', 'Closing Note', NULL),
(2304, 'close_resister_and_print_summery', 'Close Resister and print Summery', NULL),
(2305, 'previous', 'Previous', NULL),
(2306, 'unpaid', 'Unpaid', NULL),
(2307, 'check_item', 'Check Item', NULL),
(2308, 'check_item_message', 'Please check at least one item!!', NULL),
(2309, 'yes', 'Yes', NULL),
(2311, 'time_over', 'Time Over', NULL),
(2312, 'add_phrase', 'Add Phrase', NULL),
(2313, 'crd_terminal_message', 'Please Select Card Terminal!!!', NULL),
(2314, 'language_list', 'Language List', NULL),
(2315, 'commission_setting', 'Commission Setting', NULL),
(2316, 'pending', 'Pending', NULL),
(2317, 'current_register', 'Current Register', NULL),
(2318, 'due', 'Due', NULL),
(2319, 'due_invoice', 'Due Invoice', NULL),
(2320, 'payable_amount', 'Payable Amount', NULL),
(2321, 'isinclusivetax', 'Is Tax Inclusive?', NULL),
(2322, 'showhidevattin', 'Show/Hide(VAT/TIN)', NULL),
(2323, 'custfldname', 'Custom Field Name', NULL),
(2324, 'custfldtype', 'Custom Field Type', NULL),
(2325, 'customvalue', 'Custom Value', NULL),
(2326, 'cash_in_hand', 'Cash In Hand', NULL),
(2327, 'booked', 'Booked', NULL),
(2328, 'realease', 'Release\r\n', NULL),
(2329, 'liveortest', 'Live Or Test', NULL),
(2330, 'live', 'Live Mode', NULL),
(2331, 'test_mode', 'Test Mode', NULL),
(2332, 'manage_position', 'Manage Position', NULL),
(2333, 'circularprocess_list', 'Circularprocess List', NULL),
(2334, 'remarks', 'Remarks', NULL),
(2335, 'general_ledger_report', 'General Ledger Report', NULL),
(2336, 'general_ledger_of', 'General ledger of', NULL),
(2337, 'paid_amnt', 'Paid Amount', NULL),
(2338, 'tablenotfound', 'Table Not Found', NULL),
(2339, 'day_close_report', 'Day Closeing Report', NULL),
(2378, 'open_date', 'Open Date', NULL),
(2379, 'Sale_date', 'Sale Date', NULL),
(2380, 'sales_type', 'Sales Type', NULL),
(2381, 'total_discount', 'Total Discount', NULL),
(2382, 'thirdpartycommission', 'Third Party Commission', NULL),
(2383, 'close_date', 'Close Date', NULL),
(2384, 'sales_summary', 'Sales Summary', NULL),
(2385, 'total_net_sales', 'Total Net Sales', NULL),
(2386, 'total_tax', 'Total Tax', NULL),
(2387, 'total_sd', 'Total SD', NULL),
(2388, 'payment_details', 'Payment Details', NULL),
(2389, 'cashdrawer', 'Cash Drawer', NULL),
(2390, 'day_opening', 'Day Opening', NULL),
(2391, 'dayclosing', 'Day Closing', NULL),
(2392, 'counterusersignature', 'Counter user signature', NULL),
(2393, 'authorize_signature', 'Authorize signature', NULL),
(2394, 'production_note4', 'A restaurant should have a fixed recipe for a particular food For making your work easy. This application has an auto production system which describes like this', NULL),
(2395, 'production_note3', 'If you have a sufficient amount of ingredients in your restaurant stock then it will automatically upgrade the amount of production for every sale. Let me explain to you how: Suppose, set a recipe for fried rice and a bbq chicken in your system', NULL),
(2396, 'production_note5', 'once in the module Recipe Management>Add production with the ingredients, serving unit, variant, and price. Now you have got an order of 3 fried rice and 2 bbq chicken. You do not need to make this production again and again. Just select the food', NULL),
(2397, 'production_note6', 'and make the order done from POS. The system will make the dish ready and it will automatically update the in-stock and out-stock quantity in the REPORT (Production-wise) and the ingredients will be reduced from the REPORT (Kitchen-wise).', NULL),
(2398, 'applicationId', 'Application Id', NULL),
(2399, 'api_key', 'Api Key', NULL),
(2400, 'access_token', 'Access Token', NULL),
(2401, 'security_key', 'Security Key', NULL),
(2402, 'location_id', 'Location Id', NULL),
(2403, 'shipping_type', 'Shipping Type', NULL),
(2404, 'no_of_people', 'Number Of People', NULL),
(2405, 'get_in_tuch', 'Get In Tuch', NULL),
(2406, 'book_a_table', 'Book A Table', NULL),
(2407, 'pages', 'Pages', NULL),
(2408, 'open_menu', 'Open Menu', NULL),
(2409, 'gallery', 'Gallery', NULL),
(2410, 'team', 'Team', NULL),
(2411, 'hotsale', 'HOTSALE', NULL),
(2412, 'write_a_review', 'Write a Review', NULL),
(2413, 'cart_page', 'Cart Page', NULL),
(2414, 'receive_time', 'Receive Time', NULL),
(2415, 'enter_your_coupon_code_if_you_have_one', 'Enter Your Coupon Code If You Have One.', NULL),
(2416, 'apply_coupon', 'Apply Coupon', NULL),
(2417, 'cart_total', 'Cart Total', NULL),
(2418, 'this_coupon_is_expired', 'This coupon is expired!', NULL),
(2419, 'invalid_coupon', 'Invalid Coupon', NULL),
(2420, 'online_order', 'Online Order', NULL),
(2421, 'all_items', 'All Items', NULL),
(2422, 'category_food', 'Category Food', NULL),
(2423, 'header_menu', 'Header Menu', NULL),
(2424, 'footer_menu', 'Footer Menu', NULL),
(2425, 'manage_themes', 'Manage Themes', NULL),
(2426, 'show_theme', 'Show Theme', NULL),
(2427, 'activated', 'Activated', NULL),
(2428, 'no_theme_available', 'No Theme Available', NULL),
(2429, 'manage_color', 'Manage Color', NULL),
(2430, 'primary_color', 'Primary Color', NULL),
(2431, 'top_header_bg', 'Top Header Background', NULL),
(2432, 'header_bg', 'Header Background', NULL),
(2433, 'header_text_color', 'Header Text Color', NULL),
(2434, 'footer_bg', 'Footer Background', NULL),
(2435, 'footer_text_color', 'Footer Text Color', NULL),
(2436, 'reset_default', 'Reset Default', NULL),
(2437, 'theme_colors_updated_successfully', 'Theme colors updated successfully.', NULL),
(2438, 'menu', 'Menu', NULL),
(2439, 'reservation_successfull', 'Reservation Successfull', NULL),
(2440, 'offer_rate', 'Offer Rate', NULL),
(2441, 'whatsapp', 'Whatsapp', NULL),
(2442, 'whatsapp_chat', 'Whatsapp Chat', NULL),
(2443, 'whatsapp_phone_numer_internation_standard', 'Whatsapp phone Numer Internation Standard', NULL),
(2444, 'whatsapp_phone_numer', 'Whatsapp Phone Numer', NULL),
(2445, 'whatsapp_setting', 'Whatsapp Setting', NULL),
(2446, 'hello,_how_can_we_help_you?', 'Hello, How can we help you?', NULL),
(2447, 'ischatenable', 'Chat Enable', NULL),
(2448, 'wporder_enable', 'WhatsApp Order Enable', NULL),
(2449, 'whatsorderplace', 'Do you want to Chat on WhatsApp??', NULL),
(2474, 'facebooklogin', 'Facebook Login', NULL),
(2475, 'add_facebook_app', 'Facebook Setting', NULL),
(2476, 'secret_key', 'Secret Key', NULL),
(2477, 'facebook_api', 'Facebook Api', NULL),
(2478, 'facebook_login', 'Facebook Login', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_apply`
--

CREATE TABLE `leave_apply` (
  `leave_appl_id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `apply_strt_date` varchar(20) NOT NULL,
  `apply_end_date` varchar(20) NOT NULL,
  `apply_day` int(11) NOT NULL,
  `leave_aprv_strt_date` varchar(20) NOT NULL,
  `leave_aprv_end_date` varchar(20) NOT NULL,
  `num_aprv_day` varchar(15) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `apply_hard_copy` text DEFAULT NULL,
  `apply_date` varchar(20) NOT NULL,
  `approve_date` varchar(20) NOT NULL,
  `approved_by` varchar(30) NOT NULL,
  `leave_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `leave_type_id` int(11) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `leave_days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `id` int(11) NOT NULL,
  `expire_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `license_logs`
--

CREATE TABLE `license_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `old_expire_date` date NOT NULL,
  `new_expire_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_installment`
--

CREATE TABLE `loan_installment` (
  `loan_inst_id` int(11) NOT NULL,
  `employee_id` varchar(21) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `loan_id` varchar(21) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `installment_amount` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `payment` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `received_by` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `installment_no` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '1',
  `notes` varchar(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marital_info`
--

CREATE TABLE `marital_info` (
  `id` int(11) NOT NULL,
  `marital_sta` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `marital_info`
--

INSERT INTO `marital_info` (`id`, `marital_sta`) VALUES
(1, 'Single'),
(2, 'Married'),
(3, 'Divorced'),
(4, 'Widowed'),
(5, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `id` int(11) NOT NULL,
  `membership_name` varchar(250) NOT NULL,
  `discount` float NOT NULL,
  `other_facilities` varchar(255) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_date` date NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_date` date NOT NULL,
  `startpoint` int(11) NOT NULL,
  `endpoint` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `membership_name`, `discount`, `other_facilities`, `create_by`, `create_date`, `update_by`, `update_date`, `startpoint`, `endpoint`) VALUES
(1, 'Normal User', 0, '', 2, '2018-11-07', 2, '2018-11-07', 0, 0),
(2, 'Premium Member', 0, '', 1, '2020-11-04', 0, '0000-00-00', 250, 999),
(3, 'VIP', 0, '', 1, '2020-11-04', 0, '0000-00-00', 1001, 5000000);

-- --------------------------------------------------------

--
-- Table structure for table `menu_add_on`
--

CREATE TABLE `menu_add_on` (
  `row_id` bigint(20) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `add_on_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu_add_on`
--

INSERT INTO `menu_add_on` (`row_id`, `menu_id`, `add_on_id`, `is_active`) VALUES
(1, 11, 1, 1),
(2, 2, 6, 1),
(3, 3, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `datetime` datetime NOT NULL,
  `sender_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=unseen, 1=seen, 2=delete',
  `receiver_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=unseen, 1=seen, 2=delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `sender_id`, `receiver_id`, `subject`, `message`, `datetime`, `sender_status`, `receiver_status`) VALUES
(1, 2, 166, 'test', '<p>test</p>', '2025-11-01 03:11:32', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `directory` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name`, `description`, `image`, `directory`, `status`) VALUES
(1, 'WhatsApp Chat & Ordering', 'WhatsApp Chat & Ordering', 'application/modules/whatsapp/assets/images/thumbnail.jpg', 'whatsapp', 1),
(2, 'Facebook login customer', 'Facebook login customer', 'application/modules/facebooklogin/assets/images/thumbnail.jpg', 'facebooklogin', 1),
(3, 'qrapp', 'QR Application management', 'assets/img/qr.png', 'qrapp', 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_permission`
--

CREATE TABLE `module_permission` (
  `id` int(11) NOT NULL,
  `fk_module_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `create` tinyint(1) DEFAULT NULL,
  `read` tinyint(1) DEFAULT NULL,
  `update` tinyint(1) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `module_permission`
--

INSERT INTO `module_permission` (`id`, `fk_module_id`, `fk_user_id`, `create`, `read`, `update`, `delete`) VALUES
(1, 3, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_purchase_key`
--

CREATE TABLE `module_purchase_key` (
  `id` int(11) NOT NULL,
  `identity` varchar(250) DEFAULT NULL,
  `purchase_key` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `multipay_bill`
--

CREATE TABLE `multipay_bill` (
  `multipay_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `multipayid` varchar(30) DEFAULT NULL,
  `payment_type_id` int(11) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `multipay_bill`
--

INSERT INTO `multipay_bill` (`multipay_id`, `order_id`, `multipayid`, `payment_type_id`, `amount`) VALUES
(1, 1, NULL, 4, 0),
(2, 1, NULL, 4, 0),
(3, 5, NULL, 4, 91.2),
(4, 4, NULL, 4, 95),
(5, 3, NULL, 4, 104.5),
(6, 3, NULL, 4, 104.5),
(7, 2, NULL, 4, 24.225),
(8, 6, NULL, 4, 76),
(9, 7, NULL, 4, 38),
(10, 10, NULL, 4, 2525.1),
(11, 9, NULL, 4, 5415),
(12, 8, NULL, 4, 339.15),
(13, 12, NULL, 4, 182.4),
(14, 12, NULL, 4, 182.4),
(15, 11, NULL, 4, 114),
(16, 11, NULL, 4, 114),
(17, 15, NULL, 4, 456),
(18, 14, NULL, 4, 228),
(19, 13, NULL, 4, 256.5),
(20, 22, NULL, 4, 171),
(21, 21, NULL, 4, 45.6),
(22, 32, NULL, 4, 801.8),
(23, 32, NULL, 4, 801.8),
(24, 30, NULL, 4, 148.2),
(25, 29, NULL, 4, 497.04),
(26, 29, NULL, 4, 497.04),
(27, 33, NULL, 4, 307.8),
(28, 25, NULL, 4, 102.6),
(29, 20, NULL, 4, 28.5),
(30, 34, NULL, 4, 22.8),
(31, 36, NULL, 4, 123.5),
(32, 35, NULL, 4, 19),
(33, 35, NULL, 4, 19),
(34, 40, NULL, 4, 171),
(35, 39, NULL, 4, 228),
(36, 38, NULL, 4, 22.8),
(37, 37, NULL, 4, 148.2),
(38, 42, NULL, 4, 615.6),
(39, 41, NULL, 4, 359.1),
(40, 43, NULL, 4, 307.8),
(41, 45, NULL, 4, 22.8),
(42, 46, NULL, 4, 313.5),
(43, 47, NULL, 4, 798),
(44, 47, NULL, 4, 798),
(45, 48, NULL, 4, 22.8),
(46, 48, NULL, 4, 22.8),
(47, 48, NULL, 4, 125.4),
(48, 48, NULL, 4, 125.4),
(49, 49, NULL, 4, 22.8),
(50, 50, NULL, 4, 22.8),
(51, 64, NULL, 4, 125.4),
(52, 60, NULL, 4, 588.24),
(53, 58, NULL, 4, 205.2),
(54, 57, NULL, 4, 125.4),
(55, 56, NULL, 4, 1043.1),
(56, 67, NULL, 4, 441.75),
(57, 66, NULL, 4, 403.75),
(58, 59, NULL, 4, 57),
(59, 52, NULL, 4, 365.75),
(60, 68, NULL, 4, 307.8),
(61, 63, NULL, 4, 461.7),
(62, 62, NULL, 4, 22.8),
(63, 61, NULL, 4, 125.4),
(64, 61, NULL, 4, 125.4),
(65, 55, NULL, 4, 1596),
(66, 54, NULL, 4, 250.8),
(67, 53, NULL, 4, 524.4),
(68, 51, NULL, 4, 216.6);

-- --------------------------------------------------------

--
-- Table structure for table `order_menu`
--

CREATE TABLE `order_menu` (
  `row_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `price` decimal(19,3) DEFAULT 0.000,
  `groupmid` int(11) DEFAULT 0,
  `notes` varchar(255) DEFAULT NULL,
  `menuqty` float NOT NULL,
  `add_on_id` varchar(100) NOT NULL,
  `addonsqty` varchar(100) NOT NULL,
  `varientid` int(11) NOT NULL,
  `groupvarient` int(11) DEFAULT NULL,
  `addonsuid` int(11) DEFAULT NULL,
  `qroupqty` int(11) DEFAULT NULL,
  `isgroup` int(11) DEFAULT 0,
  `food_status` int(11) DEFAULT 0,
  `allfoodready` int(11) DEFAULT NULL,
  `isupdate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_menu`
--

INSERT INTO `order_menu` (`row_id`, `order_id`, `menu_id`, `price`, `groupmid`, `notes`, `menuqty`, `add_on_id`, `addonsqty`, `varientid`, `groupvarient`, `addonsuid`, `qroupqty`, `isgroup`, `food_status`, `allfoodready`, `isupdate`) VALUES
(1, 1, 1, 0.000, 0, '', 1, '', '', 0, NULL, 1, NULL, 0, 1, 1, NULL),
(2, 2, 1, 0.000, 0, '', 1, '', '', 0, NULL, 1, NULL, 0, 1, 1, NULL),
(3, 2, 10, 0.000, 0, '', 1, '', '', 0, NULL, 10, NULL, 0, 1, 1, NULL),
(4, 2, 1, 0.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(5, 3, 2, 0.000, 0, '', 1, '', '', 3, NULL, 23, NULL, 0, 1, 1, NULL),
(6, 4, 1, 0.000, 0, '', 2, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(7, 5, 1, 20.000, 0, '', 2, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(8, 5, 3, 20.000, 0, '', 1, '6', '1', 4, NULL, 364, NULL, 0, 1, 1, NULL),
(9, 6, 1, 0.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(10, 7, 3, 0.000, 0, '', 2, '', '', 4, NULL, 34, NULL, 0, 1, 1, NULL),
(11, 8, 1, 0.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(12, 8, 2, 0.000, 0, '', 1, '', '', 3, NULL, 23, NULL, 0, 1, 1, NULL),
(13, 8, 70, 0.000, 0, NULL, 1, '', '', 72, NULL, 7072, NULL, 0, 1, 1, NULL),
(14, 9, 80, 0.000, 0, '', 2, '', '', 62, NULL, 8062, NULL, 0, 1, 1, NULL),
(15, 9, 78, 0.000, 0, '', 2, '', '', 64, NULL, 7864, NULL, 0, 1, 1, NULL),
(16, 9, 75, 0.000, 0, '', 3, '', '', 67, NULL, 7567, NULL, 0, 1, 1, NULL),
(17, 9, 67, 0.000, 0, '', 6, '', '', 75, NULL, 6775, NULL, 0, 1, 1, NULL),
(18, 9, 66, 0.000, 0, '', 4, '', '', 76, NULL, 6676, NULL, 0, 1, 1, NULL),
(19, 9, 63, 0.000, 0, '', 3, '', '', 79, NULL, 6379, NULL, 0, 1, 1, NULL),
(20, 10, 64, 0.000, 0, '', 1, '', '', 78, NULL, 6478, NULL, 0, 1, 1, NULL),
(21, 10, 63, 0.000, 0, '', 1, '', '', 79, NULL, 6379, NULL, 0, 1, 1, NULL),
(22, 10, 63, 0.000, 0, '', 1, '', '', 80, NULL, 6380, NULL, 0, 1, 1, NULL),
(23, 10, 62, 0.000, 0, '', 1, '', '', 81, NULL, 6281, NULL, 0, 1, 1, NULL),
(24, 11, 1, 20.000, 0, '', 2, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(25, 11, 3, 20.000, 0, '', 2, '', '', 4, NULL, 34, NULL, 0, 1, 1, NULL),
(26, 11, 6, 20.000, 0, '', 1, '', '', 55, NULL, 655, NULL, 0, 1, 1, NULL),
(27, 12, 2, 110.000, 0, '', 1, '', '', 3, NULL, 23, NULL, 0, 1, 1, NULL),
(28, 12, 53, 50.000, 0, '', 1, '', '', 89, NULL, 5389, NULL, 0, 1, 1, NULL),
(29, 13, 12, 25.000, 0, '', 1, '', '', 96, NULL, 1296, NULL, 0, 1, 1, NULL),
(30, 13, 13, 100.000, 0, '', 1, '', '', 95, NULL, 1395, NULL, 0, 1, 1, NULL),
(31, 13, 53, 50.000, 0, '', 2, '', '', 89, NULL, 5389, NULL, 0, 1, 1, NULL),
(32, 14, 49, 200.000, 0, '', 1, '', '', 53, NULL, 4953, NULL, 0, 1, 1, NULL),
(33, 15, 11, 100.000, 0, '', 4, '', '', 61, NULL, 1161, NULL, 0, 1, 1, NULL),
(34, 16, 2, 110.000, 0, '', 1, '', '', 3, NULL, 23, NULL, 0, 0, NULL, NULL),
(35, 17, 6, 20.000, 0, '', 1, '', '', 55, NULL, 655, NULL, 0, 0, NULL, NULL),
(36, 18, 10, 150.000, 0, '', 1, '', '', 60, NULL, 1060, NULL, 0, 0, NULL, NULL),
(37, 19, 11, 100.000, 0, '', 1, '', '', 61, NULL, 1161, NULL, 0, 0, NULL, NULL),
(38, 20, 12, 25.000, 0, '', 1, '', '', 96, NULL, 1296, NULL, 0, 1, 1, NULL),
(39, 21, 54, 40.000, 0, '', 1, '', '', 88, NULL, 5488, NULL, 0, 1, 1, NULL),
(40, 22, 50, 150.000, 0, '', 1, '', '', 92, NULL, 5092, NULL, 0, 1, 1, NULL),
(41, 23, 2, 110.000, 0, '', 4, '', '', 3, NULL, 23, NULL, 0, 0, NULL, NULL),
(42, 24, 2, 110.000, 0, '', 1, '6', '1', 3, NULL, 263, NULL, 0, 0, NULL, NULL),
(43, 25, 54, 40.000, 0, '', 1, '', '', 88, NULL, 5488, NULL, 0, 1, 1, NULL),
(44, 26, 1, 20.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 0, NULL, NULL),
(45, 26, 6, 20.000, 0, '', 1, '', '', 55, NULL, 655, NULL, 0, 0, NULL, NULL),
(46, 27, 49, 200.000, 0, '', 1, '', '', 53, NULL, 4953, NULL, 0, 0, NULL, NULL),
(47, 27, 13, 100.000, 0, '', 1, '', '', 95, NULL, 1395, NULL, 0, 0, NULL, NULL),
(49, 29, 6, 20.000, 0, '', 1, '', '', 55, NULL, 655, NULL, 0, 1, 1, NULL),
(50, 29, 57, 520.000, 81, '', 1, '', '', 85, 98, 8198, 1, 1, 1, 1, NULL),
(51, 29, 3, 520.000, 81, '', 1, '', '', 4, 98, 8198, 1, 1, 1, 1, NULL),
(52, 30, 75, 70.000, 0, '', 1, '', '', 67, NULL, 7567, NULL, 0, 1, 1, NULL),
(53, 30, 76, 60.000, 0, '', 1, '', '', 66, NULL, 7666, NULL, 0, 1, 1, NULL),
(54, 31, 78, 100.000, 0, '', 1, '', '', 64, NULL, 7864, NULL, 0, 0, NULL, NULL),
(55, 31, 74, 30.000, 0, '', 1, '', '', 68, NULL, 7468, NULL, 0, 0, NULL, NULL),
(56, 32, 14, 0.000, 0, '', 1, '', '', 94, NULL, 1494, NULL, 0, 1, 1, NULL),
(57, 32, 13, 0.000, 0, '', 1, '', '', 95, NULL, 1395, NULL, 0, 1, 1, NULL),
(58, 32, 81, 0.000, 0, '', 1, '', '', 98, NULL, 8198, NULL, 0, 1, 1, NULL),
(59, 32, 10, 0.000, 0, '', 1, '', '', 60, NULL, 1060, NULL, 0, 1, 1, NULL),
(60, 33, 1, 0.000, 0, '', 3, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(61, 33, 2, 0.000, 0, '', 1, '', '', 3, NULL, 23, NULL, 0, 1, 1, NULL),
(62, 33, 80, 0.000, 0, '', 1, '', '', 62, NULL, 8062, NULL, 0, 1, 1, NULL),
(63, 25, 12, 25.000, 0, NULL, 2, '', '0', 96, NULL, 1296, NULL, 0, 1, 1, NULL),
(64, 34, 6, 20.000, 0, '', 1, '', '', 55, NULL, 655, NULL, 0, 1, 1, NULL),
(65, 35, 14, 0.000, 0, '', 1, '', '', 94, NULL, 1494, NULL, 0, 1, 1, NULL),
(66, 36, 2, 0.000, 0, '', 1, '6', '1', 3, NULL, 2613, NULL, 0, 1, 1, NULL),
(67, 37, 1, 20.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(68, 37, 2, 110.000, 0, '', 1, '', '', 3, NULL, 23, NULL, 0, 1, 1, NULL),
(69, 38, 1, 20.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(70, 39, 80, 0.000, 0, '', 1, '', '', 62, NULL, 8062, NULL, 0, 1, 1, NULL),
(71, 39, 78, 0.000, 0, '', 1, '', '', 64, NULL, 7864, NULL, 0, 1, 1, NULL),
(72, 40, 67, 0.000, 0, '', 1, '', '', 75, NULL, 6775, NULL, 0, 1, 1, NULL),
(73, 40, 66, 0.000, 0, '', 1, '', '', 76, NULL, 6676, NULL, 0, 1, 1, NULL),
(74, 41, 67, 0.000, 0, '', 1, '', '', 75, NULL, 6775, NULL, 0, 1, 1, NULL),
(75, 41, 66, 0.000, 0, '', 1, '', '', 76, NULL, 6676, NULL, 0, 1, 1, NULL),
(76, 41, 65, 0.000, 0, '', 1, '', '', 77, NULL, 6577, NULL, 0, 1, 1, NULL),
(77, 41, 64, 0.000, 0, '', 1, '', '', 78, NULL, 6478, NULL, 0, 1, 1, NULL),
(78, 41, 68, 0.000, 0, '', 1, '', '', 74, NULL, 6874, NULL, 0, 1, 1, NULL),
(79, 42, 1, 0.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(80, 42, 2, 0.000, 0, '', 4, '6', '4', 3, NULL, 2643, NULL, 0, 1, 1, NULL),
(81, 43, 1, 0.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(82, 43, 2, 0.000, 0, '', 1, '6', '7', 3, NULL, 2673, NULL, 0, 1, 1, NULL),
(83, 44, 1, 0.000, 0, '', 3, '', '', 1, NULL, 11, NULL, 0, 0, NULL, NULL),
(84, 44, 2, 0.000, 0, '', 2, '', '', 3, NULL, 23, NULL, 0, 0, NULL, NULL),
(85, 44, 80, 0.000, 0, '', 7, '', '', 62, NULL, 8062, NULL, 0, 0, NULL, NULL),
(86, 45, 1, 20.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(87, 46, 7, 300.000, 0, '', 1, '', '', 56, NULL, 756, NULL, 0, 1, 1, NULL),
(88, 46, 6, 20.000, 0, '', 1, '', '', 55, NULL, 655, NULL, 0, 1, 1, NULL),
(89, 47, 53, 50.000, 0, '', 1, '', '', 89, NULL, 5389, NULL, 0, 1, 1, NULL),
(90, 47, 52, 400.000, 0, '', 1, '', '', 90, NULL, 5290, NULL, 0, 1, 1, NULL),
(91, 47, 51, 250.000, 0, '', 1, '', '', 91, NULL, 5191, NULL, 0, 1, 1, NULL),
(92, 48, 2, 110.000, 0, '', 1, '', '', 3, NULL, 23, NULL, 0, 1, 1, NULL),
(93, 49, 3, 20.000, 0, '', 1, '', '', 4, NULL, 34, NULL, 0, 1, 1, NULL),
(94, 50, 1, 20.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(95, 51, 1, 20.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(96, 51, 2, 110.000, 0, '', 1, '6', '3', 3, NULL, 263, NULL, 0, 1, 1, NULL),
(97, 52, 12, 25.000, 0, '', 1, '', '', 96, NULL, 1296, NULL, 0, 1, 1, NULL),
(98, 52, 8, 150.000, 0, '', 1, '', '', 54, NULL, 854, NULL, 0, 1, 1, NULL),
(99, 53, 1, 20.000, 0, '', 2, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(100, 53, 11, 100.000, 0, '', 1, '', '', 61, NULL, 1161, NULL, 0, 1, 1, NULL),
(101, 53, 14, 20.000, 0, '', 1, '', '', 94, NULL, 1494, NULL, 0, 1, 1, NULL),
(102, 53, 13, 100.000, 0, '', 1, '', '', 95, NULL, 1395, NULL, 0, 1, 1, NULL),
(103, 53, 49, 200.000, 0, '', 1, '', '', 53, NULL, 4953, NULL, 0, 1, 1, NULL),
(104, 54, 9, 120.000, 0, '', 1, '', '', 59, NULL, 959, NULL, 0, 1, 1, NULL),
(105, 54, 13, 100.000, 0, '', 1, '', '', 95, NULL, 1395, NULL, 0, 1, 1, NULL),
(106, 55, 63, 1100.000, 0, '', 1, '', '', 79, NULL, 6379, NULL, 0, 1, 1, NULL),
(107, 55, 61, 300.000, 0, '', 1, '', '', 57, NULL, 6157, NULL, 0, 1, 1, NULL),
(108, 56, 69, 140.000, 0, '', 1, '', '', 73, NULL, 6973, NULL, 0, 1, 1, NULL),
(109, 56, 70, 150.000, 0, '', 1, '', '', 72, NULL, 7072, NULL, 0, 1, 1, NULL),
(110, 56, 71, 100.000, 0, '', 1, '', '', 71, NULL, 7171, NULL, 0, 1, 1, NULL),
(111, 56, 75, 70.000, 0, '', 1, '', '', 67, NULL, 7567, NULL, 0, 1, 1, NULL),
(112, 56, 74, 30.000, 0, '', 1, '', '', 68, NULL, 7468, NULL, 0, 1, 1, NULL),
(113, 56, 73, 80.000, 0, '', 1, '', '', 69, NULL, 7369, NULL, 0, 1, 1, NULL),
(114, 56, 72, 200.000, 0, '', 1, '', '', 70, NULL, 7270, NULL, 0, 1, 1, NULL),
(115, 56, 68, 130.000, 0, '', 1, '', '', 74, NULL, 6874, NULL, 0, 1, 1, NULL),
(116, 56, 64, 15.000, 0, '', 1, '', '', 78, NULL, 6478, NULL, 0, 1, 1, NULL),
(117, 57, 76, 60.000, 0, '', 1, '', '', 66, NULL, 7666, NULL, 0, 1, 1, NULL),
(118, 57, 77, 50.000, 0, '', 1, '', '', 65, NULL, 7765, NULL, 0, 1, 1, NULL),
(119, 58, 73, 80.000, 0, '', 1, '', '', 69, NULL, 7369, NULL, 0, 1, 1, NULL),
(120, 58, 74, 30.000, 0, '', 1, '', '', 68, NULL, 7468, NULL, 0, 1, 1, NULL),
(121, 58, 75, 70.000, 0, '', 1, '', '', 67, NULL, 7567, NULL, 0, 1, 1, NULL),
(122, 59, 77, 50.000, 0, '', 1, '', '', 65, NULL, 7765, NULL, 0, 1, 1, NULL),
(123, 60, 80, 100.000, 0, '', 1, '', '', 62, NULL, 8062, NULL, 0, 1, 1, NULL),
(124, 60, 57, 520.000, 81, '', 1, '', '', 85, 98, 8198, 1, 1, 1, 1, NULL),
(125, 60, 3, 520.000, 81, '', 1, '', '', 4, 98, 8198, 1, 1, 1, 1, NULL),
(126, 61, 2, 110.000, 0, '', 1, '', '', 3, NULL, 23, NULL, 0, 1, 1, NULL),
(127, 62, 1, 20.000, 0, '', 1, '', '', 1, NULL, 11, NULL, 0, 1, 1, NULL),
(128, 63, 7, 300.000, 0, '', 1, '', '', 56, NULL, 756, NULL, 0, 1, 1, NULL),
(129, 63, 8, 150.000, 0, '', 1, '', '', 54, NULL, 854, NULL, 0, 1, 1, NULL),
(130, 64, 2, 110.000, 0, '', 1, '', '', 3, NULL, 23, NULL, 0, 1, 1, NULL),
(131, 66, 8, 0.000, 0, '', 1, '', '', 54, NULL, 854, NULL, 0, 1, 1, NULL),
(132, 66, 7, 0.000, 0, '', 1, '', '', 56, NULL, 756, NULL, 0, 1, 1, NULL),
(133, 66, 6, 0.000, 0, '', 1, '', '', 55, NULL, 655, NULL, 0, 1, 1, NULL),
(134, 67, 8, 0.000, 0, '', 1, '', '', 54, NULL, 854, NULL, 0, 1, 1, NULL),
(135, 67, 7, 0.000, 0, '', 1, '', '', 56, NULL, 756, NULL, 0, 1, 1, NULL),
(136, 68, 9, 120.000, 0, '', 1, '', '', 59, NULL, 959, NULL, 0, 1, 1, NULL),
(137, 68, 10, 150.000, 0, '', 1, '', '', 60, NULL, 1060, NULL, 0, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paymentmethod`
--

CREATE TABLE `paymentmethod` (
  `payment_method_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_qr` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paymentmethod`
--

INSERT INTO `paymentmethod` (`payment_method_id`, `payment_method`, `is_active`, `is_qr`) VALUES
(1, 'Cash', 1, 0),
(2, 'Credit Card', 1, 0),
(3, 'Mobile Money', 1, 1),
(4, 'QR Pay', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `paymentsetup`
--

CREATE TABLE `paymentsetup` (
  `setupid` int(11) NOT NULL,
  `paymentid` int(11) NOT NULL,
  `marchantid` varchar(255) DEFAULT NULL,
  `password` varchar(120) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `currency` varchar(20) NOT NULL,
  `Islive` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `edit_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `paymentsetup`
--

INSERT INTO `paymentsetup` (`setupid`, `paymentid`, `marchantid`, `password`, `email`, `currency`, `Islive`, `status`, `edit_url`) VALUES
(1, 5, 'bdtas5e772deb8ff87', 'bdtas5e772deb8ff87@ssl', 'ainalcse@gmail.com', 'BDT', 0, 1, NULL),
(2, 3, '', '', 'tareq7500personal2@gmail.com', 'USD', 0, 1, NULL),
(3, 2, '901400787', '', 'ainalcse@gmail.com', 'USD', 0, 1, NULL),
(4, 6, '002020000000001', '002020000000001_KEY1', '1', '', 0, 1, NULL),
(5, 7, 'BE10000072', 'BE10000072', 'karmadorji@gmail.com', 'BTN', 0, 1, NULL),
(6, 8, 'sandbox-sq0idb-ShIOgPUIHSXxsjCPG4oh_A', 'EAAAEE3gxSvOVaHIq-5A5P_yFkUbkAfUM2-JiQju2FTxQ4n7epxmvKpaOhECxHcN', '5SNY8GNKAZM00', 'AUD', 0, 1, NULL),
(7, 9, 'sk_test_ol4WUcbGsqxNJItpeOi1ecDT00k5mDyC2G', 'pk_test_TrVFpmZBkgasCE6WTPkZgMPr00UzVVOqgp', 'ainalcse@gmail.com', 'USD', 0, 1, NULL),
(8, 10, 'sk_test_71353c2613675acb967ea532f4c4c8105ea175b8', 'pk_test_328da55755b88b1aaed96c5cda215b2fd887edb9', 'ainalcse@gmail.com', 'NGN', 0, 1, NULL),
(9, 11, NULL, '', '', '', 0, 0, NULL),
(10, 12, '7BUkXCbuHDcx1ZyQqmcKVtsLnFxF0r3f', 'vmUIfeoHXpZSKc20Wt50d6hqeIY5FcWtFR6prg0Ubak8IvmmZEFDDpQr5ZMEdnoS', '', 'XAF', 0, 1, NULL),
(12, 13, 'sandbox-5rd4uUC2yAz7LWDaalyJAOEsH2rxrqVB', 'sandbox-FsKRCZpk0BpdUss3wVsNLhvs5Ty5PSpi', '', 'BDT', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `payment_method_id` tinyint(4) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `modulename` varchar(50) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`payment_method_id`, `payment_method`, `is_active`, `modulename`) VALUES
(1, 'Card Payment', 1, ''),
(2, 'Two Checkout', 1, ''),
(3, 'Paypal', 1, ''),
(4, 'Cash Payment', 1, ''),
(5, 'SSLCommerz', 1, ''),
(6, 'SIPS Office', 1, ''),
(7, 'RMA PAYMENT GATEWAY', 1, ''),
(8, 'Square Payments', 1, ''),
(9, 'Stripe Payment', 1, ''),
(10, 'Paystack Payments', 1, ''),
(11, 'Paytm Payments', 1, ''),
(12, 'Orange Money payment', 1, ''),
(13, 'iyzico', 1, ''),
(14, 'Airtel Money', 1, ''),
(15, 'MTN Money', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` bigint(20) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('PENDING','SUCCESS','FAILED','EXPIRED') NOT NULL DEFAULT 'PENDING',
  `provider_data` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_commission_setting`
--

CREATE TABLE `payroll_commission_setting` (
  `id` int(11) NOT NULL,
  `pos_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `create_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payroll_commission_setting`
--

INSERT INTO `payroll_commission_setting` (`id`, `pos_id`, `rate`, `create_by`) VALUES
(1, 1, 234, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_holiday`
--

CREATE TABLE `payroll_holiday` (
  `payrl_holi_id` int(10) UNSIGNED NOT NULL,
  `holiday_name` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `start_date` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `end_date` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_of_days` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_by` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `updated_by` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_tax_setup`
--

CREATE TABLE `payroll_tax_setup` (
  `tax_setup_id` int(10) UNSIGNED NOT NULL,
  `start_amount` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `end_amount` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rate` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_frequency`
--

CREATE TABLE `pay_frequency` (
  `id` int(11) NOT NULL,
  `frequency_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pay_frequency`
--

INSERT INTO `pay_frequency` (`id`, `frequency_name`) VALUES
(1, 'Weekly'),
(2, 'Biweekly'),
(3, 'Annual'),
(4, 'Monthly');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `pos_id` int(10) UNSIGNED NOT NULL,
  `position_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `position_details` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`pos_id`, `position_name`, `position_details`) VALUES
(1, 'chef', 'Responsible for the pastry shop in a foodservice establishment. Ensures that the products produced in the pastry shop meet the quality standards in conjunction with the executive chef.'),
(2, 'HRM', 'Recruits and hires qualified employees, creates in-house job-training programs, and assists employees with their career needs.'),
(3, 'Kitchen manager', 'Supervises and coordinates activities concerning all back-of-the-house operations and personnel, including food preparation, kitchen and storeroom areas.'),
(4, 'Counter server', 'Responsible for providing quick and efficient service to customers. Greets customers, takes their food and beverage orders, rings orders into register, and prepares and serves hot and cold drinks.'),
(6, 'Waiter', 'Most waiters and waitresses, also called servers, work in full-service restaurants. They greet customers, take food orders, bring food and drinks to the tables and take payment and make change.'),
(7, 'Accounts', 'Play a key role in every restaurant. '),
(8, 'Salesman', 'A salesman is someone who works in sales, with the main function of selling products or services to others either by visiting locations');

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `productionid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `itemvid` int(11) DEFAULT NULL,
  `itemquantity` int(11) NOT NULL,
  `savedby` int(11) NOT NULL,
  `saveddate` date NOT NULL,
  `productionexpiredate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `production`
--

INSERT INTO `production` (`productionid`, `itemid`, `itemvid`, `itemquantity`, `savedby`, `saveddate`, `productionexpiredate`) VALUES
(1, 3, 4, 1, 2, '2025-11-03', '2025-11-03');

-- --------------------------------------------------------

--
-- Table structure for table `production_details`
--

CREATE TABLE `production_details` (
  `pro_detailsid` int(11) NOT NULL,
  `foodid` int(11) NOT NULL,
  `pvarientid` int(11) DEFAULT NULL,
  `ingredientid` int(11) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unitname` varchar(100) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `production_details`
--

INSERT INTO `production_details` (`pro_detailsid`, `foodid`, `pvarientid`, `ingredientid`, `qty`, `unitname`, `createdby`, `created_date`) VALUES
(1, 3, 4, 17, 1.00, '', 2, '2025-11-03');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseitem`
--

CREATE TABLE `purchaseitem` (
  `purID` int(11) NOT NULL,
  `invoiceid` varchar(50) DEFAULT NULL,
  `suplierID` int(11) NOT NULL,
  `paymenttype` int(11) DEFAULT NULL,
  `bankid` int(11) DEFAULT NULL,
  `total_price` decimal(19,3) NOT NULL DEFAULT 0.000,
  `paid_amount` decimal(19,3) DEFAULT 0.000,
  `details` text DEFAULT NULL,
  `purchasedate` date NOT NULL,
  `purchaseexpiredate` date NOT NULL,
  `savedby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `purchaseitem`
--

INSERT INTO `purchaseitem` (`purID`, `invoiceid`, `suplierID`, `paymenttype`, `bankid`, `total_price`, `paid_amount`, `details`, `purchasedate`, `purchaseexpiredate`, `savedby`) VALUES
(1, '2', 1, 1, 0, 144.000, 4000.000, '', '2025-11-03', '2025-11-03', 2);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `detailsid` int(11) NOT NULL,
  `purchaseid` int(11) NOT NULL,
  `indredientid` int(11) NOT NULL,
  `quantity` decimal(19,3) NOT NULL DEFAULT 0.000,
  `unitname` varchar(80) NOT NULL,
  `price` decimal(19,3) NOT NULL DEFAULT 0.000,
  `totalprice` decimal(19,3) NOT NULL DEFAULT 0.000,
  `purchaseby` int(11) NOT NULL,
  `purchasedate` date NOT NULL,
  `purchaseexpiredate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`detailsid`, `purchaseid`, `indredientid`, `quantity`, `unitname`, `price`, `totalprice`, `purchaseby`, `purchasedate`, `purchaseexpiredate`) VALUES
(1, 1, 17, 12.000, '', 12.000, 144.000, 2, '2025-11-03', '2025-11-03');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return`
--

CREATE TABLE `purchase_return` (
  `preturn_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `po_no` varchar(120) NOT NULL,
  `return_date` date NOT NULL,
  `totalamount` float NOT NULL,
  `totaldiscount` float NOT NULL,
  `return_reason` varchar(250) NOT NULL,
  `createby` int(11) NOT NULL,
  `createdate` datetime NOT NULL,
  `updateby` int(11) NOT NULL,
  `updatedate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchase_return`
--

INSERT INTO `purchase_return` (`preturn_id`, `supplier_id`, `po_no`, `return_date`, `totalamount`, `totaldiscount`, `return_reason`, `createby`, `createdate`, `updateby`, `updatedate`) VALUES
(1, 1, '', '2025-11-03', 0, 0, 'not really bought', 2, '2025-11-03 22:17:59', 0, '0000-00-00 00:00:00'),
(2, 1, '', '2025-11-03', 0, 0, '', 2, '2025-11-03 22:19:18', 0, '0000-00-00 00:00:00'),
(3, 1, '', '2025-11-03', 0, 0, 'xcd', 2, '2025-11-03 22:27:25', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `preturn_id` int(11) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `product_rate` float NOT NULL,
  `store_id` int(11) NOT NULL,
  `discount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qr_orders`
--

CREATE TABLE `qr_orders` (
  `id` int(11) NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` enum('pending','paid','cancelled') DEFAULT 'pending',
  `order_status` enum('new','processing','served','completed','cancelled') DEFAULT 'new',
  `order_time` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qr_payments`
--

CREATE TABLE `qr_payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(50) DEFAULT 'cash',
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qr_tables`
--

CREATE TABLE `qr_tables` (
  `table_id` int(11) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rate_type`
--

CREATE TABLE `rate_type` (
  `id` int(11) NOT NULL,
  `r_type_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rate_type`
--

INSERT INTO `rate_type` (`id`, `r_type_name`) VALUES
(1, 'Hourly'),
(2, 'Salary');

-- --------------------------------------------------------

--
-- Table structure for table `reservationofday`
--

CREATE TABLE `reservationofday` (
  `offdayid` int(11) NOT NULL,
  `offdaydate` date NOT NULL,
  `availtime` varchar(50) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reservationofday`
--

INSERT INTO `reservationofday` (`offdayid`, `offdaydate`, `availtime`, `is_active`) VALUES
(1, '2025-11-30', '12:40:15-05:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rest_table`
--

CREATE TABLE `rest_table` (
  `tableid` int(11) NOT NULL,
  `tablename` varchar(50) NOT NULL,
  `person_capicity` int(11) NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `table_icon` varchar(255) NOT NULL,
  `floor` int(11) DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '1=booked,0=free'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rest_table`
--

INSERT INTO `rest_table` (`tableid`, `tablename`, `person_capicity`, `qr_code`, `table_icon`, `floor`, `status`) VALUES
(1, '1', 2, 'table_1.png', 'assets/img/icons/resttable/1.png', 3, 1),
(2, '2', 4, 'table_2.png', 'assets/img/icons/resttable/4.png', 1, 1),
(3, '3', 2, 'table_3.png', 'assets/img/icons/resttable/2.png', 1, 1),
(6, '6', 3, 'table_6.png', 'assets/img/icons/resttable/3.png', 1, 0),
(7, '7', 8, 'table_7.png', 'assets/img/icons/resttable/8.png', 1, 1),
(8, '8', 4, 'table_8.png', 'assets/img/icons/resttable/4.png', 3, 1),
(9, '9', 3, 'table_9.png', 'assets/img/icons/resttable/3.png', 1, 0),
(10, 'VIP', 8, 'table_10.png', 'assets/img/icons/resttable/7.png', 2, 1),
(11, 'Single', 1, 'table_11.png', 'assets/img/icons/resttable/loading.gif', 1, 0),
(12, 'Family', 10, 'table_12.png', 'assets/img/icons/resttable/7.png', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` int(11) NOT NULL,
  `fk_module_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `create` tinyint(1) DEFAULT NULL,
  `read` tinyint(1) DEFAULT NULL,
  `update` tinyint(1) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_setup_header`
--

CREATE TABLE `salary_setup_header` (
  `s_s_h_id` int(10) UNSIGNED NOT NULL,
  `employee_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `salary_payable` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `absent_deduct` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tax_manager` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `salary_setup_header`
--

INSERT INTO `salary_setup_header` (`s_s_h_id`, `employee_id`, `salary_payable`, `absent_deduct`, `tax_manager`, `status`) VALUES
(1, 'EZR0A9IB', '400', '0', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `salary_sheet_generate`
--

CREATE TABLE `salary_sheet_generate` (
  `ssg_id` int(10) UNSIGNED NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `name` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `gdate` varchar(20) DEFAULT NULL,
  `start_date` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `end_date` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `generate_by` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_type`
--

CREATE TABLE `salary_type` (
  `salary_type_id` int(10) UNSIGNED NOT NULL,
  `sal_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `emp_sal_type` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `default_amount` varchar(30) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `salary_type`
--

INSERT INTO `salary_type` (`salary_type_id`, `sal_name`, `emp_sal_type`, `default_amount`, `status`) VALUES
(1, 'House Rent', '1', '', ''),
(2, 'Medical', '1', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sec_menu_item`
--

CREATE TABLE `sec_menu_item` (
  `menu_id` int(11) NOT NULL,
  `menu_title` varchar(200) DEFAULT NULL,
  `page_url` varchar(250) DEFAULT NULL,
  `module` varchar(200) DEFAULT NULL,
  `parent_menu` int(11) DEFAULT NULL,
  `is_report` tinyint(1) DEFAULT NULL,
  `createby` int(11) NOT NULL,
  `createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sec_menu_item`
--

INSERT INTO `sec_menu_item` (`menu_id`, `menu_title`, `page_url`, `module`, `parent_menu`, `is_report`, `createby`, `createdate`) VALUES
(1, 'manage_category', '', 'itemmanage', 0, 0, 2, '2018-11-05 00:00:00'),
(2, 'category_list', 'item_category', 'itemmanage', 0, 0, 2, '2018-11-05 00:00:00'),
(3, 'add_category', 'create', 'itemmanage', 2, 0, 2, '2018-11-05 00:00:00'),
(4, 'manage_food', '', 'itemmanage', 0, 0, 2, '2018-11-05 00:00:00'),
(5, 'food_list', 'item_food', 'itemmanage', 0, 0, 2, '2018-11-05 00:00:00'),
(6, 'add_food', 'index', 'itemmanage', 5, 0, 2, '2018-11-05 00:00:00'),
(7, 'food_varient', 'foodvarientlist', 'itemmanage', 5, 0, 2, '2018-11-07 00:00:00'),
(8, 'add_varient', 'addvariant', 'itemmanage', 5, 0, 2, '2018-11-07 00:00:00'),
(9, 'food_availablity', 'availablelist', 'itemmanage', 5, 0, 2, '2018-11-07 00:00:00'),
(10, 'add_availablity', 'addavailable', 'itemmanage', 5, 0, 2, '2018-11-07 00:00:00'),
(11, 'manage_addons', '', 'itemmanage', 0, 0, 2, '2018-11-05 00:00:00'),
(12, 'addons_list', 'menu_addons', 'itemmanage', 0, 0, 2, '2018-11-05 00:00:00'),
(13, 'add_adons', 'create', 'itemmanage', 8, 0, 2, '2018-11-05 00:00:00'),
(14, 'manage_unitmeasurement', '', 'units', 0, 0, 2, '2018-11-05 00:00:00'),
(15, 'unit_list', 'unitmeasurement', 'units', 0, 0, 2, '2018-11-05 00:00:00'),
(16, 'unit_add', 'create', 'units', 12, 0, 2, '2018-11-05 00:00:00'),
(17, 'manage_ingradient', '', 'units', 0, 0, 2, '2018-11-05 00:00:00'),
(18, 'ingradient_list', 'ingradient', 'units', 0, 0, 2, '2018-11-05 00:00:00'),
(19, 'add_ingredient', 'create', 'units', 15, 0, 2, '2018-11-05 00:00:00'),
(20, 'assign_adons_list', 'assignaddons', 'itemmanage', 8, 0, 2, '2018-11-06 00:00:00'),
(21, 'assign_adons', 'assignaddonscreate', 'itemmanage', 8, 0, 2, '2018-11-06 00:00:00'),
(28, 'membership_management', '', 'setting', 0, 0, 2, '2018-11-12 00:00:00'),
(29, 'membership_list', 'index', 'setting', 28, 0, 2, '2018-11-12 00:00:00'),
(30, 'membership_add', 'create', 'setting', 29, 0, 2, '2018-11-12 00:00:00'),
(31, 'payment_setting', '', 'setting', 0, 0, 2, '2018-11-12 00:00:00'),
(32, 'paymentmethod_list', 'index', 'setting', 31, 0, 2, '2018-11-12 00:00:00'),
(33, 'payment_add', 'create', 'setting', 32, 0, 2, '2018-11-12 00:00:00'),
(34, 'shipping_setting', '', 'setting', 0, 0, 2, '2018-11-12 00:00:00'),
(35, 'shipping_list', 'index', 'setting', 34, 0, 2, '2018-11-12 00:00:00'),
(36, 'shipping_add', 'create', 'setting', 35, 0, 2, '2018-11-12 00:00:00'),
(37, 'supplier_manage', '', 'setting', 0, 0, 2, '2018-11-12 00:00:00'),
(38, 'supplier_list', 'index', 'setting', 37, 0, 2, '2018-11-12 00:00:00'),
(39, 'supplier_add', 'create', 'setting', 38, 0, 2, '2018-11-12 00:00:00'),
(40, 'purchase_item', 'index', 'purchase', 0, 0, 2, '2018-11-12 00:00:00'),
(41, 'purchase_add', 'create', 'purchase', 40, 0, 2, '2018-11-12 00:00:00'),
(42, 'table_manage', '', 'setting', 0, 0, 2, '2018-11-13 00:00:00'),
(43, 'add_new_table', 'create', 'setting', 44, 0, 2, '2018-11-13 00:00:00'),
(44, 'table_list', 'restauranttable', 'setting', 42, 0, 2, '2018-11-13 00:00:00'),
(45, 'ordermanage', 'index', 'ordermanage', 0, 0, 2, '2018-11-22 00:00:00'),
(46, 'add_new_order', 'neworder', 'ordermanage', 45, 0, 2, '2018-11-22 00:00:00'),
(47, 'order_list', 'orderlist', 'ordermanage', 45, 0, 2, '2018-11-22 00:00:00'),
(48, 'pending_order', 'pendingorder', 'ordermanage', 45, 0, 2, '2018-11-22 00:00:00'),
(49, 'processing_order', 'processing', 'ordermanage', 45, 0, 2, '2018-11-22 00:00:00'),
(50, 'complete_order', 'completelist', 'ordermanage', 45, 0, 2, '2018-11-22 00:00:00'),
(51, 'cancel_order', 'cancellist', 'ordermanage', 45, 0, 2, '2018-11-22 00:00:00'),
(52, 'pos_invoice', 'pos_invoice', 'ordermanage', 45, 0, 2, '2018-11-22 00:00:00'),
(53, 'c_o_a', 'treeview', 'accounts', 0, 0, 2, '2018-12-17 00:00:00'),
(54, 'debit_voucher', 'debit_voucher', 'accounts', 0, 0, 2, '2018-12-17 00:00:00'),
(55, 'credit_voucher', 'credit_voucher', 'accounts', 0, 0, 2, '2018-12-17 00:00:00'),
(56, 'contra_voucher', 'contra_voucher', 'accounts', 0, 0, 2, '2018-12-17 00:00:00'),
(57, 'journal_voucher', 'journal_voucher', 'accounts', 0, 0, 2, '2018-12-17 00:00:00'),
(58, 'voucher_approval', 'voucher_approval', 'accounts', 0, 0, 2, '2018-12-17 00:00:00'),
(59, 'account_report', '', 'accounts', 0, 0, 2, '2018-12-17 00:00:00'),
(60, 'voucher_report', 'coa', 'accounts', 59, 0, 2, '2018-12-17 00:00:00'),
(61, 'cash_book', 'cash_book', 'accounts', 59, 0, 2, '2018-12-17 00:00:00'),
(62, 'bank_book', 'bank_book', 'accounts', 59, 0, 2, '2018-12-17 00:00:00'),
(63, 'general_ledger', 'general_ledger', 'accounts', 59, 0, 2, '2018-12-17 00:00:00'),
(64, 'trial_balance', 'trial_balance', 'accounts', 59, 0, 2, '2018-12-17 00:00:00'),
(65, 'profit_loss', 'profit_loss_report', 'accounts', 59, 0, 2, '2018-12-17 00:00:00'),
(66, 'cash_flow', 'cash_flow_report', 'accounts', 59, 0, 2, '2018-12-17 00:00:00'),
(67, 'coa_print', 'coa_print', 'accounts', 59, 0, 2, '2018-12-17 00:00:00'),
(68, 'hrm', '', 'hrm', 0, 0, 2, '2018-12-18 00:00:00'),
(69, 'attendance', 'Home', 'hrm', 0, 0, 2, '2018-12-18 00:00:00'),
(70, 'atn_form', 'atnview', 'hrm', 69, 0, 2, '2018-12-18 00:00:00'),
(71, 'atn_report', 'attendance_list', 'hrm', 69, 0, 2, '2018-12-18 00:00:00'),
(72, 'award', 'Award_controller', 'hrm', 0, 0, 2, '2018-12-18 00:00:00'),
(73, 'new_award', 'create_award', 'hrm', 72, 0, 2, '2018-12-18 00:00:00'),
(74, 'circularprocess', 'Candidate', 'hrm', 0, 0, 2, '2018-12-18 00:00:00'),
(75, 'add_canbasic_info', 'caninfo_create', 'hrm', 74, 0, 2, '2018-12-18 00:00:00'),
(76, 'can_basicinfo_list', 'canInfoview', 'hrm', 74, 0, 2, '2018-12-18 00:00:00'),
(77, 'candidate_basic_info', 'Candidate_select', 'hrm', 0, 0, 2, '2018-12-18 00:00:00'),
(78, 'candidate_shortlist', 'shortlist_form', 'hrm', 77, 0, 2, '2018-12-18 00:00:00'),
(79, 'candidate_interview', 'interview_form', 'hrm', 77, 0, 2, '2018-12-18 00:00:00'),
(80, 'candidate_selection', 'selection_form', 'hrm', 77, 0, 2, '2018-12-18 00:00:00'),
(81, 'department', 'Department_controller', 'hrm', 0, 0, 2, '2018-12-18 00:00:00'),
(82, 'departmentfrm', 'create_dept', 'hrm', 81, 0, 2, '2018-12-18 00:00:00'),
(83, 'division', 'Division_controller', 'hrm', 0, 0, 2, '2018-12-18 00:00:00'),
(84, 'add_division', 'division_form', 'hrm', 83, 0, 2, '2018-12-18 00:00:00'),
(85, 'ehrm', 'Employees', 'hrm', 0, 0, 2, '2018-12-18 00:00:00'),
(86, 'division_list', 'position_form', 'hrm', 87, 0, 2, '2018-12-18 00:00:00'),
(87, 'designation', 'create_position', 'hrm', 87, 0, 2, '2018-12-18 00:00:00'),
(88, 'add_employee', 'viewEmhistory', 'hrm', 87, 0, 2, '2018-12-18 00:00:00'),
(89, 'manage_employee', 'manageemployee', 'hrm', 87, 0, 2, '2018-12-18 00:00:00'),
(91, 'emp_sal_payment', 'paymentview', 'hrm', 87, 0, 2, '2018-12-18 00:00:00'),
(92, 'leave', 'leave', 'hrm', 0, 0, 2, '2018-12-18 00:00:00'),
(93, 'weekly_holiday', 'weeklyform', 'hrm', 92, 0, 2, '2018-12-18 00:00:00'),
(94, 'holiday', 'holiday_form', 'hrm', 92, 0, 2, '2018-12-18 00:00:00'),
(95, 'others_leave_application', 'others_leave', 'hrm', 92, 0, 2, '2018-12-18 00:00:00'),
(96, 'add_leave_type', 'leave_type_form', 'hrm', 92, 0, 2, '2018-12-18 00:00:00'),
(97, 'leave_application', 'others_leave', 'hrm', 92, 0, 2, '2018-12-18 00:00:00'),
(98, 'loan', 'loan', 'hrm', 0, 0, 2, '2018-12-18 00:00:00'),
(99, 'loan_grand', 'create_grandloan', 'hrm', 98, 0, 2, '2018-12-18 00:00:00'),
(100, 'loan_installment', 'create_installment', 'hrm', 98, 0, 2, '2018-12-19 00:00:00'),
(101, 'manage_installment', 'installmentView', 'hrm', 98, 0, 2, '2018-12-19 00:00:00'),
(102, 'manage_granted_loan', 'loan_view', 'hrm', 98, 0, 2, '2018-12-19 00:00:00'),
(103, 'loan_report', 'loan_report', 'hrm', 98, 0, 2, '2018-12-19 00:00:00'),
(104, 'payroll', 'Payroll', 'hrm', 0, 0, 2, '2018-12-19 00:00:00'),
(105, 'salary_type_setup', 'create_salary_setup', 'hrm', 104, 0, 2, '2018-12-19 00:00:00'),
(106, 'manage_salary_setup', 'emp_salary_setup_view', 'hrm', 104, 0, 2, '2018-12-19 00:00:00'),
(107, 'salary_setup', 'create_s_setup', 'hrm', 104, 0, 2, '2018-12-19 00:00:00'),
(108, 'manage_salary_type', 'salary_setup_view', 'hrm', 104, 0, 2, '2018-12-19 00:00:00'),
(109, 'salary_generate', 'create_salary_generate', 'hrm', 104, 0, 2, '2018-12-19 00:00:00'),
(110, 'manage_salary_generate', 'salary_generate_view', 'hrm', 104, 0, 2, '2018-12-19 00:00:00'),
(111, 'purchase_return', 'return_form', 'purchase', 40, 0, 2, '2018-12-19 00:00:00'),
(112, 'return_invoice', 'return_invoice', 'purchase', 40, 0, 2, '2018-12-19 00:00:00'),
(113, 'report', 'reports', 'report', 0, 0, 2, '2018-12-19 00:00:00'),
(114, 'purchase_report', 'index', 'report', 113, 0, 2, '2018-12-19 00:00:00'),
(115, 'stock_report_product_wise', 'productwise', 'report', 113, 0, 2, '2018-12-19 00:00:00'),
(116, 'purchase_report_ingredient', 'ingredientwise', 'report', 113, 0, 2, '2018-12-19 00:00:00'),
(117, 'sell_report', 'sellrpt', 'report', 113, 0, 2, '2018-12-19 00:00:00'),
(118, 'table_setting', 'tablesetting', 'setting', 44, 0, 2, '2018-12-19 00:00:00'),
(119, 'customer_type', '', 'setting', 0, 0, 2, '2018-12-19 00:00:00'),
(120, 'customertype_list', 'customertype', 'setting', 0, 0, 2, '2018-12-19 00:00:00'),
(121, 'add_type', 'create', 'setting', 120, 0, 2, '2018-12-19 00:00:00'),
(122, 'currency', '', 'setting', 0, 0, 2, '2018-12-19 00:00:00'),
(123, 'currency_list', 'currency', 'setting', 0, 0, 2, '2018-12-19 00:00:00'),
(124, 'currency_add', 'create', 'setting', 123, 0, 2, '2018-12-19 00:00:00'),
(125, 'production', '', 'production', 0, 0, 2, '2018-12-19 00:00:00'),
(126, 'production_set_list', 'production', 'production', 0, 0, 2, '2018-12-19 00:00:00'),
(127, 'set_productionunit', 'productionunit', 'production', 126, 0, 2, '2018-12-19 00:00:00'),
(128, 'production_add', 'create', 'production', 126, 0, 2, '2018-12-19 00:00:00'),
(129, 'production_list', 'addproduction', 'production', 126, 0, 2, '2018-12-19 00:00:00'),
(130, 'reservation', '', 'reservation', 0, 0, 2, '2018-12-19 00:00:00'),
(131, 'reservation_table', 'tablebooking', 'reservation', 130, 0, 2, '2018-12-19 00:00:00'),
(132, 'update_ord', 'updateorder', 'ordermanage', 45, 0, 2, '2019-12-11 00:00:00'),
(133, 'kitchen_dashboard', 'kitchen', 'ordermanage', 45, 0, 2, '2020-02-13 00:00:00'),
(134, 'counter_dashboard', 'counterboard', 'ordermanage', 45, 0, 2, '2020-02-16 00:00:00'),
(191, 'counter_list', 'counterlist', 'ordermanage', 45, 0, 2, '2021-03-28 00:00:00'),
(192, 'pos_setting', 'possetting', 'ordermanage', 45, 0, 2, '2021-03-28 00:00:00'),
(193, 'sound_setting', 'soundsetting', 'ordermanage', 45, 0, 2, '2021-03-28 00:00:00'),
(194, 'supplier_ledger', 'supplier_ledger_report', 'purchase', 38, 0, 2, '2021-03-28 00:00:00'),
(195, 'stock_out_ingredients', 'stock_out_ingredients', 'purchase', 40, 0, 2, '2021-03-28 00:00:00'),
(196, 'sell_report_items', 'sellrptItems', 'report', 117, 0, 2, '2021-01-21 00:00:00'),
(197, 'scharge_report', 'servicerpt', 'report', 113, 0, 2, '2021-01-21 00:00:00'),
(198, 'sell_report_waiters', 'sellrptwaiter', 'report', 113, 0, 2, '2021-01-21 00:00:00'),
(199, 'kitchen_sell', 'kichansrpt', 'report', 113, 0, 2, '2021-01-21 00:00:00'),
(200, 'sell_report_delvirytype', 'sellrptdelvirytype', 'report', 113, 0, 2, '2021-01-21 00:00:00'),
(201, 'sell_report_casher', 'sellrptCasher', 'report', 113, 0, 2, '2021-01-21 00:00:00'),
(202, 'unpaid_sell', 'unpaid_sell', 'report', 113, 0, 2, '2021-01-21 00:00:00'),
(203, 'sell_report_filter', 'sellrpt2', 'report', 113, 0, 2, '2021-01-21 00:00:00'),
(204, 'sele_by_date', 'sellrptbydate', 'report', 113, 0, 2, '2021-01-21 00:00:00'),
(205, 'production_setting', 'possetting', 'production', 125, 0, 2, '2021-03-28 00:00:00'),
(206, 'kitchen_setting', 'kitchensetting', 'setting', 0, 0, 2, '2021-03-28 00:00:00'),
(207, 'kitchen_assign', 'assignkitchen', 'setting', 206, 0, 2, '2021-03-28 00:00:00'),
(208, 'sms_setting', 'smsetting', 'setting', 0, 0, 2, '2021-03-28 00:00:00'),
(209, 'sms_configuration', 'sms_configuration', 'setting', 208, 0, 2, '2021-03-28 00:00:00'),
(210, 'sms_temp', 'sms_template', 'setting', 208, 0, 2, '2021-03-28 00:00:00'),
(211, 'bank', 'bank_list', 'setting', 0, 0, 2, '2021-03-28 00:00:00'),
(212, 'list_of_bank', 'index', 'setting', 211, 0, 2, '2021-03-28 00:00:00'),
(213, 'language', 'language', 'setting', 0, 0, 2, '2021-03-28 00:00:00'),
(214, 'application_setting', 'setting', 'setting', 0, 0, 2, '2021-03-28 00:00:00'),
(215, 'server_setting', 'serversetting', 'setting', 0, 0, 2, '2021-03-28 00:00:00'),
(216, 'factory_reset', 'factoryreset', 'setting', 214, 0, 2, '2021-03-28 00:00:00'),
(217, 'country', 'country_city_list', 'setting', 0, 0, 2, '2021-03-28 00:00:00'),
(218, 'state', 'statelist', 'setting', 217, 0, 2, '2021-03-28 00:00:00'),
(219, 'city', 'citylist', 'setting', 217, 0, 2, '2021-03-28 00:00:00'),
(220, 'commission', 'Commissionsetting/payroll_commission', 'setting', 0, 0, 2, '2021-03-28 00:00:00'),
(221, 'supplier_payment', 'supplier_payments', 'accounts', 59, 0, 2, '2021-03-28 00:00:00'),
(222, 'cash_adjustment', 'cash_adjustment', 'accounts', 59, 0, 2, '2021-03-28 00:00:00'),
(223, 'balance_sheet', 'balance_sheet', 'accounts', 59, 0, 2, '2021-03-28 00:00:00'),
(224, 'expense', 'Cexpense', 'hrm', 0, 0, 2, '2021-03-28 00:00:00'),
(225, 'unavailable_day', 'unavailablelist', 'reservation', 130, 0, 2, '2021-03-28 00:00:00'),
(226, 'reservasetting', 'setting', 'reservation', 130, 0, 2, '2021-03-28 00:00:00'),
(1388, 'dashboard', 'home', 'dashboard', 0, 0, 2, '2021-09-02 00:00:00'),
(1520, 'add_whatsapp', 'whatsappback', 'whatsapp', 0, 0, 3, '2020-12-03 00:00:00'),
(1521, 'whatsapp_api', 'showsetting', 'whatsapp', 1520, 0, 3, '2020-12-03 00:00:00'),
(1522, 'add_facebook_app', 'facebookloginback', 'facebooklogin', 0, 0, 3, '2025-11-03 01:46:19'),
(1523, 'facebook_api', 'showsetting', 'facebooklogin', 1522, 0, 3, '2025-11-03 01:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `sec_role_permission`
--

CREATE TABLE `sec_role_permission` (
  `id` bigint(20) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `can_access` tinyint(1) NOT NULL,
  `can_create` tinyint(1) NOT NULL,
  `can_edit` tinyint(1) NOT NULL,
  `can_delete` tinyint(1) NOT NULL,
  `createby` int(11) NOT NULL,
  `createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sec_role_permission`
--

INSERT INTO `sec_role_permission` (`id`, `role_id`, `menu_id`, `can_access`, `can_create`, `can_edit`, `can_delete`, `createby`, `createdate`) VALUES
(520, 3, 53, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(521, 3, 54, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(522, 3, 55, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(523, 3, 56, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(524, 3, 57, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(525, 3, 58, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(526, 3, 59, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(527, 3, 60, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(528, 3, 61, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(529, 3, 62, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(530, 3, 63, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(531, 3, 64, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(532, 3, 65, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(533, 3, 66, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(534, 3, 67, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(535, 3, 221, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(536, 3, 222, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(537, 3, 223, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(538, 3, 1388, 1, 1, 1, 1, 2, '2021-09-02 05:42:45'),
(539, 3, 68, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(540, 3, 69, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(541, 3, 70, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(542, 3, 71, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(543, 3, 72, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(544, 3, 73, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(545, 3, 74, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(546, 3, 75, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(547, 3, 76, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(548, 3, 77, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(549, 3, 78, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(550, 3, 79, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(551, 3, 80, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(552, 3, 81, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(553, 3, 82, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(554, 3, 83, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(555, 3, 84, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(556, 3, 85, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(557, 3, 86, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(558, 3, 87, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(559, 3, 88, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(560, 3, 89, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(561, 3, 90, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(562, 3, 91, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(563, 3, 92, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(564, 3, 93, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(565, 3, 94, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(566, 3, 95, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(567, 3, 96, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(568, 3, 97, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(569, 3, 98, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(570, 3, 99, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(571, 3, 100, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(572, 3, 101, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(573, 3, 102, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(574, 3, 103, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(575, 3, 104, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(576, 3, 105, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(577, 3, 106, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(578, 3, 107, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(579, 3, 108, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(580, 3, 109, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(581, 3, 110, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(582, 3, 224, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(583, 3, 1, 1, 1, 1, 1, 2, '2021-09-02 05:42:45'),
(584, 3, 2, 1, 1, 1, 1, 2, '2021-09-02 05:42:45'),
(585, 3, 3, 1, 1, 1, 1, 2, '2021-09-02 05:42:45'),
(586, 3, 4, 1, 1, 1, 1, 2, '2021-09-02 05:42:45'),
(587, 3, 5, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(588, 3, 6, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(589, 3, 7, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(590, 3, 8, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(591, 3, 9, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(592, 3, 10, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(593, 3, 11, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(594, 3, 12, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(595, 3, 13, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(596, 3, 20, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(597, 3, 21, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(598, 3, 1382, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(599, 3, 1383, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(600, 3, 1384, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(601, 3, 1385, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(602, 3, 1386, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(603, 3, 1387, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(604, 3, 45, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(605, 3, 46, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(606, 3, 47, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(607, 3, 48, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(608, 3, 49, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(609, 3, 50, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(610, 3, 51, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(611, 3, 52, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(612, 3, 132, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(613, 3, 133, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(614, 3, 134, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(615, 3, 191, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(616, 3, 192, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(617, 3, 193, 1, 1, 1, 0, 2, '2021-09-02 05:42:45'),
(618, 3, 125, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(619, 3, 126, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(620, 3, 127, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(621, 3, 128, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(622, 3, 129, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(623, 3, 205, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(624, 3, 40, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(625, 3, 41, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(626, 3, 111, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(627, 3, 112, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(628, 3, 194, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(629, 3, 195, 1, 1, 0, 0, 2, '2021-09-02 05:42:45'),
(630, 3, 227, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(631, 3, 228, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(632, 3, 229, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(633, 3, 113, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(634, 3, 114, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(635, 3, 115, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(636, 3, 116, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(637, 3, 117, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(638, 3, 196, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(639, 3, 197, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(640, 3, 198, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(641, 3, 199, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(642, 3, 200, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(643, 3, 201, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(644, 3, 202, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(645, 3, 203, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(646, 3, 204, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(647, 3, 130, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(648, 3, 131, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(649, 3, 225, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(650, 3, 226, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(651, 3, 28, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(652, 3, 29, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(653, 3, 30, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(654, 3, 31, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(655, 3, 32, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(656, 3, 33, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(657, 3, 34, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(658, 3, 35, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(659, 3, 36, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(660, 3, 37, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(661, 3, 38, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(662, 3, 39, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(663, 3, 42, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(664, 3, 43, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(665, 3, 44, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(666, 3, 118, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(667, 3, 119, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(668, 3, 120, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(669, 3, 121, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(670, 3, 122, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(671, 3, 123, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(672, 3, 124, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(673, 3, 206, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(674, 3, 207, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(675, 3, 208, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(676, 3, 209, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(677, 3, 210, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(678, 3, 211, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(679, 3, 212, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(680, 3, 213, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(681, 3, 214, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(682, 3, 215, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(683, 3, 216, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(684, 3, 217, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(685, 3, 218, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(686, 3, 219, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(687, 3, 220, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(688, 3, 14, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(689, 3, 15, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(690, 3, 16, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(691, 3, 17, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(692, 3, 18, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(693, 3, 19, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(694, 3, 230, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(695, 3, 231, 0, 0, 0, 0, 2, '2021-09-02 05:42:45'),
(696, 4, 53, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(697, 4, 54, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(698, 4, 55, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(699, 4, 56, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(700, 4, 57, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(701, 4, 58, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(702, 4, 59, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(703, 4, 60, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(704, 4, 61, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(705, 4, 62, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(706, 4, 63, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(707, 4, 64, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(708, 4, 65, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(709, 4, 66, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(710, 4, 67, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(711, 4, 221, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(712, 4, 222, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(713, 4, 223, 1, 1, 1, 1, 2, '2025-11-03 12:00:11'),
(714, 4, 1388, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(715, 4, 1522, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(716, 4, 1523, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(717, 4, 68, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(718, 4, 69, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(719, 4, 70, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(720, 4, 71, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(721, 4, 72, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(722, 4, 73, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(723, 4, 74, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(724, 4, 75, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(725, 4, 76, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(726, 4, 77, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(727, 4, 78, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(728, 4, 79, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(729, 4, 80, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(730, 4, 81, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(731, 4, 82, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(732, 4, 83, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(733, 4, 84, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(734, 4, 85, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(735, 4, 86, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(736, 4, 87, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(737, 4, 88, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(738, 4, 89, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(739, 4, 91, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(740, 4, 92, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(741, 4, 93, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(742, 4, 94, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(743, 4, 95, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(744, 4, 96, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(745, 4, 97, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(746, 4, 98, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(747, 4, 99, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(748, 4, 100, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(749, 4, 101, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(750, 4, 102, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(751, 4, 103, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(752, 4, 104, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(753, 4, 105, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(754, 4, 106, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(755, 4, 107, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(756, 4, 108, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(757, 4, 109, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(758, 4, 110, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(759, 4, 224, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(760, 4, 1, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(761, 4, 2, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(762, 4, 3, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(763, 4, 4, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(764, 4, 5, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(765, 4, 6, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(766, 4, 7, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(767, 4, 8, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(768, 4, 9, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(769, 4, 10, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(770, 4, 11, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(771, 4, 12, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(772, 4, 13, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(773, 4, 20, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(774, 4, 21, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(775, 4, 45, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(776, 4, 46, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(777, 4, 47, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(778, 4, 48, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(779, 4, 49, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(780, 4, 50, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(781, 4, 51, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(782, 4, 52, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(783, 4, 132, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(784, 4, 133, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(785, 4, 134, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(786, 4, 191, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(787, 4, 192, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(788, 4, 193, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(789, 4, 125, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(790, 4, 126, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(791, 4, 127, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(792, 4, 128, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(793, 4, 129, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(794, 4, 205, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(795, 4, 40, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(796, 4, 41, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(797, 4, 111, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(798, 4, 112, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(799, 4, 194, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(800, 4, 195, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(801, 4, 113, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(802, 4, 114, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(803, 4, 115, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(804, 4, 116, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(805, 4, 117, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(806, 4, 196, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(807, 4, 197, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(808, 4, 198, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(809, 4, 199, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(810, 4, 200, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(811, 4, 201, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(812, 4, 202, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(813, 4, 203, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(814, 4, 204, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(815, 4, 130, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(816, 4, 131, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(817, 4, 225, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(818, 4, 226, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(819, 4, 28, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(820, 4, 29, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(821, 4, 30, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(822, 4, 31, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(823, 4, 32, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(824, 4, 33, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(825, 4, 34, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(826, 4, 35, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(827, 4, 36, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(828, 4, 37, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(829, 4, 38, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(830, 4, 39, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(831, 4, 42, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(832, 4, 43, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(833, 4, 44, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(834, 4, 118, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(835, 4, 119, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(836, 4, 120, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(837, 4, 121, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(838, 4, 122, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(839, 4, 123, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(840, 4, 124, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(841, 4, 206, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(842, 4, 207, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(843, 4, 208, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(844, 4, 209, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(845, 4, 210, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(846, 4, 211, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(847, 4, 212, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(848, 4, 213, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(849, 4, 214, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(850, 4, 215, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(851, 4, 216, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(852, 4, 217, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(853, 4, 218, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(854, 4, 219, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(855, 4, 220, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(856, 4, 14, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(857, 4, 15, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(858, 4, 16, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(859, 4, 17, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(860, 4, 18, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(861, 4, 19, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(862, 4, 1520, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(863, 4, 1521, 0, 0, 0, 0, 2, '2025-11-03 12:00:11'),
(864, 2, 53, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(865, 2, 54, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(866, 2, 55, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(867, 2, 56, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(868, 2, 57, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(869, 2, 58, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(870, 2, 59, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(871, 2, 60, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(872, 2, 61, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(873, 2, 62, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(874, 2, 63, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(875, 2, 64, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(876, 2, 65, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(877, 2, 66, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(878, 2, 67, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(879, 2, 221, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(880, 2, 222, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(881, 2, 223, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(882, 2, 1388, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(883, 2, 1522, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(884, 2, 1523, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(885, 2, 68, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(886, 2, 69, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(887, 2, 70, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(888, 2, 71, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(889, 2, 72, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(890, 2, 73, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(891, 2, 74, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(892, 2, 75, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(893, 2, 76, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(894, 2, 77, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(895, 2, 78, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(896, 2, 79, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(897, 2, 80, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(898, 2, 81, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(899, 2, 82, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(900, 2, 83, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(901, 2, 84, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(902, 2, 85, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(903, 2, 86, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(904, 2, 87, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(905, 2, 88, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(906, 2, 89, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(907, 2, 91, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(908, 2, 92, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(909, 2, 93, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(910, 2, 94, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(911, 2, 95, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(912, 2, 96, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(913, 2, 97, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(914, 2, 98, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(915, 2, 99, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(916, 2, 100, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(917, 2, 101, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(918, 2, 102, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(919, 2, 103, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(920, 2, 104, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(921, 2, 105, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(922, 2, 106, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(923, 2, 107, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(924, 2, 108, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(925, 2, 109, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(926, 2, 110, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(927, 2, 224, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(928, 2, 1, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(929, 2, 2, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(930, 2, 3, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(931, 2, 4, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(932, 2, 5, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(933, 2, 6, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(934, 2, 7, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(935, 2, 8, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(936, 2, 9, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(937, 2, 10, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(938, 2, 11, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(939, 2, 12, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(940, 2, 13, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(941, 2, 20, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(942, 2, 21, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(943, 2, 45, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(944, 2, 46, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(945, 2, 47, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(946, 2, 48, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(947, 2, 49, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(948, 2, 50, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(949, 2, 51, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(950, 2, 52, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(951, 2, 132, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(952, 2, 133, 1, 1, 1, 1, 2, '2025-11-08 09:48:44'),
(953, 2, 134, 1, 1, 1, 1, 2, '2025-11-08 09:48:44'),
(954, 2, 191, 1, 1, 1, 1, 2, '2025-11-08 09:48:44'),
(955, 2, 192, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(956, 2, 193, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(957, 2, 125, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(958, 2, 126, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(959, 2, 127, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(960, 2, 128, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(961, 2, 129, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(962, 2, 205, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(963, 2, 40, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(964, 2, 41, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(965, 2, 111, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(966, 2, 112, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(967, 2, 194, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(968, 2, 195, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(969, 2, 113, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(970, 2, 114, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(971, 2, 115, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(972, 2, 116, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(973, 2, 117, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(974, 2, 196, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(975, 2, 197, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(976, 2, 198, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(977, 2, 199, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(978, 2, 200, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(979, 2, 201, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(980, 2, 202, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(981, 2, 203, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(982, 2, 204, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(983, 2, 130, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(984, 2, 131, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(985, 2, 225, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(986, 2, 226, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(987, 2, 28, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(988, 2, 29, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(989, 2, 30, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(990, 2, 31, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(991, 2, 32, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(992, 2, 33, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(993, 2, 34, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(994, 2, 35, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(995, 2, 36, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(996, 2, 37, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(997, 2, 38, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(998, 2, 39, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(999, 2, 42, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1000, 2, 43, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1001, 2, 44, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1002, 2, 118, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1003, 2, 119, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1004, 2, 120, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1005, 2, 121, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1006, 2, 122, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1007, 2, 123, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1008, 2, 124, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1009, 2, 206, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1010, 2, 207, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1011, 2, 208, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1012, 2, 209, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1013, 2, 210, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1014, 2, 211, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1015, 2, 212, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1016, 2, 213, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1017, 2, 214, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1018, 2, 215, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1019, 2, 216, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1020, 2, 217, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1021, 2, 218, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1022, 2, 219, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1023, 2, 220, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1024, 2, 14, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1025, 2, 15, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1026, 2, 16, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1027, 2, 17, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1028, 2, 18, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1029, 2, 19, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1030, 2, 1520, 0, 0, 0, 0, 2, '2025-11-08 09:48:44'),
(1031, 2, 1521, 0, 0, 0, 0, 2, '2025-11-08 09:48:44');

-- --------------------------------------------------------

--
-- Table structure for table `sec_role_tbl`
--

CREATE TABLE `sec_role_tbl` (
  `role_id` int(11) NOT NULL,
  `role_name` text NOT NULL,
  `role_description` text NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `role_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sec_role_tbl`
--

INSERT INTO `sec_role_tbl` (`role_id`, `role_name`, `role_description`, `create_by`, `date_time`, `role_status`) VALUES
(1, 'kitchen', 'manage kitchen', 2, '2020-10-12 10:27:03', 1),
(2, 'Counter', 'Display Order timing', 2, '2020-10-12 10:27:45', 1),
(3, 'Waiter', 'Order Taken and served food', 2, '2020-10-12 10:29:13', 1),
(4, 'add', '', 2, '2025-11-03 12:00:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sec_user_access_tbl`
--

CREATE TABLE `sec_user_access_tbl` (
  `role_acc_id` int(11) NOT NULL,
  `fk_role_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sec_user_access_tbl`
--

INSERT INTO `sec_user_access_tbl` (`role_acc_id`, `fk_role_id`, `fk_user_id`) VALUES
(1, 3, 172),
(2, 4, 178),
(3, 2, 180);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `storename` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `logoweb` varchar(255) DEFAULT NULL,
  `favicon` varchar(100) DEFAULT NULL,
  `opentime` varchar(255) DEFAULT NULL,
  `closetime` varchar(255) DEFAULT NULL,
  `vat` decimal(10,2) NOT NULL DEFAULT 0.00,
  `isvatnumshow` int(11) DEFAULT 0,
  `vattinno` varchar(30) DEFAULT NULL,
  `isvatinclusive` int(11) NOT NULL DEFAULT 0,
  `discount_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=amount,1=percent',
  `discountrate` decimal(19,3) DEFAULT 0.000,
  `servicecharge` decimal(10,0) NOT NULL DEFAULT 0,
  `service_chargeType` int(11) NOT NULL DEFAULT 0 COMMENT '0=amount,1=percent',
  `currency` int(11) DEFAULT 0,
  `min_prepare_time` varchar(50) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `timezone` varchar(150) NOT NULL,
  `dateformat` text NOT NULL,
  `site_align` varchar(50) DEFAULT NULL,
  `kitchenrefreshtime` int(11) DEFAULT 5,
  `powerbytxt` text DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(50) DEFAULT NULL,
  `reservation_open` varchar(30) DEFAULT NULL,
  `reservation_close` varchar(30) DEFAULT NULL,
  `maxreserveperson` int(11) DEFAULT NULL,
  `printtype` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `title`, `storename`, `address`, `email`, `phone`, `logo`, `logoweb`, `favicon`, `opentime`, `closetime`, `vat`, `isvatnumshow`, `vattinno`, `isvatinclusive`, `discount_type`, `discountrate`, `servicecharge`, `service_chargeType`, `currency`, `min_prepare_time`, `language`, `timezone`, `dateformat`, `site_align`, `kitchenrefreshtime`, `powerbytxt`, `footer_text`, `whatsapp_number`, `reservation_open`, `reservation_close`, `maxreserveperson`, `printtype`) VALUES
(2, 'Bonresto Restaurant', 'Jaipure Restaurant', '98 Green Road, brazzaville, Dhaka-1215.', 'lmk@gmail.com', '050489037', 'assets/img/icons/2019-10-29/h.png', NULL, 'assets/img/icons/m.png', '08:00AM', '11:59PM', 7.50, NULL, '23457586', 1, 1, 5.000, 20, 1, 4, '1:00 Hour', 'english', 'Africa/Brazzaville', 'd/m/Y', 'LTR', 15, 'Powered By: BDTASK, www.bdtask.com\r\n', '2025', '242064663469', '09:00:00', '22:00:00', 20, 2);

-- --------------------------------------------------------

--
-- Table structure for table `shift_management`
--

CREATE TABLE `shift_management` (
  `id` int(11) NOT NULL,
  `shift_name` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method`
--

CREATE TABLE `shipping_method` (
  `ship_id` int(11) NOT NULL,
  `shipping_method` varchar(150) NOT NULL,
  `shippingrate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `shiptype` int(11) DEFAULT NULL COMMENT '1=dinein,2=pickup,3=home'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `shipping_method`
--

INSERT INTO `shipping_method` (`ship_id`, `shipping_method`, `shippingrate`, `payment_method`, `is_active`, `shiptype`) VALUES
(1, 'Home Delivary', 60.00, '9, 8, 5, 4, 3, 1', 1, 3),
(2, 'Pickup', 0.00, '4, 3, 1', 1, 2),
(3, 'Dine-in', 0.00, '9, 8, 5, 4, 3', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sms_configuration`
--

CREATE TABLE `sms_configuration` (
  `id` int(11) NOT NULL,
  `link` text NOT NULL,
  `gateway` varchar(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sms_from` varchar(200) NOT NULL,
  `userid` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sms_configuration`
--

INSERT INTO `sms_configuration` (`id`, `link`, `gateway`, `user_name`, `password`, `sms_from`, `userid`, `status`) VALUES
(1, 'http://smsrank.com/', 'SMS Rank', 'joeldy tsna', '1234', 'smsrank', '', 0),
(2, 'https://www.nexmo.com/', 'nexmo', '50489b88', 'z1cBmtrDeQrOaqhg', 'restaurant', '', 0),
(3, 'https://www.budgetsms.net/', 'budgetsms', 'user1', '1e753da74', 'budgetsms', '21547', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sms_template`
--

CREATE TABLE `sms_template` (
  `id` int(11) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `default_status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sms_template`
--

INSERT INTO `sms_template` (`id`, `template_name`, `message`, `type`, `status`, `default_status`, `created_at`, `updated_at`) VALUES
(1, 'one', 'your Order {id} is cancel for some reason.', 'Cancel', 0, 0, '2018-12-30 17:08:07', '0000-00-00 00:00:00'),
(2, 'two', 'your order {id} is completed', 'CompleteOrder', 0, 1, '2018-12-30 18:58:19', '0000-00-00 00:00:00'),
(3, 'three', 'your order {id} is processing', 'Processing', 0, 1, '2018-11-06 17:00:46', '0000-00-00 00:00:00'),
(8, 'four', 'Your Order Has been Placed Successfully.', 'Neworder', 1, 0, '2018-12-30 18:59:32', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `subscribe_emaillist`
--

CREATE TABLE `subscribe_emaillist` (
  `emailid` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dateinsert` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `subscribe_emaillist`
--

INSERT INTO `subscribe_emaillist` (`emailid`, `email`, `dateinsert`) VALUES
(1, 'joeldytsina94@gmail.com', '2025-11-01 04:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `sub_order`
--

CREATE TABLE `sub_order` (
  `sub_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `vat` float DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `s_charge` float DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=unpaid,1=paid',
  `order_menu_id` text DEFAULT NULL,
  `adons_id` varchar(20) DEFAULT NULL,
  `adons_qty` varchar(20) DEFAULT NULL,
  `invoiceprint` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sub_order`
--

INSERT INTO `sub_order` (`sub_id`, `order_id`, `customer_id`, `vat`, `discount`, `s_charge`, `total_price`, `status`, `order_menu_id`, `adons_id`, `adons_qty`, `invoiceprint`) VALUES
(1, 27, NULL, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(2, 27, NULL, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(3, 42, NULL, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(4, 42, NULL, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(5, 42, NULL, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(6, 42, NULL, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(7, 42, NULL, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(8, 46, NULL, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(9, 46, NULL, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supid` int(11) NOT NULL,
  `suplier_code` varchar(255) NOT NULL,
  `supName` varchar(100) NOT NULL,
  `supEmail` varchar(100) NOT NULL,
  `supMobile` varchar(50) NOT NULL,
  `supAddress` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supid`, `suplier_code`, `supName`, `supEmail`, `supMobile`, `supAddress`) VALUES
(1, 'sup_002', 'Kabalan', 'Kabalan@gmail.com', '065678909', 'Congo Brazzaville, centre ville'),
(2, 'sup_003', 'Super market', 'supermarket@gmail.com', '064663463', 'centre ville, bzv');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_ledger`
--

CREATE TABLE `supplier_ledger` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `supplier_id` bigint(20) DEFAULT NULL,
  `chalan_no` varchar(100) DEFAULT NULL,
  `deposit_no` varchar(50) DEFAULT NULL,
  `amount` decimal(19,3) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `cheque_no` varchar(255) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `d_c` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `supplier_ledger`
--

INSERT INTO `supplier_ledger` (`id`, `transaction_id`, `supplier_id`, `chalan_no`, `deposit_no`, `amount`, `description`, `payment_type`, `cheque_no`, `date`, `status`, `d_c`) VALUES
(1, 'sup_002', 1, 'Adjustment ', NULL, 1000000.000, 'Previous adjustment with software', 'NA', 'NA', '2025-11-03', 1, 'c'),
(2, 'PM-1', 1, NULL, 'PM-1', 2333.000, 'Paid to Kabalan', '1', '', '2025-11-03', 1, 'd'),
(3, '2', 1, '2', NULL, 144.000, '', NULL, NULL, '2025-11-03', 1, 'c'),
(4, '2', 1, '2', NULL, 4000.000, 'Purchase From Supplier. ', NULL, NULL, '2025-11-03', 1, 'd'),
(5, 'sup_003', 2, 'Adjustment ', NULL, 100000.000, 'Previous adjustment with software', 'NA', 'NA', '2025-11-07', 1, 'c');

-- --------------------------------------------------------

--
-- Table structure for table `synchronizer_setting`
--

CREATE TABLE `synchronizer_setting` (
  `id` int(11) NOT NULL,
  `hostname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `port` varchar(10) NOT NULL,
  `debug` varchar(10) NOT NULL,
  `project_root` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `synchronizer_setting`
--

INSERT INTO `synchronizer_setting` (`id`, `hostname`, `username`, `password`, `port`, `debug`, `project_root`) VALUES
(8, '70.35.198.244', 'softest3bdtask', 'Ux5O~MBJ#odK', '21', 'true', './public_html/');

-- --------------------------------------------------------

--
-- Table structure for table `tablelist`
--

CREATE TABLE `tablelist` (
  `tableid` int(11) NOT NULL,
  `tablename` varchar(50) NOT NULL,
  `capacity` int(11) DEFAULT 0,
  `qr_code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_details`
--

CREATE TABLE `table_details` (
  `id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `time_enter` time NOT NULL,
  `total_people` int(11) NOT NULL,
  `delete_at` int(11) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `table_details`
--

INSERT INTO `table_details` (`id`, `table_id`, `customer_id`, `order_id`, `time_enter`, `total_people`, `delete_at`, `created_at`) VALUES
(3, 3, 1, 16, '18:04:42', 2, 0, '2025-11-01'),
(4, 2, 1, 17, '18:05:25', 4, 0, '2025-11-01'),
(5, 7, 1, 18, '18:05:45', 8, 0, '2025-11-01'),
(6, 9, 1, 19, '18:07:03', 3, 0, '2025-11-01'),
(8, 10, 1, 23, '18:11:10', 8, 0, '2025-11-01'),
(9, 1, 1, 24, '18:11:37', 2, 0, '2025-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `table_setting`
--

CREATE TABLE `table_setting` (
  `settingid` int(11) NOT NULL,
  `tableid` int(11) NOT NULL,
  `iconpos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `table_setting`
--

INSERT INTO `table_setting` (`settingid`, `tableid`, `iconpos`) VALUES
(1, 2, 'position: relative; left: 186px; top: 231px;'),
(2, 4, 'position: relative; left: 87px; top: 17px;'),
(3, 3, 'position: relative; left: -126px; top: 129px;'),
(4, 1, 'position: relative; left: 15px; top: 28px;'),
(5, 8, 'position: relative; left: -336px; top: 224px;'),
(6, 6, 'position: relative; left: -184px; top: 113px;'),
(7, 5, 'position: relative; left: -153px; top: 85px;'),
(8, 7, 'position: relative; left: -372px; top: 223px;'),
(9, 9, 'position: relative; left: -744px; top: 14px;'),
(10, 10, 'position: relative; left: -448px; top: 226px;'),
(11, 11, ''),
(12, 12, '');

-- --------------------------------------------------------

--
-- Table structure for table `tax_settings`
--

CREATE TABLE `tax_settings` (
  `id` int(11) NOT NULL,
  `taxname` varchar(100) NOT NULL,
  `rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblreservation`
--

CREATE TABLE `tblreservation` (
  `reserveid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `tableid` int(11) NOT NULL,
  `person_capicity` int(11) NOT NULL,
  `formtime` time NOT NULL,
  `totime` time NOT NULL,
  `reserveday` date NOT NULL,
  `customer_notes` text DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1=free,2=booked',
  `notif` int(11) NOT NULL DEFAULT 0 COMMENT '0=unseen,1=seen'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tblreservation`
--

INSERT INTO `tblreservation` (`reserveid`, `cid`, `tableid`, `person_capicity`, `formtime`, `totime`, `reserveday`, `customer_notes`, `status`, `notif`) VALUES
(1, 54, 3, 2, '21:10:00', '21:40:00', '2025-11-01', '', 2, 1),
(2, 58, 0, 3, '15:10:00', '15:40:00', '2025-11-01', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblserver`
--

CREATE TABLE `tblserver` (
  `serverid` int(11) NOT NULL,
  `localhost_url` varchar(255) NOT NULL,
  `online_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblserver`
--

INSERT INTO `tblserver` (`serverid`, `localhost_url`, `online_url`) VALUES
(1, 'http://localhost/restaurant_v2', 'http://soft14.bdtask.com/restaurant_v2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assign_kitchen`
--

CREATE TABLE `tbl_assign_kitchen` (
  `assignid` int(11) NOT NULL,
  `kitchen_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_assign_kitchen`
--

INSERT INTO `tbl_assign_kitchen` (`assignid`, `kitchen_id`, `userid`) VALUES
(2, 1, 177);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank`
--

CREATE TABLE `tbl_bank` (
  `bankid` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `ac_name` varchar(200) DEFAULT NULL,
  `ac_number` varchar(200) DEFAULT NULL,
  `branch` varchar(200) DEFAULT NULL,
  `signature_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_bank`
--

INSERT INTO `tbl_bank` (`bankid`, `bank_name`, `ac_name`, `ac_number`, `branch`, `signature_pic`) VALUES
(1, 'Dutch-Bangla Bank', 'Ainal Haque', '110535764655', 'Mirpur 10', './application/modules/hrm/assets/images/2020-01-18/c.jpg'),
(2, 'City Bank', 'Kamal Hassan', '3869583', 'Uttara', './application/modules/hrm/assets/images/2020-01-18/e.jpg'),
(3, 'Brac Bank', 'Robiul Islam', '9356346', 'Motijeel', './application/modules/hrm/assets/images/2020-01-18/f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_billingaddress`
--

CREATE TABLE `tbl_billingaddress` (
  `billaddressid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `companyname` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `city` varchar(70) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `DateInserted` datetime NOT NULL DEFAULT '1970-01-01 01:01:01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_billingaddress`
--

INSERT INTO `tbl_billingaddress` (`billaddressid`, `orderid`, `firstname`, `lastname`, `companyname`, `email`, `phone`, `city`, `district`, `country`, `zip`, `address`, `address2`, `DateInserted`) VALUES
(1, 1, 'simon', 'simon', 'Not Set', '', '064663469', '', '', '', '', 'Not Set', NULL, '2025-10-31 10:05:29'),
(2, 2, 'Simon Joeldy', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', '', 'Nagaland', 'India', '', 'Congo Brazzaville', NULL, '2025-10-31 12:18:17'),
(3, 3, 'Simon Joeldy', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', '', 'Barishal', 'Bangladesh', '', 'Congo Brazzaville', NULL, '2025-10-31 22:03:33'),
(4, 4, 'Simon Joeldy', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', '', 'Barishal', 'Bangladesh', '', 'Congo Brazzaville', NULL, '2025-10-31 22:09:05'),
(5, 6, 'joeldy tsna', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', '', 'Nagaland', 'India', '', 'Congo Brazzaville', NULL, '2025-11-01 03:02:36'),
(6, 7, 'Joeldy', 'Tsina', NULL, 'joeldytsina94@gmail.com', '050489037', '', 'Nagaland', 'India', '', 'Avenue ngamaba', NULL, '2025-11-01 04:37:12'),
(7, 8, 'simon', 'simon', 'Not Set', '', '06739988747', '', '', '', '', 'Not Set', NULL, '2025-11-01 12:37:56'),
(8, 9, 'clavina', 'clavina', 'Not Set', '', '06739988747', '', '', '', '', 'Not Set', NULL, '2025-11-01 12:45:24'),
(9, 10, 'clavina', 'clavina', 'Not Set', '', '06739988747', '', '', '', '', 'Not Set', NULL, '2025-11-01 12:46:28'),
(10, 32, 'hemercia', 'hemercia', 'Not Set', '', '045467893', '', '', '', '', 'Not Set', NULL, '2025-11-02 12:39:10'),
(11, 33, 'test@gmail', 'test@gmail', 'Not Set', '', 'testpghone', '', '', '', '', 'Not Set', NULL, '2025-11-03 01:10:06'),
(12, 35, 'Simon Joeldy', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', 'Brazzaville', 'Brazzaville', 'Congo Brazzaville', '', 'Congo Brazzaville', NULL, '2025-11-07 21:46:52'),
(13, 36, 'Simon Joeldy', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', '', 'Brazzaville', 'Congo Brazzaville', '', 'Congo Brazzaville', NULL, '2025-11-07 21:49:15'),
(14, 39, 'etstqr', 'etstqr', 'Not Set', '', '0977376733', '', '', '', '', 'Not Set', NULL, '2025-11-08 21:51:39'),
(15, 40, 'simonnn', 'simonnn', 'Not Set', '', '0645565372', '', '', '', '', 'Not Set', NULL, '2025-11-08 21:56:54'),
(16, 41, 'joeldy qr', 'joeldy qr', 'Not Set', '', '088973824863', '', '', '', '', 'Not Set', NULL, '2025-11-08 22:39:48'),
(17, 42, 'joeldy simon pierre', 'joeldy simon pierre', 'Not Set', '', '048329756\"&', '', '', '', '', 'Not Set', NULL, '2025-11-08 22:41:31'),
(18, 43, 'joeldy simon pierre', 'joeldy simon pierre', 'Not Set', '', '234324524', '', '', '', '', 'Not Set', NULL, '2025-11-08 23:10:59'),
(19, 44, 'simon', 'simon', 'Not Set', '', '1324', '', '', '', '', 'Not Set', NULL, '2025-11-08 23:17:09'),
(20, 65, 'tes', 'tes', 'Not Set', '', '0988787287392', '', '', '', '', 'Not Set', NULL, '2025-11-12 01:00:16'),
(21, 66, 'Joeldy', 'tes', NULL, 'joeldytsina94@gmail.com', '0988787287392', 'Brazzaville', 'Brazzaville', 'Congo Brazzaville', '', 'Not Set', NULL, '2025-11-12 01:01:48'),
(22, 67, 'tes', 'tes', NULL, 'tes@gmail.com', '0988787287392', 'Brazzaville', 'Brazzaville', 'Congo Brazzaville', '', 'Not Set', NULL, '2025-11-12 01:04:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cancelitem`
--

CREATE TABLE `tbl_cancelitem` (
  `cancelid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `foodid` int(11) NOT NULL,
  `varientid` int(11) NOT NULL,
  `quantity` decimal(19,3) NOT NULL DEFAULT 0.000
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_cancelitem`
--

INSERT INTO `tbl_cancelitem` (`cancelid`, `orderid`, `foodid`, `varientid`, `quantity`) VALUES
(1, 28, 56, 86, 1.000),
(2, 25, 12, 96, 1.000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_card_terminal`
--

CREATE TABLE `tbl_card_terminal` (
  `card_terminalid` int(11) NOT NULL,
  `terminal_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_card_terminal`
--

INSERT INTO `tbl_card_terminal` (`card_terminalid`, `terminal_name`) VALUES
(1, 'Nexus Terminal'),
(2, 'Brac Bank Terminal'),
(3, 'Visa-Master Terminal');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashcounter`
--

CREATE TABLE `tbl_cashcounter` (
  `ccid` int(11) NOT NULL,
  `counterno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_cashcounter`
--

INSERT INTO `tbl_cashcounter` (`ccid`, `counterno`) VALUES
(1, 1),
(2, 2),
(6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashregister`
--

CREATE TABLE `tbl_cashregister` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `counter_no` int(11) NOT NULL,
  `opening_balance` decimal(19,3) NOT NULL DEFAULT 0.000,
  `closing_balance` decimal(19,3) NOT NULL DEFAULT 0.000,
  `openclosedate` date NOT NULL,
  `opendate` datetime DEFAULT '1970-01-01 01:01:01',
  `closedate` datetime DEFAULT '1970-01-01 01:01:01',
  `status` int(11) NOT NULL DEFAULT 0,
  `openingnote` text DEFAULT NULL,
  `closing_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_cashregister`
--

INSERT INTO `tbl_cashregister` (`id`, `userid`, `counter_no`, `opening_balance`, `closing_balance`, `openclosedate`, `opendate`, `closedate`, `status`, `openingnote`, `closing_note`) VALUES
(1, 2, 2, 12000.000, 22562.575, '2025-10-30', '2025-10-30 22:14:54', '2025-11-01 22:57:13', 1, '', ''),
(2, 2, 2, 22562.575, 30058.455, '2025-11-01', '2025-11-01 23:10:32', '2025-11-12 00:20:12', 1, '', ''),
(3, 2, 3, 300589.000, 0.000, '2025-11-12', '2025-11-12 00:21:43', '1970-01-01 00:00:00', 0, 'for test purpose.', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `cityid` int(11) NOT NULL,
  `countryid` int(11) NOT NULL,
  `stateid` int(11) NOT NULL,
  `cityname` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`cityid`, `countryid`, `stateid`, `cityname`, `status`) VALUES
(3, 1, 12, 'Savar', 1),
(4, 1, 12, 'Gajipur', 1),
(5, 1, 12, 'Mirpur', 1),
(6, 6, 32, 'Owando', 1),
(7, 6, 32, 'oyo', 1),
(8, 6, 32, 'Ewo', 1),
(9, 6, 33, 'Dolisie', 1),
(10, 6, 33, 'Nkayi', 1),
(11, 6, 33, 'Pointe-Noire', 1),
(12, 6, 32, 'Brazzaville', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_country`
--

CREATE TABLE `tbl_country` (
  `countryid` int(11) NOT NULL,
  `countryname` varchar(70) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_country`
--

INSERT INTO `tbl_country` (`countryid`, `countryname`, `status`) VALUES
(1, 'Bangladesh', 1),
(2, 'United State', 1),
(3, 'United Kingdom', 1),
(4, 'India', 1),
(5, 'Vietnam', 1),
(6, 'Congo Brazzaville', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customerpoint`
--

CREATE TABLE `tbl_customerpoint` (
  `id` int(11) NOT NULL,
  `customerid` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `points` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customerpoint`
--

INSERT INTO `tbl_customerpoint` (`id`, `customerid`, `amount`, `points`, `created_at`) VALUES
(1, 71, 0.00, 10, '2025-11-11 22:42:40'),
(2, 36, 0.00, 10, '2025-11-11 22:45:15'),
(3, 55, 0.00, 10, '2025-11-11 22:50:14'),
(4, 54, 0.00, 10, '2025-11-11 23:16:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivaritime`
--

CREATE TABLE `tbl_delivaritime` (
  `dtimeid` int(11) NOT NULL,
  `deltime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_delivaritime`
--

INSERT INTO `tbl_delivaritime` (`dtimeid`, `deltime`) VALUES
(1, '10:00-10:30'),
(2, '10:30-11:00'),
(3, '11:00-11:30'),
(4, '11:30-12:00'),
(5, '12:00-12:30'),
(6, '12:30-13:00'),
(7, '13:00-13:30'),
(8, '13:30-14:00'),
(9, '14:00-14:30'),
(10, '14:30-15:00'),
(11, '15:00-15:30'),
(12, '15:30-16:00'),
(13, '16:00-16:30'),
(14, '16:30-17:00'),
(15, '17:00-17:30'),
(16, '17:30-18:00'),
(17, '18:00-18:30'),
(18, '18:30-19:00'),
(19, '19:00-19:30'),
(20, '19:30-20:00'),
(21, '20:00-20:30'),
(22, '20:30-21:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivaryaddress`
--

CREATE TABLE `tbl_delivaryaddress` (
  `delivaryid` int(11) NOT NULL,
  `deladdress` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_delivaryaddress`
--

INSERT INTO `tbl_delivaryaddress` (`delivaryid`, `deladdress`) VALUES
(1, 'Uttara,Road#7,Dhaka-Bangladesh.'),
(2, 'Uttara,Road#5,Dhaka'),
(3, 'Uttara,Road#2,Dhaka'),
(4, 'Uttara,Road#4,Dhaka'),
(5, 'Gulsion Circle,Dhaka-Bangladesh'),
(6, 'Banani, Dhaka-Bangladesh'),
(7, 'Dhanmondi,Road#15 Dhaka-Bangladesh'),
(8, 'Dhanmondi,Road#27 Dhaka-Bangladesh'),
(9, 'Elephantroad, Dhaka-Bangladesh'),
(10, 'Badda,Road#15 Dhaka-Bangladesh'),
(11, 'Rampura,Road#15 Dhaka-Bangladesh'),
(12, 'Khilkhet,Road#15 Dhaka-Bangladesh'),
(13, 'Mohammadpur,Road#15 Dhaka-Bangladesh'),
(14, 'Motijeel,Road#15 Dhaka-Bangladesh'),
(15, 'komlapur,Road#15 Dhaka-Bangladesh'),
(16, 'Newmarket,Road#15 Rajshahi-Bangladesh'),
(17, 'Road#15, Khulna-Bangladesh'),
(18, 'Road#15, Chittagong-Bangladesh'),
(19, 'Agrabad, Chittagong-Bangladesh'),
(20, 'Potengha, Chittagong-Bangladesh'),
(21, 'Kadirgonj,Rail Gate,Nogor Bhabon, Rajshahi.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_generatedreport`
--

CREATE TABLE `tbl_generatedreport` (
  `generateid` int(11) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `saleinvoice` varchar(100) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `cutomertype` int(11) NOT NULL,
  `isthirdparty` int(11) NOT NULL DEFAULT 0,
  `waiter_id` int(11) DEFAULT NULL,
  `kitchen` int(11) DEFAULT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `table_no` int(11) DEFAULT NULL,
  `tokenno` varchar(30) DEFAULT NULL,
  `totalamount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `customerpaid` decimal(10,2) DEFAULT 0.00,
  `customer_note` text DEFAULT NULL,
  `anyreason` text DEFAULT NULL,
  `order_status` tinyint(4) NOT NULL,
  `nofification` int(11) NOT NULL,
  `orderacceptreject` int(11) DEFAULT NULL,
  `reportDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_groupitems`
--

CREATE TABLE `tbl_groupitems` (
  `groupid` int(11) NOT NULL,
  `gitemid` int(11) NOT NULL,
  `items` int(11) NOT NULL,
  `item_qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `varientid` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_groupitems`
--

INSERT INTO `tbl_groupitems` (`groupid`, `gitemid`, `items`, `item_qty`, `varientid`, `status`) VALUES
(1, 81, 57, 1.00, 85, 1),
(2, 81, 3, 1.00, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itemaccepted`
--

CREATE TABLE `tbl_itemaccepted` (
  `acid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `menuid` int(11) NOT NULL,
  `varient` int(11) NOT NULL,
  `accepttime` datetime NOT NULL DEFAULT '1970-01-01 01:01:01'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_itemaccepted`
--

INSERT INTO `tbl_itemaccepted` (`acid`, `orderid`, `menuid`, `varient`, `accepttime`) VALUES
(1, 1, 1, 0, '2025-10-31 10:10:48'),
(2, 1, 0, 0, '2025-10-31 10:11:20'),
(3, 2, 1, 0, '2025-10-31 22:49:07'),
(4, 2, 1, 1, '2025-10-31 22:49:07'),
(5, 2, 0, 0, '2025-10-31 22:49:07'),
(6, 3, 2, 3, '2025-10-31 23:22:50'),
(7, 4, 1, 1, '2025-10-31 23:23:17'),
(8, 5, 1, 1, '2025-10-31 23:23:24'),
(9, 2, 10, 0, '2025-10-31 23:27:31'),
(10, 5, 3, 4, '2025-10-31 23:27:35'),
(11, 2, 0, 0, '2025-10-31 23:29:48'),
(12, 6, 1, 1, '2025-11-01 03:19:18'),
(13, 6, 0, 0, '2025-11-01 03:19:18'),
(14, 7, 3, 4, '2025-11-01 12:23:04'),
(15, 7, 0, 0, '2025-11-01 12:23:04'),
(16, 8, 1, 1, '2025-11-01 12:47:04'),
(17, 8, 2, 3, '2025-11-01 12:47:04'),
(18, 8, 0, 0, '2025-11-01 12:47:04'),
(19, 9, 80, 62, '2025-11-01 12:47:05'),
(20, 9, 67, 75, '2025-11-01 12:47:05'),
(21, 9, 66, 76, '2025-11-01 12:47:05'),
(22, 9, 63, 79, '2025-11-01 12:47:05'),
(23, 9, 0, 0, '2025-11-01 12:47:05'),
(24, 10, 64, 78, '2025-11-01 12:47:06'),
(25, 10, 63, 79, '2025-11-01 12:47:06'),
(26, 10, 63, 80, '2025-11-01 12:47:06'),
(27, 10, 62, 81, '2025-11-01 12:47:06'),
(28, 10, 0, 0, '2025-11-01 12:47:06'),
(29, 9, 78, 64, '2025-11-01 12:47:12'),
(30, 9, 0, 0, '2025-11-01 12:47:12'),
(31, 8, 70, 72, '2025-11-01 12:47:14'),
(32, 8, 0, 0, '2025-11-01 12:47:14'),
(33, 9, 75, 67, '2025-11-01 12:47:15'),
(34, 9, 0, 0, '2025-11-01 12:47:15'),
(35, 12, 2, 3, '2025-11-01 13:25:30'),
(36, 12, 0, 0, '2025-11-01 13:25:30'),
(37, 11, 1, 1, '2025-11-01 13:25:30'),
(38, 11, 0, 0, '2025-11-01 13:25:30'),
(39, 11, 3, 4, '2025-11-01 13:25:37'),
(40, 11, 6, 55, '2025-11-01 13:25:37'),
(41, 11, 0, 0, '2025-11-01 13:25:37'),
(42, 12, 53, 89, '2025-11-01 13:25:38'),
(43, 12, 0, 0, '2025-11-01 13:25:38'),
(44, 15, 11, 61, '2025-11-01 13:38:44'),
(45, 15, 0, 0, '2025-11-01 13:38:44'),
(46, 14, 49, 53, '2025-11-01 13:38:45'),
(47, 14, 0, 0, '2025-11-01 13:38:45'),
(48, 13, 12, 96, '2025-11-01 13:38:46'),
(49, 13, 13, 95, '2025-11-01 13:38:46'),
(50, 13, 53, 89, '2025-11-01 13:38:46'),
(51, 13, 0, 0, '2025-11-01 13:38:46'),
(52, 23, 2, 3, '2025-11-01 22:39:24'),
(53, 23, 0, 0, '2025-11-01 22:39:24'),
(54, 16, 2, 3, '2025-11-01 22:39:25'),
(55, 16, 0, 0, '2025-11-01 22:39:25'),
(56, 24, 2, 3, '2025-11-01 22:39:27'),
(57, 24, 0, 0, '2025-11-01 22:39:27'),
(58, 26, 1, 1, '2025-11-01 22:39:31'),
(59, 26, 0, 0, '2025-11-01 22:39:31'),
(60, 27, 49, 53, '2025-11-01 22:39:48'),
(61, 27, 13, 95, '2025-11-01 22:39:48'),
(62, 27, 0, 0, '2025-11-01 22:39:48'),
(63, 28, 56, 86, '2025-11-01 22:39:49'),
(64, 28, 0, 0, '2025-11-01 22:39:49'),
(65, 26, 6, 55, '2025-11-01 22:39:51'),
(66, 26, 0, 0, '2025-11-01 22:39:51'),
(67, 25, 54, 88, '2025-11-01 22:39:52'),
(68, 25, 0, 0, '2025-11-01 22:39:52'),
(69, 17, 6, 55, '2025-11-01 22:39:56'),
(70, 17, 0, 0, '2025-11-01 22:39:56'),
(71, 18, 10, 60, '2025-11-01 22:39:57'),
(72, 18, 0, 0, '2025-11-01 22:39:57'),
(73, 19, 11, 61, '2025-11-01 22:39:59'),
(74, 19, 0, 0, '2025-11-01 22:39:59'),
(75, 20, 12, 96, '2025-11-01 22:40:06'),
(76, 20, 0, 0, '2025-11-01 22:40:06'),
(77, 32, 14, 94, '2025-11-02 12:45:29'),
(78, 32, 13, 95, '2025-11-02 12:45:29'),
(79, 32, 10, 60, '2025-11-02 12:45:29'),
(80, 32, 0, 0, '2025-11-02 12:45:29'),
(81, 33, 1, 1, '2025-11-03 20:47:14'),
(82, 33, 2, 3, '2025-11-03 20:47:14'),
(83, 33, 80, 62, '2025-11-03 20:47:14'),
(84, 33, 0, 0, '2025-11-03 20:47:14'),
(85, 34, 6, 55, '2025-11-03 21:36:49'),
(86, 34, 0, 0, '2025-11-03 21:36:49'),
(87, 35, 14, 94, '2025-11-07 22:01:38'),
(88, 35, 0, 0, '2025-11-07 22:01:38'),
(89, 36, 2, 3, '2025-11-07 22:01:40'),
(90, 36, 0, 0, '2025-11-07 22:01:40'),
(91, 38, 1, 1, '2025-11-08 22:05:35'),
(92, 38, 0, 0, '2025-11-08 22:05:35'),
(93, 39, 80, 62, '2025-11-08 22:05:37'),
(94, 39, 0, 0, '2025-11-08 22:05:37'),
(95, 37, 1, 1, '2025-11-08 22:05:41'),
(96, 37, 2, 3, '2025-11-08 22:05:41'),
(97, 37, 0, 0, '2025-11-08 22:05:41'),
(98, 40, 67, 75, '2025-11-08 22:05:45'),
(99, 40, 66, 76, '2025-11-08 22:05:45'),
(100, 40, 0, 0, '2025-11-08 22:05:45'),
(101, 39, 78, 64, '2025-11-08 22:05:50'),
(102, 39, 0, 0, '2025-11-08 22:05:50'),
(103, 41, 67, 75, '2025-11-08 22:42:47'),
(104, 41, 66, 76, '2025-11-08 22:42:47'),
(105, 41, 65, 77, '2025-11-08 22:42:47'),
(106, 41, 64, 78, '2025-11-08 22:42:47'),
(107, 41, 68, 74, '2025-11-08 22:42:47'),
(108, 41, 0, 0, '2025-11-08 22:42:47'),
(109, 42, 1, 1, '2025-11-08 22:42:49'),
(110, 42, 2, 3, '2025-11-08 22:42:49'),
(111, 42, 0, 0, '2025-11-08 22:42:49'),
(112, 45, 1, 1, '2025-11-09 00:55:08'),
(113, 45, 0, 0, '2025-11-09 00:55:08'),
(114, 46, 6, 55, '2025-11-09 05:20:14'),
(115, 46, 0, 0, '2025-11-09 05:20:14'),
(116, 46, 7, 56, '2025-11-09 05:20:17'),
(117, 46, 0, 0, '2025-11-09 05:20:17'),
(118, 47, 51, 91, '2025-11-09 05:21:24'),
(119, 47, 0, 0, '2025-11-09 05:21:24'),
(120, 47, 53, 89, '2025-11-09 05:21:27'),
(121, 47, 52, 90, '2025-11-09 05:21:27'),
(122, 47, 0, 0, '2025-11-09 05:21:27'),
(123, 49, 3, 4, '2025-11-12 00:03:05'),
(124, 49, 0, 0, '2025-11-12 00:03:05'),
(125, 50, 1, 1, '2025-11-12 00:04:40'),
(126, 50, 0, 0, '2025-11-12 00:04:40'),
(127, 64, 2, 3, '2025-11-12 01:11:51'),
(128, 64, 0, 0, '2025-11-12 01:11:51'),
(129, 60, 80, 62, '2025-11-12 01:11:53'),
(130, 60, 0, 0, '2025-11-12 01:11:53'),
(131, 51, 1, 1, '2025-11-12 01:11:56'),
(132, 51, 2, 3, '2025-11-12 01:11:56'),
(133, 51, 0, 0, '2025-11-12 01:11:56'),
(134, 57, 76, 66, '2025-11-12 01:11:57'),
(135, 57, 0, 0, '2025-11-12 01:11:57'),
(136, 53, 1, 1, '2025-11-12 01:11:58'),
(137, 53, 0, 0, '2025-11-12 01:11:58'),
(138, 55, 63, 79, '2025-11-12 01:12:00'),
(139, 55, 61, 57, '2025-11-12 01:12:00'),
(140, 55, 0, 0, '2025-11-12 01:12:00'),
(141, 56, 69, 73, '2025-11-12 01:12:01'),
(142, 56, 71, 71, '2025-11-12 01:12:01'),
(143, 56, 68, 74, '2025-11-12 01:12:01'),
(144, 56, 64, 78, '2025-11-12 01:12:01'),
(145, 56, 0, 0, '2025-11-12 01:12:01'),
(146, 62, 1, 1, '2025-11-12 01:12:03'),
(147, 62, 0, 0, '2025-11-12 01:12:03'),
(148, 61, 2, 3, '2025-11-12 01:12:07'),
(149, 61, 0, 0, '2025-11-12 01:12:07'),
(150, 54, 9, 59, '2025-11-12 01:12:13'),
(151, 54, 0, 0, '2025-11-12 01:12:13'),
(152, 56, 74, 68, '2025-11-12 01:12:14'),
(153, 56, 72, 70, '2025-11-12 01:12:14'),
(154, 56, 0, 0, '2025-11-12 01:12:14'),
(155, 58, 74, 68, '2025-11-12 01:12:15'),
(156, 58, 0, 0, '2025-11-12 01:12:15'),
(157, 68, 9, 59, '2025-11-12 01:12:16'),
(158, 68, 0, 0, '2025-11-12 01:12:16'),
(159, 56, 73, 69, '2025-11-12 01:12:24'),
(160, 56, 0, 0, '2025-11-12 01:12:24'),
(161, 58, 73, 69, '2025-11-12 01:12:25'),
(162, 58, 0, 0, '2025-11-12 01:12:25'),
(163, 63, 7, 56, '2025-11-12 01:12:26'),
(164, 63, 0, 0, '2025-11-12 01:12:26'),
(165, 66, 7, 56, '2025-11-12 01:12:27'),
(166, 66, 0, 0, '2025-11-12 01:12:27'),
(167, 67, 7, 56, '2025-11-12 01:12:29'),
(168, 67, 0, 0, '2025-11-12 01:12:29'),
(169, 52, 12, 96, '2025-11-12 01:12:34'),
(170, 52, 0, 0, '2025-11-12 01:12:34'),
(171, 57, 77, 65, '2025-11-12 01:12:37'),
(172, 57, 0, 0, '2025-11-12 01:12:37'),
(173, 53, 11, 61, '2025-11-12 01:12:43'),
(174, 53, 14, 94, '2025-11-12 01:12:43'),
(175, 53, 13, 95, '2025-11-12 01:12:43'),
(176, 53, 49, 53, '2025-11-12 01:12:43'),
(177, 53, 0, 0, '2025-11-12 01:12:43'),
(178, 66, 6, 55, '2025-11-12 01:12:46'),
(179, 66, 0, 0, '2025-11-12 01:12:46'),
(180, 60, 57, 85, '2025-11-12 01:12:47'),
(181, 60, 3, 4, '2025-11-12 01:12:47'),
(182, 60, 0, 0, '2025-11-12 01:12:47'),
(183, 68, 10, 60, '2025-11-12 01:12:51'),
(184, 68, 0, 0, '2025-11-12 01:12:51'),
(185, 58, 75, 67, '2025-11-12 01:12:53'),
(186, 58, 0, 0, '2025-11-12 01:12:53'),
(187, 54, 13, 95, '2025-11-12 01:13:05'),
(188, 54, 0, 0, '2025-11-12 01:13:05'),
(189, 56, 70, 72, '2025-11-12 01:13:06'),
(190, 56, 75, 67, '2025-11-12 01:13:06'),
(191, 56, 0, 0, '2025-11-12 01:13:06'),
(192, 59, 77, 65, '2025-11-12 01:13:08'),
(193, 59, 0, 0, '2025-11-12 01:13:08'),
(194, 52, 8, 54, '2025-11-12 01:13:16'),
(195, 52, 0, 0, '2025-11-12 01:13:16'),
(196, 63, 8, 54, '2025-11-12 01:13:17'),
(197, 63, 0, 0, '2025-11-12 01:13:17'),
(198, 66, 8, 54, '2025-11-12 01:13:18'),
(199, 66, 0, 0, '2025-11-12 01:13:18'),
(200, 67, 8, 54, '2025-11-12 01:13:19'),
(201, 67, 0, 0, '2025-11-12 01:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kitchen`
--

CREATE TABLE `tbl_kitchen` (
  `kitchenid` int(11) NOT NULL,
  `kitchen_name` varchar(100) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `port` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_kitchen`
--

INSERT INTO `tbl_kitchen` (`kitchenid`, `kitchen_name`, `ip`, `port`, `status`) VALUES
(1, 'Common Kitchen', '192.168.1.87', '9100', 1),
(11, 'Italian', NULL, NULL, 1),
(12, 'Dessert', NULL, NULL, 1),
(13, 'Soup', NULL, NULL, 1),
(14, 'Fast Food', NULL, NULL, 1),
(15, 'Juice', NULL, NULL, 1),
(16, 'Kabab', NULL, NULL, 1),
(19, 'Water', NULL, NULL, 1),
(28, 'Congolese', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kitchen_order`
--

CREATE TABLE `tbl_kitchen_order` (
  `ktid` int(11) NOT NULL,
  `kitchenid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `varient` int(11) DEFAULT NULL,
  `addonsuid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_kitchen_order`
--

INSERT INTO `tbl_kitchen_order` (`ktid`, `kitchenid`, `orderid`, `itemid`, `varient`, `addonsuid`) VALUES
(1, 1, 1, 1, 0, NULL),
(2, 1, 1, 0, 0, NULL),
(3, 1, 2, 1, 0, NULL),
(4, 1, 2, 1, 1, NULL),
(5, 1, 2, 0, 0, NULL),
(6, 1, 3, 2, 3, NULL),
(7, 1, 4, 1, 1, NULL),
(8, 1, 5, 1, 1, NULL),
(9, 11, 2, 10, 0, NULL),
(10, 11, 5, 3, 4, NULL),
(11, 11, 2, 0, 0, NULL),
(12, 1, 6, 1, 1, NULL),
(13, 1, 6, 0, 0, NULL),
(14, 11, 7, 3, 4, NULL),
(15, 11, 7, 0, 0, NULL),
(16, 1, 8, 1, 1, NULL),
(17, 1, 8, 2, 3, NULL),
(18, 1, 8, 0, 0, NULL),
(19, 1, 9, 80, 62, NULL),
(20, 1, 9, 67, 75, NULL),
(21, 1, 9, 66, 76, NULL),
(22, 1, 9, 63, 79, NULL),
(23, 1, 9, 0, 0, NULL),
(24, 1, 10, 64, 78, NULL),
(25, 1, 10, 63, 79, NULL),
(26, 1, 10, 63, 80, NULL),
(27, 1, 10, 62, 81, NULL),
(28, 1, 10, 0, 0, NULL),
(29, 14, 9, 78, 64, NULL),
(30, 14, 9, 0, 0, NULL),
(31, 11, 8, 70, 72, NULL),
(32, 11, 8, 0, 0, NULL),
(33, 11, 9, 75, 67, NULL),
(34, 11, 9, 0, 0, NULL),
(35, 1, 12, 2, 3, NULL),
(36, 1, 12, 0, 0, NULL),
(37, 1, 11, 1, 1, NULL),
(38, 1, 11, 0, 0, NULL),
(39, 11, 11, 3, 4, NULL),
(40, 11, 11, 6, 55, NULL),
(41, 11, 11, 0, 0, NULL),
(42, 11, 12, 53, 89, NULL),
(43, 11, 12, 0, 0, NULL),
(44, 11, 15, 11, 61, NULL),
(45, 11, 15, 0, 0, NULL),
(46, 11, 14, 49, 53, NULL),
(47, 11, 14, 0, 0, NULL),
(48, 11, 13, 12, 96, NULL),
(49, 11, 13, 13, 95, NULL),
(50, 11, 13, 53, 89, NULL),
(51, 11, 13, 0, 0, NULL),
(52, 11, 22, 50, 92, NULL),
(53, 11, 21, 54, 88, NULL),
(54, 1, 23, 2, 3, NULL),
(55, 1, 23, 0, 0, NULL),
(56, 1, 16, 2, 3, NULL),
(57, 1, 16, 0, 0, NULL),
(58, 1, 24, 2, 3, NULL),
(59, 1, 24, 0, 0, NULL),
(60, 1, 26, 1, 1, NULL),
(61, 1, 26, 0, 0, NULL),
(62, 11, 27, 49, 53, NULL),
(63, 11, 27, 13, 95, NULL),
(64, 11, 27, 0, 0, NULL),
(65, 11, 28, 56, 86, NULL),
(66, 11, 28, 0, 0, NULL),
(67, 11, 26, 6, 55, NULL),
(68, 11, 26, 0, 0, NULL),
(69, 11, 25, 54, 88, NULL),
(70, 11, 25, 0, 0, NULL),
(71, 11, 17, 6, 55, NULL),
(72, 11, 17, 0, 0, NULL),
(73, 11, 18, 10, 60, NULL),
(74, 11, 18, 0, 0, NULL),
(75, 11, 19, 11, 61, NULL),
(76, 11, 19, 0, 0, NULL),
(77, 11, 20, 12, 96, NULL),
(78, 11, 20, 0, 0, NULL),
(79, 11, 32, 14, 94, NULL),
(80, 11, 32, 13, 95, NULL),
(81, 11, 32, 10, 60, NULL),
(82, 11, 32, 0, 0, NULL),
(83, 0, 32, 81, 98, NULL),
(84, 11, 30, 75, 67, NULL),
(85, 1, 30, 76, 66, NULL),
(86, 11, 29, 6, 55, NULL),
(87, 11, 29, 57, 85, NULL),
(88, 11, 29, 3, 4, NULL),
(89, 1, 33, 1, 1, NULL),
(90, 1, 33, 2, 3, NULL),
(91, 1, 33, 80, 62, NULL),
(92, 1, 33, 0, 0, NULL),
(93, 11, 25, 12, 96, NULL),
(94, 11, 34, 6, 55, NULL),
(95, 11, 34, 0, 0, NULL),
(96, 11, 35, 14, 94, NULL),
(97, 11, 35, 0, 0, NULL),
(98, 1, 36, 2, 3, NULL),
(99, 1, 36, 0, 0, NULL),
(100, 1, 38, 1, 1, NULL),
(101, 1, 38, 0, 0, NULL),
(102, 1, 39, 80, 62, NULL),
(103, 1, 39, 0, 0, NULL),
(104, 1, 37, 1, 1, NULL),
(105, 1, 37, 2, 3, NULL),
(106, 1, 37, 0, 0, NULL),
(107, 1, 40, 67, 75, NULL),
(108, 1, 40, 66, 76, NULL),
(109, 1, 40, 0, 0, NULL),
(110, 14, 39, 78, 64, NULL),
(111, 14, 39, 0, 0, NULL),
(112, 1, 41, 67, 75, NULL),
(113, 1, 41, 66, 76, NULL),
(114, 1, 41, 65, 77, NULL),
(115, 1, 41, 64, 78, NULL),
(116, 1, 41, 68, 74, NULL),
(117, 1, 41, 0, 0, NULL),
(118, 1, 42, 1, 1, NULL),
(119, 1, 42, 2, 3, NULL),
(120, 1, 42, 0, 0, NULL),
(121, 1, 43, 1, 1, NULL),
(122, 1, 43, 2, 3, NULL),
(123, 1, 45, 1, 1, NULL),
(124, 1, 45, 0, 0, NULL),
(125, 11, 46, 6, 55, NULL),
(126, 11, 46, 0, 0, NULL),
(127, 14, 46, 7, 56, NULL),
(128, 14, 46, 0, 0, NULL),
(129, 14, 47, 51, 91, NULL),
(130, 14, 47, 0, 0, NULL),
(131, 11, 47, 53, 89, NULL),
(132, 11, 47, 52, 90, NULL),
(133, 11, 47, 0, 0, NULL),
(134, 1, 48, 2, 3, NULL),
(135, 11, 49, 3, 4, NULL),
(136, 11, 49, 0, 0, NULL),
(137, 1, 50, 1, 1, NULL),
(138, 1, 50, 0, 0, NULL),
(139, 1, 64, 2, 3, NULL),
(140, 1, 64, 0, 0, NULL),
(141, 1, 60, 80, 62, NULL),
(142, 1, 60, 0, 0, NULL),
(143, 1, 51, 1, 1, NULL),
(144, 1, 51, 2, 3, NULL),
(145, 1, 51, 0, 0, NULL),
(146, 1, 57, 76, 66, NULL),
(147, 1, 57, 0, 0, NULL),
(148, 1, 53, 1, 1, NULL),
(149, 1, 53, 0, 0, NULL),
(150, 1, 55, 63, 79, NULL),
(151, 1, 55, 61, 57, NULL),
(152, 1, 55, 0, 0, NULL),
(153, 1, 56, 69, 73, NULL),
(154, 1, 56, 71, 71, NULL),
(155, 1, 56, 68, 74, NULL),
(156, 1, 56, 64, 78, NULL),
(157, 1, 56, 0, 0, NULL),
(158, 1, 62, 1, 1, NULL),
(159, 1, 62, 0, 0, NULL),
(160, 1, 61, 2, 3, NULL),
(161, 1, 61, 0, 0, NULL),
(162, 12, 54, 9, 59, NULL),
(163, 12, 54, 0, 0, NULL),
(164, 12, 56, 74, 68, NULL),
(165, 12, 56, 72, 70, NULL),
(166, 12, 56, 0, 0, NULL),
(167, 12, 58, 74, 68, NULL),
(168, 12, 58, 0, 0, NULL),
(169, 12, 68, 9, 59, NULL),
(170, 12, 68, 0, 0, NULL),
(171, 14, 56, 73, 69, NULL),
(172, 14, 56, 0, 0, NULL),
(173, 14, 58, 73, 69, NULL),
(174, 14, 58, 0, 0, NULL),
(175, 14, 63, 7, 56, NULL),
(176, 14, 63, 0, 0, NULL),
(177, 14, 66, 7, 56, NULL),
(178, 14, 66, 0, 0, NULL),
(179, 14, 67, 7, 56, NULL),
(180, 14, 67, 0, 0, NULL),
(181, 11, 52, 12, 96, NULL),
(182, 11, 52, 0, 0, NULL),
(183, 11, 57, 77, 65, NULL),
(184, 11, 57, 0, 0, NULL),
(185, 11, 53, 11, 61, NULL),
(186, 11, 53, 14, 94, NULL),
(187, 11, 53, 13, 95, NULL),
(188, 11, 53, 49, 53, NULL),
(189, 11, 53, 0, 0, NULL),
(190, 11, 66, 6, 55, NULL),
(191, 11, 66, 0, 0, NULL),
(192, 11, 60, 57, 85, NULL),
(193, 11, 60, 3, 4, NULL),
(194, 11, 60, 0, 0, NULL),
(195, 11, 68, 10, 60, NULL),
(196, 11, 68, 0, 0, NULL),
(197, 11, 58, 75, 67, NULL),
(198, 11, 58, 0, 0, NULL),
(199, 11, 54, 13, 95, NULL),
(200, 11, 54, 0, 0, NULL),
(201, 11, 56, 70, 72, NULL),
(202, 11, 56, 75, 67, NULL),
(203, 11, 56, 0, 0, NULL),
(204, 11, 59, 77, 65, NULL),
(205, 11, 59, 0, 0, NULL),
(206, 16, 52, 8, 54, NULL),
(207, 16, 52, 0, 0, NULL),
(208, 16, 63, 8, 54, NULL),
(209, 16, 63, 0, 0, NULL),
(210, 16, 66, 8, 54, NULL),
(211, 16, 66, 0, 0, NULL),
(212, 16, 67, 8, 54, NULL),
(213, 16, 67, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menutype`
--

CREATE TABLE `tbl_menutype` (
  `menutypeid` int(11) NOT NULL,
  `menutype` varchar(120) NOT NULL,
  `menu_icon` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_menutype`
--

INSERT INTO `tbl_menutype` (`menutypeid`, `menutype`, `menu_icon`, `status`) VALUES
(1, 'Breakfast', './application/modules/itemmanage/assets/images/2020-11-21/b.png', 1),
(2, 'Launch', './application/modules/itemmanage/assets/images/2020-11-21/l1.png', 1),
(3, 'Dinner', './application/modules/itemmanage/assets/images/2020-11-21/d.png', 1),
(4, 'Coffee', './application/modules/itemmanage/assets/images/2020-11-21/c.png', 1),
(5, 'Party', './application/modules/itemmanage/assets/images/2020-11-21/p.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_module_purchasekey`
--

CREATE TABLE `tbl_module_purchasekey` (
  `mpid` int(11) NOT NULL,
  `module` varchar(25) DEFAULT NULL,
  `purchasekey` varchar(55) DEFAULT NULL,
  `downloaddate` datetime NOT NULL DEFAULT '1970-01-01 01:01:01',
  `updatedate` datetime NOT NULL DEFAULT '1970-01-01 01:01:01'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notificationsetting`
--

CREATE TABLE `tbl_notificationsetting` (
  `notifid` int(11) NOT NULL,
  `firebasewaiterkitchen` text DEFAULT NULL,
  `onesignalcustomer` text NOT NULL,
  `onesignal_ioswaiter` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_openclose`
--

CREATE TABLE `tbl_openclose` (
  `stid` int(11) NOT NULL,
  `dayname` varchar(20) NOT NULL,
  `opentime` varchar(15) NOT NULL,
  `closetime` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_openclose`
--

INSERT INTO `tbl_openclose` (`stid`, `dayname`, `opentime`, `closetime`) VALUES
(1, 'Saturday', '08:00', '23:59'),
(2, 'Sunday', '08:00', '20:00'),
(3, 'Monday', '08:00', '20:00'),
(4, 'Tuesday', '08:00', '20:00'),
(5, 'Wednesday', '08:00', '20:00'),
(6, 'Thursday', '08:00', '20:00'),
(7, 'Friday', 'Closed', 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orderprepare`
--

CREATE TABLE `tbl_orderprepare` (
  `opid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `menuid` int(11) NOT NULL,
  `varient` int(11) NOT NULL,
  `preparetime` datetime NOT NULL DEFAULT '1970-01-01 01:01:01'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_orderprepare`
--

INSERT INTO `tbl_orderprepare` (`opid`, `orderid`, `menuid`, `varient`, `preparetime`) VALUES
(1, 6, 1, 1, '2025-11-01 03:42:46'),
(2, 6, 0, 1, '2025-11-01 03:42:46'),
(3, 7, 3, 4, '2025-11-01 12:25:28'),
(4, 7, 0, 4, '2025-11-01 12:25:29'),
(5, 8, 1, 1, '2025-11-01 13:18:05'),
(6, 8, 2, 1, '2025-11-01 13:18:05'),
(7, 8, 0, 1, '2025-11-01 13:18:05'),
(8, 9, 80, 62, '2025-11-01 13:18:07'),
(9, 9, 67, 62, '2025-11-01 13:18:07'),
(10, 9, 66, 62, '2025-11-01 13:18:07'),
(11, 9, 63, 62, '2025-11-01 13:18:08'),
(12, 9, 0, 62, '2025-11-01 13:18:08'),
(13, 10, 64, 78, '2025-11-01 13:18:09'),
(14, 10, 63, 78, '2025-11-01 13:18:09'),
(15, 10, 63, 78, '2025-11-01 13:18:09'),
(16, 10, 62, 78, '2025-11-01 13:18:09'),
(17, 10, 0, 78, '2025-11-01 13:18:09'),
(18, 9, 78, 64, '2025-11-01 13:18:14'),
(19, 9, 0, 64, '2025-11-01 13:18:14'),
(20, 13, 12, 96, '2025-11-01 13:45:16'),
(21, 13, 13, 96, '2025-11-01 13:45:16'),
(22, 13, 53, 96, '2025-11-01 13:45:16'),
(23, 13, 0, 96, '2025-11-01 13:45:16'),
(24, 14, 49, 53, '2025-11-01 13:45:18'),
(25, 14, 0, 53, '2025-11-01 13:45:18'),
(26, 33, 1, 1, '2025-11-03 20:47:38'),
(27, 33, 2, 1, '2025-11-03 20:47:38'),
(28, 33, 80, 1, '2025-11-03 20:47:38'),
(29, 33, 0, 1, '2025-11-03 20:47:38'),
(30, 36, 2, 3, '2025-11-07 22:05:14'),
(31, 35, 14, 94, '2025-11-07 22:05:21'),
(32, 35, 0, 94, '2025-11-07 22:05:21'),
(33, 41, 67, 75, '2025-11-08 22:43:37'),
(34, 41, 66, 75, '2025-11-08 22:43:37'),
(35, 41, 65, 75, '2025-11-08 22:43:37'),
(36, 41, 64, 75, '2025-11-08 22:43:37'),
(37, 41, 68, 75, '2025-11-08 22:43:37'),
(38, 41, 0, 75, '2025-11-08 22:43:37'),
(39, 42, 1, 1, '2025-11-08 22:43:40'),
(40, 42, 2, 1, '2025-11-08 22:43:40'),
(41, 42, 0, 1, '2025-11-08 22:43:40'),
(42, 45, 1, 1, '2025-11-09 00:55:47'),
(43, 45, 0, 1, '2025-11-09 00:55:47'),
(44, 46, 7, 56, '2025-11-09 20:48:23'),
(45, 46, 0, 56, '2025-11-09 20:48:23'),
(46, 47, 51, 91, '2025-11-09 20:48:25'),
(47, 47, 0, 91, '2025-11-09 20:48:25'),
(48, 46, 6, 55, '2025-11-09 20:48:27'),
(49, 46, 0, 55, '2025-11-09 20:48:27'),
(50, 47, 53, 89, '2025-11-09 20:48:29'),
(51, 47, 52, 89, '2025-11-09 20:48:29'),
(52, 47, 0, 89, '2025-11-09 20:48:29'),
(53, 0, 0, 0, '2025-11-12 00:03:11'),
(54, 49, 3, 4, '2025-11-12 00:03:12'),
(55, 49, 0, 4, '2025-11-12 00:03:12'),
(56, 50, 1, 1, '2025-11-12 00:06:14'),
(57, 50, 0, 1, '2025-11-12 00:06:14'),
(58, 51, 1, 1, '2025-11-12 01:31:29'),
(59, 51, 2, 1, '2025-11-12 01:31:29'),
(60, 51, 0, 1, '2025-11-12 01:31:29'),
(61, 53, 1, 1, '2025-11-12 01:31:31'),
(62, 53, 0, 1, '2025-11-12 01:31:31'),
(63, 56, 68, 74, '2025-11-12 01:31:34'),
(64, 56, 69, 73, '2025-11-12 01:31:36'),
(65, 56, 71, 73, '2025-11-12 01:31:36'),
(66, 56, 64, 73, '2025-11-12 01:31:36'),
(67, 56, 0, 73, '2025-11-12 01:31:36'),
(68, 55, 63, 79, '2025-11-12 01:31:38'),
(69, 55, 61, 79, '2025-11-12 01:31:38'),
(70, 55, 0, 79, '2025-11-12 01:31:38'),
(71, 57, 76, 66, '2025-11-12 01:31:40'),
(72, 57, 0, 66, '2025-11-12 01:31:40'),
(73, 60, 80, 62, '2025-11-12 01:31:42'),
(74, 60, 0, 62, '2025-11-12 01:31:42'),
(75, 61, 2, 3, '2025-11-12 01:31:45'),
(76, 61, 0, 3, '2025-11-12 01:31:45'),
(77, 62, 1, 1, '2025-11-12 01:31:47'),
(78, 62, 0, 1, '2025-11-12 01:31:47'),
(79, 64, 2, 3, '2025-11-12 01:31:51'),
(80, 64, 0, 3, '2025-11-12 01:31:51'),
(81, 54, 9, 59, '2025-11-12 01:31:55'),
(82, 54, 0, 59, '2025-11-12 01:31:55'),
(83, 58, 74, 68, '2025-11-12 01:31:57'),
(84, 58, 0, 68, '2025-11-12 01:31:57'),
(85, 68, 9, 59, '2025-11-12 01:31:59'),
(86, 68, 0, 59, '2025-11-12 01:31:59'),
(87, 58, 73, 69, '2025-11-12 01:32:03'),
(88, 58, 0, 69, '2025-11-12 01:32:03'),
(89, 63, 7, 56, '2025-11-12 01:32:10'),
(90, 63, 0, 56, '2025-11-12 01:32:10'),
(91, 66, 7, 56, '2025-11-12 01:32:12'),
(92, 66, 0, 56, '2025-11-12 01:32:12'),
(93, 67, 7, 56, '2025-11-12 01:32:14'),
(94, 67, 0, 56, '2025-11-12 01:32:14'),
(95, 52, 12, 96, '2025-11-12 01:32:17'),
(96, 52, 0, 96, '2025-11-12 01:32:17'),
(97, 59, 77, 65, '2025-11-12 01:32:18'),
(98, 59, 0, 65, '2025-11-12 01:32:18'),
(99, 66, 6, 55, '2025-11-12 01:32:20'),
(100, 66, 0, 55, '2025-11-12 01:32:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_posetting`
--

CREATE TABLE `tbl_posetting` (
  `possettingid` int(11) NOT NULL,
  `waiter` int(11) NOT NULL DEFAULT 0 COMMENT '1=show,0=hide',
  `tableid` int(11) NOT NULL DEFAULT 0 COMMENT '1=show,0=hide',
  `cooktime` int(11) NOT NULL DEFAULT 0 COMMENT '1=enable,0=disable',
  `productionsetting` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=manual,1=auto',
  `tablemaping` int(11) NOT NULL DEFAULT 0 COMMENT '1=enable,0=disable',
  `soundenable` int(11) DEFAULT NULL COMMENT '1=enable,0=disable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_posetting`
--

INSERT INTO `tbl_posetting` (`possettingid`, `waiter`, `tableid`, `cooktime`, `productionsetting`, `tablemaping`, `soundenable`) VALUES
(1, 1, 1, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quickordersetting`
--

CREATE TABLE `tbl_quickordersetting` (
  `quickordid` int(11) NOT NULL,
  `waiter` int(11) NOT NULL DEFAULT 1 COMMENT '1=show,0=hide',
  `tableid` int(11) NOT NULL DEFAULT 1 COMMENT '1=show,0=hide',
  `cooktime` int(11) NOT NULL DEFAULT 1 COMMENT '1=show,0=hide',
  `soundenable` int(11) NOT NULL DEFAULT 1 COMMENT '1=enable,0=disable	',
  `tablemaping` int(11) NOT NULL DEFAULT 1 COMMENT '1=enable,0=disable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_quickordersetting`
--

INSERT INTO `tbl_quickordersetting` (`quickordid`, `waiter`, `tableid`, `cooktime`, `soundenable`, `tablemaping`) VALUES
(1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `ratingid` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `reviewtxt` text DEFAULT NULL,
  `proid` int(11) NOT NULL,
  `rating` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` int(11) NOT NULL DEFAULT 0,
  `email` varchar(255) NOT NULL,
  `ratetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_rating`
--

INSERT INTO `tbl_rating` (`ratingid`, `title`, `name`, `reviewtxt`, `proid`, `rating`, `status`, `email`, `ratetime`) VALUES
(1, 'good', 'joeldy tsna', 'good meat; I enjoyed it', 1, 0.00, 1, 'joeldytsina94@gmail.com', '2025-10-31 13:48:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room`
--

CREATE TABLE `tbl_room` (
  `id` int(11) NOT NULL,
  `roomno` varchar(100) NOT NULL,
  `floorno` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=active,0=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seoption`
--

CREATE TABLE `tbl_seoption` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_slug` varchar(255) NOT NULL,
  `keywords` text DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_seoption`
--

INSERT INTO `tbl_seoption` (`id`, `title`, `title_slug`, `keywords`, `description`) VALUES
(1, 'Bhojon Home page', 'home', 'restaurant,food,reservation', 'Best Restautant Management Software'),
(3, 'Menu', 'menu', 'Desert,Meet,fish,meet,bevarage', 'Menu Page'),
(4, 'Food Details', 'food_details', 'Meet,solt', 'Details foodÂ  information'),
(5, 'Reservation', 'reservation', 'Table,booking,reservation', 'Table Reservation'),
(6, 'Cart Page', 'cart_page', 'food,menu', 'Cart Page'),
(7, 'Checkout', 'checkout', 'Checkout', 'Checkout'),
(8, 'Login', 'login', 'Login', 'Login'),
(9, 'Registration', 'registration', 'Registration', 'Registration'),
(10, 'Payment information', 'payment_information', 'Online Payment information', 'Payment information'),
(11, 'Stripe Payment information', 'stripe_payment_information', 'Stripe Payment', 'Stripe Payment information'),
(12, 'About us', 'about_us', 'About restaurant', 'About us'),
(13, 'Contact Us', 'contact_us', 'Contact Us', 'Contact Us'),
(14, 'Privacy Policy', 'privacy_policy', 'privacy', 'Privacy Policy'),
(15, 'Our Terms', 'our_terms', 'Our Terms', 'Our Terms'),
(16, 'My Profile', 'my_profile', 'My Profile', 'My Profile'),
(17, 'My Order List', 'my_order_list', 'My Order List', 'My Order List'),
(18, 'View Order', 'view_order', 'View Order', 'View Order'),
(19, 'My Reservation', 'my_reservation', 'My Reservation', 'My Reservation');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shippingaddress`
--

CREATE TABLE `tbl_shippingaddress` (
  `shipaddressid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `companyname` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `city` varchar(70) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `DateInserted` datetime NOT NULL DEFAULT '1970-01-01 01:01:01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_shippingaddress`
--

INSERT INTO `tbl_shippingaddress` (`shipaddressid`, `orderid`, `firstname`, `lastname`, `companyname`, `email`, `phone`, `city`, `district`, `country`, `zip`, `address`, `address2`, `DateInserted`) VALUES
(1, 1, 'simon', 'simon', 'Not Set', '', '064663469', '', '', '', '', 'Not Set', NULL, '2025-10-31 10:05:29'),
(2, 2, 'Simon Joeldy', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', '', 'Nagaland', 'India', '', 'Congo Brazzaville', NULL, '2025-10-31 12:18:17'),
(3, 3, 'Simon Joeldy', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', '', 'Barishal', 'Bangladesh', '', 'Congo Brazzaville', NULL, '2025-10-31 22:03:33'),
(4, 4, 'Simon Joeldy', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', '', 'Barishal', 'Bangladesh', '', 'Congo Brazzaville', NULL, '2025-10-31 22:09:05'),
(5, 6, 'joeldy tsna', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', '', 'Nagaland', 'India', '', 'Congo Brazzaville', NULL, '2025-11-01 03:02:36'),
(6, 7, 'Joeldy', 'Tsina', NULL, 'joeldytsina94@gmail.com', '050489037', '', 'Nagaland', 'India', '', 'Avenue ngamaba', NULL, '2025-11-01 04:37:12'),
(7, 8, 'simon', 'simon', 'Not Set', '', '06739988747', '', '', '', '', 'Not Set', NULL, '2025-11-01 12:37:56'),
(8, 9, 'clavina', 'clavina', 'Not Set', '', '06739988747', '', '', '', '', 'Not Set', NULL, '2025-11-01 12:45:24'),
(9, 10, 'clavina', 'clavina', 'Not Set', '', '06739988747', '', '', '', '', 'Not Set', NULL, '2025-11-01 12:46:28'),
(10, 32, 'hemercia', 'hemercia', 'Not Set', '', '045467893', '', '', '', '', 'Not Set', NULL, '2025-11-02 12:39:10'),
(11, 33, 'test@gmail', 'test@gmail', 'Not Set', '', 'testpghone', '', '', '', '', 'Not Set', NULL, '2025-11-03 01:10:06'),
(12, 35, 'Simon Joeldy', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', 'Brazzaville', 'Brazzaville', 'Congo Brazzaville', '', 'Congo Brazzaville', NULL, '2025-11-07 21:46:52'),
(13, 36, 'Simon Joeldy', 'TSINA', NULL, 'joeldytsina94@gmail.com', '064663469', '', 'Brazzaville', 'Congo Brazzaville', '', 'Congo Brazzaville', NULL, '2025-11-07 21:49:15'),
(14, 39, 'etstqr', 'etstqr', 'Not Set', '', '0977376733', '', '', '', '', 'Not Set', NULL, '2025-11-08 21:51:39'),
(15, 40, 'simonnn', 'simonnn', 'Not Set', '', '0645565372', '', '', '', '', 'Not Set', NULL, '2025-11-08 21:56:54'),
(16, 41, 'joeldy qr', 'joeldy qr', 'Not Set', '', '088973824863', '', '', '', '', 'Not Set', NULL, '2025-11-08 22:39:48'),
(17, 42, 'joeldy simon pierre', 'joeldy simon pierre', 'Not Set', '', '048329756\"&', '', '', '', '', 'Not Set', NULL, '2025-11-08 22:41:31'),
(18, 43, 'joeldy simon pierre', 'joeldy simon pierre', 'Not Set', '', '234324524', '', '', '', '', 'Not Set', NULL, '2025-11-08 23:10:59'),
(19, 44, 'simon', 'simon', 'Not Set', '', '1324', '', '', '', '', 'Not Set', NULL, '2025-11-08 23:17:09'),
(20, 65, 'tes', 'tes', 'Not Set', '', '0988787287392', '', '', '', '', 'Not Set', NULL, '2025-11-12 01:00:16'),
(21, 66, 'Joeldy', 'tes', NULL, 'joeldytsina94@gmail.com', '0988787287392', 'Brazzaville', 'Brazzaville', 'Congo Brazzaville', '', 'Not Set', NULL, '2025-11-12 01:01:48'),
(22, 67, 'tes', 'tes', NULL, 'tes@gmail.com', '0988787287392', 'Brazzaville', 'Brazzaville', 'Congo Brazzaville', '', 'Not Set', NULL, '2025-11-12 01:04:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `slid` int(11) NOT NULL,
  `Sltypeid` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `slink` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `delation_status` int(11) NOT NULL DEFAULT 0,
  `width` int(11) NOT NULL DEFAULT 0,
  `height` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`slid`, `Sltypeid`, `title`, `subtitle`, `image`, `slink`, `status`, `delation_status`, `width`, `height`) VALUES
(1, 1, 'Welcome To', 'Book <span>Your</span> Table', 'assets/img/banner/2025-11-11/1.jpg', '#', 1, 0, 1920, 902),
(2, 1, 'Find Your', 'Best <span>Cafe</span> Deals', 'assets/img/banner/2025-11-11/2.jpg', '#', 1, 0, 1920, 902),
(3, 1, 'Exclusive', 'Coffee <span>Shop</span>', 'assets/img/banner/2025-11-11/3.jpg', '#', 1, 0, 1920, 902),
(4, 2, 'Discover', 'OUR STORY', 'assets/img/banner/2025-10-31/G7.png', '#', 1, 0, 263, 332),
(5, 2, 'Discover', 'OUR STORY', 'assets/img/banner/2025-10-31/G6.png', '#', 1, 0, 263, 332),
(6, 3, 'Discover', 'OUR MENU', 'assets/img/banner/2025-10-31/H3.png', '#', 1, 0, 263, 332),
(7, 3, 'Discover', 'OUR MENU', 'assets/img/banner/2025-10-31/O2.png', '#', 1, 0, 263, 177),
(8, 3, 'Discover', 'OUR MENU', 'assets/img/banner/2025-10-31/s.png', '#', 1, 0, 263, 177),
(9, 4, 'right', 'ads', 'assets/img/banner/2025-10-31/O4.png', '#', 1, 0, 252, 621),
(10, 5, 'OUR AWESOME STREET', 'FOOD HISTORY', 'assets/img/banner/2025-10-31/O1.png', '#', 1, 0, 541, 516),
(11, 6, 'Reservation', 'BOOK YOUR TABLE', 'assets/img/banner/2025-10-31/T.png', '#', 1, 0, 470, 548),
(12, 7, 'Our Gallery', 'CHEF SELECTION', 'assets/img/banner/2025-10-31/G5.png', '#', 1, 0, 1200, 900),
(13, 7, 'Our Gallery', 'CHEF SELECTION', 'assets/img/banner/2025-10-31/G4.png', '#', 1, 0, 1200, 900),
(14, 7, 'Our Gallery', 'CHEF SELECTION', 'assets/img/banner/2025-10-31/G3.png', '#', 1, 0, 1200, 900),
(15, 7, 'Our Gallery', 'CHEF SELECTION', 'assets/img/banner/2025-10-31/G2.png', '#', 1, 0, 1200, 900),
(16, 7, 'Our Gallery', 'CHEF SELECTION', 'assets/img/banner/2025-10-31/G1.png', '#', 1, 0, 1200, 900),
(17, 7, 'Our Gallery', 'CHEF SELECTION', 'assets/img/banner/2025-10-31/G.png', '#', 1, 0, 1200, 900),
(18, 8, 'Offer', 'item offer', 'assets/img/banner/2025-10-31/O3.png', '#', 1, 0, 250, 533),
(19, 9, 'Offer', 'food offer', 'assets/img/banner/2025-10-31/O.png', '#', 1, 0, 250, 553),
(20, 10, 'contact us', 'contact', 'assets/img/banner/2025-10-31/C.png', '#', 1, 0, 475, 633),
(26, 16, 'Michael H.', 'Bhojon makes running my restaurant stress-free. The POS is super smooth, and managing online orders is now effortless.', 'assets/img/banner/2025-10-31/P2.png', '5', 1, 0, 150, 150),
(27, 16, 'Sarah K.', 'Very easy to use! My staff learned it quickly, and it really helps with table reservations and billing.', 'assets/img/banner/2025-10-31/.jpeg', '4', 1, 0, 150, 150),
(28, 16, 'James P.', 'I run two restaurants, and Bhojon keeps everything organized—from inventory to HR. Couldn’t be happier!', 'assets/img/banner/2025-10-31/P1.png', '5', 1, 0, 150, 150),
(29, 16, 'Olivia M.', 'The flexibility is amazing. I can manage my whole restaurant from one system. Customers love the fast service!', 'assets/img/banner/2025-10-31/P.png', '4', 1, 0, 150, 150),
(30, 17, 'Why Choose Us', 'Why Choose Us', 'assets/img/banner/2025-10-31/W2.png', '#', 1, 0, 300, 250),
(31, 17, 'Why Choose Us', 'Why Choose Us', 'assets/img/banner/2025-10-31/W1.png', '#', 1, 0, 300, 250),
(32, 17, 'Why Choose Us', 'Why Choose Us', 'assets/img/banner/2025-10-31/W.png', '#', 1, 0, 324, 516),
(33, 18, 'Home Hero Section', 'Home Hero Section', 'assets/img/banner/2025-10-31/H2.png', '#', 1, 0, 300, 250),
(34, 18, 'Home Hero Section', 'Home Hero Section', 'assets/img/banner/2025-10-31/H1.png', '#', 1, 0, 300, 250),
(35, 18, 'Home Hero Section', 'Home Hero Section', 'assets/img/banner/2025-10-31/H.png', '#', 1, 0, 324, 516),
(36, 19, 'Cart Page Ad', 'Cart Page Ad', 'assets/img/banner/2025-10-31/b.png', '#', 1, 0, 294, 545),
(37, 20, 'Hero Section Background(Exclusive Theme)', 'Hero Section Background(Exclusive Theme)', 'application/views/themes/exclusive/assets_web/images/common-bg.webp', '#', 1, 0, 1920, 457),
(38, 21, 'Delicious Food', 'Our dishes are full of fresh,bold flavors that you\'ll love.', 'application/views/themes/exclusive/assets_web/images/icon/icon-4.png', '#', 1, 0, 56, 56),
(39, 21, 'Relaxing', 'Enjoy your meal in a cozy and welcoming for every occasion.', 'application/views/themes/exclusive/assets_web/images/icon/icon-3.png', '#', 1, 0, 56, 56),
(40, 21, 'Friendly Service', 'Dedicated to ensuring seamless service with available.', 'application/views/themes/exclusive/assets_web/images/icon/icon-2.png', '#', 1, 0, 56, 56),
(41, 21, 'Fresh Ingredients', 'We use best freshest ingredients to make every dish perfect.', 'application/views/themes/exclusive/assets_web/images/icon/icon-1.png', '#', 1, 0, 56, 56);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider_type`
--

CREATE TABLE `tbl_slider_type` (
  `stype_id` int(11) NOT NULL,
  `STypeName` varchar(255) DEFAULT NULL,
  `delation_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_slider_type`
--

INSERT INTO `tbl_slider_type` (`stype_id`, `STypeName`, `delation_status`) VALUES
(1, 'Home Top Slider', 0),
(2, 'Home our story', 0),
(3, 'Home our menu', 0),
(4, 'Menu Page right Banner', 0),
(5, 'Classic theme Home story', 0),
(6, 'Classic theme Home reservation', 0),
(7, 'Image Gallery', 0),
(8, 'Menu Page Offer Banner Right', 0),
(9, 'Cart Page Offer Banner Right', 0),
(10, 'Contact Us', 0),
(16, 'Testimonial', 0),
(17, 'Why Choose Us', 0),
(18, 'Home Hero Section(Exclusive Theme)', 0),
(19, 'Cart Page Ad', 0),
(20, 'Hero Section Background(Exclusive Theme)', 0),
(21, 'Service Tag(Exclusive Theme)', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sociallink`
--

CREATE TABLE `tbl_sociallink` (
  `sid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `socialurl` text DEFAULT NULL,
  `icon` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_sociallink`
--

INSERT INTO `tbl_sociallink` (`sid`, `title`, `socialurl`, `icon`, `status`) VALUES
(1, 'Facebook', 'https://www.facebook.com', 'fab fa-facebook', 1),
(2, 'Twitter', 'https://www.twitter.com', 'fab fa-twitter', 1),
(3, 'Google Plus', 'https://plus.google.com', 'fab fa-google-plus', 1),
(4, 'Pinterest', 'https://www.pinterest.com/', 'fab fa-pinterest', 1),
(6, 'Linkedin', 'https://linkedin.com', 'fab fa-linkedin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_soundsetting`
--

CREATE TABLE `tbl_soundsetting` (
  `soundid` int(11) NOT NULL,
  `nofitysound` text DEFAULT NULL,
  `addtocartsound` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_soundsetting`
--

INSERT INTO `tbl_soundsetting` (`soundid`, `nofitysound`, `addtocartsound`) VALUES
(1, 'assets/2021-03-21/b1.mp3', 'h');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_state`
--

CREATE TABLE `tbl_state` (
  `stateid` int(11) NOT NULL,
  `countryid` int(11) NOT NULL,
  `statename` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_state`
--

INSERT INTO `tbl_state` (`stateid`, `countryid`, `statename`, `status`) VALUES
(1, 2, 'Alabama', 1),
(2, 2, 'Alaska', 1),
(3, 2, 'Arizona', 1),
(4, 2, 'Arkansas', 1),
(5, 2, 'California', 1),
(6, 2, 'Florida', 1),
(7, 2, 'New Mexico', 1),
(8, 2, 'New York', 1),
(9, 2, 'Oklahoma', 1),
(10, 2, 'Texas', 1),
(11, 2, 'Virginia', 1),
(12, 1, 'Dhaka', 1),
(13, 1, 'Chittagong', 1),
(14, 1, 'Rajshahi', 1),
(15, 1, 'Khulna', 1),
(16, 1, 'Sylhet', 1),
(17, 1, 'Barishal', 1),
(18, 1, 'Rangpur', 1),
(19, 1, 'Mymensingh', 1),
(20, 4, 'West Bengal', 1),
(21, 4, 'Uttar Pradesh', 1),
(22, 4, 'Tripura', 1),
(23, 4, 'Telangana', 1),
(24, 4, 'Tamil Nadu', 1),
(25, 4, 'Sikkim', 1),
(26, 4, 'Rajasthan', 1),
(27, 4, 'Punjab', 1),
(28, 4, 'Odisha', 1),
(29, 4, 'Nagaland', 1),
(30, 4, 'Kerala', 1),
(31, 4, 'Haryana', 1),
(32, 6, 'Brazzaville', 1),
(33, 6, 'Pointe-Noire', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tablefloor`
--

CREATE TABLE `tbl_tablefloor` (
  `tbfloorid` int(11) NOT NULL,
  `floorName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_tablefloor`
--

INSERT INTO `tbl_tablefloor` (`tbfloorid`, `floorName`) VALUES
(1, 'First Floor'),
(2, 'VIP Floor'),
(3, 'Second Floor'),
(4, 'Third Floor');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_thirdparty_customer`
--

CREATE TABLE `tbl_thirdparty_customer` (
  `companyId` int(11) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `address` text DEFAULT NULL,
  `commision` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_thirdparty_customer`
--

INSERT INTO `tbl_thirdparty_customer` (`companyId`, `company_name`, `address`, `commision`) VALUES
(1, 'Food Panda', 'Dhaka', 5.00),
(2, 'pathao', 'Dhaka', 8.00),
(3, 'Hungrynaki', 'Dhaka', 5.00),
(4, 'Foodmart', 'Dhaka', 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_token`
--

CREATE TABLE `tbl_token` (
  `tokenid` int(11) NOT NULL,
  `tokencode` varchar(50) NOT NULL,
  `tokenrate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tokenstartdate` date NOT NULL,
  `tokenendate` date NOT NULL,
  `tokenstatus` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_token`
--

INSERT INTO `tbl_token` (`tokenid`, `tokencode`, `tokenrate`, `tokenstartdate`, `tokenendate`, `tokenstatus`) VALUES
(1, 'ABCD', 10.00, '2021-08-28', '2021-12-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_updateitems`
--

CREATE TABLE `tbl_updateitems` (
  `updateid` int(11) NOT NULL,
  `ordid` int(11) NOT NULL,
  `menuid` int(11) NOT NULL,
  `qty` decimal(10,3) NOT NULL DEFAULT 0.000,
  `adonsqty` varchar(50) DEFAULT NULL,
  `addonsid` varchar(50) DEFAULT NULL,
  `varientid` int(11) NOT NULL,
  `addonsuid` int(11) DEFAULT NULL,
  `isupdate` varchar(5) DEFAULT NULL,
  `insertdate` date DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_version_checker`
--

CREATE TABLE `tbl_version_checker` (
  `vid` int(11) NOT NULL,
  `version` varchar(10) DEFAULT NULL,
  `disable` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_version_checker`
--

INSERT INTO `tbl_version_checker` (`vid`, `version`, `disable`) VALUES
(1, '2.8', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_waiterappcart`
--

CREATE TABLE `tbl_waiterappcart` (
  `weaterappid` int(11) NOT NULL,
  `waiterid` int(11) NOT NULL,
  `alladdOnsName` varchar(255) DEFAULT NULL,
  `total_addonsprice` decimal(10,2) DEFAULT 0.00,
  `totaladdons` int(11) DEFAULT NULL,
  `addons_name` varchar(255) DEFAULT NULL,
  `addons_id` int(11) DEFAULT NULL,
  `addons_price` double(10,2) DEFAULT 0.00,
  `addonsQty` int(11) DEFAULT NULL,
  `component` varchar(255) DEFAULT NULL,
  `destcription` text DEFAULT NULL,
  `itemnotes` varchar(255) DEFAULT NULL,
  `offerIsavailable` int(11) DEFAULT 0,
  `offerstartdate` date DEFAULT '0000-00-00',
  `OffersRate` int(11) DEFAULT NULL,
  `offerendate` date DEFAULT '0000-00-00',
  `price` decimal(10,2) DEFAULT 0.00,
  `ProductsID` int(11) NOT NULL,
  `ProductImage` varchar(255) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `productvat` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `variantName` varchar(255) NOT NULL,
  `variantid` int(11) NOT NULL,
  `orderid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_widget`
--

CREATE TABLE `tbl_widget` (
  `widgetid` int(11) NOT NULL,
  `widget_name` varchar(100) NOT NULL,
  `widget_title` varchar(150) DEFAULT NULL,
  `widget_desc` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_widget`
--

INSERT INTO `tbl_widget` (`widgetid`, `widget_name`, `widget_title`, `widget_desc`, `status`) VALUES
(1, 'Footer left', '', '<p class=\"text-justify\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard.</p>', 1),
(2, 'footermiddle', 'Available On', '<p><strong>Monday - Wednesday</strong>Â 10:00 AM - 7:00 PM</p>\r\n<p><strong>Thursday - Friday</strong>Â 10:00 AM - 11:00 PM</p>\r\n<p><strong>Saturday</strong>Â 12:00 PM - 6:00 PM</p>\r\n<p><strong>Sunday</strong>Â Off</p>', 1),
(3, 'Footer right', 'Contact Us', '<p>356, Mannan Plaza ( 4th Floar ) Khilkhet Dhaka</p>\r\n<p><a href=\"../../hungry\">support@lmk.com</a></p>\r\n<p><a href=\"../../hungry\">+06 01715 222 333</a></p>', 1),
(4, 'Our Store', 'Our Store', '<address>123 Suspendis matti,&nbsp;<br />Visaosang Building VST District,&nbsp;<br />NY Accums, North American</address>\r\n<p><a class=\"d-block\" href=\"http://soft9.bdtask.com/hungry-v1/\">0123-456-78910</a><a class=\"d-block\" href=\"http://soft9.bdtask.com/hungry-v1/\">support@domain.com</a></p>', 1),
(6, 'Reservation', 'BOOK YOUR TABLE', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', 1),
(7, 'Our Menu text', 'Our Menu ', '<p>Rosa is a restaurant, bar and coffee roastery located on a busy corner site in Farringdon\'s Exmouth Market. With glazed frontage on two sides of the building, overlooking the market and a bustling London inteon.</p>', 1),
(8, 'Specials', 'FOOD MENU', '<p>Delicious Food, Fresh Ingredients, Crafted with Love, Satisfy Your Cravings!</p>', 1),
(9, 'story text', 'OUR STORY', '<p>Rosa is a restaurant, bar and coffee roastery located on a busy corner site in Farringdon\'s Exmouth Market. With glazed frontage on two sides of the building, overlooking the market and a bustling London inteon.</p>', 1),
(10, 'Professional', 'OUR EXPERT CHEFS', '', 1),
(11, 'Need Help Booking?', 'Need Help Booking?', '<p class=\"mb-2\">Just call our customer services at any time, we are waiting 24 hours to recieve your calls.</p>\r\n<p><a href=\"#\">+06 466 34 123</a></p>', 1),
(12, 'Privacy', 'Privacy Policy', '<h2>What is Lorem Ipsum</h2>\r\n<p>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<h3>Contacting us :</h3>\r\n<p>If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us.</p>', 1),
(13, 'termscondition', 'Terms of Use', '<h3>Web browser cookies</h3>\r\n<p>Our Site may use cache and \"cookies\" to enhance User experience. User\'s web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. User may choose to set their web browser to refuse cookies, or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly.</p>\r\n<h3>How we use collected information bdtask may collect and use Users personal information for the following purposes:</h3>\r\n<p>To run and operate our Site We may need your information display content on the Site correctly. To improve customer service Information you provide helps us respond to your customer service requests and support needs more efficiently. To personalize user experience We may use information in the aggregate to understand how our Users as a group use the services and resources provided on our Site. To improve our Site We may use feedback you provide to improve our products and services. To run a promotion, contest, survey or other Site feature To send Users information they agreed to receive about topics we think will be of interest to them. To send periodic emails We may use the email address to send User information and updates pertaining to their order. It may also be used to respond to their inquiries, questions, and/or other requests.</p>', 1),
(14, 'map', 'Google Map', '<p>&lt;iframe style=\"border: 0;\" src=\"https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14599.578237069936!2d90.3654215!3d23.8223482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1583411739085!5m2!1sen!2sbd\" width=\"300\" height=\"150\" frameborder=\"0\" allowfullscreen=\"allowfullscreen\"&gt;&lt;/iframe&gt;</p>', 1),
(15, 'carousal1', 'carousal', '<p>show</p>', 1),
(16, 'TASTY MENU TODAY', 'CHEF SELECTION', '', 1),
(17, 'FOOD HISTORY', 'OUR AWESOME STREET', '<p class=\"mb-4\">Thing lesser replenish evening called void a sea blessed meat fourth called moveth place behold night own night third in they abundant and don\'t you\'re the upon fruit. Divided open divided appear also saw may fill. whales seed creepeth. Open lessegether he also morning land i saw Man</p>\r\n<p><a class=\"simple_btn\" href=\"#\">Our Story</a></p>', 1),
(21, 'Our Gallery', 'Restaurant Photo Gallery', '', 1),
(22, 'subfooter', '', '', 1),
(23, 'Get In Touch', 'contact', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', 1),
(24, 'Refund Policies', 'Refund Policies', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard.</p>', 1),
(27, 'Footer Address', NULL, '570 8th Ave, New York, NY 10018 United States', 1),
(28, 'Hero Title', 'Hero Title(Exclusive Theme)', 'Delicious food & wonderful eating experience', 1),
(29, 'Hero Sub Title', 'Hero Sub Title(Exclusive Theme)', 'Discover bold flavors and unforgettable dishes in a place where every craving is satisfied with the perfect bite, crafted just for you.', 1),
(30, 'Hero Video Link', 'Hero Video Link(Youtube, Vimeo etc)', 'https://www.youtube.com/watch?app=desktop&v=4IXGFfMgR2U', 1),
(31, 'Serve Quality Food & Thing', 'Welcome To Our Luxury Restaurant', 'Exercitation photo booth stumptown tote bag Banksy, elit small batch freegan sed. Craft beer elit seitan exercitation, photo booth et 8-bit kale chips proident chillwave deep v laborum. Aliquip veniam delectus, Marfa eiusmod Pinterest in do umami readymade swag. Selfies iPhone Kickstarter, drinking vinegar jean vinegar stumptown yr pop-up artisan sunt.', 1),
(36, 'Why choose us?', 'Enjoying the beautiful things', '<p>Discover bold flavors and unforgettable dishes in a place where every craving is satisfied with the perfect bite, crafted just for you.</p>\r\n<ul>\r\n<li>The sushi here is always fresh & beautifully</li>\r\n<li>We invite everyone to see how our products</li>\r\n<li>We invite everyone to see how our products</li>\r\n</ul>', 1),
(37, 'Testimonials', 'What Our Customers Say', NULL, 1),
(38, 'Visit Our Restaurant', 'Visit Our Restaurant', 'Experience the perfect blend of delicious cuisine and warm hospitality at our restaurant. Whether you\'re planning a family dinner, a casual lunch, or a special celebration, we are here to make every visit memorable. Call us anytime for reservations or simply walk in during our opening hours to enjoy a delightful dining experience.', 1),
(39, 'Short Opening Hours', 'Opening Hours', '<p>Mon – Thu (10:00 AM – 01:00 AM)</p>\n<p>Fri – Sun (11:00 AM – 10:00 PM)</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `themeid` int(11) NOT NULL,
  `themename` varchar(100) NOT NULL,
  `theme_thumb` varchar(255) DEFAULT NULL,
  `primary_color` varchar(10) DEFAULT NULL,
  `top_header_bg` varchar(10) DEFAULT NULL,
  `header_bg` varchar(10) DEFAULT NULL,
  `header_color` varchar(10) DEFAULT NULL,
  `footer_bg` varchar(10) DEFAULT NULL,
  `footer_color` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0=inactive,1=active',
  `activedate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`themeid`, `themename`, `theme_thumb`, `primary_color`, `top_header_bg`, `header_bg`, `header_color`, `footer_bg`, `footer_color`, `status`, `activedate`) VALUES
(1, 'defaults', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2020-11-19'),
(3, 'classic', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-11-19'),
(4, 'exclusive', NULL, '#c09342', '#112a2a', '#1f3433', '#ffffff', '#081d1c', '#ffffff', 0, '2025-08-23');

-- --------------------------------------------------------

--
-- Table structure for table `top_menu`
--

CREATE TABLE `top_menu` (
  `menuid` int(11) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `menu_slug` varchar(70) NOT NULL,
  `parentid` int(11) NOT NULL,
  `is_footer` tinyint(1) NOT NULL DEFAULT 0,
  `entrydate` date NOT NULL,
  `isactive` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `top_menu`
--

INSERT INTO `top_menu` (`menuid`, `menu_name`, `menu_slug`, `parentid`, `is_footer`, `entrydate`, `isactive`) VALUES
(1, 'Home', 'home', 0, 0, '2025-09-01', 1),
(2, 'Reservation', 'reservation', 0, 0, '2025-09-01', 1),
(3, 'Menu', 'menu', 0, 0, '2025-09-01', 1),
(4, 'About Us', 'about', 0, 0, '2025-09-01', 1),
(5, 'Contact Us', 'contact', 0, 0, '2025-09-01', 1),
(6, 'Gallery', 'gallery', 0, 0, '2025-09-01', 1),
(7, 'Team', 'team', 0, 0, '2025-09-01', 1),
(8, 'My Profile', 'myprofile', 0, 0, '2025-09-01', 1),
(9, 'Home', 'home', 0, 1, '2025-09-01', 0),
(10, 'Reservation', 'reservation', 0, 1, '2025-09-01', 0),
(11, 'Menu', 'menu', 0, 1, '2025-09-01', 0),
(12, 'About Us', 'about', 0, 1, '2025-09-01', 1),
(13, 'Contact Us', 'contact', 0, 1, '2025-09-01', 1),
(14, 'Gallery', 'gallery', 0, 1, '2025-09-01', 1),
(15, 'Team', 'team', 0, 1, '2025-09-01', 1),
(16, 'My Profile', 'myprofile', 0, 1, '2025-09-01', 1),
(17, 'Terms', 'terms', 0, 1, '2025-09-01', 1),
(18, 'Privacy Policy', 'privacy', 0, 1, '2025-09-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `unit_of_measurement`
--

CREATE TABLE `unit_of_measurement` (
  `id` int(11) NOT NULL,
  `uom_name` varchar(200) NOT NULL,
  `uom_short_code` varchar(10) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `unit_of_measurement`
--

INSERT INTO `unit_of_measurement` (`id`, `uom_name`, `uom_short_code`, `is_active`) VALUES
(1, 'Kilogram', 'kg.', 1),
(2, 'Liter', 'ltr.', 1),
(3, 'Gram', 'grm.', 1),
(4, 'tonne', 'tn.', 1),
(5, 'milligram', 'mg.', 1),
(6, 'carat', 'carat', 1),
(7, 'Per Pieces', 'pcs', 1),
(8, 'Per Cup', 'cup', 1),
(9, 'Pound', 'pnd.', 1),
(10, 'tablespoon', 'tspoon', 1),
(11, 'Milliliter', 'ML', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usedcoupon`
--

CREATE TABLE `usedcoupon` (
  `cusedid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `couponcode` varchar(100) NOT NULL,
  `couponrate` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `waiter_kitchenToken` text DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `password_reset_token` varchar(20) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL,
  `ip_address` varchar(14) DEFAULT NULL,
  `counter` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_admin` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `about`, `waiter_kitchenToken`, `email`, `password`, `password_reset_token`, `image`, `last_login`, `last_logout`, `ip_address`, `counter`, `status`, `is_admin`) VALUES
(2, 'John', 'Doe', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '', 'admin@example.com', '827ccb0eea8a706c4c34a16891f84e7b', '', './assets/img/user/m2.png', '2025-11-12 10:35:04', '2025-11-12 10:34:51', '::1', NULL, 1, 1),
(165, 'Hm', 'Isahaq', NULL, NULL, 'hmisahaq@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, './application/modules/hrm/assets/images/2025-10-31/P1.png', NULL, NULL, NULL, NULL, 1, 0),
(166, 'Ainal', 'Haque', NULL, NULL, 'ainal@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2020-12-17 12:30:42', '2020-12-17 12:30:31', '::1', NULL, 1, 0),
(168, 'Manik ', 'Hassan', NULL, NULL, 'manik@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
(177, 'Di', 'Maria', NULL, NULL, 'dimaria@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, './application/modules/hrm/assets/images/2025-10-31/P.png', NULL, NULL, NULL, NULL, 1, 0),
(178, 'welcome', 'marco', NULL, NULL, 'waiter@example.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, './application/modules/hrm/assets/images/2025-11-01/C.png', '2025-11-03 12:32:26', '2025-11-03 12:32:56', '::1', NULL, 1, 0),
(179, 'man', 'maniar', NULL, NULL, 'mantest@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, './application/modules/hrm/assets/images/2025-11-03/C.png', NULL, NULL, NULL, NULL, 1, 0),
(180, 'Simon Joeldy', 'TSINA', 'The best counter in the world.', NULL, 'counter@example.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, '', '2025-11-08 09:49:23', '2025-11-08 10:04:29', '::1', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `variant`
--

CREATE TABLE `variant` (
  `variantid` int(11) NOT NULL,
  `menuid` int(11) NOT NULL,
  `variantName` varchar(120) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `variant`
--

INSERT INTO `variant` (`variantid`, `menuid`, `variantName`, `price`) VALUES
(1, 1, '100 og', 20.00),
(2, 5, 'Mineral Water ', 10.00),
(3, 2, 'Amala Orange Juice', 110.00),
(4, 3, 'pepperoni', 20.00),
(5, 5, 'sparkling water', 30.00),
(53, 49, 'Minestrone Soup-Small', 200.00),
(54, 8, 'Tawa Naan with Ghee 1', 150.00),
(55, 6, 'Mineral Water with disposible glass', 20.00),
(56, 7, 'Vegetarian Curry', 300.00),
(57, 61, 'Vegetable Beef soup with Noodles', 300.00),
(58, 61, ' Vegetable Beef soup with Noodles', 120.00),
(59, 9, ' Vegetable sharma', 120.00),
(60, 10, 'Cheese Loven Pizza', 150.00),
(61, 11, 'Vegetable Pizza', 100.00),
(62, 80, 'Chicken Swarma Roll', 100.00),
(63, 79, 'Beef Swarma', 150.00),
(64, 78, 'Large', 100.00),
(65, 77, 'Chicken Chowmein', 50.00),
(66, 76, 'Chicken Fry', 60.00),
(67, 75, 'Spring Rolls', 70.00),
(68, 74, 'Special Wonthon', 30.00),
(69, 73, 'Egg Sandwich', 80.00),
(70, 72, 'Special Sub Sandwich', 200.00),
(71, 71, 'Chicken Sub Sandwich', 100.00),
(72, 70, 'small', 150.00),
(73, 69, 'regular', 140.00),
(74, 68, 'Small', 130.00),
(75, 67, 'regular', 120.00),
(76, 66, 'Lemon And Honey Tea', 30.00),
(77, 65, 'Green Tea Special', 20.00),
(78, 64, 'Masala Tea', 15.00),
(79, 63, 'Squid Fry-large', 1100.00),
(80, 63, 'Squid Fry-medium', 400.00),
(81, 62, 'Salmon Fish Fry-500gm', 700.00),
(82, 60, 'Ice Cream Ship', 600.00),
(83, 59, 'Butter Queen Vanilla', 200.00),
(84, 58, '1:2', 100.00),
(85, 57, 'Dessert Full Pack ', 500.00),
(86, 56, 'Fried Chicken', 30.00),
(87, 55, 'Hot Dog Sandwich', 40.00),
(88, 54, '1:2', 40.00),
(89, 53, '1:1', 50.00),
(90, 52, '1:2', 400.00),
(91, 51, 'Chicken Angara Kabab', 250.00),
(92, 50, 'Creamy Potato Soup', 150.00),
(93, 49, 'Minestrone Soup', 100.00),
(94, 14, 'Strawberry Juice', 20.00),
(95, 13, 'Special Summer', 100.00),
(96, 12, 'Orange juice', 25.00),
(97, 8, 'Tawa Naan', 35.00),
(98, 81, 'Set', 520.00);

-- --------------------------------------------------------

--
-- Table structure for table `waste_tracking`
--

CREATE TABLE `waste_tracking` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `unit` varchar(50) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weekly_holiday`
--

CREATE TABLE `weekly_holiday` (
  `wk_id` int(11) NOT NULL,
  `dayname` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `weekly_holiday`
--

INSERT INTO `weekly_holiday` (`wk_id`, `dayname`) VALUES
(1, 'Friday,Satarday,Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp_settings`
--

CREATE TABLE `whatsapp_settings` (
  `id` int(11) NOT NULL,
  `whatsapp_number` varchar(100) DEFAULT NULL,
  `chatenable` int(11) DEFAULT 0,
  `orderenable` int(11) DEFAULT 0,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `whatsapp_settings`
--

INSERT INTO `whatsapp_settings` (`id`, `whatsapp_number`, `chatenable`, `orderenable`, `status`) VALUES
(1, '242064663469', 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesslog`
--
ALTER TABLE `accesslog`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `acc_account_name`
--
ALTER TABLE `acc_account_name`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `acc_coa`
--
ALTER TABLE `acc_coa`
  ADD PRIMARY KEY (`HeadName`);

--
-- Indexes for table `acc_customer_income`
--
ALTER TABLE `acc_customer_income`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `acc_glsummarybalance`
--
ALTER TABLE `acc_glsummarybalance`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `acc_income_expence`
--
ALTER TABLE `acc_income_expence`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `acc_transaction`
--
ALTER TABLE `acc_transaction`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `acn_account_transaction`
--
ALTER TABLE `acn_account_transaction`
  ADD PRIMARY KEY (`account_tran_id`);

--
-- Indexes for table `add_ons`
--
ALTER TABLE `add_ons`
  ADD PRIMARY KEY (`add_on_id`);

--
-- Indexes for table `award`
--
ALTER TABLE `award`
  ADD PRIMARY KEY (`award_id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `bill_card_payment`
--
ALTER TABLE `bill_card_payment`
  ADD PRIMARY KEY (`row_id`);

--
-- Indexes for table `candidate_basic_info`
--
ALTER TABLE `candidate_basic_info`
  ADD PRIMARY KEY (`can_id`);

--
-- Indexes for table `candidate_education_info`
--
ALTER TABLE `candidate_education_info`
  ADD PRIMARY KEY (`can_edu_id`);

--
-- Indexes for table `candidate_interview`
--
ALTER TABLE `candidate_interview`
  ADD PRIMARY KEY (`can_int_id`);

--
-- Indexes for table `candidate_selection`
--
ALTER TABLE `candidate_selection`
  ADD PRIMARY KEY (`can_sel_id`);

--
-- Indexes for table `candidate_shortlist`
--
ALTER TABLE `candidate_shortlist`
  ADD PRIMARY KEY (`can_short_id`);

--
-- Indexes for table `candidate_workexperience`
--
ALTER TABLE `candidate_workexperience`
  ADD PRIMARY KEY (`can_workexp_id`);

--
-- Indexes for table `check_addones`
--
ALTER TABLE `check_addones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `common_setting`
--
ALTER TABLE `common_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currencyid`);

--
-- Indexes for table `customer_info`
--
ALTER TABLE `customer_info`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_membership_map`
--
ALTER TABLE `customer_membership_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `cutomertype` (`cutomertype`),
  ADD KEY `waiter_id` (`waiter_id`),
  ADD KEY `kitchen` (`kitchen`),
  ADD KEY `thirdpartyinvoiceid` (`thirdpartyinvoiceid`);

--
-- Indexes for table `customer_type`
--
ALTER TABLE `customer_type`
  ADD PRIMARY KEY (`customer_type_id`);

--
-- Indexes for table `custom_table`
--
ALTER TABLE `custom_table`
  ADD PRIMARY KEY (`custom_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `duty_type`
--
ALTER TABLE `duty_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_config`
--
ALTER TABLE `email_config`
  ADD PRIMARY KEY (`email_config_id`);

--
-- Indexes for table `employee_benifit`
--
ALTER TABLE `employee_benifit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_history`
--
ALTER TABLE `employee_history`
  ADD PRIMARY KEY (`emp_his_id`);

--
-- Indexes for table `employee_performance`
--
ALTER TABLE `employee_performance`
  ADD PRIMARY KEY (`emp_per_id`);

--
-- Indexes for table `employee_salary_payment`
--
ALTER TABLE `employee_salary_payment`
  ADD PRIMARY KEY (`emp_sal_pay_id`);

--
-- Indexes for table `employee_salary_setup`
--
ALTER TABLE `employee_salary_setup`
  ADD PRIMARY KEY (`e_s_s_id`);

--
-- Indexes for table `emp_attendance`
--
ALTER TABLE `emp_attendance`
  ADD PRIMARY KEY (`att_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_item`
--
ALTER TABLE `expense_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facebook_settings`
--
ALTER TABLE `facebook_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fcm_token`
--
ALTER TABLE `fcm_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fcm_tokens`
--
ALTER TABLE `fcm_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foodvariable`
--
ALTER TABLE `foodvariable`
  ADD PRIMARY KEY (`availableID`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grand_loan`
--
ALTER TABLE `grand_loan`
  ADD PRIMARY KEY (`loan_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `item_foods`
--
ALTER TABLE `item_foods`
  ADD PRIMARY KEY (`ProductsID`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phrase` (`phrase`);

--
-- Indexes for table `leave_apply`
--
ALTER TABLE `leave_apply`
  ADD PRIMARY KEY (`leave_appl_id`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`leave_type_id`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `license_logs`
--
ALTER TABLE `license_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_installment`
--
ALTER TABLE `loan_installment`
  ADD PRIMARY KEY (`loan_inst_id`);

--
-- Indexes for table `marital_info`
--
ALTER TABLE `marital_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_add_on`
--
ALTER TABLE `menu_add_on`
  ADD PRIMARY KEY (`row_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_permission`
--
ALTER TABLE `module_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_id` (`fk_module_id`),
  ADD KEY `fk_user_id` (`fk_user_id`);

--
-- Indexes for table `module_purchase_key`
--
ALTER TABLE `module_purchase_key`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `multipay_bill`
--
ALTER TABLE `multipay_bill`
  ADD PRIMARY KEY (`multipay_id`);

--
-- Indexes for table `order_menu`
--
ALTER TABLE `order_menu`
  ADD PRIMARY KEY (`row_id`);

--
-- Indexes for table `paymentmethod`
--
ALTER TABLE `paymentmethod`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `paymentsetup`
--
ALTER TABLE `paymentsetup`
  ADD PRIMARY KEY (`setupid`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `payroll_commission_setting`
--
ALTER TABLE `payroll_commission_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_holiday`
--
ALTER TABLE `payroll_holiday`
  ADD PRIMARY KEY (`payrl_holi_id`);

--
-- Indexes for table `payroll_tax_setup`
--
ALTER TABLE `payroll_tax_setup`
  ADD PRIMARY KEY (`tax_setup_id`);

--
-- Indexes for table `pay_frequency`
--
ALTER TABLE `pay_frequency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`pos_id`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`productionid`);

--
-- Indexes for table `production_details`
--
ALTER TABLE `production_details`
  ADD PRIMARY KEY (`pro_detailsid`);

--
-- Indexes for table `purchaseitem`
--
ALTER TABLE `purchaseitem`
  ADD PRIMARY KEY (`purID`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`detailsid`);

--
-- Indexes for table `purchase_return`
--
ALTER TABLE `purchase_return`
  ADD PRIMARY KEY (`preturn_id`);

--
-- Indexes for table `qr_orders`
--
ALTER TABLE `qr_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qr_payments`
--
ALTER TABLE `qr_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `qr_tables`
--
ALTER TABLE `qr_tables`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `rate_type`
--
ALTER TABLE `rate_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservationofday`
--
ALTER TABLE `reservationofday`
  ADD PRIMARY KEY (`offdayid`);

--
-- Indexes for table `rest_table`
--
ALTER TABLE `rest_table`
  ADD PRIMARY KEY (`tableid`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_id` (`fk_module_id`),
  ADD KEY `fk_user_id` (`role_id`);

--
-- Indexes for table `salary_setup_header`
--
ALTER TABLE `salary_setup_header`
  ADD PRIMARY KEY (`s_s_h_id`);

--
-- Indexes for table `salary_sheet_generate`
--
ALTER TABLE `salary_sheet_generate`
  ADD PRIMARY KEY (`ssg_id`);

--
-- Indexes for table `salary_type`
--
ALTER TABLE `salary_type`
  ADD PRIMARY KEY (`salary_type_id`);

--
-- Indexes for table `sec_menu_item`
--
ALTER TABLE `sec_menu_item`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `sec_role_permission`
--
ALTER TABLE `sec_role_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sec_role_tbl`
--
ALTER TABLE `sec_role_tbl`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `sec_user_access_tbl`
--
ALTER TABLE `sec_user_access_tbl`
  ADD PRIMARY KEY (`role_acc_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shift_management`
--
ALTER TABLE `shift_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_method`
--
ALTER TABLE `shipping_method`
  ADD PRIMARY KEY (`ship_id`);

--
-- Indexes for table `sms_configuration`
--
ALTER TABLE `sms_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_template`
--
ALTER TABLE `sms_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribe_emaillist`
--
ALTER TABLE `subscribe_emaillist`
  ADD PRIMARY KEY (`emailid`);

--
-- Indexes for table `sub_order`
--
ALTER TABLE `sub_order`
  ADD PRIMARY KEY (`sub_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supid`);

--
-- Indexes for table `supplier_ledger`
--
ALTER TABLE `supplier_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `synchronizer_setting`
--
ALTER TABLE `synchronizer_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tablelist`
--
ALTER TABLE `tablelist`
  ADD PRIMARY KEY (`tableid`);

--
-- Indexes for table `table_details`
--
ALTER TABLE `table_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_setting`
--
ALTER TABLE `table_setting`
  ADD PRIMARY KEY (`settingid`);

--
-- Indexes for table `tax_settings`
--
ALTER TABLE `tax_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblreservation`
--
ALTER TABLE `tblreservation`
  ADD PRIMARY KEY (`reserveid`);

--
-- Indexes for table `tblserver`
--
ALTER TABLE `tblserver`
  ADD PRIMARY KEY (`serverid`);

--
-- Indexes for table `tbl_assign_kitchen`
--
ALTER TABLE `tbl_assign_kitchen`
  ADD PRIMARY KEY (`assignid`);

--
-- Indexes for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  ADD PRIMARY KEY (`bankid`);

--
-- Indexes for table `tbl_billingaddress`
--
ALTER TABLE `tbl_billingaddress`
  ADD PRIMARY KEY (`billaddressid`);

--
-- Indexes for table `tbl_cancelitem`
--
ALTER TABLE `tbl_cancelitem`
  ADD PRIMARY KEY (`cancelid`);

--
-- Indexes for table `tbl_card_terminal`
--
ALTER TABLE `tbl_card_terminal`
  ADD PRIMARY KEY (`card_terminalid`);

--
-- Indexes for table `tbl_cashcounter`
--
ALTER TABLE `tbl_cashcounter`
  ADD PRIMARY KEY (`ccid`);

--
-- Indexes for table `tbl_cashregister`
--
ALTER TABLE `tbl_cashregister`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`cityid`);

--
-- Indexes for table `tbl_country`
--
ALTER TABLE `tbl_country`
  ADD PRIMARY KEY (`countryid`);

--
-- Indexes for table `tbl_customerpoint`
--
ALTER TABLE `tbl_customerpoint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customerid` (`customerid`);

--
-- Indexes for table `tbl_delivaritime`
--
ALTER TABLE `tbl_delivaritime`
  ADD PRIMARY KEY (`dtimeid`);

--
-- Indexes for table `tbl_delivaryaddress`
--
ALTER TABLE `tbl_delivaryaddress`
  ADD PRIMARY KEY (`delivaryid`);

--
-- Indexes for table `tbl_generatedreport`
--
ALTER TABLE `tbl_generatedreport`
  ADD PRIMARY KEY (`generateid`);

--
-- Indexes for table `tbl_groupitems`
--
ALTER TABLE `tbl_groupitems`
  ADD PRIMARY KEY (`groupid`);

--
-- Indexes for table `tbl_itemaccepted`
--
ALTER TABLE `tbl_itemaccepted`
  ADD PRIMARY KEY (`acid`);

--
-- Indexes for table `tbl_kitchen`
--
ALTER TABLE `tbl_kitchen`
  ADD PRIMARY KEY (`kitchenid`);

--
-- Indexes for table `tbl_kitchen_order`
--
ALTER TABLE `tbl_kitchen_order`
  ADD PRIMARY KEY (`ktid`);

--
-- Indexes for table `tbl_menutype`
--
ALTER TABLE `tbl_menutype`
  ADD PRIMARY KEY (`menutypeid`);

--
-- Indexes for table `tbl_module_purchasekey`
--
ALTER TABLE `tbl_module_purchasekey`
  ADD PRIMARY KEY (`mpid`);

--
-- Indexes for table `tbl_notificationsetting`
--
ALTER TABLE `tbl_notificationsetting`
  ADD PRIMARY KEY (`notifid`);

--
-- Indexes for table `tbl_openclose`
--
ALTER TABLE `tbl_openclose`
  ADD PRIMARY KEY (`stid`);

--
-- Indexes for table `tbl_orderprepare`
--
ALTER TABLE `tbl_orderprepare`
  ADD PRIMARY KEY (`opid`);

--
-- Indexes for table `tbl_posetting`
--
ALTER TABLE `tbl_posetting`
  ADD PRIMARY KEY (`possettingid`);

--
-- Indexes for table `tbl_quickordersetting`
--
ALTER TABLE `tbl_quickordersetting`
  ADD PRIMARY KEY (`quickordid`);

--
-- Indexes for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  ADD PRIMARY KEY (`ratingid`);

--
-- Indexes for table `tbl_room`
--
ALTER TABLE `tbl_room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_seoption`
--
ALTER TABLE `tbl_seoption`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_shippingaddress`
--
ALTER TABLE `tbl_shippingaddress`
  ADD PRIMARY KEY (`shipaddressid`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`slid`);

--
-- Indexes for table `tbl_slider_type`
--
ALTER TABLE `tbl_slider_type`
  ADD PRIMARY KEY (`stype_id`);

--
-- Indexes for table `tbl_sociallink`
--
ALTER TABLE `tbl_sociallink`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `tbl_soundsetting`
--
ALTER TABLE `tbl_soundsetting`
  ADD PRIMARY KEY (`soundid`);

--
-- Indexes for table `tbl_state`
--
ALTER TABLE `tbl_state`
  ADD PRIMARY KEY (`stateid`);

--
-- Indexes for table `tbl_tablefloor`
--
ALTER TABLE `tbl_tablefloor`
  ADD PRIMARY KEY (`tbfloorid`);

--
-- Indexes for table `tbl_thirdparty_customer`
--
ALTER TABLE `tbl_thirdparty_customer`
  ADD PRIMARY KEY (`companyId`);

--
-- Indexes for table `tbl_token`
--
ALTER TABLE `tbl_token`
  ADD PRIMARY KEY (`tokenid`);

--
-- Indexes for table `tbl_updateitems`
--
ALTER TABLE `tbl_updateitems`
  ADD PRIMARY KEY (`updateid`);

--
-- Indexes for table `tbl_version_checker`
--
ALTER TABLE `tbl_version_checker`
  ADD PRIMARY KEY (`vid`);

--
-- Indexes for table `tbl_waiterappcart`
--
ALTER TABLE `tbl_waiterappcart`
  ADD PRIMARY KEY (`weaterappid`);

--
-- Indexes for table `tbl_widget`
--
ALTER TABLE `tbl_widget`
  ADD PRIMARY KEY (`widgetid`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`themeid`);

--
-- Indexes for table `top_menu`
--
ALTER TABLE `top_menu`
  ADD PRIMARY KEY (`menuid`);

--
-- Indexes for table `unit_of_measurement`
--
ALTER TABLE `unit_of_measurement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usedcoupon`
--
ALTER TABLE `usedcoupon`
  ADD PRIMARY KEY (`cusedid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variant`
--
ALTER TABLE `variant`
  ADD PRIMARY KEY (`variantid`);

--
-- Indexes for table `waste_tracking`
--
ALTER TABLE `waste_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weekly_holiday`
--
ALTER TABLE `weekly_holiday`
  ADD PRIMARY KEY (`wk_id`);

--
-- Indexes for table `whatsapp_settings`
--
ALTER TABLE `whatsapp_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesslog`
--
ALTER TABLE `accesslog`
  MODIFY `sl_no` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=427;

--
-- AUTO_INCREMENT for table `acc_account_name`
--
ALTER TABLE `acc_account_name`
  MODIFY `account_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `acc_customer_income`
--
ALTER TABLE `acc_customer_income`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_glsummarybalance`
--
ALTER TABLE `acc_glsummarybalance`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_income_expence`
--
ALTER TABLE `acc_income_expence`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_transaction`
--
ALTER TABLE `acc_transaction`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `acn_account_transaction`
--
ALTER TABLE `acn_account_transaction`
  MODIFY `account_tran_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `add_ons`
--
ALTER TABLE `add_ons`
  MODIFY `add_on_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `award`
--
ALTER TABLE `award`
  MODIFY `award_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `bill_card_payment`
--
ALTER TABLE `bill_card_payment`
  MODIFY `row_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_education_info`
--
ALTER TABLE `candidate_education_info`
  MODIFY `can_edu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_interview`
--
ALTER TABLE `candidate_interview`
  MODIFY `can_int_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_selection`
--
ALTER TABLE `candidate_selection`
  MODIFY `can_sel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_shortlist`
--
ALTER TABLE `candidate_shortlist`
  MODIFY `can_short_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_workexperience`
--
ALTER TABLE `candidate_workexperience`
  MODIFY `can_workexp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `check_addones`
--
ALTER TABLE `check_addones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `common_setting`
--
ALTER TABLE `common_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currencyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_info`
--
ALTER TABLE `customer_info`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `customer_membership_map`
--
ALTER TABLE `customer_membership_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `order_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `customer_type`
--
ALTER TABLE `customer_type`
  MODIFY `customer_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `custom_table`
--
ALTER TABLE `custom_table`
  MODIFY `custom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `duty_type`
--
ALTER TABLE `duty_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `email_config`
--
ALTER TABLE `email_config`
  MODIFY `email_config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_benifit`
--
ALTER TABLE `employee_benifit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_history`
--
ALTER TABLE `employee_history`
  MODIFY `emp_his_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `employee_performance`
--
ALTER TABLE `employee_performance`
  MODIFY `emp_per_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_salary_payment`
--
ALTER TABLE `employee_salary_payment`
  MODIFY `emp_sal_pay_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_salary_setup`
--
ALTER TABLE `employee_salary_setup`
  MODIFY `e_s_s_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emp_attendance`
--
ALTER TABLE `emp_attendance`
  MODIFY `att_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_item`
--
ALTER TABLE `expense_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facebook_settings`
--
ALTER TABLE `facebook_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fcm_token`
--
ALTER TABLE `fcm_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fcm_tokens`
--
ALTER TABLE `fcm_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `foodvariable`
--
ALTER TABLE `foodvariable`
  MODIFY `availableID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grand_loan`
--
ALTER TABLE `grand_loan`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `item_foods`
--
ALTER TABLE `item_foods`
  MODIFY `ProductsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2480;

--
-- AUTO_INCREMENT for table `leave_apply`
--
ALTER TABLE `leave_apply`
  MODIFY `leave_appl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_type`
--
ALTER TABLE `leave_type`
  MODIFY `leave_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `license_logs`
--
ALTER TABLE `license_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_installment`
--
ALTER TABLE `loan_installment`
  MODIFY `loan_inst_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marital_info`
--
ALTER TABLE `marital_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu_add_on`
--
ALTER TABLE `menu_add_on`
  MODIFY `row_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `module_permission`
--
ALTER TABLE `module_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module_purchase_key`
--
ALTER TABLE `module_purchase_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `multipay_bill`
--
ALTER TABLE `multipay_bill`
  MODIFY `multipay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `order_menu`
--
ALTER TABLE `order_menu`
  MODIFY `row_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `paymentmethod`
--
ALTER TABLE `paymentmethod`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `paymentsetup`
--
ALTER TABLE `paymentsetup`
  MODIFY `setupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `payment_method_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_commission_setting`
--
ALTER TABLE `payroll_commission_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payroll_holiday`
--
ALTER TABLE `payroll_holiday`
  MODIFY `payrl_holi_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_tax_setup`
--
ALTER TABLE `payroll_tax_setup`
  MODIFY `tax_setup_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_frequency`
--
ALTER TABLE `pay_frequency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `pos_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `productionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `production_details`
--
ALTER TABLE `production_details`
  MODIFY `pro_detailsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchaseitem`
--
ALTER TABLE `purchaseitem`
  MODIFY `purID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `detailsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_return`
--
ALTER TABLE `purchase_return`
  MODIFY `preturn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `qr_orders`
--
ALTER TABLE `qr_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qr_payments`
--
ALTER TABLE `qr_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qr_tables`
--
ALTER TABLE `qr_tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rate_type`
--
ALTER TABLE `rate_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservationofday`
--
ALTER TABLE `reservationofday`
  MODIFY `offdayid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rest_table`
--
ALTER TABLE `rest_table`
  MODIFY `tableid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_setup_header`
--
ALTER TABLE `salary_setup_header`
  MODIFY `s_s_h_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `salary_sheet_generate`
--
ALTER TABLE `salary_sheet_generate`
  MODIFY `ssg_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_type`
--
ALTER TABLE `salary_type`
  MODIFY `salary_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sec_menu_item`
--
ALTER TABLE `sec_menu_item`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1524;

--
-- AUTO_INCREMENT for table `sec_role_permission`
--
ALTER TABLE `sec_role_permission`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1032;

--
-- AUTO_INCREMENT for table `sec_role_tbl`
--
ALTER TABLE `sec_role_tbl`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sec_user_access_tbl`
--
ALTER TABLE `sec_user_access_tbl`
  MODIFY `role_acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shift_management`
--
ALTER TABLE `shift_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_method`
--
ALTER TABLE `shipping_method`
  MODIFY `ship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms_configuration`
--
ALTER TABLE `sms_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms_template`
--
ALTER TABLE `sms_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subscribe_emaillist`
--
ALTER TABLE `subscribe_emaillist`
  MODIFY `emailid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_order`
--
ALTER TABLE `sub_order`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier_ledger`
--
ALTER TABLE `supplier_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `synchronizer_setting`
--
ALTER TABLE `synchronizer_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tablelist`
--
ALTER TABLE `tablelist`
  MODIFY `tableid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_details`
--
ALTER TABLE `table_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `table_setting`
--
ALTER TABLE `table_setting`
  MODIFY `settingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tax_settings`
--
ALTER TABLE `tax_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblreservation`
--
ALTER TABLE `tblreservation`
  MODIFY `reserveid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblserver`
--
ALTER TABLE `tblserver`
  MODIFY `serverid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_assign_kitchen`
--
ALTER TABLE `tbl_assign_kitchen`
  MODIFY `assignid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  MODIFY `bankid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_billingaddress`
--
ALTER TABLE `tbl_billingaddress`
  MODIFY `billaddressid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_cancelitem`
--
ALTER TABLE `tbl_cancelitem`
  MODIFY `cancelid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_card_terminal`
--
ALTER TABLE `tbl_card_terminal`
  MODIFY `card_terminalid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_cashcounter`
--
ALTER TABLE `tbl_cashcounter`
  MODIFY `ccid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_cashregister`
--
ALTER TABLE `tbl_cashregister`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `cityid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_country`
--
ALTER TABLE `tbl_country`
  MODIFY `countryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_customerpoint`
--
ALTER TABLE `tbl_customerpoint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_delivaritime`
--
ALTER TABLE `tbl_delivaritime`
  MODIFY `dtimeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_delivaryaddress`
--
ALTER TABLE `tbl_delivaryaddress`
  MODIFY `delivaryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_generatedreport`
--
ALTER TABLE `tbl_generatedreport`
  MODIFY `generateid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_groupitems`
--
ALTER TABLE `tbl_groupitems`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_itemaccepted`
--
ALTER TABLE `tbl_itemaccepted`
  MODIFY `acid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `tbl_kitchen`
--
ALTER TABLE `tbl_kitchen`
  MODIFY `kitchenid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_kitchen_order`
--
ALTER TABLE `tbl_kitchen_order`
  MODIFY `ktid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `tbl_menutype`
--
ALTER TABLE `tbl_menutype`
  MODIFY `menutypeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_module_purchasekey`
--
ALTER TABLE `tbl_module_purchasekey`
  MODIFY `mpid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notificationsetting`
--
ALTER TABLE `tbl_notificationsetting`
  MODIFY `notifid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_openclose`
--
ALTER TABLE `tbl_openclose`
  MODIFY `stid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_orderprepare`
--
ALTER TABLE `tbl_orderprepare`
  MODIFY `opid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `tbl_posetting`
--
ALTER TABLE `tbl_posetting`
  MODIFY `possettingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_quickordersetting`
--
ALTER TABLE `tbl_quickordersetting`
  MODIFY `quickordid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  MODIFY `ratingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_seoption`
--
ALTER TABLE `tbl_seoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_shippingaddress`
--
ALTER TABLE `tbl_shippingaddress`
  MODIFY `shipaddressid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `slid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_slider_type`
--
ALTER TABLE `tbl_slider_type`
  MODIFY `stype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_sociallink`
--
ALTER TABLE `tbl_sociallink`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_soundsetting`
--
ALTER TABLE `tbl_soundsetting`
  MODIFY `soundid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_state`
--
ALTER TABLE `tbl_state`
  MODIFY `stateid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_tablefloor`
--
ALTER TABLE `tbl_tablefloor`
  MODIFY `tbfloorid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_thirdparty_customer`
--
ALTER TABLE `tbl_thirdparty_customer`
  MODIFY `companyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_token`
--
ALTER TABLE `tbl_token`
  MODIFY `tokenid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_updateitems`
--
ALTER TABLE `tbl_updateitems`
  MODIFY `updateid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_version_checker`
--
ALTER TABLE `tbl_version_checker`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_waiterappcart`
--
ALTER TABLE `tbl_waiterappcart`
  MODIFY `weaterappid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_widget`
--
ALTER TABLE `tbl_widget`
  MODIFY `widgetid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `themeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `top_menu`
--
ALTER TABLE `top_menu`
  MODIFY `menuid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `unit_of_measurement`
--
ALTER TABLE `unit_of_measurement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `usedcoupon`
--
ALTER TABLE `usedcoupon`
  MODIFY `cusedid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `variant`
--
ALTER TABLE `variant`
  MODIFY `variantid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `waste_tracking`
--
ALTER TABLE `waste_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weekly_holiday`
--
ALTER TABLE `weekly_holiday`
  MODIFY `wk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `whatsapp_settings`
--
ALTER TABLE `whatsapp_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
