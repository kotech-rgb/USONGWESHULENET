-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2025 at 12:51 PM
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
-- Database: `shule_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('academic@gmail.com|127.0.0.1', 'i:1;', 1756396758),
('academic@gmail.com|127.0.0.1:timer', 'i:1756396758;', 1756396758),
('dsjdsd@gmail.com|127.0.0.1', 'i:1;', 1755189458),
('dsjdsd@gmail.com|127.0.0.1:timer', 'i:1755189458;', 1755189458),
('unknown@gmail.com|127.0.0.1', 'i:1;', 1755614494),
('unknown@gmail.com|127.0.0.1:timer', 'i:1755614494;', 1755614494);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `school_reg` varchar(100) NOT NULL,
  `box` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `reg_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`id`, `school_name`, `school_reg`, `box`, `location`, `reg_number`, `created_at`, `updated_at`) VALUES
(1, 'USONGWE SECONDARY SCHOOL', 'S0913', 'P.O.BOX 599', 'MBEYA DISTRIC COUNCIL', 'S1467', NULL, '2025-08-29 03:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `darasas`
--

CREATE TABLE `darasas` (
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `darasas`
--

INSERT INTO `darasas` (`name`, `created_at`, `updated_at`) VALUES
('FORM FIVE HGFa ', '2025-08-29 06:59:15', '2025-08-29 06:59:15'),
('FORM FIVE HGL ', '2025-08-28 14:37:27', '2025-08-28 14:37:27'),
('FORM FIVE HKL ', '2025-08-28 11:06:27', '2025-08-28 11:06:27'),
('FORM FOUR A', '2025-08-28 06:40:33', '2025-08-28 06:40:33'),
('FORM FOUR B', '2025-08-28 06:40:39', '2025-08-28 06:40:39'),
('FORM FOUR C', '2025-08-28 06:40:44', '2025-08-28 06:40:44'),
('FORM FOUR D', '2025-08-28 06:40:49', '2025-08-28 06:40:49'),
('FORM FOUR E', '2025-08-28 06:40:55', '2025-08-28 06:40:55'),
('FORM ONE A', '2025-08-28 06:37:31', '2025-08-28 06:37:31'),
('FORM ONE B', '2025-08-28 06:37:37', '2025-08-28 06:37:37'),
('FORM ONE C', '2025-08-28 06:37:42', '2025-08-28 06:37:42'),
('FORM ONE D', '2025-08-28 06:37:48', '2025-08-28 06:37:48'),
('FORM ONE E', '2025-08-28 06:37:54', '2025-08-28 06:37:54'),
('FORM ONE F', '2025-08-28 06:38:01', '2025-08-28 06:38:01'),
('FORM ONE G', '2025-08-28 06:38:07', '2025-08-28 06:38:07'),
('FORM ONE H', '2025-08-28 06:38:15', '2025-08-28 06:38:15'),
('FORM THREE A', '2025-08-28 06:39:18', '2025-08-28 06:39:18'),
('FORM THREE B', '2025-08-28 06:39:30', '2025-08-28 06:39:30'),
('FORM THREE C', '2025-08-28 06:39:36', '2025-08-28 06:39:36'),
('FORM THREE D', '2025-08-28 06:39:43', '2025-08-28 06:39:43'),
('FORM THREE E', '2025-08-28 06:39:50', '2025-08-28 06:39:50'),
('FORM THREE F', '2025-08-28 06:40:04', '2025-08-28 06:40:04'),
('FORM THREE G', '2025-08-28 06:40:10', '2025-08-28 06:40:10'),
('FORM THREE H', '2025-08-28 06:40:16', '2025-08-28 06:40:16'),
('FORM TWO A', '2025-08-28 06:38:23', '2025-08-28 06:38:23'),
('FORM TWO B', '2025-08-28 06:38:30', '2025-08-28 06:38:30'),
('FORM TWO C', '2025-08-28 06:38:35', '2025-08-28 06:38:35'),
('FORM TWO D', '2025-08-28 06:38:40', '2025-08-28 06:38:40'),
('FORM TWO E', '2025-08-28 06:38:46', '2025-08-28 06:38:46'),
('FORM TWO F', '2025-08-28 06:38:51', '2025-08-28 06:38:51'),
('FORM TWO G', '2025-08-28 06:38:57', '2025-08-28 06:38:57'),
('FORM TWO H', '2025-08-28 06:39:03', '2025-08-28 06:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int(11) NOT NULL,
  `div_name` varchar(10) NOT NULL,
  `start_point` int(11) NOT NULL,
  `end_point` int(11) NOT NULL,
  `level` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `div_name`, `start_point`, `end_point`, `level`, `created_at`, `updated_at`) VALUES
(1, 'I', 7, 17, 'O-level', NULL, '2025-08-31 04:37:39'),
(2, 'II', 18, 21, 'O-level', NULL, '2025-08-31 04:30:31'),
(3, 'III', 22, 25, 'O-level', NULL, '2025-08-31 04:30:38'),
(4, 'IV', 26, 33, 'O-level', NULL, '2025-08-31 07:11:09'),
(5, 'O', 34, 35, 'O-level', NULL, '2025-08-31 04:38:49'),
(6, 'I', 3, 9, 'A-level', NULL, '2025-08-31 04:47:00'),
(7, 'II', 10, 12, 'A-level', NULL, '2025-08-31 04:47:18'),
(8, 'III', 13, 17, 'A-level', NULL, '2025-08-31 04:47:33'),
(9, 'IV', 18, 19, 'A-level', NULL, '2025-08-31 04:47:47'),
(10, 'O', 20, 21, 'A-level', NULL, '2025-08-31 04:48:03');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `studentE` int(10) UNSIGNED NOT NULL,
  `subjectE` varchar(255) NOT NULL,
  `classE` varchar(100) NOT NULL,
  `test` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `total_average` int(11) GENERATED ALWAYS AS (case when `test` is null then `score` else (`test` + `score`) / 2 end) VIRTUAL,
  `termE` varchar(255) NOT NULL,
  `yearE` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `studentE`, `subjectE`, `classE`, `test`, `score`, `termE`, `yearE`, `created_at`, `updated_at`) VALUES
(35, 15, 'BASIC MATHEMATICS', 'FORM ONE A', 35, 40, 'SECOND MID-TERM', '2025', '2025-08-28 16:08:32', '2025-08-28 16:08:32'),
(36, 16, 'BASIC MATHEMATICS', 'FORM ONE A', 23, 34, 'SECOND MID-TERM', '2025', '2025-08-28 16:08:32', '2025-08-29 02:54:59'),
(37, 17, 'BASIC MATHEMATICS', 'FORM ONE A', 22, 23, 'SECOND MID-TERM', '2025', '2025-08-28 16:08:33', '2025-08-29 02:54:59'),
(38, 18, 'BASIC MATHEMATICS', 'FORM ONE A', 32, 45, 'SECOND MID-TERM', '2025', '2025-08-28 16:08:33', '2025-08-29 02:54:59'),
(39, 19, 'BASIC MATHEMATICS', 'FORM ONE A', 23, 22, 'SECOND MID-TERM', '2025', '2025-08-28 16:08:33', '2025-08-29 02:54:59'),
(40, 20, 'BASIC MATHEMATICS', 'FORM ONE A', 32, 55, 'SECOND MID-TERM', '2025', '2025-08-28 16:08:33', '2025-08-29 02:55:00'),
(41, 21, 'BASIC MATHEMATICS', 'FORM ONE A', 31, 67, 'SECOND MID-TERM', '2025', '2025-08-28 16:08:33', '2025-08-29 02:55:00'),
(42, 22, 'BASIC MATHEMATICS', 'FORM ONE A', 35, 34, 'SECOND MID-TERM', '2025', '2025-08-28 16:08:33', '2025-08-29 02:55:00'),
(43, 25, 'BASIC MATHEMATICS', 'FORM ONE B', NULL, 88, 'SECOND MID-TERM', '2025', '2025-08-29 02:55:00', '2025-08-29 02:55:00'),
(44, 26, 'BASIC MATHEMATICS', 'FORM ONE B', NULL, 22, 'SECOND MID-TERM', '2025', '2025-08-29 02:55:00', '2025-08-29 02:55:00'),
(45, 27, 'BASIC MATHEMATICS', 'FORM ONE B', NULL, 67, 'SECOND MID-TERM', '2025', '2025-08-29 02:55:00', '2025-08-29 02:55:00'),
(46, 28, 'BASIC MATHEMATICS', 'FORM ONE B', NULL, 44, 'SECOND MID-TERM', '2025', '2025-08-29 02:55:00', '2025-08-29 02:55:00'),
(47, 29, 'BASIC MATHEMATICS', 'FORM ONE B', NULL, 99, 'SECOND MID-TERM', '2025', '2025-08-29 02:55:00', '2025-08-29 02:55:00'),
(48, 30, 'BASIC MATHEMATICS', 'FORM ONE B', NULL, 65, 'SECOND MID-TERM', '2025', '2025-08-29 02:55:00', '2025-08-29 02:55:00'),
(49, 31, 'BASIC MATHEMATICS', 'FORM ONE B', NULL, 46, 'SECOND MID-TERM', '2025', '2025-08-29 02:55:00', '2025-08-29 02:55:00'),
(50, 32, 'BASIC MATHEMATICS', 'FORM ONE B', NULL, 44, 'SECOND MID-TERM', '2025', '2025-08-29 02:55:00', '2025-08-29 02:55:00'),
(51, 33, 'BASIC MATHEMATICS', 'FORM ONE B', NULL, 58, 'SECOND MID-TERM', '2025', '2025-08-29 02:55:00', '2025-08-29 02:55:00'),
(52, 34, 'BASIC MATHEMATICS', 'FORM ONE B', NULL, 32, 'SECOND MID-TERM', '2025', '2025-08-29 02:55:00', '2025-08-29 02:55:00'),
(53, 35, 'BASIC MATHEMATICS', 'FORM ONE B', NULL, 78, 'SECOND MID-TERM', '2025', '2025-08-29 02:55:00', '2025-08-29 02:55:00'),
(54, 15, 'PHYSICS', 'FORM ONE A', 35, 10, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:46', '2025-08-29 07:21:46'),
(55, 16, 'PHYSICS', 'FORM ONE A', 23, 12, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(56, 17, 'PHYSICS', 'FORM ONE A', 22, 14, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(57, 18, 'PHYSICS', 'FORM ONE A', 32, 16, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(58, 19, 'PHYSICS', 'FORM ONE A', 23, 18, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(59, 20, 'PHYSICS', 'FORM ONE A', 32, 20, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(60, 21, 'PHYSICS', 'FORM ONE A', 31, 22, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(61, 22, 'PHYSICS', 'FORM ONE A', 35, 24, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(62, 25, 'PHYSICS', 'FORM ONE B', 49, 26, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(63, 26, 'PHYSICS', 'FORM ONE B', 49, 28, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(64, 27, 'PHYSICS', 'FORM ONE B', 49, 30, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(65, 28, 'PHYSICS', 'FORM ONE B', 49, 32, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(66, 29, 'PHYSICS', 'FORM ONE B', 49, 34, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(67, 30, 'PHYSICS', 'FORM ONE B', 49, 36, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(68, 31, 'PHYSICS', 'FORM ONE B', 49, 38, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(69, 32, 'PHYSICS', 'FORM ONE B', 49, 40, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(70, 33, 'PHYSICS', 'FORM ONE B', 49, 42, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:47', '2025-08-29 07:21:47'),
(71, 34, 'PHYSICS', 'FORM ONE B', 49, 44, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:48', '2025-08-29 07:21:48'),
(72, 35, 'PHYSICS', 'FORM ONE B', 49, 46, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:48', '2025-08-29 07:21:48'),
(73, 36, 'PHYSICS', 'FORM ONE A', 49, 48, 'SECOND MID-TERM', '2025', '2025-08-29 07:21:48', '2025-08-29 07:21:48'),
(74, 15, 'BIOLOGY', 'FORM ONE A', 35, 44, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:15', '2025-08-30 12:10:15'),
(75, 16, 'BIOLOGY', 'FORM ONE A', 23, 33, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:15', '2025-08-30 12:10:15'),
(76, 17, 'BIOLOGY', 'FORM ONE A', 22, 44, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:16', '2025-08-30 12:10:16'),
(77, 18, 'BIOLOGY', 'FORM ONE A', 32, 22, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:16', '2025-08-30 12:10:16'),
(78, 19, 'BIOLOGY', 'FORM ONE A', 23, 44, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:16', '2025-08-30 12:10:16'),
(79, 20, 'BIOLOGY', 'FORM ONE A', 32, 11, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:16', '2025-08-30 12:10:16'),
(80, 21, 'BIOLOGY', 'FORM ONE A', 31, 33, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:16', '2025-08-30 12:10:16'),
(81, 22, 'BIOLOGY', 'FORM ONE A', 35, 33, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:16', '2025-08-30 12:10:16'),
(82, 25, 'BIOLOGY', 'FORM ONE B', 49, 44, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:16', '2025-08-30 12:10:16'),
(83, 26, 'BIOLOGY', 'FORM ONE B', 49, 55, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:16', '2025-08-30 12:10:16'),
(84, 27, 'BIOLOGY', 'FORM ONE B', 49, 22, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:16', '2025-08-30 12:10:16'),
(85, 28, 'BIOLOGY', 'FORM ONE B', 49, 55, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:17', '2025-08-30 12:10:17'),
(86, 29, 'BIOLOGY', 'FORM ONE B', 49, 33, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:17', '2025-08-30 12:10:17'),
(87, 30, 'BIOLOGY', 'FORM ONE B', 49, 22, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:17', '2025-08-30 12:10:17'),
(88, 31, 'BIOLOGY', 'FORM ONE B', 49, 55, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:17', '2025-08-30 12:10:17'),
(89, 32, 'BIOLOGY', 'FORM ONE B', 49, 66, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:17', '2025-08-30 12:10:17'),
(90, 33, 'BIOLOGY', 'FORM ONE B', 49, 33, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:17', '2025-08-30 12:10:17'),
(91, 34, 'BIOLOGY', 'FORM ONE B', 49, 77, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:17', '2025-08-30 12:10:17'),
(92, 35, 'BIOLOGY', 'FORM ONE B', 49, 66, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:17', '2025-08-30 12:10:17'),
(93, 36, 'BIOLOGY', 'FORM ONE A', 49, 66, 'SECOND MID-TERM', '2025', '2025-08-30 12:10:17', '2025-08-30 12:10:17'),
(94, 16, 'HISTORY', 'FORM ONE A', 23, 40, 'SECOND MID-TERM', '2025', '2025-08-31 05:49:21', '2025-08-31 05:49:21'),
(95, 37, 'HISTORY', 'FORM FIVE HGL', NULL, 88, 'SECOND MID-TERM', '2025', '2025-08-31 05:59:57', '2025-08-31 06:42:57'),
(96, 38, 'HISTORY', 'FORM FIVE HGL', NULL, 49, 'SECOND MID-TERM', '2025', '2025-08-31 06:12:56', '2025-08-31 06:12:56'),
(97, 37, 'ENGLISH LANGUAGE', 'FORM FIVE HGL', NULL, 81, 'SECOND MID-TERM', '2025', '2025-08-31 06:18:42', '2025-08-31 06:43:43'),
(98, 38, 'ENGLISH LANGUAGE', 'FORM FIVE HGL', NULL, 78, 'SECOND MID-TERM', '2025', '2025-08-31 06:18:42', '2025-08-31 06:18:42'),
(99, 37, 'GEOGRAPHY', 'FORM FIVE HGL', NULL, 66, 'SECOND MID-TERM', '2025', '2025-08-31 06:20:13', '2025-08-31 06:20:13'),
(100, 38, 'GEOGRAPHY', 'FORM FIVE HGL', NULL, 45, 'SECOND MID-TERM', '2025', '2025-08-31 06:20:14', '2025-08-31 06:20:14'),
(101, 37, 'HISTORIA YA TANZANIA NA MAADILI', 'FORM FIVE HGL', 65, 49, 'SECOND MID-TERM', '2025', '2025-08-31 06:29:15', '2025-08-31 06:29:15'),
(102, 38, 'HISTORIA YA TANZANIA NA MAADILI', 'FORM FIVE HGL', 55, 77, 'SECOND MID-TERM', '2025', '2025-08-31 06:29:15', '2025-08-31 06:29:15');

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
-- Table structure for table `fee_structures`
--

CREATE TABLE `fee_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` varchar(255) NOT NULL,
  `term_id` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `maelezo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_structures`
--

INSERT INTO `fee_structures` (`id`, `class_id`, `term_id`, `academic_year`, `amount`, `maelezo`, `created_at`, `updated_at`) VALUES
(1, 'FORM ONE', 'I', '2025', 450000.00, 'Ada ya awamu ya Kwanza', '2025-08-17 14:39:40', '2025-08-17 14:39:40'),
(2, 'FORM ONE', 'II', '2025', 450000.00, 'Ada ya Term ya Pili', '2025-08-17 14:41:58', '2025-08-17 14:41:58'),
(3, 'FORM TWO', 'I', '2025', 1000.00, 'Stationary', '2025-08-17 15:31:45', '2025-08-17 15:31:45'),
(4, 'FORM ONE', 'I', '2025', 5000.00, 'Hela ya T-shirt', '2025-08-24 07:44:01', '2025-08-24 07:44:01'),
(5, 'FORM TWO', 'I', '2025', 450000.00, 'Ada ya awamu ya kwanza', '2025-08-24 14:59:49', '2025-08-24 14:59:49'),
(6, 'FORM TWO', 'II', '2025', 450000.00, 'Ada ya mhula wa pili', '2025-08-24 15:02:15', '2025-08-24 15:02:15'),
(7, 'FORM TWO', 'II', '2025', 35000.00, 'Graduation fee', '2025-08-26 17:38:28', '2025-08-26 17:38:28'),
(8, 'FORM ONE A', 'SECOND MID-TERM', '2025', 150000.00, 'Ada awamu ya Tatu', '2025-08-29 02:23:18', '2025-08-29 02:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `start_form` int(11) NOT NULL,
  `end_to` int(11) NOT NULL,
  `points` float NOT NULL,
  `level` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `name`, `start_form`, `end_to`, `points`, `level`, `created_at`, `updated_at`) VALUES
(1, 'A', 75, 100, 1, 'O-level', NULL, '2025-08-31 05:01:29'),
(2, 'B', 65, 74, 2, 'O-level', NULL, '2025-08-31 07:09:41'),
(3, 'C', 45, 64, 3, 'O-level', NULL, '2025-08-31 07:09:41'),
(4, 'D', 30, 44, 4, 'O-level', NULL, '2025-08-31 07:09:41'),
(5, 'F', 0, 29, 5, 'O-level', NULL, '2025-08-31 07:09:41'),
(6, 'A', 80, 100, 1, 'A-level', NULL, '2025-08-31 06:37:41'),
(7, 'B', 70, 79, 2, 'A-level', NULL, '2025-08-31 06:37:47'),
(8, 'C', 60, 69, 3, 'A-level', NULL, '2025-08-31 06:37:56'),
(9, 'D', 50, 59, 4, 'A-level', NULL, '2025-08-31 06:38:04'),
(10, 'E', 40, 49, 5, 'A-level', NULL, '2025-08-31 06:38:13'),
(11, 'S', 35, 39, 6, 'A-level', NULL, '2025-08-31 06:38:48'),
(12, 'F', 0, 34, 7, 'A-level', NULL, '2025-08-31 06:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maombis`
--

CREATE TABLE `maombis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED DEFAULT NULL,
  `staff_id` int(10) UNSIGNED DEFAULT NULL,
  `request_type` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `change_from` varchar(200) DEFAULT NULL,
  `change_to` varchar(200) DEFAULT NULL,
  `requested_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maombis`
--

INSERT INTO `maombis` (`id`, `student_id`, `staff_id`, `request_type`, `reason`, `created_at`, `updated_at`, `change_from`, `change_to`, `requested_by`) VALUES
(1, 16, NULL, 'delete', 'Tunataka afutwe kwa sababu haudhulii darasani', '2025-08-30 05:27:43', '2025-08-30 05:27:43', NULL, NULL, ''),
(5, 19, NULL, 'delete', 'Afutwe', '2025-08-30 06:16:53', '2025-08-30 06:16:53', NULL, NULL, ''),
(6, 33, NULL, 'delete', 'Afutwer', '2025-08-30 06:23:28', '2025-08-30 06:23:28', NULL, NULL, 'ALEXANDER PIUS LUPEMBA');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_11_062356_create_darasas_table', 2),
(5, '2025_08_11_072450_create_students_table', 3),
(6, '2025_08_11_094246_create_subjects_table', 4),
(7, '2025_08_11_122003_create_student_subjects_table', 5),
(8, '2025_08_11_150229_create_terms_table', 6),
(9, '2025_08_11_150244_create_years_table', 6),
(10, '2025_08_11_151108_create_tests_table', 7),
(11, '2025_08_12_075131_create_exams_table', 8),
(12, '2025_08_14_192107_create_results_table', 9),
(13, '2025_08_15_073409_create_configurations_table', 10),
(16, '2025_08_17_163916_create_fee_structures_table', 11),
(17, '2025_08_17_163926_create_student_payments_table', 11),
(18, '2025_08_18_082448_create_teacher_subjects_table', 12),
(19, '2025_08_30_074944_create_maombis_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('joelkotasi99@gmail.com', '$2y$12$StRxrMhsBMkwyQgCMSZnj.F3SQjV3O0u33Rbw48fe/Q4N3sGecXn6', '2025-08-19 11:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `term` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `score_details` text NOT NULL,
  `average_score` decimal(10,0) NOT NULL,
  `average_grade` varchar(50) NOT NULL,
  `total_points` int(11) DEFAULT NULL,
  `division` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `sms` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_id`, `term`, `year`, `class`, `score_details`, `average_score`, `average_grade`, `total_points`, `division`, `position`, `sms`, `created_at`, `updated_at`) VALUES
(257, 15, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-38(D), BIOLOGY-N/A(N/A), PHYSICS-23(F)', 31, 'D', NULL, 'INC', 16, '1', '2025-08-30 12:07:10', '2025-08-31 03:03:55'),
(258, 16, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-29(F), BIOLOGY-N/A(N/A), PHYSICS-18(F)', 24, 'F', NULL, 'INC', 18, NULL, '2025-08-30 12:07:10', '2025-08-30 12:07:10'),
(259, 17, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-23(F), BIOLOGY-N/A(N/A), PHYSICS-18(F)', 21, 'F', NULL, 'INC', 20, NULL, '2025-08-30 12:07:10', '2025-08-30 12:07:10'),
(260, 18, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-39(D), BIOLOGY-N/A(N/A), PHYSICS-24(F)', 32, 'D', NULL, 'INC', 15, NULL, '2025-08-30 12:07:10', '2025-08-30 12:07:10'),
(261, 19, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-23(F), BIOLOGY-N/A(N/A), PHYSICS-21(F)', 22, 'F', NULL, 'INC', 19, NULL, '2025-08-30 12:07:10', '2025-08-30 12:07:10'),
(262, 20, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-44(D), BIOLOGY-N/A(N/A), PHYSICS-26(F)', 35, 'D', NULL, 'INC', 13, NULL, '2025-08-30 12:07:10', '2025-08-30 12:07:10'),
(263, 21, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-49(C), BIOLOGY-N/A(N/A), PHYSICS-27(F)', 38, 'D', NULL, 'INC', 12, NULL, '2025-08-30 12:07:10', '2025-08-30 12:07:10'),
(264, 22, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-35(D), BIOLOGY-N/A(N/A), PHYSICS-30(D)', 33, 'D', NULL, 'INC', 14, NULL, '2025-08-30 12:07:10', '2025-08-30 12:07:10'),
(265, 25, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-88(A), PHYSICS-38(D)', 63, 'C', NULL, 'INC', 2, NULL, '2025-08-30 12:07:10', '2025-08-30 12:07:10'),
(266, 26, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-22(F), PHYSICS-39(D)', 31, 'D', NULL, 'INC', 16, NULL, '2025-08-30 12:07:10', '2025-08-30 12:07:10'),
(267, 27, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-67(B), PHYSICS-40(D)', 54, 'C', NULL, 'INC', 4, NULL, '2025-08-30 12:07:11', '2025-08-30 12:07:11'),
(268, 28, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-44(D), PHYSICS-41(D)', 43, 'D', NULL, 'INC', 10, NULL, '2025-08-30 12:07:11', '2025-08-30 12:07:11'),
(269, 29, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-99(A), PHYSICS-42(D)', 71, 'B', NULL, 'INC', 1, NULL, '2025-08-30 12:07:11', '2025-08-30 12:07:11'),
(270, 30, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-65(B), PHYSICS-43(D)', 54, 'C', NULL, 'INC', 4, NULL, '2025-08-30 12:07:11', '2025-08-30 12:07:11'),
(271, 31, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-46(C), PHYSICS-44(D)', 45, 'C', NULL, 'INC', 8, NULL, '2025-08-30 12:07:11', '2025-08-30 12:07:11'),
(272, 32, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-44(D), PHYSICS-45(C)', 45, 'C', NULL, 'INC', 8, NULL, '2025-08-30 12:07:11', '2025-08-30 12:07:11'),
(273, 33, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-58(C), PHYSICS-46(C)', 52, 'C', NULL, 'INC', 6, NULL, '2025-08-30 12:07:11', '2025-08-30 12:07:11'),
(274, 34, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-32(D), PHYSICS-47(C)', 40, 'D', NULL, 'INC', 11, NULL, '2025-08-30 12:07:11', '2025-08-30 12:07:11'),
(275, 35, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-78(A), PHYSICS-48(C)', 63, 'C', NULL, 'INC', 2, '1', '2025-08-30 12:07:11', '2025-08-31 03:10:42'),
(276, 36, 'SECOND MID-TERM', '2025', 'FORM ONE', 'BASIC MATHEMATICS-N/A(N/A), BIOLOGY-N/A(N/A), PHYSICS-49(C)', 49, 'C', NULL, 'INC', 7, '1', '2025-08-30 12:07:11', '2025-08-31 03:11:48');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dNESs5SIHax89vK4B2SLUSZXwkieEbv7GDYDK0v1', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYzV5a1Y3cVBXYVFxMGw4TnhZZGtVajBDZHpkZURkbVJuY1V1eERBUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXN1bHRzL2luZGV4P2NsYXNzX25hbWU9Rk9STSUyMEZJVkUlMjBIR0wlMjAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O30=', 1756637451);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `index_number` int(10) UNSIGNED DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` enum('F','M') NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `status` enum('active','passive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `index_number`, `firstname`, `middlename`, `lastname`, `gender`, `email`, `phone`, `class_name`, `status`, `created_at`, `updated_at`) VALUES
(15, 14, 'james', 'kassimu', 'Mock', 'M', 'james@gmail.com', '0758147311', 'FORM ONE A', 'active', '2025-08-28 11:39:35', '2025-08-30 12:01:12'),
(16, 1, 'anna', 'makinda', 'president', 'F', 'joelkotasi99@gmail.com', '0758147311', 'FORM ONE A', 'active', '2025-08-28 11:41:40', '2025-08-30 12:01:11'),
(17, 9, 'basama', 'DICKSON', 'SECONDARY', 'M', 'usongwe@gmail.com', '0758147311', 'FORM ONE A', 'active', '2025-08-28 11:47:20', '2025-08-30 12:01:11'),
(18, 11, 'Christopher', 'Mwambona', 'Mwambona', 'M', 'joelkotasi99@gmail.com', '0758147311', 'FORM ONE A', 'active', '2025-08-28 11:49:27', '2025-08-30 12:01:12'),
(19, 2, 'christina', 'DICKSON', 'SECONDARY', 'F', 'usongwe@gmail.com', '0758147311', 'FORM ONE A', 'active', '2025-08-28 11:50:07', '2025-08-30 12:01:11'),
(20, 7, 'adbul', 'DICKSON', 'SECONDARY', 'M', 'usongwe@gmail.com', '0758147311', 'FORM ONE A', 'active', '2025-08-28 11:54:34', '2025-08-30 12:01:11'),
(21, 10, 'Betina', 'Baston', 'XYZ', 'M', 'unknown@gmail.com', '0783787383', 'FORM ONE A', 'active', '2025-08-28 11:57:01', '2025-08-30 12:01:11'),
(22, 13, 'james', 'bakali', 'njeza', 'M', 'none@gmail.com', '758147311', 'FORM ONE A', 'active', '2025-08-28 12:14:46', '2025-08-30 12:01:12'),
(23, 2, 'Abili', 'bakali', 'njeza', 'M', 'none@gmail.com', '758147311', 'FORM TWO A', 'active', '2025-08-28 12:18:12', '2025-08-28 12:20:21'),
(24, 1, 'Aalima', 'DICKSON', 'XYZ', 'M', 'unknown@gmail.com', '0783787383', 'FORM TWO A', 'active', '2025-08-28 12:20:21', '2025-08-28 12:20:21'),
(25, 15, 'joel1', 'edward1', 'kotasi1', 'M', 'none@gmail.com', '622033912', 'FORM ONE B', 'active', '2025-08-29 02:32:38', '2025-08-30 12:01:12'),
(26, 16, 'joel2', 'edward2', 'kotasi2', 'M', 'none@gmail.com', '622033913', 'FORM ONE B', 'active', '2025-08-29 02:32:38', '2025-08-30 12:01:12'),
(27, 17, 'joel3', 'edward3', 'kotasi3', 'M', 'none@gmail.com', '622033914', 'FORM ONE B', 'active', '2025-08-29 02:32:38', '2025-08-30 12:01:12'),
(28, 18, 'joel4', 'edward4', 'kotasi4', 'M', 'none@gmail.com', '622033915', 'FORM ONE B', 'active', '2025-08-29 02:32:39', '2025-08-30 12:01:12'),
(29, 19, 'joel5', 'edward5', 'kotasi5', 'M', 'none@gmail.com', '622033916', 'FORM ONE B', 'active', '2025-08-29 02:32:39', '2025-08-30 12:01:12'),
(30, 4, 'joel6', 'edward6', 'kotasi6', 'F', 'none@gmail.com', '622033917', 'FORM ONE B', 'active', '2025-08-29 02:32:39', '2025-08-30 12:01:11'),
(31, 20, 'joel7', 'edward7', 'kotasi7', 'M', 'none@gmail.com', '622033918', 'FORM ONE B', 'active', '2025-08-29 02:32:39', '2025-08-30 12:01:12'),
(32, 5, 'joel8', 'edward8', 'kotasi8', 'F', 'none@gmail.com', '622033919', 'FORM ONE B', 'active', '2025-08-29 02:32:39', '2025-08-30 12:01:11'),
(33, 6, 'joel9', 'edward9', 'kotasi9', 'F', 'none@gmail.com', '622033920', 'FORM ONE B', 'active', '2025-08-29 02:32:39', '2025-08-30 12:01:11'),
(34, 3, 'joel10', 'edward10', 'kotasi10', 'F', 'none@gmail.com', '622033921', 'FORM ONE B', 'active', '2025-08-29 02:32:39', '2025-08-30 12:01:11'),
(35, 8, 'akimu', 'jacson', 'kotasi99', 'M', 'none@gmail.com', '622033912', 'FORM ONE B', 'active', '2025-08-29 02:43:42', '2025-08-30 12:01:11'),
(36, 12, 'DEMO', 'DEMO', 'USEONGWE', 'M', 'none@gmail.com', '0758147311', 'FORM ONE A', 'active', '2025-08-29 06:37:13', '2025-08-30 12:01:12'),
(37, 1, 'Joel', 'Kotasi', 'Hansuri', 'M', 'joelkotasi99@gmail.com', '0758147311', 'FORM FIVE HGL', 'active', '2025-08-31 05:25:48', '2025-08-31 06:11:59'),
(38, 2, 'Shalon', 'DICKSON', 'Kotasi', 'M', 'joelkotasi99@gmail.com', '0758147311', 'FORM FIVE HGL', 'active', '2025-08-31 06:11:59', '2025-08-31 06:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `student_payments`
--

CREATE TABLE `student_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `ac_year` varchar(255) NOT NULL,
  `mhula` varchar(255) NOT NULL,
  `payment_date` date NOT NULL,
  `recorded_date` date DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `method` varchar(255) DEFAULT NULL,
  `required_amount` decimal(10,0) NOT NULL,
  `payed_amount` decimal(10,0) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `received_by` varchar(100) DEFAULT NULL,
  `last_notified` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_payments`
--

INSERT INTO `student_payments` (`id`, `student_id`, `ac_year`, `mhula`, `payment_date`, `recorded_date`, `amount`, `method`, `required_amount`, `payed_amount`, `reference`, `received_by`, `last_notified`, `created_at`, `updated_at`) VALUES
(38, 15, '2025', 'SECOND MID-TERM', '2025-08-29', '2025-08-29', 30000.00, NULL, 150000, 30000, NULL, 'mhasibu@gmail.com', NULL, '2025-08-29 02:23:38', '2025-08-29 02:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `student_subjects`
--

CREATE TABLE `student_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `class_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_subjects`
--

INSERT INTO `student_subjects` (`id`, `subject_id`, `class_id`, `created_at`, `updated_at`) VALUES
(195, 'BASIC MATHEMATICS', 'FORM FOUR A', '2025-08-28 06:44:17', '2025-08-28 06:44:17'),
(196, 'BIOLOGY', 'FORM FOUR A', '2025-08-28 06:44:17', '2025-08-28 06:44:17'),
(197, 'CHEMISTRY', 'FORM FOUR A', '2025-08-28 06:44:17', '2025-08-28 06:44:17'),
(198, 'CIVICS', 'FORM FOUR A', '2025-08-28 06:44:17', '2025-08-28 06:44:17'),
(199, 'ENGLISH LANGUAGE', 'FORM FOUR A', '2025-08-28 06:44:17', '2025-08-28 06:44:17'),
(200, 'GEOGRAPHY', 'FORM FOUR A', '2025-08-28 06:44:17', '2025-08-28 06:44:17'),
(201, 'HISTORY', 'FORM FOUR A', '2025-08-28 06:44:17', '2025-08-28 06:44:17'),
(202, 'KISWAHILI', 'FORM FOUR A', '2025-08-28 06:44:17', '2025-08-28 06:44:17'),
(203, 'PHYSICS', 'FORM FOUR A', '2025-08-28 06:44:17', '2025-08-28 06:44:17'),
(216, 'BASIC MATHEMATICS', 'FORM ONE B', '2025-08-29 07:13:03', '2025-08-29 07:13:03'),
(217, 'PHYSICS', 'FORM ONE B', '2025-08-29 07:13:03', '2025-08-29 07:13:03'),
(218, 'BASIC MATHEMATICS', 'FORM ONE A', '2025-08-30 08:40:48', '2025-08-30 08:40:48'),
(219, 'BIOLOGY', 'FORM ONE A', '2025-08-30 08:40:48', '2025-08-30 08:40:48'),
(220, 'PHYSICS', 'FORM ONE A', '2025-08-30 08:40:48', '2025-08-30 08:40:48'),
(221, 'BASIC MATHEMATICS', 'FORM ONE C', '2025-08-30 09:36:18', '2025-08-30 09:36:18'),
(222, 'ENGLISH LANGUAGE', 'FORM FIVE HGL ', '2025-08-31 06:27:23', '2025-08-31 06:27:23'),
(223, 'GEOGRAPHY', 'FORM FIVE HGL ', '2025-08-31 06:27:23', '2025-08-31 06:27:23'),
(224, 'HISTORIA YA TANZANIA NA MAADILI', 'FORM FIVE HGL ', '2025-08-31 06:27:23', '2025-08-31 06:27:23'),
(225, 'HISTORY', 'FORM FIVE HGL ', '2025-08-31 06:27:23', '2025-08-31 06:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `sub_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`sub_name`, `created_at`, `updated_at`) VALUES
('BASIC MATHEMATICS', '2025-08-11 09:49:08', '2025-08-28 06:34:44'),
('BIOLOGY', '2025-08-11 09:48:54', '2025-08-12 06:02:57'),
('BOOK KEEPING', '2025-08-28 06:34:04', '2025-08-28 06:34:04'),
('BUSSINESS STUDY', '2025-08-28 06:34:29', '2025-08-28 06:34:29'),
('CHEMISTRY', '2025-08-11 09:50:33', '2025-08-11 11:49:22'),
('CIVICS', '2025-08-11 11:58:58', '2025-08-15 09:47:24'),
('COMMERCE', '2025-08-28 06:34:19', '2025-08-28 06:34:19'),
('ENGLISH LANGUAGE', '2025-08-11 09:47:16', '2025-08-11 11:54:50'),
('GEOGRAPHY', '2025-08-11 09:48:41', '2025-08-11 09:48:41'),
('HISTORIA YA TANZANIA NA MAADILI', '2025-08-28 06:33:54', '2025-08-28 06:33:54'),
('HISTORY', '2025-08-11 07:28:01', '2025-08-11 11:49:33'),
('KISWAHILI', '2025-08-11 09:48:47', '2025-08-11 09:48:47'),
('PHYSICS', '2025-08-11 09:50:42', '2025-08-11 09:50:42');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subjects`
--

CREATE TABLE `teacher_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `teacher` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_subjects`
--

INSERT INTO `teacher_subjects` (`id`, `class`, `subject`, `teacher`, `created_at`, `updated_at`) VALUES
(12, 'FORM ONE A', 'BASIC MATHEMATICS', 3, '2025-08-28 12:59:23', '2025-08-28 12:59:23'),
(13, 'FORM ONE B', 'BASIC MATHEMATICS', 3, '2025-08-28 12:59:36', '2025-08-28 12:59:36'),
(14, 'FORM ONE C', 'BASIC MATHEMATICS', 3, '2025-08-28 12:59:48', '2025-08-28 12:59:48'),
(15, 'FORM TWO A', 'BASIC MATHEMATICS', 3, '2025-08-28 16:46:32', '2025-08-28 16:46:32'),
(16, 'FORM TWO A', 'BIOLOGY', 3, '2025-08-28 16:48:21', '2025-08-28 16:48:21'),
(17, 'FORM ONE A', 'PHYSICS', 7, '2025-08-29 07:08:00', '2025-08-29 07:08:00'),
(18, 'FORM FIVE HGFa', 'BASIC MATHEMATICS', 7, '2025-08-30 07:34:01', '2025-08-30 07:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `term_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`term_name`, `status`, `created_at`, `updated_at`) VALUES
('ANNUAL', 'passive', NULL, '2025-08-30 07:28:35'),
('FIRST MID-TERM', 'passive', NULL, '2025-08-30 08:36:19'),
('SECOND MID-TERM', 'active', NULL, '2025-08-30 08:36:19'),
('TERMINAL', 'passive', NULL, '2025-08-30 07:23:43');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `studentT` int(10) UNSIGNED NOT NULL,
  `subjectT` varchar(255) NOT NULL,
  `classT` varchar(100) NOT NULL,
  `test1` int(11) DEFAULT NULL,
  `test2` int(11) DEFAULT NULL,
  `test3` int(11) DEFAULT NULL,
  `test4` int(11) DEFAULT NULL,
  `test5` int(11) DEFAULT NULL,
  `test_avg` int(11) GENERATED ALWAYS AS ((coalesce(`test1`,0) + coalesce(`test2`,0) + coalesce(`test3`,0) + coalesce(`test4`,0) + coalesce(`test5`,0)) / nullif((`test1` is not null) + (`test2` is not null) + (`test3` is not null) + (`test4` is not null) + (`test5` is not null),0)) VIRTUAL,
  `termT` varchar(255) NOT NULL,
  `yearT` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `studentT`, `subjectT`, `classT`, `test1`, `test2`, `test3`, `test4`, `test5`, `termT`, `yearT`, `created_at`, `updated_at`) VALUES
(13, 6, 'BASIC MATHEMATICS', 'FORM ONE', 40, 22, 45, 22, 22, 'I', '2025', '2025-08-15 15:11:39', '2025-08-19 05:39:01'),
(14, 15, 'BASIC MATHEMATICS', 'FORM ONE A', 30, 40, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-28 15:29:06', '2025-08-28 15:29:06'),
(15, 16, 'BASIC MATHEMATICS', 'FORM ONE A', 23, 22, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-28 15:29:06', '2025-08-28 15:29:06'),
(16, 17, 'BASIC MATHEMATICS', 'FORM ONE A', 10, 34, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-28 15:29:07', '2025-08-28 15:29:07'),
(17, 18, 'BASIC MATHEMATICS', 'FORM ONE A', 40, 23, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-28 15:29:07', '2025-08-28 15:29:07'),
(18, 19, 'BASIC MATHEMATICS', 'FORM ONE A', 12, 34, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-28 15:29:07', '2025-08-28 15:29:07'),
(19, 20, 'BASIC MATHEMATICS', 'FORM ONE A', 40, 23, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-28 15:29:07', '2025-08-28 15:29:07'),
(20, 21, 'BASIC MATHEMATICS', 'FORM ONE A', 40, 22, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-28 15:29:07', '2025-08-28 15:29:07'),
(21, 22, 'BASIC MATHEMATICS', 'FORM ONE A', 50, 20, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-28 15:29:07', '2025-08-28 15:29:07'),
(22, 15, 'PHYSICS', 'FORM ONE A', NULL, 30, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(23, 16, 'PHYSICS', 'FORM ONE A', NULL, 44, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(24, 17, 'PHYSICS', 'FORM ONE A', NULL, 23, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(25, 18, 'PHYSICS', 'FORM ONE A', NULL, 50, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(26, 19, 'PHYSICS', 'FORM ONE A', NULL, 39, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(27, 20, 'PHYSICS', 'FORM ONE A', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(28, 21, 'PHYSICS', 'FORM ONE A', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(29, 22, 'PHYSICS', 'FORM ONE A', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(30, 25, 'PHYSICS', 'FORM ONE B', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(31, 26, 'PHYSICS', 'FORM ONE B', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(32, 27, 'PHYSICS', 'FORM ONE B', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(33, 28, 'PHYSICS', 'FORM ONE B', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(34, 29, 'PHYSICS', 'FORM ONE B', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(35, 30, 'PHYSICS', 'FORM ONE B', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(36, 31, 'PHYSICS', 'FORM ONE B', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(37, 32, 'PHYSICS', 'FORM ONE B', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(38, 33, 'PHYSICS', 'FORM ONE B', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:34', '2025-08-29 07:16:34'),
(39, 34, 'PHYSICS', 'FORM ONE B', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:35', '2025-08-29 07:16:35'),
(40, 35, 'PHYSICS', 'FORM ONE B', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:35', '2025-08-29 07:16:35'),
(41, 36, 'PHYSICS', 'FORM ONE A', NULL, 49, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-29 07:16:35', '2025-08-29 07:16:35'),
(42, 37, 'HISTORIA YA TANZANIA NA MAADILI', 'FORM FIVE HGL', 40, 90, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-31 06:28:53', '2025-08-31 06:28:53'),
(43, 38, 'HISTORIA YA TANZANIA NA MAADILI', 'FORM FIVE HGL', 33, 77, NULL, NULL, NULL, 'SECOND MID-TERM', '2025', '2025-08-31 06:28:53', '2025-08-31 06:28:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `gender` enum('F','M') NOT NULL,
  `phone` varchar(20) NOT NULL,
  `region` varchar(1000) DEFAULT NULL,
  `role` enum('Teacher','Academic','Headmaster','Mhasibu') NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `mname`, `lname`, `gender`, `phone`, `region`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Shalon', 'Edward', 'Kotasi', 'M', '0758147311', 'Mbeya', 'Teacher', 'mwalimu@gmail.com', NULL, '$2y$12$nnZtEQD.e1nLWi039yasdOAW.NR/yxDO6SwTEXeqDN6IJccJeEAKa', NULL, '2025-08-10 12:56:01', '2025-08-24 18:20:12'),
(5, 'Mhasibu', 'E', 'Accountant', 'M', '075477762', 'Arusha', 'Mhasibu', 'mhasibu@gmail.com', NULL, '$2y$12$AmibIz6pK6xfuNLwWj5ILO7YYYmMIl5x1nxSg23gKLnPubwnteIPG', NULL, '2025-08-19 09:28:47', '2025-08-19 09:28:47'),
(6, 'ALEXANDER', 'PIUS', 'LUPEMBA', 'M', '0621070064', 'MBEYA', 'Academic', 'alexanderpius6@gmail.com', NULL, '$2y$12$MU459EV/jDwfxXCoXEp76.bZs22VnTOoZla/JOpvInWkTFRx6L/Sq', NULL, '2025-08-28 06:31:44', '2025-08-30 07:34:19'),
(7, 'Amosi', 'Makongo', 'Makongo', 'M', '0763553626', 'Mbeya', 'Teacher', 'amosi@gmail.com', NULL, '$2y$12$6RYaY9flylROXH18xqiL8Ogca0n5StoQ24bNOvRtasQtyV4U4g4Fa', NULL, '2025-08-29 07:03:38', '2025-08-29 07:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `year_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`year_name`, `status`, `created_at`, `updated_at`) VALUES
('2025', 'active', NULL, '2025-08-30 08:36:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `darasas`
--
ALTER TABLE `darasas`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maombis`
--
ALTER TABLE `maombis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_name` (`class_name`);

--
-- Indexes for table `student_payments`
--
ALTER TABLE `student_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`sub_name`);

--
-- Indexes for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject`),
  ADD KEY `class` (`class`),
  ADD KEY `teacher` (`teacher`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`term_name`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`year_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_structures`
--
ALTER TABLE `fee_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maombis`
--
ALTER TABLE `maombis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `student_payments`
--
ALTER TABLE `student_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `student_subjects`
--
ALTER TABLE `student_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_name`) REFERENCES `darasas` (`name`);

--
-- Constraints for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD CONSTRAINT `student_subjects_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `darasas` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`sub_name`) ON UPDATE CASCADE;

--
-- Constraints for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD CONSTRAINT `teacher_subjects_ibfk_1` FOREIGN KEY (`subject`) REFERENCES `subjects` (`sub_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_subjects_ibfk_2` FOREIGN KEY (`class`) REFERENCES `darasas` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_subjects_ibfk_3` FOREIGN KEY (`teacher`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
