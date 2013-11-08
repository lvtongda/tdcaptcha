--
-- Database `db_tdcaptcha`
--

CREATE DATABASE `db_tdcaptcha` DEFAULT CHARACTER SET utf8;
USE `db_tdcaptcha`;

--
-- Table structure for table `db_captcha`
--

DROP TABLE IF EXISTS `db_captcha`;

CREATE TABLE `db_captcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `privatekey` varchar(32) DEFAULT NULL,
  `clientsonid` varchar(32) DEFAULT NULL,
  `captcha` varchar(10) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `privatekey` (`privatekey`,`clientsonid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `db_client`
--

DROP TABLE IF EXISTS `db_client`;

CREATE TABLE `db_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weburl` varchar(512) DEFAULT NULL,
  `publickey` varchar(32) DEFAULT NULL,
  `privatekey` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

