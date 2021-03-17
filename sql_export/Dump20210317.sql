-- MySQL dump 10.13  Distrib 8.0.23, for Win64 (x86_64)
--
-- Host: localhost    Database: pea_phukhieo
-- ------------------------------------------------------
-- Server version	8.0.23

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
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `district` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `createdby` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `modifiedby` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `createdon` datetime DEFAULT CURRENT_TIMESTAMP,
  `modifiedon` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district`
--

LOCK TABLES `district` WRITE;
/*!40000 ALTER TABLE `district` DISABLE KEYS */;
INSERT INTO `district` VALUES (1,'ภูเขียว','system','admin01','2021-03-15 06:14:39','2021-03-15 08:29:25'),(2,'คอนสาร','system','system','2021-03-15 06:14:39',NULL),(4,'บ้านแท่น','admin01','admin01','2021-03-15 08:29:42',NULL);
/*!40000 ALTER TABLE `district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_upload`
--

DROP TABLE IF EXISTS `file_upload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_upload` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `location` varchar(50) COLLATE utf8_bin NOT NULL,
  `filetype` varchar(50) COLLATE utf8_bin NOT NULL,
  `organization_id` bigint DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `modifiedby` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `createdon` datetime DEFAULT CURRENT_TIMESTAMP,
  `modifiedon` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_upload`
--

LOCK TABLES `file_upload` WRITE;
/*!40000 ALTER TABLE `file_upload` DISABLE KEYS */;
INSERT INTO `file_upload` VALUES (1,'dfdfwettgdfg','uploads/604f52fac5f2b.docx','docx',6,'admin01','admin01','2021-03-15 19:28:42','2021-03-15 19:45:38');
/*!40000 ALTER TABLE `file_upload` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organization`
--

DROP TABLE IF EXISTS `organization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organization` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `district_id` bigint DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `modifiedby` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `createdon` datetime DEFAULT CURRENT_TIMESTAMP,
  `modifiedon` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization`
--

LOCK TABLES `organization` WRITE;
/*!40000 ALTER TABLE `organization` DISABLE KEYS */;
INSERT INTO `organization` VALUES (1,'ภูเขียวหน่วย01',1,'system','system','2021-03-15 08:48:30',NULL),(2,'ภูเขียวหน่วย02',1,'system','system','2021-03-15 08:48:30',NULL),(3,'คอนสารหน่วย01',2,'system','system','2021-03-15 08:48:30',NULL),(4,'คอนสารหน่วย02',2,'system','system','2021-03-15 08:48:30',NULL),(5,'บ้านแท่นหน่วย01',4,'system','system','2021-03-15 08:48:30',NULL),(6,'บ้านแท่นหน่วย02',4,'system','system','2021-03-15 08:48:30',NULL);
/*!40000 ALTER TABLE `organization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_user`
--

DROP TABLE IF EXISTS `system_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_user` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(50) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `mobilephone` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `role` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `organization_id` bigint DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `modifiedby` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `createdon` datetime DEFAULT CURRENT_TIMESTAMP,
  `modifiedon` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_user`
--

LOCK TABLES `system_user` WRITE;
/*!40000 ALTER TABLE `system_user` DISABLE KEYS */;
INSERT INTO `system_user` VALUES (1,'admin01','12345678','admin01','admin','','','admin',4,'admin01','admin01','2021-03-15 05:01:15','2021-03-17 22:28:41'),(3,'user01','12345678','wes','ssdf','','','user',1,'admin01','admin01','2021-03-17 22:29:36','2021-03-17 22:34:01'),(4,'admin02','123456','','','','','admin',4,'admin01','admin01','2021-03-17 22:34:50',NULL);
/*!40000 ALTER TABLE `system_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vw_file_upload_detail`
--

DROP TABLE IF EXISTS `vw_file_upload_detail`;
/*!50001 DROP VIEW IF EXISTS `vw_file_upload_detail`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_file_upload_detail` AS SELECT 
 1 AS `id`,
 1 AS `name`,
 1 AS `location`,
 1 AS `filetype`,
 1 AS `organization_id`,
 1 AS `createdby`,
 1 AS `modifiedby`,
 1 AS `createdon`,
 1 AS `modifiedon`,
 1 AS `organization_name`,
 1 AS `month`,
 1 AS `monthval`,
 1 AS `year`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_file_upload_month_year`
--

DROP TABLE IF EXISTS `vw_file_upload_month_year`;
/*!50001 DROP VIEW IF EXISTS `vw_file_upload_month_year`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_file_upload_month_year` AS SELECT 
 1 AS `month`,
 1 AS `monthval`,
 1 AS `year`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_organization_detail`
--

DROP TABLE IF EXISTS `vw_organization_detail`;
/*!50001 DROP VIEW IF EXISTS `vw_organization_detail`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_organization_detail` AS SELECT 
 1 AS `id`,
 1 AS `name`,
 1 AS `district_id`,
 1 AS `createdby`,
 1 AS `modifiedby`,
 1 AS `createdon`,
 1 AS `modifiedon`,
 1 AS `district_name`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vw_file_upload_detail`
--

/*!50001 DROP VIEW IF EXISTS `vw_file_upload_detail`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_file_upload_detail` AS select `f`.`id` AS `id`,`f`.`name` AS `name`,`f`.`location` AS `location`,`f`.`filetype` AS `filetype`,`f`.`organization_id` AS `organization_id`,`f`.`createdby` AS `createdby`,`f`.`modifiedby` AS `modifiedby`,`f`.`createdon` AS `createdon`,`f`.`modifiedon` AS `modifiedon`,`o`.`name` AS `organization_name`,date_format(`f`.`createdon`,'%M') AS `month`,date_format(`f`.`createdon`,'%m') AS `monthval`,date_format(`f`.`createdon`,'%Y') AS `year` from (`file_upload` `f` join `organization` `o` on((`o`.`id` = `f`.`organization_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_file_upload_month_year`
--

/*!50001 DROP VIEW IF EXISTS `vw_file_upload_month_year`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_file_upload_month_year` AS select distinct date_format(`f`.`createdon`,'%M') AS `month`,date_format(`f`.`createdon`,'%m') AS `monthval`,date_format(`f`.`createdon`,'%Y') AS `year` from `file_upload` `f` order by `f`.`createdon` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_organization_detail`
--

/*!50001 DROP VIEW IF EXISTS `vw_organization_detail`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_organization_detail` AS select `o`.`id` AS `id`,`o`.`name` AS `name`,`o`.`district_id` AS `district_id`,`o`.`createdby` AS `createdby`,`o`.`modifiedby` AS `modifiedby`,`o`.`createdon` AS `createdon`,`o`.`modifiedon` AS `modifiedon`,`d`.`name` AS `district_name` from (`organization` `o` join `district` `d` on((`d`.`id` = `o`.`district_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-17 23:31:16
