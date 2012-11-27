-- MySQL dump 10.13  Distrib 5.5.28, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: db_tdcaptcha
-- ------------------------------------------------------
-- Server version	5.5.28-0ubuntu0.12.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `db_admin`
--

DROP TABLE IF EXISTS `db_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_admin` (
  `f_username` char(50) NOT NULL,
  `f_password` char(50) NOT NULL,
  `f_name` char(50) NOT NULL,
  `f_logintimes` int(4) NOT NULL DEFAULT '0',
  `f_lasttime` datetime DEFAULT NULL,
  `f_loginip` char(19) DEFAULT NULL,
  PRIMARY KEY (`f_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_admin`
--

LOCK TABLES `db_admin` WRITE;
/*!40000 ALTER TABLE `db_admin` DISABLE KEYS */;
INSERT INTO `db_admin` VALUES ('admin','a66abb5684c45962d887564f08346e8d','admin',0,NULL,NULL);
/*!40000 ALTER TABLE `db_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_captcha`
--

DROP TABLE IF EXISTS `db_captcha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_captcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `privatekey` varchar(32) DEFAULT NULL,
  `clientsonid` varchar(32) DEFAULT NULL,
  `captcha` varchar(10) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `privatekey` (`privatekey`,`clientsonid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_captcha`
--

LOCK TABLES `db_captcha` WRITE;
/*!40000 ALTER TABLE `db_captcha` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_captcha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_client`
--

DROP TABLE IF EXISTS `db_client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weburl` varchar(512) DEFAULT NULL,
  `publickey` varchar(32) DEFAULT NULL,
  `privatekey` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_client`
--

LOCK TABLES `db_client` WRITE;
/*!40000 ALTER TABLE `db_client` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_client` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-27 16:00:42
