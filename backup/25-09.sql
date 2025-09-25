-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: opi_bd
-- ------------------------------------------------------
-- Server version	11.5.2-MariaDB

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
-- Table structure for table `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avaliacao` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `comentario` varchar(255) NOT NULL,
  `estrelas` double NOT NULL,
  `alvo_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `avaliacao_user_id_alvo_id_unique` (`user_id`,`alvo_id`),
  CONSTRAINT `avaliacao_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avaliacao`
--

LOCK TABLES `avaliacao` WRITE;
/*!40000 ALTER TABLE `avaliacao` DISABLE KEYS */;
INSERT INTO `avaliacao` VALUES (1,2,'serviço muito bom',3.5,1,'2025-09-23 02:07:48','2025-09-23 02:07:48'),(3,2,'serviço muito bom',2.5,6,'2025-09-24 17:15:54','2025-09-24 17:15:54');
/*!40000 ALTER TABLE `avaliacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `id_prestador_destino` bigint(20) unsigned DEFAULT NULL,
  `id_empresa_autor` bigint(20) unsigned DEFAULT NULL,
  `id_contratante_autor` bigint(20) unsigned DEFAULT NULL,
  `id_empresa_destino` bigint(20) unsigned DEFAULT NULL,
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
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nome` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `cpf` varchar(255) DEFAULT NULL,
  `localidade` varchar(255) NOT NULL,
  `uf` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `infoadd` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contratante_user_id_foreign` (`user_id`),
  CONSTRAINT `contratante_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contratante`
--

