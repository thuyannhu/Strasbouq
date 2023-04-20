-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: strasbouq
-- ------------------------------------------------------
-- Server version	8.0.32
​
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
​
--
-- Table structure for table `images`
--
​
DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `filename` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Products_idProducts` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Products_idProducts` (`Products_idProducts`),
  CONSTRAINT `images_ibfk_1` FOREIGN KEY (`Products_idProducts`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
​
--
-- Dumping data for table `images`
--
​
LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;
​
--
-- Table structure for table `order`
--
​
DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `orderNumber` int NOT NULL,
  `date` date NOT NULL,
  `quantity` int NOT NULL,
  `price` float NOT NULL,
  `status` varchar(45) NOT NULL,
  `User_idUser` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Order_User1_idx` (`User_idUser`),
  CONSTRAINT `fk_Order_User1` FOREIGN KEY (`User_idUser`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
​
--
-- Dumping data for table `order`
--
​
LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;
​
--
-- Table structure for table `products`
--
​
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(455) NOT NULL,
  `color` varchar(45) NOT NULL,
  `category` varchar(45) NOT NULL,
  `inventory` int NOT NULL,
  `price` float NOT NULL,
  `User_idUser` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Products_User1_idx` (`User_idUser`),
  CONSTRAINT `fk_Products_User1` FOREIGN KEY (`User_idUser`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
​
--
-- Dumping data for table `products`
--
​
LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
​
--
-- Table structure for table `products_has_order`
--
​
DROP TABLE IF EXISTS `products_has_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_has_order` (
  `Products_idProducts` int NOT NULL,
  `Order_idOrder` int NOT NULL,
  PRIMARY KEY (`Products_idProducts`,`Order_idOrder`),
  KEY `fk_Products_has_Order_Order1_idx` (`Order_idOrder`),
  KEY `fk_Products_has_Order_Products1_idx` (`Products_idProducts`),
  CONSTRAINT `fk_Products_has_Order_Order1` FOREIGN KEY (`Order_idOrder`) REFERENCES `order` (`id`),
  CONSTRAINT `fk_Products_has_Order_Products1` FOREIGN KEY (`Products_idProducts`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
​
--
-- Dumping data for table `products_has_order`
--
​
LOCK TABLES `products_has_order` WRITE;
/*!40000 ALTER TABLE `products_has_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_has_order` ENABLE KEYS */;
UNLOCK TABLES;
​
--
-- Table structure for table `quotation`
--
​
DROP TABLE IF EXISTS `quotation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quotation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event` varchar(45) NOT NULL,
  `guest` int NOT NULL,
  `theme` varchar(100) DEFAULT NULL,
  `budget` int NOT NULL,
  `demand` varchar(500) DEFAULT NULL,
  `date` date NOT NULL,
  `location` varchar(45) NOT NULL,
  `User_idUser` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `User_idUser` (`User_idUser`),
  CONSTRAINT `quotation_ibfk_1` FOREIGN KEY (`User_idUser`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
​
--
-- Dumping data for table `quotation`
--
​
LOCK TABLES `quotation` WRITE;
/*!40000 ALTER TABLE `quotation` DISABLE KEYS */;
/*!40000 ALTER TABLE `quotation` ENABLE KEYS */;
UNLOCK TABLES;
​
--
-- Table structure for table `user`
--
​
DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `address` varchar(255) NOT NULL,
  `userPassword` varchar(45) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `fidelity` int NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `zipcode` int NOT NULL,
  `city` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
​
--
-- Dumping data for table `user`
--
​
LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
​
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
​
-- Dump completed on 2023-04-20 10:04:34