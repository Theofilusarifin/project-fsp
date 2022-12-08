-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2022 at 08:30 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas_fsp`
--

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_username` int(11) NOT NULL,
  `meme_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `memes`
--

CREATE TABLE `memes` (
  `id` int(11) NOT NULL,
  `img_url` varchar(45) NOT NULL,
  `total_like` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memes`
--

INSERT INTO `memes` (`id`, `img_url`, `total_like`) VALUES
(1, 'https://picsum.photos/200/300', 0),
(2, 'https://picsum.photos/200/300', 0),
(3, 'https://picsum.photos/200/300', 0),
(4, 'https://picsum.photos/200/300', 0),
(5, 'https://picsum.photos/200/300', 0),
(6, 'https://picsum.photos/200/300', 0),
(7, 'https://picsum.photos/200/300', 0),
(8, 'https://picsum.photos/200/300', 0),
(9, 'https://picsum.photos/200/300', 0),
(10, 'https://picsum.photos/200/300', 0),
(11, 'https://picsum.photos/200/300', 0),
(12, 'https://picsum.photos/200/300', 0),
(13, 'https://picsum.photos/200/300', 0),
(14, 'https://picsum.photos/200/300', 0),
(15, 'https://picsum.photos/200/300', 0),
(16, 'https://picsum.photos/200/300', 0),
(17, 'https://picsum.photos/200/300', 0),
(18, 'https://picsum.photos/200/300', 0),
(19, 'https://picsum.photos/200/300', 0),
(20, 'https://picsum.photos/200/300', 0),
(21, 'https://picsum.photos/200/300', 0),
(22, 'https://picsum.photos/200/300', 0),
(23, 'https://picsum.photos/200/300', 0),
(24, 'https://picsum.photos/200/300', 0),
(25, 'https://picsum.photos/200/300', 0),
(26, 'https://picsum.photos/200/300', 0),
(27, 'https://picsum.photos/200/300', 0),
(28, 'https://picsum.photos/200/300', 0),
(29, 'https://picsum.photos/200/300', 0),
(30, 'https://picsum.photos/200/300', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` int(11) NOT NULL,
  `password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
(160420013, 160420013),
(160420046, 160420046),
(160720034, 160720034);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`user_username`,`meme_id`),
  ADD KEY `fk_users_has_memes_memes1_idx` (`meme_id`),
  ADD KEY `fk_users_has_memes_users_idx` (`user_username`);

--
-- Indexes for table `memes`
--
ALTER TABLE `memes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `memes`
--
ALTER TABLE `memes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_users_has_memes_memes1` FOREIGN KEY (`meme_id`) REFERENCES `memes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_memes_users` FOREIGN KEY (`user_username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
