-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2024 at 04:05 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurantdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `register_date` date DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `email`, `register_date`, `phone_number`, `password`) VALUES
(1, 'john@gmail.com', '2023-08-31', '+1234567890', 'password123'),
(2, 'susan@gmail.com', '2023-08-30', '+1987654321', 'susanpassword'),
(3, 'james@gmail.com', '2023-08-29', '+18887776666', 'jamespass'),
(4, 'alice@gmail.com', '2023-08-28', '+15555555555', 'alicepassword'),
(5, 'mike@gmail.com', '2023-08-27', '+14444444444', 'mikepass'),
(6, 'lisa@gmail.com', '2023-08-26', '+13333333333', 'lisapassword'),
(7, 'robert@gmail.com', '2023-08-25', '+12222222222', 'robertpass'),
(8, 'emily@gmail.com', '2023-08-24', '+16666666666', 'emilypassword'),
(9, 'david@gmail.com', '2023-08-23', '+1993219999', 'davidp321ass'),
(10, 'ddwd@gmail.com', '2023-08-23', '+1999999329999', 'davidpa2ss'),
(11, 'dadsvawvid@gmail.com', '2023-08-23', '+12234132199', 'david4pass'),
(12, 'davdavid@gmail.com', '2023-08-23', '+123239999', 'davidp13ass'),
(13, 'davvdasid@gmail.com', '2023-08-23', '+1995324319999', 'david2pass'),
(14, '321david@gmail.com', '2023-08-23', '+1942199999', 'davidpa52ss'),
(15, '32avid@gmail.com', '2023-08-23', '+1942193429999', 'da2332ss'),
(16, '321da543vid@gmail.com', '2023-08-23', '+1942132199999', 'dav43a52ss'),
(17, '3211234avid@gmail.com', '2023-08-23', '+194213599999', '32533pa52ss'),
(18, '321543avid@gmail.com', '2023-08-23', '+1942154399999', '754dpa52ss'),
(19, 'rbsjsd@gmail.com', '2023-08-23', '+131351241239', '41f2s'),
(20, 'ol435143ivia@gmail.com', '2023-08-22', '+18888888888', 'oliviapass4215word'),
(21, 'robber@gmail.com', '2023-09-01', '+1234567890', 'password123'),
(22, 'jean@gmail.com', '2023-09-02', '+2345678901', 'password456'),
(23, 'emily@gmail.com', '2023-09-03', '+3456789012', 'password789'),
(24, 'robert@gmail.com', '2023-09-04', '+4567890123', 'passwordabc'),
(25, 'zoe@gmail.com', '2023-09-05', '+5678901234', 'passworddef'),
(26, 'lisa@gmail.com', '2023-09-06', '+6789012345', 'passwordghi'),
(27, 'taylor@gmail.com', '2023-09-07', '+7890123456', 'passwordjkl'),
(28, 'stephan@gmail.com', '2023-09-08', '+8901234567', 'passwordmno'),
(29, 'bruce@gmail.com', '2023-09-09', '+9012345678', 'passwordpqr'),
(30, 'jackie@gmail.com', '2023-09-10', '+0123456789', 'passwordstu'),
(31, 'rubyhen520@gmail.com', '2024-05-11', '+010111111', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `bill_time` datetime DEFAULT NULL,
  `payment_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `staff_id`, `member_id`, `reservation_id`, `table_id`, `card_id`, `payment_method`, `bill_time`, `payment_time`) VALUES
(1, 1, 1, 2220231, 1, 1, 'Card', '2023-09-28 22:45:00', '2023-09-28 22:50:00'),
(2, 1, 5, NULL, 5, NULL, 'Cash', '2023-09-28 19:00:00', '2023-09-28 19:05:00'),
(3, 1, 2, 2220232, 2, 2, 'Card', '2023-09-29 22:45:00', '2023-09-29 22:50:00'),
(4, 2, 3, 1920233, 3, NULL, 'Cash', '2023-09-30 20:15:00', '2023-09-30 20:20:00'),
(5, 2, 4, 2020234, 4, 3, 'Card', '2023-09-30 20:30:00', '2023-09-30 20:35:00'),
(6, 2, 8, NULL, 6, NULL, 'Cash', '2023-09-30 20:15:00', '2023-09-30 20:20:00'),
(7, 3, 5, 1920235, 5, NULL, 'Cash', '2023-10-01 20:15:00', '2023-10-01 20:20:00'),
(8, 3, 6, NULL, 7, NULL, 'Cash', '2023-10-01 19:00:00', '2023-10-01 19:05:00'),
(9, 3, 18, NULL, 2, NULL, 'Cash', '2023-10-01 18:30:00', '2023-10-01 18:35:00'),
(10, 4, 7, NULL, 9, NULL, 'Cash', '2023-10-02 19:30:00', '2023-10-02 19:35:00'),
(11, 4, 17, NULL, 8, NULL, 'Cash', '2023-10-02 20:00:00', '2023-10-02 20:05:00'),
(12, 4, 8, NULL, 10, 4, 'Card', '2023-10-02 19:00:00', '2023-10-02 19:05:00'),
(13, 5, 9, 1820237, 6, 5, 'Card', '2023-10-03 18:45:00', '2023-10-03 18:50:00'),
(14, 5, 16, NULL, 9, NULL, 'Cash', '2023-10-03 19:45:00', '2023-10-03 19:50:00'),
(15, 5, 10, NULL, 5, NULL, 'Cash', '2023-10-03 20:00:00', '2023-10-03 20:05:00'),
(16, 6, 11, NULL, 4, 6, 'Card', '2023-10-03 20:15:00', '2023-10-03 20:20:00'),
(17, 6, 8, NULL, 10, NULL, 'Cash', '2023-10-03 20:30:00', '2023-10-03 20:35:00'),
(18, 6, 12, NULL, 3, 7, 'Card', '2023-10-04 19:30:00', '2023-10-04 19:35:00'),
(19, 7, 13, NULL, 2, NULL, 'Cash', '2023-10-04 19:15:00', '2023-10-04 19:20:00'),
(20, 7, 14, 1920239, 1, NULL, 'Cash', '2023-10-05 20:30:00', '2023-10-05 20:35:00'),
(21, 7, 1, NULL, 6, NULL, 'Cash', '2023-10-05 14:00:00', '2023-10-05 14:05:00'),
(22, 8, 15, NULL, 8, 8, 'Card', '2023-10-05 20:45:00', '2023-10-05 20:50:00'),
(23, 8, 16, NULL, 7, NULL, 'Cash', '2023-10-05 20:00:00', '2023-10-05 20:05:00'),
(24, 8, 2, NULL, 9, NULL, 'Cash', '2023-10-05 19:30:00', '2023-10-05 19:35:00'),
(25, 8, 9, NULL, 4, NULL, 'Cash', '2023-10-05 20:15:00', '2023-10-05 20:20:00'),
(26, 9, 17, NULL, 9, 9, 'Card', '2023-10-05 12:00:00', '2023-10-05 12:05:00'),
(27, 9, 18, NULL, 10, 10, 'Card', '2023-10-06 13:15:00', '2023-10-06 13:20:00'),
(28, 9, 19, 14202310, 8, NULL, 'Cash', '2023-10-06 14:30:00', '2023-10-06 14:35:00'),
(29, 10, 7, NULL, 10, NULL, 'Cash', '2023-10-06 10:45:00', '2023-10-06 10:50:00'),
(30, 10, 20, NULL, 6, NULL, 'Cash', '2023-10-06 14:45:00', '2023-10-06 14:50:00'),
(31, 1, 1, 1111111, 1, NULL, 'cash', '2024-04-15 10:46:15', '2024-04-15 10:48:16'),
(32, 1, 1, 1111111, 1, 11, 'card', '2024-04-15 10:50:25', '2024-04-15 10:51:10'),
(37, 0, 0, 0, 1, NULL, 'cash', '2024-04-20 15:10:25', '2024-04-20 15:10:39'),
(38, 0, 0, 0, 1, NULL, 'cash', '2024-04-20 15:14:41', '2024-04-20 15:14:48'),
(39, 0, 0, 0, 1, NULL, 'cash', '2024-04-20 15:24:41', '2024-04-20 15:24:48'),
(40, 0, 0, 0, 1, NULL, 'cash', '2024-04-20 15:31:39', '2024-04-20 15:37:51'),
(41, 0, 0, 0, 1, 13, 'card', '2024-04-20 15:41:01', '2024-04-20 15:57:34'),
(42, 0, 0, 0, 1, NULL, 'cash', '2024-04-21 17:56:11', '2024-04-21 17:56:30'),
(43, 0, 0, 0, 2, NULL, 'cash', '2024-04-22 15:31:17', '2024-04-28 17:46:03'),
(44, 0, 0, 0, 1, NULL, 'cash', '2024-04-29 18:52:00', '2024-04-30 18:16:24'),
(45, 0, 0, 0, 1, NULL, 'cash', '2024-04-30 18:34:07', '2024-04-30 18:40:15'),
(46, 0, 0, 0, 1, NULL, 'cash', '2024-04-30 18:48:47', '2024-04-30 18:50:58'),
(47, 0, 0, 0, 1, 14, 'card', '2024-04-30 18:51:42', '2024-04-30 19:00:48'),
(48, NULL, NULL, NULL, 6, NULL, NULL, '2024-04-30 19:03:46', NULL),
(49, NULL, NULL, NULL, 7, NULL, NULL, '2024-04-30 19:05:32', NULL),
(50, NULL, NULL, NULL, 8, NULL, NULL, '2024-04-30 19:06:46', NULL),
(51, NULL, NULL, NULL, 9, NULL, NULL, '2024-04-30 19:09:45', NULL),
(52, 0, 0, 0, 10, NULL, 'cash', '2024-04-30 19:13:59', '2024-05-09 20:51:34'),
(53, NULL, NULL, NULL, 5, NULL, NULL, '2024-04-30 19:16:27', NULL),
(54, 0, 0, 0, 3, NULL, 'cash', '2024-04-30 19:17:48', '2024-05-12 05:38:10'),
(55, 0, 0, 0, 1, NULL, 'cash', '2024-04-30 19:20:54', '2024-04-30 19:27:58'),
(56, 0, 0, 0, 2, NULL, 'cash', '2024-04-30 19:23:14', '2024-05-03 04:56:15'),
(57, NULL, NULL, NULL, 4, NULL, NULL, '2024-04-30 19:24:52', NULL),
(58, 0, 0, 0, 1, NULL, 'cash', '2024-04-30 19:28:27', '2024-04-30 19:31:51'),
(59, NULL, NULL, NULL, 1, NULL, NULL, '2024-04-30 19:32:43', NULL),
(60, NULL, NULL, NULL, 1, NULL, NULL, '2024-04-30 19:33:22', NULL),
(61, 0, 0, 0, 1, NULL, 'cash', '2024-04-30 19:34:18', '2024-04-30 19:39:27'),
(62, 0, 1, 0, 1, NULL, 'cash', '2024-04-30 19:39:57', '2024-05-03 12:36:13'),
(63, 0, 0, 0, 2, NULL, 'cash', '2024-05-03 04:56:17', '2024-05-03 09:01:59'),
(64, 0, 0, 0, 2, NULL, 'cash', '2024-05-03 09:02:00', '2024-05-03 09:04:20'),
(65, 0, 0, 0, 2, NULL, 'cash', '2024-05-03 09:04:21', '2024-05-03 09:49:19'),
(66, 0, 0, 0, 2, NULL, 'cash', '2024-05-03 09:49:21', '2024-05-03 11:50:51'),
(67, 0, 1, 0, 2, NULL, 'cash', '2024-05-03 11:50:53', '2024-05-03 12:17:55'),
(68, 0, 0, 0, 2, 15, 'card', '2024-05-03 12:17:57', '2024-05-03 12:21:43'),
(70, NULL, 1, NULL, 2, 16, 'card', '2024-05-03 12:27:42', '2024-05-03 12:28:55'),
(71, NULL, 1, NULL, 2, 17, 'card', '2024-05-03 12:33:53', '2024-05-03 12:34:05'),
(72, 0, 1, 0, 1, NULL, 'cash', '2024-05-03 12:36:15', '2024-05-03 12:39:14'),
(73, 0, 1, 0, 1, NULL, 'cash', '2024-05-03 12:39:16', '2024-05-03 12:41:03'),
(74, 0, 1, 0, 1, NULL, 'cash', '2024-05-03 12:41:04', '2024-05-03 12:48:01'),
(75, 0, 1, 0, 1, NULL, 'cash', '2024-05-03 12:49:36', '2024-05-03 12:49:43'),
(76, NULL, 2, NULL, 1, 18, 'card', '2024-05-03 12:49:46', '2024-05-03 12:51:18'),
(77, 0, 2, 0, 1, NULL, 'cash', '2024-05-03 12:51:22', '2024-05-03 12:52:44'),
(78, 0, 0, 0, 2, NULL, 'cash', '2024-05-03 12:51:36', '2024-05-03 14:11:36'),
(79, NULL, 2, NULL, 1, 19, 'card', '2024-05-03 12:52:47', '2024-05-03 12:53:24'),
(80, 0, 0, 0, 1, 20, 'card', '2024-05-03 12:53:31', '2024-05-03 12:57:15'),
(81, NULL, 2, NULL, 1, 21, 'card', '2024-05-03 13:02:35', '2024-05-03 13:02:55'),
(82, NULL, 2, NULL, 1, 22, 'card', '2024-05-03 13:02:58', '2024-05-03 13:03:26'),
(83, 0, 0, 0, 1, 23, 'card', '2024-05-03 13:06:44', '2024-05-03 13:06:58'),
(84, 0, 0, 0, 1, 24, 'card', '2024-05-03 13:09:26', '2024-05-03 13:09:40'),
(85, 0, 0, 0, 1, 25, 'card', '2024-05-03 13:10:32', '2024-05-03 13:10:44'),
(86, 0, 0, 0, 1, 26, 'card', '2024-05-03 13:12:04', '2024-05-03 13:12:16'),
(87, 0, 0, 0, 1, 27, 'card', '2024-05-03 13:13:40', '2024-05-03 13:13:57'),
(88, NULL, 2, NULL, 1, 28, 'card', '2024-05-03 13:14:16', '2024-05-03 13:14:28'),
(89, NULL, 2, NULL, 1, 29, 'card', '2024-05-03 13:16:21', '2024-05-03 13:16:36'),
(90, NULL, 2, NULL, 1, 30, 'card', '2024-05-03 13:16:39', '2024-05-03 13:18:50'),
(91, 0, 1, 0, 1, NULL, 'cash', '2024-05-03 13:21:10', '2024-05-03 16:36:32'),
(92, 0, 0, 0, 2, NULL, 'cash', '2024-05-03 14:11:39', '2024-05-09 18:43:43'),
(93, 0, 1, 0, 1, NULL, 'cash', '2024-05-03 16:36:41', '2024-05-03 17:39:39'),
(94, 0, 1, 0, 1, NULL, 'cash', '2024-05-03 17:39:41', '2024-05-03 17:41:21'),
(95, 0, 1, 0, 1, NULL, 'cash', '2024-05-03 17:41:24', '2024-05-03 18:02:20'),
(96, 0, 18, 0, 1, NULL, 'cash', '2024-05-03 18:02:21', '2024-05-03 18:02:48'),
(97, 0, 0, 0, 1, NULL, 'cash', '2024-05-03 18:03:19', '2024-05-04 11:21:18'),
(98, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-04 11:21:28', NULL),
(99, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-04 11:22:25', NULL),
(100, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-04 11:22:58', NULL),
(101, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-04 11:25:16', NULL),
(102, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-04 11:26:32', NULL),
(103, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-04 11:26:43', NULL),
(104, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-04 11:26:50', NULL),
(105, 0, 3, 0, 1, NULL, 'cash', '2024-05-04 11:26:58', '2024-05-04 11:27:20'),
(106, 0, 2, 0, 1, NULL, 'cash', '2024-05-04 11:27:21', '2024-05-04 11:29:34'),
(107, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-04 11:29:35', NULL),
(108, 0, 13, 0, 1, NULL, 'cash', '2024-05-04 11:30:26', '2024-05-04 11:30:52'),
(109, 0, 0, 0, 1, NULL, 'cash', '2024-05-04 11:30:53', '2024-05-09 18:05:29'),
(110, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-09 18:05:45', NULL),
(111, 0, 0, 0, 1, NULL, 'cash', '2024-05-09 18:06:40', '2024-05-09 18:23:35'),
(112, 0, 0, 0, 1, 31, 'card', '2024-05-09 18:26:00', '2024-05-09 18:27:32'),
(113, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-09 18:27:47', NULL),
(114, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-09 18:28:51', NULL),
(115, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-09 18:28:52', NULL),
(116, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-09 18:29:08', NULL),
(117, 0, 0, 0, 1, NULL, 'cash', '2024-05-09 18:29:41', '2024-05-09 19:28:23'),
(118, NULL, NULL, NULL, 2, NULL, NULL, '2024-05-09 18:43:52', NULL),
(119, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-09 19:28:25', NULL),
(120, 0, 0, 0, 1, NULL, 'cash', '2024-05-09 19:31:28', '2024-05-09 19:34:05'),
(121, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-09 19:34:06', NULL),
(122, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-09 20:51:35', NULL),
(123, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-09 20:53:42', NULL),
(124, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-09 20:53:57', NULL),
(125, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-09 20:54:32', NULL),
(126, 0, 0, 0, 1, NULL, 'cash', '2024-05-09 20:55:44', '2024-05-09 20:58:02'),
(127, 0, 0, 0, 1, NULL, 'cash', '2024-05-09 20:58:03', '2024-05-10 07:43:41'),
(128, 0, 0, 0, 1, NULL, 'cash', '2024-05-10 07:45:43', '2024-05-10 12:40:19'),
(129, 0, 30, 0, 1, NULL, 'cash', '2024-05-10 12:43:08', '2024-05-10 13:20:24'),
(130, 0, 30, 0, 1, NULL, 'cash', '2024-05-10 13:23:37', '2024-05-10 13:29:58'),
(131, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-10 13:30:03', NULL),
(132, 0, 30, 0, 1, NULL, 'cash', '2024-05-10 13:36:11', '2024-05-10 15:37:42'),
(133, 0, 0, 0, 1, NULL, 'cash', '2024-05-10 15:37:44', '2024-05-10 16:19:47'),
(134, 0, 0, 0, 1, NULL, 'cash', '2024-05-10 16:19:49', '2024-05-10 16:26:08'),
(135, 0, 0, 0, 1, NULL, 'cash', '2024-05-10 16:26:09', '2024-05-10 16:46:53'),
(136, 0, 0, 0, 1, NULL, 'cash', '2024-05-10 16:46:54', '2024-05-10 16:47:05'),
(137, 0, 0, 0, 1, NULL, 'cash', '2024-05-10 16:47:06', '2024-05-11 08:38:31'),
(138, 0, 0, 0, 1, NULL, 'cash', '2024-05-11 08:38:37', '2024-05-11 08:48:38'),
(139, 0, 0, 0, 1, NULL, 'cash', '2024-05-11 08:48:40', '2024-05-11 13:13:51'),
(140, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-11 13:13:52', NULL),
(141, 0, 0, 0, 1, NULL, 'cash', '2024-05-11 13:23:58', '2024-05-11 13:24:27'),
(142, 0, 0, 0, 1, NULL, 'cash', '2024-05-11 13:24:29', '2024-05-11 13:29:19'),
(143, 0, 0, 0, 1, NULL, 'cash', '2024-05-11 13:29:20', '2024-05-11 13:32:06'),
(144, 0, 0, 0, 1, NULL, 'cash', '2024-05-11 13:32:07', '2024-05-11 13:50:35'),
(145, 0, 0, 0, 1, NULL, 'cash', '2024-05-11 13:50:36', '2024-05-11 14:08:18'),
(146, 0, 0, 0, 1, NULL, 'cash', '2024-05-11 14:08:20', '2024-05-11 17:01:04'),
(147, 0, 0, 0, 1, NULL, 'cash', '2024-05-11 17:01:06', '2024-05-11 17:41:17'),
(148, 0, 0, 0, 1, NULL, 'cash', '2024-05-11 17:41:18', '2024-05-11 17:51:50'),
(149, 0, 30, 0, 1, NULL, 'cash', '2024-05-11 17:51:52', '2024-05-12 04:14:36'),
(150, 0, 20, 0, 1, NULL, 'cash', '2024-05-12 04:14:38', '2024-05-12 04:57:56'),
(151, 0, 20, 0, 1, NULL, 'cash', '2024-05-12 04:57:58', '2024-05-12 05:11:28'),
(152, NULL, 20, NULL, 1, 32, 'card', '2024-05-12 05:11:29', '2024-05-12 05:13:51'),
(153, NULL, 20, NULL, 1, 33, 'card', '2024-05-12 05:13:53', '2024-05-12 05:19:33'),
(154, 0, 20, 0, 1, NULL, 'cash', '2024-05-12 05:19:34', '2024-05-12 05:36:26'),
(155, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-12 05:37:37', NULL),
(156, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-12 05:37:45', NULL),
(157, NULL, NULL, NULL, 3, NULL, NULL, '2024-05-12 05:38:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bill_items`
--

CREATE TABLE `bill_items` (
  `bill_item_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `item_id` varchar(6) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_items`
--

INSERT INTO `bill_items` (`bill_item_id`, `bill_id`, `item_id`, `quantity`) VALUES
(1, 1, 'MD1', 2),
(2, 1, 'MD15', 1),
(3, 1, 'S3', 2),
(4, 1, 'L1', 1),
(5, 2, 'MD2', 1),
(6, 2, 'MD5', 2),
(7, 2, 'MD16', 1),
(8, 2, 'S5', 2),
(9, 2, 'L2', 1),
(10, 2, 'HC2', 2),
(11, 3, 'MD19', 1),
(12, 3, 'MD2', 1),
(13, 3, 'MD4', 1),
(14, 3, 'S6', 2),
(15, 3, 'L3', 1),
(16, 3, 'HC3', 2),
(17, 4, 'MD23', 1),
(18, 4, 'MD9', 1),
(19, 4, 'L2', 2),
(20, 4, 'C3', 1),
(21, 4, 'HC4', 2),
(22, 5, 'MD23', 1),
(23, 5, 'S1', 1),
(24, 5, 'S8', 2),
(25, 5, 'L5', 1),
(26, 5, 'HC5', 2),
(27, 6, 'MD23', 1),
(28, 6, 'MD21', 1),
(29, 6, 'C1', 1),
(30, 6, 'C2', 2),
(31, 7, 'MD23', 1),
(32, 7, 'S1', 1),
(33, 7, 'S4', 1),
(34, 7, 'C3', 1),
(35, 7, 'C4', 2),
(36, 8, 'MD23', 1),
(37, 8, 'L2', 1),
(38, 8, 'C3', 1),
(39, 8, 'L5', 1),
(40, 8, 'C4', 2),
(41, 8, 'M1', 1),
(42, 8, 'M2', 2),
(43, 9, 'MD23', 1),
(44, 9, 'M1', 1),
(45, 9, 'M4', 1),
(46, 9, 'M2', 1),
(47, 9, 'M5', 2),
(48, 9, 'M6', 1),
(49, 9, 'HD1', 2),
(50, 10, 'SK3', 1),
(51, 10, 'SK6', 1),
(52, 10, 'CP1', 1),
(53, 10, 'CP2', 1),
(54, 10, 'CP3', 2),
(55, 10, 'CP4', 1),
(56, 10, 'CP5', 2),
(57, 11, 'MD1', 2),
(58, 11, 'MD15', 1),
(59, 11, 'S3', 2),
(60, 11, 'L1', 1),
(61, 12, 'MD2', 1),
(62, 12, 'MD5', 2),
(63, 12, 'MD16', 1),
(64, 12, 'S5', 2),
(65, 12, 'L2', 1),
(66, 12, 'HC2', 2),
(67, 13, 'MD19', 1),
(68, 13, 'MD2', 1),
(69, 13, 'MD4', 1),
(70, 13, 'S6', 2),
(71, 13, 'L3', 1),
(72, 13, 'HC3', 2),
(73, 14, 'MD23', 1),
(74, 14, 'MD9', 1),
(75, 14, 'L2', 2),
(76, 14, 'C3', 1),
(77, 14, 'HC4', 2),
(78, 15, 'MD23', 1),
(79, 15, 'S1', 1),
(80, 15, 'S8', 2),
(81, 15, 'L5', 1),
(82, 15, 'HC5', 2),
(83, 16, 'MD23', 1),
(84, 16, 'MD21', 1),
(85, 16, 'C1', 1),
(86, 16, 'C2', 2),
(87, 17, 'MD23', 1),
(88, 17, 'MD41', 1),
(89, 17, 'S4', 1),
(90, 17, 'C3', 1),
(91, 17, 'C4', 2),
(92, 18, 'MD23', 1),
(93, 18, 'MD32', 1),
(94, 18, 'MD33', 1),
(95, 18, 'L5', 1),
(96, 18, 'C4', 2),
(97, 18, 'M1', 1),
(98, 18, 'M2', 2),
(99, 19, 'MD23', 1),
(100, 19, 'M1', 1),
(101, 19, 'M4', 1),
(102, 19, 'MD29', 1),
(103, 19, 'M5', 2),
(104, 19, 'M6', 1),
(105, 19, 'HD1', 2),
(106, 20, 'MD42', 1),
(107, 20, 'SK6', 1),
(108, 20, 'CP1', 1),
(109, 20, 'CP2', 1),
(110, 20, 'CP3', 2),
(111, 20, 'CP4', 1),
(112, 20, 'CP5', 2),
(113, 21, 'MD1', 2),
(114, 21, 'MD15', 1),
(115, 21, 'S3', 2),
(116, 21, 'S1', 1),
(117, 22, 'MD2', 1),
(118, 22, 'MD5', 2),
(119, 22, 'MD16', 1),
(120, 22, 'S5', 2),
(121, 22, 'SK2', 1),
(122, 22, 'HC2', 2),
(123, 23, 'MD9', 1),
(124, 23, 'MD21', 1),
(125, 23, 'M6', 1),
(126, 23, 'SK6', 2),
(127, 23, 'L9', 1),
(128, 23, 'HC5', 2),
(129, 24, 'MD23', 1),
(130, 24, 'HD2', 1),
(131, 24, 'MD2', 2),
(132, 24, 'M3', 1),
(133, 24, 'HC1', 2),
(134, 25, 'MD2', 1),
(135, 25, 'MD21', 1),
(136, 25, 'MD8', 2),
(137, 25, 'L5', 1),
(138, 25, 'HC5', 2),
(139, 26, 'MD23', 1),
(140, 26, 'MD21', 1),
(141, 26, 'C1', 1),
(142, 26, 'C2', 2),
(143, 27, 'MD23', 1),
(144, 27, 'MD11', 1),
(145, 27, 'MD4', 1),
(146, 27, 'C3', 1),
(147, 27, 'C4', 2),
(148, 28, 'MD23', 1),
(149, 28, 'MD22', 1),
(150, 28, 'M3', 1),
(151, 28, 'CP5', 1),
(152, 28, 'SK4', 2),
(153, 28, 'M1', 1),
(154, 28, 'MD2', 2),
(155, 29, 'MD23', 1),
(156, 29, 'M1', 1),
(157, 29, 'M4', 1),
(158, 29, 'MD2', 1),
(159, 29, 'M5', 2),
(160, 29, 'CP1', 1),
(161, 29, 'HD1', 2),
(162, 30, 'MD3', 1),
(163, 30, 'MD6', 1),
(164, 30, 'MD11', 1),
(165, 30, 'MD22', 1),
(166, 30, 'CP3', 2),
(167, 30, 'CP4', 1),
(168, 30, 'CP5', 2),
(169, 31, 'D1', 3),
(170, 32, 'D2', 100),
(173, 33, 'D1', 1),
(174, 35, 'D2', 3),
(175, 36, 'MD1', 4),
(176, 37, 'MD2', 4),
(177, 38, 'D1', 1),
(178, 39, 'MD3', 5),
(179, 40, 'D3', 4),
(180, 41, 'D1', 1),
(181, 42, 'D1', 2),
(183, 43, 'D1', 2),
(185, 43, 'D2', 2),
(186, 44, 'D1', 2),
(187, 45, 'D1', 3),
(188, 46, 'MD2', 4),
(189, 47, 'MDe5', 10),
(190, 55, 'MD1', 4),
(191, 58, 'D3', 5),
(192, 61, 'D1', 2),
(235, 56, 'D1', 1),
(238, 63, 'D1', 2),
(239, 64, 'D1', 1),
(243, 65, 'D1', 5),
(244, 65, 'D2', 4),
(245, 66, 'D1', 1),
(246, 67, 'D1', 1),
(247, 68, 'D1', 2),
(248, 70, 'MD1', 4),
(249, 71, 'D2', 3),
(250, 62, 'D1', 1),
(251, 72, 'D1', 1),
(252, 73, 'D1', 1),
(253, 74, 'D1', 1),
(254, 75, 'D1', 1),
(255, 76, 'D1', 1),
(256, 77, 'D1', 1),
(257, 79, 'D2', 1),
(258, 80, 'D1', 1),
(259, 81, 'MD2', 4),
(260, 82, 'D1', 1),
(261, 83, 'D1', 1),
(262, 84, 'D1', 1),
(263, 85, 'D1', 23),
(264, 86, 'D1', 1),
(265, 87, 'D1', 1),
(266, 88, 'D1', 1),
(267, 89, 'D1', 3),
(268, 90, 'D1', 3),
(270, 78, 'D1', 1),
(273, 91, 'D1', 1),
(274, 93, 'D1', 1),
(275, 94, 'D1', 1),
(276, 95, 'D1', 1),
(277, 96, 'D1', 1),
(288, 97, 'D1', 1),
(289, 105, 'D1', 1),
(290, 106, 'D1', 1),
(291, 108, 'D1', 1),
(308, 109, 'D1', 1),
(309, 111, 'D1', 1),
(310, 112, 'D1', 1),
(311, 92, 'D1', 1),
(313, 120, 'D1', 1),
(315, 126, 'D1', 1),
(317, 127, 'D1', 1),
(318, 127, 'D2', 2),
(320, 129, 'D1', 1),
(321, 130, 'D1', 1),
(323, 132, 'D1', 1),
(326, 133, 'D1', 1),
(329, 134, 'D1', 1),
(330, 135, 'D1', 1),
(331, 136, 'D1', 1),
(333, 137, 'D1', 1),
(334, 138, 'D1', 1),
(336, 139, 'D1', 2),
(337, 141, 'D1', 1),
(338, 142, 'D1', 1),
(339, 143, 'D1', 1),
(341, 144, 'D1', 1),
(342, 145, 'D1', 3),
(343, 145, 'MD1', 3),
(346, 146, 'D1', 3),
(347, 146, 'D2', 2),
(348, 146, 'D3', 4),
(370, 147, 'D1', 1),
(371, 148, 'D1', 1),
(372, 148, 'D2', 1),
(375, 149, 'D1', 1),
(377, 150, 'D1', 1),
(378, 151, 'D1', 1),
(379, 152, 'D1', 1),
(380, 153, 'D1', 1),
(381, 154, 'D1', 1),
(382, 54, 'D1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `card_payments`
--

CREATE TABLE `card_payments` (
  `card_id` int(11) NOT NULL,
  `account_holder_name` varchar(255) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `expiry_date` varchar(7) NOT NULL,
  `security_code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `card_payments`
--

INSERT INTO `card_payments` (`card_id`, `account_holder_name`, `card_number`, `expiry_date`, `security_code`) VALUES
(1, 'John Smith', '1234567890123456', '10/15', '123'),
(2, 'Susan Johnson', '2345678901234567', '10/24', '456'),
(3, 'James Brown', '3456789012345678', '09/30', '789'),
(4, 'Alice Davis', '4567890123456789', '09/28', '321'),
(5, 'Mike Wilson', '5678901234567890', '09/29', '654'),
(6, 'Robert Miller', '7890123456789012', '10/19', '123'),
(7, 'Abbel TuTuTu', '1234123412341234', '10/25', '654'),
(8, 'Abignail Downey', '2345234523452345', '10/24', '987'),
(9, 'Jamie Mustafa', '3456345634563456', '09/23', '123'),
(10, 'Luke Gun Slinger', '4567456745674567', '09/22', '456'),
(11, 'awdwa', '1232132132132313', '11/2029', '111'),
(12, 'aaa', '1233', '08/2023', ''),
(13, 'aaa', '1233', '08/2023', ''),
(14, 'awdwaas', '3333', '08/2025', ''),
(15, 'awdwadd', '1222', '08/2024', ''),
(16, 'tubel', '2123', '08/2023', ''),
(17, 'awdwaaas', '1122', '08/2021', ''),
(18, 'awdwassa', '3312', '08/2035', ''),
(19, 'awdwa', '1233', '08/2021', ''),
(20, 'awdwa', '1222', '01/2023', ''),
(21, 'awdwaas', '2332', '07/2022', ''),
(22, 'aaa', '1321', '08/2023', ''),
(23, 'awdwa', '1111', '01/2023', ''),
(24, 'aaa', '1231', '11/2023', ''),
(25, 'ada', '1311', '11/2012', ''),
(26, 'adwa', '1111', '12/2022', ''),
(27, 'aaa', '0911', '11/2201', ''),
(28, 'aaa', '1331', '08/2021', ''),
(29, 'awdwa', '1113', '08/2012', ''),
(30, 'ada', '1113', '11/2021', ''),
(31, 'aaa', '1111', '08/2023', ''),
(32, 'aaa', '1111', '08/2024', ''),
(33, 'aaa', '1111', '08/2025', '');

-- --------------------------------------------------------

--
-- Table structure for table `kitchen`
--

CREATE TABLE `kitchen` (
  `kitchen_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `item_id` varchar(6) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `time_submitted` datetime DEFAULT NULL,
  `time_ended` datetime DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `kit_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kitchen`
--

INSERT INTO `kitchen` (`kitchen_id`, `bill_id`, `table_id`, `item_id`, `quantity`, `time_submitted`, `time_ended`, `remarks`, `kit_status`) VALUES
(1, 0, 6, 'SK3', 4, '2023-10-03 18:45:00', '2023-10-03 18:46:00', NULL, 0),
(2, 0, 6, 'CP2', 3, '2023-10-03 18:45:00', '2023-10-03 18:46:00', NULL, 0),
(3, 0, 5, 'S3', 5, '2023-10-03 20:00:00', '2023-10-03 20:46:00', NULL, 0),
(4, 0, 5, 'MD15', 2, '2023-10-03 14:45:00', '2023-10-03 14:46:00', NULL, 0),
(6, 0, 1, 'MD15', 2, '2023-09-28 22:45:00', '2023-09-28 23:00:00', '12', 1),
(7, 0, 1, 'S3', 1, '2023-09-28 22:45:00', '2023-09-28 23:00:00', '12', 1),
(8, 0, 1, 'L1', 1, '2023-09-28 22:45:00', '2023-09-28 23:00:00', '12', 1),
(9, 0, 5, 'MD2', 1, '2023-09-28 19:00:00', '2023-09-28 19:15:00', NULL, 0),
(10, 0, 5, 'MD5', 1, '2023-09-28 19:00:00', '2023-09-28 19:15:00', NULL, 0),
(11, 0, 5, 'MD16', 1, '2023-09-28 19:00:00', '2023-09-28 19:15:00', NULL, 0),
(12, 0, 5, 'S5', 1, '2023-09-28 19:00:00', '2023-09-28 19:15:00', NULL, 0),
(13, 0, 5, 'L2', 2, '2023-09-28 19:00:00', '2023-09-28 19:15:00', NULL, 0),
(14, 0, 5, 'HC2', 1, '2023-09-28 19:00:00', '2023-09-28 19:15:00', NULL, 0),
(15, 0, 2, 'MD19', 2, '2023-09-29 22:45:00', '2023-09-29 23:00:00', NULL, 1),
(16, 0, 2, 'MD2', 1, '2023-09-29 22:45:00', '2023-09-29 23:00:00', NULL, 1),
(17, 0, 2, 'MD4', 2, '2023-09-29 22:45:00', '2023-09-29 23:00:00', NULL, 1),
(18, 0, 2, 'S6', 2, '2023-09-29 22:45:00', '2023-09-29 23:00:00', NULL, 1),
(19, 0, 2, 'L3', 1, '2023-09-29 22:45:00', '2023-09-29 23:00:00', NULL, 1),
(20, 0, 2, 'HC3', 1, '2023-09-29 22:45:00', '2023-09-29 23:00:00', NULL, 1),
(21, 0, 10, 'MD23', 1, '2023-10-06 10:45:00', '2024-04-28 16:29:49', NULL, 0),
(22, 0, 10, 'MD2', 1, '2023-10-06 10:45:00', '2024-04-28 17:29:19', NULL, 0),
(23, 0, 6, 'MD22', 1, '2023-10-06 14:45:00', '2024-04-28 16:30:24', NULL, 0),
(24, 0, 6, 'CP5', 2, '2023-10-06 14:45:00', '2024-04-28 16:31:02', NULL, 0),
(44, 0, 1, 'MDe5', 10, '2024-04-30 18:59:31', '2024-05-03 05:23:41', '12', 1),
(97, 0, 2, 'D2', 4, '2024-05-03 09:49:12', '2024-05-03 09:49:24', NULL, 1),
(101, 0, 2, 'MD1', 4, '2024-05-03 12:28:30', '2024-05-03 14:10:59', NULL, 1),
(102, 0, 2, 'D2', 3, '2024-05-03 12:33:56', '2024-05-03 14:11:00', NULL, 1),
(225, 148, 1, 'D2', 1, '2024-05-11 17:41:24', '2024-05-12 05:38:56', '', 1),
(235, 54, 3, 'D1', 1, '2024-05-12 05:38:04', '2024-05-12 05:38:58', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `member_id` int(11) NOT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`member_id`, `member_name`, `points`, `account_id`) VALUES
(1, 'Abbel TuTuTu', 11, 11),
(2, 'Abignail Downey ', 255, 12),
(3, 'Jamie Mustafa', 311, 13),
(4, 'Luke Gun Slinger', 400, 14),
(5, 'Johny Rings', 500, 15),
(6, 'Wee Tuu Low', 600, 16),
(7, 'Sum Ting Wong', 700, 17),
(8, 'Ho Lee Fuk', 800, 18),
(9, 'Bang Ding Ow', 900, 19),
(10, 'Rocky Rocket', 1000, 20),
(11, 'Robber Hellington', 250, 21),
(12, 'Jean Ng', 300, 22),
(13, 'Emily Davis', 411, 23),
(14, 'Robert Wilson', 550, 24),
(15, 'Zoe Chong', 650, 25),
(16, 'Lisa Chia', 750, 26),
(17, 'Taylor Swift', 900, 27),
(18, 'Stephan Curry', 561, 28),
(19, 'Bruce Lee', 1200, 29),
(20, 'Jackie Chan', 427, 30);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `item_id` varchar(6) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_category` varchar(255) DEFAULT NULL,
  `item_price` decimal(10,2) DEFAULT NULL,
  `item_description` varchar(255) DEFAULT NULL,
  `item_img` varchar(255) NOT NULL,
  `item_status` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`item_id`, `item_name`, `item_category`, `item_price`, `item_description`, `item_img`, `item_status`) VALUES
('D1', 'Teh O Ais', 'Drinks', '10.00', ' Sweet and bitter drinks ', '661ce3d99b6a1.jpg', '1'),
('D2', 'Grape Milk Tea', 'Drinks', '11.00', 'Combination of Milk + Grape jus', '661ce4bf0bd79.jpg', '1'),
('D3', 'Milo Ais With Cute Cat Bottle', 'Drinks', '9.00', 'You can keep the Cat Bottle as the souvenir', '661ce5ca40ca3.jpg', '1'),
('MD1', 'Classic Ramen', 'Main Dishes', '11.00', 'Maggie + Cole slaw + Frech Fries', '661ce64d3bbce.jpg', '1'),
('MD2', 'Spaghetti with Fried Chicken', 'Main Dishes', '11.00', 'bolognese sauce spaghetti, fried chicken and Mayonnaise', '661ce7384909b.jpg', '1'),
('MD3', 'Lemon Grilled Chicken Pasta', 'Main Dishes', '12.00', 'Marinated rosemary grilled chicken breast served with mashed potatoes and your choice of pasta.', '661ce8e42e30e.jpg', '1'),
('MD4', 'Chicken Fried Rice', 'Main Dishes', '10.00', 'fried rice and fired chicken', '661ce8c3cd1d6.jpg', '1'),
('MDe5', 'Crispy Chicken Strips', 'Side Snacks', '8.00', 'Fried chicken strips, served with special honey mustard sauce.', '661ce916cc6bf.jpg', '1'),
('SD1', 'Fried Chicken Only', 'Side Snacks', '14.00', '3 pieces fried chicken with Hot Spicy Chili Sauce in a plate', '661ce787c9639.jpg', '1'),
('SD2', 'Classic Burger', 'Side Snacks', '13.00', 'chicken burger and french fries', '661ce8a7d8952.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `head_count` int(11) DEFAULT NULL,
  `special_request` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `customer_name`, `table_id`, `reservation_time`, `reservation_date`, `head_count`, `special_request`) VALUES
(1111111, 'Default', 9, '19:15:00', '2023-10-05', 2, 'Description'),
(1820237, 'Jean Ng', 7, '18:30:00', '2023-10-03', 2, 'Allergies: peanuts'),
(1920233, 'Jamie Mustafa', 3, '19:30:00', '2023-09-30', 2, 'Vegan options needed'),
(1920235, 'Johny Rings', 5, '19:45:00', '2023-10-01', 2, 'Quiet corner, please'),
(1920239, 'Taylor Swift', 9, '19:15:00', '2023-10-05', 2, 'Surprise dessert for anniversary'),
(2020234, 'Luke Gun Slinger', 4, '20:00:00', '2023-09-30', 3, 'Birthday celebration'),
(2220231, 'Abbel Tu Far Behind', 1, '22:00:34', '2023-09-28', 1, 'Prepare Panadol for me'),
(2220232, 'Abignaile Lin Downney Jr', 2, '22:00:34', '2023-09-29', 1, 'Default Special Request'),
(14202310, 'Bruce Lee', 10, '14:45:00', '2023-10-06', 3, 'Window seat, if available');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_tables`
--

CREATE TABLE `restaurant_tables` (
  `table_id` int(11) NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_tables`
--

INSERT INTO `restaurant_tables` (`table_id`, `capacity`, `is_available`) VALUES
(1, 4, 1),
(2, 4, 1),
(3, 4, 1),
(4, 6, 1),
(5, 6, 1),
(6, 6, 1),
(7, 6, 1),
(8, 8, 1),
(9, 8, 1),
(10, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`staff_id`, `staff_name`, `role`, `account_id`) VALUES
(1, 'John Smith', 'Waiter', 1),
(10, 'Olivia Anderson', 'Chef', 10),
(31, 'Admin', 'Admin', 31);

-- --------------------------------------------------------

--
-- Table structure for table `table_availability`
--

CREATE TABLE `table_availability` (
  `availability_id` int(11) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD PRIMARY KEY (`bill_item_id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `card_payments`
--
ALTER TABLE `card_payments`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `kitchen`
--
ALTER TABLE `kitchen`
  ADD PRIMARY KEY (`kitchen_id`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `table_id` (`table_id`);

--
-- Indexes for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `table_availability`
--
ALTER TABLE `table_availability`
  ADD PRIMARY KEY (`availability_id`),
  ADD KEY `table_id` (`table_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `bill_items`
--
ALTER TABLE `bill_items`
  MODIFY `bill_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- AUTO_INCREMENT for table `card_payments`
--
ALTER TABLE `card_payments`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `kitchen`
--
ALTER TABLE `kitchen`
  MODIFY `kitchen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14202311;

--
-- AUTO_INCREMENT for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `table_availability`
--
ALTER TABLE `table_availability`
  MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staffs` (`staff_id`),
  ADD CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `memberships` (`member_id`),
  ADD CONSTRAINT `bills_ibfk_3` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`),
  ADD CONSTRAINT `bills_ibfk_4` FOREIGN KEY (`table_id`) REFERENCES `restaurant_tables` (`table_id`),
  ADD CONSTRAINT `bills_ibfk_5` FOREIGN KEY (`card_id`) REFERENCES `card_payments` (`card_id`);

--
-- Constraints for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD CONSTRAINT `bill_items_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`),
  ADD CONSTRAINT `bill_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu` (`item_id`);

--
-- Constraints for table `kitchen`
--
ALTER TABLE `kitchen`
  ADD CONSTRAINT `kitchen_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `restaurant_tables` (`table_id`),
  ADD CONSTRAINT `kitchen_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu` (`item_id`);

--
-- Constraints for table `memberships`
--
ALTER TABLE `memberships`
  ADD CONSTRAINT `memberships_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `restaurant_tables` (`table_id`);

--
-- Constraints for table `staffs`
--
ALTER TABLE `staffs`
  ADD CONSTRAINT `staffs_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`);

--
-- Constraints for table `table_availability`
--
ALTER TABLE `table_availability`
  ADD CONSTRAINT `table_availability_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `restaurant_tables` (`table_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
