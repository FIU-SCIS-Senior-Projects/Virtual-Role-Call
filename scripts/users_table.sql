-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2015 at 03:28 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vrc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Last_Name` varchar(15) NOT NULL,
  `First_Name` varchar(15) NOT NULL,
  `Username` varchar(15) NOT NULL COMMENT 'at most 15 chars',
  `Password` varchar(50) NOT NULL COMMENT 'encrypted',
  `userType` text NOT NULL COMMENT '1)Officer, 2)Sargent, 3)Admin',
  `Shift` varchar(1) DEFAULT NULL COMMENT 'Officer shift',
  `RegistrationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Username` (`Username`),
  KEY `ID` (`ID`),
  KEY `ID_2` (`ID`),
  KEY `ID_3` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Last_Name`, `First_Name`, `Username`, `Password`, `userType`, `Shift`, `RegistrationDate`) VALUES
(52, 'Vincench', 'Frank', 'frank', 'U2FsdGVkX1/XJCD8ZUCQLa6XHNpsZL5eN3DyspDJDeo=', 'Administrator', 'A', '2015-09-13 23:58:54'),
(53, 'Reidy', 'Peter', 'peter', 'U2FsdGVkX19r/1lQXQAKZ4obW3gO5933pcm5x+QnQ2g=', 'Supervisor', 'A', '2015-09-14 22:55:19'),

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
