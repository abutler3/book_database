-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 04, 2014 at 05:14 AM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `pdo`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `bio` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `firstName`, `lastName`, `bio`) VALUES
(1, 'Marc', 'Delisle', 'Marc Delisle is a member of the MySQL Developers Guide'),
(2, 'Sohail', 'Salehi', 'In recent years, Sohail has contributed to over 20 books, mainly in programming and computer graphics'),
(3, 'Cameron', 'Cooper', 'J. Cameron Cooper has been playing around on the web since there was not much of a web with which to play around'),
(4, 'Drew', 'Butler', 'Developer of all');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `title` varchar(70) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `publisher` varchar(30) NOT NULL,
  `year` int(4) NOT NULL,
  `summary` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_isbn` (`isbn`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `author`, `title`, `isbn`, `publisher`, `year`, `summary`) VALUES
(1, 1, 'Creating your MySQL Database: Practical Design Tips and Techniques', '1904811302', 'Packt Publishing Ltd', 2006, 'A short guide for everyone on how to structure your data and setup your MySQL database tables efficiently and easily.'),
(2, 2, 'ImageMagick Tricks', '1904811868', 'Packt Publishing Ltd', 2006, 'Unleash the power of ImageMagick with this fast, friendly tutorial, and tips guide'),
(3, 3, 'Building Websites With Plone', '1904811027', 'Packt Publishing Ltd', 2004, 'An in-depth and comprehensive guide to the Plone content management system'),
(4, 2, 'fgfgfg', '4545424340', 'Pact', 2012, 'Just a test');
