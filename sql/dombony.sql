-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2017 at 02:50 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dombony`
--

-- --------------------------------------------------------

--
-- Table structure for table `blacklist`
--

CREATE TABLE IF NOT EXISTS `blacklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `amount` varchar(20) DEFAULT NULL,
  `topay` varchar(50) DEFAULT NULL,
  `pop` varchar(100) DEFAULT NULL,
  `paid` varchar(5) DEFAULT NULL,
  `ref1` varchar(30) DEFAULT NULL,
  `idref1` int(11) DEFAULT NULL,
  `confirmref1` varchar(5) DEFAULT NULL,
  `ref2` varchar(30) DEFAULT NULL,
  `idref2` int(11) DEFAULT NULL,
  `confirmref2` varchar(5) DEFAULT NULL,
  `filled` varchar(5) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `recyclebin`
--

CREATE TABLE IF NOT EXISTS `recyclebin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `amount` varchar(20) DEFAULT NULL,
  `topay` varchar(50) DEFAULT NULL,
  `pop` varchar(100) DEFAULT NULL,
  `paid` varchar(5) DEFAULT NULL,
  `ref1` varchar(30) DEFAULT NULL,
  `idref1` int(11) DEFAULT NULL,
  `confirmref1` varchar(5) DEFAULT NULL,
  `ref2` varchar(30) DEFAULT NULL,
  `idref2` int(11) DEFAULT NULL,
  `confirmref2` varchar(5) DEFAULT NULL,
  `filled` varchar(5) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `recyclebin`
--

INSERT INTO `recyclebin` (`id`, `username`, `amount`, `topay`, `pop`, `paid`, `ref1`, `idref1`, `confirmref1`, `ref2`, `idref2`, `confirmref2`, `filled`, `date`, `time`) VALUES
(17, 'mosco', '100000', 'franko4don', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-06', '01:15:13'),
(19, 'mosco', '50000', 'franko4don', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-06', '01:17:47'),
(20, 'mosco', '100000', 'franko4don', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-06', '01:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `amount` varchar(20) DEFAULT NULL,
  `topay` varchar(50) DEFAULT NULL,
  `pop` varchar(100) DEFAULT NULL,
  `paid` varchar(5) DEFAULT NULL,
  `ref1` varchar(30) DEFAULT NULL,
  `idref1` int(11) DEFAULT NULL,
  `confirmref1` varchar(5) DEFAULT NULL,
  `ref2` varchar(30) DEFAULT NULL,
  `idref2` int(11) DEFAULT NULL,
  `confirmref2` varchar(5) DEFAULT NULL,
  `filled` varchar(5) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `username`, `amount`, `topay`, `pop`, `paid`, `ref1`, `idref1`, `confirmref1`, `ref2`, `idref2`, `confirmref2`, `filled`, `date`, `time`) VALUES
(1, 'franko4don', '10000', 'confirm#$', 'yes', 'yes', 'confirm#$', 5, 'yes', 'confirm#$', 14, 'yes', 'yes', '2017-03-06', '00:51:14'),
(2, 'franko4don', '20000', 'confirm#$', 'yes', 'yes', 'confirm#$', 7, 'yes', NULL, NULL, NULL, NULL, '2017-03-06', '00:51:15'),
(3, 'franko4don', '50000', 'confirm#$', 'yes', 'yes', 'confirm#$', 10, 'yes', 'confirm#$', 22, 'yes', 'yes', '2017-03-06', '00:51:17'),
(4, 'franko4don', '100000', 'confirm#$', 'yes', 'yes', 'mosco', 24, NULL, NULL, NULL, NULL, NULL, '2017-03-06', '00:51:19'),
(5, 'mosco', '10000', 'franko4don', NULL, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-06', '00:51:40'),
(7, 'mosco', '20000', 'franko4don', NULL, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-06', '00:51:41'),
(10, 'mosco', '50000', 'franko4don', NULL, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-06', '01:00:39'),
(14, 'mosco', '10000', 'franko4don', NULL, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-06', '01:06:38'),
(18, 'mosco', '10000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-06', '01:15:09'),
(22, 'mosco', '50000', 'franko4don', NULL, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-06', '01:19:54'),
(24, 'mosco', '100000', 'franko4don', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-06', '20:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phonenumber` varchar(12) NOT NULL,
  `bankname` varchar(40) NOT NULL,
  `accountholder` varchar(50) DEFAULT NULL,
  `bankaccount` varchar(12) NOT NULL,
  `usertype` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `email`, `phonenumber`, `bankname`, `accountholder`, `bankaccount`, `usertype`, `date`, `time`) VALUES
(1, 'Nwanze Franklin', 'franko4don', '1b359d8753858b55befa0441067aaed3', 'franko4don@gmail.com', '07037219055', 'Firstbank of Nigeria', 'Nwanze Franklin Chuka', '3053512900', 1, '2017-02-21', '19:00:01'),
(2, 'Nwanze Gerald', 'mosco', '1b359d8753858b55befa0441067aaed3', 'franko4don@gmail.com', '09055082408', 'Firstbank of Nigeria', 'Nwanze Gerald', '3053512900', NULL, '2017-02-22', '16:43:42'),
(3, 'Chiekezie Kingsley', 'kingbuky', '1b359d8753858b55befa0441067aaed3', 'franko4don@gmail.com', '09055082408', 'Zenith Bank', 'chiekezie kings', '4536745312', NULL, '2017-02-26', '17:28:26'),
(4, 'newman festus', 'offiahfestus', '1b359d8753858b55befa0441067aaed3', 'offiahfestus@gmail.com', '08030783870', 'fidelity bank', 'Offiah festus chibuike', '6171231549', NULL, '2017-02-27', '18:23:39'),
(5, 'Uchenna Obiorah', 'michcarlito', '1f608e4982070a92465b8f91e74094ec', 'michcarlito@gmail.com', '08068026669', 'GTBank', 'Uchenna Obiorah', '0040531755', NULL, '2017-02-27', '18:24:52');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