LOCK TABLES `contratante` WRITE;
/*!40000 ALTER TABLE `contratante` DISABLE KEYS */;
INSERT INTO `contratante` VALUES (1,2,'kiko','fotos/ABf7wBnztc3SOQB97TVG16hQnJHMCfGaHcTw2lEw.jpg','055.527.560-45','Jaú','SP','São Paulo','17207560','rua joao alves','123','jauserve'),(2,8,'bobo','fotos/23LzCj1Fg2quXdCc3xkGojt12j8nEGyyIuoh2Cwb.png','546.476.867-87','Jaú','SP','São Paulo','17207-560','Rua João Alves','567','gfhdgfgf'),(3,9,'bobs','fotos/ZHOwWGOUy7wZJP4ePVfbr0yekCS6dTz8im2xWqoK.png','942.805.440-26','Jaú','SP','São Paulo','17207-560','Rua João Alves','568','hhhhhhhhh'),(4,10,'Pietro Joaquim Rodrigues','fotos/bBPxMffWsqp9Tpxuur7krgLs4lTowp5nbbLqdGHg.jpg','28.152.775-1','Jau','SP','São Paulo','17207560','rua das flores','122','dsggsagg'),(5,11,'lololo','fotos/W0z1U7PClk7Ng5ZEDoIGSsXWQ6FQduqCRQQeAXFH.png','789.445.331-11','Jaú','SP','São Paulo','17207-560','Rua João Alves','123','lklk'),(6,12,'jack','fotos/Kx7MXxswyjHILl29QOEvNmCuMa2XhePqg04xWS6R.png','585.856.231-47','Jaú','SP','São Paulo','17207-560','Rua João Alves','456','ghgfm');
/*!40000 ALTER TABLE `contratante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `cnpj` varchar(255) NOT NULL,
  `razao_social` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `localidade` varchar(255) NOT NULL,
  `uf` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `infoadd` varchar(255) NOT NULL,
  `id_ramo` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empresa_cnpj_unique` (`cnpj`),
  KEY `empresa_user_id_foreign` (`user_id`),
  KEY `empresa_id_ramo_foreign` (`id_ramo`),
  CONSTRAINT `empresa_id_ramo_foreign` FOREIGN KEY (`id_ramo`) REFERENCES `ramo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `empresa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,1,'90.653.970/0001-89','LMCorp','fotos/WcT8tVKX9DEryLRh1hmdI2Usn5Uxcud6VoKVt0Hb.jpg','Jaú','SP','São Paulo','17207560','123','rua joao alves','jauserve',1),(5,6,'66.883.970/0001-89','PaCorp','fotos/TP8AdmpUaLvxkYcKSBw0RmUOGBZlR03VUdDPTUra.jpg','Jaú','SP','São Paulo','17207560','123','rua joao alves','jauserve',1),(6,7,'12.759.687/0001-22','JCCorp','fotos/3lZPVn7AjfTbytqGoGtdThWwqFLszSRK7nVkKM4z.jpg','Jaú','SP','São Paulo','17207560','123','rua joao alves','jauserve',2);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fotos`
--

DROP TABLE IF EXISTS `fotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fotos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) NOT NULL,
  `portfolio_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fotos_portfolio_id_foreign` (`portfolio_id`),
  CONSTRAINT `fotos_portfolio_id_foreign` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotos`
--

LOCK TABLES `fotos` WRITE;
/*!40000 ALTER TABLE `fotos` DISABLE KEYS */;
/*!40000 ALTER TABLE `fotos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link`
--

DROP TABLE IF EXISTS `link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `link` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `link_user_id_foreign` (`user_id`),
  CONSTRAINT `link_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_04_09_193302_create_users_table',1),(2,'2025_05_13_211842_ramo',1),(3,'2025_05_13_211909_contratante',1),(4,'2025_05_13_211917_empresa',1),(5,'2025_05_13_211923_prestador',1),(6,'2025_05_13_211935_link',1),(7,'2025_05_13_211940_portfolio',1),(8,'2025_05_26_112039_create_avaliacao_table',1),(9,'2025_08_21_165325_password_code',1),(10,'2025_09_10_224639_telefone',1),(11,'2025_09_21_133310_create_fotos_table',1),(12,'2025_09_21_133329_create_videos_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_code`
--

DROP TABLE IF EXISTS `password_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_code` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `code` varchar(6) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_code`
--

LOCK TABLES `password_code` WRITE;
/*!40000 ALTER TABLE `password_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portfolio` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `id_user` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `portfolio_id_user_foreign` (`id_user`),
  CONSTRAINT `portfolio_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `prestador` (`id`) ON DELETE CASCADE
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
-- Table structure for table `portfolios`
--

DROP TABLE IF EXISTS `portfolios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portfolios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `portfolios_user_id_foreign` (`user_id`),
  CONSTRAINT `portfolios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolios`
--

LOCK TABLES `portfolios` WRITE;
/*!40000 ALTER TABLE `portfolios` DISABLE KEYS */;
/*!40000 ALTER TABLE `portfolios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestador`
--

DROP TABLE IF EXISTS `prestador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestador` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `cpf` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `localidade` varchar(255) NOT NULL,
  `uf` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `infoadd` varchar(255) NOT NULL,
  `id_ramo` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prestador_user_id_foreign` (`user_id`),
  KEY `prestador_id_ramo_foreign` (`id_ramo`),
  CONSTRAINT `prestador_id_ramo_foreign` FOREIGN KEY (`id_ramo`) REFERENCES `ramo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prestador_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestador`
--

LOCK TABLES `prestador` WRITE;
/*!40000 ALTER TABLE `prestador` DISABLE KEYS */;
INSERT INTO `prestador` VALUES (1,'Julia Pietra Almeida',14,'790.705.160-63','fotos/zWaF65h1BHOuJXf8NM6Lb4Mk3xpL6Dl7HOgHsFvJ.png','Arealva','SP','São Paulo','17162-218','123','Rua João Batista de Assis Bandeira','ureyjrt',24);
/*!40000 ALTER TABLE `prestador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ramo`
--

DROP TABLE IF EXISTS `ramo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ramo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `modalidade` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ramo`
--

LOCK TABLES `ramo` WRITE;
/*!40000 ALTER TABLE `ramo` DISABLE KEYS */;
INSERT INTO `ramo` VALUES (1,'Pedreiro','Presencial'),(2,'Servente de Obras','Presencial'),(3,'Pintor','Presencial'),(4,'Eletricista','Presencial'),(5,'Encanador','Presencial'),(6,'Carpinteiro','Presencial'),(7,'Marceneiro','Presencial'),(8,'Serralheiro','Presencial'),(9,'Gesseiro','Presencial'),(10,'Azulejista','Presencial'),(11,'Telhadista','Presencial'),(12,'Vidraceiro','Presencial'),(13,'Calheiro','Presencial'),(14,'Jardineiro','Presencial'),(15,'Paisagista','Presencial'),(16,'Mestre de Obras','Presencial'),(17,'Técnico em Refrigeração','Presencial'),(18,'Montador de Móveis','Presencial'),(19,'Instalador de Drywall','Presencial'),(20,'Chaveiro','Presencial'),(21,'Pintor Automotivo','Presencial'),(22,'Mecânico de Automóveis','Presencial'),(23,'Caldeireiro','Presencial'),(24,'Soldador','Presencial'),(25,'Operador de Máquinas Pesadas','Presencial');
/*!40000 ALTER TABLE `ramo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefone`
--

DROP TABLE IF EXISTS `telefone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefone` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `telefone` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `telefone_telefone_unique` (`telefone`),
  KEY `telefone_user_id_foreign` (`user_id`),
  CONSTRAINT `telefone_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefone`
--

LOCK TABLES `telefone` WRITE;
/*!40000 ALTER TABLE `telefone` DISABLE KEYS */;
INSERT INTO `telefone` VALUES (1,1,'(81) 9874-3554'),(2,2,'(81) 5698-3554'),(6,6,'(81) 5678-4381'),(7,7,'(81) 1835-1199'),(8,8,'(21) 24355-4656'),(9,9,'(14) 98133-7566'),(10,10,'(47) 2825-4483'),(11,11,'(65) 65666-8888'),(12,12,'(14) 55387-9642'),(14,14,'(84) 37342-249');
/*!40000 ALTER TABLE `telefone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum('empresa','prestador','contratante') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'mat@gmail.com','$2y$12$UDfX6rkvi7.QncdUT1PbH.WvdiLMTqLKX2U.vAipY7l/wZ6l9E6kW','empresa'),(2,'kiko@gmail.com','$2y$12$faLMp.13uDZnfPJMlcpUWe0g6CDVbbdMst4WXa4uDp6eTRHY0i2i6','contratante'),(6,'patrick@gmail.com','$2y$12$IRgs2myKtrOXGqIL2.LZIeXSoJ0W6k/UZxyP7UZNs0W.DAgUJPaP.','empresa'),(7,'jose@gmail.com','$2y$12$s8uDboGmRc/X7LTk57mE5eDvCcTE6IboZQIufP.Eni6.iL2jbsRb6','empresa'),(8,'bob@gmail.com','$2y$12$Tyf85xFL8D5RLgQ2AHcJb.m7XF7KYopQ/2i.a3k2/CzWEgi9EDN9m','contratante'),(9,'bobs@gmail.com','$2y$12$VW8kaHlAwZg/GZ4qNxpA/.gAHTZ/59.MVyN6hAsjMnsRgVCKM82eu','contratante'),(10,'pietro_joaquim_rodrigues@netwis.com.br','$2y$12$FYarzHmQbyXEkCw7d128YOHANNDGARvq2Tbwt6ap5p3lQuvoHOayu','contratante'),(11,'logado@gmail.com','$2y$12$weco3Q1tSLmLpWB0eEOLGOh01O58k/sbpemoES.f7KXnQJZ0rzV1u','contratante'),(12,'jack@gmail.com','$2y$12$97qYa.Mt6JSDp4y20oJE.uT6ye3LVsc1Ukc741tULj7ZFkiDviEtm','contratante'),(14,'julia.pietra.almeida@pmi.com','$2y$12$WmmwO3pTRX2Eo4SH1oV69.8rlZ99BeQncmdGBuDimTKUDFKHYVeHS','prestador');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `video` varchar(255) NOT NULL,
  `portfolio_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `videos_portfolio_id_foreign` (`portfolio_id`),
  CONSTRAINT `videos_portfolio_id_foreign` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-25 15:23:20
