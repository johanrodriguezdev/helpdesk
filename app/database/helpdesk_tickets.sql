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
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `idTick` int NOT NULL AUTO_INCREMENT,
  `usuId` int DEFAULT NULL,
  `categoriaId` int DEFAULT NULL,
  `tickTitulo` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `tickDescripcion` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `tickEstado` smallint DEFAULT NULL,
  `usuAsignadoId` int DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaCierre` datetime DEFAULT NULL,
  `fechaUpdate` datetime DEFAULT NULL,
  `tickPrioridad` smallint DEFAULT NULL,
  `estId` smallint DEFAULT NULL,
  `tickComentario` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  PRIMARY KEY (`idTick`),
  KEY `fk_usuario_ticket_idx` (`usuId`),
  KEY `fk_categoria_ticket_idx` (`categoriaId`),
  KEY `fk_usuario_asignacion_idx` (`usuAsignadoId`),
  KEY `fk_estado_idx` (`estId`),
  CONSTRAINT `fk_categoria_ticket` FOREIGN KEY (`categoriaId`) REFERENCES `tm_categorias` (`id`),
  CONSTRAINT `fk_estado` FOREIGN KEY (`estId`) REFERENCES `sys_estado` (`id`),
  CONSTRAINT `fk_usuario_asignacion` FOREIGN KEY (`usuAsignadoId`) REFERENCES `tm_trabajadores` (`id`),
  CONSTRAINT `fk_usuario_ticket` FOREIGN KEY (`usuId`) REFERENCES `sys_usuarios` (`usuId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (2,NULL,13,'Ticket de prueba22','',0,2,'2025-01-31 21:07:23',NULL,'2025-01-31 22:44:24',2,1,''),(4,1,2,'Ticket de prueba','descripcion de prueba',0,1,'2025-01-31 21:44:01',NULL,'2025-01-31 22:53:28',0,1,'comentario de prueba');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
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
