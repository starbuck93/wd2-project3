-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2015 at 11:54 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tanks`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
`key` int(5) NOT NULL,
  `name` varchar(40) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date-register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`key`, `name`, `username`, `email`, `password`, `date-register`) VALUES
(1, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '2015-03-29 20:42:35'),
(2, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '2015-03-29 20:43:34'),
(3, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '2015-03-29 20:44:33'),
(4, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '2015-03-29 20:45:59'),
(5, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '2015-03-29 20:46:33'),
(6, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '2015-03-29 20:46:47'),
(7, 'A', 'C', 'B', 'f623e75af30e62bbd73d6df5b50bb7b5', '2015-03-29 20:47:43'),
(8, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '2015-03-29 21:09:26'),
(9, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '2015-03-29 21:09:53'),
(10, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '2015-03-29 21:16:32'),
(11, 'adm', 'dsa', 'asdm', 'c4ca4238a0b923820dcc509a6f75849b', '2015-03-29 21:17:07'),
(12, 'adm', 'dsa', 'asdm', 'c4ca4238a0b923820dcc509a6f75849b', '2015-03-29 21:19:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
 ADD PRIMARY KEY (`key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
MODIFY `key` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE IF NOT EXISTS `achievements` (
`key` int(5) NOT NULL,
`user` varchar(100) NOT NULL,
`objective` varchar(300) NOT NULL,
`status` boolean NOT NULL,
`id` int(3) NOT NULL
);

ALTER TABLE `achievements`
 ADD PRIMARY KEY (`key`);

ALTER TABLE `achievements`
MODIFY `key` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;