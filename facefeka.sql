-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 27, 2020 at 05:39 PM
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `facefeka`
--

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

DROP TABLE IF EXISTS `friend_requests`;
CREATE TABLE IF NOT EXISTS `friend_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=hebrew;

-- --------------------------------------------------------

--
-- Table structure for table `game_requests`
--

DROP TABLE IF EXISTS `game_requests`;
CREATE TABLE IF NOT EXISTS `game_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user` int(11) NOT NULL,
  `to_user` int(11) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=hebrew;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `post_id` int(11) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=hebrew;

--
-- Dumping data for table `images`
--!INSERT INTO `images` (`id`, `file_name`, `post_id`, `upload_time`) VALUES
--(1, 'IMG_20190724_160602_335.PNG', 67, '2020-07-24 16:06:02');



-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isPrivate` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=hebrew;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `text`, `user_id`, `date`, `isPrivate`) VALUES
(2, 'This is a post of id 1', 1, '2020-07-10 04:17:18', 0),
(3, 'This is a post of id 2', 2, '2020-07-08 09:28:13', 0),
(4, 'This is a post of id 3', 3, '2020-07-06 14:11:26', 0),
(5, 'lolololo', 2, '2020-07-16 20:31:09', 0),
(6, 'hhhh', 1, '2020-07-24 12:32:34', 0),
(7, 'kkk', 1, '2020-07-24 12:33:11', 0),
(8, 'fgfg', 1, '2020-07-24 12:33:54', 0),
(9, 'dddd', 1, '2020-07-24 12:34:25', 0),
(10, 'ghdghdfgh', 2, '2020-07-24 12:35:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

DROP TABLE IF EXISTS `post_comments`;
CREATE TABLE IF NOT EXISTS `post_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=hebrew;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `post_id`, `user_id`, `comment`) VALUES
(3, 2, 1, 'gggg'),
(2, 2, 1, 'comment2'),
(4, 2, 1, 'gggg'),
(8, 5, 3, 'this is lololo comment');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=hebrew;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'amit', '$2y$10$dbdLc5LGGHh1lRMvbuK9J.7qTjGwwk3eT03tmLQyydF6Eyjnh3Yoi'),
(2, 'MATAN', '$2y$10$QNEKp7Ng8a7AZ0eYkqTDsed8XR3eQaJCHHamgzx33tbtojRsbPgku'),
(3, 'amitMATAN', '$2y$10$Oaxjp5u6eSW3LlfAIorSpOSiYirYodGv8qzCrRv1gROO9HK8g527y'),
(4, 'Tav', '$2y$10$r4uxxbzkz067G0rDgmdHmOAqvmdny76k6ECKM5vd.KK8XqJvy09RG'),
(5, 'Dor', '$2y$10$/riS/yRZFEe6O4FXkSl5kexaqscAKQM9soNu5Sb8XvtEUJxhjIZh2');

-- --------------------------------------------------------

--
-- Table structure for table `user_friends`
--

DROP TABLE IF EXISTS `user_friends`;
CREATE TABLE IF NOT EXISTS `user_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=hebrew;

--
-- Dumping data for table `user_friends`
--

INSERT INTO `user_friends` (`id`, `user_id`, `friend_id`) VALUES
(9, 2, 1),
(10, 1, 2);
COMMIT;

