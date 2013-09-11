-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Време на генериране: 
-- Версия на сървъра: 5.5.24-log
-- Версия на PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- БД: `phpsocialnetworkdb`
--

-- --------------------------------------------------------

--
-- Структура на таблица `friendstable`
--

CREATE TABLE IF NOT EXISTS `friendstable` (
  `firstUserId` int(11) NOT NULL,
  `secondUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Ссхема на данните от таблица `friendstable`
--

INSERT INTO `friendstable` (`firstUserId`, `secondUserId`) VALUES
(1, 9),
(9, 1),
(9, 10),
(10, 9);

-- --------------------------------------------------------

--
-- Структура на таблица `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `session` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Ссхема на данните от таблица `login`
--

INSERT INTO `login` (`id`, `name`, `password`, `session`) VALUES
(1, 'Kiro', '4ef46e93edc91ef8ad53365fdb1dfc31', 'rbef8tg43220063g426j7ukop7'),
(7, 'mm', '34be29a7b53f0949a634d62b4cb481d8', '5haps5qldb22ig0f5pcl0s7h81'),
(8, 'aa', '4211bbadc0c47322e67892bc5168bc38', '5r5vmincohkdel3jhm7b1782d5');

-- --------------------------------------------------------

--
-- Структура на таблица `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `fromUser` int(11) NOT NULL,
  `toUser` int(11) NOT NULL,
  `message` varchar(300) CHARACTER SET utf8 NOT NULL,
  `messageSent` datetime NOT NULL,
  `messageSeen` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Ссхема на данните от таблица `messages`
--

INSERT INTO `messages` (`fromUser`, `toUser`, `message`, `messageSent`, `messageSeen`) VALUES
(1, 1, 'hahaha', '2013-08-22 16:00:30', 0);

-- --------------------------------------------------------

--
-- Структура на таблица `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `userPosted` int(11) NOT NULL,
  `post` varchar(256) CHARACTER SET utf8 NOT NULL,
  `date` datetime NOT NULL,
  KEY `userPosted` (`userPosted`),
  KEY `userPosted_2` (`userPosted`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Ссхема на данните от таблица `posts`
--

INSERT INTO `posts` (`userPosted`, `post`, `date`) VALUES
(1, 'kakala6ka', '2013-08-19 21:46:59'),
(1, 'kopriva', '2013-08-19 21:54:16'),
(1, 'mu6muli', '2013-08-20 21:34:22'),
(1, 'mandramunqci', '2013-08-20 21:35:57'),
(1, 'golem post s mnogo space-ove i gluposti', '2013-08-20 22:06:29'),
(1, 'dasdasd dd', '2013-08-22 15:10:00'),
(1, 'ddd da', '2013-08-22 15:20:55');

-- --------------------------------------------------------

--
-- Структура на таблица `uploadedvideos`
--

CREATE TABLE IF NOT EXISTS `uploadedvideos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `path` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `loginId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Ссхема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `loginId`) VALUES
(1, 'Kiril', 'Porov', 'kiko@abv.bg', 1),
(9, 'mm', 'mm', 'mm@m.m', 7),
(10, 'aa', 'aa', 'aa@a', 8);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
