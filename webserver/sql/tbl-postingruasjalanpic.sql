-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 23, 2017 at 08:12 AM
-- Server version: 5.6.32-78.1-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kronolog_macet`
--

-- --------------------------------------------------------

--
-- Table structure for table `postingruasjalanpic`
--

CREATE TABLE IF NOT EXISTS `postingruasjalanpic` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `chatid` varchar(255) NOT NULL,
  `messageId` int(11) NOT NULL,
  `file_path_location` text NOT NULL,
  `originfile` text NOT NULL,
  `content` text NOT NULL,
  `saatini` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


-- Indexes for table `postingruasjalanpic`
--
ALTER TABLE `postingruasjalanpic`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `postingruasjalanpic`
--
ALTER TABLE `postingruasjalanpic`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=153;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
