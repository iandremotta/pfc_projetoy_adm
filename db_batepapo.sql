CREATE DATABASE  IF NOT EXISTS `db_batepapo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_batepapo`;
-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: db_batepapo
-- ------------------------------------------------------
-- Server version	8.0.19

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
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friends` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_follower` int NOT NULL,
  `id_followed` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (3,'Geral'),(4,'Vendas'),(5,'Financeiro'),(7,'RH'),(12,'T.I'),(13,'caneta');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_group` int NOT NULL,
  `date_msg` datetime NOT NULL,
  `msg` text NOT NULL,
  `msg_type` varchar(20) NOT NULL DEFAULT 'text',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (167,24,5,'2020-05-22 02:58:06','aew','text'),(168,24,5,'2020-05-22 02:58:08','beleza?','text');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_token`
--

DROP TABLE IF EXISTS `user_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_token` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `ut_hash` varchar(32) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_token`
--

LOCK TABLES `user_token` WRITE;
/*!40000 ALTER TABLE `user_token` DISABLE KEYS */;
INSERT INTO `user_token` VALUES (1,1,'1',1),(2,1,'1',0),(3,1,'1',0),(4,1,'1',0),(5,1,'1',0),(6,14,'2',0),(7,14,'3323',0),(8,14,'3323',0),(9,14,'24',0),(10,14,'bf4fbb7b34e1a988c1963d10b3f31576',0),(11,14,'c8725352fb6fd7e3f05e7556536e81d6',0),(12,14,'8fdf8f05b09cfcbccfee531d00e69be2',0),(13,14,'3247463e2c58609ca7b5e5e9cd04bf95',0),(14,14,'335c21f47ce8af985b85a58df4be22bc',0),(15,14,'7f2ad9da6873fc9b9a96d5406ded441e',0),(16,14,'487d6ee5bf33567d403d6d66ebcc0d6b',0),(17,14,'1edd1f88cdb23cd90a69079e2eea0c1e',0),(18,14,'92d055d2850f5fc694f57d8878afecde',0),(19,14,'ae145a142c8972529498a3cf5ec31580',0),(20,14,'628b8c4f309842702e60cdf738836fd1',0),(21,14,'2e3fafdf3f2b7e8f0f429595365dfdc2',0),(22,14,'e1d77e4135465e13f31786666a041345',0),(23,14,'0859af548ca65a8d9a8402ca33e3162b',0),(24,14,'a5f6bce69bc6068a7f7c39ae3d751116',0),(25,14,'7949e4f90aa404387f0047e97555826c',0),(26,14,'56efb0415819a3ae0a53b608968a3708',0),(27,14,'6322197db2acde0833267f438477e4eb',0),(28,14,'8cffa0a40cdcaa2e9ed9452eabe24e4b',0),(29,14,'485cd0ab4ebbc116fff486ca3f2e66fb',0),(30,14,'60a5a9265ff843b34916b442bb8e5af0',0),(31,14,'5bb7fc58bac153bcc2bb241f548328b5',0),(32,14,'848cce2b5d86fcd074f1c89725195b64',0),(33,14,'1841c670875a04a9fba7a7d2f44b252c',0),(34,14,'821502d30270a83e280b35aaafc36ed9',0),(35,12,'7932780731ac63cbf91ac829a72280ec',0),(36,13,'5221418ee58e79b665bc527d6d9604e1',0),(37,20,'82b4b5f2be8e1e6de6ea984e20214a0e',0),(38,20,'fc1fee4b7d738730d7431debf7ee5f0d',0),(39,22,'099531ac76968c0fce43b8905a81283a',0),(40,23,'bffb510f18d4e62ef5f056c2a2c119db',0),(41,23,'7dddcf77695744198322c558d4962cb5',0),(42,23,'a4d90b7942a167fe3145d6cb1bd309db',0),(43,23,'8224553936af0b220e3b0985a552746b',0),(44,23,'5cf39091b2414772ff5c3c7956564407',0),(45,23,'34d4a6f268d0e0b7a28b5a999845448e',0),(46,23,'9bf93273e7a2f40307c605a330903c00',0),(47,23,'fc67892d9d6d9086addaedfa6de403a0',0),(48,23,'29244c14262f6a14f2d6b4bb74647097',0),(49,23,'b8dd566b777ac84540667dcfda49a9e0',0),(50,23,'b3c7e5f265483c877fec415fb19da471',0),(51,23,'288afb4de3b24dee5e4e7ca1f10569e6',0),(52,23,'cbea3365b10b7a16f7532862e333a3c6',0),(53,23,'1b35eceef16fd1e69442352a5d2ea8c8',0),(54,24,'0be0fe954a08e39c5cc77f5fe60005b2',0),(55,24,'b6155ae2cd97c097d1f583ce66d96e48',0),(56,24,'eedc10a21d18ea2eb07515ff72da4b9b',0),(57,24,'42c6a39773914b804af3e13fbb28f6c6',0),(58,24,'01b888e2c9dd380978143cabe1759979',0),(59,24,'a3329fd27d45aaf42c69f9839860016c',0),(60,24,'87033e71f5bfcdb5288c8e2ac760e21e',0),(61,24,'ee27098d307ea9477a26afb376d9f5d7',0),(62,24,'e4cc74d39a343158c76b9c0c4f998461',0),(63,24,'9abc59bf21b48c4a06ecf6fa0f79103f',0),(64,24,'7e181b0d24209f40664b393850a7b4c3',0),(65,24,'46e59a60b77296175c8e305aea74d1e5',0),(66,24,'8ce8c9fa188844e8379ab50fc03c2d12',0),(67,24,'751490723c08846baaf88d1eb8592c78',0),(68,24,'6c3f0bdbf97f5dc184b48301be0305e4',0),(69,25,'07eaa2fe4f4d7c8b0cc9d56a0942e756',0),(70,24,'e0b8153a16d2828452e8b6ed6569ca52',0),(71,24,'950d432832f3cf4fd7c5a51c8b234440',0),(72,24,'fcbcce43ddafcff5bb082c1df5cad25a',0),(73,24,'e0f4ab88c065eab01df153ad91b242df',0),(74,24,'f5b1b1706c8466322f2f9f6eeac672e2',0);
/*!40000 ALTER TABLE `user_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(55) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `loginhash` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (24,'Pedro','pedro@gmail.com','pedro','$2y$10$af02n3VDkMbiEbCSojIyhu6UR83ROWbO.cY3lHaS9PHzj3RNBe.eC','6479e6dc0da3252ee0b404a0d92a3c36'),(25,'Vivian','viviane@umc.br','viviane','$2y$10$c.BpEA/NfLuXVraM9BGyPezKKmrIQ6Av./GxBAvtInqWEOU71hWxu','bf4c27869f2f6467101033f79d0c215d');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-22  8:32:27
