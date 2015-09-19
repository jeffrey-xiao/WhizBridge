-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: localhost    Database: whizbridge_db
-- ------------------------------------------------------
-- Server version	5.6.25-3+deb.sury.org~trusty+1

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
-- Table structure for table `Auth`
--

DROP TABLE IF EXISTS `Auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Auth` (
  `auth_id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_hash` varchar(128) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `whiz_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`auth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Auth`
--

LOCK TABLES `Auth` WRITE;
/*!40000 ALTER TABLE `Auth` DISABLE KEYS */;
INSERT INTO `Auth` VALUES (1,'da39a3ee5e6b4b0d3255bfef95601890afd80709QELo/YNKki,c','2015-09-19 05:58:51',NULL),(2,'da39a3ee5e6b4b0d3255bfef95601890afd80709110E2u.tA.Jk','2015-09-19 05:59:19',NULL),(3,'da39a3ee5e6b4b0d3255bfef95601890afd80709kB;Ll6v,;g7N','2015-09-19 06:04:47',NULL),(4,'da39a3ee5e6b4b0d3255bfef95601890afd80709Nj5kwOnJy5hQ','2015-09-19 06:25:57',2),(5,'da39a3ee5e6b4b0d3255bfef95601890afd80709fBq6tuYZR1,y','2015-09-19 06:58:15',2),(8,'da39a3ee5e6b4b0d3255bfef95601890afd80709XUYwbbt8wQ8/','2015-09-19 07:32:41',NULL),(26,'da39a3ee5e6b4b0d3255bfef95601890afd807093YwcLiTLnKGX','2015-09-19 15:41:43',3);
/*!40000 ALTER TABLE `Auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Job`
--

DROP TABLE IF EXISTS `Job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Job` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `job_name` varchar(140) DEFAULT NULL,
  `job_description` varchar(500) DEFAULT NULL,
  `job_price` double DEFAULT NULL,
  `job_latitude` double DEFAULT NULL,
  `job_longitude` double DEFAULT NULL,
  `job_address` varchar(300) DEFAULT NULL,
  `job_hash` varchar(128) DEFAULT NULL,
  `job_completed` tinyint(1) DEFAULT NULL,
  `job_phonenumber` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`job_id`,`buyer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Job`
--

LOCK TABLES `Job` WRITE;
/*!40000 ALTER TABLE `Job` DISABLE KEYS */;
INSERT INTO `Job` VALUES (83,0,'2015-09-19 19:42:05','Data Lost','Accidentally deleted important pictures',75,43.8424585,-79.3035977,NULL,'914b15088880cf4bfa9b12ff31c5a209',NULL,NULL),(84,0,'2015-09-19 19:43:00','Need to backup data','Have important files that should be backed up',150,51.9543738,-111.1020787,NULL,'9de60f7117d8cb729b9e9cf3adeacc2a',NULL,NULL),(85,0,'2015-09-19 19:43:37','Basic System Optimization','My system is running slowly',25,46.212655,-72.4301159,NULL,'20f0c3166b40c5108957c7c232d1be0c',NULL,NULL),(86,0,'2015-09-19 19:44:30','Advanced System Optimization','My system has a trojan! It is infected with malware!',50,45.5270415,-73.5610798,NULL,'4b6abd77ccaa9e0efd986f13809e0249',NULL,NULL),(87,0,'2015-09-19 19:46:09','Help me download ubuntu','I don\'t like Windows 10!',50,52.2698105,-113.8104141,NULL,'884e37136b483f75455102905e608337',NULL,NULL),(88,0,'2015-09-19 19:46:56','Clean my computer','My computer is dirty and I would like it cleaned',25,43.4476109,-80.4893965,NULL,'4271c3e13744d3344373d0ef7e448a23',NULL,NULL);
/*!40000 ALTER TABLE `Job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `JobJoin`
--

DROP TABLE IF EXISTS `JobJoin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `JobJoin` (
  `join_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `whiz_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `job_completed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`join_id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `JobJoin`
--

LOCK TABLES `JobJoin` WRITE;
/*!40000 ALTER TABLE `JobJoin` DISABLE KEYS */;
INSERT INTO `JobJoin` VALUES (108,47,2,NULL,NULL),(109,82,3,NULL,NULL),(110,81,3,NULL,NULL),(111,80,3,NULL,NULL),(112,47,2,NULL,NULL);
/*!40000 ALTER TABLE `JobJoin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Whiz`
--

DROP TABLE IF EXISTS `Whiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Whiz` (
  `whiz_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `full_name` varchar(120) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `salt` varchar(128) DEFAULT NULL,
  `avatar_hash` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`whiz_id`,`username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Whiz`
--

LOCK TABLES `Whiz` WRITE;
/*!40000 ALTER TABLE `Whiz` DISABLE KEYS */;
INSERT INTO `Whiz` VALUES (1,'username','Full Name Smith','whiz@whiz.com',NULL,NULL,NULL,NULL),(8,'jeffrey','jeffrey','jeffrey@jeffrey.com','2015-09-19 19:50:09','76cc4a1bb2f0eb2291692c12869ae4b56db8db7b51e22304990dd6b447411997','z53e5d8c0326e7ee3416f9402d08e6ee','fd3e33c391902efdd214b48cf6f881a8'),(9,'ben','ben','ben@ben.com','2015-09-19 19:50:22','bf2755e7700f9714ff38a515c111ff59eb93cd1da0055a7a3cde2876dbdedc6e','m987797c2da20b3b8be1cb6e3435b7f5','f77735eac2d73c11cc40eb37a5598b14'),(10,'david','david','david@david.com','2015-09-19 19:50:36','00e3966566bc48a00d2426a508d48ac5b4136ae12a2513c0c0f0d9156262b24b','w34374875372033f0bd4c3e28e29191e','cd9cf0549af505a3a6d9e191c0c8ab93'),(11,'george','george','george@george.com','2015-09-19 19:52:23','4d48e553e511f53ad1954dd0108d4f4bf86b455ad5f825a4981b43f507959873','u5c6ad9a852db40aca8940ba0c84ea00','6d7282892a12974bcc6d6d9b282a058d');
/*!40000 ALTER TABLE `Whiz` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-19 16:43:17
