-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2022 at 03:09 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `img_url` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memes`
--

INSERT INTO `memes` (`id`, `img_url`) VALUES
(1, 'https://picsum.photos/200/300'),
(2, 'https://picsum.photos/200/300'),
(3, 'https://picsum.photos/200/300'),
(4, 'https://picsum.photos/200/300'),
(5, 'https://picsum.photos/200/300'),
(6, 'https://picsum.photos/200/300'),
(7, 'https://picsum.photos/200/300'),
(8, 'https://picsum.photos/200/300'),
(9, 'https://picsum.photos/200/300'),
(10, 'https://picsum.photos/200/300'),
(11, 'https://picsum.photos/200/300'),
(12, 'https://picsum.photos/200/300'),
(13, 'https://picsum.photos/200/300'),
(14, 'https://picsum.photos/200/300'),
(15, 'https://picsum.photos/200/300'),
(16, 'https://picsum.photos/200/300'),
(17, 'https://picsum.photos/200/300'),
(18, 'https://picsum.photos/200/300'),
(19, 'https://picsum.photos/200/300'),
(20, 'https://picsum.photos/200/300'),
(21, 'https://picsum.photos/200/300'),
(22, 'https://picsum.photos/200/300'),
(23, 'https://picsum.photos/200/300'),
(24, 'https://picsum.photos/200/300'),
(25, 'https://picsum.photos/200/300'),
(26, 'https://picsum.photos/200/300'),
(27, 'https://picsum.photos/200/300'),
(28, 'https://picsum.photos/200/300'),
(29, 'https://picsum.photos/200/300'),
(30, 'https://picsum.photos/200/300');

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
