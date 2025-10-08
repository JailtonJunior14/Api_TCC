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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotos`
--

LOCK TABLES `fotos` WRITE;
/*!40000 ALTER TABLE `fotos` DISABLE KEYS */;
INSERT INTO `fotos` VALUES (1,'fotos/portfolio/dDhUoHWyX2Yl09oQrXLVyyQ1xbQMRqO6iXAlUH48.png',1,'2025-10-08 19:49:29','2025-10-08 19:49:29'),(2,'fotos/portfolio/qUJwV2mTu5OLLdGJD3pj0wXMmbLmzDvdrH05rLUG.jpg',2,'2025-10-08 21:32:07','2025-10-08 21:32:07'),(3,'fotos/portfolio/f9AzB2jczt4sS2SRstNdq9z86QIdk2wwRhBM2e45.jpg',2,'2025-10-08 21:32:07','2025-10-08 21:32:07');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolios`
--

LOCK TABLES `portfolios` WRITE;
/*!40000 ALTER TABLE `portfolios` DISABLE KEYS */;
INSERT INTO `portfolios` VALUES (1,'trabalhos testes videos',5,'2025-10-08 19:49:29','2025-10-08 19:49:29'),(2,'trabalhos testes imagens',5,'2025-10-08 21:32:07','2025-10-08 21:32:07'),(3,'trabalhos testes videos sozinhos',5,'2025-10-08 21:32:46','2025-10-08 21:32:46'),(4,'trabalhos testes videos 2',5,'2025-10-08 21:36:15','2025-10-08 21:36:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestador`
--

LOCK TABLES `prestador` WRITE;
/*!40000 ALTER TABLE `prestador` DISABLE KEYS */;
INSERT INTO `prestador` VALUES (1,'carlos',1,'432.698.969-64','fotos/be0Zd1D0mK3aG1pkFh7yGEtw3G2gUEIdwWvDhVjX.jpg','Jaú','SP','São Paulo','17208130','123','rua braz domingos rossi','jauserve',1),(2,'Antônio José',2,'458.953.421-32','fotos/sKTnPCvZpPjYEvqFuFZWaecUoPai88oGKL83HNRf.jpg','Jaú','SP','São Paulo','17208-130','197','Rua Braz Domingos Rossi','padaria',16),(3,'Carlinhos',3,'451.780.894-65','fotos/ZZeQdAz5mVr8lDon1PWa5vDQqNCkTUjQk7Yyfu4r.jpg','Jaú','SP','São Paulo','17208-130','195','Rua Braz Domingos Rossi','padaria',5),(4,'Tales',4,'154.886.531-24','fotos/7ZS5rltpeVEn3qVCnBhNq1xcpPcBCFBYqFXhh8Xr.jpg','Jaú','SP','São Paulo','17207-560','131','Rua João Alves','casa de ração',4),(5,'João',5,'140.007.653-12','fotos/D2B4fn7N2pSXxqjnbQ73awu3wwiMZSHRUUyeACJ7.jpg','Jaú','SP','São Paulo','17207-560','145','Rua João Alves','padaria',4);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefone`
--

LOCK TABLES `telefone` WRITE;
/*!40000 ALTER TABLE `telefone` DISABLE KEYS */;
INSERT INTO `telefone` VALUES (1,1,'(41) 98474-3297'),(2,2,'(14) 98645-8643'),(3,3,'(14) 98435-2187'),(4,4,'(14) 97845-1223'),(5,5,'(14) 99878-7000');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'caca@gmail.com','$2y$12$4m8viQf3/yxISk.2Rc5JiuzZNpnOHx50mNXxrhAMuOd/KBMaxmJwu','prestador'),(2,'antonio@gmail.com','$2y$12$VAxpDiACMKGM0EATcZ9B/.my.JvI.qgZWdvkmfVGmWHbXyyvvkCky','prestador'),(3,'caju@gmail.com','$2y$12$l8nHCBRLOq7ZD3r4LQQyUe2usUBhtsdAuAAms8mrSk0BELwhTZ8s.','prestador'),(4,'cata@gmail.con','$2y$12$s1XrI2uOHsRRhaQiWjqQq.iYlnrywYEhd1aoJBnkt.Z1VdHx/YFKi','prestador'),(5,'joao@gmail.com','$2y$12$OJVAK7KG42K/9VnEXdInPubGwSeHTOFH0RN6GHPmD0hzEGOCX0t.O','prestador');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (1,'fotos/portfolio/59ywFkbo8me4bxNsG0hnPN6EasmMQVnI2CyfKKMk.mp4',1,'2025-10-08 19:49:29','2025-10-08 19:49:29'),(2,'fotos/portfolio/hsUscyrvEABUDfagaIkz8lOJO2ShC3nf75rj7OyH.mp4',3,'2025-10-08 21:32:46','2025-10-08 21:32:46'),(3,'fotos/portfolio/6NuW6zTSc8QPANJKh0MeTUNZNT0rRWKF0rEld63P.mp4',4,'2025-10-08 21:36:15','2025-10-08 21:36:15'),(4,'fotos/portfolio/fVxu6eWkKUA3MFgGoly7M9KOFKsZk6r252XT7aNe.mp4',4,'2025-10-08 21:36:15','2025-10-08 21:36:15');
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

-- Dump completed on 2025-10-08 15:58:41
