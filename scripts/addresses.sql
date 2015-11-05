-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2015 at 09:14 PM
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
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AddedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Address` varchar(50) NOT NULL,
  `City` varchar(15) NOT NULL,
  `State` varchar(15) NOT NULL,
  `ZIP` varchar(11) NOT NULL,
  `validDays` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`ID`, `AddedDate`, `Address`, `City`, `State`, `ZIP`, `validDays`, `Description`) VALUES
(1, '2015-10-27 18:50:14', '661 NW 122 CT', 'MIAMI', 'FL', '33182', 3, 'Suspect found roaming around this area.'),
(2, '2015-10-27 18:50:14', '815 NW 57 AVE', 'MIAMI', 'FL', '33126', 3, 'Possible location of bank robbery suspect');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
