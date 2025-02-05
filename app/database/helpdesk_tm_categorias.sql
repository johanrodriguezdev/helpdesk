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
-- Table structure for table `tm_categorias`
--

DROP TABLE IF EXISTS `tm_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tm_categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) DEFAULT NULL,
  `descripcion` varchar(80) DEFAULT NULL,
  `estId` smallint DEFAULT NULL,
  `fechaCreate` datetime DEFAULT NULL,
  `fechaUpdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_estado_categorias_idx` (`estId`),
  CONSTRAINT `fk_estado_categorias` FOREIGN KEY (`estId`) REFERENCES `sys_estado` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_categorias`
--

LOCK TABLES `tm_categorias` WRITE;
/*!40000 ALTER TABLE `tm_categorias` DISABLE KEYS */;
INSERT INTO `tm_categorias` VALUES (1,'Categoria Uno','',1,'2025-01-30 22:23:00','2025-02-01 08:20:10'),(2,'Categoria Dos','',1,NULL,'2025-01-31 20:37:13'),(12,'Categoria Tres','pruebita',1,'2025-01-31 07:44:33','2025-01-31 20:37:21'),(13,'Categoria Cuatro','pruebaaaaa',1,'2025-01-31 07:45:38','2025-01-31 20:37:32'),(15,'Categoria cinco','',2,'2025-01-31 21:44:41','2025-01-31 21:44:44');
/*!40000 ALTER TABLE `tm_categorias` ENABLE KEYS */;
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
