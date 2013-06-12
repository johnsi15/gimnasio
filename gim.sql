CREATE DATABASE  IF NOT EXISTS `gim` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `gim`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: gim
-- ------------------------------------------------------
-- Server version	5.5.27

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
-- Table structure for table `fechasclientes`
--

DROP TABLE IF EXISTS `fechasclientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fechasclientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaInicial` date DEFAULT NULL,
  `fechaFinal` date DEFAULT NULL,
  `mes` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dias` int(11) DEFAULT NULL,
  `dinero` int(11) DEFAULT NULL,
  `condicion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigoEstudiante` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fechasclientes`
--

LOCK TABLES `fechasclientes` WRITE;
/*!40000 ALTER TABLE `fechasclientes` DISABLE KEYS */;
INSERT INTO `fechasclientes` VALUES (1,'john Andrey','2013-05-15','2013-05-31','05',16,10000,'Abono',1093763),(2,'john','2013-05-15','2013-05-31','05',16,0,'No Pago',2),(3,'andrey','2013-05-15','2013-05-31','05',16,30000,'Pago',12345),(4,'john','2013-05-22','2013-05-31','05',9,30000,'Pago',1093763837),(6,'andrey','2013-05-22','2013-05-31','05',9,30000,'Pago',1093547693),(11,'','2013-05-22','2013-06-01','06',NULL,30000,'Pago',12345),(12,'prueba3','2013-05-22','2013-05-31','05',9,30000,'Pago',123456),(14,'ActualizoTiempo','2013-05-23','2013-06-01','06',9,30000,'Pago',123456),(16,'prueba4','2013-05-23','2013-05-31','05',NULL,0,'No Pago',123),(17,'ActualizoTiempo','2013-05-24','2013-05-31','05',NULL,0,'No Pago',NULL),(18,'prueba','2013-05-24','2013-05-31','05',NULL,0,'No Pago',NULL),(19,'prueba 07','2013-06-12','2013-06-30','06',18,0,'No Pago',9876),(20,'prueba 06','2013-06-12','2013-06-30','06',18,30000,'Pago',12345690),(21,'prueba 08','2013-06-12','2013-06-30','06',18,0,'No Pago',1098374),(22,'prueba 09','2013-06-12','2013-06-30','06',18,0,'No Pago',912345);
/*!40000 ALTER TABLE `fechasclientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clave` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'andre','7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),(2,'prueb','7110eda4d09e062aa5e4a390b0a572ac0d2c0220');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiantes`
--

DROP TABLE IF EXISTS `estudiantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(10) DEFAULT NULL,
  `nombre` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  `edad` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `peso` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `altura` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaInicial` date DEFAULT NULL,
  `fechaFinal` date DEFAULT NULL,
  `dinero` int(11) DEFAULT NULL,
  `condicion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiantes`
--

LOCK TABLES `estudiantes` WRITE;
/*!40000 ALTER TABLE `estudiantes` DISABLE KEYS */;
INSERT INTO `estudiantes` VALUES (1,1093763,'john Andr3','18','54','172','2013-05-15','2013-05-31',10000,'Abono'),(2,1234567,'john','19','54','172','2013-05-15','2013-05-31',0,'No Pago'),(3,12345,'andrey','20','55','175','2013-05-22','2013-06-01',30000,'Pago'),(5,12345678,'andres','21','54','165','2013-05-15','2013-05-31',15000,'Abono'),(6,212345678,'maria','17','53','165','2013-05-16','2013-05-31',15000,'Pago'),(11,312345678,'leidy','18','45','168','2013-05-17','2013-05-31',30000,'Pago'),(12,412345678,'paola','20','56','160','2013-05-17','2013-05-31',0,'No Pago'),(13,512345678,'johanna','16','50','167','2013-05-17','2013-05-31',11000,'Abono'),(14,612345678,'karla','20','55','169','2013-05-17','2013-05-31',30000,'No Pago'),(15,712345678,'yuri','16','56','168','2013-05-17','2013-05-31',0,'No Pago'),(16,812345678,'falcao','21','58','178','2013-05-17','2013-05-31',0,'No Pago'),(17,912345678,'eduardo','21','64','173','2013-05-17','2013-05-31',0,'No Pago'),(18,1012345678,'mario','23','54','173','2013-05-17','2013-05-31',0,'No Pago'),(19,1112345678,'prueba','19','54','189','2013-05-21','2013-06-01',30000,'Pago'),(20,123456,'prueba3','19','55','170','2013-05-24','2013-05-31',0,'No Pago'),(21,1093763837,'john','18','54','172','2013-05-22','2013-05-31',30000,'Pago'),(30,1093547693,'andrey','19','54','172','2013-05-22','2013-05-31',30000,'Pago'),(31,123,'prueba4','19','56','189','2013-05-23','2013-05-31',0,'No Pago'),(32,1094567,'prueba','18','56','178','2013-05-24','2013-05-31',0,'No Pago'),(33,1093765239,'prueba scroll','19','56','176','2013-05-24','2013-05-27',0,'No Pago'),(34,109023456,'prueba vencimiento','19','45','163','2013-05-25','2013-05-28',0,'No Pago'),(35,12345690,'prueba 06','19','54','198','2013-06-12','2013-06-30',30000,'Pago'),(36,9876,'prueba 07','20','68','183','2013-06-12','2013-06-30',0,'No Pago'),(37,1098374,'prueba 08','23','45','179','2013-06-12','2013-06-30',0,'No Pago'),(38,912345,'prueba 09','23','58','183','2013-06-12','2013-06-30',0,'No Pago');
/*!40000 ALTER TABLE `estudiantes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-06-12 12:44:50
