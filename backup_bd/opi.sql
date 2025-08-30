-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: opi_bd
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cidade`
--

DROP TABLE IF EXISTS `cidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cidade` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_estado` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cidade_id_estado_foreign` (`id_estado`),
  CONSTRAINT `cidade_id_estado_foreign` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cidade`
--

LOCK TABLES `cidade` WRITE;
/*!40000 ALTER TABLE `cidade` DISABLE KEYS */;
INSERT INTO `cidade` VALUES (1,'São Paulo',1),(2,'Campinas',1),(3,'Rio de Janeiro',2),(4,'Niterói',2),(5,'Belo Horizonte',3),(6,'Uberlândia',3),(7,'Salvador',4),(8,'Feira de Santana',4),(9,'Curitiba',5),(10,'Londrina',5);
/*!40000 ALTER TABLE `cidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_prestador_destino` bigint unsigned DEFAULT NULL,
  `id_empresa_autor` bigint unsigned DEFAULT NULL,
  `id_contratante_autor` bigint unsigned DEFAULT NULL,
  `id_empresa_destino` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contratante`
--

DROP TABLE IF EXISTS `contratante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contratante` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cidade` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contratante_email_unique` (`email`),
  KEY `contratante_id_cidade_foreign` (`id_cidade`),
  CONSTRAINT `contratante_id_cidade_foreign` FOREIGN KEY (`id_cidade`) REFERENCES `cidade` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contratante`
--

LOCK TABLES `contratante` WRITE;
/*!40000 ALTER TABLE `contratante` DISABLE KEYS */;
/*!40000 ALTER TABLE `contratante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cnpj` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cep` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cidade` bigint unsigned NOT NULL,
  `id_ramo` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empresa_email_unique` (`email`),
  UNIQUE KEY `empresa_cnpj_unique` (`cnpj`),
  KEY `empresa_id_cidade_foreign` (`id_cidade`),
  KEY `empresa_id_ramo_foreign` (`id_ramo`),
  CONSTRAINT `empresa_id_cidade_foreign` FOREIGN KEY (`id_cidade`) REFERENCES `cidade` (`id`) ON DELETE CASCADE,
  CONSTRAINT `empresa_id_ramo_foreign` FOREIGN KEY (`id_ramo`) REFERENCES `ramo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (3,'empresa1','empresa1@email.com','$2y$12$33Uv8xyVVzsGtQWNl.4QQ.WZ/m8mohogsMpwir69YeE.cTQcNWd5m','11999999999','1133333333','/server/fotos/joao','12345678000199','01001000',1,1),(4,'empresa2','empresa2@email.com','$2y$12$33Uv8xyVVzsGtQWNl.4QQ.WZ/m8mohogsMpwir69YeE.cTQcNWd5m','21988888888','2133333333','/server/fotos/maria','98765432000188','02002000',1,1);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sigla` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pais` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `estado_id_pais_foreign` (`id_pais`),
  CONSTRAINT `estado_id_pais_foreign` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'São Paulo','SP',1),(2,'Rio de Janeiro','RJ',1),(3,'Minas Gerais','MG',1),(4,'Bahia','BA',1),(5,'Paraná','PR',1);
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link`
--

DROP TABLE IF EXISTS `link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `link` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prestador_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link`
--

LOCK TABLES `link` WRITE;
/*!40000 ALTER TABLE `link` DISABLE KEYS */;
/*!40000 ALTER TABLE `link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_05_13_211556_pais',1),(2,'2025_05_13_211615_estado',1),(3,'2025_05_13_211621_cidade',1),(4,'2025_05_13_211842_ramo',1),(5,'2025_05_13_211909_contratante',1),(6,'2025_05_13_211917_empresa',1),(7,'2025_05_13_211923_prestador',1),(8,'2025_05_13_211935_link',1),(9,'2025_05_13_211940_portfolio',1),(10,'2025_05_26_112039_create_comentarios_table',1),(11,'2025_08_21_165325_password_code',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pais` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES (1,'brasil');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_code`
--

DROP TABLE IF EXISTS `password_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_code` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_code`
--

LOCK TABLES `password_code` WRITE;
/*!40000 ALTER TABLE `password_code` DISABLE KEYS */;
INSERT INTO `password_code` VALUES (1,'joao.silva@email.com','719599','2025-08-28 01:22:29','2025-08-28 01:09:52','2025-08-28 01:12:29'),(2,'teste@email.com','231711','2025-08-28 02:11:05','2025-08-28 01:35:14','2025-08-28 02:01:05'),(3,'empresa1@email.com','221194','2025-08-28 02:18:29','2025-08-28 02:07:19','2025-08-28 02:08:29');
/*!40000 ALTER TABLE `password_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portfolio` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_prestador` bigint unsigned NOT NULL,
  `id_empresa` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `portfolio_id_prestador_foreign` (`id_prestador`),
  KEY `portfolio_id_empresa_foreign` (`id_empresa`),
  CONSTRAINT `portfolio_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `portfolio_id_prestador_foreign` FOREIGN KEY (`id_prestador`) REFERENCES `prestador` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolio`
--

LOCK TABLES `portfolio` WRITE;
/*!40000 ALTER TABLE `portfolio` DISABLE KEYS */;
/*!40000 ALTER TABLE `portfolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestador`
--

DROP TABLE IF EXISTS `prestador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestador` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cep` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cidade` bigint unsigned NOT NULL,
  `id_ramo` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prestador_id_cidade_foreign` (`id_cidade`),
  KEY `prestador_id_ramo_foreign` (`id_ramo`),
  CONSTRAINT `prestador_id_cidade_foreign` FOREIGN KEY (`id_cidade`) REFERENCES `cidade` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prestador_id_ramo_foreign` FOREIGN KEY (`id_ramo`) REFERENCES `ramo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestador`
--

LOCK TABLES `prestador` WRITE;
/*!40000 ALTER TABLE `prestador` DISABLE KEYS */;
INSERT INTO `prestador` VALUES (1,'João Silva','joao.silva@email.com','$2y$12$G5WnFv14grE/Ah/ou2un2.TSkDYIzxJxsyTZ0SsC8ExzTlHCzvpTG','11999999999','1133334444','/serve/foto/joao','01001000',1,1),(2,'Maria Souza','maria.souza@email.com','$2y$12$G5WnFv14grE/Ah/ou2un2.TSkDYIzxJxsyTZ0SsC8ExzTlHCzvpTG','21988887777','2132223333','/serve/foto/maria','20040002',1,1),(3,'Carlos Pereira','carlos.pereira@email.com','$2y$12$G5WnFv14grE/Ah/ou2un2.TSkDYIzxJxsyTZ0SsC8ExzTlHCzvpTG','31977776666','3131112222','/serve/foto/carlos','30110001',1,1),(4,'Ana Oliveira','ana.oliveira@email.com','$2y$12$G5WnFv14grE/Ah/ou2un2.TSkDYIzxJxsyTZ0SsC8ExzTlHCzvpTG','41966665555','4130001111','/serve/foto/ana','80010000',1,1),(5,'Pedro Santos','pedro.santos@email.com','$2y$12$G5WnFv14grE/Ah/ou2un2.TSkDYIzxJxsyTZ0SsC8ExzTlHCzvpTG','51955554444','5132221111','/serve/foto/pedro','90010000',1,1),(6,'Teste','teste@email.com','$2y$12$Po5cnxQM/kuAF5PWTVPpBO4dzM.ch1edhxCuexEWxyExQp4uVaEYG','51955554444','5132221111','/serve/foto/teste','90010000',1,1);
/*!40000 ALTER TABLE `prestador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ramo`
--

DROP TABLE IF EXISTS `ramo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ramo` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modalidade` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ramo`
--

LOCK TABLES `ramo` WRITE;
/*!40000 ALTER TABLE `ramo` DISABLE KEYS */;
INSERT INTO `ramo` VALUES (1,'servente','escravo'),(2,'pintor','presencial'),(3,'design','home-office');
/*!40000 ALTER TABLE `ramo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-30 19:41:47
