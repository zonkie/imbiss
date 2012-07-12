-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 13. Jul 2012 um 01:12
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `imbiss`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buyer`
--

CREATE TABLE IF NOT EXISTS `buyer` (
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`date`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paid`
--

CREATE TABLE IF NOT EXISTS `paid` (
  `user_name` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `change` int(11) NOT NULL,
  `change_paid` int(11) NOT NULL,
  `datetime` int(11) NOT NULL,
  PRIMARY KEY (`user_name`,`datetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `shop` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`,`shop`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `type_id`, `shop`, `title`, `price`) VALUES
(40, 1, 1, 'Gefl&uuml;gel-Frikadelle   ', 180),
(39, 1, 1, 'Frikadelle', 180),
(38, 1, 1, 'Krakauer', 230),
(37, 1, 1, 'Bratwurst', 230),
(36, 1, 1, 'Currywurst, nach Art des Hauses ', 230),
(35, 1, 1, 'Currywurst, gro&szlig;', 260),
(34, 1, 1, 'Currywurst, klein', 230),
(33, 1, 1, '1/2 H&auml;hnchen', 360),
(32, 2, 1, 'Sour Cream', 100),
(31, 2, 1, 'Ketchup / Mayo', 30),
(30, 2, 1, 'Krautsalat', 170),
(29, 2, 1, 'Gurkensalat (selbstgemacht)', 200),
(28, 2, 1, 'Kartoffelsalat (mit Speck)', 200),
(27, 2, 1, 'Kartoffelsalat (mit Mayo)', 200),
(26, 2, 1, 'Kartoffelspalten mit Sour Cream ', 270),
(25, 2, 1, 'Pommes (gro&szlig;)', 220),
(24, 2, 1, 'Pommes (normal)', 170),
(41, 1, 1, 'Schaschlik', 260),
(42, 1, 1, 'Schnitzel, paniert', 320),
(43, 1, 1, 'Schnitzel, paniert mit J&auml;gersauce', 420),
(44, 1, 1, 'Schnitzel, paniert mit Zigeunersauce', 420),
(45, 1, 1, 'Hamburger (klein, 65g)', 220),
(46, 1, 1, 'Hamburger (gro&szlig;, 225g)', 490);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `product_types`
--

CREATE TABLE IF NOT EXISTS `product_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `product_types`
--

INSERT INTO `product_types` (`id`, `name`) VALUES
(1, 'Speise'),
(2, 'Beilage');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shops`
--

CREATE TABLE IF NOT EXISTS `shops` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
