-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 23, 2017 at 08:13 AM
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
-- Table structure for table `userruasjalanpic`
--

CREATE TABLE IF NOT EXISTS `userruasjalanpic` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `latitude` double(18,12) NOT NULL,
  `longitude` double(18,12) NOT NULL,
  `googlemapdesc` text NOT NULL,
  `currentactivity` varchar(255) NOT NULL,
  `regdate` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userruasjalanpic`
--
ALTER TABLE `userruasjalanpic`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userruasjalanpic`
--
ALTER TABLE `userruasjalanpic`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
