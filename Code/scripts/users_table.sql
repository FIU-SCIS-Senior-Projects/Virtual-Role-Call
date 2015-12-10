-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2015 at 04:50 PM
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
  `RegistrationDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `onlineStatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Username` (`Username`),
  KEY `ID` (`ID`),
  KEY `ID_2` (`ID`),
  KEY `ID_3` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Last_Name`, `First_Name`, `Username`, `Password`, `userType`, `Shift`, `RegistrationDate`, `onlineStatus`) VALUES
(52, 'Vincench', 'Frank', 'frank', 'U2FsdGVkX1/uVMAgl/w5SUICAiH3Lgt0E5v5cFh6pYI=', 'Administrator', 'B', '2015-09-13 23:58:54', 0),
(53, 'Reidy', 'Peter', 'peter', 'U2FsdGVkX1/U5otRbVNAvvfPYGGHXGxGA23PlCyntG0=', 'Officer', 'B', '2015-09-14 22:55:19', 0),
(54, 'Arenas', 'Erick', 'erick', 'U2FsdGVkX1/1Gd+5WYzhKM5o8VWfrEiSe8QOBg00fU8=', 'Supervisor', 'C', '2015-09-16 22:06:30', 0),
(56, 'Cohen', 'Jason', 'jason', 'U2FsdGVkX1+6aB1WlerQ/VkrrWAnJV/Z25328kfwJjs=', 'Supervisor', 'A', '2015-09-23 22:05:23', 0),
(57, 'OBAMA', 'BARRACK', 'obama', 'U2FsdGVkX19xgq/8hhdRFMRY7/PWAm21wQsJ2PYr7MY=', 'Officer', 'C', '2015-09-25 10:58:09', 0),
(60, 'Johson', 'Dwane', 'dwane', 'U2FsdGVkX1/vUJ0FvdqvAeTQVKL202ZBJdMYL4IBdlc=', 'Administrator', 'B', '2015-09-25 12:05:28', 0),
(103, 'doe', 'john', 'john', 'U2FsdGVkX181tBFwOwTKbDXr+NagX1n/etk6LG22dTk=', 'Administrator', 'B', '2015-10-01 14:15:48', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
