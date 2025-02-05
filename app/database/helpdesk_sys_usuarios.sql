-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: helpdesk
-- ------------------------------------------------------
-- Server version	8.2.0

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
-- Table structure for table `sys_usuarios`
--

DROP TABLE IF EXISTS `sys_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_usuarios` (
  `usuId` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `password` varchar(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `estId` smallint DEFAULT NULL,
  `fechaCreate` datetime DEFAULT NULL,
  `fechaUpdate` datetime DEFAULT NULL,
  PRIMARY KEY (`usuId`),
  KEY `fk_estado_usuarios_idx` (`estId`),
  CONSTRAINT `fk_estado_usuarios` FOREIGN KEY (`estId`) REFERENCES `sys_estado` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_usuarios`
--

LOCK TABLES `sys_usuarios` WRITE;
/*!40000 ALTER TABLE `sys_usuarios` DISABLE KEYS */;
INSERT INTO `sys_usuarios` VALUES (1,'johan24','$2y$10$WIM9kIxLZjFSYimhRGbftuMFjiafjzIGD7ABx9HzW9c9v5hmNSi4u','johanrodriguez9915@gmail.com',1,'2025-01-28 23:25:56','2025-02-01 09:06:54'),(5,'magdalileon','$2y$10$Zppw8DsO1JXVuju3WUjhS.I6HDhHiHklaiLoWOGg39wI9mXBDQNt.','daliileon1998@gmail.com',1,'2025-01-30 21:01:53',NULL),(6,'lisethleon','$2y$10$pDUBrSAHiBsKDvZnVmjx0ect676nxqr/bPi0GnSbPc32zOwecgxOa','magdalileon1998@gmail.com',1,'2025-01-30 21:06:59',NULL),(7,'manu','$2y$10$m4iIz6Iu/szKMYQJzbox/OnzNSLBmfmv.8.fAXc6TSeF3ZzNha/3.','manuelleon225@hotmail.com',1,'2025-01-30 22:11:03',NULL);
/*!40000 ALTER TABLE `sys_usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-04 22:05:22
