-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 16, 2014 at 01:09 AM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Whiteboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

CREATE TABLE `invites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `invites`
--

INSERT INTO `invites` (`id`, `user_id`, `project_id`) VALUES
(3, 2, 49),
(4, 3, 48),
(8, 3, 5),
(19, 2, 54);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `contentlink` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `posX` int(11) NOT NULL,
  `posY` int(11) NOT NULL,
  `datum` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=118 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `project_id`, `title`, `description`, `contentlink`, `extension`, `posX`, `posY`, `datum`, `user_id`, `color`) VALUES
(116, 5, 'vdfv', 'fdvdfvdfv', 'NMS', 'jpg', 554, 320, '2014-12-16', 2, '#000000'),
(117, 5, 'Testing', 'WHoa, Vide-o!', 'SmilinMofo', 'mp4', 757, 292, '2014-12-16', 2, '#da6857');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `user_id`) VALUES
(1, 'Project Title', 'Project Description', 1),
(5, 'This is a project', 'This is a description', 2),
(54, 'dfgdf', 'fdgdf', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `role`) VALUES
(2, 'za@za', '$2y$12$WEkLLrgpfsxwYI30ggRyi.JhCbdG2c1mOfAbZSY4MNQpIIzCzq216', '', 0),
(3, 'qa@qa', '$2y$12$IOWb4gyxLhfhVyh5mev1m.b9FZ79nWYdlQ0bg6sIs7IVEORBn0UNC', '', 0),
(4, 're@re', '$2y$12$A6W.VJ9Sf3ArSGRFvgDrceD6szzfINWq8HeB/xEZrqZIShzhfkh0e', '', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
