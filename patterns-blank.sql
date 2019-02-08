CREATE DATABASE IF NOT EXISTS `patterns`;
USE patterns;
GRANT ALL ON patterns.* TO `pattern`@`localhost` identified by 'p@tt3rn';
--
-- Table structure for table `publisher`
--

DROP TABLE IF EXISTS `publisher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publisher` (
  `idpublisher` int(11) NOT NULL AUTO_INCREMENT,
  `publisherName` varchar(45) NOT NULL,
  PRIMARY KEY (`idpublisher`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publisher`
--

LOCK TABLES `publisher` WRITE;
/*!40000 ALTER TABLE `publisher` DISABLE KEYS */;
INSERT INTO `publisher` VALUES (1,'Anne Adams'),(2,'Blackmore'),(3,'Burda'),(4,'Butterick'),(5,'Fashion'),(6,'Kwik Sew'),(7,'Maudella'),(8,'McCalls'),(9,'Paragon'),(10,'Pauline'),(11,'Simplicity'),(12,'Style'),(13,'Vogue'),(14,'Weigels'),(15,'Academy'),(16,'Womans Day'),(17,'Australian Home Journal'),(18,'Marian Martin'),(19,'Woman\'s World'),(20,'Favorite Pattern Service'),(21,'Multisize Pattern'),(22,'English Woman'),(23,'Pictorial Review');
/*!40000 ALTER TABLE `publisher` ENABLE KEYS */;
UNLOCK TABLES;
--
-- Table structure for table `pattern`
--

DROP TABLE IF EXISTS `pattern`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pattern` (
  `idpattern` int(11) NOT NULL AUTO_INCREMENT,
  `patternPublisher` int(11) DEFAULT NULL COMMENT 'FK',
  `patternNum` varchar(8) DEFAULT NULL,
  `patternSize` varchar(45) DEFAULT NULL,
  `patternBust` varchar(45) DEFAULT NULL,
  `patternWaist` varchar(45) DEFAULT NULL,
  `patternHips` varchar(45) DEFAULT NULL,
  `patternEra` varchar(45) DEFAULT NULL,
  `patternGender` varchar(6) DEFAULT NULL,
  `patternDesc` varchar(145) DEFAULT NULL,
  `patternOrigPrice` varchar(45) DEFAULT NULL,
  `patternNotes` varchar(45) DEFAULT NULL,
  `patternPicture` mediumblob,
  PRIMARY KEY (`idpattern`),
  KEY `patternPublisher` (`patternPublisher`),
  CONSTRAINT `pattern_ibfk_1` FOREIGN KEY (`patternPublisher`) REFERENCES `publisher` (`idpublisher`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pattern`
--

LOCK TABLES `pattern` WRITE;
/*!40000 ALTER TABLE `pattern` DISABLE KEYS */;
/*!40000 ALTER TABLE `pattern` ENABLE KEYS */;

UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-08  9:54:25
