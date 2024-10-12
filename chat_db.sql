-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2024 at 12:46 AM
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
-- Database: `chat_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `username`, `message`, `created_at`) VALUES
(47, 'tum', 'we', '2024-10-11 16:52:01'),
(48, 'gh', 'dghdg', '2024-10-11 16:53:53'),
(49, 'gh', 'dghdg', '2024-10-11 16:53:55'),
(50, 'dfgdh', 'kk\';', '2024-10-11 17:58:53'),
(51, 'dfgdh', 'lgfdghd', '2024-10-11 17:58:58'),
(52, 'dfgh', 'xczx', '2024-10-11 18:58:42'),
(53, 'gggg', '34', '2024-10-11 22:19:20'),
(54, 'rt', 'rt', '2024-10-11 22:19:36'),
(55, 'fg', 'enter message ', '2024-10-11 22:20:05'),
(56, 'sdfgsdfg', 'TEST!1231231', '2024-10-11 22:21:55'),
(57, 'sdfgsdfg', 'TEST123', '2024-10-11 22:23:57'),
(58, 'sdfgsdfg', 'ASDASDAS', '2024-10-11 22:24:04'),
(59, 'Kaif', 'ASD', '2024-10-11 22:25:38'),
(60, 'Kaif1', 'zzz', '2024-10-11 22:26:44'),
(61, 'Kaif1', 'asd', '2024-10-11 22:28:15'),
(62, 'Kaif1', 'ssss', '2024-10-11 22:28:19'),
(63, 'Kaif1', 'test', '2024-10-11 22:28:53'),
(64, 'Kaif', 'test', '2024-10-11 22:29:06'),
(65, 'Kaif1', '123', '2024-10-11 22:30:01'),
(66, 'Kaif1', 'asdasfds', '2024-10-11 22:30:31'),
(67, 'Kaif1', 'sdfasd', '2024-10-11 22:30:33'),
(68, 'Kaif2', 'asdfsd', '2024-10-11 22:30:36'),
(69, 'Kaif2', 'asdfsd', '2024-10-11 22:30:39'),
(70, 'Kaif1', 'dfsdfas', '2024-10-11 22:30:43'),
(71, 'hu ', 'hi', '2024-10-11 22:31:09'),
(72, 'Kaif2', 'ki', '2024-10-11 22:31:12'),
(73, 'hu ', 'tum kaha ho ', '2024-10-11 22:31:23'),
(74, 'Kaif2', 'he kahr ', '2024-10-11 22:31:32'),
(75, 'hu ', 'Tum se bar karo gha ', '2024-10-11 22:31:49'),
(76, 'hu ', 'asdfkasd a]', '2024-10-11 22:31:54'),
(77, 'hu ', 'adf asd', '2024-10-11 22:31:55'),
(78, 'hu ', 'adfasd ', '2024-10-11 22:31:56'),
(79, 'hu ', 'jkadfasdk', '2024-10-11 22:31:57'),
(80, 'hu ', 'adfasdkf', '2024-10-11 22:31:58'),
(81, 'hu ', 'jkl; adfa', '2024-10-11 22:32:00'),
(82, 'hu ', 'kljadklfaj', '2024-10-11 22:32:01'),
(83, 'hu ', 'hu ', '2024-10-11 22:33:55'),
(84, 'Kaif2', 'zcvzcx', '2024-10-11 22:34:31'),
(85, 'Kaif2', 'Test', '2024-10-11 22:34:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
