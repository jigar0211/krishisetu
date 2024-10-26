-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 03:25 AM
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
-- Database: `main`
--

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE `authentication` (
  `auth_id` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(50) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `profile_picture` varchar(250) NOT NULL,
  `location` varchar(150) NOT NULL,
  `language` varchar(50) NOT NULL,
  `token` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authentication`
--

INSERT INTO `authentication` (`auth_id`, `name`, `email`, `contact_number`, `password`, `role`, `profession`, `profile_picture`, `location`, `language`, `token`, `created_at`) VALUES
('671aba2da7a85', 'dasdsa', 'd@gmail.com', '1232132132', '$2y$10$w91qvYTW726KzF0pfinCTOGyxetVhZkynPxihZ4LfudcbOh6u/iJy', '2', 'farmer,driver,buyer,seller', '671aba2d908a3-Google.png', '23.022505,72.5713621', '1', '', '2024-10-25 02:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` varchar(250) NOT NULL,
  `auth_id` varchar(250) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` varchar(250) NOT NULL,
  `send_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` varchar(250) NOT NULL,
  `auth_id` varchar(250) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `post_image` varchar(250) NOT NULL,
  `post_type` varchar(50) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `area_of_word` varchar(50) DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `price_by` varchar(50) DEFAULT NULL,
  `work_address` varchar(250) DEFAULT NULL,
  `work_location` varchar(100) DEFAULT NULL,
  `work_timing` varchar(50) DEFAULT NULL,
  `market_coverage` varchar(50) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `product_age` varchar(50) DEFAULT NULL,
  `is_transport` varchar(50) DEFAULT NULL,
  `post_exp_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `posted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_authentication`
--

CREATE TABLE `temp_authentication` (
  `auth_id` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(50) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `profile_picture` varchar(250) NOT NULL,
  `location` varchar(150) NOT NULL,
  `language` varchar(50) NOT NULL,
  `token` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`auth_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `contact_number` (`contact_number`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `contact_relation` (`auth_id`),
  ADD KEY `contact_relation_2` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_relation` (`auth_id`);

--
-- Indexes for table `temp_authentication`
--
ALTER TABLE `temp_authentication`
  ADD PRIMARY KEY (`auth_id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_relation` FOREIGN KEY (`auth_id`) REFERENCES `authentication` (`auth_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `contact_relation_2` FOREIGN KEY (`email`) REFERENCES `authentication` (`email`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `post_relation` FOREIGN KEY (`auth_id`) REFERENCES `authentication` (`auth_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
