-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2012 年 11 月 06 日 10:53
-- 服务器版本: 5.5.27
-- PHP 版本: 5.3.16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `db_captcha`
--
CREATE DATABASE `db_captcha` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_captcha`;

-- --------------------------------------------------------

--
-- 表的结构 `db_captcha`
--

CREATE TABLE IF NOT EXISTS `db_captcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publickey` varchar(32) DEFAULT NULL,
  `clientsonid` varchar(32) DEFAULT NULL,
  `captcha` varchar(10) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `publickey` (`publickey`,`clientsonid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `db_client`
--

CREATE TABLE IF NOT EXISTS `db_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weburl` varchar(512) CHARACTER SET utf8 DEFAULT NULL,
  `publickey` varchar(32) DEFAULT NULL,
  `privatekey` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
