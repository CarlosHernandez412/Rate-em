-- MySQL dump 10.19  Distrib 10.3.31-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: rateem
-- ------------------------------------------------------
-- Server version	10.3.31-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Temporary table structure for view `CHighToLow`
--

DROP TABLE IF EXISTS `CHighToLow`;
/*!50001 DROP VIEW IF EXISTS `CHighToLow`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `CHighToLow` (
  `CommentID` tinyint NOT NULL,
  `UEmail` tinyint NOT NULL,
  `ForEmail` tinyint NOT NULL,
  `Message` tinyint NOT NULL,
  `Date` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `Comment`
--

DROP TABLE IF EXISTS `Comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Comment` (
  `CommentID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UEmail` varchar(50) NOT NULL,
  `ForEmail` varchar(50) NOT NULL,
  `Message` varchar(500) DEFAULT NULL,
  `Date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`CommentID`),
  UNIQUE KEY `CommentID` (`CommentID`),
  KEY `UEmail` (`UEmail`),
  KEY `ForEmail` (`ForEmail`),
  CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`UEmail`) REFERENCES `User` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`ForEmail`) REFERENCES `User` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=200000012 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comment`
--

LOCK TABLES `Comment` WRITE;
/*!40000 ALTER TABLE `Comment` DISABLE KEYS */;
INSERT INTO `Comment` VALUES (200000000,'acartmell0@loc.gov','rboate5@webeden.co.uk','They were really good tenants!','2022-02-22 17:26:34'),(200000001,'ehallums8@go.com','ljiranek7@imageshack.us','Bob was always late for his rent! Never paid on time!','2022-02-22 17:27:35'),(200000005,'ehallums8@go.com','rboate5@webeden.co.uk','Would always pay on time!','2022-04-24 22:18:36'),(200000006,'acartmell0@loc.gov','rboate5@webeden.co.uk','Howdy','2022-04-24 22:48:19'),(200000007,'rboate5@webeden.co.uk','ehallums8@go.com','Hello there, how’s the weather?','2022-04-25 00:21:17'),(200000010,'rboate5@webeden.co.uk','acartmell0@loc.gov','Hello','2022-04-29 22:15:50'),(200000011,'acartmell0@loc.gov','ljiranek7@imageshack.us','It is me','2022-04-29 23:25:53');
/*!40000 ALTER TABLE `Comment` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`rateem`@`localhost`*/ /*!50003 TRIGGER editMsg
BEFORE UPDATE ON Comment
FOR EACH ROW
BEGIN
INSERT INTO editComment (CommentID, UEmail, ForEmail, oldMessage, newMessage, Date) 
VALUES(OLD.CommentID, OLD.UEmail, OLD.ForEmail, OLD.Message, NEW.Message, NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `CommentRates`
--

DROP TABLE IF EXISTS `CommentRates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CommentRates` (
  `UEmail` varchar(50) NOT NULL,
  `CommentID` bigint(20) unsigned NOT NULL,
  `Rating` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`UEmail`,`CommentID`),
  KEY `CommentID` (`CommentID`),
  CONSTRAINT `CommentRates_ibfk_1` FOREIGN KEY (`UEmail`) REFERENCES `User` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `CommentRates_ibfk_2` FOREIGN KEY (`CommentID`) REFERENCES `Comment` (`CommentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CommentRates`
--

LOCK TABLES `CommentRates` WRITE;
/*!40000 ALTER TABLE `CommentRates` DISABLE KEYS */;
INSERT INTO `CommentRates` VALUES ('acartmell0@loc.gov',200000006,-1),('ehallums8@go.com',200000005,1),('ehallums8@go.com',200000007,-1),('rboate5@webeden.co.uk',200000001,-1);
/*!40000 ALTER TABLE `CommentRates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `LHighToLow`
--

DROP TABLE IF EXISTS `LHighToLow`;
/*!50001 DROP VIEW IF EXISTS `LHighToLow`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `LHighToLow` (
  `FName` tinyint NOT NULL,
  `MI` tinyint NOT NULL,
  `LName` tinyint NOT NULL,
  `Email` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `Landlord`
--

DROP TABLE IF EXISTS `Landlord`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Landlord` (
  `Email` varchar(50) NOT NULL,
  PRIMARY KEY (`Email`),
  CONSTRAINT `Landlord_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `User` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Landlord`
--

LOCK TABLES `Landlord` WRITE;
/*!40000 ALTER TABLE `Landlord` DISABLE KEYS */;
INSERT INTO `Landlord` VALUES ('acartmell0@loc.gov'),('ehallums8@go.com');
/*!40000 ALTER TABLE `Landlord` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Occupies`
--

DROP TABLE IF EXISTS `Occupies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Occupies` (
  `TEmail` varchar(50) NOT NULL,
  `PropertyID` bigint(20) unsigned NOT NULL,
  `Start` date NOT NULL DEFAULT curdate(),
  `End` date DEFAULT NULL,
  `Stars` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`TEmail`,`PropertyID`,`Start`),
  KEY `PropertyID` (`PropertyID`),
  CONSTRAINT `Occupies_ibfk_1` FOREIGN KEY (`TEmail`) REFERENCES `Tenant` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Occupies_ibfk_2` FOREIGN KEY (`PropertyID`) REFERENCES `Property` (`PropertyID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Occupies`
--

LOCK TABLES `Occupies` WRITE;
/*!40000 ALTER TABLE `Occupies` DISABLE KEYS */;
INSERT INTO `Occupies` VALUES ('ljiranek7@imageshack.us',100000000,'2009-12-04','2014-05-23',1),('ljiranek7@imageshack.us',100000000,'2015-12-04','2016-08-12',4),('ljiranek7@imageshack.us',100000001,'2022-04-30',NULL,2),('rboate5@webeden.co.uk',100000000,'2011-03-11',NULL,3);
/*!40000 ALTER TABLE `Occupies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Property`
--

DROP TABLE IF EXISTS `Property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Property` (
  `LEmail` varchar(50) NOT NULL,
  `PropertyID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NumOfRooms` int(11) NOT NULL,
  `NumOfBathrooms` int(11) NOT NULL,
  `Price` decimal(15,2) unsigned NOT NULL,
  `State` tinytext NOT NULL,
  `City` tinytext NOT NULL,
  `Zipcode` int(5) NOT NULL,
  PRIMARY KEY (`LEmail`,`PropertyID`),
  UNIQUE KEY `PropertyID` (`PropertyID`),
  CONSTRAINT `Property_ibfk_1` FOREIGN KEY (`LEmail`) REFERENCES `Landlord` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=100000006 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Property`
--

LOCK TABLES `Property` WRITE;
/*!40000 ALTER TABLE `Property` DISABLE KEYS */;
INSERT INTO `Property` VALUES ('acartmell0@loc.gov',100000001,1,1,1164.00,'California','Bakersfield',12345),('ehallums8@go.com',100000000,3,2,140.00,'California','Bakersfield',93306);
/*!40000 ALTER TABLE `Property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PropertyType`
--

DROP TABLE IF EXISTS `PropertyType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PropertyType` (
  `PropertyID` bigint(20) unsigned NOT NULL,
  `Type` text NOT NULL,
  PRIMARY KEY (`PropertyID`),
  CONSTRAINT `PropertyType_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `Property` (`PropertyID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PropertyType`
--

LOCK TABLES `PropertyType` WRITE;
/*!40000 ALTER TABLE `PropertyType` DISABLE KEYS */;
INSERT INTO `PropertyType` VALUES (100000000,'House'),(100000001,'Condo');
/*!40000 ALTER TABLE `PropertyType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `RecentComment`
--

DROP TABLE IF EXISTS `RecentComment`;
/*!50001 DROP VIEW IF EXISTS `RecentComment`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `RecentComment` (
  `CommentID` tinyint NOT NULL,
  `UEmail` tinyint NOT NULL,
  `ForEmail` tinyint NOT NULL,
  `Message` tinyint NOT NULL,
  `Date` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `Tenant`
--

DROP TABLE IF EXISTS `Tenant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tenant` (
  `Email` varchar(50) NOT NULL,
  PRIMARY KEY (`Email`),
  CONSTRAINT `Tenant_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `User` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tenant`
--

LOCK TABLES `Tenant` WRITE;
/*!40000 ALTER TABLE `Tenant` DISABLE KEYS */;
INSERT INTO `Tenant` VALUES ('leny@email.com'),('ljiranek7@imageshack.us'),('rboate5@webeden.co.uk');
/*!40000 ALTER TABLE `Tenant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `Email` varchar(50) NOT NULL,
  `PhoneNumber` varchar(13) NOT NULL,
  `FName` text NOT NULL,
  `MI` text DEFAULT NULL,
  `LName` text NOT NULL,
  `Password` text NOT NULL,
  PRIMARY KEY (`Email`),
  UNIQUE KEY `PhoneNumber` (`PhoneNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES ('acartmell0@loc.gov','(747)119-7334','Emyle','Arlin','Cartmell','$2y$10$nTrn9/IkC.ze3puffhIIHeKloP9Y9Evyhousd4BopE7kuW2HAQNn2'),('ehallums8@go.com','(661)733-3930','Eada',NULL,'Hallums','$2y$10$1GVODKqw.Gi/yuB3JjDtD.zZjiw2/wWGRjsnnvk8Ofv8H0SdiDznu'),('leny@email.com','(943)766-0000','Leny','','Smith','$2y$10$OUakFLZ1gk3FsswcF0zb2euDXouAFqC.Mda9QHLotGuIYvHG2cjKa'),('ljiranek7@imageshack.us','(534)644-1917','Venita','Laurie','Jiranek','$2y$10$.ukUV8fcMiof2m92nSn3b.Yxp4pkkMxvWgg2sHjNqFIDOgnqfogrC'),('rboate5@webeden.co.uk','(943)766-0002','Madel','Betty','Boate','$2y$10$mononr.NyjGcb7Ffkwx0ReJcqZijaQIBentMzWZPdqRcaLrmZE8NO');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`rateem`@`localhost`*/ /*!50003 TRIGGER newAcc
AFTER INSERT ON User
FOR EACH ROW
BEGIN
INSERT INTO newAccMsg(Email, FName, Message)
VALUES(NEW.Email, NEW.FName, CONCAT('Your account was created successfully. Welcome ', NEW.FName, '!') );
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`rateem`@`localhost`*/ /*!50003 TRIGGER updateUser
BEFORE UPDATE ON User
FOR EACH ROW
BEGIN
SELECT COUNT(*) INTO @hasUpdated
FROM oldUsers
WHERE Email = OLD.Email;
IF @hasUpdated > 0 THEN
UPDATE oldUsers SET PhoneNumber =OLD.PhoneNumber, FName =OLD.FName, MI =OLD.MI, LName =OLD.LName, Password =OLD.Password, updatedTime =NOW() WHERE Email =OLD.Email;
ELSE
INSERT INTO oldUsers 
VALUES(OLD.Email, OLD.PhoneNumber, OLD.FName, OLD.MI, OLD.LName, OLD.Password, NOW());
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`rateem`@`localhost`*/ /*!50003 TRIGGER deleteAccount
BEFORE DELETE ON User
FOR EACH ROW
BEGIN
SET @accType = 'Tenant';
SELECT COUNT(*) INTO @hasDeleted
FROM oldAccount
WHERE Email = OLD.Email;
SELECT COUNT(*) INTO @accCheck
FROM Landlord
WHERE Email = OLD.Email;
IF @accCheck > 0 THEN
SET @accType = 'Landlord';
END IF;
IF @hasDeleted > 0 THEN
UPDATE oldAccount SET Email = OLD.Email, PhoneNumber = OLD.PhoneNumber , FName = OLD.FName, MI = OLD.MI, LName = OLD.LName, Password = OLD.Password, UserType =@accType, DeletedOn = NOW() WHERE Email = OLD.Email;
ELSE
INSERT INTO oldAccount (Email, PhoneNumber, FName, MI, LName, Password, UserType)
VALUES (OLD.Email, OLD.PhoneNumber, OLD.FName, OLD.MI, OLD.LName, OLD.Password, @accType);
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `UserRates`
--

DROP TABLE IF EXISTS `UserRates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserRates` (
  `UEmail` varchar(50) NOT NULL,
  `ForEmail` varchar(50) NOT NULL,
  `Stars` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`UEmail`,`ForEmail`),
  KEY `ForEmail` (`ForEmail`),
  CONSTRAINT `UserRates_ibfk_1` FOREIGN KEY (`UEmail`) REFERENCES `User` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `UserRates_ibfk_2` FOREIGN KEY (`ForEmail`) REFERENCES `User` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserRates`
--

LOCK TABLES `UserRates` WRITE;
/*!40000 ALTER TABLE `UserRates` DISABLE KEYS */;
INSERT INTO `UserRates` VALUES ('ehallums8@go.com','rboate5@webeden.co.uk',4),('rboate5@webeden.co.uk','acartmell0@loc.gov',5),('rboate5@webeden.co.uk','ehallums8@go.com',4);
/*!40000 ALTER TABLE `UserRates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `editComment`
--

DROP TABLE IF EXISTS `editComment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `editComment` (
  `CommentID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UEmail` varchar(50) NOT NULL,
  `ForEmail` varchar(50) NOT NULL,
  `oldMessage` varchar(500) NOT NULL,
  `newMessage` varchar(500) NOT NULL,
  `updateTime` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`CommentID`),
  UNIQUE KEY `CommentID` (`CommentID`),
  CONSTRAINT `editComment_ibfk_1` FOREIGN KEY (`CommentID`) REFERENCES `Comment` (`CommentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editComment`
--

LOCK TABLES `editComment` WRITE;
/*!40000 ALTER TABLE `editComment` DISABLE KEYS */;
/*!40000 ALTER TABLE `editComment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newAccMsg`
--

DROP TABLE IF EXISTS `newAccMsg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newAccMsg` (
  `Email` varchar(50) NOT NULL,
  `FName` text DEFAULT NULL,
  `Message` text DEFAULT NULL,
  PRIMARY KEY (`Email`),
  CONSTRAINT `newAccMsg_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `User` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newAccMsg`
--

LOCK TABLES `newAccMsg` WRITE;
/*!40000 ALTER TABLE `newAccMsg` DISABLE KEYS */;
INSERT INTO `newAccMsg` VALUES ('leny@email.com','Leny','Your account was created successfully. Welcome Leny!');
/*!40000 ALTER TABLE `newAccMsg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oldAccount`
--

DROP TABLE IF EXISTS `oldAccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oldAccount` (
  `Email` varchar(50) NOT NULL,
  `PhoneNumber` varchar(13) NOT NULL,
  `FName` text NOT NULL,
  `MI` text DEFAULT NULL,
  `LName` text NOT NULL,
  `Password` text NOT NULL,
  `UserType` text NOT NULL,
  `DeletedOn` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oldAccount`
--

LOCK TABLES `oldAccount` WRITE;
/*!40000 ALTER TABLE `oldAccount` DISABLE KEYS */;
INSERT INTO `oldAccount` VALUES ('leny@email.com','(987)654-2582','Leny','MI','Smith','$2y$10$KGeytTK2IIDzxn4AhOySk.O112CjEylu6fbWbeCqzS2ZiWcnvxh8K','Tenant','2022-04-28 19:51:44'),('myemail@gmailcom','(818)123-4567','Devin','','Brown','$2y$10$j5oZSDnNvDZ7l8myYdSN.ezDWWYsLWxPoUGVH.Kdf/u8LJfRngPFO','Tenant','2022-04-25 09:51:19');
/*!40000 ALTER TABLE `oldAccount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oldUsers`
--

DROP TABLE IF EXISTS `oldUsers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oldUsers` (
  `Email` varchar(50) NOT NULL,
  `PhoneNumber` varchar(13) NOT NULL,
  `FName` text NOT NULL,
  `MI` text DEFAULT NULL,
  `LName` text NOT NULL,
  `Password` text NOT NULL,
  `updatedTime` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`Email`),
  UNIQUE KEY `PhoneNumber` (`PhoneNumber`),
  CONSTRAINT `oldUsers_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `User` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oldUsers`
--

LOCK TABLES `oldUsers` WRITE;
/*!40000 ALTER TABLE `oldUsers` DISABLE KEYS */;
INSERT INTO `oldUsers` VALUES ('ehallums8@go.com','(661)733-3930','Eada',NULL,'Hallums','DUA65tcEKWBH','2022-04-24 23:38:37'),('rboate5@webeden.co.uk','(943)766-0001','Madel','Betty','Boate','$2y$10$mononr.NyjGcb7Ffkwx0ReJcqZijaQIBentMzWZPdqRcaLrmZE8NO','2022-04-29 23:20:08');
/*!40000 ALTER TABLE `oldUsers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `CHighToLow`
--

/*!50001 DROP TABLE IF EXISTS `CHighToLow`*/;
/*!50001 DROP VIEW IF EXISTS `CHighToLow`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`rateem`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `CHighToLow` AS select `rateem`.`Comment`.`CommentID` AS `CommentID`,`rateem`.`Comment`.`UEmail` AS `UEmail`,`rateem`.`Comment`.`ForEmail` AS `ForEmail`,`rateem`.`Comment`.`Message` AS `Message`,`rateem`.`Comment`.`Date` AS `Date` from (`rateem`.`Comment` join (select sum(`rateem`.`CommentRates`.`Rating`) AS `TotalRating`,`rateem`.`CommentRates`.`CommentID` AS `CommentID` from (`rateem`.`CommentRates` join `rateem`.`Comment` on(`rateem`.`CommentRates`.`UEmail` = `rateem`.`Comment`.`UEmail` and `rateem`.`CommentRates`.`CommentID` = `rateem`.`Comment`.`CommentID`)) group by `rateem`.`CommentRates`.`CommentID`) `Ratings` on(`Ratings`.`CommentID` = `rateem`.`Comment`.`CommentID`)) order by `Ratings`.`TotalRating` desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `LHighToLow`
--

/*!50001 DROP TABLE IF EXISTS `LHighToLow`*/;
/*!50001 DROP VIEW IF EXISTS `LHighToLow`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`rateem`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `LHighToLow` AS select `rateem`.`User`.`FName` AS `FName`,`rateem`.`User`.`MI` AS `MI`,`rateem`.`User`.`LName` AS `LName`,`rateem`.`User`.`Email` AS `Email` from (`rateem`.`User` join (select avg(`rateem`.`UserRates`.`Stars`) AS `TotalRating`,`rateem`.`UserRates`.`ForEmail` AS `ForEmail` from (`rateem`.`UserRates` join `rateem`.`Landlord`) group by `rateem`.`UserRates`.`ForEmail`) `Ratings` on(`Ratings`.`ForEmail` = `rateem`.`User`.`Email`)) order by `Ratings`.`TotalRating` desc limit 10 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `RecentComment`
--

/*!50001 DROP TABLE IF EXISTS `RecentComment`*/;
/*!50001 DROP VIEW IF EXISTS `RecentComment`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`rateem`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `RecentComment` AS select `Comment`.`CommentID` AS `CommentID`,`Comment`.`UEmail` AS `UEmail`,`Comment`.`ForEmail` AS `ForEmail`,`Comment`.`Message` AS `Message`,`Comment`.`Date` AS `Date` from `Comment` order by `Comment`.`Date` desc */;
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

-- Dump completed on 2022-04-30 19:52:31
