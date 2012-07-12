-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 12. Jul 2012 um 22:08
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
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`date`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `type_id`, `shop`, `title`, `price`) VALUES
(1, 2, 1, 'Pommes (normal)', 1),
(2, 2, 1, 'Pommes (groß)', 2),
(3, 2, 1, 'Kartoffelspalten mit Sour Cream ', 2),
(4, 2, 1, 'Kartoffelsalat (mit Mayo)', 2),
(5, 2, 1, 'Kartoffelsalat (mit Speck)', 2),
(6, 2, 1, 'Gurkensalat (selbstgemacht)', 2),
(7, 2, 1, 'Krautsalat', 1),
(8, 2, 1, 'Ketchup / Mayo', 0),
(9, 2, 1, 'Sour Cream', 1),
(10, 1, 1, '1/2 Hähnchen', 3),
(11, 1, 1, 'Currywurst, klein', 2),
(12, 1, 1, 'Currywurst, groß', 2),
(13, 1, 1, 'Currywurst, nach Art des Hauses ', 2),
(14, 1, 1, 'Bratwurst   ', 2),
(15, 1, 1, 'Krakauer    ', 2),
(16, 1, 1, 'Frikadelle  ', 1),
(17, 1, 1, 'Geflügel-Frikadelle   ', 1),
(18, 1, 1, 'Schaschlik  ', 2),
(19, 1, 1, 'Schnitzel, paniert', 3),
(20, 1, 1, 'Schnitzel, paniert mit Jägersauce', 4),
(21, 1, 1, 'Schnitzel, paniert mit Zigeunersauce', 4),
(22, 1, 1, 'Hamburger (klein, 65g)', 2),
(23, 1, 1, 'Hamburger (groß, 225g)', 4);

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
