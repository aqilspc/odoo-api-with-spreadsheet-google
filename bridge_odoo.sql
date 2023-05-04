-- MySQL dump 10.19  Distrib 10.3.37-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: bridge_odoo
-- ------------------------------------------------------
-- Server version	10.3.37-MariaDB-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `survey_answers`
--

DROP TABLE IF EXISTS `survey_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `survey_answers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `survey_id` bigint(20) NOT NULL,
  `quetsion_id` bigint(20) NOT NULL,
  `participant_id` bigint(20) NOT NULL,
  `type` varchar(10) NOT NULL,
  `value` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_answers`
--

LOCK TABLES `survey_answers` WRITE;
/*!40000 ALTER TABLE `survey_answers` DISABLE KEYS */;
INSERT INTO `survey_answers` VALUES (1,77,52914,70920,'suggestion','2','2023-05-04 11:32:07'),(2,77,52916,70920,'suggestion','1','2023-05-04 11:32:10'),(3,77,52917,70920,'suggestion','1','2023-05-04 11:32:12'),(4,77,52919,70920,'suggestion','1','2023-05-04 11:32:14'),(5,77,52920,70920,'suggestion','1','2023-05-04 11:32:16'),(6,77,52922,70920,'suggestion','1','2023-05-04 11:32:18'),(7,77,52924,70920,'suggestion','1','2023-05-04 11:32:20'),(8,77,52926,70920,'suggestion','1','2023-05-04 11:32:22'),(9,77,52927,70920,'suggestion','1','2023-05-04 11:32:23'),(10,77,52929,70920,'suggestion','1','2023-05-04 11:32:25'),(11,77,52931,70920,'suggestion','1','2023-05-04 11:32:27'),(12,77,52933,70920,'suggestion','1','2023-05-04 11:32:30'),(13,77,52935,70920,'suggestion','1','2023-05-04 11:32:32'),(14,77,52936,70920,'suggestion','1','2023-05-04 11:32:34'),(15,77,52938,70920,'suggestion','1','2023-05-04 11:32:37'),(16,77,52941,70920,'suggestion','1','2023-05-04 11:32:39'),(17,77,52942,70920,'suggestion','1','2023-05-04 11:32:41'),(18,77,52943,70920,'suggestion','1','2023-05-04 11:32:44'),(19,77,52945,70920,'suggestion','1','2023-05-04 11:32:46'),(20,77,52947,70920,'suggestion','1','2023-05-04 11:32:48'),(21,77,52949,70920,'suggestion','1','2023-05-04 11:32:54'),(22,77,52951,70920,'suggestion','1','2023-05-04 11:32:56'),(23,77,52953,70920,'suggestion','1','2023-05-04 11:32:58'),(24,77,52954,70920,'suggestion','1','2023-05-04 11:33:01'),(25,77,52955,70920,'suggestion','1','2023-05-04 11:33:04'),(26,77,52956,70920,'suggestion','1','2023-05-04 11:33:06'),(27,77,52897,70919,'suggestion','4','2023-05-04 11:31:24'),(28,77,52899,70919,'suggestion','3','2023-05-04 11:31:27'),(29,77,52900,70919,'suggestion','4','2023-05-04 11:31:29'),(30,77,52901,70919,'suggestion','4','2023-05-04 11:31:32'),(31,77,52902,70919,'suggestion','7','2023-05-04 11:31:35'),(32,77,52903,70919,'suggestion','4','2023-05-04 11:31:37'),(33,77,52904,70919,'suggestion','5','2023-05-04 11:31:40'),(34,77,52905,70919,'suggestion','5','2023-05-04 11:31:43'),(35,77,52906,70919,'suggestion','4','2023-05-04 11:31:46'),(36,77,52907,70919,'suggestion','6','2023-05-04 11:31:49'),(37,77,52909,70919,'suggestion','4','2023-05-04 11:31:54'),(38,77,52911,70919,'suggestion','5','2023-05-04 11:31:57'),(39,77,52912,70919,'suggestion','5','2023-05-04 11:32:00'),(40,77,52913,70919,'suggestion','5','2023-05-04 11:32:03'),(41,77,52915,70919,'suggestion','6','2023-05-04 11:32:08'),(42,77,52918,70919,'suggestion','4','2023-05-04 11:32:12'),(43,77,52921,70919,'suggestion','5','2023-05-04 11:32:16'),(44,77,52923,70919,'suggestion','6','2023-05-04 11:32:18'),(45,77,52925,70919,'suggestion','7','2023-05-04 11:32:21'),(46,77,52928,70919,'suggestion','5','2023-05-04 11:32:24'),(47,77,52930,70919,'suggestion','5','2023-05-04 11:32:26'),(48,77,52932,70919,'suggestion','5','2023-05-04 11:32:29'),(49,77,52934,70919,'suggestion','7','2023-05-04 11:32:32'),(50,77,52937,70919,'suggestion','6','2023-05-04 11:32:35'),(51,77,52939,70919,'suggestion','7','2023-05-04 11:32:37'),(52,77,52940,70919,'suggestion','2','2023-05-04 11:32:39'),(53,77,52398,68647,'suggestion','2','2023-04-14 18:26:28'),(54,77,52399,68647,'suggestion','2','2023-04-14 18:26:28'),(55,77,52400,68647,'suggestion','1','2023-04-14 18:26:28'),(56,77,52401,68647,'suggestion','1','2023-04-14 18:26:28'),(57,77,52402,68647,'suggestion','2','2023-04-14 18:26:28'),(58,77,52403,68647,'suggestion','7','2023-04-14 18:26:28'),(59,77,52404,68647,'suggestion','7','2023-04-14 18:26:28'),(60,77,52405,68647,'suggestion','2','2023-04-14 18:26:28'),(61,77,52406,68647,'suggestion','6','2023-04-14 18:26:28'),(62,77,52407,68647,'suggestion','7','2023-04-14 18:26:28'),(63,77,52408,68647,'suggestion','7','2023-04-14 18:26:28'),(64,77,52409,68647,'suggestion','7','2023-04-14 18:26:28'),(65,77,52410,68647,'suggestion','2','2023-04-14 18:26:28'),(66,77,52411,68647,'suggestion','5','2023-04-14 18:26:28'),(67,77,52412,68647,'suggestion','7','2023-04-14 18:26:28'),(68,77,52413,68647,'suggestion','7','2023-04-14 18:26:28'),(69,77,52414,68647,'suggestion','7','2023-04-14 18:26:28'),(70,77,52415,68647,'suggestion','5','2023-04-14 18:26:28'),(71,77,52416,68647,'suggestion','6','2023-04-14 18:26:28'),(72,77,52417,68647,'suggestion','7','2023-04-14 18:26:28'),(73,77,52418,68647,'suggestion','7','2023-04-14 18:26:28'),(74,77,52419,68647,'suggestion','7','2023-04-14 18:26:28'),(75,77,52420,68647,'suggestion','7','2023-04-14 18:26:28'),(76,77,52421,68647,'suggestion','7','2023-04-14 18:26:28'),(77,77,52422,68647,'suggestion','3','2023-04-14 18:26:28'),(78,77,52423,68647,'suggestion','7','2023-04-14 18:26:28');
/*!40000 ALTER TABLE `survey_answers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-05  7:02:07
