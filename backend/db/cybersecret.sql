-- MariaDB dump 10.19  Distrib 10.4.19-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: cyber_secret
-- ------------------------------------------------------
-- Server version	10.4.19-MariaDB

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
-- Table structure for table `stats`
--

DROP TABLE IF EXISTS `stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stats` (
  `user_id` int(11) NOT NULL,
  `strength` int(11) NOT NULL DEFAULT 0,
  `dexterity` int(11) NOT NULL DEFAULT 0,
  `charisma` int(11) NOT NULL DEFAULT 0,
  `intelligence` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `stats_user_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stats`
--

LOCK TABLES `stats` WRITE;
/*!40000 ALTER TABLE `stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_username_uindex` (`username`),
  UNIQUE KEY `user_user_id_uindex` (`user_id`),
  UNIQUE KEY `user_email_uindex` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Artx999','mrjj@live.no','$2y$10$9pVEbwFmFzCjYt91kRghdOyNX1pkPabf2GyhLBUcffFPC2mexsuAG','2002-11-27','2021-01-17 00:23:58'),(7,'iohj','uiohl','$2y$10$uiigoQ6fV3/xOEGYqnCfbuisdDdHpHGqjoo8WuQ2gD7QI9XtIZkjW','1200-12-12','2021-01-18 21:10:18'),(8,'a','a','$2y$10$VvOS4ZClLlq01SxHK6LUpu8x3vId9wRKKwDEEqPF4A7d6XW5TWWYG',NULL,'2021-01-26 12:18:52'),(10,'xfvgynj cghbvujm ','dfhrtgfdxrthgb','$2y$10$PamA4QkEidoYvTa3vLHMcevVn7UEgJGEDHE6yLZP89dxy3377QEjm','0000-00-00','2021-07-08 01:24:42'),(11,'gzdb rtxe','hbaedrtg','$2y$10$DbZHaRq93waW02ov4AaO1.H53yNoOO6f49BSj88YHKSZayibIe2T2','0000-00-00','2021-07-08 01:25:48'),(12,'yutrhea','kjtrhewr','$2y$10$NynlWmJ8nMzKn0IVJFPQmufni1tyKd9bUiizK2crWTOo5A4adDF0m','0000-00-00','2021-07-08 01:27:05'),(13,'hdaet','grw','$2y$10$jIVwBuSVYn35ejAJPH/gOOAkfoUSMf6OStFwhFsnvoOpLxP3oqhJO','0000-00-00','2021-07-08 01:31:23'),(16,'awdrfafqawf','qeqwrwqrf','$2y$10$UPvugv4/Uro52HWFLK2LJ.J6W6/wfHnHBhHDeMVneCDeh3GWGefWO','0000-00-00','2021-07-08 01:38:23'),(20,'liukgycfjghxyhdtxzgdrz','fxgnhnfghcghmmghcjmghjc','$2y$10$IIOOhzE/CrAuCzt/cWwkYON1sDzoipK39.Y77Sfl8fSTA69529cSu','0000-00-00','2021-07-08 01:58:56'),(21,'lol','lol','$2y$10$Z0rmkYzmGFQLY3WuVdcGsOo9MYFxhESb7TOs8DhanGLD7HLEp/rDa','0000-00-00','2021-07-08 02:06:35'),(22,'lkjhgfd','fdsghjfgk','$2y$10$wXRhQA0nMW/sck4FuBa.de67l6C48epOezv26R1t5cyOquOPDw7cC','0000-00-00','2021-07-08 03:28:30'),(23,'ojoi',NULL,'$2y$10$OCDiSFDl0khpfWV7hkh65.20hCqPfAndUAUyyJEXknxj77RTEyPY6','0000-00-00','2021-07-13 23:59:55'),(24,'tygh',NULL,'$2y$10$KVR7mJbjH9JnOiJba3xBn.BfVun8jh16IzuD4OMbInzHlov633l0G',NULL,'2021-07-14 00:24:19');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-14  0:38:27
