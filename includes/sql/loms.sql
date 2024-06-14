-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 06, 2023 at 07:44 PM
-- Server version: 10.5.12-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loms`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(15) NOT NULL,
  `groupname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_count` int(15) NOT NULL DEFAULT 0,
  `group_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `groupname`, `users_count`, `group_img`, `date_created`) VALUES
(1, 'Admin Group Chat', 0, 'background.png', '2023-04-06 17:15:51'),
(2, 'Students Group Chat\r\n', 0, 'yin-yang.png', '2023-04-06 17:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(15) NOT NULL,
  `userId_sent` int(15) NOT NULL,
  `userId_received` int(15) NOT NULL,
  `groupId` int(15) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `userId_sent`, `userId_received`, `groupId`, `message`, `time`) VALUES
(1, 2, 1, 0, 'bossman ', '2023-04-06 18:11:06'),
(2, 4, 2, 1, 'Hello, this is the admin', '2023-04-06 18:23:23'),
(3, 4, 2, 1, 'Welcome new members :)', '2023-04-06 18:23:35'),
(4, 2, 5, 0, 'is it working?', '2023-04-06 18:24:39'),
(5, 2, 5, 0, 'I am just testing it out You know ', '2023-04-06 18:25:06'),
(6, 1, 2, 0, 'I dey boss, how work ?', '2023-04-06 18:26:38'),
(7, 1, 4, 0, 'Hello', '2023-04-06 18:28:36'),
(8, 1, 5, 1, 'Nice to meet you too admin', '2023-04-06 18:30:04'),
(9, 1, 5, 1, 'I\'m Farrell', '2023-04-06 18:35:33'),
(10, 2, 6, 0, 'BON-JOUR ', '2023-04-06 18:36:39'),
(11, 2, 1, 0, 'mad men ', '2023-04-06 18:41:25'),
(12, 2, 7, 0, 'sup ', '2023-04-06 18:41:34'),
(13, 1, 2, 0, 'Lol', '2023-04-06 18:41:46'),
(14, 6, 2, 0, 'Tu fais quoi ', '2023-04-06 18:46:24'),
(15, 1, 7, 2, 'Hello, guys i\'m new here', '2023-04-06 18:46:49'),
(16, 1, 6, 0, 'Hello', '2023-04-06 18:50:21'),
(17, 5, 2, 0, 'Yes you fool', '2023-04-06 18:56:51'),
(18, 2, 1, 0, 'hello how are you?', '2023-04-06 19:20:09'),
(19, 6, 1, 0, 'Allô ', '2023-04-06 19:20:53'),
(20, 6, 1, 0, 'How are you doing ', '2023-04-06 19:21:00'),
(21, 1, 6, 0, 'I\'m good', '2023-04-06 19:22:56'),
(22, 6, 1, 0, 'Good to know ', '2023-04-06 19:23:07'),
(23, 1, 2, 0, 'Good boss :)', '2023-04-06 19:23:26'),
(24, 2, 1, 0, 'how is the project goin?', '2023-04-06 19:23:55'),
(25, 1, 6, 2, 'I\'m Farrell\'', '2023-04-06 19:24:17'),
(26, 6, 4, 2, 'My name is Ange', '2023-04-06 19:24:23'),
(27, 6, 4, 2, 'Nice to meet you ', '2023-04-06 19:24:28'),
(28, 2, 6, 2, 'hey nice to meet you all', '2023-04-06 19:24:33'),
(29, 2, 6, 2, 'i am umar', '2023-04-06 19:24:42'),
(30, 6, 4, 2, 'Hi Umar ', '2023-04-06 19:25:02'),
(31, 1, 2, 0, 'It\'s okay', '2023-04-06 19:25:06'),
(32, 6, 4, 2, 'Welcome ', '2023-04-06 19:25:07'),
(33, 6, 4, 1, 'Hello Farrell ', '2023-04-06 19:25:33'),
(34, 6, 4, 1, 'I’m Ange ', '2023-04-06 19:25:37'),
(35, 1, 6, 1, 'Hello Ange', '2023-04-06 19:25:40'),
(36, 1, 6, 1, 'We\'re finally done with the project :)', '2023-04-06 19:26:10'),
(37, 2, 6, 1, 'hello all I am the IT head here send any issue you have right away', '2023-04-06 19:26:15'),
(38, 1, 6, 1, 'Okay', '2023-04-06 19:26:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `groupId` int(15) NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstName`, `lastName`, `user_email`, `user_password`, `status`, `department`, `groupId`, `img`, `last_activity`) VALUES
(1, 'fadebo', 'Farrell', 'Adebo', 'fadebo@algomau.ca', 'f0a1e4eab1301c45d83ad8c108d1e6f5', 'offline', '', 0, 'tester.jpg', '2023-04-06 19:19:57'),
(2, 'utafida', 'Umar', 'Tafida', 'utafida@outlook.com', 'ba2dfc1f09508808ac28a6eedadb8464', 'busy', '', 0, 'default.png', '2023-04-06 18:10:52'),
(4, 'techfazzy', 'Tech', 'Fazzy', 'techfazzy@gmail.com', 'f7e210ea24ae77c31fdac027985635a4', 'offline', '', 0, 'yin-yang.png\n', '2023-04-06 18:20:44'),
(6, 'Ange', 'Ange', 'Kamgaing', 'akamgaingnecdem@algomau.ca', '099131d2dd2a482dd468af305bf30ddd', 'online', '', 0, 'default.png', '2023-04-06 18:36:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
