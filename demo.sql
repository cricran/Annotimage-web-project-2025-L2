-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: annotimage
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `annotation`
--

DROP TABLE IF EXISTS `annotation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `annotation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `imageId` int NOT NULL,
  `description` varchar(1024) NOT NULL,
  `startX` int NOT NULL,
  `startY` int NOT NULL,
  `endX` int NOT NULL,
  `endY` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `imageId` (`imageId`),
  CONSTRAINT `annotation_ibfk_1` FOREIGN KEY (`imageId`) REFERENCES `image` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annotation`
--

LOCK TABLES `annotation` WRITE;
/*!40000 ALTER TABLE `annotation` DISABLE KEYS */;
INSERT INTO `annotation` VALUES (67,67,'Une tête',1395,990,565,7),(68,71,'roche',533,540,612,597),(69,71,'pilonne',112,224,129,379),(70,71,'pilonne',151,210,186,374),(71,71,'pilonne',209,197,241,369),(72,71,'pilonne',274,188,301,371),(73,71,'pilonne',336,169,372,365),(74,71,'pilonne',412,154,458,364),(75,71,'pilonne',501,131,547,360),(76,75,'Une statue',579,61,622,169),(77,75,'le cheval',448,204,554,400),(78,79,'lion',213,285,312,389),(79,79,'lion',466,50,538,149),(80,81,'ça fait un traingle rectangle',4,7,157,223),(81,81,'ciel',304,318,248,461);
/*!40000 ALTER TABLE `annotation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `public` tinyint(1) DEFAULT '0',
  `date` datetime NOT NULL,
  `userId` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `image_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` VALUES (67,'67.webp','darth vader',1,'2025-05-09 19:02:38',13),(68,'68.jpeg','Tour Eiffel',1,'2025-05-09 19:05:46',13),(69,'69.jpeg','Paysage de montagne',0,'2025-05-09 19:06:48',13),(70,'70.jpeg','Un beau batiment',1,'2025-05-09 19:07:53',11),(71,'71.jpeg','Quelques colonne noire',1,'2025-05-09 19:08:46',11),(72,'72.jpeg','Une stelle',1,'2025-05-09 19:10:36',11),(73,'73.jpeg','Truc sur un pilier',1,'2025-05-09 19:12:16',11),(74,'74.jpeg','Rien sur une colonne',1,'2025-05-09 19:13:41',11),(75,'75.jpeg','Wouaw !!!',0,'2025-05-09 19:14:42',11),(76,'76.jpeg','Montagne',1,'2025-05-09 19:19:01',12),(77,'77.jpeg','Un château dans l&#039;eau',1,'2025-05-09 19:19:56',12),(78,'78.jpeg','Une statue (allemagne ?)',1,'2025-05-09 19:21:06',12),(79,'79.jpeg','IL Y A DES LIONS !!!',1,'2025-05-09 19:22:16',12),(80,'80.jpeg','Enfant avec des oiseaux',1,'2025-05-09 19:23:33',12),(81,'81.jpeg','Une image...',0,'2025-05-09 19:24:31',12);
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (87,'???'),(90,'chateau'),(82,'cheval'),(76,'ciel'),(65,'cinema'),(81,'collone'),(85,'colonne'),(67,'darth vader'),(89,'eau'),(66,'film'),(77,'herbe'),(93,'lion'),(69,'metal'),(88,'montagne'),(72,'monument'),(75,'nuage'),(94,'oiseaux'),(71,'Paris'),(74,'paysage'),(79,'pierre'),(84,'pilier'),(80,'pillier'),(92,'pilonne'),(78,'roche'),(68,'Star wars'),(91,'statue'),(83,'texte'),(73,'tour'),(86,'truc'),(70,'ville');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taged`
--

DROP TABLE IF EXISTS `taged`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taged` (
  `imageId` int DEFAULT NULL,
  `tagId` int DEFAULT NULL,
  KEY `imageId` (`imageId`),
  KEY `tagId` (`tagId`),
  CONSTRAINT `taged_ibfk_1` FOREIGN KEY (`imageId`) REFERENCES `image` (`id`) ON DELETE CASCADE,
  CONSTRAINT `taged_ibfk_2` FOREIGN KEY (`tagId`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taged`
--

LOCK TABLES `taged` WRITE;
/*!40000 ALTER TABLE `taged` DISABLE KEYS */;
INSERT INTO `taged` VALUES (67,65),(67,66),(67,67),(67,68),(68,69),(68,70),(68,71),(68,72),(68,73),(69,74),(69,75),(69,76),(69,77),(69,78),(70,79),(70,76),(70,72),(71,80),(71,81),(71,77),(71,76),(71,79),(72,82),(72,83),(73,72),(73,86),(73,84),(73,81),(74,81),(74,87),(74,76),(75,82),(75,79),(76,77),(76,88),(77,89),(77,79),(77,90),(78,76),(78,72),(78,91),(79,81),(79,92),(79,93),(79,91),(80,94);
/*!40000 ALTER TABLE `taged` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (11,'utilisateur1','utilisateur1@web.com','$2y$10$Y4HOB2nHc2yJxoS1ZTzS1ul0c8UzVoP9HhQ26SkzRD4n2Ji.Xvjsy'),(12,'utilisateur2','utilisateur2@web.com','$2y$10$aPD/7uCB9dfcgGZgH86OMeVmW.wqeH55s8o9MEUXu0QWkH74IXfcC'),(13,'utilisateur3','utilisateur3@web.com','$2y$10$5S6k3rDee7w6QPx9ltK0F.tIQGMx7uUnkQpjluyiw5nv9pPhtIG..'),(14,'utilisateur4','utilisateur4@web.com','$2y$10$DvxO/b49juhMbNSFUAHe.ejR4MUuwXGcHDjfpwJpZLwhhIiKBBbf6'),(15,'utilisateur5','utilisateur5@web.com','$2y$10$HNpn/qXObESGBmBqlMmR5eO3mYTIbmUehLp5oC2DwY2q6W/1AYwa.');
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

-- Dump completed on 2025-05-09 19:37:00